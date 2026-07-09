# Integracija

- Path: `/api-dok/dbsis-api/api-taikymas/officecasews.v2/integracija`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/officecasews.v2/integracija
- Index: 67

---

OfficeCaseWS.V2 integracijos operacijos

### getOfficeCasesList

Grąžina bylų sąrašą su išplėstais laukais.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:off="http://www.sintagma.lt/avilys/OfficeCaseWS/v2">
   <soapenv:Body>
      <off:getOfficeCasesList>
         <getOfficeCasesListParam>
            <index>2024-01</index>
            <title>Bylos pavadinimas</title>
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
         </getOfficeCasesListParam>
      </off:getOfficeCasesList>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetOfficeCaseListParam param = new GetOfficeCaseListParam();
param.setIndex("2024-01");
param.setTitle("Bylos pavadinimas");
param.setAccessType(AccessType.USE);
param.setExpandAccessPermissions(true);

OrgNodeParam owner = new OrgNodeParam();
owner.setOrgName("PADALINYS_001");
OrgNodeListParam ownerOrg = new OrgNodeListParam();
ownerOrg.getOrgNode().add(owner);
param.setOwnerOrg(ownerOrg);

ListWBean result = port.getOfficeCasesList(param);
System.out.println(result.getListItem().size());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:off=\"http://www.sintagma.lt/avilys/OfficeCaseWS/v2\">
   <soapenv:Body>
      <off:getOfficeCasesList>
         <getOfficeCasesListParam>
            <index>2024-01</index>
            <title>Bylos pavadinimas</title>
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
         </getOfficeCasesListParam>
      </off:getOfficeCasesList>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/OfficeCaseWS/v2",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/OfficeCaseWS/v2?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'getOfficeCasesListParam' => [
        'index' => '2024-01',
        'title' => 'Bylos pavadinimas',
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

$result = $client->getOfficeCasesList($param);
foreach ($result->officeCases->listItem ?? [] as $officeCase) {
    echo $officeCase->oid . PHP_EOL;
}
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/OfficeCaseWS/v2' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/OfficeCaseWS/v2/getOfficeCasesList"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:off="http://www.sintagma.lt/avilys/OfficeCaseWS/v2">
   <soapenv:Body>
      <off:getOfficeCasesList>
         <getOfficeCasesListParam>
            <index>2024-01</index>
            <title>Bylos pavadinimas</title>
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
         </getOfficeCasesListParam>
      </off:getOfficeCasesList>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getOfficeCase

Grąžina konkrečią bylą pagal OID.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:off="http://www.sintagma.lt/avilys/OfficeCaseWS/v2">
   <soapenv:Body>
      <off:getOfficeCase>
         <getOfficeCaseParam>
            <oid>CASE-001</oid>
         </getOfficeCaseParam>
      </off:getOfficeCase>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetOfficeCaseParam param = new GetOfficeCaseParam();
param.setOid("CASE-001");

OfficeCase result = port.getOfficeCase(param);
System.out.println(result.getTitle());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:off=\"http://www.sintagma.lt/avilys/OfficeCaseWS/v2\">
   <soapenv:Body>
      <off:getOfficeCase>
         <getOfficeCaseParam>
            <oid>CASE-001</oid>
         </getOfficeCaseParam>
      </off:getOfficeCase>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/OfficeCaseWS/v2",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/OfficeCaseWS/v2?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'getOfficeCaseParam' => [
        'oid' => 'CASE-001'
    ]
];

$result = $client->getOfficeCase($param);
echo $result->officeCase->title . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/OfficeCaseWS/v2' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/OfficeCaseWS/v2/getOfficeCase"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:off="http://www.sintagma.lt/avilys/OfficeCaseWS/v2">
   <soapenv:Body>
      <off:getOfficeCase>
         <getOfficeCaseParam>
            <oid>CASE-001</oid>
         </getOfficeCaseParam>
      </off:getOfficeCase>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija
