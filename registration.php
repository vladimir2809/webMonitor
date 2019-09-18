<?php
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
                    Вас приветствует WebMonitor! Это программа прдназначена для того что-бы отслеживать
                    работоспособность сайтов в реальном времени. WebMonitor проверяет заданные веб страницы
                    по следуюшим параметрам: Код ответа сервера; Размер страницы (не вышел ли он за допустимый 
                    диапозон); На соответсвие h1, title, keywords, description с тем что находиться в базе данных 
                    программы WebMonitor. В случае если какой либо параметр отколонился от нормальных, программа 
                    WebMonitor вышлет СМС уведомление на номер указанный пользователем в форме регистрации.
                </p>
                <p>
                   Для работы СМС уведомлений нужно иметь аккаунт на сайте  <a href="http://smsfeedback.ru">smsfeedback.ru</a>.
                </p>
                <p>
                    Если у вас нет аккаунта от сайта smsfeedback.ru. Перейдите по ссылке 
                    <a href="https://www.smsfeedback.ru/users/registration/">smsfeedback.ru Регистрация</a>. 
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
                <input type="text" name="nameUser">
                <p>Ваша Фамилия</p>
                <input type="text" name="surnameUser">
                <p>Логин</p>
                <input type="text" name="login">
                <p>Пароль</p>
                <input type="password" name="password">
                <p>Повторите пароль</p>
                <input type="password" name="password2">
                <div id="divCheckbox">
                    <input type="checkbox" name="checkboxSms" checked id="checkboxSMS">
                    <label for="checkboxSMS">Отправлять СМС</label>
                </div>
                <p class="SMS">Логин от smsfeedback</p>
                <input type="text" class="SMS" name="loginSmsFeedBack">
                <p class="SMS">Пароль от smsfeedback</p>
                <input type="password" class="SMS" name="passwordSmsFeedBack">
                <p class="SMS">Телефон</p>
                <span id="spanTelephone">+7</span>
                <input type="text" class="SMS" id="telephone" name="telephone">
                <br>
                <input type="submit" name="btnRegistration" id="submitReg" value="Зарегистрироваться">
                
            </form>
            
        </main>
    </body>
</html>

