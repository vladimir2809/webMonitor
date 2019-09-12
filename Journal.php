<?php
/*


НЕ ДО КОНЦА ДОДЕЛАН АЛГОРИТМ ПРРВЕРКИ НА ЗАПИСЬ В ЖУРНАЛ

*/
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
    public function insertDB($url,$code,$time)
    {
        require_once 'functions.php';
        $conn= connectDB();
        $sql="INSERT INTO journal  (url,code_check,time_check)"
                . "VALUES ('{$url}','{$code}','{$time}')";
        debug( $sql);
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
        require_once 'modelDBResultCheck.php';
        
        $DBResultCheck=new modelDBResultCheck();
        return $DBResultCheck->readResultIsDB();
    }
    public function checkOneToWriteDB($url,$code)// проверить нужно ли записывать в БД данные о проверки
    {
        $dataDB=$this->readDBByUrl($url);
        debug($dataDB);
      //  $flag=false;
        for ($i=0;$i<count($dataDB);$i++)
        {
            if ($dataDB[$i]['code_check']=='111111')
            {
                return false;
//                $flag=true;
//                break;
            }
            //$codeDB=$this->createCodeByResCheck($resCheckOne);
            if ($code==$dataDB[$i]['code_check']) return false;
        }
        return true;
    }
    public function updateJournal()
    {
        //require_once 'modelDBResultCheck.php';
        ///$DBResultCheck=new modelDBResultCheck();
        $resCheckDB=$this->getResCheckOfMonitor();
        for ($i=0;$i<count($resCheckDB);$i++)
        {
            $code=$this->createCodeByResCheck($resCheckDB[$i]);
            echo "code= $code";
            if ($this->checkOneToWriteDB($resCheckDB[$i]['url'], $code))
            {
                $this->insertDB($resCheckDB[$i]['url'], $code,$resCheckDB[$i]['time_upload'] );
            }
        }
//        if ($this->checkOneToWriteDB("http://vk.com",'000000')) 
//        {
//            echo "good";
//        }
//        else
//        {
//           echo "fail";
//        }
    }
}
//$journal=new Journal();
//$journal->updateJournal();