 
 <?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Training_center extends CI_Controller {

    
    function __construct() {

        parent::__construct();

        $this->load->model('training_center_model', '', TRUE);

        $ipadapplogin = $this->input->get('ipadapplogin');
        if ($ipadapplogin == 1) {
            $userinfo = array('admin_id' => 1, 'admin_username' => 'admin', 'device' => 'ipad');
            $userjson = serialize($userinfo);
            set_cookie('admin', $userjson, time() + 3600 * 24 * 30); //设置登录的Cookie
        }
        if (isset($_COOKIE['admin'])) {
            $admin = unserialize($_COOKIE['admin']);
            $this->session->set_userdata('isadmin', '1');
            if (isset($admin ['device'])) {
                $this->admin_id = $admin ['admin_id'];
                $this->admin_username = $admin ['admin_username'];
                $this->device = $admin ['device'];
            } else {
                redirect(base_url() . 'index.php/admin');
            }
        } 
        else 
        {
            redirect(base_url() . 'index.php/admin');
        }
        $lang = $this->session->userdata('lang');
        if ($lang == 'ch') {
            $this->session->set_userdata('lang', 'ch');
            $this->langtype = '_ch';
            $this->lang->load('gksel', 'chinese');
        } else {
            $this->session->set_userdata('lang', 'en');
            $this->langtype = '_en';
            $this->lang->load('gksel', 'english');
        }
    }

    public function index()
    {
        $data['getRecord'] =  $this->training_center_model->get_category();

        $this->load->view('admin/training_center/category_list', $data);
    }



    public function category_add()
    {

    	if (!empty($_POST)) {

    		if (!empty($_FILES["menu_icon"]["name"])) {
    			$menu_icon = $_FILES["menu_icon"]["name"];
    			$array_name = explode(".", $menu_icon);
    			$ext = end($array_name);

    			$menu_icon = date('ymdhis') . '.' . $ext;
    			$folder = "upload/";
    			         move_uploaded_file($_FILES["menu_icon"]["tmp_name"], $folder . $menu_icon);
    			} else {
    				$menu_icon = '';
    			}
    				$data = array(
    					'main_category_en' => !empty($this->input->post('main_category_en')) ? $this->input->post('main_category_en') : '',
    					'main_category_ch' => !empty($this->input->post('main_category_ch')) ? $this->input->post('main_category_ch') : '',
    					'status'           => !empty($this->input->post('status')) ? $this->input->post('status') : '',
    					'menu_icon'        => $menu_icon,
    					'created_date'     => date('Y-m-d H:i:s'),
    				);

    				$this->db->insert('rojoipad_main_category', $data);
    		        redirect(base_url() . 'index.php/admins/training_center/index');
    		}

    	$this->load->view('admin/training_center/category_add');
    }

    public function category_edit($id)
    {

        if (!empty($_POST)) {

            if (!empty($_FILES["menu_icon"]["name"])) {
                    if(!empty($this->input->post('old_menu_icon')) && file_exists('upload/'.$this->input->post('old_menu_icon')))
                    {
                        unlink("upload/".$this->input->post('old_menu_icon'));
                    }
                    

                    $menu_icon = $_FILES["menu_icon"]["name"];
                    $array_name = explode(".", $menu_icon);
                    $ext = end($array_name);

                    $menu_icon = date('ymdhis') . '.' . $ext;
                    $folder = "upload/";
                    move_uploaded_file($_FILES["menu_icon"]["tmp_name"], $folder . $menu_icon);
            } 
            else {
                $menu_icon = $this->input->post('old_menu_icon');
            }

                  
            
             $data_array = array(
                'main_category_en' => !empty($this->input->post('main_category_en')) ? $this->input->post('main_category_en') : '',
                'main_category_ch' => !empty($this->input->post('main_category_ch')) ? $this->input->post('main_category_ch') : '',
                'status'           => !empty($this->input->post('status')) ? $this->input->post('status') : '',
                'menu_icon'        => $menu_icon,
                'created_date'     => date('Y-m-d H:i:s'),
            );

            $this->db->where('id', $id);
            $this->db->update('rojoipad_main_category', $data_array);
            redirect(base_url() . 'index.php/admins/training_center/index');
         }

        $data['getRecord'] =  $this->training_center_model->get_single_category($id);

        $this->load->view('admin/training_center/category_edit', $data);
    }

    public function category_delete($id)
    {
        $this->db->where('id', $id);
        $this->db->set('is_delete', 1);
        $this->db->update('rojoipad_main_category');
        redirect(base_url() . 'index.php/admins/training_center/index');
    }


    // sub category work Start

    public function sub_category($id)
    {
        $data['category'] =  $this->training_center_model->get_single_category($id);
        $data['getRecord'] =  $this->training_center_model->get_sub_category($id);
        $data['main_category_id'] = $id;
        $this->load->view('admin/training_center/sub_category_list', $data);
    }

    public function sub_category_add($id)
    {
        if (!empty($_POST)) {
            $data = array( 
                'main_category_id' => $id,
                'sub_category_en' => !empty($this->input->post('sub_category_en')) ? $this->input->post('sub_category_en') : '',
                'sub_category_ch' => !empty($this->input->post('sub_category_ch')) ? $this->input->post('sub_category_ch') : '',
                'status'           => !empty($this->input->post('status')) ? $this->input->post('status') : '',
                'created_date'     => date('Y-m-d H:i:s'),
            );

            $this->db->insert('rojoipad_sub_category', $data);
            redirect(base_url() . 'index.php/admins/training_center/sub_category/'.$id);
        }


        $data['category_id'] = $id;
        $this->load->view('admin/training_center/sub_category_add',$data);
    }

    public function sub_category_edit($main_category_id, $id)
    {

        if (!empty($_POST)){
            $array = array(
                'sub_category_en'     => !empty($this->input->post('sub_category_en')) ? $this->input->post('sub_category_en') : '',
                'sub_category_ch'     => !empty($this->input->post('sub_category_ch')) ? $this->input->post('sub_category_ch') : '0',
                'status'     => !empty($this->input->post('status')) ? $this->input->post('status') : '',
            );
            $this->db->where('id', $id);
            $this->db->update('rojoipad_sub_category', $array);

            redirect(base_url() . 'index.php/admins/training_center/sub_category/'.$main_category_id);
        }

        $data['getRecord'] =  $this->training_center_model->get_single_sub_category($id);

        $this->load->view('admin/training_center/sub_category_edit', $data);
    }

    public function sub_category_delete($main_category_id, $id)
    {
        $this->db->where('id', $id);
        $this->db->set('is_delete', 1);
        $this->db->update('rojoipad_sub_category');
        redirect(base_url() . 'index.php/admins/training_center/sub_category/'.$main_category_id);
    }

    // sub category work end

    // content category work Start

    public function content_category_list($sub_category_id)
    {
        $sub_category =  $this->training_center_model->get_single_sub_category($sub_category_id);
        $data['sub_category'] = $sub_category;
        $data['category'] =  $this->training_center_model->get_single_category($sub_category->main_category_id);

        $data['getRecord'] = $this->training_center_model->get_content_category($sub_category_id);
        $data['sub_category_id'] = $sub_category_id;


// $query = $this->db->select('GROUP_CONCAT(rojoipad_sub_category_content_tag.tag_name) as full_tag_name, rojoipad_sub_category_content.* '); 
// $query = $this->db->from('rojoipad_sub_category_content');
// $query = $this->db->join('rojoipad_sub_category_content_tag', 'rojoipad_sub_category_content_tag.sub_category_content_id = rojoipad_sub_category_content.id', 'LEFT');
// $query =     $this->db->group_by('rojoipad_sub_category_content.id');

// $query = $this->db->get()->result(); 

        
        $this->load->view('admin/training_center/content_category_list', $data);
    }

    public function content_category_add($sub_category_id)
    {
        // print_r($sub_category_id);
        // die;

        if (!empty($_POST)) {
            $data = array( 
                'sub_category_id' => $sub_category_id,
                'content_name' => !empty($this->input->post('content_name')) ? $this->input->post('content_name') : '',
                'add_link' => !empty($this->input->post('add_link')) ? $this->input->post('add_link') : '',
                'description' => !empty($this->input->post('description')) ? $this->input->post('description') : '',
                'status'           => !empty($this->input->post('status')) ? $this->input->post('status') : '',
                'created_date'     => date('Y-m-d H:i:s'),
            );

            $this->db->insert('rojoipad_sub_category_content', $data);

            $sub_category_content_id = $this->db->insert_id();

            if ($this->input->post('tag_name')) {
                foreach ($this->input->post('tag_name') as $tag_name) {
                  if(!empty($tag_name)){
                    $array_tag = array(
                        'sub_category_content_id' => $sub_category_content_id,
                        'tag_name' => $tag_name,
                        'created_date'     => date('Y-m-d H:i:s'),
                    );
                    $this->db->insert('rojoipad_sub_category_content_tag', $array_tag);
                }
                }
            }

            redirect(base_url() . 'index.php/admins/training_center/content_category_list/'.$sub_category_id);
        }

        $data['sub_category_id'] = $sub_category_id;
        //$data['path'] = $path;
        $this->load->view('admin/training_center/content_category_add', $data);   
    }

    public function content_category_edit($sub_category_id, $id)
    {

        if (!empty($_POST)) {
               $array_data = array( 
                'content_name' => !empty($this->input->post('content_name')) ? $this->input->post('content_name') : '',
                'add_link' => !empty($this->input->post('add_link')) ? $this->input->post('add_link') : '',
                'description' => !empty($this->input->post('description')) ? $this->input->post('description') : '',
                'status'           => !empty($this->input->post('status')) ? $this->input->post('status') : '',
            );


            $this->db->where('id', $id);
            $this->db->update('rojoipad_sub_category_content', $array_data);


           
            $delete = $this->db->where('sub_category_content_id', $id);
            $delete = $this->db->delete('rojoipad_sub_category_content_tag');
                // print_r($delete);
                // die();
            if ($this->input->post('tag_name')) {
                //print_r($this->input->post('tag_name'));
                // die();
                foreach ($this->input->post('tag_name') as $tag_name) {
                    if(!empty($tag_name)){
                    $array_tag = array(
                        'sub_category_content_id' => $id,
                        'tag_name' => $tag_name,
                         'created_date'     => date('Y-m-d H:i:s'),
                    );
                   
                    $this->db->insert('rojoipad_sub_category_content_tag', $array_tag);
                     }
                     //$this->db->update('rojoipad_sub_category_content_tag', $array_tag);
                }
            }
            redirect(base_url() . 'index.php/admins/training_center/content_category_list/'.$sub_category_id);
        }



        $data['getRecord'] =  $this->training_center_model->get_single_sub_category_content($id);

        $getTag = $this->db->where('sub_category_content_id', $id);
        $getTag = $this->db->get('rojoipad_sub_category_content_tag')->result();
        $data['getTag'] = $getTag;

        $data['sub_category_id'] = $sub_category_id;

        // print_r($sub_category_id);
        // die();
        $this->load->view('admin/training_center/content_category_edit', $data);      
    }

    public function content_category_delete($sub_category_id, $id)
    {
        $this->db->where('id', $id);
        $this->db->set('is_delete', 1);
        $this->db->update('rojoipad_sub_category_content');
        redirect(base_url() . 'index.php/admins/training_center/content_category_list/'.$sub_category_id);
    }

    public function content_category_view($sub_category_id, $sub_category_content_id)
    {
        $data['getRecord'] =  $this->training_center_model->get_sub_category_content($sub_category_content_id);

        $data['sub_category_id'] = $sub_category_id;
        $this->load->view('admin/training_center/content_category_view', $data);      
    }

    public function content_category_tag_delete($id, $sub_category_id, $sub_category_content_id)
    {
        $this->db->where('id', $id);
        $this->db->delete('rojoipad_sub_category_content_tag');
        redirect(base_url() . 'index.php/admins/training_center/content_category_edit/'.$sub_category_id. "/".$sub_category_content_id);
    }

    // content category work End

    public function preview_add_link()
    {
        if(!empty($_POST))
        {
            $str = $this->input->post('add_link');
            // print_r($str);
            $row = explode("/", $str);
            $training_arrray = array_filter($row);
            $path = @end($training_arrray);

            $json['success'] = '<img src="https://img.youtube.com/vi/'. $path .'/mqdefault.jpg" alt="icon" width="100px" height="100px">';
            echo json_encode($json);
        }
    }

    public function preview_update_link()
    {
        if(!empty($_POST))
        {
            $str = $this->input->post('add_link');
            // print_r($str);
            $row = explode("/", $str);
            $training_arrray = array_filter($row);
            $path = @end($training_arrray);

            $json['success'] = '<img src="https://img.youtube.com/vi/'. $path .'/mqdefault.jpg" alt="icon" width="100px" height="100px">';
            echo json_encode($json);
        }
    }
    


}