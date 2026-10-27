<?php
require 'config.php'; require_login(); $pageTitle='Dashboard'; $active='dashboard';
$total=(int)$conn->query('SELECT COUNT(*) c FROM students')->fetch_assoc()['c'];
$present=(int)$conn->query("SELECT COUNT(*) c FROM attendance WHERE attendance_date=CURDATE() AND status='Present'")->fetch_assoc()['c'];
$absent=(int)$conn->query("SELECT COUNT(*) c FROM attendance WHERE attendance_date=CURDATE() AND status='Absent'")->fetch_assoc()['c'];
$r=$conn->query('SELECT AVG((internal_marks+semester_marks)/2) a FROM marks')->fetch_assoc(); $avg=$r['a']===null?0:(float)$r['a'];
$recent=$conn->query('SELECT * FROM students ORDER BY id DESC LIMIT 6'); require 'includes/header.php'; ?>
<div class="heading"><div><p class="eyebrow">OVERVIEW</p><h1>Good to see you, <?=e($_SESSION['admin_username'])?> ✦</h1><p class="muted">Here’s what’s happening across your student records today.</p></div><a class="btn primary" href="students.php?action=add">＋ Add student</a></div>
<div class="stats">
<div class="stat"><span>Total students</span><i class="purple">♙</i><strong><?=$total?></strong><small>● Live count　 Registered records</small></div>
<div class="stat"><span>Present today</span><i class="green">✓</i><strong><?=$present?></strong><small>● Attendance　 Today's records</small></div>
<div class="stat"><span>Absent today</span><i class="orange">◷</i><strong><?=$absent?></strong><small>Daily overview　 Selected date</small></div>
<div class="stat"><span>Average marks</span><i class="blue">▤</i><strong><?=number_format($avg,1)?><em>/100</em></strong><small>● Academic data　 Entered subjects</small></div></div>
<div class="columns"><section class="card"><div class="cardhead"><div><h2>Recently added students</h2><p class="muted">Latest student records in your system</p></div><a class="textlink" href="students.php">View all →</a></div><div class="tablewrap"><table><thead><tr><th>STUDENT</th><th>DEPARTMENT</th><th>YEAR</th><th>STATUS</th></tr></thead><tbody>
<?php if($recent->num_rows):while($s=$recent->fetch_assoc()):?><tr><td><b><?=e($s['name'])?></b><small><?=e($s['register_number'])?></small></td><td><?=e($s['department'])?></td><td>Year <?= (int)$s['year']?></td><td><span class="badge">Registered</span></td></tr><?php endwhile;else:?><tr><td colspan="4" class="empty">No student records yet. Add your first student to get started.</td></tr><?php endif;?></tbody></table></div></section>
<section class="card"><div class="cardhead"><div><h2>Quick actions</h2><p class="muted">Common tasks, one click away</p></div></div>
<?php foreach([['＋','Add a student','Create a new student profile','students.php?action=add','purple'],['✓','Mark attendance','Record daily attendance','attendance.php','green'],['▤','Enter marks','Update academic performance','marks.php','blue'],['▧','View reports','Review and print records','reports.php','orange']] as $a):?><a class="quick" href="<?=$a[3]?>"><i class="<?=$a[4]?>"><?=$a[0]?></i><span><b><?=$a[1]?></b><small><?=$a[2]?></small></span><strong>→</strong></a><?php endforeach;?><div class="tip"><b>Small tip</b><p>Use each student's unique register number to keep records organised and easy to find.</p></div></section></div>
<?php require 'includes/footer.php'; ?>