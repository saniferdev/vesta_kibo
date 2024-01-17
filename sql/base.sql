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
-- Structure de la table `inv_member`
--

CREATE TABLE `inv_member` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(200) NOT NULL,
  `groupe` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `site` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `inv_member`
--

INSERT INTO `inv_member` (`id`, `username`, `password`, `groupe`, `type`, `site`) VALUES
(1, 'admin', '112ae18ca654f27a219f84063bc1828f', 'TALYS', 'administrateur','KIB01'),
(2, 'stephanie', 'ec3f81b076d02f207e1fe8f22a98d94d', 'KIBO', 'utilisateur','KIB01'),
(3, 'manissa', '3477bae74baa8cec51c363d72834f257', 'KIBO', 'utilisateur','KIB01'),
(4, 'mino', '3f171f296a0a427a57543c515480bc88', 'KIBO', 'utilisateur','KIB01'),
(5, 'ravaka', 'd4f66031efb43f3ac86be3aca1541087', 'KIBO', 'utilisateur','KIB01'),
(6, 'alliance', '453fd73c0d42bfd1ced50b1fa03494fa', 'KIBO', 'utilisateur','KIB01'),
(7, 'ialy', '5ab1c7c421837406ce6c2fc29b7eb2be', 'KIBO', 'utilisateur','KIB01'),
(8, 'elysee', 'a74b4e4034e8eb1afdf380fb65e799fa', 'KIBO', 'utilisateur','KIB01'),
(9, 'jean_phillippe', 'd60948692b280adeadc29a41c10e1129', 'KIBO', 'utilisateur','KIB01'),
(10, 'nicolas', 'fb7217e46872e3d3a74e148f5a8eb639', 'KIBO', 'utilisateur','KIB01'),
(11, 'miora', '4e31b54152a19c1347c4c8b1b812d0c1', 'KIBO', 'utilisateur','KIB01'),
(12, 'fara', '1ae600110a04d81052a8c9c6b67aa71f', 'KIBO', 'utilisateur','KIB01'),
(13, 'anja', '86c7d928b12657bebbe645f38b577018', 'KIBO', 'utilisateur','KIB01'),
(14, 'kevin', 'f127a75b8b038aab65d4e6df34f6fc4d', 'KIBO', 'utilisateur','KIB01'),
(15, 'vony', 'd9603decf7d6dfbcaa5f2a304adc34c2', 'KIBO', 'utilisateur','KIB01'),
(16, 'jeannie', '9516aac60009c2b8d16fe80fd07e50dd', 'KIBO', 'utilisateur','KIB01'),
(17, 'lydien', '3903ac7417f02097dd212c51de52dddf', 'KIBO', 'utilisateur','KIB01'),
(18, 'seheno', '4d5e033d5e5c6264d8c9acd9eb1223fa', 'KIBO', 'utilisateur','KIB02'),
(19, 'jean_marc', '5d0127b9c333bc990fa67fe47e47f01c', 'KIBO', 'utilisateur','KIB02'),
(20, 'samirah', '112ae18ca654f27a219f84063bc1828f', 'KIBO', 'utilisateur','KIB02');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `inv_member`
--
ALTER TABLE `inv_member`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `inv_member`
--
ALTER TABLE `inv_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
COMMIT;