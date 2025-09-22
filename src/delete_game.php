<?php
session_start();
include './Config/mongodb.php';
require_once './Classes/Games.php';

if (!isset($_SESSION['user_id'])) {
    die("⚠️ Vous devez être connecté.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['game_id'])) {
    $gameId = $_POST['game_id'];

    $games = new Games($db);
    $deleted = $games->deleteGame($gameId);

    if ($deleted) {
        $_SESSION['message'] = "✅ Jeu supprimé avec succès.";
    } else {
        $_SESSION['message'] = "❌ Impossible de supprimer ce jeu.";
    }

    header("Location: dashboard.php");
    exit;
} else {
    die("Requête invalide.");
}