# Priedų gavimas

- Path: `/api-dok/dbsis-api/api-taikymas/rdodocumentws/priedu-gavimas`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/rdodocumentws/priedu-gavimas
- Index: 77

---

RDODocumentWS priedų gavimo operacijos

### getBodyAttachment

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_46-getbodyattachment)

Gauna dokumento pagrindinį priedą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:getBodyAttachment>
         <getBodyAttachmentParam>
            <docOid>DOC_12345</docOid>
            <oid>ATT-0001</oid>
            <retrieveBodyAttachment>CONTENT</retrieveBodyAttachment>
         </getBodyAttachmentParam>
      </rdo:getBodyAttachment>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetAttachmentParam param = new GetAttachmentParam();
param.setDocOid("DOC_12345");
param.setOid("ATT-0001");
param.setRetrieveBodyAttachment(ReturnBodyAttachmentEnumType.CONTENT);

GetAttachmentResult result = port.getBodyAttachment(param);
System.out.println("Priedo OID: " + result.getBodyAttachment().getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:getBodyAttachment>
         <getBodyAttachmentParam>
            <docOid>DOC_12345</docOid>
            <oid>ATT-0001</oid>
            <retrieveBodyAttachment>CONTENT</retrieveBodyAttachment>
         </getBodyAttachmentParam>
      </rdo:getBodyAttachment>
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
    'getBodyAttachmentParam' => [
        'docOid' => 'DOC_12345',
        'oid' => 'ATT-0001',
        'retrieveBodyAttachment' => 'CONTENT'
    ]
];

$result = $client->getBodyAttachment($param);
echo "Priedo OID: " . $result->bodyAttachment->oid;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: ""' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:getBodyAttachment>
         <getBodyAttachmentParam>
            <docOid>DOC_12345</docOid>
            <oid>ATT-0001</oid>
            <retrieveBodyAttachment>CONTENT</retrieveBodyAttachment>
         </getBodyAttachmentParam>
      </rdo:getBodyAttachment>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getDocumentAttachmentList

Gauna dokumento priedų sąrašą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:getDocumentAttachmentList>
         <getDocumentAttachmentListParam>
            <docOid>DOC_12345</docOid>
            <attachmentMapName>attachments</attachmentMapName>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
         </getDocumentAttachmentListParam>
      </rdo:getDocumentAttachmentList>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetDocumentAttachmentListParam param = new GetDocumentAttachmentListParam();
param.setDocOid("DOC_12345");
param.setAttachmentMapName("attachments");
param.setRetrieveBodyAttachment(ReturnBodyAttachmentEnumType.METADATA);

GetAttachmentListResultBean result = port.getDocumentAttachmentList(param);
System.out.println("Priedų: " + result.getDocumentAttachments().size());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:getDocumentAttachmentList>
         <getDocumentAttachmentListParam>
            <docOid>DOC_12345</docOid>
            <attachmentMapName>attachments</attachmentMapName>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
         </getDocumentAttachmentListParam>
      </rdo:getDocumentAttachmentList>
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
    'getDocumentAttachmentListParam' => [
        'docOid' => 'DOC_12345',
        'attachmentMapName' => 'attachments',
        'retrieveBodyAttachment' => 'METADATA'
    ]
];

$result = $client->getDocumentAttachmentList($param);
echo "Priedų: " . count($result->documentAttachments);
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: ""' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:getDocumentAttachmentList>
         <getDocumentAttachmentListParam>
            <docOid>DOC_12345</docOid>
            <attachmentMapName>attachments</attachmentMapName>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
         </getDocumentAttachmentListParam>
      </rdo:getDocumentAttachmentList>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getEDocumentInnerAttachment

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#getedocumentinnerattachment)

Gauna e-dokumento vidinį priedą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:getEDocumentInnerAttachment>
         <getEDocumentInnerAttachmentParam>
            <docOid>DOC_12345</docOid>
            <containerType>ADOC</containerType>
            <path>/attachments/file.pdf</path>
         </getEDocumentInnerAttachmentParam>
      </rdo:getEDocumentInnerAttachment>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetEDocumentInnerAttachmentParam param = new GetEDocumentInnerAttachmentParam();
param.setDocOid("DOC_12345");
param.setContainerType("ADOC");
param.setPath("/attachments/file.pdf");

