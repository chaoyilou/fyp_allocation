<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
		function __construct(){
            parent::__construct();
            if( !$this->session->userdata('userid') ){
            	redirect('admin/login');
            }
        }

        public function index(){
            // 根据角色id获取左边菜单内容，角色id根据登陆的账户获得
        	$role_id = $this->session->userdata('role_id');
        	$this->load->model('admin/menu_rights_model');
            $res = $this->menu_rights_model->get_menu_rights($role_id);

            // 根据登录名获取登陆账号信息，显示到首页
            $userid = $this->session->userdata('userid');
            $this->load->model('admin/meetings_model');
            $meetingsCount = $this->meetings_model->get_unprocessing_meeting_count($userid);
            $data['meetingsCount'] = $meetingsCount;

            $this->load->model('admin/login_model', 'login_model');
            $data['loginInfo'] = $this->login_model->get_login_info( $userid );

        	$data['title'] = 'FYP Information Management';
            $data['menues'] = $res;
        	$this->load->view('admin/header',$data);
            $this->load->view('admin/menu_top_left');
        	$this->load->view('admin/welcome');
        	$this->load->view('admin/footer');
        }

        public function ajax_content(){
            $this->load->model('admin_content_model');
            // print_r($this->admin_content_model->get_van_order());die;
            echo $this->admin_content_model->get_van_order();
        }
 
}
