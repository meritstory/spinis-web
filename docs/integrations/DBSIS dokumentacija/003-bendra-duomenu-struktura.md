# Bendra duomenų struktūra

- Path: `/api-dok/dbsis-api/duomenu-strukturos/bendrai-naudojamos-duomenu-strukturos`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/duomenu-strukturos/bendrai-naudojamos-duomenu-strukturos
- Index: 3

---

Bendrai naudojamos duomenų struktūros

## 1. Map – Map tipo struktūra

| Pavadinimas | Tipas                  | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                       |
| ----------- | ---------------------- | ---------- | --------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| entry       | grupuojantis elementas | Ne         | Taip            | Elementas, grupuojantis žemiau išvardintas reikšmes                                                                                                                             |
| key         | string                 | Taip       | Ne              | Lauko pavadinimas                                                                                                                                                               |
| value       | object                 | Ne         | Ne              | Lauko reikšmė. Pateikiamas toks duomenų tipas, koks sukonfigūruotas nurodytam laukui. SOAP žinutėse būtina naudoti xsi:type atributą, nurodantį, kokio tipo reikšmė pateikiama. |

### Aprašymas

Map tipo struktūra skirta pateikti arba gauti sąrašą atributų, kurių pavadinimai iš anksto nėra žinomi. Struktūra naudojama pateikti arba gauti įvairių tipų dokumentų laukus, kurių aibė yra konfigūruojama DBSIS diegimo ir eksploatacijos metu.

Struktūrą sudaro sąrašas key, value porų. Struktūros aprašymas pateiktas žemiau esančioje lentelėje.

---

## 2. ListParam – List tipo struktūra

| Pavadinimas | Tipas  | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                       |
| ----------- | ------ | ---------- | --------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| item        | object | Ne         | Taip            | Lauko reikšmė. Pateikiamas toks duomenų tipas, koks sukonfigūruotas nurodytam laukui. SOAP žinutėse būtina naudoti xsi:type atributą, nurodantį, kokio tipo reikšmė pateikiama. |

### Aprašymas

List – tipo struktūra skirta pateikti / gauti esybių sąrašui. Struktūros aprašymas pateiktas žemiau esančioje lentelėje

### Pavyzdys

```xml
<item xmlns:ns5="http://www.sintagma.lt/avilys/ClassifierWS" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="ns5:ClsEntryParam">
    <clsid>clsEpsCat.3.1.1.2.1.MET</clsid>
</item>
```

---

## 3. I18nString – lokalizuota teksto reikšmė

| Pavadinimas | Tipas                  | Privalomas | Pasikartojantis | Aprašymas                                           |
| ----------- | ---------------------- | ---------- | --------------- | --------------------------------------------------- |
| entry       | grupuojantis elementas | Ne         | Taip            | Elementas, grupuojantis žemiau išvardintas reikšmes |
| lang        | string                 | Taip       | Ne              | Kalbos, kuria pateikiama reikšmė, 2 raidžių kodas.  |
| value       | string                 | Ne         | Ne              | Reikšmė nurodyta kalba                              |

---

## 4. OrgNodeParam – organizacinės struktūros parametras

Namespace: <http://www.sintagma.lt/avilys/OrgStructWS>

Pavadinimas: OrgNodeParam

Ši esybė skirta perduoti į DBSIS informaciją, identifikuojančią organizacinės struktūros įrašą. Esybė nenaudojama duomenų pateikimui iš DBSIS.

Organizacinės struktūros įrašas gali būti (DBSIS išspręs tai automatiškai pagal pateiktus duomenis):

- OrgStaffParam – pareigybės informacija (žr.: 2.1.5 sk.);
- OrgUnitParam – padalinio informacija (žr.: 2.1.6 sk.);
- OrgContactParam – išorinis kontaktas (žr.: 2.1.7 sk.)
- OrgContactUnitParam – kontakto (juridinio asmens) informacija (žr.: 2.1.8 sk.);
- OrgContactPersonParam – kontakto (fizinio asmens) informacija (žr.: 2.1.9 sk.).

Pastaba: identifikuojant kontaktą pagal kodą, kreipiamas dėmesys tik į aktyvius kontaktus.

Rekomendacijos: esybę naudoti paieškos operacijos.

Ši esybė skirta perduoti į DBSIS informaciją, identifikuojančią išorinį juridinį kontaktą. Esybė nenaudojama duomenų perdavimui iš DBSIS. Šią esybę galima naudoti naujų kontaktų kurti ir esamų redaguoti.

### 4.1 Laukų sąrašas

| Pavadinimas | Tipas  | Privalomas | Pasikartojantis | Aprašymas                                                      |
| ----------- | ------ | ---------- | --------------- | -------------------------------------------------------------- |
| orgName     | string | Taip       | Ne              | DBSIS esančio org. struktūros įrašo unikalus identifikatorius. |

---

## 5. OrgStaffParam laukų sąrašas

Namespace: <http://www.sintagma.lt/avilys/OrgStructWS>

Pavadinimas: OrgStaffParam

Ši esybė skirta perduoti į DBSIS informaciją, identifikuojančią pareigybę. Esybė nenaudojama duomenų pateikimui iš DBSIS.

### 5.1 OrgStaffParam laukų sąrašas

Paveldi viską iš OrgNodeParam žr.: Esybės OrgNodeParam laukų sąrašas

| Pavadinimas | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                                                                                  |
| ----------- | ------------ | ---------- | --------------- | ---------------------------------------------------------------------------------------------------------- |
| unit        | OrgNodeParam | Taip       | Ne              | Padalinio, kuriam priskirta pareigybė, unikalus identifikatorius (žr.: Esybės OrgNodeParam laukų sąrašas)  |
| orgName     | OrgNodeParam | Taip       | Ne              | Darbuotojo, kuriam paskirtas pareigybė, unikalus identifikatorius (žr.: Esybės OrgNodeParam laukų sąrašas) |

---

## 8. OrgUnitParam – padalinio parametras

Namespace: <http://www.sintagma.lt/avilys/OrgStructWS>

Pavadinimas: OrgUnitParam

Ši esybė skirta perduoti į DBSIS informaciją, identifikuojančią padalinį. Esybė nenaudojama duomenų pateikimui iš DBSIS.

### 8.1 OrgUnitParam laukų sąrašas

Paveldi viską iš OrgNodeParam žr.: Esybės OrgNodeParam laukų sąrašas

| Pavadinimas | Tipas  | Privalomas | Pasikartojantis | Aprašymas       |
| ----------- | ------ | ---------- | --------------- | --------------- |
| code        | string | Ne         | Ne              | Padalinio kodas |

---

## 10. OrgContactParam – išorinio kontakto parametras

Namespace: <http://www.sintagma.lt/avilys/OrgStructWS>

Pavadinimas: OrgContactParam
Ši esybė skirta perduoti į DBSIS informaciją, identifikuojančią išorinį kontaktą. Esybė nenaudojama duomenų pateikimui iš DBSIS. Ši esybė negali būti naudojama kuriant ar modifikuoti kontaktams. Randa kontaktą pagal lauką code arba orgName (žr.: Esybės OrgNodeParam laukų sąrašas).
Šią esybę paveldi:

