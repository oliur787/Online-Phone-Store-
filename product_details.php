<?php
// Winter discount strategy
interface DiscountStrategy {
    public function applyDiscount($price);
}
 
class WinterDiscountStrategy implements DiscountStrategy {
    public function applyDiscount($price) {
        $currentMonth = date("n"); // Numeric representation of the month (1-12)
        // If the current month is November, December, January, or February, apply a 20% discount
        if (in_array($currentMonth, [11, 12, 1, 2])) {
            return $price * 0.8; // 20% discount for winter months
        }
        return $price; // No discount during other months
    }
}

$id = $_GET['id']; // Get the product ID from the URL
include_once 'dashboard/db.php'; // Include the database connection
$sql = "SELECT * FROM product_details WHERE id = $id"; // Query to fetch the product details
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result); // Fetch the product details
} else {
    echo "Product not found!";
    exit();
}

// Apply discount strategy
$discountStrategy = new WinterDiscountStrategy();
$originalPrice = $row['price'];
$finalPrice = $discountStrategy->applyDiscount($originalPrice);

// Set cookie for model
setcookie("Model", $row['model'], time() + 86400, "/"); 

// Debugging: check if discount logic works
// echo "Current Month: " . date("n") . "<br>";
// echo "Original Price: " . $originalPrice . "<br>";
// echo "Discounted Price: " . $finalPrice . "<br>";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Product Details</title>
</head>

<body>
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-5 col-md-6 col-sm-12 text-center py-5"
                style="box-shadow: rgba(9, 30, 66, 0.25) 0px 4px 8px -2px, rgba(9, 30, 66, 0.08) 0px 0px 0px 1px;">
                <img src="<?php echo $row['picture']; ?>" height="300px">
            </div>
            <div class="col-lg-7 col-md-6 col-sm-12 py-5 text-center"
                style="box-shadow: rgba(9, 30, 66, 0.25) 0px 4px 8px -2px, rgba(9, 30, 66, 0.08) 0px 0px 0px 1px;">
                <h1><?php echo $row['model']; ?></h1>
                <h2>
                    <?php 
                    // Show original and discounted price
                    if ($finalPrice < $originalPrice) {
                        echo "<s>৳ $originalPrice</s> <b>৳ $finalPrice</b>";
                        echo "<br><span style='color: green;'>Winter discount applied!</span>";
                    } else {
                        echo "৳ $originalPrice"; // No discount
                    }
                    ?>
                </h2>

                <a href="orderconfirmation.php?id=<?php echo $row['id']; ?>" class="btn btn-primary" style="font-size: 20px; background-color:#58aa3a">Buy Now offline</a>
                <a href="checkout.php?price=<?php echo $finalPrice; ?>" class="btn btn-primary" style="font-size: 20px; background-color:#58aa3a">Buy Now online</a>
            </div>
        </div>

        <h3 class='text-center my-5'>Details:</h3>

        <div style="box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px, rgb(209, 213, 219) 0px 0px 0px 1px inset;">
            <table class='table text-center' style="font-size: 20px;">
                <thead>
                    <tr>
                        <th scope='col'>Name</th>
                        <th scope='col'>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        echo "
                            <tr>
                                <th scope='row'>Model: </th>
                                <td style='color:blue;'> <strong>". $row['model'] ."</strong></td>
                            </tr>
                            <tr>
                                <th scope='row'>Display: </th>
                                <td>". $row['display'] ."</td>
                            </tr>
                            <tr>
                                <th scope='row'>Processor: </th>
                                <td>". $row['processor'] ."</td>
                            </tr>
                            <tr>
                                <th scope='row'>Front Camera: </th>
                                <td>". $row['fcam'] ."</td>
                            </tr>
                            <tr>
                                <th scope='row'>Back Camera: </th>
                                <td>". $row['rcam'] ."</td>
                            </tr>
                            <tr>
                                <th scope='row'>Storage: </th>
                                <td>". $row['storage'] ."</td>
                            </tr>
                            <tr>
                                <th scope='row'>Battery: </th>
                                <td>". $row['battery'] ."</td>
                            </tr>
                            <tr>
                                <th scope='row'>RAM: </th>
                                <td>". $row['ram'] ."</td>
                            </tr>
                            <tr>
                                <th scope='row'>Color: </th>
                                <td>". $row['color'] ."</td>
                            </tr>
                            <tr>
                                <th scope='row'>Connectivity: </th>
                                <td>". $row['connectivity'] ."</td>
                            </tr>
                            <tr>
                                <th scope='row'>SIM: </th>
                                <td>". $row['sim'] ."</td>
                            </tr>
                            <tr>
                                <th scope='row'>Sensor: </th>
                                <td>". $row['sensor'] ."</td>
                            </tr>
                            <tr>
                                <th scope='row'>Release Date: </th>
                                <td>". $row['r_date'] ."</td>
                            </tr>
                        ";
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <div class="container-fluid pt-3" style="background: currentColor;">
            <div class="row text-center">
                <p style="color:white">Copyright © 2025 Let's Connect.</p>
            </div>
        </div>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
