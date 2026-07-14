# Integracija

- Path: `/api-dok/dbsis-api/api-taikymas/ododocumentws/integracija`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/ododocumentws/integracija
- Index: 65

---

ODODocumentWS integracijos operacijos

### createDocumentFromTemplate

Sukuria ODO dokumentą pagal šabloną.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:odo="http://www.sintagma.lt/avilys/ODODocumentWS">
   <soapenv:Body>
      <odo:createDocumentFromTemplate>
         <odoDocumentFromTemplateParam>
            <templateParam>
               <oid>TEMPLATE-001</oid>
            </templateParam>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>ODO dokumentas</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>note</key>
                  <value>Papildoma informacija</value>
               </entry>
            </extraAttributes>
            <targetStaff>
               <orgName>PADALINYS_001</orgName>
            </targetStaff>
         </odoDocumentFromTemplateParam>
      </odo:createDocumentFromTemplate>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
ODODocumentFromTemplateParam param = new ODODocumentFromTemplateParam();

TemplateParam templateParam = new TemplateParam();
templateParam.setOid("TEMPLATE-001");
param.setTemplateParam(templateParam);

Map<String, Object> docAttributes = new HashMap<>();
docAttributes.put("title", "ODO dokumentas");
param.setDocAttributes(docAttributes);

Map<String, Object> extraAttributes = new HashMap<>();
extraAttributes.put("note", "Papildoma informacija");
param.setExtraAttributes(extraAttributes);

OrgNodeParam targetStaff = new OrgNodeParam();
targetStaff.setOrgName("PADALINYS_001");
param.setTargetStaff(targetStaff);

ODODocumentInfo result = port.createDocumentFromTemplate(param);
System.out.println(result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:odo=\"http://www.sintagma.lt/avilys/ODODocumentWS\">
   <soapenv:Body>
      <odo:createDocumentFromTemplate>
         <odoDocumentFromTemplateParam>
            <templateParam>
               <oid>TEMPLATE-001</oid>
            </templateParam>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>ODO dokumentas</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>note</key>
                  <value>Papildoma informacija</value>
               </entry>
            </extraAttributes>
            <targetStaff>
               <orgName>PADALINYS_001</orgName>
            </targetStaff>
         </odoDocumentFromTemplateParam>
      </odo:createDocumentFromTemplate>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/ODODocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/ODODocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'odoDocumentFromTemplateParam' => [
        'templateParam' => [
            'oid' => 'TEMPLATE-001'
        ],
        'docAttributes' => [
            'entry' => [
                ['key' => 'title', 'value' => 'ODO dokumentas']
            ]
        ],
        'extraAttributes' => [
            'entry' => [
                ['key' => 'note', 'value' => 'Papildoma informacija']
            ]
        ],
        'targetStaff' => [
            'orgName' => 'PADALINYS_001'
        ]
    ]
];

$result = $client->createDocumentFromTemplate($param);
echo $result->documentInfo->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/ODODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/ODODocumentWS/createDocumentFromTemplate"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:odo="http://www.sintagma.lt/avilys/ODODocumentWS">
   <soapenv:Body>
      <odo:createDocumentFromTemplate>
         <odoDocumentFromTemplateParam>
            <templateParam>
               <oid>TEMPLATE-001</oid>
            </templateParam>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>ODO dokumentas</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>note</key>
                  <value>Papildoma informacija</value>
               </entry>
            </extraAttributes>
            <targetStaff>
               <orgName>PADALINYS_001</orgName>
            </targetStaff>
         </odoDocumentFromTemplateParam>
      </odo:createDocumentFromTemplate>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### modifyDocument

Atnaujina ODO dokumento atributus.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:odo="http://www.sintagma.lt/avilys/ODODocumentWS">
   <soapenv:Body>
      <odo:modifyDocument>
         <modifyODODocumentParam>
            <docOid>ODO-2024-0001</docOid>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Atnaujintas ODO dokumentas</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>note</key>
                  <value>Atnaujinta</value>
               </entry>
            </extraAttributes>
            <targetStaff>
               <orgName>PADALINYS_001</orgName>
            </targetStaff>
         </modifyODODocumentParam>
      </odo:modifyDocument>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
ModifyODODocumentParam param = new ModifyODODocumentParam();
param.setDocOid("ODO-2024-0001");

Map<String, Object> docAttributes = new HashMap<>();
docAttributes.put("title", "Atnaujintas ODO dokumentas");
param.setDocAttributes(docAttributes);

Map<String, Object> extraAttributes = new HashMap<>();
extraAttributes.put("note", "Atnaujinta");
param.setExtraAttributes(extraAttributes);

OrgNodeParam targetStaff = new OrgNodeParam();
targetStaff.setOrgName("PADALINYS_001");
param.setTargetStaff(targetStaff);

ODODocumentInfo result = port.modifyDocument(param);
System.out.println(result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:odo=\"http://www.sintagma.lt/avilys/ODODocumentWS\">
   <soapenv:Body>
      <odo:modifyDocument>
         <modifyODODocumentParam>
            <docOid>ODO-2024-0001</docOid>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Atnaujintas ODO dokumentas</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>note</key>
                  <value>Atnaujinta</value>
               </entry>
            </extraAttributes>
            <targetStaff>
               <orgName>PADALINYS_001</orgName>
            </targetStaff>
         </modifyODODocumentParam>
      </odo:modifyDocument>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/ODODocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/ODODocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'modifyODODocumentParam' => [
        'docOid' => 'ODO-2024-0001',
        'docAttributes' => [
            'entry' => [
                ['key' => 'title', 'value' => 'Atnaujintas ODO dokumentas']
            ]
        ],
        'extraAttributes' => [
            'entry' => [
                ['key' => 'note', 'value' => 'Atnaujinta']
            ]
        ],
        'targetStaff' => [
            'orgName' => 'PADALINYS_001'
        ]
    ]
];

$result = $client->modifyDocument($param);
echo $result->documentInfo->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/ODODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/ODODocumentWS/modifyDocument"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:odo="http://www.sintagma.lt/avilys/ODODocumentWS">
   <soapenv:Body>
      <odo:modifyDocument>
         <modifyODODocumentParam>
            <docOid>ODO-2024-0001</docOid>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Atnaujintas ODO dokumentas</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>note</key>
                  <value>Atnaujinta</value>
               </entry>
            </extraAttributes>
            <targetStaff>
               <orgName>PADALINYS_001</orgName>
            </targetStaff>
         </modifyODODocumentParam>
      </odo:modifyDocument>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija
