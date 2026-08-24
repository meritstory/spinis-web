# Būsenos žymėjimas

- Path: `/api-dok/dbsis-api/api-taikymas/rdodocumentws/busenos-zymejimas`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/rdodocumentws/busenos-zymejimas
- Index: 85

---

RDODocumentWS būsenos žymėjimo operacijos

### markVersionReady

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_2225-operacija-markversionready)

Pažymi dokumento versiją kaip paruoštą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:markVersionReady>
         <markVersionReadyParam>
            <docOid>DOC_12345</docOid>
         </markVersionReadyParam>
      </rdo:markVersionReady>
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
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:markVersionReady>
         <markVersionReadyParam>
            <docOid>DOC_12345</docOid>
         </markVersionReadyParam>
      </rdo:markVersionReady>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS?wsdl';
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
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: \"\"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:markVersionReady>
         <markVersionReadyParam>
            <docOid>DOC_12345</docOid>
         </markVersionReadyParam>
      </rdo:markVersionReady>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### markPublished

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_2240-operacija-markpublished)

Pažymi dokumentą kaip paskelbtą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:markPublished>
         <markPublishedParam>
            <docOid>DOC_12345</docOid>
            <publicationUrl>https://example.com/doc/12345</publicationUrl>
         </markPublishedParam>
      </rdo:markPublished>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
MarkPublishedParam param = new MarkPublishedParam();
param.setDocOid("DOC_12345");
param.setPublicationUrl("https://example.com/doc/12345");

DocumentInfo result = port.markPublished(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:markPublished>
         <markPublishedParam>
            <docOid>DOC_12345</docOid>
            <publicationUrl>https://example.com/doc/12345</publicationUrl>
         </markPublishedParam>
      </rdo:markPublished>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'markPublishedParam' => [
        'docOid' => 'DOC_12345',
        'publicationUrl' => 'https://example.com/doc/12345'
    ]
];

$result = $client->markPublished($param);
echo "Dokumento OID: " . $result->documentInfo->oid;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: \"\"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:markPublished>
         <markPublishedParam>
            <docOid>DOC_12345</docOid>
            <publicationUrl>https://example.com/doc/12345</publicationUrl>
         </markPublishedParam>
      </rdo:markPublished>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### terminate

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_35-operacija-terminate)

Nutraukia dokumento gyvavimo ciklą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:terminate>
         <terminateParam>
            <docOid>DOC_12345</docOid>
            <text>Dokumentas nebereikalingas</text>
         </terminateParam>
      </rdo:terminate>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
TerminateParam param = new TerminateParam();
param.setDocOid("DOC_12345");
param.setText("Dokumentas nebereikalingas");

DocumentInfo result = port.terminate(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:terminate>
         <terminateParam>
            <docOid>DOC_12345</docOid>
            <text>Dokumentas nebereikalingas</text>
         </terminateParam>
      </rdo:terminate>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'terminateParam' => [
        'docOid' => 'DOC_12345',
        'text' => 'Dokumentas nebereikalingas'
    ]
];

$result = $client->terminate($param);
echo "Dokumento OID: " . $result->documentInfo->oid;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: \"\"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:terminate>
         <terminateParam>
            <docOid>DOC_12345</docOid>
            <text>Dokumentas nebereikalingas</text>
         </terminateParam>
      </rdo:terminate>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---
