<?php
// Include the database configuration
include("dbconf/dbconf.php");

// Determine the category to use
if (isset($_GET['value']) && !empty($_GET['value'])) {
    $category = mysqli_real_escape_string($connect, $_GET['value']); // Use the provided category
    $sql = "SELECT * FROM products WHERE category = '$category'"; // Fetch products for selected category
} else {
    $category = 'All Categories'; // Default message when no category is selected
    $sql = "SELECT * FROM products"; // Fetch all products when no category is selected
}

// Fetch products from the database
$result = mysqli_query($connect, $sql);

// Display a dropdown menu for category selection
echo '<form method="GET" action="page.php">
    <label for="category">Select Category:</label>
    <select name="value" id="category">
        <option value="">All Categories</option>
        <option value="Fruits">Fruits</option>
        <option value="Vegetables">Vegetables</option>
        <option value="Dairy">Dairy</option>
    </select>
    <button type="submit">View Products</button>
</form>';

// Display products or appropriate messages
if (mysqli_num_rows($result) > 0) {
    echo "<h2>Products in the '$category' category</h2>";
    echo '<div class="row g-4">'; // Start the row for displaying the products

    while ($row = mysqli_fetch_assoc($result)) {
        $product_image = "assets/" . $row['id'] . ".jpg"; // Dynamically link the image by ID
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
    echo '</div>'; // Close the row
} else {
    echo "<p>No products found in the '$category' category.</p>";
}
?>
