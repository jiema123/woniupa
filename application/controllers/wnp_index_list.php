<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wnp_index_list extends CI_Controller {
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
	
	public function rq(){
		
		$sql = "select b_mtime,b_id,b_name,b_author,b_status,b_describe,b_coverlocalpath from book where b_state ='11' limit 100";
		$query=$this->db->query($sql);
		$data = $query->result_array();
		$data['list'] = $data;
		$data['list_title'] = '人气漫画100看';
		$data = array_merge($data,$this->data);
		$this->load->view('wnp_index_list',$data);
	}
	
	public function sj(){
		$rand = rand(1,1000);
		$sql = "select b_mtime,b_id,b_name,b_author,b_status,b_describe,b_coverlocalpath from book where b_state ='11' limit $rand,10";
		$query=$this->db->query($sql);
		$data = $query->result_array();
		$data['list'] = $data;
		$data['list_title'] = '随便看看';
		$data = array_merge($data,$this->data);
		$this->load->view('wnp_index_list',$data);
	}
	public function wj(){

		$limit=20;
		$start = $this->input->get('per_page')?$this->input->get('per_page'):0;
		$totalnum = $this->num("b_status='已完结'");
		$totalpage = ceil($totalnum/$limit);
		$con['baseurl'] = 'index.php?c=wnp_index_list&m=wj';
		$con['totalpage'] = $totalnum;
		$con['limit'] = $limit;
		
		$this->data['link'] = $this->links($con);
		$sql = "select b_mtime,b_id,b_name,b_author,b_status,b_describe,b_coverlocalpath from book where b_state ='11' and b_status='已完结' limit $start,$limit";
		$query=$this->db->query($sql);
		$data = $query->result_array();
		$data['list'] = $data;
		$data['list_title'] = '完结版漫画，痛快看个爽';
		$data = array_merge($data,$this->data);
		$this->load->view('wnp_index_list',$data);
	}
	public function lz(){
		$limit=20;
		$start = $this->input->get('per_page')?$this->input->get('per_page'):0;
		$totalnum = $this->num("b_status='连载中'");
		$totalpage = ceil($totalnum/$limit);
		$con['baseurl'] = 'index.php?c=wnp_index_list&m=lz&page='.$start;
		$con['totalpage'] = $totalnum;
		$con['limit'] = $limit;
		
		$this->data['link'] = $this->links($con);
		$sql = "select b_mtime,b_id,b_name,b_author,b_status,b_describe,b_coverlocalpath from book where b_state ='11' and b_status='连载中' limit $start,$limit";
		$query=$this->db->query($sql);
		$data = $query->result_array();
		$data['list'] = $data;
		$data['list_title'] = '连载漫画，不要急更新通知';
		$data = array_merge($data,$this->data);
		$this->load->view('wnp_index_list',$data);
	}
	public function all(){
		$limit=20;
		$totalnum = $this->num();
		$totalpage = ceil($totalnum/$limit);
		$start = $this->input->get('page')?$this->input->get('page'):1;
		$start = $limit*($start-1);
		$sql = "select b_mtime,b_id,b_name,b_author,b_status,b_describe,b_coverlocalpath from book where b_state ='11' order by b_suoyin limit $start,$limit";
		$query=$this->db->query($sql);
		$data = $query->result_array();
		$data['totalpage'] = $totalpage;
		$data['list'] = $data;
		$data['list_title'] = '所有漫画';
		$data = array_merge($data,$this->data);
		$this->load->view('wnp_index_list',$data);		
		
	}	
	private function num($condition=false){
		if(!$condition){
			$condition = '1=1';
		}
		$sql = "select count(1) as num from book where b_isvalid=1 and b_state='11' and $condition";
		$query=$this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['num'];
	}
	
	private function links($con){
		$this->load->library('pagination');
		$config['first_link'] = '首页';
		$config['last_link'] = '末页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';
		$config['num_links'] = 10;
		$config['anchor_class'] = "class='links' ";
		$config['base_url'] = $con['baseurl'];
		$config['total_rows'] = $con['totalpage'];
		$config['per_page'] = $con['limit'];
		$this->pagination->initialize($config);
		return $this->pagination->create_links();
	}
}