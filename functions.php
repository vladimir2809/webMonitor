<?php

function debug($arrValue)
{
       echo "<pre>";
       print_r($arrValue);
       echo "</pre>";
}
function connectDB()
{    
    require_once ("config/bd.php");
    try
    {
        $conn=new PDO("mysql:host=$hostName;dbname=$dbName",$dbUserName,$dbPassword); 
    }
    catch (PDOException $e)
    {
        echo $e->getMessage();
    }
    return $conn;

}
