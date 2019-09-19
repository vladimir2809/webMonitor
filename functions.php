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
function checkStrInt($str)
{
    if (is_numeric($str) && is_int($str+0) && ($str+0 <= 2147483647)&&($str[0]!='-')
                && ( ($str[0]!='0') || ($str=='0') && (strlen($str)==1) )   
        )
    {
        return true;
    }
    else
    {
        return false;
    }
}
function varietyStr($patern,$str)// фунцкция которая проверяет что строка состоит только из определенных символов
{
    for ($i=0;$i<strlen($str);$i++)
    {
        $resFalse=false;
        for ($j=0;$j<strlen($patern);$j++)
        {
            if ($str[$i]==$patern[$j])//сравниваем каждый символ строки с патерном
            {
                $resFalse=true;

            }
        }
        if ($resFalse==false)//если совпадения символа строки с набором символов патерна не найдены 
        {
            return false;
        }
    }
    return true;
}
		
	



