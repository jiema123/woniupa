<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wnp_list extends CI_Controller {
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
		$this->load->database($config);
		$this->data['title'] = '蜗牛爬，爬你想要的';
		$this->data['seo_keyword'] = '蜗牛爬 动漫 漫画';
		$this->data['seo_desc'] = '不要广告看漫画，只看图不说话';
		$this->data['link'] = '';
	
	}
	
	public function index(){
		$bid = isset($_GET['id'])?$this->input->get('id'):false;
		$data['list_title'] = '';
		if(!$bid){
			$data=array();
		}else{
			$limit=5;
			$totalnum = $this->num('b_id = '.$bid);
			$totalpage = ceil($totalnum/$limit);
			$start = $this->input->get('page')?$this->input->get('page'):1;
			$start = $limit*($start-1);			
			$order = isset($_GET['order'])?$this->input->get('order'):'desc';
			$sql = "select c.c_id id ,c.c_name name from chapter c where  c.c_isvalid=1  and c.b_id = {$bid} order by c.c_order {$order} limit {$start}, {$limit}";
			$query=$this->db->query($sql);
			$data = $query->result_array();
			$data['list'] = $data;
			$data['totalpage'] = $totalpage;
			$data['list_title'] = $this->getname($bid);
		}

		
		$data = array_merge($data,$this->data);
		$this->load->view('wnp_list',$data);
	}
	private function num($condition=false){
		if(!$condition){
			$condition = '1=1';
		}
		$sql = "select count(1) as num from chapter where c_isvalid=1 and c_state='11' and $condition";
		$query=$this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['num'];
	}	
	private function getname($id){
		$sql = "select b_name  from book where b_id={$id}";
		$query=$this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['b_name'];		
	}
}