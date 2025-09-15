<?php
include './Config/db.php';
require_once './Classes/User.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name !== '' && $email !== '' && $password !== '') {
        $userObj = new User($pdo);

        if ($userObj->register($name, $email, $password)) {
            $_SESSION['success'] = "✅ Compte créé avec succès, vous pouvez vous connecter.";
            header("Location: login.php");
            exit;
        } else {
            $message = "⚠️ Cet email est déjà utilisé.";
        }
    } else {
        $message = "❌ Tous les champs sont obligatoires.";
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

    <?php include 'header.php'; ?>

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
    <?php include 'footer.php'; ?>
  </body>
</html>