# Susietų dokumentų pateikimo sąsaja

- Path: `/api-dok/dbsis-api/duomenu-strukturos/susietu-dokumentu-pateikimo-sasaja`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/duomenu-strukturos/susietu-dokumentu-pateikimo-sasaja
- Index: 12

---

Susietų dokumentų pateikimo sąsaja („DocLinkWS“)

## Apibendrinimas

- Sąsaja pateikiama SOAP protokolu.
- Sąsajos pavadinimas: DocLinkWS

### Bendrai naudojamos esybės

- Šios sąsajos operacijų parametrai paveldi iš „BaseParam“ esybės (žr. Esybė „BaseParam“ – bazinė WS operacijų parametro esybė).

---

## 2.10.1.1 Esybė „LinkedDocument“

- Esybė, skirta perduoti susieto dokumento informaciją. Esybės atributai pateikti žemiau esančioje lentelėje.

## Lentelė 197. Esybės „LinkedDocument“ laukų sąrašas

| Pavadinimas | Tipas             | Privalomas | Pasikartojantis | Aprašymas                                                                                   |
| ----------- | ----------------- | ---------- | --------------- | ------------------------------------------------------------------------------------------- |
| side        | enum              | Taip       | Ne              | Ryšio pusė, kurioje yra „targetDoc“                                                         |
| targetDoc   | GetDocumentResult | Taip       | Ne              | Susieto dokumento informacija (žr.: Lentelė 22. Esybės „GetDocumentResult“ laukų aprašymas) |
| link        | Link              | Taip       | Ne              | Sąryšio informacija (žr.: Lentelė 198. Esybės „Link“ laukų sąrašas)                         |

## 2.10.1.2 Esybė „Link“

- Esybė, skirta perduoti sąryšio tarp dokumentų duomenis. Esybės atributai pateikti žemiau esančioje lentelėje.

## Lentelė 198. Esybės „Link“ laukų sąrašas

| Pavadinimas  | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                                                           |
| ------------ | ------------ | ---------- | --------------- | ----------------------------------------------------------------------------------- |
| oid          | string       | Taip       | Ne              | Ryšio objekto unikalus vidinis ID.                                                  |
| type         | string       | Taip       | Ne              | Ryšio tipas                                                                         |
| parentDocOid | string       | Taip       | Ne              | Tėvinio susieto dokumento OID.                                                      |
| childDocOid  | string       | Taip       | Ne              | Vaikinio susieto dokumento OID.                                                     |
| created      | TrackingInfo | Taip       | Ne              | Susiejimo veiksmo informacija (žr.: Lentelė 14. Esybė „TrackingInfo“ laukų sąrašas) |

## 2.10.2 Operacija „getLinkedDocuments“

- Operacija grąžina dokumentus, kurie yra susieti su pateiktu dokumentu tam tikru susiejimo tipu.
- Operacijai paduodama esybė GetLinkedDocumentsParam. Jos struktūra pateikta žemiau esančioje lentelėje:

## Lentelė 199. Esybės „GetLinkedDocumentsParam“ laukų sąrašas

| Pavadinimas | Tipas              | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                |
| ----------- | ------------------ | ---------- | --------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------- |
| docOid      | string             | Taip       | Ne              | Dokumento OID, su kuriuo susietus dokumentus norima gauti.                                                                                               |
| linkType    | string             | Ne         | Ne              | Sąryšio tipas. Jei nenurodomas, pateikiami visų tipų sąryšiais susieti dokumentai.                                                                       |
| side        | enum               | Ne         | Ne              | Kurioje sąryšio pusėje esančius dokumentus grąžinti. Galimos reikšmės: „SIDE\_A“ arba „SIDE\_B“. Jei nenurodomas – grąžinami dokumentai iš abiejų pusių. |
| expand      | DocumentExpandType | Ne         | Ne              | Sąrašas atributų pavadinimų, nusakantis kurių atributų ir kokios apimties informacija pateikiama (žr. Esybė „DocumentExpandType“)                        |

- Operacija grąžina esybę GetLinkedDocumentsResult, kurios atributai aprašyti žemiau esančioje lentelėje.

## Lentelė 200. „GetLinkedDocumentsResult“ esybės laukų sąrašas

| Pavadinimas    | Tipas          | Privalomas | Pasikartojantis | Aprašymas                                                                            |
| -------------- | -------------- | ---------- | --------------- | ------------------------------------------------------------------------------------ |
| linkedDocument | LinkedDocument | Ne         | Taip            | Sąrašas susietų dokumentų (žr.: Lentelė 197. Esybės „LinkedDocument“ laukų sąrašas). |

## 2.10.3 Operacija „createDocumentLink“

- Operacija prie nurodyto dokumento susieja nurodytą dokumentą.
- Operacijai paduodama esybė CreateDocumentLinkParam. Jos struktūra pateikta žemiau esančioje lentelėje:

## Lentelė 201. „CreateDocumentLinkParam“ esybės laukų sąrašas

| Pavadinimas   | Tipas  | Privalomas | Pasikartojantis | Aprašymas                                                                                                              |
| ------------- | ------ | ---------- | --------------- | ---------------------------------------------------------------------------------------------------------------------- |
| sourceOid     | string | Taip       | Ne              | Dokumento, prie kurio siejamas kitas dokumentas, OID. Šis dokumentas visada bus sąryšio gale ‚A‘.                      |
| targetOid     | string | Taip       | Ne              | Dokumento, kurį susieti su „source“ dokumentu, OID. Šis dokumentas visada bus sąryšio gale ‚B‘.                        |
| linkType      | string | Taip       | Ne              | Sąryšio tipas, kuriuo susieti dokumentus. Pastaba: gali būti nurodytas tik infolink (dinamiškai kuriamas) ryšio tipas. |
| targetDocSide | enum   | Taip       | Ne              | Kurioje sąryšio pusėje turi būti nurodytas („target“) dokumentas. Galimos reikšmės: „SIDE\_A“ arba „SIDE\_B“.          |

- Operacija grąžina esybę CreateDocumentLinkResult, kurios atributai aprašyti žemiau esančioje lentelėje.

## Lentelė 202. „CreateDocumentLinkResult“ esybės laukų sąrašas

| Pavadinimas | Tipas   | Privalomas | Pasikartojantis | Aprašymas |
| ----------- | ------- | ---------- | --------------- | --------- |
| status      | Boolean | Taip       | Taip            |           |
