-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 08 fév. 2022 à 22:09
-- Version du serveur :  8.0.27
-- Version de PHP : 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `devis`
--

-- --------------------------------------------------------

--
-- Structure de la table `addresses`
--

CREATE TABLE `addresses` (
  `id` int NOT NULL,
  `client_id` int DEFAULT NULL,
  `quote_id` int DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `addresses`
--

INSERT INTO `addresses` (`id`, `client_id`, `quote_id`, `street`, `postale`, `city`, `company`, `country`, `type`) VALUES
(1, 3, NULL, 'Et assumenda eiusmod', 'Et aut ullamco eu vo', 'Delectus atque sit', 'Gilliam Serrano Associates', 'Exercitation labore ', 'test'),
(2, 4, NULL, 'Ea animi omnis natu', 'Reprehenderit archit', 'Non aspernatur occae', 'Gilliam Morrow LLC', 'Amet rerum proident', 'test'),
(3, 5, NULL, 'Officia animi volup', 'Consectetur numquam ', 'Aut cupidatat offici', 'Edwards and Sexton Trading', 'Saepe earum atque to', 'test'),
(4, 6, NULL, 'Officia animi volup', 'Consectetur numquam ', 'Aut cupidatat offici', 'Edwards and Sexton Trading', 'Saepe earum atque to', 'test');

-- --------------------------------------------------------

--
-- Structure de la table `billing`
--

CREATE TABLE `billing` (
  `id` int NOT NULL,
  `client_id` int DEFAULT NULL,
  `quote_id` int DEFAULT NULL,
  `created_at` date NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payement_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id` int NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `siret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `firstname`, `lastname`, `company`, `siret`, `phone`, `email`, `language`) VALUES
(3, 'Flavia', 'Delaney', 'Gilliam Serrano Associates', 'Quibusdam non quis d', '+1 (103) 202-8821', 'rokihi@mailinator.com', 'French'),
(4, 'Germaine', 'Kent', 'Gilliam Morrow LLC', 'Dolor pariatur Fuga', '+1 (452) 585-4999', 'lurif@mailinator.com', 'French'),
(5, 'Reece', 'Burnett', 'Edwards and Sexton Trading', 'Dolores aut quia dig', '+1 (964) 903-9857', 'zuqalytuha@mailinator.com', 'English'),
(6, 'Reece', 'Burnett', 'Edwards and Sexton Trading', 'Dolores aut quia dig', '+1 (964) 903-9857', 'zuqalytuha@mailinator.com', 'English');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220121202027', '2022-01-21 21:20:58', 685),
('DoctrineMigrations\\Version20220122202825', '2022-01-22 21:29:11', 131);

-- --------------------------------------------------------

--
-- Structure de la table `quote`
--

CREATE TABLE `quote` (
  `id` int NOT NULL,
  `client_id` int NOT NULL,
  `creation_date` date NOT NULL,
  `discount` int DEFAULT NULL,
  `deposit` int DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `quote`
--

INSERT INTO `quote` (`id`, `client_id`, `creation_date`, `discount`, `deposit`, `status`) VALUES
(2, 3, '2022-02-05', NULL, 93, 'test'),
(3, 4, '2022-02-06', NULL, 30, 'test'),
(4, 5, '2022-02-06', NULL, 20, 'test'),
(5, 6, '2022-02-06', NULL, 20, 'test');

-- --------------------------------------------------------

--
-- Structure de la table `quote_services`
--

CREATE TABLE `quote_services` (
  `quote_id` int NOT NULL,
  `services_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `quote_services`
--

INSERT INTO `quote_services` (`quote_id`, `services_id`) VALUES
(3, 17),
(3, 19),
(4, 18),
(4, 27),
(5, 18),
(5, 27);

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

CREATE TABLE `services` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double DEFAULT NULL,
  `velocity` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `time`, `price`, `velocity`) VALUES
(17, 'INSTALLATION / CONFIGURATION DE WORDPRESS', '- Installation de la solution Open Source Wordpress (Version 4.4.1 en\r\nFrançais)\r\n\r\n- Création de la base de données MySQL et préparation des tables', '21:38:51  22/01/2022', 150, 1),
(18, 'PERSONNALISATION GRAPHIQUE', '- Achat, Installation et personnalisation d\'un thème Wordpress responsive\r\nadapté à l\'activité du client\r\n- Inclus les extensions Visuel composer et Revolution Slider\r\n- Customisation avancée du thème : logos, couleurs, polices...\r\n- Moteur de recherche plein texte\r\n- Création des templates des gabarits de page (accueil, contenus, contact,\r\n   portfolio, actualités)', '21:41:43  22/01/2022', 600, 2),
(19, 'DEVELOPPEMENT DU SITE WEB', '- Création des rubriques, sous rubriques, pages\r\n- Formulaires de contact\r\n- Plan d\'accès Google Maps\r\n- Mise en place de la navigation (menus et sous-menus, raccourcis...)\r\n- Installation et paramétrage de modules complémentaires', '21:43:08  22/01/2022', 1800, 3),
(27, 'Jakeem Dejesus', 'Amet sint quidem do', '13:09:07  05/02/2022', 767, 3),
(28, 'Miriam Moreno', 'Minus nisi consequat', '13:09:50  05/02/2022', 252, 71),
(29, 'Devin Watts', 'Sint cupiditate minu', '13:10:12  05/02/2022', 363, 45),
(30, 'Sylvia Oliver', 'Quisquam ab nulla la', '18:14:27  05/02/2022', 245, 85),
(31, 'Rafael Vaughan', 'Tenetur officia quia', '18:14:38  05/02/2022', 622, 10),
(32, 'prestation wordpress', '\r\n=instalation du projet \r\n=instalation du projet \r\n=instalation du projet \r\n=instalation du projet ', '01:34:14  06/02/2022', 149, 3);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6FCA751619EB6921` (`client_id`),
  ADD KEY `IDX_6FCA7516DB805178` (`quote_id`);

--
-- Index pour la table `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_EC224CAADB805178` (`quote_id`),
  ADD KEY `IDX_EC224CAA19EB6921` (`client_id`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `quote`
--
ALTER TABLE `quote`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6B71CBF419EB6921` (`client_id`);

--
-- Index pour la table `quote_services`
--
ALTER TABLE `quote_services`
  ADD PRIMARY KEY (`quote_id`,`services_id`),
  ADD KEY `IDX_990849F8DB805178` (`quote_id`),
  ADD KEY `IDX_990849F8AEF5A6C1` (`services_id`);

--
-- Index pour la table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `billing`
--
ALTER TABLE `billing`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `quote`
--
ALTER TABLE `quote`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `services`
--
ALTER TABLE `services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `FK_6FCA751619EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `FK_6FCA7516DB805178` FOREIGN KEY (`quote_id`) REFERENCES `quote` (`id`);

--
-- Contraintes pour la table `billing`
--
ALTER TABLE `billing`
  ADD CONSTRAINT `FK_EC224CAA19EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`),
  ADD CONSTRAINT `FK_EC224CAADB805178` FOREIGN KEY (`quote_id`) REFERENCES `quote` (`id`);

--
-- Contraintes pour la table `quote`
--
ALTER TABLE `quote`
  ADD CONSTRAINT `FK_6B71CBF419EB6921` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`);

--
-- Contraintes pour la table `quote_services`
--
ALTER TABLE `quote_services`
  ADD CONSTRAINT `FK_990849F8AEF5A6C1` FOREIGN KEY (`services_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_990849F8DB805178` FOREIGN KEY (`quote_id`) REFERENCES `quote` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
