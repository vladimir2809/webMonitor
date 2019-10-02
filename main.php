<?php
require_once 'functions.php';
require_once 'modelDBResultCheck.php';
require_once 'modelJournal.php';
require "monitor.php";

function checkOne($data)// проверитть одну страницу
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
     }
 //    debug($resCheck);
     return $resCheck;
 }        
 //       //readDataOneForCheckByUrl
// function readDataOneForCheckByUrl($url)//читать данные одной записи из таблицы for_check по URL
// {
//     require_once "modelDBForCheck.php";
//     $conn=connectDB();
//     $DBForCheck=new modelDBForCheck;
//     $DBForCheck->setConn($conn);
//     $data=$DBForCheck->readDBOneRecordByURL($url);
//     return $data;
// }
if (isset($_GET['checkAll'])/*&& $_GET['checkAll']===true*/)   
{
    ini_set('display_errors', 'On'); // сообщения с ошибками будут показываться
    error_reporting(E_ALL); // E_ALL - отображаем ВСЕ ошибки
    require_once 'SMS.php';
    require_once 'modelDataServis.php';
    require_once "modelUserOption.php";
    $DBResultCheck=new modelDBResultCheck();
    $dataServis=new modelDataServis();
    $journal=new Journal();
    $DBUserOption=new modelUserOption();
    $resultChecks=checkAll();
    $DBResultCheck->writeResChecksInDB($resultChecks);
    $smsOption=$DBUserOption->getSmsOption();
    debug($smsOption);
    if ($smsOption['sms_submit']==1)
    {
        
        for ($i=0;$i<count($resultChecks);$i++)
        {
            $code=$journal->createCodeByResCheck($resultChecks[$i]);
            $flagSize=false;
            $flagSmsOption=false;
            $flagSmsJournal=$journal->checkOneToWriteDB($resultChecks[$i]['url'],$code);
            debug($code);
            if ($code[0]=='0') $flagSmsOption=true;
            if ($smsOption['sms_size']==true && $code[1]=="0")
            {
                $flagSmsOption=true;
            }
            if ($smsOption['sms_meta']==true &&
                    ($code[2]=='0' || $code[3]=='0' || $code[4]=='0' || $code[5]=='0'))
            {
                $flagSmsOption=true;
            }
            if ($smsOption['sms_normal']==true && strcmp($code,"111111")==0) $flagSmsOption=true;
//            if ($smsOption['sms_size']==false && $code[1]=="0")
//            {
//                $flagSms=false;
//                $flagSize=true;
//            }
//            if ($smsOption['sms_meta']==false &&
//                    ($code[2]=='0' || $code[3]=='0' || $code[4]=='0' || $code[5]=='0'))
//            {
//                echo "12234";
//                
//            }
//            if ($flagSize==true && $flagSms==false) $flagSms=true; else $flagSms=false;
           // if ($smsOption['sms_normal']==false && strcmp($code,"111111")==0) $flagSms=false;
            
            if ($flagSmsJournal==true && $flagSmsOption==true)
            {
                $textSms=$journal->codeToMessage($resultChecks[$i]['url'], $code);
                submitSMS($textSms);
            }
        }
    }
    
    $journal->updateJournal();
    //debug($resultChecks);
//    debug($dataServis->getSmsBalanceSubmit());
//    $dataServis->updateSmsBalanceSubmit(0);
//    debug($dataServis->getSmsBalanceSubmit());
//    
//    debug($dataServis->getCheckAllTime());
//    $dataServis->updateCheckAllTime(0);
//    debug($dataServis->getCheckAllTime());
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
// 
// function readResultIsDB() //чтение результатов из базы данных из таблицы result_check
// {
////        require "modelDBForCheck.php";
////        require "monitor.php";
//        $conn=connectDB();
//        $sql="SELECT * FROM result_check;";
//        //debug( $sql);
//        $resultSQL=$conn->query($sql);
//        $error=$conn->errorInfo();
//        if (isset($error[2])) die($error[2]);
//        while($row=$resultSQL->fetch(PDO::FETCH_ASSOC))
//        {
//            $result[]=$row;
//        }
//        //debug($result);
//        return $result;
//        
// }
//  function readResultIsDBOneOfUrl($url) //чтение результатов из базы данных для одной записи по Url
// {
////        require "modelDBForCheck.php";
////        require "monitor.php";
//        $conn=connectDB();
//        $sql="SELECT * FROM result_check WHERE url='$url';";
//        //debug( $sql);
//        $resultSQL=$conn->query($sql);
//        $error=$conn->errorInfo();
//        if (isset($error[2])) die($error[2]);
//        $result=$resultSQL->fetch(PDO::FETCH_ASSOC);
//        //debug($result);
//        return $result;
//        
// }
// function readDataIsDBOneOfUrl($url) // чтение данных из базы данных for_check об одной странице по url 
//  {
//        $conn=connectDB();
//        $sql="SELECT * FROM for_check WHERE url='$url';";
//        //debug( $sql);
//        $resultSQL=$conn->query($sql);
//        $error=$conn->errorInfo();
//        if (isset($error[2])) die($error[2]);
//        $result=$resultSQL->fetch(PDO::FETCH_ASSOC);
// 
//        //debug($result);
//        return $result;
//  }
//  function insertDBCheckOne($resCheckOne)// вставить в таблицу result_check одну запись
//  {
//       $conn=connectDB();
//      // debug($resCheckOne);
//       $sql="INSERT INTO result_check (url, response, size, h1, title, "
//               . "keywords, description, time_upload)"
//               . "VALUES ('{$resCheckOne['url']}',{$resCheckOne['response']},"
//               . "".$resCheckOne['size'].",".$resCheckOne['h1'].","
//               . "".$resCheckOne['title'].",".$resCheckOne['keywords'].",".$resCheckOne['description'].","
//                       ."NOW());";
//       //debug( $sql); 
//       $resultSQL=$conn->query($sql);
//       $error=$conn->errorInfo();
//       if (isset($error[2])) die($error[2]); 
//  }
//  function updateDBCheckOne($resCheckOne)// обновить одну запись в таблице result_check
//  {
//       $conn=connectDB();
//      // debug($resCheckOne);
//       $sql="UPDATE result_check SET response={$resCheckOne['response']},"
//                                   . "size={$resCheckOne['size']},"
//                                   . "h1={$resCheckOne['h1']},title={$resCheckOne['title']},"
//                                   . "keywords={$resCheckOne['keywords']},"
//                                   . "description={$resCheckOne['description']}"
//                                   . ",time_upload=NOW()"
//                                   . " WHERE url='{$resCheckOne['url']}'";
//                                   
//                                   
//      // debug( $sql); 
//       $resultSQL=$conn->query($sql);
//       $error=$conn->errorInfo();
//       if (isset($error[2])) die($error[2]);
//  }
//function deleteOneRecResCheckByUrl($url)
//{
//    $conn=connectDB();
//    $sql="DELETE FROM result_check WHERE url='{$url}';";
//    //debug( $sql);
//    $result=$conn->query($sql);
//    $error=$conn->errorInfo();
//    if (isset($error[2])) die($error[2]);  
//}
// function writeResChecksInDB($resCheck)// записать в базу данных все рзультаты проверок 
// {
//     //require "functions.php";
//     $conn=connectDB();
//     $readRes=readResultIsDB();
//          
//    // debug($resCheck);  
//     if ($readRes==null)// если в базе данных нет записей
//     {
//         for ($i=0;$i<count($resCheck);$i++)
//         {
//            $sql="INSERT INTO result_check (url, response, size, h1, title, "
//                    . "keywords, description,time_upload )"
//                    . "VALUES ('".$resCheck[$i]['url']."',".$resCheck[$i]['response'].", "
//                    . "".$resCheck[$i]['size'].",".$resCheck[$i]['h1'].","
//                    . "".$resCheck[$i]['title'].",".$resCheck[$i]['keywords'].",".$resCheck[$i]['description'].","
//                    . "NOW())";
//            //debug( $sql); 
//            $resultSQL=$conn->query($sql);
//            $error=$conn->errorInfo();
//            if (isset($error[2])) die($error[2]);  
//         }
//        
//     }
//     else// если в базе данных есть записи
//     {
//         for ($i=0;$i<count($resCheck);$i++)
//         {
//            $flag=false;// флаг того что в базе данных есть запись с url $resCheck[$i]['url']
//            for ($j=0;$j<count($readRes);$j++)
//            {
//                if ($resCheck[$i]['url']==$readRes[$j]['url'])
//                {
//                    $flag=true;
//                    // если данные проверки отличаются от того что есть в БД
//                    if (!($resCheck[$i]['response']==$readRes[$j]['response']&&
//                          $resCheck[$i]['size']==$readRes[$j]['size']&&
//                          $resCheck[$i]['h1']==$readRes[$j]['h1']&&
//                          $resCheck[$i]['title']==$readRes[$j]['title']&&
//                          $resCheck[$i]['keywords']==$readRes[$j]['keywords']&&
//                          $resCheck[$i]['description']==$readRes[$j]['description']
//                        ))
//                    {
//                        // обновить запись
//                       $sql="UPDATE result_check SET response=".$resCheck[$i]['response']
//                               .", size=".$resCheck[$i]['size'].""
//                               . ", h1=".$resCheck[$i]['h1'].""
//                               . ", title=".$resCheck[$i]['title'].""
//                               . ", keywords=".$resCheck[$i]['keywords'].""
//                               . ", description=".$resCheck[$i]['description'].""
//                               . ", time_upload=NOW()"
//                               . "WHERE url='{$resCheck[$i]['url']}';";
//                       debug($sql);
//                       $result=$conn->query($sql);
//                       $error=$conn->errorInfo();
//                       if (isset($error[2])) die($error[2]);
//                    }
//                }
//           
//            }   
//            if  ($flag==false)// если в БД нет страницы с нужным url
//            {
//                $sql="INSERT INTO result_check (url, response, size, h1, title, "
//                    . "keywords, description, time_upload)"
//                    . "VALUES ('".$resCheck[$i]['url']."',".$resCheck[$i]['response'].","
//                    . "".$resCheck[$i]['size'].",".$resCheck[$i]['h1'].","
//                    . "".$resCheck[$i]['title'].",".$resCheck[$i]['keywords'].",".$resCheck[$i]['description'].","
//                        . "NOW());";
//              //  debug( $sql); 
//                $resultSQL=$conn->query($sql);
//                $error=$conn->errorInfo();
//                if (isset($error[2])) die($error[2]); 
//            }
//      
//         }
//     }
 //}
