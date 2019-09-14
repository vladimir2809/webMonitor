<?php
class Journal
{
    //put your code here
   
    public function readDBByUrl($url)// функция чтения журнала по url
    {
        require_once 'functions.php';
        $conn= connectDB();
        $sql="SELECT * FROM journal WHERE url='{$url}' ORDER BY time_check DESC LIMIT 64;";
        debug( $sql);
       
        $resultSQL=$conn->query($sql);
        $error=$conn->errorInfo();
        if (isset($error[2])) die($error[2]);
        while($row=$resultSQL->fetch(PDO::FETCH_ASSOC))
        {
            $result[]=$row;
        }
        return $result;
    }
    public function insertDB($url,$code,$time)// вставить в БД одну запись
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
    
    public function createCodeByResCheck($resCheck)// создать код по результатам проверки
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
    private function getResCheckOfMonitor()//получить результы проверок монитора
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
            if ($dataDB[$i]['code_check']=='111111' && $i==0 && $code=="111111")
            {
                return false;
            }
            if ($dataDB[$i]['code_check']=='111111' )
            {
                //return false;
                  break;
//                $flag=true;
//                break;
            }
           
            //$codeDB=$this->createCodeByResCheck($resCheckOne);
            if ($code==$dataDB[$i]['code_check'])
            {
                return false;
            }
        }
        return true;
    }
    public function codeToMessage($url,$code)// конвертировать код в сообшение для пользователя
    {
        $result="У страницы <a href='page.php?url={$url}'><span class='urlJournal' > {$url} </span></a>: ";
        if ($code=="111111")
        {
            return "Страница <a href='page.php?url={$url}'><span class='urlJournal> {$url} </span></a>"
                    ." работает нормально";
        }
        if ($code[0]=='0') 
        {
            $result.="Код ответа сервера не 200.";
            return $result;
        }
        if ($code[1]=='0') 
        {
            $result.="Размер страницы вышел за допустимый диапозон;";
            //return $result;
        }
        if ($code[2]=='0') 
        {
            $result.="h1 не верен; ";
        //    return $result;
        }
        if ($code[3]=='0') 
        {
            $result.="title не верен; ";
        //    return $result;
        }
        if ($code[4]=='0') 
        {
            $result.="keywords не верен; ";
        //    return $result;
        }
        if ($code[5]=='0') 
        {
            $result.="description не верен; ";
        //    return $result;
        }
        return $result;
    }
    public function searchAndGetResult($key)
    {
        require_once 'functions.php';
        $conn= connectDB();
        $sql="SELECT url, code_check, time_check FROM journal WHERE url LIKE '%{$key}%'"
                . " ORDER BY time_check DESC";
        //debug( $sql);
       
        $resultSQL=$conn->query($sql);
        $error=$conn->errorInfo();
        if (isset($error[2])) die($error[2]);
        while($row=$resultSQL->fetch(PDO::FETCH_ASSOC))
        {
            $arrCode[]=$row;
        }
        for ($i=0;$i<count($arrCode);$i++)
        {
            $message=$this->codeToMessage($arrCode[$i]['url'],$arrCode[$i]['code_check'] );
            $result[]=['time'=>$arrCode[$i]['time_check'],"message"=>$message];
        }
        return $result;
    }
    public function getArrMessage()//  получить массив сообшений
    {
        require_once 'functions.php';
        $conn= connectDB();
        $sql="SELECT url, code_check, time_check FROM journal ORDER BY time_check DESC";
        //debug( $sql);
       
        $resultSQL=$conn->query($sql);
        $error=$conn->errorInfo();
        if (isset($error[2])) die($error[2]);
        while($row=$resultSQL->fetch(PDO::FETCH_ASSOC))
        {
            $arrCode[]=$row;
        }
        for ($i=0;$i<count($arrCode);$i++)
        {
            $message=$this->codeToMessage($arrCode[$i]['url'],$arrCode[$i]['code_check'] );
            $result[]=['time'=>$arrCode[$i]['time_check'],"message"=>$message];
        }
        return $result;
    }
    public function updateJournal()// обновить журнал
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
    }
}
//$journal=new Journal();
//$journal->updateJournal();