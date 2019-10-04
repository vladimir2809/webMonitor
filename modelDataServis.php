<?php
/**
 * Description of modelDataServis
 *
 * @author Владимир
 */
class modelDataServis
{
    public function getSmsBalanceSubmit()// получить флаг отправки смс о балансе
    {
        require_once 'functions.php';
        $conn= connectDB();
        $sql="SELECT submit_sms_balance FROM data_servis LIMIT 1";
        //debug( $sql);
        $result=$conn->query($sql)->fetchColumn(); ;
        $error=$conn->errorInfo();
        if (isset($error[2])) die($error[2]);
        return $result;
    }
    public function updateSmsBalanceSubmit($value) // обновить флаг отпрвки о смс о балансе
    {
        require_once 'functions.php';
        $conn= connectDB();
        $sql="UPDATE data_servis SET submit_sms_balance={$value} LIMIT 1";
        //debug( $sql);
        $result=$conn->query($sql)->fetchColumn(); ;
        $error=$conn->errorInfo();
        if (isset($error[2])) die($error[2]);
    }
    public function getCheckAllTime()// получить время обработки скрипта cgeckAll
    {
        require_once 'functions.php';
        $conn= connectDB();
        $sql="SELECT check_all_time  FROM data_servis LIMIT 1";
        //debug( $sql);
        $result=$conn->query($sql)->fetchColumn(); ;
        $error=$conn->errorInfo();
        if (isset($error[2])) die($error[2]);
        
        return $result;
    }
    public function updateCheckAllTime($value)// обновить время обработки скрипта cgeckAll
    {
        require_once 'functions.php';
        $conn= connectDB();
        $sql="UPDATE data_servis SET check_all_time={$value} LIMIT 1";
        //debug( $sql);
        $result=$conn->query($sql)->fetchColumn(); ;
        $error=$conn->errorInfo();
        if (isset($error[2])) die($error[2]);
    }
        public function getTimeForCheckAll()// получить время за которое максимум дозволенно обрабатывать скрипт checkAll
    {
        require_once 'functions.php';
        $conn= connectDB();
        $sql="SELECT time_for_check_all  FROM data_servis LIMIT 1";
        //debug( $sql);
        $result=$conn->query($sql)->fetchColumn(); ;
        $error=$conn->errorInfo();
        if (isset($error[2])) die($error[2]);
        
        return $result;
    }

}
