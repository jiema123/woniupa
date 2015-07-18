
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wnp_view extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$config['hostname'] = "localhost";
		$config['username'] = "root";
		$config['password'] = "";
		$config['database'] = "wnp";
		$config['dbdriver'] = "mysql";
		$config['char_set'] = "utf8";
		$this->load->database($config);
		$this->data['title'] = '蜗牛爬，爬你想要的';
		$this->data['seo_keyword'] = '蜗牛爬 动漫 漫画';
		$this->data['seo_desc'] = '不要广告看漫画，只看图不说话';
		$this->data['link'] = '';
	
	}
	
	public function index(){
		$limit = 2;
		$cid = isset($_GET['id'])?$_GET['id']:false;
		if(!$cid)return false;
		$totalnum = $this->num('c_id = '.$cid);
		$totalpage = ceil($totalnum/$limit);
		$start = $this->input->get('page')?$this->input->get('page'):1;
		$start = $limit*($start-1);		

		$sql = "select i_id id from img where c_id = {$cid} and i_isvalid =1 order by i_order asc limit {$start}, {$limit}";
		$query=$this->db->query($sql);
		$data = $query->result_array();
		$data['list'] = $data;
		$data['totalpage'] = $totalpage;
		$data['list_title'] = '';
		$data = array_merge($data,$this->data);
		$this->load->view('wnp_view',$data);
	}
	private function num($condition=false){
		if(!$condition){
			$condition = '1=1';
		}
		$sql = "select count(1) as num from img where i_isvalid=1 and i_state='11' and $condition";
		$query=$this->db->query($sql);
		$data = $query->result_array();
		return $data[0]['num'];
	}
}