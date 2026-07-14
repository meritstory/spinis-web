# Integracija

- Path: `/api-dok/dbsis-api/api-taikymas/journalws/integracija`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/journalws/integracija
- Index: 59

---

JournalWS integracijos operacijos

### getJournalList

Grąžina žurnalų sąrašą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:jou="http://www.sintagma.lt/avilys/JournalWS">
   <soapenv:Body>
      <jou:getJournalList>
         <getJournalListParam>
            <accessType>READ</accessType>
            <targetStaff>
               <orgName>PADALINYS_001</orgName>
            </targetStaff>
         </getJournalListParam>
      </jou:getJournalList>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetJournalListParam param = new GetJournalListParam();
param.setAccessType("READ");

OrgNodeParam targetStaff = new OrgNodeParam();
targetStaff.setOrgName("PADALINYS_001");
param.setTargetStaff(targetStaff);

GetJournalListResult result = port.getJournalList(param);
for (Journal journal : result.getJournal()) {
    System.out.println(journal.getOid());
}
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:jou=\"http://www.sintagma.lt/avilys/JournalWS\">
   <soapenv:Body>
      <jou:getJournalList>
         <getJournalListParam>
            <accessType>READ</accessType>
            <targetStaff>
               <orgName>PADALINYS_001</orgName>
            </targetStaff>
         </getJournalListParam>
      </jou:getJournalList>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/JournalWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/JournalWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'getJournalListParam' => [
        'accessType' => 'READ',
        'targetStaff' => [
            'orgName' => 'PADALINYS_001'
        ]
    ]
];

$result = $client->getJournalList($param);
foreach ($result->journalList->journal ?? [] as $journal) {
    echo $journal->oid . PHP_EOL;
}
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/JournalWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/JournalWS/getJournalList"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:jou="http://www.sintagma.lt/avilys/JournalWS">
   <soapenv:Body>
      <jou:getJournalList>
         <getJournalListParam>
            <accessType>READ</accessType>
            <targetStaff>
               <orgName>PADALINYS_001</orgName>
            </targetStaff>
         </getJournalListParam>
      </jou:getJournalList>
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
                  xmlns:jou="http://www.sintagma.lt/avilys/JournalWS">
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
                  xmlns:jou=\"http://www.sintagma.lt/avilys/JournalWS\">
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
    "https://mok.dbsis.lt/dbsis/ws-cxf/JournalWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/JournalWS?wsdl';
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
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/JournalWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/JournalWS/getJournal"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:jou="http://www.sintagma.lt/avilys/JournalWS">
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
