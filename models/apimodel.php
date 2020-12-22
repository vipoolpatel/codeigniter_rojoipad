<?php
class ApiModel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	
	function checknormalaction($con){
		$partner_id = $con['partner_id'];// Partner ID
		$partner_key = $con['partner_key'];// Partner KEY
		
		if($partner_id == "" || $partner_key == ""){
			//无效的凭证，partner_id 或者 key 无效或不是最新
			$rearr=array('status'=>'101','statusmsg'=>'invalid credential, partner_id or key is invalid or not latest');
			echo json_encode($rearr);
			exit; return ;//终止
		}
		
		//此处以后要判断是否有特殊字符，有特殊字符或许会报 sql 错误
		$sql="SELECT * FROM ".DB_PRE()."user_partner WHERE partner_id='".trim($partner_id)."' AND partner_key='".trim($partner_key)."'";
		$result=$this->db->query($sql)->row_array();
		if(!empty($result)){
			if($result['status']==1){
				
			}else{
				//无效的凭证，partner_id 已被下线
				$rearr=array('status'=>'102','statusmsg'=>'invalid credential, partner_id has been offline');
				echo json_encode($rearr);
				exit; return ;//终止
			}
		}else{
			//无效的凭证，partner_id 或者 key 无效或不是最新
			$rearr=array('status'=>'101','statusmsg'=>'invalid credential, partner_id or key is invalid or not latest');
			echo json_encode($rearr);
			exit; return ;//终止
		}
		
		
	}
	
	function getproductlist($uid = 0,$month,$year){
		
		$where = ' WHERE 1=1';
		if($uid > 0){
			$where.= ' and ro.uid="'.$uid.'"';
		}
		$database = 'ipadqrcode_';
		  $sql="
				SELECT distinct a.* ,
					
					b.brand_name_en, b.brand_name_ch
				
					, c.user_realname, c.user_number, c.company_businesslicense
					, d.step1_user_number, d.step1_date_cloth_due, d.step1_date_cloth_submitted, d.step1_status_num, d.step1_approve_status, d.step1_approve_time_1, d.step1_approve_time_2, d.step1_approve_time_3, d.step1_approve_time_4, d.step1_approve_time_5
					, e.step2_notes, e.step2_approve_status, e.step2_approve_time , e.next_step
					, f.step3_date_new_due, f.step3_approve_status, f.step3_approve_time
					, g.step4_approve_status, g.step4_approve_time, g.step4_status_num, g.step4_approve_time_1, g.step4_approve_time_2, g.step4_approve_time_3, g.date_cloth_submitted AS step4_date_start, g.date_cloth_due AS step4_date_end
					, h.step5_approve_status, h.step5_approve_time
					, t.factory_name_en, t.factory_name_ch, i.step7_1_status , i.step7_8_status , i.step7_1_approve_time , i.step7_8_approve_time, i.tracking_number
				
				FROM ".$database."product_list AS a 
				
				LEFT JOIN ".$database."system_product_brand AS b ON a.brand_id = b.brand_id
						
				LEFT JOIN ".$database."product_step1 AS d ON a.product_id = d.product_id
				LEFT JOIN ".$database."product_step2 AS e ON a.product_id = e.product_id
				LEFT JOIN ".$database."product_step3 AS f ON a.product_id = f.product_id AND f.isdel = 0
				LEFT JOIN ".$database."product_step4 AS g ON a.product_id = g.product_id AND g.isdel = 0
				LEFT JOIN ".$database."product_step5 AS h ON a.product_id = h.product_id AND h.isdel = 0
				LEFT JOIN ".$database."product_step7 AS i ON a.product_id = i.product_id 
				LEFT JOIN ".$database."system_product_factory AS t ON d.factory_id = t.factory_id
				LEFT JOIN ".$database."user_list AS c ON d.uid = c.uid 
				LEFT JOIN rojoipad_user_list AS ul ON ul.qrcode_uid = c.uid 
				LEFT JOIN rojoipad_order AS ro ON ro.client_id = ul.uid
			".$where." 
			and MONTH(FROM_UNIXTIME(ro.`created`)) = '$month' and YEAR(FROM_UNIXTIME(ro.`created`)) = '$year'
			order by a.created desc";
			//exit;
			// LEFT JOIN rojoipad_order AS ro ON ro.qrcode_product_id = a.product_id -- change this line in rojoipad_order other line
			//and MONTH(FROM_UNIXTIME(ro.`created`)) = '$month' and YEAR(FROM_UNIXTIME(ro.`created`)) = '$year'
			//echo $sql;exit;
			$result=$this->db->query($sql)->result_array();
			return $result;
			// and MONTH(FROM_UNIXTIME(ro.`created`)) = '$month' and YEAR(FROM_UNIXTIME(ro.`created`)) = '$year'  
	}
        
        function getpointlist($userid){
            $database = 'rojoipad_';
            
            $sql = "SELECT distinct c.category_name_en,ud.cat_id FROM ".$database."category_list c LEFT JOIN ".$database."user_details ud on c.category_id=ud.cat_id WHERE ud.userid=".$userid;
            $result=$this->db->query($sql)->result_array();
	    
            $first_arr = array();
            foreach($result as $data){
                $sec_arr = array();
                
                $sql1 = "SELECT  cd.design_name_en,ud.design_id,ud.points FROM ".$database."category_design cd LEFT JOIN ".$database."user_details ud on cd.design_id=ud.design_id WHERE ud.userid=".$userid." and ud.cat_id=".$data['cat_id'];
                $result1 = $this->db->query($sql1)->result_array();
                $j = 0;
                foreach($result1 as $data1){
                    $first_arr[$data['category_name_en']][$data1['design_name_en']] = $data1['points'];
                    $j = $j + 1;
                }
            }
            return $first_arr;
        }
		
		function getcustpointlist($userid){
            $database = 'rojoipad_';
            
            $sql = "SELECT distinct c.category_name_en,ud.cat_id FROM ".$database."category_list c LEFT JOIN ".$database."user_details ud on c.category_id=ud.cat_id WHERE ud.userid=".$userid;
            $result=$this->db->query($sql)->result_array();
	    
            $first_arr = array();
            foreach($result as $data){
                $sec_arr = array();
                
                $sql1 = "SELECT  cd.design_name_en,ud.design_id,ud.cust_points FROM ".$database."category_design cd LEFT JOIN ".$database."user_details ud on cd.design_id=ud.design_id WHERE ud.userid=".$userid." and ud.cat_id=".$data['cat_id'];
                $result1 = $this->db->query($sql1)->result_array();
                $j = 0;
                foreach($result1 as $data1){
                    $first_arr[$data['category_name_en']][$data1['design_name_en']] = $data1['cust_points'];
                    $j = $j + 1;
                }
            }
            return $first_arr;
        }
	
        function verifypoints($data){
            $database = 'rojoipad_';
            $sql = "SELECT ID FROM ".$database."user_wallet WHERE userid=".$data['userid']." and amount='".$data['amount']."' and status=0";
            $rows = $this->db->query($sql)->num_rows();
            if($rows > 0){
                $data['status'] = 1;
                $data['paydate'] = time();
                $this->db->update(DB_PRE() . 'user_wallet', $data, array('userid' => $data['userid'], 'amount' => $data['amount'], 'status' => 0));
                
                $sql1 = $this->db->query("SELECT sum(amount) as totalamount FROM ".$database."user_wallet WHERE userid=".$data['userid']."  and status=1 group by userid");
                $totalamount = $sql1->row()->totalamount;
                
                $rearr = array('status'=>'1', 'statusmsg'=>'Point added', 'totalpoints'=> $totalamount);
            }else{
                $rearr=array('status'=>'103','statusmsg'=>'No Record Exist!!');
            }
            return $rearr;
            
        }
        
        function totalpoints($uid){
            $database = 'rojoipad_';
            $sql1 = $this->db->query("SELECT sum(amount) as totalamount FROM ".$database."user_wallet WHERE userid=".$uid."   group by userid");
            $rows   = $sql1->num_rows();
            $totalamount =  0;
            if($rows > 0){
                $totalamount = $sql1->row()->totalamount;
            }
			
			$sql2 = $this->db->query("SELECT sum(totalPoint) as totalPoint FROM ".$database."order WHERE uid=".$uid."   group by uid");
            $rows1   = $sql2->num_rows();
            $o_amt =  0;
            if($rows1 > 0){
                $o_amt = $sql2->row()->totalPoint;
            }
			
			$t = $totalamount - $o_amt;
			
            $rearr = array('status'=>'1', 'statusmsg'=>'success', 'totalpoints'=> $t);
            return $rearr;
            
        }
        
        function paymenthistory($uid){
            $database = 'rojoipad_';
            $sql = $this->db->query("SELECT amount as point,payment_status,paydate,method FROM ".$database."user_wallet WHERE userid=".$uid."   ");
            $data = $sql->result_array();
            $rearr = array('status'=>'1', 'statusmsg'=>'success', 'data'=> json_encode($data));
            return $rearr;
            
        }
}
