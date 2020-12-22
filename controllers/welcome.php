<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct(){
		session_start();
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

	public function index(){
// 		$this->session->set_userdata('menu', 'home');
// 		$data['website_title'] = 'RJ Clothing';
// 		$this->load->view('default/home', $data);

// 		$sql = "SELECT * FROM rojoipad_order_list WHERE (design_data_15 IS NOT NULL OR design_data_16 IS NOT NULL OR design_data_17 IS NOT NULL OR design_data_18 IS NOT NULL OR design_data_19 IS NOT NULL) AND status = 0";
		
// 		$sql = "UPDATE rojoipad_order_list SET status = 3 WHERE (design_data_15 IS NOT NULL OR design_data_16 IS NOT NULL OR design_data_17 IS NOT NULL OR design_data_18 IS NOT NULL OR design_data_19 IS NOT NULL) AND status = 0";
// 		$this->db->query($sql);
// 		echo $sql;exit;
		
// 		$sql = "UPDATE rojoipad_order_list SET status = 3 WHERE (design_data_15 IS NOT NULL OR design_data_16 IS NOT NULL OR design_data_17 IS NOT NULL OR design_data_18 IS NOT NULL OR design_data_19 IS NOT NULL) AND status = 0";
// 		$this->db->query($sql);
// 		echo $sql;exit;
		
		$sql = "
				SELECT a.* 
				
				FROM rojoipad_order_list AS a
				
				LEFT JOIN rojoipad_user_list AS b ON a.client_id = b.uid
				
				WHERE b.parent NOT IN (0) AND a.status = 3
		";
		$result = $this->db->query($sql)->result_array();
		if (!empty($result)) {
			for ($i = 0; $i < count($result); $i++) {
				$this->db->update('rojoipad_user_list', array('register_process'=>3), array('uid'=>$result[$i]['client_id']));
			}
		}
	}
	
	/* 上传附件
	 * */
	function upfile(){
        $pic = $_FILES ['logo'];
        $picname = explode('.', $pic ['name']);
        $pic ['name'] = time() . rand(0, 1000) . '.' . $picname [count($picname) - 1];

        $uploaddir = "upload/";
        if (!is_dir($uploaddir)) {
            mkdir($uploaddir, 0777);
        }
        $path = $uploaddir . $pic ['name'];
        if (file_exists($path)) {
            $path = 'upload/' . '(new)' . $pic ['name'];
        }
        move_uploaded_file($pic ['tmp_name'], $path);
        //添加到临时文件表中
        $this->WelModel->add_file_interim(array('file_path' => $path, 'created' => time()));

        $jsonarr = array('name' => $pic ['name'], 'logo' => $path);
        $jsonarr = json_encode($jsonarr);
        echo $jsonarr;
    }
	
	/* 上传图片
	 * */
	function uplogo($default_width=0,$default_height=0)
    {
        $this->load->library('app');
        $pic = $_FILES ['logo'];
        $picname = explode('.', $pic ['name']);
        $pic ['name'] = time() . rand(0, 1000) . '.' . $picname [count($picname) - 1];

        $uploaddir = "upload/";
        if (!is_dir($uploaddir)) {
            mkdir($uploaddir, 0777);
        }
        $path = $uploaddir . $pic ['name'];
        if (file_exists($path)) {
            $path = 'upload/' . '(new)' . $pic ['name'];
        }
        move_uploaded_file($pic ['tmp_name'], $path);
        if ($default_width > 0 && $default_height > 0) {
            $img_width = getImgWidth($path);/*获取宽度*/
            $img_height = getImgHeight($path);/*获取高度*/
            if ($img_width == $default_width && $img_height == $default_height) {
//				如果上传的图片大小和给定的图片尺寸大小一致则不操作
            } else {
                $this->app->my_image_resize($path, $path, $default_width, $default_height);
            }
        }
        //添加到临时文件表中
        $this->WelModel->add_file_interim(array('file_path' => $path, 'created' => time()));

        $jsonarr = array('name' => $pic ['name'], 'logo' => $path);
        $jsonarr = json_encode($jsonarr);
        echo $jsonarr;
    }
	
	/* 等比例缩放
	 * */
	function uplogo_deng($default_width=0,$default_height=0)
    {
        $this->load->library('app');
        $pic = $_FILES ['logo'];
        $picname = explode('.', $pic ['name']);
        $pic ['name'] = time() . rand(0, 1000) . '.' . $picname [count($picname) - 1];

        $uploaddir = "upload/";
        if (!is_dir($uploaddir)) {
            mkdir($uploaddir, 0777);
        }
        $path = $uploaddir . $pic ['name'];
        if (file_exists($path)) {
            $path = 'upload/' . '(new)' . $pic ['name'];
        }
        move_uploaded_file($pic ['tmp_name'], $path);
        $img_width = getImgWidth($path);/*获取宽度*/
        $img_height = getImgHeight($path);/*获取高度*/
        if ($img_width >= $img_height && $img_width > $default_width) {
            resizeImage($path, $img_width, $img_height, ($default_width / $img_width));//等比例压缩
        } else if ($img_height > $img_width && $img_height > $default_width) {
            resizeImage($path, $img_width, $img_height, ($default_width / $img_height));//等比例压缩
        }
        //添加到临时文件表中
        $this->WelModel->add_file_interim(array('file_path' => $path, 'created' => time()));

        $jsonarr = array('name' => $pic ['name'], 'logo' => $path);
        $jsonarr = json_encode($jsonarr);
        echo $jsonarr;
    }
	/*
	 * 获取地址下拉列表
	 * */
	function getcity($provinceID=0){
		if($this->langtype == '_ch'){
			$city_select_text = '选择城市';
		}else{
			$city_select_text = 'Select City';
		}
		$city = $this->UserModel->getcity($provinceID);
		$citystr = '<option value="0">'.$city_select_text.'</option>';
		if(!empty($city)){
			for($i=0;$i<count($city);$i++){
				$citystr .= '<option value="'.$city[$i]['cityID'].'">'.$city[$i]['city'.$this->langtype].'</option>';
			}
		}
		echo $citystr;
	}
	function getarea($cityID=0){
		$area = $this->UserModel->getarea($cityID);
		if($this->langtype == '_ch'){
			$areastr = '<option value="0">选择区域</option>';
		}else{
			$areastr = '<option value="0">Select Area</option>';
		}
		if(!empty($area)){
			for($i=0;$i<count($area);$i++){
				$areastr .= '<option value="'.$area[$i]['areaID'].'">'.$area[$i]['area'.$this->langtype].'</option>';
			}
		}
		echo $areastr;
	}
	
	function changelanguage($lan, $url){
		$url = str_replace('slash_tag','/', $url);
		$this->session->set_userdata('lang', $lan);
		$redecodeurl = base64_decode($url);
		redirect($redecodeurl);
	}
	/*
	 * 选择日历
	 */
	function calendar_select($year = 0, $month = 0) {
		$id = $this->input->post ( 'id' );
	
		$prefs = array ('show_next_prev' => TRUE,'day_type' => 'lshort' )
		// 'next_prev_url' => 'javascript:;'
		;
	
		$prefs ['template'] = '
	
		   {table_open}<table border="0" cellpadding="0" cellspacing="0" style="float:left;width:calc(100% - 2px);padding:0px;border:1px solid #CCC;text-align:center;-moz-border-radius: 5px;-webkit-border-radius: 5px;background:white;">{/table_open}
	
	
		   {heading_row_start}<tr style="background-color:#999999;">{/heading_row_start}
		   {heading_previous_cell}<th height="50" colspan="2" style="padding:0px;-moz-border-top-left-radius: 4px;-webkit-border-top-left-radius: 4px;"><a href="javascript:;" onclick="togetshiwucalendar_month(\'' . $id . '\',{previous_url})">Prev</a></th>{/heading_previous_cell}
		   {heading_title_cell}<th colspan="3" style="font-size:14px;padding:0px;">{heading}</th>{/heading_title_cell}
		   {heading_next_cell}<th colspan="2" style="padding:0px;-moz-border-top-right-radius: 4px;-webkit-border-top-right-radius: 4px;"><a href="javascript:;" onclick="togetshiwucalendar_month(\'' . $id . '\',{next_url})">Next</a></th>{/heading_next_cell}
		   {heading_row_end}</tr>{/heading_row_end}
	
	
		   {week_row_start}<tr>{/week_row_start}
		   {week_day_cell}<td height="25" style="color:gray;border-bottom:1px solid #CCC;padding:0px;">{week_day}</td>{/week_day_cell}
		   {week_row_end}</tr>{/week_row_end}
	
	
		   {cal_row_start}<tr>{/cal_row_start}
		   {cal_cell_start}<td style="width:' . ((1 / 7) * 100) . '%;padding:0px;"><div style="float:left;text-align:center;width:90%;height:20px;line-height:20px;margin-left:3.5%;margin-top:5px;border:1px solid #EFEFEF;">{/cal_cell_start}
	
		   {cal_cell_content}<a href="{content}" id="shiwu_{day_id}" onclick="togetrilidatatoinput(\'' . $id . '\',{showthings})"><font style="float:left;width:100%;height:20px;line-height:20px;text-align:center;background:{kexuanze_itembox_bg};color:red;font-weight:bold;-moz-border-radius: 3px;-webkit-border-radius: 3px;">{day}</font></a>{/cal_cell_content}
		   {cal_cell_content_today}<a href="{content}" id="shiwu_{day_id}" onclick="togetrilidatatoinput(\'' . $id . '\',{showthings})"><font style="float:left;width:100%;height:20px;line-height:20px;text-align:center;background:{kexuanze_itembox_bg};color:red;-moz-border-radius: 3px;-webkit-border-radius: 3px;">{day}</font></a>{/cal_cell_content_today}
	
		   {cal_cell_no_content}<a href="javascript:;" id="shiwu_{day_id}" onclick="togetrilidatatoinput(\'' . $id . '\',{showthings})"><font style="float:left;width:100%;height:20px;line-height:20px;text-align:center;background:{kexuanze_itembox_bg};color:{kexuanze_itembox_color};-moz-border-radius: 3px;-webkit-border-radius: 3px;">{day}</font></a>{/cal_cell_no_content}
		   {cal_cell_no_content_today}<a href="javascript:;" id="shiwu_{day_id}" onclick="togetrilidatatoinput(\'' . $id . '\',{showthings})"><font style="float:left;width:100%;height:20px;line-height:20px;text-align:center;background:{kexuanze_itembox_bg};color:{kexuanze_itembox_color};-moz-border-radius: 3px;-webkit-border-radius: 3px;">{day}</font></a>{/cal_cell_no_content_today}
	
		   {cal_cell_blank}&nbsp;{/cal_cell_blank}
	
		   {cal_cell_end}</div></td>{/cal_cell_end}
		   {cal_row_end}</tr>{/cal_row_end}
	
		   {table_close}</table>{/table_close}
		';
	
		$this->load->library ( 'calendar', $prefs );
	
		$data = array ();
		$default_val = $this->input->post ( 'default_val' );
		if ($default_val != "") {
			$val_arr = explode ( '-', $default_val );
			if (isset ( $val_arr [0] ) && isset ( $val_arr [1] ) && isset ( $val_arr [2] )) {
				$data [intval ( $val_arr [2] )] = '123';
			}
		}
		
// 		$data = array();
// 		if($year == date('Y') && $month == date('m')){
// 			for($a=0;$a<count($idarr);$a++){
// 				$data[$idarr[$a]]='javascript:;';
// 			}
// 		}
	
		if ($year == 0 && $month == 0) {
			if ($default_val != "") {
				$val_arr = explode ( '-', $default_val );
				if (isset ( $val_arr [0] ) && isset ( $val_arr [1] ) && isset ( $val_arr [2] )) {
					echo $this->calendar->generate ( intval ( $val_arr [0] ), intval ( $val_arr [1] ), $data );
				} else {
					echo $this->calendar->generate ( $year, $month, $data );
				}
			} else {
				echo $this->calendar->generate ( $year, $month, $data );
			}
		} else {
			echo $this->calendar->generate ( $year, $month, $data );
		}
	}

	function tobookyourtailor(){
		$current_shijianduan_id = $this->input->post('current_shijianduan_id');
        $current_shijianduan_num = $this->input->post('current_shijianduan_num');
        $currentshiwudi = $this->input->post('currentshiwudi');

        if (isset ($_COOKIE ['rojoclothinginfo'])) {
            $rojoclothinginfoArr = unserialize($_COOKIE ["rojoclothinginfo"]);
            $uid = $rojoclothinginfoArr ['uid'];
        } else {
            $uid = 0;
        }

        $arr = array('shijian_date' => $currentshiwudi, 'uid' => $uid, 'shijianduan_id' => $current_shijianduan_id, 'shijianduan_num' => $current_shijianduan_num, 'status' => 0, 'created' => time(), 'edited' => time());
        $this->db->insert(DB_PRE() . 'appointment_list', $arr);
    }
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */