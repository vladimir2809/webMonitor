<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modelDBResultCheck
 *
 * @author Владимир
 */
require_once 'functions.php';
//require "monitor.php";
class modelDBResultCheck
{
 public function readResultIsDB() //чтение результатов из базы данных из таблицы result_check
 {
//        require "modelDBForCheck.php";
//        require "monitor.php";
        $conn=connectDB();
        $sql="SELECT * FROM result_check;";
        //debug( $sql);
        $resultSQL=$conn->query($sql);
        $error=$conn->errorInfo();
        if (isset($error[2])) die($error[2]);
        while($row=$resultSQL->fetch(PDO::FETCH_ASSOC))
        {
            $result[]=$row;
        }
        //debug($result);
        return $result;
        
 }
 public  function readResultIsDBOneOfUrl($url) //чтение результатов из базы данных для одной записи по Url
 {
//        require "modelDBForCheck.php";
//        require "monitor.php";
        $conn=connectDB();
        $sql="SELECT * FROM result_check WHERE url='$url';";
        //debug( $sql);
        $resultSQL=$conn->query($sql);
        $error=$conn->errorInfo();
        if (isset($error[2])) die($error[2]);
        $result=$resultSQL->fetch(PDO::FETCH_ASSOC);
        //debug($result);
        return $result;
        
 }
  public function insertDBCheckOne($resCheckOne)// вставить в таблицу result_check одну запись
  {
       $conn=connectDB();
      // debug($resCheckOne);
       $sql="INSERT INTO result_check (url, response, size, h1, title, "
               . "keywords, description, time_upload)"
               . "VALUES ('{$resCheckOne['url']}',{$resCheckOne['response']},"
               . "".$resCheckOne['size'].",".$resCheckOne['h1'].","
               . "".$resCheckOne['title'].",".$resCheckOne['keywords'].",".$resCheckOne['description'].","
                       ."NOW());";
       //debug( $sql); 
       $resultSQL=$conn->query($sql);
       $error=$conn->errorInfo();
       if (isset($error[2])) die($error[2]); 
  }
  public function updateDBCheckOne($resCheckOne)// обновить одну запись в таблице result_check
  {
       $conn=connectDB();
      // debug($resCheckOne);
       $sql="UPDATE result_check SET response={$resCheckOne['response']},"
                                   . "size={$resCheckOne['size']},"
                                   . "h1={$resCheckOne['h1']},title={$resCheckOne['title']},"
                                   . "keywords={$resCheckOne['keywords']},"
                                   . "description={$resCheckOne['description']}"
                                   . ",time_upload=NOW()"
                                   . " WHERE url='{$resCheckOne['url']}'";
                                   
                                   
      // debug( $sql); 
       $resultSQL=$conn->query($sql);
       $error=$conn->errorInfo();
       if (isset($error[2])) die($error[2]);
  }
public function deleteOneRecResCheckByUrl($url)//удалить одну запись в таблице result_check
{
    $conn=connectDB();
    $sql="DELETE FROM result_check WHERE url='{$url}';";
    //debug( $sql);
    $result=$conn->query($sql);
    $error=$conn->errorInfo();
    if (isset($error[2])) die($error[2]);  
}
 public function writeResChecksInDB($resCheck)// записать в базу данных все рзультаты проверок 
 {
     //require "functions.php";
     $conn=connectDB();
     $readRes=$this->readResultIsDB();
          
    // debug($resCheck);  
     if ($readRes==null)// если в базе данных нет записей
     {
         for ($i=0;$i<count($resCheck);$i++)
         {
            $sql="INSERT INTO result_check (url, response, size, h1, title, "
                    . "keywords, description,time_upload)"
                    . "VALUES ('".$resCheck[$i]['url']."',".$resCheck[$i]['response'].", "
                    . "".$resCheck[$i]['size'].",".$resCheck[$i]['h1'].","
                    . "".$resCheck[$i]['title'].",".$resCheck[$i]['keywords'].",".$resCheck[$i]['description'].","
                    . "NOW())";
            //debug( $sql); 
            $resultSQL=$conn->query($sql);
            $error=$conn->errorInfo();
            if (isset($error[2])) die($error[2]);  
         }
        
     }
     else// если в базе данных есть записи
     {
         for ($i=0;$i<count($resCheck);$i++)
         {
            $flag=false;// флаг того что в базе данных есть запись с url $resCheck[$i]['url']
            for ($j=0;$j<count($readRes);$j++)
            {
                if ($resCheck[$i]['url']==$readRes[$j]['url'])
                {
                    $flag=true;
//                     если данные проверки отличаются от того что есть в БД
                    if (!($resCheck[$i]['response']==$readRes[$j]['response']&&
                          $resCheck[$i]['size']==$readRes[$j]['size']&&
                          $resCheck[$i]['h1']==$readRes[$j]['h1']&&
                          $resCheck[$i]['title']==$readRes[$j]['title']&&
                          $resCheck[$i]['keywords']==$readRes[$j]['keywords']&&
                          $resCheck[$i]['description']==$readRes[$j]['description']
                                                                                    ))
                    {
                        // обновить запись
                       $sql="UPDATE result_check SET response=".$resCheck[$i]['response']
                               .", size=".$resCheck[$i]['size'].""
                               . ", h1=".$resCheck[$i]['h1'].""
                               . ", title=".$resCheck[$i]['title'].""
                               . ", keywords=".$resCheck[$i]['keywords'].""
                               . ", description=".$resCheck[$i]['description'].""
                               . ", time_upload=NOW()"
                               . "WHERE url='{$resCheck[$i]['url']}';";
                     //  debug($sql);
                       $result=$conn->query($sql);
                       $error=$conn->errorInfo();
                       if (isset($error[2])) die($error[2]);
                    }
                    else// если все данные совпадают то просто обновим время
                    {
                           $sql="UPDATE result_check SET time_upload=NOW()"
                                     . "WHERE url='{$resCheck[$i]['url']}';";
                     //  debug($sql);
                       $result=$conn->query($sql);
                       $error=$conn->errorInfo();
                       if (isset($error[2])) die($error[2]);
                    }
                }
           
            }   
            if  ($flag==false)// если в БД нет страницы с нужным url
            {
                $sql="INSERT INTO result_check (url, response, size, h1, title, "
                    . "keywords, description, time_upload)"
                    . "VALUES ('".$resCheck[$i]['url']."',".$resCheck[$i]['response'].","
                    . "".$resCheck[$i]['size'].",".$resCheck[$i]['h1'].","
                    . "".$resCheck[$i]['title'].",".$resCheck[$i]['keywords'].",".$resCheck[$i]['description'].","
                        . "NOW());";
              //  debug( $sql); 
                $resultSQL=$conn->query($sql);
                $error=$conn->errorInfo();
                if (isset($error[2])) die($error[2]); 
            }
      
         }
     }
 }
    public function deleteData()// очистить таблицу
    {
        require_once 'functions.php';
        $conn=connectDB();
        $sql="DELETE FROM result_check;";
        //debug( $sql);
        $result=$conn->query($sql);
        $error=$conn->errorInfo();
        if (isset($error[2])) die($error[2]); 
    }
}
