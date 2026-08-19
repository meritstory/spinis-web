# Tvirtinimo schemos

- Path: `/api-dok/dbsis-api/api-taikymas/rdodocumentws/tvirtinimo-schemos`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/rdodocumentws/tvirtinimo-schemos
- Index: 81

---

RDODocumentWS tvirtinimo schemų operacijos

### modifyApprovalSchema

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_2220-operacija-modifyapprovalschema)

Modifikuoja dinaminio projekto derinančiųjų sąrašą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:modifyApprovalSchema>
         <modifySchemaParam>
            <docOid>DOC_12345</docOid>
            <executors>
               <orgName>SKYRIUS_001</orgName>
            </executors>
            <sequenceType>parallel</sequenceType>
            <dueDate>2024-12-31T00:00:00</dueDate>
            <notes>Prašau suderinti</notes>
         </modifySchemaParam>
      </rdo:modifyApprovalSchema>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
ModifySchemaParam param = new ModifySchemaParam();
param.setDocOid("DOC_12345");

OrgNodeParam executor = new OrgNodeParam();
executor.setOrgName("SKYRIUS_001");
param.getExecutors().add(executor);

param.setSequenceType("parallel");
param.setNotes("Prašau suderinti");

DocumentInfo result = port.modifyApprovalSchema(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:modifyApprovalSchema>
         <modifySchemaParam>
            <docOid>DOC_12345</docOid>
            <executors>
               <orgName>SKYRIUS_001</orgName>
            </executors>
            <sequenceType>parallel</sequenceType>
            <dueDate>2024-12-31T00:00:00</dueDate>
            <notes>Prašau suderinti</notes>
         </modifySchemaParam>
      </rdo:modifyApprovalSchema>
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
    'modifySchemaParam' => [
        'docOid' => 'DOC_12345',
        'executors' => [
            ['orgName' => 'SKYRIUS_001']
        ],
        'sequenceType' => 'parallel',
        'dueDate' => '2024-12-31T00:00:00',
        'notes' => 'Prašau suderinti'
    ]
];

$result = $client->modifyApprovalSchema($param);
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
      <rdo:modifyApprovalSchema>
         <modifySchemaParam>
            <docOid>DOC_12345</docOid>
            <executors>
               <orgName>SKYRIUS_001</orgName>
            </executors>
            <sequenceType>parallel</sequenceType>
            <dueDate>2024-12-31T00:00:00</dueDate>
            <notes>Prašau suderinti</notes>
         </modifySchemaParam>
      </rdo:modifyApprovalSchema>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### modifySigningSchema

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_2221-operacija-modifysigningschema)

Modifikuoja dinaminio projekto pasirašančiųjų sąrašą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:modifySigningSchema>
         <modifySchemaParam>
            <docOid>DOC_12345</docOid>
            <executors>
               <orgName>DIREKTORIUS_001</orgName>
            </executors>
            <sequenceType>sequential</sequenceType>
            <dueDate>2024-12-31T00:00:00</dueDate>
            <notes>Prašau pasirašyti</notes>
         </modifySchemaParam>
      </rdo:modifySigningSchema>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
ModifySchemaParam param = new ModifySchemaParam();
param.setDocOid("DOC_12345");

OrgNodeParam executor = new OrgNodeParam();
executor.setOrgName("DIREKTORIUS_001");
param.getExecutors().add(executor);

param.setSequenceType("sequential");
param.setNotes("Prašau pasirašyti");

DocumentInfo result = port.modifySigningSchema(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:modifySigningSchema>
         <modifySchemaParam>
            <docOid>DOC_12345</docOid>
            <executors>
               <orgName>DIREKTORIUS_001</orgName>
            </executors>
            <sequenceType>sequential</sequenceType>
            <dueDate>2024-12-31T00:00:00</dueDate>
            <notes>Prašau pasirašyti</notes>
         </modifySchemaParam>
      </rdo:modifySigningSchema>
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
    'modifySchemaParam' => [
        'docOid' => 'DOC_12345',
        'executors' => [
            ['orgName' => 'DIREKTORIUS_001']
        ],
        'sequenceType' => 'sequential',
        'dueDate' => '2024-12-31T00:00:00',
        'notes' => 'Prašau pasirašyti'
    ]
];

$result = $client->modifySigningSchema($param);
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
      <rdo:modifySigningSchema>
         <modifySchemaParam>
            <docOid>DOC_12345</docOid>
            <executors>
               <orgName>DIREKTORIUS_001</orgName>
            </executors>
            <sequenceType>sequential</sequenceType>
            <dueDate>2024-12-31T00:00:00</dueDate>
            <notes>Prašau pasirašyti</notes>
         </modifySchemaParam>
      </rdo:modifySigningSchema>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### modifyReviewalSchema

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_2219-operacija-modifyreviewalschema)

