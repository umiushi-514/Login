<?php
require_once('../db/connect.php');
require_once('template/header.php');

// パスワード再設定処理
$message = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $new_password = trim($_POST['password']);
  if ($username && $new_password) {
    // 指定されたユーザーが存在するか確認
    $stmt = $db->prepare('SELECT id FROM users WHERE username = ?');
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
      // パスワードをハッシュ化して更新
      $hashed = password_hash($new_password, PASSWORD_DEFAULT);
      $stmt = $db->prepare('UPDATE users SET password = ? WHERE username = ?');
      $stmt->execute([$hashed, $username]);
      $message = 'パスワードを再設定しました。ログインしてください。';
    } else {
      $error = 'ユーザー名が見つかりませんでした。';
    }
  } else {
    $error = 'すべての項目を入力してください。';
  }
}
?>

<h2>パスワードを忘れた方</h2>
<form method="POST">
  <input name="username" placeholder="ユーザー名を入力" required><br>
  <input name="password" type="password" placeholder="新しいパスワードを入力" required><br>
  <button type="submit">パスワード再設定</button>
</form>
<?php if ($message): ?>
  <p style="color:green;"><?php echo $message; ?></p>
<?php elseif ($error): ?>
  <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>
<p><a href="index.php">ログイン画面に戻る</a></p>

<?php require_once('template/footer.php'); ?>