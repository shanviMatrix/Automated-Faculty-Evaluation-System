<?php
session_start();
include("../config/db.php");

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM faculty WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
        $_SESSION['faculty_id'] = $row['id'];
        $_SESSION['faculty_name'] = $row['name'];
        header("Location: dashboard.php");
    } else {
        echo "Invalid login!";
    }
}
?>

<form method="POST">
    <h2>Faculty Login</h2>
    <input type="email" name="email" placeholder="Enter email" required><br><br>
    <input type="password" name="password" placeholder="Enter password" required><br><br>
    <button name="login">Login</button>
</form>