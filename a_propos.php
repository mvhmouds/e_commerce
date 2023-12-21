<?php
    session_start();
    include("db.php");
    include("header.php");
    include("navbar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <style>

    
body {
            background-color: #fff; 

        }
        .container {
            text-align: center;
            margin-bottom: 800px;
            margin-top: 100px;
            margin-left: 500px;
            margin-right: 500px;



            
        }
        
        
    </style>
</head>
<body>

<main>
    <div class="container">
        <h1>A propos de nous </h1>
        <p>
Bienvenue chez Cosmetics !

Chez nous, la beauté réside dans la simplicité. Cosmetics crée des produits cosmétiques purs et efficaces pour révéler votre éclat naturel. Nos formules de haute qualité célèbrent la diversité de la beauté, tout en privilégiant la durabilité.

Découvrez notre gamme et rejoignez-nous dans notre engagement envers une beauté authentique et responsable.

À votre éclat naturel,
L'équipe Cosmetics </p>
    </div>
</main>
<footer>
        <?php include("footer.php"); ?>
    </footer>
</body>
</html>
