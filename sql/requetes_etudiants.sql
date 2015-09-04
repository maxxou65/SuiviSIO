-- ======================================
-- Nom du fichier : requetes_etudiants.sql
-- Dates : Septembre/Octobre 2014
-- Rôle : Contient les ordres SQL effecutés dans le module "Etudiants"
-- Auteur(s) : Maximilien Gilet
-- ======================================

-- ======================================
-- Afficher les information sur les étudiants
-- expl_donnes_etudiants

SELECT ID_ETU, NOM_ETU, PRENOM_ETU, DNAISSANCE_ETU, BAC_ORIGINE, CLASSE.CODE_CLASSE, CODE_SPECIALITE, ANNEE, DOUBLANT1_ETU, DOUBLANT2_ETU, DIPLOME_ETU 
FROM ETUDIANT 
INNER JOIN ORIGINE on ETUDIANT.ID_ORIGINE=ORIGINE.ID_ORIGINE 
inner join PROMOTION on ETUDIANT.ID_PROMOTION=PROMOTION.ID_PROMOTION 
inner join CLASSE on ETUDIANT.CODE_CLASSE=CLASSE.CODE_CLASSE;

-- ======================================
-- Mettre à jour les données sur les stages
--