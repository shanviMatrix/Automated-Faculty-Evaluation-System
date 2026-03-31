<?php
session_start();
include("../config/db.php");

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = "SELECT * FROM students WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['student_id'] = $row['id'];
        header("Location: dashboard.php");
    } else {
        $error = "Invalid email or password. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Login — Faculty Evaluation System</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="login-page">
  <div class="login-split">

    <div class="login-panel-left">
      <div class="logo-mark">FE</div>
      <h2>Student Portal</h2>
      <p>Login to submit your feedback for faculty members and help improve teaching quality.</p>
      <ul class="features">
        <li>Submit faculty feedback</li>
        <li>Track your submissions</li>
        <li>Anonymous & secure</li>
        <li>Simple & fast process</li>
      </ul>
    </div>

    <div class="login-panel-right">
      <h1>Student Login</h1>
      <p class="subtitle">Sign in with your college email</p>

      <?php if (isset($error)): ?>
        <div class="alert alert-danger">&#9888; <?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST" action="">
        <div class="form-group">
          <label class="form-label" for="email">Email Address</label>
          <input type="text" id="email" name="email" class="form-control"
            placeholder="Enter your college email"
            value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
            required autocomplete="email">
        </div>
        <div class="form-group">
          <label class="form-label" for="password">Password</label>
          <input type="password" id="password" name="password" class="form-control"
            placeholder="Enter your password" required autocomplete="current-password">
        </div>
        <button type="submit" name="login" class="btn btn-secondary btn-block">Login to Portal</button>
      </form>

      <hr class="divider">
      <p class="text-center" style="font-size:13px; color:var(--text-hint);">
        New student?
        <a href="register.php" style="color:var(--secondary); font-weight:600; text-decoration:none;">Register here &rarr;</a>
      </p>
      <p class="text-center mt-1" style="font-size:13px; color:var(--text-hint);">
        <a href="../login.php" style="color:var(--text-secondary); text-decoration:none;">&#8592; Back to Admin Login</a>
      </p>
    </div>

  </div>
</div>
</body>
</html>