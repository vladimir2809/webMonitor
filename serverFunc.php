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
    if (!(is_numeric($_POST['dataSizeDB']) && is_int($_POST['dataSizeDB']+0)))
    {
        //echo "size == int";
        //echo '<br>';
        $_SESSION['message_data']='Размер страницы должен быть целым числом';
        header("Location: ".$_SERVER["HTTP_REFERER"]);
        exit;
    }
    if (!(is_numeric($_POST['dataDeviationSizeDB']) && is_int($_POST['dataDeviationSizeDB']+0)))
    {
        $_SESSION['message_data']='Погрешность размера страницы должна быть целым числом';
        header("Location: ".$_SERVER["HTTP_REFERER"]);
        exit;
    }
    $conn=connectDB();
    $DBForCheck=new modelDBForCheck; 
    $DBForCheck->setConn($conn);
    $DBForCheck->checkRecordByUrl($_POST['url']);
    debug($_POST);
    //header("Location: "."index.php");
}

