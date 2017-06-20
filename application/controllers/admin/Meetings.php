<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	预约会议管理列表
*/
class Meetings extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if( !$this->session->userdata('userid') ){
			redirect('admin/login');
		}
		$this->load->model( 'admin/meetings_model', 'meetings_model' );
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

		$data['title'] = 'Meeting Management';
		$data['menues'] = $res;
		$this->load->view('admin/header',$data);
	    $this->load->view('admin/menu_top_left');
		$this->load->view('admin/meetingsmanager');
		$this->load->view('admin/footer');
	}

	/**
	 * [meetingsList 所有有效预约会议列表]
	 * @return   [type]                   [description]
	 */
	public function meetingsList(){
		$status = $this->input->post('status');
		$supervisor_id = $this->session->userdata('supervisor_id');
		$students = $this->meetings_model->meetings_list( $supervisor_id, $status );
		echo json_encode( array( "items" => $students ),JSON_UNESCAPED_UNICODE );
	}

	/**
	 * [changeStatus 修改会议状态]
	 * @return   [type]                   [description]
	 */
	public function changeStatus(){
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		$res = $this->meetings_model->meeting_status_change( $id, $status );
		echo return_msg( '0', 'Update Succeeded' );
	}

	/**
	 * [recoverStudent 恢复一个学生]
	 * @return   [type]                   [description]
	 */
	public function recoverStudent(){
		$supervisor_id = $this->input->post('supervisor_id');
		$res = $this->meetings_model->students_recover( $supervisor_id );
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

		// 如果有id参数，说明是课题修改，需要将原有课题信息显示到页面上
		if( isset($_GET['id']) && !empty($_GET['id']) ){
			$studentDetail = $this->meetings_model->student_detail( $_GET['id'] );
		}else{
			$studentDetail = '';
		}

		$data['title'] = 'New Project';
		$data['menues'] = $res;
		$data['studentDetail'] = $studentDetail;
		$this->load->view('admin/header',$data);
	    $this->load->view('admin/menu_top_left');
		$this->load->view('admin/studentadd.php');
		$this->load->view('admin/footer');
	}

	/**
	 * [projectAddValidate 学生新增数据验证]
	 * @return [type] [description]
	 */
	public function studentAddValidate(){
		$student_hidden_id = $this->input->post( 'id' );
		$this->form_validation->set_rules('name','学生姓名','required');
		$this->form_validation->set_rules('account','学生登陆账号','required');
		$this->form_validation->set_rules('password','登陆密码','required');
		$this->form_validation->set_rules('password_confirm','登陆密码确认','required|matches[password]');
		$this->form_validation->set_rules('headimgurl','学生头像照片','required');
		$this->form_validation->set_rules('email','学生邮箱号','required|valid_email|is_unique[students.email]');
		$this->form_validation->set_rules('stream','stream','required');

		if( $this->form_validation->run() ){
			$data = $this->input->post();
			unset( $data['password_confirm'] );
			$data['password'] = sha1( $data['password'] );
			if( isset( $student_hidden_id ) && !empty( $student_hidden_id ) ){
				$bool = $this->meetings_model->students_modify( $data, $student_hidden_id );
			}else{
				$bool = $this->meetings_model->students_add( $data );
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

			// 如果有id参数，说明是课题修改，需要将原有课题信息显示到页面上
			if( isset($_GET['id']) && !empty($_GET['id']) ){
				$studentDetail = $this->meetings_model->student_detail( $_GET['id'] );
			}else{
				$studentDetail = '';
			}
			$data['title'] = '学生新增';
			$data['menues'] = $res;
			$data['studentDetail'] = $studentDetail;
			$this->load->view('admin/header',$data);
		    $this->load->view('admin/menu_top_left');
			$this->load->view('admin/studentadd.php');
			$this->load->view('admin/footer');
		}
	}

}