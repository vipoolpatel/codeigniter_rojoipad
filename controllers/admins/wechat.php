<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wechat extends CI_Controller{

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
	function autoreplylist(){
		$this->session->set_userdata('menu','wechatautoreply');
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
		$data['autoreplylist']=$this->WechatModel->getwechatautoreplylist($con);
		$data['count']=$this->WechatModel->getwechatautoreplylist($con,1);
		$url = base_url().'index.php/admins/wechat/autoreplylist?keyword='.$keyword;
		$data['fy'] = fy_backend($data['count'],$row,$url,$data['page'],5,2);
		$this->load->view('admin/wechat_autoreply_list',$data);
	}
	//添加自动回复
	function toadd_autoreply(){
		//跳转到列表页面
		$backurl = $this->input->get('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/autoreplylist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/autoreplylist';
		}
		$data['decodebackurl'] = $decodebackurl;
		$data['backurl'] = $backurl;
		//导航栏
		if($this->langtype == '_ch'){
			$wechat_auto_reply_text = '微信自动回复';
		}else{
			$wechat_auto_reply_text = 'Wechat auto reply';
		}
		$data['url'] = '<a href="'.$decodebackurl.'">'.$wechat_auto_reply_text.'</a> &gt; '.lang('cy_add');
	
		$this->load->view('admin/wechat_autoreply_add',$data);
	}
	//添加自动回复 ------- 处理方法
	function add_autoreply(){
        //商品信息
        $autoreply_content = $this->input->post('autoreply_content');
        $autoreply_pic = $this->input->post('autoreply_pic');
        $autoreply_news = $this->input->post('autoreply_news');
        $autoreply_type = $this->input->post('autoreply_type');
        $autoreply_name = $this->input->post('autoreply_name');

        $arr = array('created' => time(), 'edited_author' => $this->admin_username, 'edited' => time());
        //商品信息
        $arr['autoreply_type'] = $autoreply_type;
        $arr['autoreply_pic'] = $autoreply_pic;
        $arr['autoreply_news'] = $autoreply_news;
        $arr['autoreply_content'] = $autoreply_content;
        $arr['autoreply_name'] = $autoreply_name;
        $autoreply_id = $this->WechatModel->add_autoreply($arr);

        //跳转到列表页面
        $backurl = $this->input->post('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/autoreplylist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/autoreplylist';
		}
		echo json_encode(array('backurl'=>$decodebackurl));
	}
	//修改自动回复
	function toedit_autoreply($autoreply_id){
		//跳转到列表页面
		$backurl = $this->input->get('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/autoreplylist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/autoreplylist';
		}
		$data['decodebackurl'] = $decodebackurl;
		$data['backurl'] = $backurl;
		//导航栏
		if($this->langtype == '_ch'){
			$wechat_auto_reply_text = '微信自动回复';
		}else{
			$wechat_auto_reply_text = 'Wechat auto reply';
		}
		$data['url'] = '<a href="'.$decodebackurl.'">'.$wechat_auto_reply_text.'</a> &gt; '.lang('cy_edit');
	
		$data['autoreplyinfo']=$this->WechatModel->getautoreplyinfo($autoreply_id);
		$this->load->view('admin/wechat_autoreply_edit',$data);
	}
	//修改自动回复 ------- 处理方法
	function edit_autoreply($autoreply_id)
    {
        //商品信息
        $autoreply_content = $this->input->post('autoreply_content');
        $autoreply_pic = $this->input->post('autoreply_pic');
        $autoreply_news = $this->input->post('autoreply_news');
        $autoreply_type = $this->input->post('autoreply_type');
        $autoreply_name = $this->input->post('autoreply_name');

        $arr = array('edited_author' => $this->admin_username, 'edited' => time());
        //商品信息
        $arr['autoreply_type'] = $autoreply_type;
        $arr['autoreply_pic'] = $autoreply_pic;
        $arr['autoreply_news'] = $autoreply_news;
        $arr['autoreply_content'] = $autoreply_content;
        if ($autoreply_id != 1) {
            $arr['autoreply_name'] = $autoreply_name;
        }
        $this->WechatModel->edit_autoreply($autoreply_id, $arr);
	
		//跳转到列表页面
		$backurl = $this->input->post('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/autoreplylist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/autoreplylist';
		}
		echo json_encode(array('backurl'=>$decodebackurl));
	}
	//删除自动回复
	function del_autoreply($autoreply_id){
		$this->WechatModel->del_autoreply($autoreply_id);
	}
	
	
	//获取更多的微信图片素材
	function togetmorewechatpicture($autoreply_id, $row){
		$ACC_TOKEN = $this->JssdkModel->getAccessToken ();
			
		$url = "https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=".$ACC_TOKEN;
		$post_data = '{
		    "type":"image",
		    "offset":'.$row.',
		    "count":20
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
		$output = json_decode($output);
		$data['picture_totalcount'] = $output->total_count;//素材总数
		$data['output'] = $output->item;
		$data['autoreplyinfo']=$this->WechatModel->getautoreplyinfo($autoreply_id);
		$this->load->view('admin/wechat_autoreply_morepicture', $data);
	}
	function togetmorewechatnews($autoreply_id, $row){
		$ACC_TOKEN = $this->JssdkModel->getAccessToken ();
					
		$url = "https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=".$ACC_TOKEN;
		$post_data = '{
		    "type":"news",
		    "offset":'.$row.',
		    "count":10
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
		$output = json_decode($output);
		$data['news'] = $output->item;
		$data['news_totalcount'] = $output->total_count;//素材总数
		$data['autoreplyinfo'] = $this->WechatModel->getautoreplyinfo($autoreply_id);
		$this->load->view('admin/wechat_autoreply_morenews', $data);
	}
	
	function menulist(){
		$this->session->set_userdata('menu','wechatmenu');
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
		$data['menulist'] = $this->WechatModel->getwechatmenulist($con);
		$data['count'] = $this->WechatModel->getwechatmenulist($con,1);
		$url = base_url().'index.php/admins/wechat/menulist?keyword='.$keyword;
		$data['fy'] = fy_backend($data['count'],$row,$url,$data['page'],5,2);
		$this->load->view('admin/wechat_menu_list',$data);
	}
	
	//修改微信菜单
	function toedit_wechatmenu($wechatmenu_id){
		//跳转到列表页面
		$backurl = $this->input->get('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/menulist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/menulist';
		}
		$data['decodebackurl'] = $decodebackurl;
		$data['backurl'] = $backurl;
		//导航栏
		if($this->langtype == '_ch'){
			$wechat_auto_reply_text = '微信菜单';
		}else{
			$wechat_auto_reply_text = 'Wechat Menu';
		}
		$data['url'] = '<a href="'.$decodebackurl.'">'.$wechat_auto_reply_text.'</a> &gt; '.lang('cy_edit');
	
		$data['wechatmenuinfo']=$this->WechatModel->getwechatmenuinfo($wechatmenu_id);
		$this->load->view('admin/wechat_menu_edit',$data);
	}
	//修改微信菜单 ------- 处理方法
	function edit_wechatmenu($wechatmenu_id)
    {
        //商品信息
        $wechatmenu_content = $this->input->post('wechatmenu_content');
        $wechatmenu_pic = $this->input->post('wechatmenu_pic');
        $wechatmenu_news = $this->input->post('wechatmenu_news');
        $wechatmenu_type = $this->input->post('wechatmenu_type');
        $wechatmenu_name = $this->input->post('wechatmenu_name');
        $wechatmenu_url = $this->input->post('wechatmenu_url');
        $status = $this->input->post('status');

        $arr = array('edited_author' => $this->admin_username, 'edited' => time());
        //商品信息
        $arr['wechatmenu_type'] = $wechatmenu_type;
        $arr['wechatmenu_pic'] = $wechatmenu_pic;
        $arr['wechatmenu_news'] = $wechatmenu_news;
        $arr['wechatmenu_content'] = $wechatmenu_content;
        $arr['wechatmenu_name'] = $wechatmenu_name;
        $arr['wechatmenu_url'] = $wechatmenu_url;
        $arr['status'] = $status;
        $this->WechatModel->edit_wechatmenu($wechatmenu_id, $arr);

		//跳转到列表页面
		$backurl = $this->input->post('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/product/menulist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/product/menulist';
		}
		echo json_encode(array('backurl'=>$decodebackurl));
	}
	
	function togetmorewechatnews_wechatmenu($wechatmenu_id, $row){
		$ACC_TOKEN = $this->JssdkModel->getAccessToken ();
			
		$url = "https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=".$ACC_TOKEN;
		$post_data = '{
		    "type":"news",
		    "offset":'.$row.',
		    "count":10
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
		$output = json_decode($output);
		$data['news'] = $output->item;
		$data['news_totalcount'] = $output->total_count;//素材总数
		$data['wechatmenuinfo'] = $this->WechatModel->getwechatmenuinfo($wechatmenu_id);
		$this->load->view('admin/wechat_menu_morenews', $data);
	}
	//获取更多的微信图片素材
	function togetmorewechatpicture_wechatmenu($wechatmenu_id, $row){
		$ACC_TOKEN = $this->JssdkModel->getAccessToken ();
			
		$url = "https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=".$ACC_TOKEN;
		$post_data = '{
		    "type":"image",
		    "offset":'.$row.',
		    "count":20
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
		$output = json_decode($output);
		$data['picture_totalcount'] = $output->total_count;//素材总数
		$data['output'] = $output->item;
		$data['wechatmenuinfo']=$this->WechatModel->getwechatmenuinfo($wechatmenu_id);
		$this->load->view('admin/wechat_menu_morepicture', $data);
	}
	
	
	
	
	
}