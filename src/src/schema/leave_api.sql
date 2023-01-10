-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 18 sep. 2021 à 17:59
-- Version du serveur : 8.0.23
-- Version de PHP : 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `leave_api`
--

-- --------------------------------------------------------

--
-- Structure de la table `requests`
--

DROP TABLE IF EXISTS `requests`;
CREATE TABLE IF NOT EXISTS `requests` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `status` tinyint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_requests_user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `requests`
--

INSERT INTO `requests` (`id`, `title`, `date_start`, `date_end`, `comment`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Request 1', '2021-09-18', '2021-10-17', 'Demande acceptée', 2, 1, '2021-09-18 16:29:05', '2021-09-18 16:29:05'),
(2, 'Request 2', '2021-09-18', '2021-10-17', 'Demande acceptée', 2, 1, '2021-09-18 16:30:00', '2021-09-18 16:30:00'),
(3, 'Request 3', '2021-09-18', '2021-10-17', NULL, 1, 1, '2021-09-18 16:30:20', '2021-09-18 16:30:20'),
(4, 'Request 4', '2021-09-18', '2021-10-17', NULL, 1, 3, '2021-09-18 16:44:26', '2021-09-18 16:44:26');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Employé', 'Rôle employé', '2021-09-15 13:15:16', '2021-09-15 13:26:14'),
(2, 'Manager', 'Rôle manager', '2021-09-15 13:15:27', '2021-09-15 13:26:21');

-- --------------------------------------------------------

--
-- Structure de la table `structures`
--

DROP TABLE IF EXISTS `structures`;
CREATE TABLE IF NOT EXISTS `structures` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `manager_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_structures_parent_id` (`parent_id`) USING BTREE,
  KEY `idx_structures_manager_id` (`manager_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `structures`
--

INSERT INTO `structures` (`id`, `name`, `parent_id`, `manager_id`, `created_at`, `updated_at`) VALUES
(1, 'Direction Générale', NULL, 2, '2021-09-16 17:54:25', '2021-09-18 17:06:06'),
(2, 'Resources Humaines', 1, NULL, '2021-09-17 16:32:33', '2021-09-18 00:26:16'),
(3, 'Informatique', 1, NULL, '2021-09-17 22:47:51', '2021-09-18 00:26:33'),
(4, 'Juridique', 1, NULL, '2021-09-17 22:47:57', '2021-09-18 00:26:43');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` tinyint UNSIGNED NOT NULL,
  `status` tinyint UNSIGNED NOT NULL,
  `structure_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_users_email_unique` (`email`) USING BTREE,
  KEY `idx_users_structure_id` (`structure_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `first_name`, `last_name`, `role`, `status`, `structure_id`, `created_at`, `updated_at`) VALUES
(1, 'chetibi.abderrahim@gmail.com', '$2y$10$TCZcFvOVydo.DMZWlu7ENu2/lTebcsUX/aFadab5WRlPwKFqibAda', 'Abderrahim', 'CHETIBI', 1, 2, 1, '2021-09-18 00:27:15', '2021-09-18 00:28:52'),
(2, 'benbrahim.mohamed@email.com', '$2y$10$zpLKsq7q43KT9IVj06a3numRALrFfLLX3gWXeBJlEskjtA.6dKYYu', 'Mohamed', 'BEN BRAHIM', 2, 2, 1, '2021-09-18 00:30:21', '2021-09-18 00:31:26'),
(3, 'chetibi.abderrahim2@email.com', '$2y$10$waoWg6/6FEJahK0vUAD5JeaNTUk5XWze/CDiUFdSE2oDeSUsxcDKe', 'Abderrahim', 'CHETIBI', 1, 1, 1, '2021-09-18 16:48:40', '2021-09-18 17:24:18');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `fk_requests_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `structures`
--
ALTER TABLE `structures`
  ADD CONSTRAINT `fk_structures_manager_id` FOREIGN KEY (`manager_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_structures_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `structures` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_structure_id` FOREIGN KEY (`structure_id`) REFERENCES `structures` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
