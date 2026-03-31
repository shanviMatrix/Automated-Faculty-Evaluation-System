<?php
session_start();
include("../config/db.php");
if (!isset($_SESSION['admin'])) { header("Location: ../login.php"); exit(); }
$_SESSION['name'] = $_SESSION['admin'];
$role = 'admin';
$id     = mysqli_real_escape_string($conn, $_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM faculty WHERE id='$id'");
$row    = mysqli_fetch_assoc($result);
if (isset($_POST['update'])) {
    $name    = mysqli_real_escape_string($conn, $_POST['name']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    mysqli_query($conn, "UPDATE faculty SET name='$name', subject='$subject' WHERE id='$id'");
    header("Location: manage_faculty.php"); exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Faculty — Faculty Evaluation System</title>
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
      <a href="manage_faculty.php" class="back-link">← Back to Faculty List</a>
      <span class="breadcrumb">
        <a href="dashboard.php">Dashboard</a>
        <span class="sep">/</span>
        <a href="manage_faculty.php">Manage Faculty</a>
        <span class="sep">/</span>
        <span class="current">Edit — <?= htmlspecialchars($row['name']) ?></span>
      </span>
    </div>

    <div class="page-header">
      <div>
        <h1>Edit Faculty ✏️</h1>
        <p>Updating details for <strong><?= htmlspecialchars($row['name']) ?></strong></p>
      </div>
    </div>

    <div style="max-width:560px;">
      <div class="card">
        <div class="card-title">✏️ Update Faculty Details</div>
        <form method="POST" action="">
          <div class="form-group">
            <label class="form-label" for="name">Faculty Name</label>
            <input type="text" id="name" name="name" class="form-control"
              value="<?= htmlspecialchars($row['name']) ?>" required>
          </div>
          <div class="form-group">
            <label class="form-label" for="subject">Subject</label>
            <input type="text" id="subject" name="subject" class="form-control"
              value="<?= htmlspecialchars($row['subject']) ?>" required>
          </div>
          <div class="d-flex gap-3">
            <button type="submit" name="update" class="btn btn-primary">✓ Save Changes</button>
            <a href="manage_faculty.php" class="btn btn-outline-gray">Cancel</a>
          </div>
        </form>
      </div>
    </div>

  </div>
  <?php include("../includes/footer.php"); ?>
</div>
</body>
</html>