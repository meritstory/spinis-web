# Dokumentų modifikavimas

- Path: `/api-dok/dbsis-api/api-taikymas/cdodocumentws/dokumentu-modifikavimas`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/cdodocumentws/dokumentu-modifikavimas
- Index: 26

---

CDODocumentWS dokumentų modifikavimo operacijos

### modifyDocumentInVersion

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/sutarciu-sasaja#_21412-operacija-modifydocumentinversion)

Modifikuoja dokumentą versijos kontekste.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cdo="http://www.sintagma.lt/avilys/CDODocumentWS">
   <soapenv:Body>
      <cdo:modifyDocumentInVersion>
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
      </cdo:modifyDocumentInVersion>
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
                  xmlns:cdo=""http://www.sintagma.lt/avilys/CDODocumentWS"">
   <soapenv:Body>
      <cdo:modifyDocumentInVersion>
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
      </cdo:modifyDocumentInVersion>
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
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/CDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: ""' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cdo="http://www.sintagma.lt/avilys/CDODocumentWS">
   <soapenv:Body>
      <cdo:modifyDocumentInVersion>
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
      </cdo:modifyDocumentInVersion>
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
                  xmlns:cdo="http://www.sintagma.lt/avilys/CDODocumentWS">
   <soapenv:Body>
      <cdo:modifyDocumentOfficeCases>
         <modifyDocumentOfficeCasesParam>
            <docOid>DOC_12345</docOid>
            <docOfficeCases>
               <officeCases>
                  <oid>CASE_001</oid>
               </officeCases>
            </docOfficeCases>
            <docOfficeCaseAction>ADD</docOfficeCaseAction>
         </modifyDocumentOfficeCasesParam>
      </cdo:modifyDocumentOfficeCases>
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
                  xmlns:cdo=""http://www.sintagma.lt/avilys/CDODocumentWS"">
   <soapenv:Body>
      <cdo:modifyDocumentOfficeCases>
         <modifyDocumentOfficeCasesParam>
            <docOid>DOC_12345</docOid>
            <docOfficeCases>
               <officeCases>
                  <oid>CASE_001</oid>
               </officeCases>
            </docOfficeCases>
            <docOfficeCaseAction>ADD</docOfficeCaseAction>
         </modifyDocumentOfficeCasesParam>
      </cdo:modifyDocumentOfficeCases>
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
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/CDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: \"\"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cdo="http://www.sintagma.lt/avilys/CDODocumentWS">
   <soapenv:Body>
      <cdo:modifyDocumentOfficeCases>
         <modifyDocumentOfficeCasesParam>
            <docOid>DOC_12345</docOid>
            <docOfficeCases>
               <officeCases>
                  <oid>CASE_001</oid>
               </officeCases>
            </docOfficeCases>
            <docOfficeCaseAction>ADD</docOfficeCaseAction>
         </modifyDocumentOfficeCasesParam>
      </cdo:modifyDocumentOfficeCases>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### modifyRegisterTarget

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/sutarciu-sasaja#_2149-operacija-modifyregistertarget)

Modifikuoja dokumento registravimo tikslą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cdo="http://www.sintagma.lt/avilys/CDODocumentWS">
   <soapenv:Body>
      <cdo:modifyRegisterTarget>
         <modifyRegisterTargetParam>
            <docOid>DOC_12345</docOid>
            <registerTarget>
               <orgNodeCode>ORG_001</orgNodeCode>
            </registerTarget>
         </modifyRegisterTargetParam>
      </cdo:modifyRegisterTarget>
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
                  xmlns:cdo=""http://www.sintagma.lt/avilys/CDODocumentWS"">
   <soapenv:Body>
      <cdo:modifyRegisterTarget>
         <modifyRegisterTargetParam>
            <docOid>DOC_12345</docOid>
            <registerTarget>
               <orgNodeCode>ORG_001</orgNodeCode>
            </registerTarget>
         </modifyRegisterTargetParam>
      </cdo:modifyRegisterTarget>
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
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/CDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: \"\"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cdo="http://www.sintagma.lt/avilys/CDODocumentWS">
   <soapenv:Body>
      <cdo:modifyRegisterTarget>
         <modifyRegisterTargetParam>
            <docOid>DOC_12345</docOid>
            <registerTarget>
               <orgNodeCode>ORG_001</orgNodeCode>
            </registerTarget>
         </modifyRegisterTargetParam>
      </cdo:modifyRegisterTarget>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### modifyAcquaintees

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/sutarciu-sasaja#_2148-operacija-modifyacquaintees)

Modifikuoja susipažįstančiųjų sąrašą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cdo="http://www.sintagma.lt/avilys/CDODocumentWS">
   <soapenv:Body>
      <cdo:modifyAcquaintees>
         <modifyAcquinteesParam>
            <docOid>DOC_12345</docOid>
            <acquaintees>
               <orgName>DARBUOTOJAS_002</orgName>
            </acquaintees>
            <notes>Atnaujintas sąrašas</notes>
         </modifyAcquinteesParam>
      </cdo:modifyAcquaintees>
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
                  xmlns:cdo=""http://www.sintagma.lt/avilys/CDODocumentWS"">
   <soapenv:Body>
      <cdo:modifyAcquaintees>
         <modifyAcquinteesParam>
            <docOid>DOC_12345</docOid>
            <acquaintees>
               <orgName>DARBUOTOJAS_002</orgName>
            </acquaintees>
            <notes>Atnaujintas sąrašas</notes>
         </modifyAcquinteesParam>
      </cdo:modifyAcquaintees>
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
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/CDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: \"\"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cdo="http://www.sintagma.lt/avilys/CDODocumentWS">
   <soapenv:Body>
      <cdo:modifyAcquaintees>
         <modifyAcquinteesParam>
            <docOid>DOC_12345</docOid>
            <acquaintees>
               <orgName>DARBUOTOJAS_002</orgName>
            </acquaintees>
            <notes>Atnaujintas sąrašas</notes>
         </modifyAcquinteesParam>
      </cdo:modifyAcquaintees>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---
