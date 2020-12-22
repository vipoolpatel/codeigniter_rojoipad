<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {
	
	function __construct(){
		parent::__construct();
	}
	//调用示例: http://www.rjclothing.cn/rojoipad/index.php/api/product/getcategorylist?partner_id=9153664774858319&partner_key=bBKJeYBcQRCM2QtPf2pat0999QTDganW&uid=1&randkey=oQqoHfEgrF0I9MTfgg4G1I82HDDk1Egf&lang=en&version=iOS_v_1.6.5
	//Author: gksel
	//Date: 2015-08-20
	function getcategorylist(){
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

	
		$sql = "SELECT * FROM ".DB_PRE()."category_list WHERE parent = 3 AND status = 1 ORDER BY sort ASC";
		$categorylist = $this->db->query($sql)->result_array();
		
		//正常返回数据(json)
		$newre = array();
		if(!empty($categorylist)){
			for ($i = 0; $i < count($categorylist); $i++) {
				$thisarr = array();
				$thisarr['category_id'] = $categorylist[$i]['category_id'];
				$thisarr['category_name_en'] = $categorylist[$i]['category_name_en'];
				$thisarr['category_name_ch'] = $categorylist[$i]['category_name_ch'];
				
				$newre[] = $thisarr;
			}
		}
		$rearr = array('status'=>'1', 'statusmsg'=>'success', 'data'=>$newre);
		echo json_encode($rearr);
	}
	
	//调用示例: http://www.rjclothing.cn/rojoipad/index.php/api/product/getcategory_designlist?partner_id=9153664774858319&partner_key=bBKJeYBcQRCM2QtPf2pat0999QTDganW&uid=1&randkey=oQqoHfEgrF0I9MTfgg4G1I82HDDk1Egf&category_id=16&lang=en&version=iOS_v_1.6.5
	//Author: gksel
	//Date: 2015-08-20
	function getcategory_designlist(){
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
		
		$category_id = $this->input->get('category_id');
	
		// 接受参数-- END
	
		$con=array('partner_id'=>$partner_id,'partner_key'=>$partner_key);
		$this->ApiModel->checknormalaction($con);
			
		if ($uid == '' || $randkey == '' || $category_id == '' || $lang == '' || $version == '') {
			//参数错误--缺少必要的参数
			$rearr=array('status'=>'103','statusmsg'=>'parameter error');
			echo json_encode($rearr);
			exit; return ;//终止
		}
	
		if(!is_numeric($uid) || $uid <= 0 || !is_numeric($category_id) || $category_id <= 0){
			//参数错误--$uid, $category_id 必须为:正整数
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

		$sql = "SELECT * FROM ".DB_PRE()."category_list WHERE category_id = ".$category_id;
		$categoryinfo = $this->db->query($sql)->row_array();
		if(empty($categoryinfo)){
			//category不存在!
			$rearr=array('status'=>'107','statusmsg'=>'category not exists');
			echo json_encode($rearr);
			exit; return ;//终止
		}
	
	
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
				$thisarr['design_info'] = $designlist[$i]['design_info'];
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
						$sublist[$j]['design_info'] = $sublist_get[$j]['design_info'];
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
								$thirdlist[$k]['design_info'] = $thirdlist_get[$k]['design_info'];
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
		$rearr = array('status'=>'1', 'statusmsg'=>'success', 'data'=>$newre);
		echo json_encode($rearr);
	}
    //调用示例: http://www.rjclothing.cn/rojoipad/index.php/api/product/getselection_ja_garment?partner_id=9153664774858319&partner_key=bBKJeYBcQRCM2QtPf2pat0999QTDganW&lang=en&version=iOS_v_1.6.5
    //Author: gksel
    //Date: 2015-08-20
    function getselection_ja_garment(){
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

        // 接受参数-- END

        $con=array('partner_id'=>$partner_id,'partner_key'=>$partner_key);
        $this->ApiModel->checknormalaction($con);

        if ($lang == '' || $version == '') {
            //参数错误--缺少必要的参数
            $rearr=array('status'=>'103','statusmsg'=>'parameter error');
            echo json_encode($rearr);
            exit; return ;//终止
        }

        $sql = "SELECT * FROM " . DB_PRE() . "cms_list WHERE parent = 61 AND status = 1 ORDER BY cms_id ASC";
        $cmslist = $this->db->query($sql)->result_array();

        //正常返回数据(json)
        $newre = array();
        if(!empty($cmslist)){
            for ($i = 0; $i < count($cmslist); $i++) {
                $thisarr = array();
                $thisarr['cms_id'] = $cmslist[$i]['cms_id'];
                $thisarr['cms_name_en'] = $cmslist[$i]['cms_name_en'];
                $thisarr['cms_name_ch'] = $cmslist[$i]['cms_name_ch'];
                $newre[] = $thisarr;
            }
        }
        $rearr = array('status'=>'1', 'statusmsg'=>'success', 'data'=>$newre);
        echo json_encode($rearr);
    }
	//调用示例: http://www.rjclothing.cn/rojoipad/index.php/api/product/getselection_sh_garment?partner_id=9153664774858319&partner_key=bBKJeYBcQRCM2QtPf2pat0999QTDganW&lang=en&version=iOS_v_1.6.5
	//Author: gksel
	//Date: 2015-08-20
	function getselection_sh_garment(){
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
	
		// 接受参数-- END

        $con = array('partner_id' => $partner_id, 'partner_key' => $partner_key);
        $this->ApiModel->checknormalaction($con);

        if ($lang == '' || $version == '') {
            //参数错误--缺少必要的参数
            $rearr = array('status' => '103', 'statusmsg' => 'parameter error');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

        $sql = "SELECT * FROM " . DB_PRE() . "cms_list WHERE parent = 69 AND status = 1 ORDER BY cms_id ASC";
        $cmslist = $this->db->query($sql)->result_array();

        //正常返回数据(json)
        $newre = array();
        if (!empty($cmslist)) {
            for ($i = 0; $i < count($cmslist); $i++) {
                $thisarr = array();
                $thisarr['cms_id'] = $cmslist[$i]['cms_id'];
                $thisarr['cms_name_en'] = $cmslist[$i]['cms_name_en'];
                $thisarr['cms_name_ch'] = $cmslist[$i]['cms_name_ch'];
				$newre[] = $thisarr;
			}
		}
		$rearr = array('status'=>'1', 'statusmsg'=>'success', 'data'=>$newre);
		echo json_encode($rearr);
	}
	//调用示例: http://www.rjclothing.cn/rojoipad/index.php/api/product/getselection_wc_garment?partner_id=9153664774858319&partner_key=bBKJeYBcQRCM2QtPf2pat0999QTDganW&lang=en&version=iOS_v_1.6.5
	//Author: gksel
	//Date: 2015-08-20
	function getselection_wc_garment(){
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
	
		// 接受参数-- END

        $con = array('partner_id' => $partner_id, 'partner_key' => $partner_key);
        $this->ApiModel->checknormalaction($con);

        if ($lang == '' || $version == '') {
            //参数错误--缺少必要的参数
            $rearr = array('status' => '103', 'statusmsg' => 'parameter error');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

        $sql = "SELECT * FROM " . DB_PRE() . "cms_list WHERE parent = 74 AND status = 1 ORDER BY cms_id ASC";
        $cmslist = $this->db->query($sql)->result_array();

        //正常返回数据(json)
        $newre = array();
        if (!empty($cmslist)) {
            for ($i = 0; $i < count($cmslist); $i++) {
                $thisarr = array();
                $thisarr['cms_id'] = $cmslist[$i]['cms_id'];
                $thisarr['cms_name_en'] = $cmslist[$i]['cms_name_en'];
                $thisarr['cms_name_ch'] = $cmslist[$i]['cms_name_ch'];
				$newre[] = $thisarr;
			}
		}
		$rearr = array('status'=>'1', 'statusmsg'=>'success', 'data'=>$newre);
		echo json_encode($rearr);
	}
	//调用示例: http://www.rjclothing.cn/rojoipad/index.php/api/product/getselection_tr_garment?partner_id=9153664774858319&partner_key=bBKJeYBcQRCM2QtPf2pat0999QTDganW&lang=en&version=iOS_v_1.6.5
	//Author: gksel
	//Date: 2015-08-20
	function getselection_tr_garment(){
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
	
		// 接受参数-- END

        $con = array('partner_id' => $partner_id, 'partner_key' => $partner_key);
        $this->ApiModel->checknormalaction($con);

        if ($lang == '' || $version == '') {
            //参数错误--缺少必要的参数
            $rearr = array('status' => '103', 'statusmsg' => 'parameter error');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

        $sql = "SELECT * FROM " . DB_PRE() . "cms_list WHERE parent = 78 AND status = 1 ORDER BY cms_id ASC";
        $cmslist = $this->db->query($sql)->result_array();

        //正常返回数据(json)
        $newre = array();
        if (!empty($cmslist)) {
            for ($i = 0; $i < count($cmslist); $i++) {
                $thisarr = array();
                $thisarr['cms_id'] = $cmslist[$i]['cms_id'];
                $thisarr['cms_name_en'] = $cmslist[$i]['cms_name_en'];
                $thisarr['cms_name_ch'] = $cmslist[$i]['cms_name_ch'];
				$newre[] = $thisarr;
			}
		}
		$rearr = array('status'=>'1', 'statusmsg'=>'success', 'data'=>$newre);
		echo json_encode($rearr);
	}
	//API LINK: http://www.rjclothing.cn/rojoipad/index.php/api/product/getselection_ft_garment?partner_id=9153664774858319&partner_key=bBKJeYBcQRCM2QtPf2pat0999QTDganW&lang=en&version=iOS_v_1.6.5
	//Author: Jcares
	//Date: 2020-07-14
	function getselection_ft_garment(){
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
	
		// 接受参数-- END

        $con = array('partner_id' => $partner_id, 'partner_key' => $partner_key);
        $this->ApiModel->checknormalaction($con);

        if ($lang == '' || $version == '') {
            //参数错误--缺少必要的参数
            $rearr = array('status' => '103', 'statusmsg' => 'parameter error');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

        $sql = "SELECT * FROM " . DB_PRE() . "cms_list WHERE parent = 78 AND status = 1 ORDER BY cms_id ASC";
        $cmslist = $this->db->query($sql)->result_array();

        //正常返回数据(json)
        $newre = array();
        if (!empty($cmslist)) {
            for ($i = 0; $i < count($cmslist); $i++) {
                $thisarr = array();
                $thisarr['cms_id'] = $cmslist[$i]['cms_id'];
                $thisarr['cms_name_en'] = $cmslist[$i]['cms_name_en'];
                $thisarr['cms_name_ch'] = $cmslist[$i]['cms_name_ch'];
				$newre[] = $thisarr;
			}
		}
		$rearr = array('status'=>'1', 'statusmsg'=>'success', 'data'=>$newre);
		echo json_encode($rearr);
	}
	//API LINK : http://www.rjclothing.cn/rojoipad/index.php/api/product/getselection_st_garment?partner_id=9153664774858319&partner_key=bBKJeYBcQRCM2QtPf2pat0999QTDganW&lang=en&version=iOS_v_1.6.5
	//Author: Jcares
	//Date: 2020-07-14
	function getselection_st_garment(){
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
	
		// 接受参数-- END

        $con = array('partner_id' => $partner_id, 'partner_key' => $partner_key);
        $this->ApiModel->checknormalaction($con);

        if ($lang == '' || $version == '') {
            //参数错误--缺少必要的参数
            $rearr = array('status' => '103', 'statusmsg' => 'parameter error');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

        $sql = "SELECT * FROM " . DB_PRE() . "cms_list WHERE parent = 78 AND status = 1 ORDER BY cms_id ASC";
        $cmslist = $this->db->query($sql)->result_array();

        //正常返回数据(json)
        $newre = array();
        if (!empty($cmslist)) {
            for ($i = 0; $i < count($cmslist); $i++) {
                $thisarr = array();
                $thisarr['cms_id'] = $cmslist[$i]['cms_id'];
                $thisarr['cms_name_en'] = $cmslist[$i]['cms_name_en'];
                $thisarr['cms_name_ch'] = $cmslist[$i]['cms_name_ch'];
				$newre[] = $thisarr;
			}
		}
		$rearr = array('status'=>'1', 'statusmsg'=>'success', 'data'=>$newre);
		echo json_encode($rearr);
	}
	//API LINK: http://www.rjclothing.cn/rojoipad/index.php/api/product/getselection_ct_garment?partner_id=9153664774858319&partner_key=bBKJeYBcQRCM2QtPf2pat0999QTDganW&lang=en&version=iOS_v_1.6.5
	//Author: Jcares
	//Date: 2020-07-14
	function getselection_ct_garment(){
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
	
		// 接受参数-- END

        $con = array('partner_id' => $partner_id, 'partner_key' => $partner_key);
        $this->ApiModel->checknormalaction($con);

        if ($lang == '' || $version == '') {
            //参数错误--缺少必要的参数
            $rearr = array('status' => '103', 'statusmsg' => 'parameter error');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

        $sql = "SELECT * FROM " . DB_PRE() . "cms_list WHERE parent = 78 AND status = 1 ORDER BY cms_id ASC";
        $cmslist = $this->db->query($sql)->result_array();

        //正常返回数据(json)
        $newre = array();
        if (!empty($cmslist)) {
            for ($i = 0; $i < count($cmslist); $i++) {
                $thisarr = array();
                $thisarr['cms_id'] = $cmslist[$i]['cms_id'];
                $thisarr['cms_name_en'] = $cmslist[$i]['cms_name_en'];
                $thisarr['cms_name_ch'] = $cmslist[$i]['cms_name_ch'];
				$newre[] = $thisarr;
			}
		}
		$rearr = array('status'=>'1', 'statusmsg'=>'success', 'data'=>$newre);
		echo json_encode($rearr);
	}
	//API LINK: http://www.rjclothing.cn/rojoipad/index.php/api/product/getselection_fot_garment?partner_id=9153664774858319&partner_key=bBKJeYBcQRCM2QtPf2pat0999QTDganW&lang=en&version=iOS_v_1.6.5
	//Author: Jcares
	//Date: 2020-07-14
	function getselection_fot_garment(){
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
	
		// 接受参数-- END

        $con = array('partner_id' => $partner_id, 'partner_key' => $partner_key);
        $this->ApiModel->checknormalaction($con);

        if ($lang == '' || $version == '') {
            //参数错误--缺少必要的参数
            $rearr = array('status' => '103', 'statusmsg' => 'parameter error');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

        $sql = "SELECT * FROM " . DB_PRE() . "cms_list WHERE parent = 78 AND status = 1 ORDER BY cms_id ASC";
        $cmslist = $this->db->query($sql)->result_array();

        //正常返回数据(json)
        $newre = array();
        if (!empty($cmslist)) {
            for ($i = 0; $i < count($cmslist); $i++) {
                $thisarr = array();
                $thisarr['cms_id'] = $cmslist[$i]['cms_id'];
                $thisarr['cms_name_en'] = $cmslist[$i]['cms_name_en'];
                $thisarr['cms_name_ch'] = $cmslist[$i]['cms_name_ch'];
				$newre[] = $thisarr;
			}
		}
		$rearr = array('status'=>'1', 'statusmsg'=>'success', 'data'=>$newre);
		echo json_encode($rearr);
	}
	
	//调用示例: http://www.rjclothing.cn/rojoipad/index.php/api/product/getselection_selection?partner_id=9153664774858319&partner_key=bBKJeYBcQRCM2QtPf2pat0999QTDganW&lang=en&version=iOS_v_1.6.5
	//Author: gksel
	//Date: 2015-08-20
	function getselection_selection(){
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
	
		// 接受参数-- END

        $con = array('partner_id' => $partner_id, 'partner_key' => $partner_key);
        $this->ApiModel->checknormalaction($con);

        if ($lang == '' || $version == '') {
            //参数错误--缺少必要的参数
            $rearr = array('status' => '103', 'statusmsg' => 'parameter error');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

        $sql = "SELECT * FROM " . DB_PRE() . "cms_list WHERE parent = 54 AND status = 1 ORDER BY cms_id ASC";
        $cmslist = $this->db->query($sql)->result_array();

        //正常返回数据(json)
        $newre = array();
        if (!empty($cmslist)) {
            for ($i = 0; $i < count($cmslist); $i++) {
                $thisarr = array();
                $thisarr['cms_id'] = $cmslist[$i]['cms_id'];
                $thisarr['cms_name_en'] = $cmslist[$i]['cms_name_en'];
                $thisarr['cms_name_ch'] = $cmslist[$i]['cms_name_ch'];
				$newre[] = $thisarr;
			}
		}
		$rearr = array('status'=>'1', 'statusmsg'=>'success', 'data'=>$newre);
		echo json_encode($rearr);
	}
	
	
}
/* End of file welcome.php */
/* Location: ./application/controllers/api.php */
