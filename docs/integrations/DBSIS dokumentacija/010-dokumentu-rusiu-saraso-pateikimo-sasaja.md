# Dokumentų rūšių sąrašo pateikimo sąsaja

- Path: `/api-dok/dbsis-api/duomenu-strukturos/dokumentu-rusiu-saraso-pateikimo-sasaja`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/duomenu-strukturos/dokumentu-rusiu-saraso-pateikimo-sasaja
- Index: 10

---

Dokumentų rūšių sąrašo pateikimo sąsaja („DocumentSortWS“)

## Apibendrinimas

- Sąsaja pateikiama SOAP protokolu.
- Sąsajos pavadinimas: DocumentSortWS.
- Sąsajos vardų sritis: <http://www.sintagma.lt/avilys/DocumentSortWS>.
- Sąsaja skirta pateikti dokumentų rūšių sąrašus. Sąraše nurodytos reikšmės gali būti naudojamos dokumentų paieškos kriterijams formuoti arba dokumentams kurti.

---

## 2.8.1 Operacija „getItemTypeList“

- Operacija grąžina sąrašą dokumentų tipų, kuriems kuriamos atskiros dokumentų rūšys. Operacijai parametrai nepaduodami.
- Operacija grąžina esybę „GetItemTypeListResult“, kurios struktūra aprašyta toliau pateiktoje lentelėje:

## Lentelė 176. Esybės „GetItemTypeListResult“ reikšmių aprašymas

| Pavadinimas | Tipas    | Privalomas | Pasikartojantis | Aprašymas                                                                           |
| ----------- | -------- | ---------- | --------------- | ----------------------------------------------------------------------------------- |
| linkType    | ClsEntry | Ne         | Taip            | Vieno dokumento tipas, naudojamas dokumentų rūšims kurti. Klasifikatoriaus reikšmė. |

## 2.8.2 Operacija „getDocumentSortListByItemType“

- Operacija grąžina dokumentų rūšių sąrašą pagal pateiktą dokumentų tipą. Operacijai paduodama esybė „GetDocumentSortListByItemTypeParam“. Jos struktūra aprašyta toliau pateiktoje lentelėje.

## Lentelė 177. Esybės „GetDocumentSortListByItemTypeParam“ reikšmių aprašymas

| Pavadinimas | Tipas         | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                                   |
| ----------- | ------------- | ---------- | --------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| itemType    | ClsEntryParam | Ne         | Ne              | Dokumento tipas, kuriam kuriamos atskiros dokumentų rūšys. Nurodoma klasifikatoriaus reikšmė, esanti operacijos „getItemTypeList“ rezultatų sąraše. (žr.: Lentelė 18. Esybės „ClsEntryParam“ laukų sąrašas) |

- Operacija grąžina esybę „GetDocumentSortListResult“.

## Lentelė 178. Esybės „GetDocumentSortListResult“ reikšmių aprašymas

| Pavadinimas  | Tipas            | Privalomas | Pasikartojantis | Aprašymas                            |
| ------------ | ---------------- | ---------- | --------------- | ------------------------------------ |
| documentSort | DocumentSortBean | Ne         | Taip            | Vienos dokumento rūšies informacija. |
