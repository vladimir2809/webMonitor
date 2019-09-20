<?php
/**
 * Description of modelUserOption
 *
 * @author Владимир
 */
class modelUserOption
{
    public function checkRecordInDB()
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
    public function getLoginPassword()
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
    public function insertUserOption($name,$surname,$login,$password,$smsSubmit,
                                        $loginSmsFeedBack,$passwordSmsFeedBack,$telephone)
    {
        require_once 'functions.php';
        $conn= connectDB();
        $sql="INSERT INTO user_option  (name,surname,login,password,sms_submit,"
                .  "login_smsfeedback,password_smsfeedback,telephone)"
                . "VALUES ('{$name}','{$surname}','{$login}','{$password}',{$smsSubmit},"
                . "'{$loginSmsFeedBack}','{$passwordSmsFeedBack}',{$telephone})";
       // debug( $sql);
        $resultSQL=$conn->query($sql);
        $error=$conn->errorInfo();
        if (isset($error[2])) die($error[2]);
    }
}
