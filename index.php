<?php
require_once "monitor.php";
require_once "modelDBforCheck.php";
//require_once 'functions.php';
$monitor=new Monitor;
//$monitor->setUrl("https://www.sberbank.ru/ru/person");
//$monitor->setUrl("http://localhost/sberbank.html");
//$monitor->setUrl("https://php.ru/manual/function.get-headers.html");
//$monitor->setUrl("http://homegame");
//$monitor->setUrl("https://www.google.com/search?rlz=1C1AVNE_ruRU855RU855&ei=FsodXbFx4YyvBOXWtZgC&q=rfr+cjplfnm+j%2Cmtrn+d+php&oq=rfr+cjplfnm+j%2Cmtrn+d+php&gs_l=psy-ab.3...1371549.1380073..1380438...6.0..0.254.4494.0j21j6......0....1..gws-wiz.....10..0i71j35i39j0j0i131j0i10i1i42j0i67j0i10i1j0i10j0i10i42j0i10i1i67j35i305i39j0i1j33i160j33i21.D9t5vZ4o2ZM");
//$monitor->setUrl("https://vk.com");
//$monitor->setUrl("https://vk.com/login?u=2&to=YWxfZmVlZC5waHA-");
$monitor->setUrl("http://art-fenshui.ru/");

$monitor->getHeader();
echo "<br>";
echo $monitor->checkResponse();
echo "<br>";
//$monitor->getFilePage();
echo $monitor->getPageSize();
$monitor->setPageSize(621000);
$monitor->setDeviationSize(9000);
echo "<br>";
$conn=connectDB();

echo $monitor->checkPageSize();
Debug($monitor->getMetaPage());
$DBForCheck=new modelDBForCheck;
$DBForCheck->setConn($conn);
//$DBForCheck->setUrl("http://art-fenshui.ru/");
//$DBForCheck->setSizePage(621000);
//$DBForCheck->setDeviationSize(9000);
//$DBForCheck->setH1("");
//$DBForCheck->setTitle("Фэн-шуй - Искусство фен-шуй - как улучшить удачу");
//$DBForCheck->setKeywords("Информационный сайт о китайской метафизике - фен-шуй,"
//        . " астрология Бацзы, выбор дат, ци мень дун цзя. Фэн-шуй прогнозы,"
//        . " рекомендации, статьи, обучающие материалы.");
//$DBForCheck->setDescription("Информационный сайт о китайской метафизике - "
//        . "фен-шуй, астрология Бацзы, выбор дат, ци мень дун цзя. "
//        . "Фэн-шуй прогнозы, рекомендации, статьи, обучающие материалы.");
//
//$DBForCheck->insertInDB();





//$DBForCheck->setUrl("http://www.ushu-academy.ru/");
//$DBForCheck->setSizePage(621000);
//$DBForCheck->setDeviationSize(9000);
//$DBForCheck->setH1(" что такое ушу");
//$DBForCheck->setTitle("ушк это круто!");
//$DBForCheck->setKeywords("ушу ухту кунгфу");
//$DBForCheck->setDescription("ушу боевое искутсво без резких движеий");
//
//$DBForCheck->insertInDB();
 //checkResponse()
$arrMonitor=$DBForCheck->readDB();
debug($arrMonitor);
for ($i=0;$i<count($arrMonitor);$i++)
{
    
}

