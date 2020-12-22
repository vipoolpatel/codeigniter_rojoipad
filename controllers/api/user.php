<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
	
	function __construct(){
		parent::__construct();
	}
	
	//用户登录的 API
	//示例: http://www.rjclothing.cn/rojoipad/index.php/api/user/login?partner_id=2382607211712490&partner_key=JM3XIsUIcAebvB7CvubIwJuIohDitBKJ&username=0001&password=16ba1508026161a9f247fdbc5d655015
	//Author: gksel
	//Date: 2015-08-20
	function login(){
		// 接受参数-- START
			$partner_id = $this->input->get('partner_id');// Partner ID
			$partner_key = $this->input->get('partner_key');// Partner KEY
			
			$version = $this->input->get ( 'version' ); // 版本
			$lang = $this->input->get('lang');// 语言
			if($lang=='ch'){
				$langtype='_ch';// 语言
			}else{
				$langtype='_en';// 语言
			}
			
			$username = $this->input->get('username');//邮箱
			$password = $this->input->get('password');//密码
		// 接受参数-- END
	
		$con = array('partner_id'=>trim($partner_id), 'partner_key'=>trim($partner_key));
		$this->ApiModel->checknormalaction($con);
		
		if ($username == '' || $password == '' || $lang == '' || $version == '') {
			//参数错误--缺少必要的参数
			$rearr=array('status'=>'103','statusmsg'=>'parameter error');
			echo json_encode($rearr);
			exit; return ;//终止
		}
		
		$isadmin = 0;
		
		$query = "SELECT * FROM ".DB_PRE()."admin_list WHERE admin_username = '".$username."' AND admin_password = '".md5($password)."' and admin_type=1";
		$res1 = $this->db->query($query)->row_array();
		if(!empty($res1)){
			$isadmin = 1;
		}
		//检查邮箱是否已经被注册
		$sql = "SELECT * FROM ".DB_PRE()."user_list WHERE user_number = '".$username."' AND password = '".md5($password)."'";
		$res = $this->db->query($sql)->row_array();
		if(!empty($res)){
			if($res['status'] == 0){
				//该用户已被下线
				$rearr=array('status'=>'105','statusmsg'=>'account has been offline');
				echo json_encode($rearr);
			}else{
				//正常返回数据(json)
				$arr = explode(" ",$res['user_brandname']);
				$acount = count($arr);
				
				$first = ucfirst($arr[0]);
				if($acount > 1){
					$last = ucfirst($arr[1]);
				}else {
					$last = '';
				}
				
				
				$f_c = substr($first,0,1);
				$l_c = substr($last,0,1);
				//$dp = $f_c.$l_c;
				
				$dp = strtoupper($res['user_brandname']);
				if($dp == ''){
					$dp = 'RJ MTM';
				}
				
				
				
				$rearr=array('status'=>'1','isadmin' => 0, 'statusmsg'=>'success','user_brandname' => strtoupper($res['user_brandname']),'dp' => $dp, 'loginuid'=>$res['uid'], 'randkey'=>$res['randkey']);
				echo json_encode($rearr);
			}
		}else{
			if($isadmin > 0){
				$dp = 'RJ MTM';
				$brand_name = 'RJ Clothing';
				$uid = $res1['admin_id'];
				$rearr=array('status'=>'1','isadmin' => 1, 'statusmsg'=>'success','user_brandname' => strtoupper($brand_name),'dp' => $dp, 'loginuid'=>$uid, 'randkey'=>$res1['key']);
				echo json_encode($rearr);
			}else{
				//用户名或密码错误
				$rearr = array('status'=>'104','statusmsg'=>'username or password error');
				echo json_encode($rearr);	
			}
		}
	}
	
	//4
	//根据 USERID 获取用户信息的 API
	//示例: http://www.rjclothing.cn/rojoipad/index.php/api/user/getuserinfo_ByUID?partner_id=2382607211712490&partner_key=JM3XIsUIcAebvB7CvubIwJuIohDitBKJ&uid=9&randkey=
	//json {"partner_id":"2382607211712490","partner_key":"JM3XIsUIcAebvB7CvubIwJuIohDitBKJ","uid":"6"}
	//Author: gksel
	//Date: 2015-08-20
	function getuserinfo_ByUID(){
		// 接受参数-- START
			$partner_id = $this->input->get('partner_id');// Partner ID
			$partner_key = $this->input->get('partner_key');// Partner KEY
			
			$version = $this->input->get ( 'version' ); // 版本
			$lang = $this->input->get('lang');// 语言
			if($lang=='ch'){
				$langtype='_ch';// 语言
			}else{
				$langtype='_en';// 语言
			}
			
			$uid = $this->input->get('uid');
			$randkey = $this->input->get('randkey');
		// 接受参数-- END
		
		$con=array('partner_id'=>$partner_id,'partner_key'=>$partner_key);
		$this->ApiModel->checknormalaction($con);
		
		if ($uid == '' || $randkey == '' || $lang == '' || $version == '') {
			//参数错误--缺少必要的参数
			$rearr=array('status'=>'103','statusmsg'=>'parameter error');
			echo json_encode($rearr);
			exit; return ;//终止
		}
		
		if(!is_numeric($uid) || $uid <= 0){
			//参数错误--$uid 必须为:正整数
			$rearr=array('status'=>'104','statusmsg'=>'parameter invalid');
			echo json_encode($rearr);
			exit; return ;//终止
		}
		
		$sql="
			SELECT 
				
			a.* 
				
			, b.user_number AS newuser_number
				
			FROM ".DB_PRE()."user_list AS a 
					
			LEFT JOIN ipadqrcode_user_list AS b ON a.qrcode_uid = b.uid
			
			WHERE a.uid='".$uid."'
		";
		$userinfo = $this->db->query($sql)->row_array();
		if(!empty($userinfo)){
			if($userinfo['status'] == 0){
				//该用户已被下线
				$rearr=array('status'=>'106','statusmsg'=>'this account has been offline');
				echo json_encode($rearr);
			}else if($userinfo['randkey'] != $randkey){
				//非法操作--用户 randkey 错误
				$rearr=array('status'=>'107','statusmsg'=>'Illegal Operation');
				echo json_encode($rearr);
			}else{
				$newre = array();
				$newre['uid'] = $userinfo['uid'];
				$newre['user_realname'] = $userinfo['user_realname'];
				$newre['user_number'] = $userinfo['newuser_number'];
				$newre['user_phone'] = $userinfo['user_phone'];
				//正常返回数据(json)
				$rearr = array('status'=>'1', 'statusmsg'=>'success', 'data'=>$newre);
				echo json_encode($rearr);
			}
		}else{
			//账号不存在
			$rearr=array('status'=>'105','statusmsg'=>'account not exists');
			echo json_encode($rearr);
		}
	}
	
	//调用示例: http://www.rjclothing.cn/rojoipad/index.php/api/user/changepassword?partner_id=2382607211712490&partner_key=JM3XIsUIcAebvB7CvubIwJuIohDitBKJ&uid=64&randkey=cQRCM2QtPf2pat0999QTDganWi3OWb7U&oldpassword=123&newpassword=123456&confirmpassword=123456
	//Author: gksel
	//Date: 2015-08-20
	function changepassword(){
		// 接受参数-- START
		$partner_id = $this->input->get('partner_id');// Partner ID
		$partner_key = $this->input->get('partner_key');// Partner KEY
		
		$version = $this->input->get ( 'version' ); // 版本
		$lang = $this->input->get('lang');// 语言
		if($lang=='ch'){
			$langtype='_ch';// 语言
		}else{
			$langtype='_en';// 语言
		}
	
		$uid = $this->input->get('uid');
		$randkey = $this->input->get('randkey');
		$oldpassword = $this->input->get('oldpassword');
		$newpassword = $this->input->get('newpassword');
		$confirmpassword = $this->input->get('confirmpassword');
		// 接受参数-- END
		
		$con=array('partner_id'=>$partner_id,'partner_key'=>$partner_key);
		$this->ApiModel->checknormalaction($con);
			
		if ($uid == '' || $randkey == '' || $oldpassword == '' || $newpassword == '' || $confirmpassword == '' || $lang == '' || $version == '') {
			//参数错误--缺少必要的参数
			$rearr=array('status'=>'103','statusmsg'=>'parameter error');
			echo json_encode($rearr);
			exit; return ;//终止
		}
		
		if(!is_numeric($uid) || $uid <= 0){
			//参数错误--$uid 必须为:正整数
			$rearr=array('status'=>'104','statusmsg'=>'parameter invalid');
			echo json_encode($rearr);
			exit; return ;//终止
		}
	
		$sql = "SELECT * FROM ".DB_PRE()."user_list WHERE uid=".$uid;
		$check_userinfo=$this->db->query($sql)->row_array();
		if(empty($check_userinfo)){
			//用户不存在!
			$rearr=array('status'=>'105','statusmsg'=>'account not exists');
			echo json_encode($rearr);
			exit; return ;//终止
		}
		
		if($check_userinfo['randkey'] != $randkey){
			//非法操作--用户 randkey 错误
			$rearr=array('status'=>'106','statusmsg'=>'Illegal Operation');
			echo json_encode($rearr);
			exit; return ;//终止
		}
		if(md5($oldpassword) != $check_userinfo['password']){
			//旧密码错误
			$rearr=array('status'=>'107','statusmsg'=>'old password error');
			echo json_encode($rearr);
            exit;
            return;//终止
        }

        if (trim($newpassword) != trim($confirmpassword)) {
            //两次密码输入不一致
            $rearr = array('status' => '108', 'statusmsg' => 'The comfirm password does not maches new password');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

        $arr = array('password' => md5($newpassword), 'edited' => time());
        $this->db->update(DB_PRE() . 'user_list', $arr, array('uid' => $uid));
        //正常返回数据(json)
        $rearr = array('status' => '1', 'statusmsg' => 'success');
        echo json_encode($rearr);
    }

	//调用示例: http://www.rjclothing.cn/rojoipad/index.php/api/user/add_client?partner_id=9153664774858319&partner_key=bBKJeYBcQRCM2QtPf2pat0999QTDganW&uid=1&randkey=oQqoHfEgrF0I9MTfgg4G1I82HDDk1Egf&user_realname=浦文龙&user_address=上海市青浦区业辉路222弄63号&user_email=742661547@qq.com&user_industry=计算机&user_wechat=1234&user_phone=13817050148&user_birthday=1990-12-13&user_nationality=中国&lang=en&version=iOS_v_1.6.5
	//Author: gksel
	//Date: 2015-08-20
	function add_client(){
		// 接受参数-- START
		$partner_id = $this->input->get('partner_id');// Partner ID
		$partner_key = $this->input->get('partner_key');// Partner KEY
		
		$version = $this->input->get ( 'version' ); // 版本
		$lang = $this->input->get('lang');// 语言
		if($lang=='ch'){
			$langtype='_ch';// 语言
		}else{
			$langtype='_en';// 语言
		}
	
		$uid = $this->input->get('uid');
		$randkey = $this->input->get('randkey');
		
		$user_realname = $this->input->get('user_realname');
		$user_address = $this->input->get('user_address');
		$user_email = $this->input->get('user_email');
		$user_industry = $this->input->get('user_industry');
		$user_wechat = $this->input->get('user_wechat');
		$user_phone = $this->input->get('user_phone');
		$user_birthday = $this->input->get('user_birthday');
		$user_nationality = $this->input->get('user_nationality');
		// 接受参数-- END
		
		$con=array('partner_id'=>$partner_id,'partner_key'=>$partner_key);
		$this->ApiModel->checknormalaction($con);
			
		if ($uid == '' || $randkey == '' || $lang == '' || $version == '') {
			//参数错误--缺少必要的参数
			$rearr=array('status'=>'103','statusmsg'=>'parameter error');
			echo json_encode($rearr);
			exit; return ;//终止
		}
		
		if(!is_numeric($uid) || $uid <= 0){
			//参数错误--$uid 必须为:正整数
			$rearr=array('status'=>'104','statusmsg'=>'parameter invalid');
			echo json_encode($rearr);
			exit; return ;//终止
		}
	
		$sql = "SELECT * FROM ".DB_PRE()."user_list WHERE uid=".$uid;
		$check_userinfo=$this->db->query($sql)->row_array();
		if(empty($check_userinfo)){
			//用户不存在!
			$rearr=array('status'=>'105','statusmsg'=>'account not exists');
			echo json_encode($rearr);
			exit; return ;//终止
        }

        if ($check_userinfo['randkey'] != $randkey) {
            //非法操作--用户 randkey 错误
            $rearr = array('status' => '106', 'statusmsg' => 'Illegal Operation');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

        $client_key = randkey(32);
        $arr = array('status' => 1, 'created' => time(), 'edited' => time());
        $arr['parent'] = $uid;
        $arr['user_realname'] = $user_realname;
        $arr['user_address'] = $user_address;
        $arr['user_email'] = $user_email;
        $arr['user_industry'] = $user_industry;
        $arr['user_wechat'] = $user_wechat;
        $arr['user_phone'] = $user_phone;
        $arr['user_birthday'] = $user_birthday;
        $arr['user_nationality'] = $user_nationality;
        $arr['randkey'] = $client_key;
        $arr['register_process'] = 1;
        $this->db->insert(DB_PRE() . 'user_list', $arr);
        $client_id = $this->db->insert_id();

        //NEW logic with last value for user_number UNIQUE Column
        $sql = "SELECT user_number FROM ipadqrcode_user_list ORDER BY user_number DESC";
        $user_number = $this->db->query($sql)->row_array();
        $numcount = $user_number['user_number'] + 1;
        if ($numcount < 10) {
            $qrcode_user_number = '0000' . $numcount;
        } else if ($numcount < 100) {
            $qrcode_user_number = '000' . $numcount;
        } else if ($numcount < 1000) {
            $qrcode_user_number = '00' . $numcount;
        } else if ($numcount < 10000) {
            $qrcode_user_number = '0' . $numcount;
        } else {
            $qrcode_user_number = $numcount;
        }

        //给该用户创建一个二维码用户----START
        try {
            $qrcodearr = array('user_realname' => $user_realname, 'user_number' => $qrcode_user_number, 'user_email' => $user_email, 'user_phone' => $user_phone, 'status' => 1, 'randkey' => randkey(32), 'created' => time(), 'edited' => time());
            $this->db->insert('ipadqrcode_user_list', $qrcodearr);
            $qrcode_uid = $this->db->insert_id();

            //		$this->db->update('ipadqrcode_user_list', array('user_number'=>$qrcode_user_number), array('uid'=>$qrcode_uid));
            $this->db->update(DB_PRE() . 'user_list', array('qrcode_uid' => $qrcode_uid), array('uid' => $client_id));
            //给该用户创建一个二维码用户----END

            //正常返回数据(json)
            $rearr = array('status' => '1', 'statusmsg' => 'success', 'client_id' => $client_id, 'client_key' => $client_key);
            echo json_encode($rearr);
        } catch (Exception $exception) {
//      Something bad happened so revert queries/records and return error
            $this->db->delete(DB_PRE() . 'user_list', array('uid' => $client_id));
            if ($qrcode_uid) {
                $this->db->delete('ipadqrcode_user_list', $qrcodearr);
            }
            $rearr = array('status' => $exception->getCode(), 'statusmsg' => $exception->getMessage());
            echo json_encode($rearr);
            exit;
            return;//终止
        }
    }
	//调用示例: http://www.rjclothing.cn/rojoipad/index.php/api/user/getclientinfo?partner_id=9153664774858319&partner_key=bBKJeYBcQRCM2QtPf2pat0999QTDganW&uid=1&randkey=oQqoHfEgrF0I9MTfgg4G1I82HDDk1Egf&client_id=2&client_key=neA2GueNESLHlkwxapwOmx5fssfXMqrZ&lang=en&version=iOS_v_1.6.5
	//Author: gksel
	//Date: 2015-08-20
	function getclientinfo(){
		// 接受参数-- START
		$partner_id = $this->input->get('partner_id');// Partner ID
		$partner_key = $this->input->get('partner_key');// Partner KEY
	
		$version = $this->input->get ( 'version' ); // 版本
		$lang = $this->input->get('lang');// 语言
		if($lang=='ch'){
			$langtype='_ch';// 语言
		}else{
			$langtype='_en';// 语言
		}
	
		$uid = $this->input->get('uid');
		$randkey = $this->input->get('randkey');
	
		$client_id = $this->input->get('client_id');
		$client_key = $this->input->get('client_key');
		// 接受参数-- END
	
		$con=array('partner_id'=>$partner_id,'partner_key'=>$partner_key);
		$this->ApiModel->checknormalaction($con);
			
		if ($uid == '' || $randkey == '' || $client_id == '' || $client_key == '' || $lang == '' || $version == '') {
			//参数错误--缺少必要的参数
			$rearr=array('status'=>'103','statusmsg'=>'parameter error');
			echo json_encode($rearr);
			exit; return ;//终止
		}
	
		if(!is_numeric($uid) || $uid <= 0 || !is_numeric($client_id) || $client_id <= 0){
			//参数错误--$uid - client_id 必须为:正整数
			$rearr=array('status'=>'104','statusmsg'=>'parameter invalid');
			echo json_encode($rearr);
			exit; return ;//终止
		}
	
		$sql = "SELECT * FROM ".DB_PRE()."user_list WHERE uid=".$uid;
		$check_userinfo=$this->db->query($sql)->row_array();
		if(empty($check_userinfo)){
			//用户不存在!
			$rearr=array('status'=>'105','statusmsg'=>'account not exists');
			echo json_encode($rearr);
			exit; return ;//终止
		}
	
		if($check_userinfo['randkey'] != $randkey){
			//非法操作--用户 randkey 错误
			$rearr=array('status'=>'106','statusmsg'=>'Illegal Operation');
			echo json_encode($rearr);
			exit; return ;//终止
		}

		$sql = "SELECT * FROM ".DB_PRE()."user_list WHERE uid=".$client_id;
		$clientinfo=$this->db->query($sql)->row_array();
		if(empty($clientinfo)){
			//client不存在!
			$rearr=array('status'=>'107','statusmsg'=>'client not exists');
			echo json_encode($rearr);
			exit; return ;//终止
		}
		if($clientinfo['randkey'] != $client_key){
			//非法操作--client randkey 错误
			$rearr=array('status'=>'108','statusmsg'=>'Illegal Operation');
			echo json_encode($rearr);
			exit; return ;//终止
		}
		
		
		$sql = "SELECT * FROM ipadqrcode_user_list WHERE uid = ".$clientinfo['qrcode_uid'];
		$ipadqrcodeuserinfo = $this->db->query($sql)->row_array();
		
	
		//正常返回数据(json)
		$newre = array();
		$newre['client_id'] = $client_id;
		if(!empty($ipadqrcodeuserinfo)){
			$newre['client_number'] = $ipadqrcodeuserinfo['user_number'];
		}else{
			$newre['client_number'] = '';
		}
		$newre['client_realname'] = $clientinfo['user_realname'];
		$newre['client_phone'] = $clientinfo['user_phone'];
		$newre['client_address'] = $clientinfo['user_address'];
		$newre['client_email'] = $clientinfo['user_email'];
		$newre['client_birthday'] = $clientinfo['user_birthday'];
		$newre['client_industry'] = $clientinfo['user_industry'];
		$newre['client_wechat'] = $clientinfo['user_wechat'];
		$newre['client_nationality'] = $clientinfo['user_nationality'];
		$newre['client_key'] = $client_key;
		$rearr = array('status'=>'1', 'statusmsg'=>'success', 'data'=>$newre);
		echo json_encode($rearr);
	}
	//调用示例: http://www.rjclothing.cn/rojoipad/index.php/api/user/getclientlist?partner_id=9153664774858319&partner_key=bBKJeYBcQRCM2QtPf2pat0999QTDganW&uid=1&randkey=oQqoHfEgrF0I9MTfgg4G1I82HDDk1Egf&lang=en&version=iOS_v_1.6.5
	//Author: gksel
	//Date: 2015-08-20
	function getclientlist(){
		// 接受参数-- START
		$partner_id = $this->input->get('partner_id');// Partner ID
		$partner_key = $this->input->get('partner_key');// Partner KEY
	
		$version = $this->input->get ( 'version' ); // 版本
		$lang = $this->input->get('lang');// 语言
		if($lang=='ch'){
			$langtype='_ch';// 语言
		}else{
			$langtype='_en';// 语言
		}
	
		$uid = $this->input->get('uid');
		$randkey = $this->input->get('randkey');
		// 接受参数-- END
	
		$con=array('partner_id'=>$partner_id,'partner_key'=>$partner_key);
		$this->ApiModel->checknormalaction($con);
			
		if ($uid == '' || $randkey == '' || $lang == '' || $version == '') {
			//参数错误--缺少必要的参数
			$rearr=array('status'=>'103','statusmsg'=>'parameter error');
			echo json_encode($rearr);
			exit; return ;//终止
		}
	
		if(!is_numeric($uid) || $uid <= 0){
			//参数错误--$uid - client_id 必须为:正整数
			$rearr=array('status'=>'104','statusmsg'=>'parameter invalid');
			echo json_encode($rearr);
			exit; return ;//终止
		}
	
		$sql = "SELECT * FROM ".DB_PRE()."user_list WHERE uid=".$uid;
		$check_userinfo=$this->db->query($sql)->row_array();
		if(empty($check_userinfo)){
			//用户不存在!
			$rearr=array('status'=>'105','statusmsg'=>'account not exists');
			echo json_encode($rearr);
			exit; return ;//终止
		}
	
		if($check_userinfo['randkey'] != $randkey){
			//非法操作--用户 randkey 错误
			$rearr=array('status'=>'106','statusmsg'=>'Illegal Operation');
			echo json_encode($rearr);
			exit; return ;//终止
		}
	
		
		$sql = "
			SELECT 
				
			a.uid AS client_id
			, a.user_realname AS client_realname
			, a.user_phone AS client_phone
			, a.user_address AS client_address
			, a.user_email AS client_email
			, a.user_birthday AS client_birthday
			, a.user_industry AS client_industry
			, a.user_wechat AS client_wechat
			, a.user_nationality AS client_nationality
			, a.randkey AS client_key
				
			FROM ".DB_PRE()."user_list AS a 
					
			WHERE a.parent = ".$uid."
					
			ORDER BY a.uid ASC
		";
		$result = $this->db->query($sql)->result_array();
	
		//正常返回数据(json)
		$newre = array();
		if(!empty($result)){
			$newre = $result;
		}else{
			$newre = array();
		}
		$rearr = array('status'=>'1', 'statusmsg'=>'success', 'data'=>$newre);
		echo json_encode($rearr);
	}
	
	
	//调用示例: http://www.rjclothing.cn/rojoipad/index.php/api/user/toresetclient?partner_id=9153664774858319&partner_key=bBKJeYBcQRCM2QtPf2pat0999QTDganW&uid=1&randkey=oQqoHfEgrF0I9MTfgg4G1I82HDDk1Egf&client_id=2&client_key=neA2GueNESLHlkwxapwOmx5fssfXMqrZ&lang=en&version=iOS_v_1.6.5
	//Author: gksel
	//Date: 2015-08-20
	function toresetclient(){
		// 接受参数-- START
		$partner_id = $this->input->get('partner_id');// Partner ID
		$partner_key = $this->input->get('partner_key');// Partner KEY
	
		$version = $this->input->get ( 'version' ); // 版本
		$lang = $this->input->get('lang');// 语言
		if($lang=='ch'){
			$langtype='_ch';// 语言
		}else{
			$langtype='_en';// 语言
		}
	
		$uid = $this->input->get('uid');
		$randkey = $this->input->get('randkey');
	
		$client_id = $this->input->get('client_id');
		$client_key = $this->input->get('client_key');
		// 接受参数-- END
	
		$con=array('partner_id'=>$partner_id,'partner_key'=>$partner_key);
		$this->ApiModel->checknormalaction($con);
			
		if ($uid == '' || $randkey == '' || $client_id == '' || $client_key == '' || $lang == '' || $version == '') {
			//参数错误--缺少必要的参数
			$rearr=array('status'=>'103','statusmsg'=>'parameter error');
			echo json_encode($rearr);
			exit; return ;//终止
		}

		if(!is_numeric($uid) || $uid <= 0 || !is_numeric($client_id) || $client_id <= 0){
			//参数错误--$uid - client_id 必须为:正整数
			$rearr=array('status'=>'104','statusmsg'=>'parameter invalid');
			echo json_encode($rearr);
			exit; return ;//终止
		}
	
		$sql = "SELECT * FROM ".DB_PRE()."user_list WHERE uid=".$uid;
		$check_userinfo=$this->db->query($sql)->row_array();
		if(empty($check_userinfo)){
			//用户不存在!
			$rearr=array('status'=>'105','statusmsg'=>'account not exists');
			echo json_encode($rearr);
			exit; return ;//终止
		}
	
		if($check_userinfo['randkey'] != $randkey){
			//非法操作--用户 randkey 错误
			$rearr=array('status'=>'106','statusmsg'=>'Illegal Operation');
			echo json_encode($rearr);
			exit; return ;//终止
		}
	
		$sql = "SELECT * FROM ".DB_PRE()."user_list WHERE uid=".$client_id;
		$clientinfo=$this->db->query($sql)->row_array();
		if(empty($clientinfo)){
			//client不存在!
			$rearr=array('status'=>'107','statusmsg'=>'client not exists');
			echo json_encode($rearr);
			exit; return ;//终止
		}
		if($clientinfo['randkey'] != $client_key){
			//非法操作--client randkey 错误
			$rearr=array('status'=>'108','statusmsg'=>'Illegal Operation');
			echo json_encode($rearr);
			exit; return ;//终止
		}
	
		//正常返回数据(json)
		$this->db->delete(DB_PRE().'user_list',array('uid'=>$client_id));
		if(!empty($clientinfo)){
			$this->db->delete('ipadqrcode_user_list',array('uid'=>$clientinfo['qrcode_uid']));
		}
		
		$rearr = array('status'=>'1', 'statusmsg'=>'success');
		echo json_encode($rearr);
	}
	
	
	
	
}
/* End of file welcome.php */
/* Location: ./application/controllers/api.php */