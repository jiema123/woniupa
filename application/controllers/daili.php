<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Daili extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->library('xquery');
		$this->load->library('functions');		
	}

	public function index(){}
	
	public function check(){
		$url['url'] = 'http://www.site-digger.com/html/articles/20110516/proxieslist.html';
		$xpath= "//table[@id='proxies_table']/tbody/tr/td[1]";
		
		$html = $this->functions->curlHtml($url);
		$this->xquery->load_string($html);
		$dailiArr = $this->xquery->Query($xpath)->textList();
		//print_r($dailiArr);
		array_push($dailiArr,'');
		$url=isset($_GET['url'])?$_GET['url']:'http://tp.hd.mi.com/gettimestamp';
		foreach($dailiArr as $d){
			$stime = time();
			
			$cmd = 'curl -sI -x '.$d.' --connect-timeout 3 -m 3 "'.$url.'"';
			if(!$d){
				$cmd = 'curl -sI --connect-timeout 3 -m 3 "'.$url.'"';
			}
			$h = $this->functions->ppopen($cmd);
			if(preg_match('/200\s*ok/is',$h)){
				echo $d.' take '. (time()-$stime)."seconds\n";
			}else{
				continue;
			}
		}
		
	}

}