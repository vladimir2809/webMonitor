<?php

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title> WebMonitor</title>   
        <link rel="stylesheet" href="style/login.css" type="text/css">
    </head>    
    <body>
        <main>
            <h3>Добро пожаловать в WebMonitor</h3>
            <form id="formLogin" action="serverFunc.php" method="post">
                <p> Логин</p>
                <input type="text" name="login">
                <p> Пароль</p>
                <input type="password" name="password">
            </form>
                
        </main>
    </body>
</html>
