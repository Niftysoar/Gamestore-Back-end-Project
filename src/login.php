<?php
session_start();

include './Config/db.php';
require_once './Classes/User.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email !== '' && $password !== '') {
        $userObj = new User($pdo);

        $user = $userObj->login($email, $password);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: dashboard.php");
            exit;
        } else {
            $message = "❌ Identifiants incorrects";
        }
    } else {
        $message = "⚠ Tous les champs sont obligatoires.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>GameStore - Connexion</title>
    <!-- <link rel="stylesheet" href="CSS/style.css" /> -->
  </head>
  <body>
    <div class="connexion">
        <!-- Header -->
        <!-- <header class="header">
            <div class="logo">
            <img src="img/Logo.png" alt="Logo GameStore" class="logo-image" />
            <h1 class="site-title">GameStore</h1>
            </div>
            <nav class="navigation">
            <button class="btn-signup">S’inscrire</button>
            <span class="btn-login">Se connecter</span>
            </nav>
        </header> -->

      <!-- Formulaire de connexion -->
      <main class="form-container">
            <div class="form-box">
                <div class="form-header">
                    <h2>Connexion</h2>
                </div>

                <form class="form-connexion" action="/src/login.php" method="post">
                    <div class="form-group">
                      <label for="email">Email *</label>
                      <input type="email" id="email" name="email" required />
                    </div>

                    <div class="form-group">
                      <label for="password">Mot de passe *</label>
                      <input type="password" id="password" name="password" required />
                    </div>

                    <div class="form-footer">
                      <p class="form-footer-text">Nouveau ? <a href="/src/register.php" class="lien-inscription"> Inscrivez-vous</a></p>
                      <button type="submit" class="btn">Connexion</button>
                     </div>
                </form>
            </div>
      </main>

      <!-- Footer -->
      <!-- <footer class="footer">
            <nav class="footer-links">
                <a href="#">Contact</a> |
                <a href="#">Conditions d’utilisation</a> |
                <a href="#">Politique de confidentialité</a> |
                <a href="#">Retour</a>
            </nav>

            <p>© 2025 GameStore, Tous droits réservés</p>
      </footer> -->
    </div>
  </body>
</html>