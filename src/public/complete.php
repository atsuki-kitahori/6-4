<?php
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone_number = $_POST['phone_number'] ?? '';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予約完了</title>
</head>
<body>
    <h1>予約が完了しました</h1>
    <p>以下の内容で予約を受け付けました：</p>
    <ul>
        <li>予約者名: <?php echo htmlspecialchars($name); ?></li>
        <li>Email: <?php echo htmlspecialchars($email); ?></li>
        <li>電話番号: <?php echo htmlspecialchars($phone_number); ?></li>
    </ul>
</body>
</html>