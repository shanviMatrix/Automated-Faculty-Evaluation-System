<?php
session_start();
include("../config/db.php");

if(isset($_POST['login'])){
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $query    = "SELECT * FROM faculty WHERE email='$email' AND password='$password'";
    $result   = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
        $_SESSION['faculty_id']   = $row['id'];
        $_SESSION['faculty_name'] = $row['name'];
        header("Location: dashboard.php");
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Faculty Login — Faculty Evaluation System</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="login-page">
  <div class="login-split">

    <div class="login-panel-left">
      <div class="logo-mark">FE</div>
      <h2>Faculty Portal</h2>
      <p>Login to view student feedback and track your teaching performance.</p>
      <ul class="features">
        <li>View all student feedback</li>
        <li>Track your ratings</li>
        <li>Improve your teaching</li>
        <li>Secure & private portal</li>
      </ul>
    </div>

    <div class="login-panel-right">
      <h1>Faculty Login 🏫</h1>
      <p class="subtitle">Sign in with your faculty credentials</p>

      <?php if (isset($error)): ?>
        <div class="alert alert-danger">⚠️ <?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST" action="">
        <div class="form-group">
          <label class="form-label" for="email">Email Address</label>
          <input type="email" id="email" name="email" class="form-control"
            placeholder="Enter your email" required autocomplete="email">
        </div>
        <div class="form-group">
          <label class="form-label" for="password">Password</label>
          <input type="password" id="password" name="password" class="form-control"
            placeholder="Enter your password" required autocomplete="current-password">
        </div>
        <button type="submit" name="login" class="btn btn-primary btn-block">Login to Portal</button>
      </form>

      <hr class="divider">
      <p class="text-center" style="font-size:13px; color:var(--text-hint);">
        <a href="../login.php" style="color:var(--text-secondary); text-decoration:none;">← Back to Admin Login</a>
      </p>
    </div>

  </div>
</div>
</body>
</html>