GetEDocumentInnerAttachmentResult result = port.getEDocumentInnerAttachment(param);
System.out.println("Priedo OID: " + result.getAttachment().getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:getEDocumentInnerAttachment>
         <getEDocumentInnerAttachmentParam>
            <docOid>DOC_12345</docOid>
            <containerType>ADOC</containerType>
            <path>/attachments/file.pdf</path>
         </getEDocumentInnerAttachmentParam>
      </rdo:getEDocumentInnerAttachment>
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
    'getEDocumentInnerAttachmentParam' => [
        'docOid' => 'DOC_12345',
        'containerType' => 'ADOC',
        'path' => '/attachments/file.pdf'
    ]
];

$result = $client->getEDocumentInnerAttachment($param);
echo "Priedo OID: " . $result->attachment->oid;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: ""' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:getEDocumentInnerAttachment>
         <getEDocumentInnerAttachmentParam>
            <docOid>DOC_12345</docOid>
            <containerType>ADOC</containerType>
            <path>/attachments/file.pdf</path>
         </getEDocumentInnerAttachmentParam>
      </rdo:getEDocumentInnerAttachment>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getElectroContainer

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_49-getelectrocontainer)

Gauna dokumento elektroninį konteinerį.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:getElectroContainer>
         <getElectroContainerParam>
            <docOid>DOC_12345</docOid>
            <retrieveElectroContainer>CONTENT</retrieveElectroContainer>
         </getElectroContainerParam>
      </rdo:getElectroContainer>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetElectroContainerParam param = new GetElectroContainerParam();
param.setDocOid("DOC_12345");
param.setRetrieveElectroContainer(ReturnBodyAttachmentEnumType.CONTENT);

GetElectroContainerResult result = port.getElectroContainer(param);
System.out.println("Konteinerio OID: " + result.getElectroContainer().getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:getElectroContainer>
         <getElectroContainerParam>
            <docOid>DOC_12345</docOid>
            <retrieveElectroContainer>CONTENT</retrieveElectroContainer>
         </getElectroContainerParam>
      </rdo:getElectroContainer>
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
    'getElectroContainerParam' => [
        'docOid' => 'DOC_12345',
        'retrieveElectroContainer' => 'CONTENT'
    ]
];

$result = $client->getElectroContainer($param);
echo "Konteinerio OID: " . $result->attachment->electroContainer->oid;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: ""' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:getElectroContainer>
         <getElectroContainerParam>
            <docOid>DOC_12345</docOid>
            <retrieveElectroContainer>CONTENT</retrieveElectroContainer>
         </getElectroContainerParam>
      </rdo:getElectroContainer>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getContentCopyAttachmentOrEmpty

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_2213-operacija-getcontentcopyattachmentorempty)

Gauna dokumento turinio kopiją arba tuščią rezultatą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:getContentCopyAttachmentOrEmpty>
         <getContentCopyAttachmentOrEmptyParam>
            <docOid>DOC_12345</docOid>
            <retrieveContentCopyAttachment>CONTENT</retrieveContentCopyAttachment>
         </getContentCopyAttachmentOrEmptyParam>
      </rdo:getContentCopyAttachmentOrEmpty>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetContentCopyAttachmentOrEmptyParam param = new GetContentCopyAttachmentOrEmptyParam();
param.setDocOid("DOC_12345");
param.setRetrieveContentCopyAttachment(ReturnBodyAttachmentEnumType.CONTENT);

GetContentCopyAttachmentOrEmptyResult result = port.getContentCopyAttachmentOrEmpty(param);
System.out.println("Kopijos OID: " + result.getContentCopyAttachment().getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:getContentCopyAttachmentOrEmpty>
         <getContentCopyAttachmentOrEmptyParam>
            <docOid>DOC_12345</docOid>
            <retrieveContentCopyAttachment>CONTENT</retrieveContentCopyAttachment>
         </getContentCopyAttachmentOrEmptyParam>
      </rdo:getContentCopyAttachmentOrEmpty>
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
    'getContentCopyAttachmentOrEmptyParam' => [
        'docOid' => 'DOC_12345',
        'retrieveContentCopyAttachment' => 'CONTENT'
    ]
];

$result = $client->getContentCopyAttachmentOrEmpty($param);
echo "Kopijos OID: " . $result->contentCopyAttachment->oid;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: ""' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:getContentCopyAttachmentOrEmpty>
         <getContentCopyAttachmentOrEmptyParam>
            <docOid>DOC_12345</docOid>
            <retrieveContentCopyAttachment>CONTENT</retrieveContentCopyAttachment>
         </getContentCopyAttachmentOrEmptyParam>
      </rdo:getContentCopyAttachmentOrEmpty>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---
