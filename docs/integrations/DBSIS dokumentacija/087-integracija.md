# Integracija

- Path: `/api-dok/dbsis-api/api-taikymas/srcadapter/integracija`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/srcadapter/integracija
- Index: 87

---

SrcAdapter integracijos operacijos

### ping

Patikrina paslaugos pasiekiamumą ir grąžina būseną.

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
Pong result = port.ping();
System.out.println(result.getStatus());
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
    "https://mok.dbsis.lt/dbsis/ws-cxf/SrcAdapter",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/SrcAdapter?wsdl';
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
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/SrcAdapter' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://viisp.asseco.lt/SrcAdapter/ping"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:viisp="http://viisp.asseco.lt/ViispDhsAdapter">
   <soapenv:Body>
      <viisp:ping />
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### sendCollectedRegistersData

Perduoda surinktus registrų duomenis.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:src="http://viisp.asseco.lt/SrcAdapter"
                  xmlns:viisp="http://viisp.asseco.lt/ViispDhsAdapter"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
   <soapenv:Body>
      <src:SendCollectedRegistersData>
         <idBlock>
            <msgId>MSG-001</msgId>
            <messageCreationDate>2024-02-01T09:00:00Z</messageCreationDate>
            <viispServiceCode>SRV-001</viispServiceCode>
            <dhsApplicationId>APP-001</dhsApplicationId>
         </idBlock>
         <serviceProvider>
            <providerOrgCode>123456789</providerOrgCode>
            <providerName>Įstaigos pavadinimas</providerName>
            <providerOrgDivisionCode>DIV-01</providerOrgDivisionCode>
            <municipalityCode>1</municipalityCode>
         </serviceProvider>
         <checkData>
            <checkCode>REG-001</checkCode>
            <registerOrgCode>987654321</registerOrgCode>
            <registerOrgTitle>Registras</registerOrgTitle>
            <responseData xsi:type="viisp:SrcResponseNodata">
               <requestDate>2024-02-01T08:55:00Z</requestDate>
               <responseDate>2024-02-01T09:00:00Z</responseDate>
               <responseStatus>NO_DATA</responseStatus>
               <reasonCode>404</reasonCode>
               <reasonText>Nerasta</reasonText>
            </responseData>
         </checkData>
      </src:SendCollectedRegistersData>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
SendCollectedRegistersData request = new SendCollectedRegistersData();

SrcIdBlock idBlock = new SrcIdBlock();
idBlock.setMsgId("MSG-001");
idBlock.setMessageCreationDate(javax.xml.datatype.DatatypeFactory.newInstance()
    .newXMLGregorianCalendar("2024-02-01T09:00:00Z"));
idBlock.setViispServiceCode("SRV-001");
idBlock.setDhsApplicationId("APP-001");
request.setIdBlock(idBlock);

ServiceProvider serviceProvider = new ServiceProvider();
serviceProvider.setProviderOrgCode(new java.math.BigDecimal("123456789"));
serviceProvider.setProviderName("Įstaigos pavadinimas");
serviceProvider.setProviderOrgDivisionCode("DIV-01");
serviceProvider.setMunicipalityCode(new java.math.BigDecimal("1"));
request.setServiceProvider(serviceProvider);

SrcData srcData = new SrcData();
srcData.setCheckCode("REG-001");
srcData.setRegisterOrgCode(new java.math.BigDecimal("987654321"));
srcData.setRegisterOrgTitle("Registras");

SrcResponseNodata responseData = new SrcResponseNodata();
responseData.setRequestDate(javax.xml.datatype.DatatypeFactory.newInstance()
    .newXMLGregorianCalendar("2024-02-01T08:55:00Z"));
responseData.setResponseDate(javax.xml.datatype.DatatypeFactory.newInstance()
    .newXMLGregorianCalendar("2024-02-01T09:00:00Z"));
responseData.setResponseStatus("NO_DATA");
responseData.setReasonCode("404");
responseData.setReasonText("Nerasta");

srcData.setResponseData(responseData);
request.getCheckData().add(srcData);

