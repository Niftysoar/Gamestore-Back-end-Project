<?php

include 'config.php';

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = md5($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = md5($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select->execute([$email]);

   if($select->rowCount() > 0){
      $message[] = 'user email already exist!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         $insert = $conn->prepare("INSERT INTO `users`(name, email, password, image) VALUES(?,?,?,?)");
         $insert->execute([$name, $email, $pass, $image]);

         if($insert){
            if($image_size > 2000000){
               $message[] = 'image size is too large!';
            }else{
               move_uploaded_file($image_tmp_name, $image_folder);
               $message[] = 'registered successfully!';
               header('location:login.php');
            }
         }

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
        <header class="header">
            <div class="logo">
            <img src="img/Logo.png" alt="Logo GameStore" class="logo-image" />
            <h1 class="site-title">GameStore</h1>
            </div>
            <nav class="navigation">
            <button class="btn-signup">S’inscrire</button>
            <span class="btn-login">Se connecter</span>
            </nav>
        </header>

      <!-- Formulaire de connexion -->
      <main class="form-container">
            <div class="form-box">
                <div class="form-header">
                    <h2>S’inscrire</h2>
                </div>

                <form class="form-connexion" action="#" method="post">
                    <div class="form-group">
                      <label for="email">Email *</label>
                      <input type="email" id="email" name="email" required />
                    </div>

                    <div class="form-group">
                        <label for="email">Nom d’utilisateur *</label>
                        <input type="email" id="email" name="email" required />
                    </div>

                    <div class="form-group">
                      <label for="password">Mot de passe *</label>
                      <input type="password" id="password" name="password" required />
                    </div>
                </form>

                <div class="form-footer">
                    <p class="form-footer-text">Deja un compte ? <a href="login.php" class="lien-inscription">Connectez-vous</a></p>
                    <button type="submit" class="btn">S’inscrire</button>
                </div>
            </div>
      </main>

      <!-- Footer -->
      <footer class="footer">
            <nav class="footer-links">
                <a href="#">Contact</a> |
                <a href="#">Conditions d’utilisation</a> |
                <a href="#">Politique de confidentialité</a> |
                <a href="#">Retour</a>
            </nav>

            <p>© 2025 GameStore, Tous droits réservés</p>
      </footer>
    </div>
  </body>
</html>