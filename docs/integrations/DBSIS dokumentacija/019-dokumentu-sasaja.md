# Dokumentų sąsaja

- Path: `/api-dok/dbsis-api/duomenu-strukturos/dokumentu-sasaja`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/duomenu-strukturos/dokumentu-sasaja
- Index: 19

---

Dokumentų sąsaja („DocumentWS“)

## 2.17.1 Operacija „removeDocumentVersions“

- Operacija skirta DBSIS esamo dokumento versijų pašalinimui. Šalinamos visos dokumento versijos, išskyrus einamąją versiją. Veiksmas galima tik, kai dokumento būsena leidžia tai atlikti ir naudotojas turi teisę.
- Operacijai paduodama esybė *RemoveDocumentVersionsParam*.

## Lentelė 227. Operacijos „removeDocumentVersions“ parametrai aprašymas

| Pavadinimas | Tipas  | Privalomas | Pasikartojantis | Aprašymas |
| ----------- | ------ | ---------- | --------------- | --------- |
| oid         | string | Ne         | Ne              |           |

- Operacija grąžina RemoveDocumentVersionsResult esybę, kurios atributai nurodyti žemiau esančioje lentelėje.

## Lentelė 228. „RemoveDocumentVersionsResult“ atributų sąrašas

| Pavadinimas | Tipas | Privalomas | Pasikartojantis | Aprašymas                                                                                              |
| ----------- | ----- | ---------- | --------------- | ------------------------------------------------------------------------------------------------------ |
| result      | enum  | Taip       | Ne              | Atlikto veiksmo rezultatas.  SUCCESS – veiksmas atliktas sėkmingai  FAILURE – veiksmo atlikti nepavyko |

## 2.17.2 Operacija „getDocumentAttachmentList“

- Operacija skirta gauti detalią dokumento priedų informaciją ir pačius preidus, pagal pageidaujamą failų šaką. Priklausomai nuo sistemos konfigūracijos požymio WS\_RETRIEVE\_ADOC\_AS\_BODY\_ATTACHMENT reikšmės gali būti pateikta ir elektroninio dokumento pakuotė.
- Operacijai paduodama esybė „GetDocumentAttachmentListParam“. Jos struktūra pateikta žemiau esančioje lentelėje:

## Lentelė 229. Esybės „GetDocumentAttachmentListParam“ laukų sąrašas

| Pavadinimas            | Tipas  | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                                                                                                                                  |
| ---------------------- | ------ | ---------- | --------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| docOid                 | string | Taip       | Ne              | Dokumento OID DBSIS sistemoje.                                                                                                                                                                                                                                                                             |
| attachmentMapName      | string | Taip       | Ne              | Dokumento priedų šaka.                                                                                                                                                                                                                                                                                     |
| retrieveBodyAttachment | string | Taip       | Ne              | Nurodoma, kaip pateikti dokumento rinkmenas: „ID“ – pateikiamas tik jų ID. „METADATA“ – pateikiami metaduomenys be turinio. „METADATA\_WITH\_ELECTRO“ – pateikiami metaduomenys ir papildoma informacija, jei rinkmena yra elektroninio dokumento pakuotė. „CONTENT“ – pateikiami metaduomenys su turiniu. |

- Operacija grąžina dokumento priedų informaciją struktūroje „GetAttachmentListResult“:

## Lentelė 230. Esybės „GetAttachmentListResult“ laukų sąrašas

| Pavadinimas         | Tipas      | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                            |
| ------------------- | ---------- | ---------- | --------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| documentAttachments | Attachment | Ne         | Taip            | Informacija apie dokumento priedus. Konkretus tipas priklauso nuo parametro ‚retrieveBodyAttachment ‘ reikšmės (žr.: Lentelė 30. Esybės „Attachment“ laukų sąrašas). |
