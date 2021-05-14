-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 04 mai 2021 à 20:13
-- Version du serveur :  10.4.18-MariaDB
-- Version de PHP : 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `social_tec`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `publish_date` date NOT NULL,
  `publisher_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `nom` varchar(38) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `content`, `publish_date`, `publisher_id`, `post_id`, `nom`) VALUES
(23, 'salut\r\n', '2021-04-16', 1, 142, 'test'),
(24, 'salut\r\n', '2021-04-16', 1, 142, 'test'),
(25, 'salut\r\n', '2021-04-16', 1, 142, 'test'),
(26, 'salut\r\n', '2021-04-16', 1, 142, 'test'),
(27, 'salut', '2021-05-02', 1, 142, 'test'),
(28, 'salut', '2021-05-02', 1, 142, 'test'),
(29, 'salut', '2021-05-02', 1, 142, 'test');

-- --------------------------------------------------------

--
-- Structure de la table `follow_tb`
--

CREATE TABLE `follow_tb` (
  `id` int(11) NOT NULL,
  `following_id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `follow_tb`
--

INSERT INTO `follow_tb` (`id`, `following_id`, `follower_id`) VALUES
(271, 1, 1),
(272, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `like_tb`
--

CREATE TABLE `like_tb` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `liker_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `like_tb`
--

INSERT INTO `like_tb` (`id`, `post_id`, `liker_id`) VALUES
(1, 12, 1);

-- --------------------------------------------------------

--
-- Structure de la table `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `nom` varchar(23) NOT NULL,
  `e_mail` varchar(23) NOT NULL,
  `pwd` varchar(150) NOT NULL,
  `age` int(2) NOT NULL,
  `date_inscription` datetime NOT NULL,
  `bio` varchar(255) NOT NULL,
  `classe` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `member`
--

INSERT INTO `member` (`id`, `nom`, `e_mail`, `pwd`, `age`, `date_inscription`, `bio`, `classe`) VALUES
(1, 'test', 'meteor3141592@gmail.com', '$2y$10$7uONQruTBtcYIi9.fJJjouJ1vy5JmsORxonbIC.QqvYJm1zz3BWeW', 0, '2021-03-12 00:06:50', '', ''),
(2, 'test', 'temp@test.com', '$2y$10$58g/T4wTA3bUXjUokjaqmeM4kdDx8MJ1cAh6Qgpjy.G6ub55LLgNy', 0, '2021-04-07 14:30:47', 'pas de description', '');

-- --------------------------------------------------------

--
-- Structure de la table `publication`
--

CREATE TABLE `publication` (
  `id` int(11) NOT NULL,
  `contenu` text NOT NULL,
  `date_de_publication` date NOT NULL,
  `admin_id` int(5) NOT NULL,
  `nom` varchar(31) NOT NULL,
  `postFileName` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `publication`
--

INSERT INTO `publication` (`id`, `contenu`, `date_de_publication`, `admin_id`, `nom`, `postFileName`) VALUES
(142, 'salut', '2021-03-27', 1, 'meteor', 'BnuQsVX.jpg'),
(143, 'jjhjjhhj', '2021-03-27', 1, 'meteor', 'NULL'),
(145, 'coucou tout le monde', '2021-04-07', 1, 'meteor', 'NULL'),
(146, 'yo', '2021-04-07', 2, 'test', 'NULL'),
(148, 'Sushi ', '2021-04-08', 1, 'meteor', 'PlhaiOJ.png');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `follow_tb`
--
ALTER TABLE `follow_tb`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `like_tb`
--
ALTER TABLE `like_tb`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `publication`
--
ALTER TABLE `publication`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `follow_tb`
--
ALTER TABLE `follow_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=273;

--
-- AUTO_INCREMENT pour la table `like_tb`
--
ALTER TABLE `like_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `publication`
--
ALTER TABLE `publication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
