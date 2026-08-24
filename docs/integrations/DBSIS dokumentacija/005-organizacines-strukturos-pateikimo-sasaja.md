# Organizacinės struktūros pateikimo sąsaja

- Path: `/api-dok/dbsis-api/duomenu-strukturos/organizacines-strukturos-pateikimo-sasaja`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/duomenu-strukturos/organizacines-strukturos-pateikimo-sasaja
- Index: 5

---

Organizacinės struktūros pateikimo sąsaja („OrgStructWS“)

## Apibendrinimas

- Sąsaja pateikiama SOAP protokolu.
- Sąsajos pavadinimas: OrgStructWS

---

## 1. „User“

- Esybė, skirta perduoti vieno naudotojo informacijai. Esybės atributai pateikti žemiau esančioje lentelėje.

### 2. „User“ esybės laukų sąrašas

| Pavadinimas    | Tipas  | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                                  |
| -------------- | ------ | ---------- | --------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| uaName         | string | Taip       | Ne              | Identifikatorius                                                                                                                                                                                           |
| account        | string | Taip       | Ne              | Prisijungimo vardas                                                                                                                                                                                        |
| email          | string | Ne         | Ne              | El. paštas                                                                                                                                                                                                 |
| phone          | string | Ne         | Ne              | Telefonas                                                                                                                                                                                                  |
| givenName      | string | Ne         | Ne              | Vardas                                                                                                                                                                                                     |
| surname        | string | Ne         | Ne              | Pavardė                                                                                                                                                                                                    |
| fullNameDative | string | Ne         | Ne              | Pilnas vardas                                                                                                                                                                                              |
| code           | string | Ne         | Ne              | Asmens kodas   Atributas yra grąžinamas priklausomai nuo sistemos konfigūracijos požymio WS\_RETRIEVE\_USER\_CODE: jei nurodyta „true“, atributas yra grąžinamas, jei „false“ – atributas nėra grąžinamas. |

---

## 2.3.1.2 Esybė „OrgStaffList“ – organizacijos etatų sąrašo elementas

- Namespace: <http://www.sintagma.lt/avilys/OrgStructWS>
- Pavadinimas: OrgStaffList
- Naudojamas kaip gaubiamasis elementas organizacijos etatų sąrašui

## Lentelė 114. „OrgStaffList“ esybės laukų sąrašas

| Pavadinimas | Tipas    | Privalomas | Pasikartojantis | Aprašymas                                                |
| ----------- | -------- | ---------- | --------------- | -------------------------------------------------------- |
| orgStaff    | OrgStaff | Ne         | Taip            | Etatas, žr. Lentelė 115. „OrgStaff“ esybės laukų sąrašas |

## 2.3.1.3 Esybė „OrgStaff“

- Esybė, skirta perduoti vienos pareigybės apjungtai informacijai. Papildo „OrgNode“. Esybės atributai pateikti žemiau esančioje lentelėje.

## Lentelė 115. „OrgStaff“ esybės laukų sąrašas

## Paveldi viską iš „OrgNode“ žr.: Lentelė 12. Esybės „OrgNode“ laukų sąrašas

| Pavadinimas  | Tipas                  | Privalomas | Pasikartojantis | Aprašymas                                                             |
| ------------ | ---------------------- | ---------- | --------------- | --------------------------------------------------------------------- |
| orgName      | string                 | Taip       | Ne              | Pareigybės identifikatorius                                           |
| officialName | string                 | Taip       | Ne              | Padalinio pavadinimas                                                 |
| isOffice     | boolean                | Taip       | Ne              | Ar pareigybė priklauso raštinei                                       |
| isAdmin      | boolean                | Taip       | Ne              | Ar pareigybė priklauso administratorių grupei                         |
| isChief      | boolean                | Taip       | Ne              | Ar pareigybė yra padalinio vadovas                                    |
| isExecutive  | boolean                | Taip       | Ne              | Ar pareigybė priklauso vadovybės grupei                               |
| user         | User                   | Taip       | Ne              | Naudotojo informacija (žr. Lentelė 113. „User“ esybės laukų sąrašas). |
| permissions  | grupuojantis elementas | Taip       | Ne              | Elementas, grupuojantis žemiau išvardintas reikšmes (teisių sąrašą)   |
| listItem     | string                 | Taip       | Taip            | Pareigybei priskirtos teisės kodas                                    |

