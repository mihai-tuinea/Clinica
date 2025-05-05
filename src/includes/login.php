<?php
session_start();

include("../includes/config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password' LIMIT 1";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        header('Location: ../admin-page.php');
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
<h2>Login</h2>
<?php if (isset($error)) { echo "<p style='color:red'>$error</p>"; } ?>
<section>
<form method="POST" action="login.php">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required><br><br>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required><br><br>
    <button type="submit">Login</button>
</form>
</section>
</body>
</html>
