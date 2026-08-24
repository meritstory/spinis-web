# Registravimas

- Path: `/api-dok/dbsis-api/api-taikymas/rdodocumentws/registravimas`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/rdodocumentws/registravimas
- Index: 79

---

RDODocumentWS registravimo operacijos

### register

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_2218-operacija-register)

Registruoja dokumentą žurnale.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:register>
         <registerParam>
            <docOid>DOC_12345</docOid>
            <journal>
               <oid>JRN-001</oid>
            </journal>
            <officeCase>
               <oid>CASE-001</oid>
            </officeCase>
            <registrationNo>RN-2024-001</registrationNo>
         </registerParam>
      </rdo:register>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
RegisterParam param = new RegisterParam();
param.setDocOid("DOC_12345");

JournalParam journal = new JournalParam();
journal.setOid("JRN-001");
param.setJournal(journal);

OfficeCaseParam officeCase = new OfficeCaseParam();
officeCase.setOid("CASE-001");
param.setOfficeCase(officeCase);

param.setRegistrationNo("RN-2024-001");

DocumentInfo result = port.register(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:register>
         <registerParam>
            <docOid>DOC_12345</docOid>
            <journal>
               <oid>JRN-001</oid>
            </journal>
            <officeCase>
               <oid>CASE-001</oid>
            </officeCase>
            <registrationNo>RN-2024-001</registrationNo>
         </registerParam>
      </rdo:register>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'registerParam' => [
        'docOid' => 'DOC_12345',
        'journal' => [
            'oid' => 'JRN-001'
        ],
        'officeCase' => [
            'oid' => 'CASE-001'
        ],
        'registrationNo' => 'RN-2024-001'
    ]
];

$result = $client->register($param);
echo "Dokumento OID: " . $result->documentInfo->oid;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: \"\"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:register>
         <registerParam>
            <docOid>DOC_12345</docOid>
            <journal>
               <oid>JRN-001</oid>
            </journal>
            <officeCase>
               <oid>CASE-001</oid>
            </officeCase>
            <registrationNo>RN-2024-001</registrationNo>
         </registerParam>
      </rdo:register>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---
