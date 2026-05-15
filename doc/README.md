# Sistema de Gestió d'Incidències - INS Pedralbes

Aquest projecte és una aplicació web completa per a la gestió d'incidències tècniques dins d'un centre educatiu, permetent la interacció entre usuaris (professors), tècnics i administradors.

## Documentació per Assignatures
* **[Base de Dades (BBDD)](BBDD.md)**: Diagrama E-R i consultes principals.
* **[Llenguatges de Marques (LLMM)](LLMM.md)**: Desenvolupament de components i JS.
* **[Programació](PROG.md)**: Gestió del projecte (Taiga) i Git.
* **[SGE & DIG+SOS](SGE.md)**: Estructura del projecte, funcionalitats i guia de desplegament.

---

## Documentació Bàsica Mínima

### 1. Objectius
* Facilitar la comunicació d'avaries per part del personal docent.
* Centralitzar la gestió de tasques per als tècnics de manteniment.
* Proporcionar estadístiques de consum i rendiment a l'administració.
* Mantenir un historial (logs) d'accessos i activitat mitjançant bases de dades NoSQL.

### 2. Arquitectura bàsica
L'aplicació utilitza una arquitectura **LAMP/M** en contenidors:
* **Tecnologies utilitzades**: 
    * **Backend**: PHP 
    * **Frontend**: HTML5, CSS3 (Bootstrap 5.3), JavaScript.
    * **BBDD Relacional**: MySQL 9.3 (Dades d'incidències, tècnics i departaments).
    * **BBDD NoSQL**: MongoDB (Registre de logs de sistema).
    * **Infraestructura**: Docker & Docker Compose.
* **Interrelació**: El backend PHP es connecta a MySQL per a la lògica de negoci i a MongoDB mitjançant un `logger.php` per traçar l'activitat de cada usuari.

### 3. Entorn de desenvolupament
Per aixecar el projecte en local:
1.  Assegura't de tenir instal·lat **Docker** i **Docker Compose**.
2.  Clona el repositori.
3.  Executa la comanda: `docker-compose up -d`.
4.  L'aplicació estarà disponible a `http://localhost:8080`.
5.  Base de dades disponible via Adminer a `http://localhost:8081`.

### 4. Desplegament a producció
El desplegament es realitza mitjançant la imatge de Docker configurada. Cal configurar les variables d'entorn `MONGODB_URI` i `MYSQL_ROOT_PASSWORD` en el fitxer `.env` del servidor de producció.

### 5. API Backend (Endpoints)
L'aplicació no és una API REST pura, però gestiona les següents rutes principals de dades:

* **GET /Administrador/gestionar.php**: Obté detalls d'una incidència.
    * *Resposta (200 OK)*: JSON/HTML amb dades de la incidència.
* **POST /Administrador/gestionar.php**: Actualitza tècnic i prioritat.
    * *Peticio JSON*: `{"tecnic": 1, "prioritat": "ALTA", "tipu": 2}`.
* **POST /Usuari/registrar.php**: Crea una nova incidència.
    * *Peticio JSON*: `{"departament": 3, "descripcio": "Pantalla trencada"}`.

---
**Autors**: Jawad Mohdith i Sergi Martinez
**Centre**: INS Pedralbes