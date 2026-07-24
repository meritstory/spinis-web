<?php

declare(strict_types=1);

namespace App\Service\Viisp;

use DOMDocument;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class ViispHttpClient
{
    private const string SOAP_ACTION_BASE = 'http://www.epaslaugos.lt/services/authenticationServiceProvider/';
    public const string SOAP_ENVELOPE_NS = 'http://schemas.xmlsoap.org/soap/envelope/';

    public function __construct(
        private HttpClientInterface $httpClient,
        #[Autowire(env: 'VIISP_SOAP_ENDPOINT_URL')]
        private string $viispSoapEndpointUrl,
        #[Autowire(env: 'VIISP_AUTH_URL')]
        private string $viispAuthUrl,
    ) {
    }

    public function doRequest(DOMDocument $dom, string $operation): ?string
    {
        $signedXml = $dom->saveXML($dom->documentElement);
        if ($signedXml === false) {
            throw new \RuntimeException('VIISP: failed to serialize signed XML request.');
        }

        $soapRequest = str_replace(
            '{xml}',
            $signedXml,
            "<soapenv:Envelope xmlns:soapenv='".self::SOAP_ENVELOPE_NS."'
                  xmlns:ns2='$this->viispAuthUrl'
                  xmlns:exc='http://www.w3.org/2001/10/xml-exc-c14n#'>
                <soapenv:Header/>
                <soapenv:Body>{xml}</soapenv:Body>
            </soapenv:Envelope>"
        );

        $response = $this->httpClient->request('POST', $this->viispSoapEndpointUrl, [
            'headers' => [
                'Connection' => 'Keep-Alive',
                'Accept-Encoding' => 'gzip,deflate',
                'Content-Type' => 'text/xml;charset=UTF-8',
                'SOAPAction' => self::SOAP_ACTION_BASE.$operation,
                'Content-Length' => strlen($soapRequest),
                'User-Agent' => 'Apache-HttpClient/4.1.1 (java 1.5)',
            ],
            'body' => $soapRequest,
            'timeout' => 10,
            'max_duration' => 20,
            'max_redirects' => 0,
        ]);

        return $response->getContent();
    }
}
