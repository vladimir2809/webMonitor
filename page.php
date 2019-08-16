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
            <li><div><a href="#"><p>Добавить сайт</p></a></li></div>
            
            <li><div> <a href="#"><p>Пополнить баланс</p></a> </li></div>
            
             <li><div> <a href="#"><p>Журнал</p></a></li></div>
             </ul>
        </nav>
        <main>  
            <form id="formUrl" action="page.php" method="post">
              <p>Введите адресс страницы </p>
              <input type="text" id="urlPage" name="urlPage" value="<?= $dataUrl['url'];?>">
              <input type='submit' value="Получить данные" name="btnGetData">
            </form>
            <div>
                <div id="divDataPage">
                        <h3> То что полученно со страницы</h3>
                        <p> Ответ сервера: <?= $dataUrl['response']?></p>
                        <div id="divDataPage2">
                            <p>Размер страницы:</p>
                            <input type="text" id="dataSize" name="dataSize" value=" <?= $dataUrl['size']?>">
                            <div id="divDataPage3">
                                <p>H1: </p>
                                <textarea readonly id='dataH1' rows="1" cols="40"><?= $dataUrl['h1']?></textarea>

                                <p>Title:</p>
                                <textarea readonly id='dataTitle' rows="1" cols="40"><?= $dataUrl['title']?></textarea>
                                <p>Keywords: </p>
                                <textarea readonly id='dataKeywords' rows="1" cols="40"><?= $dataUrl['keywords']?></textarea>
                                <p>Description: </p>
                                <textarea readonly id='dataDescription' rows="1" cols="40"><?= $dataUrl['description']?></textarea>
                            </div>
                        </div>

                </div>
                <div id="divDataPageDB">
                    <h3> То что находиться в базе данных</h3>
                    <form id="formDataPageDB" action="" method="post">
                        <div id="divPageSizeDB">
                            <p>Размер страницы</p>
                            <input type="text" id="dataSizeDB" name="dataSizeDB" value="">
                            
                            <p>Погрешность размера страницы</p>
                            <input type="text" id="dataDeviationSizeDB" name="dataDeviationSizeDB" value="">
                        </div>
                        
                        <div id="divPageMetaDB"> 
                            <p>H1</p>
                            <textarea id='dataH1DB' rows="1" cols="40"></textarea>
                            <p>Title</p>
                            <textarea id='dataTitleDB' rows="1" cols="40"></textarea>
                            <p>Keywords</p>
                            <textarea id='dataKeywordsDB' rows="1" cols="40"></textarea>
                            <p>Description</p>
                            <textarea id='dataDescriptionDB' rows="1" cols="40"></textarea>
                        </div>
                    </form>
                </div>

                <button id="btnTrancfer" name="btnTransfer" 
                        title="Перенести в область того что находиться в базе данных"> 
                    &#62; &#62;
                </button>
                <form id="formSaveDataPageInDB" action="" method="post">
                    <input type="submit" value="сохранить в БД" name="btnSaveDataPageInDB" id="btnSaveDataPageInDB">
                </form>
                    
           </div>
        </main>       
    </body>
</html>

