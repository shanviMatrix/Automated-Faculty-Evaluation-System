<?php
require_once("../includes/auth.php");
require_role('student');

include("../config/db.php");

$student_id  = current_user_id();
$message     = "";
$preselected = isset($_GET['faculty_id']) ? (int)$_GET['faculty_id'] : 0;

if (isset($_POST['submit'])) {
    $faculty_id = (int)$_POST['faculty_id'];
    $rating     = (int)$_POST['rating'];
    $comments   = mysqli_real_escape_string($conn, trim($_POST['comments']));

    if ($rating < 1 || $rating > 5) {
        $message = "Please select a valid rating between 1 and 5.";
    } else {
        $check = mysqli_query($conn,
            "SELECT id FROM feedback WHERE student_id=$student_id AND faculty_id=$faculty_id");
        if (mysqli_num_rows($check) > 0) {
            $message = "You have already submitted feedback for this faculty!";
        } else {
            mysqli_query($conn,
                "INSERT INTO feedback (student_id, faculty_id, rating, comments)
                 VALUES ($student_id, $faculty_id, $rating, '$comments')");
            header("Location: dashboard.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Give Feedback — Faculty Evaluation System</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="page-wrapper">
  <?php include("../includes/header.php"); ?>

    <div class="back-bar">
      <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
      <span class="breadcrumb">
        <span class="sep">/</span>
        <span class="current">Give Feedback</span>
      </span>
    </div>

    <div class="page-header">
      <div>
        <h1>Give Feedback ✍️</h1>
        <p>Your feedback is anonymous and helps improve teaching quality</p>
      </div>
    </div>

    <div style="max-width:640px;">
      <?php if ($message): ?>
        <div class="alert alert-danger">⚠️ <?= htmlspecialchars($message) ?></div>
      <?php endif; ?>

      <div class="card">
        <div class="card-title">📝 Feedback Form</div>
        <form method="POST" action="">
          <div class="form-group">
            <label class="form-label" for="faculty_id">Select Faculty</label>
            <select name="faculty_id" id="faculty_id" class="form-control" required>
              <option value="">— Choose a faculty member —</option>
              <?php
              $faculty_result = mysqli_query($conn, "SELECT * FROM faculty");
              while ($row = mysqli_fetch_assoc($faculty_result)) {
                  $sel = ($preselected == $row['id'] || (isset($_POST['faculty_id']) && $_POST['faculty_id'] == $row['id'])) ? 'selected' : '';
                  echo "<option value='" . (int)$row['id'] . "' $sel>"
                      . htmlspecialchars($row['name']) . " — " . htmlspecialchars($row['subject'])
                      . "</option>";
              }
              ?>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label">Rating</label>
            <div class="stars">
              <?php $cr = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
              for ($i = 5; $i >= 1; $i--): ?>
              <input type="radio" name="rating" id="star<?= $i ?>" value="<?= $i ?>" <?= $cr == $i ? 'checked' : '' ?>>
              <label for="star<?= $i ?>">★</label>
              <?php endfor; ?>
            </div>
            <p style="font-size:12px; color:var(--text-hint); margin-top:8px;">1 = Poor &nbsp;&nbsp; 5 = Excellent</p>
          </div>

          <div class="form-group">
            <label class="form-label" for="comments">
              Comments <span style="color:var(--text-hint); font-weight:400">(optional)</span>
            </label>
            <textarea name="comments" id="comments" class="form-control"
              placeholder="Share your thoughts about this faculty member..."
              rows="4"><?= isset($_POST['comments']) ? htmlspecialchars($_POST['comments']) : '' ?></textarea>
          </div>

          <div class="d-flex gap-3">
            <button type="submit" name="submit" class="btn btn-secondary">✓ Submit Feedback</button>
            <a href="dashboard.php" class="btn btn-outline-gray">Cancel</a>
          </div>
        </form>
      </div>
    </div>

  <?php include("../includes/footer.php"); ?>
</div>
</body>
</html>