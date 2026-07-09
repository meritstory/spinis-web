# Maršrutizavimas

- Path: `/api-dok/dbsis-api/api-taikymas/cdodocumentws/marsrutizavimas`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/cdodocumentws/marsrutizavimas
- Index: 27

---

CDODocumentWS maršrutizavimo operacijos

### routeForAcquaintance

Nukreipia dokumentą susipažinimui.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cdo="http://www.sintagma.lt/avilys/CDODocumentWS">
   <soapenv:Body>
      <cdo:routeForAcquaintance>
         <routeForAcquaintanceParam>
            <docOid>DOC_12345</docOid>
            <acquaintees>
               <orgNode>
                  <orgName>SKYRIUS_001</orgName>
               </orgNode>
            </acquaintees>
            <dueDate>2024-12-31T00:00:00</dueDate>
            <notes>Prašau susipažinti</notes>
         </routeForAcquaintanceParam>
      </cdo:routeForAcquaintance>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
RouteForAcquaintanceParam param = new RouteForAcquaintanceParam();
param.setDocOid("DOC_12345");

OrgNodeParam person = new OrgNodeParam();
person.setOrgName("SKYRIUS_001");

OrgNodeListParam acquaintees = new OrgNodeListParam();
acquaintees.getOrgNode().add(person);
param.setAcquaintees(acquaintees);

param.setDueDate(javax.xml.datatype.DatatypeFactory.newInstance()
    .newXMLGregorianCalendar("2024-12-31T00:00:00"));
param.setNotes("Prašau susipažinti");

DocumentInfo result = port.routeForAcquaintance(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:cdo=""http://www.sintagma.lt/avilys/CDODocumentWS"">
   <soapenv:Body>
      <cdo:routeForAcquaintance>
         <routeForAcquaintanceParam>
            <docOid>DOC_12345</docOid>
            <acquaintees>
               <orgNode>
                  <orgName>SKYRIUS_001</orgName>
               </orgNode>
            </acquaintees>
            <dueDate>2024-12-31T00:00:00</dueDate>
            <notes>Prašau susipažinti</notes>
         </routeForAcquaintanceParam>
      </cdo:routeForAcquaintance>
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
    'routeForAcquaintanceParam' => [
        'docOid' => 'DOC_12345',
        'acquaintees' => [
            'orgNode' => [
                ['orgName' => 'SKYRIUS_001']
            ]
        ],
        'dueDate' => '2024-12-31T00:00:00',
        'notes' => 'Prašau susipažinti'
    ]
];

$result = $client->routeForAcquaintance($param);
echo "Dokumento OID: " . $result->documentInfo->oid;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/CDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: \"\"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cdo="http://www.sintagma.lt/avilys/CDODocumentWS">
   <soapenv:Body>
      <cdo:routeForAcquaintance>
         <routeForAcquaintanceParam>
            <docOid>DOC_12345</docOid>
            <acquaintees>
               <orgNode>
                  <orgName>SKYRIUS_001</orgName>
               </orgNode>
            </acquaintees>
            <dueDate>2024-12-31T00:00:00</dueDate>
            <notes>Prašau susipažinti</notes>
         </routeForAcquaintanceParam>
      </cdo:routeForAcquaintance>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---
