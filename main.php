<?php
require_once 'functions.php';
require_once 'modelDBResultCheck.php';
require_once 'modelJournal.php';
require "monitor.php";
require_once 'modelDataServis.php';

function checkOne($data)// проверить одну страницу
 {
       //require "monitor.php";
       $monitor=new Monitor;
     //  debug($data);
       $monitor->setDataForMonitor($data);
      // debug($monitor->getDataMonitorPage());
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
       $resCheckOne=["url"=>$monitor->getUrl(),"response"=>$response,"size"=>$size,
                   "h1"=>$h1,"title"=>$title,"keywords"=>$keywords,
                    "description"=>$description];
  // debug($resCheckOne);
    return $resCheckOne;
 }
 function checkAll()// проверить все сайты которые есть базе данных
 {
     //require 'functions.php';
     require_once "modelDBForCheck.php";
 //    require "monitor.php";
     $conn=connectDB();
     $DBForCheck=new modelDBForCheck;
     $dataServis=new modelDataServis();
     $DBForCheck->setConn($conn);
     $data=$DBForCheck->readDB();
     $dataPause=$DBForCheck->readStatePause();
    // debug($dataPause);
   //  $monitor=new Monitor;
     for ($i=0;$i<count($data);$i++)
     {
         if ($dataPause[$i]['state_pause']==0)
         { 
            $resOne=checkOne($data[$i]);
            $resCheck[]=$resOne;
            
         }
         $GLOBALS['time2']=time()-$GLOBALS['time1'];
         //debug($GLOBALS['time2']);
         if ($GLOBALS['time2']>=$dataServis->getTimeForCheckAll()-10)
         {
             break;
         }
     }
 //    debug($resCheck);
     return $resCheck;
 }        


 function getDataOnePage($url)// получить данные от одной страницы
 {
     //require "monitor.php";
     $monitor=new Monitor; 
     if ($monitor->checkUrlForMonitor($url))
     {
        $monitor->setUrl($url);
        $response=$monitor->getResponse();
        $size=0;
        if ($response==200) $size=$monitor->getPageSize();
        $meta=$monitor->getMetaPage();
        return [ 'url'=>$url,"response"=>$response, 'size'=>$size,
            'h1'=>$meta['h1'], 'title'=>$meta['title'],
            'keywords'=>$meta['keywords'],'description'=>$meta['description']
        ];
     }
     else
     {
        return [ 'url'=>$url,"message"=>$monitor->message]; 
     }
 }

