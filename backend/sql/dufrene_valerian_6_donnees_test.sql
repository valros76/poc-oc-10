USE `poc_hebergements`;

-- Nettoyage préalable des tables (dans l'ordre inverse des contraintes de clés étrangères)
DELETE FROM `evaluations`;
DELETE FROM `prospects`;
DELETE FROM `formules`;

-- 1. Insertion des Formules d'audit et d'accompagnement
INSERT INTO `formules` (`id`, `nom`, `description`, `prix`, `delai_realisation`) VALUES 
(1, 'Formule Essentielle', 'Audit complet de visibilité numérique, analyse SEO de base et recommandations de positionnement.', 149.00, '48h'),
(2, 'Formule Pro', 'Audit approfondi, analyse de la concurrence locale, optimisation Google Business Profile et stratégie de mots-clés.', 299.00, '5 jours ouvrés'),
(3, 'Formule Premium / Sur-mesure', 'Accompagnement complet, refonte de la stratégie digitale, suivi des performances et accompagnement technique.', 599.00, '10 jours ouvrés');

-- 2. Insertion de Prospects (hébergements touristiques / gîtes / campings)
INSERT INTO `prospects` (`id`, `nom_etablissement`, `type_hebergement`, `url_actuelle`, `email`, `created_at`) VALUES 
(1, 'Gîte de la Vallée Verte', 'Gîte', 'https://gite-valleeverte-exemple.fr', 'contact@valleeverte.fr', NOW() - INTERVAL 5 DAY),
(2, 'Camping Les Pinèdes', 'Camping', 'https://camping-pinedes-exemple.com', 'direction@lespinedes.com', NOW() - INTERVAL 3 DAY),
(3, 'Chambres d''Hôtes Le Clos Fleuri', 'Chambre d''hôtes', '', 'closfleuri@example.net', NOW() - INTERVAL 1 DAY),
(4, 'Domaine de l''Océan', 'Hôtel de Plein Air', 'https://domaine-ocean-exemple.fr', 'info@domaine-ocean.fr', NOW() - INTERVAL 12 HOUR);

-- 3. Insertion des Évaluations / Résultats d'audit associés aux prospects
INSERT INTO `evaluations` (`id`, `prospect_id`, `score_visibilite`, `formule_recommandee_id`, `details_audit`, `created_at`) VALUES 
(1, 1, 85, 2, '{"seo": "Bon", "reseaux_sociaux": "Moyen", "performance_site": "Rapide", "recommandations": ["Améliorer le balisage local", "Activer le HTTPS permanent"]}', NOW() - INTERVAL 5 DAY),
(2, 2, 62, 3, '{"seo": "Faible", "reseaux_sociaux": "Inexistant", "performance_site": "Lent", "recommandations": ["Refonte de la structure des pages", "Création de la fiche Google Business Profile"]}', NOW() - INTERVAL 3 DAY),
(3, 3, 40, 3, '{"seo": "Critique", "reseaux_sociaux": "Faible", "performance_site": "Absent (pas de site web)", "recommandations": ["Création urgente d''un site vitrine", "Mise en place d''un système de réservation"]}', NOW() - INTERVAL 1 DAY),
(4, 4, 92, 1, '{"seo": "Excellent", "reseaux_sociaux": "Très bon", "performance_site": "Optimisé", "recommandations": ["Maintenir la stratégie de contenu actuelle"]}', NOW() - INTERVAL 12 HOUR);