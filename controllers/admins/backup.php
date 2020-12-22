<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Backup extends CI_Controller{

	function __construct(){
		parent::__construct();
		
		$ipadapplogin = $this->input->get('ipadapplogin');
		if($ipadapplogin == 1){
			$userinfo = array ('admin_id' => 1, 'admin_username' => 'admin', 'device' => 'ipad' );
			$userjson = serialize($userinfo);
			set_cookie('admin',$userjson,time()+3600*24*30);//设置登录的Cookie
		}
		if(isset($_COOKIE['admin'])){
			$admin = unserialize($_COOKIE['admin']);
			if(isset($admin ['device'])){
				$this->admin_id = $admin ['admin_id'];
				$this->admin_username = $admin ['admin_username'];
				$this->device = $admin ['device'];
			}else{
				redirect(base_url().'index.php/admin');
			}
		}else{
			redirect(base_url().'index.php/admin');
		}
		$lang = $this->session->userdata('lang');
		if($lang=='ch'){
			$this->session->set_userdata('lang','ch');
			$this->langtype='_ch';
			$this->lang->load('gksel','chinese');
		}else{
			$this->session->set_userdata('lang','en');
			$this->langtype='_en';
			$this->lang->load('gksel','english');
		}
	}
						
	
	
	public function index(){
		$dbname = $this->db->database;
		
		$uploaddir = "upload/";
		if (! is_dir ( $uploaddir )) {
			mkdir ( $uploaddir, 0777 );
		}
		$uploaddir = "upload/backup/";
		if (! is_dir ( $uploaddir )) {
			mkdir ( $uploaddir, 0777 );
		}
		$uploaddir = "upload/backup/".date('Y')."/";
		if (! is_dir ( $uploaddir )) {
			mkdir ( $uploaddir, 0777 );
		}
		$uploaddir = "upload/backup/".date('Y')."/".date('m')."/";
		if (! is_dir ( $uploaddir )) {
			mkdir ( $uploaddir, 0777 );
		}
		
		$fileName = $uploaddir.date('Y-m-d').'.sql';
		header("Content-type: text/html; charset=utf-8");
		
		$myfile = fopen($fileName, "w") or die("Unable to open file!");//打开存储文件
		
		
		
		$tables = array();
		$sql = "show tables;";
		$tableslist = $this->db->query($sql)->result_array();
		if(!empty($tableslist)){
			for ($j = 0; $j < count($tableslist); $j++) {
				$tableName = $tableslist[$j]['Tables_in_'.$dbname];//构成特定的下标
				
				$tableName_split = explode(DB_PRE(), $tableName);
				if(count($tableName_split) >= 2){
					$tables[] = $tableName;
				}
			}
		}
		
		if(!empty($tables)){
			for ($i = 0; $i < count($tables); $i++) {
				//var_dump($re);//查看数组构成
				$tableName = $tables[$i];//构成特定的下标
				$sql = "show create table {$tableName};";
				$tableSql = $this->db->query($sql)->row_array();
				
				fwrite($myfile, "DROP TABLE IF EXISTS `{$tableName}`;\r\n");//加入默认删除表的遇见
				//下面备份表结构，这个循环之执行一次
				if(!empty($tableSql)){
						// echo "<pre>";
						// var_dump($re);
						// echo "</pre>";
// 						echo "正在备份表{$tableSql['Table']}结构<br/>";
						fwrite($myfile, $tableSql['Create Table'].";\r\n\r\n");
// 						echo "正在备份表{$tableSql['Create Table']}结构完成<br/>";
				}
				//下面备份表数据
// 				echo "正在备份表{$tableName}数据<br/>";
				$sql = "select * from {$tableName};";
				$valueSql = $this->db->query($sql)->result_array();
				if(!empty($valueSql)){
					for ($j = 0; $j < count($valueSql); $j++) {
							$keyArr = array_keys($valueSql[$j]);//获得对应的键值
							$valueArr = array_values($valueSql[$j]);//获得对应的值
						
							$keyStr = '';
							foreach ($keyArr as $key => $value) {
								$keyStr .= "`".$value."`,";
							}
							$keyStr = substr($keyStr,0,strlen($keyStr)-1); //取出最后一个逗号
						
						
							$valueStr = '';
							// var_dump($valueArr);
							foreach ($valueArr as $key => $value) {
								$valueStr .= "'".$value."',";
							}
							//以上的处理只是对应sql的写法
						
							$valueStr = substr($valueStr,0,strlen($valueStr)-1); //取出最后一个逗号
							$sql = "insert into `{$tableName}`({$keyStr}) values({$valueStr})";
							fwrite($myfile, $sql.";\r\n\r\n");
					}
				}
				
				echo "正在备份表{$tableName}数据完成<br/>";
				echo "<br/><hr/>";
			}
		}
		fclose($myfile);
		
		redirect(base_url().$fileName);
	}
	
	
	
	
	
}