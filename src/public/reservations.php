<?php
$dbUserName = 'root';
$dbPassword = 'password';
try {
    $pdo = new PDO(
        'mysql:host=mysql;dbname=bookingform;charset=utf8',
        $dbUserName,
        $dbPassword
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query('SELECT * FROM booking');
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('データベースエラー: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予約一覧</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-4">予約一覧</h1>
        <table class="w-full border-collapse mb-4">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">ID</th>
                    <th class="border p-2">名前</th>
                    <th class="border p-2">メールアドレス</th>
                    <th class="border p-2">電話番号</th>
                    <th class="border p-2">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation): ?>
                    <tr>
                        <td class="border p-2"><?php echo htmlspecialchars($reservation['id']); ?></td>
                        <td class="border p-2"><?php echo htmlspecialchars($reservation['name']); ?></td>
                        <td class="border p-2"><?php echo htmlspecialchars($reservation['email']); ?></td>
                        <td class="border p-2"><?php echo htmlspecialchars($reservation['phone_number']); ?></td>
                        <td class="border p-2">
                            <a href="edit.php?id=<?php echo $reservation['id']; ?>" class="text-blue-500 hover:text-blue-700 mr-2">編集</a>
                            <a href="delete.php?id=<?php echo $reservation['id']; ?>" onclick="return confirm('本当に削除しますか？');" class="text-red-500 hover:text-red-700">削除</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="index.php" class="bg-indigo-500 text-white font-bold py-2 px-4 rounded-md hover:bg-indigo-600 transition duration-300">新規予約</a>
    </div>
</body>
</html>
