# Integracija

- Path: `/api-dok/dbsis-api/api-taikymas/dhsadapter/integracija`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/dhsadapter/integracija
- Index: 38

---

DhsAdapter integracijos operacijos

### createApplicationDocument

Sukuria naują prašymo dokumentą per VIISP DHS adapterį.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:dhs="http://viisp.asseco.lt/DhsAdapter"
                  xmlns:viisp="http://viisp.asseco.lt/ViispDhsAdapter"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
   <soapenv:Body>
      <dhs:CreateApplicationDocument>
         <idBlock>
            <msgId>MSG-001</msgId>
            <messageCreationDate>2024-01-15T10:00:00Z</messageCreationDate>
            <viispServiceCode>SRV-001</viispServiceCode>
            <viispProcessId>PROC-001</viispProcessId>
            <viispApplicationId>APP-001</viispApplicationId>
         </idBlock>
         <revisedApplication>false</revisedApplication>
         <applicationDate>2024-01-15</applicationDate>
         <deliveryTime>2024-01-20T12:00:00Z</deliveryTime>
         <serviceProvider>
            <providerOrgCode>123456789</providerOrgCode>
            <providerName>Įstaigos pavadinimas</providerName>
         </serviceProvider>
         <serviceInfo>
            <serviceCode>SERVICE-001</serviceCode>
            <serviceSubtype>SUB</serviceSubtype>
         </serviceInfo>
         <customer xsi:type="viisp:OrgContact">
            <email>info@pavyzdys.lt</email>
            <phone>+37060000000</phone>
            <address>Vilniaus g. 1, Vilnius</address>
            <code>123456789</code>
            <name>UAB Pavyzdys</name>
            <legalForm>UAB</legalForm>
         </customer>
         <applicant xsi:type="viisp:IndividualContact">
            <email>vardas.pavarde@pavyzdys.lt</email>
            <phone>+37060000001</phone>
            <address>Kauno g. 2, Vilnius</address>
            <code>39001010000</code>
            <name>Vardas</name>
            <surname>Pavardė</surname>
            <birthdate>1990-01-01</birthdate>
         </applicant>
         <applicationData>
            <applicationSubmissionForm>Elektroninė</applicationSubmissionForm>
            <applicationMainContent>
               <fileName>prasymas.pdf</fileName>
               <mimeType>application/pdf</mimeType>
               <data>BASE64_PDF</data>
            </applicationMainContent>
            <applicationStructureData>
               <pairs>
                  <key>theme</key>
                  <value>
                     <stringValue>Paramos prašymas</stringValue>
                  </value>
               </pairs>
            </applicationStructureData>
         </applicationData>
      </dhs:CreateApplicationDocument>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
CreateApplicationDocument request = new CreateApplicationDocument();

IdBlock idBlock = new IdBlock();
idBlock.setMsgId("MSG-001");
idBlock.setMessageCreationDate(javax.xml.datatype.DatatypeFactory.newInstance()
    .newXMLGregorianCalendar("2024-01-15T10:00:00Z"));
idBlock.setViispServiceCode("SRV-001");
idBlock.setViispProcessId("PROC-001");
idBlock.setViispApplicationId("APP-001");
request.setIdBlock(idBlock);

request.setRevisedApplication(false);
request.setApplicationDate(javax.xml.datatype.DatatypeFactory.newInstance()
    .newXMLGregorianCalendarDate(2024, 1, 15, 0));

ServiceProvider serviceProvider = new ServiceProvider();
serviceProvider.setProviderOrgCode(new java.math.BigDecimal("123456789"));
serviceProvider.setProviderName("Įstaigos pavadinimas");
request.setServiceProvider(serviceProvider);

ServiceInfo serviceInfo = new ServiceInfo();
serviceInfo.setServiceCode("SERVICE-001");
serviceInfo.setServiceSubtype("SUB");
request.setServiceInfo(serviceInfo);

OrgContact customer = new OrgContact();
customer.setEmail("info@pavyzdys.lt");
customer.setPhone("+37060000000");
customer.setAddress("Vilniaus g. 1, Vilnius");
customer.setCode(new java.math.BigDecimal("123456789"));
customer.setName("UAB Pavyzdys");
customer.setLegalForm("UAB");
request.setCustomer(customer);

IndividualContact applicant = new IndividualContact();
applicant.setEmail("vardas.pavarde@pavyzdys.lt");
applicant.setPhone("+37060000001");
applicant.setAddress("Kauno g. 2, Vilnius");
applicant.setCode(new java.math.BigDecimal("39001010000"));
applicant.setName("Vardas");
applicant.setSurname("Pavardė");
request.setApplicant(applicant);

ApplicationData applicationData = new ApplicationData();
applicationData.setApplicationSubmissionForm("Elektroninė");
Attachment mainContent = new Attachment();
mainContent.setFileName("prasymas.pdf");
mainContent.setMimeType("application/pdf");
mainContent.setData("BASE64_PDF".getBytes());
applicationData.setApplicationMainContent(mainContent);
request.setApplicationData(applicationData);

CreateApplicationDocumentResponse response = port.createApplicationDocument(request);
System.out.println(response.getRegistrationNumber());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:dhs=\"http://viisp.asseco.lt/DhsAdapter\"
                  xmlns:viisp=\"http://viisp.asseco.lt/ViispDhsAdapter\"
                  xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\">
   <soapenv:Body>
      <dhs:CreateApplicationDocument>
         <idBlock>
            <msgId>MSG-001</msgId>
            <messageCreationDate>2024-01-15T10:00:00Z</messageCreationDate>
            <viispServiceCode>SRV-001</viispServiceCode>
            <viispProcessId>PROC-001</viispProcessId>
            <viispApplicationId>APP-001</viispApplicationId>
         </idBlock>
         <revisedApplication>false</revisedApplication>
         <applicationDate>2024-01-15</applicationDate>
         <deliveryTime>2024-01-20T12:00:00Z</deliveryTime>
         <serviceProvider>
            <providerOrgCode>123456789</providerOrgCode>
            <providerName>Įstaigos pavadinimas</providerName>
         </serviceProvider>
         <serviceInfo>
            <serviceCode>SERVICE-001</serviceCode>
            <serviceSubtype>SUB</serviceSubtype>
         </serviceInfo>
         <customer xsi:type=\"viisp:OrgContact\">
            <email>info@pavyzdys.lt</email>
            <phone>+37060000000</phone>
            <address>Vilniaus g. 1, Vilnius</address>
            <code>123456789</code>
            <name>UAB Pavyzdys</name>
            <legalForm>UAB</legalForm>
         </customer>
         <applicant xsi:type=\"viisp:IndividualContact\">
            <email>vardas.pavarde@pavyzdys.lt</email>
            <phone>+37060000001</phone>
            <address>Kauno g. 2, Vilnius</address>
            <code>39001010000</code>
            <name>Vardas</name>
            <surname>Pavardė</surname>
            <birthdate>1990-01-01</birthdate>
         </applicant>
         <applicationData>
            <applicationSubmissionForm>Elektroninė</applicationSubmissionForm>
            <applicationMainContent>
               <fileName>prasymas.pdf</fileName>
               <mimeType>application/pdf</mimeType>
               <data>BASE64_PDF</data>
            </applicationMainContent>
            <applicationStructureData>
               <pairs>
                  <key>theme</key>
                  <value>
                     <stringValue>Paramos prašymas</stringValue>
                  </value>
               </pairs>
            </applicationStructureData>
         </applicationData>
      </dhs:CreateApplicationDocument>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/DhsAdapter",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/DhsAdapter?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'idBlock' => [
        'msgId' => 'MSG-001',
        'messageCreationDate' => '2024-01-15T10:00:00Z',
        'viispServiceCode' => 'SRV-001',
        'viispProcessId' => 'PROC-001',
        'viispApplicationId' => 'APP-001'
    ],
    'revisedApplication' => false,
    'applicationDate' => '2024-01-15',
    'deliveryTime' => '2024-01-20T12:00:00Z',
    'serviceProvider' => [
        'providerOrgCode' => '123456789',
        'providerName' => 'Įstaigos pavadinimas'
    ],
    'serviceInfo' => [
        'serviceCode' => 'SERVICE-001',
        'serviceSubtype' => 'SUB'
    ],
    'customer' => [
        'email' => 'info@pavyzdys.lt',
        'phone' => '+37060000000',
        'address' => 'Vilniaus g. 1, Vilnius',
        'code' => '123456789',
        'name' => 'UAB Pavyzdys',
        'legalForm' => 'UAB'
    ],
    'applicant' => [
        'email' => 'vardas.pavarde@pavyzdys.lt',
        'phone' => '+37060000001',
        'address' => 'Kauno g. 2, Vilnius',
        'code' => '39001010000',
        'name' => 'Vardas',
        'surname' => 'Pavardė',
        'birthdate' => '1990-01-01'
    ],
    'applicationData' => [
        'applicationSubmissionForm' => 'Elektroninė',
        'applicationMainContent' => [
            'fileName' => 'prasymas.pdf',
            'mimeType' => 'application/pdf',
            'data' => 'BASE64_PDF'
        ],
        'applicationStructureData' => [
            'pairs' => [
                'key' => 'theme',
                'value' => ['stringValue' => 'Paramos prašymas']
            ]
        ]
    ]
];

