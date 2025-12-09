<?php
session_start();

include_once 'dashboard/db.php';

$user = $_POST['userid'];
$pass = $_POST['password'];

if (empty($user)) {
    header("Location: login.php?error=Enter username");
    exit();
}
if (empty($pass)) {
    header("Location: login.php?error=Enter password");
    exit();
}

$sql = "SELECT user_id, username, password, power FROM users WHERE username='$user' AND password='$pass'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    
    // Store the user ID and username in the session
    $_SESSION['user_id'] = $row['user_id'];
    $_SESSION['username'] = $user;
    
    // Check user role
    if ($row['power'] == "admin") {
        $_SESSION['role'] = "admin";
    } else if ($row['power'] == "seller") {
        $_SESSION['role'] = "seller";
    } else {
        $_SESSION['role'] = "user";
    }
    
    // Redirect based on user role
    if ($_SESSION['role'] != "user") {
        header("Location: dashboard/index.php");
    } else {
        header("Location: index.php");
    }
} else {
    header("Location: login.php?error=wrong password");
}

mysqli_close($conn);
?>
