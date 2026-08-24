# Paslaugų dokumentai

- Path: `/api-dok/dbsis-api/api-taikymas/epsdocumentws/paslaugu-dokumentai`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/epsdocumentws/paslaugu-dokumentai
- Index: 52

---

EPSDocumentWS paslaugų dokumentų operacijos

### getServiceDocumentList

Grąžina paslaugų dokumentų sąrašą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:getServiceDocumentList>
         <getServiceDocumentListParam>
            <searchParameters>
               <entry>
                  <key>serviceNo</key>
                  <value>SV-001</value>
               </entry>
            </searchParameters>
            <pageSize>10</pageSize>
            <pageNum>1</pageNum>
         </getServiceDocumentListParam>
      </eps:getServiceDocumentList>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
import java.net.URI;
import java.net.http.HttpClient;
import java.net.http.HttpRequest;
import java.net.http.HttpResponse;

String soapEnvelope = """
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:getServiceDocumentList>
         <getServiceDocumentListParam>
            <searchParameters>
               <entry>
                  <key>serviceNo</key>
                  <value>SV-001</value>
               </entry>
            </searchParameters>
            <pageSize>10</pageSize>
            <pageNum>1</pageNum>
         </getServiceDocumentListParam>
      </eps:getServiceDocumentList>
   </soapenv:Body>
</soapenv:Envelope>
""";

HttpClient client = HttpClient.newHttpClient();
HttpRequest request = HttpRequest.newBuilder()
    .uri(URI.create("https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS"))
    .header("Content-Type", "text/xml; charset=utf-8")
    .header("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/getServiceDocumentList")
    .POST(HttpRequest.BodyPublishers.ofString(soapEnvelope))
    .build();

HttpResponse<String> response = client.send(request, HttpResponse.BodyHandlers.ofString());
System.out.println(response.body());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:eps=""http://www.sintagma.lt/avilys/EPSDocumentWS"">
   <soapenv:Body>
      <eps:getServiceDocumentList>
         <getServiceDocumentListParam>
            <searchParameters>
               <entry>
                  <key>serviceNo</key>
                  <value>SV-001</value>
               </entry>
            </searchParameters>
            <pageSize>10</pageSize>
            <pageNum>1</pageNum>
         </getServiceDocumentListParam>
      </eps:getServiceDocumentList>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
using var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
content.Headers.Add("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/getServiceDocumentList");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'getServiceDocumentListParam' => [
        'searchParameters' => [
            'entry' => [
                ['key' => 'serviceNo', 'value' => 'SV-001']
            ]
        ],
        'pageSize' => 10,
        'pageNum' => 1
    ]
];

$result = $client->getServiceDocumentList($param);
echo $result->serviceDocumentList->totalDocumentsFound . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/EPSDocumentWS/getServiceDocumentList"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:getServiceDocumentList>
         <getServiceDocumentListParam>
            <searchParameters>
               <entry>
                  <key>serviceNo</key>
                  <value>SV-001</value>
               </entry>
            </searchParameters>
            <pageSize>10</pageSize>
            <pageNum>1</pageNum>
         </getServiceDocumentListParam>
      </eps:getServiceDocumentList>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getServiceDocument

Grąžina paslaugos dokumentą pagal OID.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:getServiceDocument>
         <getServiceDocumentParam>
            <docOid>SVC-001</docOid>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
            <retrieveElectroContainer>METADATA</retrieveElectroContainer>
            <retrieveProcessTasks>false</retrieveProcessTasks>
         </getServiceDocumentParam>
      </eps:getServiceDocument>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
import java.net.URI;
import java.net.http.HttpClient;
import java.net.http.HttpRequest;
import java.net.http.HttpResponse;

String soapEnvelope = """
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:getServiceDocument>
         <getServiceDocumentParam>
            <docOid>SVC-001</docOid>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
            <retrieveElectroContainer>METADATA</retrieveElectroContainer>
            <retrieveProcessTasks>false</retrieveProcessTasks>
         </getServiceDocumentParam>
      </eps:getServiceDocument>
   </soapenv:Body>
</soapenv:Envelope>
""";

HttpClient client = HttpClient.newHttpClient();
HttpRequest request = HttpRequest.newBuilder()
    .uri(URI.create("https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS"))
    .header("Content-Type", "text/xml; charset=utf-8")
    .header("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/getServiceDocument")
    .POST(HttpRequest.BodyPublishers.ofString(soapEnvelope))
    .build();

HttpResponse<String> response = client.send(request, HttpResponse.BodyHandlers.ofString());
System.out.println(response.body());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:eps=""http://www.sintagma.lt/avilys/EPSDocumentWS"">
   <soapenv:Body>
      <eps:getServiceDocument>
         <getServiceDocumentParam>
            <docOid>SVC-001</docOid>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
            <retrieveElectroContainer>METADATA</retrieveElectroContainer>
            <retrieveProcessTasks>false</retrieveProcessTasks>
         </getServiceDocumentParam>
      </eps:getServiceDocument>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
using var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
content.Headers.Add("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/getServiceDocument");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'getServiceDocumentParam' => [
        'docOid' => 'SVC-001',
        'retrieveBodyAttachment' => 'METADATA',
        'retrieveElectroContainer' => 'METADATA',
        'retrieveProcessTasks' => false
    ]
];

$result = $client->getServiceDocument($param);
echo $result->serviceDocument->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/EPSDocumentWS/getServiceDocument"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:getServiceDocument>
         <getServiceDocumentParam>
            <docOid>SVC-001</docOid>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
            <retrieveElectroContainer>METADATA</retrieveElectroContainer>
            <retrieveProcessTasks>false</retrieveProcessTasks>
         </getServiceDocumentParam>
      </eps:getServiceDocument>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### createServiceDocument

Sukuria paslaugos dokumentą pagal šabloną.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:createServiceDocument>
         <createServiceDocumentParam>
            <templateParam>
               <oid>TEMPLATE-001</oid>
            </templateParam>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Paslaugos dokumentas</value>
               </entry>
            </docAttributes>
         </createServiceDocumentParam>
      </eps:createServiceDocument>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
import java.net.URI;
import java.net.http.HttpClient;
import java.net.http.HttpRequest;
import java.net.http.HttpResponse;

String soapEnvelope = """
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:createServiceDocument>
         <createServiceDocumentParam>
            <templateParam>
               <oid>TEMPLATE-001</oid>
            </templateParam>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Paslaugos dokumentas</value>
               </entry>
            </docAttributes>
         </createServiceDocumentParam>
      </eps:createServiceDocument>
   </soapenv:Body>
</soapenv:Envelope>
""";

HttpClient client = HttpClient.newHttpClient();
HttpRequest request = HttpRequest.newBuilder()
    .uri(URI.create("https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS"))
    .header("Content-Type", "text/xml; charset=utf-8")
    .header("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/createServiceDocument")
    .POST(HttpRequest.BodyPublishers.ofString(soapEnvelope))
    .build();

HttpResponse<String> response = client.send(request, HttpResponse.BodyHandlers.ofString());
System.out.println(response.body());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:eps=""http://www.sintagma.lt/avilys/EPSDocumentWS"">
   <soapenv:Body>
      <eps:createServiceDocument>
         <createServiceDocumentParam>
            <templateParam>
               <oid>TEMPLATE-001</oid>
            </templateParam>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Paslaugos dokumentas</value>
               </entry>
            </docAttributes>
         </createServiceDocumentParam>
      </eps:createServiceDocument>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
using var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
content.Headers.Add("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/createServiceDocument");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'createServiceDocumentParam' => [
        'templateParam' => ['oid' => 'TEMPLATE-001'],
        'docAttributes' => [
            'entry' => [
                ['key' => 'title', 'value' => 'Paslaugos dokumentas']
            ]
        ]
    ]
];

$result = $client->createServiceDocument($param);
echo $result->serviceDocumentInfo->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/EPSDocumentWS/createServiceDocument"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:createServiceDocument>
         <createServiceDocumentParam>
            <templateParam>
               <oid>TEMPLATE-001</oid>
            </templateParam>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Paslaugos dokumentas</value>
               </entry>
            </docAttributes>
         </createServiceDocumentParam>
      </eps:createServiceDocument>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### modifyServiceDocument

Atnaujina paslaugos dokumento atributus.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:modifyServiceDocument>
         <modifyServiceDocumentParam>
            <docOid>SVC-001</docOid>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Atnaujintas pavadinimas</value>
               </entry>
            </docAttributes>
         </modifyServiceDocumentParam>
      </eps:modifyServiceDocument>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
import java.net.URI;
import java.net.http.HttpClient;
import java.net.http.HttpRequest;
import java.net.http.HttpResponse;

String soapEnvelope = """
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:modifyServiceDocument>
         <modifyServiceDocumentParam>
            <docOid>SVC-001</docOid>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Atnaujintas pavadinimas</value>
               </entry>
            </docAttributes>
         </modifyServiceDocumentParam>
      </eps:modifyServiceDocument>
   </soapenv:Body>
</soapenv:Envelope>
""";

HttpClient client = HttpClient.newHttpClient();
HttpRequest request = HttpRequest.newBuilder()
    .uri(URI.create("https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS"))
    .header("Content-Type", "text/xml; charset=utf-8")
    .header("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/modifyServiceDocument")
    .POST(HttpRequest.BodyPublishers.ofString(soapEnvelope))
    .build();

HttpResponse<String> response = client.send(request, HttpResponse.BodyHandlers.ofString());
System.out.println(response.body());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:eps=""http://www.sintagma.lt/avilys/EPSDocumentWS"">
   <soapenv:Body>
      <eps:modifyServiceDocument>
         <modifyServiceDocumentParam>
            <docOid>SVC-001</docOid>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Atnaujintas pavadinimas</value>
               </entry>
            </docAttributes>
         </modifyServiceDocumentParam>
      </eps:modifyServiceDocument>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
using var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
content.Headers.Add("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/modifyServiceDocument");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'modifyServiceDocumentParam' => [
        'docOid' => 'SVC-001',
        'docAttributes' => [
            'entry' => [
                ['key' => 'title', 'value' => 'Atnaujintas pavadinimas']
            ]
        ]
    ]
];

$result = $client->modifyServiceDocument($param);
echo $result->serviceDocumentInfo->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/EPSDocumentWS/modifyServiceDocument"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:modifyServiceDocument>
         <modifyServiceDocumentParam>
            <docOid>SVC-001</docOid>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Atnaujintas pavadinimas</value>
               </entry>
            </docAttributes>
         </modifyServiceDocumentParam>
      </eps:modifyServiceDocument>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getServiceAttachment

Grąžina paslaugos dokumento priedą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:getServiceAttachment>
         <getAttachmentParam>
            <docOid>SVC-001</docOid>
            <oid>ATT-001</oid>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
         </getAttachmentParam>
      </eps:getServiceAttachment>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
import java.net.URI;
import java.net.http.HttpClient;
import java.net.http.HttpRequest;
import java.net.http.HttpResponse;

String soapEnvelope = """
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:getServiceAttachment>
         <getAttachmentParam>
            <docOid>SVC-001</docOid>
            <oid>ATT-001</oid>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
         </getAttachmentParam>
      </eps:getServiceAttachment>
   </soapenv:Body>
</soapenv:Envelope>
""";

HttpClient client = HttpClient.newHttpClient();
HttpRequest request = HttpRequest.newBuilder()
    .uri(URI.create("https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS"))
    .header("Content-Type", "text/xml; charset=utf-8")
    .header("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/getServiceAttachment")
    .POST(HttpRequest.BodyPublishers.ofString(soapEnvelope))
    .build();

HttpResponse<String> response = client.send(request, HttpResponse.BodyHandlers.ofString());
System.out.println(response.body());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:eps=""http://www.sintagma.lt/avilys/EPSDocumentWS"">
   <soapenv:Body>
      <eps:getServiceAttachment>
         <getAttachmentParam>
            <docOid>SVC-001</docOid>
            <oid>ATT-001</oid>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
         </getAttachmentParam>
      </eps:getServiceAttachment>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
using var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
content.Headers.Add("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/getServiceAttachment");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'getAttachmentParam' => [
        'docOid' => 'SVC-001',
        'oid' => 'ATT-001',
        'retrieveBodyAttachment' => 'METADATA'
    ]
];

$result = $client->getServiceAttachment($param);
echo $result->attachment->bodyAttachment->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/EPSDocumentWS/getServiceAttachment"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:getServiceAttachment>
         <getAttachmentParam>
            <docOid>SVC-001</docOid>
            <oid>ATT-001</oid>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
         </getAttachmentParam>
      </eps:getServiceAttachment>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getServiceInvoiceAttachment

Grąžina sąskaitos priedą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:getServiceInvoiceAttachment>
         <getAttachmentParam>
            <docOid>SVC-001</docOid>
            <oid>INV-ATT-001</oid>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
         </getAttachmentParam>
      </eps:getServiceInvoiceAttachment>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
import java.net.URI;
import java.net.http.HttpClient;
import java.net.http.HttpRequest;
import java.net.http.HttpResponse;

String soapEnvelope = """
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:getServiceInvoiceAttachment>
         <getAttachmentParam>
            <docOid>SVC-001</docOid>
            <oid>INV-ATT-001</oid>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
         </getAttachmentParam>
      </eps:getServiceInvoiceAttachment>
   </soapenv:Body>
</soapenv:Envelope>
""";

HttpClient client = HttpClient.newHttpClient();
HttpRequest request = HttpRequest.newBuilder()
    .uri(URI.create("https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS"))
    .header("Content-Type", "text/xml; charset=utf-8")
    .header("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/getServiceAttachment")
    .POST(HttpRequest.BodyPublishers.ofString(soapEnvelope))
    .build();

HttpResponse<String> response = client.send(request, HttpResponse.BodyHandlers.ofString());
System.out.println(response.body());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:eps=""http://www.sintagma.lt/avilys/EPSDocumentWS"">
   <soapenv:Body>
      <eps:getServiceInvoiceAttachment>
         <getAttachmentParam>
            <docOid>SVC-001</docOid>
            <oid>INV-ATT-001</oid>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
         </getAttachmentParam>
      </eps:getServiceInvoiceAttachment>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
using var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
content.Headers.Add("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/getServiceAttachment");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'getAttachmentParam' => [
        'docOid' => 'SVC-001',
        'oid' => 'INV-ATT-001',
        'retrieveBodyAttachment' => 'METADATA'
    ]
];

$result = $client->getServiceInvoiceAttachment($param);
echo $result->attachment->bodyAttachment->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/EPSDocumentWS/getServiceAttachment"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:getServiceInvoiceAttachment>
         <getAttachmentParam>
            <docOid>SVC-001</docOid>
            <oid>INV-ATT-001</oid>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
         </getAttachmentParam>
      </eps:getServiceInvoiceAttachment>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija
