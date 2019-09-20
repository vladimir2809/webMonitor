<?php
session_start();
require 'functions.php';
require 'modelDBForCheck.php';
require_once 'modelDBResultCheck.php';
//debug($_POST);
if (isset($_POST['btnSaveDataPageInDB']))// если нажата кнопка сохранитть на странице PAGE
{   
    
    if (checkUrl($_POST['url'])==false)// проверить URL
    {
        $_SESSION['message_data']='Неверно введен URL';
        header("Location: ".$_SERVER["HTTP_REFERER"]);
        exit;
    }
    if (checkStrInt($_POST['dataSizeDB'])==false)// проверить число размера страницы
    {
        //echo "size == int";
        //echo '<br>';
        $_SESSION['message_data']='Размер страницы должен быть целым числом не больше 2147483647';
        header("Location: ".$_SERVER["HTTP_REFERER"]);
        exit;
    }
    if (checkStrInt($_POST['dataDeviationSizeDB'])==false)// проверить число размера погрешности страницы
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
    if (isset($_POST['newPage'])&&$_POST['newPage']==true)// если мы ставим на монитооринг новую страницу
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
    else// если мы сохранеям даннцые о ранее поставленой на мониторинг странице
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
if (isset($_POST['btnSearchJournal']))// если нажата кнопка поиск в журале
{
    require_once 'modelJournal.php';
    $journal=new Journal;
    $_SESSION['resultSearch']=$journal->searchAndGetResult($_POST['querySearchJournal']);
    //debug($_POST);
    header("Location: "."journal.php");
    //debug($_POST);
    
}
if (isset($_POST['btnRegistration']))// если нажата кнопка зарегистрироваться
{
    $_SESSION['data']=$_POST;
    if (strlen($_POST['nameUser'])<3)// проверим имя на длину
    {
        $_SESSION['errorReg']="Имя должно быть не менее 3 символов.";
        header("Location: "."registration.php");
        exit;
    }
    if (strlen($_POST['surnameUser'])<3)// проверим фамилию на длину
    {
        $_SESSION['errorReg']="Фамилия должна быть не менее 3 символов.";
        header("Location: "."registration.php");
        exit;
    }
    if (strlen($_POST['login'])<3)// проверим логин на длину
    {
        $_SESSION['errorReg']="Логин должен быть не менее 3 символов.";
        header("Location: "."registration.php");
        exit;
    }
    if (strlen($_POST['password'])<6)// проверим пароль на длину
    {
        $_SESSION['errorReg']="Пароль должен быть не менее 6 символов.";
        header("Location: "."registration.php");
        exit;
    }
    if ($_POST['password']!=$_POST['password2'])// проверим на совпадение паролей
    {
        $_SESSION['errorReg']="Введенные пароли не совпадают.";
        header("Location: "."registration.php");
        exit;
    }
    if ($_POST['checkboxSms']=='on')// если включен ческбокс отправлять смс
    {
        require_once 'SMS.php';
        $resultBalance=balance("api.smsfeedback.ru", 80, $_POST['loginSmsFeedBack'],
                        $_POST['passwordSmsFeedBack']);
        $resBalanceLen=strlen($resultBalance);
        if ($resBalanceLen>40)// если не удалось получить баланс, а получили сообшение об ошибке, которое длинное
        {
          $_SESSION['errorReg']="логин или пароль от smsfeedback.ru не верен.";  
          header("Location: "."registration.php");
          exit; 
        }
        if (strlen($_POST['telephone'])!=10)// проверяем что телефон введен полностью
        {  
            $_SESSION['errorReg']="длина номера телефона должна быть 10 цивр.";  
            header("Location: "."registration.php");
            exit; 
        }   //varietyStr
        if (varietyStr("0123456789",$_POST['telephone'])==false)// проверяем что поле с телефоном состоит только из цифр
        {
            //echo "size == int";
            //echo '<br>';
            $_SESSION['errorReg']='номер телефона должен состоять только из цивр.';
            header("Location: "."registration.php");
            exit;
        }
        
        
    }
    require_once 'modelUserOption.php';
    // создаем перемнные для записи в бд
    $name=$_POST['nameUser'];
    $surname=$_POST['surnameUser'];
    $login=$_POST['login'];
    $password=$_POST['password'];
    $password=crypt($password, '_J9..rasm') ;
    if ($_POST['checkboxSms']=='on') $smsSubmit=1; else $smsSubmit=0;
    $loginSmsFeedBack=$_POST['loginSmsFeedBack'];
    $passwordSmsFeedBack=$_POST['passwordSmsFeedBack'];
    $telephone='7'.$_POST['telephone'];
    
    $DBUserOption=new modelUserOption();
    
    if ($DBUserOption->checkRecordInDB()==false)// если записи в user_option нет
    {
        $DBUserOption->insertUserOption($name, $surname, $login, $password, $smsSubmit, 
                                        $loginSmsFeedBack, $passwordSmsFeedBack, $telephone);
        $_SESSION['authorized']="Benny Bennasy";
        header("Location: "."index.php");
    }
}
if (isset($_POST['btnLogin']))// если нажата кнопка ввойти
{
   require_once 'modelUserOption.php';
   $DBUserOption=new modelUserOption();
  
   $loginPassword=$DBUserOption->getLoginPassword();
   //debug($_POST); 
   if ($_POST['login']=='')// если не введен логин
   { 
        $_SESSION['errorMes']='Не введен логин.';
        header("Location: "."login.php");
        exit;
   }
   if ($_POST['password']=='')// если не введен пароль
   { 
        $_SESSION['errorMes']='Не введен пароль.';
        header("Location: "."login.php");
        exit;
   }
   // проверка логина и пароля для входа
   if ($_POST['login']==$loginPassword['login']
           && crypt($_POST['password'], '_J9..rasm')==$loginPassword['password'])
   {
       $_SESSION['authorized']="Benny Bennasy";
       header("Location: "."index.php");
       exit;
   }
   else 
   {
        $_SESSION['errorMes']='Неверно введен логин или пароль.';
        header("Location: "."login.php");
        exit;
   } 
}
if (isset ($_GET['exit'])&&$_GET['exit']=="true")// если нажали на ссылку выход.
{
    unset($_SESSION['authorized']);
    header("Location: "."login.php");
    exit;
}
