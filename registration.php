<?php
include("db.php"); // Include the database connection file at the beginning
include("header.php");
include("navbar.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect user registration data
    $userName = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $firstName = $_POST['firstname'];
    $lastName = $_POST['lastname'];
    $streetName = $_POST['streetname'];
    $streetNumber = $_POST['streetnumber'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $zipCode = $_POST['zipcode'];
    $country = $_POST['country'];

    // Check if the username already exists
    $checkUsernameQuery = "SELECT * FROM `user` WHERE `user_name` = ?";
    $stmtCheckUsername = mysqli_prepare($con, $checkUsernameQuery);
    mysqli_stmt_bind_param($stmtCheckUsername, "s", $userName);
    mysqli_stmt_execute($stmtCheckUsername);
    $result = mysqli_stmt_get_result($stmtCheckUsername);

    if (mysqli_num_rows($result) > 0) {
        echo "Username already exists. Please choose a different username.";
    } else {
        // Insert address into the address table using prepared statements
        $insertAddressQuery = "INSERT INTO `address` (`street_name`, `street_nb`, `city`, `province`, `zip_code`, `country`) VALUES (?, ?, ?, ?, ?, ?)";
        $stmtInsertAddress = mysqli_prepare($con, $insertAddressQuery);
        mysqli_stmt_bind_param($stmtInsertAddress, "ssssss", $streetName, $streetNumber, $city, $province, $zipCode, $country);
        
        if (mysqli_stmt_execute($stmtInsertAddress)) {
            // Retrieve the generated address ID
            $addressId = mysqli_insert_id($con);

            // Insert user information into the user table using prepared statements
            $insertUserQuery = "INSERT INTO `user` (`user_name`, `email`, `pwd`, `fname`, `lname`, `billing_address_id`, `shipping_address_id`, `role_id`) VALUES (?, ?, ?, ?, ?, ?, ?, 3)";
            $stmtInsertUser = mysqli_prepare($con, $insertUserQuery);
            mysqli_stmt_bind_param($stmtInsertUser, "sssssss", $userName, $email, $password, $firstName, $lastName, $addressId, $addressId);
            
            if (mysqli_stmt_execute($stmtInsertUser)) {
                // Redirect to the login page or any other page after successful registration
                header("Location: login.php");
                exit();
            } else {
                echo "Error inserting user: " . mysqli_stmt_error($stmtInsertUser);
            }
            mysqli_stmt_close($stmtInsertUser);
        } else {
            echo "Error inserting address: " . mysqli_stmt_error($stmtInsertAddress);
        }
        mysqli_stmt_close($stmtInsertAddress);
    }
    mysqli_stmt_close($stmtCheckUsername);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            text-align: center;
            margin-bottom: 200px;
            margin-top: 90px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Inscription</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <!-- User Information -->
        <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="firstname" class="form-label">First Name:</label>
            <input type="text" name="firstname" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="lastname" class="form-label">Last Name:</label>
            <input type="text" name="lastname" class="form-control" required>
        </div>

        <!-- Address Information -->
        <div class="mb-3">
            <label for="streetname" class="form-label">Street Name:</label>
            <input type="text" name="streetname" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="streetnumber" class="form-label">Street Number:</label>
            <input type="number" name="streetnumber" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="city" class="form-label">City:</label>
            <input type="text" name="city" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="province" class="form-label">Province:</label>
            <input type="text" name="province" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="zipcode" class="form-label">ZIP Code:</label>
            <input type="text" name="zipcode" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="country" class="form-label">Country:</label>
            <input type="text" name="country" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<footer>
    <?php include("footer.php"); ?>
</footer>
</body>
</html>
