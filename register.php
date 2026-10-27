<?php
require 'config.php';
if(!empty($_SESSION['admin_id'])) { header('Location: index.php'); exit; }
$error=''; $success='';
if($_SERVER['REQUEST_METHOD']==='POST') {
  $u=trim($_POST['username']??''); $p=$_POST['password']??''; $confirm=$_POST['confirm_password']??'';
  if(strlen($u)<4 || strlen($u)>50) $error='Username must be between 4 and 50 characters.';
  elseif(!preg_match('/^[A-Za-z0-9_.-]+$/',$u)) $error='Use only letters, numbers, dot, underscore or hyphen in username.';
  elseif(strlen($p)<8) $error='Password must contain at least 8 characters.';
  elseif($p!==$confirm) $error='Passwords do not match.';
  else {
    try {
      $hash=password_hash($p,PASSWORD_DEFAULT);
      $stmt=$conn->prepare('INSERT INTO admin(username,password) VALUES(?,?)');
      $stmt->bind_param('ss',$u,$hash); $stmt->execute();
      $success='Account created successfully. You can now sign in.';
    } catch(mysqli_sql_exception $ex) { $error=$ex->getCode()===1062?'That username is already taken. Choose another one.':'Could not create account. Please try again.'; }
  }
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Create account · SmartCampus</title><link rel="stylesheet" href="css/style.css"></head>
<body class="login-body"><main class="login-shell"><section class="login-visual"><div class="brand brand-light"><span class="brand-mark">S</span> SmartCampus</div><div class="visual-copy"><span class="eyebrow">SMART ACADEMIC MANAGEMENT</span><h1>Your campus.<br>Organised better.</h1><p>Manage student records, daily attendance and academic performance in one simple workspace.</p></div><div class="visual-footer">● Student records　 ● Attendance　 ● Results</div></section>
<section class="login-panel"><div class="brand mobile-brand"><span class="brand-mark">S</span> SmartCampus</div><div class="login-content"><div class="welcome-icon">＋</div><p class="eyebrow">GET STARTED</p><h2>Create your account</h2><p class="muted">Set up an administrator account for your workspace.</p>
<?php if($error): ?><div class="alert error"><?=e($error)?></div><?php endif; ?>
<?php if($success): ?><div class="alert success"><?=e($success)?></div><?php endif; ?>
<form method="post" class="form-stack"><label>Username<input name="username" required minlength="4" maxlength="50" pattern="[A-Za-z0-9_.-]+" placeholder="Choose a username" autocomplete="username"></label><label>Password<input type="password" name="password" required minlength="8" placeholder="At least 8 characters" autocomplete="new-password"></label><label>Confirm password<input type="password" name="confirm_password" required minlength="8" placeholder="Enter password again" autocomplete="new-password"></label><button class="btn primary full" type="submit">Create account <span>→</span></button></form><p class="register-prompt">Already have an account? <a href="login.php">Sign in</a></p></div><div class="login-bottom">SmartCampus · Student Management System <span>v1.0</span></div></section></main></body></html>
