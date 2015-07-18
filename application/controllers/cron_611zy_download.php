<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
ini_set('max_execution_time', 3000);
class Cron_611zy_download extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->library('xquery');
		$this->load->library('functions');
		$this->load->library('log');
		$config['hostname'] = "localhost";
		$config['username'] = "root";
		$config['password'] = "";
		$config['database'] = "611zy";
		$config['dbdriver'] = "mysql";
		$config['char_set'] = "utf8";
		$this->proxy='76.164.213.124:7808';
		$this->load->database($config);
		
		
		$this->startUrl='http://www.611zy.la/';
		$this->xpathArr=array(
			'start_links'=>"//html/body/div[@class='search-box search-box_2']/ul[@class='search-box_2_nav']/li/a",
			'list_url' => "//div[@id='wrap']/div[@class='wrapleft']/div[@class='leftcontent']/ul/li/div[@class='list1']/a",
			'list_page'=> "//div[@id='pagelist']/span[1]",
		);
		$this->xpathArrData=array(
			'bt'=>'//*[@id="wrap"]/div[1]/div/div/div[3]/ul',
			'vod'=>'//*[@id="wrap"]/div[1]/div/div/div[5]/ul/a',
			'img'=>'//*[@id="wrap"]/div[1]/div/div/div[1]/img',
			'fl'=>'//*[@id="wrap"]/div[1]/div/div/div[1]/p[4]',
			'dq'=>'//*[@id="wrap"]/div[1]/div/div/div[1]/p[6]',
			'itime'=>'//*[@id="wrap"]/div[1]/div/div/div[1]/p[9]',
			'title'=>'//*[@id="wrap"]/div[1]/div/div/div[1]/h1',
		);
		$this->data=array();
		$this->download_path = 'F:\wamp\www\download\downloadimg/';
		
		
	}
	
	public function img(){
		$this->log->write_log('INFO',"611zy img download start");
		$this->imgArr= $this->getImgArr();
		foreach($this->imgArr as $link => $path){
			if(!file_exists($path)){
				$str = $this->get_html($link);
				if(!$str)continue;
				file_put_contents($path,$str);
				$this->updateImg($link);
				$this->log->write_log('INFO', "download $link ok");
			}else{
				$this->log->write_log('INFO', "$link is download");
				$this->updateImg($link);
			}
		}
		
	}
	
	public function index($ishis){
		$this->isDownloadArr= $this->getDataArr();
		$html = $this->get_html($this->startUrl);
		if(!$html)return FALSE;
		$startLinks = $this->get_next_links($html);
		//print_r($startLinks);exit;
		if($ishis=='new'){
			$startLinks = array($startLinks[0]);
		}
		//多进程并发
		if(is_numeric($ishis)){
			$startLinks = array($startLinks[$ishis]);
		}
		$this->for_donwload($startLinks);

	}
	private function get_html($url,$proxy=false){
		$urlinfo['url'] = $url;
		if($this->proxy){
			$urlinfo['proxy']=$this->proxy;
		}
		
		$html = $this->functions->curlHtml($urlinfo);
		if(!$html){
			$this->log->write_log('erro','empty html '.$url);
			return false;
		}
		return $html;
	}
	
	private function get_next_links($html,$type='start_links'){
		$this->xquery->load_string($html);
		return $this->xquery->Query($this->xpathArr[$type])->attrList('href');
		
	}
	private function get_pages($html,$type='list_page'){
		$this->xquery->load_string($html);
		$pagestr = $this->xquery->Query($this->xpathArr[$type])->text();
		if($pagestr){
			preg_match('/\d+\/(\d+)/is',$pagestr,$p);
			return $p[1];
		}
		return false;
	
	}
	
	private function get_data($html,$url){
		$this->data=array();
		$this->xquery->load_string($html);
		$this->data['source'] = $url;
		foreach($this->xpathArrData as $k => $xp){
			if($k=='img'){
				$str = $this->functions->getlink($this->startUrl,$this->xquery->Query($xp)->attr('src'));
				$this->data['imgpath']=$this->download_path.md5($str).$this->attr($str);
				//file_put_contents($this->data['imgpath'],$this->get_html($str));
				
			}elseif(in_array($k,array('fl','dq','itime'))){
				$str = $this->xquery->Query($xp)->text();
				$limit = iconv('gbk','utf-8','：');
				$tt = explode($limit,$str);
				$str = $tt[count($tt)-1];
				$str = preg_replace('/.*(\d{4}-\d{1,2}-\d{1,2}).*/is','$1',$str);
			}
			else{
				$str = $this->xquery->Query($xp)->text();
			}
			$this->data[$k] = $str;
		
		}
		
		//print_r($this->data);exit;
	
	}
	
	private function attr($file){
		$tmp = explode('.',$file);
		return '.'.$tmp[count($tmp)-1];
	}
	private function for_donwload($links){
		foreach($links as $k=>$lk){
			$url = $this->functions->getlink($this->startUrl,$lk);
			$this->log->write_log('info', $url);
			$html=$this->get_html($url);
			if(!$html)continue;
			$bookLinks = $this->get_next_links($html,'list_url');
			$page = $this->get_pages($html,'list_page');
			$this->for_download_page($bookLinks,$url);
			if($page){
				for($i=$page;$i>=2;$i--){
					$newlistUrl = preg_replace('/(\.html)/is',"_$i$1",$url);
					$this->log->write_log('info',$newlistUrl);
					$html=$this->get_html($newlistUrl);
					if(!$html)continue;
					$bookLinks = $this->get_next_links($html,'list_url');
					$this->for_download_page($bookLinks,$url);					
				}
			}
		}
	
	}
	
	private function for_download_page($booklink,$url){
		foreach($booklink as $k=>$val){
			$url = $this->functions->getlink($url,$val);
			$this->log->write_log('info',$url);
			if(isset($this->isDownloadArr[$url])){
				$this->log->write_log('info','is downloaded');
				continue;
			}
			$html=$this->get_html($url);
			if(!$html)continue;
			$this->get_data($html,$url);
			$this->insertDb();
		}
	
	}
	
	private function getDataArr(){
		$newArr = array();
		$sql ='select source from book';
		$query = $this->db->query($sql);
		$data = $query->result_array();
		foreach($data as $val){
			$newArr[$val['source']]=1;
		}
		return $newArr;
	}
	
	private function getImgArr(){
		$newArr = array();
		$sql ='select img,imgpath from book where isdownload = 0 order by itime desc';
		$query = $this->db->query($sql);
		$data = $query->result_array();
		foreach($data as $val){
			$newArr[$val['img']]=$val['imgpath'];
		}
		return $newArr;
	}
	private function updateImg($img){
		$sql = "update book set isdownload=1 where img = '{$img}'";
		$this->db->query($sql);
	}
	
	
	private function insertDb(){
		$this->db->insert('book', $this->data); 
		
	}
	
	public function __destruct(){
		$this->db->close();
	}
	
}