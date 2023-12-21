<?php
include("db.php");
include("header.php");
include("navbar.php");  

$orderQuery = "SELECT * FROM `user_order`";
$orderResult = mysqli_query($con, $orderQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        .container-content {
            padding: 200px;
        }

        table {
            margin-top: 2px;
        }

        th, td {
            text-align: center;
        }

        th {
            background-color: #343a40;
            color: #f8f9fa;
        }

        .confirm-btn {
            padding: 5px 10px;
            background-color: #28a745;
            color: #ffffff;
            border: none;
            cursor: pointer;
        }

        .confirm-btn:hover {
            background-color: #218838;
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


    <div class="container-content">
        <h3>Orders</h3>
        <table class="table table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>Order ID</th>
                <th>Reference</th>
                <th>Date</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($order = mysqli_fetch_assoc($orderResult)) {
                ?>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo $order['ref']; ?></td>
                    <td><?php echo $order['date']; ?></td>
                    <td><?php echo $order['total']; ?></td>
                    <td>
                        <form action="confirm_order.php?order_id=<?php echo $order['id']; ?>" method="post">
                            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                            <button type="submit" class="btn btn-success confirm-btn">Confirm Order</button>
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
