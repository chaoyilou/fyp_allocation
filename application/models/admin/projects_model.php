<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

/**
* 课程列表
*/
class Projects_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * [projects_list 获取课程列表]
	 * @param  [type] $status [description]
	 * @return [type]         [description]
	 */
	public function projects_list( $supervisor_id, $status = '-1'){
		if( $status == '-1' ){
			if( $supervisor_id == 0 ){
				$data = $this->db->order_by('id','DESC')->get( 'projects' )->result_array();
			}else{
				$data = $this->db->where( array( 'supervisor_id' => $supervisor_id ) )->order_by('id','DESC')->get( 'projects' )->result_array();
			}
		}else{
			if( $supervisor_id == 0 ){
				$data = $this->db->where( array( 'status' => $status ) )->order_by('id','DESC')->get('projects')->result_array();
			}else{
				$data = $this->db->where( array( 'supervisor_id' => $supervisor_id, 'status' => $status ) )->order_by('id','DESC')->get('projects')->result_array();
			}

		}
		foreach ($data as $key => &$value) {
			$supervisorInfo = $this->db->where( 'id', $value['supervisor_id'] )->get( 'supervisors' )->row_array();
			$selectedProjectCount = $this->db->where( 'project_id', $value['id'] )->count_all_results( 'fyp_student_projects' );
			$value['supervisor_name'] = $supervisorInfo['name'];
			$value['choosing_number'] = $selectedProjectCount;
			$streams = $value['stream'];
			$streams = json_decode( $streams, true );
			foreach ($streams as $key => $stream) {
				$streams[$key] = stream_data_filter( $stream );
			}
			$value['stream'] = $streams;
		}
		return $data;
	}

	/**
	 * [project_detail 获取课程详情]
	 * @param    [type]                   $project_id [description]
	 * @return   [type]                               [description]
	 */
	public function project_detail( $project_id ){
		$data = $this->db->where( array( 'id' => $project_id, 'status' => '1' ) )->get( 'projects' )->row_array();
		$data['stream'] = json_decode( $data['stream'], true );
		$data['supervisorDetail'] = $this->db->where( array( 'id' => $data['supervisor_id'] ) )->get( 'supervisors' )->row_array();
		return $data;
	}

	public function get_new_project_pid(){
		$data = $this->db->where( array( 'status' => '1' ) )->order_by('id', 'desc')->get( 'projects' )->row_array();
		$PID = $data['PID'];
		return ( $PID + 1 );
	}

	/**
	 * [projects_delete 课程删除]
	 * @param  [type] $project_id [description]
	 * @return [type]             [description]
	 */
	public function projects_delete( $project_id ){
		$res = $this->db->update( 'projects', array( 'status' => '0', 'update_time' => date( 'Y-m-d H:i:s',time() ) ), array( 'id' => $project_id ) );
		return $res;
	}

	/**
	 * [projects_recover 课程恢复]
	 * @param  [type] $project_id [description]
	 * @return [type]             [description]
	 */
	public function projects_recover( $project_id ){
		$res = $this->db->update( 'projects', array( 'status' => '1', 'update_time' => date( 'Y-m-d H:i:s',time() ) ), array( 'id' => $project_id ) );
		return $res;
	}

	/**
	 * [projects_add 课程添加]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function projects_add( $data ){
		$res = $this->db->insert( 'projects', $data );
		return $res;
	}

	/**
	 * [projects_modify 课程修改]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function projects_modify( $data, $id ){
		$data['update_time'] = date( 'Y-m-d H:i:s', time() );
		$res = $this->db->where( 'id' , $id )->set( $data )->update( 'projects' );
		return $res;
	}
}