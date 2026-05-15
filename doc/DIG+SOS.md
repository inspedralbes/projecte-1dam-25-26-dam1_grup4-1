# Documentació de Llenguatge de Digitalització i Sostenibilitat (DIG+SOS)

# 1. Enllaç al repositori GitHub

    Repositori oficial: https://github.com/inspedralbes/projecte-1dam-25-26-dam1_grup4-1.git

    Històric de canvis: El repositori conté tots els commits realitzats durant el desenvolupament, reflectint l'evolució del codi i la resolució d'errors.

# 2. Codi font complet

El codi font està disponible íntegrament al repositori i es divideix en les següents capes tecnològiques:

    Backend: Desenvolupat en PHP 8.x, encarregat de la lògica de negoci, la gestió de sessions i la comunicació amb les bases de dades.

    Bases de Dades: * MySQL: Model relacional per a la gestió d'incidències, tècnics i departaments.

        MongoDB: Model NoSQL per al registre de logs i traçabilitat.

    Frontend: Creat amb HTML5, CSS3 (Bootstrap 5.3) i JavaScript per a la visualització de dades.

# 3. Documentació breu: Estructura del projecte

/PROJECTE-1DAM-25-26-DAM1_GRUP4-1
    /.github
        /.keep
    /Diagrama de casos d'ús
        /IMG_8157.jpeg
    /Diagrama de flux web
        /ADMIN.jpeg
        /doc
        /Link Penpot Disseny Web.pdf
        /Principal.jpeg
        /TÈCNIC.jpeg
        /USUARI.jpeg
    /doc
        /BBDD.md
        /DIG+SOS.md
        /LLMM.md
        /PROG.md
        /README.md
        /SGE.md
    /Docker
        /db_data
        /db_dataa
        /db_init
            /Create.sql
        /images
            /Dockerfilr_php
            /Dockerfile_php_mongodb
        /.env
        /.gitignore
        /docker-compose.yaml
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
        /composer.json
        /composer.lock
        /connexio.php
        /index.php
        /logger.php
    /vendor
    /LICENSE
    /README.md



# 4. Documentació breu: Funcionalitats implementades

S'han assolit totes les funcionalitats requerides pel mòdul:

    Gestió d'Incidències: Creació, lectura, actualització i tancament de tiquets segons el rol d'usuari.

    Registre d'Actuacions: Possibilitat d'afegir notes tècniques i comptabilitzar els minuts invertits en cada incidència.

    Sistema d'Estadístiques: Generació automàtica d'un gràfic de pastís (quesito) mitjançant Chart.js que mostra la distribució del temps de manteniment per departament.

    Traçabilitat (Logs): Monitorització en temps real a MongoDB de les dades de xarxa (IP, navegador i protocol) de cada usuari que interactua amb el sistema.

    Infraestructura Docker: Desplegament automatitzat de tot l'entorn (Apache, MySQL, MongoDB i Adminer) per garantir la portabilitat.