## 2.3.1.4 Esybė „OrgUnit“

- Esybė, skirta perduoti vieno padalinio informacijai. Papildo „OrgNode“. Esybės atributai pateikti žemiau esančioje lentelėje.

## Lentelė 116. „OrgUnit“ esybės laukų sąrašas

- Paveldi viską iš „OrgNode“ žr.: Lentelė 12. Esybės „OrgNode“ laukų sąrašas

| Pavadinimas | Tipas   | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                     |
| ----------- | ------- | ---------- | --------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| unitType    | string  | Taip       | Ne              | Padalinio tipas. Nurodomas klasifikatoriaus OID, kurį galima gauti per ClassifiersWs sąsają (žr. skyrių 2.6)                                                                                  |
| childUnit   | OrgUnit | Ne         | Taip            | Padaliniui pavaldžių padalinių sąrašas. Sąrašas pateikiamas tik jei išreiktinai paprašoma jį pateikti užklausos parametruose (žr. operacijos „getChildUnits2“ parametrą „returnDescendants“). |

## 2.3.1.5 Esybė „GetChildStaffResult“

- Esybė, skirta perduoti pareigybių sąrašui. Esybės atributai pateikti žemiau esančioje lentelėje.

## Lentelė 117. „GetChildStaffResult“ esybės laukų sąrašas

| Pavadinimas | Tipas    | Privalomas | Pasikartojantis | Aprašymas                                                                                                 |
| ----------- | -------- | ---------- | --------------- | --------------------------------------------------------------------------------------------------------- |
| childStaff  | OrgStaff | Taip       | Taip            | Vienos pareigybės informaciją apjungiantis elementas (žr.: Lentelė 115. „OrgStaff“ esybės laukų sąrašas). |

## 2.3.1.6 Esybė „GetChildUnitsResult“

- Esybė, skirta perduoti padalinių informacijos sąrašui. Esybės atributai pateikti žemiau esančioje lentelėje.

## Lentelė 118. „GetChildUnitsResult“ esybės laukų sąrašas

| Pavadinimas | Tipas   | Privalomas | Pasikartojantis | Aprašymas                                                                                             |
| ----------- | ------- | ---------- | --------------- | ----------------------------------------------------------------------------------------------------- |
| childUnit   | OrgUnit | Taip       | Taip            | Vieno padalinio informaciją apjungiantis elementas (žr. Lentelė 116. „OrgUnit“ esybės laukų sąrašas). |

## 2.3.2 Operacija „getRootUnit“

- Operacija grąžina šakninį (aukščiausią) vidinės organizacinės struktūros įrašą. Operacija neturi parametrų.

## Lentelė 119. Operacijos „getRootUnit“ rezultato reikšmių aprašymas

| Pavadinimas       | Tipas   | Privalomas | Pasikartojantis | Aprašymas                                                                         |
| ----------------- | ------- | ---------- | --------------- | --------------------------------------------------------------------------------- |
| getRootUnitResult | OrgUnit | Taip       | Ne              | Operacija grąžina esybę OrgUnit (žr. Lentelė 116. „OrgUnit“ esybės laukų sąrašas) |

## 2.3.3 Operacija „getOrgUnit“

- Operacija grąžina vieną vidinės organizacinės struktūros įrašą pagal nurodytą jo identifikatorių esybėje „OrgNodeParam“ lauke „orgName“.

## Lentelė 120. Operacijos „getOrgUnit“ parametrai

