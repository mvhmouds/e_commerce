<?php
include("db.php");
include("header.php");
include("config.php");
include("navbar.php");

$userQuery = "SELECT * FROM `user`";
$stmt = mysqli_prepare($con, $userQuery);
mysqli_stmt_execute($stmt);
$userResult = mysqli_stmt_get_result($stmt);
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        .container-content {
            padding: 16px;
        }

        table {
            margin-top: 20px;
        }

        th, td {
            text-align: center;
        }

        th {
            background-color: #343a40;
            color: #f8f9fa;
        }

        .change-role-btn {
            padding: 5px 10px;
            background-color: #6D6D6D;
            color: #ffffff;
            border: none;
            cursor: pointer;
        }

        .change-role-btn:hover {
            background-color: #0056b3;
        }

        /* Center the menu items */
        .navbar-nav {
            width: 100%;
            justify-content: center;
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto justify-content-center">
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



    <div class="container-content">
        <h3>Users</h3>
        <table class="table table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($user = mysqli_fetch_assoc($userResult)) {
                ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['user_name']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td>
                        <?php
                        switch ($user['role_id']) {
                            case 1:
                                echo 'Superadmin';
                                break;
                            case 2:
                                echo 'Admin';
                                break;
                            case 3:
                                echo 'User';
                                break;
                            default:
                                echo 'Unknown Role';
                        }
                        ?>
                    </td>
                    <td>
                        <!-- Inside the form in superadmin.php -->
                        <form action="change_role.php" method="post">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">

                            <?php if ($user['role_id'] == 1) : ?>
                                <strong>Superadmin</strong>
                            <?php elseif ($user['role_id'] == 2) : ?>
                                <strong>Admin</strong>
                            <?php elseif ($user['role_id'] == 3) : ?>
                                <h4 value="2">Admin</h4>
                                <button type="submit" class="btn btn-primary change-role-btn"> Role </button>
                            <?php else : ?>
                                <strong>Unknown Role</strong>
                            <?php endif; ?>
                        </form>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
