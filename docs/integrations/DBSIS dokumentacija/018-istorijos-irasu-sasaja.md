# Istorijos įrašų sąsaja

- Path: `/api-dok/dbsis-api/duomenu-strukturos/istorijos-irasu-sasaja`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/duomenu-strukturos/istorijos-irasu-sasaja
- Index: 18

---

Istorijos įrašų sąsaja („TrackingInfoWS“)

## 2.16.1 Operacija „getTrackingEvents“

- Operacija skirta dokumento istorijos įrašų gavimui.
- Operacijai paduodama esybė GetTrackingEventsParam. Jos struktūra pateikta žemiau esančioje lentelėje.

## Lentelė 225. Esybės „GetTrackingEventsParam“ laukų sąrašas

| Pavadinimas    | Tipas              | Privalomas | Pasikartojantis | Aprašymas                                                                                                                          |
| -------------- | ------------------ | ---------- | --------------- | ---------------------------------------------------------------------------------------------------------------------------------- |
| docOid         | string             | Taip       | Ne              | Dokumento, kurio istorijos įrašus norima gauti, identifikatorius.                                                                  |
| actionName     | string             | Ne         | Ne              | Veiksmo, kurio istorijos įrašus norima gauti, pavadinimas.                                                                         |
| eventDateRange | DateRangeParam     | Ne         | Ne              | Istorijos įrašų sukūrimo datų intervalas (žr. Lentelė 25. Esybės „DateRangeParam“ laukų sąrašas).                                  |
| expand         | DocumentExpandType | Ne         | Ne              | Atributų pavadinimų sąrašas, nusakantis kurių atributų ir kokios apimties informacija pateikiama (žr. Esybė „DocumentExpandType“). |

- Operacija grąžina esybę GetTrackingEventsResult, kurios atributai aprašyti žemiau esančioje lentelėje.

## Lentelė 226. „GetTrackingEventsResult“ esybės laukų sąrašas

| Pavadinimas  | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                                                          |
| ------------ | ------------ | ---------- | --------------- | ---------------------------------------------------------------------------------- |
| docOid       | String       | Taip       | Ne              | Dokumento, kurio istorijos įrašai grąžinti, identifikatorius.                      |
| trackingInfo | TrackingInfo | Ne         | Taip            | Istorijos įrašo informacija (žr.: Lentelė 14. Esybė „TrackingInfo“ laukų sąrašas). |
