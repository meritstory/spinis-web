# Dokumentų kūrimas

- Path: `/api-dok/dbsis-api/api-taikymas/cdodocumentws/dokumentu-kurimas`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/cdodocumentws/dokumentu-kurimas
- Index: 24

---

CDODocumentWS dokumentų kūrimo operacijos

### createDocumentFromTemplate

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/sutarciu-sasaja#_2143-operacija-createdocumentfromtemplate)

Sukuria dokumentą pagal nurodytą šabloną.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cdo="http://www.sintagma.lt/avilys/CDODocumentWS">
   <soapenv:Body>
      <cdo:createDocumentFromTemplate>
         <CDODocumentFromTemplateParam>
            <templateParam>
               <oid>TEMPLATE_OID_001</oid>
            </templateParam>
            <register>true</register>
            <project>false</project>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Dokumento pavadinimas</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>language</key>
                  <value>lt</value>
               </entry>
            </extraAttributes>
         </CDODocumentFromTemplateParam>
      </cdo:createDocumentFromTemplate>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
CDODocumentFromTemplateParam param = new CDODocumentFromTemplateParam();

TemplateParam templateParam = new TemplateParam();
templateParam.setOid("TEMPLATE_OID_001");
param.setTemplateParam(templateParam);

param.setRegister(true);
param.setProject(false);

Map<String, String> docAttributes = new HashMap<>();
docAttributes.put("title", "Dokumento pavadinimas");
param.setDocAttributes(docAttributes);

Map<String, String> extraAttributes = new HashMap<>();
extraAttributes.put("language", "lt");
param.setExtraAttributes(extraAttributes);

DocumentInfo result = port.createDocumentFromTemplate(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:cdo=""http://www.sintagma.lt/avilys/CDODocumentWS"">
   <soapenv:Body>
      <cdo:createDocumentFromTemplate>
         <CDODocumentFromTemplateParam>
            <templateParam>
               <oid>TEMPLATE_OID_001</oid>
            </templateParam>
            <register>true</register>
            <project>false</project>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Dokumento pavadinimas</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>language</key>
                  <value>lt</value>
               </entry>
            </extraAttributes>
         </CDODocumentFromTemplateParam>
      </cdo:createDocumentFromTemplate>
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
    'CDODocumentFromTemplateParam' => [
        'templateParam' => [
            'oid' => 'TEMPLATE_OID_001'
        ],
        'register' => true,
        'project' => false,
        'docAttributes' => [
            'entry' => [
                ['key' => 'title', 'value' => 'Dokumento pavadinimas']
            ]
        ],
        'extraAttributes' => [
            'entry' => [
                ['key' => 'language', 'value' => 'lt']
            ]
        ]
    ]
];

$result = $client->createDocumentFromTemplate($param);
echo "Dokumento OID: " . $result->documentInfo->oid;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/CDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: ""' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cdo="http://www.sintagma.lt/avilys/CDODocumentWS">
   <soapenv:Body>
      <cdo:createDocumentFromTemplate>
         <CDODocumentFromTemplateParam>
            <templateParam>
               <oid>TEMPLATE_OID_001</oid>
            </templateParam>
            <register>true</register>
            <project>false</project>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Dokumento pavadinimas</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>language</key>
                  <value>lt</value>
               </entry>
            </extraAttributes>
         </CDODocumentFromTemplateParam>
      </cdo:createDocumentFromTemplate>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---
