<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wnp_img extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('huaban');
		$this->load->library('functions');
		$this->boardname='tmpImgBoard';
		$this->boardid='';
		$this->token='';
		$this->tokentype='';
	}
	
	public function index()
	{
		
		$url = $this->input->get('url');
		readfile($url);
		exit;

		
	}
	
	
	public function img(){
		$this->config();
		$typeArr = array(
			'236' => '_fw236',
				
		);
		$id = isset($_GET['id'])?$_GET['id']:false;
		$i_id = isset($_GET['iid'])?$_GET['iid']:false;
		$type = isset($_GET['type'])?$_GET['type']:false;
		if(!$id && !$i_id)return false;
		if($id){
			$condition = 'c_id = '.$id;
		}elseif($i_id){
			$condition = 'i_id = '.$i_id;
		}else{
			$condition = '1=1';
		}
		$sql = "select i_path path ,i_source url ,c_source host ,i_id id from img where {$condition}  order by i_id desc limit 1";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		if(count($data)<=0)return false;

		if(isset($data[0]['path']) && empty($data[0]['path']) ){
			$data[0]['path'] = $this->upload_img($data[0]['url'],$data[0]['host'],$data[0]['id']);
		}

		if($type){
			readfile($data[0]['path'].$typeArr[$type]);
		}else{
			readfile($data[0]['path']);
		}
	}
	
	
	private function config(){
		$config['hostname'] = "localhost";
		$config['username'] = "root";
		$config['password'] = "";
		$config['database'] = "wnp";
		$config['dbdriver'] = "mysql";
		$config['char_set'] = "utf8";
		$this->load->database($config);
		
	}
	private function settoken(){
		$sql = "select token,tokentype,usednum from hb_user where isvalid=1 and islock=0";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		$num = rand(0,count($data)-1);
		$this->token = $data[$num]['token'];
		$this->tokentype = $data[$num]['tokentype'];
		$updata['usednum']= $data[$num]['tokentype']+1;
		$str = $this->db->update_string('hb_user',$updata,"token='{$this->token}'");
		$this->db->query($str);

	}
	
	private function upload_img($source,$referer,$id){
			$this->settoken();
			$url = $this->functions->checkImhUrl($source,$referer);
			if(!$url)return false;
	
			if(!$this->boardid){
				$this->setboardid();
			}
	
			$config = array(
					'token'=>$this->token,
					'token_type'=>$this->tokentype,
					'title'=>'img',
					'link'=>$referer,
					'img_url'=>$url,
					'board_id'=>$this->boardid,
			);
			$data = $this->huaban->uploadImg($config);
			$condition = "i_id = {$id}";
			if(isset($data['file'])){
				$this->data['i_content'] = $this->getImgStr($data['file']['key']);
				$this->data['i_path'] = $data['file']['key'];
				$this->data['i_type'] = $data['file']['type'];
				$this->data['i_width'] = $data['file']['width'];
				$this->data['i_height'] = $data['file']['height'];
				$this->data['i_rtime'] = date('Y-m-d H:i:s');
				$str = $this->db->update_string('img',$this->data,$condition);
				$this->db->query($str);
				return $this->data['i_path'];
			}


	
	}
	private function getboardid(){
		if($this->boardname){
			$sql = "select b.boardid bid from hb_board b where  b.boardname='{$this->boardname}' and b.userid='{$this->token}'";
			$query=$this->db->query($sql);
			$data = $query->result_array();
			if(isset($data[0]['bid'])){
				$this->boardid = $data[0]['bid'];
			}else{
				$this->setboardid();
			}
		}
	}
	
	private function setboardid(){
		$this->boardid = $this->huaban->setBoard($this->boardname,$this->token,$this->tokentype);
		$data['ctime'] = date('Y-m-d H:i:s');
		$data['userid'] = $this->token;
		$data['boardid'] = $this->boardid;
		$data['boardname'] = $this->boardname;
		$str = $this->db->insert_string('hb_board',$data);
		$this->db->query($str);
	
	}	
	private function getImgStr($url){
		$request['url'] = $url;
		$html = $this->functions->curlHtml($request);
		$base64str = base64_encode($html);
		return $base64str;
	}

}