# Integracija

- Path: `/api-dok/dbsis-api/api-taikymas/substdocumentws/integracija`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/substdocumentws/integracija
- Index: 89

---

SubstDocumentWS integracijos operacijos

### createDocumentFromTemplate

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/pavadavimu-sasaja#_2152-operacija-createdocumentfromtemplate)

Sukuria pavadavimą pagal šabloną.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:sub="http://www.sintagma.lt/avilys/SubstDocumentWS">
   <soapenv:Body>
      <sub:createDocumentFromTemplate>
         <substDocumentFromTemplateParam>
            <templateParam>
               <templateNo>SUBST_001</templateNo>
            </templateParam>
            <docAttributes>
               <entry>
                  <key>realStaff</key>
                  <value>STAFF_001</value>
               </entry>
               <entry>
                  <key>substituteStaff</key>
                  <value>STAFF_002</value>
               </entry>
               <entry>
                  <key>startDate</key>
                  <value>2024-03-01T08:00:00</value>
               </entry>
               <entry>
                  <key>endDate</key>
                  <value>2024-03-15T17:00:00</value>
               </entry>
               <entry>
                  <key>substituteReason</key>
                  <value>Atostogos</value>
               </entry>
            </docAttributes>
            <linkedDoc>DOC-2024-00001234</linkedDoc>
         </substDocumentFromTemplateParam>
      </sub:createDocumentFromTemplate>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
SubstDocumentFromTemplateParam param = new SubstDocumentFromTemplateParam();

TemplateParam template = new TemplateParam();
template.setTemplateNo("SUBST_001");
param.setTemplateParam(template);

Map<String, Object> attributes = param.getDocAttributes();
attributes.put("realStaff", "STAFF_001");
attributes.put("substituteStaff", "STAFF_002");
attributes.put("startDate", "2024-03-01T08:00:00");
attributes.put("endDate", "2024-03-15T17:00:00");
attributes.put("substituteReason", "Atostogos");

param.setLinkedDoc("DOC-2024-00001234");

SubstDocumentInfo result = port.createDocumentFromTemplate(param);
System.out.println(result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:sub=\"http://www.sintagma.lt/avilys/SubstDocumentWS\">
   <soapenv:Body>
      <sub:createDocumentFromTemplate>
         <substDocumentFromTemplateParam>
            <templateParam>
               <templateNo>SUBST_001</templateNo>
            </templateParam>
            <docAttributes>
               <entry>
                  <key>realStaff</key>
                  <value>STAFF_001</value>
               </entry>
               <entry>
                  <key>substituteStaff</key>
                  <value>STAFF_002</value>
               </entry>
               <entry>
                  <key>startDate</key>
                  <value>2024-03-01T08:00:00</value>
               </entry>
               <entry>
                  <key>endDate</key>
                  <value>2024-03-15T17:00:00</value>
               </entry>
               <entry>
                  <key>substituteReason</key>
                  <value>Atostogos</value>
               </entry>
            </docAttributes>
            <linkedDoc>DOC-2024-00001234</linkedDoc>
         </substDocumentFromTemplateParam>
      </sub:createDocumentFromTemplate>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/SubstDocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/SubstDocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'substDocumentFromTemplateParam' => [
        'templateParam' => [
            'templateNo' => 'SUBST_001'
        ],
        'docAttributes' => [
            'entry' => [
                ['key' => 'realStaff', 'value' => 'STAFF_001'],
                ['key' => 'substituteStaff', 'value' => 'STAFF_002'],
                ['key' => 'startDate', 'value' => '2024-03-01T08:00:00'],
                ['key' => 'endDate', 'value' => '2024-03-15T17:00:00'],
                ['key' => 'substituteReason', 'value' => 'Atostogos']
            ]
        ],
        'linkedDoc' => 'DOC-2024-00001234'
    ]
];

$result = $client->createDocumentFromTemplate($param);
echo $result->documentInfo->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/SubstDocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/SubstDocumentWS/createDocumentFromTemplate"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:sub="http://www.sintagma.lt/avilys/SubstDocumentWS">
   <soapenv:Body>
      <sub:createDocumentFromTemplate>
         <substDocumentFromTemplateParam>
            <templateParam>
               <templateNo>SUBST_001</templateNo>
            </templateParam>
            <docAttributes>
               <entry>
                  <key>realStaff</key>
                  <value>STAFF_001</value>
               </entry>
               <entry>
                  <key>substituteStaff</key>
                  <value>STAFF_002</value>
               </entry>
               <entry>
                  <key>startDate</key>
                  <value>2024-03-01T08:00:00</value>
               </entry>
               <entry>
                  <key>endDate</key>
                  <value>2024-03-15T17:00:00</value>
               </entry>
               <entry>
                  <key>substituteReason</key>
                  <value>Atostogos</value>
               </entry>
            </docAttributes>
            <linkedDoc>DOC-2024-00001234</linkedDoc>
         </substDocumentFromTemplateParam>
      </sub:createDocumentFromTemplate>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### modifyDocument

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/pavadavimu-sasaja#_2153-operacija-modifydocument)

Atnaujina pavadavimo duomenis.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:sub="http://www.sintagma.lt/avilys/SubstDocumentWS">
   <soapenv:Body>
      <sub:modifyDocument>
         <modifySubstDocumentParam>
            <docOid>SUBST-2024-0001</docOid>
            <docAttributes>
               <entry>
                  <key>endDate</key>
                  <value>2024-03-20T17:00:00</value>
               </entry>
               <entry>
                  <key>substituteReason</key>
                  <value>Komandiruotė</value>
               </entry>
            </docAttributes>
            <linkedDoc>DOC-2024-00001234</linkedDoc>
         </modifySubstDocumentParam>
      </sub:modifyDocument>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
ModifySubstDocumentParam param = new ModifySubstDocumentParam();
param.setDocOid("SUBST-2024-0001");

Map<String, Object> attributes = param.getDocAttributes();
attributes.put("endDate", "2024-03-20T17:00:00");
attributes.put("substituteReason", "Komandiruotė");

param.setLinkedDoc("DOC-2024-00001234");

SubstDocumentInfo result = port.modifyDocument(param);
System.out.println(result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:sub=\"http://www.sintagma.lt/avilys/SubstDocumentWS\">
   <soapenv:Body>
      <sub:modifyDocument>
         <modifySubstDocumentParam>
            <docOid>SUBST-2024-0001</docOid>
            <docAttributes>
               <entry>
                  <key>endDate</key>
                  <value>2024-03-20T17:00:00</value>
               </entry>
               <entry>
                  <key>substituteReason</key>
                  <value>Komandiruotė</value>
               </entry>
            </docAttributes>
            <linkedDoc>DOC-2024-00001234</linkedDoc>
         </modifySubstDocumentParam>
      </sub:modifyDocument>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/SubstDocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/SubstDocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'modifySubstDocumentParam' => [
        'docOid' => 'SUBST-2024-0001',
        'docAttributes' => [
            'entry' => [
                ['key' => 'endDate', 'value' => '2024-03-20T17:00:00'],
                ['key' => 'substituteReason', 'value' => 'Komandiruotė']
            ]
        ],
        'linkedDoc' => 'DOC-2024-00001234'
    ]
];

$result = $client->modifyDocument($param);
echo $result->documentInfo->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/SubstDocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/SubstDocumentWS/modifyDocument"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:sub="http://www.sintagma.lt/avilys/SubstDocumentWS">
   <soapenv:Body>
      <sub:modifyDocument>
         <modifySubstDocumentParam>
            <docOid>SUBST-2024-0001</docOid>
            <docAttributes>
               <entry>
                  <key>endDate</key>
                  <value>2024-03-20T17:00:00</value>
               </entry>
               <entry>
                  <key>substituteReason</key>
                  <value>Komandiruotė</value>
               </entry>
            </docAttributes>
            <linkedDoc>DOC-2024-00001234</linkedDoc>
         </modifySubstDocumentParam>
      </sub:modifyDocument>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getDocumentList

Grąžina pavadavimų sąrašą pagal paieškos parametrus.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:sub="http://www.sintagma.lt/avilys/SubstDocumentWS">
   <soapenv:Body>
      <sub:getDocumentList>
         <getDocumentListParam>
            <searchParameters>
               <entry>
                  <key>docNo</key>
                  <value>SUB-001</value>
               </entry>
            </searchParameters>
            <pageSize>10</pageSize>
            <pageNum>1</pageNum>
         </getDocumentListParam>
      </sub:getDocumentList>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetDocumentListParam param = new GetDocumentListParam();
List<SearchParamEntry> entries = param.getSearchParameters().getEntry();
SearchParamEntry entry = new SearchParamEntry();
entry.setKey("docNo");
entry.setValue("SUB-001");
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
                  xmlns:sub=\"http://www.sintagma.lt/avilys/SubstDocumentWS\">
   <soapenv:Body>
      <sub:getDocumentList>
         <getDocumentListParam>
            <searchParameters>
               <entry>
                  <key>docNo</key>
                  <value>SUB-001</value>
               </entry>
            </searchParameters>
            <pageSize>10</pageSize>
            <pageNum>1</pageNum>
         </getDocumentListParam>
      </sub:getDocumentList>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/SubstDocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/SubstDocumentWS?wsdl';
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
                ['key' => 'docNo', 'value' => 'SUB-001']
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
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/SubstDocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/SubstDocumentWS/getDocumentList"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:sub="http://www.sintagma.lt/avilys/SubstDocumentWS">
   <soapenv:Body>
      <sub:getDocumentList>
         <getDocumentListParam>
            <searchParameters>
               <entry>
                  <key>docNo</key>
                  <value>SUB-001</value>
               </entry>
            </searchParameters>
            <pageSize>10</pageSize>
            <pageNum>1</pageNum>
         </getDocumentListParam>
      </sub:getDocumentList>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getDocument

Grąžina pavadavimo dokumento informaciją pagal OID.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:sub="http://www.sintagma.lt/avilys/SubstDocumentWS">
   <soapenv:Body>
      <sub:getDocument>
         <getDocumentParam>
            <docOid>SUBST-2024-0001</docOid>
         </getDocumentParam>
      </sub:getDocument>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetDocumentParam param = new GetDocumentParam();
param.setDocOid("SUBST-2024-0001");

GetDocumentResult result = port.getDocument(param);
System.out.println(result.getDocument().getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:sub=\"http://www.sintagma.lt/avilys/SubstDocumentWS\">
   <soapenv:Body>
      <sub:getDocument>
         <getDocumentParam>
            <docOid>SUBST-2024-0001</docOid>
         </getDocumentParam>
      </sub:getDocument>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/SubstDocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/SubstDocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'getDocumentParam' => [
        'docOid' => 'SUBST-2024-0001'
    ]
];

$result = $client->getDocument($param);
echo $result->document->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/SubstDocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/SubstDocumentWS/getDocument"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:sub="http://www.sintagma.lt/avilys/SubstDocumentWS">
   <soapenv:Body>
      <sub:getDocument>
         <getDocumentParam>
            <docOid>SUBST-2024-0001</docOid>
         </getDocumentParam>
      </sub:getDocument>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### terminate

Nutraukia pavadavimo galiojimą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:sub="http://www.sintagma.lt/avilys/SubstDocumentWS">
   <soapenv:Body>
      <sub:terminate>
         <terminateParam>
            <docOid>SUBST-2024-0001</docOid>
            <text>Pavadavimas nutrauktas</text>
         </terminateParam>
      </sub:terminate>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
TerminateParam param = new TerminateParam();
param.setDocOid("SUBST-2024-0001");
param.setText("Pavadavimas nutrauktas");

SubstDocumentInfo result = port.terminate(param);
System.out.println(result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:sub=\"http://www.sintagma.lt/avilys/SubstDocumentWS\">
   <soapenv:Body>
      <sub:terminate>
         <terminateParam>
            <docOid>SUBST-2024-0001</docOid>
            <text>Pavadavimas nutrauktas</text>
         </terminateParam>
      </sub:terminate>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/SubstDocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/SubstDocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'terminateParam' => [
        'docOid' => 'SUBST-2024-0001',
        'text' => 'Pavadavimas nutrauktas'
    ]
];

$result = $client->terminate($param);
echo $result->documentInfo->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/SubstDocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/SubstDocumentWS/terminate"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:sub="http://www.sintagma.lt/avilys/SubstDocumentWS">
   <soapenv:Body>
      <sub:terminate>
         <terminateParam>
            <docOid>SUBST-2024-0001</docOid>
            <text>Pavadavimas nutrauktas</text>
         </terminateParam>
      </sub:terminate>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija
