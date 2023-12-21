<?php
include("db.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve payment details from the POST data
    $cardNumber = $_POST['card_number'];
    $expirationDate = $_POST['expiration_date'];
    $cvv = $_POST['cvv'];
    $billingAddress = $_POST['billing_address'];
    $totalAmount = $_POST['total_amount'];

    $ref = 'REF' . time(); // You can customize this as needed

    

    // After successful payment processing, update the user_order 
    $userId = $_SESSION['user_id'];

    // Create an entry in the user_order table with prepared statement
    $orderInsertQuery = "INSERT INTO `user_order` (`ref`, `date`, `total`, `user_id`) VALUES (?, NOW(), ?, ?)";
    
    $stmtOrder = mysqli_prepare($con, $orderInsertQuery);
    mysqli_stmt_bind_param($stmtOrder, "sdi", $ref, $totalAmount, $userId);
    mysqli_stmt_execute($stmtOrder);
    mysqli_stmt_close($stmtOrder);

    // Redirect to order_placed.php after successful payment and order creation
    header("Location: order_placed.php");
    exit();
} else {
    // Redirect to payment.php if accessed without proper form submission
    header("Location: payment.php");
    exit();
}
?>
