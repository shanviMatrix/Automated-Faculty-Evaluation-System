<?php
include("config/db.php");

// Redirect if already logged in
if (isset($_SESSION['user_role'])) {
    header("Location: " . get_dashboard_url($_SESSION['user_role']));
    exit();
}

function get_dashboard_url($role) {
    switch ($role) {
        case 'admin':   return 'admin/dashboard.php';
        case 'faculty': return 'faculty/dashboard.php';
        case 'student': return 'student/dashboard.php';
        default:        return 'login.php';
    }
}

$error = '';

if (isset($_POST['login'])) {
    $role     = $_POST['role'] ?? '';
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = trim($_POST['password']);

    if (empty($username) || empty($password) || empty($role)) {
        $error = "Please fill in all fields.";
    } else {
        if ($role === 'admin') {
            $result = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");
            $user   = mysqli_fetch_assoc($result);
            if ($user && $password === $user['password']) {
                $_SESSION['user_role']  = 'admin';
                $_SESSION['user_id']    = $user['id'];
                $_SESSION['user_name']  = $user['username'];
                header("Location: admin/dashboard.php");
                exit();
            } else {
                $error = "Invalid admin credentials.";
            }

        } elseif ($role === 'faculty') {
            $result = mysqli_query($conn, "SELECT * FROM faculty WHERE email='$username'");
            $user   = mysqli_fetch_assoc($result);
            if ($user && $password === $user['password']) {
                $_SESSION['user_role']  = 'faculty';
                $_SESSION['user_id']    = $user['id'];
                $_SESSION['user_name']  = $user['name'];
                header("Location: faculty/dashboard.php");
                exit();
            } else {
                $error = "Invalid faculty credentials.";
            }

        } elseif ($role === 'student') {
            $result = mysqli_query($conn, "SELECT * FROM students WHERE email='$username'");
            $user   = mysqli_fetch_assoc($result);
            if ($user && $password === $user['password']) {
                $_SESSION['user_role']  = 'student';
                $_SESSION['user_id']    = $user['id'];
                $_SESSION['user_name']  = $user['name'];
                header("Location: student/dashboard.php");
                exit();
            } else {
                $error = "Invalid student credentials.";
            }
        } else {
            $error = "Please select a valid role.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login — Faculty Evaluation System</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <style>
    .role-tabs {
      display: flex;
      background: var(--surface-2);
      border: 1.5px solid var(--border);
      border-radius: var(--radius-sm);
      padding: 4px;
      gap: 4px;
      margin-bottom: 24px;
    }
    .role-tab {
      flex: 1;
      padding: 9px 8px;
      border: none;
      border-radius: 6px;
      background: transparent;
      font-family: var(--font-body);
      font-size: 13px;
      font-weight: 600;
      color: var(--text-hint);
      cursor: pointer;
      transition: var(--transition);
      text-align: center;
    }
    .role-tab.active {
      background: white;
      color: var(--text-primary);
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .role-tab.active.admin  { color: var(--green-deep); }
    .role-tab.active.faculty { color: #7c3aed; }
    .role-tab.active.student { color: var(--pink-deep); }
  </style>
</head>
<body>
<div class="login-page">
  <div class="login-split">

    <div class="login-panel-left">
      <div class="logo-mark">FE</div>
      <h2>Faculty Evaluation System</h2>
      <p>A smart platform to collect and analyse student feedback on faculty performance.</p>
      <ul class="features">
        <li>Single unified login</li>
        <li>Admin, Faculty & Student portals</li>
        <li>View detailed feedback reports</li>
        <li>Real-time ratings & analytics</li>
      </ul>
    </div>

    <div class="login-panel-right">
      <h1>Welcome back 👋</h1>
      <p class="subtitle">Sign in to your account</p>

      <?php if ($error): ?>
        <div class="alert alert-danger">⚠️ <?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <!-- Role Selector Tabs -->
      <div class="role-tabs" id="roleTabs">
        <button type="button" class="role-tab admin active" onclick="selectRole('admin')">🛡️ Admin</button>
        <button type="button" class="role-tab faculty"     onclick="selectRole('faculty')">🏫 Faculty</button>
        <button type="button" class="role-tab student"     onclick="selectRole('student')">🎓 Student</button>
      </div>

      <form method="POST" action="">
        <input type="hidden" name="role" id="roleInput" value="<?= htmlspecialchars($_POST['role'] ?? 'admin') ?>">

        <div class="form-group">
          <label class="form-label" id="usernameLabel" for="username">Username</label>
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
        <button type="submit" name="login" class="btn btn-primary btn-block" id="loginBtn">
          Login to Dashboard
        </button>
      </form>

      <hr class="divider">
      <p class="text-center" style="font-size:13px; color:var(--text-hint);">
        New student?
        <a href="student/register.php" style="color:var(--pink); font-weight:700; text-decoration:none;">Register here →</a>
      </p>
    </div>

  </div>
</div>

<script>
  const roleConfig = {
    admin:   { label: 'Username',      placeholder: 'Enter admin username', btnText: 'Login as Admin' },
    faculty: { label: 'Email Address', placeholder: 'Enter faculty email',   btnText: 'Login as Faculty' },
    student: { label: 'Email Address', placeholder: 'Enter student email',   btnText: 'Login as Student' },
  };

  function selectRole(role) {
    document.getElementById('roleInput').value = role;
    document.querySelectorAll('.role-tab').forEach(t => t.classList.remove('active'));
    document.querySelector('.role-tab.' + role).classList.add('active');

    const cfg = roleConfig[role];
    document.getElementById('usernameLabel').textContent = cfg.label;
    document.getElementById('username').placeholder       = cfg.placeholder;
    document.getElementById('username').type              = (role === 'admin') ? 'text' : 'email';
    document.getElementById('loginBtn').textContent       = cfg.btnText;
  }

  // Init on load (restore selected role if form was submitted)
  const savedRole = document.getElementById('roleInput').value || 'admin';
  selectRole(savedRole);
</script>
</body>
</html>