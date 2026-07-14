# RDODocumentWS

- Path: `/api-dok/dbsis-api/api-taikymas/rdodocumentws`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/api-taikymas/rdodocumentws
- Index: 74

---

Registruotų dokumentų valdymo SOAP sąsaja. Čia pateikiamos trumpesnės, praktiškai naudojamos operacijų instrukcijos su pavyzdžiais.

Svarbu: Namespace

Teisingas namespace yra būtinas SOAP užklausoms tinkamai veikti.

## Naudojama aplinka

| Parametras           | Reikšmė                                                                                                        |
| -------------------- | -------------------------------------------------------------------------------------------------------------- |
| **Endpoint**         | [`https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS`](https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS)           |
| **WSDL**             | [`https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS?wsdl`](https://mok.dbsis.lt/dbsis/ws-cxf/RDODocumentWS?wsdl) |
| **Target namespace** | `http://www.sintagma.lt/avilys/RDODocumentWS`                                                                  |

[Pilna dokumentacija](/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja)

---

## Skyriai

- [Dokumentų kūrimas](/api-dok/dbsis-api/api-taikymas/dokumentu-kurimas)
- [Dokumentų gavimas](/api-dok/dbsis-api/api-taikymas/dokumentu-gavimas)
- [Priedų gavimas](/api-dok/dbsis-api/api-taikymas/priedu-gavimas)
- [Dokumentų modifikavimas](/api-dok/dbsis-api/api-taikymas/dokumentu-modifikavimas)
- [Registravimas](/api-dok/dbsis-api/api-taikymas/registravimas)
- [Maršrutizavimas](/api-dok/dbsis-api/api-taikymas/marsrutizavimas)
- [Tvirtinimo schemos](/api-dok/dbsis-api/api-taikymas/tvirtinimo-schemos)
- [Užklausų priėmimas](/api-dok/dbsis-api/api-taikymas/uzklausu-priemimas)
- [Proceso rezultatų gavimas](/api-dok/dbsis-api/api-taikymas/proceso-rezultatu-gavimas)
- [Išorinių veiksmų žymėjimas](/api-dok/dbsis-api/api-taikymas/isoriniu-veiksmu-zimejimas)
- [Būsenos žymėjimas](/api-dok/dbsis-api/api-taikymas/busenos-zymejimas)

---

## Klaidų apdorojimas

Visos operacijos gali grąžinti `GSErrorFaultMsg` klaidą su šiais laukais:

| Laukas           | Tipas  | Aprašymas         |
| ---------------- | ------ | ----------------- |
| errorCode        | int    | Klaidos kodas     |
| errorDescription | string | Klaidos aprašymas |

```xml
<soap:Fault>
   <faultcode>soap:Server</faultcode>
   <faultstring>GSErrorFaultMsg</faultstring>
   <detail>
      <GSErrorFault>
         <errorCode>1001</errorCode>
         <errorDescription>Dokumentas nerastas</errorDescription>
      </GSErrorFault>
   </detail>
</soap:Fault>
```

---

## Susijusi dokumentacija

Pilna RDODocumentWS dokumentacija

Detalus visų duomenų struktūrų aprašymas

Bendros duomenų struktūros

Map, OrgNodeParam, AttachmentActionParam ir kitos bendros struktūros
