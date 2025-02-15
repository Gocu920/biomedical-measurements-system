<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>...:::Dodawanie parametrów i jednostek:::...</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
<?php
// var_dump(isset($_POST['save_new_parameters']));

$servername="mysql.agh.edu.pl";
$username="mateuszg";
$dbpassword="bEc7VBm5USh09AEH";
$dbname="mateuszg";

$dbconn=mysqli_connect($servername, $username, $dbpassword, $dbname);
if (isset($_POST["save_new_parameters"])){
    if(empty($_POST['parameter_name']) or empty($_POST['unit_name'])){
        if(empty($_POST['parameter_name']))
    {
        echo "Musisz podać nazwę parametru!";?><br><?php
    }
    if(empty($_POST['unit_name'])){
        echo "Musisz podać nazwę jednostki!";
    }
    // header("Location: project_add_new_unit.php");
        // echo "<br>".$Err1."<br>".$Err2;
    }else{
    $unit=$_POST['unit_name'];
    // var_dump($unit);
    $par_name=$_POST['parameter_name'];
    $unit_query=mysqli_query($dbconn,"INSERT INTO jednostki (Rodzaj_jednostki) VALUES ('$unit')");
    // var_dump($unit_query);
    $query_ID=mysqli_query($dbconn,"SELECT * FROM jednostki WHERE jednostki_ID = (SELECT MAX(jednostki_ID) FROM jednostki)");
    $record3 = mysqli_fetch_assoc($query_ID);
    // var_dump($record3);
    $z=$record3["jednostki_ID"];
    $measure_query=mysqli_query($dbconn,"INSERT INTO rodzaje_badan (nazwa_badania,jednostki_ID) VALUES ('$par_name','$z')");
    echo "Parametr dopisany!";
}
}
if(isset($_POST["return"]))
{
    header("Location: project_dropdown.php");
}
// $_SESSION['save']=$_POST['save_new_parameters'];
// $_SESSION['unit_name']=$_POST['unit_name'];
// $_SESSION['parameter_name']=$_POST['parameter_name'];
//var_dump(empty($_POST["parameter_name"]));
// if(empty($_POST["parameter_name"]))
// {
//     echo "Musisz podać nazwę parametru!";
// }
// if(empty($_POST["unit_name"]))
// {
//     echo "Musisz podać nazwę jednostki!";
// }
// if(empty($_POST["parameter_name"]) and empty($_POST["unit_name"]))
    // {
    //     echo "Musisz podać nazwę parametru oraz jednostki!";
    // }
?>
<form method="POST" action="project_add_new_unit.php">
<label for="parameter_name">Nazwa parametru:</label><br>
<input type="text" name="parameter_name"><br/>
<label for="unit_name">Nazwa jednostki:</label><br>
<input type="text" name="unit_name"><br/>
<br/>
<input type="submit" name="save_new_parameters" class="button" value="Zapisz nowe parametry">
<input type="submit" name="return" class="button" value="Powrót do strony głównej">
</form>
</body>
</html>