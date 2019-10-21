<?php
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
function submitSMS($text) // отправить смс сообшение с настройками    
{
    ini_set('display_errors', 'On'); // сообщения с ошибками будут показываться
    error_reporting(E_ALL); // E_ALL - отображаем ВСЕ ошибки
    require_once 'modelUserOption.php';
    require_once 'crypt.php';
    //require_once 'modelDataServis.php';
    $crypt=new MCrypt();
    $DBUserOption=new modelUserOption();  
   // $dataServis=new modelDataServis();
    $smsOption=$DBUserOption->getSmsOption();
    $loginPassword=$DBUserOption->getSmsOptionLoginPassword();
   
    //return balance("api.smsfeedback.ru", 80, "VladimirWebMonitor", "wV6z7PwvpAAkuRa");
    //$dataServis->updateBalance($dataServis->getBalance()-3);
    //echo 'SMS '.$text."<br>";
   
    send("api.smsfeedback.ru", 80, $loginPassword['login_smsfeedback'], 
          $crypt->decrypt($loginPassword['password_smsfeedback']), 
          $smsOption['telephone'], $text, "TEST-SMS");
   // debug ($loginPassword);
   // echo '<br> '.$crypt->decrypt($loginPassword['password_smsfeedback']).'  '.$smsOption['telephone'];
}
function getBalance()// получить баланс для отправки сообшений с настройками
{
    require_once 'modelUserOption.php';
    require_once 'crypt.php';
    //require_once 'modelDataServis.php';
    $crypt=new MCrypt();
  //  $dataServis=new modelDataServis();
    $DBUserOption=new modelUserOption();  
    $smsOption=$DBUserOption->getSmsOptionLoginPassword();
    //return balance("api.smsfeedback.ru", 80, "VladimirWebMonitor", "wV6z7PwvpAAkuRa")
    
   // return $dataServis->getBalance();
    
    $balance=balance("api.smsfeedback.ru", 80, $smsOption['login_smsfeedback'], 
                                           $crypt->decrypt($smsOption['password_smsfeedback']));
    return $balance;
    
}
function cutBalance($balance)
{
    if (strlen($balance)<40)
    {
        $balanceArr=explode(';', $balance);    
        $balance=$balanceArr[1];
        return $balance;   
    }
    else 
    {
        return 'нет данных';
    }
}