SendCollectedRegistersDataResponse response = port.sendCollectedRegistersData(request);
System.out.println(response.getResultStatus().getStatus());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:src=\"http://viisp.asseco.lt/SrcAdapter\"
                  xmlns:viisp=\"http://viisp.asseco.lt/ViispDhsAdapter\"
                  xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\">
   <soapenv:Body>
      <src:SendCollectedRegistersData>
         <idBlock>
            <msgId>MSG-001</msgId>
            <messageCreationDate>2024-02-01T09:00:00Z</messageCreationDate>
            <viispServiceCode>SRV-001</viispServiceCode>
            <dhsApplicationId>APP-001</dhsApplicationId>
         </idBlock>
         <serviceProvider>
            <providerOrgCode>123456789</providerOrgCode>
            <providerName>Įstaigos pavadinimas</providerName>
            <providerOrgDivisionCode>DIV-01</providerOrgDivisionCode>
            <municipalityCode>1</municipalityCode>
         </serviceProvider>
         <checkData>
            <checkCode>REG-001</checkCode>
            <registerOrgCode>987654321</registerOrgCode>
            <registerOrgTitle>Registras</registerOrgTitle>
            <responseData xsi:type=\"viisp:SrcResponseNodata\">
               <requestDate>2024-02-01T08:55:00Z</requestDate>
               <responseDate>2024-02-01T09:00:00Z</responseDate>
               <responseStatus>NO_DATA</responseStatus>
               <reasonCode>404</reasonCode>
               <reasonText>Nerasta</reasonText>
            </responseData>
         </checkData>
      </src:SendCollectedRegistersData>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/SrcAdapter",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/SrcAdapter?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'idBlock' => [
        'msgId' => 'MSG-001',
        'messageCreationDate' => '2024-02-01T09:00:00Z',
        'viispServiceCode' => 'SRV-001',
        'dhsApplicationId' => 'APP-001'
    ],
    'serviceProvider' => [
        'providerOrgCode' => '123456789',
        'providerName' => 'Įstaigos pavadinimas',
        'providerOrgDivisionCode' => 'DIV-01',
        'municipalityCode' => '1'
    ],
    'checkData' => [
        [
            'checkCode' => 'REG-001',
            'registerOrgCode' => '987654321',
            'registerOrgTitle' => 'Registras',
            'responseData' => [
                'requestDate' => '2024-02-01T08:55:00Z',
                'responseDate' => '2024-02-01T09:00:00Z',
                'responseStatus' => 'NO_DATA',
                'reasonCode' => '404',
                'reasonText' => 'Nerasta'
            ]
        ]
    ]
];

$result = $client->sendCollectedRegistersData($param);
echo $result->resultStatus->status . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/SrcAdapter' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://viisp.asseco.lt/SrcAdapter/sendCollectedRegistersData"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:src="http://viisp.asseco.lt/SrcAdapter"
                  xmlns:viisp="http://viisp.asseco.lt/ViispDhsAdapter"
                  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
   <soapenv:Body>
      <src:SendCollectedRegistersData>
         <idBlock>
            <msgId>MSG-001</msgId>
            <messageCreationDate>2024-02-01T09:00:00Z</messageCreationDate>
            <viispServiceCode>SRV-001</viispServiceCode>
            <dhsApplicationId>APP-001</dhsApplicationId>
         </idBlock>
         <serviceProvider>
            <providerOrgCode>123456789</providerOrgCode>
            <providerName>Įstaigos pavadinimas</providerName>
            <providerOrgDivisionCode>DIV-01</providerOrgDivisionCode>
            <municipalityCode>1</municipalityCode>
         </serviceProvider>
         <checkData>
            <checkCode>REG-001</checkCode>
            <registerOrgCode>987654321</registerOrgCode>
            <registerOrgTitle>Registras</registerOrgTitle>
            <responseData xsi:type="viisp:SrcResponseNodata">
               <requestDate>2024-02-01T08:55:00Z</requestDate>
               <responseDate>2024-02-01T09:00:00Z</responseDate>
               <responseStatus>NO_DATA</responseStatus>
               <reasonCode>404</reasonCode>
               <reasonText>Nerasta</reasonText>
            </responseData>
         </checkData>
      </src:SendCollectedRegistersData>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija
