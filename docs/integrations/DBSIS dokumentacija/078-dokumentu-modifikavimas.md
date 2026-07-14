# Dokumentų modifikavimas

- Path: `/api-dok/dbsis-api/api-taikymas/rdodocumentws/dokumentu-modifikavimas`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/rdodocumentws/dokumentu-modifikavimas
- Index: 78

---

RDODocumentWS dokumentų modifikavimo operacijos

### modifyDocument

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_30-operacijos-modifydocument-parametrai-aprasymas)

Modifikuoja dokumento atributus ir priedus.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:modifyDocument>
         <modifyDocumentParam>
            <docOid>DOC_12345</docOid>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Atnaujintas pavadinimas</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>note</key>
                  <value>Papildoma pastaba</value>
               </entry>
            </extraAttributes>
            <bodyAttachment>
               <action>add</action>
               <fileName>priedas.pdf</fileName>
               <content>BASE64_ENCODED_CONTENT</content>
               <mimeType>application/pdf</mimeType>
               <title>Priedas</title>
            </bodyAttachment>
         </modifyDocumentParam>
      </rdo:modifyDocument>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
ModifyDocumentParam param = new ModifyDocumentParam();
param.setDocOid("DOC_12345");

Map<String, Object> docAttributes = new HashMap<>();
docAttributes.put("title", "Atnaujintas pavadinimas");
param.setDocAttributes(docAttributes);

Map<String, Object> extraAttributes = new HashMap<>();
extraAttributes.put("note", "Papildoma pastaba");
param.setExtraAttributes(extraAttributes);

AttachmentActionParam attachment = new AttachmentActionParam();
attachment.setAction("add");
attachment.setFileName("priedas.pdf");
attachment.setMimeType("application/pdf");
attachment.setTitle("Priedas");
attachment.setContent(Base64.getDecoder().decode("BASE64_ENCODED_CONTENT"));
param.getBodyAttachment().add(attachment);

DocumentInfo result = port.modifyDocument(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:modifyDocument>
         <modifyDocumentParam>
            <docOid>DOC_12345</docOid>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Atnaujintas pavadinimas</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>note</key>
                  <value>Papildoma pastaba</value>
               </entry>
            </extraAttributes>
            <bodyAttachment>
               <action>add</action>
               <fileName>priedas.pdf</fileName>
               <content>BASE64_ENCODED_CONTENT</content>
               <mimeType>application/pdf</mimeType>
               <title>Priedas</title>
            </bodyAttachment>
         </modifyDocumentParam>
      </rdo:modifyDocument>
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
    'modifyDocumentParam' => [
        'docOid' => 'DOC_12345',
        'docAttributes' => [
            'entry' => [
                ['key' => 'title', 'value' => 'Atnaujintas pavadinimas']
            ]
        ],
        'extraAttributes' => [
            'entry' => [
                ['key' => 'note', 'value' => 'Papildoma pastaba']
            ]
        ],
        'bodyAttachment' => [
            [
                'action' => 'add',
                'fileName' => 'priedas.pdf',
                'mimeType' => 'application/pdf',
                'title' => 'Priedas',
                'content' => 'BASE64_ENCODED_CONTENT'
            ]
        ]
    ]
];

$result = $client->modifyDocument($param);
echo "Dokumento OID: " . $result->documentInfo->oid;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: ""' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:modifyDocument>
         <modifyDocumentParam>
            <docOid>DOC_12345</docOid>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Atnaujintas pavadinimas</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>note</key>
                  <value>Papildoma pastaba</value>
               </entry>
            </extraAttributes>
            <bodyAttachment>
               <action>add</action>
               <fileName>priedas.pdf</fileName>
               <content>BASE64_ENCODED_CONTENT</content>
               <mimeType>application/pdf</mimeType>
               <title>Priedas</title>
            </bodyAttachment>
         </modifyDocumentParam>
      </rdo:modifyDocument>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### modifyDocumentInVersion

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_32-operacija-modifydocumentinversion)

Modifikuoja dokumentą versijos kontekste.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:modifyDocumentInVersion>
         <modifyDocumentInVersionParam>
            <docOid>DOC_12345</docOid>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Naujas pavadinimas</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>note</key>
                  <value>Papildoma pastaba</value>
               </entry>
            </extraAttributes>
         </modifyDocumentInVersionParam>
      </rdo:modifyDocumentInVersion>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
ModifyDocumentInVersionParam param = new ModifyDocumentInVersionParam();
param.setDocOid("DOC_12345");

Map<String, Object> docAttributes = new HashMap<>();
docAttributes.put("title", "Naujas pavadinimas");
param.setDocAttributes(docAttributes);

Map<String, Object> extraAttributes = new HashMap<>();
extraAttributes.put("note", "Papildoma pastaba");
param.setExtraAttributes(extraAttributes);

DocumentInfo result = port.modifyDocumentInVersion(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:modifyDocumentInVersion>
         <modifyDocumentInVersionParam>
            <docOid>DOC_12345</docOid>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Naujas pavadinimas</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>note</key>
                  <value>Papildoma pastaba</value>
               </entry>
            </extraAttributes>
         </modifyDocumentInVersionParam>
      </rdo:modifyDocumentInVersion>
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
    'modifyDocumentInVersionParam' => [
        'docOid' => 'DOC_12345',
        'docAttributes' => [
            'entry' => [
                ['key' => 'title', 'value' => 'Naujas pavadinimas']
            ]
        ],
        'extraAttributes' => [
            'entry' => [
                ['key' => 'note', 'value' => 'Papildoma pastaba']
            ]
        ]
    ]
];

$result = $client->modifyDocumentInVersion($param);
echo "Dokumento OID: " . $result->documentInfo->oid;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: ""' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:modifyDocumentInVersion>
         <modifyDocumentInVersionParam>
            <docOid>DOC_12345</docOid>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Naujas pavadinimas</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>note</key>
                  <value>Papildoma pastaba</value>
               </entry>
            </extraAttributes>
         </modifyDocumentInVersionParam>
      </rdo:modifyDocumentInVersion>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### modifyDocumentOfficeCases

Modifikuoja dokumento bylas.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:modifyDocumentOfficeCases>
         <modifyDocumentOfficeCasesParam>
            <docOid>DOC_12345</docOid>
            <docOfficeCases>
               <officeCases>
                  <oid>CASE_001</oid>
               </officeCases>
            </docOfficeCases>
            <docOfficeCaseAction>ADD</docOfficeCaseAction>
         </modifyDocumentOfficeCasesParam>
      </rdo:modifyDocumentOfficeCases>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
ModifyDocumentOfficeCasesParam param = new ModifyDocumentOfficeCasesParam();
param.setDocOid("DOC_12345");

OfficeCaseParam officeCase = new OfficeCaseParam();
officeCase.setOid("CASE_001");

OfficeCaseListParam officeCases = new OfficeCaseListParam();
officeCases.getOfficeCases().add(officeCase);
param.setDocOfficeCases(officeCases);

param.setDocOfficeCaseAction(DocOfficeCasesActionType.ADD);

DocumentInfo result = port.modifyDocumentOfficeCases(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:modifyDocumentOfficeCases>
         <modifyDocumentOfficeCasesParam>
            <docOid>DOC_12345</docOid>
            <docOfficeCases>
               <officeCases>
                  <oid>CASE_001</oid>
               </officeCases>
            </docOfficeCases>
            <docOfficeCaseAction>ADD</docOfficeCaseAction>
         </modifyDocumentOfficeCasesParam>
      </rdo:modifyDocumentOfficeCases>
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
    'modifyDocumentOfficeCasesParam' => [
        'docOid' => 'DOC_12345',
        'docOfficeCases' => [
            'officeCases' => [
                ['oid' => 'CASE_001']
            ]
        ],
        'docOfficeCaseAction' => 'ADD'
    ]
];

$result = $client->modifyDocumentOfficeCases($param);
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
      <rdo:modifyDocumentOfficeCases>
         <modifyDocumentOfficeCasesParam>
            <docOid>DOC_12345</docOid>
            <docOfficeCases>
               <officeCases>
                  <oid>CASE_001</oid>
               </officeCases>
            </docOfficeCases>
            <docOfficeCaseAction>ADD</docOfficeCaseAction>
         </modifyDocumentOfficeCasesParam>
      </rdo:modifyDocumentOfficeCases>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### modifyRegisterTarget

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_2224-operacija-modifyregistertarget)

Modifikuoja dokumento registravimo tikslą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:modifyRegisterTarget>
         <modifyRegisterTargetParam>
            <docOid>DOC_12345</docOid>
            <registerTarget>
               <orgNodeCode>ORG_001</orgNodeCode>
            </registerTarget>
         </modifyRegisterTargetParam>
      </rdo:modifyRegisterTarget>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
ModifyRegisterTargetParam param = new ModifyRegisterTargetParam();
param.setDocOid("DOC_12345");

OrgNodeParam registerTarget = new OrgNodeParam();
registerTarget.setOrgNodeCode("ORG_001");
param.setRegisterTarget(registerTarget);

DocumentInfo result = port.modifyRegisterTarget(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:modifyRegisterTarget>
         <modifyRegisterTargetParam>
            <docOid>DOC_12345</docOid>
            <registerTarget>
               <orgNodeCode>ORG_001</orgNodeCode>
            </registerTarget>
         </modifyRegisterTargetParam>
      </rdo:modifyRegisterTarget>
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
    'modifyRegisterTargetParam' => [
        'docOid' => 'DOC_12345',
        'registerTarget' => [
            'orgNodeCode' => 'ORG_001'
        ]
    ]
];

$result = $client->modifyRegisterTarget($param);
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
      <rdo:modifyRegisterTarget>
         <modifyRegisterTargetParam>
            <docOid>DOC_12345</docOid>
            <registerTarget>
               <orgNodeCode>ORG_001</orgNodeCode>
            </registerTarget>
         </modifyRegisterTargetParam>
      </rdo:modifyRegisterTarget>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---
