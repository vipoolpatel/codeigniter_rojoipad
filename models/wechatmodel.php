<?php
class WechatModel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	//根据media_id获取 [图文消息] 然后直接消息推送
	function getnewspost($wechat_openid = '', $media_id = ''){
		$access_token = $this->JssdkModel->getAccessToken();
	
		$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
	
		$est=$this->WechatModel->pushnewslist($media_id);//获取 [新闻] 的消息推送
		$str='';
		if(!empty($est)){
			for($i=0;$i<count($est);$i++){
				if($i!=0){
					$str .=',';
				}
				$str .='{
					"title":"'.$est[$i]['title'].'",
					"description":"'.$est[$i]['description'].'",
					"url":"'.$est[$i]['url'].'",
					"picurl":"'.$est[$i]['picurl'].'"
				}';
			}
		}
	
		$post_data = '{
		    "touser":"'.$wechat_openid.'",
		    "msgtype":"news",
		    "news":{
		        "articles": ['.$str.']
		    }
		}';
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// post数据
		curl_setopt($ch, CURLOPT_POST, 1);
		// post的变量
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$output = curl_exec($ch);
		curl_close($ch);
		//打印获得的数据
	
		$output=json_decode($output);
		
		if (isset($output->errcode) && $output->errcode == 40001){
			$ACC_TOKEN = $this->JssdkModel->getAccessToken();
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			// post数据
			curl_setopt($ch, CURLOPT_POST, 1);
			// post的变量
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
			$output = curl_exec($ch);
			curl_close($ch);
			
			$output=json_decode($output);
		}
	
		// 		print_r($output);exit;
		// 		return $output;
		//{"errcode":0,"errmsg":"ok"}
		//$output->
		//"media_id":"Xfmam_ymjlzveDgWmMrNfpE2ZIuWao4seqF_dDes2fw"
	}
	
	
	//根据media_id获取 [图文消息] 然后下一步调用时消息推送
	function pushnewslist($media_id){
		$newsucailist = $this->WechatModel->newsucaiinfo($media_id);
	
		$contentStr = array();
		if(isset($newsucailist)){
			for($i=0;$i<count($newsucailist);$i++){
				$picurl = $newsucailist[$i]->thumb_url;
				$contentStr[] = array(
						"title" =>$newsucailist[$i]->title,
						"description" =>$newsucailist[$i]->digest,
						"picurl" =>$picurl,
						"url" =>$newsucailist[$i]->url
				);
			}
		}
		return $contentStr;
	}
	
	
	//获取所有的素材
	function getallsucailist(){
		$access_token = $this->JssdkModel->getAccessToken();
	
		$url = "https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=".$access_token;
		$post_data = '{
			    "type":"news",
			    "offset":0,
			    "count":1
			}';
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// post数据
		curl_setopt($ch, CURLOPT_POST, 1);
		// post的变量
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$output = curl_exec($ch);
		curl_close($ch);
		//打印获得的数据
	
		$output=json_decode($output);
		print_r($output);exit;
	}
	
	//根据media_id获取素材的详细
	function newsucaiinfo($media_id){
		$access_token = $this->JssdkModel->getAccessToken();
	
		$url = "https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=".$access_token;
		$post_data = '{
			"media_id":"'.$media_id.'"
		}';
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// post数据
		curl_setopt($ch, CURLOPT_POST, 1);
		// post的变量
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$output = curl_exec($ch);
		curl_close($ch);
		//打印获得的数据
	
		$output=json_decode($output);
		if (isset($output->errcode) && $output->errcode == 40001){
			$ACC_TOKEN = $this->JssdkModel->getAccessToken();
				
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			// post数据
			curl_setopt($ch, CURLOPT_POST, 1);
			// post的变量
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
			$output = curl_exec($ch);
			curl_close($ch);
				
			$output=json_decode($output);
		}
	
		$output=$output->news_item;
		
		
		
		
		
		
		return $output;
		//{"errcode":0,"errmsg":"ok"}
		//$output->
		//"media_id":"Xfmam_ymjlzveDgWmMrNfpE2ZIuWao4seqF_dDes2fw"
	}
	
	function getwechatuserinfo($open_id=0){
		$ACC_TOKEN = $this->JssdkModel->getAccessToken();
	
		$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$ACC_TOKEN."&openid=".$open_id."&lang=zh_CN";
		$post_data = '{}';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);//post数据
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);// post的变量
		$output = curl_exec($ch);
		curl_close($ch);
	
		return $output;
		// 		print_r($output);//打印获得的数据
		//{"errcode":0,"errmsg":"ok"}
	}
	//获取最新的素材--图文消息
	function lastestnewsucai(){
		$access_token = $this->JssdkModel->getAccessToken();
	
		$url = "https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=".$access_token;
		$post_data = '{
		    "type":"news",
		    "offset":0,
		    "count":1
		}';
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// post数据
		curl_setopt($ch, CURLOPT_POST, 1);
		// post的变量
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$output = curl_exec($ch);
		curl_close($ch);
		//打印获得的数据
		$output=json_decode($output);
		$output=$output->item;
		$output=$output[0];
		$output=$output->media_id;
	
		// 		print_r($output);exit;
		return $output;
		//{"errcode":0,"errmsg":"ok"}
	}
	
	//微信端聊天端口上传图片
	function wechatphoto_add($meditaid,$addarr){
		$old_pic=$meditaid;
		//处理头像--START
	
		$picname_photooriginal = date('Y_m_d_h_i_s').'_original_'.rand(0,100000000).'.jpg';
		$year=date('Y');
		$month=date('m');
	
	
		$uploaddir_photooriginal = "upload/photo/";
		if (! is_dir ( $uploaddir_photooriginal )) {
			mkdir ( $uploaddir_photooriginal, 0777 );
		}
		$uploaddir_photooriginal = "upload/photo/".$year."/";
		if (! is_dir ( $uploaddir_photooriginal )) {
			mkdir ( $uploaddir_photooriginal, 0777 );
		}
		$uploaddir_photooriginal = "upload/photo/".$year."/".$month."/";
		if (! is_dir ( $uploaddir_photooriginal )) {
			mkdir ( $uploaddir_photooriginal, 0777 );
		}
		$path_photooriginal = $uploaddir_photooriginal . $picname_photooriginal;
		if (file_exists ( $path_photooriginal )) {
			$path_photooriginal = $uploaddir_photooriginal . '(new)'.rand(1000) . $picname_photooriginal;
		}
		$res=copy($old_pic, $path_photooriginal);
		
		$addarr['pic_original']=$path_photooriginal;
		
		
		//获取该微信号的详细信息--START
		$thiswechat_id = $addarr['wechat_id'];
		$access_token = $this->JssdkModel->getAccessToken();
		
		$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$thiswechat_id."&lang=zh_CN";
		$post_data = '{}';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);//post数据
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);// post的变量
		$output = curl_exec($ch);
		curl_close($ch);
		$wechatinfo=json_decode($output);
		
		if(!empty($wechatinfo)){
			$addarr['wechat_subscribe']=$wechatinfo->subscribe;
			$addarr['wechat_nickname']=$wechatinfo->nickname;
			$addarr['wechat_avatar']=$wechatinfo->headimgurl;
			$addarr['wechat_sex']=$wechatinfo->sex;
			$addarr['wechat_country']=$wechatinfo->country;
			$addarr['wechat_province']=$wechatinfo->province;
			$addarr['wechat_city']=$wechatinfo->city;
			$addarr['wechat_language']=$wechatinfo->language;
		}
		//获取该微信号的详细信息--END
	
		$this->db->insert(DB_PRE().'wechat_picture_list',$addarr);
	}
	
	
	//绑定微信公众号
	function bindwechat($uid, $wechat_id){
		$userinfo=$this->UserModel->getuserinfo($uid);
		if(!empty($userinfo)){
			if($userinfo['wechat_id']!=''&&$userinfo['wechat_id']==$wechat_id){
				if($userinfo['wechat_subscribe']==1){
					return 'You are already bound to an account['.$userinfo['user_firstname'].' '.$userinfo['user_lastname'].']';//您已经绑定了该用户
				}else{
					$this->UserModel->edit_user($uid,array('wechat_subscribe'=>1));
					return 'ok';
				}
			}else if($userinfo['wechat_id']!=''){
				return 'bingotheraccount';//对不起该用户已经绑定了其他微信
			}else{//该用户没有绑定微信帐号
				//断该微信用户有没有绑定其他的用户
				$sql = "SELECT count(*) AS numcount FROM ".DB_PRE()."user_list WHERE uid NOT IN ('.$uid.') AND wechat_id = '".$wechat_id."'";
				$count_res = $this->db->query($sql)->row_array();
				if(!empty($count_res)){
					$count = $count_res['numcount'];
				}else{
					$count = 0;
				}
				if($count>0){
					return 'hasbingotheraccount';//您的微信号已经绑定了其他的用户了，不可以再绑定
				}else{
					$arr=array('wechat_id'=>$wechat_id);
					//获取该微信号的详细信息--START
					$wechatinfo=$this->WechatModel->getwechatuserinfo($wechat_id);
					$wechatinfo = json_decode($wechatinfo);
					if(!empty($wechatinfo)){
						$arr['wechat_subscribe']=$wechatinfo->subscribe;
						$arr['wechat_nickname']=$wechatinfo->nickname;
						$arr['wechat_avatar']=$wechatinfo->headimgurl;
// 						$arr['wechat_sex']=$wechatinfo->sex;
						$arr['wechat_country']=$wechatinfo->country;
						$arr['wechat_province']=$wechatinfo->province;
						$arr['wechat_city']=$wechatinfo->city;
// 						$arr['wechat_language']=$wechatinfo->language;
					}
					//获取该微信号的详细信息--END
					$this->UserModel->edit_user($uid,$arr);
	
					return 'ok';
	
				}
	
			}
	
		}
	
	}
	//用户取消关注微信公众号
	function unsubscribewithwechat($wechat_id){
		$con = array ('wechat_subscribe' => 0 );
		$this->UserModel->edit_user_bywechatid ($wechat_id, $con);
	}
	
	function subscribewithwechat($wechat_id){
		$con = array ('wechat_subscribe' => 1 );
		$this->UserModel->edit_user_bywechatid ($wechat_id, $con);
	}
	
	//绑定微信公众号
	function loginwithwechat($loginwechat_id, $wechat_id){
		$sql = "SELECT * FROM " . DB_PRE () . "user_loginwechat WHERE loginwechat_id = " . $loginwechat_id;
		$loginwechat_info = $this->db->query ( $sql )->row_array ();
		if(!empty($loginwechat_info)){
			
			
			$arr = array ('wechat_id' => $wechat_id );
			//获取该微信号的详细信息--START
			$wechatinfo=$this->WechatModel->getwechatfollowedinfo($wechat_id);
			$wechatinfo=json_decode($wechatinfo);
			if(!empty($wechatinfo)){
				$arr['wechat_subscribe']=$wechatinfo->subscribe;
				$arr['wechat_nickname']=userTextEncode($wechatinfo->nickname);
				$arr['wechat_avatar']=$wechatinfo->headimgurl;
				$arr['wechat_sex'] = $wechatinfo->sex;
				$arr['wechat_country']=$wechatinfo->country;
				$arr['wechat_province']=$wechatinfo->province;
				$arr['wechat_city']=$wechatinfo->city;
				$arr['wechat_language']=$wechatinfo->language;
			}
			//获取该微信号的详细信息--END
			
			$this->db->update ( DB_PRE () . 'user_loginwechat', $arr, array ('loginwechat_id' => $loginwechat_id ) );
		}
	}
	
	
	function getwechatfollowedinfo($open_id=0){
		$ACC_TOKEN = $this->JssdkModel->getAccessToken ();
	
		$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$ACC_TOKEN."&openid=".$open_id."&lang=zh_CN";
		$post_data = '{}';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);//post数据
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);// post的变量
		$output = curl_exec($ch);
		curl_close($ch);
	
		return $output;
		// 		print_r($output);//打印获得的数据
		//{"errcode":0,"errmsg":"ok"}
	}
	
	//发送文字
	function sendtext($con){
		$ACC_TOKEN = $this->JssdkModel->getAccessToken ();
	
		$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$ACC_TOKEN;
		$post_data = '{
        "touser":"'.$con['touser'].'",
        "msgtype":"text",
        "text":
        {
             "content":"'.$con['content'].'"
        }
    	}';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);//post数据
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);// post的变量
		$output = curl_exec($ch);
		curl_close($ch);
		//{"errcode":0,"errmsg":"ok"}
	}
	//发送图片
	function sendpicture($con){
		$ACC_TOKEN = $this->JssdkModel->getAccessToken ();
	
		$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$ACC_TOKEN;
		$post_data = '{
		    "touser":"'.$con['touser'].'",
		    "msgtype":"image",
		    "image":
		    {
		      "media_id":"'.$con['media_id'].'"
		    }
		}';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);// post数据
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);// post的变量
		$output = curl_exec($ch);
		curl_close($ch);
		//print_r($output);//打印获得的数据
		//{"errcode":0,"errmsg":"ok"}
	}
	
	//查询自动回复列表
	function getwechatautoreplylist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['other_con'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ".$con['other_con'];}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
	
		if($iscount==0){
			$sql="SELECT a.* FROM ".DB_PRE()."wechat_auto_reply a $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM ".DB_PRE()."wechat_auto_reply a $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	
	//自动回复详细
	function getautoreplyinfo($autoreply_id){
		$sql="select * from ".DB_PRE()."wechat_auto_reply where autoreply_id = ".$autoreply_id;
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	//修改自动回复
	function edit_autoreply($autoreply_id,$arr){
		$this->db->update(DB_PRE().'wechat_auto_reply',$arr,array('autoreply_id'=>$autoreply_id));
	}
	//添加自动回复
	function add_autoreply($arr){
		$this->db->insert(DB_PRE().'wechat_auto_reply',$arr);
		return $this->db->insert_id();
	}
	//删除自动回复
	function del_autoreply($autoreply_id){
		$this->db->delete(DB_PRE().'wechat_auto_reply', array('autoreply_id'=>$autoreply_id));
	}




	//查询微信菜单列表
	function getwechatmenulist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['other_con'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ".$con['other_con'];}
		if(isset($con['parent'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " a.parent = ".$con['parent'];}
		if(isset($con['status'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " a.status = ".$con['status'];}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
	
		if($iscount==0){
			$sql="SELECT a.* FROM ".DB_PRE()."wechat_menu_list a $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM ".DB_PRE()."wechat_menu_list a $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	
	//微信菜单详细
	function getwechatmenuinfo($wechatmenu_id){
		$sql="select * from ".DB_PRE()."wechat_menu_list where wechatmenu_id = ".$wechatmenu_id;
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	//修改微信菜单
	function edit_wechatmenu($wechatmenu_id,$arr){
		$this->db->update(DB_PRE().'wechat_menu_list',$arr,array('wechatmenu_id'=>$wechatmenu_id));
	}
	//添加微信菜单
	function add_wechatmenu($arr){
		$this->db->insert(DB_PRE().'wechat_menu_list',$arr);
		return $this->db->insert_id();
	}
	//删除微信菜单
	function del_wechatmenu($wechatmenu_id){
		$this->db->delete(DB_PRE().'wechat_menu_list', array('wechatmenu_id'=>$wechatmenu_id));
	}
	
}
