# Integracija

- Path: `/api-dok/dbsis-api/api-taikymas/tdodocumentws/integracija`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/tdodocumentws/integracija
- Index: 93

---

TDODocumentWS integracijos operacijos

### createDocumentFromTemplate

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/uzduociu-sasaja#_292-operacija-createdocumentfromtemplate)

Sukuria užduotį pagal šabloną.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:tdo="http://www.sintagma.lt/avilys/TDODocumentWS">
   <soapenv:Body>
      <tdo:createDocumentFromTemplate>
         <tdoDocumentFromTemplateParam>
            <templateParam>
               <templateNo>TDO_001</templateNo>
            </templateParam>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Užduotis dėl peržiūros</value>
               </entry>
               <entry>
                  <key>chiefExecutor</key>
                  <value>STAFF_001</value>
               </entry>
               <entry>
                  <key>dueBy</key>
                  <value>2024-04-15</value>
               </entry>
            </docAttributes>
         </tdoDocumentFromTemplateParam>
      </tdo:createDocumentFromTemplate>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
TDODocumentFromTemplateParam param = new TDODocumentFromTemplateParam();

TemplateParam template = new TemplateParam();
template.setTemplateNo("TDO_001");
param.setTemplateParam(template);

Map<String, Object> attributes = param.getDocAttributes();
attributes.put("title", "Užduotis dėl peržiūros");
attributes.put("chiefExecutor", "STAFF_001");
attributes.put("dueBy", "2024-04-15");

TDODocumentInfo result = port.createDocumentFromTemplate(param);
System.out.println(result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:tdo=\"http://www.sintagma.lt/avilys/TDODocumentWS\">
   <soapenv:Body>
      <tdo:createDocumentFromTemplate>
         <tdoDocumentFromTemplateParam>
            <templateParam>
               <templateNo>TDO_001</templateNo>
            </templateParam>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Užduotis dėl peržiūros</value>
               </entry>
               <entry>
                  <key>chiefExecutor</key>
                  <value>STAFF_001</value>
               </entry>
               <entry>
                  <key>dueBy</key>
                  <value>2024-04-15</value>
               </entry>
            </docAttributes>
         </tdoDocumentFromTemplateParam>
      </tdo:createDocumentFromTemplate>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/TDODocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/TDODocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'tdoDocumentFromTemplateParam' => [
        'templateParam' => [
            'templateNo' => 'TDO_001'
        ],
        'docAttributes' => [
            'entry' => [
                ['key' => 'title', 'value' => 'Užduotis dėl peržiūros'],
                ['key' => 'chiefExecutor', 'value' => 'STAFF_001'],
                ['key' => 'dueBy', 'value' => '2024-04-15']
            ]
        ]
    ]
];

$result = $client->createDocumentFromTemplate($param);
echo $result->documentInfo->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/TDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/TDODocumentWS/createDocumentFromTemplate"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:tdo="http://www.sintagma.lt/avilys/TDODocumentWS">
   <soapenv:Body>
      <tdo:createDocumentFromTemplate>
         <tdoDocumentFromTemplateParam>
            <templateParam>
               <templateNo>TDO_001</templateNo>
            </templateParam>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Užduotis dėl peržiūros</value>
               </entry>
               <entry>
                  <key>chiefExecutor</key>
                  <value>STAFF_001</value>
               </entry>
               <entry>
                  <key>dueBy</key>
                  <value>2024-04-15</value>
               </entry>
            </docAttributes>
         </tdoDocumentFromTemplateParam>
      </tdo:createDocumentFromTemplate>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getDocument

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/uzduociu-sasaja#_293-operacija-getdocument)

Grąžina užduoties informaciją pagal OID.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:tdo="http://www.sintagma.lt/avilys/TDODocumentWS">
   <soapenv:Body>
      <tdo:getDocument>
         <getTdoDocumentParam>
            <docOid>TDO-2024-0001</docOid>
            <retrieveResultAttachments>METADATA</retrieveResultAttachments>
         </getTdoDocumentParam>
      </tdo:getDocument>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetTDODocumentParam param = new GetTDODocumentParam();
param.setDocOid("TDO-2024-0001");
param.setRetrieveResultAttachments(ReturnBodyAttachmentEnumType.METADATA);

GetTDODocumentResult result = port.getDocument(param);
System.out.println(result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:tdo=\"http://www.sintagma.lt/avilys/TDODocumentWS\">
   <soapenv:Body>
      <tdo:getDocument>
         <getTdoDocumentParam>
            <docOid>TDO-2024-0001</docOid>
            <retrieveResultAttachments>METADATA</retrieveResultAttachments>
         </getTdoDocumentParam>
      </tdo:getDocument>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/TDODocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/TDODocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'getTdoDocumentParam' => [
        'docOid' => 'TDO-2024-0001',
        'retrieveResultAttachments' => 'METADATA'
    ]
];

$result = $client->getDocument($param);
echo $result->document->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/TDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/TDODocumentWS/getDocument"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:tdo="http://www.sintagma.lt/avilys/TDODocumentWS">
   <soapenv:Body>
      <tdo:getDocument>
         <getTdoDocumentParam>
            <docOid>TDO-2024-0001</docOid>
            <retrieveResultAttachments>METADATA</retrieveResultAttachments>
         </getTdoDocumentParam>
      </tdo:getDocument>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getLinkedResults

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/uzduociu-sasaja#_294-operacija-getlinkedresults)

Grąžina susietų rezultatų dokumentus.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:tdo="http://www.sintagma.lt/avilys/TDODocumentWS">
   <soapenv:Body>
      <tdo:getLinkedResults>
         <getLinkedResultsParam>
            <docOid>TDO-2024-0001</docOid>
         </getLinkedResultsParam>
      </tdo:getLinkedResults>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetLinkedResultsParam param = new GetLinkedResultsParam();
param.setDocOid("TDO-2024-0001");

GetLinkedDocumentsResult result = port.getLinkedResults(param);
System.out.println(result.getLinkedDocument().size());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:tdo=\"http://www.sintagma.lt/avilys/TDODocumentWS\">
   <soapenv:Body>
      <tdo:getLinkedResults>
         <getLinkedResultsParam>
            <docOid>TDO-2024-0001</docOid>
         </getLinkedResultsParam>
      </tdo:getLinkedResults>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/TDODocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/TDODocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'getLinkedResultsParam' => [
        'docOid' => 'TDO-2024-0001'
    ]
];

$result = $client->getLinkedResults($param);
foreach ($result->linkedDocuments->linkedDocument ?? [] as $linked) {
    echo $linked->targetDoc->documentInfo->oid . PHP_EOL;
}
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/TDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/TDODocumentWS/getLinkedResults"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:tdo="http://www.sintagma.lt/avilys/TDODocumentWS">
   <soapenv:Body>
      <tdo:getLinkedResults>
         <getLinkedResultsParam>
            <docOid>TDO-2024-0001</docOid>
         </getLinkedResultsParam>
      </tdo:getLinkedResults>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### modifyDocument

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/uzduociu-sasaja#_295-operacija-modifydocument)

Redaguoja užduoties duomenis.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:tdo="http://www.sintagma.lt/avilys/TDODocumentWS">
   <soapenv:Body>
      <tdo:modifyDocument>
         <modifyTdoDocumentParam>
            <docOid>TDO-2024-0001</docOid>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Atnaujinta užduotis</value>
               </entry>
               <entry>
                  <key>priority</key>
                  <value>HIGH</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>estimate</key>
                  <value>5</value>
               </entry>
            </extraAttributes>
         </modifyTdoDocumentParam>
      </tdo:modifyDocument>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
ModifyTDODocumentParam param = new ModifyTDODocumentParam();
param.setDocOid("TDO-2024-0001");

Map<String, Object> docAttributes = param.getDocAttributes();
docAttributes.put("title", "Atnaujinta užduotis");
docAttributes.put("priority", "HIGH");

Map<String, Object> extraAttributes = param.getExtraAttributes();
extraAttributes.put("estimate", 5);

TDODocumentInfo result = port.modifyDocument(param);
System.out.println(result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:tdo=\"http://www.sintagma.lt/avilys/TDODocumentWS\">
   <soapenv:Body>
      <tdo:modifyDocument>
         <modifyTdoDocumentParam>
            <docOid>TDO-2024-0001</docOid>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Atnaujinta užduotis</value>
               </entry>
               <entry>
                  <key>priority</key>
                  <value>HIGH</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>estimate</key>
                  <value>5</value>
               </entry>
            </extraAttributes>
         </modifyTdoDocumentParam>
      </tdo:modifyDocument>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/TDODocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/TDODocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'modifyTdoDocumentParam' => [
        'docOid' => 'TDO-2024-0001',
        'docAttributes' => [
            'entry' => [
                ['key' => 'title', 'value' => 'Atnaujinta užduotis'],
                ['key' => 'priority', 'value' => 'HIGH']
            ]
        ],
        'extraAttributes' => [
            'entry' => [
                ['key' => 'estimate', 'value' => '5']
            ]
        ]
    ]
];

