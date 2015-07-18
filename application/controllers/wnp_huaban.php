<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wnp_huaban extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library('huaban');
		$config['hostname'] = "localhost";
		$config['username'] = "root";
		$config['password'] = "";
		$config['database'] = "wnp";
		$config['dbdriver'] = "mysql";
		$config['char_set'] = "utf8";
		$this->load->database($config);
	}
	
	public function uptoken(){
		$userArr = $this->getuser();
		$this->huaban->setUser($userArr);
		$this->huaban->login();
		foreach($userArr as $user=>$pass){
			$tokenArr = $this->huaban->getToken($user);
			$sql = "update hb_user set token='{$tokenArr['token']}', tokentype='{$tokenArr['token_type']}', rtime= now() where user='{$user}'";
			$type = $this->db->query($sql);
			if($type){
				echo "update token success {$user} => token : {$tokenArr['token']}<br>\n";
			}
		}
	}
	
	
	public function getboardid($bname=false){
		$boradname = isset($bname)?urldecode($bname):false;
		if($boradname){
			$sql = "select b.boardid bid ,u.token token,u.tokentype tokentype from hb_board b, hb_user u where u.id=b.userid and b.boardname='{$boradname}'";
			$query=$this->db->query($sql);
			$data = $query->result_array();
			if(isset($data[0]['bid'])){
				return $data[0]['bid'];
			}else{
				return $this->setboardid($boradname);
			}
		}
	}
	
	private function setboardid($bname,$token,$tokentype){
		return $this->huaban->setBoard($bname,$token,$tokentype);
		
	}
	
	private function getuser(){
		$sql = "select user,pass from hb_user where isvalid=1";
		$query=$this->db->query($sql);
		$data = $query->result_array();
		$tmparr = array();
		if(count($data)<=0)return $tmparr;
		foreach($data as $row){
			$tmparr[trim($row['user'])]=trim($row['pass']);
		}
		return $tmparr;
	}
}