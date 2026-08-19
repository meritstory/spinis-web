# Integracija

- Path: `/api-dok/dbsis-api/api-taikymas/epsadapter/integracija`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/epsadapter/integracija
- Index: 55

---

EpsAdapter integracijos operacijos

### notifyAboutPayment

Praneša apie mokėjimo būseną ir pateikia mokėjimo duomenis.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://viisp.asseco.lt/EpsAdapter"
                  xmlns:viisp="http://viisp.asseco.lt/ViispDhsAdapter"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
   <soapenv:Body>
      <eps:NotifyAboutPayment>
         <idBlock>
            <msgId>MSG-001</msgId>
            <messageCreationDate>2024-01-15T10:00:00Z</messageCreationDate>
            <viispServiceCode>SRV-001</viispServiceCode>
            <viispProcessId>PROC-001</viispProcessId>
            <viispApplicationId>APP-001</viispApplicationId>
         </idBlock>
         <serviceProvider>
            <providerOrgCode>123456789</providerOrgCode>
            <providerName>Įstaigos pavadinimas</providerName>
         </serviceProvider>
         <payer xsi:type="viisp:OrgContact">
            <email>finansai@pavyzdys.lt</email>
            <phone>+37060000000</phone>
            <address>Vilniaus g. 1, Vilnius</address>
            <code>123456789</code>
            <name>UAB Pavyzdys</name>
            <legalForm>UAB</legalForm>
         </payer>
         <billingStatus>
            <status>PAID</status>
         </billingStatus>
         <paymentData>
            <sumPaid>
               <sum>25.00</sum>
               <currency>EUR</currency>
            </sumPaid>
            <sumPaidInNationalCurrency>
               <sum>25.00</sum>
               <currency>EUR</currency>
            </sumPaidInNationalCurrency>
            <paymentDate>2024-01-15T10:05:00Z</paymentDate>
            <paymentCode>123</paymentCode>
            <paymentName>Mokėjimas</paymentName>
            <paymentDetails>Paslaugos apmokėjimas</paymentDetails>
            <receiverAccountNo>LT000000000000000000</receiverAccountNo>
            <receiverName>EPS Administracija</receiverName>
            <payerAccountNo>LT111111111111111111</payerAccountNo>
            <payerName>UAB Pavyzdys</payerName>
            <payerCode>123456789</payerCode>
            <paymentDocumentNo>PAY-001</paymentDocumentNo>
            <paymentDocument>
               <fileName>payment.pdf</fileName>
               <mimeType>application/pdf</mimeType>
               <data>BASE64_PDF</data>
            </paymentDocument>
         </paymentData>
      </eps:NotifyAboutPayment>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
NotifyAboutPayment request = new NotifyAboutPayment();

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
serviceProvider.setProviderName("Įstaigos pavadinimas");
request.setServiceProvider(serviceProvider);

OrgContact payer = new OrgContact();
payer.setEmail("finansai@pavyzdys.lt");
payer.setPhone("+37060000000");
payer.setAddress("Vilniaus g. 1, Vilnius");
payer.setCode(new java.math.BigDecimal("123456789"));
payer.setName("UAB Pavyzdys");
payer.setLegalForm("UAB");
request.setPayer(payer);

BillingStatus billingStatus = new BillingStatus();
billingStatus.setStatus("PAID");
request.setBillingStatus(billingStatus);

Amount amount = new Amount();
amount.setSum(new java.math.BigDecimal("25.00"));
amount.setCurrency("EUR");

PaymentData paymentData = new PaymentData();
paymentData.setSumPaid(amount);
paymentData.setSumPaidInNationalCurrency(amount);
paymentData.setPaymentDate(javax.xml.datatype.DatatypeFactory.newInstance()
    .newXMLGregorianCalendar("2024-01-15T10:05:00Z"));
paymentData.setPaymentCode(new java.math.BigDecimal("123"));
paymentData.setPaymentName("Mokėjimas");
paymentData.setPaymentDetails("Paslaugos apmokėjimas");
paymentData.setReceiverAccountNo("LT000000000000000000");
paymentData.setReceiverName("EPS Administracija");
paymentData.setPayerAccountNo("LT111111111111111111");
paymentData.setPayerName("UAB Pavyzdys");
paymentData.setPayerCode("123456789");
paymentData.setPaymentDocumentNo("PAY-001");

