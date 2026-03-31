<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['faculty_id'])){
    header("Location: login.php");
    exit();
}

$faculty_id = $_SESSION['faculty_id'];

// Fetch feedback for this faculty
$query = "SELECT * FROM feedback WHERE faculty_id='$faculty_id'";
$result = mysqli_query($conn, $query);
?>

<h2>Welcome <?php echo $_SESSION['faculty_name']; ?></h2>

<a href="logout.php">Logout</a>

<h3>Student Feedback</h3>

<table border="1" cellpadding="10">
<tr>
    <th>Rating</th>
    <th>Comments</th>
    <th>Date</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?php echo $row['rating']; ?></td>
    <td><?php echo $row['comments']; ?></td>
    <td><?php echo $row['created_at']; ?></td>
</tr>
<?php } ?>

</table>