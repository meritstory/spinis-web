# Formos ir šablonai

- Path: `/api-dok/dbsis-api/api-taikymas/epsdocumentws/formos-ir-sablonai`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/epsdocumentws/formos-ir-sablonai
- Index: 50

---

EPSDocumentWS formų ir šablonų operacijos

### getServiceForm

Grąžina paslaugos formos aprašą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:getServiceForm>
         <getServiceFormParam>
            <formOid>FORM-001</formOid>
         </getServiceFormParam>
      </eps:getServiceForm>
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
      <eps:getServiceForm>
         <getServiceFormParam>
            <formOid>FORM-001</formOid>
         </getServiceFormParam>
      </eps:getServiceForm>
   </soapenv:Body>
</soapenv:Envelope>
""";

HttpClient client = HttpClient.newHttpClient();
HttpRequest request = HttpRequest.newBuilder()
    .uri(URI.create("https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS"))
    .header("Content-Type", "text/xml; charset=utf-8")
    .header("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/getServiceForm")
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
      <eps:getServiceForm>
         <getServiceFormParam>
            <formOid>FORM-001</formOid>
         </getServiceFormParam>
      </eps:getServiceForm>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
using var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
content.Headers.Add("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/getServiceForm");
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
    'getServiceFormParam' => [
        'formOid' => 'FORM-001'
    ]
];

$result = $client->getServiceForm($param);
echo $result->serviceForm->formOid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/EPSDocumentWS/getServiceForm"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:getServiceForm>
         <getServiceFormParam>
            <formOid>FORM-001</formOid>
         </getServiceFormParam>
      </eps:getServiceForm>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getServiceFormListByTemplate

Grąžina formų sąrašą pagal šabloną.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:getServiceFormListByTemplate>
         <getServiceFormListByTemplateParam>
            <serviceTemplateOid>TEMPLATE-001</serviceTemplateOid>
         </getServiceFormListByTemplateParam>
      </eps:getServiceFormListByTemplate>
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
      <eps:getServiceFormListByTemplate>
         <getServiceFormListByTemplateParam>
            <serviceTemplateOid>TEMPLATE-001</serviceTemplateOid>
         </getServiceFormListByTemplateParam>
      </eps:getServiceFormListByTemplate>
   </soapenv:Body>
</soapenv:Envelope>
""";

HttpClient client = HttpClient.newHttpClient();
HttpRequest request = HttpRequest.newBuilder()
    .uri(URI.create("https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS"))
    .header("Content-Type", "text/xml; charset=utf-8")
    .header("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/getServiceFormListByTemplate")
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
      <eps:getServiceFormListByTemplate>
         <getServiceFormListByTemplateParam>
            <serviceTemplateOid>TEMPLATE-001</serviceTemplateOid>
         </getServiceFormListByTemplateParam>
      </eps:getServiceFormListByTemplate>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
using var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
content.Headers.Add("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/getServiceFormListByTemplate");
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
    'getServiceFormListByTemplateParam' => [
        'serviceTemplateOid' => 'TEMPLATE-001'
    ]
];

$result = $client->getServiceFormListByTemplate($param);
$forms = $result->getServiceFormListByTemplate->form ?? [];
echo count($forms) . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/EPSDocumentWS/getServiceFormListByTemplate"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:getServiceFormListByTemplate>
         <getServiceFormListByTemplateParam>
            <serviceTemplateOid>TEMPLATE-001</serviceTemplateOid>
         </getServiceFormListByTemplateParam>
      </eps:getServiceFormListByTemplate>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getFormFieldValues

Grąžina formos laukų reikšmes.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:getFormFieldValues>
         <getFormFieldValuesParam>
            <formOid>FORM-001</formOid>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
         </getFormFieldValuesParam>
      </eps:getFormFieldValues>
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
      <eps:getFormFieldValues>
         <getFormFieldValuesParam>
            <formOid>FORM-001</formOid>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
         </getFormFieldValuesParam>
      </eps:getFormFieldValues>
   </soapenv:Body>
</soapenv:Envelope>
""";

HttpClient client = HttpClient.newHttpClient();
HttpRequest request = HttpRequest.newBuilder()
    .uri(URI.create("https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS"))
    .header("Content-Type", "text/xml; charset=utf-8")
    .header("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/getFormFieldValues")
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
      <eps:getFormFieldValues>
         <getFormFieldValuesParam>
            <formOid>FORM-001</formOid>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
         </getFormFieldValuesParam>
      </eps:getFormFieldValues>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
using var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
content.Headers.Add("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/getFormFieldValues");
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
    'getFormFieldValuesParam' => [
        'formOid' => 'FORM-001',
        'serviceDocumentOid' => 'SVC-001'
    ]
];

$result = $client->getFormFieldValues($param);
$fields = $result->serviceFormFieldValues->fieldValue ?? [];
echo count($fields) . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/EPSDocumentWS/getFormFieldValues"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:getFormFieldValues>
         <getFormFieldValuesParam>
            <formOid>FORM-001</formOid>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
         </getFormFieldValuesParam>
      </eps:getFormFieldValues>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### dataInput

Įrašo formos laukų reikšmes.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:dataInput>
         <dataInputParam>
            <formOid>FORM-001</formOid>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
            <fieldValue>
               <fieldName>title</fieldName>
               <fieldValue>Reikšmė</fieldValue>
            </fieldValue>
         </dataInputParam>
      </eps:dataInput>
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
      <eps:dataInput>
         <dataInputParam>
            <formOid>FORM-001</formOid>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
            <fieldValue>
               <fieldName>title</fieldName>
               <fieldValue>Reikšmė</fieldValue>
            </fieldValue>
         </dataInputParam>
      </eps:dataInput>
   </soapenv:Body>
</soapenv:Envelope>
""";

HttpClient client = HttpClient.newHttpClient();
HttpRequest request = HttpRequest.newBuilder()
    .uri(URI.create("https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS"))
    .header("Content-Type", "text/xml; charset=utf-8")
    .header("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/dataInput")
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
      <eps:dataInput>
         <dataInputParam>
            <formOid>FORM-001</formOid>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
            <fieldValue>
               <fieldName>title</fieldName>
               <fieldValue>Reikšmė</fieldValue>
            </fieldValue>
         </dataInputParam>
      </eps:dataInput>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
using var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
content.Headers.Add("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/dataInput");
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
    'dataInputParam' => [
        'formOid' => 'FORM-001',
        'serviceDocumentOid' => 'SVC-001',
        'fieldValue' => [
            ['fieldName' => 'title', 'fieldValue' => 'Reikšmė']
        ]
    ]
];

$result = $client->dataInput($param);
echo $result->dataInputResult->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/EPSDocumentWS/dataInput"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:dataInput>
         <dataInputParam>
            <formOid>FORM-001</formOid>
            <serviceDocumentOid>SVC-001</serviceDocumentOid>
            <fieldValue>
               <fieldName>title</fieldName>
               <fieldValue>Reikšmė</fieldValue>
            </fieldValue>
         </dataInputParam>
      </eps:dataInput>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getServiceTemplate

Grąžina paslaugos šabloną pagal OID.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:getServiceTemplate>
         <getServiceTemplateParam>
            <docOid>TEMPLATE-001</docOid>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
            <retrieveElectroContainer>METADATA</retrieveElectroContainer>
            <retrieveProcessTasks>false</retrieveProcessTasks>
         </getServiceTemplateParam>
      </eps:getServiceTemplate>
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
      <eps:getServiceTemplate>
         <getServiceTemplateParam>
            <docOid>TEMPLATE-001</docOid>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
            <retrieveElectroContainer>METADATA</retrieveElectroContainer>
            <retrieveProcessTasks>false</retrieveProcessTasks>
         </getServiceTemplateParam>
      </eps:getServiceTemplate>
   </soapenv:Body>
