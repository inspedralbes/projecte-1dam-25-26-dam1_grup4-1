# transversals
Esquema mínim de carpetes pels projectes transversals

/php:
    /Administrador:
        /administrador.php
        /estadístiques.php
        /gestionar.php
        /llistar.php
    /Imatges:
        /favicon.jpg
        /fons.jpg
        /logo.png
    /Tecnic:
        /tecnic.php
        /registrar_actuacio.php
        /llistar.pere.php
        /llistar.maria.php
        /llisatr.joan.php
    /Usuari
        /usuari.php
        /registrar.php
        /formulari.php
        /consultar_incidencia_usuari.php



#  Nom dels integrants

Jawad Mohdith i Sergi Martinez

#  Nom del projecte

PROJECTE-1DAM-25-26-DAM1_GRUP4-1

 * Petita descripció

Aquest és un projecte intermodul·lar del primer any de DAM, on l'objectiu  és poder registrar informació d’incidències informàtiques mitjançant una aplicació web:

    - Una persona qualsevol d’un departament determinat pot obrir una incidència, d’ella detallarà el departament al que pertany, la data de la incidència i la descripció de la incidència (Per exemple: “Ciències naturals”, 25/02/2019 , “No funciona la impresora del departament”). 

    - Hi haurà responsable informàtic que revisarà les noves incidències i assignarà cada incidència a un tècnic del departament i classificarà cada incidència (hi ha una tipología d’incidència) i assignarà una prioritat (Alta, Mitja i Baixa)

    - Cada incidència serà tractada en exclusiva per un tècnic, però cada tècnic pot a la seva vegada treballar en moltes incidències. 

    - Per cada incidència es faran una o vàries actuacions, a cada actuació el tècnic registrarà la data de l'actuació, la descripció de l’actuació, el temps invertit (en minuts) i si la descripció de l’actuació pot ser visible o no per l’usuari. Per últim, marcarà si la incidència ha quedat resolta.

 * Adreça del gestor de tasques (taiga, jira, trello...)

https://tree.taiga.io/project/a25jawmohbou-projecte-gi3p/timeline

 * Adreça del prototip gràfic del projecte (Penpot, figma, moqups...)

https://design.penpot.app/#/view?file-id=29a60c49-971d-80dc-8007-e7079f4cf328&page-id=6778173c-fbf4-8077-8004-a37f50a5020f&section=interactions&index=0&share-id=8c927302-d076-8020-8008-00b641c8da1f

 * URL de producció 

http://g4.dam.inspedralbes.cat/index.php

 * Estat: (explicació d'en quin punt està)

El projecte es troba en la fase final de desplegament. Tota la lògica de base de dades i les interfícies d'usuari estan operatives, complint amb els requisits de totes les assignatures implicades.


Funcionalitats mínimes

Les funcionalitats mínimes del projecte són:

    Gestió per rols: Sistema d'accés diferenciat per a professors (creació d'incidències), tècnics (gestió d'actuacions i temps) i administradors (control total i assignació).

    Registre i traçabilitat: Notificació d'avaries detallada i seguiment de l'estat de cada tiquet (Oberta, En Procés, Tancada).

    Anàlisi de dades: Càlcul automàtic de temps invertits per departament i generació de gràfics estadístics amb Chart.js.

    Seguretat i Monitorització: Registre automatitzat de cada accés i acció en una base de dades MongoDB (logs) per a la traçabilitat de xarxa.

    Interfície Multiplataforma: Disseny responsive amb Bootstrap 5.3 que permet l'ús de l'aplicació en qualsevol dispositiu.

    Infraestructura automatitzada: Desplegament integral de tot l'entorn (servidor web i bases de dades) mitjançant contenidors Docker.