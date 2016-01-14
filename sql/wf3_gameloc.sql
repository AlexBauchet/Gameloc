-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 14 Janvier 2016 à 15:29
-- Version du serveur :  5.6.25
-- Version de PHP :  5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `wf3_gameloc`
--

-- --------------------------------------------------------

--
-- Structure de la table `games`
--

CREATE TABLE IF NOT EXISTS `games` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `url_img` varchar(255) DEFAULT NULL,
  `description` text,
  `published_at` datetime DEFAULT NULL,
  `game_time` int(10) unsigned DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `platform_id` int(10) unsigned NOT NULL,
  `owner_user_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `games`
--

INSERT INTO `games` (`id`, `name`, `url_img`, `description`, `published_at`, `game_time`, `is_available`, `created_at`, `updated_at`, `platform_id`, `owner_user_id`) VALUES
(0, 'Batman', 'public/img/batman.jpg', NULL, '2015-06-23 00:00:00', NULL, 1, NULL, NULL, 1, 1),
(18, 'Call of Duty Black Ops 3', 'public/img/black-ops.jpg', NULL, NULL, 10, 1, NULL, NULL, 2, 1),
(19, 'The Order', 'public/img/order.jpg', NULL, NULL, NULL, 1, NULL, NULL, 3, 1),
(22, 'Halo 5', 'public/img/halo.jpg', 'Jeu de tir', '2015-10-27 00:00:00', 10, NULL, NULL, NULL, 2, 1),
(34, 'The Witcher 3', 'public/img/witcher.png', 'rpg', '0000-00-00 00:00:00', 0, NULL, NULL, NULL, 1, 1),
(35, 'Star Wars', 'public/img/stars-wars.png', 'fps', '0000-00-00 00:00:00', 0, NULL, NULL, NULL, 3, 1),
(36, 'Assassin''s Creed Unity', 'public/img/unity.jpg', 'Aventure', '0000-00-00 00:00:00', 0, NULL, NULL, NULL, 2, 1),
(37, 'Tomb Raider', 'public/img/tomb-raider.jpg', 'Action', '0000-00-00 00:00:00', 0, NULL, NULL, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `platforms`
--

CREATE TABLE IF NOT EXISTS `platforms` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `platforms`
--

INSERT INTO `platforms` (`id`, `name`) VALUES
(1, 'PC'),
(2, 'X1'),
(3, 'PS4');

-- --------------------------------------------------------

--
-- Structure de la table `rentals`
--

CREATE TABLE IF NOT EXISTS `rentals` (
  `id` int(10) unsigned NOT NULL,
  `status` varchar(45) NOT NULL DEFAULT 'waiting',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `game_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(45) NOT NULL DEFAULT 'member',
  `lastname` varchar(45) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `address` varchar(255) NOT NULL,
  `zipcode` varchar(5) NOT NULL,
  `town` varchar(45) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `updated_at` varchar(45) DEFAULT 'CURRENT_TIMESTAMP',
  `created_at` varchar(45) DEFAULT 'CURRENT_TIMESTAMP'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`, `lastname`, `firstname`, `address`, `zipcode`, `town`, `phone`, `latitude`, `longitude`, `updated_at`, `created_at`) VALUES
(1, 'admin.gameloc@gameloc.fr', '$2y$10$RSiEHp5ps0ABVJwrEtgMeeJSCEeGEbtjqG48r11aRiVfzcgk27Ame', 'admin', 'al', 'b', 'azer', '75000', 'Paris', '0123456789', NULL, NULL, 'CURRENT_TIMESTAMP', 'CURRENT_TIMESTAMP');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`,`platform_id`,`owner_user_id`),
  ADD KEY `fk_games_platforms_idx` (`platform_id`),
  ADD KEY `fk_games_users1_idx` (`owner_user_id`);

--
-- Index pour la table `platforms`
--
ALTER TABLE `platforms`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `rentals`
--
ALTER TABLE `rentals`
  ADD PRIMARY KEY (`id`,`user_id`),
  ADD KEY `fk_renting_games1_idx` (`game_id`),
  ADD KEY `fk_renting_users1_idx` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT pour la table `platforms`
--
ALTER TABLE `platforms`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `rentals`
--
ALTER TABLE `rentals`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `fk_games_platforms` FOREIGN KEY (`platform_id`) REFERENCES `platforms` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_games_users1` FOREIGN KEY (`owner_user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `rentals`
--
ALTER TABLE `rentals`
  ADD CONSTRAINT `fk_renting_games1` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_renting_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
