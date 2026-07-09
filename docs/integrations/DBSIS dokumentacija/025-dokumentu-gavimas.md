# Dokumentų gavimas

- Path: `/api-dok/dbsis-api/api-taikymas/cdodocumentws/dokumentu-gavimas`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/cdodocumentws/dokumentu-gavimas
- Index: 25

---

CDODocumentWS dokumentų gavimo operacijos

### getDocumentList

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/sutarciu-sasaja#_2142-operacija-getdocumentlist)

Gauna dokumentų sąrašą pagal paieškos kriterijus.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cdo="http://www.sintagma.lt/avilys/CDODocumentWS">
   <soapenv:Body>
      <cdo:getDocumentList>
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
      </cdo:getDocumentList>
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
                  xmlns:cdo=""http://www.sintagma.lt/avilys/CDODocumentWS"">
   <soapenv:Body>
      <cdo:getDocumentList>
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
      </cdo:getDocumentList>
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
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/CDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: ""' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cdo="http://www.sintagma.lt/avilys/CDODocumentWS">
   <soapenv:Body>
      <cdo:getDocumentList>
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
      </cdo:getDocumentList>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getDocumentReaders

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/sutarciu-sasaja#_21413-operacija-getdocumentreaders)

Gauna dokumento skaitytojų sąrašą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cdo="http://www.sintagma.lt/avilys/CDODocumentWS">
   <soapenv:Body>
      <cdo:getDocumentReaders>
         <getDocumentReadersParam>
            <docOid>DOC_12345</docOid>
         </getDocumentReadersParam>
      </cdo:getDocumentReaders>
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
                  xmlns:cdo=""http://www.sintagma.lt/avilys/CDODocumentWS"">
   <soapenv:Body>
      <cdo:getDocumentReaders>
         <getDocumentReadersParam>
            <docOid>DOC_12345</docOid>
         </getDocumentReadersParam>
      </cdo:getDocumentReaders>
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
    'getDocumentReadersParam' => [
        'docOid' => 'DOC_12345'
    ]
];

$result = $client->getDocumentReaders($param);
echo "Skaitytojų: " . count($result->documentReaders->reader);
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/CDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: ""' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cdo="http://www.sintagma.lt/avilys/CDODocumentWS">
   <soapenv:Body>
      <cdo:getDocumentReaders>
         <getDocumentReadersParam>
            <docOid>DOC_12345</docOid>
         </getDocumentReadersParam>
      </cdo:getDocumentReaders>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getContentCopyAttachmentOrEmpty

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/sutarciu-sasaja#_21411-operacija-getcontentcopyattachmentorempty)

Gauna dokumento turinio kopiją arba tuščią rezultatą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cdo="http://www.sintagma.lt/avilys/CDODocumentWS">
   <soapenv:Body>
      <cdo:getContentCopyAttachmentOrEmpty>
         <getContentCopyAttachmentOrEmptyParam>
            <docOid>DOC_12345</docOid>
            <retrieveContentCopyAttachment>CONTENT</retrieveContentCopyAttachment>
         </getContentCopyAttachmentOrEmptyParam>
      </cdo:getContentCopyAttachmentOrEmpty>
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
                  xmlns:cdo=""http://www.sintagma.lt/avilys/CDODocumentWS"">
   <soapenv:Body>
      <cdo:getContentCopyAttachmentOrEmpty>
         <getContentCopyAttachmentOrEmptyParam>
            <docOid>DOC_12345</docOid>
            <retrieveContentCopyAttachment>CONTENT</retrieveContentCopyAttachment>
         </getContentCopyAttachmentOrEmptyParam>
      </cdo:getContentCopyAttachmentOrEmpty>
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
    'getContentCopyAttachmentOrEmptyParam' => [
        'docOid' => 'DOC_12345',
        'retrieveContentCopyAttachment' => 'CONTENT'
    ]
];

$result = $client->getContentCopyAttachmentOrEmpty($param);
echo "Kopijos OID: " . $result->contentCopyAttachment->oid;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/CDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: ""' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cdo="http://www.sintagma.lt/avilys/CDODocumentWS">
   <soapenv:Body>
      <cdo:getContentCopyAttachmentOrEmpty>
         <getContentCopyAttachmentOrEmptyParam>
            <docOid>DOC_12345</docOid>
            <retrieveContentCopyAttachment>CONTENT</retrieveContentCopyAttachment>
         </getContentCopyAttachmentOrEmptyParam>
      </cdo:getContentCopyAttachmentOrEmpty>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---
