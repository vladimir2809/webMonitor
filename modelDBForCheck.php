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
    public function readStatePause()// считать поле state_pause у всех записей
    {
        $sql="SELECT url, state_pause FROM for_check";
        //debug( $sql);
       
        $resultSQL=$this->conn->query($sql); 
        $error=$this->conn->errorInfo();
        while($row=$resultSQL->fetch(PDO::FETCH_ASSOC))
        {
            $result[]=$row;
        }
        return $result;
    }
    public function updateStatePausebyUrl($url, $statePause)// обнавить статус паузы
    {
       $sql="UPDATE for_check SET state_pause={$statePause} WHERE url='{$url}'";
                                
      //  debug( $sql);
        $result=$this->conn->query($sql);
        $error=$this->conn->errorInfo();
        if (isset($error[2])) die($error[2]);   
    }
    // обновить запись по url
    public function updateRecordByUrl($url,$sizePage,$deviationSize,$h1,$title,$keywords,$description)
    {
        $h1= addslashes($h1);
        $title= addslashes($title);
        $keywords= addslashes($keywords);
        $description= addslashes($description);
        $sql="UPDATE for_check SET size_page={$sizePage},deviation_size={$deviationSize},h1='{$h1}',"
                                . "title='{$title}',keywords='{$keywords}',description='{$description}'"
                                . "WHERE url='{$url}'";
                                
        //debug( $sql);
        $result=$this->conn->query($sql);
        $error=$this->conn->errorInfo();
        if (isset($error[2])) die($error[2]);        
    }
    // вставить в БД одну запись
    public function insertInDB($url,$sizePage,$deviationSize,$h1,$title,$keywords,$description)// функция которая добавлеят в БД в таблицу for_check запись
    {
        $h1= addslashes($h1);
        $title= addslashes($title);
        $keywords= addslashes($keywords);
        $description= addslashes($description);
        $sql="INSERT INTO for_check (url,size_page,deviation_size,h1,title,keywords,description,time_add)"
                . "VALUES('".$url."',$sizePage,$deviationSize,'".$h1."','".$title."','".$keywords."'"
                . ",'".$description."',NOW())";
        //debug( $sql);
        $result=$this->conn->query($sql);
        $error=$this->conn->errorInfo();
        if (isset($error[2])) die($error[2]);  
    }
    public function readDBOneRecordByURL($url)//читать из базы данных таьлицы for_check одну запись по url 
    {
        $sql="SELECT * FROM for_check WHERE url='{$url}'";
        //debug( $sql);
        $resultSQL=$this->conn->query($sql);
        $result=$resultSQL->fetch(PDO::FETCH_ASSOC);  
        $error=$this->conn->errorInfo();
        if (isset($error[2])) die($error[2]);
       // debug($result);
        return $result;
    }
    public function deleteOneRecordByUrl($url)// удалить одну запись по УРЛ
    {
         $sql="DELETE FROM for_check WHERE url='{$url}';";
        //debug( $sql);
        $result=$this->conn->query($sql);
        $error=$this->conn->errorInfo();
        if (isset($error[2])) die($error[2]);  
    }
    public function readDB()// читать из базы данных все записи
    {
         $sql="SELECT * FROM for_check;";
        //debug( $sql);
        $resultSQL=$this->conn->query($sql);
        $error=$this->conn->errorInfo();
        if (isset($error[2])) die($error[2]);
        while($row=$resultSQL->fetch(PDO::FETCH_ASSOC))
        {
            $result[]=$row;
        }
        return $result;
    }
    public function deleteData()// удалить данные
    {
        $sql="DELETE FROM for_check;";
        //debug( $sql);
        $result=$this->conn->query($sql);
        $error=$this->conn->errorInfo();
        if (isset($error[2])) die($error[2]); 
    }
    public function setConn($value)// усртановить переменныю  соединения с БД
    {
     $this->conn=$value;   
    }
}
