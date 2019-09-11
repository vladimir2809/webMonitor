<?php
class Journal
{
    //put your code here
   
    public function readDBByUrl($url)// функция чтения журнала по url
    {
        require_once 'functions.php';
        $conn= connectDB();
        $sql="SELECT * FROM journal WHERE url='{$url}' LIMIT 64;";
        //debug( $sql);
       
        $resultSQL=$conn->query($sql);
        $error=$conn->errorInfo();
        if (isset($error[2])) die($error[2]);
        while($row=$resultSQL->fetch(PDO::FETCH_ASSOC))
        {
            $result[]=$row;
        }
        return $result;
    }
    public function insertDB($url,$response,$code,$time)
    {
        require_once 'functions.php';
        $conn= connectDB();
        $sql="INSERT INTO journal  (url,response,code_check,time_check)"
                . "VALUES ('{$url}',$response,'{$code}',$time)";
        //debug( $sql);
        $resultSQL=$conn->query($sql);
        $error=$conn->errorInfo();
        if (isset($error[2])) die($error[2]);
    }
    public function createCodeByResCheck($resCheck)
    {
        $result;
        if ($resCheck['response']==200) $result=1; else $result=0;
        $result.=$resCheck['size'];
        $result.=$resCheck['h1'];
        $result.=$resCheck['title'];
        $result.=$resCheck['keywords'];
        $result.=$resCheck['description'];
        return $result;
        
    }
    private function getResCheckOfMonitor()
    {
        require_once 'main.php';
        return readResultIsDB();
    }
    public function checkOneToWriteDB()// проверить нужно ли записывать в БД данные о проверки
    {
        
    }
}
