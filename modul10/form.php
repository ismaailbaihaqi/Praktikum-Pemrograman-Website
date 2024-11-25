<?php
require 'db.php';

// Handle form submission
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['register'])) {
        // Register logic
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $password]);
            $message = "Registrasi berhasil! Silakan login.";
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    } elseif (isset($_POST['login'])) {
        // Login logic
        $username = $_POST['username'];
        $password = $_POST['password'];

        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $message = "Login berhasil! Selamat datang, " . htmlspecialchars($user['username']) . ".";
            } else {
                $message = "Username atau password salah!";
            }
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { display: flex; gap: 50px; }
        .form-box { border: 1px solid #ccc; padding: 20px; border-radius: 8px; width: 300px; }
        .form-box h2 { margin-top: 0; }
        .form-box form { display: flex; flex-direction: column; }
        .form-box form label { margin-top: 10px; }
        .form-box form input { padding: 8px; margin-top: 5px; }
        .form-box form button { margin-top: 20px; padding: 10px; background-color: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .form-box form button:hover { background-color: #0056b3; }
        .message { margin-top: 20px; color: green; font-weight: bold; }
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Register & Login</h1>
    <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <div class="container">
        <!-- Register Form -->
        <div class="form-box">
            <h2>Register</h2>
            <form method="POST">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>

                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>

                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>

                <button type="submit" name="register">Register</button>
            </form>
        </div>

        <!-- Login Form -->
        <div class="form-box">
            <h2>Login</h2>
            <form method="POST">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>

                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>

                <button type="submit" name="login">Login</button>
            </form>
        </div>
    </div>
</body>
</html>