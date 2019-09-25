<?php
session_start();
if (!(isset($_SESSION['authorized']) && $_SESSION['authorized']=='Benny Bennasy'))
{
    header("Location: "."login.php");
}
require_once 'functions.php';
require_once 'modelJournal.php';
//debug($_GET);
if (!isset($_SESSION['resultSearch']))
{
    $journal=new Journal();
    $message=$journal->getArrMessage();
}
else
{
   $message=$_SESSION['resultSearch'];
   
   //debug($_SESSION['resultSearch']);
   if (isset($_GET['numpage'])) unset($_SESSION['resultSearch']);
   
   
   
}


//////////////////////////////////////////////////////////////ПАГИНАЦИЯ//////////////////////
$recordInPage=10;// сколько записий на странице
$recordBegin=0;// начала отчета записей
$recordEnb=$recordBegin+$recordInPage;// конец отчета записей
$paginPageAll=1;// всего страниц для пагинации.

$countRecords=count($message);// сколько всего записей

$paginPageAll=(int)($countRecords / $recordInPage);
if ($countRecords % $recordInPage!=0) $paginPageAll++;

$numPaginPage=$_GET['numpage'];
if (!isset($_GET['numpage'])) $numPaginPage=1;

$recordBegin=$recordInPage*($numPaginPage-1);// начала отчета записей
$recordEnb=$recordBegin+$recordInPage;// конец отчета записей
if ($recordEnb>=$countRecords)$recordEnb=$countRecords;
//debug ($message);
//debug ($countRecords);
//debug ($recordBegin);
//debug ($recordEnb);
//расчет номеров пагинации
if ($numPaginPage-2<=1)
{
    $paginBegin=1;
}
 else
{
     $paginBegin=$numPaginPage-2;
}
if ($numPaginPage+2>=$paginPageAll)
{
    $paginEnd=$paginPageAll;
}
 else
{
     $paginEnd=$numPaginPage+2;
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
        <style>
            #paginator{
                position: absolute;
                top: 640px;
                left:140px;
                margin-bottom: 30px;
            }
        </style>
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
                <a href="option.php">
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
            <li><div> <a href="serverFunc.php?exit=true"><p>Выход</p></a></li></div>
             </ul>
        </nav>
        <main style="border: none;">
            <div id="divSearchJournal">
                <form id="searchByJournal" action="serverFunc.php" method="post">
                    <p> Введите запрос для поиска по URL</p>
                    <input type="text" id="textSearchJournal" name="querySearchJournal"
                        value="<?=$_SESSION['querySearch']?>"
                    > 
                    <input type="submit" name="btnSearchJournal" value="Поиск">
                </form>
            </div>
            
           <?php for ($i=$recordBegin;$i<$recordEnb;$i++):
              // for ($i=0;$i<count($message);$i++):
            ?>
                <div class="divMessageJournal">
                    <h5><?= $message[$i]['time']?> </h5>
                    <p><?= $message[$i]['message']?></p>
                </div>
            <?php endfor?>
            
            <?php if ($paginPageAll>1):?>
                <div id="paginator">
                    <?php if($numPaginPage>1):?>
                        <div class="divPaginator">
                                <a href="journal.php?numpage=1"><p><< </p></a>
                        </div>
                        <div class="divPaginator">
                                <a href="journal.php?numpage=<?=$numPaginPage-1?>"><p>< </p></a>
                        </div>
                    <?php endif;?>
                    <?php
                    
                       for ($i=$paginBegin;$i<=$paginEnd;$i++):
                    ?>
                        <div class="divPaginator <?php if($numPaginPage==$i) echo " divPaginChecked" ?>">
                            <a href="journal.php?numpage=<?=$i?>"><p><?= $i?> </p></a>
                        </div>
                    <?php endfor;?>
                    <?php if($numPaginPage<$paginPageAll):?>
                        <div class="divPaginator">
                                <a href="journal.php?numpage=<?=$numPaginPage+1?>"><p>> </p></a>
                        </div>
                        <div class="divPaginator">
                                <a href="journal.php?numpage=<?=$paginPageAll?>"><p>>> </p></a>
                        </div>
                    <?php endif;?>
                </div>
            <?php endif;?>
        </main>       
    </body>
</html>

