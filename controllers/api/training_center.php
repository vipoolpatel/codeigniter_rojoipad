<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Training_center extends CI_Controller {

    function __construct() {
        parent::__construct();
		
        $this->load->model('training_center_model', '', TRUE);

    }

    public function get_category() {

        $result = array();

        $getRecord = $this->db->select('rojoipad_main_category.*');
        $getRecord = $this->db->from('rojoipad_main_category');
        $getRecord = $this->db->where('rojoipad_main_category.status','Online');
        $getRecord = $this->db->where('rojoipad_main_category.is_delete', 0); 
        // Search Box start
        if(!empty($this->input->post('keyword')))
        {
            $keyword = $this->input->post('keyword');
            $getRecord = $this->db->where("(rojoipad_main_category.main_category_en LIKE '%".$keyword."%' OR rojoipad_main_category.main_category_ch LIKE '%".$keyword."%' OR rojoipad_main_category.id LIKE '%".$keyword."%' OR rojoipad_main_category.status LIKE '%".$keyword."%' OR rojoipad_main_category.created_date LIKE '%".$keyword."%')", NULL, FALSE);
        }

         $getRecord = $this->db->get()->result();

        foreach ($getRecord as $key => $value) {

            $data = array();
            $data['category_id']               = $value->id;
            $data['main_category_en'] = $value->main_category_en;
            $data['main_category_ch'] = $value->main_category_ch;
            if(!empty($value->menu_icon))
            {
                $data['menu_icon'] = str_replace('rojoipad/', '', base_url()).'rojoipad/upload/'.$value->menu_icon;    
            }
            else
            {
                $data['menu_icon'] = '';    
            }

            $data['created_date'] = $value->created_date;
            $result[] = $data;

        }

        $json = array('status' => '1', 'statusmsg' => 'success', 'data' => $result);
        echo json_encode($json);
    }


    public function get_sub_category()
    {
        $result = array();
        $getRecord = $this->db->select('rojoipad_sub_category.*');
        $getRecord = $this->db->from('rojoipad_sub_category');
        $getRecord = $this->db->where('rojoipad_sub_category.status','Online');
        $getRecord = $this->db->where('rojoipad_sub_category.is_delete', 0);
        // Search Box start
        if(!empty($this->input->post('keyword')))
        {
            $keyword = $this->input->post('keyword');
            $getRecord = $this->db->where("(rojoipad_sub_category.sub_category_en LIKE '%".$keyword."%' OR rojoipad_sub_category.sub_category_ch LIKE '%".$keyword."%' OR rojoipad_sub_category.id LIKE '%".$keyword."%' OR rojoipad_sub_category.status LIKE '%".$keyword."%' OR rojoipad_sub_category.created_date LIKE '%".$keyword."%')", NULL, FALSE);
        }

        // Search Box end
        if(!empty($this->input->post('category_id')))
        {
            $getRecord = $this->db->where('rojoipad_sub_category.main_category_id', $this->input->post('category_id'));    
        }

        $getRecord = $this->db->get()->result();



        foreach ($getRecord as $key => $value) {
            $data = array();
            $data['sub_category_id'] = $value->id;
            $data['category_id']     = $value->main_category_id;
            $data['sub_category_en'] = $value->sub_category_en;
            $data['sub_category_ch'] = $value->sub_category_ch;
            $data['created_date']    = $value->created_date;
            $result[] = $data;
        }

        $json = array('status' => '1', 'statusmsg' => 'success', 'data' => $result);
    

        echo json_encode($json);

    }

    public function get_sub_category_content()
    {
            $result = array();
            $getRecord = $this->db->select('rojoipad_sub_category_content.*, GROUP_CONCAT(rojoipad_sub_category_content_tag.tag_name) as full_tag_name');
            $getRecord = $this->db->from('rojoipad_sub_category_content');
            $getRecord = $this->db->join('rojoipad_sub_category_content_tag', 'rojoipad_sub_category_content_tag.sub_category_content_id = rojoipad_sub_category_content.id', 'LEFT');
            $getRecord = $this->db->where('rojoipad_sub_category_content.is_delete', 0);

            // search box start
            if(!empty($this->input->post('keyword')))
            {
                $keyword = $this->input->post('keyword');
                $getRecord = $this->db->where("(rojoipad_sub_category_content.add_link LIKE '%".$keyword."%' OR rojoipad_sub_category_content.description LIKE '%".$keyword."%' OR rojoipad_sub_category_content.content_name LIKE '%".$keyword."%' OR rojoipad_sub_category_content.id LIKE '%".$keyword."%' OR rojoipad_sub_category_content.status LIKE '%".$keyword."%' OR rojoipad_sub_category_content.created_date LIKE '%".$keyword."%' OR rojoipad_sub_category_content_tag.tag_name LIKE '%".$keyword."%') ", NULL, FALSE);
            }
            // search box end

            $getRecord = $this->db->where('rojoipad_sub_category_content.status','Online');
            if(!empty($this->input->post('sub_category_id')))
            {
                $getRecord = $this->db->where('rojoipad_sub_category_content.sub_category_id', $this->input->post('sub_category_id'));    
            }
            $getRecord = $this->db->group_by('rojoipad_sub_category_content.id');
            $getRecord = $this->db->get()->result();


            foreach ($getRecord as $value) {

                $data = array();
                $data['sub_category_content_id'] = $value->id;
                $data['sub_category_id']    = $value->sub_category_id;
                $data['name']           = !empty($value->content_name) ? $value->content_name : '';
                $data['add_link']           = !empty($value->add_link) ? $value->add_link : '';
                $data['description']        = !empty($value->description) ? $value->description : '';
                $data['created_date']       = $value->created_date;

                $gettag = $this->db->where('sub_category_content_id',$value->id);
                $gettag = $this->db->get('rojoipad_sub_category_content_tag')->result();
                $tag = array();
                foreach ($gettag as $value_t) {
                    $data_t = array();
                    $data_t['id'] = $value_t->id;
                    $data_t['tag_name'] = $value_t->tag_name;
                    $tag[] = $data_t;
                }
                $data['tag'] = $tag;

                $result[] = $data;
            }

            $json = array('status' => '1', 'statusmsg' => 'success', 'data' => $result);
       

        echo json_encode($json);
    }
	
}


