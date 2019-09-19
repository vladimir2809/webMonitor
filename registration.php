<?php
    require_once 'functions.php';
    require_once 'modelUserOption.php';
    session_start();
    if (isset($_SESSION['errorReg']))
    {
        $error=$_SESSION['errorReg'];
        unset($_SESSION['errorReg']);
    }
    //debug($_SESSION);
    $data=$_SESSION['data'];
    unset($_SESSION['data']);
    
    $DBUserOption=new modelUserOption();
    
    if ($DBUserOption->checkRecordInDB()==true)
    {
        header("Location: "."login.php");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style/registration.css" type="text/css">
        <script src="scripts/jquery-1.10.2.min.js" type="text/javascript"></script>
        <script src="scripts/registration.js" type="text/javascript"></script>
        <title> WebMonitor</title>   
    </head>    
    <body>
        <header>
            <h1> WEB MONITOR</h1>   
        </header>   
        <main>
            <div id="divInform">
                <p>
                    Вас приветствует WebMonitor! Это программа предназначена для того что-бы отслеживать
                    работоспособность сайтов в реальном времени. WebMonitor проверяет заданные веб страницы
                    по следуюшим параметрам: Код ответа сервера; Размер страницы (не вышел ли он за допустимый 
                    диапозон); На соответсвие h1, title, keywords, description с тем что находиться в базе данных 
                    программы WebMonitor. В случае если какой либо параметр отколонился от нормальных, программа 
                    WebMonitor вышлет СМС уведомление на номер указанный пользователем в форме регистрации.
                </p>
                <p>
                   Для работы СМС уведомлений нужно иметь аккаунт на сайте  <a href="http://smsfeedback.ru" target="_blank">smsfeedback.ru</a>.
                </p>
                <p>
                    Если у вас нет аккаунта от сайта smsfeedback.ru. Перейдите по ссылке 
                    <a href="https://www.smsfeedback.ru/users/registration/" target="_blank">smsfeedback.ru Регистрация</a>. 
                    Зарегистрируйтесь и введите ваш логин и пароль от сайта smsfeedback.ru в соответсвующие 
                    поля в форме регистрации.
                </p>
                <p>
                    Вы можете отказаться от СМС уведомлений. Для просмотра результатов проверок страниц,
                    в программе WebMonitor есть журнал, который хранит результаты проверок страниц. Вы можете
                    в любое время его просматривать.
                </p>
            </div>
            <form action="serverFunc.php" method="post" id="formRegistration">
                <h2>Регистрация</h2>
                <p>Ваше Имя</p>
                <input type="text" name="nameUser" value="<?=$data['nameUser'] ?>">
                <p>Ваша Фамилия</p>
                <input type="text" name="surnameUser"value="<?=$data['surnameUser'] ?>">
                <p>Логин</p>
                <input type="text" name="login"value="<?=$data['login'] ?>">
                <p>Пароль (не менее 6 символов)</p>
                <input type="password" name="password"value="<?=$data['password'] ?>">
                <p>Повторите пароль</p>
                <input type="password" name="password2" value="<?=$data['password2'] ?>">
                <div id="divCheckbox">
                    <input type="checkbox" name="checkboxSms"
                         <?php if ($data['checkboxSms']=="on" || !isset($data)) echo "checked" ?> id="checkboxSMS" >
                    <label for="checkboxSMS">Отправлять СМС</label>
                </div>
                <p class="SMS">Логин от smsfeedback</p>
                <input type="text" class="SMS" name="loginSmsFeedBack"value="<?=$data['loginSmsFeedBack'] ?>">
                <p class="SMS">Пароль от smsfeedback</p>
                <input type="password" class="SMS" name="passwordSmsFeedBack" value="<?=$data['passwordSmsFeedBack'] ?>">
                <p class="SMS">Телефон</p>
                <span id="spanTelephone">+7</span>
                <input type="text" class="SMS" id="telephone" name="telephone"value="<?=$data['telephone'] ?>">
                <br>
                <input type="submit" name="btnRegistration" id="submitReg" value="Зарегистрироваться">
                
            </form>
          
        </main>  
        <?php if (isset($error)):?>
        <div id="divScreen">
            <div id="divMessageError">
                    <h3>Сообщение об ошибке</h3>
                    <p>
                       <?=$error?>
                    </p>
                    <button name="btnError" >Ok</button>

            </div>
        </div>
        <?php endif?>
    </body>
</html>

