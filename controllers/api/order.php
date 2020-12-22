<?php use Tinify\AccountException;
use Tinify\ClientException;
use Tinify\ConnectionException;
use Tinify\ServerException;
use function Tinify\fromBuffer;
use function Tinify\fromFile;
use function Tinify\setKey;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    //调用示例: http://www.rjclothing.cn/rojoipad/index.php/api/order/add_order_sequence?partner_id=9153664774858319&partner_key=bBKJeYBcQRCM2QtPf2pat0999QTDganW&uid=1&randkey=oQqoHfEgrF0I9MTfgg4G1I82HDDk1Egf&client_id=2&client_key=neA2GueNESLHlkwxapwOmx5fssfXMqrZ&category_id=16&lang=en&version=iOS_v_1.6.5
    //Author: gksel
    //Date: 2015-08-20
    function add_order_sequence()
    {
        // 接受参数-- START
        $data = json_decode($_REQUEST['orderdata'], TRUE);

        /*echo '<pre>';
        print_r($this->input->post());
        exit;*/
        $partner_id = $this->input->post('partner_id');// Partner ID
        $partner_key = $this->input->post('partner_key');// Partner KEY

        $version = $this->input->post('version'); // 版本
        $lang = $this->input->post('lang');// 语言
        if ($lang == 'ch') {
            $langtype = '_ch';// 语言
        } else {
            $langtype = '_en';// 语言
        }

        $uid = $this->input->post('uid');
        $randkey = $this->input->post('randkey');

        $client_id = $this->input->post('client_id');
        $client_key = $this->input->post('client_key');

        $category_id = $this->input->post('category_id');

        // 接受参数-- END
        $con = array('partner_id' => $partner_id, 'partner_key' => $partner_key);
        $this->ApiModel->checknormalaction($con);
        if ($uid == '' || $randkey == '' || $client_id == '' || $client_key == '' || $category_id == '' || $lang == '' || $version == '') {
            //参数错误--缺少必要的参数
            $rearr = array('status' => '103', 'statusmsg' => 'parameter error');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

        if (!is_numeric($uid) || $uid <= 0 || !is_numeric($client_id) || $client_id <= 0) {
            //参数错误--$uid - client_id 必须为:正整数
            $rearr = array('status' => '104', 'statusmsg' => 'parameter invalid');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

        $sql = "SELECT * FROM " . DB_PRE() . "user_list WHERE uid=" . $uid;
        $check_userinfo = $this->db->query($sql)->row_array();
        if (empty($check_userinfo)) {
            //用户不存在!
            $rearr = array('status' => '105', 'statusmsg' => 'account not exists');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

        if ($check_userinfo['randkey'] != $randkey) {
            //非法操作--用户 randkey 错误
            $rearr = array('status' => '106', 'statusmsg' => 'Illegal Operation');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

        $sql = "SELECT * FROM " . DB_PRE() . "user_list WHERE uid=" . $client_id;
        $clientinfo = $this->db->query($sql)->row_array();
        if (empty($clientinfo)) {
            //client不存在!
            $rearr = array('status' => '107', 'statusmsg' => 'client not exists');
            echo json_encode($rearr);
            exit;
            return;//终止
        }
        if ($clientinfo['randkey'] != $client_key) {
            //非法操作--client randkey 错误
            $rearr = array('status' => '108', 'statusmsg' => 'Illegal Operation');
            echo json_encode($rearr);
            exit;
            return;//终止
        }


        $sql = "SELECT * FROM " . DB_PRE() . "category_list WHERE category_id = " . $category_id;
        $categoryinfo = $this->db->query($sql)->row_array();
        if (empty($categoryinfo)) {
            //category不存在!
            $rearr = array('status' => '109', 'statusmsg' => 'category not exists');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

        $ordArray = $data;

        $order_count = count($ordArray);
        //exit;

        //正常返回数据(json)
        $arr = array('created' => time(), 'edited' => time());
        $order_key = randkey(32);
        $arr['uid'] = $uid;
        $arr['client_id'] = $client_id;
        $arr['category_id'] = $category_id;
        $arr['order_key'] = $order_key;


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


        $this->db->update(DB_PRE() . 'order_list', array('status' => 2), array('o_id' => $order_id));

        //$order_list_array = array();
        for ($i = 0; $i < $order_count; $i++) {
            $ja_garment = $ordArray[$i]['ja_garment'];
            $ja_length = $ordArray[$i]['ja_length'];
            $ja_shoulders = $ordArray[$i]['ja_shoulders'];
            $ja_chest = $ordArray[$i]['ja_chest'];
            $ja_chest_f = $ordArray[$i]['ja_chest_f'];
            $ja_chest_b = $ordArray[$i]['ja_chest_b'];
            $ja_bust = $ordArray[$i]['ja_bust'];
            $ja_circumference = $ordArray[$i]['ja_circumference'];
            $ja_sleeve = $ordArray[$i]['ja_sleeve'];
            $ja_bicep = $ordArray[$i]['ja_bicep'];
            $ja_wrist = $ordArray[$i]['ja_wrist'];
            $ja_neck = $ordArray[$i]['ja_neck'];

            $sh_garment = $ordArray[$i]['sh_garment'];
            $sh_length = $ordArray[$i]['sh_length'];
            $sh_shoulders = $ordArray[$i]['sh_shoulders'];
            $sh_chest = $ordArray[$i]['sh_chest'];
            $sh_chest_f = $ordArray[$i]['sh_chest_f'];
            $sh_chest_b = $ordArray[$i]['sh_chest_b'];
            $sh_bust = $ordArray[$i]['sh_bust'];
            $sh_circumference = $ordArray[$i]['sh_circumference'];
            $sh_sleeve = $ordArray[$i]['sh_sleeve'];
            $sh_bicep = $ordArray[$i]['sh_bicep'];
            $sh_wrist = $ordArray[$i]['sh_wrist'];
            $sh_neck = $ordArray[$i]['sh_neck'];

            $wc_garment = $ordArray[$i]['wc_garment'];
            $wc_length = $ordArray[$i]['wc_length'];
            $wc_shoulders = $ordArray[$i]['wc_shoulders'];
            $wc_chest = $ordArray[$i]['wc_chest'];
            $wc_chest_f = $ordArray[$i]['wc_chest_f'];
            $wc_chest_b = $ordArray[$i]['wc_chest_b'];
            $wc_bust = $ordArray[$i]['wc_bust'];
            $wc_circumference = $ordArray[$i]['wc_circumference'];
            $wc_sleeve = $ordArray[$i]['wc_sleeve'];
            $wc_bicep = $ordArray[$i]['wc_bicep'];
            $wc_wrist = $ordArray[$i]['wc_wrist'];
            $wc_neck = $ordArray[$i]['wc_neck'];

            $tr_garment = $ordArray[$i]['tr_garment'];
            $tr_length = $ordArray[$i]['tr_length'];
            $tr_waist = $ordArray[$i]['tr_waist'];
            $tr_gluteus = $ordArray[$i]['tr_gluteus'];
            $tr_thigh = $ordArray[$i]['tr_thigh'];
            $tr_crotch_rise = $ordArray[$i]['tr_crotch_rise'];
            $tr_crotch_front = $ordArray[$i]['tr_crotch_front'];
            $tr_crotch_back = $ordArray[$i]['tr_crotch_back'];

            $tr_hamstring = $ordArray[$i]['tr_hamstring'];
            $tr_calf = $ordArray[$i]['tr_calf'];
            $tr_ankle = $ordArray[$i]['tr_ankle'];

            $code_suit = $ordArray[$i]['code_suit'];
            $code_waistcoat = $ordArray[$i]['code_waistcoat'];
            $code_trousers = $ordArray[$i]['code_trousers'];
            $code_shirt = $ordArray[$i]['code_shirt'];
            $code_overcoat = $ordArray[$i]['code_overcoat'];
            $code_jacket = $ordArray[$i]['code_jacket'];
            $code_shorts = $ordArray[$i]['code_shorts'];
            $code_denim_trousers = $ordArray[$i]['code_denim_trousers'];
            $code_casual_trousers = $ordArray[$i]['code_casual_trousers'];
            $code_flannel_trousers = $ordArray[$i]['code_flannel_trousers'];
            $code_gilet_vest = $ordArray[$i]['code_gilet_vest'];
            $code_bomber_jacket = $ordArray[$i]['code_bomber_jacket'];
            $code_trench_coat = $ordArray[$i]['code_trench_coat'];

            $code_suit_select = $ordArray[$i]['code_suit_select'];
            $code_waistcoat_select = $ordArray[$i]['code_waistcoat_select'];
            $code_trousers_select = $ordArray[$i]['code_trousers_select'];
            $code_shirt_select = $ordArray[$i]['code_shirt_select'];
            $code_overcoat_select = $ordArray[$i]['code_overcoat_select'];
            $code_jacket_select = $ordArray[$i]['code_jacket_select'];
            $code_shorts_select = $ordArray[$i]['code_shorts_select'];
            $code_denim_trousers_select = $ordArray[$i]['code_denim_trousers_select'];
            $code_casual_trousers_select = $ordArray[$i]['code_casual_trousers_select'];
            $code_flannel_trousers_select = $ordArray[$i]['code_flannel_trousers_select'];
            $code_gilet_vest_select = $ordArray[$i]['code_gilet_vest_select'];
            $code_bomber_jacket_select = $ordArray[$i]['code_bomber_jacket_select'];
            $code_trench_coat_select = $ordArray[$i]['code_trench_coat_select'];


            $arr_1 = array();
            $arr_1['o_id'] = $order_id;
            $arr_1['ja_garment'] = $ja_garment;
            $arr_1['ja_length'] = $ja_length;
            $arr_1['ja_shoulders'] = $ja_shoulders;
            $arr_1['ja_chest'] = $ja_chest;
            $arr_1['ja_chest_f'] = $ja_chest_f;
            $arr_1['ja_chest_b'] = $ja_chest_b;
            $arr_1['ja_bust'] = $ja_bust;
            $arr_1['ja_circumference'] = $ja_circumference;
            $arr_1['ja_sleeve'] = $ja_sleeve;
            $arr_1['ja_bicep'] = $ja_bicep;
            $arr_1['ja_wrist'] = $ja_wrist;
            $arr_1['ja_neck'] = $ja_neck;

            $arr_1['sh_garment'] = $sh_garment;
            $arr_1['sh_length'] = $sh_length;
            $arr_1['sh_shoulders'] = $sh_shoulders;
            $arr_1['sh_chest'] = $sh_chest;
            $arr_1['sh_chest_f'] = $sh_chest_f;
            $arr_1['sh_chest_b'] = $sh_chest_b;
            $arr_1['sh_bust'] = $sh_bust;
            $arr_1['sh_circumference'] = $sh_circumference;
            $arr_1['sh_sleeve'] = $sh_sleeve;
            $arr_1['sh_bicep'] = $sh_bicep;
            $arr_1['sh_wrist'] = $sh_wrist;
            $arr_1['sh_neck'] = $sh_neck;

            $arr_1['wc_garment'] = $wc_garment;
            $arr_1['wc_length'] = $wc_length;
            $arr_1['wc_shoulders'] = $wc_shoulders;
            $arr_1['wc_chest'] = $wc_chest;
            $arr_1['wc_chest_f'] = $wc_chest_f;
            $arr_1['wc_chest_b'] = $wc_chest_b;
            $arr_1['wc_bust'] = $wc_bust;
            $arr_1['wc_circumference'] = $wc_circumference;
            $arr_1['wc_sleeve'] = $wc_sleeve;
            $arr_1['wc_bicep'] = $wc_bicep;
            $arr_1['wc_wrist'] = $wc_wrist;
            $arr_1['wc_neck'] = $wc_neck;

            $arr_1['tr_garment'] = $tr_garment;
            $arr_1['tr_length'] = $tr_length;
            $arr_1['tr_waist'] = $tr_waist;
            $arr_1['tr_gluteus'] = $tr_gluteus;
            $arr_1['tr_thigh'] = $tr_thigh;
            $arr_1['tr_crotch_rise'] = $tr_crotch_rise;
            $arr_1['tr_crotch_front'] = $tr_crotch_front;
            $arr_1['tr_crotch_back'] = $tr_crotch_back;

            $arr_1['tr_hamstring'] = $tr_hamstring;
            $arr_1['tr_calf'] = $tr_calf;
            $arr_1['tr_ankle'] = $tr_ankle;

            $arr_1['code_suit'] = $code_suit;
            $arr_1['code_waistcoat'] = $code_waistcoat;
            $arr_1['code_trousers'] = $code_trousers;
            $arr_1['code_shirt'] = $code_shirt;
            $arr_1['code_overcoat'] = $code_overcoat;
            $arr_1['code_jacket'] = $code_jacket;
            $arr_1['code_shorts'] = $code_shorts;
            $arr_1['code_denim_trousers'] = $code_denim_trousers;
            $arr_1['code_casual_trousers'] = $code_casual_trousers;
            $arr_1['code_flannel_trousers'] = $code_flannel_trousers;
            $arr_1['code_gilet_vest'] = $code_gilet_vest;
            $arr_1['code_bomber_jacket'] = $code_bomber_jacket;
            $arr_1['code_trench_coat'] = $code_trench_coat;

            $arr_1['code_suit_select'] = $code_suit_select;
            $arr_1['code_waistcoat_select'] = $code_waistcoat_select;
            $arr_1['code_trousers_select'] = $code_trousers_select;
            $arr_1['code_shirt_select'] = $code_shirt_select;
            $arr_1['code_overcoat_select'] = $code_overcoat_select;
            $arr_1['code_jacket_select'] = $code_jacket_select;
            $arr_1['code_shorts_select'] = $code_shorts_select;
            $arr_1['code_denim_trousers_select'] = $code_denim_trousers_select;
            $arr_1['code_casual_trousers_select'] = $code_casual_trousers_select;
            $arr_1['code_flannel_trousers_select'] = $code_flannel_trousers_select;
            $arr_1['code_gilet_vest_select'] = $code_gilet_vest_select;
            $arr_1['code_bomber_jacket_select'] = $code_bomber_jacket_select;
            $arr_1['code_trench_coat_select'] = $code_trench_coat_select;

            $this->db->insert(DB_PRE() . 'order_list', $arr_1);
            $order_list_id[] = $this->db->insert_id();
        }


        $this->db->update(DB_PRE() . 'user_list', array('register_process' => 2), array('uid' => $client_id));


        $rearr = array('status' => '1', 'statusmsg' => 'success', 'order_id' => $order_id, 'order_key' => $order_key, 'order_list_id' => json_encode($order_list_id));
        echo json_encode($rearr);
    }

    //调用示例: http://www.rjclothing.cn/rojoipad/index.php/api/order/saveorderdesigndata
    //Author: gksel
    //Date: 2015-08-20
    function saveorderdesigndata()
    {
        // 接受参数-- START

        /*echo '<pre>';
        print_r($this->input->post());
        exit;
        */

        $partner_id = $this->input->post('partner_id');// Partner ID
        $partner_key = $this->input->post('partner_key');// Partner KEY

        $version = $this->input->post('version'); // 版本
        $lang = $this->input->post('lang');// 语言
        if ($lang == 'ch') {
            $langtype = '_ch';// 语言
        } else {
            $langtype = '_en';// 语言
        }

        $uid = $this->input->post('uid');
        $randkey = $this->input->post('randkey');

        $order_id = $this->input->post('orderid');
        $order_key = $this->input->post('orderkey');

        $design_category_id = $this->input->post('designcategoryid');//
        $design_data1 = $this->input->post('designdata');
        $order_list_id = $this->input->post('order_list_id');

        $design_data = json_decode($design_data1, TRUE);
        /*echo '<pre>';
        print_r($design_data);
        exit;*/

// 		echo 'partnerid:'.$partner_id.'<br /><br />';
// 		echo 'partnerkey:'.$partner_key.'<br /><br />';
// 		echo 'version:'.$version.'<br /><br />';
// 		echo 'lang:'.$lang.'<br /><br />';
// 		echo 'uid:'.$uid.'<br /><br />';
// 		echo 'randkey:'.$randkey.'<br /><br />';
// 		echo 'orderid:'.$order_id.'<br /><br />';
// 		echo 'orderkey:'.$order_key.'<br /><br />';
// 		echo 'designcategoryid:'.$design_category_id.'<br /><br />';
// 		echo 'designdata:';
// 		print_r($design_data);
// 		echo '<br /><br />';
// 		exit;

        // 接受参数-- END

        $con = array('partner_id' => $partner_id, 'partner_key' => $partner_key);
        $this->ApiModel->checknormalaction($con);

        if ($uid == '' || $randkey == '' || $order_id == '' || $order_key == '' || $lang == '' || $version == '') {
            //参数错误--缺少必要的参数
            $rearr = array('status' => '103', 'statusmsg' => 'parameter error');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

        if (!is_numeric($uid) || $uid <= 0 || !is_numeric($order_id) || $order_id <= 0 || !is_numeric($design_category_id) || $design_category_id <= 0) {
            //参数错误--$uid, $order_id, $design_category_id 必须为:正整数
            $rearr = array('status' => '104', 'statusmsg' => 'parameter invalid');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

        $sql = "SELECT * FROM " . DB_PRE() . "user_list WHERE uid=" . $uid;
        $check_userinfo = $this->db->query($sql)->row_array();
        if (empty($check_userinfo)) {
            //用户不存在!
            $rearr = array('status' => '105', 'statusmsg' => 'account not exists');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

        if ($check_userinfo['randkey'] != $randkey) {
            //非法操作--用户 randkey 错误
            $rearr = array('status' => '106', 'statusmsg' => 'Illegal Operation');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

        //echo 'ghfghgh';exit;

        $isadmin = 0;
        $orderinfo = $this->OrderModel->getorderinfo($order_id, $isadmin, $uid);

        if (!empty($orderinfo)) {
            if ($orderinfo['order_key'] != $order_key) {
                //非法操作--Order Key 错误
                $rearr = array('status' => '108', 'statusmsg' => 'Illegal Operation');
                echo json_encode($rearr);
                exit;
                return;//终止
            } else {
                //echo $design_data1;exit;
                $var_name = 'design_data_' . trim($design_category_id);
                $arr = array($var_name => trim($design_data1));


                $this->OrderModel->edit_order($order_list_id, $arr);
                //exit;
                //删除以前旧的数据
                $this->db->delete(DB_PRE() . 'order_detail', array('order_id' => $order_id, 'order_list_id' => $order_list_id, 'category_id' => $design_category_id));
                if (!empty($design_data)) {
                    for ($i = 0; $i < count($design_data); $i++) {
                        /*echo '<pre>';
                        print_r($design_data[$i]);
                        exit;*/
                        $arr = array('order_id' => $order_id, 'category_id' => $design_category_id);
                        $arr['design_id'] = $design_data[$i]['design_id'];
                        $arr['radio_value'] = empty($design_data[$i]['radio_value']) ? 0 : $design_data[$i]['radio_value'];
                        $arr['checkbox_value'] = $design_data[$i]['checkbox_value'];
                        $arr['order_list_id'] = $order_list_id;
                        if (isset($design_data[$i]['input_value'])) {
                            $arr['input_value'] = $design_data[$i]['input_value'];
                        }
                        if (isset($design_data[$i]['input2_value'])) {
                            $arr['input2_value'] = $design_data[$i]['input2_value'];
                        }
                        $this->db->insert(DB_PRE() . 'order_detail', $arr);
                    }
                }

                $this->db->update(DB_PRE() . 'order_list', array('status' => 3), array('order_list_id' => $order_list_id));
                $this->db->update(DB_PRE() . 'user_list', array('register_process' => 3), array('uid' => $orderinfo['client_id']));

                //正常返回数据(json)
                $rearr = array('status' => '1', 'statusmsg' => 'success');
                echo json_encode($rearr);
            }

        } else {
            //订单不存在!
            $rearr = array('status' => '107', 'statusmsg' => 'order not exists');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

    }
    //调用示例: http://www.rjclothing.cn/rojoipad/index.php/api/order/saveorder_confirmdata?partner_id=9153664774858319&partner_key=bBKJeYBcQRCM2QtPf2pat0999QTDganW&uid=1&randkey=oQqoHfEgrF0I9MTfgg4G1I82HDDk1Egf&order_id=9&order_key=oesPvy9phNXcayRuCaTaExG5TZPJjUpy&delivery_date=2018-03-14&total_price=1200&deposit_price=600&remaining_price=600&lang=en&version=iOS_v_1.6.5
    //Author: gksel
    //Date: 2015-08-20
    function saveorder_confirmdata()
    {
        /*echo '<pre>';
        print_r($this->input->post());
        exit;*/
        // 接受参数-- START
        $partner_id = $this->input->post('partner_id');// Partner ID
        $partner_key = $this->input->post('partner_key');// Partner KEY

        $version = $this->input->post('version'); // 版本
        $lang = $this->input->post('lang');// 语言
        if ($lang == 'ch') {
            $langtype = '_ch';// 语言
        } else {
            $langtype = '_en';// 语言
        }

        $uid = $this->input->post('uid');
        $randkey = $this->input->post('randkey');

        $order_id = $this->input->post('order_id');
        $order_key = $this->input->post('order_key');

        $delivery_date = $this->input->post('delivery_date');
        $total_price = $this->input->post('total_price');
        $deposit_price = $this->input->post('deposit_price');
        $remaining_price = $this->input->post('remaining_price');

        $retail_point = $this->input->post('retail_point');
        $wholesale_point = $this->input->post('wholesale_point');

        $totalPoint = $this->input->post('totalPoint');

        $order_memo = $this->input->post('order_memo');
        // 接受参数-- END

        $con = array('partner_id' => $partner_id, 'partner_key' => $partner_key);
        $this->ApiModel->checknormalaction($con);

        if ($uid == '' || $randkey == '' || $order_id == '' || $totalPoint == '' || $order_key == '' || $delivery_date == '' || $total_price == '' || $deposit_price == '' || $remaining_price == '' || $lang == '' || $version == '') {
            //参数错误--缺少必要的参数
            $rearr = array('status' => '103', 'statusmsg' => 'parameter error');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

        if (!is_numeric($uid) || $uid <= 0 || !is_numeric($order_id) || $order_id <= 0) {
            //参数错误--$uid, $order_id 必须为:正整数
            $rearr = array('status' => '104', 'statusmsg' => 'parameter invalid');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

        $sql = "SELECT * FROM " . DB_PRE() . "user_list WHERE uid=" . $uid;
        $check_userinfo = $this->db->query($sql)->row_array();
        /*echo '<pre>';
        print_r($check_userinfo);
        exit;*/
        if (empty($check_userinfo)) {
            //用户不存在!
            $rearr = array('status' => '105', 'statusmsg' => 'account not exists');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

        if ($check_userinfo['randkey'] != $randkey) {
            //非法操作--用户 randkey 错误
            $rearr = array('status' => '106', 'statusmsg' => 'Illegal Operation');
            echo json_encode($rearr);
            exit;
            return;//终止
        }
        $isadmin = 0;
        $orderinfo = $this->OrderModel->getorderinfo($order_id, $isadmin, $uid);

        if (!empty($orderinfo)) {
            if ($orderinfo['order_key'] != $order_key) {
                //非法操作--Order Key 错误
                $rearr = array('status' => '108', 'statusmsg' => 'Illegal Operation');
                echo json_encode($rearr);
                exit;
                return;//终止
            } else {
                $arr = array();
                $arr['delivery_time'] = strtotime($delivery_date);
                $arr['total_price'] = $total_price;
                $arr['deposit_price'] = $deposit_price;
                $arr['remaining_price'] = $remaining_price;
                $arr['order_memo'] = $order_memo;

                $arr['retail_point'] = $retail_point;
                $arr['wholesale_point'] = $wholesale_point;

                $arr['totalPoint'] = $totalPoint;
                $this->OrderModel->edit_main_order($order_id, $arr);

                //$this->db->update(DB_PRE().'order_list', array('status'=>4), array('o_id'=>$order_id));
                //$this->db->update(DB_PRE().'user_list', array('register_process'=>4), array('uid'=>$orderinfo['client_id']));

                $this->db->query("update " . DB_PRE() . "order_list set  status=4 where o_id=" . $order_id);
                $this->db->query("update " . DB_PRE() . "user_list set  register_process=4 where uid=" . $orderinfo['client_id']);

                //给该用户创建一个二维码订单----START
                $qrcodearr = array('product_key' => randkey(32), 'status' => 1, 'created' => time(), 'edited' => time());
                $this->db->insert('ipadqrcode_product_list', $qrcodearr);
                $qrcode_product_id = $this->db->insert_id();
                $this->db->query("update " . DB_PRE() . "order set  qrcode_product_id=" . $qrcode_product_id . " where order_id=" . $order_id);


                //renish vamja 10-jan-2020

                $rojoipad_order_list_data = $this->db->where("o_id", $order_id)->get('rojoipad_order_list')->row();

                $jacket = $this->db
                    ->where(array("type" => "jacket", "sub_type" => "cm", "type_value" => $rojoipad_order_list_data->ja_garment))
                    ->get('default_measurement')
                    ->row();


                $shirt = $this->db
                    ->where(array("type" => "shirt", "sub_type" => "cm", "type_value" => $rojoipad_order_list_data->sh_garment))
                    ->get('default_measurement')
                    ->row();

                $waistcoat = $this->db
                    ->where(array("type" => "waistcoat", "sub_type" => "cm", "type_value" => $rojoipad_order_list_data->wc_garment))
                    ->get('default_measurement')
                    ->row();

                $trousers = $this->db
                    ->where(array("type" => "trousers", "sub_type" => "cm", "type_value" => $rojoipad_order_list_data->tr_garment))
                    ->get('default_measurement')
                    ->row();

                /*$product_form_meacheck = array(
                    "product_id" => $qrcode_product_id,
                    "meacheck_section_1_1_memo" => !empty($rojoipad_order_list_data->ja_length) ? $jacket->length.'('.$rojoipad_order_list_data->ja_length.')' : $jacket->length.'(+0)',
                    "meacheck_section_1_2_memo" => !empty($rojoipad_order_list_data->ja_shoulders) ? $jacket->shoulders.'('.$rojoipad_order_list_data->ja_shoulders.')' : $jacket->shoulders.'(+0)',
                    "meacheck_section_1_3_memo" => !empty($rojoipad_order_list_data->ja_chest) ? $jacket->chest.'('.$rojoipad_order_list_data->ja_chest.')' : $jacket->chest.'(+0)',
                    "meacheck_section_1_3_1_memo" => !empty($rojoipad_order_list_data->ja_chest_f) ? $jacket->front_chest.'('.$rojoipad_order_list_data->ja_chest_f.')' : $jacket->front_chest.'(+0)',
                    "meacheck_section_1_3_2_memo" => !empty($rojoipad_order_list_data->ja_chest_b) ? $jacket->back_chest.'('.$rojoipad_order_list_data->ja_chest_b.')' : $jacket->back_chest.'(+0)',
                    "meacheck_section_1_4_memo" => !empty($rojoipad_order_list_data->ja_bust) ? $jacket->bust.'('.$rojoipad_order_list_data->ja_bust.')' : $jacket->bust.'(+0)',
                    "meacheck_section_1_5_memo" => !empty($rojoipad_order_list_data->ja_circumference) ? $jacket->hips.'('.$rojoipad_order_list_data->ja_circumference.')' : $jacket->hips.'(+0)',
                    "meacheck_section_1_6_memo" => !empty($rojoipad_order_list_data->ja_sleeve) ? $jacket->sleeve_length.'('.$rojoipad_order_list_data->ja_sleeve.')' : $jacket->sleeve_length.'(+0)',
                    "meacheck_section_1_7_memo" => !empty($rojoipad_order_list_data->ja_bicep) ? $jacket->bicep.'('.$rojoipad_order_list_data->ja_bicep.')' : $jacket->bicep.'(+0)',
                    "meacheck_section_1_8_memo" => !empty($rojoipad_order_list_data->ja_wrist) ? $jacket->wrist_cuff.'('.$rojoipad_order_list_data->ja_wrist.')' : $jacket->wrist_cuff.'(+0)',
                    "meacheck_section_1_9_memo" => !empty($rojoipad_order_list_data->sh_length) ? $shirt->length.'('.$rojoipad_order_list_data->sh_length.')' : $shirt->length.'(+0)',
                    "meacheck_section_1_10_memo" => !empty($rojoipad_order_list_data->sh_shoulders) ? $shirt->shoulders.'('.$rojoipad_order_list_data->sh_shoulders.')' : $shirt->shoulders.'(+0)',
                    "meacheck_section_1_11_memo" => !empty($rojoipad_order_list_data->sh_chest) ? $shirt->chest.'('.$rojoipad_order_list_data->sh_chest.')' : $shirt->chest.'(+0)',
                    "meacheck_section_1_11_1_memo" => !empty($rojoipad_order_list_data->sh_chest_f) ? $shirt->front_chest.'('.$rojoipad_order_list_data->sh_chest_f.')' : $shirt->front_chest.'(+0)',
                    "meacheck_section_1_11_2_memo" => !empty($rojoipad_order_list_data->sh_chest_b) ? $shirt->back_chest.'('.$rojoipad_order_list_data->sh_chest_b.')' : $shirt->back_chest.'(+0)',
                    "meacheck_section_1_12_memo" => !empty($rojoipad_order_list_data->sh_bust) ? $shirt->bust.'('.$rojoipad_order_list_data->sh_bust.')' : $shirt->bust.'(+0)',
                    "meacheck_section_1_13_memo" => !empty($rojoipad_order_list_data->sh_circumference) ? $shirt->hips.'('.$rojoipad_order_list_data->sh_circumference.')' : $shirt->hips.'(+0)',
                    "meacheck_section_1_14_memo" => !empty($rojoipad_order_list_data->sh_sleeve) ? $shirt->sleeve_length.'('.$rojoipad_order_list_data->sh_sleeve.')' : $shirt->sleeve_length.'(+0)',
                    "meacheck_section_1_15_memo" => !empty($rojoipad_order_list_data->sh_bicep) ? $shirt->bicep.'('.$rojoipad_order_list_data->sh_bicep.')' : $shirt->bicep.'(+0)',
                    "meacheck_section_1_16_memo" => !empty($rojoipad_order_list_data->sh_wrist) ? $shirt->wrist_cuff.'('.$rojoipad_order_list_data->sh_wrist.')' : $shirt->wrist_cuff.'(+0)',
                    "meacheck_section_1_17_memo" => !empty($rojoipad_order_list_data->sh_neck) ? $shirt->neck_cuff.'('.$rojoipad_order_list_data->sh_neck.')' : $shirt->neck_cuff.'(+0)',
                    "meacheck_section_1_18_memo" => !empty($rojoipad_order_list_data->tr_length) ? $trousers->length.'('.$rojoipad_order_list_data->tr_length.')' : $trousers->length.'(+0)',
                    "meacheck_section_1_19_memo" => !empty($rojoipad_order_list_data->tr_waist) ? $trousers->waist.'('.$rojoipad_order_list_data->tr_waist.')' : $trousers->waist.'(+0)',
                    "meacheck_section_1_20_memo" => !empty($rojoipad_order_list_data->tr_gluteus) ? $trousers->gluteus.'('.$rojoipad_order_list_data->tr_gluteus.')' : $trousers->gluteus.'(+0)',
                    "meacheck_section_1_21_memo" => !empty($rojoipad_order_list_data->tr_thigh) ? $trousers->thigh.'('.$rojoipad_order_list_data->tr_thigh.')' : $trousers->thigh.'(+0)',
                    "meacheck_section_1_22_memo" => !empty($rojoipad_order_list_data->tr_crotch_rise) ? $trousers->crotch_rise.'('.$rojoipad_order_list_data->tr_crotch_rise.')' : $trousers->crotch_rise.'(+0)',
                    "meacheck_section_1_22_1_memo" => !empty($rojoipad_order_list_data->tr_crotch_front) ? $trousers->front_crotch.'('.$rojoipad_order_list_data->tr_crotch_front.')' : $trousers->front_crotch.'(+0)',
                    "meacheck_section_1_22_2_memo" => !empty($rojoipad_order_list_data->tr_crotch_back) ? $trousers->back_crotch.'('.$rojoipad_order_list_data->tr_crotch_back.')' : $trousers->back_crotch.'(+0)',
                    "meacheck_section_1_23_memo" => !empty($rojoipad_order_list_data->tr_hamstring) ? $trousers->hamstring.'('.$rojoipad_order_list_data->tr_hamstring.')' : $trousers->hamstring.'(+0)',
                    "meacheck_section_1_24_memo" => !empty($rojoipad_order_list_data->tr_calf) ? $trousers->calf.'('.$rojoipad_order_list_data->tr_calf.')' : $trousers->calf.'(+0)',
                    "meacheck_section_1_25_memo" => !empty($rojoipad_order_list_data->tr_ankle) ? $trousers->ankle.'('.$rojoipad_order_list_data->tr_ankle.')' : $trousers->ankle.'(+0)',
                    "meacheck_section_1_26_memo" => !empty($rojoipad_order_list_data->wc_length) ? $waistcoat->length.'('.$rojoipad_order_list_data->wc_length.')' : $waistcoat->length.'(+0)',
                    "meacheck_section_1_27_memo" => !empty($rojoipad_order_list_data->wc_shoulders) ? $waistcoat->shoulders.'('.$rojoipad_order_list_data->wc_shoulders.')' : $waistcoat->shoulders.'(+0)',
                    "meacheck_section_1_28_memo" => !empty($rojoipad_order_list_data->wc_chest) ? $waistcoat->chest.'('.$rojoipad_order_list_data->wc_chest.')' : $waistcoat->chest.'(+0)',
                    "meacheck_section_1_28_1_memo" => !empty($rojoipad_order_list_data->wc_chest_f) ? $waistcoat->front_chest.'('.$rojoipad_order_list_data->wc_chest_f.')' : $waistcoat->front_chest.'(+0)',
                    "meacheck_section_1_28_2_memo" => !empty($rojoipad_order_list_data->wc_chest_b) ? $waistcoat->back_chest.'('.$rojoipad_order_list_data->wc_chest_b.')' : $waistcoat->back_chest.'(+0)',
                    "meacheck_section_1_29_memo" => !empty($rojoipad_order_list_data->wc_bust) ? $waistcoat->bust.'('.$rojoipad_order_list_data->wc_bust.')' : $waistcoat->bust.'(+0)',
                    "meacheck_section_1_30_memo" => !empty($rojoipad_order_list_data->wc_circumference) ? $waistcoat->hips.'('.$rojoipad_order_list_data->wc_circumference.')' : $waistcoat->hips.'(+0)',
                    );
                */
                #echo $rojoipad_order_list_data->wc_length;exit;

                // Abhishek Change this on 26th March 2020
                if ((substr($rojoipad_order_list_data->ja_length, 0, 1) === "+") || (substr($rojoipad_order_list_data->ja_length, 0, 1) === "-") || ($rojoipad_order_list_data->ja_length == "0")) {
                    $meacheck_section_2_1_memo = $jacket->length + $rojoipad_order_list_data->ja_length;
                } else {
                    $meacheck_section_2_1_memo = $rojoipad_order_list_data->ja_length;
                }

                if ((substr($rojoipad_order_list_data->ja_shoulders, 0, 1) === "+") || (substr($rojoipad_order_list_data->ja_shoulders, 0, 1) === "-") || ($rojoipad_order_list_data->ja_shoulders == "0")) {
                    $meacheck_section_2_2_memo = $jacket->shoulders + $rojoipad_order_list_data->ja_shoulders;
                } else {
                    $meacheck_section_2_2_memo = $rojoipad_order_list_data->ja_shoulders;
                }


                if ((substr($rojoipad_order_list_data->ja_chest, 0, 1) === "+") || (substr($rojoipad_order_list_data->ja_chest, 0, 1) === "-") || ($rojoipad_order_list_data->ja_chest == "0")) {
                    $meacheck_section_2_3_memo = $jacket->chest + $rojoipad_order_list_data->ja_chest;
                } else {
                    $meacheck_section_2_3_memo = $rojoipad_order_list_data->ja_chest;
                }

                if ((substr($rojoipad_order_list_data->ja_chest_f, 0, 1) === "+") || (substr($rojoipad_order_list_data->ja_chest_f, 0, 1) === "-") || ($rojoipad_order_list_data->ja_chest_f == "0")) {
                    $meacheck_section_2_3_1_memo = $jacket->front_chest + $rojoipad_order_list_data->ja_chest_f;
                } else {
                    $meacheck_section_2_3_1_memo = $rojoipad_order_list_data->ja_chest_f;
                }

                if ((substr($rojoipad_order_list_data->ja_chest_b, 0, 1) === "+") || (substr($rojoipad_order_list_data->ja_chest_b, 0, 1) === "-") || ($rojoipad_order_list_data->ja_chest_b == "0")) {
                    $meacheck_section_2_3_2_memo = $jacket->back_chest + $rojoipad_order_list_data->ja_chest_b;
                } else {
                    $meacheck_section_2_3_2_memo = $rojoipad_order_list_data->ja_chest_b;
                }

                if ((substr($rojoipad_order_list_data->ja_bust, 0, 1) === "+") || (substr($rojoipad_order_list_data->ja_bust, 0, 1) === "-") || ($rojoipad_order_list_data->ja_bust == "0")) {
                    $meacheck_section_2_4_memo = $jacket->bust + $rojoipad_order_list_data->ja_bust;
                } else {
                    $meacheck_section_2_4_memo = $rojoipad_order_list_data->ja_bust;
                }

                if ((substr($rojoipad_order_list_data->ja_circumference, 0, 1) === "+") || (substr($rojoipad_order_list_data->ja_circumference, 0, 1) === "-") || ($rojoipad_order_list_data->ja_circumference == "0")) {
                    $meacheck_section_2_5_memo = $jacket->hips + $rojoipad_order_list_data->ja_circumference;
                } else {
                    $meacheck_section_2_5_memo = $rojoipad_order_list_data->ja_circumference;
                }

                if ((substr($rojoipad_order_list_data->ja_sleeve, 0, 1) === "+") || (substr($rojoipad_order_list_data->ja_sleeve, 0, 1) === "-") || ($rojoipad_order_list_data->ja_sleeve == "0")) {
                    $meacheck_section_2_6_memo = $jacket->sleeve_length + $rojoipad_order_list_data->ja_sleeve;
                } else {
                    $meacheck_section_2_6_memo = $rojoipad_order_list_data->ja_sleeve;
                }


                if ((substr($rojoipad_order_list_data->ja_bicep, 0, 1) === "+") || (substr($rojoipad_order_list_data->ja_bicep, 0, 1) === "-") || ($rojoipad_order_list_data->ja_bicep == "0")) {
                    $meacheck_section_2_7_memo = $jacket->bicep + $rojoipad_order_list_data->ja_bicep;
                } else {
                    $meacheck_section_2_7_memo = $rojoipad_order_list_data->ja_bicep;
                }


                if ((substr($rojoipad_order_list_data->ja_wrist, 0, 1) === "+") || (substr($rojoipad_order_list_data->ja_wrist, 0, 1) === "-") || ($rojoipad_order_list_data->ja_wrist == "0")) {
                    $meacheck_section_2_8_memo = $jacket->wrist_cuff + $rojoipad_order_list_data->ja_wrist;
                } else {
                    $meacheck_section_2_8_memo = $rojoipad_order_list_data->ja_wrist;
                }

                if ((substr($rojoipad_order_list_data->sh_length, 0, 1) === "+") || (substr($rojoipad_order_list_data->sh_length, 0, 1) === "-") || ($rojoipad_order_list_data->sh_length == "0")) {
                    $meacheck_section_2_9_memo = $shirt->length + $rojoipad_order_list_data->sh_length;
                } else {
                    $meacheck_section_2_9_memo = $rojoipad_order_list_data->sh_length;
                }


                if ((substr($rojoipad_order_list_data->sh_shoulders, 0, 1) === "+") || (substr($rojoipad_order_list_data->sh_shoulders, 0, 1) === "-") || ($rojoipad_order_list_data->sh_shoulders == "0")) {
                    $meacheck_section_2_10_memo = $shirt->shoulders + $rojoipad_order_list_data->sh_shoulders;
                } else {
                    $meacheck_section_2_10_memo = $rojoipad_order_list_data->sh_shoulders;
                }


                if ((substr($rojoipad_order_list_data->sh_chest, 0, 1) === "+") || (substr($rojoipad_order_list_data->sh_chest, 0, 1) === "-") || ($rojoipad_order_list_data->sh_chest == "0")) {
                    $meacheck_section_2_11_memo = $shirt->chest + $rojoipad_order_list_data->sh_chest;
                } else {
                    $meacheck_section_2_11_memo = $rojoipad_order_list_data->sh_chest;
                }

                if ((substr($rojoipad_order_list_data->sh_chest_f, 0, 1) === "+") || (substr($rojoipad_order_list_data->sh_chest_f, 0, 1) === "-") || ($rojoipad_order_list_data->sh_chest_f == "0")) {
                    $meacheck_section_2_11_1_memo = $shirt->front_chest + $rojoipad_order_list_data->sh_chest_f;
                } else {
                    $meacheck_section_2_11_1_memo = $rojoipad_order_list_data->sh_chest_f;
                }

                if ((substr($rojoipad_order_list_data->sh_chest_b, 0, 1) === "+") || (substr($rojoipad_order_list_data->sh_chest_b, 0, 1) === "-") || ($rojoipad_order_list_data->sh_chest_b == "0")) {
                    $meacheck_section_2_11_2_memo = $shirt->back_chest + $rojoipad_order_list_data->sh_chest_b;
                } else {
                    $meacheck_section_2_11_2_memo = $rojoipad_order_list_data->sh_chest_b;
                }


                if ((substr($rojoipad_order_list_data->sh_bust, 0, 1) === "+") || (substr($rojoipad_order_list_data->sh_bust, 0, 1) === "-") || ($rojoipad_order_list_data->sh_bust == "0")) {
                    $meacheck_section_2_12_memo = $shirt->bust + $rojoipad_order_list_data->sh_bust;
                } else {
                    $meacheck_section_2_12_memo = $rojoipad_order_list_data->sh_bust;
                }

                if ((substr($rojoipad_order_list_data->sh_circumference, 0, 1) === "+") || (substr($rojoipad_order_list_data->sh_circumference, 0, 1) === "-") || ($rojoipad_order_list_data->sh_circumference == "0")) {
                    $meacheck_section_2_13_memo = $shirt->hips + $rojoipad_order_list_data->sh_circumference;
                } else {
                    $meacheck_section_2_13_memo = $rojoipad_order_list_data->sh_circumference;
                }

                if ((substr($rojoipad_order_list_data->sh_sleeve, 0, 1) === "+") || (substr($rojoipad_order_list_data->sh_sleeve, 0, 1) === "-") || ($rojoipad_order_list_data->sh_sleeve == "0")) {
                    $meacheck_section_2_14_memo = $shirt->sleeve_length + $rojoipad_order_list_data->sh_sleeve;
                } else {
                    $meacheck_section_2_14_memo = $rojoipad_order_list_data->sh_sleeve;
                }


                if ((substr($rojoipad_order_list_data->sh_bicep, 0, 1) === "+") || (substr($rojoipad_order_list_data->sh_bicep, 0, 1) === "-") || ($rojoipad_order_list_data->sh_bicep == "0")) {
                    $meacheck_section_2_15_memo = $shirt->bicep + $rojoipad_order_list_data->sh_bicep;
                } else {
                    $meacheck_section_2_15_memo = $rojoipad_order_list_data->sh_bicep;
                }


                if ((substr($rojoipad_order_list_data->sh_wrist, 0, 1) === "+") || (substr($rojoipad_order_list_data->sh_wrist, 0, 1) === "-") || ($rojoipad_order_list_data->sh_wrist == "0")) {
                    $meacheck_section_2_16_memo = $shirt->wrist_cuff + $rojoipad_order_list_data->sh_wrist;
                } else {
                    $meacheck_section_2_16_memo = $rojoipad_order_list_data->sh_wrist;
                }

                if ((substr($rojoipad_order_list_data->sh_neck, 0, 1) === "+") || (substr($rojoipad_order_list_data->sh_neck, 0, 1) === "-") || ($rojoipad_order_list_data->sh_neck == "0")) {
                    $meacheck_section_2_17_memo = $shirt->neck_cuff + $rojoipad_order_list_data->sh_neck;
                } else {
                    $meacheck_section_2_17_memo = $rojoipad_order_list_data->sh_neck;
                }

                if ((substr($rojoipad_order_list_data->tr_length, 0, 1) === "+") || (substr($rojoipad_order_list_data->tr_length, 0, 1) === "-") || ($rojoipad_order_list_data->tr_length == "0")) {
                    $meacheck_section_2_18_memo = $trousers->length + $rojoipad_order_list_data->tr_length;
                } else {
                    $meacheck_section_2_18_memo = $rojoipad_order_list_data->tr_length;
                }

                if ((substr($rojoipad_order_list_data->tr_waist, 0, 1) === "+") || (substr($rojoipad_order_list_data->tr_waist, 0, 1) === "-") || ($rojoipad_order_list_data->tr_waist == "0")) {
                    $meacheck_section_2_19_memo = $trousers->waist + $rojoipad_order_list_data->tr_waist;
                } else {
                    $meacheck_section_2_19_memo = $rojoipad_order_list_data->tr_waist;
                }

                if ((substr($rojoipad_order_list_data->tr_gluteus, 0, 1) === "+") || (substr($rojoipad_order_list_data->tr_gluteus, 0, 1) === "-") || ($rojoipad_order_list_data->tr_gluteus == "0")) {
                    $meacheck_section_2_20_memo = $trousers->gluteus + $rojoipad_order_list_data->tr_gluteus;
                } else {
                    $meacheck_section_2_20_memo = $rojoipad_order_list_data->tr_gluteus;
                }

                if ((substr($rojoipad_order_list_data->tr_thigh, 0, 1) === "+") || (substr($rojoipad_order_list_data->tr_thigh, 0, 1) === "-") || ($rojoipad_order_list_data->tr_thigh == "0")) {
                    $meacheck_section_2_21_memo = $trousers->thigh + $rojoipad_order_list_data->tr_thigh;
                } else {
                    $meacheck_section_2_21_memo = $rojoipad_order_list_data->tr_thigh;
                }


                if ((substr($rojoipad_order_list_data->tr_crotch_rise, 0, 1) === "+") || (substr($rojoipad_order_list_data->tr_crotch_rise, 0, 1) === "-") || ($rojoipad_order_list_data->tr_crotch_rise == "0")) {
                    $meacheck_section_2_22_memo = $trousers->crotch_rise + $rojoipad_order_list_data->tr_crotch_rise;
                } else {
                    $meacheck_section_2_22_memo = $rojoipad_order_list_data->tr_crotch_rise;
                }

                if ((substr($rojoipad_order_list_data->tr_crotch_front, 0, 1) === "+") || (substr($rojoipad_order_list_data->tr_crotch_front, 0, 1) === "-") || ($rojoipad_order_list_data->tr_crotch_front == "0")) {
                    $meacheck_section_2_22_1_memo = $trousers->front_crotch + $rojoipad_order_list_data->tr_crotch_front;
                } else {
                    $meacheck_section_2_22_1_memo = $rojoipad_order_list_data->tr_crotch_front;
                }

                if ((substr($rojoipad_order_list_data->tr_crotch_back, 0, 1) === "+") || (substr($rojoipad_order_list_data->tr_crotch_back, 0, 1) === "-") || ($rojoipad_order_list_data->tr_crotch_back == "0")) {
                    $meacheck_section_2_22_2_memo = $trousers->back_crotch + $rojoipad_order_list_data->tr_crotch_back;
                } else {
                    $meacheck_section_2_22_2_memo = $rojoipad_order_list_data->tr_crotch_back;
                }

                if ((substr($rojoipad_order_list_data->tr_hamstring, 0, 1) === "+") || (substr($rojoipad_order_list_data->tr_hamstring, 0, 1) === "-") || ($rojoipad_order_list_data->tr_hamstring == "0")) {
                    $meacheck_section_2_23_memo = $trousers->hamstring + $rojoipad_order_list_data->tr_hamstring;
                } else {
                    $meacheck_section_2_23_memo = $rojoipad_order_list_data->tr_hamstring;
                }

                if ((substr($rojoipad_order_list_data->tr_calf, 0, 1) === "+") || (substr($rojoipad_order_list_data->tr_calf, 0, 1) === "-") || ($rojoipad_order_list_data->tr_calf == "0")) {
                    $meacheck_section_2_24_memo = $trousers->calf + $rojoipad_order_list_data->tr_calf;
                } else {
                    $meacheck_section_2_24_memo = $rojoipad_order_list_data->tr_calf;
                }


                if ((substr($rojoipad_order_list_data->tr_ankle, 0, 1) === "+") || (substr($rojoipad_order_list_data->tr_ankle, 0, 1) === "-") || ($rojoipad_order_list_data->tr_ankle == "0")) {
                    $meacheck_section_2_25_memo = $trousers->ankle + $rojoipad_order_list_data->tr_ankle;
                } else {
                    $meacheck_section_2_25_memo = $rojoipad_order_list_data->tr_ankle;
                }

                if ((substr($rojoipad_order_list_data->wc_length, 0, 1) === "+") || (substr($rojoipad_order_list_data->wc_length, 0, 1) === "-") || ($rojoipad_order_list_data->wc_length == "0")) {
                    $meacheck_section_2_26_memo = $waistcoat->length + $rojoipad_order_list_data->wc_length;
                } else {
                    $meacheck_section_2_26_memo = $rojoipad_order_list_data->wc_length;
                }

                if ((substr($rojoipad_order_list_data->wc_shoulders, 0, 1) === "+") || (substr($rojoipad_order_list_data->wc_shoulders, 0, 1) === "-") || ($rojoipad_order_list_data->wc_shoulders == "0")) {
                    $meacheck_section_2_27_memo = $waistcoat->shoulders + $rojoipad_order_list_data->wc_shoulders;
                } else {
                    $meacheck_section_2_27_memo = $rojoipad_order_list_data->wc_shoulders;
                }

                if ((substr($rojoipad_order_list_data->wc_chest, 0, 1) === "+") || (substr($rojoipad_order_list_data->wc_chest, 0, 1) === "-") || ($rojoipad_order_list_data->wc_chest == "0")) {
                    $meacheck_section_2_28_memo = $waistcoat->chest + $rojoipad_order_list_data->wc_chest;
                } else {
                    $meacheck_section_2_28_memo = $rojoipad_order_list_data->wc_chest;
                }

                if ((substr($rojoipad_order_list_data->wc_chest_f, 0, 1) === "+") || (substr($rojoipad_order_list_data->wc_chest_f, 0, 1) === "-") || ($rojoipad_order_list_data->wc_chest_f == "0")) {
                    $meacheck_section_2_28_1_memo = $waistcoat->front_chest + $rojoipad_order_list_data->wc_chest_f;
                } else {
                    $meacheck_section_2_28_1_memo = $rojoipad_order_list_data->wc_chest_f;
                }


                if ((substr($rojoipad_order_list_data->wc_chest_b, 0, 1) === "+") || (substr($rojoipad_order_list_data->wc_chest_b, 0, 1) === "-") || ($rojoipad_order_list_data->wc_chest_b == "0")) {
                    $meacheck_section_2_28_2_memo = $waistcoat->back_chest + $rojoipad_order_list_data->wc_chest_b;
                } else {
                    $meacheck_section_2_28_2_memo = $rojoipad_order_list_data->wc_chest_b;
                }

                if ((substr($rojoipad_order_list_data->wc_bust, 0, 1) === "+") || (substr($rojoipad_order_list_data->wc_bust, 0, 1) === "-") || ($rojoipad_order_list_data->wc_bust == "0")) {
                    $meacheck_section_2_29_memo = $waistcoat->bust + $rojoipad_order_list_data->wc_bust;
                } else {
                    $meacheck_section_2_29_memo = $rojoipad_order_list_data->wc_bust;
                }


                if ((substr($rojoipad_order_list_data->wc_circumference, 0, 1) === "+") || (substr($rojoipad_order_list_data->wc_circumference, 0, 1) === "-") || ($rojoipad_order_list_data->wc_circumference == "0")) {
                    $meacheck_section_2_30_memo = $waistcoat->hips + $rojoipad_order_list_data->wc_circumference;
                } else {
                    $meacheck_section_2_30_memo = $rojoipad_order_list_data->wc_circumference;
                }


                $product_form_meacheck = array(
                    "product_id" => $qrcode_product_id,
                    "meacheck_section_1_1_memo" => !empty($rojoipad_order_list_data->ja_length) ? $jacket->length . '(' . $rojoipad_order_list_data->ja_length . ')' : $jacket->length . '(+0)',
                    "meacheck_section_1_2_memo" => !empty($rojoipad_order_list_data->ja_shoulders) ? $jacket->shoulders . '(' . $rojoipad_order_list_data->ja_shoulders . ')' : $jacket->shoulders . '(+0)',
                    "meacheck_section_1_3_memo" => !empty($rojoipad_order_list_data->ja_chest) ? $jacket->chest . '(' . $rojoipad_order_list_data->ja_chest . ')' : $jacket->chest . '(+0)',
                    "meacheck_section_1_3_1_memo" => !empty($rojoipad_order_list_data->ja_chest_f) ? $jacket->front_chest . '(' . $rojoipad_order_list_data->ja_chest_f . ')' : $jacket->front_chest . '(+0)',
                    "meacheck_section_1_3_2_memo" => !empty($rojoipad_order_list_data->ja_chest_b) ? $jacket->back_chest . '(' . $rojoipad_order_list_data->ja_chest_b . ')' : $jacket->back_chest . '(+0)',
                    "meacheck_section_1_4_memo" => !empty($rojoipad_order_list_data->ja_bust) ? $jacket->bust . '(' . $rojoipad_order_list_data->ja_bust . ')' : $jacket->bust . '(+0)',
                    "meacheck_section_1_5_memo" => !empty($rojoipad_order_list_data->ja_circumference) ? $jacket->hips . '(' . $rojoipad_order_list_data->ja_circumference . ')' : $jacket->hips . '(+0)',
                    "meacheck_section_1_6_memo" => !empty($rojoipad_order_list_data->ja_sleeve) ? $jacket->sleeve_length . '(' . $rojoipad_order_list_data->ja_sleeve . ')' : $jacket->sleeve_length . '(+0)',
                    "meacheck_section_1_7_memo" => !empty($rojoipad_order_list_data->ja_bicep) ? $jacket->bicep . '(' . $rojoipad_order_list_data->ja_bicep . ')' : $jacket->bicep . '(+0)',
                    "meacheck_section_1_8_memo" => !empty($rojoipad_order_list_data->ja_wrist) ? $jacket->wrist_cuff . '(' . $rojoipad_order_list_data->ja_wrist . ')' : $jacket->wrist_cuff . '(+0)',
                    "meacheck_section_1_9_memo" => !empty($rojoipad_order_list_data->sh_length) ? $shirt->length . '(' . $rojoipad_order_list_data->sh_length . ')' : $shirt->length . '(+0)',
                    "meacheck_section_1_10_memo" => !empty($rojoipad_order_list_data->sh_shoulders) ? $shirt->shoulders . '(' . $rojoipad_order_list_data->sh_shoulders . ')' : $shirt->shoulders . '(+0)',
                    "meacheck_section_1_11_memo" => !empty($rojoipad_order_list_data->sh_chest) ? $shirt->chest . '(' . $rojoipad_order_list_data->sh_chest . ')' : $shirt->chest . '(+0)',
                    "meacheck_section_1_11_1_memo" => !empty($rojoipad_order_list_data->sh_chest_f) ? $shirt->front_chest . '(' . $rojoipad_order_list_data->sh_chest_f . ')' : $shirt->front_chest . '(+0)',
                    "meacheck_section_1_11_2_memo" => !empty($rojoipad_order_list_data->sh_chest_b) ? $shirt->back_chest . '(' . $rojoipad_order_list_data->sh_chest_b . ')' : $shirt->back_chest . '(+0)',
                    "meacheck_section_1_12_memo" => !empty($rojoipad_order_list_data->sh_bust) ? $shirt->bust . '(' . $rojoipad_order_list_data->sh_bust . ')' : $shirt->bust . '(+0)',
                    "meacheck_section_1_13_memo" => !empty($rojoipad_order_list_data->sh_circumference) ? $shirt->hips . '(' . $rojoipad_order_list_data->sh_circumference . ')' : $shirt->hips . '(+0)',
                    "meacheck_section_1_14_memo" => !empty($rojoipad_order_list_data->sh_sleeve) ? $shirt->sleeve_length . '(' . $rojoipad_order_list_data->sh_sleeve . ')' : $shirt->sleeve_length . '(+0)',
                    "meacheck_section_1_15_memo" => !empty($rojoipad_order_list_data->sh_bicep) ? $shirt->bicep . '(' . $rojoipad_order_list_data->sh_bicep . ')' : $shirt->bicep . '(+0)',
                    "meacheck_section_1_16_memo" => !empty($rojoipad_order_list_data->sh_wrist) ? $shirt->wrist_cuff . '(' . $rojoipad_order_list_data->sh_wrist . ')' : $shirt->wrist_cuff . '(+0)',
                    "meacheck_section_1_17_memo" => !empty($rojoipad_order_list_data->sh_neck) ? $shirt->neck_cuff . '(' . $rojoipad_order_list_data->sh_neck . ')' : $shirt->neck_cuff . '(+0)',
                    "meacheck_section_1_18_memo" => !empty($rojoipad_order_list_data->tr_length) ? $trousers->length . '(' . $rojoipad_order_list_data->tr_length . ')' : $trousers->length . '(+0)',
                    "meacheck_section_1_19_memo" => !empty($rojoipad_order_list_data->tr_waist) ? $trousers->waist . '(' . $rojoipad_order_list_data->tr_waist . ')' : $trousers->waist . '(+0)',
                    "meacheck_section_1_20_memo" => !empty($rojoipad_order_list_data->tr_gluteus) ? $trousers->gluteus . '(' . $rojoipad_order_list_data->tr_gluteus . ')' : $trousers->gluteus . '(+0)',
                    "meacheck_section_1_21_memo" => !empty($rojoipad_order_list_data->tr_thigh) ? $trousers->thigh . '(' . $rojoipad_order_list_data->tr_thigh . ')' : $trousers->thigh . '(+0)',
                    "meacheck_section_1_22_memo" => !empty($rojoipad_order_list_data->tr_crotch_rise) ? $trousers->crotch_rise . '(' . $rojoipad_order_list_data->tr_crotch_rise . ')' : $trousers->crotch_rise . '(+0)',
                    "meacheck_section_1_22_1_memo" => !empty($rojoipad_order_list_data->tr_crotch_front) ? $trousers->front_crotch . '(' . $rojoipad_order_list_data->tr_crotch_front . ')' : $trousers->front_crotch . '(+0)',
                    "meacheck_section_1_22_2_memo" => !empty($rojoipad_order_list_data->tr_crotch_back) ? $trousers->back_crotch . '(' . $rojoipad_order_list_data->tr_crotch_back . ')' : $trousers->back_crotch . '(+0)',
                    "meacheck_section_1_23_memo" => !empty($rojoipad_order_list_data->tr_hamstring) ? $trousers->hamstring . '(' . $rojoipad_order_list_data->tr_hamstring . ')' : $trousers->hamstring . '(+0)',
                    "meacheck_section_1_24_memo" => !empty($rojoipad_order_list_data->tr_calf) ? $trousers->calf . '(' . $rojoipad_order_list_data->tr_calf . ')' : $trousers->calf . '(+0)',
                    "meacheck_section_1_25_memo" => !empty($rojoipad_order_list_data->tr_ankle) ? $trousers->ankle . '(' . $rojoipad_order_list_data->tr_ankle . ')' : $trousers->ankle . '(+0)',
                    "meacheck_section_1_26_memo" => !empty($rojoipad_order_list_data->wc_length) ? $waistcoat->length . '(' . $rojoipad_order_list_data->wc_length . ')' : $waistcoat->length . '(+0)',
                    "meacheck_section_1_27_memo" => !empty($rojoipad_order_list_data->wc_shoulders) ? $waistcoat->shoulders . '(' . $rojoipad_order_list_data->wc_shoulders . ')' : $waistcoat->shoulders . '(+0)',
                    "meacheck_section_1_28_memo" => !empty($rojoipad_order_list_data->wc_chest) ? $waistcoat->chest . '(' . $rojoipad_order_list_data->wc_chest . ')' : $waistcoat->chest . '(+0)',
                    "meacheck_section_1_28_1_memo" => !empty($rojoipad_order_list_data->wc_chest_f) ? $waistcoat->front_chest . '(' . $rojoipad_order_list_data->wc_chest_f . ')' : $waistcoat->front_chest . '(+0)',
                    "meacheck_section_1_28_2_memo" => !empty($rojoipad_order_list_data->wc_chest_b) ? $waistcoat->back_chest . '(' . $rojoipad_order_list_data->wc_chest_b . ')' : $waistcoat->back_chest . '(+0)',
                    "meacheck_section_1_29_memo" => !empty($rojoipad_order_list_data->wc_bust) ? $waistcoat->bust . '(' . $rojoipad_order_list_data->wc_bust . ')' : $waistcoat->bust . '(+0)',
                    "meacheck_section_1_30_memo" => !empty($rojoipad_order_list_data->wc_circumference) ? $waistcoat->hips . '(' . $rojoipad_order_list_data->wc_circumference . ')' : $waistcoat->hips . '(+0)',
                    "meacheck_section_2_1_memo" => $meacheck_section_2_1_memo,
                    "meacheck_section_2_2_memo" => $meacheck_section_2_2_memo,
                    "meacheck_section_2_3_memo" => $meacheck_section_2_3_memo,
                    "meacheck_section_2_3_1_memo" => $meacheck_section_2_3_1_memo,
                    "meacheck_section_2_3_2_memo" => $meacheck_section_2_3_2_memo,
                    "meacheck_section_2_4_memo" => $meacheck_section_2_4_memo,
                    "meacheck_section_2_5_memo" => $meacheck_section_2_5_memo,
                    "meacheck_section_2_6_memo" => $meacheck_section_2_6_memo,
                    "meacheck_section_2_7_memo" => $meacheck_section_2_7_memo,
                    "meacheck_section_2_8_memo" => $meacheck_section_2_8_memo,
                    "meacheck_section_2_9_memo" => $meacheck_section_2_9_memo,
                    "meacheck_section_2_10_memo" => $meacheck_section_2_10_memo,
                    "meacheck_section_2_11_memo" => $meacheck_section_2_11_memo,
                    "meacheck_section_2_11_1_memo" => $meacheck_section_2_11_1_memo,
                    "meacheck_section_2_11_2_memo" => $meacheck_section_2_11_2_memo,
                    "meacheck_section_2_12_memo" => $meacheck_section_2_12_memo,
                    "meacheck_section_2_13_memo" => $meacheck_section_2_13_memo,
                    "meacheck_section_2_14_memo" => $meacheck_section_2_14_memo,
                    "meacheck_section_2_15_memo" => $meacheck_section_2_15_memo,
                    "meacheck_section_2_16_memo" => $meacheck_section_2_16_memo,
                    "meacheck_section_2_17_memo" => $meacheck_section_2_17_memo,
                    "meacheck_section_2_18_memo" => $meacheck_section_2_18_memo,
                    "meacheck_section_2_19_memo" => $meacheck_section_2_19_memo,
                    "meacheck_section_2_20_memo" => $meacheck_section_2_20_memo,
                    "meacheck_section_2_21_memo" => $meacheck_section_2_21_memo,
                    "meacheck_section_2_22_memo" => $meacheck_section_2_22_memo,
                    "meacheck_section_2_22_1_memo" => $meacheck_section_2_22_1_memo,
                    "meacheck_section_2_22_2_memo" => $meacheck_section_2_22_2_memo,
                    "meacheck_section_2_23_memo" => $meacheck_section_2_23_memo,
                    "meacheck_section_2_24_memo" => $meacheck_section_2_24_memo,
                    "meacheck_section_2_25_memo" => $meacheck_section_2_25_memo,
                    "meacheck_section_2_26_memo" => $meacheck_section_2_26_memo,
                    "meacheck_section_2_27_memo" => $meacheck_section_2_27_memo,
                    "meacheck_section_2_28_memo" => $meacheck_section_2_28_memo,
                    "meacheck_section_2_28_1_memo" => $meacheck_section_2_28_1_memo,
                    "meacheck_section_2_28_2_memo" => $meacheck_section_2_28_2_memo,
                    "meacheck_section_2_29_memo" => $meacheck_section_2_29_memo,
                    "meacheck_section_2_30_memo" => $meacheck_section_2_30_memo,
                );

                $this->db->insert('ipadqrcode_product_form_meacheck', $product_form_meacheck);
                //$this->db->update(DB_PRE().'order', array('qrcode_product_id'=>$qrcode_product_id), array('order_id'=>$order_id));
                //给该用户创建一个二维码订单----END


                //正常返回数据(json)
                $rearr = array('status' => '1', 'statusmsg' => 'success');
                echo json_encode($rearr);
            }

        } else {
            //订单不存在!
            $rearr = array('status' => '107', 'statusmsg' => 'order not exists');
            echo json_encode($rearr);
            exit;
            return;//终止
        }
    }

    //调用示例: http://www.rjclothing.cn/rojoipad/index.php/api/order/saveorder_images?partner_id=9153664774858319&partner_key=bBKJeYBcQRCM2QtPf2pat0999QTDganW&uid=1&randkey=oQqoHfEgrF0I9MTfgg4G1I82HDDk1Egf&order_id=9&order_key=oesPvy9phNXcayRuCaTaExG5TZPJjUpy&image_file&lang=en&version=iOS_v_1.6.5
    //Author: Mbilal
    //Date: 2020-06-04
    function saveorder_images()
    {
        // 接受参数-- START
        $partner_id = $this->input->post('partner_id');// Partner ID
        $partner_key = $this->input->post('partner_key');// Partner KEY

        $version = $this->input->post('version'); // 版本
        $lang = $this->input->post('lang');// 语言
        if ($lang == 'ch') {
            $langtype = '_ch';// 语言
        } else {
            $langtype = '_en';// 语言
        }

        $uid = $this->input->post('uid');
        $randkey = $this->input->post('randkey');
        $order_id = $this->input->post('order_id');
        $order_key = $this->input->post('order_key');
        $image = ($_FILES ['image']) ? $_FILES ['image'] : '';

        $con = array('partner_id' => $partner_id, 'partner_key' => $partner_key);
        $this->ApiModel->checknormalaction($con);

        if ($uid == '' || $order_id == '' || $order_key == '' || $image == '' || $lang == '' || $version == '') {
            //参数错误--缺少必要的参数
            $rearr = array('status' => '103', 'statusmsg' => 'parameter error');
            echo json_encode($rearr);
            exit;//终止
        }

        if (!is_numeric($uid) || $uid <= 0 || !is_numeric($order_id) || $order_id <= 0) {
            //参数错误--$uid, $order_id 必须为:正整数
            $rearr = array('status' => '104', 'statusmsg' => 'parameter invalid');
            echo json_encode($rearr);
            exit;//终止
        }

        $sql = "SELECT * FROM " . DB_PRE() . "user_list WHERE uid=" . $uid;
        $check_userinfo = $this->db->query($sql)->row_array();

        if (empty($check_userinfo)) {
            //用户不存在!
            $rearr = array('status' => '105', 'statusmsg' => 'account not exists');
            echo json_encode($rearr);
            exit;//终止
        }

        if ($check_userinfo['randkey'] != $randkey) {
            //非法操作--用户 randkey 错误
            $rearr = array('status' => '106', 'statusmsg' => 'Illegal Operation');
            echo json_encode($rearr);
            exit;//终止
        }

        $orderinfo = $this->OrderModel->verify_order($order_id, $uid);
        if ($orderinfo) {
            if ($orderinfo['order_key'] != $order_key) {
                //非法操作--Order Key 错误
                $rearr = array('status' => '108', 'statusmsg' => 'Illegal Operation');
                echo json_encode($rearr);
                exit;//终止
            } else {
                $imagename = explode('.', $image ['name']);
                $image ['name'] = time() . rand(0, 1000) . '.' . $imagename [count($imagename) - 1];

                $uploaddir = "upload/order_images";
                if (!is_dir($uploaddir)) {
                    mkdir($uploaddir, 0777, true);
                }
                $path = $uploaddir . '/' . $image ['name'];
                if (file_exists($path)) {
                    $path = 'upload/' . '(new)' . $image ['name'];
                }
                $this->db->from('settings');
                $this->db->where('name', 'tinify_api');
                $query = $this->db->get();
                $tinify_api = $query->row();
                if (isset($tinify_api) && $tinify_api->status == 1) {
                    require_once(BASEPATH . "/../../vendor/tinify/tinify/lib/Tinify/Exception.php");
                    require_once(BASEPATH . "/../../vendor/tinify/tinify/lib/Tinify/ResultMeta.php");
                    require_once(BASEPATH . "/../../vendor/tinify/tinify/lib/Tinify/Result.php");
                    require_once(BASEPATH . "/../../vendor/tinify/tinify/lib/Tinify/Source.php");
                    require_once(BASEPATH . "/../../vendor/tinify/tinify/lib/Tinify/Client.php");
                    require_once(BASEPATH . "/../../vendor/tinify/tinify/lib/Tinify.php");
                    try {
                        setKey(getenv('TINIFY_KEY'));
                        /*
                         * Compressing image from file
                        $source = fromFile($path);
                        $preserved_image = $source->preserve("copyright", "creation");
                        $preserved_image->toFile($path);
                        */

                        //Compressing image from binary
                        $sourceData = file_get_contents($image ['tmp_name']);
                        $resultData = fromBuffer($sourceData)->toBuffer();
                        $file_w = fopen($path, 'w+');
                        fwrite($file_w, $resultData);
                        fclose($file_w);
                    } catch (AccountException $e) {
                        echo json_encode("The error message is: " . $e->getMessage());
                        exit;
                    } catch (ClientException $e) {
                        echo json_encode("The error message is: " . $e->getMessage());
                        exit;
                    } catch (ServerException $e) {
                        echo json_encode("The error message is: " . $e->getMessage());
                        exit;
                    } catch (ConnectionException $e) {
                        echo json_encode("The error message is: " . $e->getMessage());
                        exit;
                    } catch (Exception $e) {
                        echo json_encode("The error message is: " . $e->getMessage());
                        exit;
                    }
                } else {
                    move_uploaded_file($image ['tmp_name'], $path);
                }
                $arr = array();
                $arr['order_id'] = $order_id;
                $arr['order_key'] = $order_key;
                $arr['uid'] = $uid;
                $arr['image'] = $path;
                if ($this->OrderModel->add_order_image($arr) > 0) {
                    //正常返回数据(json)
                    $rearr = array('status' => '1', 'statusmsg' => 'success');
                    echo json_encode($rearr);
                    exit;
                } else {
                    //订单不存在!
                    $rearr = array('status' => '107', 'statusmsg' => "Something went wrong, image record couldn't save");
                    echo json_encode($rearr);
                    exit;//终止
                }
            }
        } else {
            //订单不存在!
            $rearr = array('status' => '107', 'statusmsg' => 'order not exists');
            echo json_encode($rearr);
            exit;//终止
        }
    }

    //调用示例: http://www.rjclothing.cn/rojoipad/index.php/api/order/getorder_images?partner_id=9153664774858319&partner_key=bBKJeYBcQRCM2QtPf2pat0999QTDganW&uid=1&randkey=oQqoHfEgrF0I9MTfgg4G1I82HDDk1Egf&order_id=9&&lang=en&version=iOS_v_1.6.5
    //Author: Mbilal
    //Date: 2020-06-04
    function getorder_images()
    {
        // 接受参数-- START
        $partner_id = $this->input->post('partner_id');// Partner ID
        $partner_key = $this->input->post('partner_key');// Partner KEY

        $version = $this->input->post('version'); // 版本
        $lang = $this->input->post('lang');// 语言
        if ($lang == 'ch') {
            $langtype = '_ch';// 语言
        } else {
            $langtype = '_en';// 语言
        }

        $uid = $this->input->post('uid');
        $randkey = $this->input->post('randkey');
        $order_id = $this->input->post('order_id');

        $con = array('partner_id' => $partner_id, 'partner_key' => $partner_key);
        $this->ApiModel->checknormalaction($con);

        if ($uid == '' || $order_id == '' || $lang == '' || $version == '') {
            //参数错误--缺少必要的参数
            $rearr = array('status' => '103', 'statusmsg' => 'parameter error');
            echo json_encode($rearr);
            exit;//终止
        }

        if (!is_numeric($uid) || $uid <= 0 || !is_numeric($order_id) || $order_id <= 0) {
            //参数错误--$uid, $order_id 必须为:正整数
            $rearr = array('status' => '104', 'statusmsg' => 'parameter invalid');
            echo json_encode($rearr);
            exit;//终止
        }

        $sql = "SELECT * FROM " . DB_PRE() . "user_list WHERE uid=" . $uid;
        $check_userinfo = $this->db->query($sql)->row_array();

        if (empty($check_userinfo)) {
            //用户不存在!
            $rearr = array('status' => '105', 'statusmsg' => 'account not exists');
            echo json_encode($rearr);
            exit;//终止
        }

        if ($check_userinfo['randkey'] != $randkey) {
            //非法操作--用户 randkey 错误
            $rearr = array('status' => '106', 'statusmsg' => 'Illegal Operation');
            echo json_encode($rearr);
            exit;//终止
        }
        $images_data = $this->OrderModel->get_order_images($order_id, $uid);
        $rearr = array('status' => '1', 'statusmsg' => 'success', 'data' => $images_data);
        echo json_encode($rearr);
        exit;
    }

    //调用示例: http://www.rjclothing.cn/rojoipad/index.php/api/order/saveorder_notes?partner_id=9153664774858319&partner_key=bBKJeYBcQRCM2QtPf2pat0999QTDganW&uid=1&randkey=oQqoHfEgrF0I9MTfgg4G1I82HDDk1Egf&order_id=9&order_key=oesPvy9phNXcayRuCaTaExG5TZPJjUpy&note=TestOrderNote&lang=en&version=iOS_v_1.6.5
    //Author: Mbilal
    //Date: 2020-08-31
    function saveorder_notes()
    {
        // 接受参数-- START
        $partner_id = $this->input->post('partner_id');// Partner ID
        $partner_key = $this->input->post('partner_key');// Partner KEY

        $version = $this->input->post('version'); // 版本
        $lang = $this->input->post('lang');// 语言
        if ($lang == 'ch') {
            $langtype = '_ch';// 语言
        } else {
            $langtype = '_en';// 语言
        }

        $uid = $this->input->post('uid');
        $randkey = $this->input->post('randkey');
        $order_id = $this->input->post('order_id');
        $order_key = $this->input->post('order_key');
        $note = $this->input->post('note');

        $con = array('partner_id' => $partner_id, 'partner_key' => $partner_key);
        $this->ApiModel->checknormalaction($con);

        if ($uid == '' || $order_id == '' || $order_key == '' || $note == '' || $lang == '' || $version == '') {
            //参数错误--缺少必要的参数
            $rearr = array('status' => '103', 'statusmsg' => 'parameter error');
            echo json_encode($rearr);
            exit;//终止
        }

        if (!is_numeric($uid) || $uid <= 0 || !is_numeric($order_id) || $order_id <= 0) {
            //参数错误--$uid, $order_id 必须为:正整数
            $rearr = array('status' => '104', 'statusmsg' => 'parameter invalid');
            echo json_encode($rearr);
            exit;//终止
        }

        $sql = "SELECT * FROM " . DB_PRE() . "user_list WHERE uid=" . $uid;
        $check_userinfo = $this->db->query($sql)->row_array();

        if (empty($check_userinfo)) {
            //用户不存在!
            $rearr = array('status' => '105', 'statusmsg' => 'account not exists');
            echo json_encode($rearr);
            exit;//终止
        }

        if ($check_userinfo['randkey'] != $randkey) {
            //非法操作--用户 randkey 错误
            $rearr = array('status' => '106', 'statusmsg' => 'Illegal Operation');
            echo json_encode($rearr);
            exit;//终止
        }

        $orderinfo = $this->OrderModel->verify_order($order_id, $uid);
        if ($orderinfo) {
            if ($orderinfo['order_key'] != $order_key) {
                //非法操作--Order Key 错误
                $rearr = array('status' => '108', 'statusmsg' => 'Illegal Operation');
                echo json_encode($rearr);
                exit;//终止
            } else {
                $order_notes = $this->OrderModel->get_order_notes($order_id, $uid);
                if (is_array($order_notes) && count($order_notes) >= 2) {
                    //订单不存在!
                    $rearr = array('status' => '109', 'statusmsg' => "This order already reached maximum limit of 2 notes.");
                    echo json_encode($rearr);
                    exit;//终止
                }
                $arr = array();
                $arr['order_id'] = $order_id;
                $arr['order_key'] = $order_key;
                $arr['uid'] = $uid;
                $arr['note'] = $note;
                if ($this->OrderModel->add_order_note($arr) > 0) {
                    //正常返回数据(json)
                    $rearr = array('status' => '1', 'statusmsg' => 'success');
                    echo json_encode($rearr);
                    exit;
                } else {
                    //订单不存在!
                    $rearr = array('status' => '107', 'statusmsg' => "Something went wrong, note record couldn't save");
                    echo json_encode($rearr);
                    exit;//终止
                }
            }
        } else {
            //订单不存在!
            $rearr = array('status' => '107', 'statusmsg' => 'order not exists');
            echo json_encode($rearr);
            exit;//终止
        }
    }

    //调用示例: http://www.rjclothing.cn/rojoipad/index.php/api/order/editorder_notes?partner_id=9153664774858319&partner_key=bBKJeYBcQRCM2QtPf2pat0999QTDganW&uid=1&randkey=oQqoHfEgrF0I9MTfgg4G1I82HDDk1Egf&order_id&note_id=1&note=TestUpdatedNote&lang=en&version=iOS_v_1.6.5
    //Author: Mbilal
    //Date: 2020-08-31
    function editorder_notes()
    {
        // 接受参数-- START
        $partner_id = $this->input->post('partner_id');// Partner ID
        $partner_key = $this->input->post('partner_key');// Partner KEY

        $version = $this->input->post('version'); // 版本
        $lang = $this->input->post('lang');// 语言
        if ($lang == 'ch') {
            $langtype = '_ch';// 语言
        } else {
            $langtype = '_en';// 语言
        }

        $uid = $this->input->post('uid');
        $randkey = $this->input->post('randkey');
        $order_id = $this->input->post('order_id');
        $note_id = $this->input->post('note_id');
        $note = $this->input->post('note');

        $con = array('partner_id' => $partner_id, 'partner_key' => $partner_key);
        $this->ApiModel->checknormalaction($con);

        if ($uid == '' || $order_id == '' || $note_id == '' || $note == '' || $lang == '' || $version == '') {
            //参数错误--缺少必要的参数
            $rearr = array('status' => '103', 'statusmsg' => 'parameter error');
            echo json_encode($rearr);
            exit;//终止
        }

        if (!is_numeric($uid) || $uid <= 0 || !is_numeric($order_id) || $order_id <= 0 || !is_numeric($note_id) || $note_id <= 0 || empty($note)) {
            //参数错误--$uid, $order_id 必须为:正整数
            $rearr = array('status' => '104', 'statusmsg' => 'parameter invalid');
            echo json_encode($rearr);
            exit;//终止
        }

        $sql = "SELECT * FROM " . DB_PRE() . "user_list WHERE uid=" . $uid;
        $check_userinfo = $this->db->query($sql)->row_array();

        if (empty($check_userinfo)) {
            //用户不存在!
            $rearr = array('status' => '105', 'statusmsg' => 'account not exists');
            echo json_encode($rearr);
            exit;//终止
        }

        if ($check_userinfo['randkey'] != $randkey) {
            //非法操作--用户 randkey 错误
            $rearr = array('status' => '106', 'statusmsg' => 'Illegal Operation');
            echo json_encode($rearr);
            exit;//终止
        }
        $this->OrderModel->update_order_note(array('order_id' => $order_id, 'note_id' => $note_id), $note);
        $rearr = array('status' => '1', 'statusmsg' => 'success');
        echo json_encode($rearr);
        exit;
    }

    //调用示例: http://www.rjclothing.cn/rojoipad/index.php/api/order/getorder_notes?partner_id=9153664774858319&partner_key=bBKJeYBcQRCM2QtPf2pat0999QTDganW&uid=1&randkey=oQqoHfEgrF0I9MTfgg4G1I82HDDk1Egf&order_id=9&&lang=en&version=iOS_v_1.6.5
    //Author: Mbilal
    //Date: 2020-08-31
    function getorder_notes()
    {
        // 接受参数-- START
        $partner_id = $this->input->post('partner_id');// Partner ID
        $partner_key = $this->input->post('partner_key');// Partner KEY

        $version = $this->input->post('version'); // 版本
        $lang = $this->input->post('lang');// 语言
        if ($lang == 'ch') {
            $langtype = '_ch';// 语言
        } else {
            $langtype = '_en';// 语言
        }

        $uid = $this->input->post('uid');
        $randkey = $this->input->post('randkey');
        $order_id = $this->input->post('order_id');

        $con = array('partner_id' => $partner_id, 'partner_key' => $partner_key);
        $this->ApiModel->checknormalaction($con);

        if ($uid == '' || $order_id == '' || $lang == '' || $version == '') {
            //参数错误--缺少必要的参数
            $rearr = array('status' => '103', 'statusmsg' => 'parameter error');
            echo json_encode($rearr);
            exit;//终止
        }

        if (!is_numeric($uid) || $uid <= 0 || !is_numeric($order_id) || $order_id <= 0) {
            //参数错误--$uid, $order_id 必须为:正整数
            $rearr = array('status' => '104', 'statusmsg' => 'parameter invalid');
            echo json_encode($rearr);
            exit;//终止
        }

        $sql = "SELECT * FROM " . DB_PRE() . "user_list WHERE uid=" . $uid;
        $check_userinfo = $this->db->query($sql)->row_array();

        if (empty($check_userinfo)) {
            //用户不存在!
            $rearr = array('status' => '105', 'statusmsg' => 'account not exists');
            echo json_encode($rearr);
            exit;//终止
        }

        if ($check_userinfo['randkey'] != $randkey) {
            //非法操作--用户 randkey 错误
            $rearr = array('status' => '106', 'statusmsg' => 'Illegal Operation');
            echo json_encode($rearr);
            exit;//终止
        }
        $notes_data = $this->OrderModel->get_order_notes($order_id, $uid);
        $rearr = array('status' => '1', 'statusmsg' => 'success', 'data' => $notes_data);
        echo json_encode($rearr);
        exit;
    }

    //调用示例: http://www.rjclothing.cn/rojoipad/index.php/api/order/getorderlist?partner_id=9153664774858319&partner_key=bBKJeYBcQRCM2QtPf2pat0999QTDganW&uid=1&randkey=oQqoHfEgrF0I9MTfgg4G1I82HDDk1Egf&order_status=1&lang=en&version=iOS_v_1.6.5
    //Author: gksel
    //Date: 2015-08-20
    function getorderlist()
    {
        // 接受参数-- START
        $partner_id = $this->input->get('partner_id');// Partner ID
        $partner_key = $this->input->get('partner_key');// Partner KEY

        $version = $this->input->get('version'); // 版本
        $lang = $this->input->get('lang');// 语言
        if ($lang == 'ch') {
            $langtype = '_ch';// 语言
        } else {
            $langtype = '_en';// 语言
        }

        $uid = $this->input->get('uid');

        $isadmin = $this->input->get('isadmin');

        $randkey = $this->input->get('randkey');

        $order_status = $this->input->get('order_status');

        $orderby = $this->input->get('orderby');
        $orderby_res = $this->input->get('orderby_res');

        // 接受参数-- END

        $con = array('partner_id' => $partner_id, 'partner_key' => $partner_key);
        $this->ApiModel->checknormalaction($con);

        if ($uid == '' || $randkey == '' || $lang == '' || $version == '') {
            //参数错误--缺少必要的参数
            $rearr = array('status' => '103', 'statusmsg' => 'parameter error');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

        if (!is_numeric($uid) || $uid <= 0) {
            //参数错误--$uid 必须为:正整数
            $rearr = array('status' => '104', 'statusmsg' => 'parameter invalid');
            echo json_encode($rearr);
            exit;
            return;//终止
        }


        if ($isadmin > 0) {
            $sql = "SELECT * FROM " . DB_PRE() . "admin_list WHERE admin_id=" . $uid;
            $check_userinfo = $this->db->query($sql)->row_array();
        } else {
            $sql = "SELECT * FROM " . DB_PRE() . "user_list WHERE uid=" . $uid;
            $check_userinfo = $this->db->query($sql)->row_array();
        }

        if (empty($check_userinfo)) {
            //用户不存在!
            $rearr = array('status' => '105', 'statusmsg' => 'account not exists');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

        if (isset($check_userinfo['randkey']) && $check_userinfo['randkey'] != $randkey && $isadmin == 0) {
            //非法操作--用户 randkey 错误
            $rearr = array('status' => '106', 'statusmsg' => 'Illegal Operation');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

        $con = array('uid' => $uid, 'isadmin' => $isadmin);

        if ($orderby == 'client_name') {
            if (strtoupper($orderby_res) == 'ASC') {
                $con['orderby'] = 'c.user_realname';
                $con['orderby_res'] = $orderby_res;
            } else if (strtoupper($orderby_res) == 'DESC') {
                $con['orderby'] = 'c.user_realname';
                $con['orderby_res'] = $orderby_res;
            } else {
                $con['orderby'] = 'o.order_id';
                $con['orderby_res'] = 'DESC';
            }
        } else {
            $con['orderby'] = 'o.order_id';
            $con['orderby_res'] = 'DESC';
        }


        if ($order_status == 1) {
            //当前订单
            $con['status'] = 4;
        } else {
            //历史订单
            $con['status'] = 5;
        }
        $orderlist = $this->OrderModel->getorderlist($con);

        //正常返回数据(json)
        $newre = array();
        if (!empty($orderlist)) {
            for ($i = 0; $i < count($orderlist); $i++) {
                $thisarr = array();
                $thisarr['order_id'] = $orderlist[$i]['order_id'];
                $thisarr['order_key'] = $orderlist[$i]['order_key'];
                $thisarr['order_number'] = $orderlist[$i]['order_number'];
                $thisarr['user_realname'] = $orderlist[$i]['user_realname'];


                $thisarr['client_id'] = $orderlist[$i]['client_id'];
                $thisarr['client_key'] = $orderlist[$i]['client_key'];
                $thisarr['client_number'] = $orderlist[$i]['newclient_number'];
                $thisarr['client_realname'] = $orderlist[$i]['client_realname'];
                $thisarr['client_address'] = $orderlist[$i]['client_address'];
                $thisarr['client_email'] = $orderlist[$i]['client_email'];
                $thisarr['client_industry'] = $orderlist[$i]['client_industry'];
                $thisarr['client_wechat'] = $orderlist[$i]['client_wechat'];
                $thisarr['client_phone'] = $orderlist[$i]['client_phone'];
                $thisarr['client_birthday'] = $orderlist[$i]['client_birthday'];
                $thisarr['client_nationality'] = $orderlist[$i]['client_nationality'];

                $thisarr['totalPoint'] = $orderlist[$i]['totalPoint'];

                $thisarr['retail_point'] = $orderlist[$i]['retail_point'];
                $thisarr['wholesale_point'] = $orderlist[$i]['wholesale_point'];

                $thisarr['order_created'] = $orderlist[$i]['created'];
                if ($orderlist[$i]['delivery_time'] == 0) {
                    $thisarr['arrival_time'] = $orderlist[$i]['created'];
                } else {
                    $thisarr['arrival_time'] = $orderlist[$i]['delivery_time'];
                }

                if ($orderlist[$i]['delivery_time'] == 0) {
                    $thisarr['delivery_time'] = $orderlist[$i]['created'];
                } else {
                    $thisarr['delivery_time'] = $orderlist[$i]['delivery_time'];
                }


                $newre[] = $thisarr;
            }
        }
        /*echo '<pre>';
        print_r($newre);
        exit;*/
        $rearr = array('status' => '1', 'statusmsg' => 'success', 'data' => $newre);
        echo json_encode($rearr);
    }

    function getversioninfo()
    {
        $sql = $this->db->query("select version from tblversion where id=1");
        echo json_encode($sql->row()->version);
    }

    //调用示例: http://www.rjclothing.cn/rojoipad/index.php/api/order/getorderinfo?partner_id=9153664774858319&partner_key=bBKJeYBcQRCM2QtPf2pat0999QTDganW&uid=1&randkey=oQqoHfEgrF0I9MTfgg4G1I82HDDk1Egf&order_id=9&order_key=oesPvy9phNXcayRuCaTaExG5TZPJjUpy&lang=en&version=iOS_v_1.6.5
    //Author: gksel
    //Date: 2015-08-20
    function getorderinfo()
    {
        // 接受参数-- START

        /*echo '<pre>';
        print_r($this->input->get());
        exit;*/
        $partner_id = $this->input->get('partner_id');// Partner ID
        $partner_key = $this->input->get('partner_key');// Partner KEY

        $version = $this->input->get('version'); // 版本
        $lang = $this->input->get('lang');// 语言

        $isadmin = $this->input->get('isadmin');// 语言

        if ($lang == 'ch') {
            $langtype = '_ch';// 语言
        } else {
            $langtype = '_en';// 语言
        }

        $uid = $this->input->get('uid');
        $randkey = $this->input->get('randkey');

        $order_id = $this->input->get('order_id');
        $order_key = $this->input->get('order_key');

        // 接受参数-- END

        $con = array('partner_id' => $partner_id, 'partner_key' => $partner_key);
        $this->ApiModel->checknormalaction($con);


        if ($uid == '' || $randkey == '' || $order_id == '' || $order_key == '' || $lang == '' || $version == '') {
            //参数错误--缺少必要的参数
            $rearr = array('status' => '103', 'statusmsg' => 'parameter error');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

        if (!is_numeric($uid) || $uid <= 0 || !is_numeric($order_id) || $order_id <= 0) {
            //参数错误--$uid, $order_id 必须为:正整数
            $rearr = array('status' => '104', 'statusmsg' => 'parameter invalid');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

        if ($isadmin > 0) {
            $sql = "SELECT * FROM " . DB_PRE() . "admin_list WHERE admin_id=" . $uid;
            $check_userinfo = $this->db->query($sql)->row_array();
        } else {
            $sql = "SELECT * FROM " . DB_PRE() . "user_list WHERE uid=" . $uid;
            $check_userinfo = $this->db->query($sql)->row_array();
        }
        /*echo '<pre>';
        print_r($check_userinfo);
        exit;*/
        if (empty($check_userinfo)) {
            //用户不存在!
            $rearr = array('status' => '105', 'statusmsg' => 'account not exists');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

        if (isset($check_userinfo['randkey']) && $check_userinfo['randkey'] != $randkey && $isadmin == 0) {
            //非法操作--用户 randkey 错误
            $rearr = array('status' => '106', 'statusmsg' => 'Illegal Operation');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

        $orderinfo = $this->OrderModel->getorderinfo($order_id, $isadmin, $uid);


        #print_r($orderinfo);exit;
        /*foreach ($orderinfo['order_list'] as $value){
            #print_r($value);#exit;
            foreach($value as $key => $value1){
                #echo $key." - ".$value1;exit;
                $value[$key] = "10";
            }
            print_r($value);exit;
            $count_a = count($value);
            #for($i=0; $i < $count_a; $i++){
            #    echo $value[$i];exit;
            #    #$orderinfo['order_list'][$i] = $orderinfo['order_list'][$i].trim();
            #}
        }*/

        /*$orderinfo['order_list']['0']['code_suit'] = trim($orderinfo['order_list']['0']['code_suit']);
        $orderinfo['order_list']['0']['code_waistcoat'] = trim($orderinfo['order_list']['0']['code_waistcoat']);
        $orderinfo['order_list']['0']['code_trousers'] = trim($orderinfo['order_list']['0']['code_trousers']);
        $orderinfo['order_list']['0']['code_shirt'] = trim($orderinfo['order_list']['0']['code_shirt']);
        $orderinfo['order_list']['0']['code_overcoat'] = trim($orderinfo['order_list']['0']['code_overcoat']);
        $orderinfo['order_list']['0']['code_suit_select'] = trim($orderinfo['order_list']['0']['code_suit_select']);
        $orderinfo['order_list']['0']['code_waistcoat_select'] = trim($orderinfo['order_list']['0']['code_waistcoat_select']);
        $orderinfo['order_list']['0']['code_trousers_select'] = trim($orderinfo['order_list']['0']['code_trousers_select']);
        $orderinfo['order_list']['0']['code_shirt_select'] = trim($orderinfo['order_list']['0']['code_shirt_select']);
        $orderinfo['order_list']['0']['code_overcoat_select'] = trim($orderinfo['order_list']['0']['code_overcoat_select']);
        $orderinfo['order_list']['0']['code_jacket'] = trim($orderinfo['order_list']['0']['code_jacket']);
        $orderinfo['order_list']['0']['code_jacket_select'] = trim($orderinfo['order_list']['0']['code_jacket_select']);
        $orderinfo['order_list']['0']['ja_garment'] = trim($orderinfo['order_list']['0']['ja_garment']);
        $orderinfo['order_list']['0']['ja_length'] = trim($orderinfo['order_list']['0']['ja_length']);
        $orderinfo['order_list']['0']['ja_shoulders'] = trim($orderinfo['order_list']['0']['ja_shoulders']);
        $orderinfo['order_list']['0']['ja_chest'] = trim($orderinfo['order_list']['0']['ja_chest']);
        $orderinfo['order_list']['0']['ja_chest_f'] = trim($orderinfo['order_list']['0']['ja_chest_f']);
        $orderinfo['order_list']['0']['ja_chest_b'] = trim($orderinfo['order_list']['0']['ja_chest_b']);
        $orderinfo['order_list']['0']['ja_bust'] = trim($orderinfo['order_list']['0']['ja_bust']);
        $orderinfo['order_list']['0']['ja_circumference'] = trim($orderinfo['order_list']['0']['ja_circumference']);
        $orderinfo['order_list']['0']['ja_sleeve'] = trim($orderinfo['order_list']['0']['ja_sleeve']);
        $orderinfo['order_list']['0']['ja_bicep'] = trim($orderinfo['order_list']['0']['ja_bicep']);
        $orderinfo['order_list']['0']['ja_wrist'] = trim($orderinfo['order_list']['0']['ja_wrist']);
        $orderinfo['order_list']['0']['ja_neck'] = trim($orderinfo['order_list']['0']['ja_neck']);
        $orderinfo['order_list']['0']['sh_garment'] = trim($orderinfo['order_list']['0']['sh_garment']);
        $orderinfo['order_list']['0']['sh_length'] = trim($orderinfo['order_list']['0']['sh_length']);
        $orderinfo['order_list']['0']['sh_shoulders'] = trim($orderinfo['order_list']['0']['sh_shoulders']);
        $orderinfo['order_list']['0']['sh_chest'] = trim($orderinfo['order_list']['0']['sh_chest']);
        $orderinfo['order_list']['0']['sh_chest_f'] = trim($orderinfo['order_list']['0']['code_suit']);
        $orderinfo['order_list']['0']['sh_chest_b'] = trim($orderinfo['order_list']['0']['sh_chest_b']);
        $orderinfo['order_list']['0']['sh_bust'] = trim($orderinfo['order_list']['0']['sh_bust']);
        $orderinfo['order_list']['0']['sh_circumference'] = trim($orderinfo['order_list']['0']['sh_circumference']);
        $orderinfo['order_list']['0']['sh_sleeve'] = trim($orderinfo['order_list']['0']['sh_sleeve']);
        $orderinfo['order_list']['0']['sh_bicep'] = trim($orderinfo['order_list']['0']['sh_bicep']);
        $orderinfo['order_list']['0']['sh_wrist'] = trim($orderinfo['order_list']['0']['sh_wrist']);
        $orderinfo['order_list']['0']['sh_neck'] = trim($orderinfo['order_list']['0']['sh_neck']);
        $orderinfo['order_list']['0']['wc_garment'] = trim($orderinfo['order_list']['0']['wc_garment']);
        $orderinfo['order_list']['0']['wc_length'] = trim($orderinfo['order_list']['0']['wc_length']);
        $orderinfo['order_list']['0']['wc_shoulders'] = trim($orderinfo['order_list']['0']['wc_shoulders']);
        $orderinfo['order_list']['0']['wc_chest'] = ltrim($orderinfo['order_list']['0']['wc_chest']);
        #echo $orderinfo['order_list']['0']['wc_chest'];
        $orderinfo['order_list']['0']['wc_chest_f'] = trim($orderinfo['order_list']['0']['wc_chest_f']);
        $orderinfo['order_list']['0']['wc_chest_b'] = trim($orderinfo['order_list']['0']['wc_chest_b']);
        $orderinfo['order_list']['0']['wc_bust'] = trim($orderinfo['order_list']['0']['wc_bust']);
        $orderinfo['order_list']['0']['wc_circumference'] = trim($orderinfo['order_list']['0']['wc_circumference']);
        $orderinfo['order_list']['0']['wc_sleeve'] = trim($orderinfo['order_list']['0']['wc_sleeve']);
        $orderinfo['order_list']['0']['wc_bicep'] = trim($orderinfo['order_list']['0']['wc_bicep']);
        $orderinfo['order_list']['0']['wc_wrist'] = trim($orderinfo['order_list']['0']['wc_wrist']);
        $orderinfo['order_list']['0']['wc_neck'] = trim($orderinfo['order_list']['0']['wc_neck']);
        $orderinfo['order_list']['0']['tr_garment'] = trim($orderinfo['order_list']['0']['tr_garment']);
        $orderinfo['order_list']['0']['tr_length'] = trim($orderinfo['order_list']['0']['tr_length']);
        $orderinfo['order_list']['0']['tr_waist'] = trim($orderinfo['order_list']['0']['tr_waist']);
        $orderinfo['order_list']['0']['tr_gluteus'] = trim($orderinfo['order_list']['0']['tr_gluteus']);
        $orderinfo['order_list']['0']['tr_thigh'] = trim($orderinfo['order_list']['0']['tr_thigh']);
        $orderinfo['order_list']['0']['tr_crotch_rise'] = trim($orderinfo['order_list']['0']['tr_crotch_rise']);
        $orderinfo['order_list']['0']['tr_crotch_front'] = trim($orderinfo['order_list']['0']['tr_crotch_front']);
        $orderinfo['order_list']['0']['tr_crotch_back'] = trim($orderinfo['order_list']['0']['tr_crotch_back']);
        $orderinfo['order_list']['0']['tr_hamstring'] = trim($orderinfo['order_list']['0']['tr_hamstring']);
        $orderinfo['order_list']['0']['tr_calf'] = trim($orderinfo['order_list']['0']['tr_calf']);
        $orderinfo['order_list']['0']['tr_ankle'] = trim($orderinfo['order_list']['0']['tr_ankle']);*/


        #echo $orderinfo['order_list']['0']['ja_length'];
        #echo json_encode($orderinfo);
        #exit;
        if (!empty($orderinfo)) {
            /*echo '<pre>';
            print_r($orderinfo);
            exit;*/
            if ($orderinfo['order_key'] != $order_key) {
                //非法操作--Order Key 错误
                $rearr = array('status' => '108', 'statusmsg' => 'Illegal Operation');
                echo json_encode($rearr);
                exit;
                return;//终止
            } else {
                //正常返回数据(json)
                /*$newre = array();

                $newre['order_id'] = $orderinfo['order_id'];
                $newre['order_number'] = $orderinfo['order_number'];
                $newre['user_realname'] = $orderinfo['user_realname'];
                $newre['category_id'] = $orderinfo['category_id'];
                $newre['client_id'] = $orderinfo['client_id'];
                $newre['client_key'] = $orderinfo['client_key'];
                $newre['client_number'] = $orderinfo['newclient_number'];
                $newre['client_realname'] = $orderinfo['client_realname'];
                $newre['client_address'] = $orderinfo['client_address'];
                $newre['client_email'] = $orderinfo['client_email'];
                $newre['client_industry'] = $orderinfo['client_industry'];
                $newre['client_wechat'] = $orderinfo['client_wechat'];
                $newre['client_phone'] = $orderinfo['client_phone'];
                $newre['client_birthday'] = $orderinfo['client_birthday'];
                $newre['client_nationality'] = $orderinfo['client_nationality'];
                $newre['totalPoint'] = $orderinfo['totalPoint'];

                if($orderinfo['qrcode_product_id'] != 0){
                    $newre['order_qrcode_pic'] = 'http://www.rjclothing.cn/rojoipadqrcode/index.php/product/infoshengcheng/'.$orderinfo['qrcode_product_id'];
                }else{
                    $newre['order_qrcode_pic'] = '';
                }


                $newre['code_suit'] = $orderinfo['code_suit'];
                $newre['code_waistcoat'] = $orderinfo['code_waistcoat'];
                $newre['code_trousers'] = $orderinfo['code_trousers'];
                $newre['code_shirt'] = $orderinfo['code_shirt'];
                $newre['code_overcoat'] = $orderinfo['code_overcoat'];

                //code_suit_select
                if($orderinfo['code_suit_select'] != '0' && $orderinfo['code_suit_select'] != '' && $orderinfo['code_suit_select'] != ' '){
                    $sql = "SELECT * FROM ".DB_PRE()."cms_list WHERE parent = 54 AND ((cms_name_en = '".$orderinfo['code_suit_select']."') OR (cms_name_ch = '".$orderinfo['code_suit_select']."'))";
                    $selectselectinfo = $this->db->query($sql)->row_array();
                    if(!empty($selectselectinfo)){
                        $newre['code_suit_select'] = $selectselectinfo['cms_name'.$langtype];
                    }else{
                        $newre['code_suit_select'] = $orderinfo['code_suit_select'];
                    }
                }else{
                    $newre['code_suit_select'] = $orderinfo['code_suit_select'];
                }

                //code_waistcoat_select
                if($orderinfo['code_waistcoat_select'] != '0' && $orderinfo['code_waistcoat_select'] != '' && $orderinfo['code_waistcoat_select'] != ' '){
                    $sql = "SELECT * FROM ".DB_PRE()."cms_list WHERE parent = 54 AND ((cms_name_en = '".$orderinfo['code_waistcoat_select']."') OR (cms_name_ch = '".$orderinfo['code_waistcoat_select']."'))";
                    $selectselectinfo = $this->db->query($sql)->row_array();
                    if(!empty($selectselectinfo)){
                        $newre['code_waistcoat_select'] = $selectselectinfo['cms_name'.$langtype];
                    }else{
                        $newre['code_waistcoat_select'] = $orderinfo['code_waistcoat_select'];
                    }
                }else{
                    $newre['code_waistcoat_select'] = $orderinfo['code_waistcoat_select'];
                }

                //code_trousers_select
                if($orderinfo['code_trousers_select'] != '0' && $orderinfo['code_trousers_select'] != '' && $orderinfo['code_trousers_select'] != ' '){
                    $sql = "SELECT * FROM ".DB_PRE()."cms_list WHERE parent = 54 AND ((cms_name_en = '".$orderinfo['code_trousers_select']."') OR (cms_name_ch = '".$orderinfo['code_trousers_select']."'))";
                    $selectselectinfo = $this->db->query($sql)->row_array();
                    if(!empty($selectselectinfo)){
                        $newre['code_trousers_select'] = $selectselectinfo['cms_name'.$langtype];
                    }else{
                        $newre['code_trousers_select'] = $orderinfo['code_trousers_select'];
                    }
                }else{
                    $newre['code_trousers_select'] = $orderinfo['code_trousers_select'];
                }

                //code_shirt_select
                if($orderinfo['code_shirt_select'] != '0' && $orderinfo['code_shirt_select'] != '' && $orderinfo['code_shirt_select'] != ' '){
                    $sql = "SELECT * FROM ".DB_PRE()."cms_list WHERE parent = 54 AND ((cms_name_en = '".$orderinfo['code_shirt_select']."') OR (cms_name_ch = '".$orderinfo['code_shirt_select']."'))";
                    $selectselectinfo = $this->db->query($sql)->row_array();
                    if(!empty($selectselectinfo)){
                        $newre['code_shirt_select'] = $selectselectinfo['cms_name'.$langtype];
                    }else{
                        $newre['code_shirt_select'] = $orderinfo['code_shirt_select'];
                    }
                }else{
                    $newre['code_shirt_select'] = $orderinfo['code_shirt_select'];
                }

                //code_overcoat_select
                if($orderinfo['code_overcoat_select'] != '0' && $orderinfo['code_overcoat_select'] != '' && $orderinfo['code_overcoat_select'] != ' '){
                    $sql = "SELECT * FROM ".DB_PRE()."cms_list WHERE parent = 54 AND ((cms_name_en = '".$orderinfo['code_overcoat_select']."') OR (cms_name_ch = '".$orderinfo['code_overcoat_select']."'))";
                    $selectselectinfo = $this->db->query($sql)->row_array();
                    if(!empty($selectselectinfo)){
                        $newre['code_overcoat_select'] = $selectselectinfo['cms_name'.$langtype];
                    }else{
                        $newre['code_overcoat_select'] = $orderinfo['code_overcoat_select'];
                    }
                }else{
                    $newre['code_overcoat_select'] = $orderinfo['code_overcoat_select'];
                }

                $newre['ja_garment'] = $orderinfo['ja_garment'];
                $newre['ja_length'] = $orderinfo['ja_length'];
                $newre['ja_shoulders'] = $orderinfo['ja_shoulders'];
                $newre['ja_chest'] = $orderinfo['ja_chest'];
                $newre['ja_chest_f'] = $orderinfo['ja_chest_f'];
                $newre['ja_chest_b'] = $orderinfo['ja_chest_b'];
                $newre['ja_bust'] = $orderinfo['ja_bust'];
                $newre['ja_circumference'] = $orderinfo['ja_circumference'];
                $newre['ja_sleeve'] = $orderinfo['ja_sleeve'];
                $newre['ja_bicep'] = $orderinfo['ja_bicep'];
                $newre['ja_wrist'] = $orderinfo['ja_wrist'];
                $newre['ja_neck'] = $orderinfo['ja_neck'];
                $newre['sh_garment'] = $orderinfo['sh_garment'];
                $newre['sh_length'] = $orderinfo['sh_length'];
                $newre['sh_shoulders'] = $orderinfo['sh_shoulders'];
                $newre['sh_chest'] = $orderinfo['sh_chest'];
                $newre['sh_chest_f'] = $orderinfo['sh_chest_f'];
                $newre['sh_chest_b'] = $orderinfo['sh_chest_b'];
                $newre['sh_bust'] = $orderinfo['sh_bust'];
                $newre['sh_circumference'] = $orderinfo['sh_circumference'];
                $newre['sh_sleeve'] = $orderinfo['sh_sleeve'];
                $newre['sh_bicep'] = $orderinfo['sh_bicep'];
                $newre['sh_wrist'] = $orderinfo['sh_wrist'];
                $newre['sh_neck'] = $orderinfo['sh_neck'];
                $newre['wc_garment'] = $orderinfo['wc_garment'];
                $newre['wc_length'] = $orderinfo['wc_length'];
                $newre['wc_shoulders'] = $orderinfo['wc_shoulders'];
                $newre['wc_chest'] = $orderinfo['wc_chest'];
                $newre['wc_chest_f'] = $orderinfo['wc_chest_f'];
                $newre['wc_chest_b'] = $orderinfo['wc_chest_b'];
                $newre['wc_bust'] = $orderinfo['wc_bust'];
                $newre['wc_circumference'] = $orderinfo['wc_circumference'];
                $newre['wc_sleeve'] = $orderinfo['wc_sleeve'];
                $newre['wc_bicep'] = $orderinfo['wc_bicep'];
                $newre['wc_wrist'] = $orderinfo['wc_wrist'];
                $newre['wc_neck'] = $orderinfo['wc_neck'];
                $newre['tr_garment'] = $orderinfo['tr_garment'];
                $newre['tr_length'] = $orderinfo['tr_length'];
                $newre['tr_waist'] = $orderinfo['tr_waist'];
                $newre['tr_gluteus'] = $orderinfo['tr_gluteus'];
                $newre['tr_thigh'] = $orderinfo['tr_thigh'];
                $newre['tr_crotch_rise'] = $orderinfo['tr_crotch_rise'];
                $newre['tr_crotch_front'] = $orderinfo['tr_crotch_front'];
                $newre['tr_crotch_back'] = $orderinfo['tr_crotch_back'];
                $newre['totalPoint'] = $orderinfo['totalPoint'];

                $newre['tr_hamstring'] = $orderinfo['tr_hamstring'];
                $newre['tr_calf'] = $orderinfo['tr_calf'];
                $newre['tr_ankle'] = $orderinfo['tr_ankle'];

                if($orderinfo['code_suit'] == '0'){
                    $newre['code_suit'] = '';
                }
                if($orderinfo['code_waistcoat'] == '0'){
                    $newre['code_waistcoat'] = '';
                }
                if($orderinfo['code_trousers'] == '0'){
                    $newre['code_trousers'] = '';
                }
                if($orderinfo['code_shirt'] == '0'){
                    $newre['code_shirt'] = '';
                }
                if($orderinfo['code_overcoat'] == '0'){
                    $newre['code_overcoat'] = '';
                }
                if($orderinfo['code_suit_select'] == '0'){
                    $newre['code_suit_select'] = '';
                }
                if($orderinfo['code_waistcoat_select'] == '0'){
                    $newre['code_waistcoat_select'] = '';
                }
                if($orderinfo['code_trousers_select'] == '0'){
                    $newre['code_trousers_select'] = '';
                }
                if($orderinfo['code_shirt_select'] == '0'){
                    $newre['code_shirt_select'] = '';
                }
                if($orderinfo['code_overcoat_select'] == '0'){
                    $newre['code_overcoat_select'] = '';
                }
                if($orderinfo['ja_garment'] == '0'){
                    $newre['ja_garment'] = '';
                }
                if($orderinfo['ja_length'] == '0'){
                    $newre['ja_length'] = '';
                }
                if($orderinfo['ja_shoulders'] == '0'){
                    $newre['ja_shoulders'] = '';
                }
                if($orderinfo['ja_chest'] == '0'){
                    $newre['ja_chest'] = '';
                }
                if($orderinfo['ja_chest_f'] == '0'){
                    $newre['ja_chest_f'] = '';
                }
                if($orderinfo['ja_chest_b'] == '0'){
                    $newre['ja_chest_b'] = '';
                }
                if($orderinfo['ja_bust'] == '0'){
                    $newre['ja_bust'] = '';
                }
                if($orderinfo['ja_circumference'] == '0'){
                    $newre['ja_circumference'] = '';
                }
                if($orderinfo['ja_sleeve'] == '0'){
                    $newre['ja_sleeve'] = '';
                }
                if($orderinfo['ja_bicep'] == '0'){
                    $newre['ja_bicep'] = '';
                }
                if($orderinfo['ja_wrist'] == '0'){
                    $newre['ja_wrist'] = '';
                }
                if($orderinfo['ja_neck'] == '0'){
                    $newre['ja_neck'] = '';
                }
                if($orderinfo['sh_garment'] == '0'){
                    $newre['sh_garment'] = '';
                }
                if($orderinfo['sh_length'] == '0'){
                    $newre['sh_length'] = '';
                }
                if($orderinfo['sh_shoulders'] == '0'){
                    $newre['sh_shoulders'] = '';
                }
                if($orderinfo['sh_chest'] == '0'){
                    $newre['sh_chest'] = '';
                }
                if($orderinfo['sh_chest_f'] == '0'){
                    $newre['sh_chest_f'] = '';
                }
                if($orderinfo['sh_chest_b'] == '0'){
                    $newre['sh_chest_b'] = '';
                }
                if($orderinfo['sh_bust'] == '0'){
                    $newre['sh_bust'] = '';
                }
                if($orderinfo['sh_circumference'] == '0'){
                    $newre['sh_circumference'] = '';
                }
                if($orderinfo['sh_sleeve'] == '0'){
                    $newre['sh_sleeve'] = '';
                }
                if($orderinfo['sh_bicep'] == '0'){
                    $newre['sh_bicep'] = '';
                }
                if($orderinfo['sh_wrist'] == '0'){
                    $newre['sh_wrist'] = '';
                }
                if($orderinfo['sh_neck'] == '0'){
                    $newre['sh_neck'] = '';
                }
                if($orderinfo['wc_garment'] == '0'){
                    $newre['wc_garment'] = '';
                }
                if($orderinfo['wc_length'] == '0'){
                    $newre['wc_length'] = '';
                }
                if($orderinfo['wc_shoulders'] == '0'){
                    $newre['wc_shoulders'] = '';
                }
                if($orderinfo['wc_chest'] == '0'){
                    $newre['wc_chest'] = '';
                }
                if($orderinfo['wc_chest_f'] == '0'){
                    $newre['wc_chest_f'] = '';
                }
                if($orderinfo['wc_chest_b'] == '0'){
                    $newre['wc_chest_b'] = '';
                }
                if($orderinfo['wc_bust'] == '0'){
                    $newre['wc_bust'] = '';
                }
                if($orderinfo['wc_circumference'] == '0'){
                    $newre['wc_circumference'] = '';
                }
                if($orderinfo['wc_sleeve'] == '0'){
                    $newre['wc_sleeve'] = '';
                }
                if($orderinfo['wc_bicep'] == '0'){
                    $newre['wc_bicep'] = '';
                }
                if($orderinfo['wc_wrist'] == '0'){
                    $newre['wc_wrist'] = '';
                }
                if($orderinfo['wc_neck'] == '0'){
                    $newre['wc_neck'] = '';
                }
                if($orderinfo['tr_garment'] == '0'){
                    $newre['tr_garment'] = '';
                }
                if($orderinfo['tr_length'] == '0'){
                    $newre['tr_length'] = '';
                }
                if($orderinfo['tr_waist'] == '0'){
                    $newre['tr_waist'] = '';
                }
                if($orderinfo['tr_gluteus'] == '0'){
                    $newre['tr_gluteus'] = '';
                }
                if($orderinfo['tr_thigh'] == '0'){
                    $newre['tr_thigh'] = '';
                }
                if($orderinfo['tr_crotch_rise'] == '0'){
                    $newre['tr_crotch_rise'] = '';
                }
                if($orderinfo['tr_crotch_front'] == '0'){
                    $newre['tr_crotch_front'] = '';
                }
                if($orderinfo['tr_crotch_back'] == '0'){
                    $newre['tr_crotch_back'] = '';
                }

                if($orderinfo['tr_hamstring'] == '0'){
                    $newre['tr_hamstring'] = '';
                }
                if($orderinfo['tr_calf'] == '0'){
                    $newre['tr_calf'] = '';
                }
                if($orderinfo['tr_ankle'] == '0'){
                    $newre['tr_ankle'] = '';
                }

                if($orderinfo['totalPoint'] == '0'){
                    $newre['totalPoint'] = '';
                }





                $newre['order_created'] = $orderinfo['created'];
                $newre['order_totalprice'] = $orderinfo['total_price'];
                $newre['order_depositprice'] = $orderinfo['deposit_price'];
                $newre['order_remainingprice'] = $orderinfo['remaining_price'];

                $sql = "SELECT * FROM ".DB_PRE()."category_list WHERE parent = 3 ORDER BY sort ASC";
                $categorylist = $this->db->query($sql)->result_array();
                for ($c = 0; $c < count($categorylist); $c++) {
                    if(isset($orderinfo['design_list_'.$categorylist[$c]['category_id']])){
                        $newre['design_list_'.$categorylist[$c]['category_id']] = $orderinfo['design_list_'.$categorylist[$c]['category_id']];
                    }else{
                        $newre['design_list_'.$categorylist[$c]['category_id']] = '';
                    }
                }

                if($orderinfo['delivery_time'] == 0){
                    $newre['arrival_time'] = $orderinfo['created'];
                }else{
                    $newre['arrival_time'] = $orderinfo['delivery_time'];
                }
                if($orderinfo['delivery_time'] == 0){
                    $newre['delivery_time'] = $orderinfo['created'];
                }else{
                    $newre['arrival_time'] = $orderinfo['delivery_time'];
                }*/


                $jacket = $this->db
                    ->where(array("type" => "jacket", "sub_type" => "cm", "type_value" => $orderinfo['order_list']['0']['ja_garment']))
                    ->get('default_measurement')
                    ->row();


                $shirt = $this->db
                    ->where(array("type" => "shirt", "sub_type" => "cm", "type_value" => $orderinfo['order_list']['0']['sh_garment']))
                    ->get('default_measurement')
                    ->row();

                $waistcoat = $this->db
                    ->where(array("type" => "waistcoat", "sub_type" => "cm", "type_value" => $orderinfo['order_list']['0']['wc_garment']))
                    ->get('default_measurement')
                    ->row();

                $trousers = $this->db
                    ->where(array("type" => "trousers", "sub_type" => "cm", "type_value" => $orderinfo['order_list']['0']['tr_garment']))
                    ->get('default_measurement')
                    ->row();

//	$orderinfo['order_list']['0']['order_list_id'] = 1;
//	print_r($orderinfo['order_list']['0']['order_list_id']);exit;			
                /*$orderinfo['order_list']['0']['ja_length'] = !empty($orderinfo['order_list']['0']['ja_length']) ?  $jacket->length + $orderinfo['order_list']['0']['ja_length']  : "";
            $orderinfo['order_list']['0']['ja_shoulders'] = !empty($orderinfo['order_list']['0']['ja_shoulders']) ?  $jacket->shoulders  + $orderinfo['order_list']['0']['ja_shoulders']  : "";
            $orderinfo['order_list']['0']['ja_chest'] = !empty($orderinfo['order_list']['0']['ja_chest']) ?   $jacket->chest + $orderinfo['order_list']['0']['ja_chest']  : "";
            $orderinfo['order_list']['0']['ja_chest_f'] = !empty($orderinfo['order_list']['0']['ja_chest_f']) ?  $jacket->front_chest  + $orderinfo['order_list']['0']['ja_chest_f']  : "";
            $orderinfo['order_list']['0']['ja_chest_b'] = !empty($orderinfo['order_list']['0']['ja_chest_b']) ?  $jacket->back_chest  + $orderinfo['order_list']['0']['ja_chest_b']  : "";
            $orderinfo['order_list']['0']['ja_bust'] = !empty($orderinfo['order_list']['0']['ja_bust']) ?  $jacket->bust  + $orderinfo['order_list']['0']['ja_bust']  : "";
            $orderinfo['order_list']['0']['ja_circumference'] = !empty($orderinfo['order_list']['0']['ja_circumference']) ? $jacket->hips   + $orderinfo['order_list']['0']['ja_circumference']  : "";
            $orderinfo['order_list']['0']['ja_sleeve'] = !empty($orderinfo['order_list']['0']['ja_sleeve']) ?  $jacket->sleeve_length  + $orderinfo['order_list']['0']['ja_sleeve']  : "";
            $orderinfo['order_list']['0']['ja_bicep'] = !empty($orderinfo['order_list']['0']['ja_bicep']) ?  $jacket->bicep  + $orderinfo['order_list']['0']['ja_bicep']  : "";
            $orderinfo['order_list']['0']['ja_wrist'] = !empty($orderinfo['order_list']['0']['ja_wrist']) ?  $jacket->wrist_cuff  + $orderinfo['order_list']['0']['ja_wrist']  : "";
            $orderinfo['order_list']['0']['ja_neck'] = !empty($orderinfo['order_list']['0']['ja_neck']) ?  $jacket->neck_cuff  + $orderinfo['order_list']['0']['ja_neck']  : "";


            $orderinfo['order_list']['0']['sh_length'] = !empty($orderinfo['order_list']['0']['sh_length']) ?    $shirt->length + $orderinfo['order_list']['0']['sh_length']  : "";
            $orderinfo['order_list']['0']['sh_shoulders'] = !empty($orderinfo['order_list']['0']['sh_shoulders']) ?    $shirt->shoulders + $orderinfo['order_list']['0']['sh_shoulders']  : "";
            $orderinfo['order_list']['0']['sh_chest'] = !empty($orderinfo['order_list']['0']['sh_chest']) ?    $shirt->chest + $orderinfo['order_list']['0']['sh_chest']  : "";
            $orderinfo['order_list']['0']['sh_chest_f'] = !empty($orderinfo['order_list']['0']['sh_chest_f']) ?    $shirt->front_chest + $orderinfo['order_list']['0']['sh_chest_f']  : "";
            $orderinfo['order_list']['0']['sh_chest_b'] = !empty($orderinfo['order_list']['0']['sh_chest_b']) ?    $shirt->back_chest + $orderinfo['order_list']['0']['sh_chest_b']  : "";
            $orderinfo['order_list']['0']['sh_bust'] = !empty($orderinfo['order_list']['0']['sh_bust']) ?    $shirt->bust + $orderinfo['order_list']['0']['sh_bust']  : "";
            $orderinfo['order_list']['0']['sh_circumference'] = !empty($orderinfo['order_list']['0']['sh_circumference']) ?    $shirt->hips + $orderinfo['order_list']['0']['sh_circumference']  : "";
            $orderinfo['order_list']['0']['sh_sleeve'] = !empty($orderinfo['order_list']['0']['sh_sleeve']) ?    $shirt->sleeve_length + $orderinfo['order_list']['0']['sh_sleeve']  : "";
            $orderinfo['order_list']['0']['sh_bicep'] = !empty($orderinfo['order_list']['0']['sh_bicep']) ?    $shirt->bicep + $orderinfo['order_list']['0']['sh_bicep']  : "";
            $orderinfo['order_list']['0']['sh_wrist'] = !empty($orderinfo['order_list']['0']['sh_wrist']) ?    $shirt->wrist_cuff + $orderinfo['order_list']['0']['sh_wrist']  : "";
            $orderinfo['order_list']['0']['sh_neck'] = !empty($orderinfo['order_list']['0']['sh_neck']) ?    $shirt->neck_cuff + $orderinfo['order_list']['0']['sh_neck']  : "";


            $orderinfo['order_list']['0']['wc_length'] = !empty($orderinfo['order_list']['0']['wc_length']) ?   $waistcoat->length + $orderinfo['order_list']['0']['wc_length']  : "";
            $orderinfo['order_list']['0']['wc_shoulders'] = !empty($orderinfo['order_list']['0']['wc_shoulders']) ?   $waistcoat->shoulders + $orderinfo['order_list']['0']['wc_shoulders']  : "";
            $orderinfo['order_list']['0']['wc_chest'] = !empty($orderinfo['order_list']['0']['wc_chest']) ?   $waistcoat->chest + $orderinfo['order_list']['0']['wc_chest']  : "";
            $orderinfo['order_list']['0']['wc_chest_f'] = !empty($orderinfo['order_list']['0']['wc_chest_f']) ?   $waistcoat->front_chest + $orderinfo['order_list']['0']['wc_chest_f']  : "";
            $orderinfo['order_list']['0']['wc_chest_b'] = !empty($orderinfo['order_list']['0']['wc_chest_b']) ?   $waistcoat->back_chest + $orderinfo['order_list']['0']['wc_chest_b']  : "";
            $orderinfo['order_list']['0']['wc_bust'] = !empty($orderinfo['order_list']['0']['wc_bust']) ?   $waistcoat->bust + $orderinfo['order_list']['0']['wc_bust']  : "";
            $orderinfo['order_list']['0']['wc_circumference'] = !empty($orderinfo['order_list']['0']['wc_circumference']) ?   $waistcoat->hips + $orderinfo['order_list']['0']['wc_circumference']  : "";
            $orderinfo['order_list']['0']['wc_sleeve'] = !empty($orderinfo['order_list']['0']['wc_sleeve']) ?   $waistcoat->sleeve_length + $orderinfo['order_list']['0']['wc_sleeve']  : "";
            $orderinfo['order_list']['0']['wc_bicep'] = !empty($orderinfo['order_list']['0']['wc_bicep']) ?   $waistcoat->bicep + $orderinfo['order_list']['0']['wc_bicep']  : "";
            $orderinfo['order_list']['0']['wc_wrist'] = !empty($orderinfo['order_list']['0']['wc_wrist']) ?   $waistcoat->wrist_cuff + $orderinfo['order_list']['0']['wc_wrist']  : "";
            $orderinfo['order_list']['0']['wc_neck'] = !empty($orderinfo['order_list']['0']['wc_neck']) ?   $waistcoat->neck_cuff + $orderinfo['order_list']['0']['wc_neck']  : "";



            $orderinfo['order_list']['0']['tr_length'] = !empty($orderinfo['order_list']['0']['tr_length']) ?   $trousers->length + $orderinfo['order_list']['0']['tr_length']  : "";
            $orderinfo['order_list']['0']['tr_waist'] = !empty($orderinfo['order_list']['0']['tr_waist']) ?   $trousers->waist + $orderinfo['order_list']['0']['tr_waist']  : "";
            $orderinfo['order_list']['0']['tr_gluteus'] = !empty($orderinfo['order_list']['0']['tr_gluteus']) ?   $trousers->gluteus + $orderinfo['order_list']['0']['tr_gluteus']  : "";
            $orderinfo['order_list']['0']['tr_thigh'] = !empty($orderinfo['order_list']['0']['tr_thigh']) ?   $trousers->thigh + $orderinfo['order_list']['0']['tr_thigh']  : "";
            $orderinfo['order_list']['0']['tr_crotch_rise'] = !empty($orderinfo['order_list']['0']['tr_crotch_rise']) ?   $trousers->crotch_rise + $orderinfo['order_list']['0']['tr_crotch_rise']  : "";
            $orderinfo['order_list']['0']['tr_crotch_front'] = !empty($orderinfo['order_list']['0']['tr_crotch_front']) ?   $trousers->front_crotch + $orderinfo['order_list']['0']['tr_crotch_front']  : "";
            $orderinfo['order_list']['0']['tr_crotch_back'] = !empty($orderinfo['order_list']['0']['tr_crotch_back']) ?   $trousers->back_crotch + $orderinfo['order_list']['0']['tr_crotch_back']  : "";
            $orderinfo['order_list']['0']['tr_hamstring'] = !empty($orderinfo['order_list']['0']['tr_hamstring']) ?   $trousers->hamstring + $orderinfo['order_list']['0']['tr_hamstring']  : "";
            $orderinfo['order_list']['0']['tr_calf'] = !empty($orderinfo['order_list']['0']['tr_calf']) ?   $trousers->calf + $orderinfo['order_list']['0']['tr_calf']  : "";
            $orderinfo['order_list']['0']['tr_ankle'] = !empty($orderinfo['order_list']['0']['tr_ankle']) ?   $trousers->ankle + $orderinfo['order_list']['0']['tr_ankle']  : "";*/

## Abhishek change on 18th April 2020

                if ((substr($orderinfo['order_list']['0']['ja_length'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['ja_length'], 0, 1) === "-") || ($orderinfo['order_list']['0']['ja_length'] == "0")) {
                    $orderinfo['order_list']['0']['ja_length'] = $jacket->length + $orderinfo['order_list']['0']['ja_length'];
                } else {
                    $orderinfo['order_list']['0']['ja_length'] = $orderinfo['order_list']['0']['ja_length'];
                }

                if ((substr($orderinfo['order_list']['0']['ja_shoulders'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['ja_shoulders'], 0, 1) === "-") || ($orderinfo['order_list']['0']['ja_shoulders'] == "0")) {
                    $orderinfo['order_list']['0']['ja_shoulders'] = $jacket->shoulders + $orderinfo['order_list']['0']['ja_shoulders'];
                } else {
                    $orderinfo['order_list']['0']['ja_shoulders'] = $orderinfo['order_list']['0']['ja_shoulders'];
                }

                if ((substr($orderinfo['order_list']['0']['ja_chest'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['ja_chest'], 0, 1) === "-") || ($orderinfo['order_list']['0']['ja_chest'] == "0")) {
                    $orderinfo['order_list']['0']['ja_chest'] = $jacket->chest + $orderinfo['order_list']['0']['ja_chest'];
                } else {
                    $orderinfo['order_list']['0']['ja_chest'] = $orderinfo['order_list']['0']['ja_chest'];
                }

                if ((substr($orderinfo['order_list']['0']['ja_chest_f'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['ja_chest_f'], 0, 1) === "-") || ($orderinfo['order_list']['0']['ja_chest_f'] == "0")) {
                    $orderinfo['order_list']['0']['ja_chest_f'] = $jacket->front_chest + $orderinfo['order_list']['0']['ja_chest_f'];
                } else {
                    $orderinfo['order_list']['0']['ja_chest_f'] = $orderinfo['order_list']['0']['ja_chest_f'];
                }

                if ((substr($orderinfo['order_list']['0']['ja_chest_b'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['ja_chest_b'], 0, 1) === "-") || ($orderinfo['order_list']['0']['ja_chest_b'] == "0")) {
                    $orderinfo['order_list']['0']['ja_chest_b'] = $jacket->back_chest + $orderinfo['order_list']['0']['ja_chest_b'];
                } else {
                    $orderinfo['order_list']['0']['ja_chest_b'] = $orderinfo['order_list']['0']['ja_chest_b'];
                }


                if ((substr($orderinfo['order_list']['0']['ja_bust'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['ja_bust'], 0, 1) === "-") || ($orderinfo['order_list']['0']['ja_bust'] == "0")) {
                    $orderinfo['order_list']['0']['ja_bust'] = $jacket->bust + $orderinfo['order_list']['0']['ja_bust'];
                } else {
                    $orderinfo['order_list']['0']['ja_bust'] = $orderinfo['order_list']['0']['ja_bust'];
                }

                if ((substr($orderinfo['order_list']['0']['ja_circumference'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['ja_circumference'], 0, 1) === "-") || ($orderinfo['order_list']['0']['ja_circumference'] == "0")) {
                    $orderinfo['order_list']['0']['ja_circumference'] = $jacket->hips + $orderinfo['order_list']['0']['ja_circumference'];
                } else {
                    $orderinfo['order_list']['0']['ja_circumference'] = $orderinfo['order_list']['0']['ja_circumference'];
                }

                if ((substr($orderinfo['order_list']['0']['ja_sleeve'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['ja_sleeve'], 0, 1) === "-") || ($orderinfo['order_list']['0']['ja_sleeve'] == "0")) {
                    $orderinfo['order_list']['0']['ja_sleeve'] = $jacket->sleeve_length + $orderinfo['order_list']['0']['ja_sleeve'];
                } else {
                    $orderinfo['order_list']['0']['ja_sleeve'] = $orderinfo['order_list']['0']['ja_sleeve'];
                }


                if ((substr($orderinfo['order_list']['0']['ja_bicep'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['ja_bicep'], 0, 1) === "-") || ($orderinfo['order_list']['0']['ja_bicep'] == "0")) {
                    $orderinfo['order_list']['0']['ja_bicep'] = $jacket->bicep + $orderinfo['order_list']['0']['ja_bicep'];
                } else {
                    $orderinfo['order_list']['0']['ja_bicep'] = $orderinfo['order_list']['0']['ja_bicep'];
                }

                if ((substr($orderinfo['order_list']['0']['ja_wrist'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['ja_wrist'], 0, 1) === "-") || ($orderinfo['order_list']['0']['ja_wrist'] == "0")) {
                    $orderinfo['order_list']['0']['ja_wrist'] = $jacket->wrist_cuff + $orderinfo['order_list']['0']['ja_wrist'];
                } else {
                    $orderinfo['order_list']['0']['ja_wrist'] = $orderinfo['order_list']['0']['ja_wrist'];
                }

                if ((substr($orderinfo['order_list']['0']['ja_neck'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['ja_neck'], 0, 1) === "-") || ($orderinfo['order_list']['0']['ja_neck'] == "0")) {
                    $orderinfo['order_list']['0']['ja_neck'] = $jacket->neck_cuff + $orderinfo['order_list']['0']['ja_neck'];
                } else {
                    $orderinfo['order_list']['0']['ja_neck'] = $orderinfo['order_list']['0']['ja_neck'];
                }

                if ((substr($orderinfo['order_list']['0']['sh_length'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['sh_length'], 0, 1) === "-") || ($orderinfo['order_list']['0']['sh_length'] == "0")) {
                    $orderinfo['order_list']['0']['sh_length'] = $shirt->length + $orderinfo['order_list']['0']['sh_length'];
                } else {
                    $orderinfo['order_list']['0']['sh_length'] = $orderinfo['order_list']['0']['sh_length'];
                }


                if ((substr($orderinfo['order_list']['0']['sh_length'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['sh_length'], 0, 1) === "-") || ($orderinfo['order_list']['0']['sh_length'] == "0")) {
                    $orderinfo['order_list']['0']['sh_length'] = $shirt->length + $orderinfo['order_list']['0']['sh_length'];
                } else {
                    $orderinfo['order_list']['0']['sh_length'] = $orderinfo['order_list']['0']['sh_length'];
                }


                if ((substr($orderinfo['order_list']['0']['sh_shoulders'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['sh_shoulders'], 0, 1) === "-") || ($orderinfo['order_list']['0']['sh_shoulders'] == "0")) {
                    $orderinfo['order_list']['0']['sh_shoulders'] = $shirt->shoulders + $orderinfo['order_list']['0']['sh_shoulders'];
                } else {
                    $orderinfo['order_list']['0']['sh_shoulders'] = $orderinfo['order_list']['0']['sh_shoulders'];
                }


                if ((substr($orderinfo['order_list']['0']['sh_chest'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['sh_chest'], 0, 1) === "-") || ($orderinfo['order_list']['0']['sh_chest'] == "0")) {
                    $orderinfo['order_list']['0']['sh_chest'] = $shirt->chest + $orderinfo['order_list']['0']['sh_chest'];
                } else {
                    $orderinfo['order_list']['0']['sh_chest'] = $orderinfo['order_list']['0']['sh_chest'];
                }


                if ((substr($orderinfo['order_list']['0']['sh_chest_f'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['sh_chest_f'], 0, 1) === "-") || ($orderinfo['order_list']['0']['sh_chest_f'] == "0")) {
                    $orderinfo['order_list']['0']['sh_chest_f'] = $shirt->front_chest + $orderinfo['order_list']['0']['sh_chest_f'];
                } else {
                    $orderinfo['order_list']['0']['sh_chest_f'] = $orderinfo['order_list']['0']['sh_chest_f'];
                }

                if ((substr($orderinfo['order_list']['0']['sh_chest_b'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['sh_chest_b'], 0, 1) === "-") || ($orderinfo['order_list']['0']['sh_chest_b'] == "0")) {
                    $orderinfo['order_list']['0']['sh_chest_b'] = $shirt->back_chest + $orderinfo['order_list']['0']['sh_chest_b'];
                } else {
                    $orderinfo['order_list']['0']['sh_chest_b'] = $orderinfo['order_list']['0']['sh_chest_b'];
                }

                if ((substr($orderinfo['order_list']['0']['sh_bust'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['sh_bust'], 0, 1) === "-") || ($orderinfo['order_list']['0']['sh_bust'] == "0")) {
                    $orderinfo['order_list']['0']['sh_bust'] = $shirt->bust + $orderinfo['order_list']['0']['sh_bust'];
                } else {
                    $orderinfo['order_list']['0']['sh_bust'] = $orderinfo['order_list']['0']['sh_bust'];
                }

                if ((substr($orderinfo['order_list']['0']['sh_circumference'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['sh_circumference'], 0, 1) === "-") || ($orderinfo['order_list']['0']['sh_circumference'] == "0")) {
                    $orderinfo['order_list']['0']['sh_circumference'] = $shirt->hips + $orderinfo['order_list']['0']['sh_circumference'];
                } else {
                    $orderinfo['order_list']['0']['sh_circumference'] = $orderinfo['order_list']['0']['sh_circumference'];
                }


                if ((substr($orderinfo['order_list']['0']['sh_sleeve'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['sh_sleeve'], 0, 1) === "-") || ($orderinfo['order_list']['0']['sh_sleeve'] == "0")) {
                    $orderinfo['order_list']['0']['sh_sleeve'] = $shirt->sleeve_length + $orderinfo['order_list']['0']['sh_sleeve'];
                } else {
                    $orderinfo['order_list']['0']['sh_sleeve'] = $orderinfo['order_list']['0']['sh_sleeve'];
                }

                if ((substr($orderinfo['order_list']['0']['sh_bicep'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['sh_bicep'], 0, 1) === "-") || ($orderinfo['order_list']['0']['sh_bicep'] == "0")) {
                    $orderinfo['order_list']['0']['sh_bicep'] = $shirt->bicep + $orderinfo['order_list']['0']['sh_bicep'];
                } else {
                    $orderinfo['order_list']['0']['sh_bicep'] = $orderinfo['order_list']['0']['sh_bicep'];
                }


                if ((substr($orderinfo['order_list']['0']['sh_wrist'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['sh_wrist'], 0, 1) === "-") || ($orderinfo['order_list']['0']['sh_wrist'] == "0")) {
                    $orderinfo['order_list']['0']['sh_wrist'] = $shirt->wrist_cuff + $orderinfo['order_list']['0']['sh_wrist'];
                } else {
                    $orderinfo['order_list']['0']['sh_wrist'] = $orderinfo['order_list']['0']['sh_wrist'];
                }


                if ((substr($orderinfo['order_list']['0']['sh_neck'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['sh_neck'], 0, 1) === "-") || ($orderinfo['order_list']['0']['sh_neck'] == "0")) {
                    $orderinfo['order_list']['0']['sh_neck'] = $shirt->neck_cuff + $orderinfo['order_list']['0']['sh_neck'];
                } else {
                    $orderinfo['order_list']['0']['sh_neck'] = $orderinfo['order_list']['0']['sh_neck'];
                }


                if ((substr($orderinfo['order_list']['0']['wc_length'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['wc_length'], 0, 1) === "-") || ($orderinfo['order_list']['0']['wc_length'] == "0")) {
                    $orderinfo['order_list']['0']['wc_length'] = $waistcoat->length + $orderinfo['order_list']['0']['wc_length'];
                } else {
                    $orderinfo['order_list']['0']['wc_length'] = $orderinfo['order_list']['0']['wc_length'];
                }


                if ((substr($orderinfo['order_list']['0']['wc_shoulders'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['wc_shoulders'], 0, 1) === "-") || ($orderinfo['order_list']['0']['wc_shoulders'] == "0")) {
                    $orderinfo['order_list']['0']['wc_shoulders'] = $waistcoat->shoulders + $orderinfo['order_list']['0']['wc_shoulders'];
                } else {
                    $orderinfo['order_list']['0']['wc_shoulders'] = $orderinfo['order_list']['0']['wc_shoulders'];
                }


                if ((substr($orderinfo['order_list']['0']['wc_chest'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['wc_chest'], 0, 1) === "-") || ($orderinfo['order_list']['0']['wc_chest'] == "0")) {
                    $orderinfo['order_list']['0']['wc_chest'] = $waistcoat->chest + $orderinfo['order_list']['0']['wc_chest'];
                } else {
                    $orderinfo['order_list']['0']['wc_chest'] = $orderinfo['order_list']['0']['wc_chest'];
                }


                if ((substr($orderinfo['order_list']['0']['wc_chest_f'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['wc_chest_f'], 0, 1) === "-") || ($orderinfo['order_list']['0']['wc_chest_f'] == "0")) {
                    $orderinfo['order_list']['0']['wc_chest_f'] = $waistcoat->front_chest + $orderinfo['order_list']['0']['wc_chest_f'];
                } else {
                    $orderinfo['order_list']['0']['wc_chest_f'] = $orderinfo['order_list']['0']['wc_chest_f'];
                }


                if ((substr($orderinfo['order_list']['0']['wc_chest_b'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['wc_chest_b'], 0, 1) === "-") || ($orderinfo['order_list']['0']['wc_chest_b'] == "0")) {
                    $orderinfo['order_list']['0']['wc_chest_b'] = $waistcoat->back_chest + $orderinfo['order_list']['0']['wc_chest_b'];
                } else {
                    $orderinfo['order_list']['0']['wc_chest_b'] = $orderinfo['order_list']['0']['wc_chest_b'];
                }

                if ((substr($orderinfo['order_list']['0']['wc_bust'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['wc_bust'], 0, 1) === "-") || ($orderinfo['order_list']['0']['wc_bust'] == "0")) {
                    $orderinfo['order_list']['0']['wc_bust'] = $waistcoat->bust + $orderinfo['order_list']['0']['wc_bust'];
                } else {
                    $orderinfo['order_list']['0']['wc_bust'] = $orderinfo['order_list']['0']['wc_bust'];
                }


                if ((substr($orderinfo['order_list']['0']['wc_circumference'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['wc_circumference'], 0, 1) === "-") || ($orderinfo['order_list']['0']['wc_circumference'] == "0")) {
                    $orderinfo['order_list']['0']['wc_circumference'] = $waistcoat->hips + $orderinfo['order_list']['0']['wc_circumference'];
                } else {
                    $orderinfo['order_list']['0']['wc_circumference'] = $orderinfo['order_list']['0']['wc_circumference'];
                }


                if ((substr($orderinfo['order_list']['0']['wc_sleeve'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['wc_sleeve'], 0, 1) === "-") || ($orderinfo['order_list']['0']['wc_sleeve'] == "0")) {
                    $orderinfo['order_list']['0']['wc_sleeve'] = $waistcoat->sleeve_length + $orderinfo['order_list']['0']['wc_sleeve'];
                } else {
                    $orderinfo['order_list']['0']['wc_sleeve'] = $orderinfo['order_list']['0']['wc_sleeve'];
                }


                if ((substr($orderinfo['order_list']['0']['wc_bicep'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['wc_bicep'], 0, 1) === "-") || ($orderinfo['order_list']['0']['wc_bicep'] == "0")) {
                    $orderinfo['order_list']['0']['wc_bicep'] = $waistcoat->bicep + $orderinfo['order_list']['0']['wc_bicep'];
                } else {
                    $orderinfo['order_list']['0']['wc_bicep'] = $orderinfo['order_list']['0']['wc_bicep'];
                }

                if ((substr($orderinfo['order_list']['0']['wc_wrist'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['wc_wrist'], 0, 1) === "-") || ($orderinfo['order_list']['0']['wc_wrist'] == "0")) {
                    $orderinfo['order_list']['0']['wc_wrist'] = $waistcoat->wrist_cuff + $orderinfo['order_list']['0']['wc_wrist'];
                } else {
                    $orderinfo['order_list']['0']['wc_wrist'] = $orderinfo['order_list']['0']['wc_wrist'];
                }

                if ((substr($orderinfo['order_list']['0']['wc_neck'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['wc_neck'], 0, 1) === "-") || ($orderinfo['order_list']['0']['wc_neck'] == "0")) {
                    $orderinfo['order_list']['0']['wc_neck'] = $waistcoat->neck_cuff + $orderinfo['order_list']['0']['wc_neck'];
                } else {
                    $orderinfo['order_list']['0']['wc_neck'] = $orderinfo['order_list']['0']['wc_neck'];
                }


                if ((substr($orderinfo['order_list']['0']['tr_length'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['tr_length'], 0, 1) === "-") || ($orderinfo['order_list']['0']['tr_length'] == "0")) {
                    $orderinfo['order_list']['0']['tr_length'] = $trousers->length + $orderinfo['order_list']['0']['tr_length'];
                } else {
                    $orderinfo['order_list']['0']['tr_length'] = $orderinfo['order_list']['0']['tr_length'];
                }

                if ((substr($orderinfo['order_list']['0']['tr_waist'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['tr_waist'], 0, 1) === "-") || ($orderinfo['order_list']['0']['tr_waist'] == "0")) {
                    $orderinfo['order_list']['0']['tr_waist'] = $trousers->waist + $orderinfo['order_list']['0']['tr_waist'];
                } else {
                    $orderinfo['order_list']['0']['tr_waist'] = $orderinfo['order_list']['0']['tr_waist'];
                }

                if ((substr($orderinfo['order_list']['0']['tr_gluteus'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['tr_gluteus'], 0, 1) === "-") || ($orderinfo['order_list']['0']['tr_gluteus'] == "0")) {
                    $orderinfo['order_list']['0']['tr_gluteus'] = $trousers->gluteus + $orderinfo['order_list']['0']['tr_gluteus'];
                } else {
                    $orderinfo['order_list']['0']['tr_gluteus'] = $orderinfo['order_list']['0']['tr_gluteus'];
                }

                if ((substr($orderinfo['order_list']['0']['tr_thigh'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['tr_thigh'], 0, 1) === "-") || ($orderinfo['order_list']['0']['tr_thigh'] == "0")) {
                    $orderinfo['order_list']['0']['tr_thigh'] = $trousers->thigh + $orderinfo['order_list']['0']['tr_thigh'];
                } else {
                    $orderinfo['order_list']['0']['tr_thigh'] = $orderinfo['order_list']['0']['tr_thigh'];
                }

                if ((substr($orderinfo['order_list']['0']['tr_crotch_rise'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['tr_crotch_rise'], 0, 1) === "-") || ($orderinfo['order_list']['0']['tr_crotch_rise'] == "0")) {
                    $orderinfo['order_list']['0']['tr_crotch_rise'] = $trousers->crotch_rise + $orderinfo['order_list']['0']['tr_crotch_rise'];
                } else {
                    $orderinfo['order_list']['0']['tr_crotch_rise'] = $orderinfo['order_list']['0']['tr_crotch_rise'];
                }

                if ((substr($orderinfo['order_list']['0']['tr_crotch_front'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['tr_crotch_front'], 0, 1) === "-") || ($orderinfo['order_list']['0']['tr_crotch_front'] == "0")) {
                    $orderinfo['order_list']['0']['tr_crotch_front'] = $trousers->front_crotch + $orderinfo['order_list']['0']['tr_crotch_front'];
                } else {
                    $orderinfo['order_list']['0']['tr_crotch_front'] = $orderinfo['order_list']['0']['tr_crotch_front'];
                }

                if ((substr($orderinfo['order_list']['0']['tr_crotch_back'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['tr_crotch_back'], 0, 1) === "-") || ($orderinfo['order_list']['0']['tr_crotch_back'] == "0")) {
                    $orderinfo['order_list']['0']['tr_crotch_back'] = $trousers->back_crotch + $orderinfo['order_list']['0']['tr_crotch_back'];
                } else {
                    $orderinfo['order_list']['0']['tr_crotch_back'] = $orderinfo['order_list']['0']['tr_crotch_back'];
                }

                if ((substr($orderinfo['order_list']['0']['tr_hamstring'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['tr_hamstring'], 0, 1) === "-") || ($orderinfo['order_list']['0']['tr_hamstring'] == "0")) {
                    $orderinfo['order_list']['0']['tr_hamstring'] = $trousers->hamstring + $orderinfo['order_list']['0']['tr_hamstring'];
                } else {
                    $orderinfo['order_list']['0']['tr_hamstring'] = $orderinfo['order_list']['0']['tr_hamstring'];
                }

                if ((substr($orderinfo['order_list']['0']['tr_calf'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['tr_calf'], 0, 1) === "-") || ($orderinfo['order_list']['0']['tr_calf'] == "0")) {
                    $orderinfo['order_list']['0']['tr_calf'] = $trousers->calf + $orderinfo['order_list']['0']['tr_calf'];
                } else {
                    $orderinfo['order_list']['0']['tr_calf'] = $orderinfo['order_list']['0']['tr_calf'];
                }

                if ((substr($orderinfo['order_list']['0']['tr_ankle'], 0, 1) === "+") || (substr($orderinfo['order_list']['0']['tr_ankle'], 0, 1) === "-") || ($orderinfo['order_list']['0']['tr_ankle'] == "0")) {
                    $orderinfo['order_list']['0']['tr_ankle'] = $trousers->ankle + $orderinfo['order_list']['0']['tr_ankle'];
                } else {
                    $orderinfo['order_list']['0']['tr_ankle'] = $orderinfo['order_list']['0']['tr_ankle'];
                }
### Abhishek code end 

#$orderinfo['order_list']['0']['ja_length'] = !empty($orderinfo['order_list']['0']['ja_length']) ?  $jacket->length + $orderinfo['order_list']['0']['ja_length']  : $jacket->length;

#$orderinfo['order_list']['0']['ja_shoulders'] = !empty($orderinfo['order_list']['0']['ja_shoulders']) ?  $jacket->shoulders  + $orderinfo['order_list']['0']['ja_shoulders']  : $jacket->shoulders ;

#$orderinfo['order_list']['0']['ja_chest'] = !empty($orderinfo['order_list']['0']['ja_chest']) ?   $jacket->chest + $orderinfo['order_list']['0']['ja_chest']  : $jacket->chest;

#$orderinfo['order_list']['0']['ja_chest_f'] = !empty($orderinfo['order_list']['0']['ja_chest_f']) ?  $jacket->front_chest  + $orderinfo['order_list']['0']['ja_chest_f']  : $jacket->front_chest ;

#$orderinfo['order_list']['0']['ja_chest_b'] = !empty($orderinfo['order_list']['0']['ja_chest_b']) ?  $jacket->back_chest  + $orderinfo['order_list']['0']['ja_chest_b']  : $jacket->back_chest ;

#$orderinfo['order_list']['0']['ja_bust'] = !empty($orderinfo['order_list']['0']['ja_bust']) ?  $jacket->bust  + $orderinfo['order_list']['0']['ja_bust']  : $jacket->bust ;

#$orderinfo['order_list']['0']['ja_circumference'] = !empty($orderinfo['order_list']['0']['ja_circumference']) ? $jacket->hips   + $orderinfo['order_list']['0']['ja_circumference']  : $jacket->hips  ;

#$orderinfo['order_list']['0']['ja_sleeve'] = !empty($orderinfo['order_list']['0']['ja_sleeve']) ?  $jacket->sleeve_length  + $orderinfo['order_list']['0']['ja_sleeve']  : $jacket->sleeve_length ;

#$orderinfo['order_list']['0']['ja_bicep'] = !empty($orderinfo['order_list']['0']['ja_bicep']) ?  $jacket->bicep  + $orderinfo['order_list']['0']['ja_bicep']  : $jacket->bicep ;

#$orderinfo['order_list']['0']['ja_wrist'] = !empty($orderinfo['order_list']['0']['ja_wrist']) ?  $jacket->wrist_cuff  + $orderinfo['order_list']['0']['ja_wrist']  : $jacket->wrist_cuff ;

#$orderinfo['order_list']['0']['ja_neck'] = !empty($orderinfo['order_list']['0']['ja_neck']) ?  $jacket->neck_cuff  + $orderinfo['order_list']['0']['ja_neck']  : $jacket->neck_cuff ;


#$orderinfo['order_list']['0']['sh_length'] = !empty($orderinfo['order_list']['0']['sh_length']) ?    $shirt->length + $orderinfo['order_list']['0']['sh_length']  : $shirt->length;

#$orderinfo['order_list']['0']['sh_shoulders'] = !empty($orderinfo['order_list']['0']['sh_shoulders']) ?    $shirt->shoulders + $orderinfo['order_list']['0']['sh_shoulders']  : $shirt->shoulders;

#$orderinfo['order_list']['0']['sh_chest'] = !empty($orderinfo['order_list']['0']['sh_chest']) ?    $shirt->chest + $orderinfo['order_list']['0']['sh_chest']  : $shirt->chest;

#$orderinfo['order_list']['0']['sh_chest_f'] = !empty($orderinfo['order_list']['0']['sh_chest_f']) ?    $shirt->front_chest + $orderinfo['order_list']['0']['sh_chest_f']  : $shirt->front_chest;

#$orderinfo['order_list']['0']['sh_chest_b'] = !empty($orderinfo['order_list']['0']['sh_chest_b']) ?    $shirt->back_chest + $orderinfo['order_list']['0']['sh_chest_b']  : $shirt->back_chest;

#$orderinfo['order_list']['0']['sh_bust'] = !empty($orderinfo['order_list']['0']['sh_bust']) ?    $shirt->bust + $orderinfo['order_list']['0']['sh_bust']  : $shirt->bust;

#$orderinfo['order_list']['0']['sh_circumference'] = !empty($orderinfo['order_list']['0']['sh_circumference']) ?    $shirt->hips + $orderinfo['order_list']['0']['sh_circumference']  : $shirt->hips;

#$orderinfo['order_list']['0']['sh_sleeve'] = !empty($orderinfo['order_list']['0']['sh_sleeve']) ?    $shirt->sleeve_length + $orderinfo['order_list']['0']['sh_sleeve']  : $shirt->sleeve_length;

#$orderinfo['order_list']['0']['sh_bicep'] = !empty($orderinfo['order_list']['0']['sh_bicep']) ?    $shirt->bicep + $orderinfo['order_list']['0']['sh_bicep']  : $shirt->bicep;

#$orderinfo['order_list']['0']['sh_wrist'] = !empty($orderinfo['order_list']['0']['sh_wrist']) ?    $shirt->wrist_cuff + $orderinfo['order_list']['0']['sh_wrist']  : $shirt->wrist_cuff;

#$orderinfo['order_list']['0']['sh_neck'] = !empty($orderinfo['order_list']['0']['sh_neck']) ?    $shirt->neck_cuff + $orderinfo['order_list']['0']['sh_neck']  : $shirt->neck_cuff;


#$orderinfo['order_list']['0']['wc_length'] = !empty($orderinfo['order_list']['0']['wc_length']) ?   $waistcoat->length + $orderinfo['order_list']['0']['wc_length']  : $waistcoat->length;

#$orderinfo['order_list']['0']['wc_shoulders'] = !empty($orderinfo['order_list']['0']['wc_shoulders']) ?   $waistcoat->shoulders + $orderinfo['order_list']['0']['wc_shoulders']  : $waistcoat->shoulders;

#$orderinfo['order_list']['0']['wc_chest'] = !empty($orderinfo['order_list']['0']['wc_chest']) ?   $waistcoat->chest + $orderinfo['order_list']['0']['wc_chest']  : $waistcoat->chest;

#$orderinfo['order_list']['0']['wc_chest_f'] = !empty($orderinfo['order_list']['0']['wc_chest_f']) ?   $waistcoat->front_chest + $orderinfo['order_list']['0']['wc_chest_f']  : $waistcoat->front_chest;

#$orderinfo['order_list']['0']['wc_chest_b'] = !empty($orderinfo['order_list']['0']['wc_chest_b']) ?   $waistcoat->back_chest + $orderinfo['order_list']['0']['wc_chest_b']  : $waistcoat->back_chest;

#$orderinfo['order_list']['0']['wc_bust'] = !empty($orderinfo['order_list']['0']['wc_bust']) ?   $waistcoat->bust + $orderinfo['order_list']['0']['wc_bust']  : $waistcoat->bust;

#$orderinfo['order_list']['0']['wc_circumference'] = !empty($orderinfo['order_list']['0']['wc_circumference']) ?   $waistcoat->hips + $orderinfo['order_list']['0']['wc_circumference']  : $waistcoat->hips;

#$orderinfo['order_list']['0']['wc_sleeve'] = !empty($orderinfo['order_list']['0']['wc_sleeve']) ?   $waistcoat->sleeve_length + $orderinfo['order_list']['0']['wc_sleeve']  : $waistcoat->sleeve_length;

#$orderinfo['order_list']['0']['wc_bicep'] = !empty($orderinfo['order_list']['0']['wc_bicep']) ?   $waistcoat->bicep + $orderinfo['order_list']['0']['wc_bicep']  : $waistcoat->bicep;

#$orderinfo['order_list']['0']['wc_wrist'] = !empty($orderinfo['order_list']['0']['wc_wrist']) ?   $waistcoat->wrist_cuff + $orderinfo['order_list']['0']['wc_wrist']  : $waistcoat->wrist_cuff;

#$orderinfo['order_list']['0']['wc_neck'] = !empty($orderinfo['order_list']['0']['wc_neck']) ?   $waistcoat->neck_cuff + $orderinfo['order_list']['0']['wc_neck']  : $waistcoat->neck_cuff;



#$orderinfo['order_list']['0']['tr_length'] = !empty($orderinfo['order_list']['0']['tr_length']) ?   $trousers->length + $orderinfo['order_list']['0']['tr_length']  : $trousers->length;

#$orderinfo['order_list']['0']['tr_waist'] = !empty($orderinfo['order_list']['0']['tr_waist']) ?   $trousers->waist + $orderinfo['order_list']['0']['tr_waist']  : $trousers->waist;

#$orderinfo['order_list']['0']['tr_gluteus'] = !empty($orderinfo['order_list']['0']['tr_gluteus']) ?   $trousers->gluteus + $orderinfo['order_list']['0']['tr_gluteus']  : $trousers->gluteus;

#$orderinfo['order_list']['0']['tr_thigh'] = !empty($orderinfo['order_list']['0']['tr_thigh']) ?   $trousers->thigh + $orderinfo['order_list']['0']['tr_thigh']  : $trousers->thigh;

#$orderinfo['order_list']['0']['tr_crotch_rise'] = !empty($orderinfo['order_list']['0']['tr_crotch_rise']) ?   $trousers->crotch_rise + $orderinfo['order_list']['0']['tr_crotch_rise']  : $trousers->crotch_rise;

#$orderinfo['order_list']['0']['tr_crotch_front'] = !empty($orderinfo['order_list']['0']['tr_crotch_front']) ?   $trousers->front_crotch + $orderinfo['order_list']['0']['tr_crotch_front']  : $trousers->front_crotch;

#$orderinfo['order_list']['0']['tr_crotch_back'] = !empty($orderinfo['order_list']['0']['tr_crotch_back']) ?   $trousers->back_crotch + $orderinfo['order_list']['0']['tr_crotch_back']  : $trousers->back_crotch;

#$orderinfo['order_list']['0']['tr_hamstring'] = !empty($orderinfo['order_list']['0']['tr_hamstring']) ?   $trousers->hamstring + $orderinfo['order_list']['0']['tr_hamstring']  : $trousers->hamstring;

#$orderinfo['order_list']['0']['tr_calf'] = !empty($orderinfo['order_list']['0']['tr_calf']) ?   $trousers->calf + $orderinfo['order_list']['0']['tr_calf']  : $trousers->calf;

#$orderinfo['order_list']['0']['tr_ankle'] = !empty($orderinfo['order_list']['0']['tr_ankle']) ?   $trousers->ankle + $orderinfo['order_list']['0']['tr_ankle']  : $trousers->ankle;


                if ($orderinfo['qrcode_product_id'] != 0) {
                    $orderinfo['order_qrcode_pic'] = ((getenv('APPLICATION_ENV') == 'production') ? 'https://www.rjclothing.cn' : 'https://alpha.rjclothing.cn') . '/rojoipadqrcode/index.php/product/infoshengcheng/' . $orderinfo['qrcode_product_id'];
//                    $orderinfo['order_qrcode_pic'] = base_url('../rojoipadqrcode/index.php/product/infoshengcheng/') . '/' . $orderinfo['qrcode_product_id'];
                } else {
                    $orderinfo['order_qrcode_pic'] = '';
                }

                #echo '<pre>';
#print_r($orderinfo);
#exit;
                $rearr = array('status' => '1', 'statusmsg' => 'success', 'data' => $orderinfo);
                echo json_encode($rearr);
            }

        } else {
            //订单不存在!
            $rearr = array('status' => '107', 'statusmsg' => 'order not exists');
            echo json_encode($rearr);
            exit;
            return;//终止
        }

    }


}
/* End of file welcome.php */
/* Location: ./application/controllers/api.php */
