<?php

declare(strict_types=1);

namespace App\Service\Viisp;

use DOMDocument;
use DOMElement;
use SimpleXMLElement;

readonly class ViispTicket
{
    public function __construct(
        private string $pid,
        private ViispSigner $viispSigner,
        private ViispHttpClient $viispHttpClient,
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

        /** @var SimpleXMLElement $respXml */
        $respXml = simplexml_load_string((string) $resp);
        $respXml->registerXPathNamespace('ns2', $this->viispAuthUrl);
        /** @var SimpleXMLElement[] $elements */
        $elements = $respXml->xpath('//ns2:ticket');

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
            $root->appendChild($dom->createElement('ns2:authenticationProvider', htmlspecialchars($authenticationProvider, ENT_XML1 | ENT_QUOTES, 'UTF-8')));
        }
        foreach ($authenticationAttributes as $authenticationAttribute) {
            $root->appendChild($dom->createElement('ns2:authenticationAttribute', htmlspecialchars($authenticationAttribute, ENT_XML1 | ENT_QUOTES, 'UTF-8')));
        }
        foreach ($userInformations as $userInformation) {
            $root->appendChild($dom->createElement('ns2:userInformation', htmlspecialchars($userInformation, ENT_XML1 | ENT_QUOTES, 'UTF-8')));
        }
        $root->appendChild($dom->createElement('ns2:postbackUrl', htmlspecialchars($postbackUrl, ENT_XML1 | ENT_QUOTES, 'UTF-8')));

        $dom->appendChild($root);

        return $dom;
    }
}
