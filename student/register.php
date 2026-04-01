<?php
include("../config/db.php");

$success = false;
$error   = '';

if (isset($_POST['register'])) {
    $name     = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email    = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = trim($_POST['password']);

    if (!$name || !$email || !$password) {
        $error = "Please fill in all fields.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        $check = mysqli_query($conn, "SELECT id FROM students WHERE email='$email'");
        if (mysqli_num_rows($check) > 0) {
            $error = "This email is already registered. Please login instead.";
        } else {
            mysqli_query($conn,
                "INSERT INTO students (name, email, password) VALUES ('$name', '$email', '$password')");
            $success = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Register — Faculty Evaluation System</title>
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
      <h2>Create Account</h2>
      <p>Register once and start giving feedback to your faculty members instantly.</p>
      <ul class="features">
        <li>Quick one-time registration</li>
        <li>Secure & private</li>
        <li>Access your dashboard</li>
        <li>Track all submissions</li>
      </ul>
    </div>

    <div class="login-panel-right">
      <h1>Student Registration ✨</h1>
      <p class="subtitle">Create your student account</p>

      <?php if ($success): ?>
        <div class="alert alert-success">✓ Registration successful! You can now login.</div>
        <a href="../login.php" class="btn btn-secondary btn-block">Go to Login →</a>
      <?php else: ?>

        <?php if ($error): ?>
          <div class="alert alert-danger">⚠️ <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
          <div class="form-group">
            <label class="form-label" for="name">Full Name</label>
            <input type="text" id="name" name="name" class="form-control"
              placeholder="Enter your full name"
              value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>"
              required>
          </div>
          <div class="form-group">
            <label class="form-label" for="email">Email Address</label>
            <input type="email" id="email" name="email" class="form-control"
              placeholder="Enter your college email"
              value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
              required>
          </div>
          <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control"
              placeholder="At least 6 characters" required>
          </div>
          <button type="submit" name="register" class="btn btn-secondary btn-block">Create Account</button>
        </form>

        <hr class="divider">
        <p class="text-center" style="font-size:13px; color:var(--text-hint);">
          Already have an account?
          <a href="../login.php" style="color:var(--green-deep); font-weight:700; text-decoration:none;">Login here →</a>
        </p>
      <?php endif; ?>
    </div>

  </div>
</div>
</body>
</html>