<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>...:::Pomiary:::...</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <?php
$servername="mysql.agh.edu.pl";
$username="mateuszg";
$dbpassword="bEc7VBm5USh09AEH";
$dbname="mateuszg";
$id=$_SESSION["current_user"];
$dbconn=mysqli_connect($servername, $username, $dbpassword, $dbname);
if(isset($_POST['confirm_measure'])){
    if (empty($_POST["pomiar"])) {
        echo "Musisz podac wartość!";
    }
     else {
    $value=$_POST["pomiar"];
    $category=$_POST["lista"];
   // var_dump($category["lista"]);
    // $category=$_SESSION["category"];
    // var_dump($_SESSION["category"]);
    $date_time=$_POST["measuredate"];
    // $id=$_SESSION["current_user"];
   # var_dump($id);
    $query1=mysqli_query($dbconn,"SELECT * FROM jednostki WHERE jednostki_ID = '$category'");
    $record = mysqli_fetch_assoc($query1);
    $x=$record["jednostki_ID"];
  //  var_dump($x);
    $query2=mysqli_query($dbconn,"SELECT * FROM rodzaje_badan WHERE jednostki_ID = '$x'");
    $record2 = mysqli_fetch_assoc($query2);
    $y=$record2["rodzaj_pomiaru_ID"];
   // var_dump($y);
    $query=mysqli_query($dbconn, "INSERT INTO pomiary (user_id,Wartość,rodzaj_pomiaru_ID, measure_date_time) VALUES ('$id','$value','$y','$date_time')");
   // var_dump($query);
}
}
if($_POST['new_value']){
    header("Location: project_add_new_unit.php");
}
// var_dump(isset($_POST['save_new_parameters']));

$result_tab=mysqli_query($dbconn,"SELECT pomiary.ID_pomiary, pomiary.measure_date_time, rodzaje_badan.nazwa_badania, pomiary.Wartość, jednostki.Rodzaj_jednostki
FROM pomiary 
	LEFT JOIN rodzaje_badan ON pomiary.rodzaj_pomiaru_ID = rodzaje_badan.rodzaj_pomiaru_ID 
	LEFT JOIN jednostki ON rodzaje_badan.jednostki_ID = jednostki.jednostki_ID WHERE pomiary.user_id='$id'");
// var_dump($result_tab);
?>
    <form method="POST">
        <lable>Wprowadź pomiar:</lable>
<input type="text" name="pomiar"><br/>
<input type="datetime-local" name="measuredate" value="2024-01-01T00:00"><br/>
<div class="select-container">
<select name="lista" class="select-box">
    <?php
        $categories = mysqli_query($dbconn,"SELECT * FROM jednostki" );
        while ($c=mysqli_fetch_array($categories)){
            ?>
            <option value="<?php echo $c['jednostki_ID'] ?>"><?php echo $c['Rodzaj_jednostki'] ?></option>
        <?php } ?>
</select>
</div></br>
<button type="submit" name="confirm_measure" class="button">Dodaj pomiar</button>
<input type="submit" name="new_value" class="button" value="Dopisz jednostkę"><br/><br>
</form>
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}

a:link, a:visited {
  background-color: #f44336;
  color: white;
  padding: 14px 25px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
}

a:hover, a:active {
  background-color: red;
}
        
</style>
<table id="customers" style="width:70%">
  <tr>
    <th>Data wykonania pomiaru</th>
    <th>Nazwa badania</th>
    <th>Wartość</th>
    <th>Jednostka</th>
    <th>Edycja</th>
    <th>Usuń pomiar</th>
  </tr>
  <tr>
    <?php
    while($row=mysqli_fetch_assoc($result_tab)){
    ?>
    <td><?php echo $row['measure_date_time'];?></td>
    <td><?php echo $row['nazwa_badania'];?></td>
    <td><?php echo $row['Wartość'];?></td>
    <td><?php echo $row['Rodzaj_jednostki'];?></td>
    <td><a href="project_edit.php?id=<?php echo $row['ID_pomiary']; ?>" class="button">Edytuj</a></td>
    <td><a href="project_delete.php?id=<?php echo $row['ID_pomiary']; ?>" class="button">Usuń</a></td>
  </tr>
  <?php
  }
  ?>
    </table><br>
<!-- <button type="submit" name="new_value">Dopisz jednostkę</button><br/> -->
<form method="POST" action="project_statistic.php">
        <lable>Statystyka parametru:</lable></br>
        <input type="datetime-local" name="measuredate_start" value="2024-01-01T00:00"><br/>
        <input type="datetime-local" name="measuredate_end" value="2024-01-01T00:00"><br/>
<div class="select-container">
<select name="statystyka" class="select-box">
    <?php
        $categories = mysqli_query($dbconn,"SELECT * FROM rodzaje_badan" );
        while ($c=mysqli_fetch_array($categories)){
            ?>
            <option value="<?php echo $c['rodzaj_pomiaru_ID'] ?>"><?php echo $c['nazwa_badania'] ?></option>
        <?php } ?>
</select>
</div></br>
<button type="submit" name="make_statistic" class="button">Wykonaj statystykę pomiarów</button>
</form>
<a href="./project_login.php">Powrót do strony głównej</a><br><br>
<a href="./project_documentation.php">Dokumentacja</a><br>
</body>
</html>