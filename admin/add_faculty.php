<?php
session_start();
include("../config/db.php");
if (!isset($_SESSION['admin'])) { header("Location: ../login.php"); exit(); }
$_SESSION['name'] = $_SESSION['admin'];
$role = 'admin';
$success = false;
if (isset($_POST['submit'])) {
    $name    = $_POST['name'];
    $subject = $_POST['subject'];
    $query = "INSERT INTO faculty (name, subject) VALUES ('$name', '$subject')";
    mysqli_query($conn, $query);
    $success = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Faculty — Faculty Evaluation System</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="page-wrapper">
  <?php include("../includes/header.php"); ?>

  <div class="back-bar">
    <a href="dashboard.php" class="back-link">&#8592; Back to Dashboard</a>
    <span class="breadcrumb">
      <a href="dashboard.php">Dashboard</a>
      <span class="sep">/</span>
      <span class="current">Add Faculty</span>
    </span>
  </div>

  <div class="page-header">
    <div>
      <h1>Add Faculty</h1>
      <p>Add a new faculty member to the system</p>
    </div>
    <a href="manage_faculty.php" class="btn btn-outline">View All Faculty</a>
  </div>

  <div style="max-width:540px;">
    <?php if ($success): ?>
      <div class="alert alert-success">&#10003; Faculty added successfully!</div>
    <?php endif; ?>
    <div class="card">
      <div class="card-title">&#128100; Faculty Details</div>
      <form method="POST" action="">
        <div class="form-group">
          <label class="form-label" for="name">Faculty Name</label>
          <input type="text" id="name" name="name" class="form-control" placeholder="Enter full name" required>
        </div>
        <div class="form-group">
          <label class="form-label" for="subject">Subject</label>
          <input type="text" id="subject" name="subject" class="form-control" placeholder="Enter subject name" required>
        </div>
        <div class="d-flex gap-3">
          <button type="submit" name="submit" class="btn btn-primary">+ Add Faculty</button>
          <a href="manage_faculty.php" class="btn btn-outline-gray">Cancel</a>
        </div>
      </form>
    </div>
  </div>

  <?php include("../includes/footer.php"); ?>
</div>
</body>
</html>