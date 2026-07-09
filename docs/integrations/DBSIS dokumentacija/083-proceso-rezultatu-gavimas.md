# Proceso rezultatų gavimas

- Path: `/api-dok/dbsis-api/api-taikymas/rdodocumentws/proceso-rezultatu-gavimas`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/rdodocumentws/proceso-rezultatu-gavimas
- Index: 83

---

RDODocumentWS proceso rezultatų gavimo operacijos

### getApprovalResult

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_2237-operacija-getapprovalresult)

Gauna tvirtinimo proceso rezultatus.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:getApprovalResult>
         <getApprovalResultParam>
            <docOid>DOC_12345</docOid>
         </getApprovalResultParam>
      </rdo:getApprovalResult>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetProcessTasksParam param = new GetProcessTasksParam();
param.setDocOid("DOC_12345");

GetProcessTasks result = port.getApprovalResult(param);
System.out.println("Aktyvios užduotys: " + result.getActiveProcessTasks());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:getApprovalResult>
         <getApprovalResultParam>
            <docOid>DOC_12345</docOid>
         </getApprovalResultParam>
      </rdo:getApprovalResult>
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
    'getApprovalResultParam' => [
        'docOid' => 'DOC_12345'
    ]
];

$result = $client->getApprovalResult($param);
var_dump($result->processTasks);
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: \"\"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:getApprovalResult>
         <getApprovalResultParam>
            <docOid>DOC_12345</docOid>
         </getApprovalResultParam>
      </rdo:getApprovalResult>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getSigningResult

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_2238-operacija-getsigningresult)

Gauna pasirašymo proceso rezultatus.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:getSigningResult>
         <getSigningResultParam>
            <docOid>DOC_12345</docOid>
         </getSigningResultParam>
      </rdo:getSigningResult>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetProcessTasksParam param = new GetProcessTasksParam();
param.setDocOid("DOC_12345");

GetProcessTasks result = port.getSigningResult(param);
System.out.println("Aktyvios užduotys: " + result.getActiveProcessTasks());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:getSigningResult>
         <getSigningResultParam>
            <docOid>DOC_12345</docOid>
         </getSigningResultParam>
      </rdo:getSigningResult>
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
    'getSigningResultParam' => [
        'docOid' => 'DOC_12345'
    ]
];

$result = $client->getSigningResult($param);
var_dump($result->processTasks);
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: \"\"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:getSigningResult>
         <getSigningResultParam>
            <docOid>DOC_12345</docOid>
         </getSigningResultParam>
      </rdo:getSigningResult>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getReviewResult

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_2236-operacija-getreviewresult)

Gauna peržiūros proceso rezultatus.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:getReviewResult>
         <getReviewResultParam>
            <docOid>DOC_12345</docOid>
         </getReviewResultParam>
      </rdo:getReviewResult>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetProcessTasksParam param = new GetProcessTasksParam();
param.setDocOid("DOC_12345");

GetProcessTasks result = port.getReviewResult(param);
System.out.println("Aktyvios užduotys: " + result.getActiveProcessTasks());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:getReviewResult>
         <getReviewResultParam>
            <docOid>DOC_12345</docOid>
         </getReviewResultParam>
      </rdo:getReviewResult>
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
    'getReviewResultParam' => [
        'docOid' => 'DOC_12345'
    ]
];

$result = $client->getReviewResult($param);
var_dump($result->processTasks);
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: \"\"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:getReviewResult>
         <getReviewResultParam>
            <docOid>DOC_12345</docOid>
         </getReviewResultParam>
      </rdo:getReviewResult>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getConfirmationResult

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja#_2239-operacija-getconfirmationresult)

Gauna patvirtinimo proceso rezultatus.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:getConfirmationResult>
         <getConfirmationResultParam>
            <docOid>DOC_12345</docOid>
         </getConfirmationResultParam>
      </rdo:getConfirmationResult>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetProcessTasksParam param = new GetProcessTasksParam();
param.setDocOid("DOC_12345");

GetProcessTasks result = port.getConfirmationResult(param);
System.out.println("Aktyvios užduotys: " + result.getActiveProcessTasks());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=""1.0"" encoding=""UTF-8""?>
<soapenv:Envelope xmlns:soapenv=""http://schemas.xmlsoap.org/soap/envelope/""
                  xmlns:rdo=""http://www.sintagma.lt/avilys/RDODocumentWS"">
   <soapenv:Body>
      <rdo:getConfirmationResult>
         <getConfirmationResultParam>
            <docOid>DOC_12345</docOid>
         </getConfirmationResultParam>
      </rdo:getConfirmationResult>
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
    'getConfirmationResultParam' => [
        'docOid' => 'DOC_12345'
    ]
];

$result = $client->getConfirmationResult($param);
var_dump($result->processTasks);
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: \"\"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:rdo="http://www.sintagma.lt/avilys/RDODocumentWS">
   <soapenv:Body>
      <rdo:getConfirmationResult>
         <getConfirmationResultParam>
            <docOid>DOC_12345</docOid>
         </getConfirmationResultParam>
      </rdo:getConfirmationResult>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---
