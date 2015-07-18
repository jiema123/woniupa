<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
	
		echo 'Hello word';
	}
	
	public function test(){
		phpinfo();
		$data['title']='jiema I';
		$this->load->view('test_view',$data);
		$this->output->cache(3);
	}

	public function sendmail(){
		$this->load->library('email');
		$this->email->from('fang.jief@163.com','jiema fang');
		$this->email->to('523537079@qq.com');
		$this->email->subject('test email');
		$this->email->message('this is test mail');
		if($this->email->send()){
		
		}else{
			
		
		echo $this->email->print_debugger();
		}
	
	}
	
	public function sessionok(){
		$this->load->library('session');
		echo $this->session->userdata('session_id');
		$array = array('id'=>'1144','name'=>'jiema');
		$this->session->set_userdata($array);
		$se = $this->session->all_userdata();
		print_r($se);
	}
	public function page(){
		$this->load->library('pagination');
		$config['base_url'] = 'http://localhost/frame/codeIgniter/index.php?c=blog&m=page';
		$config['total_rows'] = 200;
		$config['per_page'] = 20; 
		
		$this->pagination->initialize($config); 
		
		echo $this->pagination->create_links();
		
		$this->load->library('calendar');
$data = array(
               3  => 'http://example.com/news/article/2006/03/',
               7  => 'http://example.com/news/article/2006/07/',
               13 => 'http://example.com/news/article/2006/13/',
               26 => 'http://example.com/news/article/2006/26/'
             );
		echo $this->calendar->generate(2014,04,$data);
		print_r($this->input->get());
		echo $this->load->helper('path');
	}
}