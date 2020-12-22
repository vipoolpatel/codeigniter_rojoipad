<?php
class SettingsModel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	//用户登录
	
	
	// 修改用户-by wechat_id
	function edit_user_lang($uid, $arr) {
		$this->db->update ( DB_PRE () . 'user_list', $arr, array ('uid' => $uid ) );
	}
	
	// 修改用户-by wechat_id
	function edit_user_currency($uid, $arr) {
		$this->db->update ( DB_PRE () . 'user_list', $arr, array ('uid' => $uid ) );
	}
        
        function edit_user_measurement($uid, $arr) {
		$this->db->update ( DB_PRE () . 'user_list', $arr, array ('uid' => $uid ) );
	}
        
        function edit_user_logo($uid, $arr) {
		$this->db->update ( DB_PRE () . 'user_list', $arr, array ('uid' => $uid ) );
	}
}
