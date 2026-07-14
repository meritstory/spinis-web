# Darbo aplinka

- Path: `/api-dok/dbsis-api/diegimas`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/diegimas
- Index: 2

---

Pasiruoškite aplinką DBSIS API naudojimuisi

## Aplinkos paruošimas

### 1. Įdiekite SoapUI

1. Atsisiųskite naujausią [SoapUI versiją](https://www.soapui.org/downloads/).
2. Paleiskite diegimo programą ir sekite ekrane pateikiamus žingsnius.
3. Įdiegę, atidarykite **SoapUI**.

### 2. Atsisiųskite projektą

1. Gaukite mūsų paruoštą **DBSIS API projektą** (`.xml` failą).
2. Išsaugokite jį savo kompiuteryje (pvz., kataloge `Dokumentai/DBSIS/`).

### 3. Importuokite projektą į SoapUI

1. Atidarykite **SoapUI**.
2. Pasirinkite meniu punktą **File → Import Project**.
3. Nurodykite atsisiųstą `.xml` failą.
4. Paspauskite **Open** – projektas bus įkeltas.

### 4. Patikrinkite API užklausas

1. Projekto kairėje pusėje matysite API užklausų sąrašą.
2. Pasirinkite norimą užklausą.
3. Paspauskite mygtuką **▶ Run** (žalias trikampis).
4. Atsakymai bus parodyti dešiniajame lange.

### 5. Prisijungimo duomenys

- Jei API reikalauja autentifikacijos:
  - Įveskite jums suteiktą **vartotojo vardą** ir **slaptažodį**.
  - Arba naudokite **Bearer Token**, jei toks yra numatytas.

### 6. Atnaujinimai

- Jei išleidžiame naują projekto versiją – atsisiųskite naują `.xml` failą ir importuokite jį iš naujo.
- Seną projektą galite ištrinti per SoapUI arba palikti kaip atsarginę kopiją.

### 7. Naudingi patarimai

- API užklausas galite grupuoti į **test suites**, kad būtų patogiau testuoti.
- Galite redaguoti parametrus (pvz., `URL`, `body`, `headers`) pagal savo aplinką.

Jeigu kyla problemų jungiantis prie API, pirmiausia patikrinkite:

- ar naudojate teisingą **URL**,
- ar jūsų tinklo aplinka leidžia pasiekti API,
- ar prisijungimo duomenys yra galiojantys.
