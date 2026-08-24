# DBSIS API dokumentacija (Markdown)

Šis katalogas yra paruoštas perdavimui programuotojams.

## Turinys

- `index.md` - pilnas visų dokumentų sąrašas su nuorodomis.
- `000-...md` - `099-...md` - atskiri dokumentacijos puslapiai.

## Struktūra

- Kiekvienas failas turi vieną pagrindinę antraštę (`# ...`).
- Kiekvieno failo pradžioje palikta metainformacija:
  - originalus DBSIS kelias (`Path`),
  - originalus URL,
  - numeris (`Index`).
- Lentelės suformatuotos kaip standartinės Markdown lentelės.
- Kodo pavyzdžiai turi kalbos žymas (`xml`, `java`, `csharp`, `php`, `bash`, `json`, `text`).

## Rekomenduojamas naudojimas

- Navigaciją pradėkite nuo `index.md`.
- Integraciniams pavyzdžiams daugiausia naudokite `Integracija` failus.
- Duomenų struktūroms naudokite pirmus skyrius (`003-020`), o konkrečių servisų veiksmams - vėlesnius.

## Pastabos

- Dokumentacija konvertuota iš DBSIS HTML šaltinių į Markdown, išlaikant lenteles ir pavyzdžius.
- Turinys yra techniškai suvienodintas ir tinkamas peržiūrai IDE, Git platformose ir LLM/RAG ingest.
