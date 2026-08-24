# Sutarčių sąsaja

- Path: `/api-dok/dbsis-api/duomenu-strukturos/sutarciu-sasaja`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/duomenu-strukturos/sutarciu-sasaja
- Index: 16

---

Sutarčių sąsaja („CDODocumentWS“)

## Apibendrinimas

- Sąsaja pateikiama SOAP protokolu.
- Sąsajos pavadinimas: CDODocumentWS

### Bendrai naudojamos esybės

Šios sąsajos operacijų parametrai paveldi iš „BaseParam“ esybės (žr. Esybė „BaseParam“ – bazinė WS operacijų parametro esybė).

---

## 2.14.2 Operacija „getDocumentList“

- Operacija skirta atlikti paiešką tarp DBSIS saugomų sutarčių.
- Operacijai paduodama esybė GetDocumentListParam. Jos struktūra pateikta žemiau esančioje lentelėje:

### Lentelė 213. Esybės „GetDocumentListParam“ laukų sąrašas

| Pavadinimas            | Tipas                                   | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    |
| ---------------------- | --------------------------------------- | ---------- | --------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| searchParameters       | Lentelė 2. Esybės „Map“ laukų aprašymas | Taip       | Ne              | Sutarties paieškos parametrai (žr. Lentelė 197. Esybės „LinkedDocument“ laukų sąrašas).                                                                                                                                                                                                                                                                                                                                                                                                                      |
| expand                 | DocumentExpandType                      | Ne         | Ne              | Sąrašas atributų pavadinimų, nusakantis kurių atributų ir kokios apimties informacija pateikiama (žr. Esybė „DocumentExpandType“)                                                                                                                                                                                                                                                                                                                                                                            |
| retrieveBodyAttachment | enum                                    | Ne         | Ne              | Nurodoma, kaip pateikti sutarties rinkmenas (priklausomai nuo sistemos konfigūracijos požymio WS\_RETRIEVE\_ADOC\_AS\_BODY\_ATTACHMENT reikšmės gali būti pateikta ir elektroninio dokumento pakuotė):  - „ID“ – pateikiamas tik jų ID. - „METADATA“ – pateikiami metaduomenys be turinio. - „METADATA\_WITH\_ELECTRO“ – pateikiami metaduomenys ir papildoma informacija, jei rinkmena yra elektroninio dokumento pakuotė. - Pastaba: „CONTENT“ parametro operacijai getDocumentList nurodyti **negalima**. |
| pageSize               | int                                     | Ne         | Ne              | Puslapio (grąžinamo rezultato) dydis. Jei nenurodytas, naudojama reikšmė 30                                                                                                                                                                                                                                                                                                                                                                                                                                  |
| pageNum                | int                                     | Ne         | Ne              | Kelintą puslapį rodyti (kiekviename puslapyje bus pageSize įrašų). Numeracija pradedama nuo 0. Jei nenurodyta – naudojama reikšmė 0.                                                                                                                                                                                                                                                                                                                                                                         |
| sortParam              | string                                  | Ne         | Ne              | Pagal ką surūšiuoti rezultatus. Nurodomas atributo pavadinimas su priesaga „Asc“ arba „Desc“.                                                                                                                                                                                                                                                                                                                                                                                                                |
| maxResults             | int                                     | Ne         | Ne              | Maksimalus grąžinamų sutarčių skaičius. Jei nenurodyta – naudojama reikšmė pagal nutylėjimą (200).                                                                                                                                                                                                                                                                                                                                                                                                           |

Operacija grąžina sutarties informaciją struktūroje GetDocumentListResult:

---

## Lentelė 214. Esybės „GetDocumentListResult“ laukų sąrašas

