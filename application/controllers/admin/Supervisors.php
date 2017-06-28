<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	后台教授管理列表
*/
class Supervisors extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if( !$this->session->userdata('userid') ){
			redirect('admin/login');
		}
		$this->load->model( 'admin/supervisors_model', 'supervisors_model' );
	}

	public function index(){
		$role_id = $this->session->userdata('role_id');
		$this->load->model('admin/menu_rights_model');
		$res = $this->menu_rights_model->get_menu_rights($role_id);

		// 根据登录名获取登陆账号信息，显示到首页
		$userid = $this->session->userdata('userid');
		$this->load->model('admin/meetings_model');
		$meetingsCount = $this->meetings_model->get_unprocessing_meeting_count($userid);
		$data['meetingsCount'] = $meetingsCount;

		$data['title'] = 'Supervisor Management';
		$data['menues'] = $res;
		$this->load->view('admin/header',$data);
	    $this->load->view('admin/menu_top_left');
		$this->load->view('admin/supervisorsmanager');
		$this->load->view('admin/footer');
	}

	/**
	 * [selfinfo 等同于index方法，专为教授个人开设]
	 * @return   [type]                   [description]
	 */
	public function selfinfo(){
		$role_id = $this->session->userdata('role_id');
		$this->load->model('admin/menu_rights_model');
		$res = $this->menu_rights_model->get_menu_rights($role_id);

		// 根据登录名获取登陆账号信息，显示到首页
		$userid = $this->session->userdata('userid');
		$this->load->model('admin/meetings_model');
		$meetingsCount = $this->meetings_model->get_unprocessing_meeting_count($userid);
		$data['meetingsCount'] = $meetingsCount;

		$supervisor_id = $this->session->userdata('supervisor_id');
		$supervisorDetail = $this->supervisors_model->get_supervisor_detail_for_web( $supervisor_id );
		$data['title'] = 'Personal Information';
		$data['menues'] = $res;
		$data['supervisordetail'] = $supervisorDetail;
		$this->load->view('admin/header',$data);
	    $this->load->view('admin/menu_top_left');
		$this->load->view('admin/supervisorselfinfo');
		$this->load->view('admin/footer');
	}

	/**
	 * [supervisorsList 管理后台教授列表]
	 * @return   [type]                   [description]
	 */
	public function supervisorsList(){
		$status = $this->input->post('status');
		$supervisor_id = $this->session->userdata('supervisor_id');
		$supervisors = $this->supervisors_model->supervisors_list( $supervisor_id, $status );
		echo json_encode( array( "items" => $supervisors ),JSON_UNESCAPED_UNICODE );
	}

	public function deleteSupervisor(){
		$supervisor_id = $this->input->post('supervisor_id');
		$res = $this->supervisors_model->supervisors_delete( $supervisor_id );
		echo return_msg( '0', 'Delete Succeeded' );
	}

	public function recoverSupervisor(){
		$supervisor_id = $this->input->post('supervisor_id');
		$res = $this->supervisors_model->supervisors_recover( $supervisor_id );
		echo return_msg( '0', 'Delete Succeeded' );
	}

	/**
	 * [supervisorAdd 教授新增页面]
	 * @return [type] [description]
	 */
	public function supervisorAdd(){
		$role_id = $this->session->userdata('role_id');
		$this->load->model('admin/menu_rights_model');
		$res = $this->menu_rights_model->get_menu_rights($role_id);

		// 根据登录名获取登陆账号信息，显示到首页
		$userid = $this->session->userdata('userid');
		$this->load->model('admin/meetings_model');
		$meetingsCount = $this->meetings_model->get_unprocessing_meeting_count($userid);
		$data['meetingsCount'] = $meetingsCount;

		// 如果有id参数，说明是教授修改，需要将原有教授信息显示到页面上
		if( isset($_GET['id']) && !empty($_GET['id']) ){
			$supervisorDetail = $this->supervisors_model->supervisor_detail( $_GET['id'] );
		}else{
			$supervisorDetail = '';
		}

		$data['title'] = 'Add a New Supervisor';
		$data['menues'] = $res;
		$data['supervisorDetail'] = $supervisorDetail;
		$this->load->view('admin/header',$data);
	    $this->load->view('admin/menu_top_left');
		$this->load->view('admin/supervisoradd.php');
		$this->load->view('admin/footer');
	}

	/**
	 * [supervisorAddValidate 教授新增数据验证]
	 * @return [type] [description]
	 */
	public function supervisorAddValidate(){
		$this->load->helper(array('form', 'url'));
		$supervisor_hidden_id = $this->input->post( 'id' );
		$this->form_validation->set_rules('name','Name','required');
		if( empty( $supervisor_hidden_id ) ){
			$this->form_validation->set_rules('account','Account','required|is_unique[operator.account]');
		}else{
			$this->form_validation->set_rules('account','Account','required');
		}
		if( empty( $supervisor_hidden_id ) ){
			$this->form_validation->set_rules('password','Password','required');
			$this->form_validation->set_rules('password_confirm','Password Confirm','required|matches[password]');
		}
		if( empty( $supervisor_hidden_id ) ){
			$this->form_validation->set_rules('email','Email','required|valid_email|is_unique[supervisors.email]');
		}else{
			$this->form_validation->set_rules('email','Email','required|valid_email');
		}
		$this->form_validation->set_rules('room','Office','required');
		$this->form_validation->set_rules('appointment_preference','appointment_preference','required');

		if( $this->form_validation->run() ){
			$supervisor = $this->input->post();
			$operator['account'] = $supervisor['account'];
			$operator['nickname'] = $supervisor['name'];
			$operator['role_id'] = '2';
			unset( $supervisor['account'] );
			unset( $supervisor['password'] );
			unset( $supervisor['password_confirm'] );
			unset( $supervisor['nickname'] );
			$config['upload_path']      = './uploads/supervisors';
			$config['file_name']      = date("Y",time()) . '-' . date("m",time()) . '-' . date("d",time()).'-' . time();
	        $config['allowed_types']    = 'gif|jpg|png';
	        $config['max_size']     = 10000;
	        $config['max_width']        = 1024;
	        $config['max_height']       = 1024;
	        $this->load->library('upload', $config);

	        if ( ! $this->upload->do_upload('headimgurl')){
	        	unset( $supervisor['headimgurl'] );
	        }else{
	        	$imgInfo = $this->upload->data();
	            $supervisor['headimgurl'] = date("Y",time()) . '-' . date("m",time()) . '-' . date("d",time()).'-' . time() . $imgInfo['file_ext'];
	        }
			if( isset( $supervisor_hidden_id ) && !empty( $supervisor_hidden_id ) ){
				$operator['supervisor_id'] = $supervisor_hidden_id;
				$bool = $this->supervisors_model->supervisors_and_operator_modify( $supervisor, $operator, $supervisor_hidden_id );
			}else{
				$operator['password'] = sha1( $supervisor['password'] );
				$bool = $this->supervisors_model->supervisors_and_operator_add( $supervisor, $operator );
			}
			if( $bool ){
				redirect( 'admin/supervisors' );
			}
		}else{
			$role_id = $this->session->userdata('role_id');
			$this->load->model('admin/menu_rights_model');
			$res = $this->menu_rights_model->get_menu_rights($role_id);

			// 根据登录名获取登陆账号信息，显示到首页
			$userid = $this->session->userdata('userid');
			$this->load->model('admin/meetings_model');
			$meetingsCount = $this->meetings_model->get_unprocessing_meeting_count($userid);
			$data['meetingsCount'] = $meetingsCount;

			// 如果有id参数，说明是教授修改，需要将原有教授信息显示到页面上
			if( isset($_GET['id']) && !empty($_GET['id']) ){
				$supervisorDetail = $this->supervisors_model->supervisor_detail( $_GET['id'] );
			}else{
				$supervisorDetail = '';
			}
			$data['title'] = 'Edit the Supervisor';
			$data['menues'] = $res;
			$data['supervisorDetail'] = $supervisorDetail;
			$data['supervisor_hidden_id'] = $supervisor_hidden_id;
			$this->load->view('admin/header',$data);
		    $this->load->view('admin/menu_top_left');
			$this->load->view('admin/supervisoradd.php');
			$this->load->view('admin/footer');
		}
	}
}