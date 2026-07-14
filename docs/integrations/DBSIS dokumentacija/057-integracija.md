# Integracija

- Path: `/api-dok/dbsis-api/api-taikymas/externalaccessws/integracija`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/externalaccessws/integracija
- Index: 57

---

ExternalAccessWS integracijos operacijos

### checkForExtDocumentChanges

Patikrina, ar pasikeitė dokumentai pagal pateiktus išorinius ID.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:ext="http://www.sintagma.lt/avilys/ExternalAccessWS">
   <soapenv:Body>
      <ext:checkForExtDocumentChanges>
         <checkForExtDocumentChangesParam>
            <extDocId>EXT-001</extDocId>
            <extDocId>EXT-002</extDocId>
         </checkForExtDocumentChangesParam>
      </ext:checkForExtDocumentChanges>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
CheckForExtDocumentChangesParam param = new CheckForExtDocumentChangesParam();
param.getExtDocId().add("EXT-001");
param.getExtDocId().add("EXT-002");

CheckForExtDocumentChangesResult result = port.checkForExtDocumentChanges(param);
System.out.println(result.getExtDocChanges().size());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:ext=\"http://www.sintagma.lt/avilys/ExternalAccessWS\">
   <soapenv:Body>
      <ext:checkForExtDocumentChanges>
         <checkForExtDocumentChangesParam>
            <extDocId>EXT-001</extDocId>
            <extDocId>EXT-002</extDocId>
         </checkForExtDocumentChangesParam>
      </ext:checkForExtDocumentChanges>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/ExternalAccessWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/ExternalAccessWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'checkForExtDocumentChangesParam' => [
        'extDocId' => ['EXT-001', 'EXT-002']
    ]
];

$result = $client->checkForExtDocumentChanges($param);
echo count($result->checkForExtDocumentChangesResult->extDocChanges ?? []) . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/ExternalAccessWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/ExternalAccessWS/checkForExtDocumentChanges"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:ext="http://www.sintagma.lt/avilys/ExternalAccessWS">
   <soapenv:Body>
      <ext:checkForExtDocumentChanges>
         <checkForExtDocumentChangesParam>
            <extDocId>EXT-001</extDocId>
            <extDocId>EXT-002</extDocId>
         </checkForExtDocumentChangesParam>
      </ext:checkForExtDocumentChanges>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### deleteExtDocument

Pašalina išorinį dokumentą pagal prieigos raktą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:ext="http://www.sintagma.lt/avilys/ExternalAccessWS">
   <soapenv:Body>
      <ext:deleteExtDocument>
         <deleteExtDocumentParam>
            <accessToken>ACCESS-TOKEN-001</accessToken>
         </deleteExtDocumentParam>
      </ext:deleteExtDocument>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
DeleteExtDocumentParam param = new DeleteExtDocumentParam();
param.setAccessToken("ACCESS-TOKEN-001");

DeleteExtDocumentResult result = port.deleteExtDocument(param);
System.out.println(result.getResult());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:ext=\"http://www.sintagma.lt/avilys/ExternalAccessWS\">
   <soapenv:Body>
      <ext:deleteExtDocument>
         <deleteExtDocumentParam>
            <accessToken>ACCESS-TOKEN-001</accessToken>
         </deleteExtDocumentParam>
      </ext:deleteExtDocument>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/ExternalAccessWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/ExternalAccessWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'deleteExtDocumentParam' => [
        'accessToken' => 'ACCESS-TOKEN-001'
    ]
];

$result = $client->deleteExtDocument($param);
echo $result->deleteExtDocumentResult->result . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/ExternalAccessWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/ExternalAccessWS/deleteExtDocument"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:ext="http://www.sintagma.lt/avilys/ExternalAccessWS">
   <soapenv:Body>
      <ext:deleteExtDocument>
         <deleteExtDocumentParam>
            <accessToken>ACCESS-TOKEN-001</accessToken>
         </deleteExtDocumentParam>
      </ext:deleteExtDocument>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### renewExtDocumentAccess

Atnaujina prieigos raktą prie dokumento.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:ext="http://www.sintagma.lt/avilys/ExternalAccessWS">
   <soapenv:Body>
      <ext:renewExtDocumentAccess>
         <renewExtDocumentAccessTokenParam>
            <accessToken>ACCESS-TOKEN-001</accessToken>
            <sessionParams>
               <phoneNumber>+37060000000</phoneNumber>
               <officialName>UAB Pavyzdys</officialName>
            </sessionParams>
         </renewExtDocumentAccessTokenParam>
      </ext:renewExtDocumentAccess>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
RenewDocumentAccessParam param = new RenewDocumentAccessParam();
param.setAccessToken("ACCESS-TOKEN-001");

AccessSessionParam sessionParams = new AccessSessionParam();
sessionParams.setPhoneNumber("+37060000000");
sessionParams.setOfficialName("UAB Pavyzdys");
param.setSessionParams(sessionParams);

RenewDocumentAccessTokenResult result = port.renewExtDocumentAccess(param);
System.out.println(result.getAccessToken());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:ext=\"http://www.sintagma.lt/avilys/ExternalAccessWS\">
   <soapenv:Body>
      <ext:renewExtDocumentAccess>
         <renewExtDocumentAccessTokenParam>
            <accessToken>ACCESS-TOKEN-001</accessToken>
            <sessionParams>
               <phoneNumber>+37060000000</phoneNumber>
               <officialName>UAB Pavyzdys</officialName>
            </sessionParams>
         </renewExtDocumentAccessTokenParam>
      </ext:renewExtDocumentAccess>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/ExternalAccessWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/ExternalAccessWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'renewExtDocumentAccessTokenParam' => [
        'accessToken' => 'ACCESS-TOKEN-001',
        'sessionParams' => [
            'phoneNumber' => '+37060000000',
            'officialName' => 'UAB Pavyzdys'
        ]
    ]
];

$result = $client->renewExtDocumentAccess($param);
echo $result->renewExtDocumentAccessResult->accessToken . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/ExternalAccessWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/ExternalAccessWS/renewExtDocumentAccess"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:ext="http://www.sintagma.lt/avilys/ExternalAccessWS">
   <soapenv:Body>
      <ext:renewExtDocumentAccess>
         <renewExtDocumentAccessTokenParam>
            <accessToken>ACCESS-TOKEN-001</accessToken>
            <sessionParams>
               <phoneNumber>+37060000000</phoneNumber>
               <officialName>UAB Pavyzdys</officialName>
            </sessionParams>
         </renewExtDocumentAccessTokenParam>
      </ext:renewExtDocumentAccess>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### createExtDocument

Sukuria dokumentą ir sugeneruoja prieigos raktą išorinei prieigai.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:ext="http://www.sintagma.lt/avilys/ExternalAccessWS">
   <soapenv:Body>
      <ext:createExtDocument>
         <createExtDocumentParam>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Dokumento pavadinimas</value>
               </entry>
               <entry>
                  <key>docDate</key>
                  <value>2024-01-17</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>priority</key>
                  <value>HIGH</value>
               </entry>
            </extraAttributes>
            <bodyAttachment>
               <action>add</action>
               <title>Priedas</title>
               <contentType>application/pdf</contentType>
               <content>BASE64_PDF</content>
            </bodyAttachment>
            <executor>
               <code>123456789</code>
               <name>UAB Pavyzdys</name>
               <email>info@pavyzdys.lt</email>
               <phone>+37060000000</phone>
               <address>Vilniaus g. 1, Vilnius</address>
            </executor>
            <docCategory>Vidinis</docCategory>
            <electroContainer>
               <action>add</action>
               <title>container.asice</title>
               <contentType>application/vnd.etsi.asic-e+zip</contentType>
               <content>BASE64_ASICE</content>
               <eDocumentFormat>ASIC-E</eDocumentFormat>
            </electroContainer>
            <actionName>create</actionName>
            <allowModifyAttachments>true</allowModifyAttachments>
            <sessionParams>
               <phoneNumber>+37060000000</phoneNumber>
               <officialName>UAB Pavyzdys</officialName>
            </sessionParams>
         </createExtDocumentParam>
      </ext:createExtDocument>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
CreateExtDocumentParam param = new CreateExtDocumentParam();

ModifyDocumentParam.DocAttributes docAttributes = new ModifyDocumentParam.DocAttributes();
ModifyDocumentParam.DocAttributes.Entry titleEntry = new ModifyDocumentParam.DocAttributes.Entry();
titleEntry.setKey("title");
titleEntry.setValue("Dokumento pavadinimas");
docAttributes.getEntry().add(titleEntry);
param.setDocAttributes(docAttributes);

ModifyDocumentParam.ExtraAttributes extraAttributes = new ModifyDocumentParam.ExtraAttributes();
ModifyDocumentParam.ExtraAttributes.Entry priorityEntry = new ModifyDocumentParam.ExtraAttributes.Entry();
priorityEntry.setKey("priority");
priorityEntry.setValue("HIGH");
extraAttributes.getEntry().add(priorityEntry);
param.setExtraAttributes(extraAttributes);

AttachmentActionParam bodyAttachment = new AttachmentActionParam();
bodyAttachment.setAction("add");
bodyAttachment.setTitle("Priedas");
bodyAttachment.setContentType("application/pdf");
bodyAttachment.setContent("BASE64_PDF".getBytes());
param.getBodyAttachment().add(bodyAttachment);

OrgContactParam executor = new OrgContactParam();
executor.setCode("123456789");
executor.setName("UAB Pavyzdys");
executor.setEmail("info@pavyzdys.lt");
executor.setPhone("+37060000000");
executor.setAddress("Vilniaus g. 1, Vilnius");
param.setExecutor(executor);

param.setDocCategory("Vidinis");

EDocumentAttachment electroContainer = new EDocumentAttachment();
electroContainer.setAction("add");
electroContainer.setTitle("container.asice");
electroContainer.setContentType("application/vnd.etsi.asic-e+zip");
electroContainer.setContent("BASE64_ASICE".getBytes());
electroContainer.setEDocumentFormat("ASIC-E");
param.setElectroContainer(electroContainer);

param.setActionName("create");
param.setAllowModifyAttachments(true);

AccessSessionParam sessionParams = new AccessSessionParam();
sessionParams.setPhoneNumber("+37060000000");
sessionParams.setOfficialName("UAB Pavyzdys");
param.setSessionParams(sessionParams);

ExtDocumentInfo result = port.createExtDocument(param);
System.out.println(result.getAccessToken());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:ext=\"http://www.sintagma.lt/avilys/ExternalAccessWS\">
   <soapenv:Body>
      <ext:createExtDocument>
         <createExtDocumentParam>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Dokumento pavadinimas</value>
               </entry>
               <entry>
                  <key>docDate</key>
                  <value>2024-01-17</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>priority</key>
                  <value>HIGH</value>
               </entry>
            </extraAttributes>
            <bodyAttachment>
               <action>add</action>
               <title>Priedas</title>
               <contentType>application/pdf</contentType>
               <content>BASE64_PDF</content>
            </bodyAttachment>
            <executor>
               <code>123456789</code>
               <name>UAB Pavyzdys</name>
               <email>info@pavyzdys.lt</email>
               <phone>+37060000000</phone>
               <address>Vilniaus g. 1, Vilnius</address>
            </executor>
            <docCategory>Vidinis</docCategory>
            <electroContainer>
               <action>add</action>
               <title>container.asice</title>
               <contentType>application/vnd.etsi.asic-e+zip</contentType>
               <content>BASE64_ASICE</content>
               <eDocumentFormat>ASIC-E</eDocumentFormat>
            </electroContainer>
            <actionName>create</actionName>
            <allowModifyAttachments>true</allowModifyAttachments>
            <sessionParams>
               <phoneNumber>+37060000000</phoneNumber>
               <officialName>UAB Pavyzdys</officialName>
            </sessionParams>
         </createExtDocumentParam>
      </ext:createExtDocument>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/ExternalAccessWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/ExternalAccessWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'createExtDocumentParam' => [
        'docAttributes' => [
            'entry' => [
                ['key' => 'title', 'value' => 'Dokumento pavadinimas'],
                ['key' => 'docDate', 'value' => '2024-01-17']
            ]
        ],
        'extraAttributes' => [
            'entry' => [
                ['key' => 'priority', 'value' => 'HIGH']
            ]
        ],
        'bodyAttachment' => [
            'action' => 'add',
            'title' => 'Priedas',
            'contentType' => 'application/pdf',
            'content' => 'BASE64_PDF'
        ],
        'executor' => [
            'code' => '123456789',
            'name' => 'UAB Pavyzdys',
            'email' => 'info@pavyzdys.lt',
            'phone' => '+37060000000',
            'address' => 'Vilniaus g. 1, Vilnius'
        ],
        'docCategory' => 'Vidinis',
        'electroContainer' => [
            'action' => 'add',
            'title' => 'container.asice',
            'contentType' => 'application/vnd.etsi.asic-e+zip',
            'content' => 'BASE64_ASICE',
            'eDocumentFormat' => 'ASIC-E'
        ],
        'actionName' => 'create',
        'allowModifyAttachments' => true,
        'sessionParams' => [
            'phoneNumber' => '+37060000000',
            'officialName' => 'UAB Pavyzdys'
        ]
    ]
];

$result = $client->createExtDocument($param);
echo $result->extDocumentInfo->accessToken . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/ExternalAccessWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/ExternalAccessWS/createExtDocument"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:ext="http://www.sintagma.lt/avilys/ExternalAccessWS">
   <soapenv:Body>
      <ext:createExtDocument>
         <createExtDocumentParam>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Dokumento pavadinimas</value>
               </entry>
               <entry>
                  <key>docDate</key>
                  <value>2024-01-17</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>priority</key>
                  <value>HIGH</value>
               </entry>
            </extraAttributes>
            <bodyAttachment>
               <action>add</action>
               <title>Priedas</title>
               <contentType>application/pdf</contentType>
               <content>BASE64_PDF</content>
            </bodyAttachment>
            <executor>
               <code>123456789</code>
               <name>UAB Pavyzdys</name>
               <email>info@pavyzdys.lt</email>
               <phone>+37060000000</phone>
               <address>Vilniaus g. 1, Vilnius</address>
            </executor>
            <docCategory>Vidinis</docCategory>
            <electroContainer>
               <action>add</action>
               <title>container.asice</title>
               <contentType>application/vnd.etsi.asic-e+zip</contentType>
               <content>BASE64_ASICE</content>
               <eDocumentFormat>ASIC-E</eDocumentFormat>
            </electroContainer>
            <actionName>create</actionName>
            <allowModifyAttachments>true</allowModifyAttachments>
            <sessionParams>
               <phoneNumber>+37060000000</phoneNumber>
               <officialName>UAB Pavyzdys</officialName>
            </sessionParams>
         </createExtDocumentParam>
      </ext:createExtDocument>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija
