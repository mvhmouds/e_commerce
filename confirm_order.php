<?php
include("db.php");
session_start();

// Check if the cart is not empty
if (!empty($_SESSION['cart'])) {
     $userId = $_SESSION['user_id']; 

    // Calculate the total amount
    $totalAmount = 0;
    foreach ($_SESSION['cart'] as $cartItem) {
        $productId = $cartItem['product_id'];
        $quantity = $cartItem['quantity'];

        $productQuery = "SELECT * FROM `product` WHERE `id` = ?";
        $stmt = mysqli_prepare($con, $productQuery);
        mysqli_stmt_bind_param($stmt, "i", $productId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $product = mysqli_fetch_assoc($result);
            $productPrice = $product['price'];
            $totalAmount += $quantity * $productPrice;
        }

        mysqli_stmt_close($stmt);
    }

    // Create an entry in the user_order table
    $orderRef = uniqid();
    $orderInsertQuery = "INSERT INTO `user_order` (`ref`, `date`, `total`, `user_id`) VALUES (?, NOW(), ?, ?)";
    $stmt = mysqli_prepare($con, $orderInsertQuery);
    mysqli_stmt_bind_param($stmt, "sdi", $orderRef, $totalAmount, $userId);
    
    if (mysqli_stmt_execute($stmt) === FALSE) {
        die('Error in executing order insert statement: ' . mysqli_stmt_error($stmt));
    }
    
    // Get the order_id of the newly inserted order
    $orderId = mysqli_insert_id($con);
    
    // Insert products from the cart into the order_has_product table
    foreach ($_SESSION['cart'] as $cartItem) {
        $productId = $cartItem['product_id'];
        $quantity = $cartItem['quantity'];
        $productPrice = $cartItem['price'];
    
        // Insert product details into the order_has_product table
        $orderDetailsInsertQuery = "INSERT INTO `order_has_product` (`order_id`, `product_id`, `quantity`, `price`) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $orderDetailsInsertQuery);
        mysqli_stmt_bind_param($stmt, "iiid", $orderId, $productId, $quantity, $productPrice);
    
        if (mysqli_stmt_execute($stmt) === FALSE) {
            die('Error in executing order details insert statement: ' . mysqli_stmt_error($stmt));
        }
    
        mysqli_stmt_close($stmt);
    }

    // Clear the cart after checkout
    $_SESSION['cart'] = [];

    echo "Order placed successfully!";
} else {
    echo "Your cart is empty.";
}

// Close the database connection
mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>
<body>
    <h2>Order Confirmation</h2>
</body>
</html>
