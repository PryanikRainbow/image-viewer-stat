<?php

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../DBConnect.php';
require_once __DIR__ . '/../logger.php';

try {
    $pdo = DBConnection::getInstance();

    $stmt = $pdo->prepare("
        SELECT ip_address, hit_count
        FROM banner_stats
        ORDER BY hit_count DESC
    ");
    $stmt->execute();
    $entries = $stmt->fetchAll();
    $totalHosts = count($entries);
    $totalHits  = 0;

    foreach ($entries as $entry) {
        $totalHits += $entry['hit_count'];
    }
} catch (Throwable $t) {
    logMessage("Something was wrong: " . $t->getMessage());

    http_response_code(500);
}

?>

<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <title>Banner statistics</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>

<body>

    <div class="stat-container">
        <h1>Banner impression statistics</h1>

        <table>
            <tr>
                <th>IP</th>
                <th>HIT</th>
            </tr>

            <?php foreach ($entries as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['ip_address']) ?></td>
                    <td><?= htmlspecialchars($row['hit_count']) ?></td>
                </tr>
            <?php endforeach; ?>

            <tr class="total-row">
                <td><?= $totalHosts ?></td>
                <td><?= $totalHits ?></td>
            </tr>
        </table>

        <form method="post" action="logout.php" style="display:inline;">
            <button type="submit" name="logout">Logout</button>
        </form>
    </div>

</body>

</html>