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
  <body class="bg-gray-100 min-h-screen">

    <?php include 'header.php'; ?>

    <!-- Formulaire de connexion -->
    <main class="form-container flex justify-center items-center">
          <div class="bg-white rounded-lg shadow-xl w-full max-w-md max-h-[90vh] overflow-y-auto">
              <div class="border-b px-6 py-4">
                  <h3 class="text-xl font-semibold text-gray-800">Connexion</h3>
              </div>

              <!-- Affichage des messages -->
              <?php if (!empty($message)) : ?>
                  <p style="color: red;"><?= $message ?></p>
              <?php endif; ?>

              <div class="p-6">
                  <form class="form-connexion" action="/src/login.php" method="post">
                      <div class="mb-4">
                        <label for="email" class="block text-gray-700 mb-2">Email *</label>
                        <input type="email" id="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500" required />
                      </div>

                      <div class="mb-4">
                        <label for="password" class="block text-gray-700 mb-2">Mot de passe *</label>
                        <input type="password" id="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500" required />
                      </div>

                      <div class="flex justify-center items-center mt-4 gap-7">
                        <p class="text-left text-sm mt-4 text-black">
                            Nouveau ? <a href="/src/register.php" class="text-indigo-600 underline"> Inscrivez-vous</a>
                        </p>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Connexion</button>
                        </div>
                  </form>
              </div>
          </div>
    </main>

    <?php include 'footer.php'; ?>

  </body>
</html>