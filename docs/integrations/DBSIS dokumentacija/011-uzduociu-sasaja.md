# Užduočių sąsaja

- Path: `/api-dok/dbsis-api/duomenu-strukturos/uzduociu-sasaja`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/duomenu-strukturos/uzduociu-sasaja
- Index: 11

---

Užduočių sąsaja („TDODocumentWS“)

## Apibendrinimas

- Sąsaja pateikiama SOAP protokolu.
- Sąsajos pavadinimas: TODDocumentWS
- Sąsajos vardų sritis: <http://www.sintagma.lt/avilys/TDODocumentWS>.

### Bendrai naudojamos esybės

Šios sąsajos operacijų parametrai paveldi iš „BaseParam“ esybės (žr. Esybė „BaseParam“ – bazinė WS operacijų parametro esybė).

---

## 2.9.1.1 Esybė „DocumentInfo“ – grąžinama užduoties informacija

- Namespace: <http://www.sintagma.lt/avilys/TDODocumentWS>
- Pavadinimas: TDODocumentInfo
- Šia esybe grąžinama glausta informacija užduoti, kai buvo atliktas veiksmas su juo. Esybės laukų sąrašas pateiktas žemiau esančioje lentelėje:

## Lentelė 179. „TDODocumentInfo“ esybės laukų aprašymas

| Pavadinimas | Tipas  | Privalomas | Pasikartojantis | Aprašymas                                                      |
| ----------- | ------ | ---------- | --------------- | -------------------------------------------------------------- |
| docOid      | string | Taip       | Ne              | Unikalus dokumento identifikatorius                            |
| creationNo  | string | Ne         | Ne              | Užduoties numeris.                                             |
| createdDate | date   | Ne         | Ne              | Užduoties sukūrimo data.                                       |
| docCategory | string | Ne         | Ne              | Užduoties kategorija, nusakanti, kokio tipo užduotis grąžinama |

## 2.9.1.2 Esybė „GetTDODocumentResult“

## Lentelė 180. Esybės „GetTDODocumentResult“ laukų sąrašas

- Paveldi viską iš „GetDocumentResult“ žr.: Lentelė 22. Esybės „GetDocumentResult“ laukų aprašymas

| Pavadinimas      | Tipas               | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                         |
| ---------------- | ------------------- | ---------- | --------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| resultAttachment | AttachmentReference | Ne         | Taip            | Dokumento arba jo priedo rinkmena. Galima nurodyti kelias.  Konkretus tipas priklauso nuo parametro „retrieveResultAttachment“ reikšmės (žr.: Lentelė 29. Esybės „AttachmentBase“ laukų sąrašas). |

- Laukas docAttributes - tai Map tipo struktūra (aprašymą žr. skyriuje Lentelė 2. Esybės „Map“ laukų aprašymas). Šioje struktūroje pateikiami dokumento metaduomenys. Galimi metaduomenys pateikiami žemiau esančioje lentelėje. Priklausomai nuo DBSIS konfigūracijos, gali būti pateikiami ir kiti, lentelėje nepaminėti, metaduomenys.

Pastaba: Grąžinamų laukų reikšmės gali priklausyti nuo to, ar šių laukų pavadinimai nurodyti „expand“ parametre (žr. Esybė „DocumentExpandType“).

## Lentelė 181. Atributo „docAttributes“ galimų laukų sąrašas

| Pavadinimas        | Tipas    | Pasikartojantis | Aprašymas                            |
| ------------------ | -------- | --------------- | ------------------------------------ |
| status             | string   | Ne              | Užduoties būsena                     |
| description        | string   | Ne              | Tekstas                              |
| title              | string   | Ne              | Antraštė                             |
| createdDate        | dateTime | Ne              | Užduoties sukūrimo data              |
| creationNo         | string   | Ne              | Užduoties nr.                        |
| controlType        | string   | Ne              | Užduoties kontrolės tipas            |
| controller         | OrgNode  | Ne              | Kontrolierius                        |
| curator            | OrgNode  | Ne              | Kuratorius                           |
| chiefExecutor      | OrgNode  | Ne              | Atsakingas vykdytojas                |
| dueBy              | date     | Ne              | Įvykdymo terminas                    |
| closedDate         | date     | Ne              | Užbaigimo data                       |
| process            | string   | Ne              | Darbo eigos proceso identifikatorius |
| assignmentTaskType | ClsEntry | Ne              | Veiklos užduoties tipas              |
| completionDate     | date     |                 | Užbaigimo data                       |
| priority           | ClsEntry | Ne              | Prioritetas                          |
| resultText         | string   | Ne              | Užduoties rezultatai                 |

