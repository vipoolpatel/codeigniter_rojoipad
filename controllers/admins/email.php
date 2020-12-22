<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email extends CI_Controller{

	function __construct(){
		parent::__construct();
		$ipadapplogin = $this->input->get('ipadapplogin');
		if($ipadapplogin == 1){
			$userinfo = array ('admin_id' => 1, 'admin_username' => 'admin', 'device' => 'ipad' );
			$userjson = serialize($userinfo);
			set_cookie('admin',$userjson,time()+3600*24*30);//设置登录的Cookie
		}
		if(isset($_COOKIE['admin'])){
			$admin = unserialize($_COOKIE['admin']);
			if(isset($admin ['device'])){
				$this->admin_id = $admin ['admin_id'];
				$this->admin_username = $admin ['admin_username'];
				$this->device = $admin ['device'];
			}else{
				redirect(base_url().'index.php/admin');
			}
		}else{
			redirect(base_url().'index.php/admin');
		}
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
	//邮件列表
	function index(){
		$this->session->set_userdata('menu','emaillist');
		
		$con=array('parent'=>0, 'orderby'=>'a.email_id', 'orderby_res'=>'ASC');
		$data['emaillist']=$this->EmailModel->getemaillist($con);
		$this->load->view('admin/setting_email_list',$data);
	}
	
	//修改商品分类
	function toedit_email($email_id){
		//跳转到列表页面
		$backurl = $this->input->get('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/email/index';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/email/index';
		}
		$data['decodebackurl'] = $decodebackurl;
		$data['backurl'] = $backurl;
		//导航栏
		$data['url'] = '<a href="'.$decodebackurl.'">Manage Auto Response</a> &gt; Edit Email';
	
		$data['emailinfo']=$this->EmailModel->getemailinfo($email_id);
		$this->load->view('admin/setting_email_edit',$data);
	}
	//修改商品分类 ------- 处理方法
	function edit_email($email_id){
		//邮件信息
		$email_from = $this->input->post('email_from');
        $email_sender = $this->input->post('email_sender');
        $email_replyto = $this->input->post('email_replyto');
        $email_to = $this->input->post('email_to');
        $email_cc = $this->input->post('email_cc');
        $email_bcc = $this->input->post('email_bcc');
        $email_subject_en = $this->input->post('email_subject_en');
        $email_subject_ch = $this->input->post('email_subject_ch');
        $email_content_en = $this->input->post('email_content_en');
        $email_content_ch = $this->input->post('email_content_ch');

        $arr = array('edited_author' => $this->admin_username, 'edited' => time());
        //邮件信息
        $arr['email_from'] = $email_from;
        $arr['email_sender'] = $email_sender;
        $arr['email_replyto'] = $email_replyto;
        $arr['email_to'] = $email_to;
        $arr['email_cc'] = $email_cc;
        $arr['email_bcc'] = $email_bcc;
        $arr['email_subject_en'] = $email_subject_en;
        $arr['email_subject_ch'] = $email_subject_ch;
        $arr['email_content_en'] = $email_content_en;
		$arr['email_content_ch'] = $email_content_ch;
		$this->EmailModel->edit_email($email_id, $arr);
	
		//跳转到列表页面
		$backurl = $this->input->post('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/email/index';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/email/index';
		}
		echo json_encode(array('backurl'=>$decodebackurl));
	}
	
	//修改发邮件设置
	function tosetting_email(){
		$this->load->view('admin/setting_email_setting');
	}
	//修改发邮件设置 ------- 处理方法
	function setting_email()
    {
        $email_type = $this->input->post('email_type');
        $smtp_server = $this->input->post('smtp_server');
        $smtp_serverport = $this->input->post('smtp_serverport');
        $smtp_usermail = $this->input->post('smtp_usermail');
        $smtp_user = $this->input->post('smtp_user');
        $smtp_pass = $this->input->post('smtp_pass');

        $arr = array('edited_author' => $this->admin_username, 'edited' => time());

        $this->db->update(DB_PRE() . 'email_setting', array('value' => $email_type), array('name' => 'email_type'));
        $this->db->update(DB_PRE() . 'email_setting', array('value' => $smtp_server), array('name' => 'smtp_server'));
        $this->db->update(DB_PRE() . 'email_setting', array('value' => $smtp_serverport), array('name' => 'smtp_serverport'));
        $this->db->update(DB_PRE() . 'email_setting', array('value' => $smtp_usermail), array('name' => 'smtp_usermail'));
        $this->db->update(DB_PRE() . 'email_setting', array('value' => $smtp_user), array('name' => 'smtp_user'));
        $this->db->update(DB_PRE() . 'email_setting', array('value' => $smtp_pass), array('name' => 'smtp_pass'));

    }
	
	
	
	
	
	
	
	
}