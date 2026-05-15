SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS projecte_gip3
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

CREATE USER IF NOT EXISTS 'usuari'@'%' IDENTIFIED BY '1234';
GRANT ALL PRIVILEGES ON projecte_gip3.* TO 'usuari'@'%';
FLUSH PRIVILEGES;

USE projecte_gip3;

CREATE TABLE TIPU (
    ID_TIPU    INT          AUTO_INCREMENT PRIMARY KEY,
    NOM        VARCHAR(100) NOT NULL
);

CREATE TABLE TECNIC (
    ID_TECNIC  INT          AUTO_INCREMENT PRIMARY KEY,
    NOM        VARCHAR(100) NOT NULL
);

CREATE TABLE DEPARTAMENT (
    ID_DEPARTAMENT  INT          AUTO_INCREMENT PRIMARY KEY,
    NOM             VARCHAR(100) NOT NULL
);

CREATE TABLE INCIDENCIA (
    ID_INCIDENCIA   INT          AUTO_INCREMENT PRIMARY KEY,
    DATA_CREACIO    DATETIME     DEFAULT CURRENT_TIMESTAMP,
    DATA_INICI      DATE,
    DATA_FI         DATE,
    DESCRIPCIO      VARCHAR(500),
    PRIORITAT       ENUM('ALTA','MITJANA','BAIXA'),
    ESTAT           ENUM('OBERTA','EN_PROCES','TANCADA') DEFAULT 'OBERTA',
    ID_TIPU         INT,
    ID_TECNIC       INT,
    ID_DEPARTAMENT  INT
);

CREATE TABLE ACTUACIO (
    ID_ACTUACIO       INT          AUTO_INCREMENT PRIMARY KEY,
    DESCRIPCIO        VARCHAR(500),
    TEMPS_ACTUACIO_MIN INT,
    VISIBLE           BOOLEAN      DEFAULT TRUE,
    ESTAT             ENUM('PENDENT','ACABAT') DEFAULT 'PENDENT',
    ID_INCIDENCIA     INT,
    ID_TECNIC         INT
);

ALTER TABLE INCIDENCIA
    ADD CONSTRAINT FK_INCIDENCIA_TIPU
    FOREIGN KEY (ID_TIPU) REFERENCES TIPU (ID_TIPU) ON DELETE SET NULL;

ALTER TABLE INCIDENCIA
    ADD CONSTRAINT FK_INCIDENCIA_TECNIC
    FOREIGN KEY (ID_TECNIC) REFERENCES TECNIC (ID_TECNIC) ON DELETE SET NULL;

ALTER TABLE INCIDENCIA
    ADD CONSTRAINT FK_INCIDENCIA_DEPARTAMENT
    FOREIGN KEY (ID_DEPARTAMENT) REFERENCES DEPARTAMENT (ID_DEPARTAMENT) ON DELETE SET NULL;

ALTER TABLE ACTUACIO
    ADD CONSTRAINT FK_ACTUACIO_INCIDENCIA
    FOREIGN KEY (ID_INCIDENCIA) REFERENCES INCIDENCIA (ID_INCIDENCIA) ON DELETE SET NULL;

ALTER TABLE ACTUACIO
    ADD CONSTRAINT FK_ACTUACIO_TECNIC
    FOREIGN KEY (ID_TECNIC) REFERENCES TECNIC (ID_TECNIC) ON DELETE SET NULL;

ALTER TABLE INCIDENCIA ADD COLUMN DEPARTAMENT VARCHAR(100);

CREATE OR REPLACE VIEW vista_informe_tecnics AS
SELECT
    t.ID_TECNIC,
    t.NOM AS nomTecnic,
    i.PRIORITAT,
    i.ID_INCIDENCIA,
    i.DESCRIPCIO AS descripcioIncidencia,
    i.DATA_CREACIO AS dataInici,
    IFNULL(SUM(a.TEMPS_ACTUACIO_MIN), 0) AS tempsTotalDedicat
