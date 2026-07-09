# Ryšių tipų sąrašo pateikimo sąsaja

- Path: `/api-dok/dbsis-api/duomenu-strukturos/rysiu-tipu-saraso-pateikimo-sasaja`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/duomenu-strukturos/rysiu-tipu-saraso-pateikimo-sasaja
- Index: 15

---

Ryšių tipų sąrašo pateikimo sąsaja („LinkTypeWS“)

## Apibendrinimas

- Sąsaja pateikiama SOAP protokolu.
- Sąsajos pavadinimas: LinkTypeWS
- Sąsajos vardų sritis: <http://www.sintagma.lt/avilys/LinkTypeWS>.
- Sąsaja skirta pateikti dokumentų rūšių sąrašus.

---

## 2.13.1 Esybė „LinkType“

- Esybė, skirta perduoti ryšio tipo informaciją. Esybės atributai pateikti žemiau esančioje lentelėje.

## Lentelė 210. Esybės „LinkType“ laukų sąrašas

Paveldi viską iš „GetDocumentResult“ žr.: Lentelė 22. Esybės „GetDocumentResult“ laukų aprašymas

| Pavadinimas | Tipas      | Privalomas | Pasikartojantis | Aprašymas                   |
| ----------- | ---------- | ---------- | --------------- | --------------------------- |
| oid         | string     | Taip       | Ne              | Ryšio tipo identifikatorius |
| typeCode    | string     | Taip       | Ne              | Ryšio tipo kodas            |
| sideARole   | string     | Taip       | Ne              | A ryšio identifikatorius    |
| sideAName   | I18NString | Taip       | Ne              | A ryšio pavadinimas         |
| sideAType   | string     | Taip       | Ne              | A dokumento kategorija      |
| sideBRole   | string     | Taip       | Ne              | B ryšio identifikatorius    |
| sideBName   | I18NString | Taip       | Ne              | B ryšio pavadinimas         |
| SideBType   | string     | Taip       | Ne              | B dokumento kategorija      |
| weight      | string     | Ne         | Ne              | Ryšio svoris                |
| disabled    | boolean    | Ne         | Ne              | Ar ryšio tipas aktyvus      |

---

## 2.13.2 Operacija „getLinkTypeList“

- Operacijai paduodama esybė „GetLinkTypeListParam“ . Jos struktūra pateikta žemiau esančioje lentelėje:

## Lentelė 211. Operacijos „getLinkTypeList“ laukų sąrašas

| Pavadinimas   | Tipas   | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                         |
| ------------- | ------- | ---------- | --------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| docCategory   | string  | Ne         | Ne              | Dokumento kategorija, nusakanti, kokio tipo dokumentų ryšių sąrašas turėtų būti grąžintas. Jei reikšmė nepaduodama, tuomet grąžinamas sąrašas su visomis dokumentų kategorijomis. |
| infoLinksOnly | boolean | Ne         | Ne              | Požymis nurodantis ar grąžinamame sąraše bus tik info ryšiai ar ir fiksuoti ryšiai. Nenurodžius parametro bus grąžinami tiek info, tiek fiksuoti ryšiai.                          |

- Operacija grąžina sąrašą ryšių tipų. Kaip parametrai gali būti paduodami neprivalomi atributai: dokumento kategorija ir požymis, nurodantis ar grąžinami tik info ryšiai ar pilnas sąrašas kartu su fiksuotais ryšiais.
- Operacija grąžina esybę „GetLinkTypeListResult“, kurios struktūra aprašyta toliau pateiktoje lentelėje:
- Lentelė 212. Esybės „GetLinkTypeListResult“ laukų sąrašas

| Pavadinimas | Tipas    | Privalomas | Pasikartojantis | Aprašymas                                                  |
| ----------- | -------- | ---------- | --------------- | ---------------------------------------------------------- |
| itemType    | LinkType | Ne         | Taip            | Sąrašas ryšių tipų (žr.: Esybės „LinkType“ laukų sąrašas). |
