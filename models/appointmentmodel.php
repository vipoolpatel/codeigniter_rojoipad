<?php
class AppointmentModel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	//商品详细
	function getappointmentinfo($appointment_id){
		$sql="select * from ".DB_PRE()."appointment_list where appointment_id=".$appointment_id;
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	//添加商品
	function add_appointment($arr){
		$this->db->insert(DB_PRE().'appointment_list',$arr);
		return $this->db->insert_id();
	}
	//修改商品
	function edit_appointment($appointment_id,$arr){
		$this->db->update(DB_PRE().'appointment_list',$arr,array('appointment_id'=>$appointment_id));
	}
	//删除商品
	function del_appointment($appointment_id){
		$this->db->delete(DB_PRE().'appointment_list', array('appointment_id'=>$appointment_id));
		$this->db->delete(DB_PRE().'appointment_category', array('appointment_id'=>$appointment_id));
		$this->db->delete(DB_PRE().'appointment_category', array('appointment_id'=>$appointment_id));
	}
	//查询商品列表
	function getappointmentlist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		$leftjoin = "";
		if(isset($con['category_id'])){$leftjoin .= " LEFT JOIN ".DB_PRE()."appointment_category AS e ON a.appointment_id = e.appointment_id";}
		if(isset($con['category_id'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " e.category_id = ".$con['category_id'];}
		
		if(isset($con['other_con'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ".$con['other_con'];}
		if(isset($con['brand_id'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " a.brand_id = ".$con['brand_id'];}
		if(isset($con['keyword'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ((a.appointment_name_en LIKE '%".addslashes($con['keyword'])."%') OR (a.appointment_name_ch LIKE '%".addslashes($con['keyword'])."%') OR (a.appointment_SKUno LIKE '%".addslashes($con['keyword'])."%')) ";}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
		
		if($iscount==0){
			$sql="
				SELECT a.* ,
					
					d.user_phone, d.user_email, d.user_nickname
				
				FROM ".DB_PRE()."appointment_list AS a 
				
				LEFT JOIN ".DB_PRE()."user_list AS d ON a.uid = d.uid
				
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
					
					FROM ".DB_PRE()."appointment_list a 
					
					LEFT JOIN ".DB_PRE()."user_list AS d ON a.uid = d.uid
			
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
	
	//查询商品分类列表
	function getappointmentsettinglist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['other_con'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ".$con['other_con'];}
		if(isset($con['parent'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " a.parent = ".$con['parent'];}
		if(isset($con['keyword'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ((a.category_name_en LIKE '%".addslashes($con['keyword'])."%') OR (a.category_name_ch LIKE '%".addslashes($con['keyword'])."%')) ";}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
	
		if($iscount==0){
			$sql="SELECT a.* FROM ".DB_PRE()."appointmentsetting_list a $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM ".DB_PRE()."appointmentsetting_list a $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	
	//商品分类详细
	function getappointmentcategoryinfo($category_id){
		$sql="select * from ".DB_PRE()."system_appointment_category where category_id=".$category_id;
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	//商品分类详细
	function getappointmentcategoryinfo_BYshorturl($shorturl){
		$sql="select * from ".DB_PRE()."system_appointment_category where shorturl = '".$shorturl."'";
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	//添加商品分类
	function add_appointmentcategory($arr){
		$this->db->insert(DB_PRE().'system_appointment_category',$arr);
		return $this->db->insert_id();
	}
	//修改商品分类
	function edit_appointmentcategory($category_id,$arr){
		$this->db->update(DB_PRE().'system_appointment_category',$arr,array('category_id'=>$category_id));
	}
	//删除商品分类
	function del_appointmentcategory($category_id){
		$this->db->delete(DB_PRE().'system_appointment_category', array('category_id'=>$category_id));
	}
	//查询产品品牌列表
	function getbrandlist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['other_con'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ".$con['other_con'];}
		if(isset($con['keyword'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ((a.brand_name_en LIKE '%".addslashes($con['keyword'])."%')) ";}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
	
		if($iscount==0){
			$sql="SELECT a.* FROM ".DB_PRE()."system_appointment_brand a $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM ".DB_PRE()."system_appointment_brand a $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	
	//查询产品口味列表
	function getflavorlist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['other_con'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ".$con['other_con'];}
		if(isset($con['keyword'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ((a.flavor_name_en LIKE '%".addslashes($con['keyword'])."%')) ";}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
	
		if($iscount==0){
			$sql="SELECT a.* FROM ".DB_PRE()."system_appointment_flavor a $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM ".DB_PRE()."system_appointment_flavor a $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	//查询皮肤类型列表
	function getskintypelist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['other_con'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ".$con['other_con'];}
		if(isset($con['keyword'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ((a.skintype_name_en LIKE '%".addslashes($con['keyword'])."%')) ";}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
	
		if($iscount==0){
			$sql="SELECT a.* FROM ".DB_PRE()."system_appointment_skintype a $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM ".DB_PRE()."system_appointment_skintype a $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	//查询发质类型列表
	function gethairtypelist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['other_con'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ".$con['other_con'];}
		if(isset($con['keyword'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ((a.hairtype_name_en LIKE '%".addslashes($con['keyword'])."%')) ";}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
	
		if($iscount==0){
			$sql="SELECT a.* FROM ".DB_PRE()."system_appointment_hairtype a $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM ".DB_PRE()."system_appointment_hairtype a $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	
	//查询导入历史列表
	function getappointmentimportlist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['other_con'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ".$con['other_con'];}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
	
		if($iscount==0){
			$sql="SELECT a.* FROM ".DB_PRE()."appointment_import a $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM ".DB_PRE()."appointment_import a $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	//导入详细
	function getappointmentimportinfo($import_id){
		$sql="SELECT * FROM ".DB_PRE()."appointment_import WHERE import_id=".$import_id;
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	//添加导入
	function add_import($arr){
		$this->db->insert(DB_PRE().'appointment_import',$arr);
		return $this->db->insert_id();
	}
	//修改导入
	function edit_import($import_id,$arr){
		$this->db->update(DB_PRE().'appointment_import',$arr,array('import_id'=>$import_id));
	}
	
	
	//兑换产品详细
	function getloyaltyinfo($loyalty_id){
		$sql="select * from ".DB_PRE()."loyalty_list where loyalty_id=".$loyalty_id;
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	//添加兑换产品
	function add_loyalty($arr){
		$this->db->insert(DB_PRE().'loyalty_list',$arr);
		return $this->db->insert_id();
	}
	//修改兑换产品
	function edit_loyalty($loyalty_id,$arr){
		$this->db->update(DB_PRE().'loyalty_list',$arr,array('loyalty_id'=>$loyalty_id));
	}
	//删除兑换产品
	function del_loyalty($loyalty_id){
		$this->db->delete(DB_PRE().'loyalty_list', array('loyalty_id'=>$loyalty_id));
	}
	//查询兑换产品列表
	function getloyaltylist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['other_con'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ".$con['other_con'];}
		if(isset($con['keyword'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ((a.loyalty_name_en LIKE '%".addslashes($con['keyword'])."%')) ";}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
	
		if($iscount==0){
			$sql="SELECT a.* FROM ".DB_PRE()."loyalty_list a $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM ".DB_PRE()."loyalty_list a $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	
	
	
	
	//查询图片列表
	function getpicturelist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['other_con'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ".$con['other_con'];}
		if(isset($con['appointment_id'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " a.appointment_id = ".$con['appointment_id'];}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
	
		if($iscount==0){
			$sql="SELECT a.* FROM ".DB_PRE()."appointment_picture a $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM ".DB_PRE()."appointment_picture a $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	
	//图片详细
	function getpictureinfo($picture_id){
		$sql="SELECT * FROM ".DB_PRE()."appointment_picture WHERE picture_id=".$picture_id;
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	//添加图片
	function add_picture($arr){
		$this->db->insert(DB_PRE().'appointment_picture',$arr);
		return $this->db->insert_id();
	}
	//修改图片
	function edit_picture($picture_id, $arr){
		$this->db->update(DB_PRE().'appointment_picture',$arr,array('picture_id'=>$picture_id));
	}
	//删除图片
	function del_picture($picture_id){
		$this->db->delete(DB_PRE().'appointment_picture', array('picture_id'=>$picture_id));
	}
	//获取积分设置
	function getpointsettingvalue($pointsetting_id){
		$sql="SELECT * FROM ".DB_PRE()."user_point_setting WHERE pointsetting_id = ".$pointsetting_id;
		$result = $this->db->query($sql)->row_array();
		if(!empty($result)){
			return $result['pointsetting_value'];
		}else{
			return 0;
		}
	}

}
