<?php

session_start();

if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../DBConnect.php';
    require_once __DIR__ . '/../logger.php';

    try {
        $pdo = DBConnection::getInstance();

        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE login = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['login'];
            $_SESSION['user_id'] = $user['id'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Login or Password invalid";
        }
    } catch (Throwable $t) {
        logMessage("Something was wrong: " . $t->getMessage());

        http_response_code(500);
    }
}
?>

<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <title>Admin Page</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="container">
        <h1>Admin Page</h1>

        <?php if (!empty($error)): ?>
            <div class="error">
                <?= htmlspecialchars("Something was wrong") ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <label for="username">Login:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>

</body>

</html>