| Pavadinimas         | Tipas             | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                   |
| ------------------- | ----------------- | ---------- | --------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------- |
| document            | GetDocumentResult | Ne         | Taip            | Vienos sutarties informaciją apjungiantis elementas (žr.: Lentelė 22. Esybės „GetDocumentResult“ laukų aprašymas)                                           |
| totalDocumentsFound | int               | Taip       | Ne              | Kiek iš viso rasta įrašų. Šis skaičius parodo, kiek buvo rasta sutarčių neatsižvelgiant į puslapio dydį, t.y. jis gali būti didesnis už parametrą pageSize. |

## 2.14.2.1 Esybės GetDocumentListParam laukas „searchParameters“

- Laukas searchParameters - tai Map tipo struktūra (aprašymą žr. skyriuje Lentelė 2. Esybės „Map“ laukų aprašymas). Šioje struktūroje pateikiami paieškos kriterijai (sutarties metaduomenys). Galimi laukai pateikiami žemiau esančioje lentelėje. Priklausomai nuo DBSIS konfigūracijos, gali būti pateikiami ir kiti, lentelėje nepaminėti, metaduomenys.
- Operacijai galima pateikti bet kokį žemiau išvardintų parametrų poaibį.

## Lentelė 215. Atributo „searchParameters“ galimų laukų sąrašas

| Pavadinimas         | Tipas             | Privalomas | Pasikartojantis | Aprašymas                                                                                            |
| ------------------- | ----------------- | ---------- | --------------- | ---------------------------------------------------------------------------------------------------- |
| status              | string            | Ne         | Ne              | Sutarties būsena                                                                                     |
| title               | string            | Ne         | Ne              | Sutarties antraštė                                                                                   |
| createdDate         | DateRangeParam    | Ne         | Ne              | Sukūrimo sistemoje datų intervalas (žr. Lentelė 25. Esybės „DateRangeParam“ laukų sąrašas).          |
| creationNo          | string            | Ne         | Ne              | Laikinas sukūrimo numeris                                                                            |
| registrationNo      | string            | Ne         | Ne              | Sutarties registracijos numeris                                                                      |
| registrationDate    | DateRangeParam    | Ne         | Ne              | Dokumento registracijos datų intervalas                                                              |
| contractNr          | string            | Ne         | Ne              | Sutarties numeris                                                                                    |
| documentNr          | string            | Ne         | Ne              | Dokumento numeris                                                                                    |
| documentDate        | date              | Ne         | Ne              | Dokumento data                                                                                       |
| isElectro           | boolean           | Ne         | Ne              | Ar ieškoma sutartis yra elektroninis dokumentas? Galimos reikšmės „true“ ir „false“.                 |
| journal             | JournalParam      | Ne         | Ne              | Sutarties registras: identifikatorius (žr. Lentelė 37. Esybės „JournalParam“ laukų sąrašas).         |
| sortText            | DocumentSortParam | Ne         | Ne              | Dokumento rūšis (Dokumento rušies oid arba title klasifikatoriaus OID). Pvz. : clsDHSSort.RDOINC.AKT |
| rubric              | ClsEntryParam     | Ne         | Ne              | Rubrikos klasifikatoriaus įrašas (žr. Lentelė 18. Esybės „ClsEntryParam“ laukų sąrašas).             |
| projectNo           | string            | Ne         | Ne              | Projekto kodas                                                                                       |
| wayOfReception      | ClsEntryParam     | Ne         | Ne              | Dokumento gavimo būdas                                                                               |
| docOfficeCases      | OfficeCaseParam   | Ne         | Ne              | Byla (žr. Lentelė 35. Esybės „OfficeCaseParam“ laukų sąrašas)                                        |
| senders             | OrgNodeListParam  | Ne         | Taip            | Dokumento siuntėjo informacija. Galima nurodyti kelis.                                               |
| intermediateSenders | OrgNodeListParam  | Ne         | Taip            | Dokumento tarpinio siuntėjo informacija. Galima nurodyti kelis.                                      |
| receivers           | OrgNodeListParam  | Ne         | Taip            | Dokumento gavėjo informacija. Galima nurodyti kelis.                                                 |
| registrator         | OrgNodeParam      | Ne         | Ne              | Sutarties registratoriaus informacija.                                                               |
| registratorExch     | OrgNodeParam      | Ne         | Ne              | Sutarties išorinio registratoriaus informacija.                                                      |
| preparedBy          | OrgNodeParam      | Ne         | Taip            | Sutarties rengėjo informacija. Galima nurodyti kelis.                                                |
| visedBy             | OrgNodeParam      | Ne         | Taip            | Sutarties derintojo informacija. Galima nurodyti kelis.                                              |
| signedBy            | OrgNodeParam      | Ne         | Taip            | Sutarties pasirašiusiojo informacija                                                                 |
| responsible         | OrgNodeParam      | Ne         | Ne              | Atsakingas asmuo                                                                                     |
| responsibleUnit     | OrgNodeParam      | Ne         | Ne              | Atsakingas padalinys                                                                                 |
| checkedOutBy        | OrgNodeParam      | Ne         | Ne              | Dokumentą išsegė                                                                                     |
| routeForTarget      | OrgNodeParam      | Ne         | Ne              | Kam perduota                                                                                         |
| contractorsNodes    | OrgNodeParam      | Ne         | Ne              | Sutarčių šalys                                                                                       |
| object              | string            | Ne         | Ne              | Sutarties objektas                                                                                   |
| plannedStartDate    | DateRangeParam    | Ne         | Ne              | Planuojama pradžios data                                                                             |
| realStartDate       | DateRangeParam    | Ne         | Ne              | Reali pradžios data                                                                                  |
| plannedEndDate      | DateRangeParam    | Ne         | Ne              | Planuojama pabaigos data                                                                             |
| realEndDate         | DateRangeParam    | Ne         | Ne              | Reali pabaigos data                                                                                  |
| warrantyEndDate     | DateRangeParam    | Ne         | Ne              | Garantijos pabaigos data                                                                             |
| searchOwnerUnit     | OrgNodeParam      | Ne         | Taip            | Bylos savininkas                                                                                     |
| docStoreUnit        | OrgNodeParam      | Ne         | Ne              | Dokumentą saugantis padalinys                                                                        |
| archCase            | string            | Ne         | Ne              | Archyvinė byla                                                                                       |
| isProject           | boolean           | Ne         | Ne              | Ar ieškoma sutartis yra projektas? Galimos reikšmės „true“ ir „false“.                               |
| isRegistered        | string            | Ne         | Ne              | Ar registruotas? Galimos reikšmės „T“ ir „F“.                                                        |

## 2.14.3 Operacija „createDocumentFromTemplate“

- Operacija skirta sutarčių įkėlimui į DBSIS. Galima įkelti tiek sutartis, tiek sutarčių projektus. Pirmu atveju į DBSIS bus įkeliama parengta sutartis, kurią bus galima registruoti. Antruoju atveju DBSIS bus sukuriamas sutarties projektas.
- Operacijai paduodama esybė CdoDocumentFromTemplateParam. Jos struktūra pateikta žemiau esančioje lentelėje.

## Lentelė 216. Esybės „CdoDocumentFromTemplateParam“ laukų sąrašas

- Paveldi viską iš „ModifyDocumentParam“ žr.: Lentelė 50. Esybės „ModifyDocumentParam“ laukų sąrašas

| Pavadinimas   | Tipas         | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                                                            |
| ------------- | ------------- | ---------- | --------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| templateParam | TemplateParam | Taip       | Ne              | Nurodomas sutarties šablonas (žr. Lentelė 16. Esybės „TemplateParam“ laukų sąrašas).                                                                                                                                                 |
| register      | boolean       | Taip       | Ne              | Požymis, ar sutartį reikia iškart registruoti. Nesuderinamas variantas project=true ir register=true – tokiu atveju gražinama klaida apie neteisingus parametrus. Jei register=true, tai privalo būti nurodytas sutarties registras. |
| project       | boolean       | Ne         | Ne              | Ar kuriamas dokumentas yra projektas? Galimos reikšmės „true“ ir „false“. Nenurodžius – pagal nutylėjimą bus „false“.                                                                                                                |

