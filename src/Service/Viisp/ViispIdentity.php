<?php

declare(strict_types=1);

namespace App\Service\Viisp;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMNodeList;
use DOMXPath;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

readonly class ViispIdentity
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

    public function getIdentity(string $ticket, string $privateKey): ViispIdentityData
    {
        $identityDom = $this->generateIdentityDom($this->pid, $ticket);
        /** @var DOMElement $firstChild */
        $firstChild = $identityDom->firstChild;

        $this->viispSigner->signDomElement($firstChild, $privateKey);
        $resp = $this->viispHttpClient->doRequest($identityDom, 'getAuthenticationData');

        $dom = new DOMDocument();
        if (!$dom->loadXML((string) $resp, LIBXML_NONET)) {
            throw new \RuntimeException('VIISP: received malformed XML in identity response.');
        }
        if ($dom->doctype !== null) {
            throw new \RuntimeException('VIISP: identity response contained a disallowed DOCTYPE declaration.');
        }

        $xpath = new DOMXPath($dom);
        $xpath->registerNamespace('soapenv', ViispHttpClient::SOAP_ENVELOPE_NS);
        $xpath->registerNamespace('authentication', $this->viispAuthUrl);

        $this->assertNoSoapFault($xpath);

        return $this->generateIdentity($xpath);
    }

    private function assertNoSoapFault(DOMXPath $xpath): void
    {
        /** @var DOMNodeList<DOMNode> $faultQuery */
        $faultQuery = $xpath->query('//soapenv:Envelope/soapenv:Body/soapenv:Fault');
        $fault = $faultQuery->item(0);

        if ($fault !== null) {
            /** @var DOMNodeList<DOMNode> $faultStringQuery */
            $faultStringQuery = $xpath->query('faultstring', $fault);
            $faultString = (string) $faultStringQuery->item(0)?->nodeValue;
            if ($faultString === '') {
                $faultString = 'unknown fault';
            }

            throw new \RuntimeException('VIISP: identity request returned a SOAP fault: '.$faultString);
        }
    }

    private function generateIdentity(DomXPath $xpath): ViispIdentityData
    {
        /** @var DOMNodeList<DOMNode> $codeQuery */
        $codeQuery = $xpath->query('//soapenv:Envelope/soapenv:Body//authentication:authenticationAttribute/authentication:value');
        if ($codeQuery->length > 1) {
            throw new \RuntimeException('VIISP: identity response contained more than one authentication attribute value.');
        }
        $personalCode = (string) $codeQuery->item(0)?->nodeValue;

        if ($personalCode === '') {
            throw new \RuntimeException('VIISP: identity response did not contain a personal code.');
        }

        $firstName = '';
        $lastName = '';

        /** @var DOMNodeList<DOMNode> $userInfoNodes */
        $userInfoNodes = $xpath->query('//soapenv:Envelope/soapenv:Body//authentication:userInformation');
        foreach ($userInfoNodes as $userNode) {
            /** @var DOMNodeList<DOMNode> $userInformationQuery */
            $userInformationQuery = $xpath->query('authentication:information', $userNode);
            /** @var DOMNodeList<DOMNode> $userValueQuery */
            $userValueQuery = $xpath->query('authentication:value/authentication:stringValue', $userNode);
            $infoType = $userInformationQuery->item(0)?->nodeValue;
            $infoValue = (string) $userValueQuery->item(0)?->nodeValue;

            if ($infoType === 'firstName') {
                $firstName = $infoValue;
            } elseif ($infoType === 'lastName') {
                $lastName = $infoValue;
            }
        }

        return new ViispIdentityData($personalCode, $firstName, $lastName);
    }

    private function generateIdentityDom(
        string $pid,
        string $ticket,
    ): DomDocument {
        $dom = new DOMDocument('1.0', 'utf-8');
        $root = $dom->createElementNS($this->viispAuthUrl, 'ns2:authenticationDataRequest');
        $root->setAttribute('id', 'uniqueNodeId');
        $root->setIdAttribute('id', true);
        $root->appendChild($dom->createElement('ns2:pid', $pid));
        $root->appendChild($dom->createElement('ns2:ticket', $ticket));
        $root->appendChild($dom->createElement('ns2:includeSourceData', 'true'));

        $dom->appendChild($root);

        return $dom;
    }
}
