-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 05 déc. 2025 à 11:57
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `fourtherrdb`
--

-- --------------------------------------------------------

--
-- Structure de la table `i_artiste`
--

CREATE TABLE `i_artiste` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `motdepasse` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `i_artiste`
--

INSERT INTO `i_artiste` (`id`, `nom`, `prenom`, `username`, `motdepasse`) VALUES
(1, 'Deudon', 'Lucas', 'ldeudon', '45091637e11fd7213e2bdcaccc689da387d8626b246603ec8b26a2971f033e65'),
(3, 'Blue', 'Patapim', 'brr', '577b1db8e673650850eaf734f49b4dd144d91bc75eb76dfcd476ba31c5f5862b'),
(4, 'Wawa', 'Yaya', 'osamason', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3'),
(5, 'Test', 'Lucas', 'ltest', '7cadab457ad8d811f134612436daaa5e5914b20dc2502865f714035b0f267680');

-- --------------------------------------------------------

--
-- Structure de la table `i_commandes`
--

CREATE TABLE `i_commandes` (
  `idNumCommande` int(11) NOT NULL,
  `dateCommande` datetime DEFAULT NULL,
  `description` text DEFAULT NULL,
  `prix` double(16,2) DEFAULT NULL,
  `statut` enum('Non commencé','En cours','Terminé') DEFAULT NULL,
  `FK_idCompte` int(11) DEFAULT NULL,
  `FK_idArtiste` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `i_commandes`
--

INSERT INTO `i_commandes` (`idNumCommande`, `dateCommande`, `description`, `prix`, `statut`, `FK_idCompte`, `FK_idArtiste`) VALUES
(5, '2025-12-01 16:16:04', 'test', 15.50, 'Non commencé', 2, 1),
(7, '2025-12-01 16:16:17', 'Insertion depuis swagger', 15.00, 'Non commencé', 2, 1),
(8, '2025-12-01 16:17:08', '2 splashart pour mon jeu roguelike', 165.80, 'Non commencé', 2, 3),
(9, '2025-12-04 11:19:36', 'Recharge du solde', 120.00, 'Non commencé', 7, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `i_compte`
--

CREATE TABLE `i_compte` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `motdepasse` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `i_compte`
--

INSERT INTO `i_compte` (`id`, `nom`, `prenom`, `username`, `motdepasse`) VALUES
(2, 'Think', 'Pad', 'thinkpad', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3'),
(4, 'Lucas', 'Maitre', 'ldeudon', '45091637e11fd7213e2bdcaccc689da387d8626b246603ec8b26a2971f033e65'),
(5, 'blabla', 'sds', 'ski', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3'),
(6, 'Henni', 'Wassil', 'whenni', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3'),
(7, 'Maiz', 'Moha', 'mmaiz', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3'),
(8, 'Test', 'Monsieur', 'mtest', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(11) NOT NULL,
  `migration` varchar(255) DEFAULT NULL,
  `batch` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `t_portofolio`
--

CREATE TABLE `t_portofolio` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `dateCreation` datetime DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `FK_idArtiste` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_portofolio`
--

INSERT INTO `t_portofolio` (`id`, `titre`, `description`, `dateCreation`, `image`, `FK_idArtiste`) VALUES
(2, 'Titre pour portofolio de test', 'Description plutot amusante, je n\' ai pas d\' idées', '2025-12-05 10:26:19', 'https://www.gameblog.fr/geek/ed/news/arcane-retard-artbook-678203', 3),
(3, 'Portofolio titre', 'Description', '2025-12-05 10:55:32', 'https://www.gameblog.fr/geek/ed/news/arcane-retard-artbook-678203', 1),
(5, 'Titre patapim', 'Description descriptionnante', '2025-12-05 11:47:19', 'https://imgr.gameblog.fr/img/news/678203_67d28fd44d07f.jpg?width=900&height=&aspect_ratio=900:&ver=1', 5);

-- --------------------------------------------------------

--
-- Structure de la table `t_solde`
--

CREATE TABLE `t_solde` (
  `id` int(11) NOT NULL,
  `solde` double(16,2) DEFAULT NULL,
  `FK_idCompte` int(11) DEFAULT NULL,
  `FK_idArtiste` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `t_solde`
--

INSERT INTO `t_solde` (`id`, `solde`, `FK_idCompte`, `FK_idArtiste`) VALUES
(1, 50.02, 2, NULL),
(2, 125.02, NULL, 4),
(3, 2146.74, 4, NULL),
(4, 379.25, NULL, 1),
(5, 4735.23, 7, NULL),
(6, 120.00, 8, NULL),
(7, 12.00, 8, NULL),
(8, 12.00, 8, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `i_artiste`
--
ALTER TABLE `i_artiste`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `i_commandes`
--
ALTER TABLE `i_commandes`
  ADD PRIMARY KEY (`idNumCommande`),
  ADD KEY `FK_idCompteCommande` (`FK_idCompte`),
  ADD KEY `FK_idArtisteCommande` (`FK_idArtiste`);

--
-- Index pour la table `i_compte`
--
ALTER TABLE `i_compte`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `t_portofolio`
--
ALTER TABLE `t_portofolio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Portofolio_idArtiste` (`FK_idArtiste`);

--
-- Index pour la table `t_solde`
--
ALTER TABLE `t_solde`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_Solde_idCompte` (`FK_idCompte`),
  ADD KEY `FK_Solde_idArtiste` (`FK_idArtiste`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `i_artiste`
--
ALTER TABLE `i_artiste`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `i_commandes`
--
ALTER TABLE `i_commandes`
  MODIFY `idNumCommande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `i_compte`
--
ALTER TABLE `i_compte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `t_portofolio`
--
ALTER TABLE `t_portofolio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `t_solde`
--
ALTER TABLE `t_solde`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `i_commandes`
--
ALTER TABLE `i_commandes`
  ADD CONSTRAINT `FK_idArtisteCommande` FOREIGN KEY (`FK_idArtiste`) REFERENCES `i_artiste` (`id`),
  ADD CONSTRAINT `FK_idCompteCommande` FOREIGN KEY (`FK_idCompte`) REFERENCES `i_compte` (`id`);

--
-- Contraintes pour la table `t_portofolio`
--
ALTER TABLE `t_portofolio`
  ADD CONSTRAINT `FK_Portofolio_idArtiste` FOREIGN KEY (`FK_idArtiste`) REFERENCES `i_artiste` (`id`);

--
-- Contraintes pour la table `t_solde`
--
ALTER TABLE `t_solde`
  ADD CONSTRAINT `FK_Solde_idArtiste` FOREIGN KEY (`FK_idArtiste`) REFERENCES `i_artiste` (`id`),
  ADD CONSTRAINT `FK_Solde_idCompte` FOREIGN KEY (`FK_idCompte`) REFERENCES `i_compte` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
