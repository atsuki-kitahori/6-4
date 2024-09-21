<?php
$dbUserName = 'root';
$dbPassword = 'password';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // フォームが送信された場合の処理
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];

    try {
        $pdo = new PDO(
            'mysql:host=mysql;dbname=bookingform;charset=utf8',
            $dbUserName,
            $dbPassword
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare(
            'UPDATE booking SET name = :name, email = :email, phone_number = :phone_number WHERE id = :id'
        );
        $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':email' => $email,
            ':phone_number' => $phone_number,
        ]);

        header('Location: reservations.php');
        exit();
    } catch (PDOException $e) {
        die('データベースエラー: ' . $e->getMessage());
    }
} else {
    // GETリクエストの場合、予約データを取得
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

        $stmt = $pdo->prepare('SELECT * FROM booking WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$reservation) {
            die('指定された予約が見つかりません。');
        }
    } catch (PDOException $e) {
        die('データベースエラー: ' . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>予約編集</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-4">予約編集</h1>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars(
                $reservation['id']
            ); ?>">
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">予約者名</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars(
                    $reservation['name']
                ); ?>" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars(
                    $reservation['email']
                ); ?>" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label for="phone_number" class="block text-gray-700 text-sm font-bold mb-2">電話番号</label>
                <input type="tel" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars(
                    $reservation['phone_number']
                ); ?>" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="w-full bg-indigo-500 text-white font-bold py-2 px-4 rounded-md hover:bg-indigo-600 transition duration-300">
                更新
            </button>
        </form>
        <p class="mt-4 text-center">
            <a href="reservations.php" class="text-indigo-500 hover:text-indigo-600">予約一覧に戻る</a>
        </p>
    </div>
</body>
</html>
