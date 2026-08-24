# Informavimo apie veiksmus sąsaja

- Path: `/api-dok/dbsis-api/duomenu-strukturos/informavimo-apie-veiksmus-sasaja-(dhstaskeventsws)`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/duomenu-strukturos/informavimo-apie-veiksmus-sasaja-(dhstaskeventsws)
- Index: 20

---

Informavimo apie veiksmus sąsaja („DhsTaskEventsWs“)

## Apibendrinimas

- Sąsaja pateikiama SOAP protokolu.
- Sąsajos pavadinimas: DhsTaskEventsWs

---

## 2.18.1 Operacija „receiveDhsTaskEvent“

- Operaciją iškviečia DBSIS, kai įvykdomas veiksmas su dokumentu ir reikalinga papildoma informacija apie veiksmą ir jo vykdytojus.
- Operacija pateikia ReceiveDhsTaskEventParam tipo struktūrą, kurios laukai aprašyti žemiau esančioje lentelėje:

## Lentelė 231. Struktūros „ReceiveDhsTaskEventParam“ laukų sąrašas

| Pavadinimas  | Tipas                        | Privalomas | Pasikartojantis | Aprašymas                                   |
| ------------ | ---------------------------- | ---------- | --------------- | ------------------------------------------- |
| status       | string                       | Taip       | Ne              | Dokumento būsena                            |
| isElectro    | boolean                      | Ne         | Ne              | Dokumento „Elektroninis dokumentas“ požymis |
| documentDate | Date                         | Ne         | Ne              | Dokumento data                              |
| documentNo   | string                       | Ne         | Ne              | Dokumento numeris                           |
| taskInfo     | DocumentProcessTaskInfoParam | Ne         | Ne              | Užduoties informacija                       |

## Lentelė 232. Struktūros „DocumentProcessTaskInfoParam“ laukų sąrašas

| Pavadinimas                | Tipas        | Privalomas | Pasikartojantis | Aprašymas                  |
| -------------------------- | ------------ | ---------- | --------------- | -------------------------- |
| executor                   | OrgNodeParam | Taip       | Ne              | Vykdytojas                 |
| dueDate                    | Date         | Ne         | Ne              | Terminas                   |
| notes                      | String       | Ne         | Ne              | Pastabos                   |
| allowedToModifyAttachments | Boolean      | Ne         | Ne              | Ar galima redaguoti turinį |
| actionName                 | String       | Taip       | Ne              | Atliekamas veiksmas        |
| executorNotes              | String       | Ne         | Ne              | Vykdytojo pastabos         |
| assignDate                 | Date         | Ne         | Ne              | Paskyrimo data             |
| documentOid                | String       | Taip       | Ne              | Dokumento identifikatorius |

- Kaip operacijos rezultatas turi būti grąžinama ReceiveDhsTaskEventResult tipo struktūra. Jos laukų sąrašas pateiktas žemiau esančioje lentelėje

## Lentelė 233. Operacijos rezultato „ReceiveDhsTaskEventResult“ struktūros laukų sąrašas

| Pavadinimas     | Tipas   | Privalomas | Pasikartojantis | Aprašymas                                                                   |
| --------------- | ------- | ---------- | --------------- | --------------------------------------------------------------------------- |
| statusCode      | string  | Ne         | Taip            | „SUCCESS“, jei pranešimas apdorotas sėkmingai, klaidos kodas kitu atveju.   |
| errorMessage    | string  | Ne         | Ne              | Klaidos tekstas (aprašymas) jei įvyko klaida.                               |
| persistentError | boolean | Ne         | Ne              | „true“, jei klaida yra pastovi. „false“ arba nepateikiamas kitais atvejais. |
