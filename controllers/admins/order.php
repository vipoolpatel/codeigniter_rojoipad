<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Order extends CI_Controller {

    function __construct() {

        parent::__construct();

        $ipadapplogin = $this->input->get('ipadapplogin');
        if ($ipadapplogin == 1) {
            $userinfo = array('admin_id' => 1, 'admin_username' => 'admin', 'device' => 'ipad');
            $userjson = serialize($userinfo);
            set_cookie('admin', $userjson, time() + 3600 * 24 * 30); //设置登录的Cookie
        }
        if (isset($_COOKIE['admin'])) {
            $admin = unserialize($_COOKIE['admin']);
            $this->session->set_userdata('isadmin', '1');
            if (isset($admin ['device'])) {
                $this->admin_id = $admin ['admin_id'];
                $this->admin_username = $admin ['admin_username'];
                $this->device = $admin ['device'];
            } else {
                redirect(base_url() . 'index.php/admin');
            }
        } else {
            redirect(base_url() . 'index.php/admin');
        }
        $lang = $this->session->userdata('lang');
        if ($lang == 'ch') {
            $this->session->set_userdata('lang', 'ch');
            $this->langtype = '_ch';
            $this->lang->load('gksel', 'chinese');
        } else {
            $this->session->set_userdata('lang', 'en');
            $this->langtype = '_en';
            $this->lang->load('gksel', 'english');
        }
    }

    //产品列表
    function index() {
        
        $user_id = $this->session->userdata('user_id');
        
        $isadmin = $this->session->userdata('isadmin');
        if ($isadmin == '') {
            $isadmin = 0;
        }
        $row = $this->input->get('row');
        if ($row == "") {
            $row = 0;
        }
        $page = 50;
        $data['row'] = $row;
        $data['page'] = $page;

        $keyword = $this->input->get('keyword');
        $status = $this->input->get('status');
		$user_brandname = urldecode($this->input->get('user_brandname'));
		$this->session->set_userdata('menu', 'order');

        $con = array('statusin' => '4,5', 'orderby' => 'o.order_id', 'orderby_res' => 'DESC', 'row' => $row, 'page' => $data['page'], 'isadmin' => $isadmin);
        if ($keyword != "") {
            $con['keyword'] = $keyword;
        }
        
        $con['uid'] = $user_id;
        
        if($con['uid'] > 0){
            $con['isadmin'] = 0;
        }
		

		
		if ($user_brandname != "") {
            $con['user_brandname'] = $user_brandname;
        }
		
        $data['orderlist'] = $this->OrderModel->getorderlist($con);
        #echo $this->db->last_query(); exit; ## Abhishek
        $data['count'] = $this->OrderModel->getorderlist($con, 1);
		if($user_brandname != ''){
				$url = base_url() . "index.php/admins/order/index?user_brandname=".$user_brandname."&status=" . $status . "&keyword=" . $keyword . "&page=" . $page;
		}else{
			$url = base_url() . "index.php/admins/order/index?status=" . $status . "&keyword=" . $keyword . "&page=" . $page;
		}
        
        $data['fy'] = fy_backend($data['count'], $row, $url, $data['page'], 5, 2);
        
        $data['user_id'] = $user_id;

        $this->load->view('admin/order_list', $data);
    }

    function toview_order($order_id) {
        header("Content-type: text/html; charset=utf-8");

        //跳转到列表页面
        $backurl = $this->input->get('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
                $decodebackurl = base64_decode(str_replace(" ", "+", $backurl));
            } else {
                $decodebackurl = base_url() . 'index.php/admins/order/index';
            }
        } else {
            $decodebackurl = base_url() . 'index.php/admins/order/index';
        }
        $data['decodebackurl'] = $decodebackurl;
        $data['backurl'] = $backurl;
        if ($this->langtype == '_ch') {
            $order_view_text = '查看订单';
        } else {
            $order_view_text = 'View Order';
        }
        //导航栏
        $data['url'] = '<a href="' . $decodebackurl . '">' . lang('dz_orders') . '</a> &gt; ' . $order_view_text;

        $data['orderinformation'] = $this->OrderModel->getorderinfo($order_id);
        $data['userinfo'] = $this->UserModel->getuserinfo($data['orderinformation']['uid']);
        $data['clientinfo'] = $this->UserModel->getuserinfo($data['orderinformation']['client_id']);
        $data['orderimages'] = $this->OrderModel->get_order_images($order_id, $data['userinfo']['uid']);
        $data['ordernotes'] = $this->OrderModel->get_order_notes($order_id, $data['userinfo']['uid']);
        $this->load->view('admin/order_view', $data);
    }

    function print_order($order_id)
    {
        $data['brand'] = "";
        $sql = "SELECT * FROM " . DB_PRE() . "category_list WHERE parent = 3 ORDER BY sort ASC";
        $data['categorylist'] = $this->db->query($sql)->result_array();
        $data['orderinformation'] = $this->OrderModel->getorderinfo($order_id);
        $userinfo = $this->UserModel->getuserinfo($data['orderinformation']['uid']);
        foreach (preg_split("/\s+/", $userinfo['user_brandname']) as $w) {
            $data['brand'] .= $w[0];
        }
        $data['clientinfo'] = $this->UserModel->getuserinfo($data['orderinformation']['client_id']);

        $jacket = $this->db->where(array("type" => "jacket", "sub_type" => "cm", "type_value" => $data['orderinformation']['order_list']['0']['ja_garment']))
            ->get('default_measurement')
            ->row();

        $shirt = $this->db->where(array("type" => "shirt", "sub_type" => "cm", "type_value" => $data['orderinformation']['order_list']['0']['sh_garment']))
            ->get('default_measurement')
            ->row();
        $waistcoat = $this->db->where(array("type" => "waistcoat", "sub_type" => "cm", "type_value" => $data['orderinformation']['order_list']['0']['wc_garment']))
            ->get('default_measurement')
            ->row();

        $trousers = $this->db->where(array("type" => "trousers", "sub_type" => "cm", "type_value" => $data['orderinformation']['order_list']['0']['tr_garment']))
            ->get('default_measurement')
            ->row();

        $measurement_variables = [
            'ja_length', 'ja_shoulders', 'ja_chest', 'ja_chest_f', 'ja_chest_b', 'ja_bust', 'ja_circumference', 'ja_sleeve', 'ja_bicep', 'ja_wrist', 'ja_neck',
            'sh_length', 'sh_shoulders', 'sh_chest', 'sh_chest_f', 'sh_chest_b', 'sh_bust', 'sh_circumference', 'sh_sleeve', 'sh_bicep', 'sh_wrist', 'sh_neck',
            'wc_length', 'wc_shoulders', 'wc_chest', 'wc_chest_f', 'wc_chest_b', 'wc_bust', 'wc_circumference', 'wc_sleeve', 'wc_bicep', 'wc_wrist', 'wc_neck',
            'tr_length', 'tr_waist', 'tr_gluteus', 'tr_thigh', 'tr_crotch_rise', 'tr_crotch_front', 'tr_crotch_back', 'tr_hamstring', 'tr_calf', 'tr_ankle'
        ];

        foreach ($data['orderinformation']['order_list'][0] as $key => $item) {
            if (in_array($key, $measurement_variables)) {
                $cloth = explode('_', $key)[0];
                $cloth == 'ja' ? $cloth = 'jacket' : ($cloth == 'sh' ? $cloth = 'shirt' : ($cloth == 'wc' ? $cloth = 'waistcoat' : ($cloth == 'tr' ? $cloth = 'trousers' : $cloth)));

                $jacket_parts = [
                    'ja_length' => 'length', 'ja_shoulders' => 'shoulders', 'ja_chest' => 'chest', 'ja_chest_f' => 'front_chest', 'ja_chest_b' => 'back_chest', 'ja_bust' => 'bust', 'ja_circumference' => 'hips', 'ja_sleeve' => 'sleeve_length', 'ja_bicep' => 'bicep', 'ja_wrist' => 'wrist_cuff', 'ja_neck' => 'neck_cuff'
                ];
                $shirt_parts = [
                    'sh_length' => 'length', 'sh_shoulders' => 'shoulders', 'sh_chest' => 'chest', 'sh_chest_f' => 'front_chest', 'sh_chest_b' => 'back_chest', 'sh_bust' => 'bust', 'sh_circumference' => 'hips', 'sh_sleeve' => 'sleeve_length', 'sh_bicep' => 'bicep', 'sh_wrist' => 'wrist_cuff', 'sh_neck' => 'neck_cuff'
                ];
                $waistcoat_parts = [
                    'wc_length' => 'length', 'wc_shoulders' => 'shoulders', 'wc_chest' => 'chest', 'wc_chest_f' => 'front_chest', 'wc_chest_b' => 'back_chest', 'wc_bust' => 'bust', 'wc_circumference' => 'hips', 'wc_sleeve' => 'sleeve_length', 'wc_bicep' => 'bicep', 'wc_wrist' => 'wrist_cuff', 'wc_neck' => 'neck_cuff'
                ];
                $trousers_parts = [
                    'tr_length' => 'length', 'tr_waist' => 'waist', 'tr_gluteus' => 'gluteus', 'tr_thigh' => 'thigh', 'tr_crotch_rise' => 'crotch_rise', 'tr_crotch_front' => 'front_crotch', 'tr_crotch_back' => 'back_crotch', 'tr_hamstring' => 'hamstring', 'tr_calf' => 'calf', 'tr_ankle' => 'ankle'
                ];

                if (preg_match("(-|\+)", $item) !== 1 && $item > 0) {
                    $data['orderinformation']['order_list']['0'][$key] = $item;
                } else {
                    $data['orderinformation']['order_list']['0'][$key] = 0;
                    if (isset($$cloth->{${$cloth . '_parts'}[$key]})) {
                        $data['orderinformation']['order_list']['0'][$key] = (($$cloth->{${$cloth . '_parts'}[$key]}) + $item);
                    }
                }
            }
        }

        if (file_exists('upload/qrcode.png')) {
            unlink('upload/qrcode.png');
        }
        $url = (ENVIRONMENT == 'production' ? 'https://www.rjclothing.cn' : 'https://alpha.rjclothing.cn') . "/rojoipadqrcode/index.php/product/infoshengcheng/{$data['orderinformation']['qrcode_product_id']}";
        require_once APPPATH . 'third_party/phpqrcode/qrlib.php';
        QRcode::png($url, 'upload/qrcode.png', 'L', 5, 10);
        $data['image'] = '<img style="margin:0;width:75px;" src="' . base_url('upload/qrcode.png') . '" title="Link to Product" />';
        $data['lang'] = '_ch';
        $ch_html = $this->load->view('admin/order_print', $data, true);
        $data['lang'] = '_en';
        $eng_html = $this->load->view('admin/order_print', $data, true);

        require_once APPPATH . 'third_party/mpdf/mpdf.php';
        $mpdf = new mPDF('+aCJK', [68, 200], 6, 0, 1, 1, 0.5, 0, 0, 0);
        $mpdf->showImageErrors = true;
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;

        $mpdf->WriteHTML($ch_html);
        $mpdf->AddPage();
        $mpdf->WriteHTML($eng_html);
        $filename = "({$data['orderinformation']['newclient_number']}) {$data['clientinfo']['user_realname']}.pdf";
        $mpdf->Output($filename, 'I');
    }

    function toadd_order() {
        header("Content-type: text/html; charset=utf-8");

        //跳转到列表页面
        $backurl = $this->input->get('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
                $decodebackurl = base64_decode(str_replace(" ", "+", $backurl));
            } else {
                $decodebackurl = base_url() . 'index.php/admins/order/index';
            }
        } else {
            $decodebackurl = base_url() . 'index.php/admins/order/index';
        }
        $data['decodebackurl'] = $decodebackurl;
        $data['backurl'] = $backurl;
        if ($this->langtype == '_ch') {
            $order_view_text = '添加订单';
        } else {
            $order_view_text = 'Add Order';
        }
        //导航栏
        $data['url'] = '<a href="' . $decodebackurl . '">' . lang('dz_orders') . '</a> &gt; ' . $order_view_text;


        $this->load->view('admin/order_add', $data);
    }

    //添加订单 ------- 处理方法
    function add_order() {
        $client_realname = $this->input->post('client_realname');
        $client_address = $this->input->post('client_address');
        $client_email = $this->input->post('client_email');
        $client_industry = $this->input->post('client_industry');
        $client_wechat = $this->input->post('client_wechat');
        $client_phone = $this->input->post('client_phone');
        $client_birthday = $this->input->post('client_birthday');
        $client_nationality = $this->input->post('client_nationality');

        $client_key = randkey(32);
        $add_type = 2;
        $arr = array('status' => 1, 'created' => time(), 'edited' => time());
        $arr['parent'] = 0;
        $arr['add_type'] = $add_type;
        $arr['user_realname'] = $client_realname;
        $arr['user_address'] = $client_address;
        $arr['user_email'] = $client_email;
        $arr['user_industry'] = $client_industry;
        $arr['user_wechat'] = $client_wechat;
        $arr['user_phone'] = $client_phone;
        $arr['user_birthday'] = $client_birthday;
        $arr['user_nationality'] = $client_nationality;
        $arr['randkey'] = $client_key;
        $arr['register_process'] = 4;
        $client_id = $this->UserModel->add_user($arr);

        //给该用户创建一个二维码用户----START
        $qrcodearr = array('add_type' => $add_type, 'user_realname' => $client_realname, 'user_email' => $client_email, 'user_phone' => $client_phone, 'status' => 1, 'randkey' => randkey(32), 'created' => time(), 'edited' => time());
        $this->db->insert('ipadqrcode_user_list', $qrcodearr);
        $qrcode_uid = $this->db->insert_id();

        //获取数量
        $sql = "SELECT count(*) AS numcount FROM ipadqrcode_user_list";
        $numcount_res = $this->db->query($sql)->row_array();
        if (!empty($numcount_res)) {
            $numcount = $numcount_res['numcount'];
        } else {
            $numcount = 0;
        }
        $numcount = $numcount + 792;
        if ($numcount < 10) {
            $qrcode_user_number = '0000' . $numcount;
        } else if ($numcount < 100) {
            $qrcode_user_number = '000' . $numcount;
        } else if ($numcount < 1000) {
            $qrcode_user_number = '00' . $numcount;
        } else if ($numcount < 10000) {
            $qrcode_user_number = '0' . $numcount;
        } else {
            $qrcode_user_number = $numcount;
        }
        $this->db->update('ipadqrcode_user_list', array('user_number' => $qrcode_user_number), array('uid' => $qrcode_uid));
        $this->db->update(DB_PRE() . 'user_list', array('qrcode_uid' => $qrcode_uid), array('uid' => $client_id));
        //给该用户创建一个二维码用户----END
        //给该用户创建一个订单----START
        $arr = array('created' => time(), 'edited' => time());
        $order_key = randkey(32);
        $arr['client_id'] = $client_id;
        $arr['order_key'] = $order_key;

         /*echo '<pre>';
          print_r($arr);
          exit;*/ 
        $this->db->insert(DB_PRE() . 'order', $arr);
        $order_id = $this->db->insert_id();

        if ($order_id < 10) {
            $order_number = '00000' . $order_id;
        } else if ($order_id < 100) {
            $order_number = '0000' . $order_id;
        } else if ($order_id < 1000) {
            $order_number = '000' . $order_id;
        } else if ($order_id < 10000) {
            $order_number = '00' . $order_id;
        } else if ($order_id < 100000) {
            $order_number = '0' . $order_id;
        } else if ($order_id < 1000000) {
            $order_number = '' . $order_id;
        } else {
            $order_number = $order_id;
        }
        $this->db->update(DB_PRE() . 'order', array('order_number' => $order_number), array('order_id' => $order_id));
        //给该用户创建一个订单----END
        //给该用户创建一个二维码订单----START
        $qrcodearr = array('product_key' => randkey(32), 'status' => 1, 'created' => time(), 'edited' => time());
        $this->db->insert('ipadqrcode_product_list', $qrcodearr);
        $qrcode_product_id = $this->db->insert_id();
        $this->db->update(DB_PRE() . 'order', array('qrcode_product_id' => $qrcode_product_id), array('order_id' => $order_id));
        //给该用户创建一个二维码订单----END
        //----修改图片路径--START-----//
        $arr_pic = array();
        $img1_gksel = $this->input->post('img1_gksel'); //商品图片
        $arr_pic[] = array('num' => 1, 'item' => 'company_businesslicense', 'value' => $img1_gksel);
        $arr_pic = autotofilepath('user', $arr_pic);
        if (!empty($arr_pic)) {
            $this->UserModel->edit_user($client_id, $arr_pic);

            if (isset($arr_pic['company_businesslicense']) && $arr_pic['company_businesslicense'] != '') {

                $uploaddir = "../rojoipadqrcode/upload/user";
                if (!is_dir($uploaddir)) {
                    mkdir($uploaddir, 0777);
                }
                $uploaddir = "../rojoipadqrcode/upload/user/" . date('Y');
                if (!is_dir($uploaddir)) {
                    mkdir($uploaddir, 0777);
                }
                $uploaddir = "../rojoipadqrcode/upload/user/" . date('Y') . "/" . date('m');
                if (!is_dir($uploaddir)) {
                    mkdir($uploaddir, 0777);
                }

                $uploaddir_real = "upload/user/" . date('Y') . "/" . date('m');

                $old_pic = $arr_pic['company_businesslicense'];
                $old_arr = explode(date('Y') . '/' . date('m') . '/', $old_pic);
                $pic_realnameandtype = end($old_arr);

                $copy_url = $uploaddir . '/' . $pic_realnameandtype;
                $res = copy($old_pic, $copy_url);

                $arr = array('company_businesslicense' => $uploaddir_real . '/' . $pic_realnameandtype);
                $this->db->update("ipadqrcode_user_list", $arr, array('uid' => $qrcode_uid));
            }
        }
        //----修改图片路径--END-----//
        //跳转到列表页面
        $backurl = $this->input->post('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
                $decodebackurl = base64_decode($backurl);
            } else {
                $decodebackurl = base_url() . 'index.php/admins/order/index';
            }
        } else {
            $decodebackurl = base_url() . 'index.php/admins/order/index';
        }
        echo json_encode(array('backurl' => $decodebackurl));
    }

    function del_order($order_id) {
        $this->OrderModel->del_order($order_id);
// 		redirect('admins/order/index');
    }

    function toedit_order($order_id) {
        header("Content-type: text/html; charset=utf-8");

        //跳转到列表页面
        $backurl = $this->input->get('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
                $decodebackurl = base64_decode(str_replace(" ", "+", $backurl));
            } else {
                $decodebackurl = base_url() . 'index.php/admins/order/index';
            }
        } else {
            $decodebackurl = base_url() . 'index.php/admins/order/index';
        }
        $data['decodebackurl'] = $decodebackurl;
        $data['backurl'] = $backurl;
        if ($this->langtype == '_ch') {
            $order_view_text = '修改订单';
        } else {
            $order_view_text = 'Edit Order';
        }
        //导航栏
        $data['url'] = '<a href="' . $decodebackurl . '">' . lang('dz_orders') . '</a> &gt; ' . $order_view_text;

        $data['orderinformation'] = $this->OrderModel->getorderinfo($order_id);

        $data['userinfo'] = $this->UserModel->getuserinfo($data['orderinformation']['uid']);
        $data['clientinfo'] = $this->UserModel->getuserinfo($data['orderinformation']['client_id']);


        $this->load->view('admin/order_edit', $data);
    }

    //修改订单 ------- 处理方法
    function edit_order($order_id) {
        $this->OrderModel->del_order_details($order_id);

        $sql = $this->db->query("select order_list_id,design_data_15,design_data_16,design_data_17,design_data_18,design_data_19,design_data_20 from " . DB_PRE() . "order_list where o_id=" . $order_id);
        foreach ($sql->result_array() as $data) {
            $order_list_id = $data['order_list_id'];
			
			$design_data_15  = json_decode($data['design_data_15'],true);
			$design_data_16  = json_decode($data['design_data_16'],true);
			$design_data_17  = json_decode($data['design_data_17'],true);
			$design_data_18  = json_decode($data['design_data_18'],true);
			$design_data_19  = json_decode($data['design_data_19'],true);
			$design_data_20  = json_decode($data['design_data_20'],true);

            if($design_data_15 != ''){
				$category_id1 = 15;
			}

            if($design_data_16 != ''){
				$category_id1 = 16;
			}

            if($design_data_17 != ''){
				$category_id1 = 17;
			}

            if($design_data_18 != ''){
				$category_id1 = 18;
			}

            if($design_data_19 != ''){
				$category_id1 = 19;
			}

            if($design_data_20 != ''){
				$category_id1 = 20;
			}

            //商品信息
            $ja_garment = $this->input->post('ja_garment_' . $order_list_id);
            $wc_garment = $this->input->post('wc_garment_' . $order_list_id);
            $sh_garment = $this->input->post('sh_garment_' . $order_list_id);
            $tr_garment = $this->input->post('tr_garment_' . $order_list_id);

            $ja_length = $this->input->post('ja_length_' . $order_list_id);
            $sh_length = $this->input->post('sh_length_' . $order_list_id);
            $wc_length = $this->input->post('wc_length_' . $order_list_id);
            $tr_length = $this->input->post('tr_length_' . $order_list_id);

            $ja_shoulders = $this->input->post('ja_shoulders_' . $order_list_id);
            $sh_shoulders = $this->input->post('sh_shoulders_' . $order_list_id);
            $wc_shoulders = $this->input->post('wc_shoulders_' . $order_list_id);
            $tr_waist = $this->input->post('tr_waist_' . $order_list_id);

            $ja_chest = $this->input->post('ja_chest_' . $order_list_id);
            $sh_chest = $this->input->post('sh_chest_' . $order_list_id);
            $wc_chest = $this->input->post('wc_chest_' . $order_list_id);
            $tr_gluteus = $this->input->post('tr_gluteus_' . $order_list_id);

            $ja_chest_f = $this->input->post('ja_chest_f_' . $order_list_id);
            $sh_chest_f = $this->input->post('sh_chest_f_' . $order_list_id);
            $wc_chest_f = $this->input->post('wc_chest_f_' . $order_list_id);

            $ja_chest_b = $this->input->post('ja_chest_b_' . $order_list_id);
            $sh_chest_b = $this->input->post('sh_chest_b_' . $order_list_id);
            $wc_chest_b = $this->input->post('wc_chest_b_' . $order_list_id);

            $ja_bust = $this->input->post('ja_bust_' . $order_list_id);
            $sh_bust = $this->input->post('sh_bust_' . $order_list_id);
            $wc_bust = $this->input->post('wc_bust_' . $order_list_id);
            $tr_thigh = $this->input->post('tr_thigh_' . $order_list_id);

            $ja_circumference = $this->input->post('ja_circumference_' . $order_list_id);
            $sh_circumference = $this->input->post('sh_circumference_' . $order_list_id);
            $wc_circumference = $this->input->post('wc_circumference_' . $order_list_id);
            $tr_crotch_rise = $this->input->post('tr_crotch_rise_' . $order_list_id);
            $tr_crotch_front = $this->input->post('tr_crotch_front_' . $order_list_id);
            $tr_crotch_back = $this->input->post('tr_crotch_back_' . $order_list_id);

            $ja_sleeve = $this->input->post('ja_sleeve_' . $order_list_id);
            $sh_sleeve = $this->input->post('sh_sleeve_' . $order_list_id);
            $wc_sleeve = $this->input->post('wc_sleeve_' . $order_list_id);
            $tr_hamstring = $this->input->post('tr_hamstring_' . $order_list_id);

            $ja_bicep = $this->input->post('ja_bicep_' . $order_list_id);
            $sh_bicep = $this->input->post('sh_bicep_' . $order_list_id);
            $wc_bicep = $this->input->post('wc_bicep_' . $order_list_id);
            $tr_calf = $this->input->post('tr_calf_' . $order_list_id);

            $ja_wrist = $this->input->post('ja_wrist_' . $order_list_id);
            $sh_wrist = $this->input->post('sh_wrist_' . $order_list_id);
            $wc_wrist = $this->input->post('wc_wrist_' . $order_list_id);
            $tr_ankle = $this->input->post('tr_ankle_' . $order_list_id);

            $ja_neck = $this->input->post('ja_neck_' . $order_list_id);
            $sh_neck = $this->input->post('sh_neck_' . $order_list_id);
            $wc_neck = $this->input->post('wc_neck_' . $order_list_id);

            $code_suit = $this->input->post('code_suit_' . $order_list_id);
            $code_waistcoat = $this->input->post('code_waistcoat_' . $order_list_id);
            $code_trousers = $this->input->post('code_trousers_' . $order_list_id);
            $code_shirt = $this->input->post('code_shirt_' . $order_list_id);
            $code_overcoat = $this->input->post('code_overcoat_' . $order_list_id);
            $code_jacket = $this->input->post('code_jacket_' . $order_list_id);
            $code_shorts = $this->input->post('code_shorts_' . $order_list_id);
            $code_denim_trousers = $this->input->post('code_denim_trousers_' . $order_list_id);
            $code_casual_trousers = $this->input->post('code_casual_trousers_' . $order_list_id);
            $code_flannel_trousers = $this->input->post('code_flannel_trousers_' . $order_list_id);
            

            $code_suit_select = $this->input->post('code_suit_select_' . $order_list_id);
            $code_waistcoat_select = $this->input->post('code_waistcoat_select_' . $order_list_id);
            $code_trousers_select = $this->input->post('code_trousers_select_' . $order_list_id);
            $code_shirt_select = $this->input->post('code_shirt_select_' . $order_list_id);
            $code_overcoat_select = $this->input->post('code_overcoat_select_' . $order_list_id);
            $code_jacket_select = $this->input->post('code_jacket_select_' . $order_list_id);
            $code_shorts_select = $this->input->post('code_shorts_select_' . $order_list_id);
            $code_denim_trousers_select = $this->input->post('code_denim_trousers_select_' . $order_list_id);
            $code_casual_trousers_select = $this->input->post('code_casual_trousers_select_' . $order_list_id);
            $code_flannel_trousers_select = $this->input->post('code_flannel_trousers_select_' . $order_list_id);

            $status = $this->input->post('status_' . $order_list_id);

            $arr = array();
            //商品信息

            $arr['ja_garment'] = trim($ja_garment);
            $arr['wc_garment'] = trim($wc_garment);
            $arr['sh_garment'] = trim($sh_garment);
            $arr['tr_garment'] = trim($tr_garment);

            $arr['ja_length'] = trim($ja_length);
            $arr['sh_length'] = trim($sh_length);
            $arr['wc_length'] = trim($wc_length);
            $arr['tr_length'] = trim($tr_length);

            $arr['ja_shoulders'] = trim($ja_shoulders);
            $arr['sh_shoulders'] = trim($sh_shoulders);
            $arr['wc_shoulders'] = trim($wc_shoulders);
            $arr['tr_waist'] = trim($tr_waist);

            $arr['ja_chest'] = trim($ja_chest);
            $arr['sh_chest'] = trim($sh_chest);
            $arr['wc_chest'] = trim($wc_chest);
            $arr['tr_gluteus'] = trim($tr_gluteus);

            $arr['ja_chest_f'] = trim($ja_chest_f);
            $arr['sh_chest_f'] = trim($sh_chest_f);
            $arr['wc_chest_f'] = trim($wc_chest_f);

            $arr['ja_chest_b'] = trim($ja_chest_b);
            $arr['sh_chest_b'] = trim($sh_chest_b);
            $arr['wc_chest_b'] = trim($wc_chest_b);

            $arr['ja_bust'] = trim($ja_bust);
            $arr['sh_bust'] = trim($sh_bust);
            $arr['wc_bust'] = trim($wc_bust);
            $arr['tr_thigh'] = trim($tr_thigh);

            $arr['ja_circumference'] = trim($ja_circumference);
            $arr['sh_circumference'] = trim($sh_circumference);
            $arr['wc_circumference'] = trim($wc_circumference);
            $arr['tr_crotch_rise'] = trim($tr_crotch_rise);
            $arr['tr_crotch_front'] = trim($tr_crotch_front);
            $arr['tr_crotch_back'] = trim($tr_crotch_back);

            $arr['ja_sleeve'] = trim($ja_sleeve);
            $arr['sh_sleeve'] = trim($sh_sleeve);
            $arr['wc_sleeve'] = trim($wc_sleeve);
            $arr['tr_hamstring'] = trim($tr_hamstring);

            $arr['ja_bicep'] = trim($ja_bicep);
            $arr['sh_bicep'] = trim($sh_bicep);
            $arr['wc_bicep'] = trim($wc_bicep);
            $arr['tr_calf'] = trim($tr_calf);

            $arr['ja_wrist'] = trim($ja_wrist);
            $arr['sh_wrist'] = trim($sh_wrist);
            $arr['wc_wrist'] = trim($wc_wrist);
            $arr['tr_ankle'] = trim($tr_ankle);

            $arr['ja_neck'] = trim($ja_neck);
            $arr['sh_neck'] = trim($sh_neck);
            $arr['wc_neck'] = trim($wc_neck);

            $arr['code_suit'] = trim($code_suit);
            $arr['code_waistcoat'] = trim($code_waistcoat);
            $arr['code_trousers'] = trim($code_trousers);
            $arr['code_shirt'] = trim($code_shirt);
            $arr['code_overcoat'] = trim($code_overcoat);
            $arr['code_jacket'] = trim($code_jacket);
            $arr['code_shorts'] = trim($code_shorts);
            $arr['code_denim_trousers'] = trim($code_denim_trousers);
            $arr['code_casual_trousers'] = trim($code_casual_trousers);
            $arr['code_flannel_trousers'] = trim($code_flannel_trousers);

            $arr['code_suit_select'] = ($code_suit_select == "none") ? "" : trim($code_suit_select);
            $arr['code_waistcoat_select'] = ($code_waistcoat_select == "none") ? "" : trim($code_waistcoat_select);
            $arr['code_trousers_select'] = ($code_trousers_select == "none") ? "" : trim($code_trousers_select);
            $arr['code_shirt_select'] = ($code_shirt_select == "none") ? "" : trim($code_shirt_select);
            $arr['code_overcoat_select'] = ($code_overcoat_select == "none") ? "" : trim($code_overcoat_select);
            $arr['code_jacket_select'] = ($code_jacket_select == "none") ? "" : trim($code_jacket_select);
            $arr['code_shorts_select'] = ($code_shorts_select == "none") ? "" : trim($code_shorts_select);
            $arr['code_denim_trousers_select'] = ($code_denim_trousers_select == "none") ? "" : trim($code_denim_trousers_select);
            $arr['code_casual_trousers_select'] = ($code_casual_trousers_select == "none") ? "" : trim($code_casual_trousers_select);
            $arr['code_flannel_trousers_select'] = ($code_flannel_trousers_select == "none") ? "" : trim($code_flannel_trousers_select);

            $arr['status'] = $status;

            $alldesign = $this->input->post('alldesign_id_' . $order_list_id);
            $alltarget = $this->input->post('alltarget_type_' . $order_list_id);
            $allcategory = $this->input->post('allcategory_id_' . $order_list_id);

            $jsonarr = $categories = array();
            for ($j = 0; $j < count($alldesign); $j++) {
                $designarr = array();

                $design_id = $alldesign[$j];
                $category_id = $allcategory[$j];
                (!in_array($category_id, $categories) ? ($categories[] = $category_id) : '');

                $radio_value = $checkbox_value = $input_value = $input2_value = NULL;

                if (trim($alltarget[$j]) == 'radio' || trim($alltarget[$j]) == 'radioorinput') {
                    $post_radio_value = $this->input->post('design_id_' . $design_id . '_' . $order_list_id);
                    $radio_value = !empty($post_radio_value) ? $post_radio_value : NULL;
                }
                if (trim($alltarget[$j]) == 'checkbox' || trim($alltarget[$j]) == 'checkboxorinput') {
                    $post_checkbox_value = $this->input->post('design_id_' . $design_id . '_' . $order_list_id);
                    $checkbox_value = !empty($post_checkbox_value) ? $post_checkbox_value : NULL;
                }

                if(!empty($this->input->post('input_title_' . $design_id . '_' . $order_list_id)) && $this->input->post('input_title_' . $design_id . '_' . $order_list_id) != ''){
                    $post_input_value=  $this->input->post('input_title_' . $design_id . '_' . $order_list_id);
                    $input_value= !empty($post_input_value)?$post_input_value:NULL;
                }

                if(!empty($this->input->post('input2_title_' . $design_id . '_' . $order_list_id)) && $this->input->post('input2_title_' . $design_id . '_' . $order_list_id) != ''){
                    $post_input2_value=  $this->input->post('input2_title_' . $design_id . '_' . $order_list_id);
                    $input2_value= !empty($post_input2_value)?$post_input2_value:NULL;
                }

                if (isset($radio_value) || isset($checkbox_value) || isset($input_value) || isset($input2_value)) {
                    if($radio_value == ''){
                        $radio_value = 0;
                    }
                    if ($checkbox_value == '') {
                        $checkbox_value = 0;
                    }
                    $designarr['order_id'] = trim($order_id);
                    $designarr['order_list_id'] = trim($order_list_id);
                    $designarr['category_id'] = trim($category_id);

                    $designarr['design_id'] = trim($design_id);
                    $designarr['radio_value'] = empty(trim($radio_value)) ? 0 : trim($radio_value);
                    $designarr['checkbox_value'] = empty(trim($checkbox_value)) ? 0 : trim($checkbox_value);
                    $designarr['input_value'] = empty(trim($input_value)) ? null : trim($input_value);
                    $designarr['input2_value'] = empty(trim($input2_value)) ? null : trim($input2_value);
                    $design_data = [
                        'design_id' => $designarr['design_id'],
                        'radio_value' => $designarr['radio_value'],
                        'checkbox_value' => $designarr['checkbox_value'],
                        'input_value' => $designarr['input_value'],
                        'input2_value' => $designarr['input2_value']
                    ];
                    if ($category_id > 0) {
                        $jsonarr['design_data_' . $category_id][] = $design_data;
                        $this->OrderModel->add_order_detail($designarr);
                    }
                }
            }
            foreach ($categories as $category) {
                $arr['design_data_' . $category] = json_encode($jsonarr['design_data_' . $category]);
            }
            $this->OrderModel->edit_order($order_list_id, $arr);
        }

        $this->OrderModel->edit_main_order($order_id, array('edited' => time()));

        $orderinfo = $this->OrderModel->getorderinfo($order_id);
        if (!empty($orderinfo)) {
            $client_realname = $this->input->post('client_realname');
            $client_address = $this->input->post('client_address');
            $client_email = $this->input->post('client_email');
            $client_industry = $this->input->post('client_industry');
            $client_wechat = $this->input->post('client_wechat');
            $client_phone = $this->input->post('client_phone');
            $client_birthday = $this->input->post('client_birthday');
            $client_nationality = $this->input->post('client_nationality');

            $arr = array();
            $arr['user_realname'] = trim($client_realname);
            $arr['user_address'] = trim($client_address);
            $arr['user_email'] = trim($client_email);
            $arr['user_industry'] = trim($client_industry);
            $arr['user_wechat'] = trim($client_wechat);
            $arr['user_phone'] = trim($client_phone);
            $arr['user_birthday'] = trim($client_birthday);
            $arr['user_nationality'] = trim($client_nationality);
            $this->UserModel->edit_user($orderinfo['client_id'], $arr);

            $clientinfo = $this->UserModel->getuserinfo($orderinfo['client_id']);

            $arr = array();
            $arr['user_realname'] = trim($client_realname);
            $arr['user_email'] = trim($client_email);
            $arr['user_phone'] = trim($client_phone);
            $this->db->update('ipadqrcode_user_list', $arr, array('uid' => $clientinfo['qrcode_uid']));
        }

        //跳转到列表页面
        $backurl = $this->input->post('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
                $decodebackurl = base64_decode($backurl);
            } else {
                $decodebackurl = base_url() . 'index.php/admins/order/index';
            }
        } else {
            $decodebackurl = base_url() . 'index.php/admins/order/index';
        }
		
		$decodebackurl = base_url() . 'index.php/admins/order/index';
        echo json_encode(array('backurl' => $decodebackurl));
    }

    //修改订单 ------- 处理方法
    function edit_order_databackend($order_id) {
        $orderinfo = $this->OrderModel->getorderinfo($order_id);
        if (!empty($orderinfo)) {
            $clientinfo = $this->UserModel->getuserinfo($orderinfo['client_id']);



            $client_realname = $this->input->post('client_realname');
            $client_address = $this->input->post('client_address');
            $client_email = $this->input->post('client_email');
            $client_industry = $this->input->post('client_industry');
            $client_wechat = $this->input->post('client_wechat');
            $client_phone = $this->input->post('client_phone');
            $client_birthday = $this->input->post('client_birthday');
            $client_nationality = $this->input->post('client_nationality');

            $arr = array();
            $arr['user_realname'] = $client_realname;
            $arr['user_address'] = $client_address;
            $arr['user_email'] = $client_email;
            $arr['user_industry'] = $client_industry;
            $arr['user_wechat'] = $client_wechat;
            $arr['user_phone'] = $client_phone;
            $arr['user_birthday'] = $client_birthday;
            $arr['user_nationality'] = $client_nationality;
            $this->UserModel->edit_user($orderinfo['client_id'], $arr);

            //----修改图片路径--START-----//
            $arr_pic = array();
            $img1_gksel = $this->input->post('img1_gksel'); //商品图片
            $arr_pic[] = array('num' => 1, 'item' => 'company_businesslicense', 'value' => $img1_gksel);
            $arr_pic = autotofilepath('user', $arr_pic);
            if (!empty($arr_pic)) {
                $this->UserModel->edit_user($orderinfo['client_id'], $arr_pic);

                if (isset($arr_pic['company_businesslicense']) && $arr_pic['company_businesslicense'] != '') {

                    $uploaddir = "../rojoipadqrcode/upload/user";
                    if (!is_dir($uploaddir)) {
                        mkdir($uploaddir, 0777);
                    }
                    $uploaddir = "../rojoipadqrcode/upload/user/" . date('Y');
                    if (!is_dir($uploaddir)) {
                        mkdir($uploaddir, 0777);
                    }
                    $uploaddir = "../rojoipadqrcode/upload/user/" . date('Y') . "/" . date('m');
                    if (!is_dir($uploaddir)) {
                        mkdir($uploaddir, 0777);
                    }

                    $uploaddir_real = "upload/user/" . date('Y') . "/" . date('m');

                    $old_pic = $arr_pic['company_businesslicense'];
                    $old_arr = explode(date('Y') . '/' . date('m') . '/', $old_pic);
                    $pic_realnameandtype = end($old_arr);

                    $copy_url = $uploaddir . '/' . $pic_realnameandtype;
                    $res = copy($old_pic, $copy_url);


                    $copy_url_real = $uploaddir_real . '/' . $pic_realnameandtype;


                    // 同时删除图片
                    $arr = array('company_businesslicense' => $copy_url_real);
                    $sql = "SELECT company_businesslicense FROM ipadqrcode_user_list WHERE uid = " . $clientinfo['qrcode_uid'];
                    $info = $this->db->query($sql)->row_array();
                    if (!empty($info)) {
                        $filename = $info ['company_businesslicense']; // 只能是相对路径
                        if (isset($arr ['company_businesslicense']) && $arr ['company_businesslicense'] != '' && $filename != "" && $arr ['company_businesslicense'] != $filename && file_exists('../rojoipadqrcode/' . $filename)) {
                            @unlink('../rojoipadqrcode/' . $filename);
                        }
                        $this->db->update("ipadqrcode_user_list", $arr, array('uid' => $clientinfo['qrcode_uid']));
                    }
                }
            }
            //----修改图片路径--END-----//




            $arr = array();
            $arr['user_realname'] = $client_realname;
            $arr['user_email'] = $client_email;
            $arr['user_phone'] = $client_phone;
            $this->db->update('ipadqrcode_user_list', $arr, array('uid' => $clientinfo['qrcode_uid']));
        }


        //跳转到列表页面
        $backurl = $this->input->post('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
                $decodebackurl = base64_decode($backurl);
            } else {
                $decodebackurl = base_url() . 'index.php/admins/order/index';
            }
        } else {
            $decodebackurl = base_url() . 'index.php/admins/order/index';
        }
        echo json_encode(array('backurl' => $decodebackurl));
    }

    //加入到已完成订单
    function tocompleted_order($order_id) {
		//echo $order_id;exit;
        //$arr = array();
        $arr['status'] = 5;
        $this->OrderModel->edit_order_status($order_id, $arr);
    }

   

}
