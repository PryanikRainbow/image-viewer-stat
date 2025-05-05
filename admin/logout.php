<?php

if (isset($_POST['logout'])) {

    $_SESSION = [];

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    session_destroy();
    setcookie('PHPSESSID', '', time() - 3600, '/');
    header('Location: login.php');

    exit();
} else {
    require_once __DIR__ . '/logger.php';
}