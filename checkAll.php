<?php
/*
 * это файл который запускается автоматически и проверяет все страницы
 * на мониторинге. И раздает приказы на отпрвку СМС сообщений
 */
require_once 'functions.php';
require_once 'modelDBResultCheck.php';
require_once 'modelJournal.php';
require_once 'modelDataServis.php';
require_once 'main.php';
require_once "modelDBForCheck.php";

require_once 'SMS.php';
require_once 'modelDataServis.php';
require_once "modelUserOption.php";
//ini_set('display_errors', 'On'); // сообщения с ошибками будут показываться
//error_reporting(E_ALL); // E_ALL - отображаем ВСЕ ошибки
$GLOBALS['time1']=time();// устанавливаем начало отчета времени
// создаем нужные обьекты
$DBResultCheck=new modelDBResultCheck();
$dataServis=new modelDataServis();
$journal=new Journal();
$DBUserOption=new modelUserOption();

$resultChecks=checkAll();// проверяем все сайты
$DBResultCheck->writeResChecksInDB($resultChecks);// записываем результаты проверок в таблицу result_check
$smsOption=$DBUserOption->getSmsOption();// получаем настройки отпрвки смс
//debug($smsOption);
if ($smsOption['sms_submit']==1)// если стоит галочка в насторйках отправлять смс
{
    // проверям больше ли баланс для отправки смс 10 руб и в бд записано что ранее отпраляли смс о балансе
    if (cutBalance(getBalance())>=10 && $dataServis->getSmsBalanceSubmit()==1)
    {// если да в бд записываем что не не отправляли смс о балансе
        $dataServis->updateSmsBalanceSubmit(0);
    }
    for ($i=0;$i<count($resultChecks);$i++)// цикл по результам проверок
    {
        $code=$journal->createCodeByResCheck($resultChecks[$i]);// получаем код, проверки, по результам проверки страницы
        $flagSmsOption=false;// флаг того что настройки смс позволяют отправитть смс в данном случае
        $flagSmsJournal=$journal->checkOneToWriteDB($resultChecks[$i]['url'],$code);// флаг того что журнал позволяет отправить смс 
        //debug($code);
        // узнаем позволяет ли смс настройки отправить соощение
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
        
        if ($flagSmsJournal==true && $flagSmsOption==true)// если журнал и настройки позволи отправить смс
        {
            $textSms=$journal->codeToMessage($resultChecks[$i]['url'], $code,
                                             $resultChecks[$i]['response'],true);// получим текс сообщения
           submitSMS($textSms);// отправим смс 
           
           if ($smsOption['sms_balance']==1 && cutBalance(getBalance())<10 &&
                            $dataServis->getSmsBalanceSubmit()==0)//если баланс менее 10 руб и есть условия соответствуюшие
            {
                submitSMS("Баланс WebMonitor, для отправки смс, меньше 10 руб");
                $dataServis->updateSmsBalanceSubmit(1);
            }
        }
    }
}

$journal->updateJournal();// обновить журнал
$GLOBALS['time2']=time()-$GLOBALS['time1'];// расчитать время которое заняло на обработку скрипта
//debug($GLOBALS['time2']);
$dataServis->updateCheckAllTime($GLOBALS['time2']);// записать в бд время выполнения скрипта.

