<?php
class CmsModel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	//查询关键字列表
	function getkeywordlist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		$leftjoin="";
		if(isset($con['other_con'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ".$con['other_con'];}
		if(isset($con['keyword'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ((a.article_name_en LIKE '%".addslashes($con['keyword'])."%') OR (a.article_name_ch LIKE '%".addslashes($con['keyword'])."%')) ";}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
	
		if($iscount==0){
			$sql="
					SELECT a.*
			
					FROM ".DB_PRE()."system_keyword_list a
							
					$leftjoin
							
					$where $order_by $limit
			";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
			return $result;
			}else{
			return null;
			}
			}else{
			$sql="
				SELECT count(*) as count
			
					FROM ".DB_PRE()."system_keyword_list a
							
						$leftjoin
							
						$where $order_by
						";
						$result=$this->db->query($sql)->row_array();
						if(!empty($result)){
						return $result['count'];
						}else{
						return 0;
						}
			}
	}
	//添加关键字
	function add_keyword($arr){
		$this->db->insert(DB_PRE().'system_keyword_list',$arr);
		return $this->db->insert_id();
	}
	//关键字详细
	function getkeywordinfo($keyword_id){
		$sql="
				SELECT a.*
	
				FROM ".DB_PRE()."system_keyword_list AS a
	
				WHERE a.keyword_id = ".$keyword_id."
		";
		$result = $this->db->query($sql)->row_array();
		if(!empty($result)){
			return $result;
		}else{
			return null;
		}
	}
	//修改关键字
	function edit_keyword($keyword_id,$arr){
		$this->db->update(DB_PRE().'system_keyword_list',$arr,array('keyword_id'=>$keyword_id));
	}
	//删除关键字
	function del_keyword($keyword_id){
		$this->db->delete(DB_PRE().'system_keyword_list', array('keyword_id'=>$keyword_id));
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//cms详细
	function getcmsinfo($cms_id){
		$sql="select * from ".DB_PRE()."cms_list where cms_id=".$cms_id;
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	function getcmsinfo_BYshorturl($shorturl){
		$sql="select * from ".DB_PRE()."cms_list where shorturl = '".$shorturl."'";
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	//添加cms
	function add_cms($arr,$pid){
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
	function getcmslist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['other_con'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ".$con['other_con'];}
		if(isset($con['parent'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " a.parent = ".$con['parent'];}
		if(isset($con['keyword'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ((a.cms_name_en LIKE '%".addslashes($con['keyword'])."%')) ";}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
	
		if($iscount==0){
			$sql="SELECT a.* FROM ".DB_PRE()."cms_list a $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM ".DB_PRE()."cms_list a $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	
	
	
	
}
