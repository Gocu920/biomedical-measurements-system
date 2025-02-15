<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>...:::Wyloguj:::...</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
<?php
session_unset();
session_destroy();
if(isset($_SESSION["current_user"])){
    echo "Użytkownik jest zalogowany: ".$_SESSION["current_user"];
}else{
    echo "Użytkownik nie jest zalogowany";
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
<a href="./project_logowanie.php">Zaloguj</a><br>
</body>
</html>