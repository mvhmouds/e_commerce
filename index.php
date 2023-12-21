<?php
session_start();
include("db.php");
include("header.php");
include("navbar.php");
?>

<main>
    <style>
        /* Styles for the hero section */
        .hero {
            background-image: url('./images/cover.jpg');
            background-size: cover;
            background-position: center;
            color: #fff;
            text-align: center;
            padding: 300px 0;
        }

        /* Rest of the styles */
        body {
            background-color: #fff;
        }

        #content {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        .wrapper h3 {
            font-size: 60px;
            text-align: center;
            margin-bottom: 50px;
        }

        .product-list {
            list-style: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
        }

        /* Style for each product item */
        .product-item {
            width: calc(33.33% - 20px);
            box-sizing: border-box;
            overflow: hidden;
            position: relative;
            transition: transform 0.3s;
        }

        /* Square container for images */
        .square-container {
            position: relative;
            width: 100%;
            padding-top: 100%;
            overflow: hidden;
        }

        /* Style for the image */
        .square-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Additional styling for product cards */
        .card {
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s;
            background-color: #f8f8f8;
            border: 0.3px solid #A5A5A5;
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
        }

        .card-body {
            text-align: center;
        }

        .card-title {
            font-weight: bold;
        }

        .card-text {
            color: #555;
        }

        .card-footer {
            text-align: center;
        }

        .btn-add-to-cart {
            display: inline-block;
            padding: 12px 24px;
            border: 2px solid #457231;
            border-radius: 20px;
            background-color: #457231;
            color: #fff;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s, border-color 0.3s;
            font-size: 16px;
        }

        .btn-add-to-cart:hover {
            background-color: #fff;
            color: #457231;
            border-color: #457231;
        }

        .image-text-section {
            display: flex;
            align-items: left;
            justify-content: left;
            margin-top: 90px;
            margin-bottom: 200px;
            margin-left: 150px;
        }

        .image-text-section img {
            max-width: 300px;
            margin-right: 400px;
        }

        .text-content {
            max-width: 600px;
            font-family: 'Cursive', sans-serif;
            font-size: 24px;
            color: #555;
        }

        .text-content h1 {
            font-size: 36px;
            margin-bottom: 20px;
            font-family: 'FancyFont', sans-serif;
        }
    </style>

    <div class="hero">
        <!-- Your hero content goes here -->
    </div>

    <div id="content" class="container">
        <div class="wrapper">
            <h3>Nos promotions</h3>
        </div>

        <ul class="product-list">
            <?php
            // Fetch products from the database using procedural MySQLi
            $productQuery = "SELECT * FROM `product`";
            $result = mysqli_query($con, $productQuery);

            // Check if there are products
            if (mysqli_num_rows($result) > 0) {
                while ($product = mysqli_fetch_assoc($result)) {
                    ?>
                    <li class="product-item">
                        <div class="card">
                            <div class="square-container">
                                <img src="<?php echo $product['img_url']; ?>" alt="<?php echo $product['name']; ?>"
                                    class="card-img-top">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $product['name']; ?></h5>
                                <p class="card-text">Price: $<?php echo $product['price']; ?></p>
                                <p class="card-text">Description: <?php echo $product['description']; ?></p>
                            </div>
                            <div class="card-footer">
                                <form action="cart.php" method="post" style="display: inline;">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <input type="submit" value="Add to Cart"
                                        class="btn btn-primary btn-add-to-cart">
                                </form>
                                <a href="product_details.php?product_id=<?php echo $product['id']; ?>"
                                    class="btn btn-link" style="margin-left: 10px;">View Details</a>
                            </div>
                        </div>
                    </li>
                    <?php
                }
            } else {
                ?>
                <div class="col">
                    <p>No products available.</p>
                </div>
                <?php
            }
            ?>
        </ul>
    </div>
    <div class="image-text-section">
        <img src="./images/hero.jpg" alt="Your Image">
        <div class="text-content">
            <h1>Fancy Font Heading</h1>
            <p>
            Bienvenue chez Cosmetics ! Chez nous, la beauté réside dans la simplicité. Cosmetics crée des produits cosmétiques purs et efficaces pour révéler votre éclat naturel. Nos formules de haute qualité célèbrent la diversité de la beauté, tout en privilégiant la durabilité. Découvrez notre gamme et rejoignez-nous dans notre engagement envers une beauté authentique et responsable. À votre éclat naturel, L'équipe Cosmetics


            </p>
        </div>
    </div>
</main>

<footer>
    <?php include("footer.php"); ?>
</footer>
</body>
</html>
