<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*
*/
class Operators extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if( !$this->session->userdata('userid') ){
			redirect('admin/login');
		}
		$this->load->model( 'admin/operators_model', 'operators_model' );
	}

	/**
	 * [selfinfo 等同于index方法，专为个人中心开设]
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
		$operatorDetail = $this->operators_model->get_operator_detail( $supervisor_id );
		$data['title'] = 'Personal Information';
		$data['menues'] = $res;
		$data['operatorDetail'] = $operatorDetail;
		$this->load->view('admin/header',$data);
	    $this->load->view('admin/menu_top_left');
		$this->load->view('admin/operatorinfo');
		$this->load->view('admin/footer');
	}

	public function passwordChange(){
		$userid = $this->session->userdata('userid');
		$data['old_password'] = sha1( $_POST['old_password'] );
		$data['password'] = sha1( $_POST['password'] );
		$data['userid'] = $userid;

		$res = $this->operators_model->password_change( $data );
		if( $res === true ){
			echo return_msg( '0', '更新密码更新成功' );
		}else{
			echo return_msg( '101', $res );
		}

	}

}