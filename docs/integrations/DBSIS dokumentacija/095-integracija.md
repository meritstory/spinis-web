# Integracija

- Path: `/api-dok/dbsis-api/api-taikymas/templatews/integracija`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/templatews/integracija
- Index: 95

---

TemplateWS integracijos operacijos

### getTemplateList

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/sablonu-pateikimo-sasaja#_272-operacija-gettemplatelist)

Grąžina šablonų sąrašą pagal filtrus.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:tpl="http://www.sintagma.lt/avilys/TemplateWS">
   <soapenv:Body>
      <tpl:getTemplateList>
         <getTemplateListParam>
            <templateUsage>COMMON</templateUsage>
            <name>Šablonas</name>
            <accessType>admin</accessType>
            <maxResults>10</maxResults>
         </getTemplateListParam>
      </tpl:getTemplateList>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetTemplateListWParam param = new GetTemplateListWParam();
param.setTemplateUsage("COMMON");
param.setName("Šablonas");
param.setAccessType("admin");
param.setMaxResults(10);

GetTemplateListResultBean result = port.getTemplateList(param);
System.out.println(result.getTemplates().size());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:tpl=\"http://www.sintagma.lt/avilys/TemplateWS\">
   <soapenv:Body>
      <tpl:getTemplateList>
         <getTemplateListParam>
            <templateUsage>COMMON</templateUsage>
            <name>Šablonas</name>
            <accessType>admin</accessType>
            <maxResults>10</maxResults>
         </getTemplateListParam>
      </tpl:getTemplateList>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/TemplateWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/TemplateWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'getTemplateListParam' => [
        'templateUsage' => 'COMMON',
        'name' => 'Šablonas',
        'accessType' => 'admin',
        'maxResults' => 10
    ]
];

$result = $client->getTemplateList($param);
foreach ($result->templateList->templates ?? [] as $template) {
    echo $template->oid . PHP_EOL;
}
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/TemplateWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/TemplateWS/getTemplateList"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:tpl="http://www.sintagma.lt/avilys/TemplateWS">
   <soapenv:Body>
      <tpl:getTemplateList>
         <getTemplateListParam>
            <templateUsage>COMMON</templateUsage>
            <name>Šablonas</name>
            <accessType>admin</accessType>
            <maxResults>10</maxResults>
         </getTemplateListParam>
      </tpl:getTemplateList>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getTemplate

Grąžina vieno šablono informaciją pagal OID.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:tpl="http://www.sintagma.lt/avilys/TemplateWS">
   <soapenv:Body>
      <tpl:getTemplate>
         <getTemplateParam>
            <docOid>TPL-001</docOid>
         </getTemplateParam>
      </tpl:getTemplate>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetTemplateParam param = new GetTemplateParam();
param.setDocOid("TPL-001");

GetTemplateResultBean result = port.getTemplate(param);
System.out.println(result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:tpl=\"http://www.sintagma.lt/avilys/TemplateWS\">
   <soapenv:Body>
      <tpl:getTemplate>
         <getTemplateParam>
            <docOid>TPL-001</docOid>
         </getTemplateParam>
      </tpl:getTemplate>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/TemplateWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/TemplateWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'getTemplateParam' => [
        'docOid' => 'TPL-001'
    ]
];

$result = $client->getTemplate($param);
echo $result->templateResult->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/TemplateWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/TemplateWS/getTemplate"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:tpl="http://www.sintagma.lt/avilys/TemplateWS">
   <soapenv:Body>
      <tpl:getTemplate>
         <getTemplateParam>
            <docOid>TPL-001</docOid>
         </getTemplateParam>
      </tpl:getTemplate>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija
