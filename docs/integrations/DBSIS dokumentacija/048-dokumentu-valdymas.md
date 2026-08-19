# Dokumentų valdymas

- Path: `/api-dok/dbsis-api/api-taikymas/documentws/dokumentu-valdymas`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/documentws/dokumentu-valdymas
- Index: 48

---

DocumentWS dokumentų valdymo operacijos

### getDocumentList

Grąžina dokumentų sąrašą pagal paieškos parametrus.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:doc="http://www.sintagma.lt/avilys/DocumentWS">
   <soapenv:Body>
      <doc:getDocumentList>
         <getDocumentListParam>
            <searchParameters>
               <entry>
                  <key>docNo</key>
                  <value>RN-2024-001</value>
               </entry>
            </searchParameters>
            <pageSize>10</pageSize>
            <pageNum>1</pageNum>
         </getDocumentListParam>
      </doc:getDocumentList>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetDocumentListParam param = new GetDocumentListParam();
List<SearchParamEntry> entries = param.getSearchParameters().getEntry();
SearchParamEntry entry = new SearchParamEntry();
entry.setKey("docNo");
entry.setValue("RN-2024-001");
entries.add(entry);
param.setPageSize(10);
param.setPageNum(1);

GetDocumentListResult result = port.getDocumentList(param);
System.out.println(result.getTotalDocumentsFound());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:doc=\"http://www.sintagma.lt/avilys/DocumentWS\">
   <soapenv:Body>
      <doc:getDocumentList>
         <getDocumentListParam>
            <searchParameters>
               <entry>
                  <key>docNo</key>
                  <value>RN-2024-001</value>
               </entry>
            </searchParameters>
            <pageSize>10</pageSize>
            <pageNum>1</pageNum>
         </getDocumentListParam>
      </doc:getDocumentList>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/DocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/DocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'getDocumentListParam' => [
        'searchParameters' => [
            'entry' => [
                ['key' => 'docNo', 'value' => 'RN-2024-001']
            ]
        ],
        'pageSize' => 10,
        'pageNum' => 1
    ]
];

$result = $client->getDocumentList($param);
echo $result->documentList->totalDocumentsFound . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/DocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/DocumentWS/getDocumentList"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:doc="http://www.sintagma.lt/avilys/DocumentWS">
   <soapenv:Body>
      <doc:getDocumentList>
         <getDocumentListParam>
            <searchParameters>
               <entry>
                  <key>docNo</key>
                  <value>RN-2024-001</value>
               </entry>
            </searchParameters>
            <pageSize>10</pageSize>
            <pageNum>1</pageNum>
         </getDocumentListParam>
      </doc:getDocumentList>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getDocument

Grąžina vieno dokumento informaciją pagal OID.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:doc="http://www.sintagma.lt/avilys/DocumentWS">
   <soapenv:Body>
      <doc:getDocument>
         <getDocumentParam>
            <docOid>DOC-2024-0001</docOid>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
            <retrieveElectroContainer>METADATA</retrieveElectroContainer>
            <retrieveProcessTasks>false</retrieveProcessTasks>
         </getDocumentParam>
      </doc:getDocument>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetDocumentParam param = new GetDocumentParam();
param.setDocOid("DOC-2024-0001");
param.setRetrieveBodyAttachment(ReturnBodyAttachmentEnumType.METADATA);
param.setRetrieveElectroContainer(ReturnBodyAttachmentEnumType.METADATA);
param.setRetrieveProcessTasks(false);

GetDocumentResult result = port.getDocument(param);
System.out.println(result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:doc=\"http://www.sintagma.lt/avilys/DocumentWS\">
   <soapenv:Body>
      <doc:getDocument>
         <getDocumentParam>
            <docOid>DOC-2024-0001</docOid>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
            <retrieveElectroContainer>METADATA</retrieveElectroContainer>
            <retrieveProcessTasks>false</retrieveProcessTasks>
         </getDocumentParam>
      </doc:getDocument>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/DocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/DocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'getDocumentParam' => [
        'docOid' => 'DOC-2024-0001',
        'retrieveBodyAttachment' => 'METADATA',
        'retrieveElectroContainer' => 'METADATA',
        'retrieveProcessTasks' => false
    ]
];

