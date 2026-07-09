# Išorinių veiksmų žymėjimas

- Path: `/api-dok/dbsis-api/api-taikymas/rdodocumentws/isoriniu-veiksmu-zymejimas`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/rdodocumentws/isoriniu-veiksmu-zymejimas
- Index: 84

---

RDODocumentWS išorinių veiksmų žymėjimo operacijos

### markExtApproval

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_2229-operacija-markextapproval)

Pažymi išorinį tvirtinimą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:markExtApproval>
         <markExtApprovalParam>
            <docOid>DOC_12345</docOid>
            <attachment>
               <action>add</action>
               <title>Patvirtintas dokumentas.adoc</title>
               <content>BASE64_ENCODED_CONTENT</content>
               <contentType>application/vnd.lt.archyvai.adoc-2008</contentType>
               <eDocumentFormat>ADOC_2_0</eDocumentFormat>
            </attachment>
            <actionInfo>
               <actor>
                  <orgName>EXTERNAL_USER</orgName>
               </actor>
               <done>true</done>
               <notes>Patvirtinta iš išorės</notes>
            </actionInfo>
         </markExtApprovalParam>
      </rdo:markExtApproval>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
MarkExtActionParam param = new MarkExtActionParam();
param.setDocOid("DOC_12345");

EDocumentAttachment attachment = new EDocumentAttachment();
attachment.setAction("add");
attachment.setTitle("Patvirtintas dokumentas.adoc");
attachment.setContent(Base64.getDecoder().decode("BASE64_ENCODED_CONTENT"));
attachment.setContentType("application/vnd.lt.archyvai.adoc-2008");
attachment.setEDocumentFormat("ADOC_2_0");
param.setAttachment(attachment);

ExtActionInfo actionInfo = new ExtActionInfo();
OrgNodeParam actor = new OrgNodeParam();
actor.setOrgName("EXTERNAL_USER");
actionInfo.setActor(actor);
actionInfo.setDone(true);
actionInfo.setNotes("Patvirtinta iš išorės");
param.setActionInfo(actionInfo);

DocumentInfo result = port.markExtApproval(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:markExtApproval>
         <markExtApprovalParam>
            <docOid>DOC_12345</docOid>
            <attachment>
               <action>add</action>
               <title>Patvirtintas dokumentas.adoc</title>
               <content>BASE64_ENCODED_CONTENT</content>
               <contentType>application/vnd.lt.archyvai.adoc-2008</contentType>
               <eDocumentFormat>ADOC_2_0</eDocumentFormat>
            </attachment>
            <actionInfo>
               <actor>
                  <orgName>EXTERNAL_USER</orgName>
               </actor>
               <done>true</done>
               <notes>Patvirtinta iš išorės</notes>
            </actionInfo>
         </markExtApprovalParam>
      </rdo:markExtApproval>
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
    'markExtApprovalParam' => [
        'docOid' => 'DOC_12345',
        'attachment' => [
            'action' => 'add',
            'title' => 'Patvirtintas dokumentas.adoc',
            'content' => 'BASE64_ENCODED_CONTENT',
            'contentType' => 'application/vnd.lt.archyvai.adoc-2008',
            'eDocumentFormat' => 'ADOC_2_0'
        ],
        'actionInfo' => [
            'actor' => [
                'orgName' => 'EXTERNAL_USER'
            ],
            'done' => true,
            'notes' => 'Patvirtinta iš išorės'
        ]
    ]
];

$result = $client->markExtApproval($param);
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
      <rdo:markExtApproval>
         <markExtApprovalParam>
            <docOid>DOC_12345</docOid>
            <attachment>
               <action>add</action>
               <title>Patvirtintas dokumentas.adoc</title>
               <content>BASE64_ENCODED_CONTENT</content>
               <contentType>application/vnd.lt.archyvai.adoc-2008</contentType>
               <eDocumentFormat>ADOC_2_0</eDocumentFormat>
            </attachment>
            <actionInfo>
               <actor>
                  <orgName>EXTERNAL_USER</orgName>
               </actor>
               <done>true</done>
               <notes>Patvirtinta iš išorės</notes>
            </actionInfo>
         </markExtApprovalParam>
      </rdo:markExtApproval>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### markExtSigning

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_2230-operacija-markextsigning)

Pažymi išorinį pasirašymą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:markExtSigning>
         <markExtSigningParam>
            <docOid>DOC_12345</docOid>
            <attachment>
               <action>add</action>
               <title>Pasirašytas dokumentas.adoc</title>
               <content>BASE64_ENCODED_CONTENT</content>
               <contentType>application/vnd.lt.archyvai.adoc-2008</contentType>
               <eDocumentFormat>ADOC_2_0</eDocumentFormat>
            </attachment>
            <actionInfo>
               <actor>
                  <orgName>EXTERNAL_USER</orgName>
               </actor>
               <done>true</done>
               <notes>Pasirašyta iš išorės</notes>
            </actionInfo>
         </markExtSigningParam>
      </rdo:markExtSigning>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
MarkExtActionParam param = new MarkExtActionParam();
param.setDocOid("DOC_12345");

EDocumentAttachment attachment = new EDocumentAttachment();
attachment.setAction("add");
attachment.setTitle("Pasirašytas dokumentas.adoc");
attachment.setContent(Base64.getDecoder().decode("BASE64_ENCODED_CONTENT"));
attachment.setContentType("application/vnd.lt.archyvai.adoc-2008");
attachment.setEDocumentFormat("ADOC_2_0");
param.setAttachment(attachment);

ExtActionInfo actionInfo = new ExtActionInfo();
OrgNodeParam actor = new OrgNodeParam();
actor.setOrgName("EXTERNAL_USER");
actionInfo.setActor(actor);
actionInfo.setDone(true);
actionInfo.setNotes("Pasirašyta iš išorės");
param.setActionInfo(actionInfo);

DocumentInfo result = port.markExtSigning(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:markExtSigning>
         <markExtSigningParam>
            <docOid>DOC_12345</docOid>
            <attachment>
               <action>add</action>
               <title>Pasirašytas dokumentas.adoc</title>
               <content>BASE64_ENCODED_CONTENT</content>
               <contentType>application/vnd.lt.archyvai.adoc-2008</contentType>
               <eDocumentFormat>ADOC_2_0</eDocumentFormat>
            </attachment>
            <actionInfo>
               <actor>
                  <orgName>EXTERNAL_USER</orgName>
               </actor>
               <done>true</done>
               <notes>Pasirašyta iš išorės</notes>
            </actionInfo>
         </markExtSigningParam>
      </rdo:markExtSigning>
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
    'markExtSigningParam' => [
        'docOid' => 'DOC_12345',
        'attachment' => [
            'action' => 'add',
            'title' => 'Pasirašytas dokumentas.adoc',
            'content' => 'BASE64_ENCODED_CONTENT',
            'contentType' => 'application/vnd.lt.archyvai.adoc-2008',
            'eDocumentFormat' => 'ADOC_2_0'
        ],
        'actionInfo' => [
            'actor' => [
                'orgName' => 'EXTERNAL_USER'
            ],
            'done' => true,
            'notes' => 'Pasirašyta iš išorės'
        ]
    ]
];

$result = $client->markExtSigning($param);
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
      <rdo:markExtSigning>
         <markExtSigningParam>
            <docOid>DOC_12345</docOid>
            <attachment>
               <action>add</action>
               <title>Pasirašytas dokumentas.adoc</title>
               <content>BASE64_ENCODED_CONTENT</content>
               <contentType>application/vnd.lt.archyvai.adoc-2008</contentType>
               <eDocumentFormat>ADOC_2_0</eDocumentFormat>
            </attachment>
            <actionInfo>
               <actor>
                  <orgName>EXTERNAL_USER</orgName>
               </actor>
               <done>true</done>
               <notes>Pasirašyta iš išorės</notes>
            </actionInfo>
         </markExtSigningParam>
      </rdo:markExtSigning>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### markExtReviewal

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_2228-operacija-markextreviewal)

