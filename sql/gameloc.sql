-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 11 Janvier 2016 à 17:16
-- Version du serveur :  5.6.25
-- Version de PHP :  5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `gameloc`
--

-- --------------------------------------------------------

--
-- Structure de la table `jeux_video`
--

CREATE TABLE IF NOT EXISTS `jeux_video` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_published` date NOT NULL,
  `game_time` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `support` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `jeux_video`
--

INSERT INTO `jeux_video` (`id`, `image`, `name`, `description`, `date_published`, `game_time`, `created_at`, `support`) VALUES
(4, 'public/img/batman.jpg', 'Batman', 'I''m batman', '0000-00-00', 10, '0000-00-00', ''),
(27, 'public/img/black-ops.jpg', 'Call of Duty : Black Ops 3', 'CoD BO3', '0000-00-00', 12, '0000-00-00', ''),
(29, 'public/img/tomb-raider.jpg', 'Rise of the Tomb Raider', 'game', '0000-00-00', 15, '0000-00-00', ''),
(31, 'public/img/unity.jpg', 'Assassin''s Creed Unity', 'assassin', '0000-00-00', 13, '0000-00-00', '');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `zipcode` varchar(5) NOT NULL,
  `town` varchar(40) NOT NULL,
  `phone` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `lastname`, `firstname`, `address`, `zipcode`, `town`, `phone`) VALUES
(1, 'exemple@hotmail.fr', 'azerty1&', 'john', 'firstname', '20 rue picasso', '75000', 'paris', '0123456789'),
(2, 'affifj@gfirfk.FR', '$2y$10$jGndJ0XYYuol7vaSGrjwrOElT37EUx.JEr4CPWy8owJD3E8JePz/2', 'ae', 'azer', 'aze', '01234', 'Paris', '0123456789');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `jeux_video`
--
ALTER TABLE `jeux_video`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `jeux_video`
--
ALTER TABLE `jeux_video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
