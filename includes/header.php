<?php
$current_page = basename($_SERVER['PHP_SELF']);
$role = isset($_SESSION['role']) ? $_SESSION['role'] : (isset($_SESSION['admin']) ? 'admin' : (isset($_SESSION['student_id']) ? 'student' : ''));
$user_name = isset($_SESSION['name']) ? $_SESSION['name'] : (isset($_SESSION['admin']) ? $_SESSION['admin'] : '');
$initials = '';
if ($user_name) {
    $parts = explode(' ', trim($user_name));
    $initials = strtoupper(substr($parts[0], 0, 1));
    if (isset($parts[1])) $initials .= strtoupper(substr($parts[1], 0, 1));
}
$depth = substr_count($_SERVER['PHP_SELF'], '/') - 1;
$base  = str_repeat('../', $depth);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Faculty Evaluation System</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= $base ?>style.css">
</head>
<body>
<div class="page-wrapper">
<nav class="navbar">
  <div class="navbar-inner">
    <a href="<?= $base ?>index.php" class="navbar-brand">
      <div class="navbar-logo">FE</div>
      <span class="navbar-title">Faculty <span>Eval</span></span>
    </a>
    <?php if ($role === 'admin'): ?>
    <ul class="navbar-nav">
      <li><a href="<?= $base ?>admin/dashboard.php" class="<?= $current_page==='dashboard.php'?'active':'' ?>">Dashboard</a></li>
      <li><a href="<?= $base ?>admin/add_faculty.php" class="<?= $current_page==='add_faculty.php'?'active':'' ?>">+ Add Faculty</a></li>
      <li><a href="<?= $base ?>admin/manage_faculty.php" class="<?= $current_page==='manage_faculty.php'?'active':'' ?>">Manage Faculty</a></li>
      <li><a href="<?= $base ?>admin/view_feedback.php" class="<?= $current_page==='view_feedback.php'?'active':'' ?>">View Feedback</a></li>
      <li class="nav-logout"><a href="<?= $base ?>logout.php">Logout</a></li>
    </ul>
    <?php elseif ($role === 'student'): ?>
    <ul class="navbar-nav">
      <li><a href="<?= $base ?>student/dashboard.php" class="<?= $current_page==='dashboard.php'?'active':'' ?>">Dashboard</a></li>
      <li><a href="<?= $base ?>student/feedback.php" class="<?= $current_page==='feedback.php'?'active':'' ?>">Give Feedback</a></li>
      <li class="nav-logout"><a href="<?= $base ?>logout.php">Logout</a></li>
    </ul>
    <?php else: ?>
    <ul class="navbar-nav"></ul>
    <?php endif; ?>
    <?php if ($user_name): ?>
    <div class="navbar-user">
      <div class="navbar-avatar"><?= htmlspecialchars($initials ?: 'U') ?></div>
      <?= htmlspecialchars($user_name) ?>
    </div>
    <?php endif; ?>
  </div>
</nav>
<div class="main-content">