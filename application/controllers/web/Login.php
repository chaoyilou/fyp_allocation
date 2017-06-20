<?php
/**
* student login
*/

defined('BASEPATH') OR exit('No direct script access allowed');    //防止被攻击，每次都要写

class Login extends CI_Controller
{

	function __construct()   //构造方法
	{
		parent::__construct();
	}

	public function index(){
		$this->session->unset_userdata( 'useridweb' );       //清除原来的login记录（看不见的）
        $data['title'] = 'Student Login';

        $this->load->view('web/header',$data);
        $this->load->view('web/login');
        $this->load->view('web/footer');
	}

	public function validate(){
		// 直接访问validate时，清除登录session
		unset($_SESSION['useridweb']);

		// CI表单验证； 用 set_rules()函数 设置验证规则
		// set_rules()函数 用三个参数作为输入： 1.表单域的名字 2.表单域的人性化名字（插入到错误信息中） 3.为此表单域设置的验证规则
		$this->form_validation->set_rules('username','Username','required');
		$this->form_validation->set_rules('password','Password','required');

		if( $this->form_validation->run() !== false ){

			// 表单验证通过，进入数据库验证
			$this->load->model('web/login_model', 'login_model');
            $res = $this->login_model->verify_users(
                $this->input->post('username'),
                $this->input->post('password')
            );

            if($res !== false){
            	// 数据库验证成功：设置session，跳转到首页
                $data = array('usernameweb' => $this->input->post('username'), 'role_id_web'=>$res['role_id'], 'useridweb' => $res['id']);
                $this->session->set_userdata($data);
                redirect('web/home');
            }else{
            	$data['title'] = 'Students Login';
            	$data['msg'] = 'Username or Password Incorrect. Please try again.';
				$this->load->view('web/header',$data);
				$this->load->view('web/login');
				$this->load->view('web/footer');
            }

		}else{
			$data['title'] = 'Students Login';
			$this->load->view('web/header',$data);
			$this->load->view('web/login');
			$this->load->view('web/footer');
		}
	}
}