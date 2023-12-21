<?php
include("db.php");
include("header.php");
include("navbar.php");

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if the cart is not empty
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Retrieve user information using procedural MySQLi statements
$getUserQuery = "SELECT * FROM `user` WHERE `id` = ?";
$stmtUser = mysqli_prepare($con, $getUserQuery);
mysqli_stmt_bind_param($stmtUser, "i", $userId);
mysqli_stmt_execute($stmtUser);
$resultUser = mysqli_stmt_get_result($stmtUser);
mysqli_stmt_close($stmtUser);

if (mysqli_num_rows($resultUser) > 0) {
    $user = mysqli_fetch_assoc($resultUser);
} else {
    // Redirect to login page if user not found
    header("Location: login.php");
    exit();
}

// Calculate the total amount
$totalAmount = 0;
foreach ($_SESSION['cart'] as $cartItem) {
    $productId = $cartItem['product_id'];
    $quantity = $cartItem['quantity'];

    // Retrieve product information using procedural MySQLi statements
    $getProductQuery = "SELECT * FROM `product` WHERE `id` = ?";
    $stmtProduct = mysqli_prepare($con, $getProductQuery);
    mysqli_stmt_bind_param($stmtProduct, "i", $productId);
    mysqli_stmt_execute($stmtProduct);
    $resultProduct = mysqli_stmt_get_result($stmtProduct);
    mysqli_stmt_close($stmtProduct);

    if (mysqli_num_rows($resultProduct) > 0) {
        $product = mysqli_fetch_assoc($resultProduct);
        $productPrice = $product['price'];
        $totalAmount += $quantity * $productPrice;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Information</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
        }

        .content {
            margin: 20px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>

<header>
    <h1>Payment Information</h1>
</header>

<div class="content">
    <form action="process_payment.php" method="post">
        <label for="card_number">Card Number:</label>
        <input type="text" id="card_number" name="card_number" required>

        <label for="expiration_date">Expiration Date (MM/YY):</label>
        <input type="text" id="expiration_date" name="expiration_date" pattern="\d{2}/\d{2}" placeholder="MM/YY" required>

        <label for="cvv">CVV:</label>
        <input type="text" id="cvv" name="cvv" pattern="\d{3}" placeholder="123" required>

        <label for="billing_address">Billing Address:</label>
        <input type="text" id="billing_address" name="billing_address" required>

        <input type="hidden" name="total_amount" value="<?php echo $totalAmount; ?>">
        <input type="submit" value="Submit Payment">
    </form>
</div>

</body>
</html>
