# Maršrutizavimas

- Path: `/api-dok/dbsis-api/api-taikymas/rdodocumentws/marsrutizavimas`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/rdodocumentws/marsrutizavimas
- Index: 80

---

RDODocumentWS maršrutizavimo operacijos

### routeFor

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_2216-operacija-routefor)

Nukreipia dokumentą nurodytam organizacijos mazgui.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:routeFor>
         <routeForParam>
            <docOid>DOC_12345</docOid>
            <orgNode>
               <orgName>SKYRIUS_001</orgName>
            </orgNode>
            <routedBy>
               <orgName>REGISTRATORIUS_001</orgName>
            </routedBy>
            <notes>Prašau peržiūrėti</notes>
         </routeForParam>
      </rdo:routeFor>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
RouteForParam param = new RouteForParam();
param.setDocOid("DOC_12345");

OrgNodeParam orgNode = new OrgNodeParam();
orgNode.setOrgName("SKYRIUS_001");
param.getOrgNode().add(orgNode);

OrgNodeParam routedBy = new OrgNodeParam();
routedBy.setOrgName("REGISTRATORIUS_001");
param.setRoutedBy(routedBy);

param.setNotes("Prašau peržiūrėti");

DocumentInfo result = port.routeFor(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:routeFor>
         <routeForParam>
            <docOid>DOC_12345</docOid>
            <orgNode>
               <orgName>SKYRIUS_001</orgName>
            </orgNode>
            <routedBy>
               <orgName>REGISTRATORIUS_001</orgName>
            </routedBy>
            <notes>Prašau peržiūrėti</notes>
         </routeForParam>
      </rdo:routeFor>
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
    'routeForParam' => [
        'docOid' => 'DOC_12345',
        'orgNode' => [
            ['orgName' => 'SKYRIUS_001']
        ],
        'routedBy' => [
            'orgName' => 'REGISTRATORIUS_001'
        ],
        'notes' => 'Prašau peržiūrėti'
    ]
];

$result = $client->routeFor($param);
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
      <rdo:routeFor>
         <routeForParam>
            <docOid>DOC_12345</docOid>
            <orgNode>
               <orgName>SKYRIUS_001</orgName>
            </orgNode>
            <routedBy>
               <orgName>REGISTRATORIUS_001</orgName>
            </routedBy>
            <notes>Prašau peržiūrėti</notes>
         </routeForParam>
      </rdo:routeFor>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### routeForResolution

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_2217-operacija-routeforresolution)

Nukreipia dokumentą rezoliucijai.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:routeForResolution>
         <routeForResolutionParam>
            <docOid>DOC_12345</docOid>
            <assignees>
               <orgName>DARBUOTOJAS_001</orgName>
            </assignees>
         </routeForResolutionParam>
      </rdo:routeForResolution>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
RouteForResolutionParam param = new RouteForResolutionParam();
param.setDocOid("DOC_12345");

OrgNodeParam assignee = new OrgNodeParam();
assignee.setOrgName("DARBUOTOJAS_001");
param.getAssignees().add(assignee);

DocumentInfo result = port.routeForResolution(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:routeForResolution>
         <routeForResolutionParam>
            <docOid>DOC_12345</docOid>
            <assignees>
               <orgName>DARBUOTOJAS_001</orgName>
            </assignees>
         </routeForResolutionParam>
      </rdo:routeForResolution>
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
    'routeForResolutionParam' => [
        'docOid' => 'DOC_12345',
        'assignees' => [
            ['orgName' => 'DARBUOTOJAS_001']
        ]
    ]
];

$result = $client->routeForResolution($param);
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
      <rdo:routeForResolution>
         <routeForResolutionParam>
            <docOid>DOC_12345</docOid>
            <assignees>
               <orgName>DARBUOTOJAS_001</orgName>
            </assignees>
         </routeForResolutionParam>
      </rdo:routeForResolution>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### routeForAcquaintance

Nukreipia dokumentą susipažinimui.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:routeForAcquaintance>
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
      </rdo:routeForAcquaintance>
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
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:routeForAcquaintance>
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
      </rdo:routeForAcquaintance>
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
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: \"\"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:routeForAcquaintance>
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
      </rdo:routeForAcquaintance>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### modifyAcquaintees

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_2223-operacija-modifyacquaintees)

Modifikuoja susipažįstančiųjų sąrašą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:modifyAcquaintees>
         <modifyAcquinteesParam>
            <docOid>DOC_12345</docOid>
            <acquaintees>
               <orgName>DARBUOTOJAS_002</orgName>
            </acquaintees>
            <notes>Atnaujintas sąrašas</notes>
         </modifyAcquinteesParam>
      </rdo:modifyAcquaintees>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
ModifyAcquainteesParam param = new ModifyAcquainteesParam();
param.setDocOid("DOC_12345");

OrgNodeParam person = new OrgNodeParam();
person.setOrgName("DARBUOTOJAS_002");
param.getAcquaintees().add(person);

param.setNotes("Atnaujintas sąrašas");

DocumentInfo result = port.modifyAcquaintees(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:modifyAcquaintees>
         <modifyAcquinteesParam>
            <docOid>DOC_12345</docOid>
            <acquaintees>
               <orgName>DARBUOTOJAS_002</orgName>
            </acquaintees>
            <notes>Atnaujintas sąrašas</notes>
         </modifyAcquinteesParam>
      </rdo:modifyAcquaintees>
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
    'modifyAcquinteesParam' => [
        'docOid' => 'DOC_12345',
        'acquaintees' => [
            ['orgName' => 'DARBUOTOJAS_002']
        ],
        'notes' => 'Atnaujintas sąrašas'
    ]
];

$result = $client->modifyAcquaintees($param);
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
      <rdo:modifyAcquaintees>
         <modifyAcquinteesParam>
            <docOid>DOC_12345</docOid>
            <acquaintees>
               <orgName>DARBUOTOJAS_002</orgName>
            </acquaintees>
            <notes>Atnaujintas sąrašas</notes>
         </modifyAcquinteesParam>
      </rdo:modifyAcquaintees>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---
