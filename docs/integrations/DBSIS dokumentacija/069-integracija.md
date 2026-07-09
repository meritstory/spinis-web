# Integracija

- Path: `/api-dok/dbsis-api/api-taikymas/orgstructws/integracija`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/orgstructws/integracija
- Index: 69

---

OrgStructWS integracijos operacijos

### getRootUnit

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/organizacines-strukturos-pateikimo-sasaja#_232-operacija-getrootunit)

Grąžina šakninį (aukščiausią) organizacijos padalinį.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getRootUnit />
   </soapenv:Body>
</soapenv:Envelope>
```

```java
OrgUnit result = port.getRootUnit();
System.out.println(result.getOrgName());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:org=\"http://www.sintagma.lt/avilys/OrgStructWS\">
   <soapenv:Body>
      <org:getRootUnit />
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$result = $client->getRootUnit();
echo $result->orgName . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/OrgStructWS/getRootUnit"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getRootUnit />
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getOrgUnit

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/organizacines-strukturos-pateikimo-sasaja#_233-operacija-getorgunit)

Grąžina padalinį pagal `orgName`.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getOrgUnit>
         <orgName>PADALINYS_001</orgName>
      </org:getOrgUnit>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
OrgNodeParam param = new OrgNodeParam();
param.setOrgName("PADALINYS_001");

OrgUnit result = port.getOrgUnit(param);
System.out.println(result.getOfficialName());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:org=\"http://www.sintagma.lt/avilys/OrgStructWS\">
   <soapenv:Body>
      <org:getOrgUnit>
         <orgName>PADALINYS_001</orgName>
      </org:getOrgUnit>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'orgName' => 'PADALINYS_001'
];

$result = $client->getOrgUnit($param);
echo $result->orgName . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/OrgStructWS/getOrgUnit"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getOrgUnit>
         <orgName>PADALINYS_001</orgName>
      </org:getOrgUnit>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getNodeOrganization

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/organizacines-strukturos-pateikimo-sasaja#_234-operacija-getnodeorganization)

Grąžina organizaciją, kuriai priklauso padalinys.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getNodeOrganization>
         <orgName>PADALINYS_002</orgName>
      </org:getNodeOrganization>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
OrgNodeParam param = new OrgNodeParam();
param.setOrgName("PADALINYS_002");

OrgUnit result = port.getNodeOrganization(param);
System.out.println(result.getOrgName());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:org=\"http://www.sintagma.lt/avilys/OrgStructWS\">
   <soapenv:Body>
      <org:getNodeOrganization>
         <orgName>PADALINYS_002</orgName>
      </org:getNodeOrganization>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'orgName' => 'PADALINYS_002'
];

$result = $client->getNodeOrganization($param);
echo $result->orgName . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/OrgStructWS/getNodeOrganization"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getNodeOrganization>
         <orgName>PADALINYS_002</orgName>
      </org:getNodeOrganization>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getNodeParent

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/organizacines-strukturos-pateikimo-sasaja#_235-operacija-getnodeparent)

Grąžina tėvinį padalinį.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getNodeParent>
         <orgName>PADALINYS_002</orgName>
      </org:getNodeParent>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
OrgNodeParam param = new OrgNodeParam();
param.setOrgName("PADALINYS_002");

OrgNode result = port.getNodeParent(param);
System.out.println(result.getOrgName());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:org=\"http://www.sintagma.lt/avilys/OrgStructWS\">
   <soapenv:Body>
      <org:getNodeParent>
         <orgName>PADALINYS_002</orgName>
      </org:getNodeParent>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'orgName' => 'PADALINYS_002'
];

$result = $client->getNodeParent($param);
echo $result->orgName . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/OrgStructWS/getNodeParent"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getNodeParent>
         <orgName>PADALINYS_002</orgName>
      </org:getNodeParent>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getChildUnits

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/organizacines-strukturos-pateikimo-sasaja#_236-operacija-getchildunits)

Grąžina pavaldžių padalinių sąrašą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getChildUnits>
         <orgName>PADALINYS_001</orgName>
      </org:getChildUnits>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
OrgNodeParam param = new OrgNodeParam();
param.setOrgName("PADALINYS_001");

GetChildUnitsResult result = port.getChildUnits(param);
System.out.println(result.getChildUnit().size());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:org=\"http://www.sintagma.lt/avilys/OrgStructWS\">
   <soapenv:Body>
      <org:getChildUnits>
         <orgName>PADALINYS_001</orgName>
      </org:getChildUnits>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'orgName' => 'PADALINYS_001'
];

$result = $client->getChildUnits($param);
foreach ($result->childUnit ?? [] as $unit) {
    echo $unit->orgName . PHP_EOL;
}
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/OrgStructWS/getChildUnits"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getChildUnits>
         <orgName>PADALINYS_001</orgName>
      </org:getChildUnits>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getChildUnits2

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/organizacines-strukturos-pateikimo-sasaja#_237-operacija-getchildunits2)

Grąžina padalinių sąrašą su papildomomis parinktimis.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getChildUnits2>
         <orgName>PADALINYS_001</orgName>
         <returnDescendants>true</returnDescendants>
         <returnHistoricalNames>false</returnHistoricalNames>
      </org:getChildUnits2>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetChildUnitsParam param = new GetChildUnitsParam();
param.setOrgName("PADALINYS_001");
param.setReturnDescendants(true);
param.setReturnHistoricalNames(false);

GetChildUnitsResult result = port.getChildUnits2(param);
System.out.println(result.getChildUnit().size());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:org=\"http://www.sintagma.lt/avilys/OrgStructWS\">
   <soapenv:Body>
      <org:getChildUnits2>
         <orgName>PADALINYS_001</orgName>
         <returnDescendants>true</returnDescendants>
         <returnHistoricalNames>false</returnHistoricalNames>
      </org:getChildUnits2>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'orgName' => 'PADALINYS_001',
    'returnDescendants' => true,
    'returnHistoricalNames' => false
];

$result = $client->getChildUnits2($param);
foreach ($result->childUnit ?? [] as $unit) {
    echo $unit->orgName . PHP_EOL;
}
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/OrgStructWS/getChildUnits2"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getChildUnits2>
         <orgName>PADALINYS_001</orgName>
         <returnDescendants>true</returnDescendants>
         <returnHistoricalNames>false</returnHistoricalNames>
      </org:getChildUnits2>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getAllStaff

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/organizacines-strukturos-pateikimo-sasaja#_238-operacija-getallstaff)

Grąžina visų pareigybių sąrašą organizacijoje.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getAllStaff>
         <orgName>ROOT</orgName>
      </org:getAllStaff>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
OrgNodeParam param = new OrgNodeParam();
param.setOrgName("ROOT");

GetChildStaffResult result = port.getAllStaff(param);
System.out.println(result.getChildStaff().size());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:org=\"http://www.sintagma.lt/avilys/OrgStructWS\">
   <soapenv:Body>
      <org:getAllStaff>
         <orgName>ROOT</orgName>
      </org:getAllStaff>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'orgName' => 'ROOT'
];

$result = $client->getAllStaff($param);
foreach ($result->childStaff ?? [] as $staff) {
    echo $staff->orgName . PHP_EOL;
}
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/OrgStructWS/getAllStaff"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getAllStaff>
         <orgName>ROOT</orgName>
      </org:getAllStaff>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getAllStaffWithUser

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/organizacines-strukturos-pateikimo-sasaja#_239-operacija-getallstaffwithuser)

Grąžina pareigybių sąrašą su naudotojų informacija.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getAllStaffWithUser>
         <orgName>ROOT</orgName>
      </org:getAllStaffWithUser>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
OrgNodeParam param = new OrgNodeParam();
param.setOrgName("ROOT");

