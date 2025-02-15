<?php
$user_fullname=$user_email=$user_password="";
function chgw($dane) {
    $dane = trim($dane);
    $dane = stripslashes($dane);
    $dane = htmlspecialchars($dane);
    return $dane;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
        $imErr = "Musisz podac imie!";
    } else {
        $name = chgw($_POST["name"]);
    }
    if (empty($_POST["email"])) {
        $mailErr = "Musisz podac E-mail!";
    } else {
        $email = chgw($_POST["email"]);
    }
    if (empty($_POST["password"])) {
        $passErr = "Musisz podac hasło!";
    } else {
        $password = chgw($_POST["password"]);
    }
}

$servername="mysql.agh.edu.pl";
$username="mateuszg";
$dbpassword="bEc7VBm5USh09AEH";
$dbname="mateuszg";

$dbconn=mysqli_connect($servername, $username, $dbpassword, $dbname);
$user_fullname=mysqli_real_escape_string($dbconn,$name);
$user_email=mysqli_real_escape_string($dbconn,$email);
$user_password=mysqli_real_escape_string($dbconn,$password);

$user_password_hash=password_hash($user_password,PASSWORD_DEFAULT);

echo "<br>".$imErr."<br>".$mailErr."<br>".$passErr;
var_dump($user_fullname." ".$user_email);
if(isset($name) and isset($email) and isset($password)){
if(mysqli_query($dbconn, "INSERT INTO registered_users (user_fullname,user_email, user_password_hash)
    VALUES ('$user_fullname','$user_email','$user_password_hash')")){
        echo "Rejestracja przebiegła poprawnie";
    }else{
        echo "Nieoczekiwany błąd";
    }
}else{
    echo "Nie podano danych";
}
?>