# Integracija

- Path: `/api-dok/dbsis-api/api-taikymas/linktypews/integracija`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/linktypews/integracija
- Index: 63

---

LinkTypeWS integracijos operacijos

### getLinkTypeList

[Dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/rysiu-tipu-saraso-pateikimo-sasaja#_2132-operacija-getlinktypelist)

Grąžina ryšių tipų sąrašą pagal dokumento kategoriją ir filtrus.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:lnk="http://www.sintagma.lt/avilys/LinkTypeWS">
   <soapenv:Body>
      <lnk:getLinkTypeList>
         <getLinkTypeListParam>
            <docCategory>Vidinis</docCategory>
            <infoLinksOnly>true</infoLinksOnly>
         </getLinkTypeListParam>
      </lnk:getLinkTypeList>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetLinkTypeListParam param = new GetLinkTypeListParam();
param.setDocCategory("Vidinis");
param.setInfoLinksOnly(true);

GetLinkTypeListResult result = port.getLinkTypeList(param);
for (LinkType linkType : result.getLinkType()) {
    System.out.println(linkType.getTypeCode());
}
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:lnk=\"http://www.sintagma.lt/avilys/LinkTypeWS\">
   <soapenv:Body>
      <lnk:getLinkTypeList>
         <getLinkTypeListParam>
            <docCategory>Vidinis</docCategory>
            <infoLinksOnly>true</infoLinksOnly>
         </getLinkTypeListParam>
      </lnk:getLinkTypeList>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/LinkTypeWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/LinkTypeWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'getLinkTypeListParam' => [
        'docCategory' => 'Vidinis',
        'infoLinksOnly' => true
    ]
];

$result = $client->getLinkTypeList($param);
foreach ($result->linkTypeList->linkType ?? [] as $linkType) {
    echo $linkType->typeCode . PHP_EOL;
}
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/LinkTypeWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: "http://www.sintagma.lt/avilys/LinkTypeWS/getLinkTypeList"' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:lnk="http://www.sintagma.lt/avilys/LinkTypeWS">
   <soapenv:Body>
      <lnk:getLinkTypeList>
         <getLinkTypeListParam>
            <docCategory>Vidinis</docCategory>
            <infoLinksOnly>true</infoLinksOnly>
         </getLinkTypeListParam>
      </lnk:getLinkTypeList>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija
