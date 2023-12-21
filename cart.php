<?php
include("db.php");
include("header.php");
include("navbar.php");

session_start();

$totalAmount = 0;

// Check if the cart is not initialized
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if a product is added to the cart
if (isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];

    // Check if the product is not already in the cart
    if (!isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = [
            'quantity' => 1, // Initial quantity is 1
            'product_id' => $productId
        ];
    }
}

if (isset($_POST['update_quantity'])) {
    // Check if product_id and quantity are set
    if (isset($_POST['product_id'], $_POST['quantity'])) {
        $productId = $_POST['product_id'];
        $quantity = $_POST['quantity'];

        // Check if the product is in the cart
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] = $quantity;
        } else {
            echo "Product not found in the cart.";
        }
    } else {
        echo "Product ID or quantity not provided.";
    }
}

// Check if a product is removed from the cart
if (isset($_POST['remove_product'])) {
    // Check if product_id is set
    if (isset($_POST['product_id'])) {
        $productId = $_POST['product_id'];

        // Check if the product is in the cart
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        } else {
            echo "Product not found in the cart.";
        }
    } else {
        echo "Product ID not provided.";
    }
}

// Check if the checkout button is clicked
if (isset($_POST['checkout'])) {
    // Redirect to the payment.php page for order confirmation
    header("Location: payment.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Your Cart</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Add your custom styles if needed -->
    <style>
        .container {
            text-align: center;
            margin-bottom: 100px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h3 class="text-center">Panier</h3>

    <?php if (!empty($_SESSION['cart'])): ?>
        <table class="table table-bordered mt-3">
            <thead class="thead-dark">
                <tr>
                    <th>Product Image</th>
                    <th>Product Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($_SESSION['cart'] as $productId => $cartItem):
                    $productQuery = "SELECT * FROM `product` WHERE `id` = ?";
                    $stmt = mysqli_prepare($con, $productQuery);
                    mysqli_stmt_bind_param($stmt, "i", $productId);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    if ($result && mysqli_num_rows($result) > 0) {
                        $product = mysqli_fetch_assoc($result);
                        mysqli_stmt_close($stmt);

                        $productPrice = $product['price'];
                        $quantity = $cartItem['quantity'];
                        $totalPrice = $quantity * $productPrice;

                        $totalAmount += $totalPrice;
                ?>
                    <tr>
                        <td><img src="<?php echo $product['img_url']; ?>" alt="<?php echo $product['name']; ?>" width="50"></td>
                        <td><?php echo $productPrice; ?></td>
                        <td>
                            <form action="cart.php" method="post">
                                <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                                <div class="input-group">
                                    <input type="number" name="quantity" value="<?php echo $quantity; ?>" min="1" class="form-control">
                                    <div class="input-group-append">
                                        <input type="submit" name="update_quantity" value="Update" class="btn btn-outline-secondary">
                                    </div>
                                </div>
                            </form>
                        </td>
                        <td><?php echo $totalPrice; ?></td>
                        <td>
                            <form action="cart.php" method="post">
                                <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                                <input type="submit" name="remove_product" value="Remove" class="btn btn-danger">
                            </form>
                        </td>
                    </tr>
                <?php
                    } else {
                        echo "Error fetching product details.";
                    }
                endforeach;
                ?>
            </tbody>
        </table>

        <p class="lead">Total Amount: $<?php echo $totalAmount; ?></p>
        
        <!-- Add a checkout button -->
        <form action="payment.php" method="post">
            <input type="submit" name="checkout" value="Checkout" class="btn btn-primary">
        </form>
    </div>

    <?php else: ?>
        <div class="container mt-5">
            <p class="lead">Votre panier est vide.</p>
        </div>
    <?php endif; ?>

    <div class="container mt-3">
        <a href="products.php" class="btn btn-info">Continuer vos achats </a>
    </div>

    <footer>
        <?php include("footer.php"); ?>
    </footer>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