FROM TECNIC t
INNER JOIN INCIDENCIA i ON t.ID_TECNIC = i.ID_TECNIC
LEFT JOIN ACTUACIO a ON i.ID_INCIDENCIA = a.ID_INCIDENCIA
WHERE i.DATA_FI IS NULL
GROUP BY
    t.ID_TECNIC,
    t.NOM,
    i.PRIORITAT,
    i.ID_INCIDENCIA,
    i.DESCRIPCIO,
    i.DATA_CREACIO;

CREATE OR REPLACE VIEW vista_consum_departaments AS
SELECT
    d.ID_DEPARTAMENT,
    d.NOM AS nomDepartament,
    COUNT(i.ID_INCIDENCIA) AS nombreIncidencies,
    IFNULL(SUM(temps_per_incidencia.tempsTotal), 0) AS tempsTotalDedicat
FROM DEPARTAMENT d
LEFT JOIN INCIDENCIA i ON d.ID_DEPARTAMENT = i.ID_DEPARTAMENT
LEFT JOIN (
    SELECT
        ID_INCIDENCIA,
        SUM(TEMPS_ACTUACIO_MIN) AS tempsTotal
    FROM ACTUACIO
    GROUP BY ID_INCIDENCIA
) AS temps_per_incidencia ON i.ID_INCIDENCIA = temps_per_incidencia.ID_INCIDENCIA
GROUP BY
    d.ID_DEPARTAMENT,
    d.NOM;

INSERT INTO DEPARTAMENT (NOM) VALUES
('Informàtica'),
('Matemàtiques'),
('Història'),
('Biologia'),
('Física i Química'),
('Llengues');

INSERT INTO TECNIC (NOM) VALUES
('Pere Portas'),
('Joan Garcia'),
('Maria López');

INSERT INTO TIPU (NOM) VALUES
('Problema de maquinari'),
('Problema de programari'),
('Problema de xarxa'),
('Problema de correu electrònic'),
('Problema de seguretat'),
('Problema impressora'),
('Problema de servidor'),
('Problema de base de dades'),
('Altres');

INSERT INTO INCIDENCIA (DATA_INICI, DESCRIPCIO, PRIORITAT, ESTAT, ID_TIPU, ID_TECNIC, ID_DEPARTAMENT) VALUES
('2025-05-01', 'Ordinador no arrenca despres actualitzacio Windows', 'ALTA', 'OBERTA', 1, 1, 1),
('2025-05-03', 'Projector aula 204 no connecta per HDMI', 'MITJANA', 'OBERTA', 1, 2, 3),
('2025-05-05', 'No es pot accedir Wi-Fi laboratori portatils', 'ALTA', 'OBERTA', 3, 3, 4),
('2025-05-06', 'Programari simulacio molecular no sinstalla correctament', 'MITJANA', 'OBERTA', 2, 1, 4),
('2025-05-07', 'Problemes impressora departament Fisica', 'BAIXA', 'OBERTA', 6, 2, 5),
('2025-05-08', 'Compte correu professor no rep missatges externs', 'MITJANA', 'OBERTA', 4, 3, 6),
('2025-05-09', 'Servidor fitxers compartits no accessible fora campus', 'ALTA', 'OBERTA', 7, 1, 1);

INSERT INTO INCIDENCIA (DATA_INICI, DESCRIPCIO, PRIORITAT, ESTAT, ID_TIPU, ID_TECNIC, ID_DEPARTAMENT) VALUES
('2025-04-10', 'Virus detectat als ordinadors de matematiques', 'ALTA', 'EN_PROCES', 5, 1, 2),
('2025-04-12', 'Base de dades de notes no respon correctament', 'ALTA', 'EN_PROCES', 8, 3, 1),
('2025-04-15', 'Caiguda de xarxa a la planta 2', 'ALTA', 'EN_PROCES', 3, 2, 2),
('2025-04-18', 'Actualitzacio fallida Office en aules Historia', 'MITJANA', 'EN_PROCES', 2, 1, 3),
('2025-04-20', 'Impressora planta 1 no imprimeix en color', 'BAIXA', 'EN_PROCES', 6, 2, 2),
('2025-04-22', 'Correu institucional no sincronitza calendari', 'MITJANA', 'EN_PROCES', 4, 3, 5),
('2025-04-25', 'Servidor web intern caigut intermitentment', 'ALTA', 'EN_PROCES', 7, 1, 1);

INSERT INTO INCIDENCIA (DATA_INICI, DATA_FI, DESCRIPCIO, PRIORITAT, ESTAT, ID_TIPU, ID_TECNIC, ID_DEPARTAMENT) VALUES
('2025-03-01', '2025-03-05', 'Ratolins i teclats sense resposta aula 101', 'BAIXA', 'TANCADA', 1, 2, 3),
('2025-03-08', '2025-03-10', 'Problemes connexio VPN professors', 'MITJANA', 'TANCADA', 3, 3, 6),
('2025-03-12', '2025-03-15', 'Antivirus caducat ordinadors biologia', 'ALTA', 'TANCADA', 5, 1, 4),
('2025-03-18', '2025-03-20', 'Aplicacio gestio horaris no carrega', 'MITJANA', 'TANCADA', 2, 2, 1),
('2025-03-22', '2025-03-25', 'Switch de xarxa avariat planta 3', 'ALTA', 'TANCADA', 3, 3, 5),
('2025-03-28', '2025-04-01', 'Servidor correu sense espai en disc', 'ALTA', 'TANCADA', 7, 1, 1);

INSERT INTO ACTUACIO (DESCRIPCIO, TEMPS_ACTUACIO_MIN, VISIBLE, ESTAT, ID_INCIDENCIA, ID_TECNIC) VALUES
('Revisio inicial maquinari i diagnostics', 45, TRUE, 'PENDENT', 1, 1),
('Comprovacio cables i adaptadors HDMI', 30, TRUE, 'PENDENT', 2, 2),
('Reinici router i configuracio DHCP', 60, TRUE, 'PENDENT', 3, 3),
('Descarrega dependencies programari', 50, TRUE, 'PENDENT', 4, 1),
('Neteja capçals impressora', 20, TRUE, 'PENDENT', 5, 2),
('Revisio filtres antispam correu', 35, TRUE, 'PENDENT', 6, 3),
('Revisio firewall i ports oberts servidor', 90, TRUE, 'PENDENT', 7, 1),
('Escaneig complet sistema antivirus', 120, TRUE, 'ACABAT', 8, 1),
('Restauracio backup base de dades', 180, TRUE, 'ACABAT', 9, 3),
('Substitucio switch avariat planta 2', 90, TRUE, 'ACABAT', 10, 2),
('Desinstalacio Office i reinstallacio', 75, TRUE, 'ACABAT', 11, 1),
('Canvi cartutx tinta color impressora', 25, TRUE, 'PENDENT', 12, 2),
('Reconfiguracio compte Exchange', 40, TRUE, 'ACABAT', 13, 3),
('Reinici serveis Apache i monitoratge', 60, TRUE, 'ACABAT', 14, 1),
('Substitucio teclats i ratolins defectuosos', 30, TRUE, 'ACABAT', 15, 2),
('Actualitzacio certificat VPN', 45, TRUE, 'ACABAT', 16, 3),
('Renovacio llicencies antivirus', 20, TRUE, 'ACABAT', 17, 1),
('Reinstallacio aplicacio gestio horaris', 55, TRUE, 'ACABAT', 18, 2),
('Substitucio switch i reconfiguracio VLANs', 120, TRUE, 'ACABAT', 19, 3),
('Alliberament espai disc i arxivat logs', 80, TRUE, 'ACABAT', 20, 1);

