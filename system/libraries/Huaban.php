<?php
/**
 * 用花瓣网接口 自动采集网络图
 * Enter description here ...
 * @author jiema
 *
 */


class CI_Huaban{

	public $api_auth = 'https://huaban.com/auth/';
	public $api_oauth = 'https://huaban.com/oauth/authorize';
	public $api_user = 'http://api.huaban.com/users/me';
	public $api_boards = 'http://api.huaban.com/boards/';
	public $api_pin = 'http://api.huaban.com/pins/';
	public $imghost = 'http://img.hb.aicdn.com/';
	public $cookiepath = '';
	public $userArr = array();
	public $cookieField ='tmp';
	public $agent = 'Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36';
	public $proxyObj;
	
	
	
	public function __construct(){
		$this->cookiepath = dirname(dirname(dirname(__FILE__))).'/'.$this->cookieField;
	}
	
	public function proxy(){
		if(is_object($this->proxyObj)){
			return $this->proxyObj->get_proxy();
		}else{
			return false;
		}
	}
	
	/**
	 * 
	 * 花瓣网登陆
	 */
	public function login(){

		$success='';
		$error = '';
		if(count($this->userArr)>0){

			foreach($this->userArr as $user => $pass){
				$cookie = $this->getCookiefile($user);
				if(time()-@filemtime($cookie)<7200){
					continue;	
				}else{
					@unlink($cookie);
				}
				$user = urlencode($user);
				$pass = urlencode($pass);
				$cmd = "curl {$this->proxy()} -ks \"{$this->api_auth}\" -d \"email={$user}&password={$pass}\" -c {$cookie} -A {$this->agent}";
				$res = $this->ppopen($cmd);
				if(!preg_match('|href="http://huaban.com/"|is',$res)){
					echo "$user -----login error\n";
					$error.=$user.'---';
					unset($this->userArr[$user]);
					unlink($cookie);
				}else{
					$success.=$user.'---';
					chmod($cookie,0777);
				}
			}
			return "success login:$success\n error login:$error";
		}
	}
	
	/**
	 * 
	 * 取cookie 链接
	 * @param unknown_type $user
	 */
	private function getCookiefile($user){
		
		return $this->cookiepath.'/'.md5($user).'cookie';
	}
	
	/**
	 * 
	 * 设用用户数组用来生成cookie
	 */
	public function setUser($userArr){
		
		if(is_array($userArr)){
			$this->userArr = $userArr;
		}
		return false;
		$userArr = file($this->userfile);
		foreach($userArr as $info){
			if(preg_match('/^#/is',$info))continue;
			$pinfo = explode('----',$info);
			if(trim($pinfo[0])){
				$this->userArr[trim($pinfo[0])] = trim($pinfo[1]);
			}
		}
		
	}
	
	
	/**
	 * 
	 * 传入用户名返回token 数组
	 * @param unknown_type $user
	 */
	public function getToken($user){
		$cookie = $this->getCookiefile($user);
		$cmd = "curl {$this->proxy()} -ks \"{$this->api_oauth}\" -d \"client_id=b3541fbd2abe443f87cb&response_type=token&redirect_uri=http%3A%2F%2Fhuaban.com%2Fbobobee_callback.html&action=accept&accept=yes\" -b {$cookie} -A {$this->agent}";
		$res = $this->ppopen($cmd);
		if(preg_match('/access_token=([^&]*)&token_type=([^&]*)/is',$res,$m)){
			return array('token'=>$m[1],'token_type'=>$m[2]);
		}else{
			return  "get token error maybe cookie is error\n";
		}
	}
	
	/**
	 * 
	 * 创建版块成功返回boardid
	 * @param unknown_type $bordername
	 * @param unknown_type $token
	 * @param unknown_type $tokentype
	 */
	public function setBoard($bordername,$token,$tokentype=null){
		//$bordername = urlencode(iconv('gbk','utf-8',$bordername));
		$bordername = urlencode($bordername);
		$tokentype = isset($tokentype)?$tokentype:'bearer';
		$cmd ="curl {$this->proxy()} -s \"{$this->api_boards}\" -d \"title=$bordername\" -H\"Authorization: $tokentype $token\" ";

		$res = $this->ppopen($cmd);
		$info = json_decode($res,true);
		if(isset($info['board_id'])){
			return $info['board_id'];
		}elseif(isset($info['board']['board_id'])){
			return $info['board']['board_id'];
		}else{
			echo "setBoard error\n";
			return false;
		}
	
	}
	
	/**
	 * 
	 * 根据token查询用户信息
	 * @param unknown_type $token
	 * @param unknown_type $tokentype
	 */
	public function getUserInfo($token,$tokentype=null){
		$cmd ="curl {$this->proxy()} -s \"{$this->api_user}\" -H\"Authorization: $tokentype $token\" ";
		$res = $this->ppopen($cmd);
		$info = json_decode($res,true);
		return $info;		
	}
	/**
	 * 
	 * 传入配置信息config包括
	 * token=>
	 * token_type=>
	 * title=>
	 * link=>
	 * img_url=>
	 * board_id=>
	 * @param unknown_type $config
	 */
	public function uploadImg($config){
		
		$cmd = "curl {$this->proxy()} -s \"{$this->api_pin}\" ";
		$cmd .= "-H \"Authorization: {$config['token_type']} {$config['token']}\" ";
		//$cmd .= "-d \"text=".urlencode(iconv('gbk','utf-8',$config['title']));
		$cmd .= "-d \"text=".urlencode($config['title']);
		$cmd .= "&link=".urlencode($config['link']);
		$cmd .= "&img_url=".urlencode($config['img_url']);
		$cmd .= "&board_id={$config['board_id']}";
		$cmd .= "&media_type=&video=&is_share_btn=&check=true&via=7\"";
		

		$res = $this->ppopen($cmd);
		$info = json_decode($res,true);
		if(is_array($info)){
			if(isset($info['pin'])){
				$info['pin']['file']['key'] = $this->imghost.$info['pin']['file']['key'];
				return $info['pin'];
			}else{
				return $res;
			}
		}else{
			return $res;
			echo "upload img error\n";
		}		
		
	}
	
	private function ppopen($cmd){
		$ft = popen($cmd,'r');
		$res = '';
		while(!feof($ft)){
			$res .= fgets($ft,2048);
		}
		pclose($ft);
		return $res;
	}
}