Pažymi išorinę peržiūrą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:markExtReviewal>
         <markExtReviewalParam>
            <docOid>DOC_12345</docOid>
            <attachment>
               <action>add</action>
               <title>Peržiūrėtas dokumentas.adoc</title>
               <content>BASE64_ENCODED_CONTENT</content>
               <contentType>application/vnd.lt.archyvai.adoc-2008</contentType>
               <eDocumentFormat>ADOC_2_0</eDocumentFormat>
            </attachment>
            <actionInfo>
               <actor>
                  <orgName>EXTERNAL_USER</orgName>
               </actor>
               <done>true</done>
               <notes>Peržiūrėta iš išorės</notes>
            </actionInfo>
         </markExtReviewalParam>
      </rdo:markExtReviewal>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
MarkExtActionParam param = new MarkExtActionParam();
param.setDocOid("DOC_12345");

EDocumentAttachment attachment = new EDocumentAttachment();
attachment.setAction("add");
attachment.setTitle("Peržiūrėtas dokumentas.adoc");
attachment.setContent(Base64.getDecoder().decode("BASE64_ENCODED_CONTENT"));
attachment.setContentType("application/vnd.lt.archyvai.adoc-2008");
attachment.setEDocumentFormat("ADOC_2_0");
param.setAttachment(attachment);

ExtActionInfo actionInfo = new ExtActionInfo();
OrgNodeParam actor = new OrgNodeParam();
actor.setOrgName("EXTERNAL_USER");
actionInfo.setActor(actor);
actionInfo.setDone(true);
actionInfo.setNotes("Peržiūrėta iš išorės");
param.setActionInfo(actionInfo);

DocumentInfo result = port.markExtReviewal(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:markExtReviewal>
         <markExtReviewalParam>
            <docOid>DOC_12345</docOid>
            <attachment>
               <action>add</action>
               <title>Peržiūrėtas dokumentas.adoc</title>
               <content>BASE64_ENCODED_CONTENT</content>
               <contentType>application/vnd.lt.archyvai.adoc-2008</contentType>
               <eDocumentFormat>ADOC_2_0</eDocumentFormat>
            </attachment>
            <actionInfo>
               <actor>
                  <orgName>EXTERNAL_USER</orgName>
               </actor>
               <done>true</done>
               <notes>Peržiūrėta iš išorės</notes>
            </actionInfo>
         </markExtReviewalParam>
      </rdo:markExtReviewal>
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
    'markExtReviewalParam' => [
        'docOid' => 'DOC_12345',
        'attachment' => [
            'action' => 'add',
            'title' => 'Peržiūrėtas dokumentas.adoc',
            'content' => 'BASE64_ENCODED_CONTENT',
            'contentType' => 'application/vnd.lt.archyvai.adoc-2008',
            'eDocumentFormat' => 'ADOC_2_0'
        ],
        'actionInfo' => [
            'actor' => [
                'orgName' => 'EXTERNAL_USER'
            ],
            'done' => true,
            'notes' => 'Peržiūrėta iš išorės'
        ]
    ]
];

$result = $client->markExtReviewal($param);
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
      <rdo:markExtReviewal>
         <markExtReviewalParam>
            <docOid>DOC_12345</docOid>
            <attachment>
               <action>add</action>
               <title>Peržiūrėtas dokumentas.adoc</title>
               <content>BASE64_ENCODED_CONTENT</content>
               <contentType>application/vnd.lt.archyvai.adoc-2008</contentType>
               <eDocumentFormat>ADOC_2_0</eDocumentFormat>
            </attachment>
            <actionInfo>
               <actor>
                  <orgName>EXTERNAL_USER</orgName>
               </actor>
               <done>true</done>
               <notes>Peržiūrėta iš išorės</notes>
            </actionInfo>
         </markExtReviewalParam>
      </rdo:markExtReviewal>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### markExtConfirmation

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_2231-operacija-markextconfirmation)