## 2.9.2 Operacija „createDocumentFromTemplate“

- Operacija skirta užduoties sukūrimui DBSIS.
- Operacijai paduodama esybė TDODocumentFromTemplateParam. Jos struktūra pateikta žemiau esančioje lentelėje:

## Lentelė 182. Esybės „TDODocumentFromTemplateParam“ laukų sąrašas

- Paveldi viską iš „ModifyDocumentParam“ žr.: Lentelė 16. Esybės „TemplateParam“ laukų sąrašas

| Pavadinimas   | Tipas         | Privalomas | Pasikartojantis | Aprašymas                                                                            |
| ------------- | ------------- | ---------- | --------------- | ------------------------------------------------------------------------------------ |
| templateParam | TemplateParam | Taip       | Ne              | Nurodomas dokumento šablonas (žr. Lentelė 16. Esybės „TemplateParam“ laukų sąrašas). |

- Operacija grąžina DocumentInfo tipo rezultatą (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas).

## Lentelė 183. Operacijos „createDocumentFromTemplate“ rezultato aprašymas

| Pavadinimas                | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                                            |
| -------------------------- | ------------ | ---------- | --------------- | -------------------------------------------------------------------- |
| createDocumentFromTemplate | DocumentInfo | Taip       | Ne              | (žr. 2.9.1.1 Esybė „DocumentInfo“ – grąžinama užduoties informacija) |

## Lentelė 184. Atributo „docAttributes“ galimų laukų sąrašas

| Pavadinimas          | Tipas    | Pasikartojantis | Aprašymas                            |
| -------------------- | -------- | --------------- | ------------------------------------ |
| status               | string   | Ne              | Sutarties būsena                     |
| description          | string   | Ne              | Tekstas                              |
| title                | string   | Ne              | Antraštė                             |
| createdDate          | dateTime | Ne              | Užduoties sukūrimo data              |
| creationNo           | string   | Ne              | Užduoties nr.                        |
| controlType          | string   | Ne              | Užduoties kontrolės tipas            |
| controller           | OrgNode  | Ne              | Kontrolierius                        |
| curator              | OrgNode  | Ne              | Kuratorius                           |
| chiefExecutor        | OrgNode  | Taip            | Atsakingas vykdytojas                |
| dueBy                | date     | Taip            | Įvykdymo terminas                    |
| closedDate           | date     | Ne              | Užbaigimo data                       |
| process              | string   | Ne              | Darbo eigos proceso identifikatorius |
| assignmentTaskType   | ClsEntry | Ne              | Veiklos užduoties tipas              |
| completionDate       | date     | Ne              | Užbaigimo data                       |
| priority             | ClsEntry | Ne              | Prioritetas                          |
| estimate             | integer  | Ne              | Vertė                                |
| isEstimateCalculated | boolean  | Ne              | Ar sumuojama vertė                   |

## 2.9.3 Operacija „getDocument“

- Operacija skirta gauti detalią užduoties informaciją.
- Operacijai paduodama esybė GetTDODocumentParam. Jos struktūra pateikta žemiau esančioje lentelėje:

## Lentelė 185. Esybės „GetDocumentParam“ laukų sąrašas

- Paveldi viską iš „GetDocumentParam“ žr.: Lentelė 0 145 Esybės „GetDocumentParam“ laukų sąrašas

| Pavadinimas              | Tipas | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                                                                                                                                            |
| ------------------------ | ----- | ---------- | --------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| retrieveResultAttachment | enum  | Ne         | Ne              | Nurodoma, kaip pateikti dokumento rezultatų rinkmenas: „ID“ – pateikiamas tik jų ID. „METADATA“ – pateikiami metaduomenys be turinio. „METADATA\_WITH\_ELECTRO“ – pateikiami metaduomenys ir papildoma informacija, jei rinkmena yra elektroninio dokumento pakuotė. „CONTENT“ – pateikiami metaduomenys su turiniu. |

- Operacija grąžina esybę: „GetTDODocumentResult“.

## Lentelė 186. Operacijos „getDocument“ rezultato aprašymas

| Pavadinimas | Tipas                | Privalomas | Pasikartojantis | Aprašymas                                   |
| ----------- | -------------------- | ---------- | --------------- | ------------------------------------------- |
| Document    | GetTDODocumentResult | Taip       | Ne              | (žr.: 2.9.1.2 Esybė „GetTDODocumentResult“) |

## 2.9.4 Operacija „getLinkedResults“

- Operacija skirta gauti susietų užduoties rezultatų sąrašą.
- Operacijai paduodama esybė GetLinkedResultsParam. Jos struktūra pateikta žemiau esančioje lentelėje:

## Lentelė 187. Esybės „GetLinkedResultsParam“ laukų sąrašas

| Pavadinimas | Tipas              | Privalomas | Pasikartojantis | Aprašymas                                                                                                                         |
| ----------- | ------------------ | ---------- | --------------- | --------------------------------------------------------------------------------------------------------------------------------- |
| docOid      | string             | Taip       | Ne              | Unikalus dokumento identifikatorius                                                                                               |
| expand      | DocumentExpandType | Ne         | Ne              | Sąrašas atributų pavadinimų, nusakantis kurių atributų ir kokios apimties informacija pateikiama (žr. Esybė „DocumentExpandType“) |

- Operacija grąžina esybę: „GetLinkedDocumentsResult“ (žr. į. 2.10.2).

## 2.9.5 Operacija „modifyDocument“

- Operacija skirta redaguoti užduoties duomenis kol užduotis yra nepaskirta arba vykdoma.
- Operacijai paduodama esybė ModifyTDODocumentParam. Jos struktūra pateikta žemiau esančioje lentelėje:

## Lentelė 188. Operacijos „modifyDocument“ parametro aprašymas

| Pavadinimas         | Tipas                  | Privalomas | Pasikartojantis | Aprašymas                                                             |
| ------------------- | ---------------------- | ---------- | --------------- | --------------------------------------------------------------------- |
| modifyDocumentParam | ModifyTDODocumentParam | Taip       | Ne              | (žr.: Lentelė 2 176. „ModifyTDODocumentParam“ esybės laukų aprašymas) |

## Lentelė 189. Esybės „ModifyTDODocumentParam“ laukų sąrašas

| Pavadinimas     | Tipas                                   | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                  |
| --------------- | --------------------------------------- | ---------- | --------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| docOid          | string                                  | Taip       | Ne              | Dokumento identifikatorius                                                                                                                                                 |
| docAttributes   | Lentelė 2. Esybės „Map“ laukų aprašymas | Taip       | Ne              | Dokumento metaduomenų sąrašas. Minimalus galimų reikšmių sąrašas pateiktas žemiau esančioje lentelėje. Galimos papildomos reikšmės, jei tai sukonfigūruota DBSIS sistemoje |
| extraAttributes | Lentelė 2. Esybės „Map“ laukų aprašymas | Taip       | Ne              | Dokumento papildomų atributų reikšmių sąrašas.                                                                                                                             |

- Laukas docAttributes - tai Map tipo struktūra (aprašymą žr. skyriuje Lentelė 2. Esybės „Map“ laukų aprašymas). Šioje struktūroje pateikiami įkeliamo dokumento metaduomenys. Galimi metaduomenys pateikiami žemiau esančioje lentelėje. Priklausomai nuo DBSIS konfigūracijos, gali būti pateikiami ir kiti, lentelėje nepaminėti, metaduomenys.

## Lentelė 190. „docAttributes“ galimų laukų sąrašas

| Pavadinimas          | Tipas    | Privalomas | Pasikartojantis | Aprašymas                 |
| -------------------- | -------- | ---------- | --------------- | ------------------------- |
| description          | string   | Ne         | Ne              | Tekstas                   |
| title                | string   | Ne         | Ne              | Antraštė                  |
| controlType          | string   | Ne         | Ne              | Užduoties kontrolės tipas |
| controller           | OrgNode  | Ne         | Ne              | Kontrolierius             |
| curator              | OrgNode  | Ne         | Ne              | Kuratorius                |
| chiefExecutor        | OrgNode  | Taip       | Ne              | Atsakingas vykdytojas     |
| dueBy                | date     | Ne         | Ne              | Įvykdymo terminas         |
| priority             | ClsEntry | Ne         | Ne              | Prioritetas               |
| estimate             | integer  | Ne         | Ne              | Vertė                     |
| isEstimateCalculated | integer  | Ne         | Ne              | Ar sumuojama vertė        |

## Operacija grąžina TDODocumentInfo tipo rezultatą (žr. skyrių 2.9.1.1).

## Lentelė 191. Operacijos „modifyDocument“ rezultato aprašymas

| Pavadinimas  | Tipas           | Privalomas | Pasikartojantis | Aprašymas                                                      |
| ------------ | --------------- | ---------- | --------------- | -------------------------------------------------------------- |
| documentInfo | TDODocumentInfo | Taip       | Ne              | (žr.: Lentelė 0 166. „TDODocumentInfo“ esybės laukų aprašymas) |

## 2.9.6 Operacija „claimCompletion“

- Operacija skirta užbaigti užduoties vykdumą.
- Operacijai paduodama esybė ClaimCompletionParam. Jos struktūra pateikta žemiau esančioje lentelėje:

## Lentelė 192. Operacijos „claimCompletion“ parametro aprašymas

| Pavadinimas          | Tipas                | Privalomas | Pasikartojantis | Aprašymas                                                           |
| -------------------- | -------------------- | ---------- | --------------- | ------------------------------------------------------------------- |
| claimCompletionParam | ClaimCompletionParam | Taip       | Ne              | (žr.: Lentelė 2 180. „ClaimCompletionParam“ esybės laukų aprašymas) |

## Lentelė 193. Esybės „ClaimCompletionParam“ laukų sąrašas

| Pavadinimas    | Tipas  | Privalomas | Pasikartojantis | Aprašymas                  |
| -------------- | ------ | ---------- | --------------- | -------------------------- |
| docOid         | string | Taip       | Ne              | Dokumento identifikatorius |
| completionDate | Date   | Ne         | Ne              | Užduoties užbaigimo diena  |

- Operacija grąžina TDODocumentInfo tipo rezultatą (žr skyrių 2.9.1.1).

## Lentelė 194. Operacijos „claimCompletion“ rezultato aprašymas

| Pavadinimas  | Tipas           | Privalomas | Pasikartojantis | Aprašymas                                                      |
| ------------ | --------------- | ---------- | --------------- | -------------------------------------------------------------- |
| documentInfo | TDODocumentInfo | Taip       | Ne              | (žr.: Lentelė 0 166. „TDODocumentInfo“ esybės laukų aprašymas) |

## 2.9.7 Operacija „writeResults“

- Operacija skirta pridėti užduoties rezultatus.
- Operacijai paduodama esybė WriteResultsParam. Jos struktūra pateikta žemiau esančioje lentelėje:

## Lentelė 195. Esybės „WriteResultsParam“ laukų sąrašas

| Pavadinimas | Tipas  | Privalomas | Pasikartojantis | Aprašymas                  |
| ----------- | ------ | ---------- | --------------- | -------------------------- |
| docOid      | string | Taip       | Ne              | Dokumento identifikatorius |
| resultText  | string | Taip       | Ne              | Užduoties rezultatai       |

- Operacija grąžina TDODocumentInfo tipo rezultatą (žr skyrių 2.9.1.1).

## Lentelė 196. Operacijos „writeResults“ rezultato aprašymas

| Pavadinimas  | Tipas           | Privalomas | Pasikartojantis | Aprašymas                                                      |
| ------------ | --------------- | ---------- | --------------- | -------------------------------------------------------------- |
| documentInfo | TDODocumentInfo | Taip       | Ne              | (žr.: Lentelė 0 166. „TDODocumentInfo“ esybės laukų aprašymas) |
