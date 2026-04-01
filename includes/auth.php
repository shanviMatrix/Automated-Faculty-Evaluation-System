<?php
function require_role($required_role) {
    if (session_status() === PHP_SESSION_NONE) {  // ← add this check
        session_start();
    }
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== $required_role) {
        header("Location: /faculty_eval/login.php");
        exit();
    }
}

function require_any_role(array $roles) {
    if (session_status() === PHP_SESSION_NONE) {  // ← add this check
        session_start();
    }
    if (!isset($_SESSION['user_role']) || !in_array($_SESSION['user_role'], $roles)) {
        header("Location: /faculty_eval/login.php");
        exit();
    }
}

function current_user_role()  { return $_SESSION['user_role']  ?? ''; }
function current_user_name()  { return $_SESSION['user_name']  ?? ''; }
function current_user_id()    { return $_SESSION['user_id']    ?? null; }