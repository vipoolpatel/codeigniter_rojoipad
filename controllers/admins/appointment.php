<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Appointment extends CI_Controller{

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
	
	//产品列表
	function index(){
		$this->session->set_userdata('menu','appointment');
		$row=$this->input->get('row');
		if($row==""){$row=0;}
		$page = 50;
		$data['row']=$row;
		$data['page']=$page;
	
		$is_excel = $this->input->get('is_excel');
		$keyword = $this->input->get('keyword');
		$category_id = $this->input->get('category_id');
		$brand_id = $this->input->get('brand_id');
		$con=array('orderby'=>'a.appointment_id','orderby_res'=>'DESC','row'=>$row,'page'=>$data['page']);
		if($keyword!=""){
			$con['keyword'] = $keyword;
		}
		if($category_id!=""){
			$con['category_id'] = $category_id;
		}
		if($brand_id!=""){
			$con['brand_id'] = $brand_id;
		}
		$data['appointmentlist']=$this->AppointmentModel->getappointmentlist($con);
		$data['count']=$this->AppointmentModel->getappointmentlist($con,1);
		$url = base_url().'index.php/admins/appointment/index?keyword='.$keyword.'&page='.$page;
		$data['fy'] = fy_backend($data['count'],$row,$url,$data['page'],5,2);
		
		if($is_excel != 1){
			$this->load->view('admin/appointment_list',$data);
		}else{
			$this->load->view('admin/appointment_list_excel',$data);
		}
	}
	
	//添加商品
	function toadd_appointment(){
		//跳转到列表页面
		$backurl = base64_encode(base_url().'index.php/admins/appointment/index');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/appointment/index';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/appointment/index';
		}
		$data['decodebackurl'] = $decodebackurl;
		$data['backurl'] = $backurl;
		//导航栏
		$data['url'] = '<a href="'.$decodebackurl.'">'.lang('dz_appointment_manage').'</a> &gt; '.lang('dz_appointment_add');
		
		$this->load->view('admin/appointment_add',$data);
	}
	//添加商品 ------- 处理方法
	function add_appointment(){
		//商品信息
		$appointment_name_en = $this->input->post('appointment_name_en');//产品名称
		$appointment_name_ch = $this->input->post('appointment_name_ch');//产品名称
		$appointment_SKUno = $this->input->post('appointment_SKUno');//产品编号
		$brand_id = $this->input->post('brand_id');//品牌
		if($brand_id == ''){$brand_id = 0;}
		
		$appointment_tagline_en = $this->input->post('appointment_tagline_en');//产品广告语
		$appointment_tagline_ch = $this->input->post('appointment_tagline_ch');//产品广告语
		
		$appointment_country = $this->input->post('appointment_country');//原产国
		$appointment_price_select = $this->input->post('appointment_price_select');//选中的价格
		if($appointment_price_select == ''){$appointment_price_select = 0;}
		$appointment_price_regular = $this->input->post('appointment_price_regular');//日常价格
		if($appointment_price_regular == ''){$appointment_price_regular = 0;}
		$appointment_price_promotion = $this->input->post('appointment_price_promotion');//促销价
        if ($appointment_price_promotion == '') {
            $appointment_price_promotion = 0;
        }

        $appointment_netweight = $this->input->post('appointment_netweight');//净重
        if ($appointment_netweight == '') {
            $appointment_netweight = 0;
        }
        $appointment_size = $this->input->post('appointment_size');//规格
        if ($appointment_size == '') {
            $appointment_size = 0;
        }

        $appointment_description_en = $this->input->post('appointment_description_en');//产品描述
        $appointment_description_ch = $this->input->post('appointment_description_ch');//产品描述

        $arr = array('edited_author' => $this->admin_username, 'created' => time(), 'edited' => time());
        //商品信息
        $arr['appointment_name_en'] = $appointment_name_en;
        $arr['appointment_name_ch'] = $appointment_name_ch;
        $arr['appointment_SKUno'] = $appointment_SKUno;
        $arr['brand_id'] = $brand_id;

        $arr['appointment_tagline_en'] = $appointment_tagline_en;
        $arr['appointment_tagline_ch'] = $appointment_tagline_ch;

        $arr['appointment_country'] = $appointment_country;
		$arr['appointment_price_select'] = $appointment_price_select;
		$arr['appointment_price_regular'] = $appointment_price_regular;
		$arr['appointment_price_promotion'] = $appointment_price_promotion;
		
		$arr['appointment_netweight'] = $appointment_netweight;
		$arr['appointment_size'] = $appointment_size;
		
		$arr['appointment_description_en'] = $appointment_description_en;
		$arr['appointment_description_ch'] = $appointment_description_ch;
		$appointment_id = $this->AppointmentModel->add_appointment($arr);
		
		//----修改图片路径--START-----//
		$arr_pic=array();
		$img1_gksel = $this->input->post('img1_gksel');//商品图片
		$arr_pic[]=array('num'=>1,'item'=>'appointment_pic','value'=>$img1_gksel);
		$arr_pic=autotofilepath('appointment',$arr_pic);
		if(!empty($arr_pic)){
			$this->AppointmentModel->edit_appointment($appointment_id,$arr_pic);
		}
		//----修改图片路径--END-----//
		
		//处理多个分类
		$category_id = $this->input->post('category_id');//产品分类
		$this->db->delete(DB_PRE().'appointment_category', array('appointment_id'=>$appointment_id));
		if(!empty($category_id)){
			for ($i = 0; $i < count($category_id); $i++) {
				$this->db->insert(DB_PRE().'appointment_category', array('appointment_id'=>$appointment_id, 'category_id'=>$category_id[$i]));
			}
		}
	
		//跳转到列表页面
		$backurl = $this->input->post('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/appointment/index';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/appointment/index';
		}
		echo json_encode(array('backurl'=>$decodebackurl));
	}
	
	//修改商品
	function toedit_appointment($appointment_id){
		//跳转到列表页面
		$backurl = $this->input->get('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/appointment/index';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/appointment/index';
		}
		$data['decodebackurl'] = $decodebackurl;
		$data['backurl'] = $backurl;
		//导航栏
		$data['url'] = '<a href="'.$decodebackurl.'">'.lang('dz_appointment_manage').'</a> &gt; '.lang('dz_appointment_edit');
		
		$data['appointmentinfo']=$this->AppointmentModel->getappointmentinfo($appointment_id);
		$this->load->view('admin/appointment_edit',$data);
	}
	
	
	
	
	
	
	
	
	
	//产品列表
	function appointmentsettinglist(){
		$this->session->set_userdata('menu','appointmentsetting');
		$row=$this->input->get('row');
		if($row==""){$row=0;}
		$page = 50;
		$data['row']=$row;
		$data['page']=$page;

		$this->load->view('admin/appointmentsetting_list',$data);
	}
	
	
	// ------- 处理方法
	function appointmentsetting_isclose($id){
		$isclose = $this->input->post('isclose');
		$id_splid = explode('_', $id);
		if($isclose == 1) {
            $this->db->insert(DB_PRE() . 'appointmentsetting_close', array('shijian_date' => $id_splid[0], 'shijianduan_id' => $id_splid[1], 'shijianduan_num' => $id_splid[2], 'created' => time(), 'edited' => time()));
        }else{
			$this->db->delete(DB_PRE().'appointmentsetting_close', array('shijian_date'=>$id_splid[0], 'shijianduan_id'=>$id_splid[1], 'shijianduan_num'=>$id_splid[2]));
		}
	
		//跳转到列表页面
		$backurl = $this->input->post('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/appointment/index';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/appointment/index';
		}
		echo json_encode(array('backurl'=>$decodebackurl));
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}