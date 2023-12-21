<?php
include("db.php"); 
include("header.php");


session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); /
    exit();
}

$userId = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Effectuer la suppression et mettre à jour la base de données
    $deleteAddressQuery = "DELETE FROM `address` WHERE `id` IN (SELECT `billing_address_id` FROM `user` WHERE `id` = ? OR `shipping_address_id` = ?)";
    $deleteUserQuery = "DELETE FROM `user` WHERE `id` = ?";

    $stmt = mysqli_prepare($con, $deleteAddressQuery);
    mysqli_stmt_bind_param($stmt, "ii", $userId, $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $stmt = mysqli_prepare($con, $deleteUserQuery);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Rediriger vers une page de confirmation ou toute autre page après la suppression
    header("Location: account_deleted.php");
    exit();
}
?>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Supprimer Mon Compte</h2>
        <p>  Êtes-vous sûr de vouloir supprimer votre compte ?  </p>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <button type="submit" class="btn btn-danger">Supprimer le Compte</button>
        </form>
    </div>
</body>
</html>
