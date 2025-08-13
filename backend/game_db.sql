-- Création de la base de données
CREATE DATABASE gamestore;

-- Sélection de la base
USE gamestore;

-- Table pour les jeux soumis par les utilisateurs
CREATE TABLE games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    platform VARCHAR(100),
    cover_url VARCHAR(500),
    user_id VARCHAR(64) NOT NULL, -- fait le lien avec l'utilisateur NoSQL
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Index pour accélérer les requêtes sur les utilisateurs
CREATE INDEX idx_user_id ON games(user_id);