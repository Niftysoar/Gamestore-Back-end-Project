<!-- <?php

if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

?> -->

<header class="bg-zinc-800 text-white">
   <div class="container mx-auto px-6 py-6">
      <div class="flex flex-col md:flex-row justify-between items-center">
         <div class="flex items-center mb-4 md:mb-0">
            <img src="img/Logo.png" alt="Logo GameStore" class="logo-image" />
            <h1 class="text-2xl font-bold">GameStore</h1>
         </div>
         <nav class="flex items-center space-x-6">
            <?php
               if (isset($_SESSION['user_id'])) {
                  $username = htmlspecialchars($_SESSION['user_name']);
                  echo "
                        <a href='dashboard.php' class='text-white px-4 py-2'>$username</a>
                        <a href='logout.php' class='bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-full'>Déconnexion</a>
                  ";
               } else {
                  echo "
                        <a href='login.php' class='text-white px-4 py-2'>Se connecter</a>
                        <a href='register.php' class='bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-full'>S’inscrire</a>
                  ";
               }
            ?>
         </nav>
      </div>
   </div>
</header>