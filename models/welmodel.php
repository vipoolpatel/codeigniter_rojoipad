<?php
class WelModel extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->AppID=WECHAT_APPID();                     //AppID(应用ID)
		$this->AppSecret=WECHAT_APPSECRET();   //AppSecret(应用密钥)
	}
	
	function delgiftinfo($wechat_openid){
	
		$this->db->delete(DB_PRE().'gift_list',array('wechat_id'=>$wechat_openid));
		$this->db->delete(DB_PRE().'gift_share',array('wechat_id'=>$wechat_openid));
	}
	
	//添加临时文件
	function add_file_interim($arr){
		$this->db->insert(DB_PRE().'file_interim',$arr);
		return $this->db->insert_id();
	}
	
	//删除临时文件信息
	function delete_file_interim($path){
		$this->db->delete(DB_PRE().'file_interim',array('file_path'=>$path));
	}
	
	//删除临时文件
	function truncate_file_interim(){
        $sql = "SELECT * FROM " . DB_PRE() . "file_interim WHERE created < " . (time() - 86400);
        $result = $this->db->query($sql)->result_array();
        if (!empty($result)) {
            for ($i = 0; $i < count($result); $i++) {
                $filename = "" . $result[$i]['file_path'];  //只能是相对路径
                @unlink($filename);
                $this->db->delete(DB_PRE() . 'file_interim', array('file_path' => $result[$i]['file_path']));
            }
        }
    }
	
	
	//获取语言列表
	function getlanguage_list($con=array(),$iscount=0){
		$where="";
		$order_by="";
		$limit="";
		if(isset($con['status'])){if($where!=""){$where .=" AND";}else{$where .=" WHERE";} $where .= " status = ".$con['status'];}
		if(isset($con['orderby'])&&isset($con['orderby_res'])){$order_by .=" ORDER BY ".$con['orderby']." ".$con['orderby_res']."";}
		if(isset($con['row'])&&isset($con['page'])){$limit .=" LIMIT ".$con['row'].",".$con['page']."";}
		
		if($iscount==0){
			$sql="SELECT * FROM ".DB_PRE()."language_list $where $order_by $limit";
			$result=$this->db->query($sql)->result_array();
			if(!empty($result)){
				return $result;
			}else{
				return null;
			}
		}else{
			$sql="SELECT count(*) as count FROM ".DB_PRE()."language_list $where $order_by";
			$result=$this->db->query($sql)->row_array();
			if(!empty($result)){
				return $result['count'];
			}else{
				return 0;
			}
		}
	}
	
	
	
}
