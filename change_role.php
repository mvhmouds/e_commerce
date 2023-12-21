<?php
include("db.php");
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the logged-in user is a superadmin
    session_start();
    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 1) {
        // Superadmin can change user role
        $user_id = $_POST['user_id'];
        $new_role = $_POST['new_role'] ?? null;

        if ($new_role == 3) {
            // Update the user role in the database to Admin
            updateUserRole($user_id, 2);
            $_SESSION['success_message'] = 'Role changed to Admin.';
        } elseif ($new_role == 2) {
            // Update the user role in the database to User
            updateUserRole($user_id, 3);
            $_SESSION['success_message'] = 'Role changed to User.';
        }
    }
}



function updateUserRole($user_id, $new_role_id) {
    global $con;
    $updateRoleQuery = "UPDATE `user` SET `role_id` = ? WHERE `id` = ?";
    
    $stmt = mysqli_prepare($con, $updateRoleQuery);
    mysqli_stmt_bind_param($stmt, "ii", $new_role_id, $user_id);
    
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return true;
    } else {
        mysqli_stmt_close($stmt);
        return false;
    }
}
?>
