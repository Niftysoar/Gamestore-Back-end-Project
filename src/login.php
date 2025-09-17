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
    <link rel="icon" href="img/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="CSS/style.css" />
  </head>
  <body>

    <?php include 'header.php'; ?>

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

    <?php include 'footer.php'; ?>

  </body>
</html>