<?php
/**
 * Description of monitor
 *
 * @author Владимир
 */
require_once "functions.php";
class monitor
{
   private $header;
   private $url;
   private $filePage;
   private $pageSize;
   private $deviationSize;// +- размер страницы
   private $h1;
   private $title;
   private $keywords;
   private $descripion;
   private $meta;// хранит h1, title, keywords, description;
   public  $message;// хранит сообшение о проверке
   
   public function checkUrlForMonitor($url)// функция проверки URL коорректность и на сушествование
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
            else 
            {
                $this->message='такой страницы не сушествует';
            }
        }
        else
        {
            $this->message="Неверный URL";
        }
        return false; 
   }
   public function getHeader()// получить заголовки страницы
   {
         if ($this->checkUrlForMonitor($this->url))
         {
              $this->header=get_headers($this->url);
         }
         else
         {
             $this->header[0]=0;
         }
     //  debug($this->header);
      
   }
   public function getResponse()// получить ответ от сервера
   {
       $this->getHeader();
       $response=$this->header[0];
     //  debug($response);
       if ($response!==0)$responseNum= mb_strcut($response,9,3,"UTF-8");  else $responseNum=0;          
       return $responseNum;
   }
   public function checkResponse()// проверить ответ от сервера
   {
       if ($this->getResponse()==200) return true; else return false;
   }
   private function getFilePage()//получить файл страницы
   {  
        $this->filePage = fopen($this->url, "r");
   }
   public function getPageSize()// получить размер страницы
   {
        $this->getFilePage();
        $fileSize=0;
        while(($str = fread($this->filePage, 1024)) != null)
        {
            $fileSize += strlen($str);
        }
        return $fileSize;
   }
   public function checkPageSize()// проверить размер страницы
   {
       $factPageSize=$this->getPageSize();
       if ($factPageSize <= $this->pageSize + $this->deviationSize &&
           $factPageSize >= $this->pageSize - $this->deviationSize )
       {  
           return true;
       }
       else
       {
           return false;
       }
   }
   private function file_get_contents_curl($url)// получить файл для проверки мета данных
   {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
   }
   public function getMetaPage()// получить мета данные старницы h1, title, keywords, description
    {
        $html = $this->file_get_contents_curl($this->url);
        //parsing begins here:
        $doc = new DOMDocument();
        @$doc->loadHTML($html);
        $nodes = $doc->getElementsByTagName('title');
        //get and display what you need:
        $title = $nodes->item(0)->nodeValue;
        $metas = $doc->getElementsByTagName('meta');
        $keywords='';
        $description='';
        for ($i = 0; $i < $metas->length; $i++)
        {
            $meta = $metas->item($i);
            if($meta->getAttribute('name') == 'description')
                $description = $meta->getAttribute('content');
            if($meta->getAttribute('name') == 'keywords')
                $keywords = $meta->getAttribute('content');
        }
        $h1Doc=$doc->getElementsByTagName('h1');
        //debug($h1Doc);
        $h1=$h1Doc->item(0)->nodeValue;
        $this->meta=["url"=>$this->url, "h1"=>$h1,"title"=>$title,"keywords"=>$keywords,
            "description"=>$description];
        return $this->meta;
   }
   public function checkH1()// проверить заголовок
   {
       if (strcmp(str_replace(chr(13),'',$this->meta['h1']), str_replace(chr(13),'',$this->h1))==0) 
               return true; else return false;
   } 
   public function checkTitle()// проверить подпись
   {
       if (strcmp(str_replace(chr(13),'',$this->meta['title']), str_replace(chr(13),'',$this->title))==0)
               return true; else return false;
   }
   public function checkKeywords()// проверить ключевые слова
   {
       if (strcmp(str_replace(chr(13),'',$this->meta['keywords']), str_replace(chr(13),'',$this->keywords))==0)
               return true; else return false;
   }
   public function checkDescription()// проверить  описание
   {
       if (strcmp(str_replace(chr(13),'',$this->meta['description']), str_replace(chr(13),'',$this->description))==0) 
               return true; else return false;
   }
   public function getDataMonitorPage()// получить данные монитора страницы
   {
       if ($this->checkUrlForMonitor($this->url)===true)
       {
            $response=$this->getResponse();
            if ($response==200) $sizePage=$this->getPageSize(); else $sizepage=0;
            if ($this->meta['url']!=$this->url)$this->getMetaPage();
            $data=["url"=>$this->url,
                   "response"=>$this->getResponse(),
                   "size_page"=> $sizePage,
                   "h1"=>$this->meta['h1'],
                   "title"=>$this->meta['title'],
                   "keywords"=>$this->meta['keywords'],
                   "descrtiption"=>$this->meta['description'],
                  ];
       }
       else
       {
           $data=['url'=>$this->url,"message"=>$this->message];
       }
       return $data;   
   }
   public function getUrl()// получить URL
   {
       return $this->url;
   }
   public function setDataForMonitor($data)// данные из массива параметров переносит в переменные класса
   {
       $this->setUrl($data['url']);
       $this->setPageSize($data['size_page']);
       $this->setDeviationSize($data['deviation_size']);
       $this->setH1($data['h1']);
       $this->setTitle($data['title']);
       $this->setKeywords($data['keywords']);
       $this->setDescription($data['description']);
   }
   public function setUrl($value) // положить URL
   {
       $this->url=$value;
   }
   public function setPageSize($value) // положить размер страницы с которым сравнивать
   {
       $this->pageSize=$value;
   }
   public function setDeviationSize($value)// положить поргрещность размера страницы
   {
       $this->deviationSize=$value;
   }
   public function setH1($value)
   {
              $this->h1=$value;
   }
   public function setTitle($value)
   {
              $this->title=$value;
   }
   public function setKeywords($value)
   {
              $this->keywords=$value;
   }
      public function setDescription($value)
   {
              $this->description=$value;
   }

}
