<?php
class JssdkModel extends CI_Model{
	function __construct(){
		parent::__construct();
		
		$this->appId = WECHAT_APPID();
		$this->appSecret = WECHAT_APPSECRET();
	}
	
	public function getSignPackage() {
		$jsapiTicket = $this->getJsApiTicket();
	
		// 注意 URL 一定要动态获取，不能 hardcode.
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	
		$timestamp = time();
		$nonceStr = $this->createNonceStr();
	
		// 这里参数的顺序要按照 key 值 ASCII 码升序排序
		$string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
	
		$signature = sha1($string);
	
		$signPackage = array(
				"appId"     => $this->appId,
				"nonceStr"  => $nonceStr,
				"timestamp" => $timestamp,
				"url"       => $url,
				"signature" => $signature,
				"rawString" => $string
		);
		return $signPackage;
	}
	
	private function createNonceStr($length = 16) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for ($i = 0; $i < $length; $i++) {
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
		}
		return $str;
	}
	
	public function getJsApiTicket() {
        // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
        $sql = "SELECT * FROM " . DB_PRE() . "wechat_ticket WHERE ticket_id = 1";
        $data = $this->db->query($sql)->row_array();
        if ($data['expire_time'] < time()) {
            $accessToken = $this->getAccessToken();
            // 如果是企业号用以下 URL 获取 ticket
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $res = json_decode(file_get_contents($url));
            $ticket = $res->ticket;
            if ($ticket) {
                $this->db->update(DB_PRE() . 'wechat_ticket', array('expire_time' => (time() + 6800), 'jsapi_ticket' => $ticket), array('ticket_id' => 1));
            }
        } else {
			$ticket = $data['jsapi_ticket'];
		}
	
		return $ticket;
	}
	
	
	public function getAccessToken()
    {
        // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
        $sql = "SELECT * FROM " . DB_PRE() . "wechat_token WHERE token_id = 1";
        $data = $this->db->query($sql)->row_array();
        if ($data['expire_time'] < time()) {
            // 如果是企业号用以下URL获取access_token
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
            $res = json_decode(file_get_contents($url));
            $access_token = $res->access_token;
            if ($access_token) {
                $this->db->update(DB_PRE() . 'wechat_token', array('expire_time' => (time() + 6800), 'access_token' => $access_token), array('token_id' => 1));
            }
        } else {
            $access_token = $data['access_token'];
		}
		return $access_token;
	}
	
	
	
}
