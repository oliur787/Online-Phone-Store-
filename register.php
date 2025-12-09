<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">

   <link rel="stylesheet" href="css/register.css">
   <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">

</head>

<body>
   <div class="pt-3">
      <div class="login-main-text row text-center">
         <h1 style="font-family: 'Lobster', cursive; color: #CD1818;"> <span style="color: #F3950D;">Lets</span> Connect
         </h1>
         <h2>Register Page</h2>
         <p>Login or register from here to access.</p>
      </div>
   </div>

   <div class="login-container">
            <form action="op_register.php" method="post">

            <?php
                  
                  if(isset($_GET['error'])){
                     echo "<div class='alert alert-danger' role='alert'>
                           ". $_GET['error'] ."
                        </div>";
                  }

               ?>
               <div class="form-group">
                  <label>User Name</label>
                  <input type="text" class="form-control" placeholder="User Name" name="user_name">
               </div>
               <div class="form-group">
                  <label>Full Name</label>
                  <input type="text" class="form-control" placeholder="Full Name" name="user_fname">
               </div>
               <div class="form-group">
                  <label>Email Address</label>
                  <input type="email" class="form-control" placeholder="Email" name="user_email">
               </div>
               <div class="form-group">
                  <label>Contact No. </label>
                  <input type="text" class="form-control" placeholder="Phone" name="user_phone">
               </div>
               <div class="form-group">
                  <label>Password</label>
                  <input type="password" class="form-control" placeholder="Password" name="user_pass">
               </div>
               <div class="form-group">
                  <lebel style="font-size:20px">Role: </lebel>
                  <select class="form-select col-5" style="font-size:20px" name="user_role">
                     <option value="" selected disabled>Select</option>
                     <option value="buyer">Buyer</option>
                     <option value="seller">Seller</option>
                  </select><br>
            </form>

            <button type="submit" name = "submit" class="btn btn-secondary">Sign Up</button>
            <a href="./login.php" class="btn btn-secondary ">Back</a>
   </div>
</body>

</html>