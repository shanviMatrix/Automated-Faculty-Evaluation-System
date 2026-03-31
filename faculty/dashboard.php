<?php
session_start();
include("../config/db.php");
if(!isset($_SESSION['faculty_id'])){ header("Location: login.php"); exit(); }
$faculty_id = $_SESSION['faculty_id'];
$query  = "SELECT * FROM feedback WHERE faculty_id='$faculty_id'";
$result = mysqli_query($conn, $query);
$total  = mysqli_num_rows($result);
$avg_q  = mysqli_fetch_row(mysqli_query($conn, "SELECT ROUND(AVG(rating),1) FROM feedback WHERE faculty_id='$faculty_id'"));
$avg    = $avg_q[0] ?: 'N/A';
$_SESSION['name'] = $_SESSION['faculty_name'];
$role = 'faculty';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Faculty Dashboard — Faculty Evaluation System</title>
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

    <!-- Hero Banner -->
    <div class="hero-banner">
      <h1>Welcome, <?= htmlspecialchars($_SESSION['faculty_name']) ?> 🌟</h1>
      <p>Here's what students are saying about your teaching.</p>
      <div class="hero-meta">
        <span class="hero-chip">📝 <?= $total ?> Total Reviews</span>
        <span class="hero-chip">⭐ <?= $avg ?> Avg Rating</span>
      </div>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
      <div class="stat-card green">
        <div class="stat-icon green">📝</div>
        <div class="stat-info"><p>Total Reviews</p><h3><?= $total ?></h3></div>
      </div>
      <div class="stat-card pink">
        <div class="stat-icon pink">⭐</div>
        <div class="stat-info"><p>Average Rating</p><h3><?= $avg ?></h3></div>
      </div>
    </div>

    <!-- Feedback Table -->
    <div class="card">
      <div class="card-title">💬 Student Feedback</div>
      <?php if ($total > 0):
        mysqli_data_seek($result, 0); ?>
      <div class="table-wrap">
        <table>
          <thead><tr><th>#</th><th>Rating</th><th>Comments</th><th>Date</th></tr></thead>
          <tbody>
            <?php $i=1; while($row = mysqli_fetch_assoc($result)):
              $badge = $row['rating'] >= 4 ? 'badge-green' : ($row['rating'] < 3 ? 'badge-red' : 'badge-amber'); ?>
            <tr>
              <td style="color:var(--text-hint)"><?= $i++ ?></td>
              <td><span class="badge <?= $badge ?>"><?= str_repeat('★',$row['rating']) ?> <?= $row['rating'] ?>/5</span></td>
              <td style="font-size:13px; color:var(--text-secondary)">
                <?= $row['comments'] ? htmlspecialchars($row['comments']) : '<span style="color:var(--text-hint)">No comment</span>' ?>
              </td>
              <td style="font-size:12px; color:var(--text-hint)"><?= $row['created_at'] ?></td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
      <?php else: ?>
        <div class="alert alert-info">No feedback submitted yet for you.</div>
      <?php endif; ?>
    </div>

    <div class="mt-2">
      <a href="logout.php" class="btn btn-danger">🚪 Logout</a>
    </div>

  </div>
  <?php include("../includes/footer.php"); ?>
</div>
</body>
</html>