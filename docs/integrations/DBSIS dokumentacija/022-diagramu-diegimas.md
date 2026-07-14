# Diagramų diegimas

- Path: `/api-dok/dbsis-api/api-taikymas/activitideployerws/diagramu-diegimas`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/activitideployerws/diagramu-diegimas
- Index: 22

---

ActivitiDeployerWS diegimo ir JSON gavimo operacijos

### deployDiagram

Įdiegia arba atnaujina Activiti diagramą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:act="http://www.sintagma.lt/avilys/ActivitiDeployerWS">
   <soapenv:Body>
      <act:deployDiagram>
         <deployParam>
            <oid>ACT-001</oid>
            <propertiesJsonContent>{"name":"Procesas","version":"1.0"}</propertiesJsonContent>
            <bpmXmlContent><![CDATA[<definitions id="process" />]]></bpmXmlContent>
            <user>admin</user>
            <saveType>UPDATE</saveType>
         </deployParam>
      </act:deployDiagram>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
DeployParam param = new DeployParam();
param.setOid("ACT-001");
param.setPropertiesJsonContent("{\"name\":\"Procesas\",\"version\":\"1.0\"}");
param.setBpmXmlContent("<definitions id=\"process\" />");
param.setUser("admin");
param.setSaveType("UPDATE");

ActivitiDiagramDeployResult result = port.deployDiagram(param);
System.out.println("Rezultatas: " + result.getResult());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:act=\"http://www.sintagma.lt/avilys/ActivitiDeployerWS\">
   <soapenv:Body>
      <act:deployDiagram>
         <deployParam>
            <oid>ACT-001</oid>
            <propertiesJsonContent>{\"name\":\"Procesas\",\"version\":\"1.0\"}</propertiesJsonContent>
            <bpmXmlContent><![CDATA[<definitions id=\"process\" />]]></bpmXmlContent>
            <user>admin</user>
            <saveType>UPDATE</saveType>
         </deployParam>
      </act:deployDiagram>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/ActivitiDeployerWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/ActivitiDeployerWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'deployParam' => [
        'oid' => 'ACT-001',
        'propertiesJsonContent' => '{"name":"Procesas","version":"1.0"}',
        'bpmXmlContent' => '<definitions id="process" />',
        'user' => 'admin',
        'saveType' => 'UPDATE'
    ]
];

$result = $client->deployDiagram($param);
echo "Rezultatas: " . $result->activitiDiagramDeployResult->result;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/ActivitiDeployerWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: ""' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:act="http://www.sintagma.lt/avilys/ActivitiDeployerWS">
   <soapenv:Body>
      <act:deployDiagram>
         <deployParam>
            <oid>ACT-001</oid>
            <propertiesJsonContent>{"name":"Procesas","version":"1.0"}</propertiesJsonContent>
            <bpmXmlContent><![CDATA[<definitions id="process" />]]></bpmXmlContent>
            <user>admin</user>
            <saveType>UPDATE</saveType>
         </deployParam>
      </act:deployDiagram>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija

---

### getDeployedDiagramJson

Grąžina įdiegtos diagramos JSON aprašą.

**Pavyzdžiai:** XML, Java, C#, PHP, cURL

```xml
<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:act="http://www.sintagma.lt/avilys/ActivitiDeployerWS">
   <soapenv:Body>
      <act:getDeployedDiagramJson>
         <oid>ACT-001</oid>
      </act:getDeployedDiagramJson>
   </soapenv:Body>
</soapenv:Envelope>
```

```java
GetActivitiDiagramResultBean result = port.getDeployedDiagramJson("ACT-001");
System.out.println("Diagram ID: " + result.getOid());
```

```csharp
using System.Net.Http;
using System.Text;

var soapEnvelope = @"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
                  xmlns:act=\"http://www.sintagma.lt/avilys/ActivitiDeployerWS\">
   <soapenv:Body>
      <act:getDeployedDiagramJson>
         <oid>ACT-001</oid>
      </act:getDeployedDiagramJson>
   </soapenv:Body>
</soapenv:Envelope>";

using var httpClient = new HttpClient();
var content = new StringContent(soapEnvelope, Encoding.UTF8, "text/xml");
var response = await httpClient.PostAsync(
    "https://mok.dbsis.lt/dbsis/ws-cxf/ActivitiDeployerWS",
    content
);
var responseXml = await response.Content.ReadAsStringAsync();
Console.WriteLine(responseXml);
```

```php
$wsdl = 'https://mok.dbsis.lt/dbsis/ws-cxf/ActivitiDeployerWS?wsdl';
$options = [
    'trace' => true,
    'exceptions' => true,
    'soap_version' => SOAP_1_1
];

$client = new SoapClient($wsdl, $options);

$param = [
    'oid' => 'ACT-001'
];

$result = $client->getDeployedDiagramJson($param);
echo "Diagram ID: " . $result->getActivitiDiagramResult->oid;
```

```bash
curl -X POST 'https://mok.dbsis.lt/dbsis/ws-cxf/ActivitiDeployerWS' \
  -H 'Content-Type: text/xml; charset=utf-8' \
  -H 'SOAPAction: ""' \
  -d '<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                  xmlns:act="http://www.sintagma.lt/avilys/ActivitiDeployerWS">
   <soapenv:Body>
      <act:getDeployedDiagramJson>
         <oid>ACT-001</oid>
      </act:getDeployedDiagramJson>
   </soapenv:Body>
</soapenv:Envelope>'
```

#### Papildoma informacija