GetChildStaffResult result = port.getAllStaffWithUser(param);
System.out.println(result.getChildStaff().size());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:org=\"http://www.sintagma.lt/avilys/OrgStructWS\">
   <soapenv:Body>
      <org:getAllStaffWithUser>
         <orgName>ROOT</orgName>
      </org:getAllStaffWithUser>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'orgName' => 'ROOT'
];

$result = $client->getAllStaffWithUser($param);
foreach ($result->childStaff ?? [] as $staff) {
    echo $staff->orgName . PHP_EOL;
}
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/OrgStructWS/getAllStaffWithUser"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getAllStaffWithUser>
         <orgName>ROOT</orgName>
      </org:getAllStaffWithUser>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getChildStaff

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/organizacines-strukturos-pateikimo-sasaja#_2310-operacija-getchildstaff)

Grąžina pavaldžių pareigybių sąrašą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getChildStaff>
         <orgName>PADALINYS_001</orgName>
      </org:getChildStaff>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
OrgNodeParam param = new OrgNodeParam();
param.setOrgName("PADALINYS_001");

GetChildStaffResult result = port.getChildStaff(param);
System.out.println(result.getChildStaff().size());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:org=\"http://www.sintagma.lt/avilys/OrgStructWS\">
   <soapenv:Body>
      <org:getChildStaff>
         <orgName>PADALINYS_001</orgName>
      </org:getChildStaff>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'orgName' => 'PADALINYS_001'
];

$result = $client->getChildStaff($param);
foreach ($result->childStaff ?? [] as $staff) {
    echo $staff->orgName . PHP_EOL;
}
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/OrgStructWS/getChildStaff"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getChildStaff>
         <orgName>PADALINYS_001</orgName>
      </org:getChildStaff>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getChildStaffDirect

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/organizacines-strukturos-pateikimo-sasaja#_2311-operacija-getchildstaffdirect)

Grąžina tiesiogiai pavaldžių pareigybių sąrašą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getChildStaffDirect>
         <orgName>PADALINYS_001</orgName>
      </org:getChildStaffDirect>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
OrgNodeParam param = new OrgNodeParam();
param.setOrgName("PADALINYS_001");

GetChildStaffResult result = port.getChildStaffDirect(param);
System.out.println(result.getChildStaff().size());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:org=\"http://www.sintagma.lt/avilys/OrgStructWS\">
   <soapenv:Body>
      <org:getChildStaffDirect>
         <orgName>PADALINYS_001</orgName>
      </org:getChildStaffDirect>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'orgName' => 'PADALINYS_001'
];

$result = $client->getChildStaffDirect($param);
foreach ($result->childStaff ?? [] as $staff) {
    echo $staff->orgName . PHP_EOL;
}
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/OrgStructWS/getChildStaffDirect"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getChildStaffDirect>
         <orgName>PADALINYS_001</orgName>
      </org:getChildStaffDirect>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getChildStaffRestricted

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/organizacines-strukturos-pateikimo-sasaja#_2312-operacija-getchildstaffrestricted)

Grąžina ribotą pavaldžių pareigybių sąrašą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getChildStaffRestricted>
         <orgName>PADALINYS_001</orgName>
      </org:getChildStaffRestricted>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
OrgNodeParam param = new OrgNodeParam();
param.setOrgName("PADALINYS_001");

GetChildStaffResult result = port.getChildStaffRestricted(param);
System.out.println(result.getChildStaff().size());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:org=\"http://www.sintagma.lt/avilys/OrgStructWS\">
   <soapenv:Body>
      <org:getChildStaffRestricted>
         <orgName>PADALINYS_001</orgName>
      </org:getChildStaffRestricted>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'orgName' => 'PADALINYS_001'
];

$result = $client->getChildStaffRestricted($param);
foreach ($result->childStaff ?? [] as $staff) {
    echo $staff->orgName . PHP_EOL;
}
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/OrgStructWS/getChildStaffRestricted"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getChildStaffRestricted>
         <orgName>PADALINYS_001</orgName>
      </org:getChildStaffRestricted>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getChildStaffWithUserRestricted

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/organizacines-strukturos-pateikimo-sasaja#_2313-operacija-getchildstaffwithuserrestricted)

Grąžina ribotą pareigybių sąrašą su naudotojų informacija.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getChildStaffWithUserRestricted>
         <orgName>PADALINYS_001</orgName>
      </org:getChildStaffWithUserRestricted>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
OrgNodeParam param = new OrgNodeParam();
param.setOrgName("PADALINYS_001");

GetChildStaffResult result = port.getChildStaffWithUserRestricted(param);
System.out.println(result.getChildStaff().size());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:org=\"http://www.sintagma.lt/avilys/OrgStructWS\">
   <soapenv:Body>
      <org:getChildStaffWithUserRestricted>
         <orgName>PADALINYS_001</orgName>
      </org:getChildStaffWithUserRestricted>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'orgName' => 'PADALINYS_001'
];

$result = $client->getChildStaffWithUserRestricted($param);
foreach ($result->childStaff ?? [] as $staff) {
    echo $staff->orgName . PHP_EOL;
}
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/OrgStructWS/getChildStaffWithUserRestricted"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getChildStaffWithUserRestricted>
         <orgName>PADALINYS_001</orgName>
      </org:getChildStaffWithUserRestricted>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getChildStaffWithUser

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/organizacines-strukturos-pateikimo-sasaja#_2314-operacija-getchildstaffwithuser)

Grąžina pareigybių sąrašą su naudotojų informacija.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getChildStaffWithUser>
         <orgName>PADALINYS_001</orgName>
      </org:getChildStaffWithUser>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
OrgNodeParam param = new OrgNodeParam();
param.setOrgName("PADALINYS_001");

GetChildStaffResult result = port.getChildStaffWithUser(param);
System.out.println(result.getChildStaff().size());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:org=\"http://www.sintagma.lt/avilys/OrgStructWS\">
   <soapenv:Body>
      <org:getChildStaffWithUser>
         <orgName>PADALINYS_001</orgName>
      </org:getChildStaffWithUser>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'orgName' => 'PADALINYS_001'
];

$result = $client->getChildStaffWithUser($param);
foreach ($result->childStaff ?? [] as $staff) {
    echo $staff->orgName . PHP_EOL;
}
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/OrgStructWS/getChildStaffWithUser"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getChildStaffWithUser>
         <orgName>PADALINYS_001</orgName>
      </org:getChildStaffWithUser>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getChildStaffWithUserDirect

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/organizacines-strukturos-pateikimo-sasaja#_2315-operacija-getchildstaffwithuserdirect)

Grąžina tiesiogiai pavaldžių pareigybių sąrašą su naudotojų informacija.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getChildStaffWithUserDirect>
         <orgName>PADALINYS_001</orgName>
      </org:getChildStaffWithUserDirect>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
OrgNodeParam param = new OrgNodeParam();
param.setOrgName("PADALINYS_001");

GetChildStaffResult result = port.getChildStaffWithUserDirect(param);
System.out.println(result.getChildStaff().size());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:org=\"http://www.sintagma.lt/avilys/OrgStructWS\">
   <soapenv:Body>
      <org:getChildStaffWithUserDirect>
         <orgName>PADALINYS_001</orgName>
      </org:getChildStaffWithUserDirect>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'orgName' => 'PADALINYS_001'
];

$result = $client->getChildStaffWithUserDirect($param);
foreach ($result->childStaff ?? [] as $staff) {
    echo $staff->orgName . PHP_EOL;
}
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/OrgStructWS/getChildStaffWithUserDirect"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getChildStaffWithUserDirect>
         <orgName>PADALINYS_001</orgName>
      </org:getChildStaffWithUserDirect>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getOrganizationUnits

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/organizacines-strukturos-pateikimo-sasaja#_2316-operacija-getorganizationunits)

