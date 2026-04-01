<?php
session_start();
if (isset($_SESSION['user_role'])) {
    switch ($_SESSION['user_role']) {
        case 'admin':   header("Location: admin/dashboard.php");   exit();
        case 'faculty': header("Location: faculty/dashboard.php"); exit();
        case 'student': header("Location: student/dashboard.php"); exit();
    }
}
header("Location: login.php");
exit();