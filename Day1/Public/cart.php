// cart.php
<?php
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add product to cart
if (isset($_GET['add'])) {
    $product_id = intval($_GET['add']);
    $_SESSION['cart'][] = $product_id;
}

// Display cart items
echo "<h1>Your Cart</h1>";
if (empty($_SESSION['cart'])) {
    echo "<p>Your cart is empty.</p>";
} else {
    foreach ($_SESSION['cart'] as $id) {
        // Fetch product details from the database
        $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result ->num_rows > 0) {
            $product = $result->fetch_assoc();
            echo "<div class='product-item'>";
            echo "<h5>" . htmlspecialchars($product['name']) . "</h5>";
            echo "<p>Price: " . number_format($product['price'], 2) . " LKR</p>";
            echo "<a href='cart.php?remove=" . $id . "' class='btn btn-danger'>Remove</a>";
            echo "</div>";
        }
    }
}

// Remove product from cart
if (isset($_GET['remove'])) {
    $remove_id = intval($_GET['remove']);
    if (($key = array_search($remove_id, $_SESSION['cart'])) !== false) {
        unset($_SESSION['cart'][$key]);
    }
}
?>