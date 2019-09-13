<?php
//require_once "monitor.php";
//require_once "modelDBforCheck.php";
session_start();
require_once "functions.php";
require_once "main.php";
require_once "modelDBResultCheck.php";
require_once "modelDBForCheck.php";
if (isset($_SESSION['message_data']))
{
    $mes_data=$_SESSION['message_data'];
    unset($_SESSION['message_data']);
}
if ($_POST['btnGetData'])
{
   $DBResultCheck=new modelDBResultCheck();
   $dataUrl=getDataOnePage($_POST['urlPage']);
   
//   $resultCheck= readResultIsDBOneOfUrl($_POST['urlPage']);
 //  debug($dataUrl);
    
}
if (isset( $_GET['url']))
{
  $DBResultCheck=new modelDBResultCheck();
  $DBForCheck=new modelDBForCheck();
  $conn=connectDB();
  $DBForCheck->setConn($conn);
  $dataOnePageDB=$DBForCheck->readDBOneRecordByURL($_GET['url']);
  $dataUrl=getDataOnePage($_GET['url']);  
  $resultCheck=$DBResultCheck->readResultIsDBOneOfUrl($_GET['url']);
 // debug($dataOnePageDB);
  //debug($dataUrl);
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
        <script src="scripts/jquery-1.10.2.min.js" type="text/javascript"></script>
        <script src="scripts/pageJS.js" type="text/javascript"></script>
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
            <!--
            <?php if (!isset($_GET['url'])):?>
                <form id="formUrl" action="page.php" method="post">
                    <p>Введите адресс страницы </p>
                    <input type="text" id="urlPage" name="urlPage" value="<?= $dataUrl['url'];?>">
                    <input type='submit' value="Получить данные" name="btnGetData">
                    <?php if (isset($dataUrl['message'])):?>
                        <p style="color: red; margin: 0px;"><?= $dataUrl['message']?></p>
                        <br>
                    <?php endif; ?>
                </form>
            <?php else:?>
          
            <h3 style="margin-left: 17px">Редактирование данных о странице: <?=$_GET['url'] ?></h3>
            <?php endif;?>
            --> 
            
            <h3 style="margin-left: 17px">Редактирование данных о странице: <?=$_GET['url'] ?></h3>
            <?php if (isset($mes_data)):?>
                <p style="margin-left: 17px; color: red;"><?=$mes_data ?></p>
            <?php endif?>
            <div id="divContent">
                <div id="divDataPage">
                        <h3> То что полученно со страницы</h3>
                        <p id="responseP"> Ответ сервера: <?=$dataUrl['response']?></p>
                        <div id="divDataPage2">
                            <p>Размер страницы:</p>
                            <input type="text" readonly id="dataSize" name="dataSize" value="<?=$dataUrl['size']?>">
                            <div id="divDataPage3">
                                <p>H1: </p>
                                <textarea readonly id='dataH1' rows="3" cols="40"><?=$dataUrl['h1']?></textarea>

                                <p>Title:</p>
                                <textarea readonly id='dataTitle' rows="3" cols="40"><?=$dataUrl['title']?></textarea>
                                <p>Keywords: </p>
                                <textarea readonly id='dataKeywords' rows="3" cols="40"><?=$dataUrl['keywords']?></textarea>
                                <p>Description: </p>
                                <textarea readonly id='dataDescription' rows="3" cols="40"><?=$dataUrl['description']?></textarea>
                            </div>
                        </div>

                </div>
                <div id="divDataPageDB">
                    <h3> То что находиться в базе данных</h3>
                    <form id="formDataPageDB" action="serverFunc.php" method="post">
                        <div id="divPageSizeDB">
                            <div id="divPageSizeDB2">
                                <input type="hidden" name="url" value="<?php
                                    if( isset($_GET['url'])) echo $_GET['url'];
                                    else if (isset($_POST['urlPage'])) echo $_POST['urlPage'];
                                   ?>"
                                >
                                <input type="hidden" name="newPage" value="<?php
                                    if( isset($_GET['newPage'])) echo (1);
                                   ?>"
                                >
                                <p>Размер страницы</p>
                                <input type="text"  id="dataSizeDB" name="dataSizeDB" 
                                    value="<?php if (isset($dataOnePageDB['size_page'])) 
                                    echo $dataOnePageDB['size_page']; else echo (0); ?>"
                                >
                            </div>
                            <p>Погрешность размера страницы</p>
                            <input type="text" id="dataDeviationSizeDB" name="dataDeviationSizeDB"
                                value="<?php if (isset($dataOnePageDB['deviation_size'])) 
                                echo $dataOnePageDB['deviation_size']; else echo (0); ?>"
                            >
                            
                        </div>
                        
                        <div id="divPageMetaDB"> 
                            <p>H1</p>
                            <textarea id='dataH1DB' name='dataH1DB' rows="3" cols="40"><?php 
                                    if (isset($dataOnePageDB['h1'])) 
                                        echo $dataOnePageDB['h1'] ?></textarea>
                            <p>Title</p>
                            <textarea id='dataTitleDB' name='dataTitleDB' rows="3" cols="40"><?php 
                                    if (isset($dataOnePageDB['title'])) 
                                        echo $dataOnePageDB['title'] ?></textarea>
                            <p>Keywords</p>
                            <textarea id='dataKeywordsDB'  name='dataKeywordsDB' rows="3" cols="40"><?php 
                                    if (isset($dataOnePageDB['keywords'])) 
                                        echo $dataOnePageDB['keywords'] ?></textarea>
                            <p>Description</p>
                            <textarea id='dataDescriptionDB' name='dataDescriptionDB' rows="3" cols="40"><?php 
                                    if (isset($dataOnePageDB['description'])) 
                                        echo $dataOnePageDB['description'] ?></textarea>
                        </div>
                        <input type="submit" value="сохранить в БД" name="btnSaveDataPageInDB" id="btnSaveDataPageInDB">
                    </form>
            
                </div>
                <div id="divCheckPage">
                    <?php if (!(isset($_GET['newPage'])&&$_GET['newPage']==true)):?>
                      <h4> Результат проверки</h4>
                      <p>ответ сервера:<?php if ($resultCheck['response']==200) echo "OK";
                              else echo "FAIL";  ?>
                      </p>
                      <p>Размер страницы:<?php if ($resultCheck['size']==1) echo "OK";
                              else echo "FAIL";  ?>
                      </p>
                      <p>h1:<?php if ($resultCheck['h1']==1) echo "OK";
                              else echo "FAIL";  ?>
                      </p>
                      <p>Title:<?php if ($resultCheck['title']==1) echo "OK";
                              else echo "FAIL";  ?>
                      </p>
                      <p>Keywords:<?php if ($resultCheck['keywords']==1) echo "OK";
                              else echo "FAIL";  ?>
                      </p>
                      <p>Description:<?php if ($resultCheck['description']==1) echo "OK";
                              else echo "FAIL";  ?>
                      </p>
                      <?php endif?>
                  </div>
           </div> 
                <?php //if (!isset($_GET['url'])):?>
                <button id="btnTrancfer" name="btnTransfer" 
                        title="Перенести в область того что находиться в базе данных"> 
                    &#62; &#62;
                </button>
            <!--
                <form id="formSaveDataPageInDB" action="/serverFunc.php" method="post">
                    <input type="submit" value="сохранить в БД" name="btnSaveDataPageInDB" id="btnSaveDataPageInDB">
                </form>
            -->
                <?php //endif?>
        </main>       
    </body>
</html>

