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
    $data=$_SESSION['data'];
   // debug($data);
    unset($_SESSION['data']);
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html> <!--<![endif]--> 
<html>
    <head>
        <meta charset="UTF-8">
        <title> WebMonitor</title>   
        <link rel="stylesheet" href="style/login.css" type="text/css">
        <script src="scripts/jquery-1.10.2.min.js" type="text/javascript"></script>
        <script src="scripts/position.js" type="text/javascript"></script>
    </head>    
    <body>
        <main>
        <div id="mainLogin">
            <h3>Добро пожаловать в WebMonitor</h3>
            <form id="formLogin" action="serverFunc.php" method="post">
                <p> Логин</p>
                <input type="text" name="login" value="<?=$data['login']?>">
                <p> Пароль</p>
                <input type="password" name="password">
                
                <input type="submit" id="btnLogin" name="btnLogin" value="Войти">
                <?php if (isset($error)):?>
                    <p style="color:rgb(200,0,0); font-size:17px; margin-top: 2px;">
                        <?=$error?>
                    </p>
                 <?php endif?>
            </form>
        </div>       
        </main>
    </body>
</html>
