<?php
    session_start();
    if (!(isset($_SESSION['authorized']) && $_SESSION['authorized']=='Benny Bennasy'))
    {
        header("Location: "."login.php");
    }
    require_once 'functions.php';
    require_once 'modelUserOption.php';
    
    if (isset($_SESSION['errorMes']))
    {
        $error=$_SESSION['errorMes'];
        unset($_SESSION['errorMes']);
    }
    if (isset($_SESSION['loginSms']))
    {
        $loginSms=$_SESSION['loginSms'];
        unset($_SESSION['loginSms']);
    }
    //debug($_SESSION);
    require_once 'modelUserOption.php';
    $DBUserOption=new modelUserOption();
    $data=$DBUserOption->getSmsOption();
  //  debug($data);
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html> <!--<![endif]--> 
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style/main.css" type="text/css">
        <link rel="stylesheet" href="style/option.css" type="text/css">
        <script src="scripts/jquery-1.10.2.min.js" type="text/javascript"></script>
        <script src="scripts/option.js" type="text/javascript"></script>
        <script src="scripts/position.js" type="text/javascript"></script>
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
        <main>  
        <div id="main">    
         
            <h1>Настройки</h1>
            <form id="formChangePassword" action="serverFunc.php" method="post">
                <div id="divChangePassword">
                    <h4>Изменение пароля</h4>
                    <p>Старый пароль</p>
                    <input type="password" name="passwordOld" class="inputText">
                    <p>Новый пароль</p>
                    <input type="password" name="passwordNew" class="inputText">
                    <p>Повторение нового пароля</p>
                    <input type="password" name="passwordNew2"class="inputText">
                    <br>
                    <input type="submit" id="btnChangePassword" name="btnChangePassword" value="Изменить пароль">
                </div>
            </form>
            
            <form id="formSmsOption" action="serverFunc.php" method="post"> 
                <h4>Настройка СМС уведомлений</h4>
                <input type="checkbox" name="checkboxSms" id="checkboxSms"  class="chBox"
                     <?php if ($data['sms_submit']==1 ) echo "checked" ?> id="checkboxSMS" >
                <label for="checkboxSMS">Отправлять СМС уведомления</label>
                <?php if ($data['login_smsfeedback']!=''):?>
                    <h4> Ваш логин от smsfeedback: <?=$data['login_smsfeedback'] ?></h4>
                 <?php else:?>
                    <h4> Аккаунт от smsfeedback не введен</h4>
                <?php endif?>
                <p class="SMS">Логин от нового аккаунта smsfeedback</p>
                <input type="text" class="SMS inputText" name="loginSmsFeedBack" 
                       value="<?=$loginSms?>"
                >
                <p class="SMS">Пароль от нового аккаунта smsfeedback</p>
                <input type="password" class="SMS inputText" name="passwordSmsFeedBack" >
                <br>
                <input type="submit"class="SMS" id="btnChangeAccountSms" name="btnChangeAccountSms" 
                       value="<?php if ($data['login_smsfeedback']!='') echo "Изменить аккаунт";
                           else echo "Добавить аккаунт";
                        ?>"
                >
                <p class="SMS">Телефон</p>
                <span id="spanTelephone">+7</span>
                <input type="text" class="SMS " id="telephone" name="telephone"value="<?=substr($data['telephone'],1) ?>"
                       title="Номер телефона на который будут присылаться СМС уведомления"          
                >
                
                
                <br>
                
                <input type="checkbox" name="checkboxSmsSize" id="checkboxSmsSize"  class="chBox SMS"
                     <?php if ($data['sms_size']==1 ) echo "checked" ?>  >
                <label for="checkboxSmsSize">Отправлять СМС, если размер страницы вышел за допустимый диапазон.</label>
                
                <br>
                
                <input type="checkbox" name="checkboxSmsMeta" id="checkboxSmsMeta" class="chBox SMS"
                     <?php if ($data['sms_meta']==1 ) echo "checked" ?>  >
                <label for="checkboxSmsMeta">Отправлять СМС, если неверен h1, title, keywords или description.</label>
                
                <br>
                
                <input type="checkbox" name="checkboxSmsNormal" id="checkboxSmsNormal" class="chBox SMS"
                     <?php if ($data['sms_normal']==1 ) echo "checked" ?>  >
                <label for="checkboxSmsNormal">Отправлять СМС, если страница на мониторинге, начала нормально работать.</label>
                
                <br>
                <input type="checkbox" name="checkboxSmsBalance" id="checkboxSmsBalance" class="chBox SMS"
                     <?php if ($data['sms_balance']==1 ) echo "checked" ?> >
                <label for="checkboxSmsBalance">Отправлять СМС, если баланс менее 10 руб.</label>
                
                <br>
                <input type="submit" id="btnSaveOption" name="btnSaveOption" value="Сохранить">
            </form>
                
            <form id="formAccountOption" action="serverFunc.php" method="post">
                <h4> Настройки аккаунта</h4>
                <input type="submit" id="btnDeleteData" name="btnDeleteData" value="Удалить данные о страницах">
                <br>
                <input type="submit" id="btnDeleteAccount" name="btnDeleteAccount" value="Удалить аккаунт"> 
            </form>   
        </div>    
        </main>    
        <?php if (isset($error)):?>
        <div id="divScreen">
            <div id="divMessageError">
                <h3>Сообщение</h3>
                <p>
                   <?=$error?>
                </p>
                <button name="btnError" >Ok</button>

            </div>
        </div>
        <?php endif?>
    </body>
</html>