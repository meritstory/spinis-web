# Įvykių priėmimas

- Path: `/api-dok/dbsis-api/api-taikymas/dhseventsws/ivykiu-priemimas`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/dhseventsws/ivykiu-priemimas
- Index: 40

---

DhsEventsWs įvykių priėmimo operacijos

### receiveDhsEvent

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/informavimo-apie-veiksmus-sasaja#_2111-operacija-receivedhsevent)

Priima DBSIS įvykio pranešimą apie dokumento ar kitos esybės veiksmą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:tar="http://www.sintagma.lt/avilys/">
   <soapenv:Body>
      <tar:receiveDhsEvent>
         <receiveDhsEventParam>
            <oid>DOC-2024-0001</oid>
            <appModule>RDO</appModule>
            <entityType>RegisteredDocument</entityType>
            <action>REGISTER</action>
            <docSort>VIDINIS</docSort>
            <registrationDate>2024-01-15T10:00:00Z</registrationDate>
            <registrationNo>RN-2024-001</registrationNo>
            <title>Dokumento pavadinimas</title>
            <senderCodes>123456789</senderCodes>
            <receiverCodes>987654321</receiverCodes>
         </receiveDhsEventParam>
      </tar:receiveDhsEvent>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
ReceiveDhsEventParam param = new ReceiveDhsEventParam();
param.setOid("DOC-2024-0001");
param.setAppModule("RDO");
param.setEntityType("RegisteredDocument");
param.setAction("REGISTER");
param.setDocSort("VIDINIS");
param.setRegistrationDate(javax.xml.datatype.DatatypeFactory.newInstance()
    .newXMLGregorianCalendar("2024-01-15T10:00:00Z"));
param.setRegistrationNo("RN-2024-001");
param.setTitle("Dokumento pavadinimas");
param.getSenderCodes().add("123456789");
param.getReceiverCodes().add("987654321");

ReceiveDhsEventResult result = port.receiveDhsEvent(param);
System.out.println(result.getStatusCode());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:tar=\"http://www.sintagma.lt/avilys/\">
   <soapenv:Body>
      <tar:receiveDhsEvent>
         <receiveDhsEventParam>
            <oid>DOC-2024-0001</oid>
            <appModule>RDO</appModule>
            <entityType>RegisteredDocument</entityType>
            <action>REGISTER</action>
            <docSort>VIDINIS</docSort>
            <registrationDate>2024-01-15T10:00:00Z</registrationDate>
            <registrationNo>RN-2024-001</registrationNo>
            <title>Dokumento pavadinimas</title>
            <senderCodes>123456789</senderCodes>
            <receiverCodes>987654321</receiverCodes>
         </receiveDhsEventParam>
      </tar:receiveDhsEvent>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/TAREventsWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/TAREventsWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'receiveDhsEventParam' => [
        'oid' => 'DOC-2024-0001',
        'appModule' => 'RDO',
        'entityType' => 'RegisteredDocument',
        'action' => 'REGISTER',
        'docSort' => 'VIDINIS',
        'registrationDate' => '2024-01-15T10:00:00Z',
        'registrationNo' => 'RN-2024-001',
        'title' => 'Dokumento pavadinimas',
        'senderCodes' => ['123456789'],
        'receiverCodes' => ['987654321']
    ]
];

$result = $client->receiveDhsEvent($param);
echo $result->return->statusCode . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/TAREventsWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: ""' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:tar="http://www.sintagma.lt/avilys/">
   <soapenv:Body>
      <tar:receiveDhsEvent>
         <receiveDhsEventParam>
            <oid>DOC-2024-0001</oid>
            <appModule>RDO</appModule>
            <entityType>RegisteredDocument</entityType>
            <action>REGISTER</action>
            <docSort>VIDINIS</docSort>
            <registrationDate>2024-01-15T10:00:00Z</registrationDate>
            <registrationNo>RN-2024-001</registrationNo>
            <title>Dokumento pavadinimas</title>
            <senderCodes>123456789</senderCodes>
            <receiverCodes>987654321</receiverCodes>
         </receiveDhsEventParam>
      </tar:receiveDhsEvent>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija
