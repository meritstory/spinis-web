# Registrų pateikimo sąsaja

- Path: `/api-dok/dbsis-api/duomenu-strukturos/registru-pateikimo-sasaja`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/duomenu-strukturos/registru-pateikimo-sasaja
- Index: 7

---

Registrų pateikimo sąsaja („JournalWS“)

## Apibendrinimas

- Sąsaja pateikiama SOAP protokolu.
- Sąsajos pavadinimas: JournalWS

---

## 2.5.1.1 Esybė „JournalReference“

- Namespace: <http://www.sintagma.lt/avilys/JournalWS>
- Pavadinimas: JournalReference

## Lentelė 162. Esybės „JournalReference“ laukų sąrašas

| Pavadinimas | Tipas  | Privalomas | Pasikartojantis | Aprašymas               |
| ----------- | ------ | ---------- | --------------- | ----------------------- |
| oid         | string | Taip       | Ne              | Identifikacinis numeris |

## 2.5.1.2 Esybė „Journal“

- Namespace: <http://www.sintagma.lt/avilys/JournalWS>
- Pavadinimas: Journal
- Esybė, skirta perduoti vieno registro informacijai. Esybės atributai pateikti žemiau esančioje lentelėje.

## Lentelė 163. Esybės „Journal“ laukų sąrašas

- Paveldi viską iš „JournalReference“ žr.: Lentelė 162. Esybės „JournalReference“ laukų sąrašas

| Pavadinimas | Tipas  | Privalomas | Pasikartojantis | Aprašymas                      |
| ----------- | ------ | ---------- | --------------- | ------------------------------ |
| title       | string | Taip       | Ne              | Registro pavadinimas           |
| number      | string | Taip       | Ne              | Registro identifikacinis žymuo |

## 2.5.2 Operacija „getJournalList“

- Operacija grąžina sąrašą DBSIS saugomų registrų pagal pateiktus kriterijus. Operacijai paduodama esybė „GetJournalListParam“. Esybės laukai išvardinti žemiau (žr. Lentelė 164. Esybės „GetJournalListParam“ laukų aprašymas).

## Lentelė 164. Esybės „GetJournalListParam“ laukų aprašymas

| Pavadinimas | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                                                                                                                                                                            |
| ----------- | ------------ | ---------- | --------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| targetStaff | OrgNodeParam | Ne         | Ne              | (žr.: Lentelė 41. Esybės „BaseParam“ laukų sąrašas)                                                                                                                                                                                                                                                                                                  |
| accessType  | ListParam    | Ne         | Ne              | Prieigos teisių filtras. Galimos reikšmės: „admin“ – registrų sąrašas, kuriuos naudotojas gali administruoti (kurių informaciją naudotojas gali modifikuoti – kaip administravimo sąsajoje „Administravimas -> Registrai“); „use“ – naudojimui skirtų registrų sąrašas. Jei parametras nenurodomas, pateikiamas visų DBSIS saugomų registrų sąrašas. |

Pastaba: galima nenurodyti nei vieno parametro.

- Operacijos rezultatas grąžina esybę: „GetJournalListResult“ (žr. Lentelė 165. Esybės „GetJournalListResult“ laukų aprašymas).

## Lentelė 165. Esybės „GetJournalListResult“ laukų aprašymas

| Pavadinimas | Tipas   | Privalomas | Pasikartojantis | Aprašymas                                          |
| ----------- | ------- | ---------- | --------------- | -------------------------------------------------- |
| journal     | Journal | Ne         | Taip            | (žr.: Lentelė 163. Esybės „Journal“ laukų sąrašas) |

## 2.5.3 Operacija „getJournal“

- Operacija „getJournal“ grąžina registro esybė pagal unikalų registro identifikatorių.
- Operacijai paduodama esybė „GetJournalParam“. Jos struktūra pateikta žemiau esančioje lentelėje.

## Lentelė 166. Esybės „GetJournalParam“ laukų sąrašas

| Pavadinimas | Tipas  | Privalomas | Pasikartojantis | Aprašymas                                          |
| ----------- | ------ | ---------- | --------------- | -------------------------------------------------- |
| oid         | string | Taip       | Ne              | Registro unikalus identifikatorius DBSIS sistemoje |

- Operacija grąžina Journal esybę.

## Lentelė 167. Operacijos „getJournal“ rezultatas

| Pavadinimas | Tipas   | Privalomas | Pasikartojantis | Aprašymas                                          |
| ----------- | ------- | ---------- | --------------- | -------------------------------------------------- |
| getJournal  | Journal | Ne         | Taip            | (žr.: Lentelė 163. Esybės „Journal“ laukų sąrašas) |
