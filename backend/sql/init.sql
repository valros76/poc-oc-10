-- Initialisation de la base de données pour le PoC
CREATE DATABASE IF NOT EXISTS `poc_hebergements`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `poc_hebergements`;

-- Nettoyage préalable (ordre respectant les clés étrangères)
DROP TABLE IF EXISTS `evaluation`;
DROP TABLE IF EXISTS `prospect`;
DROP TABLE IF EXISTS `formule`;

-- --------------------------------------------------------
-- Structure de la table : Formule
-- --------------------------------------------------------
CREATE TABLE `formule` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(100) NOT NULL,
    `description` TEXT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Structure de la table : Prospect
-- --------------------------------------------------------
CREATE TABLE `prospect` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nom_etablissement` VARCHAR(255) NOT NULL,
    `type_hebergement` VARCHAR(100) DEFAULT NULL,
    `url_actuelle` VARCHAR(255) DEFAULT NULL,
    `email` VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Structure de la table : Evaluation
-- --------------------------------------------------------
CREATE TABLE `evaluation` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `prospect_id` INT NOT NULL,
    `score_visibilite` INT NOT NULL,
    `formule_recommandee_id` INT NOT NULL,
    `date_creation` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_evaluation_prospect`
        FOREIGN KEY (`prospect_id`) REFERENCES `prospect` (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_evaluation_formule`
        FOREIGN KEY (`formule_recommandee_id`) REFERENCES `formule` (`id`)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Données d'initialisation : Formules commerciales
-- --------------------------------------------------------
INSERT INTO `formule` (`id`, `nom`, `description`) VALUES
(1, "Essentiel", "Création de site vitrine optimisé SEO local pour présenter votre hébergement et capter vos premières demandes de contact."),
(2, "Réservation directe", "Site internet complet intégrant un moteur de réservation direct sans commission et la synchronisation de votre planning."),
(3, "Acquisition", "Solution clé en main avec site de réservation directe, SEO avancé et campagnes publicitaires ciblées pour maximiser votre taux d'occupation.");