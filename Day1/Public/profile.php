// profile.php
<?php
include_once "resource/session.php";
include("./dbconf/dbconf.php");

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['updateProfile'])) {
    $username = $_SESSION['username'];
    $new_email = mysqli_real_escape_string($connect, $_POST['email']);
    $new_password = mysqli_real_escape_string($connect, $_POST['password']);
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    $stmt = $connect->prepare("UPDATE users SET email = ?, password = ? WHERE username = ?");
    $stmt->bind_param("ssi", $new_email, $hashed_password, $username);
    $stmt->execute();
    echo "<script>alert('Profile updated successfully!');</script>";
}

$stmt = $connect->prepare("SELECT email FROM users WHERE username = ?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>User Profile</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" name="updateProfile" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
</body>
</html>