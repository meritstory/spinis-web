# Klasifikatorių užklausos

- Path: `/api-dok/dbsis-api/api-taikymas/classifierws/klasifikatoriu-uzklausos`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/classifierws/klasifikatoriu-uzklausos
- Index: 32

---

ClassifierWS klasifikatorių užklausų operacijos

### getClassifierClassList

Grąžina klasifikatorių klasių sąrašą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cls="http://www.sintagma.lt/avilys/ClassifierWS">
   <soapenv:Body>
      <cls:getClassifierClassList/>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
ClassifierClassListResult result = port.getClassifierClassList();
System.out.println("Klasifikatorių klasių sk.: " + result.getClassifierClass().size());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:cls=\"http://www.sintagma.lt/avilys/ClassifierWS\">
   <soapenv:Body>
      <cls:getClassifierClassList/>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/ClassifierWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/ClassifierWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);
$result = $client->getClassifierClassList();

echo "Klasifikatorių klasių sk.: " . count($result->classifierClassList->classifierClass);
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/ClassifierWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: ""' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cls="http://www.sintagma.lt/avilys/ClassifierWS">
   <soapenv:Body>
      <cls:getClassifierClassList/>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getClsEntry

Grąžina vieną klasifikatoriaus įrašą pagal `clsId`.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cls="http://www.sintagma.lt/avilys/ClassifierWS">
   <soapenv:Body>
      <cls:getClsEntry>
         <getClsEntryParam>
            <clsId>CLS-001</clsId>
            <expandChildren>false</expandChildren>
         </getClsEntryParam>
      </cls:getClsEntry>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetClsEntryParam param = new GetClsEntryParam();
param.setClsId("CLS-001");
param.setExpandChildren(false);

ClsEntry result = port.getClsEntry(param);
System.out.println("ID: " + result.getClsid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:cls=\"http://www.sintagma.lt/avilys/ClassifierWS\">
   <soapenv:Body>
      <cls:getClsEntry>
         <getClsEntryParam>
            <clsId>CLS-001</clsId>
            <expandChildren>false</expandChildren>
         </getClsEntryParam>
      </cls:getClsEntry>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/ClassifierWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/ClassifierWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'getClsEntryParam' => [
        'clsId' => 'CLS-001',
        'expandChildren' => false
    ]
];

$result = $client->getClsEntry($param);
echo $result->clsEntry->clsid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/ClassifierWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/ClassifierWS/getClsEntry"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cls="http://www.sintagma.lt/avilys/ClassifierWS">
   <soapenv:Body>
      <cls:getClsEntry>
         <getClsEntryParam>
            <clsId>CLS-001</clsId>
            <expandChildren>false</expandChildren>
         </getClsEntryParam>
      </cls:getClsEntry>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getClsEntryList

Grąžina klasifikatoriaus įrašų sąrašą pagal klasę.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cls="http://www.sintagma.lt/avilys/ClassifierWS">
   <soapenv:Body>
      <cls:getClsEntryList>
         <getClsEntryListParam>
            <className>DocSort</className>
            <expandChildren>false</expandChildren>
            <showDisabled>false</showDisabled>
         </getClsEntryListParam>
      </cls:getClsEntryList>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetClsEntryListParam param = new GetClsEntryListParam();
param.setClassName("DocSort");
param.setExpandChildren(false);
param.setShowDisabled(false);

GetClsEntryListResult result = port.getClsEntryList(param);
System.out.println("Įrašų sk.: " + result.getClassifier().size());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:cls=\"http://www.sintagma.lt/avilys/ClassifierWS\">
   <soapenv:Body>
      <cls:getClsEntryList>
         <getClsEntryListParam>
            <className>DocSort</className>
            <expandChildren>false</expandChildren>
            <showDisabled>false</showDisabled>
         </getClsEntryListParam>
      </cls:getClsEntryList>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/ClassifierWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/ClassifierWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'getClsEntryListParam' => [
        'className' => 'DocSort',
        'expandChildren' => false,
        'showDisabled' => false
    ]
];

$result = $client->getClsEntryList($param);
echo count($result->clsEntryList->classifier) . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/ClassifierWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/ClassifierWS/getClsEntryList"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cls="http://www.sintagma.lt/avilys/ClassifierWS">
   <soapenv:Body>
      <cls:getClsEntryList>
         <getClsEntryListParam>
            <className>DocSort</className>
            <expandChildren>false</expandChildren>
            <showDisabled>false</showDisabled>
         </getClsEntryListParam>
      </cls:getClsEntryList>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija
