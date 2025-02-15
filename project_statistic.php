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
        $id=$_SESSION["current_user"];
        // var_dump($id);
        $servername="mysql.agh.edu.pl";
        $username="mateuszg";
        $dbpassword="bEc7VBm5USh09AEH";
        $dbname="mateuszg";
        $dbconn=mysqli_connect($servername, $username, $dbpassword, $dbname);
        $start=$_POST["measuredate_start"];
        $end=$_POST["measuredate_end"];
        $choice=$_POST["statystyka"];
        $query=mysqli_query($dbconn,"SELECT pomiary.Wartość FROM pomiary LEFT JOIN rodzaje_badan ON pomiary.rodzaj_pomiaru_ID=
        rodzaje_badan.rodzaj_pomiaru_ID WHERE rodzaje_badan.rodzaj_pomiaru_ID='$choice' AND pomiary.measure_date_time BETWEEN '$start' AND '$end' AND pomiary.user_id='$id'");
        // var_dump($start,$end,$choice);
        $row=mysqli_fetch_all($query);
        //  var_dump($row);
        // var_dump(max($row));
        // var_dump(min($row));
        // var_dump($row[2][0]);
        // var_dump($row);
        $num=count($row);
        // var_dump($num);
        // var_dump($num);
        $sum=0;
        $mean=0;
        $val=array();
        for($x=0;$x<$num;$x++) {
            array_push($val,floatval($row[$x][0])); 
        }
        for($x=0;$x<$num;$x++) {
            $m=floatval($row[$x][0]);  
            $sum+=$m;
            
        }
        $mean=number_format($sum/$num,1);
    //    var_dump($mean);
     
        
    ?>
    <h3>Maksymalna wartość wynosi: <?php echo max($val) ?></h3>
    <h3>Minimalna wartość wynosi: <?php echo min($val) ?></h3>
    <h3>Średnia wartość wybranego parametru za okres od <?php echo $start ?> do <?php echo $end ?> wynosi: <?php echo $mean ?></h3>
<a href="./project_dropdown.php">Powrót do moich pomiarów</a><br>
</body>
</html>