</soapenv:Envelope>
""";

HttpClient client = HttpClient.newHttpClient();
HttpRequest request = HttpRequest.newBuilder()
    .uri(URI.create("https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS"))
    .header("Content-Type", "text/xml; charset=utf-8")
    .header("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/getServiceTemplate")
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
      <eps:getServiceTemplate>
         <getServiceTemplateParam>
            <docOid>TEMPLATE-001</docOid>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
            <retrieveElectroContainer>METADATA</retrieveElectroContainer>
            <retrieveProcessTasks>false</retrieveProcessTasks>
         </getServiceTemplateParam>
      </eps:getServiceTemplate>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
using var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
content.Headers.Add("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/getServiceTemplate");
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
    'getServiceTemplateParam' => [
        'docOid' => 'TEMPLATE-001',
        'retrieveBodyAttachment' => 'METADATA',
        'retrieveElectroContainer' => 'METADATA',
        'retrieveProcessTasks' => false
    ]
];

$result = $client->getServiceTemplate($param);
echo $result->serviceTemplate->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/EPSDocumentWS/getServiceTemplate"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:getServiceTemplate>
         <getServiceTemplateParam>
            <docOid>TEMPLATE-001</docOid>
            <retrieveBodyAttachment>METADATA</retrieveBodyAttachment>
            <retrieveElectroContainer>METADATA</retrieveElectroContainer>
            <retrieveProcessTasks>false</retrieveProcessTasks>
         </getServiceTemplateParam>
      </eps:getServiceTemplate>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getServiceTemplateListBySpecification

Grąžina paslaugos šablonų sąrašą pagal specifikaciją.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:getServiceTemplateListBySpecification>
         <getServiceTemplateListBySpecificationParam>
            <serviceSpecOid>SPEC-001</serviceSpecOid>
         </getServiceTemplateListBySpecificationParam>
      </eps:getServiceTemplateListBySpecification>
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
      <eps:getServiceTemplateListBySpecification>
         <getServiceTemplateListBySpecificationParam>
            <serviceSpecOid>SPEC-001</serviceSpecOid>
         </getServiceTemplateListBySpecificationParam>
      </eps:getServiceTemplateListBySpecification>
   </soapenv:Body>
</soapenv:Envelope>
""";

HttpClient client = HttpClient.newHttpClient();
HttpRequest request = HttpRequest.newBuilder()
    .uri(URI.create("https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS"))
    .header("Content-Type", "text/xml; charset=utf-8")
    .header("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/getServiceTemplateListBySpecification")
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
      <eps:getServiceTemplateListBySpecification>
         <getServiceTemplateListBySpecificationParam>
            <serviceSpecOid>SPEC-001</serviceSpecOid>
         </getServiceTemplateListBySpecificationParam>
      </eps:getServiceTemplateListBySpecification>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
using var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
content.Headers.Add("SOAPAction", "http://www.sintagma.lt/avilys/EPSDocumentWS/getServiceTemplateListBySpecification");
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
    'getServiceTemplateListBySpecificationParam' => [
        'serviceSpecOid' => 'SPEC-001'
    ]
];

$result = $client->getServiceTemplateListBySpecification($param);
echo $result->serviceTemplateList->totalDocumentsFound . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/EPSDocumentWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/EPSDocumentWS/getServiceTemplateListBySpecification"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://www.sintagma.lt/avilys/EPSDocumentWS">
   <soapenv:Body>
      <eps:getServiceTemplateListBySpecification>
         <getServiceTemplateListBySpecificationParam>
            <serviceSpecOid>SPEC-001</serviceSpecOid>
         </getServiceTemplateListBySpecificationParam>
      </eps:getServiceTemplateListBySpecification>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija
