# Documentació de Sistemes de Gestió Empresarial (SGE)

# 1. Codi font del projecte (Focussat en el mòdul)

    Fitxer clau: estadistiques.php.

    Tecnologia: Ús de PHP per a la consulta de dades i integració de la llibreria Chart.js per a la part de frontend.

    Lògica: Inclusió del fitxer de connexió db.php i l'ús de json_encode per passar dades del servidor al client.

# 2. Breu documentació de l'estructura i funcionalitats

    Estructura: El mòdul consta d'una part de processament de dades en PHP (Backend) que realitza un JOIN entre les taules INCIDENCIA i ACTUACIO, i una part de visualització (Frontend) que utilitza un <canvas> de HTML5.

    Funcionalitats:

        Consulta dinàmica: Extreu el temps total invertit en manteniment per cada departament de l'institut.

        Gràfic de "Quesito" (Pie Chart): Implementació visual que permet a l'administrador veure de forma intuïtiva quins departaments generen més càrrega de treball.

        Interactivitat: La llegenda és interactiva i permet filtrar visualment les dades des del navegador.

# 3. Guia de desplegament de l'aplicació 

    Requisits de Backend: Disposar d'un servidor amb PHP 8.x i extensió de MySQL activa.

    Base de Dades: Tenir carregat l'esquema SQL amb les taules DEPARTAMENT, INCIDENCIA i ACTUACIO amb dades de prova (perquè el gràfic no surti buit).

    Dependències Externes: El fitxer realitza una crida via CDN a la llibreria Chart.js, per tant, el servidor necessita accés a internet per carregar el gràfic correctament.

    Accés: Un cop el contenidor Docker està aixecat, es pot accedir directament a la ruta http://localhost:8080/estadistiques.php.