# Darbo eigos proceso užduočių pateikimo sąsaja

- Path: `/api-dok/dbsis-api/duomenu-strukturos/darbo-eigos-procesu-uzduociu-pateikimo-sasaja`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/duomenu-strukturos/darbo-eigos-procesu-uzduociu-pateikimo-sasaja
- Index: 14

---

Darbo eigos proceso užduočių pateikimo sąsaja („ProcessTaskWS“)

## Apibendrinimas

- Sąsaja pateikiama SOAP protokolu.
- Sąsajos pavadinimas: ProcessTaskWS.

### Tipiniai darbo eigos procesų veiksmai

- Veiksmų sąrašas

| Identifikatorius                   | Pavadinimas             |
| ---------------------------------- | ----------------------- |
| action.rdo.markReviewal            | Peržiūrėti              |
| action.rdo.markApproval            | Derinti                 |
| action.rdo.markSigning             | Pasirašyti              |
| action.rdo.markConfirmation        | Tvirtinti               |
| action.dhs.register                | Registruoti             |
| action.dhs.markAcquaintance        | Susipažinti             |
| action.dhs.markProjectAcquaintance | Susipažinti su projektu |

---

## 2.12.1.2 Esybė „ProcessTask“

- Esybė, skirta perduoti darbo eigos proceso užduoties informaciją. Esybės atributai pateikti žemiau esančioje lentelėje.

## Lentelė 206. Esybės „ProcessTask“ laukų sąrašas

Paveldi viską iš „GetDocumentResult“ žr.: Lentelė 22. Esybės „GetDocumentResult“ laukų aprašymas

| Pavadinimas | Tipas  | Privalomas | Pasikartojantis | Aprašymas                                                                                                       |
| ----------- | ------ | ---------- | --------------- | --------------------------------------------------------------------------------------------------------------- |
| actionName  | string | Taip       | Ne              | Darbo eigos proceso užduoties veiksmo identifikatorius (žr. Lentelė 205. Tipiniai darbo eigos procesų veiksmai) |
| assignDate  | string | Taip       | Ne              | Darbo eigos proceso užduoties paskyrimo data                                                                    |
| executor    | string | Taip       | Ne              | Darbo eigos proceso užduoties vykdytojas (savininkas)                                                           |
| dueDate     | string | Ne         | Ne              | Darbo eigos proceso užduoties baigimo data                                                                      |
| name        | string | Ne         | Ne              | Darbo eigos proceso užduoties pavadinimas                                                                       |
| documentOid | string | Ne         | Ne              | Darbo eigos proceso užduoties dokumento unikalus identifikatorius                                               |
| notes       | string | Ne         | Ne              | Pastabos apie darbo eigos proceso užduotį                                                                       |

---

### 2.12.1.3 Esybė „GetProcessTasks“

- Esybė, skirta perduoti užduočių esamus (activeProcessTasks) ir atliktus (completedProcessTasks) procesus. Esybės atributai hierarchiškai nuo activeProcessTasks / completedProcessTasks -> processTask pateikti žemiau esančioje lentelėje.

## Lentelė 207. Esybės „ProcessTask“ laukų sąrašas

| Pavadinimas        | Tipas               | Privalomas | Pasikartojantis | Aprašymas                                                                          |
| ------------------ | ------------------- | ---------- | --------------- | ---------------------------------------------------------------------------------- |
| actionName         | string              | Taip       | Ne              | Proceso užduoties veiksmo identifikatorius (žr. lentelę Tipiniai procesų veiksmai) |
| assignDate         | date                | Taip       | Ne              | Proceso užduoties paskyrimo data                                                   |
| executor           | OrgNode             | Taip       | Ne              | Proceso užduoties vykdytojas (savininkas)                                          |
| dueDate            | date                | Ne         | Ne              | Proceso užduoties baigimo data                                                     |
| name               | string              | Ne         | Ne              | Proceso užduoties pavadinimas                                                      |
| documentOid        | string              | Ne         | Ne              | Proceso užduoties dokumento unikalus identifikatorius                              |
| notes              | string              | Ne         | Ne              | Pastabos apie proceso užduotį                                                      |
| bodyAttachmentList | AttachmentReference | Ne         | Taip            | Prisegti failai prie užduoties proceso                                             |
| negativeMark       | boolean             | Ne         | Ne              | Požymis ar procesas pažymėtas kaip neigiamas ar teigiamas                          |

## 2.12.2 Operacija „getCurrentProcessTaskList“

- Operacija grąžina aktyvias darbo eigos proceso užduotis, kurios yra nurodytos konkrečiam dokumentui, užduoties savininkui ir (ar) veiksmui. Operacijai privalo būti paduotas užduoties vykdytojas arba dokumento identifikatorius.
- Operacijai paduodama esybė GetCurrentProcessTaskListParam. Jos struktūra pateikta žemiau esančioje lentelėje:

## Lentelė 208. Esybės „GetCurrentProcessTaskListParam“ laukų sąrašas

| Pavadinimas | Tipas | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                                                                                                                                                                                                                                      |
| ----------- | ----- | ---------- | --------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| actionName  |       | Ne         | Ne              | Nurodomas darbo eigos proceso užduoties veiksmo identifikatorius (žr. lentelę Lentelė 205. Tipiniai darbo eigos procesų veiksmai).                                                                                                                                                                                                                                                                             |
| executor    |       | Ne         | Ne              | Darbo eigos proceso užduoties vykdytojas (savininkas). Turi būti nurodyta pareigybė. Pateikiamos visos aktyvios darbo eigos procesų užduotys, kurias nurodyta pareigybė gali vykdyti (tuo tarpu ir tas užduotis, kurios paskirtos ne tiesiogiai pareigybei, o jos padaliniui). Nurodžius ne pareigybę, paieška nieko negrąžina. Jei vykdytojas nėra nurodytas, turi būti nurodytas dokumento identifikatorius. |
| documentOid |       | Ne         | Ne              | Darbo eigos proceso užduoties dokumento unikalus identifikatorius. Jei nenurodytas, turi būti nurodytas užduoties vykdytojas.                                                                                                                                                                                                                                                                                  |

- Operacija grąžina GetProcessTaskListResult tipo esybę, kurios atributai aprašyti žemiau esančioje lentelėje.

## Lentelė 209. „GetProcessTaskListResult“ esybės laukų sąrašas

| Pavadinimas | Tipas       | Privalomas | Pasikartojantis | Aprašymas                                                                         |
| ----------- | ----------- | ---------- | --------------- | --------------------------------------------------------------------------------- |
| processTask | ProcessTask | Ne         | Ne              | Sąrašas aktyvių darbo eigos proceso užduočių (žr.: 2.12.1.2 Esybė „ProcessTask“). |
