<?php
class Bama extends CI_Controller{
	public function index(){
		$this->load->library('functions');
		$post['url'] = 'http://activity.app.bama555.com/gs/climb/index/%2BxiSxiM8zzlgsjO9%2FxjDvRs1COzza5F92QBGVw%2Fex5iSJMoZ6vkDqWEGidW8DjzF%2Fi0vSyUcl0p3NcMMwgrD1Q%3D%3D';
		$post['agent'] = 'MicroMessenger';
		$post['referer'] = 'http://activity.app.bama555.com/gs/climb/mountain/%2BxiSxiM8zzlgsjO9%2FxjDvRs1COzza5F92QBGVw%2Fex5iSJMoZ6vkDqWEGidW8DjzF%2Fi0vSyUcl0p3NcMMwgrD1Q%3D%3D';
		$name = iconv('gbk','utf-8','ÖúÁ¦Ö£Çï·ÒµÇÉ½');
		$pname = iconv('gbk','utf-8','·½½Ü·å');
		$post['post'] = array(
			'name'=>$pname,
			'tel'=>'15158193804',
			'sex'=>1,
			'submit'=>$name,
		);
		print_r($post);
		echo $this->functions->curlHtml($post);
		echo "<pre>";
		echo $html;
		echo "<pre>";
		exit;
		preg_match('/location\.href=\'(.*?)\'/is',$html,$u);
		$newp['url'] = $u[1];
		$newp['agent'] = 'MicroMessenger';
		$html = $this->functions->curlHtml($newp);
		preg_match('/location\.href=\'(.*?)\'/is',$html,$u);
		echo $html;
		$newp['url'] = $u[1];
		$newp['agent'] = 'MicroMessenger';
		$html = $this->functions->curlHtml($newp);
		echo $html;
	}
	

}