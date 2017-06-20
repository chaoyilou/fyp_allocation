<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 课程管理
*/
class Projects extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if( !$this->session->userdata('userid') ){
			redirect('admin/login');
		}
		$this->load->model( 'admin/projects_model', 'projects_model' );
		$this->load->model( 'admin/supervisors_model','supervisors_model' );
	}

	/**
	 * [index 默认方法]
	 * @return [type] [description]
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

		$data['title'] = 'Project Management';
		$data['menues'] = $res;
		$this->load->view('admin/header',$data);
	    $this->load->view('admin/menu_top_left');
		$this->load->view('admin/projectsmanager');
		$this->load->view('admin/footer');
	}

	/**
	 * [projectsList 课程列表]
	 * @return [type] [description]
	 */
	public function projectsList(){
		$status = $this->input->post('status');
		$supervisor_id = $this->session->userdata('supervisor_id');
		$projects = $this->projects_model->projects_list( $supervisor_id, $status );
		echo json_encode( array( "items" => $projects ),JSON_UNESCAPED_UNICODE );
	}

	/**
	 * [deleteProject 课程删除]
	 * @return [type] [description]
	 */
	public function deleteProject(){
		$project_id = $this->input->post('project_id');
		$res = $this->projects_model->projects_delete( $project_id );
		echo return_msg( '0', 'Delete Succeeded' );
	}

	/**
	 * [recoverProject 已删除课程恢复]
	 * @return [type] [description]
	 */
	public function recoverProject(){
		$project_id = $this->input->post('project_id');
		$res = $this->projects_model->projects_recover( $project_id );
		echo return_msg( '0', 'Delete Succeeded' );
	}

	/**
	 * [projectAdd 课题新增页面]
	 * @return [type] [description]
	 */
	public function projectAdd(){
		$role_id = $this->session->userdata('role_id');
		$this->load->model('admin/menu_rights_model');
		$res = $this->menu_rights_model->get_menu_rights($role_id);
		$supervisor_id = $this->session->userdata('supervisor_id');
		$supervisors = $this->supervisors_model->supervisors_list( $supervisor_id );

		// 根据登录名获取登陆账号信息，显示到首页
		$userid = $this->session->userdata('userid');
		$this->load->model('admin/meetings_model');
		$meetingsCount = $this->meetings_model->get_unprocessing_meeting_count($userid);
		$data['meetingsCount'] = $meetingsCount;

		// 如果有id参数，说明是课题修改，需要将原有课题信息显示到页面上
		if( isset($_GET['id']) && !empty($_GET['id']) ){
			$projectDetail = $this->projects_model->project_detail( $_GET['id'] );
		}else{
			$projectDetail['PID'] = $this->projects_model->get_new_project_pid();
		}

		$data['title'] = 'Upload a New Project';
		$data['menues'] = $res;
		$data['supervisors'] = $supervisors;
		$data['projectDetail'] = $projectDetail;
		$this->load->view('admin/header',$data);
	    $this->load->view('admin/menu_top_left');
		$this->load->view('admin/projectadd.php');
		$this->load->view('admin/footer');
	}

	/**
	 * [projectAddValidate 课题新增数据验证]
	 * @return [type] [description]
	 */
	public function projectAddValidate(){
		$project_hidden_id = $this->input->post( 'id' );
		$this->form_validation->set_rules('supervisor_id','Supervisor Name','required');
		$this->form_validation->set_rules('title','Title','required');
		$this->form_validation->set_rules('PID','PID','required');
		$this->form_validation->set_rules('desc','Description','required');
		$this->form_validation->set_rules('stream[]','Stream','required');
		$this->form_validation->set_rules('difficulty_min','Minimum Mark','required');
		$this->form_validation->set_rules('difficulty_max','Maximum Mark','required');

		if( $this->form_validation->run() ){
			$data = $this->input->post();
			$data['stream'] = json_encode($data['stream']);
			if( isset( $project_hidden_id ) && !empty( $project_hidden_id ) ){
				$bool = $this->projects_model->projects_modify( $data, $project_hidden_id );
			}else{
				$bool = $this->projects_model->projects_add( $data );
			}
			if( $bool ){
				redirect( 'admin/projects' );
			}
		}else{
			$role_id = $this->session->userdata('role_id');
			$this->load->model('admin/menu_rights_model');
			$res = $this->menu_rights_model->get_menu_rights($role_id);

			$supervisor_id = $this->session->userdata('supervisor_id');
			$supervisors = $this->supervisors_model->supervisors_list( $supervisor_id );

			// 根据登录名获取登陆账号信息，显示到首页
			$userid = $this->session->userdata('userid');
			$this->load->model('admin/meetings_model');
			$meetingsCount = $this->meetings_model->get_unprocessing_meeting_count($userid);
			$data['meetingsCount'] = $meetingsCount;

			// 如果有id参数，说明是课题修改，需要将原有课题信息显示到页面上
			if( isset($_GET['id']) && !empty($_GET['id']) ){
				$projectDetail = $this->projects_model->project_detail( $_GET['id'] );
			}else{
				$projectDetail['PID'] = $this->projects_model->get_new_project_pid();
			}
			$data['title'] = 'Edit the Project';
			$data['menues'] = $res;
			$data['supervisors'] = $supervisors;
			$data['projectDetail'] = $projectDetail;
			$data['project_hidden_id'] = $project_hidden_id;
			$this->load->view('admin/header',$data);
		    $this->load->view('admin/menu_top_left');
			$this->load->view('admin/projectadd.php');
			$this->load->view('admin/footer');
		}
	}
}