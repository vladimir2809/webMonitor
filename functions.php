<?php

function debug($arrValue)
{
       echo "<pre>";
       print_r($arrValue);
       echo "</pre>";
}
function connectDB()
{    
    static $conn=null;
    require_once ("config/bd.php");
    if ($conn==null)
    {
        try
        {
            $conn=new PDO("mysql:host=$hostName;dbname=$dbName",$dbUserName,$dbPassword); 
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }
    }
    return $conn;


}
function checkUrl($url)// функция проверки URL корректность и на сушествование
{


     // Remove all illegal characters from a url
     $url = filter_var($url, FILTER_SANITIZE_URL);

     // Validate url
     if (!filter_var($url, FILTER_VALIDATE_URL) === false) // если URL валиден
     {
        // echo("$url is not a valid URL");  
         $parse = parse_url($url);
         //echo $parse['host'];
         //  debug(get_headers($this->url, 1));
         if(checkdnsrr($parse['host'],'A') && get_headers($url, 1))// если URL сушествует
         {
             return true;
         }
     }
     return false; 
     
}


