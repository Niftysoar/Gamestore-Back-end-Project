<?php
session_start();

include './Config/mongodb.php';
require_once './Classes/Games.php';

if (!isset($_SESSION['user_id'])) {
    die("⚠️ Vous devez être connecté.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = mongo_db();
    $games = new Games($db);

    try {
        // Gestion de l’image uploadée
        $image = null;
        if (!empty($_FILES['image']['name'])) {
            // 📌 Dossier cible
            $uploadDir = __DIR__ . "/uploaded_img/";

            // Si le dossier n’existe pas → on le crée
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Nom unique pour éviter les conflits
            $image = time() . "_" . basename($_FILES['image']['name']);
            $targetPath = $uploadDir . $image;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                // ✅ Upload réussi
            } else {
                echo "<p style='color:red'>Erreur lors de l’upload de l’image</p>";
            }
        }

        $games->addGame(
            $_SESSION['user_id'],
            $image,
            $_POST['title'],
            $_POST['platform'],
            $_POST['status'],
            $_POST['rating'] ?? null,
            $_POST['hours_played'] ?? 0,
            $_POST['notes'] ?? ""
        );

        $_SESSION['message'] = "✅ Jeu ajouté avec succès !";
        header("Location: dashboard.php");
        exit();
    } catch (Exception $e) {
        die("❌ Erreur lors de l'ajout : " . $e->getMessage());
    }
}