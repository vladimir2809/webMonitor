<?php

/**
 * Description of modelBDForCheck
 *
 * @author Владимир
 */
class modelDBForCheck
{
    private $conn;// переменая которая хранит соедение с БД
    private $url;
    private $sizePage;
    private $deviationSize;
    private $h1;
    private $title;
    private $keywords;
    private $description;
    
    public function insertInDB()// функция которая добавлеят в БД в таблицу for_check запись
    {
        $url=$this->url;
        $sizePage=$this->sizePage;
        $deviationSize=$this->deviationSize;
        $h1=$this->h1;
        $title=$this->title;
        $keywords=$this->keywords;
        $description=$this->description;
        $sql="INSERT INTO for_check (url,size_page,deviation_size,h1,title,keywords,description)"
                . "VALUES('".$url."',$sizePage,$deviationSize,'".$h1."','".$title."','".$keywords."'"
                . ",'".$description."')";
        debug( $sql);
        $result=$this->conn->query($sql);
        $error=$this->conn->errorInfo();
        if (isset($error[2])) die($error[2]);
        
    }
    public function readDB()
    {
         $sql="SELECT * FROM for_check;";
        debug( $sql);
       
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
    public function setUrl($value)
    {
        $this->url=$value;
    }
    public function setSizePage($value)
    {
        $this->sizePage=$value;
    }
    public function setDeviationSize($value)
    {
        $this->deviationSize=$value;
    }
    public function setH1($value)
    {
        $this->h1=$value;
    }
    public function setTitle($value)
    {
        $this->title=$value;
    }
    public function setKeywords($value)
    {
        $this->keywords=$value;
    }    
    public function setDescription($value)
    {
        $this->description=$value;
    }
}
