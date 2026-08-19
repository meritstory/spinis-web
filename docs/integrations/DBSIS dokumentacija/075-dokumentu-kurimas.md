# Dokumentų kūrimas

- Path: `/api-dok/dbsis-api/api-taikymas/rdodocumentws/dokumentu-kurimas`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/rdodocumentws/dokumentu-kurimas
- Index: 75

---

RDODocumentWS dokumentų kūrimo operacijos

### createWSDocument

Sukuria naują dokumentą pagal šabloną su nurodytais atributais ir priedais.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:createWSDocument>
         <param>
            <templateParam>
               <templateNo>TEMPLATE_001</templateNo>
            </templateParam>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Dokumento pavadinimas</value>
               </entry>
            </docAttributes>
         </param>
      </rdo:createWSDocument>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
import javax.xml.namespace.QName;
import javax.xml.ws.Service;
import java.net.URL;

// Sukurti servisą iš WSDL
URL wsdlURL = new URL("https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS?wsdl");
QName serviceName = new QName("http://www.sintagma.lt/avilys/RDODocumentWS", "RDODocumentWS");
Service service = Service.create(wsdlURL, serviceName);

// Gauti port'ą
RDODocumentWSPortType port = service.getPort(RDODocumentWSPortType.class);

// Sukurti parametrus
CreateWSDocumentParam param = new CreateWSDocumentParam();

TemplateParam templateParam = new TemplateParam();
templateParam.setTemplateNo("TEMPLATE_001");
param.setTemplateParam(templateParam);

Map<String, String> docAttributes = new HashMap<>();
docAttributes.put("title", "Dokumento pavadinimas");
param.setDocAttributes(docAttributes);

// Iškviesti operaciją
DocumentInfo result = port.createWSDocument(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

// Sukurti SOAP užklausą
var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:createWSDocument>
         <param>
            <templateParam>
               <templateNo>TEMPLATE_001</templateNo>
            </templateParam>
            <docAttributes>
               <entry><key>title</key><value>Dokumento pavadinimas</value></entry>
            </docAttributes>
         </param>
      </rdo:createWSDocument>
   </soapenv:Body>
</soapenv:Envelope>";

// Siųsti užklausą
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
<?php
// Sukurti SOAP klientą
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

// Sukurti parametrus
$param = [
    'param' => [
        'templateParam' => [
            'templateNo' => 'TEMPLATE_001'
        ],
        'docAttributes' => [
            'entry' => [
                ['key' => 'title', 'value' => 'Dokumento pavadinimas']
            ]
        ]
    ]
];

// Iškviesti operaciją
$result = $client->createWSDocument($param);
echo "Dokumento OID: " . $result->oid;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: ""' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:createWSDocument>
         <param>
            <templateParam>
               <templateNo>TEMPLATE_001</templateNo>
            </templateParam>
            <docAttributes>
               <entry><key>title</key><value>Dokumento pavadinimas</value></entry>
            </docAttributes>
         </param>
      </rdo:createWSDocument>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### createDocumentFromTemplate

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_12-createdocumentfromtemplate)

Sukuria dokumentą pagal nurodytą šabloną.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:createDocumentFromTemplate>
         <documentFromTemplateParam>
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
         </documentFromTemplateParam>
      </rdo:createDocumentFromTemplate>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
DocumentFromTemplateParam param = new DocumentFromTemplateParam();

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
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:createDocumentFromTemplate>
         <documentFromTemplateParam>
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
         </documentFromTemplateParam>
      </rdo:createDocumentFromTemplate>
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
    'documentFromTemplateParam' => [
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
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: ""' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:createDocumentFromTemplate>
         <documentFromTemplateParam>
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
         </documentFromTemplateParam>
      </rdo:createDocumentFromTemplate>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### createDocumentFromEDocument

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_23-operacija-createdocumentfromedocument)

Sukuria dokumentą iš elektroninio dokumento (e-dokumento) failo.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:createDocumentFromEDocument>
         <documentFromEDocumentParam>
            <templateParam>
               <oid>TEMPLATE_OID_001</oid>
            </templateParam>
            <register>true</register>
            <project>false</project>
            <eDocumentFile>
               <title>dokumentas.adoc</title>
               <contentType>application/vnd.lt.archyvai.adoc-2008</contentType>
               <eDocumentFormat>ADOC_1_0</eDocumentFormat>
               <content>BASE64_ENCODED_CONTENT</content>
            </eDocumentFile>
            <docAttributes>
               <entry>
                  <key>draftJournal</key>
                  <value>JRN-001</value>
               </entry>
               <entry>
                  <key>draftOfficeCase</key>
                  <value>CASE-001</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>note</key>
                  <value>Papildoma informacija</value>
               </entry>
            </extraAttributes>
         </documentFromEDocumentParam>
      </rdo:createDocumentFromEDocument>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