$result = $client->modifyDocument($param);
echo $result->documentInfo->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/TDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/TDODocumentWS/modifyDocument"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:tdo="http://www.sintagma.lt/avilys/TDODocumentWS">
   <soapenv:Body>
      <tdo:modifyDocument>
         <modifyTdoDocumentParam>
            <docOid>TDO-2024-0001</docOid>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Atnaujinta užduotis</value>
               </entry>
               <entry>
                  <key>priority</key>
                  <value>HIGH</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>estimate</key>
                  <value>5</value>
               </entry>
            </extraAttributes>
         </modifyTdoDocumentParam>
      </tdo:modifyDocument>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### claimCompletion

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/uzduociu-sasaja#_296-operacija-claimcompletion)

Pažymi užduotį kaip užbaigtą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:tdo="http://www.sintagma.lt/avilys/TDODocumentWS">
   <soapenv:Body>
      <tdo:claimCompletion>
         <claimCompletionParam>
            <docOid>TDO-2024-0001</docOid>
            <completionDate>2024-04-10T12:00:00</completionDate>
         </claimCompletionParam>
      </tdo:claimCompletion>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
ClaimCompletionWParam param = new ClaimCompletionWParam();
param.setDocOid("TDO-2024-0001");
param.setCompletionDate(javax.xml.datatype.DatatypeFactory.newInstance()
    .newXMLGregorianCalendar("2024-04-10T12:00:00"));

TDODocumentInfo result = port.claimCompletion(param);
System.out.println(result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:tdo=\"http://www.sintagma.lt/avilys/TDODocumentWS\">
   <soapenv:Body>
      <tdo:claimCompletion>
         <claimCompletionParam>
            <docOid>TDO-2024-0001</docOid>
            <completionDate>2024-04-10T12:00:00</completionDate>
         </claimCompletionParam>
      </tdo:claimCompletion>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/TDODocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/TDODocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'claimCompletionParam' => [
        'docOid' => 'TDO-2024-0001',
        'completionDate' => '2024-04-10T12:00:00'
    ]
];

$result = $client->claimCompletion($param);
echo $result->documentInfo->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/TDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/TDODocumentWS/claimCompletion"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:tdo="http://www.sintagma.lt/avilys/TDODocumentWS">
   <soapenv:Body>
      <tdo:claimCompletion>
         <claimCompletionParam>
            <docOid>TDO-2024-0001</docOid>
            <completionDate>2024-04-10T12:00:00</completionDate>
         </claimCompletionParam>
      </tdo:claimCompletion>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### writeResults

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/uzduociu-sasaja#_297-operacija-writeresults)

Įrašo užduoties rezultatus.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:tdo="http://www.sintagma.lt/avilys/TDODocumentWS">
   <soapenv:Body>
      <tdo:writeResults>
         <writeResutsParam>
            <docOid>TDO-2024-0001</docOid>
            <resultText>Rezultatas parengtas</resultText>
         </writeResutsParam>
      </tdo:writeResults>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
WriteResultsParam param = new WriteResultsParam();
param.setDocOid("TDO-2024-0001");
param.setResultText("Rezultatas parengtas");

TDODocumentInfo result = port.writeResults(param);
System.out.println(result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:tdo=\"http://www.sintagma.lt/avilys/TDODocumentWS\">
   <soapenv:Body>
      <tdo:writeResults>
         <writeResutsParam>
            <docOid>TDO-2024-0001</docOid>
            <resultText>Rezultatas parengtas</resultText>
         </writeResutsParam>
      </tdo:writeResults>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/TDODocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/TDODocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'writeResutsParam' => [
        'docOid' => 'TDO-2024-0001',
        'resultText' => 'Rezultatas parengtas'
    ]
];

$result = $client->writeResults($param);
echo $result->documentInfo->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/TDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/TDODocumentWS/writeResults"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:tdo="http://www.sintagma.lt/avilys/TDODocumentWS">
   <soapenv:Body>
      <tdo:writeResults>
         <writeResutsParam>
            <docOid>TDO-2024-0001</docOid>
            <resultText>Rezultatas parengtas</resultText>
         </writeResutsParam>
      </tdo:writeResults>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija
