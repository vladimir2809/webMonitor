<?php
session_start();
require 'functions.php';
require 'modelDBForCheck.php';
//debug($_POST);
if (isset($_POST['btnSaveDataPageInDB']))
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
    if (isset($_POST['newPage']))
    {
        if ($DBForCheck->checkRecordByUrl($_POST['url'])==false)
        {
            $url=$_POST['url'];
            $sizePage=$_POST['dataSizeDB'];
            $deviationSize=$_POST['dataDeviationSizeDB'];
            $h1=$_POST['dataH1DB'];
            $title=$_POST['dataTitleDB'];
            $keywords=$_POST['dataKeywordsDB'];
            $description=$_POST['dataDescriptionDB'];
            //////////
            $DBForCheck->insertInDB($url,$sizePage,$deviationSize,$h1,$title,$keywords,$description);
            require_once 'main.php';
            $data=readDataOneForCheckByUrl($url);
            debug($data);
            insertDBCheckOne(checkOne($data));

        }
    }
    else
    {
        
    }
    //debug($_POST);
    header("Location: "."index.php");
}

