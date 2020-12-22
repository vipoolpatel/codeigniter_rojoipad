<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	//微信APPID
	function WECHAT_APPID(){
		$CI =& get_instance();
		$WECHAT_APPID=$CI->config->item('WECHAT_APPID');
		return $WECHAT_APPID;
	}
	
	//微信APPSECRET
	function WECHAT_APPSECRET(){
		$CI =& get_instance();
		$WECHAT_APPSECRET=$CI->config->item('WECHAT_APPSECRET');
		return $WECHAT_APPSECRET;
	}
	//授权获取微信用户信息
	function getwechatuserinfo($code){
		$CI =& get_instance();
		$wechat_appid=WECHAT_APPID();
		$wechat_secret=WECHAT_APPSECRET();
	
		//echo urlencode('http://www.gogre3n.cn/index.php/weixin_oauth/index');exit;
		//获取code
// 		echo '<a href="';
// 		echo "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$wechat_appid&secret=$wechat_secret&code=".$code."&grant_type=authorization_code";
// 		echo '">hhh</a>';
// 		exit;
		//获取 code 后，请求以下链接获取 access_token：
// 		$ch = curl_init();
// 		curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$wechat_appid&secret=$wechat_secret&code=".$code."&grant_type=authorization_code");
// 		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 		curl_setopt($ch, CURLOPT_HEADER, 0);
// 		$output = curl_exec($ch);
// 		curl_close($ch);
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$wechat_appid&secret=$wechat_secret&code=".$code."&grant_type=authorization_code";
		$output = file_get_contents($url);
		
		$output=json_decode($output);
		$access_token=$output->access_token;
	
		$expires_in=$output->expires_in;
		$refresh_token=$output->refresh_token;
		$openid=$output->openid;
		$scope=$output->scope;
		
	
		// 获取第二步的 refresh_token 后，请求以下链接获取 access_token：
// 		$ch = curl_init();
// 		curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=$wechat_appid&grant_type=refresh_token&refresh_token=".$refresh_token);
// 		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 		curl_setopt($ch, CURLOPT_HEADER, 0);
// 		$output = curl_exec($ch);
// 		curl_close($ch);

		$url = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=$wechat_appid&grant_type=refresh_token&refresh_token=".$refresh_token;
		$output = file_get_contents($url);
	
		$output=json_decode($output);
		$access_token=$output->access_token;
		$expires_in=$output->expires_in;
		$refresh_token=$output->refresh_token;
		$openid=$output->openid;
		$scope=$output->scope;
		
	
		//通过 access_token 拉取用户信息(仅限 scope= snsapi_userinfo)：
// 		$ch = curl_init();
// 		curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid);
// 		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 		curl_setopt($ch, CURLOPT_HEADER, 0);
// 		$output = curl_exec($ch);
// 		// 		print_r($output);exit;
// 		curl_close($ch);
		$url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid;
		$output = file_get_contents($url);
		
		$output=json_decode($output);
		//获取后得到的用户信息
		$openid=$output->openid;
		$nickname=$output->nickname;
		$sex=$output->sex;
		$language=$output->language;
		$headimgurl=$output->headimgurl;
		$province=$output->province;
		$city=$output->city;
		$country=$output->country;
		$privilege=$output->privilege;
	
		$arr=array('openid'=>$openid,'nickname'=>$nickname,'sex'=>$sex,'language'=>$language,'headimgurl'=>$headimgurl,'province'=>$province,'city'=>$city,'country'=>$country,'privilege'=>$privilege);
		
		//echo '<meta http-equiv="Content-Type" content="textml; charset=utf-8" />';
		return $arr;
	}
	
	
	//发送模版消息 -- 审核结果通知
	function notice_auditnotice($con){
		$CI =& get_instance();
	
// 		{{first.DATA}}
// 		账号名称：{{keyword1.DATA}}
// 		审核状态：{{keyword2.DATA}}
// 		审核时间：{{keyword3.DATA}}
// 		{{remark.DATA}}
	
		$postJosnData = '
		{
           "touser":"'.$con['touser'].'",
           "template_id":"gK6CWKrcWAP_a2zUVKv-QtGE6sUrS4-KdTZvnqSBvEI",
           "url":"'.$con['url'].'",
           "data":{
				"first": {
					"value":"'.$con['first_value'].'",
					"color":"'.$con['first_color'].'"
				},
				"keyword1":{
					"value":"'.$con['keyword1_value'].'",
					"color":"'.$con['keyword1_color'].'"
				},
				"keyword2": {
					"value":"'.$con['keyword2_value'].'",
					"color":"'.$con['keyword2_color'].'"
				},
				"keyword3": {
					"value":"'.$con['keyword3_value'].'",
					"color":"'.$con['keyword3_color'].'"
				},
				"remark":{
					"value":"'.$con['remark_value'].'",
					"color":"'.$con['remark_color'].'"
				}
			}
		}';
	
		$ACC_TOKEN = $CI->JssdkModel->getAccessToken();
		$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$ACC_TOKEN;
	
		$output = do_post_request($url,$postJosnData);
		$output = json_decode($output);
		if($output->errcode==0){
			return 'yes';
		}else{
			return 'no';
		}
	}
	
	//发送模版消息 -- 活动人员分配通知
	function notice_fenpeiguwennotice($con){
		$CI =& get_instance();
	
// 		{{first.DATA}}
// 		活动名称：{{keyword1.DATA}}
// 		活动时间：{{keyword2.DATA}}
// 		{{remark.DATA}}
	
		$postJosnData = '
		{
           "touser":"'.$con['touser'].'",
           "template_id":"SamfXd6nX66iXa22BRuR4_6x87U_jIXn-pZ5rnTSdRU",
           "url":"'.$con['url'].'",
           "data":{
				"first": {
					"value":"'.$con['first_value'].'",
					"color":"'.$con['first_color'].'"
				},
				"keyword1":{
					"value":"'.$con['keyword1_value'].'",
					"color":"'.$con['keyword1_color'].'"
				},
				"keyword2": {
					"value":"'.$con['keyword2_value'].'",
					"color":"'.$con['keyword2_color'].'"
				},
				"remark":{
					"value":"'.$con['remark_value'].'",
					"color":"'.$con['remark_color'].'"
				}
			}
		}';
	
		$ACC_TOKEN = $CI->JssdkModel->getAccessToken();
		$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$ACC_TOKEN;
	
		$output = do_post_request($url,$postJosnData);
		$output = json_decode($output);
		if($output->errcode==0){
			return 'yes';
		}else{
			return 'no';
		}
	}
	
	//发送模版消息 -- 服务状态提醒
	function notice_servicestatusnotice($con){
		$CI =& get_instance();
	
// 		{{first.DATA}}
// 		服务名称：{{keyword1.DATA}}
// 		服务进度：{{keyword2.DATA}}
// 		{{remark.DATA}}
	
		$postJosnData = '
		{
           "touser":"'.$con['touser'].'",
           "template_id":"p_d9eIOe75pnYb8LlYfWB1GFemuIONaG0Fm_zAl24yE",
           "url":"'.$con['url'].'",
           "data":{
				"first": {
					"value":"'.$con['first_value'].'",
					"color":"'.$con['first_color'].'"
				},
				"keyword1":{
					"value":"'.$con['keyword1_value'].'",
					"color":"'.$con['keyword1_color'].'"
				},
				"keyword2": {
					"value":"'.$con['keyword2_value'].'",
					"color":"'.$con['keyword2_color'].'"
				},
				"remark":{
					"value":"'.$con['remark_value'].'",
					"color":"'.$con['remark_color'].'"
				}
			}
		}';
	
		$ACC_TOKEN = $CI->JssdkModel->getAccessToken();
		$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$ACC_TOKEN;
	
		$output = do_post_request($url,$postJosnData);
		$output = json_decode($output);
		if($output->errcode==0){
			return 'yes';
		}else{
			return 'no';
		}
	}
	//发送模版消息 -- 订单付款通知
	function notice_orderpaynotice($con){
		$CI =& get_instance();
	
// 		{{first.DATA}}
// 		客户账号：{{keyword1.DATA}}
// 		订单编号：{{keyword2.DATA}}
// 		付款金额：{{keyword3.DATA}}
// 		付款时间：{{keyword4.DATA}}
// 		{{remark.DATA}}
	
		$postJosnData = '
		{
           "touser":"'.$con['touser'].'",
           "template_id":"XQblM7ym7P3XF7atpmEMBAqCKJh0BZVAWeIcW_32mVA",
           "url":"'.$con['url'].'",
           "data":{
				"first": {
					"value":"'.$con['first_value'].'",
					"color":"'.$con['first_color'].'"
				},
				"keyword1":{
					"value":"'.$con['keyword1_value'].'",
					"color":"'.$con['keyword1_color'].'"
				},
				"keyword2": {
					"value":"'.$con['keyword2_value'].'",
					"color":"'.$con['keyword2_color'].'"
				},
				"keyword3": {
					"value":"'.$con['keyword3_value'].'",
					"color":"'.$con['keyword3_color'].'"
				},
				"keyword4": {
					"value":"'.$con['keyword4_value'].'",
					"color":"'.$con['keyword4_color'].'"
				},
				"remark":{
					"value":"'.$con['remark_value'].'",
					"color":"'.$con['remark_color'].'"
				}
			}
		}';
	
		$ACC_TOKEN = $CI->JssdkModel->getAccessToken();
		$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$ACC_TOKEN;
	
		$output = do_post_request($url,$postJosnData);
		$output = json_decode($output);
		if($output->errcode==0){
			return 'yes';
		}else{
			return 'no';
		}
	}
	
	//发送模版消息 -- 订单状态提醒
	function notice_orderstatusnotice($con){
		$CI =& get_instance();
	
// 		{{first.DATA}}
// 		订单号：{{keyword1.DATA}}
// 		时间：{{keyword2.DATA}}
// 		{{remark.DATA}}
	
		$postJosnData = '
		{
           "touser":"'.$con['touser'].'",
           "template_id":"jk4SYlTVYGdbw4FT5jqhPRNGPehrWrKJb-Unj8kZ7Z4",
           "url":"'.$con['url'].'",
           "data":{
				"first": {
					"value":"'.$con['first_value'].'",
					"color":"'.$con['first_color'].'"
				},
				"keyword1":{
					"value":"'.$con['keyword1_value'].'",
					"color":"'.$con['keyword1_color'].'"
				},
				"keyword2": {
					"value":"'.$con['keyword2_value'].'",
					"color":"'.$con['keyword2_color'].'"
				},
				"remark":{
					"value":"'.$con['remark_value'].'",
					"color":"'.$con['remark_color'].'"
				}
			}
		}';
	
		$ACC_TOKEN = $CI->JssdkModel->getAccessToken();
		$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$ACC_TOKEN;
	
		$output = do_post_request($url,$postJosnData);
		$output = json_decode($output);
		if($output->errcode==0){
			return 'yes';
		}else{
			return 'no';
		}
	}

	//发送模版消息 -- 新评价通知
	function notice_newpingjianotice($con){
		$CI =& get_instance();
	
// 		{{first.DATA}}
// 		评价来源：{{keyword1.DATA}}
// 		活动时间：{{keyword2.DATA}}
// 		{{remark.DATA}}
	
		$postJosnData = '
		{
           "touser":"'.$con['touser'].'",
           "template_id":"Rxaa3ZKBA2XNBOhyBwI8sUwrmUpGcoDKVf-1zmeeivQ",
           "url":"'.$con['url'].'",
           "data":{
				"first": {
					"value":"'.$con['first_value'].'",
					"color":"'.$con['first_color'].'"
				},
				"keyword1":{
					"value":"'.$con['keyword1_value'].'",
					"color":"'.$con['keyword1_color'].'"
				},
				"keyword2": {
					"value":"'.$con['keyword2_value'].'",
					"color":"'.$con['keyword2_color'].'"
				},
				"remark":{
					"value":"'.$con['remark_value'].'",
					"color":"'.$con['remark_color'].'"
				}
			}
		}';
	
		$ACC_TOKEN = $CI->JssdkModel->getAccessToken();
		$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$ACC_TOKEN;
	
		$output = do_post_request($url,$postJosnData);
		$output = json_decode($output);
		if($output->errcode==0){
			return 'yes';
		}else{
			return 'no';
		}
	}
	
	
	
	
	
	//发送模版消息 -- 订单完成通知
	function notice_orderfinishnotice($con){
		$CI =& get_instance();
	
		// 		{{first.DATA}}
		// 		订单号：{{keyword1.DATA}}
		// 		完成时间：{{keyword2.DATA}}
		// 		{{remark.DATA}}
	
		$postJosnData = '
		{
           "touser":"'.$con['touser'].'",
           "template_id":"NC1fhkTmjGvAsljapulGZbE_TXvNDMOVhaf5O98BHok",
           "url":"'.$con['url'].'",
           "data":{
				"first": {
					"value":"'.$con['first_value'].'",
					"color":"'.$con['first_color'].'"
				},
				"keyword1":{
					"value":"'.$con['keyword1_value'].'",
					"color":"'.$con['keyword1_color'].'"
				},
				"keyword2": {
					"value":"'.$con['keyword2_value'].'",
					"color":"'.$con['keyword2_color'].'"
				},
				"remark":{
					"value":"'.$con['remark_value'].'",
					"color":"'.$con['remark_color'].'"
				}
			}
		}';
	
		$ACC_TOKEN = $CI->JssdkModel->getAccessToken();
		$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$ACC_TOKEN;
	
		$output = do_post_request($url,$postJosnData);
		$output = json_decode($output);
		if($output->errcode==0){
			return 'yes';
		}else{
			return 'no';
		}
	}
	
	
	
	
	
	
	
	
	
