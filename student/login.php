<?php
session_start();
include("config/db.php");

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
        $_SESSION['admin'] = $username;
        header("Location: admin/dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login — Faculty Evaluation System</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="login-page">
  <div class="login-split">

    <div class="login-panel-left">
      <div class="logo-mark">FE</div>
      <h2>Faculty Evaluation System</h2>
      <p>A smart platform to collect and analyse student feedback on faculty performance.</p>
      <ul class="features">
        <li>Secure admin dashboard</li>
        <li>Manage faculty records</li>
        <li>View detailed feedback reports</li>
        <li>Real-time ratings & analytics</li>
      </ul>
    </div>

    <div class="login-panel-right">
      <h1>Welcome back 👋</h1>
      <p class="subtitle">Sign in to your Admin account</p>

      <?php if (isset($error)): ?>
        <div class="alert alert-danger">⚠️ <?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST" action="">
        <div class="form-group">
          <label class="form-label" for="username">Username</label>
          <input type="text" id="username" name="username" class="form-control"
            placeholder="Enter your username"
            value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>"
            required autocomplete="username">
        </div>
        <div class="form-group">
          <label class="form-label" for="password">Password</label>
          <input type="password" id="password" name="password" class="form-control"
            placeholder="Enter your password" required autocomplete="current-password">
        </div>
        <button type="submit" name="login" class="btn btn-primary btn-block">Login to Dashboard</button>
      </form>

      <hr class="divider">
      <p class="text-center" style="font-size:13px; color:var(--text-hint);">
        Are you a student?
        <a href="student/login.php" style="color:var(--pink); font-weight:700; text-decoration:none;">Student login →</a>
      </p>
    </div>

  </div>
</div>
</body>
</html>