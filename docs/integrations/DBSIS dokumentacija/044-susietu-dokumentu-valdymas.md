# Susietų dokumentų valdymas

- Path: `/api-dok/dbsis-api/api-taikymas/doclinkws/susietu-dokumentu-valdymas`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/doclinkws/susietu-dokumentu-valdymas
- Index: 44

---

DocLinkWS susietų dokumentų operacijos

### getLinkedDocuments

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/susietu-dokumentu-pateikimo-sasaja#_2102-operacija-getlinkeddocuments)

Grąžina su nurodytu dokumentu susietus dokumentus.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:doc="http://www.sintagma.lt/avilys/DocLinkWS">
   <soapenv:Body>
      <doc:getLinkedDocuments>
         <getLinkedDocumentsParam>
            <docOid>DOC-2024-0001</docOid>
            <linkType>INFOLINK</linkType>
            <side>SIDE_A</side>
         </getLinkedDocumentsParam>
      </doc:getLinkedDocuments>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetLinkedDocumentsParam param = new GetLinkedDocumentsParam();
param.setDocOid("DOC-2024-0001");
param.setLinkType("INFOLINK");
param.setSide(Side.SIDE_A);

GetLinkedDocumentsResult result = port.getLinkedDocuments(param);
for (LinkedDocument linked : result.getLinkedDocument()) {
    System.out.println(linked.getTargetDoc().getDocumentInfo().getOid());
}
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:doc=\"http://www.sintagma.lt/avilys/DocLinkWS\">
   <soapenv:Body>
      <doc:getLinkedDocuments>
         <getLinkedDocumentsParam>
            <docOid>DOC-2024-0001</docOid>
            <linkType>INFOLINK</linkType>
            <side>SIDE_A</side>
         </getLinkedDocumentsParam>
      </doc:getLinkedDocuments>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/DocLinkWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/DocLinkWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'getLinkedDocumentsParam' => [
        'docOid' => 'DOC-2024-0001',
        'linkType' => 'INFOLINK',
        'side' => 'SIDE_A'
    ]
];

$result = $client->getLinkedDocuments($param);
foreach ($result->linkedDocuments->linkedDocument ?? [] as $linked) {
    echo $linked->targetDoc->documentInfo->oid . PHP_EOL;
}
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/DocLinkWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/DocLinkWS/getLinkedDocuments"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:doc="http://www.sintagma.lt/avilys/DocLinkWS">
   <soapenv:Body>
      <doc:getLinkedDocuments>
         <getLinkedDocumentsParam>
            <docOid>DOC-2024-0001</docOid>
            <linkType>INFOLINK</linkType>
            <side>SIDE_A</side>
         </getLinkedDocumentsParam>
      </doc:getLinkedDocuments>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### createDocumentLink

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/susietu-dokumentu-pateikimo-sasaja#_2103-operacija-createdocumentlink)

Sukuria dokumentų susiejimą nurodytu ryšio tipu.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:doc="http://www.sintagma.lt/avilys/DocLinkWS">
   <soapenv:Body>
      <doc:createDocumentLink>
         <createDocumentLinkParam>
            <sourceOid>DOC-2024-0001</sourceOid>
            <targetOid>DOC-2024-0002</targetOid>
            <linkType>INFOLINK</linkType>
            <targetDocSide>SIDE_B</targetDocSide>
         </createDocumentLinkParam>
      </doc:createDocumentLink>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
CreateDocumentLinkParam param = new CreateDocumentLinkParam();
param.setSourceOid("DOC-2024-0001");
param.setTargetOid("DOC-2024-0002");
param.setLinkType("INFOLINK");
param.setTargetDocSide(Side.SIDE_B);

boolean status = port.createDocumentLink(param);
System.out.println(status);
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:doc=\"http://www.sintagma.lt/avilys/DocLinkWS\">
   <soapenv:Body>
      <doc:createDocumentLink>
         <createDocumentLinkParam>
            <sourceOid>DOC-2024-0001</sourceOid>
            <targetOid>DOC-2024-0002</targetOid>
            <linkType>INFOLINK</linkType>
            <targetDocSide>SIDE_B</targetDocSide>
         </createDocumentLinkParam>
      </doc:createDocumentLink>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/DocLinkWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/DocLinkWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'createDocumentLinkParam' => [
        'sourceOid' => 'DOC-2024-0001',
        'targetOid' => 'DOC-2024-0002',
        'linkType' => 'INFOLINK',
        'targetDocSide' => 'SIDE_B'
    ]
];

$result = $client->createDocumentLink($param);
echo $result->status ? 'true' : 'false';
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/DocLinkWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/DocLinkWS/createDocumentLink"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:doc="http://www.sintagma.lt/avilys/DocLinkWS">
   <soapenv:Body>
      <doc:createDocumentLink>
         <createDocumentLinkParam>
            <sourceOid>DOC-2024-0001</sourceOid>
            <targetOid>DOC-2024-0002</targetOid>
            <linkType>INFOLINK</linkType>
            <targetDocSide>SIDE_B</targetDocSide>
         </createDocumentLinkParam>
      </doc:createDocumentLink>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija
