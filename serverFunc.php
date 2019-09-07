<?php
session_start();
require 'functions.php';
require 'modelDBForCheck.php';
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
        if ($DBForCheck->checkRecordByUrl($_POST['url'])==false)
        {
         //   echo "222";
            //////////
            $DBForCheck->insertInDB($url,$sizePage,$deviationSize,$h1,$title,$keywords,$description);
            require_once 'main.php';
            $data=readDataOneForCheckByUrl($url);
            //debug($data);
            insertDBCheckOne(checkOne($data));

        }
    }
    else
    {
       /// echo "111";
        if ($DBForCheck->checkRecordByUrl($_POST['url'])==true)
        {
            $DBForCheck->updateRecordByUrl($url,$sizePage,$deviationSize,$h1,$title,$keywords,$description); 
            require_once 'main.php';
            $data=readDataOneForCheckByUrl($url);
            //debug($data);
            updateDBCheckOne(checkOne($data));
        }
    }
    //debug($_POST);
    header("Location: "."index.php");
}
if (isset($_POST['btnPause_x']))// если нажата пауза на странице index
{
    debug($_POST);
    $conn=connectDB();
    $DBForCheck=new modelDBForCheck; 
    $DBForCheck->setConn($conn);
    $DBForCheck->updateStatePauseByUrl($_POST['urlOfPause'],1);
}
if (isset($_POST['btnDelete_x']))// если нажата  снять с мониторинга на странице index
{
    debug($_POST);
}