Modifikuoja dinaminio projekto peržiūrinčiųjų sąrašą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:modifyReviewalSchema>
         <modifySchemaParam>
            <docOid>DOC_12345</docOid>
            <executors>
               <orgName>SPECIALISTAS_001</orgName>
            </executors>
            <sequenceType>parallel</sequenceType>
            <dueDate>2024-12-31T00:00:00</dueDate>
            <notes>Prašau peržiūrėti</notes>
         </modifySchemaParam>
      </rdo:modifyReviewalSchema>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
ModifySchemaParam param = new ModifySchemaParam();
param.setDocOid("DOC_12345");

OrgNodeParam executor = new OrgNodeParam();
executor.setOrgName("SPECIALISTAS_001");
param.getExecutors().add(executor);

param.setSequenceType("parallel");
param.setNotes("Prašau peržiūrėti");

DocumentInfo result = port.modifyReviewalSchema(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:modifyReviewalSchema>
         <modifySchemaParam>
            <docOid>DOC_12345</docOid>
            <executors>
               <orgName>SPECIALISTAS_001</orgName>
            </executors>
            <sequenceType>parallel</sequenceType>
            <dueDate>2024-12-31T00:00:00</dueDate>
            <notes>Prašau peržiūrėti</notes>
         </modifySchemaParam>
      </rdo:modifyReviewalSchema>
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
    'modifySchemaParam' => [
        'docOid' => 'DOC_12345',
        'executors' => [
            ['orgName' => 'SPECIALISTAS_001']
        ],
        'sequenceType' => 'parallel',
        'dueDate' => '2024-12-31T00:00:00',
        'notes' => 'Prašau peržiūrėti'
    ]
];

$result = $client->modifyReviewalSchema($param);
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
      <rdo:modifyReviewalSchema>
         <modifySchemaParam>
            <docOid>DOC_12345</docOid>
            <executors>
               <orgName>SPECIALISTAS_001</orgName>
            </executors>
            <sequenceType>parallel</sequenceType>
            <dueDate>2024-12-31T00:00:00</dueDate>
            <notes>Prašau peržiūrėti</notes>
         </modifySchemaParam>
      </rdo:modifyReviewalSchema>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### modifyConfirmationSchema

Modifikuoja patvirtinimo schemą.

Modifikuoja dinaminio projekto patvirtintojų sąrašą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:modifyConfirmationSchema>
         <modifySchemaParam>
            <docOid>DOC_12345</docOid>
            <executors>
               <orgName>TVIRTINTOJAS_001</orgName>
            </executors>
            <sequenceType>sequential</sequenceType>
            <dueDate>2024-12-31T00:00:00</dueDate>
            <notes>Prašau patvirtinti</notes>
         </modifySchemaParam>
      </rdo:modifyConfirmationSchema>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
ModifySchemaParam param = new ModifySchemaParam();
param.setDocOid("DOC_12345");

OrgNodeParam executor = new OrgNodeParam();
executor.setOrgName("TVIRTINTOJAS_001");
param.getExecutors().add(executor);

param.setSequenceType("sequential");
param.setNotes("Prašau patvirtinti");

DocumentInfo result = port.modifyConfirmationSchema(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:modifyConfirmationSchema>
         <modifySchemaParam>
            <docOid>DOC_12345</docOid>
            <executors>
               <orgName>TVIRTINTOJAS_001</orgName>
            </executors>
            <sequenceType>sequential</sequenceType>
            <dueDate>2024-12-31T00:00:00</dueDate>
            <notes>Prašau patvirtinti</notes>
         </modifySchemaParam>
      </rdo:modifyConfirmationSchema>
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
    'modifySchemaParam' => [
        'docOid' => 'DOC_12345',
        'executors' => [
            ['orgName' => 'TVIRTINTOJAS_001']
        ],
        'sequenceType' => 'sequential',
        'dueDate' => '2024-12-31T00:00:00',
        'notes' => 'Prašau patvirtinti'
    ]
];

$result = $client->modifyConfirmationSchema($param);
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
      <rdo:modifyConfirmationSchema>
         <modifySchemaParam>
            <docOid>DOC_12345</docOid>
            <executors>
               <orgName>TVIRTINTOJAS_001</orgName>
            </executors>
            <sequenceType>sequential</sequenceType>
            <dueDate>2024-12-31T00:00:00</dueDate>
            <notes>Prašau patvirtinti</notes>
         </modifySchemaParam>
      </rdo:modifyConfirmationSchema>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---