- OrgContactUnitParam – kontakto (juridinio asmens) informacija (žr.: 2.1.8 sk.);
- OrgContactPersonParam – kontakto (fizinio asmens) informacija (žr.: 2.1.9 sk.).

Pastaba: identifikuojant kontaktą pagal kodą, kreipiamas dėmesys tik į aktyvius kontaktus.
Rekomendacijos: esybę naudoti paieškos operacijos.

### 10.1 Laukų sąrašas

| Pavadinimas | Tipas  | Privalomas | Pasikartojantis | Aprašymas                                               |
| ----------- | ------ | ---------- | --------------- | ------------------------------------------------------- |
| Code        | string | Ne         | Ne              | Kontakto kodas. Laukas code arba orgName yra privalomas |

---

## 12. OrgContactUnitParam – išorinio juridinio kontakto parametras

Namespace: <http://www.sintagma.lt/avilys/OrgStructWS>

Pavadinimas: OrgContactUnitParam

Ši esybė skirta perduoti į DBSIS informaciją, identifikuojančią išorinį juridinį kontaktą. Esybė nenaudojama duomenų perdavimui iš DBSIS. Šią esybę galima naudoti naujų kontaktų kurti ir esamų redaguoti.

### 13. OrgContactPersonParam laukų sąrašas

Paveldi viską iš OrgContactParam žr.: Lentelė 8. Esybės OrgContactParam laukų sąrašas

| Pavadinimas  | Tipas   | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             |
| ------------ | ------- | ---------- | --------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| code         | string  | Ne         | Ne              | Kontakto juridinis kodas                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              |
| name         | string  | Ne         | Ne              | Kontakto pavadinimas                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  |
| email        | string  | Ne         | Ne              | Kontakto el. paštas                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   |
| phone        | string  | Ne         | Ne              | Kontakto tel. nr.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     |
| address      | string  | Ne         | Ne              | kontakto adresas                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      |
| createModify | boolean | Ne         | Ne              | Kontaktą galima identifikuoti pagal **orgName** arba **code**.    Jei kontaktas pagal lauką **code** nerastas, jis bus sukurtas. Kontakto kūrimui privalomas laukas **name**.    Taip pat galima nurodyti laukų **phone** ir **address** reikšmes. Jei kontaktas rastas sistemoje tiek pagal **code** ar **orgName** jis bus modifikuotas (kontakto parametrai bus perrašyti paduotomis reikšmėmis: code, name, email, phone, address.    Jei esybė naudojama operacijose su dokumentais, nenurodžius lauko **orgName** ir **code**, bus sukurtas frozen (neredaguojamas) kontaktas. Pagal šį kontaktą nebus galima atlikti struktūrizuotos paieškos. |

---

## 14. OrgContactPersonParam – išorinio fizinio kontakto parametras

- Namespace: <http://www.sintagma.lt/avilys/OrgStructWS>
- Pavadinimas: OrgContactPersonParam
- Ši esybė skirta perduoti į DBSIS informaciją, identifikuojančią išorinį fizinį kontaktą. Šia esybe galima kurti ir redaguoti naujus kontaktus.

### 15. OrgContactPersonParam laukų sąrašas

Paveldi viską iš OrgContactParam žr.: Lentelė 8. Esybės OrgContactParam laukų sąrašas

| Pavadinimas  | Tipas   | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             |
| ------------ | ------- | ---------- | --------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| code         | string  | Ne         | Ne              | Kontakto asmens kodas                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 |
| name         | string  | Ne         | Ne              | Kontakto pavadinimas                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  |
| email        | string  | Ne         | Ne              | Kontakto el. paštas                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   |
| phone        | string  | Ne         | Ne              | Kontakto tel. nr.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     |
| address      | string  | Ne         | Ne              | kontakto adresas                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      |
| createModify | boolean | Ne         | Ne              | Kontaktą galima identifikuoti pagal **orgName** arba **code**.    Jei kontaktas pagal lauką **code** nerastas, jis bus sukurtas. Kontakto kūrimui privalomas laukas **name**.    Taip pat galima nurodyti laukų **phone** ir **address** reikšmes. Jei kontaktas rastas sistemoje tiek pagal **code** ar **orgName** jis bus modifikuotas (kontakto parametrai bus perrašyti paduotomis reikšmėmis: code, name, email, phone, address.    Jei esybė naudojama operacijose su dokumentais, nenurodžius lauko **orgName** ir **code**, bus sukurtas frozen (neredaguojamas) kontaktas. Pagal šį kontaktą nebus galima atlikti struktūrizuotos paieškos. |

---

## 16. OrgContactOtherParam – išorinio kito asmens kontakto parametras

- Namespace: <http://www.sintagma.lt/avilys/OrgStructWS>
- Pavadinimas: OrgContactOtherParam
- Ši esybė skirta perduoti į DBSIS informaciją, identifikuojančią išorinį kito asmens (įprastai užsienio piliečio) kontaktą. Šia esybe galima kurti ir redaguoti naujus kontaktus.

Paveldi viską iš OrgContactParam žr.: Lentelė 8. Esybės OrgContactParam laukų sąrašas

### 17. OrgContactOtherParam – išorinio kito asmens kontakto parametras

| Pavadinimas  | Tipas   | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             |
| ------------ | ------- | ---------- | --------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| code         | string  | Ne         | Ne              | Kontakto asmens kodas                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 |
| name         | string  | Ne         | Ne              | Kontakto pavadinimas                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  |
| email        | string  | Ne         | Ne              | Kontakto el. paštas                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   |
| phone        | string  | Ne         | Ne              | Kontakto tel. nr.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     |
| address      | string  | Ne         | Ne              | kontakto adresas                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      |
| createModify | boolean | Ne         | Ne              | Kontaktą galima identifikuoti pagal **orgName** arba **code**.    Jei kontaktas pagal lauką **code** nerastas, jis bus sukurtas. Kontakto kūrimui privalomas laukas **name**.    Taip pat galima nurodyti laukų **phone** ir **address** reikšmes. Jei kontaktas rastas sistemoje tiek pagal **code** ar **orgName** jis bus modifikuotas (kontakto parametrai bus perrašyti paduotomis reikšmėmis: code, name, email, phone, address.    Jei esybė naudojama operacijose su dokumentais, nenurodžius lauko **orgName** ir **code**, bus sukurtas frozen (neredaguojamas) kontaktas. Pagal šį kontaktą nebus galima atlikti struktūrizuotos paieškos. |

---

## 18. OrgNode – organizacinės struktūros elementas

- Namespace: <http://www.sintagma.lt/avilys/OrgStructWS>
- Pavadinimas: OrgNode
- Ši esybė naudojama grąžinti tokią informaciją:
  - OrgUnit – padalinio informacija
  - OrgStaff – pareigybės informacija
  - OrgPerson – darbuotojo informacija
  - OrgContactUnit – kontakto (juridinio asmens) informacija
  - OrgContactPerson – kontakto (fizinio asmens) informacija

### 19. OrgNode laukų sąrašas

| Pavadinimas    | Tipas                                                      | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                    |
| -------------- | ---------------------------------------------------------- | ---------- | --------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| orgName        | string                                                     | Taip       | Ne              | Identifikatorius                                                                                                                                                             |
| officialName   | string                                                     | Ne         | Ne              | Oficialus pavadinimas                                                                                                                                                        |
| personName     | string                                                     | Ne         | Ne              | Su organizaciniu vienetu susieto asmens vardas ir pavardė                                                                                                                    |
| type           | int                                                        | Taip       | Ne              | Organizacinės struktūros tipas. Galimos reikšmės:  - 1 - PERSON; - 2 - UNIT; - 3 - STAFF; - 4 - GROUP; - 5 - CONTACT; - 6 - CONTACT\_UNIT; - 7 - CONTACT\_PERSON; - 8 – SET. |
| personPhone    | string                                                     | Ne         | Ne              | Su organizaciniu vienetu susieto asmens telefonas                                                                                                                            |
| historicalName | Žr.: Sk. 2.1.38. Esybės „HistoricalName“ galimos reikšmės. | Ne         | Taip            | Sąrašas pateikiamas tik jei išreiktinai paprašoma jį pateikti užklausos parametruose (žr. operacijos „getChildUnits2“ parametrą „returnHistoricalNames“).                    |
| properties     | Lentelė 2. Esybės „Map“ laukų aprašymas                    | Taip       | Ne              | Žr.: Lentelė 13. Esybės „OrgNode“ atributo „properties“ galimos reikšmės                                                                                                     |

### 20. „OrgNode“ atributo „properties“ galimos reikšmės

properties galimų laukų sąrašas

| Pavadinimas        | Tipas  | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                          |
| ------------------ | ------ | ---------- | --------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| officialNameDative | string | Ne         | Ne              | Organizacinio vieneto Pilnas pavadinimas naudininko linksniu                                                                                                       |
| address            | string | Ne         | Ne              | Organizacinio vieneto adresas                                                                                                                                      |
| phone              | string | Ne         | Ne              | Organizacinio vieneto telefonas                                                                                                                                    |
| cellPhone          | string | Ne         | Ne              | Organizacinio vieneto mob. telefonas                                                                                                                               |
| code               | string | Ne         | Ne              | Kodas (asmens atveju – asmens kodas, juridinio asmens atveju – įmonės kodas, padalinio atveju – tuščias arba importuotas kitos IS suteiktas kodas).                |
| nameForSelect      | string | Ne         | Ne              | Pagal sistemoje apibrėžtas taisykles iš kelių reikšmių suformuotas organizacinio vieneto pavadinimas, skirtas vieneto atvaizdavimui naudotojui, sąrašų rūšiavimui  |
| orgUnitType        | string | Ne         | Ne              | Padalinio tipas. Klasifikatoriaus įrašo clsid (identifikatorius). Klasifikatorius: „clsDHSOrgUnitType“.   Grąžinamas tik padalinio tipo org. Struktūros vienetams. |
| email              | string | Ne         | Ne              | El. pašto adresas.                                                                                                                                                 |
| pvmCode            | string | Ne         | Ne              | Tik padalinio tipo įrašams, kurie yra įstaigos: PVM mokėtojo kodas.                                                                                                |
| unitCode           | string | Ne         | Ne              | Padalinio kodas                                                                                                                                                    |
| account            | string | Ne         | Ne              | Naudotojo prisijungimo vardas                                                                                                                                      |
| edeliveryInbox     | string | Ne         | Ne              | E-pristatymo dėžutės numeris                                                                                                                                       |
| disabled           | string | Ne         | Ne              | Požymis ar pareigybė yra neaktyvi (true – neaktyvi, false – aktyvi)                                                                                                |

---

## 21. „TrackingInfo“ – istorijos elementas

- Namespace: <http://www.sintagma.lt/avilys/DocumentWS>
- Pavadinimas: TrackingInfo

### 22. „TrackingInfo“ laukų sąrašas

| Pavadinimas     | Tipas                                   | Privalomas | Pasikartojantis | Aprašymas                                                                            |
| --------------- | --------------------------------------- | ---------- | --------------- | ------------------------------------------------------------------------------------ |
| orgStaff        | OrgStaff                                | Taip       | Ne              | Veiksmą atlikusio asmens pareigos (žr. Lentelė 115. „OrgStaff“ esybės laukų sąrašas) |
| oid             | string                                  | Taip       | Ne              | Identifikatorius                                                                     |
| whenForSchema   | string                                  | Taip       | Ne              | Įrašo data                                                                           |
| what            | string                                  | Taip       | Ne              | Atlikto veiksmo aprašymas                                                            |
| eventAttributes | Lentelė 2. Esybės „Map“ laukų aprašymas | Ne         | Ne              | Istorijos įrašo specifinių duomenų sąrašas                                           |

---

## 23. „AttachmentActionParam“ – veiksmas su dokumento priedu

- Namespace: <http://www.sintagma.lt/avilys/DocumentWS>
- Pavadinimas: AttachmentActionParam
- Pridedamas, keičiamas ar šalinamas dokumento priedas (rinkmenos turinys bei metaduomenys).

### 24. „AttachmentActionParam“ laukų sąrašas

| Pavadinimas  | Tipas                        | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             |
| ------------ | ---------------------------- | ---------- | --------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| type         | string                       | Ne         | Ne              | Dokumento priedo tipas. Galimos reikšmės:     - **clsDHSAttaType.MAIN** - Dokumento turinys ir jo priedai; - **clsDHSAttaType.MAINONLY** - Dokumento turinys (be priedų); - **clsDHSAttaType.SUPP** - Priedo turinys; - **clsDHSAttaType.ADOC** - Pridedamas el. dokumentas.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          |
| action       | enum                         | Taip       | Ne              | Veiksmas. Galimos reikšmės: (*add, modify, replace, remove, nothing*)     - **add** – priedo pridėjimas. Privaloma užpildyti laukus: *type, title, content, contentType*. Priedo pavadinimas *title* turi būti unikalus; - **modify** – priedo turinio ir metaduomenų keitimas. Privaloma užpildyti laukus: *title, content, contentType*. Keičiamas priedas identifikuojamas pagal *oid* (jei nurodytas) arba *title*. Versijuojamiems priedams nurodyti tik *title*. Priedų pavadinimai turi būti unikalūs. Priedas su nurodytu *oid* ar *title* turi egzistuoti dokumente; - **replace** – priedo keitimas. Keičiamas priedas identifikuojamas pagal *title*. Privaloma užpildyti laukus: *type, title, content, contentType*. Priedų pavadinimai turi būti unikalūs. Jei priedas nurodytu *title* nebus rastas – priedas bus pridėtas kaip naujas; - **remove** – priedo trynimas. Trinamas priedas identifikuojamas pagal *oid* arba pagal *title* (jei oid nenurodytas). Versijuojamiems priedams nurodyti tik pavadinimą *title* (bendru atveju naudoti *title*). - **nothing** – priedo perkėlimas į nurodytą sąrašo vietą (kai užpildytas laukas *position*) nieko daugiau nekeičiant. Trinamas priedas identifikuojamas pagal *oid* arba pagal *title* (jei oid nenurodytas). Versijuojamiems priedams nurodyti tik pavadinimą *title* (bendru atveju naudoti *title*). - **Pastaba:** identifikuojant priedus pagal *title*, naudojamas priedo *title* su plėtiniu, išskaičiuotu pagal *contentType*, todėl svarbu keičiant priedą teisingai nurodyti ir jo *contentType*. |
| title        | string                       | Taip       | Ne              | Priedo pavadinimas. Priedu pavadinimai turi būti unikalūs. Leidžiama ne ilgesnė nei 80 simbolių reikšmė                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               |
| content      | base64binary                 | Ne         | Ne              | Priedo turinys. Techniškai turinys bus perduodamas naudojant MTOM išplėtimą, naudojant *application/octet-stream content type*.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       |
| contentType  | string                       | Ne         | Ne              | Turinio MIME tipas                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    |
| oid          | string                       | Ne         | Ne              | Priedo identifikatorius. Identifikatoriaus reikšmė keičiasi automatiškai kviečiant *modifyDocument*. Versijuojamiems priedams, po dokumento modifikavimo *(„Check In/Check Out“)* sukuriamos jų naujos versijos su naujais identifikatoriais.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         |
| position     | integer                      | Ne         | Ne              | Vieta, į kurią perkeliamas priedas dokumento priedų sąraše, skaičiuojant nuo 0. Tai vieta į kurią reikia perkelti priedą veiksmo su priedu vykdymo metu (veiksmai vykdomi veiksmų surašymo tvarka). Pavyzdžiui, jei kuriant fokumentą visiems priedų pridėjimo veiksmams bus nurodyta vieta 0, priedai sąraše bus surikiuoti atvirkštine tvarka. Jei lauko reikšmė nenurodyta, dokumente esančių priedų tvarka nekeičima, nauji priedai pridedamai į sąrašo pabaigą.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  |
| customFields | Esybės „Map“ laukų aprašymas | Taip       | Ne              | Galimos reikšmės priklauso nuo sisteminės konfigūracijos                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              |
| comments     | string                       | Ne         | Ne              | *(parametras nenaudojamas)*                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           |
| Fillable     | Boolean                      | Ne         | Ne              | Požymis, nusakantis, ar dokumento turinys turi būti užpildytas, ar išlaikomas kaip pateikstas. Nenurodžius – laikoma, kad pildomas.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   |

---

## 25. „TemplateParam“ - dokumento šablono parametras

- Namespace: <http://www.sintagma.lt/avilys/DocumentWS>
- Pavadinimas: TemplateParam arba TemplateNameParam
- Esybė, kuri naudojama nurodyti (identifikuoti) dokumento šabloną iškviečiant operaciją. Galima pateikti TemplateParam, nurodant šablono oid.
- TemplateParam esybės struktūra:

### 26. Esybės „TemplateParam“ laukų sąrašas

| Pavadinimas | Tipas  | Privalomas | Pasikartojantis | Aprašymas                                   |
| ----------- | ------ | ---------- | --------------- | ------------------------------------------- |
| oid         | string | Taip       | Ne              | Dokumento šablono unikalus identifikatorius |

---

## 27. „TemplateNameParam“ - dokumento šablono parametras

- Namespace: <http://www.sintagma.lt/avilys/DocumentWS>
- Pavadinimas: TemplateNameParam
- Esybė, kuri naudojama nurodyti (identifikuoti) dokumento šabloną iškviečiant operaciją. Galima pateikti arba TemplateParam (nurodant šablono oid; papildoma informacija pateikiama Priedas nr.2), arba TemplateNameParam (nurodant šablono pavadinimą bei įstaigos savininkės orgName atributus.
- TemplateNameParam esybės paveldi esybę TemplateParam. TemplateNameParam struktūra:

### 28. „TemplateNameParam“ laukų sąrašas

Paveldi viską iš „TemplateParam“ žr.: Lentelė 16. Esybės „TemplateParam“ laukų sąrašas

| Pavadinimas  | Tipas  | Privalomas | Pasikartojantis | Aprašymas                                                             |
| ------------ | ------ | ---------- | --------------- | --------------------------------------------------------------------- |
| title        | string | Taip       | Ne              | Šablono pilnas, tikslus pavadinimas                                   |
| ownerOrgName | string | Taip       | Ne              | Įstaigos lygio padalinio orgName atributas, kuriam priklauso šablonas |

---

## 29. „ClsEntryParam“ – klasifikatoriaus įrašas

- Namespace: <http://www.sintagma.lt/avilys/ClassifierWS>
- Pavadinimas: ClsEntryParam
- Klasifikatoriaus įrašo duomenys, pateikiami per sąsają į DBSIS. Gali būti pateikiama arba ClsEntryParam, arba ClsEntryKeyParam, arba ClsEntryDocAttrCodeParam tipo esybė.
- ClsEntryParam esybės struktūra pateikta žemiau esančioje lentelėje:

### 30. „ClsEntryParam“ laukų sąrašas

| Pavadinimas | Tipas  | Privalomas | Pasikartojantis | Aprašymas                       |
| ----------- | ------ | ---------- | --------------- | ------------------------------- |
| clsid       | string | Taip       | Ne              | Įrašo unikalus identifikatorius |

---

## 31. „ClsEntryDocAttrCodeParam“ – klasifikatoriaus įrašas

- Namespace: <http://www.sintagma.lt/avilys/ClassifierWS>
- Pavadinimas: ClsEntryDocAttrCodeParam
- Klasifikatoriaus reikšmė nustatoma pagal lauką „key“ ir dokumento atributą. Dokumento atributas privalo būti Klasifikatoriaus tipo. Iš dokumento atributo išsprendžiame klasifikatoriaus klasę. ClsEntryDocAttrCodeParam esybės struktūra pateikta žemiau esančioje lentelėje:

### 32. „ClsEntryDocAttrCodeParam“ laukų sąrašas

Paveldi viską iš „ClsEntryParam“ žr.: Lentelė 18. Esybės „ClsEntryParam“ laukų sąrašas

| Pavadinimas | Tipas  | Privalomas | Pasikartojantis | Aprašymas                                             |
| ----------- | ------ | ---------- | --------------- | ----------------------------------------------------- |
| key         | string | Taip       | Ne              | Įrašo raktas (unikalus vieno klasifikatoriaus ribose) |

---

## 33. „ClsEntry“ – klasifikatoriaus įrašas

- Namespace: <http://www.sintagma.lt/avilys/ClassifierWS>
- Pavadinimas: ClsEntry
- Klasifikatoriaus įrašo duomenys. Struktūra pateikta žemiau esančioje lentelėje:

### 34. „ClsEntry“ laukų sąrašas

| Pavadinimas  | Tipas                                            | Privalomas | Pasikartojantis | Aprašymas                                                                                     |
| ------------ | ------------------------------------------------ | ---------- | --------------- | --------------------------------------------------------------------------------------------- |
| clsid        | string                                           | Taip       | Ne              | Unikalus klasifikatoriaus įrašo ID                                                            |
| className    | string                                           | Taip       | Ne              | Klasifikatoriaus kodas, kuriam priklauso įrašas                                               |
| key          | string                                           | Ne         | Ne              | Klasifikatoriaus įrašo kodas                                                                  |
| displayValue | I18nString                                       | Taip       | Ne              | Klasifikatoriaus pavadinimas (įvairiomis kalbomis)                                            |
| parent       | Lentelė 18. Esybės „ClsEntryParam“ laukų sąrašas | Ne         | Ne              | Tėvinis klasifikatoriaus įrašas (jei klasifikatorius hierarchinis, kitu atveju nepateikiamas) |
| children     | Lentelė 18. Esybės „ClsEntryParam“ laukų sąrašas | Ne         | Taip            | Sąrašas vaikinių klasifikatoriaus įrašų                                                       |

---

## 35. „DocumentSortBean“ – dokumento rūšis

- Namespace: <http://www.sintagma.lt/avilys/DocumentWS>
- Pavadinimas: DocumentSortBean
- Dokumentų rūšies duomenys. Struktūra pateikta žemiau esančioje lentelėje:

### 36. „DocumentSortBean“ laukų sąrašas

| Pavadinimas | Tipas    | Privalomas | Pasikartojantis | Aprašymas                                     |
| ----------- | -------- | ---------- | --------------- | --------------------------------------------- |
| oid         | string   | Taip       | Ne              | Unikalus rūšies ID                            |
| title       | ClsEntry | Taip       | Ne              | Dokumento rūšies pavadinimas. Klasifikatorius |
| itemType    | ClsEntry | Taip       | Ne              | Dokumento tipas. Klasifikatorius              |
| isLegalAct  | boolean  | Taip       | Ne              | Teisės akto požymis                           |
| isDisabled  | boolean  | Taip       | Ne              | Neaktyvios rūšies požymis                     |

---

## 37. „GetDocumentResult“ – grąžinama universali dokumento informacija

- Namespace: <http://www.sintagma.lt/avilys/DocumentWS>
- Pavadinimas: GetDocumentResult
- Esybėje „GetDocumentResult“ grąžinama įvairių tipų dokumentų informacija. Tai gali būti tiek dokumentai, tiek ir, pvz., užduotys, posėdžiai ir kitokios esybės. Kokia konkrečiai esybė bus grąžinama priklauso nuo kviečiamos operacijos semantikos.
- „GetDocumentResult“ esybę sudaro dinaminis sąrašas atributų („Map tipo struktūra“) konkretūs atributų pavadinimai priklauso nuo to, kokio tipo dokumentas grąžinamas ir kaip sukonfigūruotas DBSIS.
- Žemiau pateikti esybės „GetDocumentResult“ laukai.

### 38. „GetDocumentResult“ laukų aprašymas

| Pavadinimas      | Tipas                                                     | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                      |
| ---------------- | --------------------------------------------------------- | ---------- | --------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| docOid           | string                                                    | Taip       | Ne              | Unikalus dokumento identifikatorius                                                                                                                                                            |
| docCategory      | string                                                    | Ne         | Ne              | Dokumento kategorija, nusakanti, kokio tipo dokumentas grąžinamas. Kai kuriems dokumentų tipams šis laukas gali būti grąžinamas tuščias.                                                       |
| version          | DocumentVersionType                                       | Ne         | Ne              | Dokumento versijos informacija. Grąžinama tik versijuojamiems dokumentų tipams (žr.: Lentelė 23. Esybės „DocumentVersionType“ laukų aprašymas).                                                |
| docAttributes    | Lentelė 2. Esybės „Map“ laukų aprašymas                   | Taip       | Ne              | Dokumento metaduomenų sąrašas. Minimalus galimų reikšmių sąrašas pateiktas žemiau esančioje lentelėje. Galimos papildomos reikšmės, jei tai sukonfigūruota DBSIS sistemoje.                    |
| processTasks     | Lentelė 2-2-202. Esybės „GetProcessTasks“ laukų aprašymas | Ne         | Ne              | Dokumento esamų ir atliktų proceso uždavinių sąrašas                                                                                                                                           |
| bodyAttachment   | Attachment                                                | Ne         | Taip            | Dokumento arba jo priedo rinkmena. Galima nurodyti kelias.   Konkretus tipas priklauso nuo parametro „retrieveAttachment“ reikšmės.  Niekada negrąžinamas, kai pateikiami paieškos rezultatai. |
| electroContainer | string                                                    | Ne         | Ne              | Dokumento elektroninė pakuotė.  Konkretus tipas priklauso nuo parametro„retrieveElectroContainer“ reikšmės.  Niekada negrąžinamas, kai pateikiami paieškos rezultatai.                         |

---

## 39. „DocumentVersionType“

### 40. „DocumentVersionType“ laukų aprašymas

| Pavadinimas | Tipas | Privalomas | Pasikartojantis | Aprašymas                    |
| ----------- | ----- | ---------- | --------------- | ---------------------------- |
| major       | int   | Taip       | Ne              | Pagrindinis versijos numeris |
| minor       | int   | Taip       | Ne              | Juodraščio versijos numeris  |

---

## 41. „DocumentInfo“ – grąžinama glausta dokumento informacija

- Namespace: <http://www.sintagma.lt/avilys/DocumentWS>
- Pavadinimas: DocumentInfo
- Šia esybe grąžinama glausta informacija apie dokumentą, kai buvo atliktas veiksmas su juo. Esybės laukų sąrašas pateiktas žemiau esančioje lentelėje:

### 42. „DocumentInfo“ esybės laukų aprašymas

| Pavadinimas      | Tipas  | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                |
| ---------------- | ------ | ---------- | --------------- | ---------------------------------------------------------------------------------------------------------------------------------------- |
| docOid           | string | Taip       | Ne              | Unikalus dokumento identifikatorius                                                                                                      |
| registrationNo   | string | Ne         | Ne              | Dokumento registracijos numeris. Grąžinamas tik registruotiems (RDO) dokumentams ir tik tuomet, kai jie jį turi.                         |
| registrationDate | date   | Ne         | Ne              | Dokumento registracijos data. Grąžinama tik registruotiems (RDO) dokumentams ir tik tuomet, kai jie jį turi.                             |
| docCategory      | string | Ne         | Ne              | Dokumento kategorija, nusakanti, kokio tipo dokumentas grąžinamas. Kai kuriems dokumentų tipams šis laukas gali būti grąžinamas tuščias. |

---

## 43. „DateRangeParam“ – datų intervalas

- Namespace: <http://www.sintagma.lt/avilys/DocumentWS>
- Pavadinimas: DateRangeParam
- Esybė, skirta perduoti datų intervalui (nuo, iki). Esybės atributai pateikti žemiau esančioje lentelėje.

### 44. Esybės „DateRangeParam“ laukų sąrašas

| Pavadinimas | Tipas | Privalomas | Pasikartojantis | Aprašymas |
| ----------- | ----- | ---------- | --------------- | --------- |
| fromDate    | date  | Ne         | Ne              | Data nuo  |
| toDate      | date  | Ne         | Ne              | Data iki  |

---

## 45. „DocumentExpandType“

- Namespace: <http://www.sintagma.lt/avilys/DocumentWS>
- Pavadinimas: DocumentExpandType
- Esybė, skirta perduoti pavadinimams tų atributų, kurių detalią informaciją norima gauti.
- Užklausiant sąrašų, rastuose elementuose (dokumentuose) bus užpildomi tie atributai, kurių pavadinimai nurodyti šiame objekte. Jei pavadinimas nurodytas su „+“ gale, bus pateikiama pilna atributo informacija, kitu atveju bus pateikiamas tik atributo ID arba primityvi reikšmė.
- Užklausiant vieno dokumento, bus pateikiama pilna informacija („išskleidžiamas“ atributas) apie tuos jo atributus, kurių pavadinimai išvardinti šiame objekte. Neišvardintų atributų bus pateikiama tik ID ar primityvi reikšmė. Speciali reikšmė „all“ reiškia, kad išskleisti (pateikti detalią informaciją) visiems atributams.

Pastaba: įjungus konfigūracijos nustatymą „WS\_GSORGNODE\_EXPANDING\_COMPATIBILITY“, OrgNode tipo atributai, jei užpildomi, tai pateikiami visada su pilna informacija.

### 46. „DocumentExpandType“ laukų sąrašas

| Pavadinimas | Tipas  | Privalomas | Pasikartojantis | Aprašymas                                                                       |
| ----------- | ------ | ---------- | --------------- | ------------------------------------------------------------------------------- |
| entry       | string | Taip       | Taip            | Atributų pavadinimai kuriuos reikia išskleisti (rodyti detalia jų informaciją). |

Galimi atributų pavadinimai priklauso nuo dokumento tipo. Konkrečiam dokumento tipui atributų pavadinimai sutampa su pavadinimais, kurių sąrašas nurodomas prie to tipo dokumento „getDocument()“ operacijos.

---

## 47. „OrgNodeListParam“ – organizacinės struktūros parametras

- Namespace: <http://www.sintagma.lt/avilys/OrgStructWS>
- Pavadinimas: OrgNodeListParam
- Ši esybė skirta perduoti į DBSIS informaciją, kuria sudaro OrgNodeParam esybių sąrašas. Esybė nenaudojama duomenų pateikimui iš DBSIS.

### 48. Struktūros laukų sąrašas

| Pavadinimas | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                                              |
| ----------- | ------------ | ---------- | --------------- | ---------------------------------------------------------------------- |
| orgNode     | OrgNodeParam | Ne         | Taip            | OrgNodeParam esybių sąrašas (žr.: Esybės „OrgNodeParam“ laukų sąrašas) |

---

## 49. „AttachmentReference“ – prisegto failo identifikacinis numeris

- Namespace: <http://www.sintagma.lt/avilys/DocumentWS>
- Pavadinimas: AttachmentReference
- Skirta pateikti DBSIS saugomo dokumento priedo identifikatorių.

### 50. „AttachmentReference“ laukų sąrašas

| Pavadinimas | Tipas  | Privalomas | Pasikartojantis | Aprašymas                              |
| ----------- | ------ | ---------- | --------------- | -------------------------------------- |
| oid         | string | Taip       | Ne              | Prisegto failo identifikacinis numeris |

---

## 51. „AttachmentBase“ – prisegto failo informacija

- Namespace: <http://www.sintagma.lt/avilys/DocumentWS>
- Pavadinimas: AttachmentBase
- Skirta pateikti DBSIS saugomo dokumento metaduomenis.

### 52. „AttachmentBase“ laukų sąrašas

Paveldi viską iš „AttachmentReference“ žr.: Lentelė 28. Esybės „AttachmentReference“ laukų sąrašas

| Pavadinimas     | Tipas                                            | Privalomas | Pasikartojantis | Aprašymas                                                                                                                   |
| --------------- | ------------------------------------------------ | ---------- | --------------- | --------------------------------------------------------------------------------------------------------------------------- |
| title           | string                                           | Taip       | Ne              | Pavadinimas                                                                                                                 |
| contentType     | string                                           | Taip       | Ne              | Tipas                                                                                                                       |
| type            | Lentelė 18. Esybės „ClsEntryParam“ laukų sąrašas | Taip       | Ne              | Dokumento priedo tipas.                                                                                                     |
| author          | OrgNode                                          | Ne         | Ne              | Autorius (žr.: Esybės „OrgNodeParam“ laukų sąrašas)                                                                         |
| dateCreated     | string                                           | Ne         | Ne              | Sukūrimo data sistemoje                                                                                                     |
| dateCreatedReal | string                                           | Ne         | Ne              | Bylos sukūrimo data                                                                                                         |
| customFields    | string                                           | Taip       | Ne              | Paskutinio pakeitimo data                                                                                                   |
| electroData     | string                                           | Ne         | Ne              | Papildoma informacija, jei rinkmena yra elektroninio dkoumento pakuotė (žr. Lentelė 31. Esybės „ElectroData“ laukų sąrašas) |

---

## 53. „Attachment“ – prisegtas failas

- Namespace: <http://www.sintagma.lt/avilys/DocumentWS>
- Pavadinimas: Attachment
- Skirta pateikti DBSIS saugomo dokumento metaduomenis bei turinį.

### 54. „Attachment“ laukų sąrašas

Paveldi viską iš „AttachmentBase“ žr.: Lentelė 29. Esybės „AttachmentBase“ laukų sąrašas

| Pavadinimas | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                                                                                                       |
| ----------- | ------------ | ---------- | --------------- | ------------------------------------------------------------------------------------------------------------------------------- |
| Content     | base64Binary | Taip       | Ne              | Priedo turinys. Techniškai turinys bus perduodamas naudojant MTOM išplėtimą, naudojant *application/octet-stream* content type. |

---

## 55. „ElectroData“ – prisegto elektroninio dokumento pakuotės informacija

- Namespace: <http://www.sintagma.lt/avilys/DocumentWS>
- Pavadinimas: ElectroData
- Skirta pateikti papildomą informaciją apie DBSIS saugomą prisegtą failą, jei jis yra elektroninio dokumento pakuotė.

### 56. „ElectroData“ laukų sąrašas

| Pavadinimas | Tipas          | Privalomas | Pasikartojantis | Aprašymas                                                                                                                |
| ----------- | -------------- | ---------- | --------------- | ------------------------------------------------------------------------------------------------------------------------ |
| content     | ElectroContent | Taip       | Ne              | Prisegto elektroninio dokumento pakuotės struktūros informacija. (žr. Lentelė 32. Esybės „ElectroContent“ laukų sąrašas) |

---

## 57. „ElectroContent“ – prisegto elektroninio dokumento pakuotės struktūros informacija

- Namespace: <http://www.sintagma.lt/avilys/DocumentWS>
- Pavadinimas: ElectroContent
- Skirta pateikti informaciją apie DBSIS saugomą elektroninio dokumento pakuotę sudarančius failus.

### 58. „ElectroContent“ laukų sąrašas

| Pavadinimas  | Tipas               | Privalomas | Pasikartojantis | Aprašymas                                                                                           |
| ------------ | ------------------- | ---------- | --------------- | --------------------------------------------------------------------------------------------------- |
| mainDocument | ElectroContentEntry | Taip       | Ne              | Pagrindinio turinio failo informacija. (žr. Lentelė 33. Esybės „ElectroContentEntry“ laukų sąrašas) |
| appendix     | ElectroContentEntry | Ne         | Taip            | Priedo turinio failo informacija.                                                                   |
| attachment   | ElectroContentEntry | Ne         | Taip            | Prisegto elektroninio dokumento turinio failo informacija.                                          |

---

## 59. „ElectroContentEntry“ – prisegto elektroninio dokumento pakuotės struktūros įrašas

- Namespace: <http://www.sintagma.lt/avilys/DocumentWS>
- Pavadinimas: ElectroContentEntry
- Skirta pateikti informaciją apie vieną failą, priklausantį DBSIS saugomai elektroninio dokumento pakuotei.

### 60. „ElectroContentEntry“ laukų sąrašas

| Pavadinimas | Tipas  | Privalomas | Pasikartojantis | Aprašymas                                                         |
| ----------- | ------ | ---------- | --------------- | ----------------------------------------------------------------- |
| name        | string | Taip       | Ne              | Pakuotei priklausančio failo pavadinimas                          |
| mediaType   | string | Taip       | Ne              | Pakuotei priklausančio failo MIME tipas                           |
| path        | string | Taip       | Ne              | Pakuotei priklausančio failo kelias pakuotės viduje               |
| parentPath  | string | Ne         | Ne              | Pakuotei priklausančio failo tėvinio failo kelias pakuotės viduje |

---

## 61. „DocVersionReference“ prisegtas failas

- Namespace: <http://www.sintagma.lt/avilys/DocumentWS>
- Pavadinimas: DocVersionReference
- Skirta pateikti nuorodą į DBSIS saugomo dokumento versiją. Pateikiami dokumento bei jo versijos OID.

### 62. „DocVersionReference“ laukų sąrašas

| Pavadinimas      | Tipas  | Privalomas | Pasikartojantis | Aprašymas                                    |
| ---------------- | ------ | ---------- | --------------- | -------------------------------------------- |
| refDocOid        | string | Taip       | Ne              | Dokumento, į kurį rodo nuoroda, OID          |
| refDocVersionOid | string | Taip       | Ne              | Dokumento, į kurį rodo nuoroda, versijos OID |

---

## 63. „OfficeCaseParam“ – dokumento byla

- Namespace: <http://www.sintagma.lt/avilys/OfficeCaseWS>
- Pavadinimas: OfficeCaseParam
- Skirta pateikti DBSIS bylos duomenis.

### 64. „OfficeCaseParam“ laukų sąrašas

| Pavadinimas | Tipas  | Privalomas | Pasikartojantis | Aprašymas        |
| ----------- | ------ | ---------- | --------------- | ---------------- |
| oid         | string | Taip       | Ne              | Identifikatorius |

---

## 65. „OfficeCaseListParam“ – dokumento bylų sąrašo elementas

- Namespace: <http://www.sintagma.lt/avilys/OfficeCaseWS>
- Pavadinimas: OfficeCaseListParam
- Ši esybė skirta perduoti į DBSIS informaciją, kurią sudaro OfficeCaseParam esybių sąrašas.

### 66. „OfficeCaseListParam“ laukų sąrašas

| Pavadinimas | Tipas           | Privalomas | Pasikartojantis | Aprašymas                                                                                |
| ----------- | --------------- | ---------- | --------------- | ---------------------------------------------------------------------------------------- |
| officeCases | OfficeCaseParam | Taip       | Taip            | OfficeCaseParam esybių sąrašas. (žr.:Lentelė 35. Esybės „OfficeCaseParam“ laukų sąrašas) |

---

## 67. Esybė „JournalParam“ – dokumento registras

- Namespace: <http://www.sintagma.lt/avilys/JournalWS>
- Pavadinimas: JournalParam
- Skirta pateikti DBSIS registro duomenis.

### 68. „JournalParam“ laukų sąrašas

| Pavadinimas | Tipas  | Privalomas | Pasikartojantis | Aprašymas        |
| ----------- | ------ | ---------- | --------------- | ---------------- |
| oid         | string | Taip       | Ne              | Identifikatorius |

---

## 69. „ExternalActionInfo“ – informacija apie išorinius veiksmus

- Namespace: <http://www.sintagma.lt/avilys/DocumentWS>
- Pavadinimas: ExternalActionInfo
- Skirta pateikti DBSIS informaciją apie išorinius veiksmus.

### 70. „ExternalActionInfo“ laukų sąrašas

| Pavadinimas | Tipas                   | Privalomas | Pasikartojantis | Aprašymas                                                                |
| ----------- | ----------------------- | ---------- | --------------- | ------------------------------------------------------------------------ |
| entry       | ExternalActionInfoEntry | Ne         | Taip            | Informacija apie vieną išorinį veiksmą (pasirašymą, derinimą ir pan...). |

---

## 71. „ExternalActionInfoEntry“ – informacija apie vieną išorinį veiksmą

- Namespace: <http://www.sintagma.lt/avilys/DocumentWS>
- Pavadinimas: ExternalActionInfo
- Skirta pateikti DBSIS informacija apie vieną išorinį veiksmą (pasirašymą, derinimą ir pan...).

### 72. „ExternalActionInfoEntry“ laukų sąrašas

| Pavadinimas | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                         |
| ----------- | ------------ | ---------- | --------------- | ------------------------------------------------------------------------------------------------------------------------------------------------- |
| actor       | OrgNodeParam | Taip       | Ne              | Veiksmą atlikęs asmuo. Turi būti išorinis kontaktas (asmuo).   OrgNodeParam esybių sąrašas (žr.: Esybės „OrgNodeParam“ laukų sąrašas)             |
| actionDate  | date         | Taip       | Ne              | Veiksmo atlikimo data                                                                                                                             |
| done        | boolean      | Ne         | Ne              | Ar veiksmas atliktas (jei nenurodyta – taip). Parametras, skirtas atsisakymo atlikti veiksmą (pvz.: atsisakymo pasirašyti) informacijai perduoti. |
| notes       | string       | Ne         | Ne              | Veiksmą atlikusio asmens pastabos / komentarai.                                                                                                   |

---

## 73. „ClsEntryListParam“ – klasifikatorių sąrašas

- Namespace: <http://www.sintagma.lt/avilys/ClassifierWS>
- Pavadinimas: ClsEntryListParam
- Ši esybė skirta perduoti į DBSIS informaciją, kurią sudaro ClsEntryParam esybių sąrašas. Esybė nenaudojama duomenų pateikimui iš DBSIS.

### 74. „ClsEntryListParam“ laukų sąrašas

| Pavadinimas | Tipas         | Privalomas | Pasikartojantis | Aprašymas                                                                            |
| ----------- | ------------- | ---------- | --------------- | ------------------------------------------------------------------------------------ |
| clsEntry    | ClsEntryParam | Ne         | Taip            | ClsEntryParam esybių sąrašas (žr.: Lentelė 18. Esybės „ClsEntryParam“ laukų sąrašas) |

---

## 74. „BaseParam“ – bazinė WS operacijų parametro esybė

- Namespace: <http://www.sintagma.lt/avilys/DocumentWS>
- Pavadinimas: BaseParam
- Ši esybė yra bazinė esybėms, kurios paduodamos kaip pagrindinis parametras daugumai WS operacijų. Pagrindinė paskirtis – galimybė nurodyti, kurios pareigybės vardu ir teisėmis atliekama WS operacija.

### 75. „BaseParam“ laukų sąrašas

| Pavadinimas | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                                                                                                                                                                                                            |
| ----------- | ------------ | ---------- | --------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| targetStaff | OrgNodeParam | Ne         | Ne              | Nurodoma pareigybė, už kurią veiksmus atlikti. Jei ji nurodoma, DBSIS persijungs nurodyta pareigybe prieš vykdydamas veiksmą. Nurodyta pareigybė gali priklausyti tiek vidinei struktūrai, tiek išoriniam kontaktui.   Jei nurodyta pareigybė priklauso vidinei struktūrai, tikrinama, ar autentifikuotas naudotojas turi teisę persijungti nurodyta pareigybe (t. y. dirbti už ją). |

---

## 76. „HistoricalName“ – istorinio pavadinimo informacija

- Namespace: <http://www.sintagma.lt/avilys/OrgStructWS>
- Pavadinimas: HistoricalName
- Ši esybė skirta atvaizduoti istoriniams pavadinimams prie OrgNode esybės.

### 77. „HistoricalName“ laukų aprašymas

| Pavadinimas  | Tipas    | Privalomas | Pasikartojantis | Aprašymas                                    |
| ------------ | -------- | ---------- | --------------- | -------------------------------------------- |
| id           | String   | Ne         | Ne              | Istorinio pavadinimo identifikatorius        |
| officialName | String   | Ne         | Ne              | Istorinis pavadinimas                        |
| shortName    | String   | Ne         | Ne              | Istorinio pavadinimo trumpas pavadinimas     |
| validFrom    | dateTime | Ne         | Ne              | Istorinio pavadinimo galiojimo pradžios data |
| validUntil   | dateTime | Ne         | Ne              | Istorinio pavadinimo galiojimo pabaigos data |

---

### 78. „UserParam“ – vartotojo informacija

- Namespace: <http://www.sintagma.lt/avilys/OrgStructWS>
- Pavadinimas: UserParam
- Ši esybė skirta atvaizduoti vartotojo duomenims. Vienu metu gali būti naudojamas tik vienas esybės iš laukų.

## 79. „UserParam“ laukų aprašymas

| Pavadinimas | Tipas  | Privalomas | Pasikartojantis | Aprašymas           |
| ----------- | ------ | ---------- | --------------- | ------------------- |
| uaName      | string | Ne         | Ne              | Identifikatorius    |
| account     | string | Ne         | Ne              | Prisijungimo vardas |

---

## 80. „GetStaffForUserExtendedResult“ – pareigybių rinkinys

- Namespace: <http://www.sintagma.lt/avilys/OrgStructWS>
- Pavadinimas: GetStaffForUserExtendedResult
- Ši esybė skirta atvaizduoti pareigybes.

### 81. „GetStaffForUserExtendedResult“ laukų aprašymas

| Pavadinimas       | Tipas    | Privalomas | Pasikartojantis | Aprašymas            |
| ----------------- | -------- | ---------- | --------------- | -------------------- |
| orgStaffSet       | orgStaff | Ne         | Ne              | Pareigybių rinkinys  |
| prefferedOrgStaff | Set      | Ne         | Taip            | Pagrindinė pareigybė |

---

## 82. „SubstDocumentInfo“ – grąžinama glausta pavadavimo informacija

- Namespace: <http://www.sintagma.lt/avilys/SubstDocumentWS>
- Pavadinimas: SubstDocumentInfo
- Šia esybe grąžinama glausta informacija apie pavadavimą, kai buvo atliktas veiksmas su juo. Esybės laukų sąrašas pateiktas žemiau esančioje lentelėje:

### 83. „SubstDocumentInfo“ esybės laukų aprašymas

| Pavadinimas | Tipas  | Privalomas | Pasikartojantis | Aprašymas                            |
| ----------- | ------ | ---------- | --------------- | ------------------------------------ |
| docOid      | string | Taip       | Ne              | Unikalus pavadavimo identifikatorius |
| creationNo  | string | Ne         | Ne              | Pavadavimo numeris                   |
| createdDate | date   | Ne         | Ne              | Pavadavimo sukūrimo data             |

---

## 84. „CdoContractorParam“ – sutarties šalies parametras

- Namespace: <http://www.sintagma.lt/avilys/OrgStructWS>
- Pavadinimas: CdoContractorParam
- Sutarties šalies įrašo duomenys, pateikiami į DBSIS.
- CdoContractorParam esybės struktūra pateikta žemiau esančioje lentelėje.

### 85. „CdoContractorParam“ laukų sąrašas

| Pavadinimas | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                                  |
| ----------- | ------------ | ---------- | --------------- | ---------------------------------------------------------- |
| orgNode     | OrgNodeParam | Taip       | Ne              | Sutarties šalis (žr. Esybės „OrgNodeParam“ laukų sąrašas ) |
| comment     | string       | Ne         | Ne              | Komentaras                                                 |

---

## 86. „CdoContractorListParam“ – sutarčių šalių parametras

- Namespace: <http://www.sintagma.lt/avilys/OrgStructWS>
- Pavadinimas: CdoContractorListParam
- Ši esybė skirta perduoti į DBSIS informaciją, kurią sudaro CdoContractorParam esybių sąrašas.

### 87. „CdoContractorListParam“ laukų sąrašas

| Pavadinimas | Tipas              | Privalomas | Pasikartojantis | Aprašymas                                                                            |
| ----------- | ------------------ | ---------- | --------------- | ------------------------------------------------------------------------------------ |
| contractors | CdoContractorParam | Ne         | Taip            | CdoContractorParam esybių sąrašas (žr.:Lentelė 46. Esybės „CdoContractorParam“ laukų |

---

## 88. „SendingType“ – gavėjo (pristatymo būdo) elementas

- Namespace:<http://www.sintagma.lt/avilys/DocumentWS>
- Pavadinimas: SendingType
- Gavėjo (pristatymo būdo) duomenys. Struktūra pateikta žemiau esančioje lentelėje:

### 89. „SendingType“ laukų sąrašas

| Pavadinimas    | Tipas    | Privalomas | Pasikartojantis | Aprašymas               |
| -------------- | -------- | ---------- | --------------- | ----------------------- |
| receiver       | OrgNode  | Taip       | Ne              | Gavėjo informacija      |
| sendingDate    | date     | Ne         | Ne              | Siuntimo data           |
| wayOfReception | ClsEntry | Taip       | Taip            | Sąrašas išsiuntimo būdų |

---

## 90. „OfficeCaseListParam“ – dokumento bylų sąrašo elementas

- Namespace: <http://www.sintagma.lt/avilys/OfficeCaseWS>
- Pavadinimas: OfficeCaseListParam
- Ši esybė skirta perduoti į DBSIS informaciją, kurią sudaro OfficeCaseParam esybių sąrašas.

### 91. „OfficeCaseListParam“ laukų sąrašas

| Pavadinimas | Tipas           | Privalomas | Pasikartojantis | Aprašymas                                                                                |
| ----------- | --------------- | ---------- | --------------- | ---------------------------------------------------------------------------------------- |
| officeCases | OfficeCaseParam | Taip       | Taip            | OfficeCaseParam esybių sąrašas. (žr.:Lentelė 35. Esybės „OfficeCaseParam“ laukų sąrašas) |