Attachment paymentDocument = new Attachment();
paymentDocument.setFileName("payment.pdf");
paymentDocument.setMimeType("application/pdf");
paymentDocument.setData("BASE64_PDF".getBytes());
paymentData.setPaymentDocument(paymentDocument);

request.setPaymentData(paymentData);

NotifyAboutPaymentResponse response = port.notifyAboutPayment(request);
System.out.println(response.getResultStatus().getStatus());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:eps=\"http://viisp.asseco.lt/EpsAdapter\"
                  xmlns:viisp=\"http://viisp.asseco.lt/ViispDhsAdapter\"
                  xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\">
   <soapenv:Body>
      <eps:NotifyAboutPayment>
         <idBlock>
            <msgId>MSG-001</msgId>
            <messageCreationDate>2024-01-15T10:00:00Z</messageCreationDate>
            <viispServiceCode>SRV-001</viispServiceCode>
            <viispProcessId>PROC-001</viispProcessId>
            <viispApplicationId>APP-001</viispApplicationId>
         </idBlock>
         <serviceProvider>
            <providerOrgCode>123456789</providerOrgCode>
            <providerName>Įstaigos pavadinimas</providerName>
         </serviceProvider>
         <payer xsi:type=\"viisp:OrgContact\">
            <email>finansai@pavyzdys.lt</email>
            <phone>+37060000000</phone>
            <address>Vilniaus g. 1, Vilnius</address>
            <code>123456789</code>
            <name>UAB Pavyzdys</name>
            <legalForm>UAB</legalForm>
         </payer>
         <billingStatus>
            <status>PAID</status>
         </billingStatus>
         <paymentData>
            <sumPaid>
               <sum>25.00</sum>
               <currency>EUR</currency>
            </sumPaid>
            <sumPaidInNationalCurrency>
               <sum>25.00</sum>
               <currency>EUR</currency>
            </sumPaidInNationalCurrency>
            <paymentDate>2024-01-15T10:05:00Z</paymentDate>
            <paymentCode>123</paymentCode>
            <paymentName>Mokėjimas</paymentName>
            <paymentDetails>Paslaugos apmokėjimas</paymentDetails>
            <receiverAccountNo>LT000000000000000000</receiverAccountNo>
            <receiverName>EPS Administracija</receiverName>
            <payerAccountNo>LT111111111111111111</payerAccountNo>
            <payerName>UAB Pavyzdys</payerName>
            <payerCode>123456789</payerCode>
            <paymentDocumentNo>PAY-001</paymentDocumentNo>
            <paymentDocument>
               <fileName>payment.pdf</fileName>
               <mimeType>application/pdf</mimeType>
               <data>BASE64_PDF</data>
            </paymentDocument>
         </paymentData>
      </eps:NotifyAboutPayment>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/EpsAdapter",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/EpsAdapter?wsdl';
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
        'providerOrgCode' => '123456789',
        'providerName' => 'Įstaigos pavadinimas'
    ],
    'payer' => [
        'email' => 'finansai@pavyzdys.lt',
        'phone' => '+37060000000',
        'address' => 'Vilniaus g. 1, Vilnius',
        'code' => '123456789',
        'name' => 'UAB Pavyzdys',
        'legalForm' => 'UAB'
    ],
    'billingStatus' => [
        'status' => 'PAID'
    ],
    'paymentData' => [
        'sumPaid' => [
            'sum' => '25.00',
            'currency' => 'EUR'
        ],
        'sumPaidInNationalCurrency' => [
            'sum' => '25.00',
            'currency' => 'EUR'
        ],
        'paymentDate' => '2024-01-15T10:05:00Z',
        'paymentCode' => '123',
        'paymentName' => 'Mokėjimas',
        'paymentDetails' => 'Paslaugos apmokėjimas',
        'receiverAccountNo' => 'LT000000000000000000',
        'receiverName' => 'EPS Administracija',
        'payerAccountNo' => 'LT111111111111111111',
        'payerName' => 'UAB Pavyzdys',
        'payerCode' => '123456789',
        'paymentDocumentNo' => 'PAY-001',
        'paymentDocument' => [
            'fileName' => 'payment.pdf',
            'mimeType' => 'application/pdf',
            'data' => 'BASE64_PDF'
        ]
    ]
];

