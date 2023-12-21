<?php
include("db.php");
include("header.php");
include("navbar.php");

session_start();

// Check if the user is logged in and is a superadmin
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect product data
    $productName = $_POST['product_name'];
    $productQuantity = $_POST['product_quantity'];
    $productPrice = $_POST['product_price'];
    $productDescription = $_POST['product_description'];
    $productImagePath = $_POST['product_image_path'];

    // Validate the data 
    if (empty($productName) || empty($productQuantity) || empty($productPrice)) {
        $errorMessage = "Please fill in all required fields.";
    } else {
        // Process the image upload
        if (isset($_FILES['product_image'])) {
            $uploadDir = './images/';
            $imageName = basename($_FILES['product_image']['name']);
            $uploadFile = $uploadDir . $imageName;

            if (move_uploaded_file($_FILES['product_image']['tmp_name'], $uploadFile)) {
                $productImageUrl = './images/' . $imageName;
            } else {
                $errorMessage = "Error uploading image.";
            }
        }

        $insertProductQuery = "INSERT INTO `product` (`name`, `quantity`, `price`, `img_url`, `description`, `img_path`) 
                               VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($con, $insertProductQuery);

        mysqli_stmt_bind_param($stmt, "sdssss", $productName, $productQuantity, $productPrice, $productImageUrl, $productDescription, $productImagePath);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Product inserted successfully
            $successMessage = "Product added successfully.";
        } else {
            $errorMessage = "Error adding the product: " . mysqli_error($con);
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <!-- Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto"> 
            <li class="nav-item">
                <a class="nav-link" href="inserting_pro.php">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin_order.php">Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="user_table_admin.php">Users</a>
            </li>
        </ul>
    </div>
</nav>
    <div class="container mt-5">
        <h2>Add Product</h2>

        <?php if (isset($errorMessage)) : ?>
            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
        <?php endif; ?>

        <?php if (isset($successMessage)) : ?>
            <div class="alert alert-success"><?php echo $successMessage; ?></div>
        <?php endif; ?>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="product_name">Product Name:</label>
                <input type="text" name="product_name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="product_quantity">Quantity:</label>
                <input type="number" name="product_quantity" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="product_price">Price:</label>
                <input type="text" name="product_price" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="product_image_url">Image URL:</label>
                <input type="file" name="product_image" class="form-control-file" required>
            </div>

            <div class="form-group">
                <label for="product_description">Description:</label>
                <textarea name="product_description" class="form-control" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="product_image_path">Image Path:</label>
                <input type="text" name="product_image_path" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
