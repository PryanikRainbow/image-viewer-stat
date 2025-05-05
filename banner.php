<?php

require_once __DIR__ . '/DBConnect.php';
require_once __DIR__ . '/logger.php';

$bannerPath = __DIR__ . '/public/image.jpg';

try {

    if (file_exists($bannerPath)) {
        header('Content-Type: image/jpeg');
        readfile($bannerPath);

        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        }

        $pdo = DBConnection::getInstance();

        $ip = $_SERVER["REMOTE_ADDR"] ?? 'unknown';
        $stmt = $pdo->prepare(
            "INSERT INTO banner_stats (ip_address, hit_count) 
             VALUES (:ip_address, 1) 
             ON DUPLICATE KEY UPDATE hit_count = hit_count + 1"
        );

        $stmt->execute(['ip_address' => $ip]);
    } else {
        logMessage('Banner not found');
        http_response_code(404);
    }
} catch (\Throwable $t) {
    logMessage("Something was wrong: " . $t->getMessage());
    http_response_code(500);
}

exit;