- Operacija grąžina DocumentInfo tipo rezultatą (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas)

## Lentelė 217. Operacijos „createDocumentFromTemplate“ rezultato aprašymas

| Pavadinimas                | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                               |
| -------------------------- | ------------ | ---------- | --------------- | ------------------------------------------------------- |
| createDocumentFromTemplate | DocumentInfo | Taip       | Ne              | (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas) |

## Lentelė 218. Atributo „docAttributes“ galimų laukų sąrašas

| Pavadinimas          | Tipas                  | Pasikartojantis | Aprašymas                                                                                                           |
| -------------------- | ---------------------- | --------------- | ------------------------------------------------------------------------------------------------------------------- |
| note                 | string                 | Ne              | Pastaba                                                                                                             |
| title                | string                 | Ne              | Antraštė                                                                                                            |
| contractNr           | string                 | Ne              | Sutarties numeris                                                                                                   |
| documentNr           | string                 | Ne              | Dokumento numeris                                                                                                   |
| documentDate         | dateTime               | Ne              | Dokumento data                                                                                                      |
| isElectro            | boolean                | Ne              | Elektroninis dokumentas                                                                                             |
| sort                 | DocSortParam           | Ne              | Dokumento rūšis                                                                                                     |
| nature               | ClsEntryParam          | Ne              | Dokumento svarbumo klasifikatoriaus įrašas (žr.: Lentelė 18. Esybės „ClsEntryParam“ laukų sąrašas)                  |
| rubric               | ClsEntryParam          | Ne              | Rubrikos klasifikatoriaus įrašas. (žr.: Lentelė 18. Esybės „ClsEntryParam“ laukų sąrašas)                           |
| caseForm             | ClsEntryParam          | Ne              | Bylos formos klasifikatoriaus įrašas (žr.: Lentelė 18. Esybės „ClsEntryParam“ laukų sąrašas)                        |
| wayOfReception       | ClsEntryParam          | Ne              | Gavimo būdo klasifikatoriaus įrašas (žr.: Lentelė 18. Esybės „ClsEntryParam“ laukų sąrašas)                         |
| senders              | OrgNodeListParam       | Ne              | Sutarties siuntėjo informacija. Galima nurodyti kelis.                                                              |
| intermediateSenders  | OrgNodeListParam       | Ne              | Sutarties tarpinių siuntėjų informacija. Galima nurodyti kelis.                                                     |
| receivers            | OrgNodeListParam       | Ne              | Sutarties gavėjo informacija. Galima nurodyti kelis.                                                                |
| preparedBy           | OrgNodeListParam       | Ne              | Dokumentą parengusio informacija. Galima nurodyti kelis.                                                            |
| reviewedBy           | OrgNodeListParam       | Ne              | Dokumentą peržiūrėjusio informacija. Galima nurodyti kelis.                                                         |
| visedBy              | OrgNodeListParam       | Ne              | Dokumentą derinurio informacija. Galima nurodyti kelis.                                                             |
| signedBy             | OrgNodeListParam       | Ne              | Dokumentą pasirašusio informacija. Galima nurodyti kelis.                                                           |
| confirmedBy          | OrgNodeListParam       | Ne              | Dokumentą tvirtinusio informacija. Galima nurodyti kelis.                                                           |
| coordinators         | OrgNodeListParam       | Ne              | Koordinatoriaus informacija. Galima nurodyti kelis.                                                                 |
| responsible          | OrgNodeListParam       | Ne              | Atsakingo asmens informacija                                                                                        |
| responsibleUnit      | OrgNodeListParam       | Ne              | Atsakingo padalinio informacija                                                                                     |
| contractors          | CdoContractorListParam | Ne              | Sutarties šalies informacija. Galima nurodyti kelis. Žr. Lentelė 47. Esybės „CdoContractorListParam“ laukų sąrašas. |
| object               | string                 | Ne              | Sutarties objektas                                                                                                  |
| plannedStartDate     | dateTime               | Ne              | Planuojama pradžios data                                                                                            |
| realStartDate        | dateTime               | Ne              | Reali pradžios data                                                                                                 |
| plannedEndDate       | dateTime               | Ne              | Planuojama pabaigos data                                                                                            |
| warrantyEndDate      | dateTime               | Ne              | Garantijos pabaigos data                                                                                            |
| docStoreUnit         | OrgNodeParam           | Ne              | Dokumentą saugo                                                                                                     |
| contractCost         | decimal                | Ne              | Sutarties kaina eurais su PVM                                                                                       |
| orgRole              | ClsEntryParam          | Ne              | Organizacijos statuso sutartyje klasifikatoriaus įrašas (žr.: Lentelė 18. Esybės „ClsEntryParam“ laukų sąrašas)     |
| executionNote        | ClsEntryParam          | Ne              | Vykdymo pastabų klasifikatoriaus įrašas (žr.: Lentelė 18. Esybės „ClsEntryParam“ laukų sąrašas)                     |
| useType              | ClsEntryParam          | Ne              | Naudojimo tipo klasifikatoriaus įrašas (žr.: Lentelė 18. Esybės „ClsEntryParam“ laukų sąrašas)                      |
| priority             | ClsEntryParam          | Ne              | Prioriteto klasifikatoriaus įrašas (žr.: Lentelė 18. Esybės „ClsEntryParam“ laukų sąrašas)                          |
| numberOfPagesInDoc   | int                    | Ne              | Lapų skaičius                                                                                                       |
| numberOfPagesInAtt   | int                    | Ne              | Priedų lapų sk.                                                                                                     |
| paymentAmountInitial | decimal                | Ne              | Pradinė suma                                                                                                        |

