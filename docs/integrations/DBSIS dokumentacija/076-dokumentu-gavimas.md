# Dokumentų gavimas

- Path: `/api-dok/dbsis-api/api-taikymas/rdodocumentws/dokumentu-gavimas`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/rdodocumentws/dokumentu-gavimas
- Index: 76

---

RDODocumentWS dokumentų gavimo operacijos

### getDocument

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_38-getdocument)

Gauna dokumento informaciją pagal OID.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:getDocument>
         <getDocumentParam>
            <docOid>DOC_12345</docOid>
            <expand>ATTACHMENTS</expand>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
            <retrieveElectroContainer>METADATA</retrieveElectroContainer>
            <retrieveProcessTasks>false</retrieveProcessTasks>
         </getDocumentParam>
      </rdo:getDocument>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetDocumentParam param = new GetDocumentParam();
param.setDocOid("DOC_12345");
param.setExpand(DocumentExpandType.ATTACHMENTS);
param.setRetrieveBodyAttachment(ReturnBodyAttachmentEnumType.METADATA);
param.setRetrieveElectroContainer(ReturnBodyAttachmentEnumType.METADATA);
param.setRetrieveProcessTasks(false);

GetDocumentResult result = port.getDocument(param);
System.out.println("OID: " + result.getDocOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:getDocument>
         <getDocumentParam>
            <docOid>DOC_12345</docOid>
            <expand>ATTACHMENTS</expand>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
            <retrieveElectroContainer>METADATA</retrieveElectroContainer>
            <retrieveProcessTasks>false</retrieveProcessTasks>
         </getDocumentParam>
      </rdo:getDocument>
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
    'getDocumentParam' => [
        'docOid' => 'DOC_12345',
        'expand' => 'ATTACHMENTS',
        'retrieveBodyAttachment' => 'METADATA',
        'retrieveElectroContainer' => 'METADATA',
        'retrieveProcessTasks' => false
    ]
];

$result = $client->getDocument($param);
echo "OID: " . $result->document->docOid;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: ""' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:getDocument>
         <getDocumentParam>
            <docOid>DOC_12345</docOid>
            <expand>ATTACHMENTS</expand>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
            <retrieveElectroContainer>METADATA</retrieveElectroContainer>
            <retrieveProcessTasks>false</retrieveProcessTasks>
         </getDocumentParam>
      </rdo:getDocument>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getDocumentList

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_41-getdocumentlist)

Gauna dokumentų sąrašą pagal paieškos kriterijus.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:getDocumentList>
         <getDocumentListParam>
            <searchParameters>
               <entry>
                  <key>registrationDateFrom</key>
                  <value>2024-01-01</value>
               </entry>
               <entry>
                  <key>registrationDateTo</key>
                  <value>2024-12-31</value>
               </entry>
            </searchParameters>
            <expand>ATTACHMENTS</expand>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
            <pageSize>50</pageSize>
            <pageNum>0</pageNum>
            <sortParam>registrationDateDesc</sortParam>
            <maxResults>200</maxResults>
         </getDocumentListParam>
      </rdo:getDocumentList>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetDocumentListParam param = new GetDocumentListParam();

Map<String, Object> searchParameters = new HashMap<>();
searchParameters.put("registrationDateFrom", "2024-01-01");
searchParameters.put("registrationDateTo", "2024-12-31");
param.setSearchParameters(searchParameters);

param.setExpand(DocumentExpandType.ATTACHMENTS);
param.setRetrieveBodyAttachment(ReturnBodyAttachmentEnumType.METADATA);
param.setPageSize(50);
param.setPageNum(0);
param.setSortParam("registrationDateDesc");
param.setMaxResults(200);

GetDocumentListResult result = port.getDocumentList(param);
System.out.println("Rasta dokumentų: " + result.getTotalDocumentsFound());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:getDocumentList>
         <getDocumentListParam>
            <searchParameters>
               <entry>
                  <key>registrationDateFrom</key>
                  <value>2024-01-01</value>
               </entry>
               <entry>
                  <key>registrationDateTo</key>
                  <value>2024-12-31</value>
               </entry>
            </searchParameters>
            <expand>ATTACHMENTS</expand>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
            <pageSize>50</pageSize>
            <pageNum>0</pageNum>
            <sortParam>registrationDateDesc</sortParam>
            <maxResults>200</maxResults>
         </getDocumentListParam>
      </rdo:getDocumentList>
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
    'getDocumentListParam' => [
        'searchParameters' => [
            'entry' => [
                ['key' => 'registrationDateFrom', 'value' => '2024-01-01'],
                ['key' => 'registrationDateTo', 'value' => '2024-12-31']
            ]
        ],
        'expand' => 'ATTACHMENTS',
        'retrieveBodyAttachment' => 'METADATA',
        'pageSize' => 50,
        'pageNum' => 0,
        'sortParam' => 'registrationDateDesc',
        'maxResults' => 200
    ]
];

$result = $client->getDocumentList($param);
echo "Rasta dokumentų: " . $result->documentList->totalDocumentsFound;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: ""' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:getDocumentList>
         <getDocumentListParam>
            <searchParameters>
               <entry>
                  <key>registrationDateFrom</key>
                  <value>2024-01-01</value>
               </entry>
               <entry>
                  <key>registrationDateTo</key>
                  <value>2024-12-31</value>
               </entry>
            </searchParameters>
            <expand>ATTACHMENTS</expand>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
            <pageSize>50</pageSize>
            <pageNum>0</pageNum>
            <sortParam>registrationDateDesc</sortParam>
            <maxResults>200</maxResults>
         </getDocumentListParam>
      </rdo:getDocumentList>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getDocumentReaders

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_2226-operacija-getdocumentreaders)

Gauna dokumento skaitytojų sąrašą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:getDocumentReaders>
         <getDocumentReadersParam>
            <docOid>DOC_12345</docOid>
         </getDocumentReadersParam>
      </rdo:getDocumentReaders>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetDocumentReadersParam param = new GetDocumentReadersParam();
param.setDocOid("DOC_12345");

GetDocumentReadersResult result = port.getDocumentReaders(param);
System.out.println("Skaitytojų: " + result.getReader().size());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:getDocumentReaders>
         <getDocumentReadersParam>
            <docOid>DOC_12345</docOid>
         </getDocumentReadersParam>
      </rdo:getDocumentReaders>
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
    'getDocumentReadersParam' => [
        'docOid' => 'DOC_12345'
    ]
];

$result = $client->getDocumentReaders($param);
echo "Skaitytojų: " . count($result->documentReaders->reader);
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: ""' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:getDocumentReaders>
         <getDocumentReadersParam>
            <docOid>DOC_12345</docOid>
         </getDocumentReadersParam>
      </rdo:getDocumentReaders>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getLinkedTasksInfo

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_2227-operacija-getlinkedtasksinfo)

Gauna su dokumentu susietų užduočių informaciją.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:getLinkedTasksInfo>
         <getLinkedTasksInfoParam>
            <docOid>DOC_12345</docOid>
         </getLinkedTasksInfoParam>
      </rdo:getLinkedTasksInfo>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetLinkedTasksInfoParam param = new GetLinkedTasksInfoParam();
param.setDocOid("DOC_12345");

GetLinkedTasksInfoResult result = port.getLinkedTasksInfo(param);
System.out.println("Užduočių: " + result.getTaskInfo().size());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:getLinkedTasksInfo>
         <getLinkedTasksInfoParam>
            <docOid>DOC_12345</docOid>
         </getLinkedTasksInfoParam>
      </rdo:getLinkedTasksInfo>
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
    'getLinkedTasksInfoParam' => [
        'docOid' => 'DOC_12345'
    ]
];

$result = $client->getLinkedTasksInfo($param);
echo "Užduočių: " . count($result->taskInfo);
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: ""' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:getLinkedTasksInfo>
         <getLinkedTasksInfoParam>
            <docOid>DOC_12345</docOid>
         </getLinkedTasksInfoParam>
      </rdo:getLinkedTasksInfo>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---
