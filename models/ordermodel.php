<?php
class OrderModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function getorderlist($con = array(), $iscount = 0)
    {
        $where = "";
        $group_by = " group by o.order_id ";
        $order_by = "";
        $limit = "";
        $where1 = "";
        $where2 = "";
        $where3 = "";
        $isadmin = $con['isadmin'];

        //$user_id = $con['user_id'];

        if (isset($con['other_con'])) {
            if ($where != "") {
                $where .= " AND";
            } else {
                $where .= " WHERE";
            }
            $where .= " " . $con['other_con'];
        }
        if (isset($con['status'])) {
            if ($where != "") {
                $where .= " AND";
            } else {
                $where .= " WHERE";
            }
            $where .= " ol.status = " . $con['status'];
        }
        if (isset($con['uid']) && $isadmin == 0) {
            if ($where != "") {
                $where .= " AND";
            } else {
                $where .= " WHERE";
            }
            $where .= " o.uid = " . $con['uid'];
        }
        if (isset($con['uidin'])) {
            if ($where != "") {
                $where .= " AND";
            } else {
                $where .= " WHERE";
            }
            $where .= " o.uid IN ( " . $con['uidin'] . " )";
        }
        if (isset($con['statusin'])) {
            if ($where != "") {
                $where .= " AND";
            } else {
                $where .= " WHERE";
            }
            $where .= " ol.status IN ( " . $con['statusin'] . " )";
        }
        if (isset($con['statusnotin'])) {
            if ($where != "") {
                $where .= " AND";
            } else {
                $where .= " WHERE";
            }
            $where .= " ol.status NOT IN ( " . $con['statusnotin'] . " )";
        }
        if (isset($con['order_id'])) {
            if ($where != "") {
                $where .= " AND";
            } else {
                $where .= " WHERE";
            }
            $where .= " o.order_id = " . $con['order_id'];
        }
        //echo strlen($con['user_brandname']);
        //print_r($con);exit;
        if (isset($con['user_brandname']) && $con['user_brandname'] != '') {
            if ($where != "") {
                $where .= " AND";
            } else {
                $where .= " WHERE";
            }
            $where .= ' u.user_brandname = "' . $con['user_brandname'] . '"';
        }

        if (isset($con['order_number'])) {
            if ($where != "") {
                $where .= " AND";
            } else {
                $where .= " WHERE";
            }
            $where .= " o.order_number LIKE '%" . $con['order_number'] . "%'";
        }
        if (isset($con['orderby']) && isset($con['orderby_res'])) {
            $order_by .= " ORDER BY " . $con['orderby'] . " " . $con['orderby_res'] . "";
        }
        if (isset($con['row']) && isset($con['page'])) {
            $limit .= " LIMIT " . $con['row'] . "," . $con['page'] . "";
        }
        if (isset($con['keyword'])) {
            if ($where != "") {
                $where .= " AND";
            } else {
                $where .= " WHERE";
            }
            $where .= " (u.user_realname like '%" . $con['keyword'] . "%' or aaaa.user_realname like '%" . $con['keyword'] . "%' or aaaa.user_number like '%" . $con['keyword'] . "%' or c.user_realname like '%" . $con['keyword'] . "%' or d.category_name_en like '%" . $con['keyword'] . "%' or o.order_number like '%" . $con['keyword'] . "%')";
        }
        //  echo $where;exit;
        if ($iscount == 0) {
            $sql = "
                    
                    SELECT o.*,ol.status
                    
                    , u.user_realname
                    , c.uid AS client_id
                    , c.randkey AS client_key
                    , c.user_realname AS client_realname
                    , c.user_address AS client_address
                    , c.user_email AS client_email
                    , c.user_industry AS client_industry
                    , c.user_wechat AS client_wechat
                    , c.user_phone AS client_phone
                    , c.user_birthday AS client_birthday
                    , c.user_nationality AS client_nationality
                    
                    , d.category_name_en, d.category_name_ch
                    
                    , aaaa.user_number AS newclient_number
                    
                    , dddddd.step1_user_number, dddddd.step1_date_cloth_due, dddddd.step1_date_cloth_submitted, dddddd.step1_status_num, dddddd.step1_approve_status, dddddd.step1_approve_time_1, dddddd.step1_approve_time_2, dddddd.step1_approve_time_3, dddddd.step1_approve_time_4, dddddd.step1_approve_time_5
                    , eeeeee.step2_notes, eeeeee.step2_approve_status, eeeeee.step2_approve_time
                    , ffffff.step3_date_new_due, ffffff.step3_approve_status, ffffff.step3_approve_time
                    , gggggg.step4_approve_status, gggggg.step4_approve_time, gggggg.step4_status_num, gggggg.step4_approve_time_1, gggggg.step4_approve_time_2, gggggg.step4_approve_time_3, gggggg.date_cloth_submitted AS step4_date_start, gggggg.date_cloth_due AS step4_date_end
                    , hhhhhh.step5_approve_status, hhhhhh.step5_approve_time
                    , tttttt.factory_name_en, tttttt.factory_name_ch
                    
                    FROM " . DB_PRE() . "order AS o 
                    
                    LEFT JOIN " . DB_PRE() . "user_list AS u ON o.uid = u.uid
                    
                    LEFT JOIN " . DB_PRE() . "user_list AS c ON o.client_id = c.uid
                    
                    LEFT JOIN " . DB_PRE() . "category_list AS d ON d.category_id = o.category_id
                    
					LEFT JOIN " . DB_PRE() . "order_list AS ol ON ol.o_id = o.order_id
                    
                    LEFT JOIN ipadqrcode_user_list AS aaaa ON aaaa.uid = c.qrcode_uid
                    
                    
                    LEFT JOIN ipadqrcode_product_list AS qra ON qra.product_id = o.qrcode_product_id
                    LEFT JOIN ipadqrcode_product_step1 AS dddddd ON qra.product_id = dddddd.product_id
                    LEFT JOIN ipadqrcode_product_step2 AS eeeeee ON qra.product_id = eeeeee.product_id
                    LEFT JOIN ipadqrcode_product_step3 AS ffffff ON qra.product_id = ffffff.product_id AND ffffff.isdel = 0
                    LEFT JOIN ipadqrcode_product_step4 AS gggggg ON qra.product_id = gggggg.product_id AND gggggg.isdel = 0
                    LEFT JOIN ipadqrcode_product_step5 AS hhhhhh ON qra.product_id = hhhhhh.product_id AND hhhhhh.isdel = 0
                    LEFT JOIN ipadqrcode_user_list AS cccccc ON dddddd.uid = cccccc.uid
                    LEFT JOIN ipadqrcode_system_product_factory AS tttttt ON dddddd.factory_id = tttttt.factory_id
            
                    $where $group_by $order_by $limit
            ";


            // echo $sql;exit;
            $result = $this->db->query($sql)->result_array();
            if (!empty($result)) {
                return $result;
            } else {
                return null;
            }
        } else {
            $sql = "
            
                    SELECT count(*) as count
            
                    FROM " . DB_PRE() . "order AS o
            
                    LEFT JOIN " . DB_PRE() . "user_list AS u ON o.uid = u.uid
            
                    LEFT JOIN " . DB_PRE() . "user_list AS c ON o.client_id = c.uid
                    
                    LEFT JOIN " . DB_PRE() . "category_list AS d ON d.category_id = o.category_id
                    LEFT JOIN " . DB_PRE() . "order_list AS ol ON ol.o_id = o.order_id
                    LEFT JOIN ipadqrcode_user_list AS aaaa ON aaaa.uid = c.qrcode_uid
                    
                    LEFT JOIN ipadqrcode_product_list AS qra ON qra.product_id = o.qrcode_product_id
                    LEFT JOIN ipadqrcode_product_step1 AS dddddd ON qra.product_id = dddddd.product_id
                    LEFT JOIN ipadqrcode_product_step2 AS eeeeee ON qra.product_id = eeeeee.product_id
                    LEFT JOIN ipadqrcode_product_step3 AS ffffff ON qra.product_id = ffffff.product_id AND ffffff.isdel = 0
                    LEFT JOIN ipadqrcode_product_step4 AS gggggg ON qra.product_id = gggggg.product_id AND gggggg.isdel = 0
                    LEFT JOIN ipadqrcode_product_step5 AS hhhhhh ON qra.product_id = hhhhhh.product_id AND hhhhhh.isdel = 0
                    LEFT JOIN ipadqrcode_user_list AS cccccc ON dddddd.uid = cccccc.uid
                    LEFT JOIN ipadqrcode_system_product_factory AS tttttt ON dddddd.factory_id = tttttt.factory_id
                                    
                    $where  $order_by
            ";

            // echo $sql;exit;
            //$group_by
            $result = $this->db->query($sql)->row_array();
            if (!empty($result)) {
                return $result['count'];
            } else {
                return 0;
            }
        }
    }

    function getorder_productlist($con = array(), $iscount = 0)
    {
        $where    = "";
        $order_by = "";
        $limit    = "";
        $group_by = "";
        if (isset($con['product_name_ch'])) {
            if ($where != "") {
                $where .= " AND ";
            } else {
                $where .= " WHERE ";
            }
            $where .= " od.product_name_ch LIKE '%" . $con['product_name_ch'] . "%'";
        }
        if (isset($con['id'])) {
            if ($where != "") {
                $where .= " AND ";
            } else {
                $where .= " WHERE ";
            }
            $where .= " od.id =" . $con['id'];
        }
        if (isset($con['refunt_status_all'])) {
            if ($where != "") {
                $where .= " AND ";
            } else {
                $where .= " WHERE ";
            }
            $where .= " od.refund_status !=" . $con['refunt_status_all'];
        }
        if (isset($con['order_id'])) {
            if ($where != "") {
                $where .= " AND ";
            } else {
                $where .= " WHERE ";
            }
            $where .= " od.order_id =" . $con['order_id'];
        }
        if (isset($con['product_id'])) {
            if ($where != "") {
                $where .= " AND ";
            } else {
                $where .= " WHERE ";
            }
            $where .= " od.product_id =" . $con['product_id'];
        }
        if (isset($con['orderby']) && isset($con['orderby_res'])) {
            $order_by .= " ORDER BY " . $con['orderby'] . " " . $con['orderby_res'] . "";
        }
        if (isset($con['row']) && isset($con['page'])) {
            $limit .= " LIMIT " . $con['row'] . "," . $con['page'] . "";
        }

        if ($iscount == 0) {
            $sql    = "
                    
                    SELECT od.* , b.size_name_en , b.size_name_ch
                    
                    FROM " . DB_PRE() . "order_detail AS od
                    
                    LEFT JOIN " . DB_PRE() . "system_product_size AS b ON b.size_id = od.size_id
            
            
            $where $group_by $order_by $limit";
            $result = $this->db->query($sql)->result_array();
            if (!empty($result)) {
                return $result;
            } else {
                return null;
            }
        } else {
            $sql    = "
                    SELECT count(*) as count 
                    
                    FROM " . DB_PRE() . "order_detail AS od
                    
                    LEFT JOIN " . DB_PRE() . "system_product_size AS b ON b.size_id = od.size_id
            
            $where $group_by $order_by";
            $result = $this->db->query($sql)->row_array();
            if (!empty($result)) {
                return $result['count'];
            } else {
                return 0;
            }
        }
    }
    function getcouponlist($con = array(), $iscount = 0)
    {
        $where    = "";
        $order_by = "";
        $limit    = "";
        $group_by = "";
        if (isset($con['uid'])) {
            if ($where != "") {
                $where .= " AND ";
            } else {
                $where .= " WHERE ";
            }
            $where .= " uid =" . $con['uid'];
        }
        if (isset($con['orderby']) && isset($con['orderby_res'])) {
            $order_by .= " ORDER BY " . $con['orderby'] . " " . $con['orderby_res'] . "";
        }
        if (isset($con['row']) && isset($con['page'])) {
            $limit .= " LIMIT " . $con['row'] . "," . $con['page'] . "";
        }

        if ($iscount == 0) {
            $sql    = "SELECT * FROM " . DB_PRE() . "coupon_list  $where $group_by $order_by $limit";
            $result = $this->db->query($sql)->result_array();
            if (!empty($result)) {
                return $result;
            } else {
                return null;
            }
        } else {
            $sql    = "SELECT count(*) as count FROM " . DB_PRE() . "coupon_list  $where $group_by $order_by";
            $result = $this->db->query($sql)->row_array();
            if (!empty($result)) {
                return $result['count'];
            } else {
                return 0;
            }
        }
    }
    function get_product_order_count($product_id = 0)
    {
        $sql    = "SELECT sum(count) as count FROM " . DB_PRE() . "order_detail od where product_id=$product_id ";
        $result = $this->db->query($sql)->row_array();
        if (!empty($result['count'])) {
            return $result['count'];
        } else {
            return 0;
        }
    }
    /*
    function get_ordernumber($order_id){
    if($order_id < 10){
    return '00000000000000'.$order_id;
    }else if($order_id<100){
    return '0000000000000'.$order_id;
    }else if($order_id<1000){
    return '000000000000'.$order_id;
    }else if($order_id<10000){
    return '00000000000'.$order_id;
    }else if($order_id<100000){
    return '0000000000'.$order_id;
    }else if($order_id<1000000){
    return '000000000'.$order_id;
    }else if($order_id<10000000){
    return '00000000'.$order_id;
    }else if($order_id<100000000){
    return '0000000'.$order_id;
    }else if($order_id<1000000000){
    return '000000'.$order_id;
    }else if($order_id<10000000000){
    return '00000'.$order_id;
    }else if($order_id<100000000000){
    return '0000'.$order_id;
    }else if($order_id<1000000000000){
    return '000'.$order_id;
    }else if($order_id<10000000000000){
    return '00'.$order_id;
    }else if($order_id<100000000000000){
    return '0'.$order_id;
    }else{
    return ''.$order_id;
    }
    }
    */
    function get_ordernumber($order_id)
    {
        $rand   = mt_rand(100, 999) + 1;
        $rand_n = mt_rand(1000, 9999) + 1;
        return $newcode = "DKSH" . date('Ymd') . $rand . date('s') . $rand_n . $order_id;
    }

    function add_order($arr)
    {
        $this->db->insert(DB_PRE() . 'order_list', $arr);
        $order_id = $this->db->insert_id();
        $order_number = $this->get_ordernumber($order_id);
        $this->db->update(DB_PRE() . 'order_list', array(
            'order_number' => $order_number
        ), array(
            'order_id' => $order_id
        ));
        return $order_id;
    }

    function add_order_detail($arr)
    {
        $this->db->insert(DB_PRE() . 'order_detail', $arr);
        return $this->db->insert_id();
    }

    function verify_order($order_id, $uid)
    {
        $sql = "select * from " . DB_PRE() . "order where order_id = '$order_id' AND uid = '$uid'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return null;
        }
    }

    function add_order_image($arr)
    {
        $this->db->insert(DB_PRE() . 'order_image', $arr);
        return $this->db->insert_id();
    }

    function get_order_images($order_id, $uid)
    {
        $sql = "select order_image_id,order_id,image from " . DB_PRE() . "order_image where order_id = '$order_id' AND uid = '$uid'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    function add_order_note($arr)
    {
        $this->db->insert(DB_PRE() . 'order_note', $arr);
        return $this->db->insert_id();
    }

    function update_order_note($whereArr, $note)
    {
        $this->db->where(array('order_id' => $whereArr['order_id'], 'order_note_id' => $whereArr['note_id']));
        $this->db->update(DB_PRE() . 'order_note', array(
            'note' => $note
        ));
        return true;
    }

    function get_order_notes($order_id, $uid)
    {
        $sql = "select order_note_id,order_id,note from " . DB_PRE() . "order_note where order_id = '$order_id' AND uid = '$uid'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    function edit_order_detail($id, $arr)
    {
        $this->db->update(DB_PRE() . 'order_detail', $arr, array(
            'id' => $id
        ));
    }

    function getorderinfo_byordernumber($order_number)
    {
        $sql   = "select * from " . DB_PRE() . "order_list where order_number = '$order_number'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return null;
        }
    }

    function getorderinfo($order_id,$isadmin=0,$uid=0)
    {
        $where = " and 1=1";
        if ($isadmin > 0) {
            $where = " and 1=1";
        } else if ($uid > 0) {
            $where = " and o.uid=$uid";
        }
        $sql = "
            SELECT o.*
                
            , u.user_realname
            , c.uid AS client_id
            , c.randkey AS client_key
            , c.user_realname AS client_realname
            , c.user_address AS client_address
            , c.user_email AS client_email
            , c.user_industry AS client_industry
            , c.user_wechat AS client_wechat
            , c.user_phone AS client_phone
            , c.user_birthday AS client_birthday
            , c.user_nationality AS client_nationality
                
            , d.category_name_en, d.category_name_ch
                
            , aaaa.user_number AS newclient_number
                
            , qra.product_key AS qrcode_product_randkey

            , dddddd.step1_user_number, dddddd.step1_date_cloth_due, dddddd.step1_date_cloth_submitted, dddddd.step1_status_num, dddddd.step1_approve_status, dddddd.step1_approve_time_1, dddddd.step1_approve_time_2, dddddd.step1_approve_time_3, dddddd.step1_approve_time_4, dddddd.step1_approve_time_5
            , eeeeee.step2_notes, eeeeee.step2_approve_status, eeeeee.step2_approve_time
            , ffffff.step3_date_new_due, ffffff.step3_approve_status, ffffff.step3_approve_time
            , gggggg.step4_approve_status, gggggg.step4_approve_time, gggggg.step4_status_num, gggggg.step4_approve_time_1, gggggg.step4_approve_time_2, gggggg.step4_approve_time_3, gggggg.date_cloth_submitted AS step4_date_start, gggggg.date_cloth_due AS step4_date_end
            , hhhhhh.step5_approve_status, hhhhhh.step5_approve_time
            , tttttt.factory_name_en, tttttt.factory_name_ch

            FROM " . DB_PRE() . "order AS o
            LEFT JOIN " . DB_PRE() . "user_list AS u ON o.uid = u.uid
            LEFT JOIN " . DB_PRE() . "user_list AS c ON o.client_id = c.uid
            
            LEFT JOIN " . DB_PRE() . "category_list AS d ON d.category_id = o.category_id
            
            LEFT JOIN ipadqrcode_user_list AS aaaa ON aaaa.uid = c.qrcode_uid
            
            LEFT JOIN ipadqrcode_product_list AS qra ON qra.product_id = o.qrcode_product_id
            LEFT JOIN ipadqrcode_product_step1 AS dddddd ON qra.product_id = dddddd.product_id
            LEFT JOIN ipadqrcode_product_step2 AS eeeeee ON qra.product_id = eeeeee.product_id
            LEFT JOIN ipadqrcode_product_step3 AS ffffff ON qra.product_id = ffffff.product_id AND ffffff.isdel = 0
            LEFT JOIN ipadqrcode_product_step4 AS gggggg ON qra.product_id = gggggg.product_id AND gggggg.isdel = 0
            LEFT JOIN ipadqrcode_product_step5 AS hhhhhh ON qra.product_id = hhhhhh.product_id AND hhhhhh.isdel = 0
            LEFT JOIN ipadqrcode_user_list AS cccccc ON dddddd.uid = cccccc.uid
            LEFT JOIN ipadqrcode_system_product_factory AS tttttt ON dddddd.factory_id = tttttt.factory_id
            
            
            WHERE o.order_id = $order_id".$where;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $orderinfo = $query->row_array();

            $sql1 = $this->db->query("select * from " . DB_PRE() . "order_list where o_id=$order_id");
            $new_order_list = $sql1->result_array();

            $mainarr = array();

            $sql = "SELECT * FROM " . DB_PRE() . "category_list WHERE parent = 3 ORDER BY sort ASC";
            $categorylist = $this->db->query($sql)->result_array();

            if (!empty($new_order_list)) {
                for ($j = 0; $j < count($new_order_list); $j++) {


                    if (!empty($categorylist)) {
                        for ($c = 0; $c < count($categorylist); $c++) {
                            $category_id = $categorylist[$c]['category_id'];
                            $sql = "
                        SELECT a.*
						, b.design_name_en, b.design_name_ch, b.ishave_checkbox, b.ishave_input, b.input_title_en, b.input_title_ch, b.ishave_input2, b.input2_title_en, b.input2_title_ch, b.ishave_picture, b.design_pic
                        , c.design_name_en AS radio_name_en, c.design_name_ch AS radio_name_ch, c.design_pic AS radio_pic
						FROM " . DB_PRE() . "order_detail AS a
						LEFT JOIN " . DB_PRE() . "category_design AS b ON a.design_id = b.design_id
						LEFT JOIN " . DB_PRE() . "category_design AS c ON a.radio_value = c.design_id
						WHERE a.order_id = " . $order_id . " AND order_list_id=" . $new_order_list[$j]['order_list_id'] . " AND a.category_id = " . $category_id . "
						ORDER BY a.detail_id ASC
                ";
                            $designlist = $this->db->query($sql)->result_array();
                            /*echo '<pre>';
                            print_r($designlist);
                            exit;*/
                            $subarr = array();
                            if (!empty($designlist)) {
                                for ($i = 0; $i < count($designlist); $i++) {
                                    $thisarr = array();
                                    $thisarr['design_id'] = $designlist[$i]['design_id'];
                                    $thisarr['design_name_en'] = $designlist[$i]['design_name_en'];
                                    $thisarr['design_name_ch'] = $designlist[$i]['design_name_ch'];
                                    if ($designlist[$i]['design_pic'] != '') {
                                        $thisarr['design_pic'] = $designlist[$i]['design_pic'];
                                    }

                                    if ($designlist[$i]['radio_value'] != 0) {
                                        $thisarr['radio_value'] = $designlist[$i]['radio_value'];
                                        $thisarr['radio_name_en'] = $designlist[$i]['radio_name_en'];
                                        $thisarr['radio_name_ch'] = $designlist[$i]['radio_name_ch'];
                                        $thisarr['radio_pic'] = $designlist[$i]['radio_pic'];
                                    }

                                    //if ($designlist[$i]['ishave_checkbox'] == 1) {
                                    $thisarr['checkbox_value'] = $designlist[$i]['checkbox_value'];
                                    //}
                                    //if ($designlist[$i]['ishave_input'] == 1) {
                                    $thisarr['input_value'] = $designlist[$i]['input_value'];
                                    if ($designlist[$i]['input_title_en'] != '') {
                                        $thisarr['input_title_en'] = $designlist[$i]['input_title_en'];
                                    }
                                    if ($designlist[$i]['input_title_ch'] != '') {
                                        $thisarr['input_title_ch'] = $designlist[$i]['input_title_ch'];
                                    }
                                    //}
                                    //if ($designlist[$i]['ishave_input2'] == 1) {
                                    $thisarr['input2_value'] = $designlist[$i]['input2_value'];
                                    if ($designlist[$i]['input2_title_en'] != '') {
                                        $thisarr['input2_title_en'] = $designlist[$i]['input2_title_en'];
                                    }
                                    if ($designlist[$i]['input2_title_ch'] != '') {
                                        $thisarr['input2_title_ch'] = $designlist[$i]['input2_title_ch'];
                                    }
                                    //}

                                    $subarr[] = $thisarr;

                                }

                            }
                            /*echo '<pre>';
                            print_r($subarr);
                            exit;*/
                            $new_order_list[$j]['design_list_' . $category_id] = $subarr;
                            //array_push($mainarr[$j],$order_information);
                        }
                    }


                    $mainarr[] = $new_order_list[$j];

                }
                //$orderinfo['order_list_' . $order_id] = $mainarr;

                $orderinfo['order_list'] = $mainarr;
                //design data goes here


            }

            return $orderinfo;
        } else {
            return null;
        }
    }

    function get_and_check_orderinfo($order_id, $uid = 0)
    {
        $sql   = "select * from " . DB_PRE() . "order_list where order_id=$order_id and uid=$uid";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return null;
        }
    }

    function edit_order($order_list_id, $arr)
    {
        $this->db->update(DB_PRE() . 'order_list', $arr, array(
            'order_list_id' => $order_list_id
        ));
    }

    function edit_main_order($order_id, $arr)
    {
        $this->db->update(DB_PRE() . 'order', $arr, array(
            'order_id' => $order_id
        ));
    }

    function del_order($order_id)
    {
        $orderinfo = $this->OrderModel->getorderinfo($order_id);
        if (!empty($orderinfo)) {
            $clientinfo = $this->UserModel->getuserinfo($orderinfo['client_id']);
            //同时删除订单的详细产品--开始
            $sql        = "SELECT * FROM " . DB_PRE() . "order_detail WHERE order_id=$order_id";
            $result     = $this->db->query($sql)->result_array();
            if (!empty($result)) {
                for ($i = 0; $i < count($result); $i++) {
                    $this->del_gksel_order_detail($result[$i]['detail_id']);
                }
            }
            //同时删除订单的详细产品--结束
            $this->db->delete(DB_PRE() . 'user_list', array(
                'uid' => $orderinfo['client_id']
            ));

            if (!empty($clientinfo)) {
                $this->db->delete('ipadqrcode_user_list', array(
                    'uid' => $clientinfo['qrcode_uid']
                ));
            }


            $this->db->delete('ipadqrcode_product_list', array(
                'product_id' => $orderinfo['qrcode_product_id']
            ));
            $this->db->delete('ipadqrcode_product_step1', array(
                'product_id' => $orderinfo['qrcode_product_id']
            ));
            $this->db->delete('ipadqrcode_product_step2', array(
                'product_id' => $orderinfo['qrcode_product_id']
            ));
            $this->db->delete('ipadqrcode_product_step3', array(
                'product_id' => $orderinfo['qrcode_product_id']
            ));
            $this->db->delete('ipadqrcode_product_step4', array(
                'product_id' => $orderinfo['qrcode_product_id']
            ));
            $this->db->delete('ipadqrcode_product_step5', array(
                'product_id' => $orderinfo['qrcode_product_id']
            ));
            $this->db->delete('ipadqrcode_product_form_meacheck', array(
                'product_id' => $orderinfo['qrcode_product_id']
            ));
            $this->db->delete('ipadqrcode_product_form_qfcheck', array(
                'product_id' => $orderinfo['qrcode_product_id']
            ));


            $this->db->delete(DB_PRE() . 'order', array(
                'order_id' => $order_id
            ));

            $this->db->delete(DB_PRE() . 'order_list', array(
                'o_id' => $order_id
            ));

            $this->db->delete(DB_PRE() . 'order_detail', array(
                'order_id' => $order_id
            ));
        }

    }

    function del_gksel_order_detail($detail_id = 0)
    {
        $this->db->delete(DB_PRE() . 'order_detail', array(
            'detail_id' => $detail_id
        ));
    }

    function getexpress($order_id)
    {
        $sql = "select orders.express_number,express.code,express.name from " . DB_PRE() . "order_list orders left join " . DB_PRE() . "express_list exp on exp.id=orders.express_type left join " . DB_PRE() . "express_code express on express.id=exp.code where orders.order_id=$order_id";
        return $this->db->query($sql)->row_array();
    }

    function getexpressinfo($express_id)
    {
        $subsql = "SELECT code FROM " . DB_PRE() . "express_code code WHERE id=exp.code";
        $sql    = "select exp.*,($subsql) as code_name from " . DB_PRE() . "express_list exp WHERE exp.id=$express_id";
        $result = $this->db->query($sql)->row_array();
        if (!empty($result)) {
            return $result;
        } else {
            return null;
        }
    }

    function gksel_order_detail_info($order_id, $product_id)
    {
        $sql   = "SELECT * FROM " . DB_PRE() . "order_detail WHERE order_id=$order_id AND product_id=$product_id";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return null;
        }
    }

    function is_review($pid, $oid, $uid)
    {
        $sql    = "SELECT * FROM order_pingjia WHERE pid=$pid AND oid=$oid AND uid=$uid";
        $result = $this->db->query($sql)->result_array();
        if (!empty($result)) {
            return $result;
        } else {
            return null;
        }
    }

    function get_review_info($id)
    {
        $sql   = "select * from order_pingjia where id=$id";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return null;
        }
    }

    function add_order_review($arr)
    {
        $this->db->insert('order_pingjia', $arr);
    }

    //添加订单的记录
    function addorder_log($con = array())
    {
        if (isset($con['order_id']) && isset($con['content'])) {
            $con['created'] = time();
            $this->db->insert(DB_PRE() . 'order_log', $con);
        }
    }
    //获取订单的记录
    function getorder_loglist($con = "", $iscount = 0)
    {
        $where    = "";
        $order_by = "";
        $limit    = "";
        if (isset($con['order_id'])) {
            if ($where != "") {
                $where .= " AND ";
            } else {
                $where .= " WHERE ";
            }
            $where .= " order_id =" . $con['order_id'];
        }
        if (isset($con['orderby']) && isset($con['orderby_res'])) {
            $order_by .= " ORDER BY " . $con['orderby'] . " " . $con['orderby_res'] . "";
        }
        if (isset($con['row']) && isset($con['page'])) {
            $limit .= " LIMIT " . $con['row'] . "," . $con['page'] . "";
        }

        if ($iscount == 0) {
            $sql    = "SELECT * FROM " . DB_PRE() . "order_log  $where $order_by $limit";
            $result = $this->db->query($sql)->result_array();
            if (!empty($result)) {
                return $result;
            } else {
                return null;
            }
        } else {
            $sql    = "SELECT count(*) as count FROM " . DB_PRE() . "order_log  $where $order_by";
            $result = $this->db->query($sql)->row_array();
            if (!empty($result)) {
                return $result['count'];
            } else {
                return 0;
            }
        }
    }

    //获取用户所有订单
    function getuserorders($uid)
    {
        $this->db->order_by('created', 'desc');
        return $this->db->get_where(DB_PRE() . 'order_list', array(
            'uid' => $uid
        ))->result_array();
    }

    function getreviewlist($con = array(), $iscount = 0)
    {
        $where    = "";
        $order_by = "";
        $limit    = "";
        if (isset($con['status'])) {
            if ($where != "") {
                $where .= " AND ";
            } else {
                $where .= " WHERE ";
            }
            $where .= " status =" . $con['status'];
        }
        if (isset($con['pid'])) {
            if ($where != "") {
                $where .= " AND ";
            } else {
                $where .= " WHERE ";
            }
            $where .= " pid =" . $con['pid'];
        }
        if (isset($con['orderby']) && isset($con['orderby_res'])) {
            $order_by .= " ORDER BY " . $con['orderby'] . " " . $con['orderby_res'] . "";
        }
        if (isset($con['row']) && isset($con['page'])) {
            $limit .= " LIMIT " . $con['row'] . "," . $con['page'] . "";
        }
        if ($iscount == 0) {
            $sql    = "SELECT * FROM order_pingjia $where $order_by $limit";
            $result = $this->db->query($sql)->result_array();
            if (!empty($result)) {
                return $result;
            } else {
                return null;
            }
        } else {
            $sql    = "SELECT count(*) as count FROM order_pingjia $where $order_by";
            $result = $this->db->query($sql)->row_array();
            if (!empty($result)) {
                return $result['count'];
            } else {
                return 0;
            }
        }
    }

    function edit_product_pingjia($id, $arr)
    {
        $this->db->update('order_pingjia', $arr, array(
            'id' => $id
        ));
    }

    function del_product_pingjia($id)
    {
        $this->db->delete('order_pingjia', array(
            'id' => $id
        ));
    }

    /*
     * 验证当前的订单是否存在评论
     * */
    function check_gksel_product_reviews($con)
    {
        $where    = "";
        $order_by = "";
        $limit    = "";
        if (isset($con['detail_id'])) {
            if ($where != "") {
                $where .= " AND ";
            } else {
                $where .= " WHERE ";
            }
            $where .= " detail_id =" . $con['detail_id'];
        }
        $sql    = "SELECT * FROM " . DB_PRE() . "product_reviews $where $order_by $limit";
        $result = $this->db->query($sql)->result_array();
        if (!empty($result)) {
            return $result;
        } else {
            return null;
        }
    }

    function insert_gksel_product_reviews($arr)
    {
        $this->db->insert(DB_PRE() . 'product_reviews', $arr);
    }


    //获取快递的列表
    function getexpress_select($id = 0)
    {
        $str     = '';
        $express = $this->ExpressModel->getexpresslist(array(
            'status' => 1,
            'orderby' => 'e.id',
            'orderby_res' => 'ASC'
        ));
        if (!empty($express)) {
            for ($i = 0; $i < count($express); $i++) {
                if ($id == $express[$i]['id']) {
                    $isselect = ' selected';
                } else {
                    $isselect = '';
                }
                $str .= '<option value="' . $express[$i]['id'] . '" ' . $isselect . '>' . $express[$i]['name'] . '</option>';
            }
        }
        return $str;
    }

    //计算一个订单的产品的售出数量
    function updateorder_soldnum($order_id = 0)
    {
        $order_detaillist = $this->OrderModel->getorder_productlist(array(
            'order_id' => $order_id,
            'orderby' => 'id',
            'orderby_res' => 'ASC'
        ));
        if (!empty($order_detaillist)) {
            for ($i = 0; $i < count($order_detaillist); $i++) {
                $this->ProductModel->updateproduct_soldnum($order_detaillist[$i]['product_id']); //计算一个产品的售出数量
            }
        }
    }

    function del_order_details($order_id = 0)
    {
        $this->db->delete(DB_PRE() . 'order_detail', array(
            'order_id' => $order_id
        ));
    }

    //订单减少产品库存
    function order_minusinventory($order_id)
    {
        $orderinfo = $this->OrderModel->getorderinfo($order_id);
        //减少库存 ------ START
        $order_detaillist = $this->OrderModel->getorder_productlist(array(
            'order_id' => $order_id,
            'orderby' => 'id',
            'ASC'
        ));
        if (!empty($order_detaillist)) {
            for ($dddd = 0; $dddd < count($order_detaillist); $dddd++) {
                $product_id  = $order_detaillist[$dddd]['product_id'];
                $size_id     = $order_detaillist[$dddd]['size_id'];
                $action_num  = $order_detaillist[$dddd]['count'];
                $action_desc = $orderinfo['order_number'];

                $size_id = 1;

                $sql           = "SELECT * FROM " . DB_PRE() . "product_inventory_list WHERE product_id = " . $product_id . " AND size_id = " . $size_id;
                $inventoryinfo = $this->db->query($sql)->row_array();
                if (!empty($inventoryinfo)) {
                    $inventory_id      = $inventoryinfo['inventory_id'];
                    $old_inventory_num = $inventoryinfo['inventory_num'];
                } else {
                    $this->db->insert(DB_PRE() . 'product_inventory_list', array(
                        'product_id' => $product_id,
                        'size_id' => $size_id,
                        'inventory_num' => 0
                    ));
                    $inventory_id      = $this->db->insert_id();
                    $old_inventory_num = 0;
                }
                if ($old_inventory_num >= $action_num) {

                    $this->db->insert(DB_PRE() . 'product_inventory_detail', array(
                        'action_type' => 3,
                        'inventory_id' => $inventory_id,
                        'action_num' => $action_num,
                        'action_desc' => $action_desc,
                        'action_time' => time()
                    ));

                    $sql = "UPDATE " . DB_PRE() . "product_inventory_list SET inventory_num = inventory_num - " . $action_num . " WHERE product_id = " . $product_id . " AND size_id = " . $size_id;
                    $this->db->query($sql);

                    //计算该商品的库存总量
                    $sql = "SELECT SUM(inventory_num) AS totalnum FROM " . DB_PRE() . "product_inventory_list WHERE product_id = " . $product_id;
                    $res = $this->db->query($sql)->row_array();
                    if (!empty($res)) {
                        $totalnum = $res['totalnum'];
                    } else {
                        $totalnum = 0;
                    }
                    $sql  = "SELECT * FROM " . DB_PRE() . "product_inventory_total WHERE product_id = " . $product_id;
                    $info = $this->db->query($sql)->row_array();
                    if (!empty($info)) {
                        $this->db->update(DB_PRE() . 'product_inventory_total', array(
                            'inventory_totalnum' => $totalnum
                        ), array(
                            'inventory_totalid' => $info['inventory_totalid']
                        ));
                    } else {
                        $this->db->insert(DB_PRE() . 'product_inventory_total', array(
                            'product_id' => $product_id,
                            'inventory_totalnum' => $totalnum
                        ));
                        $this->db->insert_id();
                    }
                }
            }
        }
        //减少库存 ------ END
    }

    //自动清理所有 超过一天未付款的订单
    function autocleanup_unpayorder()
    {
        $con       = array(
            'other_con' => 'o.created < ' . (time() - 86400 * 3),
            'statusin' => '0',
            'orderby' => 'o.order_id',
            'orderby_res' => 'DESC'
        );
        $orderlist = $this->OrderModel->getorderlist($con);
        if (!empty($orderlist)) {
            for ($i = 0; $i < count($orderlist); $i++) {
                $this->OrderModel->del_order($orderlist[$i]['order_id']);
            }
        }
    }

    function edit_order_status($order_id)
    {
        $this->db->query("update rojoipad_order_list set status=5 where o_id=" . $order_id);
    }


}