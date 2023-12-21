<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .navbar {
            background-color: #333; /* Set  desired background color */
            padding: 10px 0; /* Add padding   */
            text-align: center; /* Center  links horizontally */
        }

        .navbar ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex; /*  flexbox   layut */
            justify-content: space-between; /* Space items     */
            align-items: center; /* Center items     */
        }

        /* Style for  navbar(list item) */
        .navbar li {
            margin: 0 15px;
        }

        .navbar a {
            text-decoration: none;
            color: #fff;
            font-size: 18px; 
        }

        .navbar a:hover {
            color: #ffcc00; 
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="products.php">Produits</a></li>
            <li><a href="a_propos.php"> À-propos</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="registration.php">Inscription</a></li>
            <li><a href="my_account.php">Mon compte</a></li>
            <li style="margin-left: auto;"><a href="cart.php">Mon panier</a></li>
        </ul>
    </nav>
</body>
</html>