$result = $client->createApplicationDocument($param);
echo $result->registrationNumber . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/DhsAdapter' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://viisp.asseco.lt/DhsAdapter/createApplicationDocument"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:dhs="http://viisp.asseco.lt/DhsAdapter"
                  xmlns:viisp="http://viisp.asseco.lt/ViispDhsAdapter"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
   <soapenv:Body>
      <dhs:CreateApplicationDocument>
         <idBlock>
            <msgId>MSG-001</msgId>
            <messageCreationDate>2024-01-15T10:00:00Z</messageCreationDate>
            <viispServiceCode>SRV-001</viispServiceCode>
            <viispProcessId>PROC-001</viispProcessId>
            <viispApplicationId>APP-001</viispApplicationId>
         </idBlock>
         <revisedApplication>false</revisedApplication>
         <applicationDate>2024-01-15</applicationDate>
         <deliveryTime>2024-01-20T12:00:00Z</deliveryTime>
         <serviceProvider>
            <providerOrgCode>123456789</providerOrgCode>
            <providerName>Įstaigos pavadinimas</providerName>
         </serviceProvider>
         <serviceInfo>
            <serviceCode>SERVICE-001</serviceCode>
            <serviceSubtype>SUB</serviceSubtype>
         </serviceInfo>
         <customer xsi:type="viisp:OrgContact">
            <email>info@pavyzdys.lt</email>
            <phone>+37060000000</phone>
            <address>Vilniaus g. 1, Vilnius</address>
            <code>123456789</code>
            <name>UAB Pavyzdys</name>
            <legalForm>UAB</legalForm>
         </customer>
         <applicant xsi:type="viisp:IndividualContact">
            <email>vardas.pavarde@pavyzdys.lt</email>
            <phone>+37060000001</phone>
            <address>Kauno g. 2, Vilnius</address>
            <code>39001010000</code>
            <name>Vardas</name>
            <surname>Pavardė</surname>
            <birthdate>1990-01-01</birthdate>
         </applicant>
         <applicationData>
            <applicationSubmissionForm>Elektroninė</applicationSubmissionForm>
            <applicationMainContent>
               <fileName>prasymas.pdf</fileName>
               <mimeType>application/pdf</mimeType>
               <data>BASE64_PDF</data>
            </applicationMainContent>
            <applicationStructureData>
               <pairs>
                  <key>theme</key>
                  <value>
                     <stringValue>Paramos prašymas</stringValue>
                  </value>
               </pairs>
            </applicationStructureData>
         </applicationData>
      </dhs:CreateApplicationDocument>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getAnswerDocument

