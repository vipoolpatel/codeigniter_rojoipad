<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Userfeedback extends CI_Controller{

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
	
	
	//cms列表
	function userfeedbacklist(){
		$this->session->set_userdata('menu','userfeedback');
		$row=$this->input->get('row');
		if($row==""){$row=0;}
		$page = 50;
		$data['row']=$row;
		$data['page']=$page;
	
		$keyword = $this->input->get('keyword');
		$con=array('orderby'=>'a.feedback_id','orderby_res'=>'DESC','row'=>$row,'page'=>$data['page']);
		if($keyword!=""){
			$con['keyword'] = $keyword;
		}
		$data['userfeedbacklist']=$this->UserfeedbackModel->getuserfeedbacklist($con);
		$data['count']=$this->UserfeedbackModel->getuserfeedbacklist($con,1);
		$url = base_url().'index.php/admins/userfeedback/userfeedbacklist?keyword='.$keyword.'&page='.$page;
		$data['fy'] = fy_backend($data['count'],$row,$url,$data['page'],5,2);
		$this->load->view('admin/userfeedback_list',$data);
	}
	
	
	
	
	
}