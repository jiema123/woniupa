<?php
/*
 用法：
 $xq = new xQuery();
 $xq->load("http://jingyan.baidu.com");
 $texts = $xq->Query('//a')->textList();
 详情介绍：http://hi.baidu.com/tdweb/blog/item/5d510f955ba8971a7af48059.html
*/
libxml_use_internal_errors(true);
class CI_XQuery{
	private $html;
	private $query;
	private $dom;
	private $xpath;
	private $gb_arr=array();


	function __construct(){
		$this->dom = new DOMDocument();		
	}
	//直接传入HTML代码
	function load_string($html){
		$html = $this->format_html($html);
		$this->html = $html;
		$this->dom->loadHTML($this->html);
		$this->xpath = new DOMXPath($this->dom);
	}

	//格式化HTML并且进行自动转码
	function format_html($html){
		if ($this->chkCode($html) == "GBK"){
			$html = iconv("gb18030","utf-8",$html);
			$html = '<meta http-equiv="Content-Type" content="text/html;charset=utf-8">'.$html;
			$gb_arr = array("charset=gb18030","charset=gbk","charset=gb2312");
			$html = str_replace($this->gb_arr,"charset=utf-8",$html);
		}
		return $html;
	}

	//通过CURL读取URL
	function load($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_REFERER,'http://www.baidu.com');
		curl_setopt($ch, CURLOPT_USERAGENT, "Baiduspider+(+http://www.baidu.com/search/spider.htm)");
		$html = curl_exec($ch);
		curl_close($ch);
		$this->html = $this->format_html($html);
		$this->dom->loadHTML($this->html);
		$this->xpath = new DOMXPath($this->dom);
	}

	function __call($method,$args){
		switch ($method){
			case "Query":
				$this->query = $args[0];
				break;
		}
		return $this;
	}

	function textList(){
		$return_array = array();
		$list = $this->xpath->query($this->query);
		foreach ($list as $v){
			$text = $this->clear_whites($v->nodeValue);
			array_push($return_array,$text);
		}
		return $return_array;
	}

	function text(){
		$list = $this->xpath->query($this->query);
		$item = $list->item(0);
		try{
			return $this->clear_whites($item->nodeValue);
		}catch(Exception $e){
			echo $e->getMessage();
			return false;
		}
	}

	function attrList($attr){
		$return_array = array();
		$list = $this->xpath->query($this->query);
		foreach ($list as $v){
			$text = $v->getAttributeNode($attr)->value;
			array_push($return_array,$text);
		}
		return $return_array;
	}

	function attr($attr){
		$list = $this->xpath->query($this->query);
		$item = $list->item(0)->getAttributeNode($attr)->value;
		return $item;
	}

	function htmlList(){
		$return_array = array();
		$list = $this->xpath->query($this->query);
		foreach ($list as $v){
			$text = $this->dom->saveXML($v);
			array_push($return_array,$text);
		}
		return $return_array;
	}

	function html(){
		$list = $this->xpath->query($this->query);
		$item = $this->dom->saveXML($list->item(0));
		return $item;
	}

	function clear_whites($str){
		$replace_arr = array("\r","\n","\r\n","	");
		return trim(str_replace($replace_arr,'',$str));
	}

	function chkCode($string){
		$code = array('ASCII', 'GBK', 'UTF-8');
		foreach($code as $c){
			if( $string === @iconv('UTF-8', $c, @iconv($c, 'UTF-8', $string))){
				return $c;
			}
		}
		return null;
	}
}
?>