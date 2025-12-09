Online<?php 
session_start(); // Start the session to access session variables

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // Get user_id from the session
    echo 'User ID: ' . htmlspecialchars($user_id); // Safely display the user_id
} else {
    echo "User is not logged in.";
}
?>    


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Online Phone Store</title>

        
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

    <link rel="stylesheet" href="css/style.css?r=x">

</head>

<body>

    <header style="min-height: 100vh;">

            <div class="row navbar">
                <nav class="navbar navbar-expand-sm navbar-light">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#"><img src="images/Imageofbackground.png" alt="" class="img-fluid"></a>
                        
                        <div  id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ">

                                <li class="nav-item ">
                                    <input class ="search js-search" oninput="get_data(this.value)" type="text" autofocus="true" placeholder = "Search Here">
                                    <div class="results js-results">
                                        <div></div>
                                        <div></div>
                                    </div>
                                </li>

                                <li class="nav-item ">
                                    <a class="nav-link" aria-current="page" href="./index.php">Home</a>
                                </li>
                                <li class="nav-item dropdown">
                                    
                                    <?php
                                if(!isset($_SESSION['username'])){
                                    echo "<a class='nav-link' href='./login.php'>Login</a>";
                                }
                                else{
                                    echo "
                                        <a class='dropdown-toggle ms-4' style='text-decoration:none;' type='button'
                                            id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false'>
                                            <img src='https://s3.eu-central-1.amazonaws.com/bootstrapbaymisc/blog/24_days_bootstrap/fox.jpg' width='40' height='40' class='rounded-circle'>
                                        </a>
                                        <ul class='dropdown-menu' aria-labelledby='dropdownMenuButton1'>
                                            <li><a class='dropdown-item' href='#'>". $_SESSION['username'] ."</a></li>
                                            <hr>
                                            <li><a class='dropdown-item' href='./orderhistory.php'>My Orders</a></li> <!-- New My Orders Link -->
                                            <li><a class='dropdown-item' href='./logout.php'>Logout
                                            </a></li>
                                            
                                        </ul>
                                        ";
                                }
                                ?>
                                    
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./about.php">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="./contact.php">Contact Us</a>
                                </li>
                            </ul>
                        </div> 
                    </div>      
                </nav>
            </div>

            <div class="row hg align-items-center" style="padding-left: 10%;">
                <div class="col-lg-6 col-md-8 col-sm-12 left">
                    <h4>resell phone store</h4>

                    <h1>Be Connected with your <br> Friends & Families.</h1> <a href="login.php" 
   class="btn btn-primary mt-4 px-4 py-2" 
   style="font-size: 18px; border-radius: 8px;">
   Login
</a>

                    <P>
 
                    </P>
                </div>
                <div class="col-lg-6 col-md-8 col-sm-12  ">
                    <img  class="img-fluid" src="images/background-phone.png" alt="">
                </div>
            </div>

    </header>





    <section class="brands">

        <div class="container">
            <div class="row py-5">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="online_course">
                        <img src="images/apple.png" alt="" class="img-fluid">
                        <h3>Apple</h3>
                        <p>Let's Connect</p>
                        <a href="./product.php?brand=apple" class="btn btn-course">Buy Product</a>
                    </div>
                </div> 

                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="online_course">
                        <img src="images/samsung.png" alt="" class="img-fluid">
                        <h3>Samsung</h3>
                        <p>Let's Connect</p>       
                        <a href="./product.php?brand=samsung" class="btn btn-course">Buy Product</a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="online_course">
                        <img src="images/mi.png" alt="" class="img-fluid">
                        <h3>Xiaomi</h3>
                        <p>Let's Connect</p>
                        <a href="./product.php?brand=xiaomi" class="btn btn-course">Buy Product</a>
                    </div>
                </div>
            </div>

            <div class="row py-5">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="online_course">
                        <img src="images/one plus.png" alt="" class="img-fluid">
                        <h3>OnePlus</h3>
                        <p>Let's Connect</p>
                        <a href="./product.php?brand=oneplus" class="btn btn-course">Buy Product</a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="online_course">
                        <img src="images/readme.png" alt="" class="img-fluid">
                        <h3>Realme</h3>
                        <p>Let's Connect</p>
                        <a href="./product.php?brand=realme" class="btn btn-course">Buy Product</a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="online_course">
                        <img src="images/google.png" alt="" class="img-fluid">
                        <h3>Google Pixel</h3>
                        <p>Let's Connect</p>
                        <a href="./product.php?brand= google pixel" class="btn btn-course ">Buy Product</a>
                    </div>
                </div>
            </div>
        </div>


    </section>


    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md">
                    <div class="logos">
                        
                        <i class="fas fa-basketball-ball"></i>
                        <i class="fab fa-twitter"></i>
                        <i class="fab fa-facebook-f"></i>
                        <i class="fab fa-linkedin-in"></i>
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <p>Copyright © 2023 Let's Connect All rights reserved.</p>
            </div>
        </div>
    </footer>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
   
  
 


</body>


<script type="text/javascript">
    //for live search 
    function get_data(text)
    {
        
        if(text.trim() == "")
            return

        var form = new FormData();
        form.append('text',text);

        var ajax = new XMLHttpRequest();

        ajax.addEventListener('readystatechange',function(e){
            if(ajax.readyState == 4 && ajax.status == 200){
                //result are back 
                 handle_result(ajax.responseText);
            }
        });

        ajax.open('post','api.php',true)
        ajax.send(form);
    }

    function handle_result(result)
    {

         var result_div = document.querySelector(".js-results");
         var str = "";

         var obj = JSON.parse(result);
         for (var i = obj.length - 1; i >=0; i--){
            
           
            str += `<a href='product_details.php?id=${obj[i].id}'><div>` + obj[i].model + "</div></a>";
         }

         result_div.innerHTML = str;
    }

</script>

</html>