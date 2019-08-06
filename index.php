<?php
//require_once "monitor.php";
//require_once "modelDBforCheck.php";
require_once "functions.php";
require_once "main.php";
$resultCheck=readResultIsDB();
//debug($resultCheck);
//writeResChecksInDB(checkAll());
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style/main.css" type="text/css">
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
            <div id='mainDiv'>
                <div id='mainDivP'><p  > Страницы на мониторинге</p></div>
                <div id='PBalanse'><p  > баланс</p></div>
            </div>
            <table>
                <tr>
                    <td> url</td><td> ответ сервера</td><td> размер старницы</td>
                    <td> h1</td><td> title</td><td> keywords</td><td> description</td>
                </tr>
                <?php for($i=0;$i<count($resultCheck);$i++): ?>
                 <tr>
                    <td><a href='#'><?= $resultCheck[$i]['url']?><a> </td>
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
                </tr>
                <?php endfor;?>
            </table>
        </main>       
    </body>
</html>


