<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller{

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
						
	//产品分类列表
	function categorylist(){
		$this->session->set_userdata('menu','productcategory');
		$row=$this->input->get('row');
		if($row==""){$row=0;}
		$page = 50;
		$data['row']=$row;
		$data['page']=$page;
		
		$keyword = $this->input->get('keyword');
		$con=array('parent'=>0, 'orderby'=>'a.sort', 'orderby_res'=>'ASC', 'row'=>$row, 'page'=>$data['page']);
		if($keyword!=""){
			$con['keyword'] = $keyword;
		}
		$data['categorylist']=$this->ProductModel->getproductcategorylist($con);
		$data['count']=$this->ProductModel->getproductcategorylist($con,1);
		$url = base_url().'index.php/admins/product/categorylist?keyword='.$keyword.'&page='.$page;
		$data['fy'] = fy_backend($data['count'],$row,$url,$data['page'],5,2);
		$this->load->view('admin/product_category_list',$data);
	}
	//产品分类列表 -- 排序功能
	function editcategory_sort(){
		$idarr=$this->input->post('idarr');
		$newsrot=$this->input->post('newsrot');
		if(!empty($idarr)){
			for($i=0;$i<count($idarr);$i++){
				$arr = array('sort'=>$newsrot[$i]);
				$this->ProductModel->edit_productcategory($idarr[$i], $arr);
			}
		}
	}
	//添加商品分类
	function toadd_product_category(){
		//跳转到列表页面
		$backurl = base64_encode(base_url().'index.php/admins/product/categorylist');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/categorylist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/categorylist';
		}
		$data['decodebackurl'] = $decodebackurl;
		$data['backurl'] = $backurl;
		//导航栏
		$data['url'] = '<a href="'.$decodebackurl.'">'.lang('dz_product_category_manage').'</a> &gt; '.lang('dz_product_category_add');

		$this->load->view('admin/product_category_add',$data);
	}
	//添加商品分类 ------- 处理方法
	function add_product_category(){
		//商品信息
		$category_name_en = $this->input->post('category_name_en');//产品分类名称
		$category_name_ch = $this->input->post('category_name_ch');//产品分类名称
	
		$arr = array('edited_author'=>$this->admin_username, 'created'=>time(), 'edited'=>time());
		//商品信息
		$arr['category_name_en'] = $category_name_en;
		$arr['category_name_ch'] = $category_name_ch;
		$category_id = $this->ProductModel->add_productcategory($arr);
	
	
		//跳转到列表页面
		$backurl = $this->input->post('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/categorylist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/categorylist';
		}
		echo json_encode(array('backurl'=>$decodebackurl));
	}
	//修改商品分类
	function toedit_productcategory($category_id){
		//跳转到列表页面
		$backurl = $this->input->get('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/categorylist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/categorylist';
		}
		$data['decodebackurl'] = $decodebackurl;
		$data['backurl'] = $backurl;
		//导航栏
		$data['url'] = '<a href="'.$decodebackurl.'">'.lang('dz_product_category_manage').'</a> &gt; '.lang('dz_product_category_edit');
	
		$data['categoryinfo']=$this->ProductModel->getproductcategoryinfo($category_id);
		$this->load->view('admin/product_category_edit',$data);
	}
	//修改商品分类 ------- 处理方法
	function edit_productcategory($category_id){
		//商品信息
		$category_name_en = $this->input->post('category_name_en');//产品分类名称
		$category_name_ch = $this->input->post('category_name_ch');//产品分类名称
	
		$arr = array('edited_author'=>$this->admin_username, 'edited'=>time());
		//商品信息
		$arr['category_name_en'] = $category_name_en;
		$arr['category_name_ch'] = $category_name_ch;
		$this->ProductModel->edit_productcategory($category_id, $arr);
	
		//跳转到列表页面
		$backurl = $this->input->post('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/categorylist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/categorylist';
		}
		echo json_encode(array('backurl'=>$decodebackurl));
	}
	//删除商品分类
	function del_productcategory($category_id){
		$this->ProductModel->del_productcategory($category_id);
	}










	//产品子分类列表
	function subcategorylist($parent){
		//跳转到列表页面
		$backurl = $this->input->get('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/categorylist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/categorylist';
		}
		$data['decodebackurl'] = $decodebackurl;
		$data['backurl'] = $backurl;
		//导航栏
		$data['url'] = '<a href="'.$decodebackurl.'">'.lang('dz_product_category_manage').'</a> &gt; '.lang('dz_product_subcategory_manage');
		
		
		
		
		$row=$this->input->get('row');
		if($row==""){$row=0;}
		$page = 50;
		$data['row']=$row;
		$data['page']=$page;
		$data['parent']=$parent;
	
		$keyword = $this->input->get('keyword');
		$con=array('parent'=>$parent, 'orderby'=>'a.sort', 'orderby_res'=>'ASC', 'row'=>$row, 'page'=>$data['page']);
		if($keyword!=""){
			$con['keyword'] = $keyword;
		}
		$data['subcategorylist']=$this->ProductModel->getproductcategorylist($con);
		$data['count']=$this->ProductModel->getproductcategorylist($con,1);
		$url = base_url().'index.php/admins/product/subcategorylist/'.$parent.'?keyword='.$keyword.'&page='.$page;
		$data['fy'] = fy_backend($data['count'],$row,$url,$data['page'],5,2);
		$this->load->view('admin/product_category_sub_list',$data);
	}
	//添加商品子分类
	function toadd_product_subcategory($parent){
		//跳转到列表页面
		$backurl = $this->input->get('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/categorylist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/categorylist';
		}
		$data['decodebackurl'] = $decodebackurl;
		$data['backurl'] = $backurl;
		
		//跳转到列表页面
		$subbackurl = $this->input->get('subbackurl');
		if($subbackurl!=""){
			$subbackurl=str_replace('slash_tag','/',$subbackurl);
			if(base64_decode($subbackurl)!=""){
				$decodesubbackurl = base64_decode($subbackurl);
			}else{
				$decodesubbackurl = base_url().'index.php/admins/product/subcategorylist/'.$parent.'?backurl='.$backurl;
			}
		}else{
			$decodesubbackurl = base_url().'index.php/admins/product/subcategorylist/'.$parent.'?backurl='.$backurl;
		}
		$data['decodesubbackurl'] = $decodesubbackurl;
		$data['subbackurl'] = $subbackurl;
		//导航栏
		$data['url'] = '<a href="'.$decodebackurl.'">'.lang('dz_product_category_manage').'</a> &gt; <a href="'.$decodesubbackurl.'">'.lang('dz_product_subcategory_manage').'</a> &gt; '.lang('dz_product_subcategory_add').'';
		$data['parent'] = $parent;
		$this->load->view('admin/product_category_sub_add',$data);
	}
	//添加商品子分类 ------- 处理方法
	function add_product_subcategory($parent){
        //商品信息
        $category_name_en = $this->input->post('category_name_en');//产品分类名称
        $category_name_ch = $this->input->post('category_name_ch');//产品分类名称
        $category_status = $this->input->post('status');//产品分类名称

        $arr = array('edited_author' => $this->admin_username, 'parent' => $parent, 'status' => 1, 'created' => time(), 'edited' => time());
        //商品信息
        $arr['category_name_en'] = $category_name_en;
        $arr['category_name_ch'] = $category_name_ch;
        $arr['status'] = $category_status;
        $subcategory_id = $this->ProductModel->add_productcategory($arr);


        //跳转到列表页面
        $backurl = $this->input->post('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
                $decodebackurl = base64_decode($backurl);
            } else {
				$decodebackurl = base_url().'index.php/admins/product/categorylist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/categorylist';
		}
		//跳转到列表页面
		$subbackurl = $this->input->post('subbackurl');
		if($subbackurl!=""){
			$subbackurl=str_replace('slash_tag','/',$subbackurl);
			if(base64_decode($subbackurl)!=""){
				$decodesubbackurl = base64_decode($subbackurl);
			}else{
				$decodesubbackurl = base_url().'index.php/admins/product/subcategorylist/'.$parent.'?backurl='.$backurl;
			}
		}else{
			$decodesubbackurl = base_url().'index.php/admins/product/subcategorylist/'.$parent.'?backurl='.$backurl;
		}
		echo json_encode(array('backurl'=>$decodebackurl, 'subbackurl'=>$decodesubbackurl));
	}
	//修改商品子分类
	function toedit_productsubcategory($parent, $category_id){
		//跳转到列表页面
		$backurl = $this->input->get('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/categorylist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/categorylist';
		}
		$data['decodebackurl'] = $decodebackurl;
		$data['backurl'] = $backurl;
		
		$data['parent'] = $parent;
		
		//跳转到列表页面
		$subbackurl = $this->input->get('subbackurl');
		if($subbackurl!=""){
			$subbackurl=str_replace('slash_tag','/',$subbackurl);
			if(base64_decode($subbackurl)!=""){
				$decodesubbackurl = base64_decode($subbackurl);
			}else{
				$decodesubbackurl = base_url().'index.php/admins/product/subcategorylist/'.$parent.'?backurl='.$backurl;
			}
		}else{
			$decodesubbackurl = base_url().'index.php/admins/product/subcategorylist/'.$parent.'?backurl='.$backurl;
		}
		$data['decodesubbackurl'] = $decodesubbackurl;
		$data['subbackurl'] = $subbackurl;
		//导航栏
		$data['url'] = '<a href="'.$decodebackurl.'">'.lang('dz_product_category_manage').'</a> &gt; <a href="'.$decodesubbackurl.'">'.lang('dz_product_subcategory_manage').'</a> &gt; '.lang('dz_product_subcategory_edit').'';
	
		$data['categoryinfo']=$this->ProductModel->getproductcategoryinfo($category_id);
//		print_r($data['categoryinfo']);exit;
		$this->load->view('admin/product_category_sub_edit',$data);
	}
	//修改商品子分类 ------- 处理方法
	function edit_productsubcategory($parent, $category_id)
    {
        //商品信息
        $category_name_en = $this->input->post('category_name_en');//产品分类名称
        $category_name_ch = $this->input->post('category_name_ch');//产品分类名称
        $category_status = $this->input->post('status');//产品分类名称

        $arr = array('edited_author' => $this->admin_username, 'edited' => time());
        //商品信息
        $arr['category_name_en'] = $category_name_en;
        $arr['category_name_ch'] = $category_name_ch;
        $arr['status'] = $category_status;
        $this->ProductModel->edit_productcategory($category_id, $arr);

        //跳转到列表页面
        $backurl = $this->input->post('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
                $decodebackurl = base64_decode($backurl);
            } else {
                $decodebackurl = base_url() . 'index.php/admins/product/categorylist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/categorylist';
		}
		//跳转到列表页面
		$subbackurl = $this->input->post('subbackurl');
		if($subbackurl!=""){
			$subbackurl=str_replace('slash_tag','/',$subbackurl);
			if(base64_decode($subbackurl)!=""){
				$decodesubbackurl = base64_decode($subbackurl);
			}else{
				$decodesubbackurl = base_url().'index.php/admins/product/subcategorylist/'.$parent.'?backurl='.$backurl;
			}
		}else{
			$decodesubbackurl = base_url().'index.php/admins/product/subcategorylist/'.$parent.'?backurl='.$backurl;
		}
		echo json_encode(array('backurl'=>$decodebackurl, 'subbackurl'=>$decodesubbackurl));
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//产品列表
	function index(){
		$this->session->set_userdata('menu','product');
		$row=$this->input->get('row');
		if($row==""){$row=0;}
		$page = 500;
		$data['row']=$row;
		$data['page']=$page;
	
		$is_excel = $this->input->get('is_excel');
		$keyword = $this->input->get('keyword');
		$category_id = $this->input->get('category_id');
		$brand_id = $this->input->get('brand_id');
		$con=array('orderby'=>'d.step1_id DESC, a.product_id','orderby_res'=>'ASC');
		if($keyword!=""){
			$con['keyword'] = $keyword;
		}
		if($category_id!=""){
			$con['category_id'] = $category_id;
		}
		if($brand_id!=""){
			$con['brand_id'] = $brand_id;
		}
		if($is_excel == 1){
			
		}else if($is_excel == 2){
			$con['other_con'] = 'd.step1_id IS NOT NULL';
		}else{
			$con['row'] = $row;
			$con['page'] = $page;
		}

		
		
		$data['productlist']=$this->ProductModel->getproductlist($con);
		$data['count']=$this->ProductModel->getproductlist($con,1);
		$url = base_url().'index.php/admins/product/index?keyword='.$keyword.'&page='.$page;
		$data['fy'] = fy_backend($data['count'],$row,$url,$data['page'],5,2);
		
		if($is_excel == 1){
			$this->load->view('admin/product_list_excel',$data);
		}else if($is_excel == 2){
			$this->load->view('admin/product_list_excel2',$data);
		}else{
			$this->load->view('admin/product_list',$data);
		}
	}
	//产品列表手机版
	function product_list_phone(){
		$this->session->set_userdata('menu','product');
		$row=$this->input->get('row');
		if($row==""){$row=0;}
		$page = 500;
		$data['row']=$row;
		$data['page']=$page;
	
		$is_excel = $this->input->get('is_excel');
		$keyword = $this->input->get('keyword');
		$category_id = $this->input->get('category_id');
		$brand_id = $this->input->get('brand_id');
		$con=array('orderby'=>'a.product_id','orderby_res'=>'ASC');
		if($keyword!=""){
			$con['keyword'] = $keyword;
		}
		if($category_id!=""){
			$con['category_id'] = $category_id;
		}
		if($brand_id!=""){
			$con['brand_id'] = $brand_id;
		}
		if($is_excel == 1){
				
		}else if($is_excel == 2){
			$con['other_con'] = 'd.step1_id IS NOT NULL';
		}else{
			$con['row'] = $row;
			$con['page'] = $page;
		}
	
	
	
		$data['productlist']=$this->ProductModel->getproductlist($con);
		$data['count']=$this->ProductModel->getproductlist($con,1);
		$url = base_url().'index.php/admins/product/product_list_phone?keyword='.$keyword.'&page='.$page;
		$data['fy'] = fy_backend($data['count'],$row,$url,$data['page'],5,2);
	
		if($is_excel == 1){
			$this->load->view('admin/product_list_excel',$data);
		}else if($is_excel == 2){
			$this->load->view('admin/product_list_excel2',$data);
		}else{
			$this->load->view('admin/product_list_phone',$data);
		}
	}
	//产品列表
	function gant(){
		$this->session->set_userdata('menu','gant');
		$row=$this->input->get('row');
		if($row==""){$row=0;}
		$page = 50;
		$data['row']=$row;
		$data['page']=$page;
	
		$keyword = $this->input->get('keyword');
		$category_id = $this->input->get('category_id');
		$brand_id = $this->input->get('brand_id');
		$con=array('orderby'=>'a.product_id','orderby_res'=>'ASC');
		if($keyword!=""){
			$con['keyword'] = $keyword;
		}
		if($category_id!=""){
			$con['category_id'] = $category_id;
		}
		if($brand_id!=""){
			$con['brand_id'] = $brand_id;
		}
		$con['other_con'] = 'd.step1_id IS NOT NULL';
		$con['row'] = 0;
		$con['page'] = 2000;
	
		$data['productlist']=$this->ProductModel->getproductlist($con);
		$data['count']=$this->ProductModel->getproductlist($con,1);
		$url = base_url().'index.php/admins/product/index?keyword='.$keyword.'&page='.$page;
		$data['fy'] = fy_backend($data['count'],$row,$url,$data['page'],5,2);
	
		$this->load->view('admin/product_list_gant',$data);
	}
	
	//产品列表
	function gant2(){
        ini_set("memory_limit","256M");
		$this->session->set_userdata('menu','gant2');
		$row=$this->input->get('row');
		if($row==""){$row=0;}
		$page = 50;
		$data['row']=$row;
		$data['page']=$page;
	
		$keyword = $this->input->get('keyword');
		$category_id = $this->input->get('category_id');
		$brand_id = $this->input->get('brand_id');
		$con=array('orderby'=>'d.step1_approve_time_1','orderby_res'=>'DESC');
		if($keyword!=""){
			$con['keyword'] = $keyword;
		}
		if($category_id!=""){
			$con['category_id'] = $category_id;
		}
		if($brand_id!=""){
			$con['brand_id'] = $brand_id;
		}
		$con['other_con'] = 'd.step1_id IS NOT NULL';
		$con['row'] = 0;
		$con['page'] = 2000;
	
		$data['productlist']=$this->ProductModel->getproductlist($con);
		$data['count']=$this->ProductModel->getproductlist($con,1);
		$url = base_url().'index.php/admins/product/index?keyword='.$keyword.'&page='.$page;
		$data['fy'] = fy_backend($data['count'],$row,$url,$data['page'],5,2);
	
		$this->load->view('admin/product_list_gant2',$data);
	}
	
	//添加商品
	function toadd_product(){
		//跳转到列表页面
		$backurl = base64_encode(base_url().'index.php/admins/product/index');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/index';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/index';
		}
		$data['decodebackurl'] = $decodebackurl;
		$data['backurl'] = $backurl;
		//导航栏
		$data['url'] = '<a href="'.$decodebackurl.'">'.lang('dz_product_manage').'</a> &gt; '.lang('dz_product_add');
		
		$this->load->view('admin/product_add',$data);
	}
	//添加商品 ------- 处理方法
	function add_product(){
		//商品信息
		$product_name_en = $this->input->post('product_name_en');//产品名称
		$product_name_ch = $this->input->post('product_name_ch');//产品名称
		$product_SKUno = $this->input->post('product_SKUno');//产品编号
		$brand_id = $this->input->post('brand_id');//品牌
		if($brand_id == ''){$brand_id = 0;}
		$uid = $this->input->post('uid');
		if($uid == ''){$uid = 0;}
		
		$product_tagline_en = $this->input->post('product_tagline_en');//产品广告语
		$product_tagline_ch = $this->input->post('product_tagline_ch');//产品广告语
		
		$product_country = $this->input->post('product_country');//原产国
		$product_price_select = $this->input->post('product_price_select');//选中的价格
		if($product_price_select == ''){$product_price_select = 0;}
		$product_price_regular = $this->input->post('product_price_regular');//日常价格
		if($product_price_regular == ''){$product_price_regular = 0;}
		$product_price_promotion = $this->input->post('product_price_promotion');//促销价
		if($product_price_promotion == ''){$product_price_promotion = 0;}
		
		
		$product_description_en = $this->input->post('product_description_en');//产品描述
		$product_description_ch = $this->input->post('product_description_ch');//产品描述
		
		
	
		$arr = array('edited_author'=>$this->admin_username, 'product_key'=>randkey(32), 'created'=>time(), 'edited'=>time());
		//商品信息
		$arr['product_name_en'] = $product_name_en;
		$arr['product_name_ch'] = $product_name_ch;
		$arr['product_SKUno'] = $product_SKUno;
		$arr['brand_id'] = $brand_id;
		$arr['uid'] = $uid;
		
		$arr['product_tagline_en'] = $product_tagline_en;
		$arr['product_tagline_ch'] = $product_tagline_ch;
		
		$arr['product_country'] = $product_country;
		$arr['product_price_select'] = $product_price_select;
		$arr['product_price_regular'] = $product_price_regular;
		$arr['product_price_promotion'] = $product_price_promotion;
		
		
		$arr['product_description_en'] = $product_description_en;
		$arr['product_description_ch'] = $product_description_ch;
		$product_id = $this->ProductModel->add_product($arr);
		
		//----修改图片路径--START-----//
		$arr_pic=array();
		$img1_gksel = $this->input->post('img1_gksel');//商品图片
		$arr_pic[]=array('num'=>1,'item'=>'product_pic','value'=>$img1_gksel);
		$arr_pic=autotofilepath('product',$arr_pic);
		if(!empty($arr_pic)){
			$this->ProductModel->edit_product($product_id,$arr_pic);
		}
		//----修改图片路径--END-----//
		
		//处理多个分类
		$category_id = $this->input->post('category_id');//产品分类
		$this->db->delete(DB_PRE().'product_category', array('product_id'=>$product_id));
		if(!empty($category_id)){
			for ($i = 0; $i < count($category_id); $i++) {
				$this->db->insert(DB_PRE().'product_category', array('product_id'=>$product_id, 'category_id'=>$category_id[$i]));
			}
		}
	
		//跳转到列表页面
		$backurl = $this->input->post('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/index';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/index';
		}
		echo json_encode(array('backurl'=>$decodebackurl));
	}
	
	function toview_qfcheckform($product_id){
		//跳转到列表页面
		$backurl = $this->input->get('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/index';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/index';
		}
		$data['decodebackurl'] = $decodebackurl;
		$data['backurl'] = $backurl;
		//导航栏
		$data['url'] = '<a href="'.$decodebackurl.'">'.lang('dz_product_manage').'</a> &gt; Quality Check Form';
	
		$data['productinfo']=$this->ProductModel->getproductinfo($product_id);
		$this->load->view('admin/product_view_quality_check',$data);
	}
	function toview_meacheckform($product_id){
		//跳转到列表页面
		$backurl = $this->input->get('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/index';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/index';
		}
		$data['decodebackurl'] = $decodebackurl;
		$data['backurl'] = $backurl;
		//导航栏
		$data['url'] = '<a href="'.$decodebackurl.'">'.lang('dz_product_manage').'</a> &gt; Measurement Check Form';
		
		$data['productinfo']=$this->ProductModel->getproductinfo($product_id);
		$this->load->view('admin/product_view_measulement_check',$data);
	}
	//修改商品
	function toview_kehudanzi($product_id){
		//跳转到列表页面
		$backurl = $this->input->get('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/index';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/index';
		}
		$data['decodebackurl'] = $decodebackurl;
		$data['backurl'] = $backurl;
		//导航栏
		$data['url'] = '<a href="'.$decodebackurl.'">'.lang('dz_product_manage').'</a> &gt; 查看客户单子';
	
		$data['productinfo']=$this->ProductModel->getproductinfo($product_id);
		$this->load->view('admin/product_kehudanzi_view',$data);
	}
	//修改商品
	function toedit_product($product_id){
		//跳转到列表页面
		$backurl = $this->input->get('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/index';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/index';
		}
		$data['decodebackurl'] = $decodebackurl;
		$data['backurl'] = $backurl;
		//导航栏
		$data['url'] = '<a href="'.$decodebackurl.'">'.lang('dz_product_manage').'</a> &gt; '.lang('dz_product_edit');
		
		$data['productinfo']=$this->ProductModel->getproductinfo($product_id);
		$this->load->view('admin/product_edit',$data);
	}
	//修改商品 ------- 处理方法
	function edit_product($product_id){
		//商品信息
		$product_name_en = $this->input->post('product_name_en');//产品名称
		$product_name_ch = $this->input->post('product_name_ch');//产品名称
		$product_SKUno = $this->input->post('product_SKUno');//产品编号
		$brand_id = $this->input->post('brand_id');//品牌
		if($brand_id == ''){$brand_id = 0;}
		$uid = $this->input->post('uid');
		if($uid == ''){$uid = 0;}
		
		$product_tagline_en = $this->input->post('product_tagline_en');//产品广告语
		$product_tagline_ch = $this->input->post('product_tagline_ch');//产品广告语
		
		$product_country = $this->input->post('product_country');//原产国
		$product_price_select = $this->input->post('product_price_select');//选中的价格
		if($product_price_select == ''){$product_price_select = 0;}
		$product_price_regular = $this->input->post('product_price_regular');//日常价格
		if($product_price_regular == ''){$product_price_regular = 0;}
		$product_price_promotion = $this->input->post('product_price_promotion');//促销价
		if($product_price_promotion == ''){$product_price_promotion = 0;}
		
		
		$product_description_en = $this->input->post('product_description_en');//产品描述
		$product_description_ch = $this->input->post('product_description_ch');//产品描述
		
		$category_id = $this->input->post('category_id');//产品分类
		
		$arr = array('edited_author'=>$this->admin_username, 'edited'=>time());
		//商品信息
		$arr['product_name_en'] = $product_name_en;
		$arr['product_name_ch'] = $product_name_ch;
		$arr['product_SKUno'] = $product_SKUno;
		$arr['brand_id'] = $brand_id;
		$arr['uid'] = $uid;
		
		$arr['product_tagline_en'] = $product_tagline_en;
		$arr['product_tagline_ch'] = $product_tagline_ch;
		
		$arr['product_country'] = $product_country;
		$arr['product_price_select'] = $product_price_select;
		$arr['product_price_regular'] = $product_price_regular;
		$arr['product_price_promotion'] = $product_price_promotion;
		
		
		$arr['product_description_en'] = $product_description_en;
		$arr['product_description_ch'] = $product_description_ch;
		
		$this->ProductModel->edit_product($product_id, $arr);
		
		//处理多个分类
		$this->db->delete(DB_PRE().'product_category', array('product_id'=>$product_id));
		if(!empty($category_id)){
			for ($i = 0; $i < count($category_id); $i++) {
				$this->db->insert(DB_PRE().'product_category', array('product_id'=>$product_id, 'category_id'=>$category_id[$i]));
			}
		}
		
		//----修改图片路径--START-----//
		$arr_pic=array();
		$img1_gksel = $this->input->post('img1_gksel');//商品图片
		$arr_pic[]=array('num'=>1,'item'=>'product_pic','value'=>$img1_gksel);
		$arr_pic = autotofilepath('product',$arr_pic);
		if(!empty($arr_pic)){
			$this->ProductModel->edit_product($product_id,$arr_pic);
			
			$this->load->library ( 'app' );
			$newproductinfo = $this->ProductModel->getproductinfo($product_id);
			if($newproductinfo['product_pic']!= ""){
				$product_pic = $newproductinfo['product_pic'];
				$sp = explode('.', $product_pic);
				$houzuitype = end($sp);
					
				//400*400
				$new_pic=date('Y_m_d_H_i_s').'_400_'.rand(1,999999999).'.'.$houzuitype;
				$copy_url = 'upload/product/'.date('Y').'/'.date('m').'/'.$new_pic;
				$res=copy($product_pic, $copy_url);
				$this->app->my_image_resize($copy_url, $copy_url, 400, 400 );
				$this->ProductModel->edit_product($product_id, array('product_pic_400'=>$copy_url));
					
				//100*100
				$new_pic=date('Y_m_d_H_i_s').'_small_'.rand(1,999999999).'.'.$houzuitype;
				$copy_url = 'upload/product/'.date('Y').'/'.date('m').'/'.$new_pic;
				$res=copy($product_pic, $copy_url);
				$this->app->my_image_resize($copy_url, $copy_url, 100, 100 );
				$this->ProductModel->edit_product($product_id, array('product_pic_100'=>$copy_url));
			}
		}
		//----修改图片路径--END-----//
		
		//跳转到列表页面
		$backurl = $this->input->post('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/index';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/index';
		}
		echo json_encode(array('backurl'=>$decodebackurl));
	}
	
	
	
	//删除商品
	function del_product($product_id){
		$this->db->delete('ipadqrcode_product_step1', array('product_id'=>$product_id));
		$this->db->delete('ipadqrcode_product_step2', array('product_id'=>$product_id));
		$this->db->delete('ipadqrcode_product_step3', array('product_id'=>$product_id));
		$this->db->delete('ipadqrcode_product_step4', array('product_id'=>$product_id));
		$this->db->delete('ipadqrcode_product_step5', array('product_id'=>$product_id));
		
		$this->db->delete('ipadqrcode_product_form_qfcheck', array('product_id'=>$product_id));
		$this->db->delete('ipadqrcode_product_form_meacheck', array('product_id'=>$product_id));
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//兑换产品列表
	function loyaltylist(){
		$this->session->set_userdata('menu','productloyalty');
		$row=$this->input->get('row');
		if($row==""){$row=0;}
		$page = 50;
		$data['row']=$row;
		$data['page']=$page;
	
		$keyword = $this->input->get('keyword');
		$con=array('orderby'=>'a.loyalty_id','orderby_res'=>'DESC','row'=>$row,'page'=>$data['page']);
		if($keyword!=""){
			$con['keyword'] = $keyword;
		}
		$data['loyaltylist']=$this->ProductModel->getloyaltylist($con);
		$data['count']=$this->ProductModel->getloyaltylist($con,1);
		$url = base_url().'index.php/admins/product/loyaltylist?keyword='.$keyword.'&page='.$page;
		$data['fy'] = fy_backend($data['count'],$row,$url,$data['page'],5,2);
		$this->load->view('admin/product_loyalty_list',$data);
	}
	
	//添加兑换产品
	function toadd_loyalty(){
		//跳转到列表页面
		$backurl = base64_encode(base_url().'index.php/admins/product/loyaltylist');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/loyaltylist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/loyaltylist';
		}
		$data['decodebackurl'] = $decodebackurl;
		$data['backurl'] = $backurl;
		//导航栏
		$data['url'] = '<a href="'.$decodebackurl.'">'.lang('dz_product_loyalty_manage').'</a> &gt; '.lang('dz_product_loyalty_add');
	
		$this->load->view('admin/product_loyalty_add',$data);
	}
	//添加兑换产品 ------- 处理方法
	function add_loyalty(){
		//商品信息
		$loyalty_name_en = $this->input->post('loyalty_name_en');//产品名称
		$loyalty_name_ch = $this->input->post('loyalty_name_ch');//产品名称
	
		$loyalty_tagline_en = $this->input->post('loyalty_tagline_en');//产品广告语
		$loyalty_tagline_ch = $this->input->post('loyalty_tagline_ch');//产品广告语
	
		$loyalty_points = $this->input->post('loyalty_points');//需要积分
		if($loyalty_points == ''){$loyalty_points = 0;}
	
		$loyalty_description_en = $this->input->post('loyalty_description_en');//产品描述
		$loyalty_description_ch = $this->input->post('loyalty_description_ch');//产品描述
	
		$arr = array('edited_author'=>$this->admin_username, 'created'=>time(), 'edited'=>time());
		//商品信息
		$arr['loyalty_name_en'] = $loyalty_name_en;
		$arr['loyalty_name_ch'] = $loyalty_name_ch;
		$arr['loyalty_tagline_en'] = $loyalty_tagline_en;
		$arr['loyalty_tagline_ch'] = $loyalty_tagline_ch;
	
		$arr['loyalty_points'] = $loyalty_points;
	
		$arr['loyalty_description_en'] = $loyalty_description_en;
		$arr['loyalty_description_ch'] = $loyalty_description_ch;
		$loyalty_id = $this->ProductModel->add_loyalty($arr);
	
		//----修改图片路径--START-----//
		$arr_pic=array();
		$img1_gksel = $this->input->post('img1_gksel');//商品图片
		$arr_pic[]=array('num'=>1,'item'=>'loyalty_pic','value'=>$img1_gksel);
		$arr_pic=autotofilepath('loyalty',$arr_pic);
		if(!empty($arr_pic)){
			$this->ProductModel->edit_loyalty($loyalty_id,$arr_pic);
		}
		//----修改图片路径--END-----//
		
		//处理多个分类
		$category_id = $this->input->post('category_id');//产品分类
		$this->db->delete(DB_PRE().'loyalty_category', array('loyalty_id'=>$loyalty_id));
		if(!empty($category_id)){
			for ($i = 0; $i < count($category_id); $i++) {
				$this->db->insert(DB_PRE().'loyalty_category', array('loyalty_id'=>$loyalty_id, 'category_id'=>$category_id[$i]));
			}
		}
	
		//跳转到列表页面
		$backurl = $this->input->post('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/loyaltylist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/loyaltylist';
		}
		echo json_encode(array('backurl'=>$decodebackurl));
	}
	
	//修改兑换产品
	function toedit_loyalty($loyalty_id){
		//跳转到列表页面
		$backurl = $this->input->get('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/loyaltylist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/loyaltylist';
		}
		$data['decodebackurl'] = $decodebackurl;
		$data['backurl'] = $backurl;
		//导航栏
		$data['url'] = '<a href="'.$decodebackurl.'">'.lang('dz_product_manage').'</a> &gt; '.lang('dz_product_edit');
	
		$data['loyaltyinfo']=$this->ProductModel->getloyaltyinfo($loyalty_id);
		$this->load->view('admin/product_loyalty_edit',$data);
	}
	//修改兑换产品 ------- 处理方法
	function edit_loyalty($loyalty_id){
		//商品信息
		$loyalty_name_en = $this->input->post('loyalty_name_en');//产品名称
		$loyalty_name_ch = $this->input->post('loyalty_name_ch');//产品名称
	
		$loyalty_tagline_en = $this->input->post('loyalty_tagline_en');//产品广告语
		$loyalty_tagline_ch = $this->input->post('loyalty_tagline_ch');//产品广告语
	
		$loyalty_points = $this->input->post('loyalty_points');//需要积分
		if($loyalty_points == ''){$loyalty_points = 0;}
	
		$loyalty_description_en = $this->input->post('loyalty_description_en');//产品描述
		$loyalty_description_ch = $this->input->post('loyalty_description_ch');//产品描述
	
		$arr = array('edited_author'=>$this->admin_username, 'edited'=>time());
		//商品信息
		$arr['loyalty_name_en'] = $loyalty_name_en;
		$arr['loyalty_name_ch'] = $loyalty_name_ch;
		$arr['loyalty_tagline_en'] = $loyalty_tagline_en;
		$arr['loyalty_tagline_ch'] = $loyalty_tagline_ch;
	
		$arr['loyalty_points'] = $loyalty_points;
	
		$arr['loyalty_description_en'] = $loyalty_description_en;
		$arr['loyalty_description_ch'] = $loyalty_description_ch;
	
		$this->ProductModel->edit_loyalty($loyalty_id, $arr);
		
		
		//处理多个分类
		$category_id = $this->input->post('category_id');//产品分类
		$this->db->delete(DB_PRE().'loyalty_category', array('loyalty_id'=>$loyalty_id));
		if(!empty($category_id)){
			for ($i = 0; $i < count($category_id); $i++) {
				$this->db->insert(DB_PRE().'loyalty_category', array('loyalty_id'=>$loyalty_id, 'category_id'=>$category_id[$i]));
			}
		}
	
	
		//----修改图片路径--START-----//
		$arr_pic=array();
		$img1_gksel = $this->input->post('img1_gksel');//商品图片
		$arr_pic[]=array('num'=>1,'item'=>'loyalty_pic','value'=>$img1_gksel);
		$arr_pic=autotofilepath('loyalty',$arr_pic);
		if(!empty($arr_pic)){
			$this->ProductModel->edit_loyalty($loyalty_id,$arr_pic);
		}
		//----修改图片路径--END-----//
	
		//跳转到列表页面
		$backurl = $this->input->post('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/loyaltylist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/loyaltylist';
		}
		echo json_encode(array('backurl'=>$decodebackurl));
	}
	//删除兑换产品
	function del_loyalty($loyalty_id){
		$this->ProductModel->del_loyalty($loyalty_id);
	}
	
	
	
	
	
	
	
	
	
	//图片列表
	function picturelist($product_id){
		//跳转到列表页面
		$backurl = $this->input->get('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/index';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/index';
		}
		$data['decodebackurl'] = $decodebackurl;
		$data['backurl'] = $backurl;
		//导航栏
		$data['url'] = '<a href="'.$decodebackurl.'">'.lang('dz_product_manage').'</a> &gt; '.lang('cy_picture_manage');
	
	
	
		$row=$this->input->get('row');
		if($row==""){$row=0;}
		$page = 50;
		$data['row']=$row;
		$data['page']=$page;
		$data['product_id']=$product_id;
	
		$con=array('product_id'=>$product_id, 'orderby'=>'a.sort', 'orderby_res'=>'ASC', 'row'=>$row, 'page'=>$data['page']);
		$data['picturelist']=$this->ProductModel->getpicturelist($con);
		$data['count']=$this->ProductModel->getpicturelist($con,1);
		$url = base_url().'index.php/admins/product/picturelist/'.$product_id.'?backurl='.$backurl;
		$data['fy'] = fy_backend($data['count'],$row,$url,$data['page'],5,2);
		$this->load->view('admin/product_picture_list',$data);
	}
	//添加图片
	function toadd_picture($product_id){
		//跳转到列表页面
		$backurl = $this->input->get('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/index';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/index';
		}
		$data['decodebackurl'] = $decodebackurl;
		$data['backurl'] = $backurl;
	
		//跳转到列表页面
		$subbackurl = $this->input->get('subbackurl');
		if($subbackurl!=""){
			$subbackurl=str_replace('slash_tag','/',$subbackurl);
			if(base64_decode($subbackurl)!=""){
				$decodesubbackurl = base64_decode($subbackurl);
			}else{
				$decodesubbackurl = base_url().'index.php/admins/product/subcategorylist/'.$product_id.'?backurl='.$backurl;
			}
		}else{
			$decodesubbackurl = base_url().'index.php/admins/product/subcategorylist/'.$product_id.'?backurl='.$backurl;
		}
		$data['decodesubbackurl'] = $decodesubbackurl;
		$data['subbackurl'] = $subbackurl;
		//导航栏
		$data['url'] = '<a href="'.$decodebackurl.'">'.lang('dz_product_manage').'</a> &gt; <a href="'.$decodesubbackurl.'">'.lang('cy_picture_manage').'</a> &gt; '.lang('cy_picture_add').'';
		$data['product_id'] = $product_id;
		$this->load->view('admin/product_picture_add',$data);
	}
	//图片 ------- 处理方法
	function add_picture($product_id){
		//图片信息
		$picture_name_en = $this->input->post('picture_name_en');//图片名称
		$picture_name_ch = $this->input->post('picture_name_ch');//图片名称
	
		$arr = array('product_id'=>$product_id, 'status'=>1, 'created'=>time(), 'edited'=>time());
		//图片信息
		$arr['picture_name_en'] = $picture_name_en;
		$arr['picture_name_ch'] = $picture_name_ch;
		$picture_id = $this->ProductModel->add_picture($arr);
		
		
		//----修改图片路径--START-----//
		$arr_pic=array();
		$img1_gksel = $this->input->post('img1_gksel');//商品图片
		$arr_pic[]=array('num'=>1,'item'=>'picture_pic','value'=>$img1_gksel);
		$arr_pic=autotofilepath('product',$arr_pic);
		if(!empty($arr_pic)){
			$this->ProductModel->edit_picture($picture_id,$arr_pic);
		}
		//----修改图片路径--END-----//
	
	
		//跳转到列表页面
		$backurl = $this->input->post('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/index';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/index';
		}
		//跳转到列表页面
		$subbackurl = $this->input->post('subbackurl');
		if($subbackurl!=""){
			$subbackurl=str_replace('slash_tag','/',$subbackurl);
			if(base64_decode($subbackurl)!=""){
				$decodesubbackurl = base64_decode($subbackurl);
			}else{
				$decodesubbackurl = base_url().'index.php/admins/product/picturelist/'.$product_id.'?backurl='.$backurl;
			}
		}else{
			$decodesubbackurl = base_url().'index.php/admins/product/picturelist/'.$product_id.'?backurl='.$backurl;
		}
		echo json_encode(array('backurl'=>$decodebackurl, 'subbackurl'=>$decodesubbackurl));
	}
	//修改图片
	function toedit_picture($product_id, $picture_id){
		//跳转到列表页面
		$backurl = $this->input->get('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/index';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/index';
		}
		$data['decodebackurl'] = $decodebackurl;
		$data['backurl'] = $backurl;
	
		$data['product_id'] = $product_id;
	
		//跳转到列表页面
		$subbackurl = $this->input->post('subbackurl');
		if($subbackurl!=""){
			$subbackurl=str_replace('slash_tag','/',$subbackurl);
			if(base64_decode($subbackurl)!=""){
				$decodesubbackurl = base64_decode($subbackurl);
			}else{
				$decodesubbackurl = base_url().'index.php/admins/product/picturelist/'.$product_id.'?backurl='.$backurl;
			}
		}else{
			$decodesubbackurl = base_url().'index.php/admins/product/picturelist/'.$product_id.'?backurl='.$backurl;
		}
		$data['decodesubbackurl'] = $decodesubbackurl;
		$data['subbackurl'] = $subbackurl;
		//导航栏
		$data['url'] = '<a href="'.$decodebackurl.'">'.lang('dz_product_manage').'</a> &gt; <a href="'.$decodesubbackurl.'">'.lang('cy_picture_manage').'</a> &gt; '.lang('cy_picture_edit').'';
	
		$data['pictureinfo']=$this->ProductModel->getpictureinfo($picture_id);
		$this->load->view('admin/product_picture_edit',$data);
	}
	//修改图片 ------- 处理方法
	function edit_picture($product_id, $picture_id){
		//图片信息
		$picture_name_en = $this->input->post('picture_name_en');//图片名称
		$picture_name_ch = $this->input->post('picture_name_ch');//图片名称
	
		$arr = array('edited'=>time());
		//图片信息
		$arr['picture_name_en'] = $picture_name_en;
		$arr['picture_name_ch'] = $picture_name_ch;
		$this->ProductModel->edit_picture($picture_id, $arr);
		
		//----修改图片路径--START-----//
		$arr_pic=array();
		$img1_gksel = $this->input->post('img1_gksel');//商品图片
		$arr_pic[]=array('num'=>1,'item'=>'picture_pic','value'=>$img1_gksel);
		$arr_pic=autotofilepath('product',$arr_pic);
		if(!empty($arr_pic)){
			$this->ProductModel->edit_picture($picture_id,$arr_pic);
		}
		//----修改图片路径--END-----//
	
		//跳转到列表页面
		$backurl = $this->input->post('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/index';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/index';
		}
		//跳转到列表页面
		$subbackurl = $this->input->post('subbackurl');
		if($subbackurl!=""){
			$subbackurl=str_replace('slash_tag','/',$subbackurl);
			if(base64_decode($subbackurl)!=""){
				$decodesubbackurl = base64_decode($subbackurl);
			}else{
				$decodesubbackurl = base_url().'index.php/admins/product/picturelist/'.$product_id.'?backurl='.$backurl;
			}
		}else{
			$decodesubbackurl = base_url().'index.php/admins/product/picturelist/'.$product_id.'?backurl='.$backurl;
		}
		echo json_encode(array('backurl'=>$decodebackurl, 'subbackurl'=>$decodesubbackurl));
	}
	//图片的排序
	function editpicture_sort(){
		$idarr=$this->input->post('idarr');
		$newsrot=$this->input->post('newsrot');
		if(!empty($idarr)){
			for($i=0;$i<count($idarr);$i++){
				$this->ProductModel->edit_picture($idarr[$i], array('sort'=>$newsrot[$i]));
			}
		}
	}
	//删除图片
	function del_picture($picture_id){
		echo $picture_id;exit;
		$this->ProductModel->del_picture($picture_id);
	}
	
	//产品分类列表
	function designlist($parent, $category_id){
		//跳转到列表页面
		$backurl = $this->input->get('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/categorylist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/categorylist';
		}
		$data['decodebackurl'] = $decodebackurl;
		$data['backurl'] = $backurl;
	
		$data['parent'] = $parent;
		$data['category_id'] = $category_id;
	
		//跳转到列表页面
		$subbackurl = $this->input->get('subbackurl');
		if($subbackurl!=""){
			$subbackurl=str_replace('slash_tag','/',$subbackurl);
			if(base64_decode($subbackurl)!=""){
				$decodesubbackurl = base64_decode($subbackurl);
			}else{
				$decodesubbackurl = base_url().'index.php/admins/product/subcategorylist/'.$parent.'?backurl='.$backurl;
			}
		}else{
			$decodesubbackurl = base_url().'index.php/admins/product/subcategorylist/'.$parent.'?backurl='.$backurl;
		}
		$data['decodesubbackurl'] = $decodesubbackurl;
		$data['subbackurl'] = $subbackurl;
		//导航栏
		$data['url'] = '<a href="'.$decodebackurl.'">'.lang('dz_product_category_manage').'</a> &gt; <a href="'.$decodesubbackurl.'">'.lang('dz_product_subcategory_manage').'</a> &gt; Design List';
	
		$data['categoryinfo']=$this->ProductModel->getproductcategoryinfo($category_id);
		
		
		
		
		$sql = "SELECT * FROM ".DB_PRE()."category_design WHERE status = 1 AND parent = 0 AND category_id = ".$category_id." ORDER BY sort ASC";
		$designlist = $this->db->query($sql)->result_array();
                
		//正常返回数据(json)
		$newre = array();
		if(!empty($designlist)){
			for ($i = 0; $i < count($designlist); $i++) {
				$thisarr = array();
				$thisarr['design_id'] = $designlist[$i]['design_id'];
				$thisarr['design_name_en'] = $designlist[$i]['design_name_en'];
				$thisarr['design_name_ch'] = $designlist[$i]['design_name_ch'];
				if($designlist[$i]['ishave_input'] == 1){
					$thisarr['ishave_input'] = 1;
		
					if($designlist[$i]['input_title_en'] != ''){
						$thisarr['input_title_en'] = $designlist[$i]['input_title_en'];
					}
					if($designlist[$i]['input_title_ch'] != ''){
						$thisarr['input_title_ch'] = $designlist[$i]['input_title_ch'];
					}
				}
				if($designlist[$i]['ishave_input2'] == 1){
					$thisarr['ishave_input2'] = 1;
				
					if($designlist[$i]['input2_title_en'] != ''){
						$thisarr['input2_title_en'] = $designlist[$i]['input2_title_en'];
					}
					if($designlist[$i]['input2_title_ch'] != ''){
						$thisarr['input2_title_ch'] = $designlist[$i]['input2_title_ch'];
					}
				}
		
		
				$sql = "SELECT * FROM ".DB_PRE()."category_design WHERE status = 1 AND parent = ".$designlist[$i]['design_id']." ORDER BY sort ASC";
				$sublist_get = $this->db->query($sql)->result_array();
				$sublist = array();
				if(!empty($sublist_get)){
					for ($j = 0; $j < count($sublist_get); $j++) {
						$sublist[$j]['design_id'] = $sublist_get[$j]['design_id'];
						$sublist[$j]['design_name_en'] = $sublist_get[$j]['design_name_en'];
						$sublist[$j]['design_name_ch'] = $sublist_get[$j]['design_name_ch'];
						if($sublist_get[$j]['ishave_radio'] == 1){
							$sublist[$j]['ishave_radio'] = 1;
						}
						if($sublist_get[$j]['ishave_checkbox'] == 1){
							$sublist[$j]['ishave_checkbox'] = 1;
						}
						if($sublist_get[$j]['ishave_input'] == 1){
							$sublist[$j]['ishave_input'] = 1;
								
							if($sublist_get[$j]['input_title_en'] != ''){
								$sublist[$j]['input_title_en'] = $sublist_get[$j]['input_title_en'];
							}
							if($sublist_get[$j]['input_title_ch'] != ''){
								$sublist[$j]['input_title_ch'] = $sublist_get[$j]['input_title_ch'];
							}
						}
						if($sublist_get[$j]['ishave_input2'] == 1){
							$sublist[$j]['ishave_input2'] = 1;
						
							if($sublist_get[$j]['input2_title_en'] != ''){
								$sublist[$j]['input2_title_en'] = $sublist_get[$j]['input2_title_en'];
							}
							if($sublist_get[$j]['input2_title_ch'] != ''){
								$sublist[$j]['input2_title_ch'] = $sublist_get[$j]['input2_title_ch'];
							}
						}
						if($sublist_get[$j]['ishave_picture'] == 1){
							$sublist[$j]['design_pic'] = $sublist_get[$j]['design_pic'];
						}
		
		
		
						$sql = "SELECT * FROM ".DB_PRE()."category_design WHERE status = 1 AND parent = ".$sublist_get[$j]['design_id']." ORDER BY sort ASC";
						$thirdlist_get = $this->db->query($sql)->result_array();
						$thirdlist = array();
						if(!empty($thirdlist_get)){
							for ($k = 0; $k < count($thirdlist_get); $k++) {
								$thirdlist[$k]['design_id'] = $thirdlist_get[$k]['design_id'];
								$thirdlist[$k]['design_name_en'] = $thirdlist_get[$k]['design_name_en'];
								$thirdlist[$k]['design_name_ch'] = $thirdlist_get[$k]['design_name_ch'];
								if($thirdlist_get[$k]['ishave_radio'] == 1){
									$thirdlist[$k]['ishave_radio'] = 1;
								}
								if($thirdlist_get[$k]['ishave_checkbox'] == 1){
									$thirdlist[$k]['ishave_checkbox'] = 1;
								}
								if($thirdlist_get[$k]['ishave_input'] == 1){
									$thirdlist[$k]['ishave_input'] = 1;
										
									if($thirdlist_get[$k]['input_title_en'] != ''){
										$thirdlist[$k]['input_title_en'] = $thirdlist_get[$k]['input_title_en'];
									}
									if($thirdlist_get[$k]['input_title_ch'] != ''){
										$thirdlist[$k]['input_title_ch'] = $thirdlist_get[$k]['input_title_ch'];
									}
								}
								if($thirdlist_get[$k]['ishave_input2'] == 1){
									$thirdlist[$k]['ishave_input2'] = 1;
								
									if($thirdlist_get[$k]['input2_title_en'] != ''){
										$thirdlist[$k]['input2_title_en'] = $thirdlist_get[$k]['input2_title_en'];
									}
									if($thirdlist_get[$k]['input2_title_ch'] != ''){
										$thirdlist[$k]['input2_title_ch'] = $thirdlist_get[$k]['input2_title_ch'];
									}
								}
								if($thirdlist_get[$k]['ishave_picture'] == 1){
									$thirdlist[$k]['design_pic'] = $thirdlist_get[$k]['design_pic'];
								}
							}
							$sublist[$j]['thirdlist'] = $thirdlist;
						}
					}
					$thisarr['sublist'] = $sublist;
				}
				$newre[] = $thisarr;
			}
		}
		$data['designlist'] = $newre;
		
		
		$this->load->view('admin/product_design_list',$data);
	}
        
        function editdesign_sort(){
            $idarr=$this->input->post('idarr');
            $newsrot=$this->input->post('newsrot');
            if(!empty($idarr)){
                for($i=0;$i<count($idarr);$i++){
                    $arr = array('sort'=>$newsrot[$i]);
                    $this->ProductModel->edit_design($idarr[$i], $arr);
                }
            }
    }
        
        
	//修改商品分类
	function toedit_design($parent, $category_id, $design_id){
		//跳转到列表页面
		$backurl = $this->input->get('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/categorylist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/categorylist';
		}
		$data['decodebackurl'] = $decodebackurl;
		$data['backurl'] = $backurl;
	
		$data['parent'] = $parent;
		$data['category_id'] = $category_id;
	
		//跳转到列表页面
		$subbackurl = $this->input->get('subbackurl');
		if($subbackurl!=""){
			$subbackurl=str_replace('slash_tag','/',$subbackurl);
			if(base64_decode($subbackurl)!=""){
				$decodesubbackurl = base64_decode($subbackurl);
			}else{
				$decodesubbackurl = base_url().'index.php/admins/product/subcategorylist/'.$parent.'?backurl='.$backurl;
			}
		}else{
			$decodesubbackurl = base_url().'index.php/admins/product/subcategorylist/'.$parent.'?backurl='.$backurl;
		}
		$data['decodesubbackurl'] = $decodesubbackurl;
		$data['subbackurl'] = $subbackurl;

		//跳转到列表页面
		$thirdbackurl = $this->input->get('thirdbackurl');
		if($thirdbackurl!=""){
			$thirdbackurl=str_replace('slash_tag','/',$thirdbackurl);
			if(base64_decode($thirdbackurl)!=""){
				$decodethirdbackurl = base64_decode($thirdbackurl);
			}else{
				$decodethirdbackurl = base_url().'index.php/admins/product/thirdcategorylist/'.$parent.'?backurl='.$backurl;
			}
		}else{
			$decodethirdbackurl = base_url().'index.php/admins/product/thirdcategorylist/'.$parent.'?backurl='.$backurl;
		}
		$data['decodethirdbackurl'] = $decodethirdbackurl;
		$data['thirdbackurl'] = $thirdbackurl;
		
		//导航栏
		$data['url'] = '<a href="'.$decodebackurl.'">'.lang('dz_product_category_manage').'</a> &gt; <a href="'.$decodesubbackurl.'">'.lang('dz_product_subcategory_manage').'</a> &gt; <a href="'.$decodethirdbackurl.'">Design List</a> &gt; Edit';
		
		$data['categoryinfo']=$this->ProductModel->getproductcategoryinfo($category_id);
		
		
		$sql = "SELECT * FROM ".DB_PRE()."category_design WHERE design_id = ".$design_id."";
		$designinfo = $this->db->query($sql)->row_array();
		if(!empty($designinfo)){
			$data['designinfo'] = $designinfo;
		}else{
			$data['designinfo'] = null;
		}
		
		$this->load->view('admin/product_design_edit',$data);
	}
	//修改商品分类 ------- 处理方法
	function edit_design($parent, $category_id, $design_id){
        //商品信息
        $design_name_en = $this->input->post('design_name_en');//产品分类名称
        $design_name_ch = $this->input->post('design_name_ch');//产品分类名称
        $input_title_en = $this->input->post('input_title_en');
        $input_title_ch = $this->input->post('input_title_ch');
        $design_info = $this->input->post('design_info');//产品分类名称
        $sort = $this->input->post('sort');
        $type = intval($this->input->post('design_type'));
        $arr = array('edited' => time());
        //商品信息
//        $arr['design_type'] = $type;
        $arr['design_name_en'] = $design_name_en;
        $arr['design_name_ch'] = $design_name_ch;
        $arr['input_title_en'] = isset($input_title_en) ? $input_title_en : null;
        $arr['input_title_ch'] = isset($input_title_ch) ? $input_title_ch : null;
        $arr['design_info'] = $design_info;
        $arr['sort'] = $sort;

        switch ($type) {
            case 1:
                $arr['ishave_picture'] = 1;
                $arr['ishave_radio'] = 1;
                break;
            case 2:
                $arr['ishave_picture'] = 1;
                        $arr['ishave_radio'] = 1;
                        $arr['ishave_input'] = 1;
                        break;
                    case 3:
                        $arr['ishave_input'] = 1;
                        break;
                    case 4:
                        $arr['ishave_picture'] = 1;
                        $arr['ishave_radio'] = 1;
                        $arr['ishave_input'] = 1;
                        break;
                    case 5:
                        $arr['ishave_picture'] = 1;
                        $arr['ishave_radio'] = 1;
                        $arr['ishave_input'] = 1;
                        $arr['ishave_input2'] = 1;
                        break;
                    case 6:
                        $arr['ishave_picture'] = 1;
                        $arr['ishave_checkbox'] = 1;
                        $arr['ishave_input'] = 1;
                        break;
                    case 7:
                        $arr['ishave_checkbox'] = 1;
                        $arr['ishave_input'] = 1;
                        break;
                    default:
                        break;
                }

		$this->ProductModel->edit_design($design_id, $arr);
		
		
		//----修改图片路径--START-----//
		$arr_pic=array();
		//获取内容
		$img1_gksel = $this->input->post('img1_gksel');
		$arr_pic[] = array('num'=>1, 'item'=>'design_pic','value'=>$img1_gksel);
		
		$arr_pic = autotofilepath('design', $arr_pic);
		if(!empty($arr_pic)){
			$this->ProductModel->edit_design($design_id, $arr_pic);
		}
		//----修改图片路径--END-----//
	
		//跳转到列表页面
		$backurl = $this->input->post('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/categorylist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/categorylist';
		}
		//跳转到列表页面
		$subbackurl = $this->input->post('subbackurl');
		if($subbackurl!=""){
			$subbackurl=str_replace('slash_tag','/',$subbackurl);
			if(base64_decode($subbackurl)!=""){
				$decodesubbackurl = base64_decode($subbackurl);
			}else{
				$decodesubbackurl = base_url().'index.php/admins/product/categorylist';
			}
		}else{
			$decodesubbackurl = base_url().'index.php/admins/product/categorylist';
		}
		//跳转到列表页面
		$thirdbackurl = $this->input->post('thirdbackurl');
		if($thirdbackurl!=""){
			$thirdbackurl=str_replace('slash_tag','/',$thirdbackurl);
			if(base64_decode($thirdbackurl)!=""){
				$decodethirdbackurl = base64_decode($thirdbackurl);
			}else{
				$decodethirdbackurl = base_url().'index.php/admins/product/categorylist';
			}
		}else{
			$decodethirdbackurl = base_url().'index.php/admins/product/categorylist';
		}
		echo json_encode(array('backurl'=>$decodebackurl, 'subbackurl'=>$decodesubbackurl, 'thirdbackurl'=>$decodethirdbackurl));
	}
        
        
	//修改商品分类 to add design
	function toadd_design($parent, $category_id){
		//跳转到列表页面
		$backurl = $this->input->get('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/categorylist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/categorylist';
		}
		$data['decodebackurl'] = $decodebackurl;
		$data['backurl'] = $backurl;
	
		$data['parent'] = $parent;
		$data['category_id'] = $category_id;
	
		//跳转到列表页面
		$subbackurl = $this->input->get('subbackurl');
		if($subbackurl!=""){
			$subbackurl=str_replace('slash_tag','/',$subbackurl);
			if(base64_decode($subbackurl)!=""){
				$decodesubbackurl = base64_decode($subbackurl);
			}else{
				$decodesubbackurl = base_url().'index.php/admins/product/subcategorylist/'.$parent.'?backurl='.$backurl;
			}
		}else{
			$decodesubbackurl = base_url().'index.php/admins/product/subcategorylist/'.$parent.'?backurl='.$backurl;
		}
		$data['decodesubbackurl'] = $decodesubbackurl;
		$data['subbackurl'] = $subbackurl;

		//跳转到列表页面
		$thirdbackurl = $this->input->get('thirdbackurl');
		if($thirdbackurl!=""){
			$thirdbackurl=str_replace('slash_tag','/',$thirdbackurl);
			if(base64_decode($thirdbackurl)!=""){
				$decodethirdbackurl = base64_decode($thirdbackurl);
			}else{
				$decodethirdbackurl = base_url().'index.php/admins/product/thirdcategorylist/'.$parent.'?backurl='.$backurl;
			}
		}else{
			$decodethirdbackurl = base_url().'index.php/admins/product/thirdcategorylist/'.$parent.'?backurl='.$backurl;
		}
		$data['decodethirdbackurl'] = $decodethirdbackurl;
		$data['thirdbackurl'] = $thirdbackurl;
		
		//导航栏
		$data['url'] = '<a href="'.$decodebackurl.'">'.lang('dz_product_category_manage').'</a> &gt; <a href="'.$decodesubbackurl.'">'.lang('dz_product_subcategory_manage').'</a> &gt; <a href="'.$decodethirdbackurl.'">Design List</a> &gt; Add';
		
		$data['categoryinfo']=$this->ProductModel->getproductcategoryinfo($category_id);
		
		
		//$sql = "SELECT design_id, design_name_en, design_name_ch FROM ".DB_PRE()."category_design";
		$sql = "SELECT design_id, design_name_en, design_name_ch FROM ".DB_PRE()."category_design WHERE status = 1 AND parent = 0 AND category_id = ".$category_id;
                $data['designlist'] = $this->db->query($sql)->result_array();
		
		$this->load->view('admin/product_design_add',$data);
	}
	//修改商品分类 ------- 处理方法
	function add_design($parent, $category_id){
		//商品信息
		$design_name_en = $this->input->post('design_name_en');//产品分类名称
		$design_name_ch = $this->input->post('design_name_ch');//产品分类名称
//		$design_info = $this->input->post('design_info');//产品分类名称
		$parent_design = $this->input->post('parent_design');//parent design
		$sort = $this->input->post('sort');
                $type = intval($this->input->post('design_type'));
                $arr = array('edited_author'=>$this->admin_username, 'edited'=>time(), 'created' => time());
		//商品信息
		$arr['design_name_en'] = $design_name_en;
		$arr['design_name_ch'] = $design_name_ch;
		$arr['category_id'] = $category_id;
		$arr['parent'] = $parent_design;
		$arr['status'] = 1;
		$arr['sort'] = $sort;
                
                switch ($type) {
                    case 1:
                        $arr['ishave_picture'] = 1;
                        $arr['ishave_radio'] = 1;
                        break;
                    case 2:
                        $arr['ishave_picture'] = 1;
                        $arr['ishave_radio'] = 1;
                        $arr['ishave_input'] = 1;
                        break;
                    case 3:
                        $arr['ishave_input'] = 1;
                        break;
                    case 4:
                        $arr['ishave_picture'] = 1;
                        $arr['ishave_radio'] = 1;
                        $arr['ishave_input'] = 1;
                        break;
                    case 5:
                        $arr['ishave_picture'] = 1;
                        $arr['ishave_radio'] = 1;
                        $arr['ishave_input'] = 1;
                        $arr['ishave_input2'] = 1;
                        break;
                    case 6:
                        $arr['ishave_picture'] = 1;
                        $arr['ishave_checkbox'] = 1;
                        $arr['ishave_input'] = 1;
                        break;
                    case 7:
                        $arr['ishave_checkbox'] = 1;
                        $arr['ishave_input'] = 1;
                        break;
                    default:
                        break;
                }
		$design_id = $this->ProductModel->add_design($arr);
		
		
                if(!empty($this->input->post('img1_gksel'))){
		//----修改图片路径--START-----//
		$arr_pic=array();
		//获取内容
		$img1_gksel = $this->input->post('img1_gksel');
		$arr_pic[] = array('num'=>1, 'item'=>'design_pic','value'=>$img1_gksel);
		
		$arr_pic = autotofilepath('design', $arr_pic);
		if(!empty($arr_pic)){
			$this->ProductModel->edit_design($design_id, $arr_pic);
		}
		//----修改图片路径--END-----//
                    
                }
	
		//跳转到列表页面
		$backurl = $this->input->post('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/categorylist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/categorylist';
		}
		//跳转到列表页面
		$subbackurl = $this->input->post('subbackurl');
		if($subbackurl!=""){
			$subbackurl=str_replace('slash_tag','/',$subbackurl);
			if(base64_decode($subbackurl)!=""){
				$decodesubbackurl = base64_decode($subbackurl);
			}else{
				$decodesubbackurl = base_url().'index.php/admins/product/categorylist';
			}
		}else{
			$decodesubbackurl = base_url().'index.php/admins/product/categorylist';
		}
		//跳转到列表页面
		$thirdbackurl = $this->input->post('thirdbackurl');
		if($thirdbackurl!=""){
			$thirdbackurl=str_replace('slash_tag','/',$thirdbackurl);
			if(base64_decode($thirdbackurl)!=""){
				$decodethirdbackurl = base64_decode($thirdbackurl);
			}else{
				$decodethirdbackurl = base_url().'index.php/admins/product/categorylist';
			}
		}else{
			$decodethirdbackurl = base_url().'index.php/admins/product/categorylist';
		}
		echo json_encode(array('backurl'=>$decodebackurl, 'subbackurl'=>$decodesubbackurl, 'thirdbackurl'=>$decodethirdbackurl));
	}
        
        public function delete_design($parent, $category_id, $design_id) {
            
            $this->ProductModel->delete_design($design_id);
            
            $url = base_url().'index.php/admins/product/designlist/' . $parent . '/' . $category_id . '/';
            
            header("Location: $url");
            die();
        }
}
