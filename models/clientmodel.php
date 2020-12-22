<?php
class ClientModel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	//用户登录
	function checkUser_login($phone, $pwd){
		$sql="SELECT * FROM ".DB_PRE()."user_list WHERE user_phone='$phone' and password='$pwd'";
		$result=$this->db->query($sql)->row_array();
		if(!empty($result)){
			return $result;
		}else{
			return null;
		}
	}
	//用户详细
	function getuserinfo($uid){
		$sql="select * from ".DB_PRE()."user_list where uid=".$uid;
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	// 用户详细
	function getuserinfo_Bywechatid($wechat_id) {
		$sql="select * from ".DB_PRE()."user_list where wechat_id = '".$wechat_id."'";
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	//用户详细----根据手机号
	function getuserinfo_ByPhone($phone){
		$sql="SELECT * FROM ".DB_PRE()."user_list WHERE user_phone='$phone'";
		$result=$this->db->query($sql)->row_array();
		if(!empty($result)){
			return $result;
		}else{
			return null;
		}
	}
	//添加用户
	function add_user($arr){
		$this->db->insert(DB_PRE().'user_list',$arr);
		return $this->db->insert_id();
	}
	//修改用户
	function edit_user($uid, $arr){
		// 配置图片字段
		$picarr = array ('company_businesslicense');
		$picstr = '';
		for($i = 0; $i < count ( $picarr ); $i ++) {
			if ($i != 0) {
				$picstr .= ',';
			}
			$picstr .= $picarr [$i];
		}
		// 同时删除图片
		$sql = "SELECT ".$picstr." FROM ".DB_PRE ()."user_list WHERE uid = ".$uid;
		$info = $this->db->query ( $sql )->row_array ();
		if (! empty ( $info )) {
			for($i = 0; $i < count ( $picarr ); $i ++) {
				$filename = $info [$picarr [$i]]; // 只能是相对路径
				if (isset ( $arr [$picarr [$i]] ) && $arr [$picarr [$i]] != '' && $filename != "" && $arr [$picarr [$i]] != $filename && file_exists ( $filename )) {
					@unlink ( $filename );
				}
			}
			$this->db->update(DB_PRE()."user_list",$arr,array('uid'=>$uid));
		}
	}
	// 修改用户-by wechat_id
	function edit_user_bywechatid($wechat_id, $arr) {
		$this->db->update ( DB_PRE () . 'user_list', $arr, array ('wechat_id' => $wechat_id ) );
	}
	//删除用户
	function del_user($uid){
		$this->db->delete(DB_PRE().'user_list', array('uid'=>$uid));
	}
	//删除用户form
	function del_user_form($form_id){
		$this->db->delete(DB_PRE().'user_form', array('form_id'=>$form_id));
	}
	//查询用户列表
	function getuserlist($con=array(),$uid,$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['other_con'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ".$con['other_con'];}
		if(isset($con['username'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " u.wechat_nickname LIKE '%".addslashes($con['username'])."%'";}
		if(isset($con['keyword'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ((u.user_phone LIKE '%".addslashes($con['keyword'])."%') OR (u.user_realname LIKE '%".addslashes($con['keyword'])."%') OR (u.user_number LIKE '%".addslashes($con['keyword'])."%')) ";}
		if(isset($con['parent'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " u.parent = ".$con['parent'];}
		if(isset($con['user_type'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " u.user_type = ".$con['user_type'];}
		if(isset($con['status'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " u.status =".$con['status'];}
                $where.=" and u.uid=".$uid;
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
		
		if($iscount==0){
			$sql="SELECT u.* FROM ".DB_PRE()."user_list u $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM ".DB_PRE()."user_list u $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}

	//检查手机号码是否已经被注册
	function checkphoneisexists($user_phone){
		$sql = "SELECT * FROM ".DB_PRE()."user_list WHERE user_phone = '".$user_phone."'";
		$result = $this->db->query($sql)->row_array();
		if(!empty($result)){
			return 'yes';
		}else{
			return 'no';
		}
	}

	//查询用户地址列表
	function getaddresslist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['other_con'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ".$con['other_con'];}
		if(isset($con['uid'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " uid =".$con['uid'];}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
	
		if($iscount==0){
			$sql="SELECT * FROM ".DB_PRE()."user_address $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM ".DB_PRE()."user_address $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	//用户地址详细
	function getaddressinfo($address_id){
		$sql = "select * from ".DB_PRE()."user_address where address_id=".$address_id;
		$result = $this->db->query($sql)->row_array();
		if(!empty($result)){
			return $result;
		}else{
			return null;
		}
	}
	//添加用户地址
	function add_useraddress($arr){
		$this->db->insert(DB_PRE().'user_address', $arr);
		return $this->db->insert_id();
	}
	
	
	function add_productstep2($arr){
		$this->db->insert(DB_PRE().'product_step2', $arr);
		return $this->db->$phase_id();
	}
	//修改用户地址
	function edit_useraddress($address_id, $arr){
		$this->db->update(DB_PRE().'user_address',$arr,array('address_id'=>$address_id));
	}
	//删除用户地址
	function del_useraddress($uid, $address_id){
		$this->db->delete(DB_PRE().'user_address', array('uid'=>$uid, 'address_id'=>$address_id));
	}
	
	/*获取 国家 数据库数据
	 * */
	function getcountry(){
		$sql="SELECT * FROM ".DB_PRE()."hat_country WHERE status=1 ORDER BY country_name ASC";
		$result=$this->db->query($sql)->result_array();
		return $result;
	}
	
	/*获取 省市区 数据库数据
	 * */
	function getprovince(){
		$this->db->select(array('provinceID','province_ch','province_en'));
		return $this->db->get_where(DB_PRE().'hat_province')->result_array();
	}
	
	/*获取城市*/
	function getcity($provinceID){
		$this->db->select(array('cityID','city_ch','city_en','father'));
		return $this->db->get_where(DB_PRE().'hat_city',array('father'=>$provinceID))->result_array();
	}
	
	/*获取地区*/
	function getarea($cityID){
		$this->db->select(array('areaID','area_ch','area_en','father'));
		return $this->db->get_where(DB_PRE().'hat_area',array('father'=>$cityID))->result_array();
	}
	function getcountry_name($countryID=0){
		$sql="SELECT * FROM ".DB_PRE()."hat_country WHERE countryID=$countryID";
		$result=$this->db->query($sql)->row_array();
		if(!empty($result)){
			return $result['country_name'];
		}else{
			return null;
		}
	}
	
	function getprovince_name($provinceID=0){
		$sql="SELECT * FROM ".DB_PRE()."hat_province WHERE provinceID=$provinceID";
		$result=$this->db->query($sql)->row_array();
		if(!empty($result)){
			return $result['province'];
		}else{
			return null;
		}
	}
	
	function getcity_name($cityID=0){
		$sql="SELECT * FROM ".DB_PRE()."hat_city WHERE cityID=$cityID";
		$result=$this->db->query($sql)->row_array();
		if(!empty($result)){
			return $result['city'];
		}else{
			return null;
		}
	}
	
	function getarea_name($areaID=0){
		$sql="SELECT * FROM ".DB_PRE()."hat_area WHERE areaID=$areaID";
		$result=$this->db->query($sql)->row_array();
		if(!empty($result)){
			return $result['area'];
		}else{
			return null;
		}
	}
	
	//查出用户密码
	function check_user_pass($uid){
		$sql="select * from ".DB_PRE()."user_list where uid='$uid'";
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return $query->row_array();
		}else{
			return false;
		}
	}
	
	//查询用户地址列表
	function getuser_formlist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['other_con'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ".$con['other_con'];}
		if(isset($con['uid'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " uid =".$con['uid'];}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
	
		if($iscount==0){
			$sql="SELECT * FROM ".DB_PRE()."user_form $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM ".DB_PRE()."user_form $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	//用户地址详细
	function getuser_forminfo($form_id){
		$sql = "select * from ".DB_PRE()."user_form where form_id=".$form_id;
		$result = $this->db->query($sql)->row_array();
		if(!empty($result)){
			return $result;
		}else{
			return null;
		}
	}
	//查询积分设置列表
	function getuser_pointsetting_historylist($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['other_con'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " ".$con['other_con'];}
		if(isset($con['pointsetting_id'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " pointsetting_id =".$con['pointsetting_id'];}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
	
		if($iscount==0){
			$sql="SELECT * FROM ".DB_PRE()."user_point_setting_history $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM ".DB_PRE()."user_point_setting_history $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	//添加用户地址
	function add_userform($arr){
		$this->db->insert(DB_PRE().'user_form', $arr);
		return $this->db->insert_id();
	}
	//修改用户地址
	function edit_userform($form_id, $arr){
		$this->db->update(DB_PRE().'user_form',$arr,array('form_id'=>$form_id));
	}
	//删除用户地址
	function del_userform($uid, $form_id){
		$this->db->delete(DB_PRE().'user_form', array('uid'=>$uid, 'form_id'=>$form_id));
	}
	
}
