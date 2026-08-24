# Integracija

- Path: `/api-dok/dbsis-api/api-taikymas/synchronizationws/integracija`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/synchronizationws/integracija
- Index: 91

---

SynchronizationWS integracijos operacijos

### getDocsToExport

Grąžina dokumentų sąrašą, kuriuos reikia eksportuoti.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:syn="http://www.sintagma.lt/avilys/SynchronizationWS">
   <soapenv:Body>
      <syn:getDocsToExport />
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetDocsToExportResponse response = port.getDocsToExport();
System.out.println(response.getDocumentList().size());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:syn=\"http://www.sintagma.lt/avilys/SynchronizationWS\">
   <soapenv:Body>
      <syn:getDocsToExport />
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/SynchronizationWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/SynchronizationWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$result = $client->getDocsToExport();
foreach ($result->documentList ?? [] as $item) {
    echo $item->oid . PHP_EOL;
}
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/SynchronizationWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/SynchronizationWS/getDocsToExport"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:syn="http://www.sintagma.lt/avilys/SynchronizationWS">
   <soapenv:Body>
      <syn:getDocsToExport />
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### exportDoc

Eksportuoja dokumentą pagal OID ir sekos numerį.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:syn="http://www.sintagma.lt/avilys/SynchronizationWS">
   <soapenv:Body>
      <syn:exportDoc>
         <synchExporParam>
            <oid>DOC-2024-00001234</oid>
            <seqId>1</seqId>
         </synchExporParam>
      </syn:exportDoc>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
SynchronizationParam param = new SynchronizationParam();
param.setOid("DOC-2024-00001234");
param.setSeqId(1);

RootMessage result = port.exportDoc(param);
System.out.println(result.getDocOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:syn=\"http://www.sintagma.lt/avilys/SynchronizationWS\">
   <soapenv:Body>
      <syn:exportDoc>
         <synchExporParam>
            <oid>DOC-2024-00001234</oid>
            <seqId>1</seqId>
         </synchExporParam>
      </syn:exportDoc>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/SynchronizationWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/SynchronizationWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'synchExporParam' => [
        'oid' => 'DOC-2024-00001234',
        'seqId' => 1
    ]
];

$result = $client->exportDoc($param);
echo $result->exportedDoc->docOid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/SynchronizationWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/SynchronizationWS/exportDoc"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:syn="http://www.sintagma.lt/avilys/SynchronizationWS">
   <soapenv:Body>
      <syn:exportDoc>
         <synchExporParam>
            <oid>DOC-2024-00001234</oid>
            <seqId>1</seqId>
         </synchExporParam>
      </syn:exportDoc>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### importDoc

Importuoja dokumentą ir sukuria arba atnaujina įrašą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:syn="http://www.sintagma.lt/avilys/SynchronizationWS"
                  xmlns:doc="http://www.sintagma.lt/avilys/DocumentWS">
   <soapenv:Body>
      <syn:importDoc>
         <synchronizationParam>
            <oid>DOC-2024-00004567</oid>
            <category>Vidinis</category>
            <qualifier>IMPORT</qualifier>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Importuotas dokumentas</value>
               </entry>
            </docAttributes>
         </synchronizationParam>
      </syn:importDoc>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
TDOSynchronizationParam param = new TDOSynchronizationParam();
param.setOid("DOC-2024-00004567");
param.setCategory("Vidinis");
param.setQualifier("IMPORT");

Map<String, Object> attributes = param.getDocAttributes();
attributes.put("title", "Importuotas dokumentas");

TDODocumentInfo result = port.importDoc(param);
System.out.println(result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:syn=\"http://www.sintagma.lt/avilys/SynchronizationWS\"
                  xmlns:doc=\"http://www.sintagma.lt/avilys/DocumentWS\">
   <soapenv:Body>
      <syn:importDoc>
         <synchronizationParam>
            <oid>DOC-2024-00004567</oid>
            <category>Vidinis</category>
            <qualifier>IMPORT</qualifier>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Importuotas dokumentas</value>
               </entry>
            </docAttributes>
         </synchronizationParam>
      </syn:importDoc>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/SynchronizationWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/SynchronizationWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'synchronizationParam' => [
        'oid' => 'DOC-2024-00004567',
        'category' => 'Vidinis',
        'qualifier' => 'IMPORT',
        'docAttributes' => [
            'entry' => [
                ['key' => 'title', 'value' => 'Importuotas dokumentas']
            ]
        ]
    ]
];

$result = $client->importDoc($param);
echo $result->documentInfo->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/SynchronizationWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/SynchronizationWS/importDoc"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:syn="http://www.sintagma.lt/avilys/SynchronizationWS"
                  xmlns:doc="http://www.sintagma.lt/avilys/DocumentWS">
   <soapenv:Body>
      <syn:importDoc>
         <synchronizationParam>
            <oid>DOC-2024-00004567</oid>
            <category>Vidinis</category>
            <qualifier>IMPORT</qualifier>
            <docAttributes>
               <entry>
                  <key>title</key>
                  <value>Importuotas dokumentas</value>
               </entry>
            </docAttributes>
         </synchronizationParam>
      </syn:importDoc>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### markExported

Pažymi dokumentą kaip eksportuotą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:syn="http://www.sintagma.lt/avilys/SynchronizationWS">
   <soapenv:Body>
      <syn:markExported>
         <markExportedParam>
            <docOid>DOC-2024-00001234</docOid>
            <seqId>1</seqId>
            <success>true</success>
         </markExportedParam>
      </syn:markExported>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
MarkExportedParam param = new MarkExportedParam();
param.setDocOid("DOC-2024-00001234");
param.setSeqId(1);
param.setSuccess(true);

TDODocumentInfo result = port.markExported(param);
System.out.println(result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:syn=\"http://www.sintagma.lt/avilys/SynchronizationWS\">
   <soapenv:Body>
      <syn:markExported>
         <markExportedParam>
            <docOid>DOC-2024-00001234</docOid>
            <seqId>1</seqId>
            <success>true</success>
         </markExportedParam>
      </syn:markExported>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/SynchronizationWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/SynchronizationWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'markExportedParam' => [
        'docOid' => 'DOC-2024-00001234',
        'seqId' => 1,
        'success' => true
    ]
];

$result = $client->markExported($param);
echo $result->markExported->oid . PHP_EOL;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/SynchronizationWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/SynchronizationWS/markExported"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:syn="http://www.sintagma.lt/avilys/SynchronizationWS">
   <soapenv:Body>
      <syn:markExported>
         <markExportedParam>
            <docOid>DOC-2024-00001234</docOid>
            <seqId>1</seqId>
            <success>true</success>
         </markExportedParam>
      </syn:markExported>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija
