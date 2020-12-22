<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Script extends CI_Controller {
	
	function __construct(){
		parent::__construct();
	}
	
	//Author: gksel
	//Date: 2015-08-20
	/*function index_script_old(){
		$sql1 = $this->db->query("select * from tmp_order_cross");
		foreach($sql1->result_array() as $data1){
			$sql2 = $this->db->query("select * from rojoipad_order_detail_old where order_id='".$data1['olist_no']."'");
			foreach($sql2->result_array() as $newdata){
				$array2 = array(
					'order_id' => $data1['o_no'],
					'order_list_id' => $data1['o_no'],
					'category_id' => $newdata['category_id'],
					'design_id' => $newdata['design_id'],
					'radio_value' => $newdata['radio_value'],
					'checkbox_value' => $newdata['checkbox_value'],
					'input_value' => $newdata['input_value'],
					'input2_value' => $newdata['input2_value']
				);
				
				$this->db->insert('rojoipad_order_detail', $array2);
			}
			 
		}
		
		echo 'Done';
		exit;
	}*/
	/*function index_script(){
		
		$sql = $this->db->query("select * from rojoipad_order_list");
		foreach($sql->result_array() as $data){
			//echo '<pre>';
			//print_r($data);
			//exit;
			$total = 0;
			if($data['totalPoint'] > 0){
				$total = $data['totalPoint'];
			}
			$array = array(
				'order_number' => $data['order_number'],
				'uid' => $data['uid'],
				'client_id' => $data['client_id'],
				'category_id' => $data['category_id'],
				'qrcode_product_id' => $data['qrcode_product_id'],
				'total_price' => $data['total_price'],
				'totalPoint' => $total ,
				'deposit_price' => $data['deposit_price'],
				'remaining_price' => $data['remaining_price'],
				'order_memo' => $data['order_memo'],
				'order_key' => $data['order_key'],
				'delivery_time' => $data['delivery_time'],
				'arrival_time' => $data['arrival_time'],
				'created' => $data['created'],
				'edited' => $data['edited']
			);
			
			$this->db->insert('rojoipad_order1', $array);
			$order_id = $this->db->insert_id();
			
			$array1 = array(
				'o_id' => $order_id ,
				'code_suit' => $data['code_suit'],
				'code_waistcoat' => $data['code_waistcoat'],
				'code_trousers' => $data['code_trousers'],
				'code_shirt' => $data['code_shirt'],
				'code_overcoat' => $data['code_overcoat'],
				'code_suit_select' => $data['code_suit_select'],
				'code_waistcoat_select' => $data['code_waistcoat_select'],
				'code_trousers_select' => $data['code_trousers_select'],
				'code_shirt_select' => $data['code_shirt_select'],
				'code_overcoat_select' => $data['code_overcoat_select'],
				'ja_garment' => $data['ja_garment'],
				'ja_length' => $data['ja_length'],
				'ja_shoulders' => $data['ja_shoulders'],
				'ja_chest' => $data['ja_chest'],
				'ja_chest_f' => $data['ja_chest_f'],
				'ja_chest_b' => $data['ja_chest_b'],
				'ja_bust' => $data['ja_bust'],
				'ja_circumference' => $data['ja_circumference'],
				'ja_sleeve' => $data['ja_sleeve'],
				'ja_bicep' => $data['ja_bicep'],
				'ja_wrist' => $data['ja_wrist'],
				'ja_neck' => $data['ja_neck'],
				'sh_garment' => $data['sh_garment'],
				'sh_length' => $data['sh_length'],
				'sh_shoulders' => $data['sh_shoulders'],
				'sh_chest' => $data['sh_chest'],
				'sh_chest_f' => $data['sh_chest_f'],
				'sh_chest_b' => $data['sh_chest_b'],
				'sh_bust' => $data['sh_bust'],
				'sh_circumference' => $data['sh_circumference'],
				'sh_sleeve' => $data['sh_sleeve'],
				'sh_bicep' => $data['sh_bicep'],
				'sh_wrist' => $data['sh_wrist'],
				'sh_neck' => $data['sh_neck'],
				'wc_garment' => $data['wc_garment'],
				'wc_length' => $data['wc_length'],
				'wc_shoulders' => $data['wc_shoulders'],
				'wc_chest' => $data['wc_chest'],
				'wc_chest_f' => $data['wc_chest_f'],
				'wc_chest_b' => $data['wc_chest_b'],
				'wc_bust' => $data['wc_bust'],
				'wc_circumference' => $data['wc_circumference'],
				'wc_sleeve' => $data['wc_sleeve'],
				'wc_bicep' => $data['wc_bicep'],
				'wc_wrist' => $data['wc_wrist'],
				'wc_neck' => $data['wc_neck'],
				'tr_garment' => $data['tr_garment'],
				'tr_length' => $data['tr_length'],
				'tr_waist' => $data['tr_waist'],
				'tr_gluteus' => $data['tr_gluteus'],
				'tr_thigh' => $data['tr_thigh'],
				'tr_crotch_rise' => $data['tr_crotch_rise'],
				'tr_crotch_front' => $data['tr_crotch_front'],
				'tr_crotch_back' => $data['tr_crotch_back'],
				'tr_hamstring' => $data['tr_hamstring'],
				'tr_calf' => $data['tr_calf'],
				'tr_ankle' => $data['tr_ankle'],
				'design_data_15' => $data['design_data_15'],
				'design_data_16' => $data['design_data_16'],
				'design_data_17' => $data['design_data_17'],
				'design_data_18' => $data['design_data_18'],
				'design_data_19' => $data['design_data_19'],
				'status' => $data['status'],
			);
			
			$this->db->insert('rojoipad_order_list1', $array1);
			$order_list_id = $this->db->insert_id();
			
			$sql2 = $this->db->query("select * from rojoipad_order_detail where order_id=".$order_id);
			foreach($sql2->result_array() as $newdata){
				$array2 = array(
					'order_id' => $order_id,
					'order_list_id' => $order_list_id,
					'category_id' => $newdata['category_id'],
					'design_id' => $newdata['design_id'],
					'radio_value' => $newdata['radio_value'],
					'checkbox_value' => $newdata['checkbox_value'],
					'input_value' => $newdata['input_value'],
					'input2_value' => $newdata['input2_value']
				);
				
				$this->db->insert('rojoipad_order_detail1', $array2);
			}
			
			
		}
		echo 'Done';
		exit;
		
	}
	
	function updateStatus(){
		$sql1 = $this->db->query("select order_id,status from sonali");
		foreach($sql1->result_array() as $data){
			$this->db->query("update rojoipad_order_list set status=".$data['status']." where o_id=".$data['order_id']);
			
		}
		echo 'done';
		exit;
	}
*/
	
}
