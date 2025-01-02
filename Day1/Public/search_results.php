<?php
include_once "resource/session.php";  // For session handling
include("./dbconf/dbconf.php");  // Include your database configuration file

// Check if the search query exists
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = htmlspecialchars($_GET['search']);  // Sanitize the search input

    // Prepare the SQL statement to search for products that match the search query
    $stmt = $connect->prepare("SELECT * FROM products WHERE product_name LIKE ?");
    $search_term = "%" . $search_query . "%";  // Adding wildcards for partial matching
    $stmt->bind_param("s", $search_term);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = [];  // If no search query, set an empty result set
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>FarmDirect: Search Results</title>

    <!-- Bootstrap Core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add custom styles if needed -->
</head>

<body>

    <!-- Your navigation bar here -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php"><strong>FarmDirect</strong></a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <!-- Other menu items here -->
                </ul>
            </div>
        </div>
    </nav>

    <!-- Search Results Section -->
    <div class="container my-4">
        <h2>Search Results for "<?php echo $search_query; ?>"</h2>
        <?php
        if ($result && $result->num_rows > 0) {
            // Display the results
            while ($row = $result->fetch_assoc()) {
                echo '<div class="row mb-4">';
                echo '<div class="col-md-4">';
                echo '<div class="card">';
                echo '<img src="path_to_images/' . $row['product_image'] . '" class="card-img-top" alt="Product Image">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $row['product_name'] . '</h5>';
                echo '<p class="card-text">' . $row['product_description'] . '</p>';
                echo '<p><strong>Price:</strong> $' . $row['product_price'] . '</p>';
                echo '<a href="product_details.php?id=' . $row['product_id'] . '" class="btn btn-warning">View Details</a>';
                echo '</div></div></div>';
                echo '</div>';
            }
        } else {
            // If no results found
            echo '<p>No products found matching your search query.</p>';
        }
        ?>
    </div>

    <!-- Footer -->
    <footer>
        <hr>
        <p>Contact Us: (+94)0762552365 &copy; FarmDirect. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