Grąžina organizacijos padalinių sąrašą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getOrganizationUnits>
         <orgName>ORG_001</orgName>
      </org:getOrganizationUnits>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
OrgNodeParam param = new OrgNodeParam();
param.setOrgName("ORG_001");

GetChildUnitsResult result = port.getOrganizationUnits(param);
System.out.println(result.getChildUnit().size());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:org=\"http://www.sintagma.lt/avilys/OrgStructWS\">
   <soapenv:Body>
      <org:getOrganizationUnits>
         <orgName>ORG_001</orgName>
      </org:getOrganizationUnits>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'orgName' => 'ORG_001'
];

$result = $client->getOrganizationUnits($param);
foreach ($result->childUnit ?? [] as $unit) {
    echo $unit->orgName . PHP_EOL;
}
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/OrgStructWS/getOrganizationUnits"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getOrganizationUnits>
         <orgName>ORG_001</orgName>
      </org:getOrganizationUnits>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getOrgStaff

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/organizacines-strukturos-pateikimo-sasaja#_2317-operacija-getorgstaff)

Grąžina pareigybės informaciją pagal `orgName`.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getOrgStaff>
         <orgName>STAFF_001</orgName>
      </org:getOrgStaff>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
OrgNodeParam param = new OrgNodeParam();
param.setOrgName("STAFF_001");

OrgStaff result = port.getOrgStaff(param);
System.out.println(result.getOfficialName());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:org=\"http://www.sintagma.lt/avilys/OrgStructWS\">
   <soapenv:Body>
      <org:getOrgStaff>
         <orgName>STAFF_001</orgName>
      </org:getOrgStaff>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'orgName' => 'STAFF_001'
];

$result = $client->getOrgStaff($param);
echo $result->officialName . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/OrgStructWS/getOrgStaff"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getOrgStaff>
         <orgName>STAFF_001</orgName>
      </org:getOrgStaff>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getStaffsForUser

Grąžina naudotojo pareigybių sąrašą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getStaffsForUser>
         <uaName>USER_001</uaName>
      </org:getStaffsForUser>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
UserParam param = new UserParam();
param.setUaName("USER_001");

GetChildStaffResult result = port.getStaffsForUser(param);
System.out.println(result.getChildStaff().size());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:org=\"http://www.sintagma.lt/avilys/OrgStructWS\">
   <soapenv:Body>
      <org:getStaffsForUser>
         <uaName>USER_001</uaName>
      </org:getStaffsForUser>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'uaName' => 'USER_001'
];

$result = $client->getStaffsForUser($param);
foreach ($result->childStaff ?? [] as $staff) {
    echo $staff->orgName . PHP_EOL;
}
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/OrgStructWS/getStaffsForUser"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getStaffsForUser>
         <uaName>USER_001</uaName>
      </org:getStaffsForUser>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getStaffForUserExtended

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/organizacines-strukturos-pateikimo-sasaja#_2318-operacija-getstaffforuserresultextended)

Grąžina naudotojo pareigybių sąrašą su papildomomis teisėmis.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getStaffForUserExtended>
         <uaName>USER_001</uaName>
      </org:getStaffForUserExtended>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
UserParam param = new UserParam();
param.setUaName("USER_001");

GetStaffForUserResult result = port.getStaffForUserExtended(param);
System.out.println(result.getOrgStaffSet().size());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:org=\"http://www.sintagma.lt/avilys/OrgStructWS\">
   <soapenv:Body>
      <org:getStaffForUserExtended>
         <uaName>USER_001</uaName>
      </org:getStaffForUserExtended>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'uaName' => 'USER_001'
];

$result = $client->getStaffForUserExtended($param);
echo count($result->orgStaffSet ?? []) . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/OrgStructWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/OrgStructWS/getStaffForUserExtended"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:org="http://www.sintagma.lt/avilys/OrgStructWS">
   <soapenv:Body>
      <org:getStaffForUserExtended>
         <uaName>USER_001</uaName>
      </org:getStaffForUserExtended>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija
