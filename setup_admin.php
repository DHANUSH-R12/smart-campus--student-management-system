<?php
require 'config.php';
$u='admin'; $p=password_hash('Admin@123', PASSWORD_DEFAULT);
try { $s=$conn->prepare('INSERT INTO admin(username,password) VALUES(?,?)'); $s->bind_param('ss',$u,$p); $s->execute(); echo 'Admin created. Username: admin | Temporary password: Admin@123. Delete setup_admin.php now.'; }
catch(Throwable $e) { echo 'Admin may already exist. Delete setup_admin.php now.'; }
