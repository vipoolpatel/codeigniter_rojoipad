<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms extends CI_Controller{

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
	//关键字列表
	function keywordlist(){
		$this->session->set_userdata('menu','keyword');
		$con=array('orderby'=>'a.sort','orderby_res'=>'ASC');
		$data['keywordlist']=$this->CmsModel->getkeywordlist($con);
		$this->load->view('admin/cms_keyword_list',$data);
	}
	//关键字列表 -- 排序功能
	function editkeyword_sort(){
		$idarr=$this->input->post('idarr');
		$newsrot=$this->input->post('newsrot');
		if(!empty($idarr)){
			for($i=0;$i<count($idarr);$i++){
				$arr = array('sort'=>$newsrot[$i]);
				$this->CmsModel->edit_keyword($idarr[$i], $arr);
			}
		}
	}
	//添加关键字
	function toadd_keyword(){
		//跳转到列表页面
		$backurl = base64_encode(base_url().'index.php/admins/cms/keywordlist');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/cms/keywordlist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/cms/keywordlist';
		}
		$data['decodebackurl'] = $decodebackurl;
		$data['backurl'] = $backurl;
		//导航栏
		$data['url'] = '<a href="'.$decodebackurl.'">'.lang('cy_keyword_manage').'</a> &gt; '.lang('cy_keyword_add');
	
		$this->load->view('admin/cms_keyword_add',$data);
	}
	//添加关键字 ------- 处理方法
	function add_keyword(){
        //关键字信息
        $keyword_name_en = $this->input->post('keyword_name_en');//关键字名称
        $keyword_name_ch = $this->input->post('keyword_name_ch');//关键字名称

        $arr = array('edited_author' => $this->admin_username, 'created' => time(), 'edited' => time());
        //文章分类信息
        $arr['keyword_name_en'] = $keyword_name_en;
        $arr['keyword_name_ch'] = $keyword_name_ch;
        $keyword_id = $this->CmsModel->add_keyword($arr);

        //跳转到列表页面
        $backurl = $this->input->post('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/cms/keywordlist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/cms/keywordlist';
		}
		echo json_encode(array('backurl'=>$decodebackurl));
	}
	//添加关键字 ------- 处理方法ajax
	function add_keyword_ajax()
    {
        //关键字信息
        $keyword_name_en = $this->input->post('keyword_name_en');//关键字名称
        $keyword_name_ch = $this->input->post('keyword_name_ch');//关键字名称

        $arr = array('edited_author' => $this->admin_username, 'created' => time(), 'edited' => time());
        //文章分类信息
        $arr['keyword_name_en'] = $keyword_name_en;
        $arr['keyword_name_ch'] = $keyword_name_ch;
        $keyword_id = $this->CmsModel->add_keyword($arr);
        echo json_encode(array('keyword_id' => $keyword_id, 'keyword_name_en' => $keyword_name_en, 'keyword_name_ch' => $keyword_name_ch));
    }
	//修改关键字
	function toedit_keyword($keyword_id){
		//跳转到列表页面
		$backurl = $this->input->get('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/cms/keywordlist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/cms/keywordlist';
		}
		$data['decodebackurl'] = $decodebackurl;
		$data['backurl'] = $backurl;
		//导航栏
		$data['url'] = '<a href="'.$decodebackurl.'">'.lang('cy_keyword_manage').'</a> &gt; '.lang('cy_keyword_edit');
	
		$data['keywordinfo']=$this->CmsModel->getkeywordinfo($keyword_id);
		$this->load->view('admin/cms_keyword_edit',$data);
	}
	//修改关键字 ------- 处理方法
	function edit_keyword($keyword_id)
    {
        //关键字信息
        $keyword_name_en = $this->input->post('keyword_name_en');//关键字名称
        $keyword_name_ch = $this->input->post('keyword_name_ch');//关键字名称

        $arr = array('edited_author' => $this->admin_username, 'edited' => time());
        //关键字信息
        $arr['keyword_name_en'] = $keyword_name_en;
        $arr['keyword_name_ch'] = $keyword_name_ch;
        $this->CmsModel->edit_keyword($keyword_id, $arr);

        //跳转到列表页面
        $backurl = $this->input->post('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/cms/keywordlist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/cms/keywordlist';
		}
		echo json_encode(array('backurl'=>$decodebackurl));
	}
	//删除关键字
	function del_keyword($keyword_id){
		$this->CmsModel->del_keyword($keyword_id);
	}
	
	
	
	//cms列表
	function cmslist(){
		$this->session->set_userdata('menu','cms');
		$row=$this->input->get('row');
		if($row==""){$row=0;}
		$page = 50;
		$data['row']=$row;
		$data['page']=$page;
	
		$keyword = $this->input->get('keyword');
		$con=array('parent'=>0,'orderby'=>'a.cms_id','orderby_res'=>'ASC','row'=>$row,'page'=>$data['page']);
		if($keyword!=""){
			$con['keyword'] = $keyword;
		}
		$data['cmslist']=$this->CmsModel->getcmslist($con);
		$data['count']=$this->CmsModel->getcmslist($con,1);
		$url = base_url().'index.php/admins/cms/cmslist?keyword='.$keyword.'&page='.$page;
		$data['fy'] = fy_backend($data['count'],$row,$url,$data['page'],5,2);
		$this->load->view('admin/cms_list',$data);
	}
	
	//添加cms
	function toadd_cms(){
		//跳转到列表页面
             $parentid = end($this->uri->segment_array());
                        
		$backurl = base64_encode(base_url().'index.php/admins/cms/cmslist');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/cms/cmslist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/cms/cmslist';
		}
		$data['decodebackurl'] = $decodebackurl;
		$data['backurl'] = $backurl;
                $data['parentid'] = $parentid;
		//导航栏
		$data['url'] = '<a href="'.$decodebackurl.'">'.lang('cy_commoncontent_manage').'</a> &gt; '.lang('cy_commoncontent_add');
	
		$this->load->view('admin/cms_add',$data);
	}
	//添加cms ------- 处理方法
	function add_cms($parentid){
            //echo $parentid;exit;
		$lancodelist = getlancodelist();//多语言
		$postOBJ = $this->input->post('GETOBJ');
		$postOBJ_type = $this->input->post('GETOBJ_type');
		$postLANGOBJ = $this->input->post('GETLANGOBJ');
		$postLANGOBJ_type = $this->input->post('GETLANGOBJ_type');
		//获取内容
		if (!empty($postOBJ)) {
			for ($p = 0; $p < count($postOBJ); $p++) {
				${$postOBJ[$p]} = $this->input->post($postOBJ[$p]);
				if($postOBJ_type[$p] == 'ckeditor'){
					${$postOBJ[$p]} = str_replace("{sign_douhao}", "'", ${$postOBJ[$p]});
					${$postOBJ[$p]} = str_replace("<br />", "\n", ${$postOBJ[$p]});
					${$postOBJ[$p]} = str_replace(base_url(), "{base_url}", ${$postOBJ[$p]});
					
					${$postOBJ[$p]} = str_replace("/(width:(\s)*(\d){1,3}(%|(px));(\s)height:(\s)*(\d){1,3}(%|(px));)/", "max-width:100%;", ${$postOBJ[$p]});
				}else{
					${$postOBJ[$p]} = replace_content(defaultreparr(), ${$postOBJ[$p]});
				}
			}
		}
		if (!empty($postLANGOBJ)) {
			for ($lc = 0; $lc < count($lancodelist); $lc++) {
				for ($p = 0; $p < count($postLANGOBJ); $p++) {
					${$postLANGOBJ[$p].$lancodelist[$lc]['langtype']} = $this->input->post($postLANGOBJ[$p].$lancodelist[$lc]['langtype']);//产品名称
					if($postLANGOBJ_type[$p] == 'ckeditor'){
						${$postLANGOBJ[$p].$lancodelist[$lc]['langtype']} = str_replace("{sign_douhao}", "'", ${$postLANGOBJ[$p].$lancodelist[$lc]['langtype']});
                        ${$postLANGOBJ[$p] . $lancodelist[$lc]['langtype']} = str_replace("<br />", "\n", ${$postLANGOBJ[$p] . $lancodelist[$lc]['langtype']});
                        ${$postLANGOBJ[$p] . $lancodelist[$lc]['langtype']} = str_replace(base_url(), "{base_url}", ${$postLANGOBJ[$p] . $lancodelist[$lc]['langtype']});

                        ${$postLANGOBJ[$p] . $lancodelist[$lc]['langtype']} = str_replace("/(width:(\s)*(\d){1,3}(%|(px));(\s)height:(\s)*(\d){1,3}(%|(px));)/", "max-width:100%;", ${$postLANGOBJ[$p] . $lancodelist[$lc]['langtype']});
                    } else {
                        ${$postLANGOBJ[$p] . $lancodelist[$lc]['langtype']} = replace_content(defaultreparr(), ${$postLANGOBJ[$p] . $lancodelist[$lc]['langtype']});
                    }
                }
            }
        }
        $arr = array('created' => time(), 'edited_author' => $this->admin_username, 'edited' => time());
        //处理内容到数据库
        if (!empty($postOBJ)) {
            for ($p = 0; $p < count($postOBJ); $p++) {
                $arr[$postOBJ[$p]] = ${$postOBJ[$p]};
            }
        }
        if (!empty($postLANGOBJ)) {
            for ($lc = 0; $lc < count($lancodelist); $lc++) {
                for ($p = 0; $p < count($postLANGOBJ); $p++) {
                    $arr[$postLANGOBJ[$p] . $lancodelist[$lc]['langtype']] = ${$postLANGOBJ[$p] . $lancodelist[$lc]['langtype']};
				}
			}
		}
                
		$cms_id = $this->CmsModel->add_cms($arr,$parentid);
	
		//跳转到列表页面
		$backurl = $this->input->post('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/cms/cmslist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/cms/cmslist';
		}
		echo json_encode(array('backurl'=>$decodebackurl));
	}
	
	//修改cms
	function toedit_cms($cms_id){
		//跳转到列表页面
		$backurl = $this->input->get('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/cms/cmslist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/cms/cmslist';
		}
		$data['decodebackurl'] = $decodebackurl;
		$data['backurl'] = $backurl;
		//导航栏
		$data['url'] = '<a href="'.$decodebackurl.'">'.lang('cy_commoncontent_manage').'</a> &gt; '.lang('cy_commoncontent_edit');
	
		$data['cmsinfo']=$this->CmsModel->getcmsinfo($cms_id);
		$this->load->view('admin/cms_edit',$data);
	}
	//修改cms ------- 处理方法
	function edit_cms($cms_id){
		$lancodelist = getlancodelist();//多语言
		$postOBJ = $this->input->post('GETOBJ');
		$postOBJ_type = $this->input->post('GETOBJ_type');
		$postLANGOBJ = $this->input->post('GETLANGOBJ');
		$postLANGOBJ_type = $this->input->post('GETLANGOBJ_type');
		//获取内容
		if (!empty($postOBJ)) {
			for ($p = 0; $p < count($postOBJ); $p++) {
				${$postOBJ[$p]} = $this->input->post($postOBJ[$p]);
				if($postOBJ_type[$p] == 'ckeditor'){
					${$postOBJ[$p]} = str_replace("{sign_douhao}", "'", ${$postOBJ[$p]});
					${$postOBJ[$p]} = str_replace("<br />", "\n", ${$postOBJ[$p]});
					${$postOBJ[$p]} = str_replace(base_url(), "{base_url}", ${$postOBJ[$p]});
					
					${$postOBJ[$p]} = str_replace("/(width:(\s)*(\d){1,3}(%|(px));(\s)height:(\s)*(\d){1,3}(%|(px));)/", "max-width:100%;", ${$postOBJ[$p]});
				}else{
					${$postOBJ[$p]} = replace_content(defaultreparr(), ${$postOBJ[$p]});
				}
			}
		}
		if (!empty($postLANGOBJ)) {
			for ($lc = 0; $lc < count($lancodelist); $lc++) {
				for ($p = 0; $p < count($postLANGOBJ); $p++) {
					${$postLANGOBJ[$p].$lancodelist[$lc]['langtype']} = $this->input->post($postLANGOBJ[$p].$lancodelist[$lc]['langtype']);//产品名称
					if($postLANGOBJ_type[$p] == 'ckeditor'){
						${$postLANGOBJ[$p].$lancodelist[$lc]['langtype']} = str_replace("{sign_douhao}", "'", ${$postLANGOBJ[$p].$lancodelist[$lc]['langtype']});
                        ${$postLANGOBJ[$p] . $lancodelist[$lc]['langtype']} = str_replace("<br />", "\n", ${$postLANGOBJ[$p] . $lancodelist[$lc]['langtype']});
                        ${$postLANGOBJ[$p] . $lancodelist[$lc]['langtype']} = str_replace(base_url(), "{base_url}", ${$postLANGOBJ[$p] . $lancodelist[$lc]['langtype']});

                        ${$postLANGOBJ[$p] . $lancodelist[$lc]['langtype']} = str_replace("/(width:(\s)*(\d){1,3}(%|(px));(\s)height:(\s)*(\d){1,3}(%|(px));)/", "max-width:100%;", ${$postLANGOBJ[$p] . $lancodelist[$lc]['langtype']});
                    } else {
                        ${$postLANGOBJ[$p] . $lancodelist[$lc]['langtype']} = replace_content(defaultreparr(), ${$postLANGOBJ[$p] . $lancodelist[$lc]['langtype']});
                    }
                }
            }
        }
        $arr = array('edited_author' => $this->admin_username, 'edited' => time(), 'status' => $this->input->post('status'));
        //处理内容到数据库
        if (!empty($postOBJ)) {
            for ($p = 0; $p < count($postOBJ); $p++) {
                $arr[$postOBJ[$p]] = ${$postOBJ[$p]};
            }
        }
        if (!empty($postLANGOBJ)) {
            for ($lc = 0; $lc < count($lancodelist); $lc++) {
                for ($p = 0; $p < count($postLANGOBJ); $p++) {
                    $arr[$postLANGOBJ[$p] . $lancodelist[$lc]['langtype']] = ${$postLANGOBJ[$p] . $lancodelist[$lc]['langtype']};
				}
			}
		}
	
		$this->CmsModel->edit_cms($cms_id, $arr);
	
		//跳转到列表页面
		$backurl = $this->input->post('backurl');
		if($backurl!=""){
			$backurl=str_replace('slash_tag','/',$backurl);
			if(base64_decode($backurl)!=""){
				$decodebackurl = base64_decode($backurl);
			}else{
				$decodebackurl = base_url().'index.php/admins/cms/cmslist';
			}
		}else{
			$decodebackurl = base_url().'index.php/admins/cms/cmslist';
		}
		echo json_encode(array('backurl'=>$decodebackurl));
	}
	//删除cms
	function del_cms($cms_id){
		$this->CmsModel->del_cms($cms_id);
	}
	
	
	
	
	
}