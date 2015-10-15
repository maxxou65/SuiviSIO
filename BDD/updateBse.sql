-- ajouter login, password, email à la table etudiant
ALTER TABLE ETUDIANT
ADD LOGIN VARCHAR2(30) NOT NULL UNIQUE,
ADD EMAIL VARCHAR2(50) NULL,
ADD PASSWORD VARCHAR2(20) NOT NULL,
ADD ETAT VARCHAR(20) DEFAULT "EN ATTENTE";
-- attention, le login doit être unique