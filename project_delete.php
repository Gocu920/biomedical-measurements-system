<?php
session_start();

$ide=$_GET['id'];
$id=$_SESSION["current_user"];
$servername="mysql.agh.edu.pl";
$username="mateuszg";
$dbpassword="bEc7VBm5USh09AEH";
$dbname="mateuszg";
$dbconn=mysqli_connect($servername, $username, $dbpassword, $dbname);
$query=mysqli_query($dbconn, "DELETE FROM pomiary WHERE pomiary.ID_pomiary='$ide'");
$row=mysqli_fetch_assoc($query);
var_dump($row);
header("Location: project_dropdown.php");
?>