Pažymi išorinį patvirtinimą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:markExtConfirmation>
         <markExtConfirmationParam>
            <docOid>DOC_12345</docOid>
            <attachment>
               <action>add</action>
               <title>Patvirtintas dokumentas.adoc</title>
               <content>BASE64_ENCODED_CONTENT</content>
               <contentType>application/vnd.lt.archyvai.adoc-2008</contentType>
               <eDocumentFormat>ADOC_2_0</eDocumentFormat>
            </attachment>
            <actionInfo>
               <actor>
                  <orgName>EXTERNAL_USER</orgName>
               </actor>
               <done>true</done>
               <notes>Patvirtinta iš išorės</notes>
            </actionInfo>
         </markExtConfirmationParam>
      </rdo:markExtConfirmation>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
MarkExtActionParam param = new MarkExtActionParam();
param.setDocOid("DOC_12345");

EDocumentAttachment attachment = new EDocumentAttachment();
attachment.setAction("add");
attachment.setTitle("Patvirtintas dokumentas.adoc");
attachment.setContent(Base64.getDecoder().decode("BASE64_ENCODED_CONTENT"));
attachment.setContentType("application/vnd.lt.archyvai.adoc-2008");
attachment.setEDocumentFormat("ADOC_2_0");
param.setAttachment(attachment);

ExtActionInfo actionInfo = new ExtActionInfo();
OrgNodeParam actor = new OrgNodeParam();
actor.setOrgName("EXTERNAL_USER");
actionInfo.setActor(actor);
actionInfo.setDone(true);
actionInfo.setNotes("Patvirtinta iš išorės");
param.setActionInfo(actionInfo);

DocumentInfo result = port.markExtConfirmation(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:markExtConfirmation>
         <markExtConfirmationParam>
            <docOid>DOC_12345</docOid>
            <attachment>
               <action>add</action>
               <title>Patvirtintas dokumentas.adoc</title>
               <content>BASE64_ENCODED_CONTENT</content>
               <contentType>application/vnd.lt.archyvai.adoc-2008</contentType>
               <eDocumentFormat>ADOC_2_0</eDocumentFormat>
            </attachment>
            <actionInfo>
               <actor>
                  <orgName>EXTERNAL_USER</orgName>
               </actor>
               <done>true</done>
               <notes>Patvirtinta iš išorės</notes>
            </actionInfo>
         </markExtConfirmationParam>
      </rdo:markExtConfirmation>
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
    'markExtConfirmationParam' => [
        'docOid' => 'DOC_12345',
        'attachment' => [
            'action' => 'add',
            'title' => 'Patvirtintas dokumentas.adoc',
            'content' => 'BASE64_ENCODED_CONTENT',
            'contentType' => 'application/vnd.lt.archyvai.adoc-2008',
            'eDocumentFormat' => 'ADOC_2_0'
        ],
        'actionInfo' => [
            'actor' => [
                'orgName' => 'EXTERNAL_USER'
            ],
            'done' => true,
            'notes' => 'Patvirtinta iš išorės'
        ]
    ]
];

$result = $client->markExtConfirmation($param);
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
      <rdo:markExtConfirmation>
         <markExtConfirmationParam>
            <docOid>DOC_12345</docOid>
            <attachment>
               <action>add</action>
               <title>Patvirtintas dokumentas.adoc</title>
               <content>BASE64_ENCODED_CONTENT</content>
               <contentType>application/vnd.lt.archyvai.adoc-2008</contentType>
               <eDocumentFormat>ADOC_2_0</eDocumentFormat>
            </attachment>
            <actionInfo>
               <actor>
                  <orgName>EXTERNAL_USER</orgName>
               </actor>
               <done>true</done>
               <notes>Patvirtinta iš išorės</notes>
            </actionInfo>
         </markExtConfirmationParam>
      </rdo:markExtConfirmation>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### markExternalSigningComplete

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_2214-operacija-markexternalsigningcomplete)

Pažymi išorinio pasirašymo užbaigimą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:markExternalSigningComplete>
         <markExternalSigningCompleteParam>
            <docOid>DOC_12345</docOid>
            <adocFile>
               <action>add</action>
               <title>pasirasytas.adoc</title>
               <content>BASE64_ENCODED_CONTENT</content>
               <contentType>application/vnd.lt.archyvai.adoc-2008</contentType>
            </adocFile>
            <externalActionInfo>
               <entry>
                  <actor>
                     <orgName>EXTERNAL_USER</orgName>
                  </actor>
                  <actionDate>2024-06-15T00:00:00</actionDate>
                  <done>true</done>
                  <notes>Pasirašyta iš išorės</notes>
               </entry>
            </externalActionInfo>
         </markExternalSigningCompleteParam>
      </rdo:markExternalSigningComplete>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
MarkExternalActionCompleteParam param = new MarkExternalActionCompleteParam();
param.setDocOid("DOC_12345");

ADocAttachment adocFile = new ADocAttachment();
adocFile.setAction("add");
adocFile.setTitle("pasirasytas.adoc");
adocFile.setContent(Base64.getDecoder().decode("BASE64_ENCODED_CONTENT"));
adocFile.setContentType("application/vnd.lt.archyvai.adoc-2008");
param.setAdocFile(adocFile);

ExternalActionInfoEntry entry = new ExternalActionInfoEntry();
OrgNodeParam actor = new OrgNodeParam();
actor.setOrgName("EXTERNAL_USER");
entry.setActor(actor);
entry.setActionDate(OffsetDateTime.parse("2024-06-15T00:00:00Z"));
entry.setDone(true);
entry.setNotes("Pasirašyta iš išorės");

ExternalActionInfo info = new ExternalActionInfo();
info.getEntry().add(entry);
param.setExternalActionInfo(info);

DocumentInfo result = port.markExternalSigningComplete(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:markExternalSigningComplete>
         <markExternalSigningCompleteParam>
            <docOid>DOC_12345</docOid>
            <adocFile>
               <action>add</action>
               <title>pasirasytas.adoc</title>
               <content>BASE64_ENCODED_CONTENT</content>
               <contentType>application/vnd.lt.archyvai.adoc-2008</contentType>
            </adocFile>
            <externalActionInfo>
               <entry>
                  <actor>
                     <orgName>EXTERNAL_USER</orgName>
                  </actor>
                  <actionDate>2024-06-15T00:00:00</actionDate>
                  <done>true</done>
                  <notes>Pasirašyta iš išorės</notes>
               </entry>
            </externalActionInfo>
         </markExternalSigningCompleteParam>
      </rdo:markExternalSigningComplete>
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
    'markExternalSigningCompleteParam' => [
        'docOid' => 'DOC_12345',
        'adocFile' => [
            'action' => 'add',
            'title' => 'pasirasytas.adoc',
            'content' => 'BASE64_ENCODED_CONTENT',
            'contentType' => 'application/vnd.lt.archyvai.adoc-2008'
        ],
        'externalActionInfo' => [
            'entry' => [
                [
                    'actor' => ['orgName' => 'EXTERNAL_USER'],
                    'actionDate' => '2024-06-15T00:00:00',
                    'done' => true,
                    'notes' => 'Pasirašyta iš išorės'
                ]
            ]
        ]
    ]
];

$result = $client->markExternalSigningComplete($param);
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
      <rdo:markExternalSigningComplete>
         <markExternalSigningCompleteParam>
            <docOid>DOC_12345</docOid>
            <adocFile>
               <action>add</action>
               <title>pasirasytas.adoc</title>
               <content>BASE64_ENCODED_CONTENT</content>
               <contentType>application/vnd.lt.archyvai.adoc-2008</contentType>
            </adocFile>
            <externalActionInfo>
               <entry>
                  <actor>
                     <orgName>EXTERNAL_USER</orgName>
                  </actor>
                  <actionDate>2024-06-15T00:00:00</actionDate>
                  <done>true</done>
                  <notes>Pasirašyta iš išorės</notes>
               </entry>
            </externalActionInfo>
         </markExternalSigningCompleteParam>
      </rdo:markExternalSigningComplete>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### markExternalAcquaintanceComplete

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_2215-operacija-markexternalacquaintancecomplete)

Pažymi išorinio susipažinimo užbaigimą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:markExternalAcquaintanceComplete>
         <markExternalAcquaintanceCompleteParam>
            <docOid>DOC_12345</docOid>
            <adocFile>
               <action>add</action>
               <title>susipazinimas.adoc</title>
               <content>BASE64_ENCODED_CONTENT</content>
               <contentType>application/vnd.lt.archyvai.adoc-2008</contentType>
            </adocFile>
            <externalActionInfo>
               <entry>
                  <actor>
                     <orgName>EXTERNAL_USER</orgName>
                  </actor>
                  <actionDate>2024-06-15T00:00:00</actionDate>
                  <done>true</done>
                  <notes>Susipažinta iš išorės</notes>
               </entry>
            </externalActionInfo>
         </markExternalAcquaintanceCompleteParam>
      </rdo:markExternalAcquaintanceComplete>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
MarkExternalActionCompleteParam param = new MarkExternalActionCompleteParam();
param.setDocOid("DOC_12345");

ADocAttachment adocFile = new ADocAttachment();
adocFile.setAction("add");
adocFile.setTitle("susipazinimas.adoc");
adocFile.setContent(Base64.getDecoder().decode("BASE64_ENCODED_CONTENT"));
adocFile.setContentType("application/vnd.lt.archyvai.adoc-2008");
param.setAdocFile(adocFile);

ExternalActionInfoEntry entry = new ExternalActionInfoEntry();
OrgNodeParam actor = new OrgNodeParam();
actor.setOrgName("EXTERNAL_USER");
entry.setActor(actor);
entry.setActionDate(OffsetDateTime.parse("2024-06-15T00:00:00Z"));
entry.setDone(true);
entry.setNotes("Susipažinta iš išorės");

ExternalActionInfo info = new ExternalActionInfo();
info.getEntry().add(entry);
param.setExternalActionInfo(info);

DocumentInfo result = port.markExternalAcquaintanceComplete(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:markExternalAcquaintanceComplete>
         <markExternalAcquaintanceCompleteParam>
            <docOid>DOC_12345</docOid>
            <adocFile>
               <action>add</action>
               <title>susipazinimas.adoc</title>
               <content>BASE64_ENCODED_CONTENT</content>
               <contentType>application/vnd.lt.archyvai.adoc-2008</contentType>
            </adocFile>
            <externalActionInfo>
               <entry>
                  <actor>
                     <orgName>EXTERNAL_USER</orgName>
                  </actor>
                  <actionDate>2024-06-15T00:00:00</actionDate>
                  <done>true</done>
                  <notes>Susipažinta iš išorės</notes>
               </entry>
            </externalActionInfo>
         </markExternalAcquaintanceCompleteParam>
      </rdo:markExternalAcquaintanceComplete>
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
    'markExternalAcquaintanceCompleteParam' => [
        'docOid' => 'DOC_12345',
        'adocFile' => [
            'action' => 'add',
            'title' => 'susipazinimas.adoc',
            'content' => 'BASE64_ENCODED_CONTENT',
            'contentType' => 'application/vnd.lt.archyvai.adoc-2008'
        ],
        'externalActionInfo' => [
            'entry' => [
                [
                    'actor' => ['orgName' => 'EXTERNAL_USER'],
                    'actionDate' => '2024-06-15T00:00:00',
                    'done' => true,
                    'notes' => 'Susipažinta iš išorės'
                ]
            ]
        ]
    ]
];

$result = $client->markExternalAcquaintanceComplete($param);
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
      <rdo:markExternalAcquaintanceComplete>
         <markExternalAcquaintanceCompleteParam>
            <docOid>DOC_12345</docOid>
            <adocFile>
               <action>add</action>
               <title>susipazinimas.adoc</title>
               <content>BASE64_ENCODED_CONTENT</content>
               <contentType>application/vnd.lt.archyvai.adoc-2008</contentType>
            </adocFile>
            <externalActionInfo>
               <entry>
                  <actor>
                     <orgName>EXTERNAL_USER</orgName>
                  </actor>
                  <actionDate>2024-06-15T00:00:00</actionDate>
                  <done>true</done>
                  <notes>Susipažinta iš išorės</notes>
               </entry>
            </externalActionInfo>
         </markExternalAcquaintanceCompleteParam>
      </rdo:markExternalAcquaintanceComplete>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---
