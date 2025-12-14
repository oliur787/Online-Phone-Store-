<?php
// Include necessary files and start session
include_once 'dashboard/db.php';
 
// Interface for Discount Strategy
interface DiscountStrategy {
    public function applyDiscount($price);
}

// Winter discount strategy (20% off during winter months)
class WinterDiscountStrategy implements DiscountStrategy {
    public function applyDiscount($price) {
        $currentMonth = date("n"); // Numeric representation of the month
        if (in_array($currentMonth, [12, 1, 2])) {
            return $price * 0.8; // 20% discount during winter months
        }
        return $price;
    }
}

// Product Interface for MobileProduct
interface Product {
    public function getModel();
    public function getPrice();
    public function getImage();
    public function getDiscountedPrice();
}

// Concrete Product: MobileProduct
class MobileProduct implements Product {
    private $model;
    private $price;
    private $image;
    private $discountStrategy;

    public function __construct($model, $price, $image, DiscountStrategy $discountStrategy) {
        $this->model = $model;
        $this->price = $price;
        $this->image = $image;
        $this->discountStrategy = $discountStrategy;
    }

    public function getModel() {
        return $this->model;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getImage() {
        return $this->image;
    }

    public function getDiscountedPrice() {
        return $this->discountStrategy->applyDiscount($this->price);
    }
}

// Product Factory Class to create MobileProduct
class ProductFactory {
    public static function createMobileProduct($model, $price, $image, DiscountStrategy $discountStrategy) {
        return new MobileProduct($model, $price, $image, $discountStrategy);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Buy Mobile</title>
    <link rel="stylesheet" href="css/productt.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row navbar">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#"><img src="images/logo.png" alt="" class="img-fluid"></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class=""><i class="fas fa-bars"></i></span>
                    </button>
                    
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="./index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./login.php">Login</a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" href="./contact.php">Contact Us</a>
                            </li>
                        </ul>
                    </div> 
                </div>   
            </nav>
        </div>
    </div>

    <div class="container">
        <div class="row text-center" style="margin-top: 25px;">
            <h1 style="margin-bottom: 0px;"> <b><?php echo strtoupper($_GET['brand']);?></b> </h1>
        </div>
        <?php

            // Get the brand from the URL
            $brand = $_GET['brand'];

            // Initialize Discount Strategy (e.g., Winter Discount)
            $discountStrategy = new WinterDiscountStrategy();

            // SQL query to fetch mobile products based on the brand
            $sql = "SELECT * FROM product_details WHERE brand='$brand' AND id IN (SELECT id FROM products WHERE pending=1) ORDER BY id DESC;";
            $result = mysqli_query($conn, $sql);
            $count = 0;

            while($row = $result->fetch_assoc()) {
                $model = $row['model'];
                $price = $row['price'];
                $image = $row['picture'];

                // Create MobileProduct object using the Factory
                $product = ProductFactory::createMobileProduct($model, $price, $image, $discountStrategy);

                if ($product) {
                    if ($count == 0) {
                        echo "<div class='row'>";
                    }
                    
                    $finalPrice = $product->getDiscountedPrice();

                    // Display each product card
                    echo "
                    <div class='col-md-4'>
                        <div class='thumb-wrapper'>
                            <span class='wish-icon'><i class='fa fa-heart-o'></i></span>
                            <div class='img-box'>
                                <img src='" . $product->getImage() . "' class='img-fluid' alt='Mobile'>
                            </div>
                            <div class='thumb-content'>
                                <h4>" . $product->getModel() . "</h4>
                                <p class='item-price' style='font-size: 20px;'>";

                    // Display the discounted price if applicable
                    if ($finalPrice < $price) {
                        echo "<s>৳ $price</s> <b>৳ $finalPrice</b>";
                    } else {
                        echo "<b>৳ $price</b>";
                    }

                    echo "</p>
                            <a href='./product_details.php?id=".$row['id']."' class='btn btn-primary'>Details</a>
                        </div>
                    </div>
                    </div>
                    ";

                    $count++;

                    // Break the row after 3 products
                    if ($count == 3) {
                        $count = 0;
                        echo "</div><div class='row'>";
                    }
                }
            }
        ?>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>