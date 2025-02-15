<?php
$ide=$_GET['id'];
$id=$_SESSION["current_user"];
$servername="mysql.agh.edu.pl";
$username="mateuszg";
$dbpassword="bEc7VBm5USh09AEH";
$dbname="mateuszg";
$dbconn=mysqli_connect($servername, $username, $dbpassword, $dbname);
$measuredate=$_POST['measuredate'];
$nazwabadania=$_POST['nazwa_badania'];
$wartość=$_POST['wartość'];
mysqli_query($dbconn,"UPDATE pomiary set measure_date_time='$measuredate', Wartość='$wartość' WHERE ID_pomiary='$ide'");
// mysqli_query($dbconn,"UPDATE rodzaje_badan set nazwa_badania='$nazwabadania' WHERE pomiary.rodzaj_pomiaru_ID = rodzaje_badan.rodzaj_pomiaru_ID");
header("Location: project_dropdown.php");
?>