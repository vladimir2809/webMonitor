<?php
//ini_set('display_errors', 'On'); // сообщения с ошибками будут показываться
//error_reporting(E_ALL); // E_ALL - отображаем ВСЕ ошибки
session_start();
if (!(isset($_SESSION['authorized']) && $_SESSION['authorized']=='Benny Bennasy'))
{
    header("Location: "."login.php");
}
require_once 'functions.php';
require_once 'modelJournal.php';
//debug($_GET['numpage']);
if (!isset($_GET['numpage'])) 
{
    unset($_SESSION['resultSearch']);
    unset($_SESSION['querySearch']);
}
if (!isset($_SESSION['resultSearch']))
{
    $journal=new Journal();
    $message=$journal->getArrMessage();
    unset($_SESSION['resultSearch']);
    //unset($_SESSION['querySearch']);
}
else
{
   $message=$_SESSION['resultSearch']; 
}
if ($_SESSION['querySearch']!='')
{
    
}

//debug($message);
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
if (!isset($_GET['numpage']) || is_numeric($_GET['numpage'])==false || (int)$_GET['numpage']<1)
{
    header("Location: "."journal.php?numpage=1");
    exit;
}   
if ((int)$_GET['numpage']>$paginPageAll && $paginPageAll>0)
{
    //echo '111';
    header("Location: "."journal.php?numpage={$paginPageAll}");
    exit;
}


$recordBegin=$recordInPage*($numPaginPage-1);// начала отчета записей
$recordEnb=$recordBegin+$recordInPage;// конец отчета записей
if ($recordEnb>=$countRecords)$recordEnb=$countRecords;
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
        <script src="scripts/position.js" type="text/javascript"></script>
        <style>
            #paginator{
                position: relative;
                top: 60px;
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
            
            <li><div> <a href="https://www.smsfeedback.ru/users/invoices/addinvoiceform.php">
                        <p>Пополнить баланс</p></a> </li></div>
            
            <li><div> <a href="journal.php"><p>Журнал</p></a></li></div>
            <li><div> <a href="serverFunc.php?exit=true"><p>Выход</p></a></li></div>
             </ul>
        </nav>
        <main style="border: none;">
            <h2>Журнал</h2>
            <?php if (!isset($message) && !isset($_SESSION['querySearch'])):?>
                <h3 style="margin-left: 30px;">Нет данных</h3>
            <?php else: ?>
                <div id="divSearchJournal">
                    <form id="searchByJournal" action="serverFunc.php" method="post">
                        <p> Введите запрос для поиска по URL</p>
                        <input type="text" id="textSearchJournal" name="querySearchJournal"
                            value="<?=$_SESSION['querySearch']?>"
                        > 
                        <input type="submit" name="btnSearchJournal" value="Поиск">
                    </form>
                </div>
                <?php if ($_SESSION['querySearch']!='' && !isset($_SESSION['resultSearch'])):?>
                    <h4 style="margin-left: 150px"> по вашему запросу ни чего не найдено</h4>
                 <?php else: ?>
                    <?php for ($i=$recordBegin;$i<$recordEnb;$i++):
                       // for ($i=0;$i<count($message);$i++):
                     ?>
                         <div class="divMessageJournal">
                             <h5><?= $message[$i]['time']?> </h5>
                             <p><?= $message[$i]['message']?></p>
                         </div>
                     <?php endfor?>
                <?php endif;?> 
            <?php endif?>
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

