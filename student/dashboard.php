<?php
session_start();
include("../config/db.php");
if (!isset($_SESSION['student_id'])) { header("Location: login.php"); exit(); }
$student_id = $_SESSION['student_id'];
$student_query = mysqli_query($conn, "SELECT * FROM students WHERE id='$student_id'");
$student = mysqli_fetch_assoc($student_query);
$_SESSION['name'] = $student['name'];
$role = 'student';
$faculty_query = mysqli_query($conn, "SELECT * FROM faculty");
$feedback_query = mysqli_query($conn, "SELECT faculty_id FROM feedback WHERE student_id='$student_id'");
$submitted = [];
while ($row = mysqli_fetch_assoc($feedback_query)) { $submitted[] = $row['faculty_id']; }
$total_faculty   = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM faculty"));
$total_submitted = count($submitted);
$pending         = $total_faculty - $total_submitted;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Dashboard — Faculty Evaluation System</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="page-wrapper">
  <?php include("../includes/header.php"); ?>

  <!-- Back bar -->
  <div class="back-bar">
    <span class="breadcrumb">
      <a href="../index.php">Home</a>
      <span class="sep">/</span>
      <span class="current">Student Dashboard</span>
    </span>
  </div>

  <div class="page-header">
    <div>
      <h1>Welcome, <?= htmlspecialchars($student['name']) ?> &#128075;</h1>
      <p>Here is your feedback overview for this semester</p>
    </div>
    <a href="feedback.php" class="btn btn-secondary">+ Give Feedback</a>
  </div>

  <div class="stats-grid">
    <div class="stat-card">
      <div class="stat-icon blue">&#128100;</div>
      <div class="stat-info"><p>Total Faculty</p><h3><?= $total_faculty ?></h3></div>
    </div>
    <div class="stat-card">
      <div class="stat-icon green">&#10003;</div>
      <div class="stat-info"><p>Submitted</p><h3><?= $total_submitted ?></h3></div>
    </div>
    <div class="stat-card">
      <div class="stat-icon amber">&#9203;</div>
      <div class="stat-info"><p>Pending</p><h3><?= $pending ?></h3></div>
    </div>
  </div>

  <div class="card">
    <div class="card-title">&#9997; Faculty Feedback Status</div>
    <?php mysqli_data_seek($faculty_query, 0); ?>
    <?php if (mysqli_num_rows($faculty_query) > 0): ?>
    <div class="table-wrap">
      <table>
        <thead>
          <tr><th>#</th><th>Faculty Name</th><th>Subject</th><th>Status</th><th>Action</th></tr>
        </thead>
        <tbody>
          <?php $i=1; while ($f = mysqli_fetch_assoc($faculty_query)): $done = in_array($f['id'], $submitted); ?>
          <tr>
            <td><?= $i++ ?></td>
            <td class="font-bold"><?= htmlspecialchars($f['name']) ?></td>
            <td><span class="badge badge-blue"><?= htmlspecialchars($f['subject']) ?></span></td>
            <td>
              <?php if ($done): ?>
                <span class="badge badge-green">&#10003; Submitted</span>
              <?php else: ?>
                <span class="badge badge-amber">&#9203; Pending</span>
              <?php endif; ?>
            </td>
            <td>
              <?php if ($done): ?>
                <span style="font-size:13px; color:var(--text-hint)">Already submitted</span>
              <?php else: ?>
                <a href="feedback.php?faculty_id=<?= $f['id'] ?>" class="btn btn-secondary btn-sm">Give Feedback</a>
              <?php endif; ?>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
    <?php else: ?>
      <div class="alert alert-info">No faculty found. Please check back later.</div>
    <?php endif; ?>
  </div>

  <?php include("../includes/footer.php"); ?>
</div>
</body>
</html>