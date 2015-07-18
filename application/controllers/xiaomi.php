<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Xiaomi extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->library('functions');
		$this->load->library('xquery');
		$this->cookie_path = 'F:\wamp\www\cookie/';
		$this->client_id = '180100031013';
		$cd = 2;//抢购日期 为每周二
		$datejump = ($cd -date('w'))>0?$cd -date('w'):($cd -date('w'))+7;
		$this->crawltime = strtotime(date('Y-m-d',strtotime($datejump .' days')).' 11:59:59');
	}
	
	//得到商品
	public function getproducts(){
		$productArr = array();
		$productArr = array(
		'2140800001',
		'2141600006',//红米
		'2141600007',//红米1s
		'2135000522',//米3
		);
		return $productArr;
	
	}
	
	
	//得到用户名
	public function getusers(){
		$userArr = array();
		
		$userArr[] = array('user'=>'15158193804','pwd'=>'jiema251314?');
		$userArr[] = array('user'=>'13857193056','pwd'=>'jin251314');
		return $userArr;
	}

	
	public function login($user,$pwd){
		$user = urlencode($user);
		$passwd = urlencode($pwd);
		
		$loginurl = 'https://account.xiaomi.com/pass/serviceLoginAuth2';
		
		$cookiefile = $this->getcookiefile($user);
		$display = 'mobile';
		
		//app 手机客户端，电脑客户端拿 到的token不一样
		$sign = urlencode('OYJXepN4O4858+snay1GLrvQsIU=');
		$sid = urlencode('mi_eshopm');
		$qs = urlencode('%3Fcallback%3Dhttp%253A%252F%252Fm.mi.com%252Fmshopapi%252Fv1%252Fauthorize%252Fsso_callback%253Ffollowup%253Dhttp%25253A%25252F%25252Fm.mi.com%25252Findex.html%252523ac%25253Daccount%252526op%25253Dindex%2526sign%253DYjJhY2VjZWEwZDYzOTNhNmZhOTRjYmRmMDVlN2ZlZTJhZDFhOTViOA%252C%252C%26sid%3Dmi_eshopm');
		$callback = urlencode('http://m.mi.com/mshopapi/v1/authorize/sso_callback?followup=http%3A%2F%2Fm.mi.com%2Findex.html%23ac%3Daccount%26op%3Dindex&sign=YjJhY2VjZWEwZDYzOTNhNmZhOTRjYmRmMDVlN2ZlZTJhZDFhOTViOA,,');		
		
/*		
		
		$sign =urlencode('6f/KJ3piD5EyDCFo/PvvBBLTXxI=');
		$sid = urlencode('mi_eshop');
		$qs = urlencode('%3Fcallback%3Dhttp%253A%252F%252Forder.mi.com%252Flogin%252Fcallback%253Ffollowup%253Dhttp%25253A%25252F%25252Fwww.mi.com%2526sign%253DMjMyMGJhNjNmZmM2NTc0YWM4NzdkN2IzMjNlZjhmMzhhODAxMDZiNg%252C%252C%26sid%3Dmi_eshop');
		$callback = urlencode('http://order.mi.com/login/callback?followup=http%3A%2F%2Fwww.mi.com&sign=MjMyMGJhNjNmZmM2NTc0YWM4NzdkN2IzMjNlZjhmMzhhODAxMDZiNg,,');
*/
/*
 
 		$sign = 'KKkRvCpZoDC%2BgLdeyOsdMhwV0Xg%3D';
		$sid = 'passport';
		$qs = '%253Fsid%253Dpassport';
		$callback = 'https%3A%2F%2Faccount.xiaomi.com';
 */
/*
		$sid = urlencode('mi_eshopm');
		$sign = urlencode('DP6Te452jM3lGYdC9rHNyUOcNhA=');
		$qs = urlencode('%3Fcallback%3D%26sid%3Dmi_eshopm');
		$callback = urlencode('http://m.mi.com/mshopapi/v1/authorize/sso_callback');
*/				
		
		$cmdtmp = 'curl  -k -s "<loginurl>" -d "user=<user>&_json=true&pwd=<passwd>&sid=<sid>&_sign=<sign>&callback=<call>&qs=<qs>&<display>"';
		$display = $display?"display=$display":'';
		$cmd = strtr($cmdtmp, array('<loginurl>'=>$loginurl,'<user>'=>$user,'<passwd>'=>$passwd,'<sign>'=>$sign,'<sid>'=>$sid,'<qs>'=>$qs,'<call>'=>$callback,'<display>'=>$display));
		$html = $this->functions->ppopen($cmd);

		$jsonStr = str_replace('&&&START&&&','',$html);
		$jsonArr = json_decode($jsonStr,true);
		//print_r($jsonArr);exit;
		if(isset($jsonArr['userId'])){
			echo $user ."===". $jsonArr['userId'] .'==='.iconv('utf-8','gbk',$jsonArr['desc'])."\n";
			$cookiecmd = 'curl -sLk "'.$jsonArr['location'] . '" -c '. $cookiefile;
			$this->functions->ppopen($cookiecmd);
			return true;
		}else{
			echo $user ."===".iconv('utf-8','gbk',$jsonArr['desc'])."\n";
			return false;
		}
	
	}
	
	
	//批量生成cookie
	public function makecookie(){
		$userArr = $this->getusers();
		foreach($userArr as $userinfo){
			$s = $this->login($userinfo['user'], $userinfo['pwd']);
			if(!$s){
				sleep(10);
				$this->login($userinfo['user'], $userinfo['pwd']);
			}
		}
	}
	
	public function getcookiefile($user){
		$cookiefile = $this->cookie_path.md5($user).'.cookie';
		$this->functions->makeDir(dirname($cookiefile));
		return $cookiefile;
	}
	
	//抓取处理方法
	public function main(){
		$userArr = $this->getusers();
		$productsArr = $this->getproducts();
		while(true){
/*			if(!$this->checkSystemTime()){
				sleep(1);
				echo "等待中....当前时间  ".date('Y-m-d H:i:s')."\n";
				continue;
			}
*/			
			foreach($userArr as $uarr){
				$user = $uarr['user'];
				foreach($productsArr as $k => $pid){
					$state = $this->check($user,$pid);
					if($state){
						$this->addcar($user, $pid, $state['hdurl']);
					}
				}
			}
			echo "等待30秒请求下次冲击，频率太高会被封号，还是按小米的标准来干吧\n";
			sleep(29);
		
		}	
	
	}
	
	//检查服务器系统时间
	public function checkSystemTime(){
		$url = 'http://tp.hd.mi.com/gettimestamp';
		$cmd = 'curl -s "'.$url.'"';
		$html= $this->functions->ppopen($cmd);
		if(preg_match('/=(\d{10})/is',$html,$t)){
			if($t[1]>=$this->crawltime){
				return true;
			}else{
				return false;
			}
		}else{
			echo "error 获取系统时间出错\n";
		}
		
	}
	
	//检查是否请求到
	public function check($user,$pid){
		$url = "http://tp.hd.mi.com/hdget/cn?jsonpcallback=hdcontrol&product=$pid&addcart=1&m=3&_=".time();
		$cmd = 'curl -sLk "'.$url.'" -b '.$this->getcookiefile($user); 
		$html= $this->functions->ppopen($cmd);
		if(preg_match('/hdcontrol\((.*?)\)/is',$html,$m)){
			$tmpArr = json_decode($m[1],true);
			if($tmpArr['status'][$pid]['hdstart']){
				return $tmpArr['status'][$pid];
			}else{
				echo "$pid 该商品还未开始抢购\n";
			}
		}else{
			echo "error:  $html\n";
		}
	}
	
	//添加购物车
	public function addcar($user,$pid,$token=false){
		$tokenstr = $token?'&token='.$token:'';
		$url ="http://m.mi.com/mshopapi/v1/shopping/addcart";
		$post = "product_id=$pid&consumption=1&client_id={$this->client_id}$tokenstr";
		$referer = 'http://m.mi.com/index.html';
		
		$cmd = 'curl -s "'.$url.'" -d "'.$post.'" -e "'.$referer.'" -b '.$this->getcookiefile($user);
		$html= $this->functions->ppopen($cmd);
		$tmpArr = json_decode($html,true);
		if($tmpArr['result']=='ok'){
			echo "$user===$pid===添加购物车".iconv('utf-8','gbk',$tmpArr['description'])."\n";
		}else{
			echo "$user===$pid===添加购物车失败\n".iconv('utf-8','gbk',$tmpArr['description'])."\n";
			
		}
	}
	
	
	//检查购物车
	public function checkcar($user){
		$url ="http://m.mi.com/mshopapi/index.php/v1/shopping/count";
		$post = "client_id={$this->client_id}";
		$referer = 'http://m.mi.com/index.html';
		
		$cmd = 'curl -s "'.$url.'" -d "'.$post.'" -e "'.$referer.'" -b '.$this->getcookiefile($user);
		$html= $this->functions->ppopen($cmd);
		$tmpArr = json_decode($html,true);
		if($tmpArr['result']=='ok'){
			echo "$user===购物车中有".$tmpArr['data']['result']."\n";
		}		
	}
	
	//查看购物车清单
	public function carlist($user=false){
		if(!$this->input->get('user') && !$user){
			exit('请传入用户名查看购物车');
		}
		$webuser = $this->input->get('user');
		$user = $user?$user:$webuser;
		$url ="http://m.mi.com/mshopapi/index.php/v1/shopping/cartlist";
		$post = "client_id={$this->client_id}";
		$referer = 'http://m.mi.com/index.html';
		
		$cmd = 'curl -s "'.$url.'" -d "'.$post.'" -e "'.$referer.'" -b '.$this->getcookiefile($user);
		$html= $this->functions->ppopen($cmd);
		$tmpArr = json_decode($html,true);
		if($tmpArr['result']=='ok'){
			echo "$user===购物车中有".count($tmpArr['data']['items'])."款宝贝\n";
			return $tmpArr['data']['items'];
		}			
	}
	
	
	//清空购物车
	public function delcarlist($user=false){
		if(!$this->input->get('user') && !$user){
			exit('请传入用户名清空购物车');
		}
		$user = $user?$user:$this->input->get('user');
		$carlist = $this->carlist($user);
		$url ='http://m.mi.com/mshopapi/index.php/v1/shopping/delcart';
		$referer = 'http://m.mi.com/index.html';
		foreach($carlist as $item){
			$post = "product_id={$item['product_id']}&itemId={$item['itemId']}&scenario={$item['scenario']}&client_id={$this->client_id}";
			$cmd = 'curl -s "'.$url.'" -d "'.$post.'" -e "'.$referer.'" -b '.$this->getcookiefile($user);
			$html= $this->functions->ppopen($cmd);
			$tmpArr = json_decode($html,true);
			if($tmpArr['result']=='ok'){
				echo $item['product_id'].' 已被删除'."\n";
			}else{
				echo "删除出错".$html."\n";
			}
		}
	
	}
	
	
	
	/**
	 * 
	 * 网页版获取宝贝id
	 */
	public function getMgoodId($html){
		$xpathid = "//ul[@class='goods']/li/@data-sku";
		$xpathname = "//ul[@class='goods']/li/div/div/p";
		$this->xquery->load_string($html);
		$idarr = $this->xquery->Query($xpathid)->textList();
		$namearr = $this->xquery->Query($xpathname)->textList();
		//$request['url'] = 'http://m.mi.com/index.html#ac=home&op=selectsuit&reserve=1&product_id=2141800004';//下单链接
		$request['url'] = "http://tp.hd.mi.com/hdget/cn?jsonpcallback=hdcontrol&product=2141800004&addcart=1&m=3&_=1400921797474";
		print_r($idarr);
	}
}