$result = $client->getDocument($param);
echo $result->document->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/DocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/DocumentWS/getDocument"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:doc="http://www.sintagma.lt/avilys/DocumentWS">
   <soapenv:Body>
      <doc:getDocument>
         <getDocumentParam>
            <docOid>DOC-2024-0001</docOid>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
            <retrieveElectroContainer>METADATA</retrieveElectroContainer>
            <retrieveProcessTasks>false</retrieveProcessTasks>
         </getDocumentParam>
      </doc:getDocument>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### modifyDocument

Atnaujina dokumento atributus ir priedus.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:doc="http://www.sintagma.lt/avilys/DocumentWS">
   <soapenv:Body>
      <doc:modifyDocument>
         <modifyDocumentParam>
            <docOid>DOC-2024-0001</docOid>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Atnaujintas pavadinimas</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>note</key>
                  <value>Atnaujinta</value>
               </entry>
            </extraAttributes>
         </modifyDocumentParam>
      </doc:modifyDocument>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
ModifyDocumentParam param = new ModifyDocumentParam();
param.setDocOid("DOC-2024-0001");

Map<String, Object> docAttributes = new HashMap<>();
docAttributes.put("title", "Atnaujintas pavadinimas");
param.setDocAttributes(docAttributes);

Map<String, Object> extraAttributes = new HashMap<>();
extraAttributes.put("note", "Atnaujinta");
param.setExtraAttributes(extraAttributes);

DocumentInfo result = port.modifyDocument(param);
System.out.println(result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:doc=\"http://www.sintagma.lt/avilys/DocumentWS\">
   <soapenv:Body>
      <doc:modifyDocument>
         <modifyDocumentParam>
            <docOid>DOC-2024-0001</docOid>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Atnaujintas pavadinimas</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>note</key>
                  <value>Atnaujinta</value>
               </entry>
            </extraAttributes>
         </modifyDocumentParam>
      </doc:modifyDocument>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/DocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/DocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'modifyDocumentParam' => [
        'docOid' => 'DOC-2024-0001',
        'docAttributes' => [
            'entry' => [
                ['key' => 'title', 'value' => 'Atnaujintas pavadinimas']
            ]
        ],
        'extraAttributes' => [
            'entry' => [
                ['key' => 'note', 'value' => 'Atnaujinta']
            ]
        ]
    ]
];

$result = $client->modifyDocument($param);
echo $result->documentInfo->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/DocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/DocumentWS/modifyDocument"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:doc="http://www.sintagma.lt/avilys/DocumentWS">
   <soapenv:Body>
      <doc:modifyDocument>
         <modifyDocumentParam>
            <docOid>DOC-2024-0001</docOid>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Atnaujintas pavadinimas</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>note</key>
                  <value>Atnaujinta</value>
               </entry>
            </extraAttributes>
         </modifyDocumentParam>
      </doc:modifyDocument>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getDocumentAttachmentList

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/dokumentu-sasaja#_2172-operacija-getdocumentattachmentlist)

Grąžina dokumento priedų sąrašą pagal šaką.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:doc="http://www.sintagma.lt/avilys/DocumentWS">
   <soapenv:Body>
      <doc:getDocumentAttachmentList>
         <getDocumentAttachmentListParam>
            <docOid>DOC-2024-0001</docOid>
            <attachmentMapName>APPENDICES</attachmentMapName>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
         </getDocumentAttachmentListParam>
      </doc:getDocumentAttachmentList>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetDocumentAttachmentListParam param = new GetDocumentAttachmentListParam();
param.setDocOid("DOC-2024-0001");
param.setAttachmentMapName("APPENDICES");
param.setRetrieveBodyAttachment(ReturnBodyAttachmentEnumType.METADATA);

GetAttachmentListResultBean result = port.getDocumentAttachmentList(param);
System.out.println(result.getDocumentAttachments().size());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:doc=\"http://www.sintagma.lt/avilys/DocumentWS\">
   <soapenv:Body>
      <doc:getDocumentAttachmentList>
         <getDocumentAttachmentListParam>
            <docOid>DOC-2024-0001</docOid>
            <attachmentMapName>APPENDICES</attachmentMapName>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
         </getDocumentAttachmentListParam>
      </doc:getDocumentAttachmentList>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/DocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/DocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'getDocumentAttachmentListParam' => [
        'docOid' => 'DOC-2024-0001',
        'attachmentMapName' => 'APPENDICES',
        'retrieveBodyAttachment' => 'METADATA'
    ]
];

$result = $client->getDocumentAttachmentList($param);
foreach ($result->documentAttachments->documentAttachments ?? [] as $attachment) {
    echo $attachment->oid . PHP_EOL;
}
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/DocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/DocumentWS/getDocumentAttachmentList"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:doc="http://www.sintagma.lt/avilys/DocumentWS">
   <soapenv:Body>
      <doc:getDocumentAttachmentList>
         <getDocumentAttachmentListParam>
            <docOid>DOC-2024-0001</docOid>
            <attachmentMapName>APPENDICES</attachmentMapName>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
         </getDocumentAttachmentListParam>
      </doc:getDocumentAttachmentList>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### removeDocumentVersions

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/dokumentu-sasaja#_2171-operacija-removedocumentversions)

Pašalina dokumento versijas, paliekant einamąją.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:doc="http://www.sintagma.lt/avilys/DocumentWS">
   <soapenv:Body>
      <doc:removeDocumentVersions>
         <removeDocumentVersionsParam>
            <docOid>DOC-2024-0001</docOid>
         </removeDocumentVersionsParam>
      </doc:removeDocumentVersions>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
RemoveDocumentVersionsParam param = new RemoveDocumentVersionsParam();
param.setDocOid("DOC-2024-0001");

RemoveDocumentVersionsResult result = port.removeDocumentVersions(param);
System.out.println(result.getResult());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:doc=\"http://www.sintagma.lt/avilys/DocumentWS\">
   <soapenv:Body>
      <doc:removeDocumentVersions>
         <removeDocumentVersionsParam>
            <docOid>DOC-2024-0001</docOid>
         </removeDocumentVersionsParam>
      </doc:removeDocumentVersions>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/DocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/DocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'removeDocumentVersionsParam' => [
        'docOid' => 'DOC-2024-0001'
    ]
];

$result = $client->removeDocumentVersions($param);
echo $result->removeDocumentVersionsResult->result . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/DocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/DocumentWS/removeDocumentVersions"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:doc="http://www.sintagma.lt/avilys/DocumentWS">
   <soapenv:Body>
      <doc:removeDocumentVersions>
         <removeDocumentVersionsParam>
            <docOid>DOC-2024-0001</docOid>
         </removeDocumentVersionsParam>
      </doc:removeDocumentVersions>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### createDocumentFromTemplate

Sukuria dokumentą pagal šabloną.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:doc="http://www.sintagma.lt/avilys/DocumentWS">
   <soapenv:Body>
      <doc:createDocumentFromTemplate>
         <documentFromTemplateParam>
            <templateParam>
               <oid>TEMPLATE_OID_001</oid>
            </templateParam>
            <register>true</register>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Dokumento pavadinimas</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>note</key>
                  <value>Papildoma informacija</value>
               </entry>
            </extraAttributes>
         </documentFromTemplateParam>
      </doc:createDocumentFromTemplate>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
DocumentFromTemplateParam param = new DocumentFromTemplateParam();
TemplateParam templateParam = new TemplateParam();
templateParam.setOid("TEMPLATE_OID_001");
param.setTemplateParam(templateParam);
param.setRegister(true);

Map<String, Object> docAttributes = new HashMap<>();
docAttributes.put("title", "Dokumento pavadinimas");
param.setDocAttributes(docAttributes);

Map<String, Object> extraAttributes = new HashMap<>();
extraAttributes.put("note", "Papildoma informacija");
param.setExtraAttributes(extraAttributes);

DocumentInfo result = port.createDocumentFromTemplate(param);
System.out.println(result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:doc=\"http://www.sintagma.lt/avilys/DocumentWS\">
   <soapenv:Body>
      <doc:createDocumentFromTemplate>
         <documentFromTemplateParam>
            <templateParam>
               <oid>TEMPLATE_OID_001</oid>
            </templateParam>
            <register>true</register>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Dokumento pavadinimas</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>note</key>
                  <value>Papildoma informacija</value>
               </entry>
            </extraAttributes>
         </documentFromTemplateParam>
      </doc:createDocumentFromTemplate>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/DocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/DocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'documentFromTemplateParam' => [
        'templateParam' => ['oid' => 'TEMPLATE_OID_001'],
        'register' => true,
        'docAttributes' => [
            'entry' => [
                ['key' => 'title', 'value' => 'Dokumento pavadinimas']
            ]
        ],
        'extraAttributes' => [
            'entry' => [
                ['key' => 'note', 'value' => 'Papildoma informacija']
            ]
        ]
    ]
];

$result = $client->createDocumentFromTemplate($param);
echo $result->documentInfo->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/DocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/DocumentWS/createDocumentFromTemplate"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:doc="http://www.sintagma.lt/avilys/DocumentWS">
   <soapenv:Body>
      <doc:createDocumentFromTemplate>
         <documentFromTemplateParam>
            <templateParam>
               <oid>TEMPLATE_OID_001</oid>
            </templateParam>
            <register>true</register>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Dokumento pavadinimas</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>note</key>
                  <value>Papildoma informacija</value>
               </entry>
            </extraAttributes>
         </documentFromTemplateParam>
      </doc:createDocumentFromTemplate>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getBodyAttachment

Grąžina dokumento priedą arba pagrindinį turinį pagal OID.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:doc="http://www.sintagma.lt/avilys/DocumentWS">
   <soapenv:Body>
      <doc:getBodyAttachment>
         <getAttachmentParam>
            <docOid>DOC-2024-0001</docOid>
            <oid>ATT-001</oid>
            <retrieveBodyAttachment>CONTENT</retrieveBodyAttachment>
         </getAttachmentParam>
      </doc:getBodyAttachment>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetAttachmentParam param = new GetAttachmentParam();
param.setDocOid("DOC-2024-0001");
param.setOid("ATT-001");
param.setRetrieveBodyAttachment(ReturnBodyAttachmentEnumType.CONTENT);

GetAttachmentResult result = port.getBodyAttachment(param);
System.out.println(result.getBodyAttachment().getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:doc=\"http://www.sintagma.lt/avilys/DocumentWS\">
   <soapenv:Body>
      <doc:getBodyAttachment>
         <getAttachmentParam>
            <docOid>DOC-2024-0001</docOid>
            <oid>ATT-001</oid>
            <retrieveBodyAttachment>CONTENT</retrieveBodyAttachment>
         </getAttachmentParam>
      </doc:getBodyAttachment>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/DocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/DocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'getAttachmentParam' => [
        'docOid' => 'DOC-2024-0001',
        'oid' => 'ATT-001',
        'retrieveBodyAttachment' => 'CONTENT'
    ]
];

$result = $client->getBodyAttachment($param);
echo $result->attachment->bodyAttachment->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/DocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/DocumentWS/getBodyAttachment"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:doc="http://www.sintagma.lt/avilys/DocumentWS">
   <soapenv:Body>
      <doc:getBodyAttachment>
         <getAttachmentParam>
            <docOid>DOC-2024-0001</docOid>
            <oid>ATT-001</oid>
            <retrieveBodyAttachment>CONTENT</retrieveBodyAttachment>
         </getAttachmentParam>
      </doc:getBodyAttachment>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### createDocumentFromAdoc

