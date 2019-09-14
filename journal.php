<?php
require_once 'functions.php';
require_once 'modelJournal.php';
session_start();
if (!isset($_SESSION['resultSearch']))
{
    $journal=new Journal();
    $message=$journal->getArrMessage();
}
else
{
    $message=$_SESSION['resultSearch'];
    unset($_SESSION['resultSearch']);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style/main.css" type="text/css">
        <link rel="stylesheet" href="style/journal.css" type="text/css">
        <script src="scripts/jquery-1.10.2.min.js" type="text/javascript"></script>
        <script src="scripts/mainJS.js" type="text/javascript"></script>
        <script src="scripts/journal.js" type="text/javascript"></script>
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
        <main style="border: none;">
            <div id="divSearchJournal">
                <form id="searchByJournal" action="serverFunc.php" method="post">
                    <p> Введите запрос для поиска по URL</p>
                    <input type="text" id="textSearchJournal" name="querySearchJournal"> 
                    <input type="submit" name="btnSearchJournal" value="Поиск">
                </form>
            </div>
           <?php for ($i=0;$i<count($message);$i++):?>
                <div class="divMessageJournal">
                    <h5><?= $message[$i]['time']?> </h5>
                    <p><?= $message[$i]['message']?></p>
                </div>
            <?php endfor?>
        </main>       
    </body>
</html>

