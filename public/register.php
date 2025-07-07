<?php
require_once('../db/connect.php');
require_once('template/header.php');

// ユーザー新規登録処理
$message = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  if ($username && $password) {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    try {
      $stmt = $db->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
      $stmt->execute([$username, $hashed]);
      $message = '登録が成功しました。ログインしてください。';
    } catch (PDOException $e) {
      $error = '登録に失敗しました：' . htmlspecialchars($e->getMessage());
    }
  } else {
    $error = 'すべての項目を入力してください';
  }
}
?>

<h2>新規登録</h2>
<form method="POST">
  <input name="username" placeholder="ユーザー名" required><br>
  <input name="password" type="password" placeholder="パスワード" required><br>
  <button type="submit">登録</button>
</form>
<?php if ($message) echo "<p style='color:green;'>$message</p>"; ?>
<?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
<p><a href="index.php">ログインへ戻る</a></p>

<?php require_once('template/footer.php'); ?>