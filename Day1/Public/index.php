<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farm Connect: Buy and Sell Raw Products Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .hero {
            background: url('image/background4.jpg') center/cover no-repeat;
            height: 400px;
            color: white;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .hero h1 {
            font-weight: bold;
        }

        .marketplace h1 {
            margin-bottom: 20px;
        }

        .thumbnail img:hover {
            transform: scale(1.05);
            filter: brightness(85%);
            transition: transform 0.3s ease-in, filter 0.3s ease-in;
            box-shadow: 0 0 16px rgba(0, 255, 255, 0.5);
        }

        footer {
            background-color: #f8f9fa;
            color: #333;
            padding: 1em 0;
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php"><strong>FarmDirect</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="">Buy Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Farmers_Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item">
                        <a class="nav-link text-warning" href="#"><strong>Cart</strong> <i class="fas fa-cart-plus"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero">
        <h1>Taking Agriculture to Another Level</h1>
        <p>A platform to expand opportunities for farmers and simplify purchases for buyers online.</p>
        <form class="d-flex justify-content-center" action="searchresult.php" method="post">
            <input class="form-control w-50 me-2" type="text" name="searchvalue" placeholder="What do you need?" maxlength="20">
            <button class="btn btn-primary" type="submit" name="search">Search</button>
        </form>
    </header>

    <!-- Marketplace -->
    <div class="container my-5">
        <div class="marketplace text-center">
            <?php
            include("dbconf/dbconf.php");

            // Check if a category is selected
            if (isset($_GET['category'])) {
                $category = $_GET['category'];
                $name = isset($_GET['name']) ? $_GET['name'] : '';  // Safely initialize $name

                // Query to fetch products from the selected category
                $sql = "SELECT * FROM products WHERE category = '$category'";
                $result = mysqli_query($connect, $sql);

                // Display category name dynamically
                echo "<h1>$category</h1>";

                // Check if any products are found
                if (mysqli_num_rows($result) > 0) {
                    echo "<div class='row g-4'>";

                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <div class="col-md-4">
                            <div class="card">
                                <img class="card-img-top" src="assets/<?php echo $row['name']; ?>.jpg" alt="<?php echo htmlspecialchars($row['name']); ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['name']; ?></h5>
                                    <p class="card-text">Price: $<?php echo number_format($row['price'], 2); ?></p>
                                    <a href="product_detail.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    echo "</div>";
                } else {
                    echo "<p>No products found in this category.</p>";
                }
            } else {
                // If no category is selected, show the category images
                $categories = [
                    'Fruits' => 'fruits.jpg',
                    'Vegetables' => 'vegetables.jpg',
                    'Grains' => 'grains.jpg',
                    'Poultry' => 'poultry.jpg',
                    'Fish' => 'fish.jpg' ,
                     'Spices' => 'e.jpg',
                     'Dairy' => 'dairy.jpg',
                    'Herbs' => 'herbs.jpg',
                   
                ];

                echo "<h1>Explore Our Marketplace</h1>";
                echo "<div class='row g-4'>";
                foreach ($categories as $category_name => $image_name) {
                    $image_path = "assets/" . $image_name; // Path to the image in the 'assets' folder
                    ?>
                    <div class="col-md-4">
                        <div class="card">
                            <a href="index.php?category=<?php echo urlencode($category_name); ?>"> <!-- Link to filter products by category -->
                                <img class="card-img-top" src="<?php echo $image_path; ?>" alt="<?php echo htmlspecialchars($category_name); ?>">
                            </a>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $category_name; ?></h5>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                echo "</div>";
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <hr>
        <p>Contact Us: (+94)762552365 &copy; FarmDirect. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