DocumentFromEDocumentParam param = new DocumentFromEDocumentParam();

TemplateParam templateParam = new TemplateParam();
templateParam.setOid("TEMPLATE_OID_001");
param.setTemplateParam(templateParam);

param.setRegister(true);
param.setProject(false);

EDocumentAttachment eDocumentFile = new EDocumentAttachment();
eDocumentFile.setTitle("dokumentas.adoc");
eDocumentFile.setContentType("application/vnd.lt.archyvai.adoc-2008");
eDocumentFile.setEDocumentFormat("ADOC_1_0");
eDocumentFile.setContent(Base64.getDecoder().decode("BASE64_ENCODED_CONTENT"));
param.setEDocumentFile(eDocumentFile);

Map<String, Object> docAttributes = new HashMap<>();
docAttributes.put("draftJournal", "JRN-001");
docAttributes.put("draftOfficeCase", "CASE-001");
param.setDocAttributes(docAttributes);

Map<String, Object> extraAttributes = new HashMap<>();
extraAttributes.put("note", "Papildoma informacija");
param.setExtraAttributes(extraAttributes);

DocumentInfo result = port.createDocumentFromEDocument(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:createDocumentFromEDocument>
         <documentFromEDocumentParam>
            <templateParam>
               <oid>TEMPLATE_OID_001</oid>
            </templateParam>
            <register>true</register>
            <project>false</project>
            <eDocumentFile>
               <title>dokumentas.adoc</title>
               <contentType>application/vnd.lt.archyvai.adoc-2008</contentType>
               <eDocumentFormat>ADOC_1_0</eDocumentFormat>
               <content>BASE64_ENCODED_CONTENT</content>
            </eDocumentFile>
            <docAttributes>
               <entry>
                  <key>draftJournal</key>
                  <value>JRN-001</value>
               </entry>
               <entry>
                  <key>draftOfficeCase</key>
                  <value>CASE-001</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>note</key>
                  <value>Papildoma informacija</value>
               </entry>
            </extraAttributes>
         </documentFromEDocumentParam>
      </rdo:createDocumentFromEDocument>
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
    'documentFromEDocumentParam' => [
        'templateParam' => [
            'oid' => 'TEMPLATE_OID_001'
        ],
        'register' => true,
        'project' => false,
        'eDocumentFile' => [
            'title' => 'dokumentas.adoc',
            'contentType' => 'application/vnd.lt.archyvai.adoc-2008',
            'eDocumentFormat' => 'ADOC_1_0',
            'content' => 'BASE64_ENCODED_CONTENT'
        ],
        'docAttributes' => [
            'entry' => [
                ['key' => 'draftJournal', 'value' => 'JRN-001'],
                ['key' => 'draftOfficeCase', 'value' => 'CASE-001']
            ]
        ],
        'extraAttributes' => [
            'entry' => [
                ['key' => 'note', 'value' => 'Papildoma informacija']
            ]
        ]
    ]
];

$result = $client->createDocumentFromEDocument($param);
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
      <rdo:createDocumentFromEDocument>
         <documentFromEDocumentParam>
            <templateParam>
               <oid>TEMPLATE_OID_001</oid>
            </templateParam>
            <register>true</register>
            <project>false</project>
            <eDocumentFile>
               <title>dokumentas.adoc</title>
               <contentType>application/vnd.lt.archyvai.adoc-2008</contentType>
               <eDocumentFormat>ADOC_1_0</eDocumentFormat>
               <content>BASE64_ENCODED_CONTENT</content>
            </eDocumentFile>
            <docAttributes>
               <entry>
                  <key>draftJournal</key>
                  <value>JRN-001</value>
               </entry>
               <entry>
                  <key>draftOfficeCase</key>
                  <value>CASE-001</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>note</key>
                  <value>Papildoma informacija</value>
               </entry>
            </extraAttributes>
         </documentFromEDocumentParam>
      </rdo:createDocumentFromEDocument>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### createDocumentFromAdoc

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_17-createdocumentfromadoc)

