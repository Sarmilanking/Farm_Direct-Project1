// product_detail.php
<?php
include("./dbconf/dbconf.php");

if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title><?php echo htmlspecialchars($product['name']); ?></title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>
            <div class="container">
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                <img src="assets/<?php echo $product['id']; ?>.jpg" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-fluid">
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <p>Price: <?php echo number_format($product['price'], 2); ?> LKR</p>
                <button class="btn btn-primary">Add to Cart</button>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "<p>Product not found.</p>";
    }
} else {
    echo "<p>No product ID provided.</p>";
}
?>