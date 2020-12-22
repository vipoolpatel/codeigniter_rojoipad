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

        $this->session->set_userdata('menu', 'order');

        $con = array('statusin' => '4,5', 'orderby' => 'o.order_id', 'orderby_res' => 'DESC', 'row' => $row, 'page' => $data['page'], 'isadmin' => $isadmin);
        if ($keyword != "") {
            $con['keyword'] = $keyword;
        }
        $data['orderlist'] = $this->OrderModel->getorderlist($con);
        $data['count'] = $this->OrderModel->getorderlist($con, 1);
        $url = base_url() . 'index.php/admins/order/index?status=' . $status . '&keyword=' . $keyword . '&page=' . $page;
        $data['fy'] = fy_backend($data['count'], $row, $url, $data['page'], 5, 2);


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

        /* echo '<pre>';
          print_r($data['orderinfo']);
          exit; */
        $data['userinfo'] = $this->UserModel->getuserinfo($data['orderinformation']['uid']);
        $data['clientinfo'] = $this->UserModel->getuserinfo($data['orderinformation']['client_id']);

        //echo '<pre>';
        //print_r($data['orderinfo']);exit;

        $this->load->view('admin/order_view', $data);
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
        
        /*echo '<pre>';
        print_r($data['orderinformation']);
        exit;*/
        $data['userinfo'] = $this->UserModel->getuserinfo($data['orderinformation']['uid']);
        $data['clientinfo'] = $this->UserModel->getuserinfo($data['orderinformation']['client_id']);


        if ($data['userinfo']['add_type'] == 1) {
            $this->load->view('admin/order_edit', $data);
        } else {
            $this->load->view('admin/order_edit_databackend', $data);
        }
    }

    //修改订单 ------- 处理方法
    function edit_order($order_id) {

        /* echo '<pre>';
          print_r($this->input->post());
          exit;
         */
        
        //Delete order details
        $this->OrderModel->del_order_details($order_id);
        $count = 0;

        $sql = $this->db->query("select order_list_id from " . DB_PRE() . "order_list where o_id=" . $order_id);
        foreach ($sql->result_array() as $data) {
            $order_list_id = $data['order_list_id'];
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

            $code_suit_select = $this->input->post('code_suit_select_' . $order_list_id);
            $code_waistcoat_select = $this->input->post('code_waistcoat_select_' . $order_list_id);
            $code_trousers_select = $this->input->post('code_trousers_select_' . $order_list_id);
            $code_shirt_select = $this->input->post('code_shirt_select_' . $order_list_id);
            $code_overcoat_select = $this->input->post('code_overcoat_select_' . $order_list_id);

            $status = $this->input->post('status_' . $order_list_id);

            $arr = array();
            //商品信息

            $arr['ja_garment'] = $ja_garment;
            $arr['wc_garment'] = $wc_garment;
            $arr['sh_garment'] = $sh_garment;
            $arr['tr_garment'] = $tr_garment;

            $arr['ja_length'] = $ja_length;
            $arr['sh_length'] = $sh_length;
            $arr['wc_length'] = $wc_length;
            $arr['tr_length'] = $tr_length;

            $arr['ja_shoulders'] = $ja_shoulders;
            $arr['sh_shoulders'] = $sh_shoulders;
            $arr['wc_shoulders'] = $wc_shoulders;
            $arr['tr_waist'] = $tr_waist;

            $arr['ja_chest'] = $ja_chest;
            $arr['sh_chest'] = $sh_chest;
            $arr['wc_chest'] = $wc_chest;
            $arr['tr_gluteus'] = $tr_gluteus;

            $arr['ja_chest_f'] = $ja_chest_f;
            $arr['sh_chest_f'] = $sh_chest_f;
            $arr['wc_chest_f'] = $wc_chest_f;

            $arr['ja_chest_b'] = $ja_chest_b;
            $arr['sh_chest_b'] = $sh_chest_b;
            $arr['wc_chest_b'] = $wc_chest_b;

            $arr['ja_bust'] = $ja_bust;
            $arr['sh_bust'] = $sh_bust;
            $arr['wc_bust'] = $wc_bust;
            $arr['tr_thigh'] = $tr_thigh;

            $arr['ja_circumference'] = $ja_circumference;
            $arr['sh_circumference'] = $sh_circumference;
            $arr['wc_circumference'] = $wc_circumference;
            $arr['tr_crotch_rise'] = $tr_crotch_rise;
            $arr['tr_crotch_front'] = $tr_crotch_front;
            $arr['tr_crotch_back'] = $tr_crotch_back;

            $arr['ja_sleeve'] = $ja_sleeve;
            $arr['sh_sleeve'] = $sh_sleeve;
            $arr['wc_sleeve'] = $wc_sleeve;
            $arr['tr_hamstring'] = $tr_hamstring;

            $arr['ja_bicep'] = $ja_bicep;
            $arr['sh_bicep'] = $sh_bicep;
            $arr['wc_bicep'] = $wc_bicep;
            $arr['tr_calf'] = $tr_calf;

            $arr['ja_wrist'] = $ja_wrist;
            $arr['sh_wrist'] = $sh_wrist;
            $arr['wc_wrist'] = $wc_wrist;
            $arr['tr_ankle'] = $tr_ankle;

            $arr['ja_neck'] = $ja_neck;
            $arr['sh_neck'] = $sh_neck;
            $arr['wc_neck'] = $wc_neck;

            $arr['code_suit'] = $code_suit;
            $arr['code_waistcoat'] = $code_waistcoat;
            $arr['code_trousers'] = $code_trousers;
            $arr['code_shirt'] = $code_shirt;
            $arr['code_overcoat'] = $code_overcoat;

            $arr['code_suit_select'] = $code_suit_select;
            $arr['code_waistcoat_select'] = $code_waistcoat_select;
            $arr['code_trousers_select'] = $code_trousers_select;
            $arr['code_shirt_select'] = $code_shirt_select;
            $arr['code_overcoat_select'] = $code_overcoat_select;

            $arr['status'] = $status;

            $alldesign = $this->input->post('alldesign_id_' . $order_list_id);
            $alltarget = $this->input->post('alltarget_type_' . $order_list_id);
            $allcategory = $this->input->post('allcategory_id_' . $order_list_id);

            $designarr = array();
            $jsonarr1 = array();
            for ($j = 0; $j < count($alldesign); $j++) {

                $design_id = $alldesign[$j];
                $category_id = $allcategory[$j];
                
                $radio_value = $checkbox_value = 0;
                
                //if ($this->input->post('design_id_' . $design_id . '_' . $order_list_id) != '') {
                    
                    if (trim($alltarget[$j]) == 'radio') {
                        $radio_value = $this->input->post('design_id_' . $design_id . '_' . $order_list_id);
                    }
                    if (trim($alltarget[$j]) == 'checkbox') {
                       $checkbox_value =  $this->input->post('design_id_' . $design_id . '_' . $order_list_id);
                    }
                    
                    if(!empty($this->input->post('input_title_' . $design_id . '_' . $order_list_id)) && $this->input->post('input_title_' . $design_id . '_' . $order_list_id) != ''){
                       $input_value =  $this->input->post('input_title_' . $design_id . '_' . $order_list_id);
                    }else{
                        $input_value  = NULL;
                    }
                    
                    if(!empty($this->input->post('input2_title_' . $design_id . '_' . $order_list_id)) && $this->input->post('input2_title_' . $design_id . '_' . $order_list_id) != ''){
                       $input2_value =  $this->input->post('input2_title_' . $design_id . '_' . $order_list_id);
                    }else{
                       $input2_value = NULL;
                    }
                    
                    $designarr['order_id'] = $order_id;
                    $designarr['order_list_id'] = $order_list_id;
                    $designarr['category_id'] = $category_id;
                    
                    $designarr['design_id'] = $design_id;
                    $designarr['input_value'] = $input_value;
                    $designarr['checkbox_value'] = $checkbox_value;
                    $designarr['radio_value'] = $radio_value;
                    $designarr['input2_value'] = $input2_value;
                    
                    $jsonarr['design_id'] = $design_id;
                    $jsonarr['input_value'] = ($input_value != '') ? $input_value:"";
                    $jsonarr['checkbox_value'] = ($checkbox_value != '') ? true:false;
                    $jsonarr['radio_value'] = ($radio_value != '') ? $radio_value:false;
                    $jsonarr['input2_value'] = ($input2_value != '') ? $input2_value:"";
                    
                    $jsonarr1[] = $jsonarr; 
                    $this->OrderModel->add_order_detail($designarr);
                    
                //}
            }
            
            $arr['design_data_'.$category_id] = json_encode($jsonarr1);
            
            $this->OrderModel->edit_order($order_list_id, $arr);
        }

        $arr1 = array('edited' => time());
        $this->OrderModel->edit_main_order($order_id, $arr1);

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
            $arr['user_realname'] = $client_realname;
            $arr['user_address'] = $client_address;
            $arr['user_email'] = $client_email;
            $arr['user_industry'] = $client_industry;
            $arr['user_wechat'] = $client_wechat;
            $arr['user_phone'] = $client_phone;
            $arr['user_birthday'] = $client_birthday;
            $arr['user_nationality'] = $client_nationality;
            $this->UserModel->edit_user($orderinfo['client_id'], $arr);

            $clientinfo = $this->UserModel->getuserinfo($orderinfo['client_id']);

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
        //$arr = array();
        $arr['status'] = 5;
        $this->OrderModel->edit_order_status($order_id, $arr);
    }

}
