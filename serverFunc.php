<?php
session_start();
require 'functions.php';
require 'modelDBForCheck.php';
require_once 'modelDBResultCheck.php';
//debug($_POST);
//ini_set('display_errors', 'On'); // сообщения с ошибками будут показываться
//error_reporting(E_ALL); // E_ALL - отображаем ВСЕ ошибки
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
    require_once 'modelJournal.php';
    $journal=new Journal();
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
            $journal->updateJournal();
        }
    }
    else// если мы сохранеям данные о ранее поставленой на мониторинг странице
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
            $journal->updateJournal();
        }
    }
    //debug($_POST);
    header("Location: "."index.php");
}
if (isset($_POST['btnPause_x']))// если нажата пауза на странице index
{
    //debug($_POST);
    $conn=connectDB();
    $DBForCheck=new modelDBForCheck; 
    $DBForCheck->setConn($conn);
    $DBForCheck->updateStatePauseByUrl($_POST['urlOfPause'],1);
    if (empty($_POST['numpage']))
    {
        header("Location: "."index.php");
    }
    else
    {
        header("Location: "."index.php?numpage={$_POST['numpage']}");
    }
}
if (isset($_POST['btnPlay_x']))// если нажата пауза на странице index
{
    //debug($_POST);
    $conn=connectDB();
    $DBForCheck=new modelDBForCheck; 
    $DBForCheck->setConn($conn);
    $DBForCheck->updateStatePauseByUrl($_POST['urlOfPause'],0);
    if (empty($_POST['numpage'])||$_POST['numpage']==1)
    {
        header("Location: "."index.php");
    }
    else
    {
        header("Location: "."index.php?numpage={$_POST['numpage']}");
    }
}
if (isset($_POST['btnDelete_x']))// если нажата  снять с мониторинга на странице index
{
    //debug($_POST);
    require_once 'modelJournal.php';
    $conn=connectDB();
    $DBForCheck=new modelDBForCheck; 
    $journal=new Journal;
    $DBForCheck->setConn($conn);
    $DBForCheck->deleteOneRecordByUrl($_POST['urlOfDelete']);
    //include_once 'main.php';
    $DBResultCheck=new modelDBResultCheck();
    $DBResultCheck->deleteOneRecResCheckByUrl($_POST['urlOfDelete']);
    $journal->deleteByUrl($_POST['urlOfDelete']);
    if (empty($_POST['numpage'])||$_POST['numpage']==1)
    {
        header("Location: "."index.php");
    }
    else
    {
        header("Location: "."index.php?numpage={$_POST['numpage']}");
    }
}
if (isset($_POST['btnSearchJournal']))// если нажата кнопка поиск в журале
{
    require_once 'modelJournal.php';
    $journal=new Journal;
    $_SESSION['resultSearch']=$journal->searchAndGetResult($_POST['querySearchJournal']);
    $_SESSION['querySearch']=$_POST['querySearchJournal'];
    //$_GET['numpage']=1;
    //debug($_POST);
    header("Location: "."journal.php?numpage=1");
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
    require_once "crypt.php";
    $crypt=new MCrypt();
    // создаем переменные для записи в бд
    $name=$_POST['nameUser'];
    $surname=$_POST['surnameUser'];
    $login=$_POST['login'];
    $password=$_POST['password'];
    $password=crypt($password, '_J9..rasm') ;
    if ($_POST['checkboxSms']=='on') $smsSubmit=1; else $smsSubmit=0;
    $loginSmsFeedBack=$_POST['loginSmsFeedBack'];
    if (isset($_POST['passwordSmsFeedBack']))
    {
        $passwordSmsFeedBack=$crypt->encrypt($_POST['passwordSmsFeedBack']);
    }
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
if (isset($_POST['btnLogin']))// если нажата кнопка войти
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
        $_SESSION['data']=$_POST;
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
        $_SESSION['data']=$_POST;
        header("Location: "."login.php");
        exit;
   } 
}
if (isset($_POST['btnChangePassword']))// если нажата кнопка изменить пароль в настройках
{
   // debug($_POST);
    if ($_POST['passwordOld']=='')// если не введен пароль
    { 
         $_SESSION['errorMes']='Не введен старый пароль.';
         //debug($_SESSION['errorMes']);
         header("Location: "."option.php");
         exit;
    }
     if ($_POST['passwordNew']=='')// если не введен новый пароль
    { 
         $_SESSION['errorMes']='Не введен новый пароль.';
         //debug($_SESSION['errorMes']);
         header("Location: "."option.php");
         exit;
    }
    if ($_POST['passwordNew2']!=$_POST['passwordNew']) // если новый и новый пароль 2 не совпадают
    { 
         $_SESSION['errorMes']='Новые пароли не совпадают.';
        // debug($_SESSION['errorMes']);
         header("Location: "."option.php");
         exit;
    }
    if (strlen($_POST['passwordNew'])<6)// если длина нового пароля меньше 6
    { 
         $_SESSION['errorMes']='Длина пароля должна быть не менее 6 символов.';
         //debug($_SESSION['errorMes']);
         header("Location: "."option.php");
         exit;
    }
    require_once 'modelUserOption.php';
    $DBUserOption=new modelUserOption();
    //debug($DBUserOption->getPassword());
    $passwordDB=$DBUserOption->getPassword();
    
    if (crypt($_POST['passwordOld'], '_J9..rasm')!=$passwordDB)// если старый пароль не верен
    {
         $_SESSION['errorMes']='Старый пароль не верен.';
         //debug($_SESSION['errorMes']);
         header("Location: "."option.php");
         exit; 
    }
    else if (crypt($_POST['passwordOld'], '_J9..rasm')==$passwordDB)// если старый пароль верен
    {
        $DBUserOption->updatePassword(crypt($_POST['passwordNew'], '_J9..rasm'));
        $_SESSION['errorMes']='Пароль успешно обновлен.';
        header("Location: "."option.php");
        exit; 
    }
    
}
if (isset($_POST['btnChangeAccountSms']))// если нажата кнопка изменить аккаунт от smsfeedback
{
    if($_POST['loginSmsFeedBack']=="")
    {
        $_SESSION['errorMes']='Не введен логин от smsfeedback.';
        header("Location: "."option.php");
        exit;
    }
    if($_POST['passwordSmsFeedBack']=="")
    {
        $_SESSION['errorMes']='Не введен пароль от smsfeedback.';
        $_SESSION['loginSms']=$_POST['loginSmsFeedBack'];
        header("Location: "."option.php");
        exit;
    }
    require_once 'SMS.php';
    $resultBalance=balance("api.smsfeedback.ru", 80, $_POST['loginSmsFeedBack'],
                    $_POST['passwordSmsFeedBack']);
    $resBalanceLen=strlen($resultBalance);
    if ($resBalanceLen>40)// если не удалось получить баланс, а получили сообшение об ошибке, которое длинное
    {
      $_SESSION['errorMes']="логин или пароль от smsfeedback.ru не верен.";  
      $_SESSION['loginSms']=$_POST['loginSmsFeedBack'];
      header("Location: "."option.php");
      exit; 
    }
    else
    {
        require_once 'modelUserOption.php';
        require_once 'crypt.php';
        $crypt=new MCrypt();
        $DBUserOption=new modelUserOption();   
        $DBUserOption->updateLoginPasswordSmsFeedBack($_POST['loginSmsFeedBack'],
                                                     $crypt->encrypt($_POST['passwordSmsFeedBack']) );
        $DBUserOption->updateSmsSubmit(1);
        $_SESSION['errorMes']="Аккаунт от smsfeedback успешно изменен.";
        header("Location: "."option.php");
        exit; 
    }
}
if (isset($_POST['btnSaveOption']))// сохранить настройки аккаунта для смс
{
    require_once 'modelUserOption.php';
    $DBUserOption=new modelUserOption();
    if ($_POST['checkboxSms']=="on")
    {
        if (strlen($_POST['telephone'])!=10)// проверяем что телефон введен полностью
        {  
            $_SESSION['errorMes']="длина номера телефона должна быть 10 цивр.";  
            header("Location: "."option.php");
            exit; 
        }   //varietyStr
        if (varietyStr("0123456789",$_POST['telephone'])==false)// проверяем что поле с телефоном состоит только из цифр
        {
            //echo "size == int";
            //echo '<br>';
            $_SESSION['errorMes']='номер телефона должен состоять только из цивр.';
            header("Location: "."option.php");
            exit;
        }
       
       // debug($_POST);
        $telephone='7'.$_POST['telephone'];
        if ($_POST['checkboxSms']=='on') $smsSubmit=1; else $smsSubmit=0;
        if ($_POST['checkboxSmsSize']=='on') $smsSize=1; else $smsSize=0;
        if ($_POST['checkboxSmsMeta']=='on') $smsMeta=1; else $smsMeta=0;
        if ($_POST['checkboxSmsNormal']=='on') $smsNormal=1; else $smsNormal=0;
        if ($_POST['checkboxSmsBalance']=='on') $smsBalance=1; else $smsBalance=0;
        $loginPasswordSms=$DBUserOption->getSmsOptionLoginPassword();
        // проверяем есть ли аккунт smsfeedback в БД
        if ($loginPasswordSms['login_smsfeedback']==''||$loginPasswordSms['password_smsfeedback']=='')
        {// если не аккаунта smsfeedback
            $smsSubmit=0;
            $_SESSION['errorMes']="Нет аккаунта от smsfeedback.";  
        }
        $DBUserOption->updateSmsOption($telephone, $smsSubmit, $smsSize, $smsMeta, $smsNormal, $smsBalance);
        
    }
    else
    {
        $DBUserOption->updateSmsSubmit(0);
    }
    header("Location: "."option.php");
    exit;
}
if (isset($_POST['btnDeleteData']))// если нажата кнопка удалить данные в настройках
{
    require_once 'functions.php';
    require_once 'modelDBForCheck.php';
    require_once 'modelDBResultCheck.php';
    require_once 'modelJournal.php';
    
    $DBForCheck=new modelDBForCheck();
    $DBResultCheck=new modelDBResultCheck();
    $journal=new Journal();
    
    $DBForCheck->setConn(connectDB());
    
    $DBForCheck->deleteData();
    $DBResultCheck->deleteData();
    $journal->deleteData();
    header("Location: "."option.php");
    exit;
}
if (isset($_POST['btnDeleteAccount']))// если нажата кнопка удалить аккаунт
{
    require_once 'modelDBForCheck.php';
    require_once 'modelDBResultCheck.php';
    require_once 'modelJournal.php';
    require_once 'modelUserOption.php';
    require_once 'modelDataServis.php';
    
    $DBForCheck=new modelDBForCheck();
    $DBResultCheck=new modelDBResultCheck();
    $journal=new Journal();
    $DBUserOption=new modelUserOption();
    $dataServis=new modelDataServis();
    
    $DBForCheck->setConn(connectDB());
    
    $DBForCheck->deleteData();
    $DBResultCheck->deleteData();
    $journal->deleteData(); 
    $DBUserOption->deleteData();
    $dataServis->updateSmsBalanceSubmit(0);
    $dataServis->updateCheckAllTime(0);
    session_destroy();
    header("Location: "."registration.php");
    exit;
}
if (isset ($_GET['exit'])&&$_GET['exit']=="true")// если нажали на ссылку выход.
{
    //unset($_SESSION['authorized']);
    session_destroy();
    header("Location: "."login.php");
    exit;
}
