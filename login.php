<?php
    session_start();
    require_once 'modelUserOption.php';
    $DBUserOption=new modelUserOption();
    
    if ($DBUserOption->checkRecordInDB()==false)
    {
        header("Location: "."registration.php");
        exit;
    }
    if (isset($_SESSION['errorMes']))
    {
        $error=$_SESSION['errorMes'];
        unset($_SESSION['errorMes']);
    }
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
                
                <input type="submit" id="btnLogin" name="btnLogin" value="Войти">
                <?php if (isset($error)):?>
                    <p style="color:red; font-size:17px;">
                        <?=$error?>
                    </p>
                 <?php endif?>
            </form>
                
        </main>
    </body>
</html>
