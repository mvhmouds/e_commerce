<?php
// Include your database connection file here
include("db.php");
include("header.php");
include("navbar.php");
include("config.php");

// Check if product ID is provided in the URL
if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];

    // Fetch product details from the database using procedural statements
    $productQuery = "SELECT * FROM `product` WHERE `id` = ?";
    
    $stmtProduct = mysqli_prepare($con, $productQuery);
    mysqli_stmt_bind_param($stmtProduct, "i", $productId);
    mysqli_stmt_execute($stmtProduct);
    
    $result = mysqli_stmt_get_result($stmtProduct);

    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    } else {
        header("Location: products.php");
        exit();
    }

    mysqli_stmt_close($stmtProduct);
} else {
    // Handle missing product ID
    header("Location: products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['name']; ?> - Product</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        #content {
            max-width: 800px;
            margin: 0 auto;
            padding: 150px;
            margin-bottom: 90px;

        }

        .product-info {
            text-align: center;
            margin-top: 10px;
        }

        .product-info img {
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .product-info h2 {
            font-size: 36px;
            color: #343a40;
            margin-bottom: 20px;
        }

        .product-info p {
            font-size: 20px;
            color: #555;
            margin-bottom: 20px;
        }

        .btn-add-to-cart {
            padding: 12px 24px;
            margin-left: 8px;
            border: 2px solid #457231;
            border-radius: 20px;
            background-color: #457231;
            color: #fff;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s, border-color 0.3s;
            font-size: 18px;
        }

        .btn-add-to-cart:hover {
            background-color: #fff;
            color: #457231;
            border-color: #457231;
        }
    </style>
</head>

<body>
    <div class="container" id="content">
        <a href="products.php" class="btn btn-secondary mb-3">Revenir</a>
        <div class="product-info">
            <img src="<?php echo $product['img_url']; ?>" alt="<?php echo $product['name']; ?>" class="img-fluid">
            <h2><?php echo $product['name']; ?></h2>
            <p class="lead">Price: $<?php echo $product['price']; ?></p>
            <p><?php echo $product['description']; ?></p>

            <form action="cart.php" method="post">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <button type="submit" class="btn btn-primary btn-add-to-cart">Ajouter au panier</button>
            </form>
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
