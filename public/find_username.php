<?php
require_once('../db/connect.php');
require_once('template/header.php');

// パスワードからユーザー名を逆引き（教育目的）
$message = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $password_input = $_POST['password'];
  $stmt = $db->query('SELECT username, password FROM users');
  while ($row = $stmt->fetch()) {
    if (password_verify($password_input, $row['password'])) {
      $message = '登録されているユーザー名は「' . htmlspecialchars($row['username']) . '」です。';
      break;
    }
  }
  if (!$message) {
    $error = '該当するユーザー名は見つかりませんでした。';
  }
}
?>

<h2>ユーザー名を忘れた方</h2>
<form method="POST">
  <input name="password" type="password" placeholder="パスワードを入力" required><br>
  <button type="submit">ユーザー名を検索</button>
</form>
<?php if ($message): ?>
  <p style="color:green;"><?php echo $message; ?></p>
<?php elseif ($error): ?>
  <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>
<p><a href="index.php">ログイン画面に戻る</a></p>

<?php require_once('template/footer.php'); ?>