Sukuria dokumentą iš ADOC konteinerio.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:doc="http://www.sintagma.lt/avilys/DocumentWS">
   <soapenv:Body>
      <doc:createDocumentFromAdoc>
         <documentFromAdocParam>
            <templateParam>
               <oid>TEMPLATE_OID_001</oid>
            </templateParam>
            <register>true</register>
            <adocFile>
               <action>add</action>
               <title>Dokumentas</title>
               <contentType>application/octet-stream</contentType>
               <content>BASE64_ADOC</content>
            </adocFile>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Dokumentas iš ADOC</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>note</key>
                  <value>Papildoma informacija</value>
               </entry>
            </extraAttributes>
         </documentFromAdocParam>
      </doc:createDocumentFromAdoc>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
DocumentFromAdocParam param = new DocumentFromAdocParam();
TemplateParam templateParam = new TemplateParam();
templateParam.setOid("TEMPLATE_OID_001");
param.setTemplateParam(templateParam);
param.setRegister(true);

ADocAttachment adoc = new ADocAttachment();
adoc.setAction(AttachmentAction.ADD);
adoc.setTitle("Dokumentas");
adoc.setContentType("application/octet-stream");
adoc.setContent("BASE64_ADOC".getBytes());
param.setAdocFile(adoc);

Map<String, Object> docAttributes = new HashMap<>();
docAttributes.put("title", "Dokumentas iš ADOC");
param.setDocAttributes(docAttributes);

Map<String, Object> extraAttributes = new HashMap<>();
extraAttributes.put("note", "Papildoma informacija");
param.setExtraAttributes(extraAttributes);

DocumentInfo result = port.createDocumentFromAdoc(param);
System.out.println(result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:doc=\"http://www.sintagma.lt/avilys/DocumentWS\">
   <soapenv:Body>
      <doc:createDocumentFromAdoc>
         <documentFromAdocParam>
            <templateParam>
               <oid>TEMPLATE_OID_001</oid>
            </templateParam>
            <register>true</register>
            <adocFile>
               <action>add</action>
               <title>Dokumentas</title>
               <contentType>application/octet-stream</contentType>
               <content>BASE64_ADOC</content>
            </adocFile>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Dokumentas iš ADOC</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>note</key>
                  <value>Papildoma informacija</value>
               </entry>
            </extraAttributes>
         </documentFromAdocParam>
      </doc:createDocumentFromAdoc>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/DocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/DocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'documentFromAdocParam' => [
        'templateParam' => ['oid' => 'TEMPLATE_OID_001'],
        'register' => true,
        'adocFile' => [
            'action' => 'add',
            'title' => 'Dokumentas',
            'contentType' => 'application/octet-stream',
            'content' => 'BASE64_ADOC'
        ],
        'docAttributes' => [
            'entry' => [
                ['key' => 'title', 'value' => 'Dokumentas iš ADOC']
            ]
        ],
        'extraAttributes' => [
            'entry' => [
                ['key' => 'note', 'value' => 'Papildoma informacija']
            ]
        ]
    ]
];

$result = $client->createDocumentFromAdoc($param);
echo $result->documentInfo->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/DocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/DocumentWS/createDocumentFromAdoc"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:doc="http://www.sintagma.lt/avilys/DocumentWS">
   <soapenv:Body>
      <doc:createDocumentFromAdoc>
         <documentFromAdocParam>
            <templateParam>
               <oid>TEMPLATE_OID_001</oid>
            </templateParam>
            <register>true</register>
            <adocFile>
               <action>add</action>
               <title>Dokumentas</title>
               <contentType>application/octet-stream</contentType>
               <content>BASE64_ADOC</content>
            </adocFile>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Dokumentas iš ADOC</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>note</key>
                  <value>Papildoma informacija</value>
               </entry>
            </extraAttributes>
         </documentFromAdocParam>
      </doc:createDocumentFromAdoc>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija
