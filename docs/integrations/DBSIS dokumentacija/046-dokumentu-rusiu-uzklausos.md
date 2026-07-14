# Dokumentų rūšių užklausos

- Path: `/api-dok/dbsis-api/api-taikymas/documentsortws/dokumentu-rusiu-uzklausos`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/documentsortws/dokumentu-rusiu-uzklausos
- Index: 46

---

DocumentSortWS dokumentų rūšių užklausos

### getItemTypeList

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/dokumentu-rusiu-saraso-pateikimo-sasaja#_281-operacija-getitemtypelist)

Grąžina dokumentų tipų sąrašą, kuriems kuriamos dokumentų rūšys.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:doc="http://www.sintagma.lt/avilys/DocumentSortWS">
   <soapenv:Body>
      <doc:getItemTypeList />
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetItemTypeListResult result = port.getItemTypeList();
for (ClsEntry itemType : result.getItemType()) {
    System.out.println(itemType.getClsid());
}
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:doc=\"http://www.sintagma.lt/avilys/DocumentSortWS\">
   <soapenv:Body>
      <doc:getItemTypeList />
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/DocumentSortWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/DocumentSortWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$result = $client->getItemTypeList();
foreach ($result->itemTypeList->itemType ?? [] as $itemType) {
    echo $itemType->clsid . PHP_EOL;
}
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/DocumentSortWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/DocumentSortWS/getItemTypeList"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:doc="http://www.sintagma.lt/avilys/DocumentSortWS">
   <soapenv:Body>
      <doc:getItemTypeList />
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getDocumentSortListByItemType

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/dokumentu-rusiu-saraso-pateikimo-sasaja#_282-operacija-getdocumentsortlistbyitemtype)

Grąžina dokumentų rūšių sąrašą pagal dokumento tipą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:doc="http://www.sintagma.lt/avilys/DocumentSortWS">
   <soapenv:Body>
      <doc:getDocumentSortListByItemType>
         <getDocumentSortListByItemTypeParam>
            <itemType>
               <clsid>ITEM_TYPE_001</clsid>
            </itemType>
         </getDocumentSortListByItemTypeParam>
      </doc:getDocumentSortListByItemType>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetDocumentSortListByItemTypeParam param = new GetDocumentSortListByItemTypeParam();
ClsEntryParam itemType = new ClsEntryParam();
itemType.setClsid("ITEM_TYPE_001");
param.setItemType(itemType);

GetDocumentSortListResult result = port.getDocumentSortListByItemType(param);
for (DocumentSortBean sort : result.getDocumentSort()) {
    System.out.println(sort.getDocSort());
}
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:doc=\"http://www.sintagma.lt/avilys/DocumentSortWS\">
   <soapenv:Body>
      <doc:getDocumentSortListByItemType>
         <getDocumentSortListByItemTypeParam>
            <itemType>
               <clsid>ITEM_TYPE_001</clsid>
            </itemType>
         </getDocumentSortListByItemTypeParam>
      </doc:getDocumentSortListByItemType>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/DocumentSortWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/DocumentSortWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'getDocumentSortListByItemTypeParam' => [
        'itemType' => ['clsid' => 'ITEM_TYPE_001']
    ]
];

$result = $client->getDocumentSortListByItemType($param);
foreach ($result->documentSortList->documentSort ?? [] as $sort) {
    echo $sort->docSort . PHP_EOL;
}
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/DocumentSortWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/DocumentSortWS/getDocumentSortListByItemType"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:doc="http://www.sintagma.lt/avilys/DocumentSortWS">
   <soapenv:Body>
      <doc:getDocumentSortListByItemType>
         <getDocumentSortListByItemTypeParam>
            <itemType>
               <clsid>ITEM_TYPE_001</clsid>
            </itemType>
         </getDocumentSortListByItemTypeParam>
      </doc:getDocumentSortListByItemType>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija
