<?php
session_start(); // Start the session to access user data

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Include database configuration
include("./dbconf/dbconf.php");

// Initialize search results
$search_results = [];
$search_query = '';

// Check if a search query is submitted
if (isset($_POST['search'])) {
    $search_query = mysqli_real_escape_string($connect, $_POST['searchvalue']);
    $sql = "SELECT * FROM products WHERE product_name LIKE '%$search_query%'"; // Search for products
    $search_results = mysqli_query($connect, $sql);
} else {
    // Fetch a limited number of products for display if no search is performed
    $sql = "SELECT * FROM products LIMIT 6"; // Fetch a limited number of products for display
    $search_results = mysqli_query($connect, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to FarmDirect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Background image styling */
        body {
            background-image: url('image/background.avif'); /* Path to your background image */
            background-size: cover; /* Cover the entire viewport */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Prevent the image from repeating */
            color: white; /* Change text color to white for better contrast */
        }
        .container {
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background for readability */
            padding: 20px;
            border-radius: 10px; /* Rounded corners */
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="home.php"><strong>FarmDirect</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Welcome Section -->
    <div class="container my-5">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>Explore our wide range of agricultural products.</p>

        <!-- Search Bar -->
        <form class="d-flex mb-4" method="POST" action="home.php">
            <input class="form-control me-2" type="text" name="searchvalue" placeholder="Search for products..." value="<?php echo htmlspecialchars($search_query); ?>" required>
            <button class="btn btn-primary" type="submit" name="search">Search</button>
        </form>

        <!-- Products Section -->
        <h2>Search Results</h2>
        <div class="row">
            <?php
            if (mysqli_num_rows($search_results) > 0) {
                while ($row = mysqli_fetch_assoc($search_results)) {
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="assets/<?php echo $row['id']; ?>.jpg" class="card-img-top" alt="<?php echo htmlspecialchars($row['name']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                                <p class="card-text">Price: <?php echo number_format($row['price'], 2); ?> LKR</p>
                                <a href="product_detail.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<p>No products found.</p>';
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center text-white bg-dark py-3">
        <p>Contact Us: (+94)0762552365 &copy; FarmDirect. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>