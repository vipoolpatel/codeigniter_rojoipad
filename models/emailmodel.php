<?php
class EmailModel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	//邮件详细
	function getemailinfo($email_id){
		$sql="
				SELECT a.*
	
				FROM ".DB_PRE()."email_list AS a
	
				WHERE a.email_id = ".$email_id."
		";
		$result = $this->db->query($sql)->row_array();
		if(!empty($result)){
			return $result;
		}else{
			return null;
		}
	}
	
	//添加邮件
	function add_email($arr){
		$this->db->insert(DB_PRE().'email_list',$arr);
		return $this->db->insert_id();
	}
	
	//修改邮件
	function edit_email($email_id,$arr){
		$this->db->update(DB_PRE().'email_list',$arr,array('email_id'=>$email_id));
	}
	//删除邮件
	function del_email($email_id){
		$this->db->delete(DB_PRE().'email_list', array('email_id'=>$email_id));
	}
	
	//查询邮件列表
	function getemaillist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['other_con'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ".$con['other_con'];}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
	
		if($iscount==0){
			$sql="SELECT a.* FROM ".DB_PRE()."email_list a $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM ".DB_PRE()."email_list a $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	
	
	
}
