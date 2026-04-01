<?php
session_start();
if (isset($_SESSION['user_role'])) {
    switch ($_SESSION['user_role']) {
        case 'admin':   header("Location: /faculty_eval/admin/dashboard.php");   exit();
        case 'faculty': header("Location: /faculty_eval/faculty/dashboard.php"); exit();
        case 'student': header("Location: /faculty_eval/student/dashboard.php"); exit();
    }
}
header("Location: /faculty_eval/login.php");
exit();