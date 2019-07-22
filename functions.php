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
