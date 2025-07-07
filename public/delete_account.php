<?php
require_once('../db/connect.php');
require_once('template/header.php');

// セッション確認
if (!isset($_SESSION['user_id'])) {
  header('Location: index.php');
  exit();
}

$deleted = false;
$error = '';

try {
  // メモとアカウントを削除
  $db->prepare('DELETE FROM notes WHERE user_id = ?')->execute([$_SESSION['user_id']]);
  $db->prepare('DELETE FROM users WHERE id = ?')->execute([$_SESSION['user_id']]);
  session_destroy();
  $deleted = true;
} catch (PDOException $e) {
  $error = '削除中にエラーが発生しました：' . htmlspecialchars($e->getMessage());
}
?>

<h2>アカウント削除</h2>
<?php if ($deleted): ?>
  <p>✅ アカウントが正常に削除されました。</p>
  <p><a href="index.php" class="button">ログイン画面へ戻る</a></p>
<?php elseif ($error): ?>
  <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>

<?php require_once('template/footer.php'); ?>