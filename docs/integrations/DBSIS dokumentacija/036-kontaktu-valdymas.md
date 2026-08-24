# Kontaktų valdymas

- Path: `/api-dok/dbsis-api/api-taikymas/contactws/kontaktu-valdymas`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/contactws/kontaktu-valdymas
- Index: 36

---

ContactWS kontaktų valdymo operacijos

### getContactList

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/isoriniu-kontaktu-sasaja#_242-operacija-getcontactlist)

Grąžina kontaktų identifikatorių sąrašą pagal nurodytus filtrus.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:con="http://www.sintagma.lt/avilys/ContactWS">
   <soapenv:Body>
      <con:getContactList>
         <getContactListParam>
            <officialName>UAB Pavyzdys</officialName>
            <email>info@pavyzdys.lt</email>
            <maxAmount>10</maxAmount>
         </getContactListParam>
      </con:getContactList>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetContactListParam param = new GetContactListParam();
param.setOfficialName("UAB Pavyzdys");
param.setEmail("info@pavyzdys.lt");
param.setMaxAmount(10);

GetContactListResult result = port.getContactList(param);
for (ContactReference contact : result.getContact()) {
    System.out.println(contact.getOrgName());
}
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:con=\"http://www.sintagma.lt/avilys/ContactWS\">
   <soapenv:Body>
      <con:getContactList>
         <getContactListParam>
            <officialName>UAB Pavyzdys</officialName>
            <email>info@pavyzdys.lt</email>
            <maxAmount>10</maxAmount>
         </getContactListParam>
      </con:getContactList>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/ContactWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/ContactWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'getContactListParam' => [
        'officialName' => 'UAB Pavyzdys',
        'email' => 'info@pavyzdys.lt',
        'maxAmount' => 10
    ]
];

$result = $client->getContactList($param);
foreach ($result->contactList->contact ?? [] as $contact) {
    echo $contact->orgName . PHP_EOL;
}
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/ContactWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: ""' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:con="http://www.sintagma.lt/avilys/ContactWS">
   <soapenv:Body>
      <con:getContactList>
         <getContactListParam>
            <officialName>UAB Pavyzdys</officialName>
            <email>info@pavyzdys.lt</email>
            <maxAmount>10</maxAmount>
         </getContactListParam>
      </con:getContactList>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getContact

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/isoriniu-kontaktu-sasaja#_243-operacija-getcontact)

Grąžina detalią kontakto informaciją pagal jo identifikatorių.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:con="http://www.sintagma.lt/avilys/ContactWS">
   <soapenv:Body>
      <con:getContact>
         <getContactParam>
            <orgName>CONTACT_123</orgName>
         </getContactParam>
      </con:getContact>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetContactParam param = new GetContactParam();
param.setOrgName("CONTACT_123");

Contact result = port.getContact(param);
System.out.println(result.getOrgName());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:con=\"http://www.sintagma.lt/avilys/ContactWS\">
   <soapenv:Body>
      <con:getContact>
         <getContactParam>
            <orgName>CONTACT_123</orgName>
         </getContactParam>
      </con:getContact>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/ContactWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/ContactWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'getContactParam' => [
        'orgName' => 'CONTACT_123'
    ]
];

$result = $client->getContact($param);
echo $result->contact->orgName . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/ContactWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: ""' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:con="http://www.sintagma.lt/avilys/ContactWS">
   <soapenv:Body>
      <con:getContact>
         <getContactParam>
            <orgName>CONTACT_123</orgName>
         </getContactParam>
      </con:getContact>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### createContact

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/isoriniu-kontaktu-sasaja#_244-operacija-createcontact)

Sukuria naują kontaktą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:con="http://www.sintagma.lt/avilys/ContactWS">
   <soapenv:Body>
      <con:createContact>
         <createContactParam>
            <officialName>UAB Pavyzdys</officialName>
            <contactType>CONTACT</contactType>
            <properties>
               <entry>
                  <key>address</key>
                  <value>Vilniaus g. 1, Vilnius</value>
               </entry>
               <entry>
                  <key>email</key>
                  <value>info@pavyzdys.lt</value>
               </entry>
            </properties>
         </createContactParam>
      </con:createContact>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
CreateContactParam param = new CreateContactParam();
param.setOfficialName("UAB Pavyzdys");
param.setContactType(ContactEnumType.CONTACT);

Map<String, String> properties = new HashMap<>();
properties.put("address", "Vilniaus g. 1, Vilnius");
properties.put("email", "info@pavyzdys.lt");
param.setProperties(properties);

CreateContactResult result = port.createContact(param);
System.out.println(result.getContact().getOrgName());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:con=\"http://www.sintagma.lt/avilys/ContactWS\">
   <soapenv:Body>
      <con:createContact>
         <createContactParam>
            <officialName>UAB Pavyzdys</officialName>
            <contactType>CONTACT</contactType>
            <properties>
               <entry>
                  <key>address</key>
                  <value>Vilniaus g. 1, Vilnius</value>
               </entry>
               <entry>
                  <key>email</key>
                  <value>info@pavyzdys.lt</value>
               </entry>
            </properties>
         </createContactParam>
      </con:createContact>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/ContactWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/ContactWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'createContactParam' => [
        'officialName' => 'UAB Pavyzdys',
        'contactType' => 'CONTACT',
        'properties' => [
            'entry' => [
                ['key' => 'address', 'value' => 'Vilniaus g. 1, Vilnius'],
                ['key' => 'email', 'value' => 'info@pavyzdys.lt']
            ]
        ]
    ]
];

$result = $client->createContact($param);
echo $result->createContactResult->contact->orgName . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/ContactWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: ""' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:con="http://www.sintagma.lt/avilys/ContactWS">
   <soapenv:Body>
      <con:createContact>
         <createContactParam>
            <officialName>UAB Pavyzdys</officialName>
            <contactType>CONTACT</contactType>
            <properties>
               <entry>
                  <key>address</key>
                  <value>Vilniaus g. 1, Vilnius</value>
               </entry>
               <entry>
                  <key>email</key>
                  <value>info@pavyzdys.lt</value>
               </entry>
            </properties>
         </createContactParam>
      </con:createContact>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### createOrModifyContact

Sukuria arba atnaujina kontaktą pagal pateiktus duomenis.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:con="http://www.sintagma.lt/avilys/ContactWS">
   <soapenv:Body>
      <con:createOrModifyContact>
         <createOrModifyContactParam>
            <officialName>UAB Pavyzdys</officialName>
            <contactType>CONTACT</contactType>
            <email>info@pavyzdys.lt</email>
            <properties>
               <entry>
                  <key>address</key>
                  <value>Vilniaus g. 1, Vilnius</value>
               </entry>
            </properties>
            <modifyKeys>email</modifyKeys>
            <modifyKeys>address</modifyKeys>
         </createOrModifyContactParam>
      </con:createOrModifyContact>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
CreateOrModifyContactParam param = new CreateOrModifyContactParam();
param.setOfficialName("UAB Pavyzdys");
param.setContactType(ContactEnumType.CONTACT);
param.setEmail("info@pavyzdys.lt");

Map<String, String> properties = new HashMap<>();
properties.put("address", "Vilniaus g. 1, Vilnius");
param.setProperties(properties);

param.getModifyKeys().add("email");
param.getModifyKeys().add("address");

CreateOrModifyContactResult result = port.createOrModifyContact(param);
System.out.println(result.getContact().getOrgName());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:con=\"http://www.sintagma.lt/avilys/ContactWS\">
   <soapenv:Body>
      <con:createOrModifyContact>
         <createOrModifyContactParam>
            <officialName>UAB Pavyzdys</officialName>
            <contactType>CONTACT</contactType>
            <email>info@pavyzdys.lt</email>
            <properties>
               <entry>
                  <key>address</key>
                  <value>Vilniaus g. 1, Vilnius</value>
               </entry>
            </properties>
            <modifyKeys>email</modifyKeys>
            <modifyKeys>address</modifyKeys>
         </createOrModifyContactParam>
      </con:createOrModifyContact>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/ContactWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/ContactWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'createOrModifyContactParam' => [
        'officialName' => 'UAB Pavyzdys',
        'contactType' => 'CONTACT',
        'email' => 'info@pavyzdys.lt',
        'properties' => [
            'entry' => [
                ['key' => 'address', 'value' => 'Vilniaus g. 1, Vilnius']
            ]
        ],
        'modifyKeys' => ['email', 'address']
    ]
];

$result = $client->createOrModifyContact($param);
echo $result->createOrModifyContactResult->contact->orgName . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/ContactWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: ""' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:con="http://www.sintagma.lt/avilys/ContactWS">
   <soapenv:Body>
      <con:createOrModifyContact>
         <createOrModifyContactParam>
            <officialName>UAB Pavyzdys</officialName>
            <contactType>CONTACT</contactType>
            <email>info@pavyzdys.lt</email>
            <properties>
               <entry>
                  <key>address</key>
                  <value>Vilniaus g. 1, Vilnius</value>
               </entry>
            </properties>
            <modifyKeys>email</modifyKeys>
            <modifyKeys>address</modifyKeys>
         </createOrModifyContactParam>
      </con:createOrModifyContact>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### modifyContact

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/isoriniu-kontaktu-sasaja#_245-operacija-modifycontact)

Atnaujina esamo kontakto duomenis.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:con="http://www.sintagma.lt/avilys/ContactWS">
   <soapenv:Body>
      <con:modifyContact>
         <modifyContactParam>
            <orgName>CONTACT_123</orgName>
            <properties>
               <entry>
                  <key>phone</key>
                  <value>+37060000000</value>
               </entry>
            </properties>
         </modifyContactParam>
      </con:modifyContact>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
ModifyContactParam param = new ModifyContactParam();
param.setOrgName("CONTACT_123");

Map<String, String> properties = new HashMap<>();
properties.put("phone", "+37060000000");
param.setProperties(properties);

ModifyContactResult result = port.modifyContact(param);
System.out.println(result.getContact().getOrgName());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:con=\"http://www.sintagma.lt/avilys/ContactWS\">
   <soapenv:Body>
      <con:modifyContact>
         <modifyContactParam>
            <orgName>CONTACT_123</orgName>
            <properties>
               <entry>
                  <key>phone</key>
                  <value>+37060000000</value>
               </entry>
            </properties>
         </modifyContactParam>
      </con:modifyContact>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/ContactWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/ContactWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'modifyContactParam' => [
        'orgName' => 'CONTACT_123',
        'properties' => [
            'entry' => [
                ['key' => 'phone', 'value' => '+37060000000']
            ]
        ]
    ]
];

$result = $client->modifyContact($param);
echo $result->modifyContactResult->contact->orgName . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/ContactWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: ""' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:con="http://www.sintagma.lt/avilys/ContactWS">
   <soapenv:Body>
      <con:modifyContact>
         <modifyContactParam>
            <orgName>CONTACT_123</orgName>
            <properties>
               <entry>
                  <key>phone</key>
                  <value>+37060000000</value>
               </entry>
            </properties>
         </modifyContactParam>
      </con:modifyContact>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija
