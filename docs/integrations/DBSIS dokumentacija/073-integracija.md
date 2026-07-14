# Integracija

- Path: `/api-dok/dbsis-api/api-taikymas/processtaskws/integracija`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/processtaskws/integracija
- Index: 73

---

ProcessTaskWS integracijos operacijos

### getCurrentProcessTaskList

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/darbo-eigos-procesu-uzduociu-pateikimo-sasaja#_2122-operacija-getcurrentprocesstasklist)

Grąžina aktyvias darbo eigos proceso užduotis pagal vykdytoją, dokumentą ir (ar) veiksmą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:pro="http://www.sintagma.lt/avilys/ProcessTaskWS">
   <soapenv:Body>
      <pro:getCurrentProcessTaskList>
         <getCurrentProcessTaskListParam>
            <actionName>review</actionName>
            <executor>
               <orgName>STAFF_001</orgName>
            </executor>
            <documentOid>DOC-2024-00001234</documentOid>
         </getCurrentProcessTaskListParam>
      </pro:getCurrentProcessTaskList>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetCurrentProcessTaskListParam param = new GetCurrentProcessTaskListParam();
param.setActionName("review");
param.setDocumentOid("DOC-2024-00001234");

OrgNodeParam executor = new OrgNodeParam();
executor.setOrgName("STAFF_001");
param.setExecutor(executor);

GetProcessTaskListResult result = port.getCurrentProcessTaskList(param);
System.out.println(result.getProcessTask().size());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:pro=\"http://www.sintagma.lt/avilys/ProcessTaskWS\">
   <soapenv:Body>
      <pro:getCurrentProcessTaskList>
         <getCurrentProcessTaskListParam>
            <actionName>review</actionName>
            <executor>
               <orgName>STAFF_001</orgName>
            </executor>
            <documentOid>DOC-2024-00001234</documentOid>
         </getCurrentProcessTaskListParam>
      </pro:getCurrentProcessTaskList>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/ProcessTaskWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/ProcessTaskWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'getCurrentProcessTaskListParam' => [
        'actionName' => 'review',
        'executor' => [
            'orgName' => 'STAFF_001'
        ],
        'documentOid' => 'DOC-2024-00001234'
    ]
];

$result = $client->getCurrentProcessTaskList($param);
foreach ($result->processTaskList->processTask ?? [] as $task) {
    echo $task->actionName . PHP_EOL;
}
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/ProcessTaskWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/ProcessTaskWS/getCurrentProcessTaskList"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:pro="http://www.sintagma.lt/avilys/ProcessTaskWS">
   <soapenv:Body>
      <pro:getCurrentProcessTaskList>
         <getCurrentProcessTaskListParam>
            <actionName>review</actionName>
            <executor>
               <orgName>STAFF_001</orgName>
            </executor>
            <documentOid>DOC-2024-00001234</documentOid>
         </getCurrentProcessTaskListParam>
      </pro:getCurrentProcessTaskList>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija
