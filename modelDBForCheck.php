<?php

/**
 * Description of modelBDForCheck
 *
 * @author Владимир
 */
class modelDBForCheck
{
    private $conn;// переменая которая хранит соедение с БД

    public function checkRecordByUrl($url)// функция проверки наличия записи в таблице for_check по url
    {
        $sql="SELECT COUNT(*) FROM for_check WHERE url="."'".$url."'";
        //debug( $sql);
        $result=$this->conn->query($sql)->fetchColumn(); ;
        $error=$this->conn->errorInfo();
        if (isset($error[2])) die($error[2]);
        if ($result==1) 
        {
            return true;
        }
        else
        {
            return false;
        }
        //debug($result);
    }
    public function insertInDB($url,$sizePage,$deviationSize,$h1,$title,$keywords,$description)// функция которая добавлеят в БД в таблицу for_check запись
    {
        $sql="INSERT INTO for_check (url,size_page,deviation_size,h1,title,keywords,description)"
                . "VALUES('".$url."',$sizePage,$deviationSize,'".$h1."','".$title."','".$keywords."'"
                . ",'".$description."')";
        //debug( $sql);
        $result=$this->conn->query($sql);
        $error=$this->conn->errorInfo();
        if (isset($error[2])) die($error[2]);
        
    }
    public function readDB()
    {
         $sql="SELECT * FROM for_check;";
        //debug( $sql);
       
        $resultSQL=$this->conn->query($sql);
        while($row=$resultSQL->fetch(PDO::FETCH_ASSOC))
        {
            $result[]=$row;
        }
        return $result;
//        foreach($this->conn->query($sql) as $row)
//        {
//            
//        }
//        $error=$this->conn->errorInfo();
//        if (isset($error[2])) die($error[2]);
    }
    public function setConn($value)
    {
     $this->conn=$value;   
    }
}
