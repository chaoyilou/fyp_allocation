<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	教授列表
*/

class Supervisors extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if( !$this->session->userdata('useridweb') ){
			redirect('web/login');
		}
		$this->load->model( 'admin/Supervisors_model', 'supervisors_model' );
		// $this->load->model( 'web/Projects_model', 'projects_model' );
	}

	/**
	 * [index 教授详情]
	 * @return   [type]                   [description]
	 */
	public function detail(){
		$useridweb = $this->session->userdata('useridweb');
		$supervisor_id = $this->input->get( 'id' );
		$supervisorDetail = $this->supervisors_model->get_supervisor_detail_for_web( $supervisor_id );

		$data['title'] = 'Supervisor Detail';
		$data['supervisordetail'] = $supervisorDetail;
	    $this->load->view('web/header',$data);
		$this->load->view('web/menu_top');
		$this->load->view('web/supervisordetail');
		$this->load->view('web/footer');
	}

}