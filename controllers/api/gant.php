<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gant extends CI_Controller {
	
	function __construct(){
		parent::__construct();
	}
	
	//Author: gksel
	//Date: 2015-08-20
	function index(){
		
		
		$partner_id = $this->input->get('partner_id');// Partner ID
		$partner_key = $this->input->get('partner_key');// Partner KEY
		
		$version = $this->input->get ( 'version' ); // 版本
		$lang = $this->input->get('lang');// 语言
		if($lang=='ch'){
			$langtype='_ch';// 语言
		}else{
			$langtype='_en';// 语言
		}
	
		 $uid = $this->input->get('uid');
		$randkey = $this->input->get('randkey');
		
		$month = $this->input->get('month'); // added by abhishek on 22nd March 2020
		$year = $this->input->get('year'); // added by abhishek on 22nd March 2020

		$con=array('partner_id'=>$partner_id,'partner_key'=>$partner_key);
		$this->ApiModel->checknormalaction($con);
			
		if ($uid == '' || $randkey == ''  || $lang == '' || $version == '' || $month == '' || $year == '' ) {
			//参数错误--缺少必要的参数
			$rearr=array('status'=>'103','statusmsg'=>'parameter error');
			echo json_encode($rearr);
			exit; return ;//终止
		}
		
		if(!is_numeric($uid) || $uid <= 0){
			//参数错误--$uid - client_id 必须为:正整数
			$rearr=array('status'=>'104','statusmsg'=>'parameter invalid');
			echo json_encode($rearr);
			exit; return ;//终止
		}
	
		$sql = "SELECT * FROM ".DB_PRE()."user_list WHERE uid=".$uid;
		$check_userinfo=$this->db->query($sql)->row_array();
		
		if(empty($check_userinfo)){
			//用户不存在!
			$rearr=array('status'=>'105','statusmsg'=>'account not exists');
			echo json_encode($rearr);
			exit; return ;//终止
		}
	
		if($check_userinfo['randkey'] != $randkey){
			//非法操作--用户 randkey 错误
			$rearr=array('status'=>'106','statusmsg'=>'Illegal Operation');
			echo json_encode($rearr);
			exit; return ;//终止
		}

		//$sql = "SELECT * FROM ".DB_PRE()."user_list WHERE uid=".$client_id;
		//$clientinfo=$this->db->query($sql)->row_array();
		/*if(empty($clientinfo)){
			//client不存在!
			$rearr=array('status'=>'107','statusmsg'=>'client not exists');
			echo json_encode($rearr);
			exit; return ;//终止
		}
		if($clientinfo['randkey'] != $client_key){
			//非法操作--client randkey 错误
			$rearr=array('status'=>'108','statusmsg'=>'Illegal Operation');
			echo json_encode($rearr);
			exit; return ;//终止
		}*/
		
		//$month = date('m');
		//$year = date('Y');




		$data = $this->ApiModel->getproductlist($uid,$month,$year);

		//dipak added code 17/02/2020
		
		foreach($data as $key => $val)
		{   
		   
			if( (!empty($val['tracking_number'])) || ($val['tracking_number'] != "") ){
				#echo "track";exit;
				$track =  $this->get_traking($val['tracking_number']);
		   
				foreach(array_reverse($track)  as $key1 => $trc)
				{
				  $keys = $key1+1;
				  
				  $trackinfo[] = array(
				    'no'=> '7.1.'.$keys,
				    'activity_country'=>$trc['activity_country'],
				    'activity_city'=>$trc['activity_city'],
				    'status'=>$trc['status'],
				    'date'=>$trc['date'],
				    'time'=>$trc['time'],
				  );
				}

				$data[$key]['track_info'] = $trackinfo;
				unset($trackinfo);

			} 

		}
		
		//dipak added  end code 17/02/2020
		
		
		$rearr = array('status'=>'1', 'statusmsg'=>'success', 'feedback_id'=>json_encode($data));
		echo json_encode($rearr);
	}


	//dipak added code 17/02/2020
	
	function get_traking($traking_number)
	{
	    $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://wwwcie.ups.com/rest/Track",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => "{\n  \"Security\": {\n    \"UsernameToken\": {\n      \"Username\": \"7XF698\",\n      \"Password\": \"UPSups123\"\n    },\n    \"UPSServiceAccessToken\": {\n      \"AccessLicenseNumber\": \"0D770B6203CF7096\"\n    }\n  },\n  \"TrackRequest\": {\n    \"Request\": {\n      \"RequestAction\": \"Track\",\n      \"RequestOption\": \"activity\"\n    },\n    \"InquiryNumber\": \"'".$traking_number."'\"\n  }\n}",
          CURLOPT_HTTPHEADER => array(
            "Cache-Control: no-cache",
            "Postman-Token: 09e89e26-6d05-4a76-bd63-952a45f9ce23"
          ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if (!$err) {
          $response_array = json_decode($response);
        
          $activities = $response_array->TrackResponse->Shipment->Package->Activity;
        
          foreach ($activities as $activity) {
        
          	#print("<pre>".print_r($activity,true)."</pre>");
          	$activity_country = $activity->ActivityLocation->Address->CountryCode;
          	$activity_city = $activity->ActivityLocation->Address->City;
          	$status = $activity->Status->Description;
          	$date = $activity->Date;
          	$time = $activity->Time;
            
            $datatrack[] = array(
                'activity_country'=>$activity_country,
                'activity_city'=>$activity_city,
                'status'=>$status,
                'date'=>date('Y-m-d',strtotime($date)),
                'time'=>date('H:i:s',strtotime($time)),
            );  	
                 
                         	
          }
          
          return $datatrack; 
          
        } else {
          
        	return  "cURL Error #:" . $err;
        
        }
	}
	
	//dipak added  end code 17/02/2020
	
}
