<?php
/**
 * Description of modelDataServis
 *
 * @author Владимир
 */
class modelDataServis
{
    public function getSmsBalanceSubmit()
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
    public function updateSmsBalanceSubmit($value)
    {
        require_once 'functions.php';
        $conn= connectDB();
        $sql="UPDATE data_servis SET submit_sms_balance={$value} LIMIT 1";
        //debug( $sql);
        $result=$conn->query($sql)->fetchColumn(); ;
        $error=$conn->errorInfo();
        if (isset($error[2])) die($error[2]);
    }
    public function getCheckAllTime()
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
    public function updateCheckAllTime($value)
    {
        require_once 'functions.php';
        $conn= connectDB();
        $sql="UPDATE data_servis SET check_all_time={$value} LIMIT 1";
        //debug( $sql);
        $result=$conn->query($sql)->fetchColumn(); ;
        $error=$conn->errorInfo();
        if (isset($error[2])) die($error[2]);
    }
}
