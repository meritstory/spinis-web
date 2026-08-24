# Integracija

- Path: `/api-dok/dbsis-api/api-taikymas/pingws/integracija`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/pingws/integracija
- Index: 71

---

PingWS integracijos operacijos

### ping

Tikrina sistemos pasiekiamumą ir grąžina `pong` atsaką su tuo pačiu token.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:pin="http://www.sintagma.lt/avilys/PingWS">
   <soapenv:Body>
      <pin:ping>
         <ping>
            <token>TOKEN_123</token>
         </ping>
      </pin:ping>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
PingParam param = new PingParam();
param.setToken("TOKEN_123");

Pong result = port.ping(param);
System.out.println(result.getToken());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:pin=\"http://www.sintagma.lt/avilys/PingWS\">
   <soapenv:Body>
      <pin:ping>
         <ping>
            <token>TOKEN_123</token>
         </ping>
      </pin:ping>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/PingWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/PingWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'ping' => [
        'token' => 'TOKEN_123'
    ]
];

$result = $client->ping($param);
if (isset($result->pong)) {
    echo $result->pong->token . PHP_EOL;
}
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/PingWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/PingWS/ping"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:pin="http://www.sintagma.lt/avilys/PingWS">
   <soapenv:Body>
      <pin:ping>
         <ping>
            <token>TOKEN_123</token>
         </ping>
      </pin:ping>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija
