# Integracija

- Path: `/api-dok/dbsis-api/api-taikymas/journalws.v2/integracija`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/journalws.v2/integracija
- Index: 61

---

JournalWS.V2 integracijos operacijos

### getJournalsList

Grąžina žurnalų sąrašą su išplėstais laukais.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:jou="http://www.sintagma.lt/avilys/JournalWS/v2">
   <soapenv:Body>
      <jou:getJournalsList>
         <getJournalsListParam>
            <title>Žurnalas</title>
            <number>JN-2024</number>
            <ownerOrg>
               <orgNode>
                  <orgName>PADALINYS_001</orgName>
               </orgNode>
            </ownerOrg>
            <registerUnits>
               <orgNode>
                  <orgName>PADALINYS_002</orgName>
               </orgNode>
            </registerUnits>
            <accessType>use</accessType>
            <expandAccessPermissions>true</expandAccessPermissions>
         </getJournalsListParam>
      </jou:getJournalsList>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetJournalListParam param = new GetJournalListParam();
param.setTitle("Žurnalas");
param.setNumber("JN-2024");
param.setAccessType(AccessType.USE);
param.setExpandAccessPermissions(true);

OrgNodeParam owner = new OrgNodeParam();
owner.setOrgName("PADALINYS_001");
OrgNodeListParam ownerOrg = new OrgNodeListParam();
ownerOrg.getOrgNode().add(owner);
param.setOwnerOrg(ownerOrg);

ListWBean result = port.getJournalsList(param);
System.out.println(result.getListItem().size());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:jou=\"http://www.sintagma.lt/avilys/JournalWS/v2\">
   <soapenv:Body>
      <jou:getJournalsList>
         <getJournalsListParam>
            <title>Žurnalas</title>
            <number>JN-2024</number>
            <ownerOrg>
               <orgNode>
                  <orgName>PADALINYS_001</orgName>
               </orgNode>
            </ownerOrg>
            <registerUnits>
               <orgNode>
                  <orgName>PADALINYS_002</orgName>
               </orgNode>
            </registerUnits>
            <accessType>use</accessType>
            <expandAccessPermissions>true</expandAccessPermissions>
         </getJournalsListParam>
      </jou:getJournalsList>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/JournalWS/v2",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/JournalWS/v2?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'getJournalsListParam' => [
        'title' => 'Žurnalas',
        'number' => 'JN-2024',
        'ownerOrg' => [
            'orgNode' => [
                ['orgName' => 'PADALINYS_001']
            ]
        ],
        'registerUnits' => [
            'orgNode' => [
                ['orgName' => 'PADALINYS_002']
            ]
        ],
        'accessType' => 'use',
        'expandAccessPermissions' => true
    ]
];

$result = $client->getJournalsList($param);
foreach ($result->journals->listItem ?? [] as $journal) {
    echo $journal->oid . PHP_EOL;
}
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/JournalWS/v2' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/JournalWS/v2/getJournalsList"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:jou="http://www.sintagma.lt/avilys/JournalWS/v2">
   <soapenv:Body>
      <jou:getJournalsList>
         <getJournalsListParam>
            <title>Žurnalas</title>
            <number>JN-2024</number>
            <ownerOrg>
               <orgNode>
                  <orgName>PADALINYS_001</orgName>
               </orgNode>
            </ownerOrg>
            <registerUnits>
               <orgNode>
                  <orgName>PADALINYS_002</orgName>
               </orgNode>
            </registerUnits>
            <accessType>use</accessType>
            <expandAccessPermissions>true</expandAccessPermissions>
         </getJournalsListParam>
      </jou:getJournalsList>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getJournal

Grąžina konkretaus žurnalo informaciją pagal OID.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:jou="http://www.sintagma.lt/avilys/JournalWS/v2">
   <soapenv:Body>
      <jou:getJournal>
         <getJournalParam>
            <oid>JRN-001</oid>
         </getJournalParam>
      </jou:getJournal>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetJournalParam param = new GetJournalParam();
param.setOid("JRN-001");

Journal result = port.getJournal(param);
System.out.println(result.getTitle());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:jou=\"http://www.sintagma.lt/avilys/JournalWS/v2\">
   <soapenv:Body>
      <jou:getJournal>
         <getJournalParam>
            <oid>JRN-001</oid>
         </getJournalParam>
      </jou:getJournal>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/JournalWS/v2",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/JournalWS/v2?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'getJournalParam' => [
        'oid' => 'JRN-001'
    ]
];

$result = $client->getJournal($param);
echo $result->journal->title . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/JournalWS/v2' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/JournalWS/v2/getJournal"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:jou="http://www.sintagma.lt/avilys/JournalWS/v2">
   <soapenv:Body>
      <jou:getJournal>
         <getJournalParam>
            <oid>JRN-001</oid>
         </getJournalParam>
      </jou:getJournal>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija
