<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>...:::Logowanie:::...</title>
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
$user_password=mysqli_real_escape_string($dbconn,$_POST["password"]);
$user_email=mysqli_real_escape_string($dbconn,$_POST["email"]);
$query=mysqli_query($dbconn,"SELECT * FROM registered_users WHERE user_email = '$user_email'");
$ipaddress = getenv("REMOTE_ADDR");
$datetime=date("Y/m/d")." ".date("h:i:sa");
if(mysqli_num_rows($query) > 0){
    $record = mysqli_fetch_assoc($query);
    $hash= $record["user_password_hash"];
    #var_dump($record);

    if(password_verify($user_password, $hash)){
        $_SESSION["current_user"]=$record["user_id"];
        $_SESSION["email_user"]=$record["user_email"];
        #$_SESSION["password_user"]=$record["user_password_hash"];
        header("Location: project_login.php");

    }else{
        header('Location: project_logowanie.php?login=false');
    }
}
#var_dump($hash," ",$user_password," ",$record," ",$user_email," ",password_verify($user_password, $hash));
if(isset($_SESSION["current_user"])){
    mysqli_query($dbconn, "INSERT INTO login_attempts (Success,Datetimeval, client_IP)
    VALUES ('Yes','$datetime','$ipaddress')");
    echo "Użytkownik jest zalogowany: ";
}else{
    mysqli_query($dbconn, "INSERT INTO login_attempts (Success,Datetimeval, client_IP)
    VALUES ('No','$datetime','$ipaddress')");
    echo "Użytkownik nie jest zalogowany";

}
if(isset($_SESSION["current_user"])){
if(isset($_POST["change"])){
$email= $_SESSION["email_user"];
var_dump($email);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["changed_password"])) {
        $Err = "Musisz podac nowe hasło!";
    } else {
        $new_passwd = chgw($_POST["changed_password"]);
    }
}
$new_password=mysqli_real_escape_string($dbconn,$new_passwd);
$new_password_hash=password_hash($new_password,PASSWORD_DEFAULT);

echo "<br>".$Err."<br>";

if(mysqli_query($dbconn, "UPDATE registered_users SET user_password_hash = '$new_password_hash' WHERE user_email= '$email'")){
        echo "Hasło zmienione";
    }else{
        echo "Nie udało się zmienić hasła";
    }
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
<form method="POST" action="project_login.php">
<input type="password" name="changed_password" placeholder="Hasło"><br>
<input type="submit" name="change" class="button" value="Zmień hasło"><br>
</form>
<br>
<a href="./project_wyloguj.php">Wyloguj</a><br><br>
<a href="./project_dropdown.php">Moje pomiary</a><br>
</body>
</html>