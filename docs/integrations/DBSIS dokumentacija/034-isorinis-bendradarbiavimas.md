# Išorinis bendradarbiavimas

- Path: `/api-dok/dbsis-api/api-taikymas/collaborationws/isorinis-bendradarbiavimas`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/collaborationws/isorinis-bendradarbiavimas
- Index: 34

---

CollaborationWS išorinio bendradarbiavimo operacijos

### routeForExternalCollaborator

Perduoda dokumentą išoriniam bendradarbiui.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:col="http://www.sintagma.lt/avilys/CollaborationWS">
   <soapenv:Body>
      <col:routeForExternalCollaborator>
         <documentFromTemplateParam>
            <templateParam>
               <templateNo>EXT_COLLAB_001</templateNo>
            </templateParam>
            <docOid>DOC_12345</docOid>
            <docAttributes>
               <entry>
                  <key>note</key>
                  <value>Perduodama peržiūrai</value>
               </entry>
            </docAttributes>
         </documentFromTemplateParam>
      </col:routeForExternalCollaborator>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
RouteForCollaboratorParam param = new RouteForCollaboratorParam();
param.setDocOid("DOC_12345");

TemplateParam template = new TemplateParam();
template.setTemplateNo("EXT_COLLAB_001");
param.setTemplateParam(template);

DocumentInfo result = port.routeForExternalCollaborator(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:col=\"http://www.sintagma.lt/avilys/CollaborationWS\">
   <soapenv:Body>
      <col:routeForExternalCollaborator>
         <documentFromTemplateParam>
            <templateParam>
               <templateNo>EXT_COLLAB_001</templateNo>
            </templateParam>
            <docOid>DOC_12345</docOid>
            <docAttributes>
               <entry>
                  <key>note</key>
                  <value>Perduodama peržiūrai</value>
               </entry>
            </docAttributes>
         </documentFromTemplateParam>
      </col:routeForExternalCollaborator>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/CollaborationWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/CollaborationWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'documentFromTemplateParam' => [
        'templateParam' => [
            'templateNo' => 'EXT_COLLAB_001'
        ],
        'docOid' => 'DOC_12345',
        'docAttributes' => [
            'entry' => [
                ['key' => 'note', 'value' => 'Perduodama peržiūrai']
            ]
        ]
    ]
];

$result = $client->routeForExternalCollaborator($param);
echo $result->documentInfo->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/CollaborationWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/CollaborationWS/routeForExternalCollaborator"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:col="http://www.sintagma.lt/avilys/CollaborationWS">
   <soapenv:Body>
      <col:routeForExternalCollaborator>
         <documentFromTemplateParam>
            <templateParam>
               <templateNo>EXT_COLLAB_001</templateNo>
            </templateParam>
            <docOid>DOC_12345</docOid>
            <docAttributes>
               <entry>
                  <key>note</key>
                  <value>Perduodama peržiūrai</value>
               </entry>
            </docAttributes>
         </documentFromTemplateParam>
      </col:routeForExternalCollaborator>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### returnToExternalCollaborator

Grąžina dokumentą išoriniam bendradarbiui (pakartotiniam perdavimui).

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:col="http://www.sintagma.lt/avilys/CollaborationWS">
   <soapenv:Body>
      <col:returnToExternalCollaborator>
         <modifyDocumentExtendedParam>
            <docOid>DOC_12345</docOid>
            <docAttributes>
               <entry>
                  <key>note</key>
                  <value>Grąžinama patikslinimui</value>
               </entry>
            </docAttributes>
         </modifyDocumentExtendedParam>
      </col:returnToExternalCollaborator>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
ModifyDocumentExtendedParam param = new ModifyDocumentExtendedParam();
param.setDocOid("DOC_12345");

DocumentInfo result = port.returnToExternalCollaborator(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:col=\"http://www.sintagma.lt/avilys/CollaborationWS\">
   <soapenv:Body>
      <col:returnToExternalCollaborator>
         <modifyDocumentExtendedParam>
            <docOid>DOC_12345</docOid>
            <docAttributes>
               <entry>
                  <key>note</key>
                  <value>Grąžinama patikslinimui</value>
               </entry>
            </docAttributes>
         </modifyDocumentExtendedParam>
      </col:returnToExternalCollaborator>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/CollaborationWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/CollaborationWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'modifyDocumentExtendedParam' => [
        'docOid' => 'DOC_12345',
        'docAttributes' => [
            'entry' => [
                ['key' => 'note', 'value' => 'Grąžinama patikslinimui']
            ]
        ]
    ]
];

$result = $client->returnToExternalCollaborator($param);
echo "Dokumento OID: " . $result->documentInfo->oid;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/CollaborationWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/CollaborationWS/returnToExternalCollaborator"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:col="http://www.sintagma.lt/avilys/CollaborationWS">
   <soapenv:Body>
      <col:returnToExternalCollaborator>
         <modifyDocumentExtendedParam>
            <docOid>DOC_12345</docOid>
            <docAttributes>
               <entry>
                  <key>note</key>
                  <value>Grąžinama patikslinimui</value>
               </entry>
            </docAttributes>
         </modifyDocumentExtendedParam>
      </col:returnToExternalCollaborator>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### repeatRouteForExternalCollaborator

Pakartoja dokumento perdavimą išoriniam bendradarbiui.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:col="http://www.sintagma.lt/avilys/CollaborationWS">
   <soapenv:Body>
      <col:repeatRouteForExternalCollaborator>
         <modifyDocumentExtendedParam>
            <docOid>DOC_12345</docOid>
         </modifyDocumentExtendedParam>
      </col:repeatRouteForExternalCollaborator>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
ModifyDocumentExtendedParam param = new ModifyDocumentExtendedParam();
param.setDocOid("DOC_12345");

DocumentInfo result = port.repeatRouteForExternalCollaborator(param);
System.out.println("Dokumento OID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:col=\"http://www.sintagma.lt/avilys/CollaborationWS\">
   <soapenv:Body>
      <col:repeatRouteForExternalCollaborator>
         <modifyDocumentExtendedParam>
            <docOid>DOC_12345</docOid>
         </modifyDocumentExtendedParam>
      </col:repeatRouteForExternalCollaborator>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/CollaborationWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/CollaborationWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'modifyDocumentExtendedParam' => [
        'docOid' => 'DOC_12345'
    ]
];

$result = $client->repeatRouteForExternalCollaborator($param);
echo "Dokumento OID: " . $result->documentInfo->oid;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/CollaborationWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/CollaborationWS/repeatRouteForExternalCollaborator"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:col="http://www.sintagma.lt/avilys/CollaborationWS">
   <soapenv:Body>
      <col:repeatRouteForExternalCollaborator>
         <modifyDocumentExtendedParam>
            <docOid>DOC_12345</docOid>
         </modifyDocumentExtendedParam>
      </col:repeatRouteForExternalCollaborator>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija
