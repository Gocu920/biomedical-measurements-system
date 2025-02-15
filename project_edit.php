<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>...:::Edycja pomiaru:::...</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <?php
$ide=$_GET['id'];
$id=$_SESSION["current_user"];
$servername="mysql.agh.edu.pl";
$username="mateuszg";
$dbpassword="bEc7VBm5USh09AEH";
$dbname="mateuszg";
$dbconn=mysqli_connect($servername, $username, $dbpassword, $dbname);
$query=mysqli_query($dbconn, "SELECT pomiary.ID_pomiary, pomiary.measure_date_time, rodzaje_badan.nazwa_badania, pomiary.Wartość FROM pomiary 
LEFT JOIN rodzaje_badan ON pomiary.rodzaj_pomiaru_ID = rodzaje_badan.rodzaj_pomiaru_ID WHERE pomiary.ID_pomiary='$ide'");
$row=mysqli_fetch_assoc($query);
// var_dump($row);
?>
<form method="POST" action="project_update_table.php?id=<?php echo $ide; ?>">
<br>Data wykonania pomiaru:</br>
<input type="datetime-local" name="measuredate" value="<?php echo $row['measure_date_time']; ?>">
<br>Nazwa badania:</br>
<input type="text" name="nazwa_badania" value="<?php echo $row['nazwa_badania']; ?>">
<br>Wartość:</br>
<input type="text" name="wartość" value="<?php echo $row['Wartość']; ?>"><br/>
<br>
<input type="submit" name="potwierdzenie" class="button" value="Potwierdź zmiany"><br>
</body>
</html>
