# Pavadavimų sąsaja

- Path: `/api-dok/dbsis-api/duomenu-strukturos/pavadavimu-sasaja`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/duomenu-strukturos/pavadavimu-sasaja
- Index: 17

---

Pavadavimų sąsaja („SubstDocumentWS“)

## Apibendrinimas

- Sąsaja pateikiama SOAP protokolu.
- Sąsajos pavadinimas: SubstDocumentWS
- Sąsajos vardų sritis: <http://www.sintagma.lt/avilys/SubstDocumentWS>.

### Bendrai naudojamos esybės

Šios sąsajos operacijų parametrai paveldi iš „BaseParam“ esybės (žr. Esybė „BaseParam“ – bazinė WS operacijų parametro esybė).

---

## 2.15.1.1 Esybė „SubstDocumentInfo“ – grąžinama pavadavimo informacija

- Žr. skyrių 2.1.43 Esybė „SubstDocumentInfo“ – grąžinama glausta pavadavimo informacija.

## 2.15.2 Operacija „createDocumentFromTemplate“

- Operacija skirta pavadavimo sukūrimui DBSIS.
- Operacijai paduodama esybė SubstDocumentFromTemplateParam. Jos struktūra pateikta žemiau esančioje lentelėje:

## Lentelė 219. Operacijos „createDocumentFromTemplate“ parametro aprašymas

| Pavadinimas                    | Tipas                          | Privalomas | Pasikartojantis | Aprašymas                                                                                               |
| ------------------------------ | ------------------------------ | ---------- | --------------- | ------------------------------------------------------------------------------------------------------- |
| substDocumentFromTemplateParam | SubstDocumentFromTemplateParam | Taip       | Ne              | Sukuriamo pavadavimo parametrai (žr. Lentelė 220. Esybės „SubstDocumentFromTemplateParam“ laukų sąrašas |

## Lentelė 220. Esybės „SubstDocumentFromTemplateParam“ laukų sąrašas

| Pavadinimas   | Tipas                                   | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                            |
| ------------- | --------------------------------------- | ---------- | --------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------- |
| docAttributes | Lentelė 2. Esybės „Map“ laukų aprašymas | Taip       | Ne              | Dokumento metaduomenų sąrašas. Galimų reikšmių sąrašas pateiktas Lentelė 221. „docAttributes“ galimų laukų sąrašas.                                  |
| templateParam | TemplateParam                           | Ne         | Ne              | Nurodomas dokumento šablonas (žr. Lentelė 16. Esybės „TemplateParam“ laukų sąrašas). Nepateikus reikšmės naudojamas numatytasis pavadavimo šablonas. |
| linkedDoc     | String                                  | Ne         | Ne              | Su pavadavimu susiejamo vidaus dokumento oid.                                                                                                        |

- Laukas docAttributes - tai Map tipo struktūra (aprašymą žr. Lentelė 2. Esybės „Map“ laukų aprašymas). Šioje struktūroje pateikiami įkeliamo dokumento metaduomenys. Galimi metaduomenys pateikiami žemiau esančioje lentelėje. Tarp nurodomų docAttributes reikšmių būtina nurodyti darbuotoją ir pavadavimo pradžios, t.y. galioja nuo (imtinai) reikšmes.

## Lentelė 221. „docAttributes“ galimų laukų sąrašas

| Pavadinimas                  | Tipas    | Privalomas | Pasikartojantis | Aprašymas                                                 |
| ---------------------------- | -------- | ---------- | --------------- | --------------------------------------------------------- |
| realStaff                    | orgNode  | Ne         | Ne              | Darbuotojas, kuris bus pavaduojamas                       |
| substituteStaff              | orgNode  | Ne         | Ne              | Pavaduojantis darbuotojas                                 |
| startDate                    | dateTime | Ne         | Ne              | Galioja nuo (imtinai)                                     |
| endDate                      | dateTime | Ne         | Ne              | Galioja iki (imtinai)                                     |
| substituteOfficialName       | String   | Ne         | Ne              | Pavaduojančios pareigybės pavadinimas                     |
| substituteOfficialNameDative | String   | Ne         | Ne              | Pavaduojančios pareigybės pavadinimas naudininko linksniu |
| substituteReason             | String   | Ne         | Ne              | Nebuvimo darbe priežastis                                 |

- Operacija grąžina SubstDocumentInfo tipo rezultatą (žr. skyrių 2.15.1.1 Esybė „SubstDocumentInfo“ – grąžinama pavadavimo informacija).

## Lentelė 222. Operacijos „createDocumentFromTemplate“ rezultato aprašymas

| Pavadinimas  | Tipas             | Privalomas | Pasikartojantis | Aprašymas                                                                                     |
| ------------ | ----------------- | ---------- | --------------- | --------------------------------------------------------------------------------------------- |
| documentInfo | SubstDocumentInfo | Taip       | Ne              | Grąžinama pavadavimo informacija (žr. Lentelė 45. „SubstDocumentInfo“ esybės laukų aprašymas) |

## 2.15.3 Operacija „modifyDocument“

- Operacija skirta pavadavimo redagavimui DBSIS.
- Operacijai paduodama esybė ModifySubstDocumentParam. Jos struktūra pateikta žemiau esančioje lentelėje:

## Lentelė 223. Operacijos „modifyDocument“ parametro aprašymas

| Pavadinimas              | Tipas                    | Privalomas | Pasikartojantis | Aprašymas                                                                                            |
| ------------------------ | ------------------------ | ---------- | --------------- | ---------------------------------------------------------------------------------------------------- |
| modifySubstDocumentParam | ModifySubstDocumentParam | Taip       | Ne              | Redaguojamo pavadavimo parametrai (žr. Lentelė 224. Esybės „ModifySubstDocumentParam“ laukų sąrašas) |

## Lentelė 224. Esybės „ModifySubstDocumentParam“ laukų sąrašas

| Pavadinimas   | Tipas                                   | Privalomas | Pasikartojantis | Aprašymas                                                                                                           |
| ------------- | --------------------------------------- | ---------- | --------------- | ------------------------------------------------------------------------------------------------------------------- |
| docOid        | String                                  | Taip       | Ne              | Redaguojamo pavadavimo oid.                                                                                         |
| docAttributes | Lentelė 2. Esybės „Map“ laukų aprašymas | Taip       | Ne              | Dokumento metaduomenų sąrašas. Galimų reikšmių sąrašas pateiktas Lentelė 221. „docAttributes“ galimų laukų sąrašas. |
| linkedDoc     | String                                  | Ne         | Ne              | Su pavadavimu susiejamo vidaus dokumento oid.                                                                       |

- Nurodant parametrus pavadavimo redagavimo veiksmui, jeigu redaguojamas pavadavimas jau buvo apdorotas, nurodyti duomenis atributams „Darbuotojas“ ir „Galioja nuo (imtinai)“ nėra būtina, tačiau nurodžius, šie duomenys privalo atitikti pavadavime įvestus duomenis. Jeigu pavadavimas dar neapdorotas (tai galima nuspręsti pagal pavadavimo pradžios datą), tai galima pakeisti atributų „Darbuotojas“ ir „Galioja nuo (imtinai)“ reikšmes.
- Operacija „modifyDocument“ grąžina SubstDocumentInfo tipo rezultatą (žr. skyrių 2.15.1.1 Esybė „SubstDocumentInfo“ – grąžinama pavadavimo informacija).
