<?php
session_start();
include("../config/db.php");
if (!isset($_SESSION['admin'])) { header("Location: ../login.php"); exit(); }
$_SESSION['name'] = $_SESSION['admin'];
$role = 'admin';
$query = "SELECT faculty.name, faculty.subject, feedback.rating, feedback.comments
          FROM feedback JOIN faculty ON feedback.faculty_id = faculty.id ORDER BY feedback.id DESC";
$result = mysqli_query($conn, $query);
$total  = mysqli_num_rows($result);
$summary_query = mysqli_query($conn,
  "SELECT faculty.name, faculty.subject, COUNT(feedback.id) AS total_reviews, ROUND(AVG(feedback.rating),1) AS avg_rating
   FROM faculty LEFT JOIN feedback ON feedback.faculty_id = faculty.id
   GROUP BY faculty.id ORDER BY avg_rating DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Feedback — Faculty Evaluation System</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="page-wrapper">
  <?php include("../includes/header.php"); ?>
  <div class="main-content">

    <div class="back-bar">
      <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
      <span class="breadcrumb">
        <span class="sep">/</span>
        <span class="current">Feedback Report</span>
      </span>
    </div>

    <div class="page-header">
      <div>
        <h1>Feedback Report 📊</h1>
        <p><?= $total ?> total submission<?= $total!=1?'s':'' ?></p>
      </div>
    </div>

    <!-- Rating Summary -->
    <div class="card mb-3">
      <div class="card-title">⭐ Faculty Rating Summary</div>
      <div class="table-wrap">
        <table>
          <thead><tr><th>#</th><th>Faculty Name</th><th>Subject</th><th>Total Reviews</th><th>Average Rating</th></tr></thead>
          <tbody>
            <?php $i=1; while ($s = mysqli_fetch_assoc($summary_query)):
              $avg   = $s['avg_rating'];
              $badge = $avg >= 4 ? 'badge-green' : ($avg < 3 ? 'badge-red' : 'badge-amber'); ?>
            <tr>
              <td style="color:var(--text-hint); font-size:13px"><?= $i++ ?></td>
              <td class="font-bold"><?= htmlspecialchars($s['name']) ?></td>
              <td><?= htmlspecialchars($s['subject']) ?></td>
              <td><span class="badge badge-pink"><?= $s['total_reviews'] ?> review<?= $s['total_reviews']!=1?'s':'' ?></span></td>
              <td>
                <?php if ($s['avg_rating']): ?>
                  <span class="badge <?= $badge ?>"><?= str_repeat('★', round($avg)) ?> <?= $avg ?> / 5</span>
                <?php else: ?>
                  <span style="color:var(--text-hint); font-size:13px">No reviews yet</span>
                <?php endif; ?>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- All Submissions -->
    <div class="card">
      <div class="card-title">📋 All Feedback Submissions</div>
      <?php if ($total > 0): ?>
      <div class="table-wrap">
        <table>
          <thead><tr><th>#</th><th>Faculty Name</th><th>Subject</th><th>Rating</th><th>Comments</th></tr></thead>
          <tbody>
            <?php $i=1; while ($row = mysqli_fetch_assoc($result)):
              $badge = $row['rating'] >= 4 ? 'badge-green' : ($row['rating'] < 3 ? 'badge-red' : 'badge-amber'); ?>
            <tr>
              <td style="color:var(--text-hint); font-size:13px"><?= $i++ ?></td>
              <td class="font-bold"><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['subject']) ?></td>
              <td><span class="badge <?= $badge ?>"><?= str_repeat('★',$row['rating']) ?> <?= $row['rating'] ?>/5</span></td>
              <td style="font-size:13px; color:var(--text-secondary); max-width:280px">
                <?= $row['comments'] ? htmlspecialchars($row['comments']) : '<span style="color:var(--text-hint)">No comment</span>' ?>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
      <?php else: ?>
        <div class="alert alert-info">No feedback submitted yet.</div>
      <?php endif; ?>
    </div>

  </div>
  <?php include("../includes/footer.php"); ?>
</div>
</body>
</html>