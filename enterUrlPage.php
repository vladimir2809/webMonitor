<?php
require_once "functions.php";
require_once "main.php";
require "modelDBForCheck.php";
if ($_POST['btnGetData'])
{
   $dataUrl=getDataOnePage($_POST['urlPage']);
   
//   $resultCheck= readResultIsDBOneOfUrl($_POST['urlPage']);
 //  debug($dataUrl); 
    $conn=connectDB();
    $DBForCheck=new modelDBForCheck; 
    $DBForCheck->setConn($conn);
    if ($DBForCheck->checkRecordByUrl($_POST['urlPage']))
    {
        $dataUrl['message']="Эта страница с таким адрессом сушествует в базе данных";
    }
    if (!isset($dataUrl['message']))
    {
        header("Location: "."page.php?newPage=true&url={$_POST['urlPage']}");
    }
}?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style/main.css" type="text/css">
        <link rel="stylesheet" href="style/page.css" type="text/css">
        <script src="scripts/jquery-1.10.2.min.js" type="text/javascript"></script>
        <title> WebMonitor</title>   
    </head>    
    <body>
        <header>
            <h1> WEB MONITOR</h1>   
            <div id="headDiv">
                <a href="index.php">
                    <div id="headIndexA">
                        <p> Главная</p>
                    </div>
                </a>
                <a href="index.php">
                    <div id="headOptionA">
                        <p> Настройки</p>
                    </div>
                </a>
            </div>
        </header> 
        <nav>
            <ul>
                <li><div><a href="/enterUrlPage.php"><p>Добавить сайт</p></a></li></div>
            
            <li><div> <a href="#"><p>Пополнить баланс</p></a> </li></div>
            
             <li><div> <a href="journal.php"><p>Журнал</p></a></li></div>
             </ul>
        </nav>
        <main>  
           
            <form id="formUrl" action="enterUrlPage.php" method="post">
                    <p>Введите адресс страницы </p>
                    <input type="text" id="urlPage" name="urlPage" value="<?= $dataUrl['url'];?>">
                    <input type='submit' value="Получить данные" name="btnGetData">
                    <?php if (isset($dataUrl['message'])):?>
                        <p style="color: red; margin: 0px;"><?= $dataUrl['message']?></p>
                        <br>
                    <?php endif; ?>
                </form>
            
            
        </main>       
    </body>
</html>