| Pavadinimas | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                                                                |
| ----------- | ------------ | ---------- | --------------- | ---------------------------------------------------------------------------------------- |
| getOrgUnit  | OrgNodeParam | Taip       | Ne              | Esybėje lauko „orgName“ reikšmė yra privaloma (žr. Esybės „OrgNodeParam“ laukų sąrašas). |

## Lentelė 121. Operacijos „getOrgUnit“ rezultato reikšmių aprašymas

| Pavadinimas      | Tipas   | Privalomas | Pasikartojantis | Aprašymas                                                                         |
| ---------------- | ------- | ---------- | --------------- | --------------------------------------------------------------------------------- |
| getOrgUnitResult | OrgUnit | Taip       | Ne              | Operacija grąžina esybę OrgUnit (žr. Lentelė 116. „OrgUnit“ esybės laukų sąrašas) |

## 2.3.4 Operacija „getNodeOrganization“

- Operacija grąžina įstaigos lygio padalinį, kuriam priklauso nurodytas esybės „OrgNodeParam“ lauko „orgName“ vidinės organizacinės struktūros vienetas. Operacijai paduodama esybė „OrgNodeParam“.
- Lentelė 122. Operacijos „getNodeOrganization“ parametrai

| Pavadinimas         | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                                                                |
| ------------------- | ------------ | ---------- | --------------- | ---------------------------------------------------------------------------------------- |
| getNodeOrganization | OrgNodeParam | Taip       | Ne              | Esybėje lauko „orgName“ reikšmė yra privaloma (žr. Esybės „OrgNodeParam“ laukų sąrašas). |

## Lentelė 123. Operacijos „getNodeOrganization“ rezultato reikšmių aprašymas

| Pavadinimas               | Tipas   | Privalomas | Pasikartojantis | Aprašymas                                                                         |
| ------------------------- | ------- | ---------- | --------------- | --------------------------------------------------------------------------------- |
| getNodeOrganizationResult | OrgUnit | Taip       | Ne              | Operacija grąžina esybę OrgUnit (žr. Lentelė 116. „OrgUnit“ esybės laukų sąrašas) |

## 2.3.5 Operacija „getNodeParent“

- Operacija grąžina tiesioginį padalinį, kuriam priklauso nurodytas esybės „OrgNodeParam“ lauko „orgName“ vidinės organizacinės struktūros vienetas. Operacijai paduodama esybė „OrgNodeParam“.
- Elgesys su skirtingų tipų „OrgNode“ esybėmis (žr. Lentelė 12. Esybės „OrgNode“ laukų sąrašas, laukas „type“):
  - Pareigybės tipo („STAFF“) esybei grąžinamas padalinys, kuriam priklauso pareigybė;
  - Padalinio tipo („UNIT“) esybei grąžinamas jo tėvinis padalinys; šakniniam padaliniui grąžinama „null“ reikšmė;
  - Padalinio grupės („GROUP“) esybei grąžinamas padalinys, kuriame ši grupė apibrėžta;
  - Sisteminės grupės („SET“) esybei grąžinama „null“ reikšmė;

## Lentelė 124. Operacijos „getNodeParent“ parametrai

| Pavadinimas   | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                                                                |
| ------------- | ------------ | ---------- | --------------- | ---------------------------------------------------------------------------------------- |
| getNodeParent | OrgNodeParam | Taip       | Ne              | Esybėje lauko „orgName“ reikšmė yra privaloma (žr. Esybės „OrgNodeParam“ laukų sąrašas). |

## Lentelė 125. Operacijos „getNodeParent“ rezultato reikšmių aprašymas

| Pavadinimas         | Tipas   | Privalomas | Pasikartojantis | Aprašymas                                                                        |
| ------------------- | ------- | ---------- | --------------- | -------------------------------------------------------------------------------- |
| getNodeParentResult | OrgNode | Taip       | Ne              | Operacija grąžina esybę OrgNode (žr. Lentelė 12. Esybės „OrgNode“ laukų sąrašas) |

## 2.3.6 Operacija „getChildUnits“

- Operacija grąžina nurodyto vidinės organizacinės struktūros padalinio vaikinių (pavaldžių) padalinių sąrašą.

## Lentelė 126. Operacijos „getChildUnits“ parametrai

| Pavadinimas   | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                                                                |
| ------------- | ------------ | ---------- | --------------- | ---------------------------------------------------------------------------------------- |
| getChildUnits | OrgNodeParam | Taip       | Ne              | Esybėje lauko „orgName“ reikšmė yra privaloma (žr. Esybės „OrgNodeParam“ laukų sąrašas). |

- Operacija grąžina esybę GetChildUnitsResult, kurios atributai aprašyti (žr. Lentelė 118. „GetChildUnitsResult“ esybės laukų sąrašas) esančioje lentelėje.

## Lentelė 127. Operacijos „getChildUnits“ rezultato reikšmių aprašymas

| Pavadinimas         | Tipas               | Privalomas | Pasikartojantis | Aprašymas                                                                                                            |
| ------------------- | ------------------- | ---------- | --------------- | -------------------------------------------------------------------------------------------------------------------- |
| getChildUnitsResult | GetChildUnitsResult | Taip       | Ne              | Esybė, skirta perduoti padalinių informacijos sąrašui (žr. Lentelė 118. „GetChildUnitsResult“ esybės laukų sąrašas). |

## 2.3.7 Operacija „getChildUnits2“

- Operacija grąžina nurodytam vidinės organizacinės struktūros padaliniui priklausančių (pavaldžių) padalinių sąrašą. Išplėsdama „getChildUnits“ funkcionalumą, operacija gali pateikti pavaldžių padalinių hierarchinį sąrašą, į kurį įtraukti padaliniams pavaldūs padaliniai.
- Operacijai paduodama esybė GetChildUnitsParam, kurios struktūra aprašyta toliau pateiktoje lentelėje:

## Lentelė 128. Esybės „GetChildUnitsParam“ laukų sąrašas

| Pavadinimas           | Tipas   | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                        |
| --------------------- | ------- | ---------- | --------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| orgName               | string  | Taip       | Ne              | Org. struktūros padalinio, kurio pavaldžių padalinių sąrašą tikimasi gauti, lauko „orgName“ reikšmė.                                                                             |
| returnDescendants     | Boolean | Ne         | Ne              | Nurodžius reikšmę „true“, pavaldūs padaliniai pateikiami kartu su pavaldžiais padaliniais, išvardintais sąraše pateikiamų OrgUnit tipo esybių laukuose „childUnit“.              |
| returnHistoricalNames | Boolean | Ne         | Ne              | Nurodžius reikšmę „true“, pavaldūs padaliniai pateikiami kartu su istoriniais pavadinimais, išvardintais sąraše pateikiamų HistoricalName tipo esybių laukuose „historicalName“. |

- Operacija grąžina esybę GetChildUnitsResult, kurios atributai aprašyti lentelėje „Lentelė 118. „GetChildUnitsResult“ esybės laukų sąrašas“.

## 2.3.8 Operacija „getAllStaff“

- Operacija grąžina nurodyto vidinės organizacinės struktūros padalinio ir vaikinių padalinių visų pareigybių sąrašą. Operacijai paduodama esybė „OrgNodeParam“.

## Lentelė 129. Operacijos „getAllStaff“ parametrai

| Pavadinimas | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                      |
| ----------- | ------------ | ---------- | --------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| getAllStaff | OrgNodeParam | Taip       | Ne              | Esybėje nenurodžius lauko „orgName“ bus grąžinamas šakninio (aukščiausio) vidinės organizacinės struktūros visas pareigybių sąrašas (žr. Esybės „OrgNodeParam“ laukų sąrašas). |

- Operacija grąžina esybę GetChildStaffResult, kurios atributai aprašyti (žr. Lentelė 117. „GetChildStaffResult“ esybės laukų sąrašas) esančioje lentelėje. Lauko „user“ reikšmė bus null.

## Lentelė 130. Operacijos „getAllStaff“ rezultato reikšmių aprašymas

| Pavadinimas       | Tipas               | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                        |
| ----------------- | ------------------- | ---------- | --------------- | ------------------------------------------------------------------------------------------------------------------------------------------------ |
| getAllStaffResult | GetChildStaffResult | Taip       | Ne              | Operacija grąžina esybę GetChildStaffResult (žr. Lentelė 117. „GetChildStaffResult“ esybės laukų sąrašas). Lauko „user“ reikšmė nebus užpildyta. |

## 2.3.9 Operacija „getAllStaffWithUser“

- Operacija grąžina nurodyto vidinės organizacinės struktūros padalinio ir vaikinių padalinių visų pareigybių sąrašą. Taip pat grąžinama ir naudotojo informaciją šalia pareigybės. Operacijai paduodama esybė „OrgNodeParam“.

## Lentelė 131. Operacijos „getAllStaff“ parametrai

| Pavadinimas         | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                      |
| ------------------- | ------------ | ---------- | --------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| getAllStaffWithUser | OrgNodeParam | Taip       | Ne              | Esybėje nenurodžius lauko „orgName“ bus grąžinamas šakninio (aukščiausio) vidinės organizacinės struktūros visas pareigybių sąrašas (žr. Esybės „OrgNodeParam“ laukų sąrašas). |

- Operacija grąžina esybę GetChildStaffResult, kurios atributai aprašyti (žr. Lentelė 117. „GetChildStaffResult“ esybės laukų sąrašas) esančioje lentelėje. Lauko „user“ reikšmė bus užpildyta naudotojo informacija.

## Lentelė 132. Operacijos „getAllStaffWithUser“ rezultato reikšmių aprašymas

| Pavadinimas               | Tipas               | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                            |
| ------------------------- | ------------------- | ---------- | --------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| getAllStaffWithUserResult | GetChildStaffResult | Taip       | Ne              | Operacija grąžina esybę GetChildStaffResult (žr. Lentelė 117. „GetChildStaffResult“ esybės laukų sąrašas). Lauko „user“ reikšmė bus užpildyta naudotojo informacija. |

## 2.3.10 Operacija „getChildStaff“

Operacija grąžina nurodyto vidinės organizacinės struktūros padalinio pareigybių sąrašą. Operacijai paduodama esybė „OrgNodeParam“.

## Lentelė 133. Operacijos „getChildStaff“ parametrai

| Pavadinimas   | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                                                                |
| ------------- | ------------ | ---------- | --------------- | ---------------------------------------------------------------------------------------- |
| getChildStaff | OrgNodeParam | Taip       | Ne              | Esybėje lauko „orgName“ reikšmė yra privaloma (žr. Esybės „OrgNodeParam“ laukų sąrašas). |

- Operacija grąžina esybę GetChildStaffResult, kurios atributai aprašyti (žr. Lentelė 117. „GetChildStaffResult“ esybės laukų sąrašas) esančioje lentelėje.

## Lentelė 134. Operacijos „getChildStaff“ rezultato reikšmių aprašymas

| Pavadinimas         | Tipas               | Privalomas | Pasikartojantis | Aprašymas                                                                                                                               |
| ------------------- | ------------------- | ---------- | --------------- | --------------------------------------------------------------------------------------------------------------------------------------- |
| getChildStaffResult | GetChildStaffResult | Taip       | Ne              | Operacija grąžina esybę GetChildStaffResult (žr. Lentelė 117. „GetChildStaffResult“ esybės laukų sąrašas). Lauko „user“ reikšmė tuščia. |

## 2.3.11 Operacija „getChildStaffDirect“

- Operacija grąžina nurodyto vidinės organizacinės struktūros tiesiogiai paskirtų pareigybių sąrašą. Operacijai paduodama esybė „OrgNodeParam“.

## Lentelė 135. Operacijos „getChildStaffDirect“ parametrai

