# Užduočių įvykių priėmimas

- Path: `/api-dok/dbsis-api/api-taikymas/dhstaskeventsws/uzduociu-ivykiu-priemimas`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/dhstaskeventsws/uzduociu-ivykiu-priemimas
- Index: 42

---

DhsTaskEventsWs užduočių įvykių priėmimo operacijos

### receiveDhsTaskEvent

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/informavimo-apie-veiksmus-sasaja-dhstaskeventsw#_2181-operacija-receivedhstaskevent)

Priima DBSIS užduoties įvykio pranešimą apie veiksmą ir jo vykdytojus.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:tar="http://www.sintagma.lt/avilys/">
   <soapenv:Body>
      <tar:receiveDhsTaskEvent>
         <receiveDhsTaskEventParam>
            <oid>DOC-2024-0001</oid>
            <appModule>RDO</appModule>
            <entityType>RegisteredDocument</entityType>
            <action>ASSIGN_TASK</action>
            <docSort>VIDINIS</docSort>
            <registrationDate>2024-01-15T10:00:00Z</registrationDate>
            <registrationNo>RN-2024-001</registrationNo>
            <title>Dokumento pavadinimas</title>
            <senderCodes>123456789</senderCodes>
            <receiverCodes>987654321</receiverCodes>
            <status>Vykdoma</status>
            <isElectro>true</isElectro>
            <documentDate>2024-01-15T09:00:00Z</documentDate>
            <documentNo>DOC-001</documentNo>
            <taskInfo>
               <actionName>Sudaryti atsakymą</actionName>
               <executor>
                  <orgName>UNIT_001</orgName>
               </executor>
               <documentOid>DOC-2024-0001</documentOid>
               <dueDate>2024-01-20T17:00:00Z</dueDate>
               <notes>Skubiai parengti atsakymą</notes>
               <executorNotes>Pradėta</executorNotes>
               <assignDate>2024-01-15T10:05:00Z</assignDate>
               <allowedToModifyAttachments>false</allowedToModifyAttachments>
            </taskInfo>
         </receiveDhsTaskEventParam>
      </tar:receiveDhsTaskEvent>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
ReceiveDhsTaskEventParam param = new ReceiveDhsTaskEventParam();
param.setOid("DOC-2024-0001");
param.setAppModule("RDO");
param.setEntityType("RegisteredDocument");
param.setAction("ASSIGN_TASK");
param.setDocSort("VIDINIS");
param.setRegistrationDate(javax.xml.datatype.DatatypeFactory.newInstance()
    .newXMLGregorianCalendar("2024-01-15T10:00:00Z"));
param.setRegistrationNo("RN-2024-001");
param.setTitle("Dokumento pavadinimas");
param.getSenderCodes().add("123456789");
param.getReceiverCodes().add("987654321");

param.setStatus("Vykdoma");
param.setIsElectro(true);
param.setDocumentDate(javax.xml.datatype.DatatypeFactory.newInstance()
    .newXMLGregorianCalendar("2024-01-15T09:00:00Z"));
param.setDocumentNo("DOC-001");

DocumentProcessTaskInfoParam taskInfo = new DocumentProcessTaskInfoParam();
taskInfo.setActionName("Sudaryti atsakymą");
OrgNodeParam executor = new OrgNodeParam();
executor.setOrgName("UNIT_001");
taskInfo.setExecutor(executor);
taskInfo.setDocumentOid("DOC-2024-0001");
taskInfo.setDueDate(javax.xml.datatype.DatatypeFactory.newInstance()
    .newXMLGregorianCalendar("2024-01-20T17:00:00Z"));
taskInfo.setNotes("Skubiai parengti atsakymą");
taskInfo.setExecutorNotes("Pradėta");
taskInfo.setAssignDate(javax.xml.datatype.DatatypeFactory.newInstance()
    .newXMLGregorianCalendar("2024-01-15T10:05:00Z"));
taskInfo.setAllowedToModifyAttachments(false);
param.setTaskInfo(taskInfo);

ReceiveDhsTaskEventResult result = port.receiveDhsTaskEvent(param);
System.out.println(result.getStatusCode());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:tar=\"http://www.sintagma.lt/avilys/\">
   <soapenv:Body>
      <tar:receiveDhsTaskEvent>
         <receiveDhsTaskEventParam>
            <oid>DOC-2024-0001</oid>
            <appModule>RDO</appModule>
            <entityType>RegisteredDocument</entityType>
            <action>ASSIGN_TASK</action>
            <docSort>VIDINIS</docSort>
            <registrationDate>2024-01-15T10:00:00Z</registrationDate>
            <registrationNo>RN-2024-001</registrationNo>
            <title>Dokumento pavadinimas</title>
            <senderCodes>123456789</senderCodes>
            <receiverCodes>987654321</receiverCodes>
            <status>Vykdoma</status>
            <isElectro>true</isElectro>
            <documentDate>2024-01-15T09:00:00Z</documentDate>
            <documentNo>DOC-001</documentNo>
            <taskInfo>
               <actionName>Sudaryti atsakymą</actionName>
               <executor>
                  <orgName>UNIT_001</orgName>
               </executor>
               <documentOid>DOC-2024-0001</documentOid>
               <dueDate>2024-01-20T17:00:00Z</dueDate>
               <notes>Skubiai parengti atsakymą</notes>
               <executorNotes>Pradėta</executorNotes>
               <assignDate>2024-01-15T10:05:00Z</assignDate>
               <allowedToModifyAttachments>false</allowedToModifyAttachments>
            </taskInfo>
         </receiveDhsTaskEventParam>
      </tar:receiveDhsTaskEvent>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/DhsTaskEventsWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/DhsTaskEventsWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'receiveDhsTaskEventParam' => [
        'oid' => 'DOC-2024-0001',
        'appModule' => 'RDO',
        'entityType' => 'RegisteredDocument',
        'action' => 'ASSIGN_TASK',
        'docSort' => 'VIDINIS',
        'registrationDate' => '2024-01-15T10:00:00Z',
        'registrationNo' => 'RN-2024-001',
        'title' => 'Dokumento pavadinimas',
        'senderCodes' => ['123456789'],
        'receiverCodes' => ['987654321'],
        'status' => 'Vykdoma',
        'isElectro' => true,
        'documentDate' => '2024-01-15T09:00:00Z',
        'documentNo' => 'DOC-001',
        'taskInfo' => [
            'actionName' => 'Sudaryti atsakymą',
            'executor' => ['orgName' => 'UNIT_001'],
            'documentOid' => 'DOC-2024-0001',
            'dueDate' => '2024-01-20T17:00:00Z',
            'notes' => 'Skubiai parengti atsakymą',
            'executorNotes' => 'Pradėta',
            'assignDate' => '2024-01-15T10:05:00Z',
            'allowedToModifyAttachments' => false
        ]
    ]
];

$result = $client->receiveDhsTaskEvent($param);
echo $result->return->statusCode . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/DhsTaskEventsWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: ""' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:tar="http://www.sintagma.lt/avilys/">
   <soapenv:Body>
      <tar:receiveDhsTaskEvent>
         <receiveDhsTaskEventParam>
            <oid>DOC-2024-0001</oid>
            <appModule>RDO</appModule>
            <entityType>RegisteredDocument</entityType>
            <action>ASSIGN_TASK</action>
            <docSort>VIDINIS</docSort>
            <registrationDate>2024-01-15T10:00:00Z</registrationDate>
            <registrationNo>RN-2024-001</registrationNo>
            <title>Dokumento pavadinimas</title>
            <senderCodes>123456789</senderCodes>
            <receiverCodes>987654321</receiverCodes>
            <status>Vykdoma</status>
            <isElectro>true</isElectro>
            <documentDate>2024-01-15T09:00:00Z</documentDate>
            <documentNo>DOC-001</documentNo>
            <taskInfo>
               <actionName>Sudaryti atsakymą</actionName>
               <executor>
                  <orgName>UNIT_001</orgName>
               </executor>
               <documentOid>DOC-2024-0001</documentOid>
               <dueDate>2024-01-20T17:00:00Z</dueDate>
               <notes>Skubiai parengti atsakymą</notes>
               <executorNotes>Pradėta</executorNotes>
               <assignDate>2024-01-15T10:05:00Z</assignDate>
               <allowedToModifyAttachments>false</allowedToModifyAttachments>
            </taskInfo>
         </receiveDhsTaskEventParam>
      </tar:receiveDhsTaskEvent>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija
