<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Index_611zy extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$config['hostname'] = "localhost";
		$config['username'] = "root";
		$config['password'] = "";
		$config['database'] = "611zy";
		$config['dbdriver'] = "mysql";
		$config['char_set'] = "utf8";
		$this->limit = 20;
		$this->offset=1;
		$this->load->database($config);		
	}	
	public function index(){
		if($this->input->get('per_page')>0){
			$this->offset=$this->input->get('per_page');
	
		}
	
		$data['result'] = $this->getData();
		$data['rootpath'] = 'F:\wamp\www';
		$data['fldy'] = $this->getOneType();
		$data['dqdy'] = $this->getOneType('dq');
		$this->totalpage = $this->getTotal();
		$data['page_link'] = $this->links('index.php?c=index_611zy&m=index');

		$this->load->view('index_611zy',$data);
	}

	public function content(){
		$id = $this->input->get('id');
		$data = $this->getOneData($id);
		$data['fldy'] = $this->getOneType();
		$data['dqdy'] = $this->getOneType('dq');
		$data['rootpath'] = 'F:\wamp\www';
		
		$this->load->view('content_611zy',$data);
	}
	
	public function blist(){
		if($this->input->get('per_page')>0){
			$this->offset=$this->input->get('per_page');
	
		}		
		$fl = urldecode($this->input->get('fl'));
		$dq = urldecode($this->input->get('dq'));
		if($fl){
			$q = "fl = '$fl'";
			$pq = "fl=$fl";
		}else{
			$q = "dq = '$dq'";
			$pq="dq=$dq";
		}
		
		$data['result'] = $this->getData($q);
		$data['rootpath'] = 'F:\wamp\www';
		$data['fldy'] = $this->getOneType();
		$data['dqdy'] = $this->getOneType('dq');
		$this->totalpage = $this->getTotal($q);
		$data['page_link'] = $this->links("index.php?c=index_611zy&m=blist&$pq");
		$this->load->view('index_611zy',$data);
	}
	
	private function links($baseurl){
		$this->load->library('pagination');		
		$config['first_link'] = '首页';
		$config['last_link'] = '末页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';
		$config['num_links'] = 10;
		$config['anchor_class'] = "class='links' ";
		$config['base_url'] = $baseurl;
		$config['total_rows'] = $this->totalpage;
		$config['per_page'] = $this->limit; 
		$this->pagination->initialize($config);	
		return $this->pagination->create_links();
	}
	
	private function getOneData($id){
		$sql = "select * from book where id=$id and isvalid=1";
		$query = $this->db->query($sql);
		$data=$query->row_array();
		return $data;
	}
	private function getOneType($type='fl'){
		$newA=array();
		$sql = "select DISTINCT($type) as tt from book where isvalid=1";
		$query = $this->db->query($sql);
		$data=$query->result_array();
		foreach($data as $sa){
			$newA[] = $sa['tt'];
		}
		return $newA;		
	}
	private function getTotal($where=false){
		if(!$where){
			$where ='1=1';
		}
		if($this->input->get('new')){
			$where.=" and itime='".date('Y-m-d')."'";
		}
		$sql = "select count(1) as con from book where isvalid=1 and {$where}";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		$data=$query->row_array();
		//print_r($data);exit;
		return $data['con'];		
	}
	private function getData($where=false){
		if(!$where){
			$where ='1=1';
		}
		if($this->input->get('new')){
			$where.=" and itime ='".date('Y-m-d')."'";
		}
		$sql = "select * from book where isvalid=1 and {$where} order by itime desc limit {$this->limit} offset {$this->offset}";
		//echo $sql;exit;
		$query = $this->db->query($sql);
		$data=$query->result_array();
		return $data;
	}
}
