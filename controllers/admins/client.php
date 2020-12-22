<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Client extends CI_Controller {

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

    //用户列表
    function index() {
        $uid = $this->session->userdata('user_id');

        $row = $this->input->get('row');
        if ($row == "") {
            $row = 0;
        }
        $page = 50;
        $data['row'] = $row;
        $data['page'] = $page;

        $is_excel = $this->input->get('is_excel');
        $keyword = $this->input->get('keyword');
        $user_type = $this->input->get('user_type');
        if ($user_type == 1) {
            $this->session->set_userdata('menu', 'user');
        } else if ($user_type == 2) {
            $this->session->set_userdata('menu', 'client');
        } else if ($user_type == 3) {
            $this->session->set_userdata('menu', 'providers');
        } else {
            $this->session->set_userdata('menu', 'user');
        }
        $con = array('parent' => 0, 'orderby' => 'u.user_number', 'orderby_res' => 'DESC');
        if ($is_excel != 1) {
            $con['row'] = $row;
            $con['page'] = $data['page'];
        }
        if ($keyword != "") {
            $con['keyword'] = $keyword;
        }
        if ($user_type != "") {
            $con['user_type'] = $user_type;
        }
        $data['userlist'] = $this->ClientModel->getuserlist($con, $uid);
        /*echo '<pre>';
        print_r($data);
        exit;*/
        $data['count'] = $this->ClientModel->getuserlist($con, $uid, 1);
        $url = base_url() . 'index.php/admins/user/index?user_type=' . $user_type . '&keyword=' . $keyword . '&page=' . $page;
        $data['fy'] = fy_backend($data['count'], $row, $url, $data['page'], 5, 2);
        $data['user_type'] = $user_type;

        $this->load->view('admin/subuser_list', $data);
    }

    function user_list_phone() {
        $row = $this->input->get('row');
        if ($row == "") {
            $row = 0;
        }
        $page = 50;
        $data['row'] = $row;
        $data['page'] = $page;

        $is_excel = $this->input->get('is_excel');
        $keyword = $this->input->get('keyword');
        $user_type = $this->input->get('user_type');
        if ($user_type == 1) {
            $this->session->set_userdata('menu', 'user');
        } else if ($user_type == 2) {
            $this->session->set_userdata('menu', 'client');
        } else if ($user_type == 3) {
            $this->session->set_userdata('menu', 'providers');
        } else {
            $this->session->set_userdata('menu', 'user');
        }
        $con = array('parent' => 0, 'orderby' => 'u.uid', 'orderby_res' => 'DESC');
        if ($is_excel != 1) {
            $con['row'] = $row;
            $con['page'] = $data['page'];
        }
        if ($keyword != "") {
            $con['keyword'] = $keyword;
        }
        if ($user_type != "") {
            $con['user_type'] = $user_type;
        }
        $data['userlist'] = $this->ClientModel->getuserlist($con);
        $data['count'] = $this->ClientModel->getuserlist($con, 1);
        $url = base_url() . 'index.php/admins/user/user_list_phone?keyword=' . $keyword . '&page=' . $page;
        $data['fy'] = fy_backend($data['count'], $row, $url, $data['page'], 5, 2);

        $data['user_type'] = $user_type;
        if ($is_excel != 1) {
            $this->load->view('admin/user_list_phone', $data);
        } else {
            $this->load->view('admin/user_list_excel_' . $user_type, $data);
        }
    }

    //添加用户
    function toadd_user($user_type = 0) {
        //跳转到列表页面
        $backurl = $this->input->get('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
                $decodebackurl = base64_decode($backurl);
            } else {
                $decodebackurl = base_url() . 'index.php/admins/user/index';
            }
        } else {
            $decodebackurl = base_url() . 'index.php/admins/user/index';
        }
        $data['decodebackurl'] = $decodebackurl;
        $data['backurl'] = $backurl;
        //导航栏
        if ($user_type == 1) {
            $data['url'] = '<a href="' . $decodebackurl . '">Administrator</a> &gt; Add Administrator';
        } else if ($user_type == 2) {
            $data['url'] = '<a href="' . $decodebackurl . '">' . lang('dz_company_business_manage') . '</a> &gt; ' . lang('dz_company_business_add');
        } else if ($user_type == 3) {
            $data['url'] = '<a href="' . $decodebackurl . '">' . lang('dz_user_contentproviders_manage') . '</a> &gt; ' . lang('dz_user_contentproviders_add');
        }
        $data['user_type'] = $user_type;
        $this->load->view('admin/user_add', $data);
    }

    //添加用户---------------手机版
    function toadd_user_phone($user_type = 0) {
        //跳转到列表页面
        $backurl = $this->input->get('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
                $decodebackurl = base64_decode($backurl);
            } else {
                $decodebackurl = base_url() . 'index.php/admins/user/index';
            }
        } else {
            $decodebackurl = base_url() . 'index.php/admins/user/index';
        }
        $data['decodebackurl'] = $decodebackurl;
        $data['backurl'] = $backurl;
        //导航栏
        if ($user_type == 1) {
            $data['url'] = '<a href="' . $decodebackurl . '">' . lang('dz_user_manage') . '</a> &gt; ' . lang('dz_user_add');
        } else if ($user_type == 2) {
            $data['url'] = '<a href="' . $decodebackurl . '">' . lang('dz_company_business_manage') . '</a> &gt; ' . lang('dz_company_business_add');
        } else if ($user_type == 3) {
            $data['url'] = '<a href="' . $decodebackurl . '">' . lang('dz_user_contentproviders_manage') . '</a> &gt; ' . lang('dz_user_contentproviders_add');
        }
        $data['user_type'] = $user_type;
        $this->load->view('admin/user_add_phone', $data);
    }

    //添加用户 ------- 处理方法
    function add_user($user_type = 0) {
        //用户信息


        $user_nickname = $this->input->post('user_nickname'); //昵称
        $user_number = $this->input->post('user_number');
        $user_realname = $this->input->post('user_realname'); //姓名
        $user_sex = $this->input->post('user_sex'); //性别
        $user_phone = $this->input->post('user_phone'); //手机号码
        $user_email = $this->input->post('user_email'); //邮箱
        $password = $this->input->post('password'); //密码
        $user_profile = $this->input->post('user_profile'); //个人简介
        //公司信息
        $company_name = $this->input->post('company_name'); //公司名称
        $company_title = $this->input->post('company_title'); //公司职位
        $company_email = $this->input->post('company_email'); //公司邮箱
        $company_address = $this->input->post('company_address'); //公司地址
        $company_phone = $this->input->post('company_phone'); //公司电话

        $user_brandname = $this->input->post('user_brandname'); //公司电话


        $arr = array('status' => 1, 'edited_author' => $this->admin_username, 'user_type' => $user_type, 'created' => time(), 'edited' => time());
        //用户信息
        $arr['user_nickname'] = $user_nickname;
        $arr['user_number'] = $user_number;
        $arr['user_realname'] = $user_realname;

        $arr['user_brandname'] = $user_brandname;

        $arr['user_sex'] = $user_sex;
        $arr['user_phone'] = $user_phone;
        $arr['user_email'] = $user_email;
        $arr['user_profile'] = $user_profile;
        //公司信息
        $arr['company_name'] = $company_name;
        $arr['company_title'] = $company_title;
        $arr['company_email'] = $company_email;
        $arr['company_address'] = $company_address;
        $arr['company_phone'] = $company_phone;
        $arr['password'] = md5($password);
        $arr['randkey'] = randkey(32);


        $uid = $this->ClientModel->add_user($arr);

        //----修改图片路径--START-----//
        $arr_pic = array();
        $img1_gksel = $this->input->post('img1_gksel'); //商品图片
        $arr_pic[] = array('num' => 1, 'item' => 'company_businesslicense', 'value' => $img1_gksel);
        $arr_pic = autotofilepath('user', $arr_pic);
        if (!empty($arr_pic)) {
            $this->ClientModel->edit_user($uid, $arr_pic);
        }
        //----修改图片路径--END-----//
        //跳转到列表页面
        $backurl = $this->input->post('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
                $decodebackurl = base64_decode($backurl);
            } else {
                $decodebackurl = base_url() . 'index.php/admins/user/index?user_type=' . $user_type;
            }
        } else {
            $decodebackurl = base_url() . 'index.php/admins/user/index?user_type=' . $user_type;
        }
        echo json_encode(array('backurl' => $decodebackurl));
    }

    //修改用户
    function toedit_user($user_type, $uid) {
        //跳转到列表页面
        $backurl = $this->input->get('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
                $decodebackurl = base64_decode($backurl);
            } else {
                $decodebackurl = base_url() . 'index.php/admins/user/index';
            }
        } else {
            $decodebackurl = base_url() . 'index.php/admins/user/index';
        }
        $data['decodebackurl'] = $decodebackurl;
        $data['backurl'] = $backurl;
        //导航栏
        if ($user_type == 1) {
            $data['url'] = '<a href="' . $decodebackurl . '">Administrator</a> &gt; Edit Administrator';
        } else if ($user_type == 2) {
            $data['url'] = '<a href="' . $decodebackurl . '">' . lang('dz_company_business_manage') . '</a> &gt; ' . lang('dz_company_business_edit');
        } else if ($user_type == 3) {
            $data['url'] = '<a href="' . $decodebackurl . '">' . lang('dz_user_contentproviders_manage') . '</a> &gt; ' . lang('dz_user_contentproviders_edit');
        }

        $data['userinfo'] = $this->ClientModel->getuserinfo($uid);
        $this->load->view('admin/user_edit', $data);
    }

    //修改用户 ------- 处理方法
    function edit_user($uid) {
        //用户信息
        $user_nickname = $this->input->post('user_nickname'); //昵称
        $user_number = $this->input->post('user_number');
        $user_realname = $this->input->post('user_realname'); //姓名
        $user_sex = $this->input->post('user_sex'); //性别
        $user_email = $this->input->post('user_email'); //邮箱
        $password = $this->input->post('password'); //密码
        $user_profile = $this->input->post('user_profile'); //个人简介
        $status = $this->input->post('status');
        if ($status == '') {
            $status = 1;
        }
        //公司信息
        $company_name = $this->input->post('company_name'); //公司名称
        $company_title = $this->input->post('company_title'); //公司职位
        $company_email = $this->input->post('company_email'); //公司邮箱
        $company_address = $this->input->post('company_address'); //公司地址
        $company_phone = $this->input->post('company_phone'); //公司电话

        $user_address = $this->input->post('user_address');
        $user_birthday = $this->input->post('user_birthday');
        $user_industry = $this->input->post('user_industry');
        $user_wechat = $this->input->post('user_wechat');
        $user_nationality = $this->input->post('user_nationality');

        $user_brandname = $this->input->post('user_brandname'); //公司电话

        $arr = array('edited_author' => $this->admin_username, 'edited' => time());
        //用户信息
        $arr['user_nickname'] = $user_nickname;
        $arr['user_number'] = $user_number;
        $arr['user_realname'] = $user_realname;
        $arr['user_brandname'] = $user_brandname;
        $arr['user_sex'] = $user_sex;
        $arr['user_email'] = $user_email;
        $arr['user_profile'] = $user_profile;
        //公司信息
        $arr['company_name'] = $company_name;
        $arr['company_title'] = $company_title;
        $arr['company_email'] = $company_email;
        $arr['company_address'] = $company_address;
        $arr['company_phone'] = $company_phone;
        if ($password != '') {
            $arr['password'] = md5($password);
        }
        $arr['status'] = $status;

        $arr['user_address'] = $user_address;
        $arr['user_birthday'] = $user_birthday;
        $arr['user_industry'] = $user_industry;
        $arr['user_wechat'] = $user_wechat;
        $arr['user_nationality'] = $user_nationality;
        $this->ClientModel->edit_user($uid, $arr);


        //----修改图片路径--START-----//
        $arr_pic = array();
        $img1_gksel = $this->input->post('img1_gksel'); //商品图片
        $arr_pic[] = array('num' => 1, 'item' => 'company_businesslicense', 'value' => $img1_gksel);
        $arr_pic = autotofilepath('user', $arr_pic);
        if (!empty($arr_pic)) {
            $this->ClientModel->edit_user($uid, $arr_pic);
        }
        //----修改图片路径--END-----//
        //跳转到列表页面
        $backurl = $this->input->post('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
                $decodebackurl = base64_decode($backurl);
            } else {
                $decodebackurl = base_url() . 'index.php/admins/user/index';
            }
        } else {
            $decodebackurl = base_url() . 'index.php/admins/user/index';
        }
        echo json_encode(array('backurl' => $decodebackurl));
    }

    //删除用户
    function del_user($uid) {
        $this->ClientModel->del_user($uid);
    }

    //删除用户form
    function del_user_form($form_id) {
        $this->ClientModel->del_user_form($form_id);
    }

    //供应商助理列表
    function assistant_list($user_type, $parent) {
        //跳转到列表页面
        $backurl = $this->input->get('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
                $decodebackurl = base64_decode($backurl);
            } else {
                $decodebackurl = base_url() . 'index.php/admins/user/index?user_type=' . $user_type;
            }
        } else {
            $decodebackurl = base_url() . 'index.php/admins/user/index?user_type=' . $user_type;
        }
        $data['decodebackurl'] = $decodebackurl;
        $data['backurl'] = $backurl;

        //导航栏
        if ($user_type == 1) {
            $data['url'] = '<a href="' . $decodebackurl . '">' . lang('dz_user_manage') . '</a> &gt; ' . lang('dz_company_business_assistant_manage');
        } else if ($user_type == 2) {
            $data['url'] = '<a href="' . $decodebackurl . '">' . lang('dz_company_business_manage') . '</a> &gt; ' . lang('dz_company_business_assistant_manage');
        } else if ($user_type == 3) {
            $data['url'] = '<a href="' . $decodebackurl . '">' . lang('dz_user_contentproviders_manage') . '</a> &gt; ' . lang('dz_company_business_assistant_manage');
        }

        $con = array('parent' => $parent, 'orderby' => 'u.uid', 'orderby_res' => 'DESC');
        $data['user_type'] = $user_type;
        $data['parent'] = $parent;
        $data['userlist'] = $this->ClientModel->getuserlist($con);
        $this->load->view('admin/user_assistant_list', $data);
    }

    //修改供应商助理
    function toedit_assistant($user_type, $parent, $uid) {
        //跳转到列表页面
        $backurl = $this->input->get('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
                $decodebackurl = base64_decode($backurl);
            } else {
                $decodebackurl = base_url() . 'index.php/admins/user/index';
            }
        } else {
            $decodebackurl = base_url() . 'index.php/admins/user/index';
        }
        $data['decodebackurl'] = $decodebackurl;
        $data['backurl'] = $backurl;
        //导航栏
        if ($user_type == 1) {
            $data['url'] = '<a href="' . $decodebackurl . '">' . lang('dz_user_manage') . '</a> &gt; <a href="' . site_url('admins/user/assistant_list/' . $user_type . '/' . $parent . '?backurl=' . $backurl) . '">' . lang('dz_company_business_assistant_manage') . '</a> &gt; ' . lang('dz_company_business_assistant_edit') . '';
        } else if ($user_type == 2) {
            $data['url'] = '<a href="' . $decodebackurl . '">' . lang('dz_company_business_manage') . '</a> &gt; <a href="' . site_url('admins/user/assistant_list/' . $user_type . '/' . $parent . '?backurl=' . $backurl) . '">' . lang('dz_company_business_assistant_manage') . '</a> &gt; ' . lang('dz_company_business_assistant_edit') . '';
        } else if ($user_type == 3) {
            $data['url'] = '<a href="' . $decodebackurl . '">' . lang('dz_user_contentproviders_manage') . '</a> &gt; <a href="' . site_url('admins/user/assistant_list/' . $user_type . '/' . $parent . '?backurl=' . $backurl) . '">' . lang('dz_company_business_assistant_manage') . '</a> &gt; ' . lang('dz_company_business_assistant_edit') . '';
        }

        $data['userinfo'] = $this->ClientModel->getuserinfo($uid);
        $data['parent'] = $parent;
        $data['user_type'] = $user_type;
        $this->load->view('admin/user_assistant_edit', $data);
    }

    //修改供应商助理 ------- 处理方法
    function edit_assistant($user_type, $parent, $uid) {
        //用户信息
        $user_nickname = $this->input->post('user_nickname'); //昵称
        $user_realname = $this->input->post('user_realname'); //姓名
        $user_sex = $this->input->post('user_sex'); //性别
        $user_phone = $this->input->post('user_phone'); //手机号码
        $user_email = $this->input->post('user_email'); //邮箱
        $password = $this->input->post('password'); //密码
        $user_profile = $this->input->post('user_profile'); //个人简介

        $arr = array('edited_author' => $this->admin_username, 'parent' => $parent, 'edited' => time());
        //用户信息
        $arr['user_nickname'] = $user_nickname;
        $arr['user_realname'] = $user_realname;
        $arr['user_sex'] = $user_sex;
        $arr['user_phone'] = $user_phone;
        $arr['user_email'] = $user_email;
        $arr['user_profile'] = $user_profile;
        if ($password != '') {
            $arr['password'] = md5($password);
        }
        $this->ClientModel->edit_user($uid, $arr);
        //跳转到列表页面
        $backurl = $this->input->post('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
                $decodebackurl = base64_decode($backurl);
            } else {
                $decodebackurl = base_url() . 'index.php/admins/user/assistant_list/' . $user_type . '/' . $parent . '?backurl=' . $backurl;
            }
        } else {
            $decodebackurl = base_url() . 'index.php/admins/user/assistant_list/' . $user_type . '/' . $parent . '?backurl=' . $backurl;
        }
        echo json_encode(array('backurl' => $decodebackurl));
    }

    //修改供应商助理
    function toadd_assistant($user_type, $parent) {
        //跳转到列表页面
        $backurl = $this->input->get('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
                $decodebackurl = base64_decode($backurl);
            } else {
                $decodebackurl = base_url() . 'index.php/admins/user/index';
            }
        } else {
            $decodebackurl = base_url() . 'index.php/admins/user/index';
        }
        $data['decodebackurl'] = $decodebackurl;
        $data['backurl'] = $backurl;
        //导航栏
        if ($user_type == 1) {
            $data['url'] = '<a href="' . $decodebackurl . '">' . lang('dz_user_manage') . '</a> &gt; <a href="' . site_url('admins/user/assistant_list/' . $user_type . '/' . $parent . '?backurl=' . $backurl) . '">' . lang('dz_company_business_assistant_manage') . '</a> &gt; ' . lang('dz_company_business_assistant_add') . '';
        } else if ($user_type == 2) {
            $data['url'] = '<a href="' . $decodebackurl . '">' . lang('dz_company_business_manage') . '</a> &gt; <a href="' . site_url('admins/user/assistant_list/' . $user_type . '/' . $parent . '?backurl=' . $backurl) . '">' . lang('dz_company_business_assistant_manage') . '</a> &gt; ' . lang('dz_company_business_assistant_add') . '';
        } else if ($user_type == 3) {
            $data['url'] = '<a href="' . $decodebackurl . '">' . lang('dz_user_contentproviders_manage') . '</a> &gt; <a href="' . site_url('admins/user/assistant_list/' . $user_type . '/' . $parent . '?backurl=' . $backurl) . '">' . lang('dz_company_business_assistant_manage') . '</a> &gt; ' . lang('dz_company_business_assistant_add') . '';
        }

        $data['parent'] = $parent;
        $data['user_type'] = $user_type;
        $this->load->view('admin/user_assistant_add', $data);
    }

    //修改供应商助理 ------- 处理方法
    function add_assistant($user_type, $parent) {
        //用户信息
        $user_nickname = $this->input->post('user_nickname'); //昵称
        $user_realname = $this->input->post('user_realname'); //姓名
        $user_sex = $this->input->post('user_sex'); //性别
        $user_phone = $this->input->post('user_phone'); //手机号码
        $user_email = $this->input->post('user_email'); //邮箱
        $password = $this->input->post('password'); //密码
        $user_profile = $this->input->post('user_profile'); //个人简介

        $arr = array('edited_author' => $this->admin_username, 'user_type' => $user_type, 'parent' => $parent, 'created' => time(), 'edited' => time());
        //用户信息
        $arr['user_nickname'] = $user_nickname;
        $arr['user_realname'] = $user_realname;
        $arr['user_sex'] = $user_sex;
        $arr['user_phone'] = $user_phone;
        $arr['user_email'] = $user_email;
        $arr['user_profile'] = $user_profile;
        if ($password != '') {
            $arr['password'] = md5($password);
        }
        $uid = $this->ClientModel->add_user($arr);
        //跳转到列表页面
        $backurl = $this->input->post('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
                $decodebackurl = base64_decode($backurl);
            } else {
                $decodebackurl = base_url() . 'index.php/admins/user/assistant_list/' . $user_type . '/' . $parent . '?backurl=' . $backurl;
            }
        } else {
            $decodebackurl = base_url() . 'index.php/admins/user/assistant_list/' . $user_type . '/' . $parent . '?backurl=' . $backurl;
        }
        echo json_encode(array('backurl' => $decodebackurl));
    }

    //用户地址列表
    function address_list($uid) {
        //跳转到列表页面
        $backurl = $this->input->get('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
                $decodebackurl = base64_decode($backurl);
            } else {
                $decodebackurl = base_url() . 'index.php/admins/user/index';
            }
        } else {
            $decodebackurl = base_url() . 'index.php/admins/user/index';
        }
        $data['decodebackurl'] = $decodebackurl;
        $data['backurl'] = $backurl;
        //导航栏
        $data['url'] = '<a href="' . $decodebackurl . '">' . lang('dz_user_manage') . '</a> &gt; ' . lang('dz_user_address_manage');

        $con = array('uid' => $uid, 'orderby' => 'address_id', 'orderby_res' => 'DESC');
        $data['uid'] = $uid;
        $data['addresslist'] = $this->ClientModel->getaddresslist($con);
        $this->load->view('admin/user_address_list', $data);
    }

    //修改用户地址
    function toedit_address($uid, $address_id) {
        //跳转到列表页面
        $backurl = $this->input->get('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
                $decodebackurl = base64_decode($backurl);
            } else {
                $decodebackurl = base_url() . 'index.php/admins/user/index';
            }
        } else {
            $decodebackurl = base_url() . 'index.php/admins/user/index';
        }
        $data['decodebackurl'] = $decodebackurl;
        $data['backurl'] = $backurl;
        //导航栏
        $data['url'] = '<a href="' . $decodebackurl . '">' . lang('dz_user_manage') . '</a> &gt; <a href="' . base_url() . 'index.php/admins/user/address_list/' . $uid . '?backurl=' . $backurl . '">' . lang('dz_user_address_manage') . '</a> &gt; ' . lang('dz_user_address_edit');

        $data['userinfo'] = $this->ClientModel->getuserinfo($uid);
        $data['addressinfo'] = $this->ClientModel->getaddressinfo($address_id);
        $this->load->view('admin/user_address_edit', $data);
    }

    //修改用户地址 ------- 处理方法
    function edit_address($uid, $address_id) {
        //用户信息
        $address_realname = $this->input->post('address_realname'); //姓名
        $address_phone = $this->input->post('address_phone'); //手机号码
        $address_email = $this->input->post('address_email'); //邮箱
        $provinceID = $this->input->post('provinceID'); //省份
        $cityID = $this->input->post('cityID'); //城市
        $areaID = $this->input->post('areaID'); //区域
        $address_street_address = $this->input->post('address_street_address'); //详细地址
        $address_zip_code = $this->input->post('address_zip_code'); //邮编

        $arr = array('edited_author' => $this->admin_username, 'edited' => time());
        //用户信息
        $arr['address_realname'] = $address_realname;
        $arr['address_phone'] = $address_phone;
        $arr['address_email'] = $address_email;
        $arr['address_province_id'] = $provinceID;
        $arr['address_city_id'] = $cityID;
        $arr['address_area_id'] = $areaID;
        $arr['address_province_name'] = $this->ClientModel->getprovince_name($provinceID);
        $arr['address_city_name'] = $this->ClientModel->getcity_name($cityID);
        $arr['address_area_name'] = $this->ClientModel->getarea_name($areaID);
        $arr['address_street_address'] = $address_street_address;
        $arr['address_zip_code'] = $address_zip_code;
        $this->ClientModel->edit_useraddress($address_id, $arr);

        //跳转到列表页面
        $backurl = $this->input->post('backurl');
        echo json_encode(array('backurl' => base_url() . 'index.php/admins/user/address_list/' . $uid . '?backurl=' . $backurl));
    }

    //管理员助手列表
    function adminassistantlist() {

        $row = $this->input->get('row');
        if ($row == "") {
            $row = 0;
        }
        $page = 50;
        $data['row'] = $row;
        $data['page'] = $page;

        $is_excel = $this->input->get('is_excel');
        $admin_type = $this->input->get('admin_type');
        if ($admin_type == 1) {
            $this->session->set_userdata('menu', 'superadmin');
        } else if ($admin_type == 2) {
            $this->session->set_userdata('menu', 'adminassistant');
        } else {
            $this->session->set_userdata('menu', 'adminassistant');
        }
        $keyword = $this->input->get('keyword');

        $con = array('orderby' => 'u.admin_id', 'orderby_res' => 'DESC', 'row' => $row, 'page' => $data['page']);
        if ($keyword != "") {
            $con['keyword'] = $keyword;
        }
        if ($admin_type != "") {
            $con['admin_type'] = $admin_type;
        }
        $data['adminlist'] = $this->AdminModel->getadminlist($con);
        $data['count'] = $this->AdminModel->getadminlist($con, 1);
        $url = base_url() . 'index.php/admins/user/adminassistantlist?admin_type=' . $admin_type . '&keyword=' . $keyword;
        $data['fy'] = fy_backend($data['count'], $row, $url, $data['page'], 5, 2);
        $data['admin_type'] = $admin_type;
        if ($is_excel != 1) {
            $this->load->view('admin/user_admin_list', $data);
        } else {
            $this->load->view('admin/user_admin_list_excel_2', $data);
        }
    }

    //添加管理员助手
    function toadd_adminassistant($admin_type) {
        //跳转到列表页面
        $backurl = $this->input->get('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
                $decodebackurl = base64_decode($backurl);
            } else {
                $decodebackurl = base_url() . 'index.php/admins/user/adminassistantlist?admin_type=' . $admin_type;
            }
        } else {
            $decodebackurl = base_url() . 'index.php/admins/user/adminassistantlist?admin_type=' . $admin_type;
        }
        $data['decodebackurl'] = $decodebackurl;
        $data['backurl'] = $backurl;
        //导航栏
        if ($admin_type == 1) {
            $data['url'] = '<a href="' . $decodebackurl . '">' . lang('cy_admin_super_manage') . '</a> &gt; ' . lang('cy_admin_super_add');
        } else if ($admin_type == 2) {
            $data['url'] = '<a href="' . $decodebackurl . '">' . lang('cy_admin_assistant_manage') . '</a> &gt; ' . lang('cy_admin_assistant_add');
        } else {
            $data['url'] = '<a href="' . $decodebackurl . '">' . lang('cy_admin_assistant_manage') . '</a> &gt; ' . lang('cy_admin_assistant_add');
        }
        $data['admin_type'] = $admin_type;
        $this->load->view('admin/user_admin_add', $data);
    }

    //添加管理员助手 ------- 处理方法
    function add_adminassistant($admin_type) {
        //用户信息
        $admin_username = $this->input->post('admin_username'); //用户名
        $admin_phone = $this->input->post('admin_phone'); //手机号码
        $admin_email = $this->input->post('admin_email'); //邮箱
        $admin_sex = $this->input->post('admin_sex'); //性别
        $admin_password = $this->input->post('admin_password'); //密码

        $admin_roles = $this->input->post('admin_roles'); //权限

        $arr = array('edited_author' => $this->admin_username, 'admin_type' => $admin_type, 'created' => time(), 'edited' => time());
        //用户信息
        $arr['admin_username'] = $admin_username;
        $arr['admin_phone'] = $admin_phone;
        $arr['admin_email'] = $admin_email;
        $arr['admin_sex'] = $admin_sex;
        if ($admin_password != '') {
            $arr['admin_password'] = md5($admin_password);
        }
        $arr['admin_roles'] = serialize($admin_roles);
        $admin_id = $this->AdminModel->add_admin($arr);

        //跳转到列表页面
        $backurl = $this->input->post('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
                $decodebackurl = base64_decode($backurl);
            } else {
                $decodebackurl = base_url() . 'index.php/admins/user/adminassistantlist?admin_type=' . $admin_type;
            }
        } else {
            $decodebackurl = base_url() . 'index.php/admins/user/adminassistantlist?admin_type=' . $admin_type;
        }
        echo json_encode(array('backurl' => $decodebackurl));
    }

    //修改管理员助手
    function toedit_adminassistant($admin_type, $admin_id) {
        //跳转到列表页面
        $backurl = $this->input->get('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
                $decodebackurl = base64_decode($backurl);
            } else {
                $decodebackurl = base_url() . 'index.php/admins/user/adminassistantlist?admin_type=' . $admin_type;
            }
        } else {
            $decodebackurl = base_url() . 'index.php/admins/user/adminassistantlist?admin_type=' . $admin_type;
        }
        $data['decodebackurl'] = $decodebackurl;
        $data['backurl'] = $backurl;
        //导航栏
        if ($admin_type == 1) {
            $data['url'] = '<a href="' . $decodebackurl . '">' . lang('cy_admin_super_manage') . '</a> &gt; ' . lang('cy_admin_super_edit');
        } else if ($admin_type == 2) {
            $data['url'] = '<a href="' . $decodebackurl . '">' . lang('cy_admin_assistant_manage') . '</a> &gt; ' . lang('cy_admin_assistant_edit');
        } else {
            $data['url'] = '<a href="' . $decodebackurl . '">' . lang('cy_admin_assistant_manage') . '</a> &gt; ' . lang('cy_admin_assistant_edit');
        }

        $data['admin_type'] = $admin_type;

        $data['admininfo'] = $this->AdminModel->getadmininfo($admin_id);
        $this->load->view('admin/user_admin_edit', $data);
    }

    //修改管理员助手 ------- 处理方法
    function edit_adminassistant($admin_type, $admin_id) {
        //用户信息
        $admin_username = $this->input->post('admin_username'); //用户名
        $admin_phone = $this->input->post('admin_phone'); //手机号码
        $admin_email = $this->input->post('admin_email'); //邮箱
        $admin_sex = $this->input->post('admin_sex'); //性别
        $admin_password = $this->input->post('admin_password'); //密码

        $admin_roles = $this->input->post('admin_roles'); //权限


        $arr = array('edited_author' => $this->admin_username, 'edited' => time());
        //用户信息
        $arr['admin_username'] = $admin_username;
        $arr['admin_phone'] = $admin_phone;
        $arr['admin_email'] = $admin_email;
        $arr['admin_sex'] = $admin_sex;
        if ($admin_password != '') {
            $arr['admin_password'] = md5($admin_password);
        }

        $arr['admin_roles'] = serialize($admin_roles);

        $this->AdminModel->edit_admin($admin_id, $arr);

        //跳转到列表页面
        $backurl = $this->input->post('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
                $decodebackurl = base64_decode($backurl);
            } else {
                $decodebackurl = base_url() . 'index.php/admins/user/adminassistantlist?admin_type=' . $admin_type;
            }
        } else {
            $decodebackurl = base_url() . 'index.php/admins/user/adminassistantlist?admin_type=' . $admin_type;
        }
        echo json_encode(array('backurl' => $decodebackurl));
    }

    //删除管理员助手
    function del_adminassistant($admin_id) {
        $this->AdminModel->del_admin($admin_id);
    }

    //用户地址列表
    function form_list($uid) {
        //跳转到列表页面
        $backurl = $this->input->get('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
                $decodebackurl = base64_decode($backurl);
            } else {
                $decodebackurl = base_url() . 'index.php/admins/user/index';
            }
        } else {
            $decodebackurl = base_url() . 'index.php/admins/user/index';
        }
        $data['decodebackurl'] = $decodebackurl;
        $data['backurl'] = $backurl;
        //导航栏
        $data['url'] = '<a href="' . $decodebackurl . '">' . lang('dz_user_manage') . '</a> &gt; FORM';

        $con = array('uid' => $uid, 'orderby' => 'form_id', 'orderby_res' => 'DESC');
        $data['uid'] = $uid;
        $data['formlist'] = $this->ClientModel->getuser_formlist($con);
        $this->load->view('admin/user_form_list', $data);
    }

    //修改用户地址
    function toedit_form($uid, $form_id) {
        //跳转到列表页面
        $backurl = $this->input->get('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
                $decodebackurl = base64_decode($backurl);
            } else {
                $decodebackurl = base_url() . 'index.php/admins/user/index';
            }
        } else {
            $decodebackurl = base_url() . 'index.php/admins/user/index';
        }
        $data['decodebackurl'] = $decodebackurl;
        $data['backurl'] = $backurl;


        //跳转到列表页面
        $subbackurl = $this->input->get('subbackurl');
        if ($subbackurl != "") {
            $subbackurl = str_replace('slash_tag', '/', $subbackurl);
            if (base64_decode($subbackurl) != "") {
                $decodesubbackurl = base64_decode($subbackurl);
            } else {
                $decodesubbackurl = base_url() . 'index.php/admins/user/form_list/' . $uid . '?backurl=' . $backurl;
            }
        } else {
            $decodesubbackurl = base_url() . 'index.php/admins/user/form_list/' . $uid . '?backurl=' . $backurl;
        }
        $data['decodesubbackurl'] = $decodesubbackurl;
        $data['subbackurl'] = $subbackurl;
        //导航栏
        $data['url'] = '<a href="' . $decodebackurl . '">' . lang('dz_user_manage') . '</a> &gt; <a href="' . $subbackurl . '">FORM</a> &gt; Edit FORM';

        $data['userinfo'] = $this->ClientModel->getuserinfo($uid);
        $data['forminfo'] = $this->ClientModel->getuser_forminfo($form_id);
        $this->load->view('admin/user_form_edit', $data);
    }

    //修改用户地址 ------- 处理方法
    function edit_form($uid, $form_id) {
        $lancodelist = getlancodelist(); //多语言
        $postOBJ = $this->input->post('GETOBJ');
        $postOBJ_type = $this->input->post('GETOBJ_type');
        $postOBJ_realname = $this->input->post('GETOBJ_realname');
        $postLANGOBJ = $this->input->post('GETLANGOBJ');
        //获取内容
        if (!empty($postOBJ)) {
            for ($p = 0; $p < count($postOBJ); $p++) {
                if ($postOBJ_type[$p] != 'image' && $postOBJ_type[$p] != 'file' && $postOBJ_type[$p] != 'checkbox') {
                    ${$postOBJ[$p]} = $this->input->post($postOBJ[$p]);
                    ${$postOBJ[$p]} = replace_content(defaultreparr(), ${$postOBJ[$p]});
                }
                if ($postOBJ_type[$p] == 'checkbox') {
                    ${$postOBJ[$p]} = $this->input->post($postOBJ[$p]);
                    if (!empty(${$postOBJ[$p]})) {
                        ${$postOBJ[$p]} = ${$postOBJ[$p]}[0];
                    } else {
                        ${$postOBJ[$p]} = 0;
                    }
                }
            }
        }
        if (!empty($postLANGOBJ)) {
            for ($lc = 0; $lc < count($lancodelist); $lc++) {
                for ($p = 0; $p < count($postLANGOBJ); $p++) {
                    ${$postLANGOBJ[$p] . $lancodelist[$lc]['langtype']} = $this->input->post($postLANGOBJ[$p] . $lancodelist[$lc]['langtype']); //产品名称
                    ${$postLANGOBJ[$p] . $lancodelist[$lc]['langtype']} = replace_content(defaultreparr(), ${$postLANGOBJ[$p] . $lancodelist[$lc]['langtype']});
                }
            }
        }
        $arr = array('edited_author' => $this->admin_username, 'edited' => time());
        //处理内容到数据库
        if (!empty($postOBJ)) {
            for ($p = 0; $p < count($postOBJ); $p++) {
                if ($postOBJ_type[$p] != 'image' && $postOBJ_type[$p] != 'file') {
                    $arr[$postOBJ[$p]] = ${$postOBJ[$p]};
                }
            }
        }
        if (!empty($postLANGOBJ)) {
            for ($lc = 0; $lc < count($lancodelist); $lc++) {
                for ($p = 0; $p < count($postLANGOBJ); $p++) {
                    $arr[$postLANGOBJ[$p] . $lancodelist[$lc]['langtype']] = ${$postLANGOBJ[$p] . $lancodelist[$lc]['langtype']};
                }
            }
        }
        $this->ClientModel->edit_userform($form_id, $arr);


        //----修改图片路径--START-----//
        $arr_pic = array();
        //获取内容
        if (!empty($postOBJ)) {
            $ppp = 0;
            for ($p = 0; $p < count($postOBJ); $p++) {
                if ($postOBJ_type[$p] == 'image' || $postOBJ_type[$p] == 'file') {
                    ${$postOBJ[$p]} = $this->input->post($postOBJ[$p]);
                    ${$postOBJ[$p]} = replace_content(defaultreparr(), ${$postOBJ[$p]});
                    $arr_pic[] = array('num' => $ppp, 'item' => $postOBJ_realname[$ppp], 'value' => ${$postOBJ[$p]});
                    $ppp++;
                }
            }
        }
        $arr_pic = autotofilepath('user', $arr_pic);
        if (!empty($arr_pic)) {
            $this->ClientModel->edit_userform($form_id, $arr_pic);
        }
        //----修改图片路径--END-----//
        //跳转到列表页面
        $backurl = $this->input->post('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
                $decodebackurl = base64_decode($backurl);
            } else {
                $decodebackurl = base_url() . 'index.php/admins/user/index';
            }
        } else {
            $decodebackurl = base_url() . 'index.php/admins/user/index';
        }
        $subbackurl = $this->input->post('subbackurl');
        if ($subbackurl != "") {
            $subbackurl = str_replace('slash_tag', '/', $subbackurl);
            if (base64_decode($subbackurl) != "") {
                $decodesubbackurl = base64_decode($subbackurl);
            } else {
                $decodesubbackurl = base_url() . 'index.php/admins/user/form_list/' . $uid . '?backurl=' . $backurl;
            }
        } else {
            $decodesubbackurl = base_url() . 'index.php/admins/user/form_list/' . $uid . '?backurl=' . $backurl;
        }
        echo json_encode(array('backurl' => $decodebackurl, 'subbackurl' => $decodesubbackurl));
    }

    //添加用户FORM
    function toadd_form($uid) {
        //跳转到列表页面
        $backurl = $this->input->get('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
                $decodebackurl = base64_decode($backurl);
            } else {
                $decodebackurl = base_url() . 'index.php/admins/user/index';
            }
        } else {
            $decodebackurl = base_url() . 'index.php/admins/user/index';
        }
        $data['decodebackurl'] = $decodebackurl;
        $data['backurl'] = $backurl;


        //跳转到列表页面
        $subbackurl = $this->input->get('subbackurl');
        if ($subbackurl != "") {
            $subbackurl = str_replace('slash_tag', '/', $subbackurl);
            if (base64_decode($subbackurl) != "") {
                $decodesubbackurl = base64_decode($subbackurl);
            } else {
                $decodesubbackurl = base_url() . 'index.php/admins/user/form_list/' . $uid . '?backurl=' . $backurl;
            }
        } else {
            $decodesubbackurl = base_url() . 'index.php/admins/user/form_list/' . $uid . '?backurl=' . $backurl;
        }
        $data['decodesubbackurl'] = $decodesubbackurl;
        $data['subbackurl'] = $subbackurl;

        //导航栏
        $data['url'] = '<a href="' . $decodebackurl . '">' . lang('dz_user_manage') . '</a> &gt; <a href="' . $decodesubbackurl . '">FORM</a> &gt; Add FORM';

        $data['userinfo'] = $this->ClientModel->getuserinfo($uid);
        $this->load->view('admin/user_form_add', $data);
    }

    //添加用户FORM -- 处理方法
    function add_form($uid) {
        $lancodelist = getlancodelist(); //多语言
        $postOBJ = $this->input->post('GETOBJ');
        $postOBJ_type = $this->input->post('GETOBJ_type');
        $postOBJ_realname = $this->input->post('GETOBJ_realname');
        $postLANGOBJ = $this->input->post('GETLANGOBJ');
        //获取内容
        if (!empty($postOBJ)) {
            for ($p = 0; $p < count($postOBJ); $p++) {
                if ($postOBJ_type[$p] != 'image' && $postOBJ_type[$p] != 'file' && $postOBJ_type[$p] != 'checkbox') {
                    ${$postOBJ[$p]} = $this->input->post($postOBJ[$p]);
                    ${$postOBJ[$p]} = replace_content(defaultreparr(), ${$postOBJ[$p]});
                }

                if ($postOBJ_type[$p] == 'checkbox') {
                    ${$postOBJ[$p]} = $this->input->post($postOBJ[$p]);
                    if (!empty(${$postOBJ[$p]})) {
                        ${$postOBJ[$p]} = ${$postOBJ[$p]}[0];
                    } else {
                        ${$postOBJ[$p]} = 0;
                    }
                }
            }
        }
        if (!empty($postLANGOBJ)) {
            for ($lc = 0; $lc < count($lancodelist); $lc++) {
                for ($p = 0; $p < count($postLANGOBJ); $p++) {
                    ${$postLANGOBJ[$p] . $lancodelist[$lc]['langtype']} = $this->input->post($postLANGOBJ[$p] . $lancodelist[$lc]['langtype']); //产品名称
                    ${$postLANGOBJ[$p] . $lancodelist[$lc]['langtype']} = replace_content(defaultreparr(), ${$postLANGOBJ[$p] . $lancodelist[$lc]['langtype']});
                }
            }
        }
        $arr = array('uid' => $uid, 'edited_author' => $this->admin_username, 'created' => time(), 'edited' => time());
        //处理内容到数据库
        if (!empty($postOBJ)) {
            for ($p = 0; $p < count($postOBJ); $p++) {
                if ($postOBJ_type[$p] != 'image' && $postOBJ_type[$p] != 'file') {
                    $arr[$postOBJ[$p]] = ${$postOBJ[$p]};
                }
            }
        }
        if (!empty($postLANGOBJ)) {
            for ($lc = 0; $lc < count($lancodelist); $lc++) {
                for ($p = 0; $p < count($postLANGOBJ); $p++) {
                    $arr[$postLANGOBJ[$p] . $lancodelist[$lc]['langtype']] = ${$postLANGOBJ[$p] . $lancodelist[$lc]['langtype']};
                }
            }
        }
        $form_id = $this->ClientModel->add_userform($arr);


        //----修改图片路径--START-----//
        $arr_pic = array();
        //获取内容
        if (!empty($postOBJ)) {
            $ppp = 0;
            for ($p = 0; $p < count($postOBJ); $p++) {
                if ($postOBJ_type[$p] == 'image' || $postOBJ_type[$p] == 'file') {
                    ${$postOBJ[$p]} = $this->input->post($postOBJ[$p]);
                    ${$postOBJ[$p]} = replace_content(defaultreparr(), ${$postOBJ[$p]});
                    $arr_pic[] = array('num' => $ppp, 'item' => $postOBJ_realname[$ppp], 'value' => ${$postOBJ[$p]});
                    $ppp++;
                }
            }
        }
        $arr_pic = autotofilepath('user', $arr_pic);
        if (!empty($arr_pic)) {
            $this->ClientModel->edit_userform($form_id, $arr_pic);
        }
        //----修改图片路径--END-----//
        //跳转到列表页面
        $backurl = $this->input->post('backurl');
        if ($backurl != "") {
            $backurl = str_replace('slash_tag', '/', $backurl);
            if (base64_decode($backurl) != "") {
                $decodebackurl = base64_decode($backurl);
            } else {
                $decodebackurl = base_url() . 'index.php/admins/user/index';
            }
        } else {
            $decodebackurl = base_url() . 'index.php/admins/user/index';
        }
        $subbackurl = $this->input->post('subbackurl');
        if ($subbackurl != "") {
            $subbackurl = str_replace('slash_tag', '/', $subbackurl);
            if (base64_decode($subbackurl) != "") {
                $decodesubbackurl = base64_decode($subbackurl);
            } else {
                $decodesubbackurl = base_url() . 'index.php/admins/user/form_list/' . $uid . '?backurl=' . $backurl;
            }
        } else {
            $decodesubbackurl = base_url() . 'index.php/admins/user/form_list/' . $uid . '?backurl=' . $backurl;
        }
        echo json_encode(array('backurl' => $decodebackurl, 'subbackurl' => $decodesubbackurl));
    }

    //删除无效的 client
    function toresetclient($client_id) {
        $sql = "SELECT * FROM " . DB_PRE() . "user_list WHERE uid=" . $client_id;
        $clientinfo = $this->db->query($sql)->row_array();
        if (!empty($clientinfo)) {
            //正常返回数据(json)
            $this->db->delete(DB_PRE() . 'user_list', array('uid' => $client_id));
            if (!empty($clientinfo)) {
                $this->db->delete('ipadqrcode_user_list', array('uid' => $clientinfo['qrcode_uid']));
            }
        }
    }

    //重新生成 客户编号
    function toreaction_clientno_fromorder($order_id) {
        $orderinfo = $this->OrderModel->getorderinfo($order_id);
        $client_id = $orderinfo['client_id'];

        $clientinfo = $this->ClientModel->getuserinfo($client_id);
        $qrcode_uid = $clientinfo['qrcode_uid'];


        //获取数量
        $sql = "SELECT count(*) AS numcount FROM ipadqrcode_user_list WHERE uid < " . $qrcode_uid;
        $numcount_res = $this->db->query($sql)->row_array();
        if (!empty($numcount_res)) {
            $numcount = $numcount_res['numcount'];
        } else {
            $numcount = 0;
        }
        $numcount = $numcount + 792 + 1;
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
    }

}
