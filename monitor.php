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
   
  
   public function getHeader()
   {
        $url = $this->url;

        // Remove all illegal characters from a url
        $url = filter_var($url, FILTER_SANITIZE_URL);

        // Validate url
        if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
        echo("$url is a valid URL");
        } else {
        echo("$url is not a valid URL");
        }

       $this->header=get_headers($this->url);
     //  debug($this->header);
      
   }
   public function getResponse()
   {
       $this->getHeader();
       $response=$this->header[0];
     //  debug($response);
       $responseNum= mb_strcut($response,9,3,"UTF-8");
       return $responseNum;
   }
   public function checkResponse()
   {
       if ($this->getResponse()==200) return true; else return false;
   }
   private function getFilePage()
   {  
        $this->filePage = fopen($this->url, "r");
   }
   public function getPageSize()
   {
        $this->getFilePage();
        $fileSize=0;
        while(($str = fread($this->filePage, 1024)) != null)
        {
            $fileSize += strlen($str);
        }
        return $fileSize;
   }
   public function checkPageSize()
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
   private function file_get_contents_curl($url)
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
//        echo "H1: $h1";
//        echo "Title: $title". '<br/><br/>';
//        echo "Description: $description". '<br/><br/>';
//        echo "Keywords: $keywords"."<br>";
        $this->meta=["url"=>$this->url, "h1"=>$h1,"title"=>$title,"keywords"=>$keywords,
            "description"=>$description];
        return $this->meta;
   }

   public function checkH1()
   {
       if ($this->meta['h1']==$this->h1) return true; else return false;
   } 
   public function checkTitle()
   {
       if ($this->meta['title']==$this->title) return true; else return false;
   }
   public function checkKeywords()
   {
       if ($this->meta['keywords']==$this->keywords) return true; else return false;
   }
   public function checkDescription()
   {
       if ($this->meta['description']==$this->description) return true; else return false;
   }
   public function getDataMonitorPage()
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
       return $data;
   }
   public function getUrl()
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
   public function setUrl($value)
   {
       $this->url=$value;
   }
   public function setPageSize($value)
   {
       $this->pageSize=$value;
   }
   public function setDeviationSize($value)
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
//$monitor=new Monitor;
//$monitor->setUrl("https://www.sberbank.ru/ru/person");
//$monitor->getHeader();