$result = $client->notifyAboutPayment($param);
echo $result->resultStatus->status . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/EpsAdapter' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://viisp.asseco.lt/EpsAdapter/notifyAboutPayment"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://viisp.asseco.lt/EpsAdapter"
                  xmlns:viisp="http://viisp.asseco.lt/ViispDhsAdapter"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
   <soapenv:Body>
      <eps:NotifyAboutPayment>
         <idBlock>
            <msgId>MSG-001</msgId>
            <messageCreationDate>2024-01-15T10:00:00Z</messageCreationDate>
            <viispServiceCode>SRV-001</viispServiceCode>
            <viispProcessId>PROC-001</viispProcessId>
            <viispApplicationId>APP-001</viispApplicationId>
         </idBlock>
         <serviceProvider>
            <providerOrgCode>123456789</providerOrgCode>
            <providerName>Įstaigos pavadinimas</providerName>
         </serviceProvider>
         <payer xsi:type="viisp:OrgContact">
            <email>finansai@pavyzdys.lt</email>
            <phone>+37060000000</phone>
            <address>Vilniaus g. 1, Vilnius</address>
            <code>123456789</code>
            <name>UAB Pavyzdys</name>
            <legalForm>UAB</legalForm>
         </payer>
         <billingStatus>
            <status>PAID</status>
         </billingStatus>
         <paymentData>
            <sumPaid>
               <sum>25.00</sum>
               <currency>EUR</currency>
            </sumPaid>
            <sumPaidInNationalCurrency>
               <sum>25.00</sum>
               <currency>EUR</currency>
            </sumPaidInNationalCurrency>
            <paymentDate>2024-01-15T10:05:00Z</paymentDate>
            <paymentCode>123</paymentCode>
            <paymentName>Mokėjimas</paymentName>
            <paymentDetails>Paslaugos apmokėjimas</paymentDetails>
            <receiverAccountNo>LT000000000000000000</receiverAccountNo>
            <receiverName>EPS Administracija</receiverName>
            <payerAccountNo>LT111111111111111111</payerAccountNo>
            <payerName>UAB Pavyzdys</payerName>
            <payerCode>123456789</payerCode>
            <paymentDocumentNo>PAY-001</paymentDocumentNo>
            <paymentDocument>
               <fileName>payment.pdf</fileName>
               <mimeType>application/pdf</mimeType>
               <data>BASE64_PDF</data>
            </paymentDocument>
         </paymentData>
      </eps:NotifyAboutPayment>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### notifyAboutAction

Praneša apie atliktą veiksmą arba jo būseną.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://viisp.asseco.lt/EpsAdapter">
   <soapenv:Body>
      <eps:NotifyAboutAction>
         <idBlock>
            <msgId>MSG-002</msgId>
            <messageCreationDate>2024-01-15T11:00:00Z</messageCreationDate>
            <viispServiceCode>SRV-001</viispServiceCode>
            <viispProcessId>PROC-001</viispProcessId>
            <viispApplicationId>APP-001</viispApplicationId>
         </idBlock>
         <serviceProvider>
            <providerOrgCode>123456789</providerOrgCode>
            <providerName>Įstaigos pavadinimas</providerName>
         </serviceProvider>
         <actionType>APPROVED</actionType>
         <actionCompleted>true</actionCompleted>
         <actionDescription>Veiksmas atliktas</actionDescription>
         <additionalData>
            <pairs>
               <key>comment</key>
               <value>
                  <stringValue>Papildoma informacija</stringValue>
               </value>
            </pairs>
         </additionalData>
      </eps:NotifyAboutAction>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
NotifyAboutAction request = new NotifyAboutAction();

IdBlock idBlock = new IdBlock();
idBlock.setMsgId("MSG-002");
idBlock.setMessageCreationDate(javax.xml.datatype.DatatypeFactory.newInstance()
    .newXMLGregorianCalendar("2024-01-15T11:00:00Z"));
idBlock.setViispServiceCode("SRV-001");
idBlock.setViispProcessId("PROC-001");
idBlock.setViispApplicationId("APP-001");
request.setIdBlock(idBlock);

ServiceProvider serviceProvider = new ServiceProvider();
serviceProvider.setProviderOrgCode(new java.math.BigDecimal("123456789"));
serviceProvider.setProviderName("Įstaigos pavadinimas");
request.setServiceProvider(serviceProvider);

request.setActionType("APPROVED");
request.setActionCompleted(true);
request.setActionDescription("Veiksmas atliktas");

