<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	学生预约
*/
class Meetings extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if( !$this->session->userdata('useridweb') ){
			redirect('web/login');
		}
		$this->load->model( 'admin/Supervisors_model', 'supervisors_model' );
		$this->load->model( 'web/Meetings_model', 'meetings_model' );
	}

	/**
	 * [supervisorlist 开会预约教授列表--真实内容为教授列表]
	 * @return   [type]                   [description]
	 */
	public function supervisorlist(){
		$useridweb = $this->session->userdata('useridweb');
		if( isset( $_GET['searchKey'] ) ){
			$searchKey = $_GET['searchKey'];
		}else{
			$searchKey = '';
		}
		// 放在搜索参数被分页弄丢
		$searchKeyString = '?searchKey=' . $searchKey;

		// 启用分页类，并且配置自定义参数
		$this->load->library('pagination');
		// 选择页面后显示的基础url
		$config['base_url'] = site_url('/web/meetings/supervisorlist') . $searchKeyString;
		// 数据的总条数
		$config['total_rows'] = $this->supervisors_model->get_supervisors_total_num( $searchKey );
		// 每页显示条数
		$config['per_page'] = 6;
		// 将url的page参数改成与当前页码一致，默认是当前开始条数
		$config['use_page_numbers'] = TRUE;
		// 将REQUEST_URI 从CI自带的URL片段改成字符串格式
		$config['page_query_string'] = TRUE;
		$config['page_query_string'] = TRUE;
		// 初始化创建分页器
		$this->pagination->initialize($config);
		// 创建分页器
		$pagination = $this->pagination->create_links();

		// 获取当前页面
		$curentPageNum = $this->input->get('per_page');

		if( $curentPageNum <= 0 || $curentPageNum == '' ){
			$curentPageNum = 1;
		}else if( $curentPageNum > ceil( $config['total_rows'] / $config['per_page'] ) ){
			$curentPageNum = ceil( $config['total_rows'] / $config['per_page'] );
		}
		$supervisors = $this->supervisors_model->get_supervisors_for_web_pagination( $config['total_rows'],  $config['per_page'], $curentPageNum, $searchKey );

		$data['title'] = 'Arrange Meeting';
		$data['supervisors'] = $supervisors;
		$data['pagination'] = $pagination;
	    $this->load->view('web/header',$data);
		$this->load->view('web/menu_top');
		$this->load->view('web/meetings');
		$this->load->view('web/footer');
	}

	/**
	 * [appointment 开会预约表单提交页面]
	 * @return   [type]                   [description]
	 */
	public function appointment(){
		$supervisor_id = $this->input->get( 'id' );
		$data['supervisorInfo'] = $this->supervisors_model->get_supervisor_detail_for_web( $supervisor_id );
		$data['title'] = '开会预约';
		$this->load->view('web/header',$data);
		$this->load->view('web/menu_top');
		$this->load->view('web/appointment');
		$this->load->view('web/footer');
	}

	public function appointmentSubmission(){
		$this->form_validation->set_rules('appointSupervisor','appointSupervisor','required');
		$this->form_validation->set_rules('appointRoom','appointRoom','required');
		$this->form_validation->set_rules('appointType','appointType','required');
		$this->form_validation->set_rules('appointDate','appointDate','required');
		$this->form_validation->set_rules('appointTime','appointTime','required');
		if( $this->form_validation->run() !== false ){
			$postData = $this->input->post();
			$data = array();
			$data['supervisor_id'] = $postData['hidden_supervisor_id'];
			$data['student_id'] = $this->session->userdata('useridweb');
			$data['appointment_time'] = $postData['appointDate'] . ' ' . $postData['appointTime'];
			$data['meeting_room'] = $postData['appointRoom'];
			$data['appointment_preference'] = $postData['appointType'];
			$data['memo'] = isset($postData['appointMemo']) ? $postData['appointMemo'] : '';
			$this->meetings_model->appointment_submisson( $data );
			$data['title'] = '开会预约成功';
			$this->load->view('web/header',$data);
			$this->load->view('web/menu_top');
			$this->load->view('web/appointmentsuccess');
			$this->load->view('web/footer');
		}else{
			$supervisor_id = $this->input->post( 'hidden_supervisor_id' );
			$data['supervisorInfo'] = $this->supervisors_model->get_supervisor_detail_for_web( $supervisor_id );
			$data['title'] = '开会预约';
			$this->load->view('web/header',$data);
			$this->load->view('web/menu_top');
			$this->load->view('web/appointment');
			$this->load->view('web/footer');
		}
	}

}