<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wnp_index extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$config['hostname'] = "localhost";
		$config['username'] = "root";
		$config['password'] = "";
		$config['database'] = "wnp";
		$config['dbdriver'] = "mysql";
		$config['char_set'] = "utf8";
		$this->limit = 20;
		$this->offset=1;
		$this->data = array();
		$this->load->database($config);
		$this->data2['title'] = '蜗牛爬，爬你想要的';
		$this->data2['seo_keyword'] = '蜗牛爬 动漫 漫画';
		$this->data2['seo_desc'] = '不要广告看漫画，只看图不说话';
	
	}
	
	public function index()
	{
		$this->getHotManHua();
		$this->getLzManHua();
		$this->getWjManHua();
		$data['hotmanhua'] = $this->data['hotmanhua'];
		$data['lzmanhua'] = $this->data['lzmanhua'];
		$data['wjmanhua'] = $this->data['wjmanhua'];
		$data = array_merge($data,$this->data2);
		$this->load->view('wnp_index',$data);
	}
	
	
	public function showres(){
		$data = $this->getSearch();
		$data['list'] = $data;
		$data['list_title'] = '搜索结果';
		$data['link'] = '';
		$data = array_merge($data,$this->data2);
		$this->load->view('wnp_index_list',$data);		
	}
	
	public function search(){
		$q = $this->input->get('q');
		$sql = "select b_name,b_id,b_status from book where b_isvalid = 1 and b_state=11 and instr(b_name,'{$q}')";
		$query=$this->db->query($sql);
		$data = $query->result_array();
		foreach($data as $k=>$row){
			echo "{$row['b_name']}|{$row['b_id']}|{$row['b_status']}\n";
		}		
	}
	
	private function getSearch(){
		$key = $this->input->get('key');
		$keys = urldecode($key);
		$tmparr = explode(', ',$keys);
		foreach($tmparr as $val){
			$val = trim($val);
			if(!$val)continue;
			if(count($tmparr)>1){
				$q[] = "'$val'";
				
			}else{
				$q = "'$val'";
			}
		}
		if(is_array($q)){
			$str = implode(',',$q);
			$where = "b_name in($str)";
		}else{
			$where = "instr(b_name, $q)";
		}
		$sql = "select b_mtime,b_id,b_name,b_author,b_status,b_describe,b_coverlocalpath from book where b_state ='11' and $where limit 10";
		$query=$this->db->query($sql);
		$data = $query->result_array();	
		return $data;	
	}
	
	private function getHotManHua(){
		$sql ="select b_name,b_id,b_status,b_coverlocalpath from book  where b_isvalid =1 and b_state = '11' limit 15";
		$query=$this->db->query($sql);
		$data = $query->result_array();
		$this->data['hotmanhua'] = $data;
	}
	private function getLzManHua(){
		$sql ="select b_name,b_id,b_status,b_coverlocalpath from book  where b_status = '连载中' and b_state = '11' and b_isvalid =1 order by b_mtime desc limit 20 ";
		$query=$this->db->query($sql);
		$data = $query->result_array();
		$this->data['lzmanhua'] = $data;		
		
	}
	private function getWjManHua(){
		$sql ="select b_name,b_id,b_status,b_coverlocalpath from book  where b_status = '已完结' and b_state = '11' and b_isvalid =1 order by b_mtime  desc limit 20 ";
		$query=$this->db->query($sql);
		$data = $query->result_array();
		$this->data['wjmanhua'] = $data;
	
	}	
}
