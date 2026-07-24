<?php

declare(strict_types=1);

namespace App\Service\Viisp;

use DOMDocument;
use DOMElement;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

readonly class ViispTicket
{
    public function __construct(
        #[Autowire(env: 'VIISP_PID')]
        private string $pid,
        private ViispSigner $viispSigner,
        private ViispHttpClient $viispHttpClient,
        #[Autowire(env: 'VIISP_AUTH_URL')]
        private string $viispAuthUrl,
    ) {
    }

    public function getAuthenticationTicket(string $postbackUrl, string $privateKey): string
    {
        $ticketDom = $this->generateTicketDom($this->pid, $postbackUrl);
        /** @var DOMElement $firstChild */
        $firstChild = $ticketDom->firstChild;

        $this->viispSigner->signDomElement($firstChild, $privateKey);
        $resp = $this->viispHttpClient->doRequest($ticketDom, 'initAuthentication');

        $respXmlString = (string) $resp;
        if (str_contains($respXmlString, '<!DOCTYPE')) {
            throw new \RuntimeException('VIISP: authentication ticket response contained a disallowed DOCTYPE declaration.');
        }

        $respXml = simplexml_load_string($respXmlString, \SimpleXMLElement::class, LIBXML_NONET);
        if ($respXml === false) {
            throw new \RuntimeException('VIISP: received malformed XML in authentication ticket response.');
        }

        $respXml->registerXPathNamespace('soapenv', ViispHttpClient::SOAP_ENVELOPE_NS);
        $respXml->registerXPathNamespace('ns2', $this->viispAuthUrl);

        $faultElements = $respXml->xpath('//soapenv:Envelope/soapenv:Body/soapenv:Fault');
        if ($faultElements === false) {
            throw new \RuntimeException('VIISP: failed to evaluate authentication ticket response.');
        }
        if (isset($faultElements[0])) {
            $faultStringElements = $faultElements[0]->xpath('faultstring');
            $faultString = ($faultStringElements !== false && isset($faultStringElements[0])) ? (string) $faultStringElements[0] : 'unknown fault';

            throw new \RuntimeException('VIISP: authentication ticket request returned a SOAP fault: '.$faultString);
        }

        $elements = $respXml->xpath('//soapenv:Envelope/soapenv:Body//ns2:ticket');
        if ($elements === false || !isset($elements[0])) {
            throw new \RuntimeException('VIISP: authentication ticket response did not contain a ticket.');
        }
        if (count($elements) > 1) {
            throw new \RuntimeException('VIISP: authentication ticket response contained more than one ticket value.');
        }

        return (string) $elements[0];
    }

    private function generateTicketDom(
        string $pid,
        string $postbackUrl = 'https://localhost',
    ): DomDocument {
        $authenticationProviders = ['auth.lt.identity.card', 'auth.lt.bank', 'auth.signatureProvider'];
        $authenticationAttributes = ['lt-personal-code'];
        $userInformations = ['firstName', 'lastName'];

        $dom = new DOMDocument('1.0', 'utf-8');
        $root = $dom->createElementNS($this->viispAuthUrl, 'ns2:authenticationRequest');
        $root->setAttribute('id', 'uniqueNodeId');
        $root->setIdAttribute('id', true);
        $root->appendChild($dom->createElement('ns2:pid', $pid));
        $root->appendChild($dom->createElement('ns2:serviceTarget', 'citizen'));
        foreach ($authenticationProviders as $authenticationProvider) {
            $root->appendChild($dom->createElement('ns2:authenticationProvider', $authenticationProvider));
        }
        foreach ($authenticationAttributes as $authenticationAttribute) {
            $root->appendChild($dom->createElement('ns2:authenticationAttribute', $authenticationAttribute));
        }
        foreach ($userInformations as $userInformation) {
            $root->appendChild($dom->createElement('ns2:userInformation', $userInformation));
        }
        $root->appendChild($dom->createElement('ns2:postbackUrl', $postbackUrl));

        $dom->appendChild($root);

        return $dom;
    }
}
