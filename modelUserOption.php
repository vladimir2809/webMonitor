<?php
/**
 * Description of modelUserOption
 *
 * @author Владимир
 */
class modelUserOption
{
    public function checkRecordInDB()// проверить есть ли записи в таблице user_option
    {
        require_once 'functions.php';
        $conn= connectDB();
        $sql="SELECT COUNT(*) FROM user_option";
        //debug( $sql);
        $result=$conn->query($sql)->fetchColumn(); ;
        $error=$conn->errorInfo();
        if (isset($error[2])) die($error[2]);
        if ($result==1) 
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function getLoginPassword()// получить логин и пароль
    {
        require_once 'functions.php';
        $conn= connectDB();
        $sql="SELECT login, password FROM user_option LIMIT 1";
        //debug( $sql);
        $result=$conn->query($sql);
        $error=$conn->errorInfo();
        if (isset($error[2])) die($error[2]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }
    public function getPassword()// получить пароль
    {
        require_once 'functions.php';
        $conn= connectDB();
        $sql="SELECT password FROM user_option LIMIT 1";
        //debug( $sql);
        $result=$conn->query($sql);
        $error=$conn->errorInfo();
        if (isset($error[2])) die($error[2]);
        return $result->fetch(PDO::FETCH_ASSOC)['password'];
        
    } 
    public function updatePassword($password)// обновить пароль
    {
        require_once 'functions.php';
        $conn= connectDB();
        $sql="UPDATE user_option SET password='{$password}' LIMIT 1";
        //debug( $sql);
        $result=$conn->query($sql);
        $error=$conn->errorInfo();
        if (isset($error[2])) die($error[2]);   
    }
    public function updateLoginPasswordSmsFeedBack($login,$password)// обновить пароль и логин smsfeedback
    {
        require_once 'functions.php';
        $conn= connectDB();
        $login= addslashes($login);
        $sql="UPDATE user_option SET login_smsfeedback='{$login}',"
                                 .  "password_smsfeedback='{$password}' LIMIT 1";
        //debug( $sql);
        $result=$conn->query($sql);
        $error=$conn->errorInfo();
        if (isset($error[2])) die($error[2]); 
    }
    public function getSmsOption()// получить настройки относяшиеся к смс уведомленям
    {
        require_once 'functions.php';
        $conn= connectDB();
        $sql="SELECT sms_submit,login_smsfeedback,telephone,sms_size,sms_meta,sms_normal,sms_balance"
                . " FROM user_option LIMIT 1";
        //debug( $sql);
        $result=$conn->query($sql);
        $error=$conn->errorInfo();
        if (isset($error[2])) die($error[2]);
        return $result->fetch(PDO::FETCH_ASSOC); 
    }
    public function getSmsOptionLoginPassword()// получить логин и пароль от smsfeedback из БД
    {
        require_once 'functions.php';
        $conn= connectDB();
        $sql="SELECT login_smsfeedback, password_smsfeedback"
                . " FROM user_option LIMIT 1";
        //debug( $sql);
        $result=$conn->query($sql);
        $error=$conn->errorInfo();
        if (isset($error[2])) die($error[2]);
        return $result->fetch(PDO::FETCH_ASSOC); 
    }
    // обновить настройки смс сообшений
    public function updateSmsOption($telephone,$smsSubmit,$smsSize,$smsMeta,$smsNormal,$smsBalance)
    {
        require_once 'functions.php';
        $conn= connectDB();
        $sql="UPDATE user_option SET telephone='{$telephone}', "
                                 . "sms_submit={$smsSubmit}, "
                                 . "sms_size={$smsSize}, "
                                 . "sms_meta={$smsMeta}, "
                                 . "sms_normal={$smsNormal}, "
                                 . "sms_balance={$smsBalance} "
                                 . "LIMIT 1";
       // debug( $sql);
        $result=$conn->query($sql);
        $error=$conn->errorInfo();
        if (isset($error[2])) die($error[2]); 
    }
    public function updateSmsSubmit($smsSubmit)// обновить флаг отправки сообшений
    {
        require_once 'functions.php';
        $conn= connectDB();
        $sql="UPDATE user_option SET sms_submit={$smsSubmit} LIMIT 1";
       // debug( $sql);
        $result=$conn->query($sql);
        $error=$conn->errorInfo();
        if (isset($error[2])) die($error[2]); 
    }
    //вставить запись в таблицу user_option
    public function insertUserOption($name,$surname,$login,$password,$smsSubmit,
                                        $loginSmsFeedBack,$passwordSmsFeedBack,$telephone)
    {
        require_once 'functions.php';
        $conn= connectDB();
        $name= addslashes($name);
        $surname= addslashes($surname);
        $login= addslashes($login);
        $sql="INSERT INTO user_option  (name,surname,login,password,sms_submit,"
                .  "login_smsfeedback,password_smsfeedback,telephone)"
                . "VALUES ('{$name}','{$surname}','{$login}','{$password}',{$smsSubmit},"
                . "'{$loginSmsFeedBack}','{$passwordSmsFeedBack}',{$telephone})";
       // debug( $sql);
        $resultSQL=$conn->query($sql);
        $error=$conn->errorInfo();
        if (isset($error[2])) die($error[2]);
    }
    public function deleteData()// очистить таблицу
    {
         require_once 'functions.php';
        $conn=connectDB();
        $sql="DELETE FROM user_option;";
        //debug( $sql);
        $result=$conn->query($sql);
        $error=$conn->errorInfo();
        if (isset($error[2])) die($error[2]); 
    }
}
