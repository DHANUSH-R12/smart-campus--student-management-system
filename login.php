<?php
require 'config.php';
if(!empty($_SESSION['admin_id'])) { header('Location: index.php'); exit; }
$error='';
if($_SERVER['REQUEST_METHOD']==='POST') {
 $u=trim($_POST['username']??''); $p=$_POST['password']??'';
 $s=$conn->prepare('SELECT id,username,password FROM admin WHERE username=? LIMIT 1'); $s->bind_param('s',$u); $s->execute(); $a=$s->get_result()->fetch_assoc();
 if($a && password_verify($p,$a['password'])) { session_regenerate_id(true); $_SESSION['admin_id']=$a['id']; $_SESSION['admin_username']=$a['username']; header('Location: index.php'); exit; }
 $error='Incorrect username or password.';
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Sign in · SmartCampus</title><link rel="stylesheet" href="css/style.css"></head>
<body class="login-body"><main class="login-shell"><section class="login-visual"><div class="brand brand-light"><span class="brand-mark">S</span> SmartCampus</div><div class="visual-copy"><span class="eyebrow">CAMPUS ADMINISTRATION</span><h1>Every student.<br>One clear picture.</h1><p>A calmer, smarter way to manage student records, attendance and academic performance.</p></div><div class="visual-footer">● Student records　 ● Attendance　 ● Results</div></section>
<section class="login-panel"><div class="brand mobile-brand"><span class="brand-mark">S</span> SmartCampus</div><div class="login-content"><div class="welcome-icon">↗</div><p class="eyebrow">WELCOME BACK</p><h2>Sign in to your workspace</h2><p class="muted">Enter your administrator credentials to continue.</p>
<?php if($error): ?><div class="alert error"><?=e($error)?></div><?php endif;?>
<form method="post" class="form-stack"><label>Username<input name="username" required placeholder="Enter your username" autocomplete="username"></label><label>Password<div class="password-wrap"><input id="password" type="password" name="password" required placeholder="Enter your password" autocomplete="current-password"><button type="button" class="toggle-password" onclick="let p=document.getElementById('password');p.type=p.type==='password'?'text':'password';this.textContent=p.type==='password'?'Show':'Hide'">Show</button></div></label><button class="btn primary full" type="submit">Sign in <span>→</span></button></form><p class="login-note">▣ Protected administrator access</p><p class="register-prompt">New to SmartCampus? <a href="register.php">Create an account</a></p></div><div class="login-bottom">SmartCampus · Student Management System <span>v1.0</span></div></section></main></body></html>
