# Užklausų priėmimas

- Path: `/api-dok/dbsis-api/api-taikymas/rdodocumentws/uzklausu-priemimas`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/rdodocumentws/uzklausu-priemimas
- Index: 82

---

RDODocumentWS užklausų priėmimo operacijos

### receiveApprovalRequest

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_2233-operacija-receiveapprovalrequest)

Priima tvirtinimo užklausą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:receiveApprovalRequest>
         <receiveApprovalRequestParam>
            <templateParam>
               <templateNo>APPROVAL_TEMPLATE</templateNo>
            </templateParam>
            <linkToDocument>DOC_ORIGINAL_001</linkToDocument>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Tvirtinimo užklausa</value>
               </entry>
            </docAttributes>
         </receiveApprovalRequestParam>
      </rdo:receiveApprovalRequest>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
ReceiveRequestParam param = new ReceiveRequestParam();

TemplateParam templateParam = new TemplateParam();
templateParam.setTemplateNo("APPROVAL_TEMPLATE");
param.setTemplateParam(templateParam);

param.setLinkToDocument("DOC_ORIGINAL_001");

Map<String, Object> docAttributes = new HashMap<>();
docAttributes.put("title", "Tvirtinimo užklausa");
param.setDocAttributes(docAttributes);

DocumentInfo result = port.receiveApprovalRequest(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:receiveApprovalRequest>
         <receiveApprovalRequestParam>
            <templateParam>
               <templateNo>APPROVAL_TEMPLATE</templateNo>
            </templateParam>
            <linkToDocument>DOC_ORIGINAL_001</linkToDocument>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Tvirtinimo užklausa</value>
               </entry>
            </docAttributes>
         </receiveApprovalRequestParam>
      </rdo:receiveApprovalRequest>
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
    'receiveApprovalRequestParam' => [
        'templateParam' => [
            'templateNo' => 'APPROVAL_TEMPLATE'
        ],
        'linkToDocument' => 'DOC_ORIGINAL_001',
        'docAttributes' => [
            'entry' => [
                ['key' => 'title', 'value' => 'Tvirtinimo užklausa']
            ]
        ]
    ]
];

$result = $client->receiveApprovalRequest($param);
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
      <rdo:receiveApprovalRequest>
         <receiveApprovalRequestParam>
            <templateParam>
               <templateNo>APPROVAL_TEMPLATE</templateNo>
            </templateParam>
            <linkToDocument>DOC_ORIGINAL_001</linkToDocument>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Tvirtinimo užklausa</value>
               </entry>
            </docAttributes>
         </receiveApprovalRequestParam>
      </rdo:receiveApprovalRequest>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### receiveSigningRequest

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_2234-operacija-receivesigningrequest)

Priima pasirašymo užklausą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:receiveSigningRequest>
         <receiveSigningRequestParam>
            <templateParam>
               <templateNo>SIGNING_TEMPLATE</templateNo>
            </templateParam>
            <linkToDocument>DOC_ORIGINAL_001</linkToDocument>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Pasirašymo užklausa</value>
               </entry>
            </docAttributes>
         </receiveSigningRequestParam>
      </rdo:receiveSigningRequest>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
ReceiveRequestParam param = new ReceiveRequestParam();

TemplateParam templateParam = new TemplateParam();
templateParam.setTemplateNo("SIGNING_TEMPLATE");
param.setTemplateParam(templateParam);

param.setLinkToDocument("DOC_ORIGINAL_001");

Map<String, Object> docAttributes = new HashMap<>();
docAttributes.put("title", "Pasirašymo užklausa");
param.setDocAttributes(docAttributes);

DocumentInfo result = port.receiveSigningRequest(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:receiveSigningRequest>
         <receiveSigningRequestParam>
            <templateParam>
               <templateNo>SIGNING_TEMPLATE</templateNo>
            </templateParam>
            <linkToDocument>DOC_ORIGINAL_001</linkToDocument>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Pasirašymo užklausa</value>
               </entry>
            </docAttributes>
         </receiveSigningRequestParam>
      </rdo:receiveSigningRequest>
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
    'receiveSigningRequestParam' => [
        'templateParam' => [
            'templateNo' => 'SIGNING_TEMPLATE'
        ],
        'linkToDocument' => 'DOC_ORIGINAL_001',
        'docAttributes' => [
            'entry' => [
                ['key' => 'title', 'value' => 'Pasirašymo užklausa']
            ]
        ]
    ]
];

$result = $client->receiveSigningRequest($param);
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
      <rdo:receiveSigningRequest>
         <receiveSigningRequestParam>
            <templateParam>
               <templateNo>SIGNING_TEMPLATE</templateNo>
            </templateParam>
            <linkToDocument>DOC_ORIGINAL_001</linkToDocument>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Pasirašymo užklausa</value>
               </entry>
            </docAttributes>
         </receiveSigningRequestParam>
      </rdo:receiveSigningRequest>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### receiveReviewRequest

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_2232-operacija-receivereviewrequest)

Priima peržiūros užklausą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:receiveReviewRequest>
         <receiveReviewRequestParam>
            <templateParam>
               <templateNo>REVIEW_TEMPLATE</templateNo>
            </templateParam>
            <linkToDocument>DOC_ORIGINAL_001</linkToDocument>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Peržiūros užklausa</value>
               </entry>
            </docAttributes>
         </receiveReviewRequestParam>
      </rdo:receiveReviewRequest>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
ReceiveRequestParam param = new ReceiveRequestParam();

TemplateParam templateParam = new TemplateParam();
templateParam.setTemplateNo("REVIEW_TEMPLATE");
param.setTemplateParam(templateParam);

param.setLinkToDocument("DOC_ORIGINAL_001");

Map<String, Object> docAttributes = new HashMap<>();
docAttributes.put("title", "Peržiūros užklausa");
param.setDocAttributes(docAttributes);

DocumentInfo result = port.receiveReviewRequest(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:receiveReviewRequest>
         <receiveReviewRequestParam>
            <templateParam>
               <templateNo>REVIEW_TEMPLATE</templateNo>
            </templateParam>
            <linkToDocument>DOC_ORIGINAL_001</linkToDocument>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Peržiūros užklausa</value>
               </entry>
            </docAttributes>
         </receiveReviewRequestParam>
      </rdo:receiveReviewRequest>
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
    'receiveReviewRequestParam' => [
        'templateParam' => [
            'templateNo' => 'REVIEW_TEMPLATE'
        ],
        'linkToDocument' => 'DOC_ORIGINAL_001',
        'docAttributes' => [
            'entry' => [
                ['key' => 'title', 'value' => 'Peržiūros užklausa']
            ]
        ]
    ]
];

$result = $client->receiveReviewRequest($param);
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
      <rdo:receiveReviewRequest>
         <receiveReviewRequestParam>
            <templateParam>
               <templateNo>REVIEW_TEMPLATE</templateNo>
            </templateParam>
            <linkToDocument>DOC_ORIGINAL_001</linkToDocument>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Peržiūros užklausa</value>
               </entry>
            </docAttributes>
         </receiveReviewRequestParam>
      </rdo:receiveReviewRequest>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### receiveConfirmationRequest

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_2235-operacija-receiveconfirmationrequest)

Priima patvirtinimo užklausą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:receiveConfirmationRequest>
         <receiveConfirmationRequestParam>
            <templateParam>
               <templateNo>CONFIRMATION_TEMPLATE</templateNo>
            </templateParam>
            <linkToDocument>DOC_ORIGINAL_001</linkToDocument>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Patvirtinimo užklausa</value>
               </entry>
            </docAttributes>
         </receiveConfirmationRequestParam>
      </rdo:receiveConfirmationRequest>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
ReceiveRequestParam param = new ReceiveRequestParam();

TemplateParam templateParam = new TemplateParam();
templateParam.setTemplateNo("CONFIRMATION_TEMPLATE");
param.setTemplateParam(templateParam);

param.setLinkToDocument("DOC_ORIGINAL_001");

Map<String, Object> docAttributes = new HashMap<>();
docAttributes.put("title", "Patvirtinimo užklausa");
param.setDocAttributes(docAttributes);

DocumentInfo result = port.receiveConfirmationRequest(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:receiveConfirmationRequest>
         <receiveConfirmationRequestParam>
            <templateParam>
               <templateNo>CONFIRMATION_TEMPLATE</templateNo>
            </templateParam>
            <linkToDocument>DOC_ORIGINAL_001</linkToDocument>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Patvirtinimo užklausa</value>
               </entry>
            </docAttributes>
         </receiveConfirmationRequestParam>
      </rdo:receiveConfirmationRequest>
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
    'receiveConfirmationRequestParam' => [
        'templateParam' => [
            'templateNo' => 'CONFIRMATION_TEMPLATE'
        ],
        'linkToDocument' => 'DOC_ORIGINAL_001',
        'docAttributes' => [
            'entry' => [
                ['key' => 'title', 'value' => 'Patvirtinimo užklausa']
            ]
        ]
    ]
];

$result = $client->receiveConfirmationRequest($param);
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
      <rdo:receiveConfirmationRequest>
         <receiveConfirmationRequestParam>
            <templateParam>
               <templateNo>CONFIRMATION_TEMPLATE</templateNo>
            </templateParam>
            <linkToDocument>DOC_ORIGINAL_001</linkToDocument>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Patvirtinimo užklausa</value>
               </entry>
            </docAttributes>
         </receiveConfirmationRequestParam>
      </rdo:receiveConfirmationRequest>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---
