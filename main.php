<?php
 function checkAll()
 {
     require "modelDBForCheck.php";
     require "monitor.php";
     $conn=connectDB();
     $DBForCheck=new modelDBForCheck;
     $DBForCheck->setConn($conn);
     $data=$DBForCheck->readDB();
     $monitor=new Monitor;
     for ($i=0;$i<count($data);$i++)
     {

       $monitor->setDataForMonitor($data[$i]);
      // debug($monitor->getDataMonitorPage());
       $resOne;
       $response=$monitor->getResponse();
       if ($response==200)
       {
            if ($monitor->checkPageSize()) 
            {
              $size=1;
            }
            else
            {
              $size=0;
            }      
            $monitor->getMetaPage();
            if ($monitor->checkH1()) 
            {
               $h1=1;
            }
            else
            {
                $h1=0;
            }
            if ($monitor->checkTitle()) 
            {
                $title=1;
            }
            else
            {
                 $title=0;
            }   
            if ($monitor->checkKeywords()) 
            {
                $keywords=1;

            }
            else
            {
                 $keywords=0;
            }
            if ($monitor->checkDescription()) 
            {
                $description=1;
            }
            else
            {
                 $description=0;
            }
        }
     
       else
       {
        $size=0;
        $h1=0;
        $title=0;
        $keywords=0;
        $description=0;
       }
       $resCheck[]=["url"=>$monitor->getUrl(),"response"=>$response,"size"=>$size,
                   "h1"=>$h1,"title"=>$title,"keywords"=>$keywords,
                    "description"=>$description];
    }
    return $resCheck;
 }
 function getDataOnePage($url)
 {
     require "monitor.php";
     $monitor=new Monitor; 
     $monitor->setUrl($url);
     $response=$monitor->getResponse();
     $size=$monitor->getPageSize();
     $meta=$monitor->getMetaPage();
     return [ 'url'=>$url,"response"=>$response, 'size'=>$size,
         'h1'=>$meta['h1'], 'title'=>$meta['title'],
         'keywords'=>$meta['keywords'],'description'=>$meta['description']
     ];
 }
 function readResultIsDB() //чтение результатов из базы данных
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
 function writeResChecksInDB($resCheck)// записать в базу данных рзультаты проверок 
 {
     //require "functions.php";
     $conn=connectDB();
     $readRes=readResultIsDB();
          
    // debug($resCheck);  
     if ($readRes==null)// если в базе данных нет записей
     {
         for ($i=0;$i<count($resCheck);$i++)
         {
            $sql="INSERT INTO result_check (url, response, size, h1, title, "
                    . "keywords, description )"
                    . "VALUES ('".$resCheck[$i]['url']."',".$resCheck[$i]['response'].", "
                    . "".$resCheck[$i]['size'].",".$resCheck[$i]['h1'].","
                    . "".$resCheck[$i]['title'].",".$resCheck[$i]['keywords'].",".$resCheck[$i]['description'].")";
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
                    if (!($resCheck[$i]['response']==$readRes[$j]['response']&&
                          $resCheck[$i]['size']==$readRes[$j]['size']&&
                          $resCheck[$i]['h1']==$readRes[$j]['h1']&&
                          $resCheck[$i]['title']==$readRes[$j]['title']&&
                          $resCheck[$i]['keywords']==$readRes[$j]['keywords']&&
                          $resCheck[$i]['description']==$readRes[$j]['description']
                        ))
                    {
                       $sql="UPDATE result_check SET response=".$resCheck[$i]['response']
                               .", size=".$resCheck[$i]['size'].""
                               . ", h1=".$resCheck[$i]['h1'].""
                               . ", title=".$resCheck[$i]['title'].""
                               . ", keywords=".$resCheck[$i]['keywords'].""
                               . ", description=".$resCheck[$i]['description']." "
                               . "WHERE url='{$resCheck[$i]['url']}';";
                       $result=$conn->query($sql);
                       $error=$conn->errorInfo();
                       if (isset($error[2])) die($error[2]);
                    }
                }
           
            }   
            if  ($flag==false)
            {
                $sql="INSERT INTO result_check (url, response, size, h1, title, "
                    . "keywords, description )"
                    . "VALUES ('".$resCheck[$i]['url']."',".$resCheck[$i]['response'].", "
                    . "".$resCheck[$i]['size'].",".$resCheck[$i]['h1'].","
                    . "".$resCheck[$i]['title'].",".$resCheck[$i]['keywords'].",".$resCheck[$i]['description'].")";
                //debug( $sql); 
                $resultSQL=$conn->query($sql);
                $error=$conn->errorInfo();
                if (isset($error[2])) die($error[2]); 
            }
      
         }
     }
 }

