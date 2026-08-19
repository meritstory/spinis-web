# Išorinių veiksmų žymėjimas

- Path: `/api-dok/dbsis-api/api-taikymas/cdodocumentws/isoriniu-veiksmu-zymejimas`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/cdodocumentws/isoriniu-veiksmu-zymejimas
- Index: 29

---

CDODocumentWS išorinių veiksmų žymėjimo operacijos

### markExtReviewal

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_2228-operacija-markextreviewal)

Pažymi išorinę peržiūrą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cdo="http://www.sintagma.lt/avilys/CDODocumentWS">
   <soapenv:Body>
      <cdo:markExtReviewal>
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
      </cdo:markExtReviewal>
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
                  xmlns:cdo=""http://www.sintagma.lt/avilys/CDODocumentWS"">
   <soapenv:Body>
      <cdo:markExtReviewal>
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
      </cdo:markExtReviewal>
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
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/CDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: \"\"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cdo="http://www.sintagma.lt/avilys/CDODocumentWS">
   <soapenv:Body>
      <cdo:markExtReviewal>
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
      </cdo:markExtReviewal>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### markExtApproval

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_2229-operacija-markextapproval)

Pažymi išorinį tvirtinimą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cdo="http://www.sintagma.lt/avilys/CDODocumentWS">
   <soapenv:Body>
      <cdo:markExtApproval>
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
      </cdo:markExtApproval>
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
                  xmlns:cdo=""http://www.sintagma.lt/avilys/CDODocumentWS"">
   <soapenv:Body>
      <cdo:markExtApproval>
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
      </cdo:markExtApproval>
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
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/CDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: \"\"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cdo="http://www.sintagma.lt/avilys/CDODocumentWS">
   <soapenv:Body>
      <cdo:markExtApproval>
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
      </cdo:markExtApproval>
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
                  xmlns:cdo="http://www.sintagma.lt/avilys/CDODocumentWS">
   <soapenv:Body>
      <cdo:markExtSigning>
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
      </cdo:markExtSigning>
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
                  xmlns:cdo=""http://www.sintagma.lt/avilys/CDODocumentWS"">
   <soapenv:Body>
      <cdo:markExtSigning>
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
      </cdo:markExtSigning>
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
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/CDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: \"\"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cdo="http://www.sintagma.lt/avilys/CDODocumentWS">
   <soapenv:Body>
      <cdo:markExtSigning>
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
      </cdo:markExtSigning>
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
                  xmlns:cdo="http://www.sintagma.lt/avilys/CDODocumentWS">
   <soapenv:Body>
      <cdo:markExtConfirmation>
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
      </cdo:markExtConfirmation>
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
                  xmlns:cdo=""http://www.sintagma.lt/avilys/CDODocumentWS"">
   <soapenv:Body>
      <cdo:markExtConfirmation>
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
      </cdo:markExtConfirmation>
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
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/CDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: \"\"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:cdo="http://www.sintagma.lt/avilys/CDODocumentWS">
   <soapenv:Body>
      <cdo:markExtConfirmation>
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
      </cdo:markExtConfirmation>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---
