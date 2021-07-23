-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : jeu. 22 juil. 2021 à 14:33
-- Version du serveur :  5.7.32
-- Version de PHP : 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `eval_php`
--

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

CREATE TABLE `avis` (
  `id_avis` int(3) NOT NULL,
  `id_membre` int(5) NOT NULL,
  `id_salle` int(3) NOT NULL,
  `commentaire` text NOT NULL,
  `note` enum('1','2','3','4','5') NOT NULL,
  `date_enregistrement` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`id_avis`, `id_membre`, `id_salle`, `commentaire`, `note`, `date_enregistrement`) VALUES
(2, 20, 14, 'cool, j\'adore', '5', '2021-07-18'),
(3, 21, 13, 'cool, j\'adore', '3', '2021-07-20'),
(4, 21, 17, 'super', '4', '2021-07-08'),
(5, 21, 16, 'cool, j\'adore', '1', '2021-07-03');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id_commande` int(3) NOT NULL,
  `id_membre` int(3) NOT NULL,
  `id_produit` int(3) NOT NULL,
  `date_enregistrement` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_commande`, `id_membre`, `id_produit`, `date_enregistrement`) VALUES
(3, 20, 22, '2021-07-20');

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `id_membre` int(3) NOT NULL,
  `pseudo` varchar(20) NOT NULL,
  `mdp` varchar(20) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `civilite` enum('Mme','Mlle','Mr') NOT NULL,
  `date_enregistrement` date NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `civilite`, `date_enregistrement`, `status`) VALUES
(20, 'AnnaGor', '123', 'Gor', 'Anna', 'Anngor@gmail.com', 'Mlle', '2021-07-16', 0),
(21, 'regirou', '123', 'Ruiar', 'Regina', 'Regiru82@gmail.com', 'Mme', '2021-07-15', 0);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id_produit` int(3) NOT NULL,
  `date_arrivee` date NOT NULL,
  `heure_arrivee` time NOT NULL,
  `date_depart` date NOT NULL,
  `heure_depart` time NOT NULL,
  `id_salle` int(3) NOT NULL,
  `prix` int(5) NOT NULL,
  `etat` enum('Libre','Réservée') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id_produit`, `date_arrivee`, `heure_arrivee`, `date_depart`, `heure_depart`, `id_salle`, `prix`, `etat`) VALUES
(13, '2021-08-01', '09:00:00', '2021-08-01', '19:00:00', 3, 300, 'Libre'),
(14, '2021-08-02', '09:00:00', '2021-08-02', '19:00:00', 12, 400, 'Libre'),
(15, '2021-08-03', '09:00:00', '2021-08-03', '19:00:00', 13, 450, 'Libre'),
(16, '2021-08-04', '09:00:00', '2021-08-04', '19:00:00', 14, 300, 'Libre'),
(17, '2021-08-05', '09:00:00', '2021-08-05', '19:00:00', 15, 500, 'Libre'),
(18, '2021-08-05', '09:00:00', '2021-08-05', '19:00:00', 16, 1000, 'Libre'),
(19, '2021-08-07', '09:00:00', '2021-08-07', '09:00:00', 17, 800, 'Libre'),
(20, '2021-08-08', '09:00:00', '2021-08-08', '19:00:00', 20, 900, 'Libre'),
(21, '2021-08-05', '09:00:00', '2021-08-05', '19:00:00', 21, 500, 'Libre'),
(22, '2021-08-01', '09:00:00', '2021-08-01', '19:00:00', 22, 500, 'Libre');

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

CREATE TABLE `salle` (
  `id_salle` int(3) NOT NULL,
  `titre` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `photo` varchar(200) NOT NULL,
  `pays` varchar(20) NOT NULL,
  `ville` varchar(20) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `cp` int(5) NOT NULL,
  `capacite` int(6) NOT NULL,
  `categorie` enum('Réunion','Bureau','Formation') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `salle`
--

INSERT INTO `salle` (`id_salle`, `titre`, `description`, `photo`, `pays`, `ville`, `adresse`, `cp`, `capacite`, `categorie`) VALUES
(3, 'Noir', 'Salle de couleur noir', '/ifocop/php/eval_php/photo/Noir_Noir.jpeg', 'France', 'Asnières-sur-Seine', '3 rue Alma', 92600, 12, 'Réunion'),
(12, 'Cool', 'Salle moderne avec un design', '/ifocop/php/eval_php/photo/Cool_Cool.jpeg', 'France', 'Asnières-sur-Seine', '3 rue Monet', 92600, 20, 'Bureau'),
(13, 'Musical', 'Salle avec un piano', '/ifocop/php/eval_php/photo/Musical_Musical.jpeg', 'France', 'Paris', '5 rue Musical', 75000, 200, 'Formation'),
(14, 'Moderne', 'Salle simple avec des grandes fênetres', '/ifocop/php/eval_php/photo/Moderne_Modern.jpeg', 'France', 'Asnières-sur-Seine', '3 Avenue Moderne', 92600, 50, 'Formation'),
(15, 'Blanche', 'Salle blanche avec des carreaux rouge', '/ifocop/php/eval_php/photo/Blanche_Blanche.jpeg', 'France', 'Paris', '5 rue Blanche', 75000, 30, 'Réunion'),
(16, 'Sheraton', 'Salle classique avec un écran', '/ifocop/php/eval_php/photo/Sheraton_Sheraton.jpeg', 'France', 'Paris', '5 rue Sheraton', 75000, 20, 'Réunion'),
(17, 'Laffitte', 'Salle arrondie avec des chaises bleues ', '/ifocop/php/eval_php/photo/Laffitte_Laffitte.jpeg', 'France', 'Paris', '5 rue Laffitte', 75000, 40, 'Formation'),
(20, 'Atmosphere', 'Salle claire spacieuse ', '/ifocop/php/eval_php/photo/Atmosphere_Air.jpeg', 'France', 'Paris', '5 rue Atmosphere', 75000, 50, 'Bureau'),
(21, 'Cozy', 'Salle de bureau avec des tables en bois et des grandes fenêtres', '/ifocop/php/eval_php/photo/Cozy_Cosy.jpeg', 'France', 'Paris', '5 rue Cozy', 75000, 40, 'Bureau'),
(22, 'Pullman', 'Salle classique avec une table ronde et des micros', '/ifocop/php/eval_php/photo/Pullman_Pullman.jpeg', 'France', 'Paris', '5 rue Pullman', 75000, 20, 'Réunion');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `avis`
--
ALTER TABLE `avis`
  ADD PRIMARY KEY (`id_avis`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id_commande`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id_membre`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id_produit`);

--
-- Index pour la table `salle`
--
ALTER TABLE `salle`
  ADD PRIMARY KEY (`id_salle`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `avis`
--
ALTER TABLE `avis`
  MODIFY `id_avis` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id_commande` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `id_membre` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id_produit` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `salle`
--
ALTER TABLE `salle`
  MODIFY `id_salle` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
