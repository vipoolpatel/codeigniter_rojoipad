<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller {

    function __construct() {
        session_start();
        parent::__construct();
        $this->session->set_userdata('menu', 'home');
        $lang = $this->session->userdata('lang');
        $this->session->set_userdata('lang', 'en');
        $this->langtype = '_en';
        $this->lang->load('gksel', 'english');
    }

    // function index(){
    // $this->load->view ( 'admin/home_list');
    // }

    function autologin() {
        $userinfo = array('admin_id' => 1, 'admin_username' => 'admin', 'device' => 'pc');
        $userjson = serialize($userinfo);
        set_cookie('admin', $userjson, time() + 3600 * 24 * 30); //设置登录的Cookie
        redirect(base_url() . 'index.php/admins/cms/cmslist');
    }

    function index() {
        if (isset($_COOKIE['admin'])) {
            $admin = unserialize($_COOKIE['admin']);
            if (isset($admin ['device'])) {
                $admin_id = $admin ['admin_id'];
                $admin_username = $admin ['admin_username'];
                $admin_device = $admin ['device'];
            } else {
                $admin_id = 0;
                $admin_username = '';
                $admin_device = '';
            }
        } else {
            $admin_id = 0;
            $admin_username = '';
            $admin_device = '';
        }
        if ($admin_id != 0 && $admin_username != '' && $admin_device != '') {
// 			if(checkagent() == 'iphone' || checkagent() == 'android'){
// 				redirect ( base_url () . 'index.php/admins/user/user_list_phone' );
// 			}else{
            redirect(base_url() . 'index.php/admins/user/index?user_type=1');
// 			}
        } else {
            if (checkagent() == 'iphone' || checkagent() == 'android') {
                $this->load->view('admin/hlogin_phone');
            } else {
                $this->load->view('admin/hlogin');
            }
        }
// 		$this->load->view ( 'admin/hlogin' );
    }

    function tologin() {
        /* echo '<pre>';
          print_r($this->input->post());
          exit; */
        $ishaveyanzhengma = strip_tags($this->input->post('ishaveyanzhengma'));
        $aname = strip_tags($this->input->post('aname'));
        $apass = strip_tags($this->input->post('apass'));
        $ispass = 1;
        $result = $this->AdminModel->checkAdmin($aname, md5($apass));
        $result_username = $this->AdminModel->checkAdmin_username($aname);
        //if (!$result) {
            $user_result = $this->AdminModel->checkUser($aname, md5($apass));
            $user_username = $this->AdminModel->checkUser_username($aname);
        //}



        if (!empty($_SERVER ["HTTP_CLIENT_IP"])) {
            $ip_address = $_SERVER ["HTTP_CLIENT_IP"];
        } elseif (!empty($_SERVER ["HTTP_X_FORWARDED_FOR"])) {
            $ip_address = $_SERVER ["HTTP_X_FORWARDED_FOR"];
        } elseif (!empty($_SERVER ["REMOTE_ADDR"])) {
            $ip_address = $_SERVER ["REMOTE_ADDR"];
        } else {
            $ip_address = "127.0.0.1";
        }
        if ($ip_address == '::1') {
            $ip_address = '127.0.0.1';
        }

        if (!empty($result_username) && empty($user_username)) {
            //添加后台管理员登录日志--开始
            $err_num = 0;
            $sql = "SELECT * FROM " . DB_PRE() . "admin_login WHERE ip_address = '" . $ip_address . "' ORDER BY created DESC LIMIT 0, 5";
            $resdlogin = $this->db->query($sql)->result_array();


            if (!empty($resdlogin)) {
                for ($i = 0; $i < count($resdlogin); $i++) {
                    if ($resdlogin[$i]['status'] == 0) {
                        $err_num = $err_num + 1;
                    }
                }
            }
            if ($err_num >= 3) {
                $data ['ishaveyanzhengma'] = 1;
            }
            if ($err_num == 5) {
                if (($resdlogin[0]['created'] + 600) > time()) {
                    $data ['error'] = 'Please log in after ten minutes';
                    $this->load->view('admin/hlogin', $data);
                    return;
                    exit;
                }
            }
            //添加后台管理员登录日志--结束
        }

        if ($ishaveyanzhengma == 1) {
            $code = $this->input->post('code');
            if (strtolower($code) != strtolower($_SESSION ["yan"])) {
                $data ['code_error'] = 'Verification code error';
                $this->load->view('admin/hlogin', $data);
                return;
                exit;
            }
        }



        if ($result && !$user_result) {
            $userinfo = array('admin_id' => $result ['admin_id'], 'admin_username' => $result ['admin_username'], 'device' => 'pc');
            $userjson = serialize($userinfo);
            set_cookie('admin', $userjson, time() + 3600 * 24 * 30); //设置登录的Cookie
            //添加后台管理员登录日志--开始
            $arr = array('status' => 1, 'admin_id' => $result ['admin_id'], 'IP_address' => $ip_address, 'created' => time(), 'date_year' => date('Y'), 'date_month' => date('m'), 'date_day' => date('d'));
            $this->db->insert(DB_PRE() . 'admin_login', $arr);
            //添加后台管理员登录日志--结束
// 			if(checkagent() == 'iphone' || checkagent() == 'android'){
// 				redirect ( base_url () . 'index.php/admins/user/user_list_phone' );
// 			}else{
            redirect(base_url() . 'index.php/admins/user/index?user_type=1');
// 			}
        } else if (!$result && $user_result) {
            /*echo '<pre>';
            print_r($user_result);
            exit;*/
            $userinfo = array('admin_id' => $user_result ['uid'], 'admin_username' => $user_result ['uid'], 'device' => 'pc');
            $userjson = serialize($userinfo);
            $this->session->set_userdata('user_id',$user_result ['uid']);
            $this->session->set_userdata('user_brandname',$user_result ['user_brandname']);
            $this->session->set_userdata('user_realname',$user_result ['user_realname']);
            
            set_cookie('admin', $userjson, time() + 3600 * 24 * 30); //设置登录的Cookie
            //添加后台管理员登录日志--开始
            $arr = array('status' => 1, 'admin_id' => $user_result ['uid'], 'IP_address' => $ip_address, 'created' => time(), 'date_year' => date('Y'), 'date_month' => date('m'), 'date_day' => date('d'));
            $this->db->insert(DB_PRE() . 'admin_login', $arr);
            //添加后台管理员登录日志--结束
// 			if(checkagent() == 'iphone' || checkagent() == 'android'){
// 				redirect ( base_url () . 'index.php/admins/user/user_list_phone' );
// 			}else{
            redirect(base_url() . 'index.php/admins/client/index?user_type=1');
// 			}
        } else {
            if ($result == "" && $aname != '' && $apass != '') {
                $ispass = 0;
                $data ['error'] = 'Username or password error';


                if (!empty($result_username)) {
                    //添加后台管理员登录日志--开始
                    $arr = array('status' => 0, 'admin_id' => $result_username ['admin_id'], 'IP_address' => $ip_address, 'created' => time(), 'date_year' => date('Y'), 'date_month' => date('m'), 'date_day' => date('d'));
                    $this->db->insert(DB_PRE() . 'admin_login', $arr);
                    //添加后台管理员登录日志--结束
                } else {
                    //添加后台管理员登录日志--开始
                    $arr = array('status' => 0, 'admin_id' => 0, 'IP_address' => $ip_address, 'created' => time(), 'date_year' => date('Y'), 'date_month' => date('m'), 'date_day' => date('d'));
                    $this->db->insert(DB_PRE() . 'admin_login', $arr);
                    //添加后台管理员登录日志--结束
                }
            }

            if ($aname == '') {
                $data ['aname_error'] = 'Please enter your username';
                $ispass = 0;
            }

            if ($apass == '') {
                $data ['apass_error'] = 'Please enter your password';
                $ispass = 0;
            }
        }
        if ($ispass == 0) {
            $this->load->view('admin/hlogin', $data);
        }
    }

    function logout()
    {
        delete_cookie('admin');
        $this->session->sess_destroy();
        redirect(base_url() . 'index.php/admin/index');
    }

    function update_setting_status()
    {
        if (empty($this->input->post())) {
            echo json_encode(['status' => 'failed', 'message' => 'Please provide required data']);
            exit;
        }
        $name = $this->input->post('name');
        $value = $this->input->post('value');
        if (isset($value)) {
            $data['value'] = $this->input->post('value');
        }
        $data['status'] = ($this->input->post('status') == 'true' ? '1' : '0');
        $this->db->where('name', $name);
        $this->db->update('settings', $data);
        echo json_encode(['status' => 'success', 'message' => 'Settings updated successfully!']);
        exit;
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */