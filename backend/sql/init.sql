-- Initialisation de la base de données pour le PoC
CREATE DATABASE IF NOT EXISTS `poc_hebergements`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `poc_hebergements`;

-- Nettoyage préalable (ordre respectant les clés étrangères)
DROP TABLE IF EXISTS `evaluations`;
DROP TABLE IF EXISTS `prospects`;
DROP TABLE IF EXISTS `formules`;

-- --------------------------------------------------------
-- Structure de la table : formules
-- --------------------------------------------------------
CREATE TABLE `formules` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(100) NOT NULL,
    `description` TEXT NULL,
    `prix` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `delai_realisation` VARCHAR(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Structure de la table : prospects
-- --------------------------------------------------------
CREATE TABLE `prospects` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nom_etablissement` VARCHAR(255) NOT NULL,
    `type_hebergement` VARCHAR(100) DEFAULT NULL,
    `url_actuelle` VARCHAR(255) DEFAULT NULL,
    `email` VARCHAR(255) NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Structure de la table : evaluations
-- --------------------------------------------------------
CREATE TABLE `evaluations` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `prospect_id` INT NOT NULL,
    `score_visibilite` INT NOT NULL,
    `formule_recommandee_id` INT NOT NULL,
    `details_audit` TEXT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_evaluations_prospect`
        FOREIGN KEY (`prospect_id`) REFERENCES `prospects` (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_evaluations_formule`
        FOREIGN KEY (`formule_recommandee_id`) REFERENCES `formules` (`id`)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 1. Insertion des Formules d'audit et d'accompagnement
INSERT INTO `formules` (`id`, `nom`, `description`, `prix`, `delai_realisation`) VALUES 
(1, 'Formule Essentielle', 'Audit complet de visibilité numérique, analyse SEO de base et recommandations de positionnement.', 149.00, '48h'),
(2, 'Formule Pro', 'Audit approfondi, analyse de la concurrence locale, optimisation Google Business Profile et stratégie de mots-clés.', 299.00, '5 jours ouvrés'),
(3, 'Formule Premium / Sur-mesure', 'Accompagnement complet, refonte de la stratégie digitale, suivi des performances et accompagnement technique.', 599.00, '10 jours ouvrés');