## 2.14.4 Operacija „modifyReviewalSchema“

- Analogiška RDODocumentWS operacijai „modifyReviewalSchema“. Žr. Operacija „modifyReviewalSchema“.

## 2.14.5 Operacija „modifyApprovalSchema“

- Analogiška RDODocumentWS operacijai „modifyApprovalSchema“. Žr. Operacija „modifyApprovalSchema“.

## 2.14.6 Operacija „modifySigningSchema“

- Analogiška RDODocumentWS operacijai „modifySigningSchema“. Žr. Operacija „modifySigningSchema“.

## 2.14.7 Operacija „modifyConfirmationSchema“

- Analogiška RDODocumentWS operacijai „modifySigningSchema“. Žr. Operacija „modifyConfirmationSchema“.

## 2.14.8 Operacija „modifyAcquaintees“

- Analogiška RDODocumentWS operacijai „modifyAcquaintees“. Žr. Operacija „modifyAcquaintees“.

## 2.14.9 Operacija „modifyRegisterTarget“

- Analogiška RDODocumentWS operacijai „modifyRegisterTarget“. Žr. Operacija „modifyRegisterTarget“.

## 2.14.10 Operacija „markVersionReady“

- Analogiška RDODocumentWS operacijai „markVersionReady“. Žr. Operacija „markVersionReady“.

## 2.14.11 Operacija „getContentCopyAttachmentOrEmpty“

- Analogiška RDODocumentWS operacija „getContentCopyAttachmentOrEmpty“. Žr. Operacija „getContentCopyAttachmentOrEmpty“.

## 2.14.12 Operacija „modifyDocumentInVersion“

- Operacija skirta DBSIS esačios sutarties modifikavimui nekeičiant versijos. Operacija identiška RDODocumentWS Operacija „modifyDocumentInVersion“.

## 2.14.13 Operacija „getDocumentReaders“

- Operacija skirta gauti pareigybių, kurios gali peržiūrėti dokumentą, sąrašą. Operacija identiška RDODocumentWS operacijai „getDocumentReaders“.
