<?php
class AdminModel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function checkAdmin_username($name){
		$sql="select * from ".DB_PRE()."admin_list where admin_username='$name'";
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
        
        function checkUser_username($name){
		$sql="select * from ".DB_PRE()."user_list where user_number='$name'";
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	
	function checkAdmin($name,$pwd){
		$sql="select * from ".DB_PRE()."admin_list where admin_username='$name' and admin_password='$pwd'";
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
        
        function checkUser($name,$pwd){
		$sql="select * from ".DB_PRE()."user_list where user_number='$name' and password='$pwd'";
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
        
	function checkpassword($password){
		$sql="select * from ".DB_PRE()."admin_list where password='$password'";
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	function getadmininfo($admin_id){
		$sql="select * from ".DB_PRE()."admin_list where admin_id = ".$admin_id;
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	function add_admin($arr){
		$this->db->insert(DB_PRE().'admin_list',$arr);
		return $this->db->insert_id();
	}
	function edit_admin($admin_id,$arr){
		$this->db->where('admin_id',$admin_id);
		$this->db->update(DB_PRE().'admin_list',$arr);
	}
	
	function del_admin($admin_id){
		$this->db->delete(DB_PRE().'admin_list', array('admin_id'=>$admin_id));
	}
	
	//查询管理员助手列表
	function getadminlist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['other_con'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ".$con['other_con'];}
		if(isset($con['keyword'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ((u.admin_username LIKE '%".addslashes($con['keyword'])."%') OR (u.admin_email LIKE '%".addslashes($con['keyword'])."%') OR (u.admin_phone LIKE '%".addslashes($con['keyword'])."%')) ";}
		if(isset($con['admin_type'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " u.admin_type =".$con['admin_type'];}
		if(isset($con['status'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " u.status =".$con['status'];}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
	
		if($iscount==0){
			$sql="SELECT u.* FROM ".DB_PRE()."admin_list u $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM ".DB_PRE()."admin_list u $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
		
		
		
	}
	
	
	
}
