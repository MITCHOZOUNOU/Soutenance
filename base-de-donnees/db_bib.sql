-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 12 nov. 2023 à 10:25
-- Version du serveur : 5.7.36
-- Version de PHP : 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_bib`
--

-- --------------------------------------------------------

--
-- Structure de la table `auteur`
--

DROP TABLE IF EXISTS `auteur`;
CREATE TABLE IF NOT EXISTS `auteur` (
  `num_aut` int(11) NOT NULL AUTO_INCREMENT,
  `nom_aut` varchar(255) DEFAULT NULL,
  `prenoms_aut` varchar(255) DEFAULT NULL,
  `creer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `est_actif` int(11) NOT NULL DEFAULT '1',
  `est_supprimer` int(11) NOT NULL DEFAULT '0',
  `maj_le` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`num_aut`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `date_parution`
--

DROP TABLE IF EXISTS `date_parution`;
CREATE TABLE IF NOT EXISTS `date_parution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_ouvrage` int(11) NOT NULL,
  `id_langue` int(11) NOT NULL,
  `date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `est_actif` int(11) NOT NULL DEFAULT '1',
  `est_supprimer` int(11) NOT NULL DEFAULT '0',
  `créer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mis_a_jour_le` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `date_parution_ouvrage_cod_ouv` (`id_ouvrage`),
  KEY `date_parution_langue_cod_lang` (`id_langue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `domaine`
--

DROP TABLE IF EXISTS `domaine`;
CREATE TABLE IF NOT EXISTS `domaine` (
  `cod_dom` int(11) NOT NULL AUTO_INCREMENT,
  `lib_dom` varchar(255) DEFAULT NULL,
  `creer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `est_actif` int(11) NOT NULL DEFAULT '1',
  `est_supprimer` int(11) NOT NULL DEFAULT '0',
  `maj_le` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cod_dom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `emprumt`
--

DROP TABLE IF EXISTS `emprumt`;
CREATE TABLE IF NOT EXISTS `emprumt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num_emp` varchar(255) NOT NULL,
  `num_mem` int(11) NOT NULL,
  `date_approbation` varchar(255) DEFAULT NULL,
  `date_butoir_retour` varchar(255) DEFAULT NULL,
  `est_actif` int(11) NOT NULL DEFAULT '1',
  `est_supprimer` int(11) NOT NULL DEFAULT '0',
  `creer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `maj_le` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `emprumt_utilisateur_id` (`num_mem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `langue`
--

DROP TABLE IF EXISTS `langue`;
CREATE TABLE IF NOT EXISTS `langue` (
  `cod_lang` int(11) NOT NULL AUTO_INCREMENT,
  `lib_lang` varchar(255) DEFAULT NULL,
  `creer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `est_actif` int(11) NOT NULL DEFAULT '1',
  `est_supprimer` int(11) NOT NULL DEFAULT '0',
  `maj_le` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cod_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `membre_indelicat`
--

DROP TABLE IF EXISTS `membre_indelicat`;
CREATE TABLE IF NOT EXISTS `membre_indelicat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num_mem` int(11) NOT NULL,
  `num_emp` varchar(255) NOT NULL,
  `cod_ouv` int(11) NOT NULL,
  `date_butoir_retour` varchar(255) NOT NULL,
  `date_effective_retour` varchar(255) DEFAULT NULL,
  `etat_ouvrage` varchar(255) DEFAULT NULL,
  `banque` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `numero_compte` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `est_actif` int(11) NOT NULL DEFAULT '1',
  `est_supprimer` int(11) NOT NULL DEFAULT '0',
  `creer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `maj_le` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `membre_indelicat_utilisateur_id` (`num_mem`),
  KEY `membre_indelicat_ouvrage_cod_ouv` (`cod_ouv`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ouvrage`
--

DROP TABLE IF EXISTS `ouvrage`;
CREATE TABLE IF NOT EXISTS `ouvrage` (
  `cod_ouv` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `nb_ex` int(11) NOT NULL,
  `nb_emprunter` int(11) DEFAULT NULL,
  `periodicite` varchar(255) NOT NULL,
  `num_aut` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `creer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `est_actif` int(11) NOT NULL DEFAULT '1',
  `est_supprimer` int(11) NOT NULL DEFAULT '0',
  `maj_le` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cod_ouv`),
  KEY `num_aut` (`num_aut`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ouvrages_auteurs_secondaires`
--

DROP TABLE IF EXISTS `ouvrages_auteurs_secondaires`;
CREATE TABLE IF NOT EXISTS `ouvrages_auteurs_secondaires` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_ouvrage` int(11) NOT NULL,
  `id_auteur_secondaire` int(11) NOT NULL,
  `est_actif` int(11) NOT NULL DEFAULT '1',
  `est_supprimer` int(11) NOT NULL DEFAULT '0',
  `créer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mis_a_jour_le` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ouvrages_auteurs_secondaires_ouvrage_cod_ouv` (`id_ouvrage`),
  KEY `ouvrages_auteurs_secondaires_auteur_num_aut` (`id_auteur_secondaire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ouvrages_domaines`
--

DROP TABLE IF EXISTS `ouvrages_domaines`;
CREATE TABLE IF NOT EXISTS `ouvrages_domaines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_ouvrage` int(11) NOT NULL,
  `id_domaine` int(11) NOT NULL,
  `est_actif` int(11) NOT NULL DEFAULT '1',
  `est_supprimer` int(11) NOT NULL DEFAULT '0',
  `créer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mis_a_jour_le` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ouvrages_domaines_ouvrage_cod_ouv` (`id_ouvrage`),
  KEY `ouvrages_domaines_domaines_cod_dom` (`id_domaine`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ouvrage_emprunt`
--

DROP TABLE IF EXISTS `ouvrage_emprunt`;
CREATE TABLE IF NOT EXISTS `ouvrage_emprunt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num_mem` int(11) NOT NULL,
  `num_emp` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cod_ouv` int(11) NOT NULL,
  `date_approbation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_butoir_retour` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_effective_retour` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `etat_ouvrage` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `banque` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `num_cmpt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `est_actif` int(11) NOT NULL DEFAULT '1',
  `est_supprimer` int(11) NOT NULL DEFAULT '0',
  `creer_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `maj_le` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ouvrage_emprunt_ouvrage_cod_ouv` (`cod_ouv`),
  KEY `ouvrage_emprunt_utilisateur_id` (`num_mem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `token`
--

DROP TABLE IF EXISTS `token`;
CREATE TABLE IF NOT EXISTS `token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(2555) COLLATE utf8_unicode_ci NOT NULL,
  `est_actif` int(11) NOT NULL DEFAULT '1',
  `est_supprimer` int(11) NOT NULL DEFAULT '0',
  `cree_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `maj_le` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8 NOT NULL,
  `prenom` varchar(255) CHARACTER SET utf8 NOT NULL,
  `sexe` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `telephone` bigint(20) DEFAULT NULL,
  `mot_de_passe` varchar(255) CHARACTER SET utf8 NOT NULL,
  `profil` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8 DEFAULT 'no_image',
  `email_valide` varchar(11) CHARACTER SET utf8 DEFAULT NULL,
  `telephone_valide` int(255) DEFAULT NULL,
  `nom_utilisateur` varchar(255) CHARACTER SET utf8 NOT NULL,
  `adresse` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `est_actif` int(11) NOT NULL DEFAULT '0',
  `est_supprimer` int(11) DEFAULT '0',
  `creer_le` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `maj_le` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `date_parution`
--
ALTER TABLE `date_parution`
  ADD CONSTRAINT `date_parution_langue_cod_lang` FOREIGN KEY (`id_langue`) REFERENCES `langue` (`cod_lang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `date_parution_ouvrage_cod_ouv` FOREIGN KEY (`id_ouvrage`) REFERENCES `ouvrage` (`cod_ouv`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `emprumt`
--
ALTER TABLE `emprumt`
  ADD CONSTRAINT `emprumt_utilisateur_id` FOREIGN KEY (`num_mem`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `membre_indelicat`
--
ALTER TABLE `membre_indelicat`
  ADD CONSTRAINT `membre_indelicat_ouvrage_cod_ouv` FOREIGN KEY (`cod_ouv`) REFERENCES `ouvrage` (`cod_ouv`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `membre_indelicat_utilisateur_id` FOREIGN KEY (`num_mem`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ouvrages_auteurs_secondaires`
--
ALTER TABLE `ouvrages_auteurs_secondaires`
  ADD CONSTRAINT `ouvrages_auteurs_secondaires_auteur_num_aut` FOREIGN KEY (`id_auteur_secondaire`) REFERENCES `auteur` (`num_aut`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ouvrages_auteurs_secondaires_ouvrage_cod_ouv` FOREIGN KEY (`id_ouvrage`) REFERENCES `ouvrage` (`cod_ouv`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ouvrages_domaines`
--
ALTER TABLE `ouvrages_domaines`
  ADD CONSTRAINT `ouvrages_domaines_domaines_cod_dom` FOREIGN KEY (`id_domaine`) REFERENCES `domaine` (`cod_dom`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ouvrages_domaines_ouvrage_cod_ouv` FOREIGN KEY (`id_ouvrage`) REFERENCES `ouvrage` (`cod_ouv`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ouvrage_emprunt`
--
ALTER TABLE `ouvrage_emprunt`
  ADD CONSTRAINT `ouvrage_emprunt_ouvrage_cod_ouv` FOREIGN KEY (`cod_ouv`) REFERENCES `ouvrage` (`cod_ouv`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ouvrage_emprunt_utilisateur_id` FOREIGN KEY (`num_mem`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
