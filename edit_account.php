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

$userID = $_SESSION['user_id'];
$query = "SELECT * FROM user u
          JOIN address a ON u.billing_address_id = a.id
          WHERE u.id = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $userID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $userData = mysqli_fetch_assoc($result);
} else {
    echo "User not found";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newFirstName = $_POST['firstname'];
    $newLastName = $_POST['lastname'];
    $newStreetName = $_POST['streetname'];
    $newStreetNumber = $_POST['streetnumber'];
    $newCity = $_POST['city'];
    $newProvince = $_POST['province'];
    $newZipCode = $_POST['zipcode'];
    $newCountry = $_POST['country'];

    $updateUserQuery = "UPDATE user
                        SET fname = ?, lname = ?
                        WHERE id = ?";
    $stmt = mysqli_prepare($con, $updateUserQuery);
    mysqli_stmt_bind_param($stmt, "ssi", $newFirstName, $newLastName, $userID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $updateAddressQuery = "UPDATE address
                           SET street_name = ?, street_nb = ?,
                               city = ?, province = ?,
                               zip_code = ?, country = ?
                           WHERE id = ?";
    $stmt = mysqli_prepare($con, $updateAddressQuery);
    mysqli_stmt_bind_param($stmt, "ssisssi", $newStreetName, $newStreetNumber, $newCity, $newProvince, $newZipCode, $newCountry, $userData['billing_address_id']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: my_account.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 500px;
            margin-top: 50px;
            margin-bottom: 90px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Account</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="form-group">
            <label for="firstname">First Name:</label>
            <input type="text" name="firstname" value="<?php echo $userData['fname']; ?>" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="lastname">Last Name:</label>
            <input type="text" name="lastname" value="<?php echo $userData['lname']; ?>" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="streetname">Street Name:</label>
            <input type="text" name="streetname" value="<?php echo $userData['street_name']; ?>" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="streetnumber">Street Number:</label>
            <input type="number" name="streetnumber" value="<?php echo $userData['street_nb']; ?>" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" name="city" value="<?php echo $userData['city']; ?>" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="province">Province:</label>
            <input type="text" name="province" value="<?php echo $userData['province']; ?>" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="zipcode">ZIP Code:</label>
            <input type="text" name="zipcode" value="<?php echo $userData['zip_code']; ?>" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="country">Country:</label>
            <input type="text" name="country" value="<?php echo $userData['country']; ?>" class="form-control" required>
        </div>

        <input type="submit" value="Update" class="btn btn-primary">
    </form>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<footer>
        <?php include("footer.php"); ?>
    </footer>
</body>
</html>
