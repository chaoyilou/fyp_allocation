<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	后台学生管理列表
*/
class Students extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if( !$this->session->userdata('userid') ){
			redirect('admin/login');
		}
		$this->load->model( 'admin/students_model', 'students_model' );
	}

	/**
	 * [index 学生管理展示页]
	 * @return   [type]                   [description]
	 */
	public function index(){
		$role_id = $this->session->userdata('role_id');
		$this->load->model('admin/menu_rights_model');
		$res = $this->menu_rights_model->get_menu_rights($role_id);

		// 根据登录名获取登陆账号信息，显示到首页
		$userid = $this->session->userdata('userid');
		$this->load->model('admin/meetings_model');
		$meetingsCount = $this->meetings_model->get_unprocessing_meeting_count($userid);
		$data['meetingsCount'] = $meetingsCount;

		$data['title'] = 'Student Management';
		$data['menues'] = $res;
		$this->load->view('admin/header',$data);
	    $this->load->view('admin/menu_top_left');
		$this->load->view('admin/studentsmanager');
		$this->load->view('admin/footer');
	}

	/**
	 * [studentsList 所有有效学生列表]
	 * @return   [type]                   [description]
	 */
	public function studentsList(){
		$status = $this->input->post('status');
		$students = $this->students_model->students_list( $status );
		echo json_encode( array( "items" => $students ),JSON_UNESCAPED_UNICODE );
	}

	/**
	 * [deleteStudent 删除一个学生]
	 * @return   [type]                   [description]
	 */
	public function deleteStudent(){
		$student_id = $this->input->post('student_id');
		$res = $this->students_model->students_delete( $student_id );
		echo return_msg( '0', '删除成功' );
	}

	/**
	 * [recoverStudent 恢复一个学生]
	 * @return   [type]                   [description]
	 */
	public function recoverStudent(){
		$student_id = $this->input->post('student_id');
		$res = $this->students_model->students_recover( $student_id );
		echo return_msg( '0', '删除成功' );
	}

	/**
	 * [projectAdd 学生新增页面]
	 * @return [type] [description]
	 */
	public function studentAdd(){
		$role_id = $this->session->userdata('role_id');
		$this->load->model('admin/menu_rights_model');
		$res = $this->menu_rights_model->get_menu_rights($role_id);

		// 根据登录名获取登陆账号信息，显示到首页
		$userid = $this->session->userdata('userid');
		$this->load->model('admin/meetings_model');
		$meetingsCount = $this->meetings_model->get_unprocessing_meeting_count($userid);
		$data['meetingsCount'] = $meetingsCount;

		// 如果有id参数，说明是学生修改，需要将原有学生信息显示到页面上
		if( isset($_GET['id']) && !empty($_GET['id']) ){
			$studentDetail = $this->students_model->student_detail( $_GET['id'] );
		}else{
			$studentDetail = '';
		}

		$data['title'] = 'Add a New Stuudent';
		$data['menues'] = $res;
		$data['studentDetail'] = $studentDetail;
		$this->load->view('admin/header',$data);
	    $this->load->view('admin/menu_top_left');
		$this->load->view('admin/studentadd.php');
		$this->load->view('admin/footer');
	}

	/**
	 * [studentAddValidate 学生新增数据验证]
	 * @return [type] [description]
	 */
	public function studentAddValidate(){
		$this->load->helper(array('form', 'url'));
		$student_hidden_id = $this->input->post( 'id' );
		$this->form_validation->set_rules('name','Name','required');
		
		if(empty( $student_hidden_id)){
			$this->form_validation->set_rules('account','Account','required|is_unique[students.account]');
		}else{
			$this->form_validation->set_rules('account','Account','required');
		}

		if( empty( $student_hidden_id ) ){
			$this->form_validation->set_rules('password','Password','required');
			$this->form_validation->set_rules('password_confirm','Password Confirm','required|matches[password]');
		}

		if(empty($student_hidden_id)){
			$this->form_validation->set_rules('email','Email','required|valid_email|is_unique[students.email]');
		}else{
			$this->form_validation->set_rules('email','Email','required|valid_email');
		}


		$this->form_validation->set_rules('stream','stream','required');

		if( $this->form_validation->run() ){
			$data = $this->input->post();
			unset( $data['password_confirm'] );
			if( isset( $data['password'] ) ){
				$data['password'] = sha1( $data['password'] );
			}
			$config['upload_path']      = './uploads/students';
			$config['file_name']      = date("Y",time()) . '-' . date("m",time()) . '-' . date("d",time()).'-' . time();
	        $config['allowed_types']    = 'gif|jpg|png';
	        $config['max_size']     = 10000;
	        $config['max_width']        = 1024;
	        $config['max_height']       = 1024;
	        $this->load->library('upload', $config);

	        if ( ! $this->upload->do_upload('headimgurl')){
	        	unset( $data['headimgurl'] );
	        }else{
	        	$imgInfo = $this->upload->data();
	            $data['headimgurl'] = date("Y",time()) . '-' . date("m",time()) . '-' . date("d",time()).'-' . time() . $imgInfo['file_ext'];
	        }
			if( isset( $student_hidden_id ) && !empty( $student_hidden_id ) ){
				$bool = $this->students_model->students_modify( $data, $student_hidden_id );
			}else{
				$bool = $this->students_model->students_add( $data );
			}
			if( $bool ){
				redirect( 'admin/students' );
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

			// 如果有id参数，说明是学生修改，需要将原有学生信息显示到页面上
			if( isset($_GET['id']) && !empty($_GET['id']) ){
				$studentDetail = $this->students_model->student_detail( $_GET['id'] );
			}else{
				$studentDetail = '';
			}
			$data['title'] = 'Edit the Student';
			$data['menues'] = $res;
			$data['studentDetail'] = $studentDetail;
			$data['student_hidden_id'] = $student_hidden_id;
			$this->load->view('admin/header',$data);
		    $this->load->view('admin/menu_top_left');
			$this->load->view('admin/studentadd.php');
			$this->load->view('admin/footer');
		}
	}

}