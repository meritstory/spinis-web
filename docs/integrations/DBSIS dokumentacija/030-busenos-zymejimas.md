# Būsenos žymėjimas

- Path: `/api-dok/dbsis-api/api-taikymas/cdodocumentws/busenos-zymejimas`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/cdodocumentws/busenos-zymejimas
- Index: 30

---

CDODocumentWS būsenos žymėjimo operacijos

### markVersionReady

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/sutarciu-sasaja#_21410-operacija-markversionready)

Pažymi dokumento versiją kaip paruoštą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cdo="http://www.sintagma.lt/avilys/CDODocumentWS">
   <soapenv:Body>
      <cdo:markVersionReady>
         <markVersionReadyParam>
            <docOid>DOC_12345</docOid>
         </markVersionReadyParam>
      </cdo:markVersionReady>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
MarkVersionReadyParam param = new MarkVersionReadyParam();
param.setDocOid("DOC_12345");

DocumentInfo result = port.markVersionReady(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:cdo=""http://www.sintagma.lt/avilys/CDODocumentWS"">
   <soapenv:Body>
      <cdo:markVersionReady>
         <markVersionReadyParam>
            <docOid>DOC_12345</docOid>
         </markVersionReadyParam>
      </cdo:markVersionReady>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/CDODocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/CDODocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'markVersionReadyParam' => [
        'docOid' => 'DOC_12345'
    ]
];

$result = $client->markVersionReady($param);
echo "Dokumento OID: " . $result->documentInfo->oid;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/CDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: \"\"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cdo="http://www.sintagma.lt/avilys/CDODocumentWS">
   <soapenv:Body>
      <cdo:markVersionReady>
         <markVersionReadyParam>
            <docOid>DOC_12345</docOid>
         </markVersionReadyParam>
      </cdo:markVersionReady>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---
