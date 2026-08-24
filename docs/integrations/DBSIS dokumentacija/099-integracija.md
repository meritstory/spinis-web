# Integracija

- Path: `/api-dok/dbsis-api/api-taikymas/tspws/integracija`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/tspws/integracija
- Index: 99

---

TspWS integracijos operacijos

### getTrustServiceProviders

Grąžina patikimų paslaugų teikėjų sąrašą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:tsp="http://www.sintagma.lt/avilys/TspWS">
   <soapenv:Body>
      <tsp:getTrustServiceProviders />
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetTrustSerovceProvidersResult result = port.getTrustServiceProviders();
System.out.println(result.getTrustedServiceProvider().size());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:tsp=\"http://www.sintagma.lt/avilys/TspWS\">
   <soapenv:Body>
      <tsp:getTrustServiceProviders />
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/TspWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/TspWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$result = $client->getTrustServiceProviders();
foreach ($result->tspList->trustedServiceProvider ?? [] as $provider) {
    echo $provider->name . PHP_EOL;
}
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/TspWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/TspWS/getTrustServiceProviders"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:tsp="http://www.sintagma.lt/avilys/TspWS">
   <soapenv:Body>
      <tsp:getTrustServiceProviders />
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija
