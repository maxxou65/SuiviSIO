-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Ven 19 Juin 2015 à 08:11
-- Version du serveur: 5.5.8
-- Version de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `suivisio`
--

-- --------------------------------------------------------

--
-- Structure de la table `classe`
--

CREATE TABLE `classe` 
(
  `CODE_CLASSE` char(20) NOT NULL,
  PRIMARY KEY (`CODE_CLASSE`)
) 
ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `classe`
--

INSERT INTO `classe` (`CODE_CLASSE`) VALUES
('DIPLOME'),
('SIO1'),
('SIO2');

-- --------------------------------------------------------

--
-- Structure de la table `connectes`
--

CREATE TABLE `connectes` 
(
  `IP` varchar(15) NOT NULL,
  `TIMESTAMP` int(11) NOT NULL
)
ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `connectes`
--

INSERT INTO `connectes` (`IP`, `TIMESTAMP`) VALUES
('194.254.62.28', 1417103870),
('193.248.162.128', 1417103859),
('127.0.0.1', 1431958758),
('172.20.248.146', 1432631585);

-- --------------------------------------------------------

--
-- Structure de la table `connexion`
--

CREATE TABLE `connexion` (
  `ID_CONNEXION` varchar(30) NOT NULL,
  `MDP_CONNEXION` varchar(30) NOT NULL,
  PRIMARY KEY (`ID_CONNEXION`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `connexion`
--

INSERT INTO `connexion` (`ID_CONNEXION`, `MDP_CONNEXION`) VALUES
('enseignant', 'qsdfghjklm'),
('etudiant', 'azertyuiop');

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `ID_CONTACT` int(11) NOT NULL AUTO_INCREMENT,
  `NOM_CONTACT` varchar(50) DEFAULT NULL,
  `PRENOM_CONTACT` varchar(50) DEFAULT NULL,
  `MAIL_CONTACT` varchar(255) DEFAULT NULL,
  `NUM_TELEPHONE` char(10) DEFAULT NULL,
  PRIMARY KEY (`ID_CONTACT`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `contact`
--

INSERT INTO `contact` (`ID_CONTACT`, `NOM_CONTACT`, `PRENOM_CONTACT`, `MAIL_CONTACT`, `NUM_TELEPHONE`) VALUES
(1, 'NR', 'NR', 'NR', '0');

-- --------------------------------------------------------

--
-- Structure de la table `dperiode`
--

CREATE TABLE `dperiode` (
  `ID_DPERIODE` bigint(4) NOT NULL AUTO_INCREMENT,
  `DATE_DEBUT` date DEFAULT NULL,
  `DATE_FIN` date DEFAULT NULL,
  PRIMARY KEY (`ID_DPERIODE`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `dperiode`
--

INSERT INTO `dperiode` (`ID_DPERIODE`, `DATE_DEBUT`, `DATE_FIN`) VALUES
(1, '2012-03-21', '2012-04-12'),
(2, '2012-01-21', '2012-03-12'),
(3, '2013-03-21', '2013-04-12'),
(4, '2013-01-21', '2013-03-12'),
(5, '2014-03-21', '2014-04-12'),
(6, '2014-01-21', '2014-03-12');

-- --------------------------------------------------------

--
-- Structure de la table `entreprise`
--

CREATE TABLE `entreprise` (
  `ID_ENTREPRISE` bigint(4) NOT NULL AUTO_INCREMENT,
  `NOM_ENTREPRISE` varchar(255) DEFAULT NULL,
  `TYPE_ENTREPRISE` int(30) NOT NULL,
  `ADRESSE_ENTREPRISE` varchar(255) DEFAULT NULL,
  `CPOSTAL_ENTREPRISE` char(5) DEFAULT NULL,
  `VILLE_ENTREPRISE` varchar(255) DEFAULT NULL,
  `TEL_ENTREPRISE` char(15) DEFAULT NULL,
  `EMAIL_ENTREPRISE` varchar(255) DEFAULT NULL,
  `ID_TUTEUR` bigint(4) DEFAULT NULL,
  `ID_CONTACT` int(100) DEFAULT NULL,
  PRIMARY KEY (`ID_ENTREPRISE`),
  KEY `FK_ENTREPRISE_TUTEUR` (`ID_TUTEUR`),
  KEY `FK_ID_CONTACT` (`ID_CONTACT`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=118 ;

--
-- Contenu de la table `entreprise`
--

INSERT INTO `entreprise` (`ID_ENTREPRISE`, `NOM_ENTREPRISE`, `TYPE_ENTREPRISE`, `ADRESSE_ENTREPRISE`, `CPOSTAL_ENTREPRISE`, `VILLE_ENTREPRISE`, `TEL_ENTREPRISE`, `EMAIL_ENTREPRISE`, `ID_TUTEUR`, `ID_CONTACT`) VALUES
(14, 'WALL-E', 1, '1 rue du robot', '11111', 'Roboland', '101010101', 'robo@wall.net', 7, 1),
(15, ' Aerazur', 1, '', ' ', 'COGNAC', '05 45 83 20 84', 'aurelien.bouillon@zodiacaerospace.com', 1, 1),
(16, ' AT INTERNET', 1, 'Parc d''activités La devèze - 8 impasse Rudolf Diesel', '33700', 'Merignac', '01 56 54 14 30', ' nicolas.boineau@atinternet.com', 1, 1),
(17, 'Auto-école du Littoral', 1, ' 17, Rue Pujos', '17300', 'ROCHEFORT', '05 46 87 69 69', ' aedulittoral@laposte.net', 1, 1),
(18, ' Base aérienne 721', 1, '', '17133', 'Rochefort AIR', '05 46 88 83 38', 'eric,lutas@intradef.gouv.fr', 1, 1),
(19, ' Dokimedia', 2, '29 Rue du Général Dumont', ' \n170', 'La Rochelle', '05 46 30 09 37', ' michel@dokimedia.fr', 1, 1),
(20, ' Léa Nature', 9, '23 Avenue Paul Langevin,', '17183', 'Perigny Cedex', '05 46 52 00 81', ' jm.bourreau@leanature.com', 1, 1),
(21, ' Novatique', 1, '17 place Joffre', '\n5640', 'AURAY', ' 06 45 60 95 13', ' frederic.rault@novatique.com', 1, 1),
(22, ' Pays Rochefortais', 1, '3 avenue Maurice Chupin Parc des Fouriers', '17300', 'Rochefort', '05 46 82 40 57', ' f.paticat@cda-paysrochefortais.fr', 1, 1),
(23, ' Sacrée Com', 6, '15 rue Renouleau', '\n1743', 'Tonnay-Charente', ' 06 86 21 50 51', ' jppetit@sacreecom.org', 1, 1),
(24, ' TESSI TECHNOLOGIES', 3, ' 1-3 Avenue des Satellites', '33185', 'Le Haillan', ' 05 57 22 20 61', ' nicolas.schmitt@tessi.fr', 1, 1),
(25, '4DConcept', 3, '41-43 Avenue du centre MONTIGNY LE BRETONNEUX', '78180', 'MONTIGNY LE BRETONNEUX', '01 61 08 50 20', 'mathieu.balcerak@4dconcept.fr', 1, 1),
(26, '6 TEM'' INFORMATIQUE', 3, ' 2 RD 734', '17550', 'Dolus', '05 46 36 70 70', 'durand.cyril@wanadoo.fr', 1, 1),
(27, 'A2I Informatique SAS', 3, ' Rue Augustin Fresnel –', '17183', 'PERIGNY', '05 46 57 69 71', 'vpacomme@novenci.fr', 1, 1),
(28, 'A2I Informatique SAS', 3, 'ZAC Les Montagnes BP5', '16430', 'CHAMPNIERS', '05 43 37 18 08', 'vpacomme@novenci.fr', 1, 1),
(29, 'ACT Service', 3, '18 rue de la Bonnette\nLes minimes', '17000', 'La Rochelle', '05 46 44 44 59', '', 1, 1),
(30, 'AKROMICRO', 3, '20 bis, Rue Albert Einstein', '17000', 'La Rochelle', '05 46 07 35 14', 'akromicro@hotmail.com', 1, 1),
(31, 'ALPMS', 10, '3, Rue J.B. Charcot', '17000', 'La Rochelle', '05 46 41 32 32', 'louis.leblevec@wanadoo.fr', 1, 1),
(32, 'Alstom', 9, 'Avenue Commdt Lysiack', '17440', 'Aytré', '', 'stephane.petit@itc.alstom.com', 1, 1),
(33, 'Archipel', 10, '', '17300', 'ROCHEFORT', '', 'support@archipelweb.fr', 1, 1),
(34, 'Astron Associate SA', 9, 'Ch du grand Puits 38\nCP 339\nCH – 1217 Meyrin - 1', '', 'Meyrin- Suisse', '0041 76 324 05', 'jean-christophe@astron-assoc.com', 1, 1),
(35, 'CAF', 11, '', '17000', 'LA ROCHELLE', '', '', 1, 1),
(36, 'CARA', 11, '107 avenue de ROCHEFORT', '17200', 'Royan', '05 46 22 19 14', 'f.pinet@agglo-royan,fr', 1, 1),
(37, 'Caserne Renaudin', 12, 'av Porte Dauphine', '17000', 'LA ROCHELLE', '05 46 51 45 70', 'pierre.naudet@base-transit.com', 1, 1),
(38, 'CC17', 3, '37 rue du Dr Peltier', '17300', 'ROCHEFORT', '546875608', '', 1, 1),
(39, 'Centre hospitalier de Rochefort', 13, '16, Rue du Docteur Peltier', '17300', 'ROCHEFORT', '05 46 82 20 36', 'thierry.moscato@ch-rochefort.fr', 1, 1),
(40, 'Centre hospitalier de Royan', 13, '', '17205', 'Royan', '05 46 39 52 43', 'direction@ch-royan.fr', 1, 1),
(41, 'Centre Hospitalier De SaintongeAlstom', 13, '11 Bd Ambroise Paré\nBP326', '17108', 'SAINTES', '05-46-95-12-70', 'v.mahau@saintonge.fr', 1, 1),
(42, 'Cetios', 1, 'Allée de la Baucette', '17700', 'Surgères', '05 46 07 68 00', ' ', 1, 1),
(43, 'CH Jonzac', 13, ' Av, Winston churchild, BP 109', '17503', 'Jonzac', '05 46 48 75 68', 'c,pesnel@ch-jonzac.fr', 1, 1),
(44, 'Chambre de commerce', 11, 'Corderie Royale - BP 20 129 -', '17306', 'ROCHEFORT', '05 46 84 11 75', 'f.moreno@rochefort.cci.fr', 1, 1),
(45, 'cipecma', 14, '', '17340', 'Chatelaillon', '', '', 1, 1),
(46, 'Clinique Pasteur', 13, '', '17200', 'Royan', '05 46 22 22 33', 'epechereau@clinique-pasteur-royan.fr', 1, 1),
(47, 'CMAF', 11, '', '17000', 'LA ROCHELLE', '', '', 1, 1),
(48, 'Communauté d''agglomération de la rochelle', 11, '', '17180', 'PERIGNY', '06-84-53-23-70\n', 'laurent.cagna@agglo-larochelle.fr', 1, 1),
(49, 'CYBERNET COPY 17', 3, ' 37, rue du Docteur Peltier', '17300', 'ROCHEFORT', '05 46 87 56 08', 'cc17@wanadoo.fr', 1, 1),
(50, 'CYBERTEK', 3, '\nAvenue Fourneaux', '17690', 'ANGOULINS SUR MER', '05 46 42 46 33', 'angoulins@cybertek.fr', 1, 1),
(51, 'DATACLIC', 3, '\n47, Rue Pierre de Campet', '17600', 'SAUJON', '05 46 06 65 45', 'contact@dataclic.fr\nAlexandre.ozon@wanadoo.fr', 1, 1),
(52, 'DDAF-', 11, '', '17000', 'LA ROCHELLE', '05 46 68 61 18', '', 1, 1),
(53, 'DDSV', 11, '', '17000', 'LA ROCHELLE', '05 46 68 61 44', '', 1, 1),
(54, 'DELAMET SAS', 9, '\n16, Rue Gambetta', '17360', 'Saint Aigulin', '05 46 04 08 08', 't.huchet@delamet.com', 1, 1),
(55, 'DIGITAL', 3, '\nLes Montagnes', '16430', 'CHAMPNIERS', '05 45 37 15 30', 'contact@cardinaud-hall.com', 1, 1),
(56, 'Easy info 17', 3, 'Avenue des vignes', '17320', 'St Just Luzac', '06 99 70 08 29', '', 1, 1),
(57, 'EASY ORDI.COM', 3, '42, Rue de la République', '17300', 'ROCHEFORT', '05 46 99 15 54', 'nicolas.s@easy-ordi.com', 1, 1),
(58, 'EIGSI -', 14, '', '17000', 'La Rochelle', '', 'olivier.nerrand@eigsi.fr', 1, 1),
(59, 'ENILIA – ENSMIC', 14, 'Avenue François Mitterand BP 49', '17700', 'SURGERES', '05 46 27 69 09', 'julien.coutant@educagri.fr', 1, 1),
(60, 'ERDF', 11, 'rue Chauvin', '17300', 'ROCHEFORT', '', '', 1, 1),
(61, 'exedra', 15, '29 avenue des martyrs de la liberation', '33700', 'merignac', '05 56 13 86 44', 'ronald.laloue@exedra.fr', 1, 1),
(62, 'GARANDEAU FRERES Chamblanc', 1, '', '16370', 'Cherves-Richemont', '05.45.83.24.11', '', 1, 1),
(63, 'Groupe Coop Atlantique', 9, '3 rue du docteur jean', '17100', 'SAINTES', '681482711', 'jroy@coop-atlantique.fr', 1, 1),
(64, 'Groupe Gibaud', 16, '15 rue de l''ormeau du Pied Saintes', '17100', 'SAINTES', '', 'js.boncour@barns.fr', 1, 1),
(65, 'Groupe SUP DE CO', 14, '102, Rue de Coureilles', '17000', 'La Rochelle', '05 46 51 77 42', 'pierrel@esc-larochelle.fr', 1, 1),
(66, 'Hôpital Rochefort', 13, '1 avenue Bélingon', '17300', 'ROCHEFORT', '05 46 88 50 50', 'thierry.moscato@ch-rochefort.fr', 1, 1),
(67, 'IN TECH', 3, ' 2bis, rue Ferdinand Gateau', '17430', 'Tonnay Charente', '05 46 87 35 10', 'in-tech.fr', 1, 1),
(68, 'IUT La Rochelle', 14, '15 rue François De Vaux Foletier 17026 LA ROCHELE cedex 01', '17000', 'La Rochelle', '05 46 51 39 26', 'charly@univ-lr.fr', 1, 1),
(69, 'J.C.M', 9, 'Investissements Avenue Jean-Paul Sartre\nGroupe Michel 163 Avenue Jean-Paul SARTRE', '17000', 'La Rochelle', '05 46 44 01 00', 'jean.praille.larochelle@reseau.renault.fr\ninformatique@groupemichel.com', 1, 1),
(70, 'Jean-Noël Informatique', 3, '37 avenue d''aunis', '17430', 'tonnay-charente', '05 46 88 06 93', 'jni17@orange.fr', 1, 1),
(71, 'KUEHNE+NAGEL DSIA', 1, '16 rue de la petite sensive', '44323', 'Nantes', '02 51 81 85 85', 'patrice.huteau@kuehne-nagel.com', 1, 1),
(72, 'LEA Nature', 1, '', '', '', '', '', 1, 1),
(73, 'LP Jean Rostand louise lériget', 14, '', '16000', 'Angouleme', '05 45 97 45 42', '', 1, 1),
(74, 'Lycee bellevue', 14, '', '17100', 'SAINTES', '', '', 1, 1),
(75, 'Lycée Bernard Palissy', 14, '1, Rue de Gascogne', '17100', 'SAINTES', '05 46 92 08 15', 'ce.0170060y@ac-poitiers.fr', 1, 1),
(76, 'lycée Georges Desclaude', 14, 'rue Georges Desclaude', '17100', ' Saintes', '546933122', '', 1, 1),
(77, 'Lycée georges Leygues', 14, '', '47300', 'Villeneuvelot', '', '', 1, 1),
(78, 'Lycée Jamain', 14, '2A Boulevard Pouzet', '17300', 'ROCHEFORT', '05 46 99 06 68', 'sebastien.celerier@ac-poitiers.fr', 1, 1),
(79, 'Lycée Jean DAUTET', 14, '', '17000', 'La Rochelle', 'non donné', 'ph.petit@cr-poitou-charnentes.f', 1, 1),
(80, 'Lycée Léonce Vieljeux', 14, 'Rue des Gonthières', '17000', 'La Rochelle', '546347932', 'cedric.regeon@ac-poitiers.fr', 1, 1),
(81, 'Lycée Marcel Dassault -', 14, '', '17300', 'ROCHEFORT', '05 46 88 13 09', 'nicolas.wojciechowski@ac-poitiers.fr', 1, 1),
(82, 'lycée Professionnel Régional Industriel Louis Delage', 14, '', '16100', 'COGNAC', '05 45 35 86 70', '', 1, 1),
(83, 'Lycée Professionnel Rompsay', 14, ' Rue de Périgny', '17025', 'La Rochelle', '', 'atp-rompsay@ac-poitiers.fr', 1, 1),
(84, 'Lycée Victor hugo', 14, '', '86000', 'Poitiers', '05 49 41 91 04', 'mickael.guerin@lyc-victorhugo.ac-poitiers.fr', 1, 1),
(85, 'MAAF Assurances\nSA Chauray', 17, '', '79036', 'Niort', '05 49 34 35 36', 'antonino.cacace@maaf.fr', 1, 1),
(86, 'Maiano Informatique', 0, ' 17 rue de l''électricité 17200 Royan', '17200', 'Royan', '05 46 49 48 68', 'contact@maianoinfo.com', 1, 1),
(87, 'Mairie de Chatelaillon', 11, '', '17340', 'Chatelaillon', '', '', 1, 1),
(88, 'Mairie de Meschers', 1, ' 8 rue Paul Massy', '17132', 'MESCHERS SUR GIRONDE', ' 05 46 39 71 13', ' informatique@meschers.com', 1, 1),
(89, 'Mairie de Poitiers Informatique', 1, 'Rue du Dolmen', '86000', 'Poitiers', '05 49 30 81 55', ' ', 1, 1),
(90, 'Mairie de Pont l''Abbé d''Arnoult.', 11, 'Place du général de Gaulle', '17250', 'Pont l''Abbé d''Arnoult', '06 80 07 12 21', 'yannick.dieu@wanadoo.fr', 1, 1),
(91, 'MAIRIE DE ROYAN', 11, ' 80, avenue de Pontaillac', '17200', 'Royan', '05 46 39 56 56', 'f.chauveau@mairie-royan.fr', 1, 1),
(92, 'Mairie de Saintes', 11, '', '17100', 'SAINTES', '', '', 1, 1),
(93, 'MAIRIE DE SAUJON ', 11, 'Hotel de ville\nBP 108', '17600', 'SAUJON', '05 46 02 94 71', 'mediatheque_saujon@hotmail.com', 1, 1),
(94, 'Maison de l''emploi', 1, 'Parc des Fourriers', '17300', 'ROCHEFORT', '546998000', 'e.ecale@mde-paysrochefortais.fr', 1, 1),
(95, 'Malichaud atlantique', 9, '13 rue Hubert Pennevert', '17300', 'ROCHEFORT', '05 46 84 79 19', 'david.carre@malichaudatlantique.com', 1, 1),
(96, 'MAPA\nMutuelle d''Assurance', 17, '\nRue Anatole Contré', '17400', 'Saint Jean d''Angély', '05 46 59 54 16', 'service.informatique@mapa-assurances.com', 1, 1),
(97, 'Metal Néo', 1, 'ZI des Soeurs, 21 Boulevard du vercors', '17300', ' Rochefort', ' ', '', 1, 1),
(98, 'MSA', 17, '', '16000', 'Angouleme', '05 45 97 81 60', 'nicoine.pascal@msa16.msa.fr', 1, 1),
(99, 'NEOPC', 3, 'ZI OUEST voie C', '17700', 'SURGERES', '05 46 30 09 71', 'neopc1@orange.fr', 1, 1),
(100, 'NEVA technologies', 1, '40 Rue de Marignan', '16', ' Cognac', '545352725', '', 1, 1),
(101, 'ORECO S.A.', 9, '44 bd Oscar Planat', '16100', 'COGNAC', '05 45 35 13 83', 'daniel.desaintours@oreco.fr\nchristophe.raffier@oreco.fr', 1, 1),
(102, 'PRODWARE', 1, '9 rue jacques cartier', '17440', 'AYTRE', '06 76 48 28 35', 'jprobbe@prodware.fr', 1, 1),
(103, 'SAINTRONIC ', 1, 'parc atlantique, l''ormeau de pied', '17101', 'SAINTES', '546927152', 'jean-jacques,paille@saintronic,fr', 1, 1),
(104, 'SARL A.I.P.C', 3, '. 18, route de Frontenay RUFFIGNY', '79260', 'LA CRECHE', '05 49 75 19 19', 'eric.carlet@aipc-info.fr', 1, 1),
(105, 'SARL Concept Joueur Cité Joueur', 3, '\n15, rue Jean Fougerat', '16000', 'Angouleme', '06 68 91 71 88', 'n.viroulaud@citejoueur.com', 1, 1),
(106, 'SARL DIF', 1, '\n25 route de Cognac', '17520', 'Archiac', ' ', ' ', 1, 1),
(107, 'SARL LE MONDE DU PC', 3, ' 16,rue G. Claude', '17640', 'Vaux Sur Mer', '05 46 22 06 57', '', 1, 1),
(108, 'SARL Top Micro', 3, ' 85, avenue de Gaulle', '17300', 'ROCHEFORT', '05 46 87 04 28', '', 1, 1),
(109, 'Satti informatique', 3, '\nrue Augustin Fresnel ZI', '17183', 'PERIGNY', '05 46 51 65 65', 'vthoulon@novenci,fr', 1, 1),
(110, 'Services-emedia', 1, '\n12 rue de la boulangerie', '17330', 'Bernay Saint-Martin', '05 16 51 70 43', 'contact@services-emedia,fr', 1, 1),
(111, 'SIR Poitou-Charentes ', 11, '14, Rue des ?', '86035', 'Poitiers', '05 49 50 37 46', 'am@sir-poitou-charentes.fr', 1, 1),
(112, 'SODISROY', 18, '\n2 rue Lavoisier', '17201', 'Royan', '05 46 05 11 89', '/', 1, 1),
(113, 'SOGEMAP', 3, '\n40, Rue de Marignan', '16100', 'COGNAC', '05 45 35 27 25', 'bmachefert@nevatec.fr', 1, 1),
(114, 'STEF INFORMATIX', 3, ' 61, av. Lafayette', '17300', 'ROCHEFORT', '06 80 07 19 16', 'contact@stefinformatix.com', 1, 1),
(115, 'Syndicat Informatique', 11, '', '17100', 'SAINTES', '05 46 92 39 05', 'j.piekarek@si17.fr', 1, 1),
(116, 'TOP MICRO', 3, '85, Rue Charles de Gaulle', '17300', 'ROCHEFORT', '05 46 87 04 28', 'top.micro17@wanadoo.fr', 1, 1),
(117, 'URANIE', 3, ' Zone d''activité des docks maritimes\nBat A Quai Carriet', '33310', 'Lormont', '05 56 39 79 08', 'sylvain.berger@uranie-conseil.fr', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE `etudiant` (
  `ID_ETU` bigint(4) NOT NULL AUTO_INCREMENT,
  `ID_ORIGINE` bigint(4) DEFAULT NULL,
  `ID_PROMOTION` bigint(4) DEFAULT NULL,
  `CODE_SPECIALITE` char(20) DEFAULT NULL,
  `CODE_CLASSE` char(20) DEFAULT NULL,
  `NOM_ETU` varchar(255) DEFAULT NULL,
  `PRENOM_ETU` varchar(255) DEFAULT NULL,
  `DNAISSANCE_ETU` date DEFAULT NULL,
  `DOUBLANT1_ETU` tinyint(1) DEFAULT NULL,
  `DOUBLANT2_ETU` tinyint(1) DEFAULT NULL,
  `DIPLOME_ETU` tinyint(1) DEFAULT NULL,
  `REGIME` char(20) DEFAULT NULL,
  PRIMARY KEY (`ID_ETU`),
  KEY `I_FK_ETUDIANT_ORIGINE` (`ID_ORIGINE`),
  KEY `FK_ETUDIANT_PROMOTION` (`ID_PROMOTION`),
  KEY `FK_ETUDIANT_SPECIALITE` (`CODE_SPECIALITE`),
  KEY `FK_ETUDIANT_CLASSE` (`CODE_CLASSE`),
  KEY `FK_ETUDIANT_REGIME` (`REGIME`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4;

--
-- Contenu de la table `etudiant`
--

INSERT INTO `etudiant` (`ID_ETU`, `ID_ORIGINE`, `ID_PROMOTION`, `CODE_SPECIALITE`, `CODE_CLASSE`, `NOM_ETU`, `PRENOM_ETU`, `DNAISSANCE_ETU`, `DOUBLANT1_ETU`, `DOUBLANT2_ETU`, `DIPLOME_ETU`, `REGIME`) VALUES
(1, 1, 7, 'SLAM', 'SIO2', 'Lozano', 'Anthony', '1994-03-13', 0, 0, NULL, 'Externe'),
(2, 2, 7, 'SLAM', 'SIO2', 'Gillet', 'Maximilien', '1995-08-02', 0, 0, NULL, 'Demi-Pensionnaire'),
(3, 3, 7, 'SLAM', 'SIO2', 'Mayeur', 'Olivier', '1992-12-17', 0, 0, NULL, 'Interne');



-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `fiche_entreprise`
--
CREATE TABLE `fiche_entreprise` (
`CODE_CLASSE` char(20)
,`NOM_ETU` varchar(255)
,`PRENOM_ETU` varchar(255)
,`CODE_SPECIALITE` char(20)
,`DATE_DEBUT` date
,`DATE_FIN` date
,`NOM_TUTEUR` varchar(255)
,`NOM_PROF` varchar(255)
);
-- --------------------------------------------------------

--
-- Structure de la table `origine`
--

CREATE TABLE `origine` (
  `ID_ORIGINE` bigint(4) NOT NULL AUTO_INCREMENT,
  `BAC_ORIGINE` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_ORIGINE`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `origine`
--

INSERT INTO `origine` (`ID_ORIGINE`, `BAC_ORIGINE`) VALUES
(1, 'BAC S'),
(2, 'BAC ES'),
(3, 'BAC STG'),
(4, 'BAC STI'),
(5, 'BAC PRO');

-- --------------------------------------------------------

--
-- Structure de la table `periode`
--

CREATE TABLE `periode` (
  `ID_PERIODE` bigint(4) NOT NULL AUTO_INCREMENT,
  `ID_DPERIODE` bigint(4) DEFAULT NULL,
  PRIMARY KEY (`ID_PERIODE`),
  KEY `FK_PERIODE_DPERIODE` (`ID_DPERIODE`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `periode`
--

INSERT INTO `periode` (`ID_PERIODE`, `ID_DPERIODE`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6);

-- --------------------------------------------------------

--
-- Structure de la table `professeur`
--

CREATE TABLE  `professeur` (
  `ID_PROF` int(2) NOT NULL AUTO_INCREMENT,
  `MAT_PROF` varchar(128) DEFAULT NULL,
  `NOM_PROF` varchar(255) DEFAULT NULL,
  `PRENOM_PROF` varchar(255) DEFAULT NULL,
  `TEL_PROF` int(11) DEFAULT NULL,
  `MAIL_PROF` varchar(255) DEFAULT NULL,
  `LOGIN_PROF` varchar(255) DEFAULT NULL,
  `MDP_PROF` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_PROF`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `professeur`
--

INSERT INTO `professeur` (`ID_PROF`, `MAT_PROF`, `NOM_PROF`, `PRENOM_PROF`, `TEL_PROF`, `MAIL_PROF`, `LOGIN_PROF`, `MDP_PROF`) VALUES
(1, 'JCC', 'Castillo', 'Jean Christophe', 123456789, 'jcc@lmp.fr', 'jccastillo', 'castillo'),
(2, 'FC', 'Fichet', 'Claude', 223456789, 'fc@lmp.fr', 'cfichet', 'fichet'),
(3, 'BB', 'Bouchereau', 'Bertrand', 323456789, 'bb@lmp.fr', 'bbouchereau', 'bouchereau'),
(4, 'PSO', 'Sore', 'Pascal', 323456789, 'pso@lmp.fr', 'psore', 'sore'),
(5, 'FJ', 'Jarnan', 'Florence', 323456789, 'fj@lmp.fr', 'fjarnan', 'jarnan'),
(6, 'LR', 'Reyx', 'Laurent', 0, 'lr@lmp.fr', 'lreyx', 'reyx');

-- --------------------------------------------------------

--
-- Structure de la table `promotion`
--

CREATE TABLE `promotion` (
  `ID_PROMOTION` bigint(4) NOT NULL AUTO_INCREMENT,
  `ANNEE` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_PROMOTION`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `promotion`
--

INSERT INTO `promotion` (`ID_PROMOTION`, `ANNEE`) VALUES
(1, '2009'),
(2, '2010'),
(3, '2011'),
(4, '2012'),
(5, '2013'),
(6, '2014'),
(7, '2015');

-- --------------------------------------------------------

--
-- Structure de la table `regime`
--

CREATE TABLE `regime` (
  `REGIME` char(20) NOT NULL,
  PRIMARY KEY (`REGIME`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `regime`
--

INSERT INTO `regime` (`REGIME`) VALUES
('Demi-Pensionnaire'),
('Externe'),
('Interne');

-- --------------------------------------------------------

--
-- Structure de la table `specialite`
--

CREATE TABLE `specialite` (
  `CODE_SPECIALITE` char(20) NOT NULL,
  `LIB_SPECIALITE` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`CODE_SPECIALITE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `specialite`
--

INSERT INTO `specialite` (`CODE_SPECIALITE`, `LIB_SPECIALITE`) VALUES
('SISR', 'Solutions d''Infrastructure Systèmes et Réseaux'),
('SLAM', 'Solutions Logicielles et Applications Metiers');

-- --------------------------------------------------------

--
-- Structure de la table `stage`
--

CREATE TABLE `stage` (
  `ID_STAGE` bigint(4) NOT NULL AUTO_INCREMENT,
  `ID_PROF` int(2) NOT NULL,
  `ID_ETU` bigint(4) NOT NULL,
  `ID_ENTREPRISE` bigint(4) NOT NULL,
  `ID_PERIODE` bigint(4) NOT NULL,
  `ID_PROF_VISITER` int(2) DEFAULT NULL,
  `CLASSE_STAGE` varchar(32) DEFAULT NULL,
  `CONTENU` varchar(350) NOT NULL,
  `ID_TUTEUR` bigint(4) NOT NULL,
  PRIMARY KEY (`ID_STAGE`),
  KEY `I_FK_STAGE_PROFESSEUR` (`ID_PROF`),
  KEY `I_FK_STAGE_ETUDIANT` (`ID_ETU`),
  KEY `I_FK_STAGE_ENTREPRISE` (`ID_ENTREPRISE`),
  KEY `I_FK_STAGE_PERIODE` (`ID_PERIODE`),
  KEY `I_FK_STAGE_PROFESSEUR1` (`ID_PROF_VISITER`),
  KEY `FK_ID_TUTEUR` (`ID_TUTEUR`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

--
-- Contenu de la table `stage`
--

-- --------------------------------------------------------

--
-- Structure de la table `tuteur`
--

CREATE TABLE `tuteur` (
  `ID_TUTEUR` bigint(4) NOT NULL AUTO_INCREMENT,
  `NOM_TUTEUR` varchar(255) DEFAULT NULL,
  `PRENOM_TUTEUR` varchar(255) DEFAULT NULL,
  `SERVICE_TUTEUR` varchar(255) DEFAULT NULL,
  `STATUT_TUTEUR` varchar(255) DEFAULT NULL,
  `TEL_TUTEUR` varchar(20) DEFAULT NULL,
  `MAIL_TUTEUR` varchar(255) DEFAULT NULL,
  `ID_ENTREPRISE` bigint(4) NOT NULL,
  PRIMARY KEY (`ID_TUTEUR`),
  KEY `FK_ID_ENTREPRISE` (`ID_ENTREPRISE`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `tuteur`
--

-- --------------------------------------------------------

--
-- Structure de la table `type_entreprise`
--

CREATE TABLE `type_entreprise` (
  `ID_TYPE_ENTREPRISE` int(11) NOT NULL AUTO_INCREMENT,
  `TYPE` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_TYPE_ENTREPRISE`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Contenu de la table `type_entreprise`
--

INSERT INTO `type_entreprise` (`ID_TYPE_ENTREPRISE`, `TYPE`) VALUES
(1, 'INCONNU'),
(2, 'Agence web'),
(3, 'ESN'),
(4, 'Mairie'),
(5, 'Société d ingienerie'),
(6, 'Agence de communication'),
(7, 'Grande surface'),
(8, 'Agence de création'),
(9, 'Industrie'),
(10, 'Association'),
(11, 'Administration'),
(12, 'Armée'),
(13, 'Hopital'),
(14, 'Lycée'),
(15, 'Conseil'),
(16, 'Concessionnaire auto'),
(17, 'Assurance'),
(18, 'Commerce');

-- --------------------------------------------------------

--
-- Structure de la vue `fiche_entreprise`
--
DROP TABLE `fiche_entreprise`;

CREATE VIEW `fiche_entreprise` AS select `etudiant`.`CODE_CLASSE` 
AS `CODE_CLASSE`,`etudiant`.`NOM_ETU` AS `NOM_ETU`,`etudiant`.`PRENOM_ETU` AS `PRENOM_ETU`,`etudiant`.`CODE_SPECIALITE` AS `CODE_SPECIALITE`,
`dperiode`.`DATE_DEBUT` AS `DATE_DEBUT`,`dperiode`.`DATE_FIN` AS `DATE_FIN`,`tuteur`.`NOM_TUTEUR` AS `NOM_TUTEUR`,`professeur`.`NOM_PROF` AS 
`NOM_PROF` from ((((((`etudiant` join `stage` on((`etudiant`.`ID_ETU` = `stage`.`ID_ETU`))) join `periode` on((`periode`.`ID_PERIODE` = `stage`.`ID_PERIODE`))) join `dperiode` on((`dperiode`.`ID_DPERIODE` = `periode`.`ID_DPERIODE`))) join `entreprise` 
on((`entreprise`.`ID_ENTREPRISE` = `stage`.`ID_ENTREPRISE`))) join `tuteur` on((`tuteur`.`ID_TUTEUR` = `entreprise`.`ID_TUTEUR`))) 
join `professeur` on((`professeur`.`ID_PROF` = `stage`.`ID_PROF`)));

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `entreprise`
--
ALTER TABLE `entreprise`
  ADD CONSTRAINT `ENTREPRISE_ibfk_1` FOREIGN KEY (`ID_TUTEUR`) REFERENCES `tuteur` (`ID_TUTEUR`),
  ADD CONSTRAINT `FK_ID_CONTACT` FOREIGN KEY (`ID_CONTACT`) REFERENCES `contact` (`ID_CONTACT`);

--
-- Contraintes pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD CONSTRAINT `ETUDIANT_ibfk_1` FOREIGN KEY (`ID_ORIGINE`) REFERENCES `origine` (`ID_ORIGINE`),
  ADD CONSTRAINT `ETUDIANT_ibfk_2` FOREIGN KEY (`ID_PROMOTION`) REFERENCES `promotion` (`ID_PROMOTION`),
  ADD CONSTRAINT `ETUDIANT_ibfk_3` FOREIGN KEY (`CODE_SPECIALITE`) REFERENCES `specialite` (`CODE_SPECIALITE`),
  ADD CONSTRAINT `ETUDIANT_ibfk_4` FOREIGN KEY (`CODE_CLASSE`) REFERENCES `classe` (`CODE_CLASSE`),
  ADD CONSTRAINT `ETUDIANT_ibfk_5` FOREIGN KEY (`REGIME`) REFERENCES `regime` (`REGIME`);

--
-- Contraintes pour la table `periode`
--
ALTER TABLE `periode`
  ADD CONSTRAINT `PERIODE_ibfk_1` FOREIGN KEY (`ID_DPERIODE`) REFERENCES `dperiode` (`ID_DPERIODE`);

--
-- Contraintes pour la table `stage`
--
ALTER TABLE `stage`
  ADD CONSTRAINT `FK_ID_TUTEUR` FOREIGN KEY (`ID_TUTEUR`) REFERENCES `tuteur` (`ID_TUTEUR`),
  ADD CONSTRAINT `STAGE_ibfk_2` FOREIGN KEY (`ID_PROF`) REFERENCES `professeur` (`ID_PROF`),
  ADD CONSTRAINT `STAGE_ibfk_3` FOREIGN KEY (`ID_ETU`) REFERENCES `etudiant` (`ID_ETU`),
  ADD CONSTRAINT `STAGE_ibfk_4` FOREIGN KEY (`ID_ENTREPRISE`) REFERENCES `entreprise` (`ID_ENTREPRISE`),
  ADD CONSTRAINT `STAGE_ibfk_5` FOREIGN KEY (`ID_PERIODE`) REFERENCES `periode` (`ID_PERIODE`),
  ADD CONSTRAINT `STAGE_ibfk_6` FOREIGN KEY (`ID_PROF_VISITER`) REFERENCES `professeur` (`ID_PROF`);

--
-- Contraintes pour la table `tuteur`
--
ALTER TABLE `tuteur`
  ADD CONSTRAINT `FK_ID_ENTREPRISE` FOREIGN KEY (`ID_ENTREPRISE`) REFERENCES `entreprise` (`ID_ENTREPRISE`);
