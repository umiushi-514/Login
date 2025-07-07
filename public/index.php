<?php
require_once('../db/connect.php');
require_once('template/header.php');

// ログインフォーム処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stmt = $db->prepare('SELECT * FROM users WHERE username = ?');
  $stmt->execute([$_POST['username']]);
  $user = $stmt->fetch();

  // 入力されたパスワードとDBのハッシュを検証
  if ($user && password_verify($_POST['password'], $user['password'])) {
    $_SESSION['user_id'] = $user['id']; // セッションにユーザーID保存
    header('Location: dashboard.php');  // ダッシュボードへ遷移
    exit();
  } else {
    $error = 'ユーザー名またはパスワードが正しくありません';
  }
}
?>

<div class="center-text">
  <h2>ログイン</h2>
</div>
<form method="POST">
  <div class="center-text">
    <p><input name="username" placeholder="ユーザー名" required></p>
    <p><input name="password" type="password" placeholder="パスワード" required></p>
    <p><button type="submit">ログイン</button></p>
  </div>
  </form>
<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<?php require_once('template/footer.php'); ?>