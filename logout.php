<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
session_destroy();
header("Location: /faculty_eval/login.php");
exit();