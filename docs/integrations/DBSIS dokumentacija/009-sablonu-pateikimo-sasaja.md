# Šablonų pateikimo sąsaja

- Path: `/api-dok/dbsis-api/duomenu-strukturos/sablonu-pateikimo-sasaja`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/duomenu-strukturos/sablonu-pateikimo-sasaja
- Index: 9

---

Šablonų pateikimo sąsaja („TemplateWS“)

## Apibendrinimas

- Sąsaja pateikiama SOAP protokolu.
- Sąsajos pavadinimas: TemplateWS
- Namespace: <http://www.sintagma.lt/avilys/TemplateWS>

### Bendrai naudojamos esybės

Šios sąsajos operacijų parametrai paveldi iš „BaseParam“ esybės (žr. Esybė „BaseParam“ – bazinė WS operacijų parametro esybė)

---

## 2.7.1.1 Esybė „TemplateResultBean“

- Namespace: <http://www.sintagma.lt/avilys/TemplateWS>
- Pavadinimas: TemplateResultBean
- Vieno šablono informaciją apjungiantis elementas „TemplateResultBean“

## Lentelė 173. Esybės „TemplateResultBean“ laukų sąrašas

- Paveldi viską iš „GetDocumentResult“ žr.: Lentelė 22. Esybės „GetDocumentResult“ laukų aprašymas

| Pavadinimas | Tipas  | Privalomas | Pasikartojantis | Aprašymas                                                                                                                  |
| ----------- | ------ | ---------- | --------------- | -------------------------------------------------------------------------------------------------------------------------- |
| oid         | string | Taip       | Ne              | Unikalus šablono identifikatorius DBSIS sistemoje. Operacija grąžina sąrašą OID reikšmių, kurios atitinka rastus šablonus. |

Pastaba: lauke „docAttributes“ pateikiami atributai, nurodyti parametre expand (žr.: Lentelė 174. Esybės „GetTemplateListWParam“ laukų sąrašas).

## 2.7.2 Operacija „getTemplateList“

- Operacija grąžina sąrašą DBSIS esančių dokumento šablonų pagal pateiktus kriterijus. Operacijai paduodama esybė „GetTemplateListWParam“. Esybės laukai išvardinti žemiau

## Lentelė 174. Esybės „GetTemplateListWParam“ laukų sąrašas

| Pavadinimas      | Tipas              | Privalomas | Pasikartojantis | Aprašymas                                                                                                                                                                                                                                                                                                                                                                                   |
| ---------------- | ------------------ | ---------- | --------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| itemType         | string             | Ne         | Ne              | Dokumento tipas, kuriam taikomas šablonas. Nurodomas klasifikatoriaus OID, kurį galima gauti per ClassifierWS sąsają (žr. skyrių 2.6)                                                                                                                                                                                                                                                       |
| templateUsage    | string             | Ne         | Ne              | Šablono panaudojimo sritis. Nurodyti „COMMON“.                                                                                                                                                                                                                                                                                                                                              |
| name             | string             | Ne         | Ne              | Šablono pavadinimas                                                                                                                                                                                                                                                                                                                                                                         |
| accessType       | string             | Ne         | Ne              | Prieigos teisių filtras. Galimos reikšmės: „admin“ – administravimui skirtas šablonų sąrašas (kuriuos naudotojas gali modifikuoti – kaip administravimo sąsajoje „Administravimas -> Šablonai“); „user“ –naudojimui skirtas šablonų sąrašas (kuriuos naudotojas gali naudoti dokumentams kurti). Jei parametras nenurodomas, pateikiamas administravimui skirtas šablonų sąrašas („admin“). |
| templateUserCode | string             | Ne         | Ne              | Šablono naudotojo (padalinio ar organizacijos) kodas (OrgNode code atributas).                                                                                                                                                                                                                                                                                                              |
| maxResults       | int                | Ne         | Ne              | Kiek maksimaliai rezultatų grąžinti                                                                                                                                                                                                                                                                                                                                                         |
| expand           | DocumentExpandType | Ne         | Ne              | Sąrašas atributų pavadinimų, nusakantis kurių atributų ir kokios apimties informacija pateikiama (žr. Esybė „DocumentExpandType“)                                                                                                                                                                                                                                                           |

Pastaba: bent vieną parametrą nurodyti privaloma.

- Operacijos rezultatas gražina esybę: „GetTemplateListResultBean“.

## Lentelė 175. Esybės „GetTemplateListResultBean“ reikšmių aprašymas

| Pavadinimas | Tipas              | Privalomas | Pasikartojantis | Aprašymas                                                     |
| ----------- | ------------------ | ---------- | --------------- | ------------------------------------------------------------- |
| templates   | TemplateResultBean | Ne         | Taip            | (žr.: Lentelė 173. Esybės „TemplateResultBean“ laukų sąrašas) |
