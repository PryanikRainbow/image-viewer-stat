<?php

if (!function_exists('logMessage')) {
    function logMessage($message) {
        $filePath = __DIR__ . '/app.log';

        $logMessage = "[" . date('Y-m-d H:i:s') . "] " . $message . PHP_EOL;

        file_put_contents($filePath, $logMessage, FILE_APPEND);
    }
}