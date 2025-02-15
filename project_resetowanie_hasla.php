<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>...:::Restetowanie hasła:::...</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
<?php
function chgw($dane) {
    $dane = trim($dane);
    $dane = stripslashes($dane);
    $dane = htmlspecialchars($dane);
    return $dane;
}
$servername="mysql.agh.edu.pl";
$username="mateuszg";
$dbpassword="bEc7VBm5USh09AEH";
$dbname="mateuszg";

$dbconn=mysqli_connect($servername, $username, $dbpassword, $dbname);
$code="";
if(isset($_POST["send_email"])){
    for ($i = 1; $i <= 5; $i++) {
        $random_number=rand(1,9);
        $code.=$random_number;
        $_SESSION["code"]=$code;
    }
}
#var_dump(isset($_POST["send_email"]));
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["reset_email"])) {
        $mailErr = "Musisz podac E-mail!";
    } else {
        $reset_email = chgw($_POST["reset_email"]);
        $_SESSION["reset_email"]=$reset_email;
    }
}
mail($reset_email,"Resetowanie hasła",$code);
#var_dump($_POST["verify"]);
#var_dump($_SESSION["code"]);
if(isset($_POST["confirm"]))
{
 #   if($_POST["verify"]==$_SESSION["code"]){
        $_SESSION["entered_code"]=$_POST["verify"];
  #  }
}
#var_dump(isset( $_SESSION["entered_code"]));
if(isset($_SESSION["entered_code"])){
if($_SESSION["entered_code"]==$_SESSION["code"]){
    echo "Podany kod jest poprawny. Wprowadź nowe hasło: ";
    if(isset($_POST["confirm_new_password"])){
        $resetmail= $_SESSION["reset_email"];
        #var_dump($_SESSION["reset_email"]);
        $lastmail=$_SESSION["reset_email"];
        #var_dump($lastmail);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["new_password"])) {
                $Err = "Musisz podac nowe hasło!";
            } else {
                $new_pass = chgw($_POST["new_password"]);
            }
        }
        $new_passwd=mysqli_real_escape_string($dbconn,$new_pass);
        $new_password_hash_1=password_hash($new_passwd,PASSWORD_DEFAULT);
        
        echo "<br>".$Err."<br>";
        
        if(mysqli_query($dbconn, "UPDATE registered_users SET user_password_hash = '$new_password_hash_1' WHERE user_email= '$lastmail'")){
            echo "Hasło zmienione";
        }
        
        }
}else{
    echo "Podany kod jest niepoprawny. Podaj poprawny kod:";
}
}

?>
<style>
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
<br>Podaj kod z emaila</br>
<form method="POST" action="project_resetowanie_hasla.php">
<input type="name" name="verify" placeholder="Kod:"><br>
    <input type="submit" name="confirm" class="button" value="Potwierdź kod"><br>
</form>
<form method="POST" action="project_resetowanie_hasla.php">
<input type="password" name="new_password" placeholder="Nowe hasło:"><br>
<input type="submit" name="confirm_new_password" class="button" value="Zmień hasło: "><br>
</form>
<a href="./project_logowanie.php">Powrót do logowania</a><br>
</body>
</html>