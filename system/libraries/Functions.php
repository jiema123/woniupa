<?php 
ini_set('max_execution_time', 3000);
class CI_Functions{

	public function checkImhUrl($url,$referer){
		$imghost = array(
				'auto.mangafiles.com',
				'c5.mangafiles.com',
				'c4.mangafiles.com',
				't5.mangafiles.com',
				't4.mangafiles.com',
		);
	
		foreach($imghost as $host){
			$newurl = "http://{$host}/{$url}";
			$session = 'ASP.NET_SessionId=w3fxgu55sirzt155maajjb55';
			$cmd = "curl -s \"$newurl\" --connect-timeout 4 -I -H \"Cookie: $session\" -e \"$referer\" ";
			$res = $this->ppopen($cmd);
			if(preg_match('/200\s*ok/is',$res)){
				return $newurl;
			}
				
		}
		return false;
			
	}
	
	/**
	 * �õ�ȫ����
	 * Enter description here ...
	 * @param unknown_type $starturl
	 * @param unknown_type $nowurl
	 */
        public function getlink($starturl, $nowurl){
                if(preg_match('/^http/', $nowurl))return $nowurl;
                $parseArr = parse_url($starturl);
                $hosturl = $parseArr['scheme'].'://'.$parseArr['host'];
                if(preg_match('/^\w/is',$nowurl)){
                        return $hosturl.dirname($parseArr['path']).'/'.$nowurl;
                }elseif (preg_match('/^\.\/\w/is', $nowurl)){
                        return $hosturl.dirname($parseArr['path']).'/'.substr($nowurl,2);
                }elseif(preg_match('/^\.\.\/\w/is', $nowurl)){
                        return $hosturl.dirname($parseArr['path']).'/'.substr($nowurl,4);
                }elseif(preg_match('/^\//',$nowurl)){
                        return $hosturl.$nowurl;
                }
                else{
                        return false;
                }

        }	
	
	/**
	 * �õ�qq��g_tk ֵ
	 * $cookie array or str
	 * @param unknown_type $cookie
	 */
	public function getGtk($cookie){
	   if(is_array($cookie) && isset($cookie['skey']))
	   {
	   		$str = $cookie['skey'];
	   }elseif(preg_match('/skey[\'"]:\s*[\'"]([^\'"]*)[\'"]/is', $cookie, $m) || preg_match('/skey=([^;]*);/is',$cookie,$m)){
	   		$str = $m[1];
	   	
	   }else{
	   		return false;
	   }
	   $hash = 5381;
	   $len = strlen($str);
	   for($i = 0;$i < $len;$i++)
	   {
	      $h = ($hash << 5) + $this->_utf8_unicode($str[$i]);
	      $hash+=$h;
	   }
	   return $hash & 0x7fffffff;
	}
	
	private function _utf8_unicode($c) {
		switch(strlen($c)) {
		    case 1:
		      return ord($c);
		    case 2:
		      $n = (ord($c[0]) & 0x3f) << 6;
		      $n += ord($c[1]) & 0x3f;
		      return $n;
		    case 3:
		      $n = (ord($c[0]) & 0x1f) << 12;
		      $n += (ord($c[1]) & 0x3f) << 6;
		      $n += ord($c[2]) & 0x3f;
		      return $n;
		    case 4:
		      $n = (ord($c[0]) & 0x0f) << 18;
		      $n += (ord($c[1]) & 0x3f) << 12;
		      $n += (ord($c[2]) & 0x3f) << 6;
		      $n += ord($c[3]) & 0x3f;
		      return $n;
		}
	}
	
	/**
	 * 
	 * ����gzip �����ַ� 
	 * @param unknown_type $data
	 */
	public function gzDecode ($data) {
        $flags = ord(substr($data, 3, 1));
        $headerlen = 10;
        $extralen = 0;
        $filenamelen = 0;
        if ($flags & 4) {
            $extralen = unpack('v' ,substr($data, 10, 2));
            $extralen = $extralen[1];
            $headerlen += 2 + $extralen;
        }
        if ($flags & 8) // Filename
            $headerlen = strpos($data, chr(0), $headerlen) + 1;
        if ($flags & 16) // Comment
            $headerlen = strpos($data, chr(0), $headerlen) + 1;
        if ($flags & 2) // CRC at end of file
            $headerlen += 2;
        $unpacked = @gzinflate(substr($data, $headerlen));
        if ($unpacked === FALSE)
            $unpacked = $data;
        return $unpacked;
    }

    
    /**
     * 
     * curl ��ʽȡhtml
     * @param unknown_type $request
     */
	public function curlHtml($request){

		if(preg_match('/\.qq\./is',$request['url']) && isset($request['cookie'])){
			$cookie = str_replace('%40','@',$this->_make_cookie($request['cookie']));		
		}elseif(isset($request['cookie'])){
			$cookie = $this->_make_cookie($request['cookie']);
		}

		$t = curl_init($request['url']);
		if(isset($request['showHeader'])){
			curl_setopt($t, CURLOPT_HEADER, 1);
		}
		curl_setopt($t, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($t, CURLOPT_TIMEOUT,60);
		if(isset($request['cookie'])){
			if(!$cookie){
				
				curl_setopt($t, CURLOPT_COOKIEFILE, $request['cookie']);
			}else{
				curl_setopt($t, CURLOPT_COOKIE, $cookie);
			}
		}
		if(preg_match('/^https/is',$request['url'])){
			curl_setopt($t, CURLOPT_SSL_VERIFYPEER, false);
        	curl_setopt($t, CURLOPT_SSL_VERIFYHOST, false);
		}
		if(isset($request['referer'])){
			curl_setopt($t, CURLOPT_REFERER, $request['referer']);
		}
		if(isset($request['agent'])){
			curl_setopt($t, CURLOPT_USERAGENT, $request['agent']);
			
		}
		if(isset($request['proxy'])){
			$ptmp = explode(":",$request['proxy']);
			curl_setopt($t, CURLOPT_PROXY, $ptmp[0]);  
            curl_setopt($t, CURLOPT_PROXYPORT, $ptmp[1]);  
			
		}

		if(isset($request['post'])){
			//post is array
			curl_setopt($t, CURLOPT_POST, 1);
			curl_setopt($t, CURLOPT_POSTFIELDS, $request['post']);
		}
		if(isset($request['header'])){
			curl_setopt($t, CURLOPT_HTTPHEADER, $request['header']);  //����ͷ��Ϣ�ĵط�
		}
		$content = curl_exec($t);
		curl_close($t);
		return $content;
		
	}
	
	private function _make_cookie($ck){
		if(is_array($ck)){
			//cookie arr
			$cookie = str_replace(array('&'),array(';'),http_build_query($ck));
		}elseif(preg_match('/\{\["/is',$ck)){
			//python cookie
			$cookie = preg_replace(array('/{["\']/is','/["\']}/is','/["\']:\s*[\'"]/is','/["\'],\s*["\']/is'),array('','','=',';'),$ck);
		}elseif(file_exists($ck)){
			//curl cookie 
			return false;
/*			$tempArr = explode("\n",$ck);
			array_shift($tempArr);
			array_shift($tempArr);
			array_shift($tempArr);
			array_shift($tempArr);
			foreach($tempArr as $val){
				if(empty($val))continue;
				$tt = explode("\t",$val);
				$cookieArr[]=trim($tt[count($tt)-2]).'='.trim($tt[count($tt)-1]); 
			}
			$cookie = implode(';',$cookieArr);
			*/
		}
		return $cookie;
	}
	
	/**
	 * 
	 * sock��ʽȡhtml
	 * @param unknown_type $request
	 */
	public function sockHtml($request){
		$port = isset($request['port'])?$request['port']:80;
		$fp = fsockopen($request['host'], $port, $errno, $errstr, 30);
		if (!$fp) {
		    return  "$errstr ($errno)<br />\n";
		} else {
		    fwrite($fp, $request['postHead']);
		    while (!feof($fp)) {
		        $respons .= fgets($fp, 1024);
		    }
		    fclose($fp);
		    
		    return $respons;
		}
	}

	

	/**
	 * 
	 * linux �����з��ؽ��
	 * @param unknown_type $cmd
	 */
	public function ppopen($cmd){
		$res = '';
		$ft = popen($cmd,'r');
		while(!feof($ft)){
			$res .= fgets($ft, 2048); //fgets �Զ����ƴ���������
		}
		pclose($ft);
		return $res;
	}
	
	public function fileToArr($filename){
		$fileArr = array();
		if(!file_exists($filename)){
			return $fileArr;	
		}
		$ft = fread($filename, 'r');
		while(!feof($ft)){
			$fileArr[] = fgets($ft,1024);
		}
		fclose($ft);
		return $fileArr;
	}
	
	public function utfToGbk($str){
		return iconv('utf-8', 'gbk', $str);
	}
	
	public function gbkToUtf8($str){
		return iconv('gbk', 'utf-8', $str);
	}
	
    public function get_onlineip() {  
	    $onlineip = '';  
	    if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {  
	        $onlineip = getenv('HTTP_CLIENT_IP');  
	    } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {  
	        $onlineip = getenv('HTTP_X_FORWARDED_FOR');  
	    } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {  
	        $onlineip = getenv('REMOTE_ADDR');  
	    } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {  
	        $onlineip = $_SERVER['REMOTE_ADDR'];  
	    }  
	    return $onlineip;  
	}
		
	public function makeDir($dir,$mode=0777){
		if(!is_dir($dir))
		{
			if(!$this->makeDir(dirname($dir))){
				return false;
			}
			if(!mkdir($dir,$mode)){
				return false;
			}
		}
		chmod($dir, 777);    //��Ŀ¼����Ȩ��
		return true;		
		
	}
}




?>
