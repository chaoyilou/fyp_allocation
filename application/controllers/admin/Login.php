<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*
*/
class Login extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	public function index(){
		$this->session->unset_userdata( 'userid' );
		//if ($this->session->userdata('userid')){
          //  redirect('admin/welcome');
        //}
        $data['title'] = 'Admin/Supervisor Login';

        $this->load->view('admin/header',$data);
        $this->load->view('admin/login');
        $this->load->view('admin/footer');
	}

	public function validate(){
		// 直接访问validate时，清除登录session
		unset($_SESSION['userid']);

		$this->form_validation->set_rules('username','USERNAME','required');
		$this->form_validation->set_rules('password','PASSWORD','required');

		if( $this->form_validation->run() ){

			// 表单验证通过，进入数据库验证
			$this->load->model('admin/login_model', 'login_model');
            $res = $this->login_model->verify_users(
                $this->input->post('username'),
                $this->input->post('password')
            );

            if($res !== false){
            	// 数据库验证成功：设置session，跳转到首页
                $data = array('username' => $this->input->post('username'), 'role_id'=>$res['role_id'], 'userid' => $res['id'], 'supervisor_id' => $res['supervisor_id']);
                $this->session->set_userdata($data);
                redirect('admin/welcome');
            }else{
            	$data['title'] = 'Admin/Supervisor Login';
            	$data['msg'] = 'Username or Password incorrect';
				$this->load->view('admin/header',$data);
				$this->load->view('admin/login');
				$this->load->view('admin/footer');
            }

		}else{
			$data['title'] = 'Admin/Supervisor Login';
			$this->load->view('admin/header',$data);
			$this->load->view('admin/login');
			$this->load->view('admin/footer');
		}
	}
}