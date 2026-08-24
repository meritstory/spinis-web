# Integracija

- Path: `/api-dok/dbsis-api/api-taikymas/trackinginfows/integracija`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/trackinginfows/integracija
- Index: 97

---

TrackingInfoWS integracijos operacijos

### getTrackingEvents

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/istorijos-irasu-sasaja#_2161-operacija-gettrackingevents)

Grąžina dokumento istorijos įrašus pagal filtrus.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:trk="http://www.sintagma.lt/avilys/TrackingInfoWS">
   <soapenv:Body>
      <trk:getTrackingEvents>
         <getTrackingEventsParam>
            <docOid>DOC-2024-00001234</docOid>
            <actionName>REGISTER</actionName>
            <eventDateRange>
               <from>2024-01-01T00:00:00</from>
               <to>2024-01-31T23:59:59</to>
            </eventDateRange>
         </getTrackingEventsParam>
      </trk:getTrackingEvents>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetTrackingEventsParam param = new GetTrackingEventsParam();
param.setDocOid("DOC-2024-00001234");
param.setActionName("REGISTER");

DateRangeParam dateRange = new DateRangeParam();
dateRange.setFrom(javax.xml.datatype.DatatypeFactory.newInstance()
    .newXMLGregorianCalendar("2024-01-01T00:00:00"));
dateRange.setTo(javax.xml.datatype.DatatypeFactory.newInstance()
    .newXMLGregorianCalendar("2024-01-31T23:59:59"));
param.setEventDateRange(dateRange);

GetTrackingEventsResult result = port.getTrackingEvents(param);
System.out.println(result.getTrackingInfo().size());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:trk=\"http://www.sintagma.lt/avilys/TrackingInfoWS\">
   <soapenv:Body>
      <trk:getTrackingEvents>
         <getTrackingEventsParam>
            <docOid>DOC-2024-00001234</docOid>
            <actionName>REGISTER</actionName>
            <eventDateRange>
               <from>2024-01-01T00:00:00</from>
               <to>2024-01-31T23:59:59</to>
            </eventDateRange>
         </getTrackingEventsParam>
      </trk:getTrackingEvents>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/TrackingInfoWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/TrackingInfoWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'getTrackingEventsParam' => [
        'docOid' => 'DOC-2024-00001234',
        'actionName' => 'REGISTER',
        'eventDateRange' => [
            'from' => '2024-01-01T00:00:00',
            'to' => '2024-01-31T23:59:59'
        ]
    ]
];

$result = $client->getTrackingEvents($param);
foreach ($result->docTrackingInfos->trackingInfo ?? [] as $item) {
    echo $item->actionName . PHP_EOL;
}
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/TrackingInfoWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/TrackingInfoWS/getTrackingEvents"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:trk="http://www.sintagma.lt/avilys/TrackingInfoWS">
   <soapenv:Body>
      <trk:getTrackingEvents>
         <getTrackingEventsParam>
            <docOid>DOC-2024-00001234</docOid>
            <actionName>REGISTER</actionName>
            <eventDateRange>
               <from>2024-01-01T00:00:00</from>
               <to>2024-01-31T23:59:59</to>
            </eventDateRange>
         </getTrackingEventsParam>
      </trk:getTrackingEvents>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija
