<?php
session_start();
require 'functions.php';
require 'modelDBForCheck.php';
require_once 'modelDBResultCheck.php';
//debug($_POST);
if (isset($_POST['btnSaveDataPageInDB']))// если нажата кнопка сохранитть на странице PAGE
{   
    
    if (checkUrl($_POST['url'])==false)
    {
        $_SESSION['message_data']='Неверно введен URL';
        header("Location: ".$_SERVER["HTTP_REFERER"]);
        exit;
    }
    if (checkStrInt($_POST['dataSizeDB'])==false)
    {
        //echo "size == int";
        //echo '<br>';
        $_SESSION['message_data']='Размер страницы должен быть целым числом не больше 2147483647';
        header("Location: ".$_SERVER["HTTP_REFERER"]);
        exit;
    }
    if (checkStrInt($_POST['dataDeviationSizeDB'])==false)
    {
        $_SESSION['message_data']='Погрешность размера страницы должна быть целым числом не больше 2147483647';
        header("Location: ".$_SERVER["HTTP_REFERER"]);
        exit;
    }
    $conn=connectDB();
    $DBForCheck=new modelDBForCheck; 
    $DBForCheck->setConn($conn);
    $url=$_POST['url'];
    $sizePage=$_POST['dataSizeDB'];
    $deviationSize=$_POST['dataDeviationSizeDB'];
    $h1=$_POST['dataH1DB'];
    $title=$_POST['dataTitleDB'];
    $keywords=$_POST['dataKeywordsDB'];
    $description=$_POST['dataDescriptionDB'];
     //debug($_POST);
    if (isset($_POST['newPage'])&&$_POST['newPage']==true)
    {
    //    echo "333";
     //   debug($_POST);
        if ($DBForCheck->checkRecordByUrl($_POST['url'])==false)// если нет записи в for_check 
        {
         //   echo "222";
            //////////
            $DBForCheck->insertInDB($url,$sizePage,$deviationSize,$h1,$title,$keywords,$description);
            require_once 'main.php';
            $DBResultCheck=new modelDBResultCheck();
            $data=$DBForCheck->readDBOneRecordByURL($url);
            //debug($data);
            $DBResultCheck->insertDBCheckOne(checkOne($data));

        }
    }
    else
    {
       /// echo "111";
       if ($DBForCheck->checkRecordByUrl($_POST['url'])==true)// если есть запись в for_check
        {
            $DBForCheck->updateRecordByUrl($url,$sizePage,$deviationSize,$h1,$title,$keywords,$description); 
            require_once 'main.php';
            $DBResultCheck=new modelDBResultCheck();
            $data=$DBForCheck->readDBOneRecordByURL($url);
            //debug($data);
            $DBResultCheck->updateDBCheckOne(checkOne($data));
        }
    }
    //debug($_POST);
    header("Location: "."index.php");
}
if (isset($_POST['btnPause_x']))// если нажата пауза на странице index
{
   // debug($_POST);
    $conn=connectDB();
    $DBForCheck=new modelDBForCheck; 
    $DBForCheck->setConn($conn);
    $DBForCheck->updateStatePauseByUrl($_POST['urlOfPause'],1);
    header("Location: "."index.php");
}
if (isset($_POST['btnPlay_x']))// если нажата пауза на странице index
{
   // debug($_POST);
    $conn=connectDB();
    $DBForCheck=new modelDBForCheck; 
    $DBForCheck->setConn($conn);
    $DBForCheck->updateStatePauseByUrl($_POST['urlOfPause'],0);
    header("Location: "."index.php");
}
if (isset($_POST['btnDelete_x']))// если нажата  снять с мониторинга на странице index
{
    //debug($_POST);
    $conn=connectDB();
    $DBForCheck=new modelDBForCheck; 
    $DBForCheck->setConn($conn);
    $DBForCheck->deleteOneRecordByUrl($_POST['urlOfDelete']);
    include_once 'main.php';
    $DBResultCheck=new modelDBResultCheck();
    $DBResultCheck->deleteOneRecResCheckByUrl($_POST['urlOfDelete']);
    header("Location: "."index.php");
}
if (isset($_POST['btnSearchJournal']))
{
    require_once 'modelJournal.php';
    $journal=new Journal;
    $_SESSION['resultSearch']=$journal->searchAndGetResult($_POST['querySearchJournal']);
    //debug($_POST);
    header("Location: "."journal.php");
    //debug($_POST);
    
}