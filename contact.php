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
    <title>Contact Us</title>
    <style>
      
        .container {
            text-align: center;
            margin-bottom: 800px;
            margin-top: 100px;
            margin-left: 500px;
            margin-right: 500px;



        }
    </style>
<main>
    <div class="container">
        <h1>Contactez nous</h1>
        <p>Contactez-nous

Nous sommes ravis de vous entendre ! Si vous avez des questions, des commentaires ou simplement envie de discuter, n'hésitez pas à nous contacter.



Email :
cosmetics@cosmetics.ca
Téléphone :
+1 488 963 2222


Notre équipe est là pour vous aider. Merci de choisir Cosmetics !

À bientôt,
L'équipe Cosmetics</p>
        <p>Email: cosmetics@cosmetics.ca</p>
        <p>Phone: +1 488 963 2222 </p>
        <!-- Add a contact form or more information as needed -->
    </div>
</main>
<footer>
        <?php include("footer.php"); ?>
    </footer>
</body>

</html>
