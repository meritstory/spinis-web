# Išorinių kontaktų pateikimo sąsaja

- Path: `/api-dok/dbsis-api/duomenu-strukturos/isoriniu-kontaktu-sasaja`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/duomenu-strukturos/isoriniu-kontaktu-sasaja
- Index: 6

---

Išorinių kontaktų pateikimo sąsaja („ContactWS“)

## Apibendrinimas

- Sąsaja pateikiama SOAP protokolu.
- Sąsajos pavadinimas: ContactWS

---

## 2.4.1 Bendrai naudojamos esybės

## 2.4.1.1 Esybė „ContactReference“

- Esybė, skirta perduoti vieno kontakto identifikatoriui. Esybės atributai pateikti žemiau esančioje lentelėje.

## Lentelė 151. „ContactReference“ esybės laukų sąrašas

| Pavadinimas | Tipas  | Privalomas | Pasikartojantis | Aprašymas                 |
| ----------- | ------ | ---------- | --------------- | ------------------------- |
| orgName     | string | Taip       | Ne              | Kontakto identifikatorius |

## 2.4.1.2 Esybė „Contact“

- Esybė, skirta perduoti vieno kontakto informacijai. Esybės atributai pateikti žemiau esančioje lentelėje.

## Lentelė 152. „Contact“ esybės laukų sąrašas

| Pavadinimas | Tipas                                   | Privalomas | Pasikartojantis | Aprašymas                                                 |
| ----------- | --------------------------------------- | ---------- | --------------- | --------------------------------------------------------- |
| orgName     | string                                  | Taip       | Ne              | Kontakto identifikatorius                                 |
| nodeType    | enum                                    | Taip       | Ne              | Kontakto tipas. (CONTACT, CONTACT\_UNIT, CONTACT\_PERSON) |
| properties  | Lentelė 2. Esybės „Map“ laukų aprašymas | Taip       | Ne              |                                                           |

## 2.4.1.3 „ContactWS“ esybėse „properties“ laukas

- Laukas properties - tai Map tipo struktūra (aprašymą žr.: Lentelė 2. Esybės „Map“ laukų aprašymas). Šioje struktūroje pateikiami kontakto metaduomenys. Galimi metaduomenys pateikiami žemiau esančioje lentelėje. Priklausomai nuo DBSIS konfigūracijos, gali būti pateikiami ir kiti, lentelėje nepaminėti, metaduomenys.

## Lentelė 153. Lauko „properties“ galimų laukų sąrašas

| Pavadinimas  | Tipas   | Privalomas | Pasikartojantis | Aprašymas                                                                                                                        |
| ------------ | ------- | ---------- | --------------- | -------------------------------------------------------------------------------------------------------------------------------- |
| officialName | string  | Taip       | Ne              | Kontakto pavadinimas                                                                                                             |
| contactType  | string  | Taip       | Ne              | Kontakto tipas                                                                                                                   |
| address      | string  | Taip       | Ne              | Kontakto adresas                                                                                                                 |
| phone        | string  | Taip       | Ne              | Kontakto tel. nr.                                                                                                                |
| code         | boolean | Ne         | Ne              | Kontakto kodas (fizinio ar juridinio asmens kodas). Galimas tik tuomet, kai sistema sukonfigūruota saugoti fizinio asmens kodus. |
| codeHash     | string  | Ne         | Ne              | Fizinio kontakto MD5 hash kodas (pateikiamas, jei sistema sukonfigūruota nesaugoti fizinio asmens kodo).                         |
| email        | string  | Ne         | Ne              | Kontakto el. pašto adresas                                                                                                       |
| externalId   | string  | Ne         | Ne              | Kontakto ID išorinėje sistemoje                                                                                                  |
| orgName      | string  | Ne         | Ne              | Kontakto ID                                                                                                                      |
| shortName    | string  | Ne         | Ne              | Kontakto trumpas pavadinimas                                                                                                     |
| rating       | string  | Ne         | Ne              | Įvertinimas                                                                                                                      |
| pvmCode      | string  | Ne         | Ne              | PVM mokėtojo kodas                                                                                                               |
| accountNo    | string  | Ne         | Ne              | Sąskaitos numeris                                                                                                                |
| cellPhone    | string  | Ne         | Ne              | Mob. telefono numeris                                                                                                            |
| fax          | string  | Ne         | Ne              | Fakso numeris                                                                                                                    |

## 2.4.2 Operacija „getContactList“

- Operacija grąžina sąrašą DBSIS esančių kontaktų identifikatorių pagal nurodytus kriterijus. Operacijos parametras esybė – GetContactListParam. Jos struktūra pateikta žemiau esančioje lentelėje:

## Lentelė 154. „GetContactListParam“ esybės laukų sąrašas

| Pavadinimas  | Tipas  | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                 |
| ------------ | ------ | ---------- | --------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------- |
| officialName | string | Ne         | Ne              | Kontakto pavadinimas                                                                                                                                      |
| nodeType     | enum   | Ne         | Ne              | Kontakto tipas. (CONTACT, CONTACT\_UNIT, CONTACT\_PERSON)                                                                                                 |
| address      | string | Ne         | Ne              | Kontakto adresas                                                                                                                                          |
| phone        | string | Ne         | Ne              | Kontakto telefono numeris                                                                                                                                 |
| email        | string | Ne         | Ne              | Kontakto el. pašto adresas                                                                                                                                |
| code         | string | Ne         | Ne              | Kontakto kodas (fizinio ar juridinio asmens kodas). Gali būti pateikiamas nesvarbu, ar sistema sukonfigūruota saugoti, ar nesaugoti fizinio asmens kodus. |
| codeHash     | string | Ne         | Ne              | Fizinio kontakto MD5 hash kodas (pateikiamas, jei sistema sukonfigūruota nesaugoti fizinio asmens kodo).                                                  |
| fileNo       | string | Ne         | Ne              | Aplanko, kuriame yra kontaktas, numeris                                                                                                                   |
| externalId   | string | Ne         | Ne              | Kontakto identifikatorius išorinėje sistemoje                                                                                                             |
| maxAmount    | int    | Ne         | Ne              | Kiek maksimaliai rezultatų grąžinti.                                                                                                                      |

Pastaba: bent vieną parametrą nurodyti privaloma.

- Operacija grąžina esybę GetContactListResult, kurios atributai aprašyti žemiau esančioje lentelėje.

## Lentelė 155. „GetContactListResult“ esybės laukų sąrašas

| Pavadinimas | Tipas            | Privalomas | Pasikartojantis | Aprašymas                                                                                                                      |
| ----------- | ---------------- | ---------- | --------------- | ------------------------------------------------------------------------------------------------------------------------------ |
| contact     | ContactReference | Ne         | Taip            | Kontakto identifikatirių sąrašas. Esybė ContactReference aprašoma (žr.: Lentelė 151. „ContactReference“ esybės laukų sąrašas). |

## 2.4.3 Operacija „getContact“

- Operacija grąžina detalią vieno kontakto informaciją pagal jo ID. Operacijai paduodama esybė GetContactParam. Jos struktūra pateikta žemiau esančioje lentelėje:

## Lentelė 156. „GetContactParam“ esybės laukų sąrašas

| Pavadinimas | Tipas  | Privalomas | Pasikartojantis | Aprašymas                  |
| ----------- | ------ | ---------- | --------------- | -------------------------- |
| orgName     | string | Taip       | Ne              | Kontakto identifikatorius. |

- Operacija grąžina esybę GetContactResult, kurios atributai aprašyti žemiau esančioje lentelėje.

## Lentelė 157. „GetContactResult“ esybės laukų sąrašas

| Pavadinimas | Tipas            | Privalomas | Pasikartojantis | Aprašymas                                                                                                                      |
| ----------- | ---------------- | ---------- | --------------- | ------------------------------------------------------------------------------------------------------------------------------ |
| contact     | ContactReference | Ne         | Taip            | Kontakto identifikatirių sąrašas. Esybė ContactReference aprašoma (žr.: Lentelė 151. „ContactReference“ esybės laukų sąrašas). |

## 2.4.4 Operacija „createContact“

| Pavadinimas  | Tipas                                   | Privalomas | Pasikartojantis | Aprašymas                                                                                                                       |
| ------------ | --------------------------------------- | ---------- | --------------- | ------------------------------------------------------------------------------------------------------------------------------- |
| officialName | string                                  | True       | Ne              | Kontakto pavadinimas.                                                                                                           |
| contactType  | enum                                    | True       | Ne              | Kontakto tipas. (CONTACT, CONTACT\_UNIT, CONTACT\_PERSON)                                                                       |
| properties   | Lentelė 2. Esybės „Map“ laukų aprašymas | True       | Ne              | Kontakto parametrai. Galimos reikšmės aprašytos Lentelė 13. Esybės „OrgNode“ atributo „properties“ galimos reikšmės) lentelėje. |

- Operacija grąžina esybę CreateContactResult, kurios atributai aprašyti žemiau esančioje lentelėje. Esybėje naujo sukurto kontakto informacija.

## Lentelė 159. „CreateContactResult“ esybės laukų sąrašas

| Pavadinimas | Tipas            | Privalomas | Pasikartojantis | Aprašymas                                                                                                               |
| ----------- | ---------------- | ---------- | --------------- | ----------------------------------------------------------------------------------------------------------------------- |
| contact     | ContactReference | Ne         | Ne              | Kontakto identifikatorius. Esybė ContactReference aprašoma (žr.: Lentelė 151. „ContactReference“ esybės laukų sąrašas). |

## 2.4.5 Operacija „modifyContact“

- Operacija modifikuoja kontaktą. Operacijai paduodama esybė ModifyContactPara. Jos struktūra pateikta žemiau esančioje lentelėje:

## Lentelė 160. „ModifyContactParam“ esybės laukų sąrašas

| Pavadinimas | Tipas                                   | Privalomas | Pasikartojantis | Aprašymas                                                                                                                       |
| ----------- | --------------------------------------- | ---------- | --------------- | ------------------------------------------------------------------------------------------------------------------------------- |
| orgName     | string                                  | Taip       | Ne              | Kontakto identifikatorius.                                                                                                      |
| properties  | Lentelė 2. Esybės „Map“ laukų aprašymas | Taip       | Ne              | Kontakto parametrai. Galimos reikšmės aprašytos Lentelė 13. Esybės „OrgNode“ atributo „properties“ galimos reikšmės) lentelėje. |

- Operacija grąžina esybę ModifyContactResult, kurios atributai aprašyti žemiau esančioje lentelėje. Esybėje modifikuoto kontakto informacija.

## Lentelė 161. „ModifyContactResult“ esybės laukų sąrašas

| Pavadinimas | Tipas            | Privalomas | Pasikartojantis | Aprašymas                                                                                                               |
| ----------- | ---------------- | ---------- | --------------- | ----------------------------------------------------------------------------------------------------------------------- |
| coontact    | ContactReference | Ne         | Ne              | Kontakto identifikatorius. Esybė ContactReference aprašoma (žr.: Lentelė 151. „ContactReference“ esybės laukų sąrašas). |
