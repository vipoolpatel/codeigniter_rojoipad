<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Statistics extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->session->set_userdata('menu','statistics');
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
	
	function index(){
		$this->load->view('admin/statistics_list');
	}
	
	
	
}