Sukuria dokumentą iš ADOC formato failo.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:createDocumentFromAdoc>
         <documentFromAdocParam>
            <templateParam>
               <oid>TEMPLATE_OID_001</oid>
            </templateParam>
            <register>true</register>
            <project>false</project>
            <adocFile>
               <action>add</action>
               <fileName>dokumentas.adoc</fileName>
               <content>BASE64_ENCODED_CONTENT</content>
               <mimeType>application/vnd.lt.archyvai.adoc-2008</mimeType>
               <title>dokumentas.adoc</title>
            </adocFile>
            <docAttributes>
               <entry>
                  <key>draftJournal</key>
                  <value>JRN-001</value>
               </entry>
               <entry>
                  <key>draftOfficeCase</key>
                  <value>CASE-001</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>note</key>
                  <value>Papildoma informacija</value>
               </entry>
            </extraAttributes>
         </documentFromAdocParam>
      </rdo:createDocumentFromAdoc>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
DocumentFromAdocParam param = new DocumentFromAdocParam();

TemplateParam templateParam = new TemplateParam();
templateParam.setOid("TEMPLATE_OID_001");
param.setTemplateParam(templateParam);

param.setRegister(true);
param.setProject(false);

ADocAttachment adocFile = new ADocAttachment();
adocFile.setAction("add");
adocFile.setFileName("dokumentas.adoc");
adocFile.setMimeType("application/vnd.lt.archyvai.adoc-2008");
adocFile.setTitle("dokumentas.adoc");
adocFile.setContent(Base64.getDecoder().decode("BASE64_ENCODED_CONTENT"));
param.setAdocFile(adocFile);

Map<String, Object> docAttributes = new HashMap<>();
docAttributes.put("draftJournal", "JRN-001");
docAttributes.put("draftOfficeCase", "CASE-001");
param.setDocAttributes(docAttributes);

Map<String, Object> extraAttributes = new HashMap<>();
extraAttributes.put("note", "Papildoma informacija");
param.setExtraAttributes(extraAttributes);

DocumentInfo result = port.createDocumentFromAdoc(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:createDocumentFromAdoc>
         <documentFromAdocParam>
            <templateParam>
               <oid>TEMPLATE_OID_001</oid>
            </templateParam>
            <register>true</register>
            <project>false</project>
            <adocFile>
               <action>add</action>
               <fileName>dokumentas.adoc</fileName>
               <content>BASE64_ENCODED_CONTENT</content>
               <mimeType>application/vnd.lt.archyvai.adoc-2008</mimeType>
               <title>dokumentas.adoc</title>
            </adocFile>
            <docAttributes>
               <entry>
                  <key>draftJournal</key>
                  <value>JRN-001</value>
               </entry>
               <entry>
                  <key>draftOfficeCase</key>
                  <value>CASE-001</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>note</key>
                  <value>Papildoma informacija</value>
               </entry>
            </extraAttributes>
         </documentFromAdocParam>
      </rdo:createDocumentFromAdoc>
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
    'documentFromAdocParam' => [
        'templateParam' => [
            'oid' => 'TEMPLATE_OID_001'
        ],
        'register' => true,
        'project' => false,
        'adocFile' => [
            'action' => 'add',
            'fileName' => 'dokumentas.adoc',
            'mimeType' => 'application/vnd.lt.archyvai.adoc-2008',
            'title' => 'dokumentas.adoc',
            'content' => 'BASE64_ENCODED_CONTENT'
        ],
        'docAttributes' => [
            'entry' => [
                ['key' => 'draftJournal', 'value' => 'JRN-001'],
                ['key' => 'draftOfficeCase', 'value' => 'CASE-001']
            ]
        ],
        'extraAttributes' => [
            'entry' => [
                ['key' => 'note', 'value' => 'Papildoma informacija']
            ]
        ]
    ]
];

$result = $client->createDocumentFromAdoc($param);
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
      <rdo:createDocumentFromAdoc>
         <documentFromAdocParam>
            <templateParam>
               <oid>TEMPLATE_OID_001</oid>
            </templateParam>
            <register>true</register>
            <project>false</project>
            <adocFile>
               <action>add</action>
               <fileName>dokumentas.adoc</fileName>
               <content>BASE64_ENCODED_CONTENT</content>
               <mimeType>application/vnd.lt.archyvai.adoc-2008</mimeType>
               <title>dokumentas.adoc</title>
            </adocFile>
            <docAttributes>
               <entry>
                  <key>draftJournal</key>
                  <value>JRN-001</value>
               </entry>
               <entry>
                  <key>draftOfficeCase</key>
                  <value>CASE-001</value>
               </entry>
            </docAttributes>
            <extraAttributes>
               <entry>
                  <key>note</key>
                  <value>Papildoma informacija</value>
               </entry>
            </extraAttributes>
         </documentFromAdocParam>
      </rdo:createDocumentFromAdoc>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---
