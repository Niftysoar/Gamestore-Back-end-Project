<?php
require '../vendor/autoload.php'; // charge MongoDB\Client

try {
    // Connexion au serveur MongoDB (par défaut en local)
    $client = new MongoDB\Client("mongodb://localhost:27017");

    // Sélectionne la base de données GameStore
    $db = $client->GameStore;

} catch (Exception $e) {
    die("Erreur de connexion MongoDB : " . $e->getMessage());
}