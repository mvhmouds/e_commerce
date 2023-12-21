<?php
include("db.php");
include("header.php");
include("navbar.php");

// Fetch products from the database using procedural statements
$productQuery = "SELECT * FROM `product`";
$stmtProduct = mysqli_prepare($con, $productQuery);
mysqli_stmt_execute($stmtProduct);
$result = mysqli_stmt_get_result($stmtProduct);

// Check if there are products
if (mysqli_num_rows($result) > 0) {
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $products = []; // Empty array if no products found
}
mysqli_stmt_close($stmtProduct);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List - Your Website</title>
    
    <style>
        /* Style for the container */
        body {
            margin: 0; /* Remove default margin */
            background-color: #fff; /* Set the background color to white */
        }

        .container {
            max-width: 800px; 
            margin: 0 auto; 
            padding: 40px; /* Add padding for empty space on the sides */
        }

        .product-list {
            list-style: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
        }

        /* Style for each product item */
        .product-item {
            width: calc(33.33% - 20px);
            box-sizing: border-box;
            overflow: hidden;
            position: relative;
            transition: transform 0.3s;
        }

        /* Square container for images */
        .square-container {
            position: relative;
            width: 100%;
            padding-top: 100%; /* Maintain 1:1 aspect ratio */
            overflow: hidden;
            margin-bottom: 70px;
        }

        /* Style for the image */
        .square-container img {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            object-fit: contain; /* Maintain aspect ratio and fit within the container */
        }

        /* Additional styling for product cards */
        .card {
            margin-bottom: 40px;
            margin-top: 40px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s;
            background-color: #f8f8f8; /* Set your desired background color */
            border: 0.3px solid #457231; /* Add a black border */
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
        }

        .card-body {
            text-align: center;
        }

        .card-title {
            font-weight: bold; 
        }

        .card-text {
            color: #555;
        }

        .card-footer {
            text-align: center;
        }

        .btn-add-to-cart {
            display: inline-block;
            margin-bottom: 40px;
            padding: 12px 24px; /* Adjust the padding  */
            border: 2px solid #457231; /* Set your desired border color */
            border-radius: 20px;
            background-color: #457231; /* Set your desired background color */
            color: #fff; /* Set the text color to white */
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s, border-color 0.3s;
            font-size: 16px; /* Adjust the font size for a larger button */
        }

        .btn-add-to-cart:hover {
            background-color: #fff; /* Change background color on hover */
            color: #457231; /* Change text color on hover */
            border-color: #457231; /* Change border color on hover */
        }

    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Liste de produits</h1>
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <ul class="product-list">
                <?php
                // Check if there are products to display
                if (!empty($products)) {
                    foreach ($products as $product) {
                        ?>
                        <li class="product-item">
                            <div class="card">
                                <div class="square-container">
                                    <img src="<?php echo $product['img_url']; ?>" alt="<?php echo $product['name']; ?>"
                                        class="card-img-top">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $product['name']; ?></h5>
                                    <p class="card-text">Price: $<?php echo $product['price']; ?></p>
                                    <p class="card-text">Description: <?php echo $product['description']; ?></p>
                                </div>
                                <div class="card-footer">
                                    <form action="cart.php" method="post" style="display: inline;">
                                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                        <input type="submit" value="Add to Cart" class="btn btn-primary btn-add-to-cart">
                                    </form>
                                    <a href="product_details.php?product_id=<?php echo $product['id']; ?>"
                                        class="btn btn-link" style="margin-left: 10px;">View Details</a>
                                </div>
                            </div>
                        </li>
                        <?php
                    }
                } else {
                    ?>
                    <div class="col">
                        <p>No products available.</p>
                    </div>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
    <footer>
        <?php include("footer.php"); ?>
    </footer>
</body>

</html>
