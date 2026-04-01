<?php
require_once("../includes/auth.php");
require_role('admin');

include("../config/db.php");

$success = false;

if (isset($_POST['submit'])) {
    $name    = mysqli_real_escape_string($conn, trim($_POST['name']));
    $subject = mysqli_real_escape_string($conn, trim($_POST['subject']));
    $email   = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = trim($_POST['password']); 

    if ($name && $subject) {
        mysqli_query($conn, "INSERT INTO faculty (name, subject, email, password) VALUES ('$name', '$subject', '$email', '$password')");
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Faculty — Faculty Evaluation System</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
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
          <div class="form-group">
            <label class="form-label" for="email">Email <span style="color:var(--text-hint); font-weight:400">(for faculty login)</span></label>
            <input type="email" id="email" name="email" class="form-control" placeholder="Enter faculty email">
          </div>
          <div class="form-group">
            <label class="form-label" for="password">Default Password</label>
            <input type="text" id="password" name="password" class="form-control" placeholder="Set a default password">
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