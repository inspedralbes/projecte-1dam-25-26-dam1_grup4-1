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

INSERT INTO INCIDENCIA (DATA_CREACIO, DESCRIPCIO, PRIORITAT, ESTAT, ID_TIPU, ID_TECNIC, ID_DEPARTAMENT) VALUES

-- EN PROCÉS
('2025-04-01 08:00:00', 'La pantalla d\'un professor parpelleja i de vegades es queda en negre.', 'MITJANA', 'EN_PROCES', 1, 1, 3),
('2025-04-05 09:15:00', 'El sistema operatiu d\'un ordinador de l\'aula no actualitza correctament.', 'BAIXA', 'EN_PROCES', 2, 2, 1),
('2025-04-08 11:30:00', 'La xarxa WiFi del departament cau cada cert temps.', 'MITJANA', 'EN_PROCES', 3, 3, 4),
('2025-04-10 10:00:00', 'No es reben correus externs des de fa 2 dies.', 'ALTA', 'EN_PROCES', 4, 1, 5),
('2025-04-14 08:30:00', 'S\'ha detectat accés no autoritzat a un compte d\'usuari.', 'ALTA', 'EN_PROCES', 5, 2, 1),
('2025-04-17 09:00:00', 'El servidor de fitxers compartits va molt lent des de l\'actualització.', 'MITJANA', 'EN_PROCES', 7, 3, 2),
('2025-04-19 10:45:00', 'Error de connexió intermitent a la base de dades del sistema de notes.', 'ALTA', 'EN_PROCES', 8, 1, 3),
('2025-04-21 08:15:00', 'La impressora del departament fa soroll però no imprimeix.', 'BAIXA', 'EN_PROCES', 6, 2, 6),

-- OBERTES
('2025-04-20 09:00:00', 'La impressora de la sala de professors no agafa el paper correctament.', 'BAIXA', 'OBERTA', 6, NULL, 6),
('2025-04-22 10:30:00', 'El projector de l\'aula 3 no es connecta per HDMI.', 'MITJANA', 'OBERTA', 1, NULL, 2),
('2025-04-25 11:00:00', 'Diversos alumnes no poden accedir a la plataforma Moodle.', 'ALTA', 'OBERTA', 2, NULL, 3),
('2025-04-28 08:15:00', 'El servidor de còpies de seguretat no ha executat la tasca nocturna.', 'ALTA', 'OBERTA', 7, NULL, 1),
('2025-04-30 09:45:00', 'El teclat d\'un ordinador de la biblioteca no funciona bé (tecles enganxades).', 'BAIXA', 'OBERTA', 1, NULL, 4),
('2025-05-02 10:00:00', 'No es pot accedir a la base de dades de la biblioteca des de cap terminal.', 'ALTA', 'OBERTA', 8, NULL, 5),
('2025-05-04 11:30:00', 'El correu electrònic del departament no carrega els adjunts.', 'MITJANA', 'OBERTA', 4, NULL, 2),
('2025-05-05 08:00:00', 'Problema general no identificat amb el sistema d\'autenticació corporatiu.', 'MITJANA', 'OBERTA', 9, NULL, 6),
('2025-05-06 09:30:00', 'Virus detectat en un ordinador de l\'aula d\'informàtica 2.', 'ALTA', 'OBERTA', 5, NULL, 1),
('2025-05-07 07:45:00', 'L\'ordinador del professor de Física no arrenca després del cap de setmana.', 'MITJANA', 'OBERTA', 1, NULL, 5);