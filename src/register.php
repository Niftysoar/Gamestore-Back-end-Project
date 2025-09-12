<?php
include './Config/db.php'; // ton fichier PDO (connexion SQL)

$message = ""; // variable pour afficher le feedback à l’utilisateur

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {

    // Sécurisation des données
    $name     = isset($_POST['name']) ? trim($_POST['name']) : null;
    $email    = isset($_POST['email']) ? trim($_POST['email']) : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    if (!$name || !$email || !$password) {
        $message = "⚠️ Tous les champs sont obligatoires.";
    } else {
        try {
            // Vérifier si l’email existe déjà
            $check = $pdo->prepare("SELECT id FROM users WHERE email = :email");
            $check->execute([":email" => $email]);

            if ($check->rowCount() > 0) {
                $message = "⚠️ Cet email est déjà utilisé.";
            } else {
                // Hachage sécurisé du mot de passe
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insérer l’utilisateur
                $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
                $stmt->execute([
                    ":name"     => $name,
                    ":email"    => $email,
                    ":password" => $hashedPassword
                ]);

                $message = "✅ Inscription réussie ! Vous pouvez vous connecter.";
                header("Location: login.php");
                exit;
            }
        } catch (PDOException $e) {
            $message = "❌ Erreur SQL : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>GameStore - Inscription</title>
    <link rel="icon" href="img/favicon.ico">

    <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   
    <link rel="stylesheet" href="CSS/style.css" />
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
                <h2>S’inscrire</h2>
            </div>

            <!-- Affichage des messages -->
            <?php if (!empty($message)) : ?>
                <p style="color: red;"><?= $message ?></p>
            <?php endif; ?>

            <form class="form-connexion" action="/src/register.php" method="post">
                <div class="form-group">
                    <label for="name">Nom d’utilisateur *</label>
                    <input type="text" id="name" name="name" required />
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required />
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe *</label>
                    <input type="password" id="password" name="password" required />
                </div>

                <div class="form-footer">
                    <p class="form-footer-text">
                        Déjà un compte ? <a href="login.php" class="lien-inscription">Connectez-vous</a>
                    </p>
                    <button type="submit" name="submit" class="btn">S’inscrire</button>
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