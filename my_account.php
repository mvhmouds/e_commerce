<?php
include("db.php");
include("config.php");

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Retrieve user information using procedural MySQLi statements
$userId = $_SESSION['user_id'];
$getUserQuery = "SELECT * FROM `user` WHERE `id` = ?";
$stmt = mysqli_prepare($con, $getUserQuery);
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    // Redirect to login page if user not found
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon compte</title>
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

        nav {
            background-color: #555;
            overflow: hidden;
        }

        nav a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .content {
            margin: 20px;
        }

        .user-info {
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<header>
    <h1>Welcome, <?php echo $user['user_name']; ?>!</h1>
</header>

<nav>
    <a href="index.php">Accueil</a>
    <a href="my_account.php">Mon Compte</a>
    <a href="edit_account.php">Modifier le Compte</a>
    <a href="delete_account.php">Supprimer le Compte</a>
    <a href="products.php">Continuer les Achats</a>
    <a href="logout.php">Déconnexion</a>
    <a href="cart.php">Mon panier</a>

    <?php
    // Check if the user is a superadmin
    if ($_SESSION['user_role'] == 1) {
        echo '<a href="inserting_pro.php">Superadmin</a>';
    }
    ?>
</nav>

<div class="content">
    <div class="user-info">
        <h2>Informations</h2>
        <p>Email: <?php echo $user['email']; ?></p>
        <p>First Name: <?php echo $user['fname']; ?></p>
        <p>Last Name: <?php echo $user['lname']; ?></p>
        
    </div>
</div>

</body>
</html>
