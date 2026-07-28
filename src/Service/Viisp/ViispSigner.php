<?php

declare(strict_types=1);

namespace App\Service\Viisp;

use DOMElement;
use OpenSSLAsymmetricKey;

readonly class ViispSigner
{
    public function signDomElement(DOMElement $node, string $privateKey): DOMElement
    {
        $signInfoElement = $this->getSignInfo($node);
        $signatureElement = $node->ownerDocument->createElement('Signature');
        $signatureElement->setAttribute('xmlns', 'http://www.w3.org/2000/09/xmldsig#');
        $signatureElement->appendChild($signInfoElement);
        $node->appendChild($signatureElement);

        $signatureValueElement = $this->getSignatureValue($signInfoElement, $privateKey);
        $signatureElement->appendChild($signatureValueElement);

        $keyInfoElement = $this->getKeyInfo($signInfoElement, $privateKey);
        $signatureElement->appendChild($keyInfoElement);

        $node->setAttribute('xmlns', 'http://www.w3.org/2000/09/xmldsig#');
        $node->setAttribute('xmlns:ns3', 'http://www.w3.org/2001/10/xml-exc-c14n#');

        return $node;
    }

    private function getSignInfo(DOMElement $node): DOMElement
    {
        $dom = $node->ownerDocument;

        $signedInfoElement = $dom->createElement('SignedInfo');
        $inclusiveNamespaces = $dom->createElement('InclusiveNamespaces');
        $inclusiveNamespaces->setAttribute('PrefixList', 'ns2');
        $inclusiveNamespaces->setAttribute('xmlns', 'http://www.w3.org/2001/10/xml-exc-c14n#');

        $canonicalizationMethodElement = $dom->createElement('CanonicalizationMethod');
        $canonicalizationMethodElement->setAttribute('Algorithm', 'http://www.w3.org/2001/10/xml-exc-c14n#');
        $canonicalizationMethodElement->appendChild($inclusiveNamespaces);

        $signedInfoElement->appendChild($canonicalizationMethodElement);

        $signatureMethodElement = $dom->createElement('SignatureMethod');
        $signatureMethodElement->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#rsa-sha1');
        $signedInfoElement->appendChild($signatureMethodElement);

        $referenceElement = $dom->createElement('Reference');
        $referenceElement->setAttribute('URI', '#'.$node->getAttribute('id'));

        $transformsElement = $dom->createElement('Transforms');
        $transformsElementFirstChild = $dom->createElement('Transform');
        $transformsElementFirstChild->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#enveloped-signature');
        $transformsElement->appendChild($transformsElementFirstChild);

        $transformsElementSecondChild = $dom->createElement('Transform');
        $transformsElementSecondChild->setAttribute('Algorithm', 'http://www.w3.org/2001/10/xml-exc-c14n#');
        $transformsElementSecondChild->appendChild(clone $inclusiveNamespaces);
        $transformsElement->appendChild($transformsElementSecondChild);
        $referenceElement->appendChild($transformsElement);

        $digestMethodElement = $dom->createElement('DigestMethod');
        $digestMethodElement->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#sha1');
        $referenceElement->appendChild($digestMethodElement);

        $digestValue = base64_encode(hash('sha1', $this->canonicalize($node), true));
        $digestValueElement = $dom->createElement('DigestValue', $digestValue);
        $referenceElement->appendChild($digestValueElement);

        $signedInfoElement->appendChild($referenceElement);

        return $signedInfoElement;
    }

    private function canonicalize(DOMElement $node): string
    {
        $canonical = $node->C14N(true);
        if ($canonical === false) {
            throw new \RuntimeException('VIISP: failed to canonicalize XML for digest calculation.');
        }
        return $canonical;
    }

    private function getSignatureValue(DOMElement $signInfo, string $privateKey): DOMElement
    {
        $dom = $signInfo->ownerDocument;
        $privateKeyId = $this->getPrivateKeyId($privateKey);

        if (!openssl_sign($signInfo->C14N(), $signature, $privateKeyId)) {
            throw new \RuntimeException('VIISP: failed to sign SOAP request: '.openssl_error_string());
        }

        $signatureValue = base64_encode((string) $signature);

        return $dom->createElement('SignatureValue', $signatureValue);
    }

    private function getKeyInfo(DOMElement $signInfo, string $privateKey): DOMElement
    {
        $dom = $signInfo->ownerDocument;
        $privateKeyId = $this->getPrivateKeyId($privateKey);
        /** @var array<string, array<string, string>> $keyDetails */
        $keyDetails = openssl_pkey_get_details($privateKeyId);

        $modulus = base64_encode($keyDetails['rsa']['n']);
        $exponent = base64_encode($keyDetails['rsa']['e']);

        $keyInfoElement = $dom->createElement('KeyInfo');
        $keyValueElement = $keyInfoElement->appendChild($dom->createElement('KeyValue'));
        $rsaKeyValueElement = $keyValueElement->appendChild($dom->createElement('RSAKeyValue'));
        $rsaKeyValueElement->appendChild($dom->createElement('Modulus', $modulus));
        $rsaKeyValueElement->appendChild($dom->createElement('Exponent', $exponent));

        return $keyInfoElement;
    }

    private function getPrivateKeyId(string $privateKey): OpenSSLAsymmetricKey
    {
        $privateKeyContent = file_get_contents($privateKey);
        if ($privateKeyContent === false) {
            throw new \RuntimeException('VIISP: failed to read private key file: '.$privateKey);
        }

        $opensslKey = openssl_pkey_get_private($privateKeyContent);
        if ($opensslKey === false) {
            throw new \RuntimeException('VIISP: failed to load private key: '.openssl_error_string());
        }

        return $opensslKey;
    }
}