Grąžina atsakymo dokumentą pagal pateiktą identifikatorių.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:dhs="http://viisp.asseco.lt/DhsAdapter">
   <soapenv:Body>
      <dhs:GetAnswerDocument>
         <idBlock>
            <msgId>MSG-001</msgId>
            <messageCreationDate>2024-01-15T10:00:00Z</messageCreationDate>
            <viispServiceCode>SRV-001</viispServiceCode>
            <viispProcessId>PROC-001</viispProcessId>
            <viispApplicationId>APP-001</viispApplicationId>
         </idBlock>
         <serviceProvider>
            <providerOrgCode>123456789</providerOrgCode>
         </serviceProvider>
      </dhs:GetAnswerDocument>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetAnswerDocument request = new GetAnswerDocument();

IdBlock idBlock = new IdBlock();
idBlock.setMsgId("MSG-001");
idBlock.setMessageCreationDate(javax.xml.datatype.DatatypeFactory.newInstance()
    .newXMLGregorianCalendar("2024-01-15T10:00:00Z"));
idBlock.setViispServiceCode("SRV-001");
idBlock.setViispProcessId("PROC-001");
idBlock.setViispApplicationId("APP-001");
request.setIdBlock(idBlock);

ServiceProvider serviceProvider = new ServiceProvider();
serviceProvider.setProviderOrgCode(new java.math.BigDecimal("123456789"));
request.setServiceProvider(serviceProvider);

GetAnswerDocumentResponse response = port.getAnswerDocument(request);
System.out.println(response.getDocument().getDocId());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:dhs=\"http://viisp.asseco.lt/DhsAdapter\">
   <soapenv:Body>
      <dhs:GetAnswerDocument>
         <idBlock>
            <msgId>MSG-001</msgId>
            <messageCreationDate>2024-01-15T10:00:00Z</messageCreationDate>
            <viispServiceCode>SRV-001</viispServiceCode>
            <viispProcessId>PROC-001</viispProcessId>
            <viispApplicationId>APP-001</viispApplicationId>
         </idBlock>
         <serviceProvider>
            <providerOrgCode>123456789</providerOrgCode>
         </serviceProvider>
      </dhs:GetAnswerDocument>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/DhsAdapter",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/DhsAdapter?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'idBlock' => [
        'msgId' => 'MSG-001',
        'messageCreationDate' => '2024-01-15T10:00:00Z',
        'viispServiceCode' => 'SRV-001',
        'viispProcessId' => 'PROC-001',
        'viispApplicationId' => 'APP-001'
    ],
    'serviceProvider' => [
        'providerOrgCode' => '123456789'
    ]
];

$result = $client->getAnswerDocument($param);
echo $result->document->docId . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/DhsAdapter' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://viisp.asseco.lt/DhsAdapter/getAnswerDocument"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:dhs="http://viisp.asseco.lt/DhsAdapter">
   <soapenv:Body>
      <dhs:GetAnswerDocument>
         <idBlock>
            <msgId>MSG-001</msgId>
            <messageCreationDate>2024-01-15T10:00:00Z</messageCreationDate>
            <viispServiceCode>SRV-001</viispServiceCode>
            <viispProcessId>PROC-001</viispProcessId>
            <viispApplicationId>APP-001</viispApplicationId>
         </idBlock>
         <serviceProvider>
            <providerOrgCode>123456789</providerOrgCode>
         </serviceProvider>
      </dhs:GetAnswerDocument>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### ping

Patikrina paslaugos pasiekiamumą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:viisp="http://viisp.asseco.lt/ViispDhsAdapter">
   <soapenv:Body>
      <viisp:ping />
   </soapenv:Body>
</soapenv:Envelope>
```

```java
Pong response = port.ping();
System.out.println(response.getStatus());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:viisp=\"http://viisp.asseco.lt/ViispDhsAdapter\">
   <soapenv:Body>
      <viisp:ping />
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/DhsAdapter",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/DhsAdapter?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$result = $client->ping();
echo $result->status . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/DhsAdapter' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://viisp.asseco.lt/DhsAdapter/ping"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:viisp="http://viisp.asseco.lt/ViispDhsAdapter">
   <soapenv:Body>
      <viisp:ping />
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija
