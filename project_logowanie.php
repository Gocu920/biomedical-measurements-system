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
        if ('false' === $_GET['login']) {
            #var_dump( $_GET['login']);
            echo 'Login failed. Please try again.';
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
    <input type="email" name="email" placeholder="E-mail"><br>
    <input type="password" name="password" placeholder="Hasło"><br>
    <input type="submit" name="submit" class="button" value="Wyślij"><br>
</form>
<br>Nie pamiętasz hasła? Podaj adres mailowy na który zostanie wysłany kod do zresetowania hasła</br>
<form method="POST" action="project_resetowanie_hasla.php">
<input type="email" name="reset_email" placeholder="E-mail"><br>
    <input type="submit" name="send_email"  class="button" value="Wyślij link na maila"><br>
</form>
<a href="./project_rejestracja.php">Rejestracja</a><br>

</body>
</html>
