<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admingant extends CI_Controller {
	
	function __construct(){
		parent::__construct();
	}
	
	//Author: gksel
	//Date: 2015-08-20
	function index(){
		
		
		$partner_id = $this->input->post('partner_id');// Partner ID
		$partner_key = $this->input->post('partner_key');// Partner KEY
		
		$version = $this->input->post ( 'version' ); // 版本
		$lang = $this->input->post('lang');// 语言
		if($lang=='ch'){
			$langtype='_ch';// 语言
		}else{
			$langtype='_en';// 语言
		}
	
		$uid = $this->input->post('uid');
		$randkey = $this->input->post('randkey');
		
		$con=array('partner_id'=>$partner_id,'partner_key'=>$partner_key);
		$this->ApiModel->checknormalaction($con);
			
		if ($uid == '' || $randkey == ''  || $lang == '' || $version == '') {
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

		//$sql = "SELECT * FROM ".DB_PRE()."user_list WHERE uid=".$client_id;
		//$clientinfo=$this->db->query($sql)->row_array();
		/*if(empty($clientinfo)){
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
		}*/
		
		$data = $this->ApiModel->getproductlist(0);
		
		
		$rearr = array('status'=>'1', 'statusmsg'=>'success', 'feedback_id'=>json_encode($data));
		echo json_encode($rearr);
	}
	
}
