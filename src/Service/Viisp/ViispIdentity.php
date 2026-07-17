<?php

declare(strict_types=1);

namespace App\Service\Viisp;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMNodeList;
use DOMXPath;

readonly class ViispIdentity
{
    public function __construct(
        private string $pid,
        private ViispSigner $viispSigner,
        private ViispHttpClient $viispHttpClient,
        private string $viispAuthUrl,
    ) {
    }

    public function getIdentity(string $ticket, string $privateKey): ViispIdentityData
    {
        $identityDom = $this->generateIdentityDom($this->pid, $ticket);
        /** @var DOMElement $firstChild */
        $firstChild = $identityDom->firstChild;

        $this->viispSigner->signDomElement($firstChild, $privateKey);
        $resp = $this->viispHttpClient->doRequest($identityDom);

        $dom = new DOMDocument();
        $dom->loadXML($resp);
        $xpath = new DOMXPath($dom);
        $xpath->registerNamespace('authentication', $this->viispAuthUrl);

        return $this->generateIdentity($xpath);
    }

    private function generateIdentity(DomXPath $xpath): ViispIdentityData
    {
        /** @var DOMNodeList<DOMNode> $codeQuery */
        $codeQuery = $xpath->query('//authentication:authenticationAttribute/authentication:value');
        $personalCode = (string) $codeQuery->item(0)?->nodeValue;

        $firstName = '';
        $lastName = '';

        /** @var DOMNodeList<DOMNode> $userInfoNodes */
        $userInfoNodes = $xpath->query('//authentication:userInformation');
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
