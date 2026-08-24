# Registruotų dokumentų sąsaja

- Path: `/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/duomenu-strukturos/registruotu-dokumentu-sasaja
- Index: 4

---

Registruotų dokumentų sąsaja („RDODocumentWS“)

## Apibendrinimas

- Sąsaja pateikiama SOAP protokolu.
- Sąsajos pavadinimas: RDODocumentWS

### Bendrai naudojamos esybės

Šios sąsajos operacijų parametrai paveldi iš „BaseParam“ esybės (žr. Esybė „BaseParam“ – bazinė WS operacijų parametro esybė).

---

## 1. „ModifyDocumentParam“

- Namespace: <http://www.sintagma.lt/avilys/DocumentWS>
- Pavadinimas: ModifyDocumentParam
- Ši esybė skirta perduoti į DBSIS informaciją. Esybė nenaudojama duomenų pateikimui iš DBSIS.

### 2. „ModifyDocumentParam“ laukų sąrašas

| Pavadinimas     | Tipas                                   | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                  |
| --------------- | --------------------------------------- | ---------- | --------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| docOid          | string                                  | Taip       | Ne              | Dokumento identifikatorius                                                                                                                                                 |
| docAttributes   | Lentelė 2. Esybės „Map“ laukų aprašymas | Taip       | Ne              | Dokumento metaduomenų sąrašas. Minimalus galimų reikšmių sąrašas pateiktas žemiau esančioje lentelėje. Galimos papildomos reikšmės, jei tai sukonfigūruota DBSIS sistemoje |
| extraAttributes | Lentelė 2. Esybės „Map“ laukų aprašymas | Taip       | Ne              | Dokumento papildomų atributų reikšmių sąrašas.                                                                                                                             |
| bodyAttachment  | AttachmentActionParam                   | Ne         | Taip            | Dokumento arba jo priedo rinkmena. Galima nurodyti kelias. (žr.: Lentelė 15. Esybės „AttachmentActionParam“ laukų sąrašas)                                                 |

Laukas docAttributes - tai Map tipo struktūra (aprašymą žr. Lentelė 2. Esybės „Map“ laukų aprašymas). Šioje struktūroje pateikiami įkeliamo dokumento metaduomenys. Galimi metaduomenys pateikiami žemiau esančioje lentelėje. Priklausomai nuo DBSIS konfigūracijos, gali būti pateikiami ir kiti, lentelėje nepaminėti, metaduomenys.

---

## 3. „docAttributes“ galimų laukų sąrašas

| Pavadinimas         | Tipas            | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      |
| ------------------- | ---------------- | ---------- | --------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| isElectro           | boolean          | Ne         | Ne              | Ar kuriamas elektroninis dokumentas? Galimos reikšmės „true“ ir „false“. Nenurodžius – pagal nutylėjimą bus „false“. Funkcija leidžia sukurti tik siunčiamojo, vidaus ar sutarties el. dokumento projektą, t.y., turi būti nurodytas parametras project=true. Parametruose taip pat turi būti nurodyta bent viena turinio rinkmena – pagrindinio dokumento rinkmena, atitinkanti ADOC specifikacijos reikalavimus (dar gali būtų priedų ir pridedamų el. dokumentų). Gautiems el. dokumentams kurti naudotina funkcija createDocumentFromAdoc. |
| title               | string           | Taip       | Ne              | Dokumento antraštė                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             |
| draftJournal        | JournalParam     | Ne         | Ne              | Dokumento registras: identifikatorius. (žr.: Lentelė 37. Esybės „JournalParam“ laukų sąrašas)                                                                                                                                                                                                                                                                                                                                                                                                                                                  |
| draftOfficeCase     | OfficeCaseParam  | Ne         | Ne              | Dokumento byla. (žr.: Lentelė 35. Esybės „OfficeCaseParam“ laukų sąrašas)                                                                                                                                                                                                                                                                                                                                                                                                                                                                      |
| dueBy               | dateTime         | Ne         | Ne              | Dokumento įvykdymo terminas. Data.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             |
| rubricId            | ClsEntryParam    | Ne         | Ne              | Dokumento rubrikos klasifikatoriaus įrašas. (žr.: Lentelė 18. Esybės „ClsEntryParam“ laukų sąrašas)                                                                                                                                                                                                                                                                                                                                                                                                                                            |
| wayOfReception      | ClsEntryParam    | Ne         | Ne              | Dokumento gavimo būdas. Klasifikatorius. (žr.: Lentelė 18. Esybės „ClsEntryParam“ laukų sąrašas)                                                                                                                                                                                                                                                                                                                                                                                                                                               |
| numberOfPagesIntAtt | int              | Ne         | Ne              | Lapų skaičius prieduose                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        |
| numberOfPagesInDoc  | int              | Ne         | Ne              | Lapų skaičius dokumente                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        |
| note                | string           | Ne         | Ne              | Komentaras dokumente                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           |
| privacyCode         | ClsEntryParam    | Ne         | Ne              | Viešumo lygis. Klasifikatorius. (žr.: Lentelė 18. Esybės „ClsEntryParam“ laukų sąrašas)                                                                                                                                                                                                                                                                                                                                                                                                                                                        |
| description         | string           | Ne         | Ne              | Dokumento aprašymas                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            |
| documentDate        | dateTime         | Ne         | Ne              | Gauto dokumento data (dokumentą išsiuntusios organizacijos registravimo data)                                                                                                                                                                                                                                                                                                                                                                                                                                                                  |
| documentNr          | string           | Ne         | Ne              | Gauto dokumento numeris (dokumentą išsiuntusios organizacijos registravimo numeris)                                                                                                                                                                                                                                                                                                                                                                                                                                                            |
| senders             | OrgNodeListParam | Ne         | Taip            | Dokumento siuntėjo informacija. Galima nurodyti kelis.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         |
| receivers           | OrgNodeListParam | Ne         | Taip            | Dokumento gavėjo informacija. Galima nurodyti kelis.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           |
| intermediateSenders | OrgNodeListParam | Ne         | Taip            | Dokumento tarpinio siuntėjo informacija. Galima nurodyti kelis.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                |
| docStoreUnit        | OrgNodeParam     | Ne         | Ne              | Dokumentą saugantis padalinys.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 |

---

## 4. „ModifyDocumentInVersionParam“

- Namespace: <http://www.sintagma.lt/avilys/DocumentWS>
- Pavadinimas: ModifyDocumentInVersionParam
- Ši esybė skirta perduoti į DBSIS informaciją. Esybė nenaudojama duomenų pateikimui iš DBSIS.

| Pavadinimas     | Tipas                                   | Privalomas | Pasikartojantis | Aprašymas                                                                                                                              |
| --------------- | --------------------------------------- | ---------- | --------------- | -------------------------------------------------------------------------------------------------------------------------------------- |
| docOid          | string                                  | Taip       | Ne              | Dokumento identifikatorius                                                                                                             |
| docAttributes   | Lentelė 2. Esybės „Map“ laukų aprašymas | Taip       | Ne              | Dokumento metaduomenų sąrašas. Minimalus galimų reikšmių sąrašas pateiktas Lentelė 51. „docAttributes“ galimų laukų sąrašas lentelėje. |
| extraAttributes | Lentelė 2. Esybės „Map“ laukų aprašymas | Taip       | Ne              | Dokumento papildomų atributų reikšmių sąrašas.                                                                                         |

Laukas docAttributes - tai Map tipo struktūra (aprašymą žr. Lentelė 2. Esybės „Map“ laukų aprašymas). Šioje struktūroje pateikiami įkeliamo dokumento metaduomenys. Galimi metaduomenys pateikiami Lentelė 51. „docAttributes“ galimų laukų sąrašas lentelėje. Priklausomai nuo DBSIS konfigūracijos, gali būti pateikiami ir kiti, lentelėje nepaminėti, metaduomenys.

---

## 5. „ADocAttachment“

- Namespace: <http://www.sintagma.lt/avilys/DocumentWS>
- Pavadinimas: ADocAttachment

### 6. „ADocAttachment“ laukų sąrašas

Paveldi viską iš „AttachmentActionParam“ žr.: Lentelė 15. Esybės „AttachmentActionParam“ laukų sąrašas. Nurodyti esybės laukai užpildomi taip:

| Pavadinimas | Aprašymas                                                                                         |
| ----------- | ------------------------------------------------------------------------------------------------- |
| type        | Nurodoma reikšmė: clsDHSAttaType.ADOC                                                             |
| type        | Rinkmenos pavadinimas turi baigtis plėtiniu „.adoc“. Leidžiama ne ilgesnė nei 80 simbolių reikšmė |
| type        | Nurodoma reikšmė: application/vnd.lt.archyvai.adoc-2008                                           |

---

## 7. „EDocumentAttachment“

- Namespace: <http://www.sintagma.lt/avilys/DocumentWS>
- Pavadinimas: EDocumentAttachment

### 8. „EDocumentAttachment“ laukų sąrašas

Paveldi viską iš „AttachmentActionParam“ žr.: Lentelė 15. Esybės „AttachmentActionParam“ laukų sąrašas. Nurodyti esybės laukai užpildomi taip:

| Pavadinimas     | Aprašymas                                                                                                                  |
| --------------- | -------------------------------------------------------------------------------------------------------------------------- |
| title           | Rinkmenos pavadinimas turi baigtis plėtiniu „.adoc“, „asice“ arba „pdf“. Leidžiama ne ilgesnė nei 80 simbolių reikšmė      |
| contentType     | Nurodoma reikšmė: application/vnd.lt.archyvai.adoc-2008, application/vnd.etsi.asic-e+zip arba application/pdf atitinkamai. |
| eDocumentFormat | Nurodoma reikšmė: ADOC\_1\_0, ADOC\_2\_0, PDF\_LT, PDF\_RC, PDF\_PADES arba ASIC\_E atitinkamai                            |

---

## 9. „GetDocumentResult“

- Namespace: <http://www.sintagma.lt/avilys/DocumentWS>
- Pavadinimas: GetDocumentResult

### 10. „GetDocumentResult“ laukų sąrašas

| Pavadinimas    | Tipas                                   | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                                                           |
| -------------- | --------------------------------------- | ---------- | --------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| docOid         | string                                  | Taip       | Ne              | Unikalus dokumentus identifikatorius                                                                                                                                                                                                |
| version        | DocumentVersionType                     | Ne         | Ne              | Versijos informacija (žr.: Lentelė 23. Esybės „DocumentVersionType“ laukų aprašymas)                                                                                                                                                |
| docAttributes  | Lentelė 2. Esybės „Map“ laukų aprašymas | Taip       | Ne              | Dokumento metaduomenų sąrašas. Minimalus galimų reikšmių sąrašas pateiktas žemiau esančioje lentelėje. Galimos papildomos reikšmės, jei tai sukonfigūruota DBSIS sistemoje (žr.: Lentelė 51. „docAttributes“ galimų laukų sąrašas). |
| bodyAttachment | string                                  | Ne         | Taip            | Dokumento arba jo priedo rinkmena. Galima nurodyti kelias.  Konkretus tipas priklauso nuo parametro ‚retrieveAttachment ‘ reikšmės (žr.: Lentelė 29. Esybės „AttachmentBase“ laukų sąrašas).                                        |

- Laukas docAttributes – tai Map tipo struktūra (aprašymą žr. skyriuje Lentelė 2. Esybės „Map“ laukų aprašymas). Šioje struktūroje pateikiami dokumento metaduomenys. Galimi metaduomenys pateikiami žemiau esančioje lentelėje. Priklausomai nuo DBSIS konfigūracijos, gali būti pateikiami ir kiti, lentelėje nepaminėti, metaduomenys.

**Pastaba**: Grąžinamų laukų reikšmės gali priklausyti nuo to, ar šių laukų pavadinimai nurodyti „expand“ parametre (žr. Esybė „DocumentExpandType“).

---

## 11. „docAttributes“ galimų laukų sąrašas

| Pavadinimas               | Tipas            | Pasikartojantis | Aprašymas                                                                                                                                                                                                                                                                                                                                                                                                                  |
| ------------------------- | ---------------- | --------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| status                    | string           | Ne              | Sutarties būsena                                                                                                                                                                                                                                                                                                                                                                                                           |
| statuses                  | string           | Ne              | Dokumento būsena (kelios parinktys)                                                                                                                                                                                                                                                                                                                                                                                        |
| title                     | string           | Ne              | Antraštė                                                                                                                                                                                                                                                                                                                                                                                                                   |
| altTitle                  | string           | Ne              | Alternatyvi antraštė                                                                                                                                                                                                                                                                                                                                                                                                       |
| description               | string           | Ne              | Tekstas                                                                                                                                                                                                                                                                                                                                                                                                                    |
| note                      | string           | Ne              | Pastaba                                                                                                                                                                                                                                                                                                                                                                                                                    |
| createDate                | dateTime         | Ne              | Dokumento sukūrimo data                                                                                                                                                                                                                                                                                                                                                                                                    |
| creatioNo                 | string           | Ne              | Laikinas nr.                                                                                                                                                                                                                                                                                                                                                                                                               |
| createdUnit               | OrgNode          | Ne              | Padalinys                                                                                                                                                                                                                                                                                                                                                                                                                  |
| registrationNo            | string           | Ne              | Registracijos numeris                                                                                                                                                                                                                                                                                                                                                                                                      |
| registrationDate          | string           | Ne              | Registracijos data                                                                                                                                                                                                                                                                                                                                                                                                         |
| documentNr                | string           | Ne              | Dokumento numeris                                                                                                                                                                                                                                                                                                                                                                                                          |
| documentDate              | dateTime         | Ne              | Dokumento data                                                                                                                                                                                                                                                                                                                                                                                                             |
| isElectro                 | string           | Ne              | Elektroninis dokumentas                                                                                                                                                                                                                                                                                                                                                                                                    |
| controlType               | ClsEntry         | Ne              | Dokumento kontrolės tipas                                                                                                                                                                                                                                                                                                                                                                                                  |
| docText                   | string           | Ne              | Dokumento turinys                                                                                                                                                                                                                                                                                                                                                                                                          |
| journal                   | Journal          | Ne              | Dokumento registras                                                                                                                                                                                                                                                                                                                                                                                                        |
| draftJournal              | Journal          | Ne              | Numatomas registras                                                                                                                                                                                                                                                                                                                                                                                                        |
| sort                      | DocumentSortBean | Ne              | Dokumento rūšis                                                                                                                                                                                                                                                                                                                                                                                                            |
| sorts                     | DocumentSortBean | Taip            | Dokumento rūšys                                                                                                                                                                                                                                                                                                                                                                                                            |
| altSorts                  | DocumentSortBean | Taip            | Papildomos rūšys                                                                                                                                                                                                                                                                                                                                                                                                           |
| sendEmail                 | boolean          | Ne              | Informuoti el. paštu                                                                                                                                                                                                                                                                                                                                                                                                       |
| sendSMS                   | boolean          | Ne              | Informuoti SMS žinute                                                                                                                                                                                                                                                                                                                                                                                                      |
| rubric                    | ClsEntry         | Ne              | Dokumento rubrika                                                                                                                                                                                                                                                                                                                                                                                                          |
| numberOfPagesInDoc        | int              | Ne              | Lapų skaičius                                                                                                                                                                                                                                                                                                                                                                                                              |
| numberOfPagesInAtt        | int              | Ne              | Priedų lapų sk.                                                                                                                                                                                                                                                                                                                                                                                                            |
| projectNo                 | string           | Ne              | Projekto kodas                                                                                                                                                                                                                                                                                                                                                                                                             |
| privacyCode               | ClsEntry         | Ne              | Slaptumo žyma                                                                                                                                                                                                                                                                                                                                                                                                              |
| wayOfReception            | OfficeCase       | Ne              | Byla                                                                                                                                                                                                                                                                                                                                                                                                                       |
| docOfficeCases            | OfficeCase       | Ne              | Nustatoma byla                                                                                                                                                                                                                                                                                                                                                                                                             |
| draftOfficeCase           | OfficeCase       | Taip            | Byla                                                                                                                                                                                                                                                                                                                                                                                                                       |
| senders                   | OrgNode          | Ne              | Siuntėjai                                                                                                                                                                                                                                                                                                                                                                                                                  |
| intermediateSenders       | OrgNode          | Taip            | Tarpiniai siuntėjai                                                                                                                                                                                                                                                                                                                                                                                                        |
| curator                   | OrgNode          | Ne              | Kuratorius                                                                                                                                                                                                                                                                                                                                                                                                                 |
| receivers                 | OrgNode          | Taip            | Gavėjai                                                                                                                                                                                                                                                                                                                                                                                                                    |
| registrator               | OrgNode          | Ne              | Registratorius                                                                                                                                                                                                                                                                                                                                                                                                             |
| registratorExch           | OrgNode          | Ne              | Išorinis registratorius                                                                                                                                                                                                                                                                                                                                                                                                    |
| preparedBy                | OrgNode          | Taip            | Dokumentą parengė                                                                                                                                                                                                                                                                                                                                                                                                          |
| dueBy                     | date             | Ne              | Įvykdymo terminas                                                                                                                                                                                                                                                                                                                                                                                                          |
| checkedOutBy              | OrgNode          | Ne              | Dokumentą išdavė                                                                                                                                                                                                                                                                                                                                                                                                           |
| routeForTarget            | OrgNode          | Taip            | Kam perduota                                                                                                                                                                                                                                                                                                                                                                                                               |
| executors                 | OrgNode          | Taip            | Vykdytojai                                                                                                                                                                                                                                                                                                                                                                                                                 |
| searchOwnerUnit           | OrgNode          | Ne              | Bylos savininkas                                                                                                                                                                                                                                                                                                                                                                                                           |
| projectProcess            | string           | Ne              | Projekto darbo eigos proceso indentifikatorius                                                                                                                                                                                                                                                                                                                                                                             |
| priority                  | ClsEntry         | Ne              | Prioritetas                                                                                                                                                                                                                                                                                                                                                                                                                |
| projectRegistrationNo     | string           | Ne              | Projekto registracijos numeris                                                                                                                                                                                                                                                                                                                                                                                             |
| finalPreparedDate         | dateTime         | Ne              | Parengimo data                                                                                                                                                                                                                                                                                                                                                                                                             |
| reviewedBy                | OrgNode          | Taip            | Dokumentą peržiūrėjo                                                                                                                                                                                                                                                                                                                                                                                                       |
| visedBy                   | OrgNode          | Taip            | Dokumentą derino                                                                                                                                                                                                                                                                                                                                                                                                           |
| signedBy                  | OrgNode          | Taip            | Dokumentą pasirašė                                                                                                                                                                                                                                                                                                                                                                                                         |
| confirmedBy               | OrgNode          | Taip            | Dokumentą tvirtino                                                                                                                                                                                                                                                                                                                                                                                                         |
| coordinators              | OrgNode          | Taip            | Koordinatorius                                                                                                                                                                                                                                                                                                                                                                                                             |
| isLegalAct                | boolean          | Ne              | Teisės aktas                                                                                                                                                                                                                                                                                                                                                                                                               |
| passedUnit                | OrgNode          | Ne              | Teisės aktą priėmusi įstaiga                                                                                                                                                                                                                                                                                                                                                                                               |
| legalActValidForm         | date             | Ne              | Teisės aktas galioja nuo                                                                                                                                                                                                                                                                                                                                                                                                   |
| legalActValidUntil        | date             | Ne              | Teisės aktas galioja iki                                                                                                                                                                                                                                                                                                                                                                                                   |
| legalActValidityDate      | date             | Ne              | Teisės akto galiojimo data                                                                                                                                                                                                                                                                                                                                                                                                 |
| legalActValidToday        | date             | Ne              | Teisės akto galiojimas                                                                                                                                                                                                                                                                                                                                                                                                     |
| legalActPublication       | ClsEntry         | Ne              | Leidinys                                                                                                                                                                                                                                                                                                                                                                                                                   |
| legalPublicationDate      | date             | Ne              | Leidinio data                                                                                                                                                                                                                                                                                                                                                                                                              |
| legalActPublicationNo     | int              | Ne              | Leidinio Nr.                                                                                                                                                                                                                                                                                                                                                                                                               |
| legalActPublicationNo     | string           | Ne              | Dokumento Nr. leidinyje                                                                                                                                                                                                                                                                                                                                                                                                    |
| actualEditionValidityDate | date             | Ne              | Aktualios redakcijos galiojimo data                                                                                                                                                                                                                                                                                                                                                                                        |
| documentProcess           | string           | Ne              | Dokumento darbo eigos proceso indentifikatorius                                                                                                                                                                                                                                                                                                                                                                            |
| sendingTypeForDisplay     | string           | Ne              | Gavėjas (pristatymo būdas). Grąžinama informacija priklauso nuo parametro WS\_SENDING\_TYPE\_FOR\_DISPLAY\_COMPATIBILITY nustatytos reikšmės: jeigu nurodytas „true“ – reikšmė grąžinama string tipo html lentelės pagrindu naudojang sendingTypes reikšmes. Jei sendingTypes nėra užpildytas, bet užpildytas sendingTypeForDisplay – grąžinama ši reikšmė, jeigu parametras „false“ – sendingTypeForDisplay lauko reikšmė |
| docStoreUnit              | OrgNode          | Ne              | Dokumentą saugantis padalinys                                                                                                                                                                                                                                                                                                                                                                                              |
| sendingTypes              | SendingType      | Ne              | Gavėjas (pristatymo būdas)                                                                                                                                                                                                                                                                                                                                                                                                 |
| originalOwner             | OrgNode          | Ne              | Orginalo turėtojas                                                                                                                                                                                                                                                                                                                                                                                                         |
| originalOwnerExch         | OrgNode          | Ne              | Kam perduotas orginalas                                                                                                                                                                                                                                                                                                                                                                                                    |
| isMarkedByOriginalOwner   | boolean          | Ne              | Patvirtintas orginalo turėtojo                                                                                                                                                                                                                                                                                                                                                                                             |

---

## 12. „createDocumentFromTemplate“

- Operacija skirta dokumento įkėlimui į DBSIS. Galima įkelti tiek gautus dokumentus, tiek ir vidaus ar siunčiamų dokumentų projektus. Pirmu atveju į DBSIS bus įkeliamas parengtas ir pasirašytas dokumentas, kurį bus galima registruoti. Antruoju atveju DBSIS bus sukuriamas dokumento projektas, iš kurio parengiamas siunčiamas ar vidaus dokumentas.

Operacijai paduodama esybė DocumentFromTemplateParam. Jos struktūra pateikta žemiau esančioje lentelėje:

### 13. „DocumentFromTemplateParam“ laukų sąrašas

Paveldi viską iš „ModifyDocumentParam“ žr.: Lentelė 50. Esybės „ModifyDocumentParam“ laukų sąrašas

| Pavadinimas         | Tipas         | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                                                                                |
| ------------------- | ------------- | ---------- | --------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| templateParam       | TemplateParam | Taip       | Ne              | Nurodomas dokumento šablonas (žr. Lentelė 16. Esybės „TemplateParam“ laukų sąrašas).                                                                                                                                                                     |
| register            | boolean       | Ne         | Ne              | Požymis ar dokumentą reikia iškart registruoti. Nesuderinamas variantas project=true ir register=true – tokiu atveju gražinama klaida apie neteisingus parametrus. Jei register=true, tai privalo būti nurodytas dokumento registras.                    |
| project             | boolean       | Ne         | Ne              | Ar kuriamas dokumentas yra projektas? Galimos reikšmės „true“ ir „false“. Nenurodžius – pagal nutylėjimą bus „false“.  Gauti dokumentai negali būti projektai, todėl jei šablonas bus pasirinktas gauto dokumento – į šį požymį bus nekreipiama dėmesio. |
| linkRdoIncDocOid    | string        | Ne         | Ne              | Dokumento OID, kuriam kuriamas dokumentas – atsakymas (ši f-ja sukurs dokumentą, kuris bus atsakymas į dokumentą, kurio OID nurodytas).                                                                                                                  |
| linkTdoResultDocOid | string        | Ne         | Ne              | Kuriamas dokumentas užpildomas duomenimis kaip nurodytos užduoties linkTdoResultDocOid rezultatas.                                                                                                                                                       |

Operacija grąžina DocumentInfo tipo rezultatą (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas).

### 14. „createDocumentFromTemplate“ rezultato aprašymas

| Pavadinimas                | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                               |
| -------------------------- | ------------ | ---------- | --------------- | ------------------------------------------------------- |
| createDocumentFromTemplate | DocumentInfo | Taip       | Ne              | (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas) |

---

## 15. Sukurto dokumento tipas

- Žemiau pateiktoje lentelėje nurodytos galimos parametrų project ir isElectro reikšmės ir kokioms reikšmėms esant kokio tipo dokumentas bus sukurtas DBSIS:

### 16. Kuriamų dokumentų tipų sąrašas

| Pavadinimas                | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                               |
| -------------------------- | ------------ | ---------- | --------------- | ------------------------------------------------------- |
| createDocumentFromTemplate | DocumentInfo | Taip       | Ne              | (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas) |

|                            | Project atributo reikškmė                        |                                                      |     |
| -------------------------- | ------------------------------------------------ | ---------------------------------------------------- | --- |
| IsElectro atributo reikšmė | false                                            | true                                                 |     |
| false                      | Paprastas (ne ADOC) gautas dokumentas            | Paprasto siunčiamo ar vidaus dokumento projektas     |     |
| true                       | Klaida. Naudoti operaciją createDocumentFromAdoc | Elektroninio siunčiamo ar vidaus dokumento projektas |     |

---

## 17. „createDocumentFromAdoc“

Operacija skirta gauto, siunčiamo, vidaus arba sutarties elektroninio dokumento arba elektroninio dokumento projekto ADOC formatu įkėlimui (ir pasirinktinai užregistravimui arba išorinio pasirašymo pažymėjimui). DBSIS dokumento metaduomenis nuskaito iš ADOC formato rinkmenos ir užpildo automatiškai. Operacijai reikia pateikti tik tuos duomenis, kurių ADOC formato metaduomenyse nėra.

**Pastaba:** Vietoj šios operacijos (kuri lieka dėl suderinamumo) rekomenduojama naudoti operaciją „createDocumentFromEDocument“

### 18. „createDocumentFromADOC“ rezultato aprašymas

| Pavadinimas         | Tipas                                   | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                                                                    |
| ------------------- | --------------------------------------- | ---------- | --------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| templateParam       | TemplateParam                           | Taip       | Ne              | Nurodomas dokumento šablonas (žr. Lentelė 16. Esybės „TemplateParam“ laukų sąrašas).                                                                                                                                                         |
| register            | boolean                                 | Taip       | Ne              | Požymis ar dokumentą reikia iškart registruoti. Nesuderinamas variantas project=true ir register=true – tokiu atveju gražinama klaida apie neteisingus parametrus. Jei register=true, tai privalo būti nurodytas dokumento registras.        |
| adocFile            | ADocAttachment                          | Taip       | Ne              | Elektroninio dokumento rinkmena ir jos metaduomenys (žr.: Lentelė 53. Esybės „ADocAttachment“ laukų sąrašas).                                                                                                                                |
| docAttributes       | Lentelė 2. Esybės „Map“ laukų aprašymas |            |                 | Dokumento metaduomenų sąrašas. Minimalus galimų reikšmių sąrašas pateiktas žemiau esančioje lentelėje. Galimos papildomos reikšmės, jei tai sukonfigūruota DBSIS sistemoje                                                                   |
| extraAttributes     | Lentelė 2. Esybės „Map“ laukų aprašymas |            |                 | Dokumento papildomų atributų reikšmių sąrašas.                                                                                                                                                                                               |
| project             | boolean                                 | Ne         | Ne              | Ar kuriamas dokumentas yra projektas? Galimos reikšmės „true“ ir „false“. Nenurodžius – pagal nutylėjimą bus „false“. Gauti dokumentai negali būti projektai, todėl jei šablonas bus pasirinktas gauto dokumento – bus pranešta apie klaidą. |
| externalSigningInfo | ExternalActionInfo                      | Ne         | Ne              | Informacija apie išorinius parašus.   Jei ši struktūra nurodoma, operacija atliks išorinio pasirašymo pažymėjimo veiksmą su sukurtu dokumentu.  (žr.: 2.1.36 Esybė „ExternalActionInfo“ – informacija apie išorinius )                       |

Laukas docAttributes - tai Map tipo struktūra (aprašymą žr. skyriuje Lentelė 2. Esybės „Map“ laukų aprašymas). Šioje struktūroje pateikiami įkeliamo dokumento metaduomenys. Galimi metaduomenys pateikiami žemiau esančioje lentelėje. Priklausomai nuo DBSIS konfigūracijos, gali būti pateikiami ir kiti, lentelėje nepaminėti, metaduomenys.

## 19. Lauko „docAttributes“ galimų laukų sąrašas

| Pavadinimas     | Tipas           | Privalomas | Pasikartojantis | Aprašymas                                                                                     |
| --------------- | --------------- | ---------- | --------------- | --------------------------------------------------------------------------------------------- |
| draftJournal    | JournalParam    | Ne         | Ne              | Dokumento registras: identifikatorius. (žr.: Lentelė 37. Esybės „JournalParam“ laukų sąrašas) |
| draftOfficeCase | OfficeCaseParam | Ne         | Ne              | Dokumento byla. (žr.: Lentelė 35. Esybės „OfficeCaseParam“ laukų sąrašas)                     |

Operacija grąžina DocumentInfo tipo rezultatą (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas).

## 20. „createDocumentFromAdoc“ rezultato aprašymas

| Pavadinimas            | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                               |
| ---------------------- | ------------ | ---------- | --------------- | ------------------------------------------------------- |
| createDocumentFromAdoc | DocumentInfo | Taip       | Ne              | (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas) |

## 21. Sukurto dokumento tipas

Žemiau esančioje lentelėje pavaizduota, kokiam kuriamam dokumento tipui (šablono tipui) kokie parametrai ir kokios reikšmės gali būti pateikiamos. Vienu metu register ir project reikšmės „true“ nurodyti negalima.

## 22. Kuriamų dokumentų tipų ir galimų parametrų atitikimas

Kuriamo dokumento tipo ir galimų parametrų atitikimas

| Dokumento tipas | „register=true“ | „project=true“ |
| --------------- | --------------- | -------------- |
| Gautas          | +               | -              |
| Vidaus          | +               | \*/ESI         |
| Siunčiamas      | +               | \*/ESI         |
| Sutartis        | -               | \*/ESI         |

Žymėjimas:

- `„+“` – reiškia, kad parametro reikšmė yra galima;
- `„*“` – reiškia, kad tik stulpelio antraštėje apibrėžta parametro reikšmė yra galima;
- `„-“` – reiškia, kad parametro reikšmė negalima;
- `„ESI“` – reiškia, kad galima atlikti išorinio pasirašymo veiksmą (nurodyti „externalSigningInfo“ parametrą). Veiksmą galima atlikti tik kai project parametro reikšmė yra true;

## 23. Operacija „createDocumentFromEDocument“

Operacija skirta gauto, siunčiamo, vidaus arba sutarties elektroninio dokumento arba elektroninio dokumento projekto ADOC (1.0) arba PDF-LT formatu įkėlimui (ir pasirinktinai užregistravimui arba išorinio pasirašymo pažymėjimui). DBSIS dokumento metaduomenis nuskaito iš el. dokumento pakuotės rinkmenos ir užpildo automatiškai. Operacijai reikia pateikti tik tuos duomenis, kurių el. dokumento pakuotės metaduomenyse nėra.

---

### 24. „createDocumentFromEDocument“ parametrų aprašymas

| Pavadinimas         | Tipas                                   | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                                                                     |
| ------------------- | --------------------------------------- | ---------- | --------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| templateParam       | TemplateParam                           | Taip       | Ne              | Nurodomas dokumento šablonas.  Žr. Lentelė 16. Esybės „TemplateParam“ laukų sąrašas                                                                                                                                                           |
| Register            | boolean                                 | Taip       | Ne              | Požymis ar dokumentą reikia iškart registruoti. Nesuderinamas variantas project=true ir register=true – tokiu atveju gražinama klaida apie neteisingus parametrus. Jei register=true, tai privalo būti nurodytas dokumento registras.         |
| adocFile            | EDocumentAttachment                     | Taip       | Ne              | Elektroninio dokumento rinkmena ir jos metaduomenys (žr.: 2.2.1.4 Esybė „EDocumentAttachment“).                                                                                                                                               |
| docAttributes       | Lentelė 2. Esybės „Map“ laukų aprašymas |            | Ne              | Dokumento metaduomenų sąrašas. Minimalus galimų reikšmių sąrašas pateiktas žemiau esančioje lentelėje. Galimos papildomos reikšmės, jei tai sukonfigūruota DBSIS sistemoje                                                                    |
| extraAttributes     | Lentelė 2. Esybės „Map“ laukų aprašymas |            | Ne              | Dokumento papildomų atributų reikšmių sąrašas.                                                                                                                                                                                                |
| project             | boolean                                 | Ne         | Ne              | Ar kuriamas dokumentas yra projektas? Galimos reikšmės „true“ ir „false“. Nenurodžius – pagal nutylėjimą bus „false“.  Gauti dokumentai negali būti projektai, todėl jei šablonas bus pasirinktas gauto dokumento – bus pranešta apie klaidą. |
| externalSigningInfo | ExternalActionInfo                      | Ne         | Ne              | Informacija apie išorinius parašus.  Jei ši struktūra nurodoma, operacija atliks išorinio pasirašymo pažymėjimo veiksmą su sukurtu dokumentu. (žr.: 2.1.36 Esybė „ExternalActionInfo“ – informacija apie išorinius )                          |

- Laukas docAttributes - tai Map tipo struktūra (aprašymą žr. skyriuje Lentelė 2. Esybės „Map“ laukų aprašymas). Šioje struktūroje pateikiami įkeliamo dokumento metaduomenys. Galimi metaduomenys pateikiami žemiau esančioje lentelėje. Priklausomai nuo DBSIS konfigūracijos, gali būti pateikiami ir kiti, lentelėje nepaminėti, metaduomenys.

---

### 25. „docAttributes“ galimų laukų sąrašas

| Pavadinimas     | Tipas           | Privalomas | Pasikartojantis | Aprašymas                                                                                     |
| --------------- | --------------- | ---------- | --------------- | --------------------------------------------------------------------------------------------- |
| draftJournal    | JournalParam    | Ne         | Ne              | Dokumento registras: identifikatorius. (žr.: Lentelė 37. Esybės „JournalParam“ laukų sąrašas) |
| draftOfficeCase | OfficeCaseParam | Ne         | Ne              | Dokumento byla. (žr.: Lentelė 35. Esybės „OfficeCaseParam“ laukų sąrašas)                     |

- Operacija grąžina DocumentInfo tipo rezultatą (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas).

---

### 26. Operacijos „createDocumentFromEDocument“ rezultato aprašymas

| Pavadinimas                 | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                               |
| --------------------------- | ------------ | ---------- | --------------- | ------------------------------------------------------- |
| createDocumentFromEDocument | DocumentInfo | Taip       | Ne              | (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas) |

## 27. Sukurto dokumento tipas

- Žemiau esančioje lentelėje pavaizduota, kokiam kuriamam dokumento tipui (šablono tipui) kokie parametrai ir kokios reikšmės gali būti pateikiamos. Vienu metu register ir project reikšmės „true“ nurodyti negalima.

## 28. Kuriamų dokumentų tipų ir galimų parametrų atitikimas

| Dokumento tipas | „register=true“ | „project=true“ |
| --------------- | --------------- | -------------- |
| Gautas          | +               | -              |
| Vidaus          | +               | \*/ESI         |
| Siunčiamas      | +               | \*/ESI         |
| Sutartis        | -               | \*/ESI         |

Žymėjimas:

- `„+“` – reiškia, kad parametro reikšmė yra galima;
- `„*“` – reiškia, kad tik stulpelio antraštėje apibrėžta parametro reikšmė yra galima;
- `„-“` – reiškia, kad parametro reikšmė negalima;
- `„ESI“` – reiškia, kad galima atlikti išorinio pasirašymo veiksmą (nurodyti „externalSigningInfo“ parametrą). Veiksmą galima atlikti tik kai project parametro reikšmė yra true;

---

### 29. Operacija „modifyDocument“

- Operacija skirta DBSIS esamo dokumento modifikavimui. Modifikavimo veiksmas galimas tik tais atvejais, kai dokumento būsena leidžia tai atlikti. Taip pat kai kurių čia išvardintų atributų negalima modifikuoti esant kai kurios dokumento būsenoms.
- Operacijai paduodama esybė ModifyDocumentParam.

## 30. Operacijos „modifyDocument“ parametrai aprašymas

| Pavadinimas         | Tipas               | Privalomas | Pasikartojantis | Aprašymas                                                     |
| ------------------- | ------------------- | ---------- | --------------- | ------------------------------------------------------------- |
| modifyDocumentParam | ModifyDocumentParam | Taip       | Ne              | (žr.: Lentelė 50. Esybės „ModifyDocumentParam“ laukų sąrašas) |

- Operacija grąžina DocumentInfo tipo rezultatą (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas).

---

### 31. Operacijos „modifyDocument“ rezultato aprašymas

| Pavadinimas    | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                               |
| -------------- | ------------ | ---------- | --------------- | ------------------------------------------------------- |
| modifyDocument | DocumentInfo | Taip       | Ne              | (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas) |

---

## 32. Operacija „modifyDocumentInVersion“

- Operacija skirta DBSIS esamo dokumento modifikavimui nekeičiant jo versijos. Modifikavimo veiksmas galimas tik tais atvejais, kai dokumento būsena leidžia tai atlikti. Taip pat kai kurių čia išvardintų atributų negalima modifikuoti esant kai kurios dokumento būsenoms.
- Operacijai paduodama esybė ModifyDocumentInVersionParam.

### 33. Operacijos „modifyDocument“ parametrai aprašymas

| Pavadinimas                  | Tipas                        | Privalomas | Pasikartojantis | Aprašymas                                                              |
| ---------------------------- | ---------------------------- | ---------- | --------------- | ---------------------------------------------------------------------- |
| modifyDocumentInVersionParam | ModifyDocumentInVersionParam | Taip       | Ne              | (žr.: Lentelė 52. Esybės „ModifyDocumentInVersionParam“ laukų sąrašas) |

- Operacija grąžina DocumentInfo tipo rezultatą (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas).

### 34. Operacijos „modifyDocumentInVersion“ rezultato aprašymas

| Pavadinimas             | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                               |
| ----------------------- | ------------ | ---------- | --------------- | ------------------------------------------------------- |
| modifyDocumentInVersion | DocumentInfo | Taip       | Ne              | (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas) |

---

## 35. Operacija „terminate“

- Operacija „terminate“ skirta anuliuoti užregistruotą dokumentą.
- Operacijai paduodama esybė TerminateParam. Jos struktūra pateikta žemiau esančioje lentelėje:

### 36. „TerminateParam“ laukų sąrašas

| Pavadinimas | Tipas  | Privalomas | Pasikartojantis | Aprašymas                                           |
| ----------- | ------ | ---------- | --------------- | --------------------------------------------------- |
| docOid      | string | Taip       | Ne              | Dokumento unikalus identifikatorius DBSIS sistemoje |
| text        | string | Taip       | Ne              | Anuliavimo priežastis laisvu tekstu                 |

- Operacija grąžina DocumentInfo tipo rezultatą (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas).

### 37. Operacijos „terminate“ rezultato aprašymas

| Pavadinimas | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                               |
| ----------- | ------------ | ---------- | --------------- | ------------------------------------------------------- |
| terminate   | DocumentInfo | Taip       | Ne              | (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas) |

---

## 38. „getDocument“

- Operacija skirta gauti detalią vieno dokumento informaciją.
- Operacijai paduodama esybė GetDocumentParam. Jos struktūra pateikta žemiau esančioje lentelėje:

### 39. „GetDocumentParam“ laukų sąrašas

| Pavadinimas              | Tipas              | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                                                                                                                                                                                                                                                                                            |
| ------------------------ | ------------------ | ---------- | --------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| docOid                   | string             | Taip       | Ne              | Dokumento OID DBSIS sistemoje.                                                                                                                                                                                                                                                                                                                                                                                                                                       |
| expand                   | DocumentExpandType | Ne         | Ne              | Sąrašas atributų pavadinimų, nusakantis kurių atributų ir kokios apimties informacija pateikiama (žr. Esybė „DocumentExpandType“)                                                                                                                                                                                                                                                                                                                                    |
| retrieveBodyAttachment   | enum               | Ne         | Ne              | Nurodoma, kaip pateikti dokumento rinkmenas (priklausomai nuo sistemos konfigūracijos požymio WS\_RETRIEVE\_ADOC\_AS\_BODY\_ATTACHMENT reikšmės gali būti pateikta ir elektroninio dokumento pakuotė): „ID“ – pateikiamas tik jų ID. „METADATA“ – pateikiami metaduomenys be turinio. „METADATA\_WITH\_ELECTRO“ – pateikiami metaduomenys ir papildoma informacija, jei rinkmena yra elektroninio dokumento pakuotė. „CONTENT“ – pateikiami metaduomenys su turiniu. |
| retrieveElectroContainer | enum               | Ne         | Ne              | Nurodoma, kaip pateikti elektroninio dokumento pakuotę: „ID“ – pateikiamas tik ID. „METADATA“ – pateikiami metaduomenys be turinio. „METADATA\_WITH\_ELECTRO“ – pateikiami metaduomenys ir papildoma informacija, jei rinkmena yra elektroninio dokumento pakuotė. „CONTENT“ – pateikiami metaduomenys su turiniu.                                                                                                                                                   |
| retrieveProcessTasks     | boolean            | Ne         | Ne              | Nurodoma ar grąžinti dokumento esamas ir atliktas procesų užduotis                                                                                                                                                                                                                                                                                                                                                                                                   |

- Operacija grąžina bendrai naudojamą esybę: „GetDocumentResult“.

### 40. „getDocument“ rezultato aprašymas

| Pavadinimas | Tipas             | Privalomas | Pasikartojantis | Aprašymas                                                             |
| ----------- | ----------------- | ---------- | --------------- | --------------------------------------------------------------------- |
| document    | GetDocumentResult | Taip       | Ne              | (žr.: 2.2.1.4 Lentelė 22. Esybės „GetDocumentResult“ laukų aprašymas) |

---

## 41. „getDocumentList“

- Operacija skirta atlikti paiešką tarp DBSIS saugomų dokumentų.
- Operacijai paduodama esybė GetDocumentListParam. Jos struktūra pateikta žemiau esančioje lentelėje:

### 42. „GetDocumentListParam“ laukų sąrašas

| Pavadinimas            | Tipas                                   | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       |
| ---------------------- | --------------------------------------- | ---------- | --------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| searchParameters       | Lentelė 2. Esybės „Map“ laukų aprašymas | Taip       | Ne              | Dokumentų paieškos parametrai (žr. Lentelė 78. Atributo „searchParameters“ galimų laukų sąrašas).                                                                                                                                                                                                                                                                                                                                                                                               |
| expand                 | DocumentExpandType                      | Ne         | Ne              | Sąrašas atributų pavadinimų, nusakantis kurių atributų ir kokios apimties informacija pateikiama (žr. Esybė „DocumentExpandType“)                                                                                                                                                                                                                                                                                                                                                               |
| retrieveBodyAttachment | enum                                    | Ne         | Ne              | Nurodoma, kaip pateikti dokumento rinkmenas (priklausomai nuo sistemos konfigūracijos požymio WS\_RETRIEVE\_ADOC\_AS\_BODY\_ATTACHMENT reikšmės gali būti pateikta ir elektroninio dokumento pakuotė): „ID“ – pateikiamas tik jų ID. „METADATA“ – pateikiami metaduomenys be turinio. „METADATA\_WITH\_ELECTRO“ – pateikiami metaduomenys ir papildoma informacija, jei rinkmena yra elektroninio dokumento pakuotė. Pastaba: „CONTENT“ parametro operacijai getDocumentList nurodyti negalima. |
| pageSize               | int                                     | Ne         | Ne              | Puslapio (grąžinamo rezultato) dydis. Jei nenurodytas, naudojama reikšmė 30                                                                                                                                                                                                                                                                                                                                                                                                                     |
| pageNum                | int                                     | Ne         | Ne              | Kelintą puslapį rodyti (kiekviename puslapyje bus pageSize įrašų). Numeracija pradedama nuo 0. Jei nenurodyta – naudojama reikšmė 0.                                                                                                                                                                                                                                                                                                                                                            |
| sortParam              | string                                  | Ne         | Ne              | Pagal ką surūšiuoti rezultatus. Nurodomas atributo pavadinimas su priesaga „Asc“ arba „Desc“.                                                                                                                                                                                                                                                                                                                                                                                                   |
| maxResults             | int                                     | Ne         | Ne              | Maksimalus grąžinamų dokumentų skaičius. Jei nenurodyta – naudojama reikšmė pagal nutylėjimą (200).                                                                                                                                                                                                                                                                                                                                                                                             |

Operacija grąžina dokumento informaciją struktūroje GetDocumentListResult:

### 43. „GetDocumentListResult“ laukų sąrašas

| Pavadinimas | Tipas             | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                    |
| ----------- | ----------------- | ---------- | --------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| document    | GetDocumentResult | Ne         | Taip            | Vieno dokumento informaciją apjungiantis elementas (žr.: 2.2.1.4 Lentelė 22. Esybės „GetDocumentResult“ laukų aprašymas)                                     |
| total       | int               | Taip       | Ne              | Kiek iš viso rasta įrašų. Šis skaičius parodo, kiek buvo rasta dokumentų neatsižvelgiant į puslapio dydį, t.y. jis gali būti didesnis už parametrą pageSize. |

---

## 44. GetDocumentListParam laukas „searchParameters“

- Laukas searchParameters - tai Map tipo struktūra (aprašymą žr. skyriuje Lentelė 2. Esybės „Map“ laukų aprašymas). Šioje struktūroje pateikiami paieškos kriterijai (dokumento metaduomenys). Galimi laukai pateikiami žemiau esančioje lentelėje. Priklausomai nuo DBSIS konfigūracijos, gali būti pateikiami ir kiti, lentelėje nepaminėti, metaduomenys.
- Operacijai galima pateikti bet kokį žemiau išvardintų parametrų poaibį, bet būtina nurodyti parametrą itemType.

### 45. „searchParameters“ galimų laukų sąrašas

| Pavadinimas                | Tipas             | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                       |
| -------------------------- | ----------------- | ---------- | --------------- | ----------------------------------------------------------------------------------------------------------------------------------------------- |
| itemType                   | ClsEntryParam     | Taip       | Ne              | Dokumento tipas. Klasifikatorius. (žr.: Lentelė 18. Esybės „ClsEntryParam“ laukų sąrašas)                                                       |
| isProject                  | boolean           | Ne         | Ne              | Ar ieškomas dokumentas yra projektas? Galimos reikšmės „true“ ir „false“.                                                                       |
| isLegalAct                 | boolean           | Ne         | Ne              | Galimos reikšmės „true“ ir „false“.                                                                                                             |
| isRegistered               | string            | Ne         | Ne              | Ar registruotas? Galimos reikšmės „T“ ir „F“.                                                                                                   |
| status                     | string            | Ne         | Ne              | Dokumento būsena                                                                                                                                |
| projectNo                  | string            | Ne         | Ne              | Projekto numeris                                                                                                                                |
| creationNo                 | string            | Ne         | Ne              | Laikinas sukūrimo numeris                                                                                                                       |
| sortText                   | DocumentSortParam | Ne         | Ne              | Dokumento rūšis (Dokumento rušies oid arba title klasifikatoriaus OID). Pvz. : clsDHSSort.RDOINC.AKT                                            |
| rubric                     | ClsEntryParam     | Ne         | Ne              | Dokumento rubrikos klasifikatoriaus įrašas. (žr.: Lentelė 18. Esybės „ClsEntryParam“ laukų sąrašas)                                             |
| projectJournal             | string            | Ne         | Ne              | Dokumento projekto registro identifikatorius                                                                                                    |
| registrationNo             | string            | Ne         | Ne              | Dokumento registracijos numeris.                                                                                                                |
| registrationDate           | DateRangeParam    | Ne         | Ne              | Dokumento registracijos datų intervalas (žr.: Lentelė 25. Esybės „DateRangeParam“ laukų sąrašas).                                               |
| projectRegistrationDate    | DateRangeParam    | Ne         | Ne              | Projekto registracijos datų intervalas – veiksmas „Užregistruoti projektą registre“ - (žr.: Lentelė 25. Esybės „DateRangeParam“ laukų sąrašas). |
| checkedOutByMe             | boolean           | Ne         | Ne              | Ar mano (prisijungusio darbuotojo) išsegtas? Galimos reikšmės „true“ ir „false“.                                                                |
| title                      | string            | Ne         | Ne              | Dokumento antraštė                                                                                                                              |
| journal                    | JournalParam      | Ne         | Ne              | Dokumento registras: identifikatorius.                                                                                                          |
| senders                    | string            | Ne         | Taip            | Dokumento siuntėjo informacija. Galima nurodyti kelis.                                                                                          |
| documentNr                 | string            | Ne         | Ne              | Gauto dokumento numeris (registravimo numeris išsiuntusioje organizacijoje)                                                                     |
| documentDate               | date              | Ne         | Ne              | Dokumento data.                                                                                                                                 |
| wayOfReception             | ClsEntryParam     | Ne         | Ne              | Dokumento gavimo būdas. Klasifikatorius. (žr.: Lentelė 18. Esybės „ClsEntryParam“ laukų sąrašas)                                                |
| createdDate                | DateRangeParam    | Ne         | Ne              | Sukūrimo sistemoje datų intervalas (žr.: Lentelė 25. Esybės „DateRangeParam“ laukų sąrašas).                                                    |
| project                    | string            | Ne         | Ne              | Projekto identifikatorius                                                                                                                       |
| privacyCode                | ClsEntryParam     | Ne         | Ne              | Viešumo lygis. Klasifikatorius. (žr.: Lentelė 18. Esybės „ClsEntryParam“ laukų sąrašas)                                                         |
| receivers                  | OrgNodeParam      | Ne         | Ne              | Dokumento gavėjo informacija. Galima nurodyti kelis.                                                                                            |
| intermediateSender OrgName | OrgNodeParam      | Ne         | Ne              | Dokumento tarpinio siuntėjo informacija. Galima nurodyti kelis.                                                                                 |
| maxAmount                  | int               | Ne         | Ne              | Nurodo, kiek dokumentų grąžinti, jei pagal paieškos parametrus randama daugiau nei maxAmount dokumentų.                                         |
| skipResults                | int               | Ne         | Ne              | Nurodo, nuo kurio rasto elemento formuoti sąrašą, t.y., praleidžia nurodytą skaičių pirmųjų įrašų sąraše.                                       |

---

## 46. „getBodyAttachment“

- Operacija skirta gauti detalią vieno dokumento priedo informaciją ir patį preidą. Priklausomai nuo sistemos konfigūracijos požymio WS\_RETRIEVE\_ADOC\_AS\_BODY\_ATTACHMENT reikšmės gali būti pateikta ir elektroninio dokumento pakuotė.
- Operacijai paduodama esybė „GetAttachmentParam“. Jos struktūra pateikta žemiau esančioje lentelėje:

### 47. „GetAttachmentParam“ laukų sąrašas

| Pavadinimas            | Tipas  | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                                                                                                                                  |
| ---------------------- | ------ | ---------- | --------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| docOid                 | string | Taip       | Ne              | Dokumento OID DBSIS sistemoje.                                                                                                                                                                                                                                                                             |
| oid                    | string | Taip       | Ne              | Dokumento priedo OID DBSIS sistemoje.                                                                                                                                                                                                                                                                      |
| retrieveBodyAttachment | enum   | Taip       | Ne              | Nurodoma, kaip pateikti dokumento rinkmenas: „ID“ – pateikiamas tik jų ID. „METADATA“ – pateikiami metaduomenys be turinio. „METADATA\_WITH\_ELECTRO“ – pateikiami metaduomenys ir papildoma informacija, jei rinkmena yra elektroninio dokumento pakuotė. „CONTENT“ – pateikiami metaduomenys su turiniu. |

- Operacija grąžina dokumento priedo informaciją struktūroje „GetAttachmentResult“:

---

## 48. Esybės „GetAttachmentResult“ laukų sąrašas

| Pavadinimas    | Tipas      | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                   |
| -------------- | ---------- | ---------- | --------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| bodyAttachment | Attachment | Ne         | Taip            | Dokumento arba jo priedo rinkmena. Galima nurodyti kelias. Konkretus tipas priklauso nuo parametro ‚retrieveBodyAttachment ‘ reikšmės (žr.: Lentelė 30. Esybės „Attachment“ laukų sąrašas). |

## 49. „getElectroContainer“

- Operacija skirta gauti vieno dokumento elektroninę pakuotę.
- Operacijai paduodama esybė „GetElectroContainerParam“. Jos struktūra pateikta žemiau esančioje lentelėje:

### 50. „GetElectroContainerParam“ laukų sąrašas

| Pavadinimas              | Tipas  | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                                                                                                                                         |
| ------------------------ | ------ | ---------- | --------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| docOid                   | string | Taip       | Ne              | Dokumento OID DBSIS sistemoje.                                                                                                                                                                                                                                                                                    |
| retrieveElectroContainer | enum   | Taip       | Ne              | Nurodoma, kaip pateikti dokumento elektroninę pakuotę: „ID“ – pateikiamas tik ID. „METADATA“ – pateikiami metaduomenys be turinio. „METADATA\_WITH\_ELECTRO“ – pateikiami metaduomenys ir papildoma informacija, jei rinkmena yra elektroninio dokumento pakuotė. „CONTENT“ – pateikiami metaduomenys su turiniu. |

- Operacija grąžina dokumento elektroninė pakuotės informaciją struktūroje „GetElectroContainerResult“

### 51. „GetElectroContainerResult“ laukų sąrašas

| Pavadinimas      | Tipas      | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                       |
| ---------------- | ---------- | ---------- | --------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| electroContainer | Attachment | Ne         | Ne              | Dokumento elektroninė pakuotė Konkretus tipas priklauso nuo „retrieveElectroContainer“ parametro reikšmės (žr.: Lentelė 30. Esybės „Attachment“ laukų sąrašas). |

---

## „getEDocumentInnerAttachment“

- Operacija skirta elektroninio dokumento pakuotėje esančios vienos turinio rinkmenos ištraukimui.
- Operacijai pateikiama esybė „GetEDocumentInnerAttachmentParam“, kurios struktūra aprašyta toliau pateiktoje lentelėje:

## Lentelė 83. Esybės „GetEDocumentInnerAttachmentParam“ laukų sąrašas

| Pavadinimas   | Tipas  | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                                                                                                                                                                     |
| ------------- | ------ | ---------- | --------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| docOid        | string | Taip       | Ne              | Dokumento OID DBSIS sistemoje.                                                                                                                                                                                                                                                                                                                |
| containerType | string | Taip       | Ne              | Dokumento atributo su elektroninio dokumento pakuote, pavadinimas. Pvz.: electroContainer, originalElectroContainer.                                                                                                                                                                                                                          |
| path          | string | Taip       | Ne              | Kelias iki rinkmenos elektroninio dokumento pakuotėje, pvz.: 'appendices/priedas.docx'. Jei el. dokumentas turi pridedamų el. dokumentų, galima ištrukti ir jų failus, pvz.: 'attachments/pridedamo.adoc/appendices/priedas.docx'. Nurodoma operacijos getElectroContainer rezultate gaunamo „electroData/ content/\*/path“ elemento reikšmė. |

- Operacija grąžina elektroninio dokumento pakuotėje esančios turinio rinkmenos informaciją struktūroje „GetEDocumentInnerAttachmentResult“.

## 2.2.13 Operacija „getContentCopyAttachmentOrEmpty“

- Operacija skirta gauti vieno dokumento nuorašą.
- Operacijai paduodama esybė „GetContentCopyAttachmentOrEmptyParam“. Jos struktūra pateikta žemiau esančioje lentelėje:

## Lentelė 84. Esybės „GetContentCopyAttachmentOrEmptyParam“ laukų sąrašas

| Pavadinimas                   | Tipas  | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                                                              |
| ----------------------------- | ------ | ---------- | --------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| docOid                        | string | Taip       | Ne              | Dokumento OID DBSIS sistemoje.                                                                                                                                                                                                         |
| retrieveContentCopyAttachment | enum   | Taip       | Ne              | Nurodoma, kaip pateikti dokumento nuorašą:  „ID“ – pateikiamas tik ID. „METADATA“ – pateikiami metaduomenys be turinio. „METADATA\_WITH\_ELECTRO“ – pateikiami metaduomenys be turinio „CONTENT“ – pateikiami metaduomenys su turiniu. |

- Operacija grąžina dokumento nuorašo informaciją struktūroje „GetContentCopyAttachmentOrEmptyResult“. Jeigu dokumentas nuorašo neturi, grąžintas „GetContentCopyAttachmentOrEmptyResult“ bus tuščias.

---

## Lentelė 85. Esybės „GetContentCopyAttachmentOrEmptyResult“ laukų sąrašas

| Pavadinimas           | Tipas      | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                  |
| --------------------- | ---------- | ---------- | --------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------- |
| contentCopyAttachment | Attachment | Taip       | Ne              | Dokumento nuorašas. Konkretus tipas priklauso nuo „retrieveContentCopyAttachment“ parametro reikšmės (žr.: Lentelė 30. Esybės „Attachment“ laukų sąrašas). |

## Lentelė 86. Esybės „GetEDocumentInnerAttachmentResult“ laukų sąrašas

| Pavadinimas | Tipas      | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                                                                                                                                                                                                                                                                                     |
| ----------- | ---------- | ---------- | --------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| attachment  | Attachment | Ne         | Ne              | Elektroninio dokumento pakuotėje esančios turinio rinkmenos informacija.  Grąžinami užpildyti laukai (žr.: Lentelė 30. Esybės „Attachment“ laukų sąrašas): title - failo vardas; contentType - MIME tipas; type – turinio rinkmenos tipas (kasifikatorius: pagrindinis dokumentas, priedas, pridedamas el. dokumentas); content - failo turinys. Kiti šios esybės laukai (įskaitant ir lauką oid) yra neprasminiai, nepildomi ir neturi būti interpretuojami. |

## 2.2.14 Operacija „markExternalSigningComplete“

- Operacija skirta DBSIS esamam dokumentui pažymėti, kad įvykdytas išorinis pasirašymas. Jei operacija vykdoma su el. dokumentu – privaloma nurodyti ADOC rinkmeną su parašais. Elektroninio dokumento atveju bus atliekama papildoma patikra, ar esami DBSIS dokumente parašai išlikę ir yra galiojantys.

## Lentelė 87. Esybės „markExternalSigningComplete“ laukų sąrašas

| Pavadinimas        | Tipas              | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                        |
| ------------------ | ------------------ | ---------- | --------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| docOid             | string             | Taip       | Ne              | Dokumento, kuriam pažymėti išorinį pasirašymą, DBSIS ID.                                                                                                                         |
| adocFile           | ADocAttachment     | Ne         | Ne              | Elektroninio dokumento rinkmena ir jos metaduomenys. (žr.: Lentelė 15. Esybės „AttachmentActionParam“ laukų sąrašas). Jei nurodyta – bus atnaujintas DBSIS esanti ADOC rinkmena. |
| externalActionInfo | ExternalActionInfo | Taip       | Ne              | Informacija apie išorinius pasirašymus. (žr.: 2.1.36 Lentelė 38. Esybės „ExternalActionInfo“ laukų sąrašas)                                                                      |

- Operacija grąžina DocumentInfo tipo rezultatą.

## Lentelė 88. Operacijos „markExternalSigningComplete“ rezultato aprašymas

| Pavadinimas                       | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                               |
| --------------------------------- | ------------ | ---------- | --------------- | ------------------------------------------------------- |
| markExternalSigningCompleteResult | DocumentInfo | Taip       | Ne              | (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas) |

## 2.2.15 Operacija „markExternalAcquaintanceComplete“

- Operacija skirta DBSIS esamam dokumentui pažymėti, kad įvykdytas išorinis susipažinimas. Jei operacija vykdoma su el. dokumentu – privaloma nurodyti ADOC rinkmeną su parašais. Elektroninio dokumento atveju bus atliekama papildoma patikra, ar esami DBSIS dokumente parašai išlikę ir yra galiojantys.

## Lentelė 89. Esybės „markExternalAcquaintanceComplete“ laukų sąrašas

Struktūros laukų sąrašas

| Pavadinimas        | Tipas              | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                 |
| ------------------ | ------------------ | ---------- | --------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| docOid             | string             | Taip       | Ne              | Dokumento, kuriam pažymėti išorinį susipažinimą, DBSIS ID.                                                                                                                |
| adocFile           | ADocAttachment     | Ne         | Ne              | Elektroninio dokumento rinkmena ir jos metaduomenys. (žr.: Lentelė 53. Esybės „ADocAttachment“ laukų sąrašas). Jei nurodyta – bus atnaujintas DBSIS esanti ADOC rinkmena. |
| externalActionInfo | ExternalActionInfo | Taip       | Ne              | Informacija apie išorinius susipažinimus. (žr.: 2.1.36 Esybė „ExternalActionInfo“ – informacija apie išorinius )                                                          |

Operacija grąžina DocumentInfo tipo rezultatą.

## Lentelė 90. Operacijos „markExternalAcquaintanceComplete“ rezultato aprašymas

| Pavadinimas  | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                               |
| ------------ | ------------ | ---------- | --------------- | ------------------------------------------------------- |
| documentInfo | DocumentInfo | Taip       | Ne              | (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas) |

## 2.2.16 Operacija „routeFor“

- Operacija „routeFor“ skirta perduoti toliau tvarkyti dokumentą.
- Operacijai paduodama esybė RouteForParam. Jos struktūra pateikta žemiau esančioje lentelėje:

## Lentelė 91. Esybės „RouteForParam“ laukų sąrašas

| Pavadinimas | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                                                                |
| ----------- | ------------ | ---------- | --------------- | ---------------------------------------------------------------------------------------- |
| docOid      | string       | Taip       | Ne              | Dokumento unikalus identifikatorius DBSIS sistemoje                                      |
| orgNode     | OrgNodeParam | Taip       | Taip            | Esybėje lauko „orgName“ reikšmė yra privaloma (žr. Esybės „OrgNodeParam“ laukų sąrašas). |
| routedBy    | OrgNodeParam | Taip       | Ne              | Esybėje lauko „orgName“ reikšmė yra privaloma (žr. Esybės „OrgNodeParam“ laukų sąrašas). |
| notes       | string       | Ne         | Ne              | Perdavimo pastabos laisvu tekstu                                                         |

- Operacija grąžina DocumentInfo tipo rezultatą (žr skyrių Lentelė 24. „DocumentInfo“ esybės laukų aprašymas).

## Lentelė 92. Operacijos „routeForResponse“ rezultato aprašymas

| Pavadinimas      | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                               |
| ---------------- | ------------ | ---------- | --------------- | ------------------------------------------------------- |
| routeForResponse | DocumentInfo | Taip       | Ne              | (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas) |

## 2.2.17 Operacija „routeForResolution“

- Operacija „routeForResolution“ skirta kurti darbą paskirti vykdytoją.
- Operacijai paduodama esybė RouteForResolutionParam. Jos struktūra pateikta žemiau esančioje lentelėje:

## Lentelė 93. Esybės „RouteForResolutionParam“ laukų sąrašas

| Pavadinimas | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                                                                |
| ----------- | ------------ | ---------- | --------------- | ---------------------------------------------------------------------------------------- |
| docOid      | string       | Taip       | Ne              | Dokumento unikalus identifikatorius DBSIS sistemoje                                      |
| assignees   | OrgNodeParam | Taip       | Taip            | Esybėje lauko „orgName“ reikšmė yra privaloma (žr. Esybės „OrgNodeParam“ laukų sąrašas). |

- Operacija grąžina DocumentInfo tipo rezultatą (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas).

## Lentelė 94. Operacijos „routeForResolutionResponse“ rezultato aprašymas

| Pavadinimas                | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                               |
| -------------------------- | ------------ | ---------- | --------------- | ------------------------------------------------------- |
| routeForResolutionResponse | DocumentInfo | Taip       | Ne              | (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas) |

## 2.2.18 Operacija „register“

- Operacija „register“ skirta užregistruoti dokumentą. Jeigu registras nenurodomas tarp parametrų, registravimui panaudojamas registras nurodytas dokumente. Jei nebus nurodytas nei tarp parametrų, nei dokumente, tai bus laikoma klaida.
- Operacijai paduodama esybė RegisterParam. Jos struktūra pateikta žemiau esančioje lentelėje (žr. Lentelė 95. Esybės „RegisterParam“ laukų sąrašas) :

## Lentelė 95. Esybės „RegisterParam“ laukų sąrašas

| Pavadinimas    | Tipas           | Privalomas | Pasikartojantis | Aprašymas                                                                                        |
| -------------- | --------------- | ---------- | --------------- | ------------------------------------------------------------------------------------------------ |
| docOid         | string          | Taip       | Ne              | Dokumento unikalus identifikatorius DBSIS sistemoje                                              |
| journal        | JournalParam    | Ne         | Ne              | Esybėje lauko „oid“ reikšmė yra privaloma (žr. Lentelė 37. Esybės „JournalParam“ laukų sąrašas). |
| officeCase     | OfficeCaseParam | Ne         | Ne              | Esybėje lauko „oid“ reikšmė privaloma (žr. Lentelė 35. Esybės „OfficeCaseParam“ laukų sąrašas).  |
| registrationNo | String          | Ne         | Ne              | Dokumento registravimo numeris                                                                   |

- Operacija grąžina DocumentInfo tipo rezultatą (žr.Lentelė 24. „DocumentInfo“ esybės laukų aprašymas ).

## Lentelė 96. Operacijos „register“ rezultato aprašymas

| Pavadinimas  | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                               |
| ------------ | ------------ | ---------- | --------------- | ------------------------------------------------------- |
| documentInfo | DocumentInfo | Taip       | Ne              | (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas) |

## 2.2.19 Operacija „modifyReviewalSchema“

- Operacija „modifyReviewalSchema“ skirta dinaminio projekto peržiūrinčiųjų sąrašo modifikavimui. Nurodytiems peržiūrintiesiems nebūtinai iš karto bus leidžiama atlikti peržiūros veiksmą. Bendru atveju, nurodytiems peržiūrintiesiems iš karto bandoma kurti peržiūros užduotis, jei projekto peržiūra jau vyksta.
- Snake darbo eigos procesų atveju projektas turi tik dinaminius peržiūrinčiuosius. Administruojamoje Snake darbo eigos proceso schemoje galima nurodyti pradinį dinaminių peržiūrinčiųjų sąrašą, kuris šia funkcija gali būti keičiamas.
- Activiti darbo eigos procesų atveju darbo eigos proceso būsenos pasikeitimas priklauso nuo konkrečios schemos. Kraštutiniu atveju schema gali apskritai neleisti šio veiksmo.
- Operacijai paduodama esybė ModifySchemaParam, kurios struktūra pateikta žemiau esančioje lentelėje (žr. Lentelė 97. Esybės „ModifySchemaParam“ laukų sąrašas):

## Lentelė 97. Esybės „ModifySchemaParam“ laukų sąrašas

| Pavadinimas             | Tipas | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                                                                                                |
| ----------------------- | ----- | ---------- | --------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| docOid                  |       | Taip       | Ne              | Dokumento projekto unikalus identifikatorius DBSIS sistemoje                                                                                                                                                                                                             |
| executors               |       | Ne         | Taip            | Veiksmą atliekančio vykdytojo identifikatorius. Esybėje lauko „orgName“ reikšmė yra privaloma (žr. Esybės „OrgNodeParam“ laukų sąrašas).                                                                                                                                 |
| notes                   |       | Ne         | Ne              | Rengėjo komentaras vykdytojams.                                                                                                                                                                                                                                          |
| sequenceType            |       | Ne         | Ne              | Vykdymo eigos tipas nuoseklus/lygiagretus. Pateikti galima dvi reikšmes: sequential, rodantį, kad eiga nuosekli arba parallel, rodantį, kad eiga lygiagreti. Nenurodžius reikšmės, nustatomas lygiagretus eigos tipas. Pastaba: Activiti atveju parametras ignoruojamas. |
| dueDate                 |       | Ne         | Ne              | Terminas, iki kada turi būti įvykdyta, bendras ir aktyvioms ir būsimoms užduotims.                                                                                                                                                                                       |
| workingDays             |       | Ne         | Ne              | Terminas darbo dienų skaičiumi, iki kada turi būti baigtas vykdymas. Jei nurodytas dueDate, šis parametras ignoruojamas.                                                                                                                                                 |
| allowModifyAttachments  |       | Ne         | Ne              | Požymis, ar leidžiama modifikuoti projekto turinio failų kopijas. Nenurodžius, nustatoma reikšmė false.                                                                                                                                                                  |
| executorsAppendOnly     |       | Ne         | Ne              | Požymis, ar nurodyti vykdytojai tik papildo esamą sąrašą, ar jį pakeičia. Nenurodžius, nustatoma reikšmė false.                                                                                                                                                          |
| copyToSecondaryProjects |       | Ne         | Ne              | Požymis, ar atitinkamas modifikavimas atliekamas ir susijusiems antriniams projektams. Nenurodžius, nustatomas reikšmė false. Pastaba: CDO šis požymis ignoruojamas.                                                                                                     |

- Operacija grąžina DocumentInfo tipo rezultatą (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas ).

## 2.2.20 Operacija „modifyApprovalSchema“

- Operacija „modifyApprovalSchema“ skirta dinaminio projekto derinančiųjų sąrašo modifikavimui. Operacijos veikimas ir paduodami parametrai analogiški operacijai modifyReviewalSchema (žr. Operacija „modifyReviewalSchema“).
- Operacija grąžina DocumentInfo tipo rezultatą (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas ).

## 2.2.21 Operacija „modifySigningSchema“

- Operacija „modifySigningSchema“ skirta dinaminio projekto pasirašančiųjų sąrašo modifikavimui. Operacijos veikimas ir paduodami parametrai analogiški operacijai modifyReviewalSchema (žr. Operacija „modifyReviewalSchema“).
- Operacija grąžina DocumentInfo tipo rezultatą (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas ).
- Operacija grąžina DocumentInfo tipo rezultatą (žr.Lentelė 24. „DocumentInfo“ esybės laukų aprašymas ).

## 2.2.23 Operacija „modifyAcquaintees“

- Operacija „modifyAcquaintees“ skirta nurodyti, kas susipažins su dokumentu po registracijos. Jei darbo eigos procesas numato tokią galimybę, nurodytoms pareigybėms atitinkamu metu bus suteiktos teisės, sukurtos užduotys. Nurodytų susipažįstančiųjų sąrašas pilnai pakeičia egzistavusį, ankstesnės neįvykdytos susipažinimo užduotys sunaikinamos.
- Operacijai paduodama esybė ModifyAcquainteesParam, kurios struktūra pateikta žemiau esančioje lentelėje (žr. Lentelė 98. Esybės „ModifyAcquainteesParam“ laukų sąrašas) :

## Lentelė 98. Esybės „ModifyAcquainteesParam“ laukų sąrašas

| Pavadinimas | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                       |
| ----------- | ------------ | ---------- | --------------- | ----------------------------------------------------------------------------------------------------------------------------------------------- |
| docOid      | string       | Taip       | Ne              | Dokumento projekto unikalus identifikatorius DBSIS sistemoje                                                                                    |
| acquaintees | OrgNodeParam | Taip       | Taip            | Susipažinimą atliekančios pareigybės identifikatorius. Esybėje lauko „orgName“ reikšmė yra privaloma (žr. Esybės „OrgNodeParam“ laukų sąrašas). |
| notes       | string       | Ne         | Ne              | Komentaras susipažįstantiesiems                                                                                                                 |

- Operacija grąžina DocumentInfo tipo rezultatą (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas ).

## 2.2.24 Operacija „modifyRegisterTarget“

- Operacija „modifyRegisterTarget“ skirta nurodyti, kas registruos dokumento projektą. Jei darbo eigos procesas numato tokią galimybę, nurodytam registratoriui atitinkamu metu bus suteiktos teisės, sukurta užduotis. Veiksmas galimas kol dokumento projektas nėra registruotas.
- Operacijai paduodama esybė ModifyRegisterTargetParam, kurios struktūra pateikta žemiau esančioje lentelėje (žr. Lentelė 99. Esybės „ModifyRegisterTargetParam“ laukų sąrašas) :

## Lentelė 99. Esybės „ModifyRegisterTargetParam“ laukų sąrašas

| Pavadinimas    | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                       |
| -------------- | ------------ | ---------- | --------------- | ----------------------------------------------------------------------------------------------------------------------------------------------- |
| docOid         | string       | Taip       | Ne              | Dokumento projekto unikalus identifikatorius DBSIS sistemoje                                                                                    |
| registerTarget | OrgNodeParam | Taip       | Ne              | Registravimą atliekančios pareigybės identifikatorius. Esybėje lauko „orgName“ reikšmė yra privaloma (žr. Esybės „OrgNodeParam“ laukų sąrašas). |

- Operacija grąžina DocumentInfo tipo rezultatą (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas ).

## 2.2.25 Operacija „markVersionReady“

- Operacija „markVersionReady“ skirta pažymėti, kad dokumento projekto versija parengta. Šis veiksmas pradeda arba pratęsia projekto peržiūros, derinimo, pasirašymo, tvirtinimo darbo eigos procesą pagal esamą darbo eigos proceso informaciją. Bendru atveju, veiksmas galimas tik tada, kai projektui nėra jokių minėto tipo užduočių.
- Operacijai paduodama esybė MarkVersionReadyParam, kurios struktūra pateikta žemiau esančioje lentelėje (žr. Lentelė 100. Esybės „MarkVersionReadyParam“ laukų sąrašas) :

## Lentelė 100. Esybės „MarkVersionReadyParam“ laukų sąrašas

| Pavadinimas | Tipas  | Privalomas | Pasikartojantis | Aprašymas                                                    |
| ----------- | ------ | ---------- | --------------- | ------------------------------------------------------------ |
| docOid      | string | Taip       | Ne              | Dokumento projekto unikalus identifikatorius DBSIS sistemoje |

- Operacija grąžina DocumentInfo tipo rezultatą (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas ).

## 2.2.26 Operacija „getDocumentReaders“

- Operacija skirta gauti pareigybių, kurios gali peržiūrėti dokumentą, sąrašą.
- Operacijai paduodama esybė GetDocumentReadersParam. Jos struktūra pateikta žemiau esančioje lentelėje:

## Lentelė 101. Esybės „GetDocumentReadersParam“ laukų sąrašas

| Pavadinimas | Tipas  | Privalomas | Pasikartojantis | Aprašymas                      |
| ----------- | ------ | ---------- | --------------- | ------------------------------ |
| docOid      | string | Taip       | Ne              | Dokumento OID DBSIS sistemoje. |

- Operacija grąžina esybę: „GetDocumentReadersResult“.

## Lentelė 102. Operacijos „getDocumentReaders“ rezultato aprašymas

| Pavadinimas | Tipas   | Privalomas | Pasikartojantis | Aprašymas                                           |
| ----------- | ------- | ---------- | --------------- | --------------------------------------------------- |
| reader      | OrgNode | Ne         | Taip            | (žr. Lentelė 115. „OrgStaff“ esybės laukų sąrašas). |

## 2.2.27 Operacija „getLinkedTasksInfo“

- Operacija skirta grąžinti iš dokumento ar sutarties sukurtų užduočių ir jų vaikų informaciją.
- Operacijai paduodama esybė GetLinkedTasksInfoParam, kurios struktūra pateikta žemiau esančioje lentelėje:

## Lentelė 103. Esybės „GetLinkedTasksInfoParam“ laukų sąrašas

| Pavadinimas | Tipas  | Privalomas | Pasikartojantis | Aprašymas                                                     |
| ----------- | ------ | ---------- | --------------- | ------------------------------------------------------------- |
| docOid      | string | Taip       | Ne              | Dokumento arba sutarties unikalus identifikatorius sistemoje. |

- Operacija grąžina esybę: „GetLinkedTasksInfoResult“.

## Lentelė 104. Operacijos „getLinkedTasksInfo“ rezultato aprašymas

| Pavadinimas | Tipas          | Privalomas | Pasikartojantis | Aprašymas                                                      |
| ----------- | -------------- | ---------- | --------------- | -------------------------------------------------------------- |
| taskInfo    | LinkedTaskInfo | Ne         | Taip            | (žr. Lentelė 105. Esybės „LinkedTaskInfo“ rezultato aprašymas) |

## Lentelė 105. Esybės „LinkedTaskInfo“ rezultato aprašymas

| Pavadinimas     | Tipas   | Privalomas | Pasikartojantis | Aprašymas                                                                                                                              |
| --------------- | ------- | ---------- | --------------- | -------------------------------------------------------------------------------------------------------------------------------------- |
| oid             | string  | Taip       | Ne              | Užduoties unikalus identifikatorius                                                                                                    |
| parentOid       | string  | Ne         | Ne              | Užduoties, iš kurios sukurta ši, unikalus identifikatorius. Jeigu užduotis kurta iš dokumento arba sutarties, laukas reikšmės neturės. |
| executor        | OrgNode | Ne         | Ne              | Užduoties vykdytojo informacija. Jeigu vykdytojas pavaduojamas, pateikiama laikinos pareigybės informacija.                            |
| realStaff       | OrgNode | Ne         | Ne              | Vykdytojui esant pavaduojamam, pateikiama informacija apie tikrąją pareigybę, kuriai užduotis paskirta.                                |
| substituteStaff | OrgNode | Ne         | Ne              | Vykdytojui esant pavaduojamam, pateikiama informacija apie jį pavaduojančią pareigybę.                                                 |

## 2.2.28 Operacija „markExtReviewal“

- Operacija skirta atžymėti išorinę peržiūrą dokumente. Dokumentas privalo turėti peržiūros darbą ir kaip vykdytojas nurodytas išorinis kontaktas.
- Operacijai paduodama esybė MarkExtApprovalParam, kurios struktūra pateikta žemiau esančioje lentelėje:

## Lentelė 106. Esybės „MarkExtReviewalParams“ laukų sąrašas

| Pavadinimas    | Tipas                 | Privalomas | Pasikartojantis | Aprašymas                                                                                      |
| -------------- | --------------------- | ---------- | --------------- | ---------------------------------------------------------------------------------------------- |
| docOid         | string                | Taip       | Ne              | Dokumento arba sutarties unikalus identifikatorius sistemoje.                                  |
| attachment     | EDocumentAttachment   | Taip       | Ne              | Pasirašytas elektroninis dokumentas. Žr. 2.2.1.4 Esybė „EDocumentAttachment“                   |
| actionInfo     | ExtActionInfo         | Taip       | Ne              | Veiksmo informacija. Žr. Error! Reference source not found. Error! Reference source not found. |
| adoAttachments | AttachmentActionParam | Ne         | Taip            | Papildomo derinimo priedai. Negalimas kai darbas neleidžia                                     |

- Operacija grąžina DocumentInfo tipo rezultatą (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas ).

## 2.2.29 Operacija „markExtApproval“

- Operacija skirta atžymėti išorinį derinimą dokumente. Dokumentas privalo turėti derinimo darbą ir kaip vykdytojas nurodytas išorinis kontaktas.
- Operacijai paduodama esybė MarkExtApprovalParam, kurios struktūra identiška MarkExtReviewalParam (žr. 2.2.28 Operacija „markExtReviewal“)

## 2.2.30 Operacija „markExtSigning“

- Operacija skirta atžymėti išorinį pasirašymą dokumente. Dokumentas privalo turėti pasirašymo darbą ir kaip vykdytojas būti nurodytas išorinis kontaktas.
- Operacijai paduodama esybė MarkExtSigningParam, kurios struktūra identiška MarkExtReviewalParam (žr. 2.2.28 Operacija „markExtReviewal“)
- Operacija grąžina DocumentInfo tipo rezultatą (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas ).

## 2.2.31 Operacija „markExtConfirmation“

- Operacija skirta atžymėti išorinį tvirtinimą dokumente. Dokumentas privalo turėti tvirtinimo darbą ir kaip vykdytojas būti nurodytas išorinis kontaktas.
- Operacijai paduodama esybė MarkExtConfirmationParam, kurios struktūra identiška MarkExtReviewalParam (žr. 2.2.28 Operacija „markExtReviewal“)
- Operacija grąžina DocumentInfo tipo rezultatą (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas ).

## 2.2.32 Operacija „receiveReviewRequest“

- Operacija skirta dokumento projekto sukūrimui, kuris, priklausomai nuo proceso, būtų automatiškai perduotas peržiūrai. Dokumentai, sukurti naudojant šią operaciją, bus pažymėti kaip „Sukurtas pateikus prašymą per WS“ ir randami per paiešką. Jeigu dokumentui pateiktas electroContainer reikšmė, kuriamas elektroninis dokumento projektas.
- Operacijai paduodama esybė ReceiveReviewRequestParam, kurios struktūra pateikta žemiau esančioje lentelėje:

## Lentelė 107. Esybės „ReceiveReviewRequestParam“ laukų sąrašas

| Pavadinimas      | Tipas               | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                 |
| ---------------- | ------------------- | ---------- | --------------- | ----------------------------------------------------------------------------------------------------------------------------------------- |
| templateParam    | TemplateParam       | Taip       | Ne              | Nurodomas dokumento šablonas (žr. Lentelė 16. Esybės „TemplateParam“ laukų sąrašas).                                                      |
| linkToDocument   | String              | Ne         | Ne              | Peržiūrai, derinimui, pasirašymui ar tvirtinimui anksčiau sukurto dokumento identifikatorius, su kuriuo susieti naujai sukurtą dokumentą. |
| electroContainer | EDocumentAttachment | Ne         | Ne              | Elektroninio dokumento rinkmena ir jos metaduomenys (žr.: 2.2.1.4 Esybė „EDocumentAttachment“).                                           |

- Paveldi viską iš „ModifyDocumentParam“ žr.: Lentelė 16. Esybės „TemplateParam“ laukų sąrašas
- Operacija grąžina DocumentInfo tipo rezultatą (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas ).

## 2.2.33 Operacija „receiveApprovalRequest“

- Operacija skirta dokumento projekto sukūrimui, kuris, priklausomai nuo proceso, būtų automatiškai perduotas derinimui. Dokumentai, sukurti naudojant šią operaciją, bus pažymėti kaip „Sukurtas pateikus prašymą per WS“ ir randami per paiešką. Jeigu dokumentui pateiktas electroContainer reikšmė, kuriamas elektroninis dokumento projektas.
- Operacijai paduodama esybė ReceiveApprovalRequestParam, kurios struktūra pateikta Lentelė 107. Esybės „ReceiveReviewRequestParam“ laukų sąrašas.
- Operacija grąžina DocumentInfo tipo rezultatą (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas ).

## 2.2.34 Operacija „receiveSigningRequest“

- Operacija skirta dokumento projekto sukūrimui, kuris, priklausomai nuo proceso, būtų automatiškai perduotas pasirašymui. Dokumentai, sukurti naudojant šią operaciją, bus pažymėti kaip „Sukurtas pateikus prašymą per WS“ ir randami per paiešką. Jeigu dokumentui pateiktas electroContainer reikšmė, kuriamas elektroninis dokumento projektas.
- Operacijai paduodama esybė ReceiveSigningRequestParam, kurios struktūra pateikta Lentelė 107. Esybės „ReceiveReviewRequestParam“ laukų sąrašas.
- Operacija grąžina DocumentInfo tipo rezultatą (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas ).

## 2.2.35 Operacija „receiveConfirmationRequest“

- Operacija skirta dokumento projekto sukūrimui, kuris, priklausomai nuo proceso, būtų automatiškai perduotas tvirtinimui. Dokumentai, sukurti naudojant šią operaciją, bus pažymėti kaip „Sukurtas pateikus prašymą per WS“ ir randami per paiešką. Jeigu dokumentui pateiktas electroContainer reikšmė, kuriamas elektroninis dokumento projektas.
- Operacijai paduodama esybė ReceiveApprovalRequestParam, kurios struktūra pateikta Lentelė 107. Esybės „ReceiveReviewRequestParam“ laukų sąrašas.
- Operacija grąžina DocumentInfo tipo rezultatą (žr. Lentelė 24. „DocumentInfo“ esybės laukų aprašymas ).

## 2.2.36 Operacija „getReviewResult“

- Operacija skirta dokumento peržiūros informacijos gavimui. Grąžinama informacija tik dokumento, kuris buvo prieš tai sukurtas naudojant receiveReviewRequest operaciją.
- Operacijai paduodama esybė GetReviewResultParam, kurios struktūra pateikta žemiau esančioje lentelėje.

## Lentelė 108. Esybės „GetReviewResultParam“ laukų sąrašas

| Pavadinimas | Tipas  | Privalomas | Pasikartojantis | Aprašymas                            |
| ----------- | ------ | ---------- | --------------- | ------------------------------------ |
| docOid      | String | Taip       | Ne              | Nurodomas dokumento identifikatorius |

- Operacija grąžina GetProcessTasks tipo rezultatą, kuris pateiktas žemiau esančioje lentelėje

## Lentelė 109. Esybės „GetProcessTasks“ laukų sąrašas

| Pavadinimas           | Tipas                          | Privalomas | Pasikartojantis | Aprašymas                              |
| --------------------- | ------------------------------ | ---------- | --------------- | -------------------------------------- |
| activeProcessTasks    | ProcessTaskListWithAttachments | Ne         | Ne              | Aktyvių proceso darbų informacija      |
| completedProcessTasks | ProcessTaskListWithAttachments | Ne         | Ne              | Pasibaigusių proceso darbų informacija |

## Lentelė 110. Esybės „ProcessTaskListWithAttachments“ laukų sąrašas

| Pavadinimas | Tipas                      | Privalomas | Pasikartojantis | Aprašymas                    |
| ----------- | -------------------------- | ---------- | --------------- | ---------------------------- |
| processTask | ProcessTaskWithAttachments | Ne         | Taip            | Sąrašas procesų informacijos |

## Lentelė 111. Esybės „ProcessTaskWithAttachments“ laukų sąrašas

| Pavadinimas        | Tipas               | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                      |
| ------------------ | ------------------- | ---------- | --------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| bodyAttachmentList | AttachmentReference | Ne         | Taip            | Dokumento arba jo priedo rinkmena. Galima nurodyti kelias.  Konkretus tipas priklauso nuo parametro ‚retrieveAttachment ‘   reikšmės (žr.: Lentelė 29. Esybės „AttachmentBase“ laukų sąrašas). |
| negativeMark       | Boolean             | Ne         | Ne              | Požymis, ar atliktas neigiamas veiksmas                                                                                                                                                        |
| actionName         | String              | Taip       | Ne              | Atlikto veiksmo pavadinimas                                                                                                                                                                    |
| assignDate         | Date                | Taip       | Ne              | Veiksmo paskyrimo data                                                                                                                                                                         |
| executor           | OrgNode             | Taip       | Ne              | Veiksmą atliekantis/-ęs asmuo                                                                                                                                                                  |
| dueDate            | Date                | Ne         | Ne              | Terminas                                                                                                                                                                                       |
| name               | String              | Ne         | Ne              | Pavadinimas                                                                                                                                                                                    |
| documentOid        | String              | Ne         | Ne              | Dokumento identifikatorius                                                                                                                                                                     |
| notes              | String              | Ne         | Ne              | Kol aktyvus darbas – vykdytojui nurodytos pastabos, o atlikus – vykdytojo įrašytos.                                                                                                            |

## 2.2.37 Operacija „getApprovalResult“

- Operacija skirta dokumento derinimo informacijos gavimui. Grąžinama informacija tik dokumento, kuris buvo prieš tai sukurtas naudojant receiveApprovalRequest operaciją.
- Operacijai paduodama esybė GetApprovalResultParam, kurios struktūra pateikta Lentelė 108. Esybės „GetReviewResultParam“ laukų sąrašas.
- Operacija grąžina GetProcessTasks tipo rezultatą (žr. Lentelė 109. Esybės „GetProcessTasks“ laukų sąrašas).

## 2.2.38 Operacija „getSigningResult“

- Operacija skirta dokumento pasirašymo informacijos gavimui. Grąžinama informacija tik dokumento, kuris buvo prieš tai sukurtas naudojant receiveSigningRequest operaciją.
- Operacijai paduodama esybė GetSigningResultParam, kurios struktūra pateikta Lentelė 108. Esybės „GetReviewResultParam“ laukų sąrašas.
- Operacija grąžina GetProcessTasks tipo rezultatą (žr. Lentelė 109. Esybės „GetProcessTasks“ laukų sąrašas).

## 2.2.39 Operacija „getConfirmationResult“

- Operacija skirta dokumento tvirtinimo informacijos gavimui. Grąžinama informacija tik dokumento, kuris buvo prieš tai sukurtas naudojant receiveConfirmationRequest operaciją.
- Operacijai paduodama esybė GetConfirmationResultParam, kurios struktūra pateikta Lentelė 108. Esybės „GetReviewResultParam“ laukų sąrašas.
- Operacija grąžina GetProcessTasks tipo rezultatą (žr. Lentelė 109. Esybės „GetProcessTasks“ laukų sąrašas).

## 2.2.40 Operacija „markPublished“

- Operacija „markPublished“ skirta pažymėti dokumentą publikuotu.
- Operacijai paduodama esybė MarkPublishedParam. Jos struktūra pateikta žemiau esančioje lentelėje:

## Lentelė 112. Esybės „MarkPublishedParam“ laukų sąrašas

| Pavadinimas    | Tipas  | Privalomas | Pasikartojantis | Aprašymas                                           |
| -------------- | ------ | ---------- | --------------- | --------------------------------------------------- |
| docOid         | string | Taip       | Ne              | Dokumento unikalus identifikatorius DBSIS sistemoje |
| publicationUrl | string | Taip       | Ne              | Publikuojamo dokumento URL                          |

- Operacija grąžina DocumentInfo tipo rezultatą (žr skyrių Lentelė 24. „DocumentInfo“ esybės laukų aprašymas).