NotifyAboutActionResponse response = port.notifyAboutAction(request);
System.out.println(response.getResultStatus().getStatus());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:eps=\"http://viisp.asseco.lt/EpsAdapter\">
   <soapenv:Body>
      <eps:NotifyAboutAction>
         <idBlock>
            <msgId>MSG-002</msgId>
            <messageCreationDate>2024-01-15T11:00:00Z</messageCreationDate>
            <viispServiceCode>SRV-001</viispServiceCode>
            <viispProcessId>PROC-001</viispProcessId>
            <viispApplicationId>APP-001</viispApplicationId>
         </idBlock>
         <serviceProvider>
            <providerOrgCode>123456789</providerOrgCode>
            <providerName>Įstaigos pavadinimas</providerName>
         </serviceProvider>
         <actionType>APPROVED</actionType>
         <actionCompleted>true</actionCompleted>
         <actionDescription>Veiksmas atliktas</actionDescription>
         <additionalData>
            <pairs>
               <key>comment</key>
               <value>
                  <stringValue>Papildoma informacija</stringValue>
               </value>
            </pairs>
         </additionalData>
      </eps:NotifyAboutAction>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/EpsAdapter",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/EpsAdapter?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'idBlock' => [
        'msgId' => 'MSG-002',
        'messageCreationDate' => '2024-01-15T11:00:00Z',
        'viispServiceCode' => 'SRV-001',
        'viispProcessId' => 'PROC-001',
        'viispApplicationId' => 'APP-001'
    ],
    'serviceProvider' => [
        'providerOrgCode' => '123456789',
        'providerName' => 'Įstaigos pavadinimas'
    ],
    'actionType' => 'APPROVED',
    'actionCompleted' => true,
    'actionDescription' => 'Veiksmas atliktas',
    'additionalData' => [
        'pairs' => [
            'key' => 'comment',
            'value' => ['stringValue' => 'Papildoma informacija']
        ]
    ]
];

$result = $client->notifyAboutAction($param);
echo $result->resultStatus->status . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/EpsAdapter' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://viisp.asseco.lt/EpsAdapter/notifyAboutAction"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://viisp.asseco.lt/EpsAdapter">
   <soapenv:Body>
      <eps:NotifyAboutAction>
         <idBlock>
            <msgId>MSG-002</msgId>
            <messageCreationDate>2024-01-15T11:00:00Z</messageCreationDate>
            <viispServiceCode>SRV-001</viispServiceCode>
            <viispProcessId>PROC-001</viispProcessId>
            <viispApplicationId>APP-001</viispApplicationId>
         </idBlock>
         <serviceProvider>
            <providerOrgCode>123456789</providerOrgCode>
            <providerName>Įstaigos pavadinimas</providerName>
         </serviceProvider>
         <actionType>APPROVED</actionType>
         <actionCompleted>true</actionCompleted>
         <actionDescription>Veiksmas atliktas</actionDescription>
         <additionalData>
            <pairs>
               <key>comment</key>
               <value>
                  <stringValue>Papildoma informacija</stringValue>
               </value>
            </pairs>
         </additionalData>
      </eps:NotifyAboutAction>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### cancelServiceExecution

Atšaukia paslaugos vykdymą nurodant priežastį.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://viisp.asseco.lt/EpsAdapter">
   <soapenv:Body>
      <eps:CancelServiceExecution>
         <idBlock>
            <msgId>MSG-003</msgId>
            <messageCreationDate>2024-01-16T08:00:00Z</messageCreationDate>
            <viispServiceCode>SRV-001</viispServiceCode>
            <viispProcessId>PROC-001</viispProcessId>
            <viispApplicationId>APP-001</viispApplicationId>
         </idBlock>
         <serviceProvider>
            <providerOrgCode>123456789</providerOrgCode>
         </serviceProvider>
         <cancelReasonCode>CANCELLED</cancelReasonCode>
         <cancelReasonText>Kliento prašymu</cancelReasonText>
      </eps:CancelServiceExecution>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
CancelServiceExecution request = new CancelServiceExecution();

IdBlock idBlock = new IdBlock();
idBlock.setMsgId("MSG-003");
idBlock.setMessageCreationDate(javax.xml.datatype.DatatypeFactory.newInstance()
    .newXMLGregorianCalendar("2024-01-16T08:00:00Z"));
idBlock.setViispServiceCode("SRV-001");
idBlock.setViispProcessId("PROC-001");
idBlock.setViispApplicationId("APP-001");
request.setIdBlock(idBlock);

ServiceProvider serviceProvider = new ServiceProvider();
serviceProvider.setProviderOrgCode(new java.math.BigDecimal("123456789"));
request.setServiceProvider(serviceProvider);

request.setCancelReasonCode("CANCELLED");
request.setCancelReasonText("Kliento prašymu");

CancelServiceExecutionResponse response = port.cancelServiceExecution(request);
System.out.println(response.getResultStatus().getStatus());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:eps=\"http://viisp.asseco.lt/EpsAdapter\">
   <soapenv:Body>
      <eps:CancelServiceExecution>
         <idBlock>
            <msgId>MSG-003</msgId>
            <messageCreationDate>2024-01-16T08:00:00Z</messageCreationDate>
            <viispServiceCode>SRV-001</viispServiceCode>
            <viispProcessId>PROC-001</viispProcessId>
            <viispApplicationId>APP-001</viispApplicationId>
         </idBlock>
         <serviceProvider>
            <providerOrgCode>123456789</providerOrgCode>
         </serviceProvider>
         <cancelReasonCode>CANCELLED</cancelReasonCode>
         <cancelReasonText>Kliento prašymu</cancelReasonText>
      </eps:CancelServiceExecution>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/EpsAdapter",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/EpsAdapter?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'idBlock' => [
        'msgId' => 'MSG-003',
        'messageCreationDate' => '2024-01-16T08:00:00Z',
        'viispServiceCode' => 'SRV-001',
        'viispProcessId' => 'PROC-001',
        'viispApplicationId' => 'APP-001'
    ],
    'serviceProvider' => [
        'providerOrgCode' => '123456789'
    ],
    'cancelReasonCode' => 'CANCELLED',
    'cancelReasonText' => 'Kliento prašymu'
];

$result = $client->cancelServiceExecution($param);
echo $result->resultStatus->status . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/EpsAdapter' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://viisp.asseco.lt/EpsAdapter/cancelServiceExecution"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://viisp.asseco.lt/EpsAdapter">
   <soapenv:Body>
      <eps:CancelServiceExecution>
         <idBlock>
            <msgId>MSG-003</msgId>
            <messageCreationDate>2024-01-16T08:00:00Z</messageCreationDate>
            <viispServiceCode>SRV-001</viispServiceCode>
            <viispProcessId>PROC-001</viispProcessId>
            <viispApplicationId>APP-001</viispApplicationId>
         </idBlock>
         <serviceProvider>
            <providerOrgCode>123456789</providerOrgCode>
         </serviceProvider>
         <cancelReasonCode>CANCELLED</cancelReasonCode>
         <cancelReasonText>Kliento prašymu</cancelReasonText>
      </eps:CancelServiceExecution>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### createServiceApplication

Sukuria EPS paslaugos prašymą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://viisp.asseco.lt/EpsAdapter"
                  xmlns:viisp="http://viisp.asseco.lt/ViispDhsAdapter"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
   <soapenv:Body>
      <eps:CreateServiceApplication>
         <idBlock>
            <msgId>MSG-004</msgId>
            <messageCreationDate>2024-01-17T09:00:00Z</messageCreationDate>
            <viispServiceCode>SRV-001</viispServiceCode>
            <viispProcessId>PROC-002</viispProcessId>
            <viispApplicationId>APP-002</viispApplicationId>
         </idBlock>
         <revisedApplication>false</revisedApplication>
         <applicationDate>2024-01-17</applicationDate>
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
         <applicationFormInfo>
            <applicationFormCode>FORM-001</applicationFormCode>
            <formFields>
               <formField xsi:type="viisp:SimpleFormField">
                  <fieldName>field1</fieldName>
                  <fieldTitle>Pareiškėjo vardas</fieldTitle>
                  <canBeRevised>true</canBeRevised>
                  <fieldValueType>stringValue</fieldValueType>
               </formField>
            </formFields>
         </applicationFormInfo>
      </eps:CreateServiceApplication>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
CreateServiceApplication request = new CreateServiceApplication();

IdBlock idBlock = new IdBlock();
idBlock.setMsgId("MSG-004");
idBlock.setMessageCreationDate(javax.xml.datatype.DatatypeFactory.newInstance()
    .newXMLGregorianCalendar("2024-01-17T09:00:00Z"));
