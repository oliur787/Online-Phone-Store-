<?php
// Check if the price is passed through the URL
if (isset($_GET['price'])) {
    $originalPrice = (int)$_GET['price']; // Original price
    $discountedPrice = $originalPrice - ($originalPrice * 0.20); // Apply 20% discount
} else {
    $originalPrice = 0;
    $discountedPrice = 0;
}
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Integration (Card Payment)</title>
    <link rel="stylesheet" href="./css/_style.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<button type="button" onclick="goback()" class="back">Go Back</button> 
<div class="row">
    <div class="col-md-6">
        <div class="form-container">
            <form autocomplete="off" action="checkout-charge.php" method="POST">
                <div>
                    <input type="text" name="c_name" required/>
                    <label>Customer Name</label>
                </div>
                <div>
                    <input type="text" name="address" required/>
                    <label>Address</label>
                </div>
                <div>
                    <input type="number" id="ph" name="phone" pattern="\d{10}" maxlength="10" required/>
                    <label>Contact number</label>
                </div>
                
                <!-- Display discounted price -->
                <p>Original Price: ৳<?php echo $originalPrice; ?></p>
                <p>Discounted Price: ৳<?php echo number_format($discountedPrice, 2); ?> (20% Winter Discount Applied)</p>

                <!-- Hidden field to pass the discounted price -->
                <input type="hidden" name="price" value="<?php echo $discountedPrice; ?>">

                <!-- Stripe checkout button integration -->
                <script
                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="pk_test_51N9pLtFm1dxI5Ce5NFBqMnzFamDhBBi0QxkTYbYO8nY35BFhtR05WGSnquztSy1DK3VTpHb744xuQxpgi1SuUMCI008ffahKAk"
                    data-amount="<?php echo $discountedPrice * 100; ?>"  <!-- Stripe requires amount in cents -->
                    data-name="Mobile Shop Purchase"
                    data-description="Purchase from Mobile Shop"
                    data-currency="bdt"
                    data-locale="auto">
                </script>
            </form>
        </div>
    </div>
</div>

<script>
    function goback(){
        window.history.go(-1);
    }
</script>
</body>
</html>
