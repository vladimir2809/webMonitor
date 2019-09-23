<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/* 
* функция передачи сообщения 
*/
 //require "functions.php";
function send($host, $port, $login, $password, $phone, $text, $sender = false, $wapurl = false )
{
    $fp = fsockopen($host, $port, $errno, $errstr);
    if (!$fp) {
        return "errno: $errno \nerrstr: $errstr\n";
    }
    fwrite($fp, "GET /messages/v2/send/" .
        "?phone=" . rawurlencode($phone) .
        "&text=" . rawurlencode($text) .
        ($sender ? "&sender=" . rawurlencode($sender) : "") .
        ($wapurl ? "&wapurl=" . rawurlencode($wapurl) : "") .
        "  HTTP/1.0\n");
    fwrite($fp, "Host: " . $host . "\r\n");
    if ($login != "") {
        fwrite($fp, "Authorization: Basic " . 
            base64_encode($login. ":" . $password) . "\n");
    }
    fwrite($fp, "\n");
    $response = "";
    while(!feof($fp)) {
        $response .= fread($fp, 1);
    }
    fclose($fp);
    list($other, $responseBody) = explode("\r\n\r\n", $response, 2);
    return $responseBody;
}
/* 
* функция проверки состояния отправленного сообщения
*/
/* 
* использование функции проверки состояния отправленного сообщения
* например, прри отпраке смс мы получили ответ: accepted;A133541BC
*/
 function status($host, $port, $login, $password, $sms_id)
{
    $fp = fsockopen($host, $port, $errno, $errstr);
    if (!$fp) {
        return "errno: $errno \nerrstr: $errstr\n";
    }
    fwrite($fp, "GET /messages/v2/status/" .
        "?id=" . $sms_id .
        "  HTTP/1.0\n");
    fwrite($fp, "Host: " . $host . "\r\n");
    if ($login != "") {
        fwrite($fp, "Authorization: Basic " . 
            base64_encode($login. ":" . $password) . "\n");
    }
    fwrite($fp, "\n");
    $response = "";
    while(!feof($fp)) {
        $response .= fread($fp, 1);
    }
    fclose($fp);
    list($other, $responseBody) = explode("\r\n\r\n", $response, 2);
    return $responseBody;
}
/* 
* функция проверки баланса
*/
function balance($host, $port, $login, $password)
{
    $fp = fsockopen($host, $port, $errno, $errstr);
    if (!$fp) {
        return "errno: $errno \nerrstr: $errstr\n";
    }
   fwrite($fp, "GET /messages/v2/balance/  HTTP/1.0\n");
    fwrite($fp, "Host: " . $host . "\r\n");
    if ($login != "") {
        fwrite($fp, "Authorization: Basic " . 
            base64_encode($login. ":" . $password) . "\n");
    }
    fwrite($fp, "\n");
    $response = "";
    while(!feof($fp)) {
        $response .= fread($fp, 1);
    }
    fclose($fp);
    list($other, $responseBody) = explode("\r\n\r\n", $response, 2);
    return $responseBody;
}

If (isset($_POST['submit']))
{
 debug($_POST);
  
//echo send("api.smsfeedback.ru", 80, "VladimirWebMonitor", "wV6z7PwvpAAkuRa", 
//          "79505582918", "привет! Это PHP", "TEST-SMS");
}
function getBalance()
{
    require_once 'modelUserOption.php';
    require_once 'crypt.php';
    $crypt=new MCrypt();
    $DBUserOption=new modelUserOption();  
    $smsOption=$DBUserOption->getSmsOptionLoginPassword();
    //return balance("api.smsfeedback.ru", 80, "VladimirWebMonitor", "wV6z7PwvpAAkuRa");
    return balance("api.smsfeedback.ru", 80, $smsOption['login_smsfeedback'], 
                                            $crypt->decrypt($smsOption['password_smsfeedback']));
   //return $crypt->decrypt($smsOption['password_smsfeedback']). "  ".$smsOption['login_smsfeedBack'];
    
}
//echo status("api.smsfeedback.ru", 80, "VladimirWebMonitor", "wV6z7PwvpAAkuRa", "A133541BC");
