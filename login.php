<?php 
   session_start();
   if(isset($_SESSION['username'])){
      echo "<script>top.window.location = './index.php'</script>";
   }
?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="css/login.css">
   <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
</head>

<body>

   <div class="pt-3">
      <div class="login-main-text row text-center">
         <!-- Changed brand text -->
         <h1 style="font-family: 'Lobster', cursive; color: #CD1818;">
            <span style="color: #F3950D;">Online</span> Phone Store
         </h1>
         <h2>Login Page</h2>
         <p>Login or register from here to access.</p>
      </div>
   </div>
   
   <div class="login-container">
      <h1 class="text-center">Login</h1>
      <form action="validate_user.php" method="post">
         <label for="userid">Username</label>
         <input type="text" id="userid" name="userid" placeholder="Enter your username">
        
         <label for="password">Password</label>
         <input type="password" id="password" name="password" placeholder="Enter your password">

         <button type="submit" name="submit" class="btn btn-secondary">Login</button>
      </form>
      <br>
      <a href="./register.php" class="btn btn-secondary">Register</a>
      <a href="./index.php" class="btn btn-secondary">Back</a>
   </div>

</body>

</html>
