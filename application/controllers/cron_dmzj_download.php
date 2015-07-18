<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
ini_set('max_execution_time', 3000);
class Cron_dmzj_download extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->library('xquery');
		$this->load->library('functions');
	
	}
	
	public function getChapter(){

		$this->url = 'http://manhua.dmzj.com/hundun/29258.shtml';
		$str = $this->get_html($this->url);

		if(preg_match_all("/\\\'\[(.*?)\]\\\'/is",$str,$link)){
			print_r($link);
		}
		if(preg_match("/\w+,'(.*?)'\.split/is",$str,$split)){
			print_r($split);
		}
	
	}
	
	private function get_html($url,$proxy=false){
		$urlinfo['url'] = $url;
		if($proxy){
			$urlinfo['proxy']=$proxy;
		}
		
		$html = $this->functions->curlHtml($urlinfo);
		if(!$html){
			$this->log->write_log('erro','empty html '.$url);
			return false;
		}
		return $html;
	}
}