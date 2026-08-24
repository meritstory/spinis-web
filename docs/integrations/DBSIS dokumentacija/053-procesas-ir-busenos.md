# Procesas ir būsenos

- Path: `/api-dok/dbsis-api/api-taikymas/epsdocumentws/procesas-ir-busenos`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/epsdocumentws/procesas-ir-busenos
- Index: 53

---

EPSDocumentWS proceso ir būsenų operacijos

### submitService

Pateikia paslaugos dokumentą vykdymui.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:submitService>
         <submitServiceParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
         </submitServiceParam>
      </eps:submitService>
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
      <eps:submitService>
         <submitServiceParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
         </submitServiceParam>
      </eps:submitService>
   </soapenv:Body>
</soapenv:Envelope>
""";

HttpClient client = HttpClient.newHttpClient();
HttpRequest request = HttpRequest.newBuilder()
    .uri(URI.create("https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS"))
    .header("Content-Type", "text/xml; charset=utf-8")
    .header("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/submitService")
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
      <eps:submitService>
         <submitServiceParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
         </submitServiceParam>
      </eps:submitService>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
using var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
content.Headers.Add("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/submitService");
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
    'submitServiceParam' => [
        'serviceDocumentOid' => 'SVC-001'
    ]
];

$result = $client->submitService($param);
echo $result->submitServiceResult->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/EPSDocumentWS/submitService"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:submitService>
         <submitServiceParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
         </submitServiceParam>
      </eps:submitService>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### execute

Pradeda paslaugos vykdymą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:execute>
         <executeParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
            <serviceExecutor>
               <orgName>UNIT_001</orgName>
            </serviceExecutor>
         </executeParam>
      </eps:execute>
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
      <eps:execute>
         <executeParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
            <serviceExecutor>
               <orgName>UNIT_001</orgName>
            </serviceExecutor>
         </executeParam>
      </eps:execute>
   </soapenv:Body>
</soapenv:Envelope>
""";

HttpClient client = HttpClient.newHttpClient();
HttpRequest request = HttpRequest.newBuilder()
    .uri(URI.create("https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS"))
    .header("Content-Type", "text/xml; charset=utf-8")
    .header("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/execute")
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
      <eps:execute>
         <executeParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
            <serviceExecutor>
               <orgName>UNIT_001</orgName>
            </serviceExecutor>
         </executeParam>
      </eps:execute>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
using var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
content.Headers.Add("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/execute");
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
    'executeParam' => [
        'serviceDocumentOid' => 'SVC-001',
        'serviceExecutor' => ['orgName' => 'UNIT_001']
    ]
];

$result = $client->execute($param);
echo $result->executeResult->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/EPSDocumentWS/execute"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:execute>
         <executeParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
            <serviceExecutor>
               <orgName>UNIT_001</orgName>
            </serviceExecutor>
         </executeParam>
      </eps:execute>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### finish

Užbaigia paslaugos vykdymą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:finish>
         <finishParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
            <resultText>Atlikta</resultText>
         </finishParam>
      </eps:finish>
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
      <eps:finish>
         <finishParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
            <resultText>Atlikta</resultText>
         </finishParam>
      </eps:finish>
   </soapenv:Body>
</soapenv:Envelope>
""";

HttpClient client = HttpClient.newHttpClient();
HttpRequest request = HttpRequest.newBuilder()
    .uri(URI.create("https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS"))
    .header("Content-Type", "text/xml; charset=utf-8")
    .header("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/execute")
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
      <eps:finish>
         <finishParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
            <resultText>Atlikta</resultText>
         </finishParam>
      </eps:finish>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
using var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
content.Headers.Add("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/execute");
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
    'finishParam' => [
        'serviceDocumentOid' => 'SVC-001',
        'resultText' => 'Atlikta'
    ]
];

$result = $client->finish($param);
echo $result->executeResult->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/EPSDocumentWS/execute"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:finish>
         <finishParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
            <resultText>Atlikta</resultText>
         </finishParam>
      </eps:finish>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### order

Pateikia užsakymą paslaugai.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:order>
         <orderParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
         </orderParam>
      </eps:order>
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
      <eps:order>
         <orderParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
         </orderParam>
      </eps:order>
   </soapenv:Body>
</soapenv:Envelope>
""";

HttpClient client = HttpClient.newHttpClient();
HttpRequest request = HttpRequest.newBuilder()
    .uri(URI.create("https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS"))
    .header("Content-Type", "text/xml; charset=utf-8")
    .header("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/order")
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
      <eps:order>
         <orderParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
         </orderParam>
      </eps:order>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
using var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
content.Headers.Add("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/order");
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
    'orderParam' => [
        'serviceDocumentOid' => 'SVC-001'
    ]
];

$result = $client->order($param);
echo $result->orderResult->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/EPSDocumentWS/order"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:order>
         <orderParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
         </orderParam>
      </eps:order>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### reject

Atmeta paslaugos dokumentą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:reject>
         <rejectParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
         </rejectParam>
      </eps:reject>
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
      <eps:reject>
         <rejectParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
         </rejectParam>
      </eps:reject>
   </soapenv:Body>
</soapenv:Envelope>
""";

HttpClient client = HttpClient.newHttpClient();
HttpRequest request = HttpRequest.newBuilder()
    .uri(URI.create("https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS"))
    .header("Content-Type", "text/xml; charset=utf-8")
    .header("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/reject")
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
      <eps:reject>
         <rejectParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
         </rejectParam>
      </eps:reject>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
using var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
content.Headers.Add("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/reject");
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
    'rejectParam' => [
        'serviceDocumentOid' => 'SVC-001'
    ]
];

$result = $client->reject($param);
echo $result->rejectResult->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/EPSDocumentWS/reject"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:reject>
         <rejectParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
         </rejectParam>
      </eps:reject>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### cancel

Atšaukia paslaugos dokumentą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:cancel>
         <cancelParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
            <cancelReasonText>Atšaukta</cancelReasonText>
         </cancelParam>
      </eps:cancel>
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
      <eps:cancel>
         <cancelParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
            <cancelReasonText>Atšaukta</cancelReasonText>
         </cancelParam>
      </eps:cancel>
   </soapenv:Body>
</soapenv:Envelope>
""";

HttpClient client = HttpClient.newHttpClient();
HttpRequest request = HttpRequest.newBuilder()
    .uri(URI.create("https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS"))
    .header("Content-Type", "text/xml; charset=utf-8")
    .header("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/cancel")
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
      <eps:cancel>
         <cancelParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
            <cancelReasonText>Atšaukta</cancelReasonText>
         </cancelParam>
      </eps:cancel>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
using var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
content.Headers.Add("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/cancel");
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
    'cancelParam' => [
        'serviceDocumentOid' => 'SVC-001',
        'cancelReasonText' => 'Atšaukta'
    ]
];

$result = $client->cancel($param);
echo $result->cancelResult->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/EPSDocumentWS/cancel"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:cancel>
         <cancelParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
            <cancelReasonText>Atšaukta</cancelReasonText>
         </cancelParam>
      </eps:cancel>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### markRevised

Pažymi paslaugos dokumentą kaip patikslintą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:markRevised>
         <markRevisedParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
         </markRevisedParam>
      </eps:markRevised>
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
      <eps:markRevised>
         <markRevisedParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
         </markRevisedParam>
      </eps:markRevised>
   </soapenv:Body>
</soapenv:Envelope>
""";

HttpClient client = HttpClient.newHttpClient();
HttpRequest request = HttpRequest.newBuilder()
    .uri(URI.create("https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS"))
    .header("Content-Type", "text/xml; charset=utf-8")
    .header("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/markRevised")
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
      <eps:markRevised>
         <markRevisedParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
         </markRevisedParam>
      </eps:markRevised>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
using var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
content.Headers.Add("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/markRevised");
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
    'markRevisedParam' => [
        'serviceDocumentOid' => 'SVC-001'
    ]
];

$result = $client->markRevised($param);
echo $result->markRevisedResult->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/EPSDocumentWS/markRevised"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:markRevised>
         <markRevisedParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
         </markRevisedParam>
      </eps:markRevised>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### modifyServiceCheckList

Atnaujina paslaugos patikros sąrašą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:modifyServiceCheckList>
         <modifyServiceCheckListParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
            <checkListItem>
               <name>Dokumentas pateiktas</name>
               <checked>true</checked>
            </checkListItem>
         </modifyServiceCheckListParam>
      </eps:modifyServiceCheckList>
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
      <eps:modifyServiceCheckList>
         <modifyServiceCheckListParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
            <checkListItem>
               <name>Dokumentas pateiktas</name>
               <checked>true</checked>
            </checkListItem>
         </modifyServiceCheckListParam>
      </eps:modifyServiceCheckList>
   </soapenv:Body>
</soapenv:Envelope>
""";

HttpClient client = HttpClient.newHttpClient();
HttpRequest request = HttpRequest.newBuilder()
    .uri(URI.create("https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS"))
    .header("Content-Type", "text/xml; charset=utf-8")
    .header("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/modifyServiceCheckList")
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
      <eps:modifyServiceCheckList>
         <modifyServiceCheckListParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
            <checkListItem>
               <name>Dokumentas pateiktas</name>
               <checked>true</checked>
            </checkListItem>
         </modifyServiceCheckListParam>
      </eps:modifyServiceCheckList>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
using var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
content.Headers.Add("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/modifyServiceCheckList");
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
    'modifyServiceCheckListParam' => [
        'serviceDocumentOid' => 'SVC-001',
        'checkListItem' => [
            ['name' => 'Dokumentas pateiktas', 'checked' => true]
        ]
    ]
];

$result = $client->modifyServiceCheckList($param);
echo $result->modifyServiceCheckListResult->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/EPSDocumentWS/modifyServiceCheckList"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:modifyServiceCheckList>
         <modifyServiceCheckListParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
            <checkListItem>
               <name>Dokumentas pateiktas</name>
               <checked>true</checked>
            </checkListItem>
         </modifyServiceCheckListParam>
      </eps:modifyServiceCheckList>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### addPaymentEntry

Įrašo apmokėjimo informaciją.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:addPaymentEntry>
         <addPaymentParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
            <paid>true</paid>
            <paymentEntry>
               <sum>25.00</sum>
               <date>2024-01-15T10:00:00Z</date>
               <documentNr>INV-001</documentNr>
            </paymentEntry>
         </addPaymentParam>
      </eps:addPaymentEntry>
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
      <eps:addPaymentEntry>
         <addPaymentParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
            <paid>true</paid>
            <paymentEntry>
               <sum>25.00</sum>
               <date>2024-01-15T10:00:00Z</date>
               <documentNr>INV-001</documentNr>
            </paymentEntry>
         </addPaymentParam>
      </eps:addPaymentEntry>
   </soapenv:Body>
</soapenv:Envelope>
""";

HttpClient client = HttpClient.newHttpClient();
HttpRequest request = HttpRequest.newBuilder()
    .uri(URI.create("https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS"))
    .header("Content-Type", "text/xml; charset=utf-8")
    .header("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/addPaymentEntry")
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
      <eps:addPaymentEntry>
         <addPaymentParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
            <paid>true</paid>
            <paymentEntry>
               <sum>25.00</sum>
               <date>2024-01-15T10:00:00Z</date>
               <documentNr>INV-001</documentNr>
            </paymentEntry>
         </addPaymentParam>
      </eps:addPaymentEntry>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
using var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
content.Headers.Add("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/addPaymentEntry");
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
    'addPaymentParam' => [
        'serviceDocumentOid' => 'SVC-001',
        'paid' => true,
        'paymentEntry' => [
            'sum' => '25.00',
            'date' => '2024-01-15T10:00:00Z',
            'documentNr' => 'INV-001'
        ]
    ]
];

$result = $client->addPaymentEntry($param);
echo $result->addPaymentResult->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/EPSDocumentWS/addPaymentEntry"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:addPaymentEntry>
         <addPaymentParam>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
            <paid>true</paid>
            <paymentEntry>
               <sum>25.00</sum>
               <date>2024-01-15T10:00:00Z</date>
               <documentNr>INV-001</documentNr>
            </paymentEntry>
         </addPaymentParam>
      </eps:addPaymentEntry>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija
