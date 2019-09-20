<?php
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style/main.css" type="text/css">
        <link rel="stylesheet" href="style/option.css" type="text/css">
        <script src="scripts/jquery-1.10.2.min.js" type="text/javascript"></script>
        <script src="scripts/option.js" type="text/javascript"></script>
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
            
            <li><div> <a href="#"><p>Пополнить баланс</p></a> </li></div>
            
            <li><div> <a href="journal.php"><p>Журнал</p></a></li></div>
            <li><div> <a href="serverFunc.php?exit=true"><p>Выход</p></a></li></div>
             </ul>
        </nav>
        <main>  
            <h1>Настройки</h1>
            <form id="formOption" action="serverFunc.php" method="post">
                <div id="divChangePassword">
                    <h4>Изменение пароля</h4>
                    <p>Старый пароль</p>
                    <input type="password" name="passwordOld" class="inputText">
                    <p>Новый пароль</p>
                    <input type="password" name="PasswordNew" class="inputText">
                    <p>Повторение нового пароля</p>
                    <input type="password" name="passwordNew2"class="inputText">
                    <br>
                </div>
                <h4>Настройка СМС уведомлений</h4>
                <input type="checkbox" name="checkboxSms" id="checkboxSms"  class="chBox"
                     <?php if ($data['checkboxSms']=="on" || !isset($data)) echo "checked" ?> id="checkboxSMS" >
                <label for="checkboxSMS">Отправлять СМС</label>

                <p class="SMS">Логин от smsfeedback</p>
                <input type="text" class="SMS inputText" name="loginSmsFeedBack"value="<?=$data['loginSmsFeedBack'] ?>">
                <p class="SMS">Пароль от smsfeedback</p>
                <input type="password" class="SMS inputText" name="passwordSmsFeedBack" value="<?=$data['passwordSmsFeedBack'] ?>">
                <p class="SMS">Телефон</p>
                <span id="spanTelephone">+7</span>
                <input type="text" class="SMS " id="telephone" name="telephone"value="<?=$data['telephone'] ?>">
                
                <br>
                
                <input type="checkbox" name="checkboxSmsSize" id="checkboxSmsSize"  class="chBox"
                     <?php if ($data['checkboxSms']=="on" || !isset($data)) echo "checked" ?> id="checkboxSMS" >
                <label for="checkboxSMS">Отправлять СМС, если размер страницы вышел за допустимый диапазон.</label>
                
                <br>
                
                <input type="checkbox" name="checkboxSmsMeta" id="checkboxSmsMeta" class="chBox"
                     <?php if ($data['checkboxSms']=="on" || !isset($data)) echo "checked" ?> id="checkboxSMS" >
                <label for="checkboxSMS">Отправлять СМС, если неверен h1, title, keywords или description.</label>
                
                <br>
                
                <input type="submit" id="btnSaveOption" name="btnSaveOption" value="Сохранить">
               
              
            </form>   
        </main>       
    </body>
</html>