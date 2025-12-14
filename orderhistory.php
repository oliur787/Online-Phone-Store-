<?php
// Start the session 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Assuming the session variable 'user_id' holds the logged-in user's ID
$user_id = $_SESSION['user_id'];
// Database connection details
include_once 'dashboard/db.php';
$user_id = $_SESSION['user_id'];// Get user_id from the session
// Order class
class Order {
    public $order_id;
    public $products = [];
    public $totalPrice;
    public $customerName;
    public $phone;
    public $address;
    public $status;


    public function displayOrder() {
        echo "<tr>";
        echo "<td>{$this->order_id}</td>";
        echo "<td>{$this->customerName}</td>";
        echo "<td>{$this->phone}</td>";
        echo "<td>{$this->address}</td>";
        echo "<td>";
        echo implode("<br>", $this->products); // Join products with line breaks
        echo "</td>";
        echo "<td>৳ " . number_format($this->totalPrice, 2) . "</td>";
        echo "<td>{$this->status}</td>";
        echo "</tr>";
    }
}


// Builder interface
interface OrderBuilder {
    public function setOrderId($order_id);
    public function setCustomerName($name);
    public function setPhone($phone);
    public function setAddress($address);
    public function addProduct($product);
    public function setTotalPrice($price);
    public function setStatus($status);
    public function getOrder();
}

// Concrete Builder
class ConcreteOrderBuilder implements OrderBuilder {
    private $order;

    public function __construct() {
        $this->order = new Order();
    }

    public function setOrderId($order_id) {
        $this->order->order_id = $order_id;
        return $this;
    }

    public function setCustomerName($name) {
        $this->order->customerName = $name;
        return $this;
    }

    public function setPhone($phone) {
        $this->order->phone = $phone;
        return $this;
    }

    public function setAddress($address) {
        $this->order->address = $address;
        return $this;
    }

    public function addProduct($product) {
        $this->order->products[] = $product;
        return $this;
    }

    public function setTotalPrice($price) {
        $this->order->totalPrice = $price;
        return $this;
    }

    public function setStatus($status) {
        $this->order->status = $status;
        return $this;
    }

    public function getOrder() {
        return $this->order;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Order History</title>
</head>
<header>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-sm navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="images/logo.png" alt="Logo" class="img-fluid"></a>
            <div id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <input class="search js-search" oninput="get_data(this.value)" type="text" autofocus="true" placeholder="Search Here">
                        <div class="results js-results"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <?php
                        if (!isset($_SESSION['username'])) {
                            echo "<a class='nav-link' href='./login.php'>Login</a>";
                        } else {
                            echo "
                                <a class='dropdown-toggle ms-4' style='text-decoration:none;' type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false'>
                                    <img src='https://s3.eu-central-1.amazonaws.com/bootstrapbaymisc/blog/24_days_bootstrap/fox.jpg' width='40' height='40' class='rounded-circle'>
                                </a>
                                <ul class='dropdown-menu' aria-labelledby='dropdownMenuButton1'>
                                    <li><a class='dropdown-item' href='#'>" . $_SESSION['username'] . "</a></li>
                                    <hr>
                                    <li><a class='dropdown-item' href='./logout.php'>Logout</a></li>
                                </ul>
                            ";
                        }
                        ?>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="./contact.php">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<body>

<div class="container mt-4">
<?php

//$user_id = $_SESSION['user_id'];// Get user_id from the session

//echo 'User ID: ' . htmlspecialchars($user_id); // Safely display the user_id
?>
    <h1 class="text-center">Order History</h1>
    
    <?php
 $sql = "SELECT o.order_id, o.name, o.phone, p.model, o.address, o.amount, o.status
 FROM orders o
 JOIN product_details p ON o.p_id = p.id
 WHERE o.user_id = ?";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Check for statement preparation failure
if (!$stmt) {
die("Statement preparation failed: " . $conn->error);
}

// Bind the parameters (bind user_id from session)
$stmt->bind_param("s", $user_id); // 'i' stands for integer, as user_id is likely an integer

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

// Check if any orders exist for the user
if ($result->num_rows > 0) {
// Start table
echo "<table class='table table-striped'>";
echo "<thead>
     <tr>
         <th>Order ID</th>
         <th>Customer Name</th>
         <th>Phone</th>
         <th>Address</th>
         <th>Products</th>
         <th>Total Amount</th>
         <th>Status</th>
     </tr>
   </thead><tbody>";

// Process the results and display each order
while ($row = $result->fetch_assoc()) {
 // Build the order using the builder pattern
 $orderBuilder = new ConcreteOrderBuilder();
 $orderBuilder->setOrderId($row['order_id'])
              ->setCustomerName($row['name'])
              ->setPhone($row['phone'])
              ->setAddress($row['address'])
              ->addProduct($row['model'])  // Assuming product model is the key identifier
              ->setTotalPrice($row['amount'])
              ->setStatus($row['status']);
 
 // Get the built order object
 $order = $orderBuilder->getOrder();

 // Call the displayOrder method to print the order inside a table row
 $order->displayOrder();
}

echo "</tbody></table>";
} else {
echo "<p>No orders found for the user.</p>";
}

$stmt->close();
?>
</div>

<!-- Bootstrap and JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
<script>
    function get_data(query) {
        const resultsDiv = document.querySelector('.js-results');
        if (query.length === 0) {
            resultsDiv.innerHTML = '';
            return;
        }

        // Example search result filtering
        resultsDiv.innerHTML = `<p>Search results for "${query}" will appear here.</p>`;
    }
</script>
</body>
</html>
<?php
$conn->close();
?>