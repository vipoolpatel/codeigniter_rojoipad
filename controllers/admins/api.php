<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller{

	function __construct(){
		parent::__construct();
		
		$lang = $this->session->userdata('lang');
		if($lang=='ch'){
			$this->session->set_userdata('lang','ch');
			$this->langtype='_ch';
			$this->lang->load('gksel','chinese');
		}else{
			$this->session->set_userdata('lang','en');
			$this->langtype='_en';
			$this->lang->load('gksel','english');
		}
	}
	
	
	//修改商品
	function tologin(){
		$aname = $this->input->post ('aname');
		$apass = $this->input->post ('apass');
		$ispass = 1;
		$result = $this->AdminModel->checkAdmin ( $aname, md5 ( $apass ) );
		$result_username = $this->AdminModel->checkAdmin_username ( $aname );
		
		if ($result) {
			$userinfo = array ('admin_id' => $result ['admin_id'], 'admin_username' => $result ['admin_username'], 'device' => 'ipad' );
			$userjson = serialize($userinfo);
			set_cookie('admin',$userjson,time()+3600*24*30);//设置登录的Cookie
			
// 			redirect ( base_url () . 'index.php/admins/user/index?user_type=1' );
			
			$rearr=array('status'=>'1','statusmsg'=>'success');
			echo json_encode($rearr);
			exit; return ;//终止
			
		} else {
			if ($result == "" && $aname != '' && $apass != '') {
				$rearr=array('status'=>'107','statusmsg'=>'Username or password error');
				echo json_encode($rearr);
				exit; return ;//终止
			}
			
			if ($aname == '') {
				$rearr=array('status'=>'107','statusmsg'=>'Please enter your username');
				echo json_encode($rearr);
				exit; return ;//终止
			}
			
			if ($apass == '') {
				$rearr=array('status'=>'107','statusmsg'=>'Please enter your password');
				echo json_encode($rearr);
				exit; return ;//终止
			}
		}
	}
	
	
	
	
	
	
	
}