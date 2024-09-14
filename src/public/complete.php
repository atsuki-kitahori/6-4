<?php

// POSTデータの取得と検証
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone_number = $_POST['phone_number'] ?? '';

// 入力チェック
if (empty($name) || empty($email) || empty($phone_number)) {
    $success = false;
    $error_message = '名前、メールアドレス、電話番号はすべて入力してください。';
} else {
    // データベースに接続
    $dbUserName = 'root';
    $dbPassword = 'password';
    try {
        $pdo = new PDO(
            'mysql:host=mysql;dbname=bookingform;charset=utf8',
            $dbUserName,
            $dbPassword
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // データの挿入
        $stmt = $pdo->prepare(
            'INSERT INTO booking (name, email, phone_number) VALUES (:name, :email, :phone_number)'
        );
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':phone_number' => $phone_number,
        ]);

        $success = true;
    } catch (PDOException $e) {
        $success = false;
        $error_message = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予約完了</title>
</head>
<body>
    <?php if ($success): ?>
        <h1>予約完了^^</h1>
    <?php else: ?>
        <h1>エラーが発生しました</h1>
        <p>申し訳ありませんが、予約の処理中にエラーが発生しました。もう一度お試しください。</p>
        <p>エラー詳細: <?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>
    <p><a href="index.php">予約画面へ</a></p>
</body>
</html>