<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller{
        
        function __construct(){
		parent::__construct();
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
        
	//cms列表
	function language(){
                
                //echo '<pre>';
                //print_r($this->session->userdata);
                //exit;
                $backurl = base_url().'index.php/admins/settings/language';
                $user_id = $this->session->userdata('user_id');
                $data['userinfo']=$this->UserModel->getuserinfo($user_id);
                $data['backurl'] = $backurl;
		$this->load->view('admin/language',$data);
	}
        
        function currency(){
                
                //echo '<pre>';
                //print_r($this->session->userdata);
                //exit;
                $backurl = base_url().'index.php/admins/settings/currency';
                $user_id = $this->session->userdata('user_id');
                $data['userinfo']=$this->UserModel->getuserinfo($user_id);
                $data['backurl'] = $backurl;
		$this->load->view('admin/currency',$data);
	}
        
        function logo(){
                
                $backurl = base_url().'index.php/admins/settings/logo';
                $user_id = $this->session->userdata('user_id');
                $data['userinfo']=$this->UserModel->getuserinfo($user_id);
                
                /*echo '<pre>';
                print_r($data['userinfo']);
                exit;
                */
                $data['backurl'] = $backurl;
		$this->load->view('admin/logo',$data);
	}
        
        function measurement(){
                
                //echo '<pre>';
                //print_r($this->session->userdata);
                //exit;
                $backurl = base_url().'index.php/admins/settings/measurement';
                $user_id = $this->session->userdata('user_id');
                $data['userinfo']=$this->UserModel->getuserinfo($user_id);
                $data['backurl'] = $backurl;
		$this->load->view('admin/measurement',$data);
	}
        
        function design(){
                
                //echo '<pre>';
                //print_r($this->session->userdata);
                //exit;
                $backurl = base_url().'index.php/admins/settings/design';
                $user_id = $this->session->userdata('user_id');
                
                $count = $this->UserModel->get_user_details($user_id);
               
                $data['userinfo']=$this->UserModel->getuserinfo($user_id);
                $data['count'] = $count;
                $data['user_id'] = $user_id;
                $data['backurl'] = $backurl;
		$this->load->view('admin/design',$data);
	}
	
	//Edit Language
        function edit_user_lang($uid){
            //Edit by user by sonali 17th oct 2019
            $user_language = $this->input->post('user_language');
            $arr['user_language'] = $user_language;
            $this->SettingsModel->edit_user_lang($uid, $arr);
        }
	
	//Edit Language
        function edit_user_currency($uid){
            //Edit by user by sonali 17th oct 2019
            $user_currency = $this->input->post('user_currency');
            $arr['user_currency'] = $user_currency;
            $this->SettingsModel->edit_user_lang($uid, $arr);
        }
        
        //Edit Language
        function edit_user_measurement($uid){
            //Edit by user by sonali 17th oct 2019
            $user_measurement = $this->input->post('user_measurement');
            $arr['user_measurement'] = $user_measurement;
            $this->SettingsModel->edit_user_measurement($uid, $arr);
        }
        
        //Edit Logo
        function edit_user_logo($uid){
            //Edit by user by sonali 17th oct 2019
            
            /*echo '<pre>';
            print_r($this->input->post());
            exit;
            */
            $user_brand_logo = $this->input->post('user_brand_logo');
            $user_brandname = $this->input->post('user_brandname');
            $user_brand_initials = $this->input->post('user_brand_initials');
            
            if($user_brand_logo != ''){
                $arr['user_brand_logo'] = $user_brand_logo;
            }
            
            $arr['user_brandname'] = $user_brandname;
            $arr['user_brand_initials'] = $user_brand_initials;
            $this->SettingsModel->edit_user_logo($uid, $arr);
        }
	
}