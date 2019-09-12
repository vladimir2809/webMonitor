<?php
//require_once "monitor.php";
require_once "modelDBforCheck.php";
require_once "functions.php";
require_once "main.php";
//require_once 'Journal.php';
require_once "SMS.php";
require_once "modelDBResultCheck.php";
$DBResultCheck=new modelDBResultCheck();
$resultCheck=$DBResultCheck->readResultIsDB();
$conn=connectDB();
$DBForCheck=new modelDBForCheck; 
$DBForCheck->setConn($conn);
$statePause=$DBForCheck->readStatePause();
//debug($statePause);
//debug($resultCheck);
//$journal=new Journal();
//for($i=0;$i<count($resultCheck);$i++)
//{
//    echo $journal->createCodeByResCheck($resultCheck[$i]);
//    echo '<br>';
//}
//writeResChecksInDB(checkAll());
//debug($resultCheck);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style/main.css" type="text/css">
        <script src="scripts/jquery-1.10.2.min.js" type="text/javascript"></script>
        <script src="scripts/mainJS.js" type="text/javascript"></script>
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
            
             <li><div> <a href="#"><p>Журнал</p></a></li></div>
             </ul>
        </nav>
        <main>
            <div id='mainDiv'>
                <div id='mainDivP'><p  > Страницы на мониторинге</p></div>
                <div id='PBalanse'><p  > баланс: <?= getBalance()?></p></div>
            </div>
            <table>
                <tr>
                    <th> url</th><th> состояние</th><th>проверен</th><th> ответ</th><th>размер</th>
                    <th> h1</th><th> title</th><th> keywords</th><th> description</th>
                    <th></th><th></th>
                </tr>
                <?php for($i=0;$i<count($resultCheck);$i++): ?>
                 <tr>
                    <td><a href='/page.php?url=<?=$resultCheck[$i]['url']?>'>
                        <?= $resultCheck[$i]['url']?><a> 
                    </td>
                    <td>
                       <?php if ($statePause[$i]['state_pause']==0) echo "Мониторится";
                           else echo 'Остановлено'?>
                    </td>
                    <td><?= date("d-M-y H:i",strtotime($resultCheck[$i]['time_upload']))?> </td>
                    <td><?= $resultCheck[$i]['response']?> </td>
                    <td><?php if ($resultCheck[$i]['size']==1) echo "OK";
                            else echo "FAIL";  ?>
                    </td>
                     <td><?php if ($resultCheck[$i]['h1']==1) echo "OK";
                            else echo "FAIL";  ?>
                    </td>
                     <td><?php if ($resultCheck[$i]['title']==1) echo "OK";
                            else echo "FAIL";  ?>
                    </td>
                     <td><?php if ($resultCheck[$i]['keywords']==1) echo "OK";
                            else echo "FAIL";  ?>
                    </td>
                    <td><?php if ($resultCheck[$i]['description']==1) echo "OK";
                            else echo "FAIL";  ?>
                    </td>
                    <td>
                      <!--  <div><img class="imgBtn"style=" width: 17px;"src="image/pause.png"  title='поставить на паузу'></div>-->
                        <form id='formPauseBtn' action="serverFunc.php" method="post">
                            <input type='hidden' name='urlOfPause' value='<?=$resultCheck[$i]['url']?>' >
                            <?php if ($statePause[$i]['state_pause']==0):?>
                                <input type='image' style=" width: 17px;" class='imgBtn'
                                       src='image/pause.png' name='btnPause' value='pause'
                                       title='поставить на паузу'
                                >
                            <?php else: ?>
                                <input type='image' style=" width: 17px;" class='imgBtn'
                                   src='image/play.png' name='btnPlay' value='play'
                                   title='возобновить мониторинг'
                                >
                            <?php endif?>
                        </form>
                            
                            
                    </td>
                    <td>
                      <!--  <div><img class="imgBtn" style=" width: 17px;"src="image/bag.png" title="снять с мониторинга"></div>-->
                        <form id='formDeleteBtn' action="serverFunc.php" method="post">
                            <input type='hidden' id='hidUrlOfDelete' name='urlOfDelete' value='<?=$resultCheck[$i]['url']?>' >
                            <input type='image' style=" width: 17px;" class='imgBtn' 
                                   src='image/bag.png' name='btnDelete' value='delete'
                                   title='снять с мониторинга'
                            >
                        </form>
                    </td>
                </tr>
                <?php endfor;?>
            </table>
        </main>       
    </body>
</html>


