<?php
include("dbconf.php");

if (isset($_GET['value'])) {
    $category = $_GET['value'];

    // Fetch products by category
    $sql = "SELECT * FROM products WHERE category = '$category'";
    $result = mysqli_query($connect, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<h2>Products in the $category category</h2>";

        echo '<div class="row g-4">';  // Start the row for displaying the products

        while ($row = mysqli_fetch_assoc($result)) {
            // Assuming you have a directory with product images named by product ID or category
            $product_image = "assets/" . $row['id'] . ".jpg"; // Example: dynamically link the image by ID
            ?>
            <div class="col-md-4">
                <div class="card">
                    <a href="productdetails.php?id=<?php echo $row['id']; ?>"> <!-- Link to a product details page -->
                        <img class="card-img-top" src="<?php echo $product_image; ?>" alt="<?php echo $row['name']; ?>">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['name']; ?></h5>
                        <p class="card-text">Price: <?php echo $row['price']; ?> LKR</p>
                    </div>
                </div>
            </div>
            <?php
        }

        echo '</div>';  // Close the row
    } else {
        echo "<p>No products found in this category.</p>";
    }
} else {
    echo "<p>Category not specified.</p>";
}
?>
