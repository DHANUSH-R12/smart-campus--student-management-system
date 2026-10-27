<?php
session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
  $conn = new mysqli('localhost', 'root', '', 'student_management');
  $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
  exit('Database connection failed. Check WAMP and config.php.');
}
function e($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function require_login() { if (empty($_SESSION['admin_id'])) { header('Location: login.php'); exit; } }
function flash($type,$message) { $_SESSION['flash']=['type'=>$type,'message'=>$message]; }
function show_flash() { if(isset($_SESSION['flash'])) { $f=$_SESSION['flash']; echo '<div class="alert '.e($f['type']).'">'.e($f['message']).'</div>'; unset($_SESSION['flash']); } }
