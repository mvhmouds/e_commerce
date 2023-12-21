<?php
include("db.php");
include("header.php");
include("navbar.php");

session_start();

define('Sadminaccesskey', true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect login data
    $userName = $_POST['username'];
    $password = $_POST['password'];

    // Check if either username or email is provided
    if (!empty($userName)) {
        // Retrieve user information from the database based on username using procedural MySQLi
        $getUserQuery = "SELECT * FROM `user` WHERE `user_name` = ?";
        $stmt = mysqli_prepare($con, $getUserQuery);
        mysqli_stmt_bind_param($stmt, "s", $userName);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            // Verify the password
            if (password_verify($password, $user['pwd'])) {
                // Password is correct, store user information in the session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['user_name'];
                $_SESSION['user_role'] = $user['role_id'];

                // Redirect based on user role
                if ($_SESSION['user_role'] == 1) {
                    //redirect to insert prod
                    header("Location: inserting_pro.php");
                    exit();
                } elseif ($_SESSION['user_role'] == 2) {
                    // Admin
                    header("Location: admin.php");
                    exit();
                } elseif ($_SESSION['user_role'] == 3) {
                    // Regular user
                    header("Location: index.php");
                    exit();
                } else {
                    $loginError = "Unidentified Role";
                }
            } else {
                $loginError = "Incorrect password";
            }
        } else {
            $loginError = "User not found";
        }
    } else {
        $loginError = "Please enter a username";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <style>
        .container {
            text-align: center;
            margin-top: 50px;
            margin-bottom: 300px;
        }

        /* Additional Bootstrap styles for form alignment */
        .form-group {
            text-align: left;
        }

        .btn-primary {
            margin-top: 15px;
        }
    </style>

</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4"> Login</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" class="form-control">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>

        <?php if (isset($loginError)) : ?>
            <div class="alert alert-danger mt-3" role="alert">
                <?php echo $loginError; ?>
            </div>
        <?php endif; ?>
    </div>

    <footer>
        <?php include("footer.php"); ?>
    </footer>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