idBlock.setViispServiceCode("SRV-001");
idBlock.setViispProcessId("PROC-002");
idBlock.setViispApplicationId("APP-002");
request.setIdBlock(idBlock);

request.setRevisedApplication(false);
request.setApplicationDate(javax.xml.datatype.DatatypeFactory.newInstance()
    .newXMLGregorianCalendarDate(2024, 1, 17, 0));

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

ApplicationFormInfo formInfo = new ApplicationFormInfo();
formInfo.setApplicationFormCode("FORM-001");
request.setApplicationFormInfo(formInfo);

CreateServiceApplicationResponse response = port.createServiceApplication(request);
System.out.println(response.getResultStatus().getStatus());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:eps=\"http://viisp.asseco.lt/EpsAdapter\"
                  xmlns:viisp=\"http://viisp.asseco.lt/ViispDhsAdapter\"
                  xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\">
   <soapenv:Body>
      <eps:CreateServiceApplication>
         <idBlock>
            <msgId>MSG-004</msgId>
            <messageCreationDate>2024-01-17T09:00:00Z</messageCreationDate>
            <viispServiceCode>SRV-001</viispServiceCode>
            <viispProcessId>PROC-002</viispProcessId>
            <viispApplicationId>APP-002</viispApplicationId>
         </idBlock>
         <revisedApplication>false</revisedApplication>
         <applicationDate>2024-01-17</applicationDate>
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
         <applicationFormInfo>
            <applicationFormCode>FORM-001</applicationFormCode>
            <formFields>
               <formField xsi:type=\"viisp:SimpleFormField\">
                  <fieldName>field1</fieldName>
                  <fieldTitle>Pareiškėjo vardas</fieldTitle>
                  <canBeRevised>true</canBeRevised>
                  <fieldValueType>stringValue</fieldValueType>
               </formField>
            </formFields>
         </applicationFormInfo>
      </eps:CreateServiceApplication>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/EpsAdapter",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/EpsAdapter?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'idBlock' => [
        'msgId' => 'MSG-004',
        'messageCreationDate' => '2024-01-17T09:00:00Z',
        'viispServiceCode' => 'SRV-001',
        'viispProcessId' => 'PROC-002',
        'viispApplicationId' => 'APP-002'
    ],
    'revisedApplication' => false,
    'applicationDate' => '2024-01-17',
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
    ],
    'applicationFormInfo' => [
        'applicationFormCode' => 'FORM-001',
        'formFields' => [
            'formField' => [
                'fieldName' => 'field1',
                'fieldTitle' => 'Pareiškėjo vardas',
                'canBeRevised' => true,
                'fieldValueType' => 'stringValue'
            ]
        ]
    ]
];

$result = $client->createServiceApplication($param);
echo $result->resultStatus->status . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/EpsAdapter' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://viisp.asseco.lt/EpsAdapter/createServiceApplication"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:eps="http://viisp.asseco.lt/EpsAdapter"
                  xmlns:viisp="http://viisp.asseco.lt/ViispDhsAdapter"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
   <soapenv:Body>
      <eps:CreateServiceApplication>
         <idBlock>
            <msgId>MSG-004</msgId>
            <messageCreationDate>2024-01-17T09:00:00Z</messageCreationDate>
            <viispServiceCode>SRV-001</viispServiceCode>
            <viispProcessId>PROC-002</viispProcessId>
            <viispApplicationId>APP-002</viispApplicationId>
         </idBlock>
         <revisedApplication>false</revisedApplication>
         <applicationDate>2024-01-17</applicationDate>
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
         <applicationFormInfo>
            <applicationFormCode>FORM-001</applicationFormCode>
            <formFields>
               <formField xsi:type="viisp:SimpleFormField">
                  <fieldName>field1</fieldName>
                  <fieldTitle>Pareiškėjo vardas</fieldTitle>
                  <canBeRevised>true</canBeRevised>
                  <fieldValueType>stringValue</fieldValueType>
               </formField>
            </formFields>
         </applicationFormInfo>
      </eps:CreateServiceApplication>
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
    "https://mok.dbsis.lt/dbsis/ws-cxf/EpsAdapter",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/EpsAdapter?wsdl';
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
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/EpsAdapter' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://viisp.asseco.lt/EpsAdapter/ping"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:viisp="http://viisp.asseco.lt/ViispDhsAdapter">
   <soapenv:Body>
      <viisp:ping />
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija
