<?php
require_once('../db/connect.php');
require_once('template/header.php');

// 未ログインならリダイレクト
if (!isset($_SESSION['user_id'])) {
  header('Location: index.php');
  exit();
}

// 自分のメモ一覧を取得
$stmt = $db->prepare('SELECT content, created_at FROM notes WHERE user_id = ? ORDER BY created_at DESC');
$stmt->execute([$_SESSION['user_id']]);
$notes = $stmt->fetchAll();
?>

<h2>メモ一覧</h2>
<form action="add_note.php" method="POST">
  <textarea name="note" required></textarea>
  <button type="submit">メモを追加</button>
</form>

<ul>
<?php foreach ($notes as $note): ?>
  <li><?= htmlspecialchars($note['created_at']) ?>: <?= htmlspecialchars($note['content']) ?></li>
<?php endforeach; ?>
</ul>

<div class="account-delete-container">
  <form action="delete_account.php" method="POST" onsubmit="return confirm('本当にアカウントを削除しますか？');">
    <button type="submit" class="account-delete-button">アカウント削除</button>
  </form>
</div>

<a href="logout.php">ログアウト</a>



<?php require_once('template/footer.php'); ?>