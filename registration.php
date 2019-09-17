<?php
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style/registration.css" type="text/css">
        <title> WebMonitor</title>   
    </head>    
    <body>
        <header>
            <h1> WEB MONITOR</h1>   
        </header>   
        <main>
            <h2>Регистрация</h2>
            <form action="serverFunc.php" method="post" id="formRegistration">
                <p>Ваше Имя</p>
                <input type="text" name="nameUser">
                <p>Ваша Фамилия</p>
                <input type="text" name="surnameUser">
                <p>Логин</p>
                <input type="text" name="login">
                <p>Пароль</p>
                <input type="password" name="password">
                <p>Логин от smsfeedback</p>
                <input type="text" name="loginSmsFeedBack">
                <p>Пароль от smsfeedback</p>
                <input type="password" name="passwordSmsFeedBack">
                <p>Телефон</p>
                <input type="text" name="telephone">
                <br>
                <input type="submit" name="btnRegaistration" id="submitReg" value="Зарегистрироваться">
                
            </form>
        </main>
    </body>
</html>

