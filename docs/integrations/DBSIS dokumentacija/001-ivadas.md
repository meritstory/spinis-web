# Įvadas

- Path: `/api-dok/dbsis-api/ivadas`
- URL: https://intranetas.dbsis.lt/api-dok/dbsis-api/ivadas
- Index: 1

---

DBSIS – Dokumentų valdymo bendroji informacinė sistema

## Integracijų sąsajos (API) versijos

| Versija | Data       | Autorius             | Aprašymas                                                                                                         |
| ------- | ---------- | -------------------- | ----------------------------------------------------------------------------------------------------------------- |
| `1.0`   | 2022-01-13 | UAB „Asseco Lietuva“ | Pradinė versija.                                                                                                  |
| `2.0`   | 2024-04-02 | UAB „Asseco Lietuva“ | Papildytas 2.1.14 skyrius ir įtrauktas Priedas Nr. 2                                                              |
| `3.0`   | 2025-01-14 | UAB „Asseco Lietuva“ | Papildytas 2.1.13, 2.1.20, 2.2.1, 2.3, 2.12., skyrius, naujai sukurti 2.1.10, 2.1.47, 2.2.28-2.2.40, 2.18 skyriai |

---

### Naudojami terminai ir sutrumpinimai

| Terminas | Paaiškinimas                                                                                                                         |
| -------- | ------------------------------------------------------------------------------------------------------------------------------------ |
| API      | Programinė sąsaja (angl. Application Programming Interface).                                                                         |
| DBVS     | Duomenų bazių valdymo sistema. Šiame dokumente ši santrumpa naudojama žymint reliacinę DBVS.                                         |
| DBSIS    | Dokumentų valdymo bendroji informacinė sistema                                                                                       |
| HTML     | Hiperteksto ženklinimo kalba, dažniausiai vartojama tinklalapiams rašyti (angl. HyperText Markup Language).                          |
| HTTP     | Hipertekstų persiuntimo protokolas saityno duomenims persiųsti (angl. Hypertext Transfer Protocol).                                  |
| IS       | Informacinė sistema                                                                                                                  |
| OID      | Unikalus objekto identifikatorius, naudojamas DBSIS. Šis identifikatorius konkrečiam objektui nesikeičia.                            |
| SOAP     | Atviras tinklo paslaugų teikimo formatas (angl. Simple Object Access Protocol).                                                      |
| WSDL     | SOAP protokolo dalis, kompiuterinė kalba, skirta vienareikšmiškai aprašyti tinklo paslaugą (angl. Web Service Description Language). |

---

## Pateikiamos sąsajos

- DBSIS pateikia sąsajas SOAP protokolu per `HTTPS` transporto protokolą.
- Autentifikavimui naudojamas **WS-Security Username** išplėtimas, įgalinantis SOAP žinutėje perduoti naudotojo vardą ir slaptažodį. Pagal šią informaciją DBSIS **autentikuoja** naudotoją ir **autorizuoja** veiksmą.
- **Rekomenduojama** kiekvienai integruojamai su DBSIS sistemai sukurti **sisteminį naudotoją**, kuriuo veiks integuojama sistema.
- Dėl saugumo SOAP žinutės koduojamos, naudojant HTTPS transporto mechanizmą *(HTTPS kliento sertifikatas nebus tikrinamas)*.
- DBSIS sukonfigūruojama **60** sekundžių HTTP timeout reikšmė (jei nenurodyta kitaip).

## Kaip pradėti naudoti

1. Valstybinė ar savivaldybės įstaiga kreipiasi į IRD dėl DBSIS įtraukimo.
2. Jei patvirtinama, patvirtinamas naudojimosi grafikas (min. 4 mėn. pasiruošimo).
3. Organizacija rengia komandą, pasirūpina infrastruktūra (workstations, VPN, el. parašai).
4. Įvykdomas prisijungimas, 2FA nustatymai.
5. Reikalinga – integracija per API.
6. Registruojamasi pagalbos tarnyboje.
