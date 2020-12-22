<?php
if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );
class Training_center_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}

    public function get_category()
    {
        $getRecord = $this->db->select('rojoipad_main_category.*');
        $getRecord = $this->db->from('rojoipad_main_category');
        $getRecord = $this->db->where('rojoipad_main_category.is_delete', 0); 
        // Search Box start
        if(!empty($this->input->get('keyword')))
        {
            $keyword = $this->input->get('keyword');
            $getRecord = $this->db->where("(rojoipad_main_category.main_category_en LIKE '%".$keyword."%' OR rojoipad_main_category.main_category_ch LIKE '%".$keyword."%' OR rojoipad_main_category.id LIKE '%".$keyword."%' OR rojoipad_main_category.status LIKE '%".$keyword."%' OR rojoipad_main_category.created_date LIKE '%".$keyword."%')", NULL, FALSE);
        }
        // Search Box end
        $getRecord = $this->db->get()->result();

        // print_r($this->db->last_query());
        // die;

        return $getRecord;
    }

    public function get_single_category($id)
	{
	    $getRecord = $this->db->select('rojoipad_main_category.*');
        $getRecord = $this->db->from('rojoipad_main_category');
        $getRecord = $this->db->where('rojoipad_main_category.id', $id); 
    	$getRecord = $this->db->get()->row();
    	return $getRecord;
	}

    public function get_sub_category($id)
    {
        $getRecord = $this->db->select('rojoipad_sub_category.*');
        $getRecord = $this->db->from('rojoipad_sub_category');
        $getRecord = $this->db->where('rojoipad_sub_category.is_delete', 0);
        // Search Box start
        if(!empty($this->input->get('keyword')))
        {
            $keyword = $this->input->get('keyword');
            $getRecord = $this->db->where("(rojoipad_sub_category.sub_category_en LIKE '%".$keyword."%' OR rojoipad_sub_category.sub_category_ch LIKE '%".$keyword."%' OR rojoipad_sub_category.id LIKE '%".$keyword."%' OR rojoipad_sub_category.status LIKE '%".$keyword."%' OR rojoipad_sub_category.created_date LIKE '%".$keyword."%')", NULL, FALSE);
        }
        // Search Box end
        $getRecord = $this->db->where('rojoipad_sub_category.main_category_id', $id);
        $getRecord = $this->db->get()->result();
         return $getRecord;
    }

    public function get_single_sub_category($id)
    {
        $getRecord = $this->db->select('rojoipad_sub_category.*');
        $getRecord = $this->db->from('rojoipad_sub_category');
        $getRecord = $this->db->where('rojoipad_sub_category.id', $id);
        $getRecord = $this->db->get()->row();
        return $getRecord;
    }

    public function get_content_category($sub_category_id)
    {
        $getRecord = $this->db->select('rojoipad_sub_category_content.*, GROUP_CONCAT(rojoipad_sub_category_content_tag.tag_name) as full_tag_name');
        $getRecord = $this->db->from('rojoipad_sub_category_content');
        $getRecord = $this->db->join('rojoipad_sub_category_content_tag', 'rojoipad_sub_category_content_tag.sub_category_content_id = rojoipad_sub_category_content.id', 'LEFT');
        $getRecord = $this->db->where('rojoipad_sub_category_content.is_delete', 0);

        // search box start
        if(!empty($this->input->get('keyword')))
        {
            $keyword = $this->input->get('keyword');
            $getRecord = $this->db->where("(rojoipad_sub_category_content.add_link LIKE '%".$keyword."%' OR rojoipad_sub_category_content.description LIKE '%".$keyword."%' OR rojoipad_sub_category_content.content_name LIKE '%".$keyword."%' OR rojoipad_sub_category_content.id LIKE '%".$keyword."%' OR rojoipad_sub_category_content.status LIKE '%".$keyword."%' OR rojoipad_sub_category_content.created_date LIKE '%".$keyword."%' OR rojoipad_sub_category_content_tag.tag_name LIKE '%".$keyword."%') ", NULL, FALSE);
        }
        // search box end


        $getRecord = $this->db->where('rojoipad_sub_category_content.sub_category_id', $sub_category_id);
        $getRecord = $this->db->group_by('rojoipad_sub_category_content.id');
        $getRecord = $this->db->get()->result();
        return $getRecord;
    }

    public function get_single_sub_category_content($id)
    {
        $getRecord = $this->db->select('rojoipad_sub_category_content.*');
        $getRecord = $this->db->from('rojoipad_sub_category_content');
        $getRecord = $this->db->where('rojoipad_sub_category_content.id', $id);
        $getRecord = $this->db->get()->row();
        return $getRecord;
    }

    public function get_sub_category_content($sub_category_content_id)
    {
        $getRecord = $this->db->select('rojoipad_sub_category_content_tag.*');
        $getRecord = $this->db->from('rojoipad_sub_category_content_tag');
      
        $getRecord = $this->db->where('rojoipad_sub_category_content_tag.sub_category_content_id', $sub_category_content_id);
        $getRecord = $this->db->get()->result();
        return $getRecord;
    }


	
}