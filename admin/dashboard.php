<?php
session_start();
if (!isset($_SESSION['admin'])) { header("Location: ../login.php"); exit(); }
$_SESSION['name'] = $_SESSION['admin'];
$role = 'admin';
include("../config/db.php");
$total_faculty  = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM faculty"))[0];
$total_students = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM students"))[0];
$total_feedback = mysqli_fetch_row(mysqli_query($conn, "SELECT COUNT(*) FROM evaluation"))[0];
$avg_rating     = mysqli_fetch_row(mysqli_query($conn, "SELECT ROUND(AVG(rating),1) FROM feedback"))[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard — Faculty Evaluation System</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="page-blob blob-1"></div>
<div class="page-blob blob-2"></div>
<div class="page-wrapper">
  <?php include("../includes/header.php"); ?>

  <div class="main-content">
    <div class="back-bar">
      <span class="breadcrumb"><span class="current">Admin Dashboard</span></span>
    </div>

    <!-- Hero Banner -->
    <div class="hero-banner">
      <h1>Welcome back, <?= htmlspecialchars($_SESSION['admin']) ?> 🎉</h1>
      <p>Here's what's happening in the Faculty Evaluation System today.</p>
      <div class="hero-meta">
        <span class="hero-chip">📊 <?= $total_feedback ?> Total Submissions</span>
        <span class="hero-chip">⭐ <?= $avg_rating ?: 'N/A' ?> Avg Rating</span>
      </div>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
      <div class="stat-card green">
        <div class="stat-icon green">👤</div>
        <div class="stat-info"><p>Total Faculty</p><h3><?= $total_faculty ?></h3></div>
      </div>
      <div class="stat-card pink">
        <div class="stat-icon pink">🎓</div>
        <div class="stat-info"><p>Total Students</p><h3><?= $total_students ?></h3></div>
      </div>
      <div class="stat-card green">
        <div class="stat-icon green">✍️</div>
        <div class="stat-info"><p>Feedback Submitted</p><h3><?= $total_feedback ?></h3></div>
      </div>
      <div class="stat-card pink">
        <div class="stat-icon pink">⭐</div>
        <div class="stat-info"><p>Average Rating</p><h3><?= $avg_rating ?: 'N/A' ?></h3></div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="card mb-3">
      <div class="card-title">⚡ Quick Actions</div>
      <div class="action-grid">
        <a href="add_faculty.php" class="action-card">
          <div class="action-card-icon">➕</div>
          <div class="action-card-label">Add Faculty</div>
        </a>
        <a href="manage_faculty.php" class="action-card">
          <div class="action-card-icon">👥</div>
          <div class="action-card-label">Manage Faculty</div>
        </a>
        <a href="view_feedback.php" class="action-card">
          <div class="action-card-icon">📋</div>
          <div class="action-card-label">View Feedback</div>
        </a>
        <a href="../logout.php" class="action-card pink">
          <div class="action-card-icon">🚪</div>
          <div class="action-card-label">Logout</div>
        </a>
      </div>
    </div>

    <!-- Recent Feedback -->
    <div class="card">
      <div class="card-title">📝 Recent Feedback</div>
      <?php
      $recent = mysqli_query($conn,
        "SELECT faculty.name, faculty.subject, feedback.rating, feedback.comments
         FROM feedback JOIN faculty ON feedback.faculty_id = faculty.id
         ORDER BY feedback.id DESC LIMIT 5");
      ?>
      <?php if (mysqli_num_rows($recent) > 0): ?>
      <div class="table-wrap">
        <table>
          <thead><tr><th>Faculty</th><th>Subject</th><th>Rating</th><th>Comment</th></tr></thead>
          <tbody>
            <?php while ($row = mysqli_fetch_assoc($recent)):
              $badge = $row['rating'] >= 4 ? 'badge-green' : ($row['rating'] == 3 ? 'badge-amber' : 'badge-red'); ?>
            <tr>
              <td class="font-bold"><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['subject']) ?></td>
              <td><span class="badge <?= $badge ?>"><?= str_repeat('★',$row['rating']) ?> <?= $row['rating'] ?>/5</span></td>
              <td style="font-size:13px; color:var(--text-hint)">
                <?= $row['comments'] ? htmlspecialchars(substr($row['comments'],0,60)).'...' : '—' ?>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
      <div class="mt-2"><a href="view_feedback.php" class="btn btn-outline btn-sm">View All Feedback →</a></div>
      <?php else: ?>
        <div class="alert alert-info">No feedback submitted yet.</div>
      <?php endif; ?>
    </div>

  </div>
  <?php include("../includes/footer.php"); ?>
</div>
</body>
</html>