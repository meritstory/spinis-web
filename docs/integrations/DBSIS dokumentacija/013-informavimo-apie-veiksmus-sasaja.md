# Informavimo apie veiksmus sąsaja

- Path: `/api-dok/dbsis-api/duomenu-strukturos/informavimo-apie-veiksmus-sasaja`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/duomenu-strukturos/informavimo-apie-veiksmus-sasaja
- Index: 13

---

Informavimo apie veiksmus sąsaja

## Apibendrinimas

- Sąsaja pateikiama SOAP protokolu.
- Sąsajos pavadinimas: DhsEventWS

---

## 2.11.1 Operacija „receiveDhsEvent“

- Operaciją iškviečia DBSIS, kai įvykdomas veiksmas su dokumentu ar kita esybe.
- Operacija pateikia ReceiveDhsEventParam tipo struktūrą, kurios laukai aprašyti žemiau esančioje lentelėje:

## Lentelė 203. Struktūros „ReceiveDhsEventParam“ laukų sąrašas

| Pavadinimas      | Tipas         | Privalomas | Pasikartojantis | Aprašymas                                                                       |
| ---------------- | ------------- | ---------- | --------------- | ------------------------------------------------------------------------------- |
| oid              | string        | Taip       | Ne              | Dokumento (esybės) unikalus identifikatorius                                    |
| appModule        | string        | Taip       | Ne              | Aplikacijos modulis, kuriame atliktas veiksmas                                  |
| entityType       | string        | Taip       | Ne              | Esybės, su kuria atliktas veiksmas, tipas (pvz. registruotas vidaus dokumentas) |
| action           | string        | Taip       | Ne              | Veiksmo pavadinimas                                                             |
| docSort          | string        | Ne         | Ne              | Dokumento rūšis. Privaloma dokumentams, kitoms esybėms – nepateikiamas.         |
| registrationDate | dateTime      | Ne         | Ne              | Dokumento registravimo data.                                                    |
| registrationNo   | string        | Ne         | Ne              | Dokumento registravimo numeris                                                  |
| title            | string        | Ne         | Taip            | Dokumento antraštė. Privalomas dokumentams.                                     |
| sender           | senderCodes   | Ne         | Taip            | Sąrašas dokumento siuntėjų kodų                                                 |
| receiver         | receiverCodes | Ne         | Taip            | Sąrašas dokumento gavėjų kodų                                                   |

- Kaip operacijos rezultatas turi būti grąžinama ReceiveDhsEventResult tipo struktūra. Jos laukų sąrašas pateiktas žemiau esančioje lentelėje

## Lentelė 204. Operacijos rezultato „ReceiveDhsEventResult“ struktūros laukų sąrašas

| Pavadinimas     | Tipas   | Privalomas | Pasikartojantis | Aprašymas                                                                   |
| --------------- | ------- | ---------- | --------------- | --------------------------------------------------------------------------- |
| statusCode      | string  | Taip       | Ne              | „0“, jei pranešimas apdorotas sėkmingai, klaidos kodas kitu atveju.         |
| errorMessage    | string  | Ne         | Ne              | Klaidos tekstas (aprašymas) jei įvyko klaida.                               |
| persistentError | boolean | Ne         | Ne              | „true“, jei klaida yra pastovi. „false“ arba nepateikiamas kitais atvejais. |
