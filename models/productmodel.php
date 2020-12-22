<?php
class ProductModel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	//商品详细
	function getproductinfo($product_id){
		$sql="
				SELECT a.*
				
				, c.user_realname, c.user_number, c.company_businesslicense
				, d.step1_user_number, d.step1_date_cloth_due, d.step1_date_cloth_submitted, d.step1_status_num, d.step1_approve_status, d.step1_approve_time_1, d.step1_approve_time_2, d.step1_approve_time_3, d.step1_approve_time_4, d.step1_approve_time_5
				, e.step2_notes, e.step2_approve_status, e.step2_approve_time
				, f.step3_date_new_due, f.step3_approve_status, f.step3_approve_time
				, g.step4_approve_status, g.step4_approve_time, g.step4_status_num, g.step4_approve_time_1, g.step4_approve_time_2, g.step4_approve_time_3, g.date_cloth_submitted AS step4_date_start, g.date_cloth_due AS step4_date_end
				, h.step5_approve_status, h.step5_approve_time
				, t.factory_name_en, t.factory_name_ch

				FROM ".DB_PRE()."product_list AS a 

				LEFT JOIN ipadqrcode_product_step1 AS d ON a.product_id = d.product_id
				LEFT JOIN ipadqrcode_product_step2 AS e ON a.product_id = e.product_id
				LEFT JOIN ipadqrcode_product_step3 AS f ON a.product_id = f.product_id AND f.isdel = 0
				LEFT JOIN ipadqrcode_product_step4 AS g ON a.product_id = g.product_id AND g.isdel = 0
				LEFT JOIN ipadqrcode_product_step5 AS h ON a.product_id = h.product_id AND h.isdel = 0

				LEFT JOIN ipadqrcode_user_list AS c ON d.uid = c.uid
				LEFT JOIN ipadqrcode_system_product_factory AS t ON d.factory_id = t.factory_id
						
				WHERE a.product_id=".$product_id
		;
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	//添加商品
	function add_product($arr){
		$this->db->insert(DB_PRE().'product_list',$arr);
		return $this->db->insert_id();
	}
	//修改商品
	function edit_product($product_id,$arr){
		$this->db->update(DB_PRE().'product_list',$arr,array('product_id'=>$product_id));
	}
	//删除商品
	function del_product($product_id){
		$this->db->delete(DB_PRE().'product_list', array('product_id'=>$product_id));
		$this->db->delete(DB_PRE().'product_category', array('product_id'=>$product_id));
	}
	//查询商品分类列表
	function getproductcategorylist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['other_con'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ".$con['other_con'];}
		if(isset($con['parent'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " a.parent = ".$con['parent'];}
		if(isset($con['keyword'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ((a.category_name_en LIKE '%".addslashes($con['keyword'])."%') OR (a.category_name_ch LIKE '%".addslashes($con['keyword'])."%')) ";}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
	
		if($iscount==0){
			$sql="SELECT a.* FROM ".DB_PRE()."category_list a $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM ".DB_PRE()."category_list a $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	
	//商品分类详细
	function getproductcategoryinfo($category_id){
		$sql="select * from ".DB_PRE()."category_list where category_id=".$category_id;
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	//商品分类详细
	function getproductcategoryinfo_BYshorturl($shorturl){
		$sql="select * from ".DB_PRE()."category_list where shorturl = '".$shorturl."'";
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	//添加商品分类
	function add_productcategory($arr){
		$this->db->insert(DB_PRE().'category_list',$arr);
		return $this->db->insert_id();
	}
	//修改商品分类
	function edit_productcategory($category_id,$arr){
		$this->db->update(DB_PRE().'category_list',$arr,array('category_id'=>$category_id));
	}
	//删除商品分类
	function del_productcategory($category_id){
		$this->db->delete(DB_PRE().'category_list', array('category_id'=>$category_id));
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
			$sql="SELECT a.* FROM ".DB_PRE()."system_product_brand a $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM ".DB_PRE()."system_product_brand a $where $order_by";
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
			$sql="SELECT a.* FROM ".DB_PRE()."system_product_flavor a $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM ".DB_PRE()."system_product_flavor a $where $order_by";
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
			$sql="SELECT a.* FROM ".DB_PRE()."system_product_skintype a $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM ".DB_PRE()."system_product_skintype a $where $order_by";
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
			$sql="SELECT a.* FROM ".DB_PRE()."system_product_hairtype a $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM ".DB_PRE()."system_product_hairtype a $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	
	//查询导入历史列表
	function getproductimportlist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['other_con'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ".$con['other_con'];}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
	
		if($iscount==0){
			$sql="SELECT a.* FROM ".DB_PRE()."product_import a $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM ".DB_PRE()."product_import a $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	//导入详细
	function getproductimportinfo($import_id){
		$sql="SELECT * FROM ".DB_PRE()."product_import WHERE import_id=".$import_id;
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	//添加导入
	function add_import($arr){
		$this->db->insert(DB_PRE().'product_import',$arr);
		return $this->db->insert_id();
	}
	//修改导入
	function edit_import($import_id,$arr){
		$this->db->update(DB_PRE().'product_import',$arr,array('import_id'=>$import_id));
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
		if(isset($con['product_id'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " a.product_id = ".$con['product_id'];}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
	
		if($iscount==0){
			$sql="SELECT a.* FROM ".DB_PRE()."product_picture a $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM ".DB_PRE()."product_picture a $where $order_by";
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
		$sql="SELECT * FROM ".DB_PRE()."product_picture WHERE picture_id=".$picture_id;
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	//添加图片
	function add_picture($arr){
		$this->db->insert(DB_PRE().'product_picture',$arr);
		return $this->db->insert_id();
	}
	//修改图片
	function edit_picture($picture_id, $arr){
		$this->db->update(DB_PRE().'product_picture',$arr,array('picture_id'=>$picture_id));
	}
	//删除图片
	function del_picture($picture_id){
		$this->db->delete(DB_PRE().'product_picture', array('picture_id'=>$picture_id));
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

	
	
	

	//查询工厂列表
	function getproductfactorylist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['other_con'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ".$con['other_con'];}
		if(isset($con['keyword'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ((a.factory_name_en LIKE '%".addslashes($con['keyword'])."%') OR (a.factory_name_ch LIKE '%".addslashes($con['keyword'])."%')) ";}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
	
		if($iscount==0){
			$sql="SELECT a.* FROM ".DB_PRE()."system_product_factory a $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM ".DB_PRE()."system_product_factory a $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	
	//工厂详细
	function getproductfactoryinfo($factory_id){
		$sql="select * from ".DB_PRE()."system_product_factory where factory_id=".$factory_id;
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	//添加工厂
	function add_productfactory($arr){
		$this->db->insert(DB_PRE().'system_product_factory',$arr);
		return $this->db->insert_id();
	}
	//修改工厂
	function edit_productfactory($factory_id,$arr){
		$this->db->update(DB_PRE().'system_product_factory',$arr,array('factory_id'=>$factory_id));
	}
	//删除工厂
	function del_productfactory($factory_id){
		$this->db->delete(DB_PRE().'system_product_factory', array('factory_id'=>$factory_id));
	}
	//添加产品尺寸
	function product_step2($arr){
		$this->db->insert(DB_PRE().'product_step2', $arr);
// 		return $this->db->insert_id();
	}
	
	//修改design
	function add_design($arr){
		$this->db->insert(DB_PRE().'category_design', $arr);
                return $this->db->insert_id();
	}
	//修改design
	function edit_design($design_id, $arr){
		$this->db->update(DB_PRE().'category_design', $arr, array('design_id'=>$design_id));
	}
	function delete_design($design_id){
        $this->db->delete(DB_PRE() . 'category_design', array('parent' => $design_id));
        $this->db->delete(DB_PRE() . 'category_design', array('design_id' => $design_id));
    }
}
