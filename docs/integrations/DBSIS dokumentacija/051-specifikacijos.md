# Specifikacijos

- Path: `/api-dok/dbsis-api/api-taikymas/epsdocumentws/specifikacijos`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/epsdocumentws/specifikacijos
- Index: 51

---

EPSDocumentWS specifikacijų operacijos

### getServiceSpecificationList

Grąžina paslaugų specifikacijų sąrašą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:getServiceSpecificationList>
         <getServiceSpecificationListParam>
            <searchParameters>
               <entry>
                  <key>title</key>
                  <value>Specifikacija</value>
               </entry>
            </searchParameters>
            <pageSize>10</pageSize>
            <pageNum>1</pageNum>
         </getServiceSpecificationListParam>
      </eps:getServiceSpecificationList>
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
      <eps:getServiceSpecificationList>
         <getServiceSpecificationListParam>
            <searchParameters>
               <entry>
                  <key>title</key>
                  <value>Specifikacija</value>
               </entry>
            </searchParameters>
            <pageSize>10</pageSize>
            <pageNum>1</pageNum>
         </getServiceSpecificationListParam>
      </eps:getServiceSpecificationList>
   </soapenv:Body>
</soapenv:Envelope>
""";

HttpClient client = HttpClient.newHttpClient();
HttpRequest request = HttpRequest.newBuilder()
    .uri(URI.create("https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS"))
    .header("Content-Type", "text/xml; charset=utf-8")
    .header("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/getServiceSpecificationList")
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
      <eps:getServiceSpecificationList>
         <getServiceSpecificationListParam>
            <searchParameters>
               <entry>
                  <key>title</key>
                  <value>Specifikacija</value>
               </entry>
            </searchParameters>
            <pageSize>10</pageSize>
            <pageNum>1</pageNum>
         </getServiceSpecificationListParam>
      </eps:getServiceSpecificationList>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
using var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
content.Headers.Add("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/getServiceSpecificationList");
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
    'getServiceSpecificationListParam' => [
        'searchParameters' => [
            'entry' => [
                ['key' => 'title', 'value' => 'Specifikacija']
            ]
        ],
        'pageSize' => 10,
        'pageNum' => 1
    ]
];

$result = $client->getServiceSpecificationList($param);
echo $result->serviceSpecificationList->totalDocumentsFound . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/EPSDocumentWS/getServiceSpecificationList"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:getServiceSpecificationList>
         <getServiceSpecificationListParam>
            <searchParameters>
               <entry>
                  <key>title</key>
                  <value>Specifikacija</value>
               </entry>
            </searchParameters>
            <pageSize>10</pageSize>
            <pageNum>1</pageNum>
         </getServiceSpecificationListParam>
      </eps:getServiceSpecificationList>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getServiceSpecification

Grąžina paslaugos specifikaciją pagal OID.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:getServiceSpecification>
         <getServiceSpecificationParam>
            <docOid>SPEC-001</docOid>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
            <retrieveElectroContainer>METADATA</retrieveElectroContainer>
            <retrieveProcessTasks>false</retrieveProcessTasks>
         </getServiceSpecificationParam>
      </eps:getServiceSpecification>
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
      <eps:getServiceSpecification>
         <getServiceSpecificationParam>
            <docOid>SPEC-001</docOid>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
            <retrieveElectroContainer>METADATA</retrieveElectroContainer>
            <retrieveProcessTasks>false</retrieveProcessTasks>
         </getServiceSpecificationParam>
      </eps:getServiceSpecification>
   </soapenv:Body>
</soapenv:Envelope>
""";

HttpClient client = HttpClient.newHttpClient();
HttpRequest request = HttpRequest.newBuilder()
    .uri(URI.create("https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS"))
    .header("Content-Type", "text/xml; charset=utf-8")
    .header("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/getServiceSpecification")
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
      <eps:getServiceSpecification>
         <getServiceSpecificationParam>
            <docOid>SPEC-001</docOid>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
            <retrieveElectroContainer>METADATA</retrieveElectroContainer>
            <retrieveProcessTasks>false</retrieveProcessTasks>
         </getServiceSpecificationParam>
      </eps:getServiceSpecification>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
using var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
content.Headers.Add("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/getServiceSpecification");
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
    'getServiceSpecificationParam' => [
        'docOid' => 'SPEC-001',
        'retrieveBodyAttachment' => 'METADATA',
        'retrieveElectroContainer' => 'METADATA',
        'retrieveProcessTasks' => false
    ]
];

$result = $client->getServiceSpecification($param);
echo $result->serviceSpecification->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/EPSDocumentWS/getServiceSpecification"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:getServiceSpecification>
         <getServiceSpecificationParam>
            <docOid>SPEC-001</docOid>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
            <retrieveElectroContainer>METADATA</retrieveElectroContainer>
            <retrieveProcessTasks>false</retrieveProcessTasks>
         </getServiceSpecificationParam>
      </eps:getServiceSpecification>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getSpecificationAttachment

Grąžina specifikacijos priedą pagal OID.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:getSpecificationAttachment>
         <getAttachmentParam>
            <docOid>SPEC-001</docOid>
            <oid>ATT-001</oid>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
         </getAttachmentParam>
      </eps:getSpecificationAttachment>
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
      <eps:getSpecificationAttachment>
         <getAttachmentParam>
            <docOid>SPEC-001</docOid>
            <oid>ATT-001</oid>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
         </getAttachmentParam>
      </eps:getSpecificationAttachment>
   </soapenv:Body>
</soapenv:Envelope>
""";

HttpClient client = HttpClient.newHttpClient();
HttpRequest request = HttpRequest.newBuilder()
    .uri(URI.create("https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS"))
    .header("Content-Type", "text/xml; charset=utf-8")
    .header("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/getSpecificationAttachment")
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
      <eps:getSpecificationAttachment>
         <getAttachmentParam>
            <docOid>SPEC-001</docOid>
            <oid>ATT-001</oid>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
         </getAttachmentParam>
      </eps:getSpecificationAttachment>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
using var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
content.Headers.Add("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/getSpecificationAttachment");
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
        'docOid' => 'SPEC-001',
        'oid' => 'ATT-001',
        'retrieveBodyAttachment' => 'METADATA'
    ]
];

$result = $client->getSpecificationAttachment($param);
echo $result->attachment->bodyAttachment->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/EPSDocumentWS/getSpecificationAttachment"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:getSpecificationAttachment>
         <getAttachmentParam>
            <docOid>SPEC-001</docOid>
            <oid>ATT-001</oid>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
         </getAttachmentParam>
      </eps:getSpecificationAttachment>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija
