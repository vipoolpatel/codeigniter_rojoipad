<?php
class UserfeedbackModel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	//添加cms
	function add_cms($arr,$pid){
		/*echo '<pre>';
		print_r($arr);
		exit;*/
                $arr['parent'] = $pid;
		$this->db->insert(DB_PRE().'cms_list',$arr);
		return $this->db->insert_id();
	}
	//修改cms
	function edit_cms($cms_id,$arr){
		$this->db->update(DB_PRE().'cms_list',$arr,array('cms_id'=>$cms_id));
	}
		//删除cms
	function del_cms($cms_id){
		$this->db->delete(DB_PRE().'cms_list', array('cms_id'=>$cms_id));
	}
	//查询cms列表
	function getuserfeedbacklist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['other_con'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ".$con['other_con'];}
		if(isset($con['fb_subject'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " a.fb_subject = ".$con['keyword'];}
		if(isset($con['fb_email'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ((a.fb_email LIKE '%".addslashes($con['keyword'])."%')) ";}
		if(isset($con['fb_description'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ((a.fb_description LIKE '%".addslashes($con['keyword'])."%')) ";}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
	
		if($iscount==0){
			$sql="SELECT a.* FROM ".DB_PRE()."user_feedback a $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM ".DB_PRE()."user_feedback a $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	
	
	
	
}
