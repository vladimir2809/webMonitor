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
       $this->header=get_headers($this->url);
       debug($this->header);
      
   }
   public function getResponse()
   {
       $response=$this->header[0];
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
   public function getMetaPage(){
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
        $this->meta=["h1"=>$h1,"title"=>$title,"keywords"=>$keywords,
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
   
   public function setDataForMonitor($data)// данные из массива параметров переносит в переменные класса
   {
       setUrl($data['url']);
       setPageSize($data['size_page']);
       setDeviationSize($data['deviation_size']);
       setH1($data['h1']);
       setTitle($data['title']);
       setKeywords($data['keywords']);
       setDescription($data['description']);
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