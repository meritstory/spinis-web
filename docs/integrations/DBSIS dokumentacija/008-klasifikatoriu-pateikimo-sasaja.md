# Klasifikatorių pateikimo sąsaja

- Path: `/api-dok/dbsis-api/duomenu-strukturos/klasifikatoriu-pateikimo-sasaja`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/duomenu-strukturos/klasifikatoriu-pateikimo-sasaja
- Index: 8

---

Klasifikatorių pateikimo sąsaja („ClassifierWS“)

## Apibendrinimas

- Sąsaja pateikiama SOAP protokolu.
- Sąsajos pavadinimas: ClassifierWS

---

## 2.6.1 Bendrai naudojamos esybės

## 2.6.1.1 Esybė „ClassifierClass“

- Esybė naudojama perduoti klasifikatoriaus informaciją (pvz. kalbų klasifikatorius ir t.t.).

| Pavadinimas  | Tipas      | Privalomas | Pasikartojantis | Aprašymas                                          |
| ------------ | ---------- | ---------- | --------------- | -------------------------------------------------- |
| className    | string     | Taip       | Ne              | Klasifikatoriaus kodas (unikalus)                  |
| displayValue | I18nString | Taip       | Ne              | Klasifikatoriaus pavadinimas (įvairiomis kalbomis) |

## 2.6.2 Operacija „getClassifierClassList“

- Operacija grąžina visų DBSIS įvestų klasifikatorių sąrašą. Operacijai parametrai nepaduodami.
- Operacija grąžina ClassifierClassLisResult tipo esybę, kurios atributai nurodyti žemiau esančioje lentelėje:

## Lentelė 169. „ClassifierClassListResult“ atributų sąrašas

| Pavadinimas     | Tipas           | Privalomas | Pasikartojantis | Aprašymas              |
| --------------- | --------------- | ---------- | --------------- | ---------------------- |
| classifierClass | ClassifierClass | Taip       | Taip            | Sąrašas klasifikatorių |

## 2.6.3 Operacija „getClsEntryList“

- Operacija grąžina klasifikatoriaus įrašų sąrašą pagal pateiktą klasifikatoriaus kodą.
- Operacijai perduodama esybė „GetClsEntryListParam“, kurios atributai nurodyti žemiau esančioje lentelėje.

## Lentelė 170. „GetClsEntryListParam“ atributų sąrašas

| Pavadinimas    | Tipas   | Privalomas | Pasikartojantis | Aprašymas                                                                                                                    |
| -------------- | ------- | ---------- | --------------- | ---------------------------------------------------------------------------------------------------------------------------- |
| className      | string  | Taip       | Ne              | Klasifikatoriaus kodas                                                                                                       |
| expandChildren | boolean | Taip       | Ne              | Jei reikšmė true, tai bus pateikiamas ne tik tiesiogiai klasifikatoriui priklausančių įrašų sąrašas, bet ir tų įrašų vaikai. |
| showDisabled   | boolean | Ne         | Ne              | Ar pateikti ir nenaudojamus klasifikatorių įrašus. Jei nenurodyta – nenaudojami įrašai nepateikiami.                         |

- Operacija grąžina GetClsEntryListResult esybę, kurios atributai nurodyti žemiau esančioje lentelėje.

## Lentelė 171. „GetClsEntryListResult“ atributų sąrašas

| Pavadinimas | Tipas                                            | Privalomas | Pasikartojantis | Aprašymas                       |
| ----------- | ------------------------------------------------ | ---------- | --------------- | ------------------------------- |
| classifier  | Lentelė 18. Esybės „ClsEntryParam“ laukų sąrašas | Ne         | Taip            | Klasifikatoriaus įrašų sąrašas. |

## 2.6.4 Operacija „getClsEntry“

- Operacija grąžina konkretų klasifikatoriaus įrašą pagal jo ID.
- Operacijai pateikiama GetClsEntryParam esybė, kurios atributai nurodyti žemiau esančioje lentelėje.

## Lentelė 172. „GetClsEntryParam“ atributų sąrašas

| Pavadinimas    | Tipas   | Privalomas | Pasikartojantis | Aprašymas                                                                                                       |
| -------------- | ------- | ---------- | --------------- | --------------------------------------------------------------------------------------------------------------- |
| clsid          | string  | Taip       | Ne              | Klasifikatoriaus įrašo ID                                                                                       |
| expandChildren | boolean | Ne         | Ne              | Jei reikšmė true, tai bus pateikiamas ne tik klasifikatoriaus įrašas, bei ir jo vaikinių klasifikatorių įrašai. |

- Operacija grąžina ClsEntry esybę, kurios atributai aprašytiu skyriuje Lentelė 18. Esybės „ClsEntryParam“ laukų sąrašas.
