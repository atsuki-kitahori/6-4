<?php
$dbUserName = 'root';
$dbPassword = 'password';

$id = $_GET['id'] ?? '';
if (!$id) {
    die('IDが指定されていません。');
}

try {
    $pdo = new PDO(
        'mysql:host=mysql;dbname=bookingform;charset=utf8',
        $dbUserName,
        $dbPassword
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare('DELETE FROM booking WHERE id = :id');
    $stmt->execute([':id' => $id]);

    header('Location: reservations.php');
    exit();
} catch (PDOException $e) {
    die('データベースエラー: ' . $e->getMessage());
}
