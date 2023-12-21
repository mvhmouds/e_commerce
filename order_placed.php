<?php
// Include your database connection file here
include("db.php");
include("header.php");
include("navbar.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Placed - Thank You</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .thank-you-message {
            text-align: center;
            margin-top: 160px;
            margin-bottom: 400px;

        }

        .btn-back-to-products {
            display: inline-block;
            padding: 12px 24px;
            border: 2px solid #457231;
            border-radius: 20px;
            background-color: #457231;
            color: #fff;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s, border-color 0.3s;
            font-size: 18px;
        }

        .btn-back-to-products:hover {
            background-color: #fff;
            color: #457231;
            border-color: #457231;
        }
    </style>
</head>

<body>
    <div class="container">
        <div id="content" class="thank-you-message">
            <h2>Thank You for Your Order!</h2>
            <p>Your order has been successfully placed.</p>
            <p>We appreciate your business!</p>

            <a href="cart.php" class="btn btn-secondary btn-back-to-products">Back to Cart</a>
        </div>
    </div>

    <footer>
        <?php include("footer.php"); ?>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
