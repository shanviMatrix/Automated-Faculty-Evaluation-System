<?php
session_start();
include("../config/db.php");
if (!isset($_SESSION['admin'])) { header("Location: ../login.php"); exit(); }
$_SESSION['name'] = $_SESSION['admin'];
$role = 'admin';
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete']);
    mysqli_query($conn, "DELETE FROM faculty WHERE id='$id'");
    header("Location: manage_faculty.php"); exit();
}
$result = mysqli_query($conn, "SELECT * FROM faculty");
$total  = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Faculty — Faculty Evaluation System</title>
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
        <a href="dashboard.php">Dashboard</a>
        <span class="sep">/</span>
        <span class="current">Manage Faculty</span>
      </span>
    </div>

    <div class="page-header">
      <div>
        <h1>Manage Faculty 👥</h1>
        <p><?= $total ?> faculty member<?= $total!=1?'s':'' ?> in the system</p>
      </div>
      <a href="add_faculty.php" class="btn btn-primary">+ Add New Faculty</a>
    </div>

    <div class="card">
      <div class="card-title">👤 Faculty List</div>
      <?php if ($total > 0): ?>
      <div class="table-wrap">
        <table>
          <thead><tr><th>#</th><th>Name</th><th>Subject</th><th>Actions</th></tr></thead>
          <tbody>
            <?php $i=1; while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td style="color:var(--text-hint); font-size:13px"><?= $i++ ?></td>
              <td class="font-bold"><?= htmlspecialchars($row['name']) ?></td>
              <td><span class="badge badge-green"><?= htmlspecialchars($row['subject']) ?></span></td>
              <td>
                <div class="d-flex gap-2">
                  <a href="edit_faculty.php?id=<?= $row['id'] ?>" class="btn btn-outline btn-sm">✏️ Edit</a>
                  <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                     onclick="return confirm('Delete <?= htmlspecialchars($row['name']) ?>? This cannot be undone.')">
                    ✕ Delete
                  </a>
                </div>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
      <?php else: ?>
        <div class="alert alert-info">No faculty found. <a href="add_faculty.php" style="color:var(--green-deep); font-weight:700">Add one now →</a></div>
      <?php endif; ?>
    </div>

  </div>
  <?php include("../includes/footer.php"); ?>
</div>
</body>
</html>