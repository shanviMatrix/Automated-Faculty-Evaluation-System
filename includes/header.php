<?php
$current_page = basename($_SERVER['PHP_SELF']);
$role         = $_SESSION['user_role'] ?? '';
$user_name    = $_SESSION['user_name'] ?? '';

$initials = '';
if ($user_name) {
    $parts    = explode(' ', trim($user_name));
    $initials = strtoupper(substr($parts[0], 0, 1));
    if (isset($parts[1])) $initials .= strtoupper(substr($parts[1], 0, 1));
}

$base = '/faculty_eval/';

$dashboard_url = match($role) {
    'admin'   => $base . 'admin/dashboard.php',
    'student' => $base . 'student/dashboard.php',
    'faculty' => $base . 'faculty/dashboard.php',
    default   => $base . 'login.php',
};
?>
<nav class="navbar">
  <div class="navbar-inner">
    <a href="<?= $dashboard_url ?>" class="navbar-brand">
      <div class="navbar-logo">FE</div>
      <span class="navbar-title">Faculty <span>Eval</span></span>
    </a>

    <?php if ($role === 'admin'): ?>
    <ul class="navbar-nav">
      <li><a href="<?= $base ?>admin/dashboard.php"      class="<?= $current_page==='dashboard.php'     ?'active':'' ?>">Dashboard</a></li>
      <li><a href="<?= $base ?>admin/add_faculty.php"    class="<?= $current_page==='add_faculty.php'   ?'active':'' ?>">+ Add Faculty</a></li>
      <li><a href="<?= $base ?>admin/manage_faculty.php" class="<?= $current_page==='manage_faculty.php'?'active':'' ?>">Manage Faculty</a></li>
      <li><a href="<?= $base ?>admin/view_feedback.php"  class="<?= $current_page==='view_feedback.php' ?'active':'' ?>">View Feedback</a></li>
      <li class="nav-logout"><a href="<?= $base ?>logout.php">Logout</a></li>
    </ul>

    <?php elseif ($role === 'student'): ?>
    <ul class="navbar-nav">
      <li><a href="<?= $base ?>student/dashboard.php" class="<?= $current_page==='dashboard.php'?'active':'' ?>">Dashboard</a></li>
      <li><a href="<?= $base ?>student/feedback.php"  class="<?= $current_page==='feedback.php' ?'active':'' ?>">Give Feedback</a></li>
      <li class="nav-logout"><a href="<?= $base ?>logout.php">Logout</a></li>
    </ul>

    <?php elseif ($role === 'faculty'): ?>
    <ul class="navbar-nav">
      <li><a href="<?= $base ?>faculty/dashboard.php" class="<?= $current_page==='dashboard.php'?'active':'' ?>">My Feedback</a></li>
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