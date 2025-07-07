<?php
// データベース接続設定（SQLite）とセッション開始
$db = new PDO('sqlite:' . __DIR__ . '/../secure_note.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
session_start();
?>