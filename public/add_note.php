<?php
require_once('../db/connect.php');

// ログイン確認
if (!isset($_SESSION['user_id'])) {
  header('Location: index.php');
  exit();
}

// メモをDBに追加
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['note'])) {
  $stmt = $db->prepare('INSERT INTO notes (user_id, content) VALUES (?, ?)');
  $stmt->execute([$_SESSION['user_id'], $_POST['note']]);
}
header('Location: dashboard.php');
exit();
?>