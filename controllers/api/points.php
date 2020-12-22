<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Points extends CI_Controller {

    function __construct() {
        parent::__construct();
		

    }

    //Author: gksel
    //Date: 2015-08-20
    function getpointlist() {

        $partner_id = $this->input->post('partner_id'); // Partner ID
        $partner_key = $this->input->post('partner_key'); // Partner KEY

        $version = $this->input->post('version'); // 版本
        $lang = $this->input->post('lang'); // 语言
        if ($lang == 'ch') {
            $langtype = '_ch'; // 语言
        } else {
            $langtype = '_en'; // 语言
        }

        $uid = $this->input->post('uid');
        $randkey = $this->input->post('randkey');

        $con = array('partner_id' => $partner_id, 'partner_key' => $partner_key);
        $this->ApiModel->checknormalaction($con);

        if ($uid == '' || $randkey == '' || $lang == '' || $version == '') {
            //参数错误--缺少必要的参数
            $rearr = array('status' => '103', 'statusmsg' => 'parameter error');
            echo json_encode($rearr);
            exit;
            return; //终止
        }

        if (!is_numeric($uid) || $uid <= 0) {
            //参数错误--$uid - client_id 必须为:正整数
            $rearr = array('status' => '104', 'statusmsg' => 'parameter invalid');
            echo json_encode($rearr);
            exit;
            return; //终止
        }

        $sql = "SELECT * FROM " . DB_PRE() . "user_list WHERE uid=" . $uid;
        $check_userinfo = $this->db->query($sql)->row_array();

        if (empty($check_userinfo)) {
            //用户不存在!
            $rearr = array('status' => '105', 'statusmsg' => 'account not exists');
            echo json_encode($rearr);
            exit;
            return; //终止
        }

        if ($check_userinfo['randkey'] != $randkey) {
            //非法操作--用户 randkey 错误
            $rearr = array('status' => '106', 'statusmsg' => 'Illegal Operation');
            echo json_encode($rearr);
            exit;
            return; //终止
        }

        $data = $this->ApiModel->getpointlist($uid);
        $rearr = array('status' => '1', 'statusmsg' => 'success', 'data' => json_encode($data));
        echo json_encode($rearr);
    }
	
	
	function getcustpointlist() {

        $partner_id = $this->input->post('partner_id'); // Partner ID
        $partner_key = $this->input->post('partner_key'); // Partner KEY

        $version = $this->input->post('version'); // 版本
        $lang = $this->input->post('lang'); // 语言
        if ($lang == 'ch') {
            $langtype = '_ch'; // 语言
        } else {
            $langtype = '_en'; // 语言
        }

        $uid = $this->input->post('uid');
        $randkey = $this->input->post('randkey');

        $con = array('partner_id' => $partner_id, 'partner_key' => $partner_key);
        $this->ApiModel->checknormalaction($con);

        if ($uid == '' || $randkey == '' || $lang == '' || $version == '') {
            //参数错误--缺少必要的参数
            $rearr = array('status' => '103', 'statusmsg' => 'parameter error');
            echo json_encode($rearr);
            exit;
            return; //终止
        }

        if (!is_numeric($uid) || $uid <= 0) {
            //参数错误--$uid - client_id 必须为:正整数
            $rearr = array('status' => '104', 'statusmsg' => 'parameter invalid');
            echo json_encode($rearr);
            exit;
            return; //终止
        }

        $sql = "SELECT * FROM " . DB_PRE() . "user_list WHERE uid=" . $uid;
        $check_userinfo = $this->db->query($sql)->row_array();

        if (empty($check_userinfo)) {
            //用户不存在!
            $rearr = array('status' => '105', 'statusmsg' => 'account not exists');
            echo json_encode($rearr);
            exit;
            return; //终止
        }

        if ($check_userinfo['randkey'] != $randkey) {
            //非法操作--用户 randkey 错误
            $rearr = array('status' => '106', 'statusmsg' => 'Illegal Operation');
            echo json_encode($rearr);
            exit;
            return; //终止
        }

        $data = $this->ApiModel->getcustpointlist($uid);
        $rearr = array('status' => '1', 'statusmsg' => 'success', 'data' => json_encode($data));
        echo json_encode($rearr);
    }
	
	
    function verifypoints() {

        $partner_id = $this->input->post('partner_id'); // Partner ID
        $partner_key = $this->input->post('partner_key'); // Partner KEY

        $version = $this->input->post('version'); // 版本
        $lang = $this->input->post('lang'); // 语言
        if ($lang == 'ch') {
            $langtype = '_ch'; // 语言
        } else {
            $langtype = '_en'; // 语言
        }

        $uid = $this->input->post('uid');
        $randkey = $this->input->post('randkey');

        $amount = $this->input->post('Amount');
        $type = $this->input->post('Type');
        $stripe_id = $this->input->post('StripeId');
        $remark = $this->input->post('Remark');
        $method = $this->input->post('Method');

        $data = array('userid' => $uid,
            'amount' => $amount,
            'type' => $type,
            'stripeid' => $stripe_id,
            'remark' => $remark,
            'method' => $method
        );

        $con = array('partner_id' => $partner_id, 'partner_key' => $partner_key);
        $this->ApiModel->checknormalaction($con);

        if ($uid == '' || $randkey == '' || $lang == '' || $version == '') {
            //参数错误--缺少必要的参数
            $rearr = array('status' => '103', 'statusmsg' => 'parameter error');
            echo json_encode($rearr);
            exit;
            return; //终止
        }

        if (!is_numeric($uid) || $uid <= 0) {
            //参数错误--$uid - client_id 必须为:正整数
            $rearr = array('status' => '104', 'statusmsg' => 'parameter invalid');
            echo json_encode($rearr);
            exit;
            return; //终止
        }

        $sql = "SELECT * FROM " . DB_PRE() . "user_list WHERE uid=" . $uid;
        $check_userinfo = $this->db->query($sql)->row_array();

        if (empty($check_userinfo)) {
            //用户不存在!
            $rearr = array('status' => '105', 'statusmsg' => 'account not exists');
            echo json_encode($rearr);
            exit;
            return; //终止
        }

        if ($check_userinfo['randkey'] != $randkey) {
            //非法操作--用户 randkey 错误
            $rearr = array('status' => '106', 'statusmsg' => 'Illegal Operation');
            echo json_encode($rearr);
            exit;
            return; //终止
        }

        //$sql = "SELECT * FROM ".DB_PRE()."user_list WHERE uid=".$client_id;
        //$clientinfo=$this->db->query($sql)->row_array();
        /* if(empty($clientinfo)){
          //client不存在!
          $rearr=array('status'=>'107','statusmsg'=>'client not exists');
          echo json_encode($rearr);
          exit; return ;//终止
          }
          if($clientinfo['randkey'] != $client_key){
          //非法操作--client randkey 错误
          $rearr=array('status'=>'108','statusmsg'=>'Illegal Operation');
          echo json_encode($rearr);
          exit; return ;//终止
          } */

        $data = $this->ApiModel->verifypoints($data);
        /* echo '<pre>';
          print_r($data);
          exit;
         */

        echo json_encode($data);
    }

    function gettotalpoints() {

        $partner_id = $this->input->post('partner_id'); // Partner ID
        $partner_key = $this->input->post('partner_key'); // Partner KEY

        $version = $this->input->post('version'); // 版本
        $lang = $this->input->post('lang'); // 语言
        if ($lang == 'ch') {
            $langtype = '_ch'; // 语言
        } else {
            $langtype = '_en'; // 语言
        }

        $uid = $this->input->post('uid');
        $randkey = $this->input->post('randkey');

        $con = array('partner_id' => $partner_id, 'partner_key' => $partner_key);
        $this->ApiModel->checknormalaction($con);

        if ($uid == '' || $randkey == '' || $lang == '' || $version == '') {
            //参数错误--缺少必要的参数
            $rearr = array('status' => '103', 'statusmsg' => 'parameter error');
            echo json_encode($rearr);
            exit;
            return; //终止
        }

        if (!is_numeric($uid) || $uid <= 0) {
            //参数错误--$uid - client_id 必须为:正整数
            $rearr = array('status' => '104', 'statusmsg' => 'parameter invalid');
            echo json_encode($rearr);
            exit;
            return; //终止
        }

        $sql = "SELECT * FROM " . DB_PRE() . "user_list WHERE uid=" . $uid;
        $check_userinfo = $this->db->query($sql)->row_array();

        if (empty($check_userinfo)) {
            //用户不存在!
            $rearr = array('status' => '105', 'statusmsg' => 'account not exists');
            echo json_encode($rearr);
            exit;
            return; //终止
        }

        if ($check_userinfo['randkey'] != $randkey) {
            //非法操作--用户 randkey 错误
            $rearr = array('status' => '106', 'statusmsg' => 'Illegal Operation');
            echo json_encode($rearr);
            exit;
            return; //终止
        }

        $data = $this->ApiModel->totalpoints($uid);
        echo json_encode($data);
    }

    function getpaymenthistory() {

        $partner_id = $this->input->post('partner_id'); // Partner ID
        $partner_key = $this->input->post('partner_key'); // Partner KEY

        $version = $this->input->post('version'); // 版本
        $lang = $this->input->post('lang'); // 语言
        if ($lang == 'ch') {
            $langtype = '_ch'; // 语言
        } else {
            $langtype = '_en'; // 语言
        }

        $uid = $this->input->post('uid');
        $randkey = $this->input->post('randkey');

        $con = array('partner_id' => $partner_id, 'partner_key' => $partner_key);
        $this->ApiModel->checknormalaction($con);

        if ($uid == '' || $randkey == '' || $lang == '' || $version == '') {
            //参数错误--缺少必要的参数
            $rearr = array('status' => '103', 'statusmsg' => 'parameter error');
            echo json_encode($rearr);
            exit;
            return; //终止
        }

        if (!is_numeric($uid) || $uid <= 0) {
            //参数错误--$uid - client_id 必须为:正整数
            $rearr = array('status' => '104', 'statusmsg' => 'parameter invalid');
            echo json_encode($rearr);
            exit;
            return; //终止
        }

        $sql = "SELECT * FROM " . DB_PRE() . "user_list WHERE uid=" . $uid;
        $check_userinfo = $this->db->query($sql)->row_array();

        if (empty($check_userinfo)) {
            //用户不存在!
            $rearr = array('status' => '105', 'statusmsg' => 'account not exists');
            echo json_encode($rearr);
            exit;
            return; //终止
        }

        if ($check_userinfo['randkey'] != $randkey) {
            //非法操作--用户 randkey 错误
            $rearr = array('status' => '106', 'statusmsg' => 'Illegal Operation');
            echo json_encode($rearr);
            exit;
            return; //终止
        }

        $data = $this->ApiModel->paymenthistory($uid);
        echo json_encode($data);
    }
	
	
	public function token_generation() {
		$partner_id = $this->input->post('partner_id'); // Partner ID
        $partner_key = $this->input->post('partner_key'); // Partner KEY

        $version = $this->input->post('version'); // 版本
        $lang = $this->input->post('lang'); // 语言
        if ($lang == 'ch') {
            $langtype = '_ch'; // 语言
        } else {
            $langtype = '_en'; // 语言
        }

        $uid = $this->input->post('uid');
        $randkey = $this->input->post('randkey');

        $con = array('partner_id' => $partner_id, 'partner_key' => $partner_key);
        $this->ApiModel->checknormalaction($con);

        if ($uid == '' || $randkey == '' || $lang == '' || $version == '') {
            //参数错误--缺少必要的参数
            $rearr = array('status' => '103', 'statusmsg' => 'parameter error');
            echo json_encode($rearr);
            exit;
            return; //终止
        }

        if (!is_numeric($uid) || $uid <= 0) {
            //参数错误--$uid - client_id 必须为:正整数
            $rearr = array('status' => '104', 'statusmsg' => 'parameter invalid');
            echo json_encode($rearr);
            exit;
            return; //终止
        }

        $sql = "SELECT * FROM " . DB_PRE() . "user_list WHERE uid=" . $uid;
        $check_userinfo = $this->db->query($sql)->row_array();

        if (empty($check_userinfo)) {
            //用户不存在!
            $rearr = array('status' => '105', 'statusmsg' => 'account not exists');
            echo json_encode($rearr);
            exit;
            return; //终止
        }

        if ($check_userinfo['randkey'] != $randkey) {
            //非法操作--用户 randkey 错误
            $rearr = array('status' => '106', 'statusmsg' => 'Illegal Operation');
            echo json_encode($rearr);
            exit;
            return; //终止
        }
		
		$number = $this->input->post('number');
		$exp_month = $this->input->post('exp_month');
		$exp_year = $this->input->post('exp_year');
		$cvc = $this->input->post('cvc');
		
		$amount = $this->input->post('amount');
		$currency = $this->input->post('currency');
		//$uid = $this->input->post('uid');
		
		$this->api_error = ''; 
		$this->CI =& get_instance(); 
		require_once APPPATH . "third_party/stripe/init.php";	
		\Stripe\Stripe::setApiKey('sk_test_OyJK8gSzx86dC8cM9j9bWirQ00KiklP0gc');
		
		try{
				
$intent = \Stripe\PaymentIntent::create([
    'amount' => $amount,
    'currency' => $currency,
]);
$client_secret = $intent->client_secret;

$rearr = array('status' => '103', 'statusmsg' => 'success','client_secret' => $client_secret);					
             //echo $token =  $intent->client_secret;
			
		}catch(Exception $e) { 
					//$this->api_error = $e->getMessage(); 
					//return false;
$rearr = array('status' => '103', 'statusmsg' => $e->getMessage());					
			}
			
			echo json_encode($rearr);
	}

    public function checkout_payment() {
		/*echo '<pre>';
		print_r($this->input->post());
		exit;*/
		$partner_id = $this->input->post('partner_id'); // Partner ID
        $partner_key = $this->input->post('partner_key'); // Partner KEY
		$version = $this->input->post('version'); // 版本
        $lang = $this->input->post('lang'); // 语言
		
		$token = $this->input->post('token'); // 语言
		$amount = $this->input->post('amount'); // 语言
		$currency = $this->input->post('currency'); // 语言
		$description = $this->input->post('description'); // 语言
		
		$lastfourdigit = $this->input->post('lastfourdigit'); // 语言
		$expiremonth = $this->input->post('expiremonth'); // 语言
		$expireyear = $this->input->post('expireyear'); // 语言
		
		$uid = $this->input->post('uid');
		$randkey = $this->input->post('randkey');
		
        if ($lang == 'ch') {
            $langtype = '_ch'; // 语言
        } else {
            $langtype = '_en'; // 语言
        }

        

        $con = array('partner_id' => $partner_id, 'partner_key' => $partner_key);
        $this->ApiModel->checknormalaction($con);

        if ($uid == '' || $randkey == '' || $lang == '' || $version == '') {
            //参数错误--缺少必要的参数
            $rearr = array('status' => '103', 'statusmsg' => 'parameter error');
            echo json_encode($rearr);
            exit;
            return; //终止
        }

        if (!is_numeric($uid) || $uid <= 0) {
            //参数错误--$uid - client_id 必须为:正整数
            $rearr = array('status' => '104', 'statusmsg' => 'parameter invalid');
            echo json_encode($rearr);
            exit;
            return; //终止
        }

        $sql = "SELECT * FROM " . DB_PRE() . "user_list WHERE uid=" . $uid;
        $check_userinfo = $this->db->query($sql)->row_array();

        if (empty($check_userinfo)) {
            //用户不存在!
            $rearr = array('status' => '105', 'statusmsg' => 'account not exists');
            echo json_encode($rearr);
            exit;
            return; //终止
        }

        if ($check_userinfo['randkey'] != $randkey) {
            //非法操作--用户 randkey 错误
            $rearr = array('status' => '106', 'statusmsg' => 'Illegal Operation');
            echo json_encode($rearr);
            exit;
            return; //终止
        }

        $date = time();
        //insert tansaction data into the database
        $dataDB = array(
            'paid_amount_currency' => $currency,
            'stripeid' => $token,
            'payment_status' => 'Completed',
            'paydate' => $date,
            'amount' => $amount,
            'method' => 'Added by Card',
            'userid' => $uid,
            'last4' => $lastfourdigit,
			'exp_month' => $expiremonth,
			'exp_year' => $expireyear,
			'comment' => $description 
		);

		$this->db->insert('rojoipad_user_wallet',$dataDB);
		$data = $this->ApiModel->totalpoints($uid);
		//$rearr = array('status' => '1', 'statusmsg' => 'success', 'data' => json_encode($data));
               	
			
		echo json_encode($data);
        }
    }


