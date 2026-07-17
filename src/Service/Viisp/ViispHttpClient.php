<?php

declare(strict_types=1);

namespace App\Service\Viisp;

use DOMDocument;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class ViispHttpClient
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private string $viispSoapEndpointUrl,
        private string $viispSoapActionBaseUrl,
        private string $viispAuthUrl,
    ) {
    }

    public function doRequest(DOMDocument $dom): ?string
    {
        $soapRequest = str_replace(
            '{xml}',
            (string) $dom->saveHTML(),
            "<soapenv:Envelope xmlns:soapenv='http://schemas.xmlsoap.org/soap/envelope/'
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
                'SOAPAction' => $this->viispSoapActionBaseUrl.'authenticationServiceProvider/initAuthentication',
                'Content-Length' => strlen($soapRequest),
                'User-Agent' => 'Apache-HttpClient/4.1.1 (java 1.5)',
            ],
            'body' => $soapRequest,
        ]);

        return $response->getContent();
    }
}
