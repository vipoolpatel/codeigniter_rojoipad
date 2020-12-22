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
	
	function getproductlist($uid){
	
		$database = 'ipadqrcode_';
		$sql="
				SELECT a.* ,
					
					b.brand_name_en, b.brand_name_ch
				
					, c.user_realname, c.user_number, c.company_businesslicense
					, d.step1_user_number, d.step1_date_cloth_due, d.step1_date_cloth_submitted, d.step1_status_num, d.step1_approve_status, d.step1_approve_time_1, d.step1_approve_time_2, d.step1_approve_time_3, d.step1_approve_time_4, d.step1_approve_time_5
					, e.step2_notes, e.step2_approve_status, e.step2_approve_time
					, f.step3_date_new_due, f.step3_approve_status, f.step3_approve_time
					, g.step4_approve_status, g.step4_approve_time, g.step4_status_num, g.step4_approve_time_1, g.step4_approve_time_2, g.step4_approve_time_3, g.date_cloth_submitted AS step4_date_start, g.date_cloth_due AS step4_date_end
					, h.step5_approve_status, h.step5_approve_time
					, t.factory_name_en, t.factory_name_ch
				
				FROM ".$database."product_list AS a 
				
				LEFT JOIN ".$database."system_product_brand AS b ON a.brand_id = b.brand_id
						
				LEFT JOIN ".$database."product_step1 AS d ON a.product_id = d.product_id
				LEFT JOIN ".$database."product_step2 AS e ON a.product_id = e.product_id
				LEFT JOIN ".$database."product_step3 AS f ON a.product_id = f.product_id AND f.isdel = 0
				LEFT JOIN ".$database."product_step4 AS g ON a.product_id = g.product_id AND g.isdel = 0
				LEFT JOIN ".$database."product_step5 AS h ON a.product_id = h.product_id AND h.isdel = 0
				LEFT JOIN ".$database."system_product_factory AS t ON d.factory_id = t.factory_id
				
				LEFT JOIN ".$database."user_list AS c ON d.uid = c.uid
				WHERE c.uid=".$uid."
				
			";
			$result=$this->db->query($sql)->result_array();
			return $result;
	}
	
}
