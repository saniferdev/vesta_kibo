-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 21 sep. 2022 à 12:25
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `vesta_kibo`
--

-- --------------------------------------------------------

--
-- Structure de la table `tbl_member`
--

CREATE TABLE `tbl_member` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(200) NOT NULL,
  `groupe` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `site` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tbl_member`
--

INSERT INTO `tbl_member` (`id`, `username`, `password`, `groupe`, `type`, `site`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'TALYS', 'administrateur','KIB01'),
(2, 'sortie_casse', '094bb6cfeede011699cbc4a5671a377e', 'KIBO', 'utilisateur','KIB01'),
(3, 'sortie_kibo', '094bb6cfeede011699cbc4a5671a377e', 'KIBO', 'utilisateur','KIB02');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `tbl_member`
--
ALTER TABLE `tbl_member`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `tbl_member`
--
ALTER TABLE `tbl_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
COMMIT;