| Pavadinimas         | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                                                                |
| ------------------- | ------------ | ---------- | --------------- | ---------------------------------------------------------------------------------------- |
| getChildStaffDirect | OrgNodeParam | Taip       | Ne              | Esybėje lauko „orgName“ reikšmė yra privaloma (žr. Esybės „OrgNodeParam“ laukų sąrašas). |

- Operacija grąžina esybę GetChildStaffResult, kurios atributai aprašyti (žr. Lentelė 117. „GetChildStaffResult“ esybės laukų sąrašas) esančioje lentelėje.

## Lentelė 136. Operacijos „getChildStaffDirect“ rezultato reikšmių aprašymas

| Pavadinimas               | Tipas               | Privalomas | Pasikartojantis | Aprašymas                                                                                                                               |
| ------------------------- | ------------------- | ---------- | --------------- | --------------------------------------------------------------------------------------------------------------------------------------- |
| getChildStaffDirectResult | GetChildStaffResult | Taip       | Ne              | Operacija grąžina esybę GetChildStaffResult (žr. Lentelė 117. „GetChildStaffResult“ esybės laukų sąrašas). Lauko „user“ reikšmė tuščia. |

## 2.3.12 Operacija „getChildStaffRestricted“

- Operacija grąžina nurodyto vidinės organizacinės struktūros tiesiogiai ir per organizacijos grupes paskirtų pareigybių sąrašą. Į rezultatą neįtraukiamos pavaduojančios pareigybės (tempStaff tipo), bet įtraukiamos pavaduojamos pareigybės Operacijai paduodama esybė „OrgNodeParam“.

## Lentelė 137. Operacijos „getChildStaffRestricted“ parametrai

| Pavadinimas             | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                                                                |
| ----------------------- | ------------ | ---------- | --------------- | ---------------------------------------------------------------------------------------- |
| getChildStaffRestricted | OrgNodeParam | Taip       | Ne              | Esybėje lauko „orgName“ reikšmė yra privaloma (žr. Esybės „OrgNodeParam“ laukų sąrašas). |

- Operacija grąžina esybę GetChildStaffResult, kurios atributai aprašyti (žr. Lentelė 117. „GetChildStaffResult“ esybės laukų sąrašas) esančioje lentelėje. Naudotojo informacija neužpildoma.

## Lentelė 138. Operacijos „getChildStaffRestricted“ rezultato reikšmių aprašymas

| Pavadinimas                   | Tipas               | Privalomas | Pasikartojantis | Aprašymas                                                                                                                               |
| ----------------------------- | ------------------- | ---------- | --------------- | --------------------------------------------------------------------------------------------------------------------------------------- |
| getChildStaffRestrictedResult | GetChildStaffResult | Taip       | Ne              | Operacija grąžina esybę GetChildStaffResult (žr. Lentelė 117. „GetChildStaffResult“ esybės laukų sąrašas). Lauko „user“ reikšmė tuščia. |

## 2.3.13 Operacija „getChildStaffWithUserRestricted“

- Operacija grąžina nurodyto vidinės organizacinės struktūros tiesiogiai ir per organizacijos grupes paskirtų pareigybių sąrašą. Į rezultatą neįtraukiamos pavaduojančios pareigybės (tempStaff tipo), bet įtraukiamos pavaduojamos pareigybės. Taip pat grąžinama ir naudotojo informacija. Operacijai paduodama esybė „OrgNodeParam“.

## Lentelė 139. Operacijos „getChildStaffWithUserRestricted“ parametrai

| Pavadinimas                     | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                                                                |
| ------------------------------- | ------------ | ---------- | --------------- | ---------------------------------------------------------------------------------------- |
| getChildStaffWithUserRestricted | OrgNodeParam | Taip       | Ne              | Esybėje lauko „orgName“ reikšmė yra privaloma (žr. Esybės „OrgNodeParam“ laukų sąrašas). |

- Operacija grąžina esybę GetChildStaffResult, kurios atributai aprašyti (žr. Lentelė 117. „GetChildStaffResult“ esybės laukų sąrašas) esančioje lentelėje. Naudotojo informacija užpildoma.

## Lentelė 140. Operacijos „getChildStaffWithUserRestricted“ rezultato reikšmių aprašymas

| Pavadinimas                           | Tipas               | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                  |
| ------------------------------------- | ------------------- | ---------- | --------------- | ------------------------------------------------------------------------------------------------------------------------------------------ |
| getChildStaffWithUserRestrictedResult | GetChildStaffResult | Taip       | Ne              | Operacija grąžina esybę GetChildStaffResult (žr. Lentelė 117. „GetChildStaffResult“ esybės laukų sąrašas). Lauko „user“ reikšmė užpildoma. |

## 2.3.14 Operacija „getChildStaffWithUser“

- Operacija grąžina nurodyto vidinės organizacinės struktūros tiesiogiai ir per organizacijos grupes paskirtų pareigybių sąrašą. Taip pat grąžinama ir naudotojo informaciją šalia pareigybės. Operacijai paduodama esybė „OrgNodeParam“.

## Lentelė 141. Operacijos „getChildStaffWithUser“ parametrai

| Pavadinimas           | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                                                                |
| --------------------- | ------------ | ---------- | --------------- | ---------------------------------------------------------------------------------------- |
| getChildStaffWithUser | OrgNodeParam | Taip       | Ne              | Esybėje lauko „orgName“ reikšmė yra privaloma (žr. Esybės „OrgNodeParam“ laukų sąrašas). |

- Operacija grąžina esybę GetChildStaffResult, kurios atributai aprašyti (žr. Lentelė 117. „GetChildStaffResult“ esybės laukų sąrašas) esančioje lentelėje. Naudotojo informacija užpildoma.

## Lentelė 142. Operacijos „getChildStaffWithUser“ rezultato reikšmių aprašymas

| Pavadinimas                 | Tipas               | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                  |
| --------------------------- | ------------------- | ---------- | --------------- | ------------------------------------------------------------------------------------------------------------------------------------------ |
| getChildStaffWithUserResult | GetChildStaffResult | Taip       | Ne              | Operacija grąžina esybę GetChildStaffResult (žr. Lentelė 117. „GetChildStaffResult“ esybės laukų sąrašas). Lauko „user“ reikšmė užpildoma. |

## 2.3.15 Operacija „getChildStaffWithUserDirect“

- Operacija grąžina nurodyto vidinės organizacinės struktūros tik tiesiogiai paskirtų pareigybių sąrašą. Taip pat grąžinama ir naudotojo informaciją šalia pareigybės. Operacijai paduodama esybė „OrgNodeParam“.

## Lentelė 143. Operacijos „getChildStaffWithUserDirect“ parametrai

| Pavadinimas                 | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                                                                |
| --------------------------- | ------------ | ---------- | --------------- | ---------------------------------------------------------------------------------------- |
| getChildStaffWithUserDirect | OrgNodeParam | Taip       | Ne              | Esybėje lauko „orgName“ reikšmė yra privaloma (žr. Esybės „OrgNodeParam“ laukų sąrašas). |

- Operacija grąžina esybę GetChildStaffResult, kurios atributai aprašyti (žr. Lentelė 117. „GetChildStaffResult“ esybės laukų sąrašas) esančioje lentelėje. Naudotojo informacija užpildoma.

## Lentelė 0\_144. Operacijos „getChildStaffWithUserDirect“ rezultato reikšmių aprašymas

| Pavadinimas                       | Tipas                             | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                  |
| --------------------------------- | --------------------------------- | ---------- | --------------- | ------------------------------------------------------------------------------------------------------------------------------------------ |
| getChildStaffWithUserDirectResult | getChildStaffWithUserDirectResult | Taip       | Ne              | Operacija grąžina esybę GetChildStaffResult (žr. Lentelė 117. „GetChildStaffResult“ esybės laukų sąrašas). Lauko „user“ reikšmė užpildoma. |

## 2.3.16 Operacija „getOrganizationUnits“

- Operacija grąžina nurodyto vidinės organizacinės struktūros padalinio organizacijų sąrašą. Operacijai paduodama esybė „OrgNodeParam“.

## Lentelė 145. Operacijos „getOrganizationUnits“ parametrai

| Pavadinimas          | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                                                              |
| -------------------- | ------------ | ---------- | --------------- | -------------------------------------------------------------------------------------- |
| getOrganizationUnits | OrgNodeParam | Taip       | Ne              | Esybėje lauko „orgName“ reikšmė yra privaloma (žr. Esybės „OrgNodeParam“ laukų sąrašas |

## Lentelė 146. Operacijos „getOrganizationUnits“ rezultato reikšmių aprašymas

| Pavadinimas                | Tipas               | Privalomas | Pasikartojantis | Aprašymas                                                                                                            |
| -------------------------- | ------------------- | ---------- | --------------- | -------------------------------------------------------------------------------------------------------------------- |
| getOrganizationUnitsResult | GetChildUnitsResult | Taip       | Ne              | Esybė, skirta perduoti padalinių informacijos sąrašui (žr. Lentelė 118. „GetChildUnitsResult“ esybės laukų sąrašas). |

## 2.3.17 Operacija „getOrgStaff“

- Operacija grąžina nurodyto vidinės organizacinės struktūros vieneto pareigybę. Operacijai paduodama esybė „OrgNodeParam“.

## Lentelė 147. Operacijos „getOrgStaff“ parametrai

| Pavadinimas | Tipas        | Privalomas | Pasikartojantis | Aprašymas                                                                                |
| ----------- | ------------ | ---------- | --------------- | ---------------------------------------------------------------------------------------- |
| getOrgStaff | OrgNodeParam | Taip       | Ne              | Esybėje lauko „orgName“ reikšmė yra privaloma (žr. Esybės „OrgNodeParam“ laukų sąrašas). |

## Lentelė 0 148. Operacijos „getOrgStaff“ rezultato reikšmių aprašymas

| Pavadinimas       | Tipas    | Privalomas | Pasikartojantis | Aprašymas                                           |
| ----------------- | -------- | ---------- | --------------- | --------------------------------------------------- |
| getOrgStaffResult | OrgStaff | Taip       | Ne              | (žr. Lentelė 115. „OrgStaff“ esybės laukų sąrašas). |

## 2.3.18 Operacija „getStaffForUserResultExtended“

- Operacija grąžina esybę: „GetStaffForUserExtendedResult“. Operacijai paduodama esybė „UserParam“.
- Ši funkcija užpildo grąžinamų „OrgStaff“ esybių laukus „user“ ir „permissions“.
- Laukas „permissions“ užpildomas pareigybės turimomis teisėmis pagal sąrašą, nurodytą sistemos nustatyme „PERMISSIONS\_TO\_CHECK\_FOR\_EXTERNAL\_APP“.

## Lentelė 149. Operacijos „getStaffForUserResultExtended“ parametrai

| Pavadinimas | Tipas     | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                  |
| ----------- | --------- | ---------- | --------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------- |
| userParam   | UserParam | Taip       | Ne              | Esybėje lauko „uaName“ arba „account“ reikšmė yra privaloma, tačiau abiejų reikšmių vienu metu naudoti negalima (žr. Esybės „OrgNodeParam“ laukų sąrašas). |

## Lentelė 150. Esybės „getStaffForUserExtendedResult“ parametrų aprašymas

| Pavadinimas       | Tipas    | Privalomas | Pasikartojantis | Aprašymas                                           |
| ----------------- | -------- | ---------- | --------------- | --------------------------------------------------- |
| prefferedOrgStaff | OrgStaff | Ne         | Ne              | (žr. Lentelė 115. „OrgStaff“ esybės laukų sąrašas). |
| orgStaffSet       | Set      | Ne         | Taip            | (žr. Lentelė 115. „OrgStaff“ esybės laukų sąrašas). |
