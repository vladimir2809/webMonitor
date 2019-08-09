<?php
//require_once "monitor.php";
//require_once "modelDBforCheck.php";
require_once "functions.php";
require_once "main.php";
if ($_POST['btnGetData'])
{
   $dataUrl=getDataOnePage($_POST['urlPage']);
    
}
//debug($resultCheck);
//writeResChecksInDB(checkAll());
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style/main.css" type="text/css">
        <link rel="stylesheet" href="style/page.css" type="text/css">
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
            <li><div><a href="#"><p>Добавить сайт</p></a></li></div>
            
            <li><div> <a href="#"><p>Пополнить баланс</p></a> </li></div>
            
             <li><div> <a href="#"><p>Журнал</p></a></li></div>
             </ul>
        </nav>
        <main>  
            <form id="formUrl" action="page.php" method="post">
              <p>Введите адресс страницы </p>
              <input type="text" id="urlPage" name="urlPage">
              <input type='submit' value="Получить данные" name="btnGetData">
            </form>
            <div id="dataPage">
                    <p style="padding-left: 23px;">ответ сервера: <?= $dataUrl['response']?></p>
                    <p>размер страницы: <?= $dataUrl['size']?></p>
                    <p>H1: </p>
                    <textarea rows="1" cols="20"><?= $dataUrl['h1']?></textarea>

                    <p>Title:</p>
                    <textarea rows="1" cols="20"><?= $dataUrl['title']?></textarea>
                    <p>Keywords: </p>
                    <textarea rows="1" cols="20"><?= $dataUrl['keywords']?></textarea>
                    <p>Description: </p>
                    <textarea rows="1" cols="20"><?= $dataUrl['description']?></textarea>
                    
                
            </div>
            <div id="dataPageDB">
                
            </div>
             
           
        </main>       
    </body>
</html>

