<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

/**
*	web端课程列表model
*/

class Projects_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * [projects_list 所有有效的课程列表]
	 * @param    [type]                   $userid [description]
	 * @return   [type]                           [description]
	 */
	public function projects_list( $userid ){
		$studentInfo = $this->db->get_where( 'students', array( 'id' => $userid, 'status' => '1' ) )->row_array();
		$projectReadJson = $studentInfo['read_mark'];
		$projectReadArr = json_decode( $projectReadJson, true );
		$projectWishesJson = $studentInfo['project_wishes'];
		$projectWishesArr = json_decode( $projectWishesJson, true );
		if( empty( $projectReadArr ) || $projectReadArr == '' || $projectReadArr == null ){
			$projectReadArr = array();
		}
		if( empty( $projectWishesArr ) || $projectWishesArr == '' || $projectWishesArr == null ){
			$projectWishesArr = array();
		}
		$projects = $this->db->where( array( 'status' => '1' ) )->get( 'projects' )->result_array();
		$newProjects = array();
		foreach ($projects as $key => $project) {
			$projectStreamList = json_decode( $project['stream'], true );
			if( in_array( $studentInfo['stream'], $projectStreamList ) ){
				$newProjects[] = $project;
			}
		}
		foreach ($newProjects as $key => $value) {
			$res = $this->db->get_where( 'supervisors', array( 'id' => $value['supervisor_id'] ) )->row_array();
			$newProjects[$key]['supervisor'] = $res;
			// 判断是否收藏过
			if( in_array( $value['id'] , $projectWishesArr) ){
				$newProjects[$key]['is_wish'] = true;
			}else{
				$newProjects[$key]['is_wish'] = false;
			}
			if( in_array( $value['id'] , $projectReadArr) ){
				$newProjects[$key]['is_read'] = true;
			}else{
				$newProjects[$key]['is_read'] = false;
			}
			// 统计每个课题当前已选人数
			$hadSelectedRows = $this->db->get_where( 'student_projects', array( 'project_id' => $value['id'], 'status' => '1' ) )->result_array();
			$hadSelectedNo = count( $hadSelectedRows );
			$newProjects[$key]['hadSelectedNo'] = $hadSelectedNo;
		}
		return $newProjects;
	}

	/**
	 * [projects_read_list 学生已读的课题列表]
	 * @param    [type]                   $userid [description]
	 * @return   [type]                           [description]
	 */
	public function projects_read_list( $userid ){
		// 根据userid获取学生信息
		$studentInfo = $this->db->get_where( 'students', array( 'id' => $userid, 'status' => '1' ) )->row_array();
		$projectReadJson = $studentInfo['read_mark'];
		$projectReadArr = json_decode( $projectReadJson, true );
		$projectWishesJson = $studentInfo['project_wishes'];
		$projectWishesArr = json_decode( $projectWishesJson, true );
		if( empty( $projectReadArr ) || $projectReadArr == '' || $projectReadArr == null ){
			$projectReadArr = array();
		}
		if( empty( $projectWishesArr ) || $projectWishesArr == '' || $projectWishesArr == null ){
			$projectWishesArr = array();
		}
		if( !empty( $projectReadArr ) ){
			$projects = $this->db->where( array( 'status' => '1' ) )->where_not_in( 'id', $projectReadArr )->get( 'projects' )->result_array();
		}else{
			$projects = $this->db->where( array( 'status' => '1' ) )->get( 'projects' )->result_array();
		}
		$newProjects = array();
		foreach ($projects as $key => $project) {
			$projectStreamList = json_decode( $project['stream'], true );
			if( in_array( $studentInfo['stream'], $projectStreamList ) ){
				$newProjects[] = $project;
			}
		}
		foreach ($newProjects as $key => $value) {
			$res = $this->db->get_where( 'supervisors', array( 'id' => $value['supervisor_id'] ) )->row_array();
			$newProjects[$key]['supervisor'] = $res;
			if( in_array( $value['id'] , $projectWishesArr) ){
				$newProjects[$key]['is_wish'] = true;
			}else{
				$newProjects[$key]['is_wish'] = false;
			}
			if( in_array( $value['id'] , $projectReadArr) ){
				$newProjects[$key]['is_read'] = true;
			}else{
				$newProjects[$key]['is_read'] = false;
			}
		}
		return $newProjects;
	}

	/**
	 * [projects_wishes_list 学生喜欢的课题列表]
	 * @return [type] [description]
	 */
	public function projects_wishes_list( $userid ){
		// 根据userid获取学生信息
		$studentInfo = $this->db->get_where( 'students', array( 'id' => $userid, 'status' => '1' ) )->row_array();
		$projectReadJson = $studentInfo['read_mark'];
		$projectReadArr = json_decode( $projectReadJson, true );
		$projectWishesJson = $studentInfo['project_wishes'];
		$projectWishesArr = json_decode( $projectWishesJson, true );
		if( empty( $projectReadArr ) || $projectReadArr == '' || $projectReadArr == null ){
			$projectReadArr = array();
		}
		if( empty( $projectWishesArr ) || $projectWishesArr == '' || $projectWishesArr == null ){
			$projectWishesArr = array();
		}
		if( !empty( $projectWishesArr ) ){
			$projects = $this->db->where( array( 'status' => '1' ) )->where_in( 'id', $projectWishesArr )->get( 'projects' )->result_array();
			$newProjects = array();
			foreach ($projects as $key => $project) {
				$projectStreamList = json_decode( $project['stream'], true );
				if( in_array( $studentInfo['stream'], $projectStreamList ) ){
					$newProjects[] = $project;
				}
			}
			foreach ($newProjects as $key => $value) {
				$res = $this->db->get_where( 'supervisors', array( 'id' => $value['supervisor_id'] ) )->row_array();
				$newProjects[$key]['supervisor'] = $res;
				if( in_array( $value['id'] , $projectWishesArr) ){
					$newProjects[$key]['is_wish'] = true;
				}else{
					$newProjects[$key]['is_wish'] = false;
				}
				if( in_array( $value['id'] , $projectReadArr) ){
					$newProjects[$key]['is_read'] = true;
				}else{
					$newProjects[$key]['is_read'] = false;
				}
			}
		}else{
			$newProjects = '';
		}
		return $newProjects;
	}

	public function my_wish_list_change( $wish_mark, $id, $userid ){
		$studentInfo = $this->db->get_where( 'students', array( 'id' => $userid ) )->row_array();
		$projectWishesJson = $studentInfo['project_wishes'];
		$projectWishesJson = str_replace( '\\', '', $projectWishesJson );
		$projectWishesArr = json_decode( $projectWishesJson, JSON_UNESCAPED_UNICODE );
		if( empty( $projectReadArr ) || $projectReadArr == '' || $projectReadArr == null ){
			$projectReadArr = array();
		}
		if( empty( $projectWishesArr ) || $projectWishesArr == '' || $projectWishesArr == null ){
			$projectWishesArr = array();
		}
		if( $wish_mark == '1' ){
			unset( $projectWishesArr[$id] );
		}else{
			$projectWishesArr[$id] = $id;
		}
		$newProjectWishesJson = json_encode( $projectWishesArr, true );
		$res = $this->db->update( 'students', array( 'project_wishes' => $newProjectWishesJson ), array( 'id' => $userid ) );
		return $res;
	}

	public function my_read_list_change( $read_mark, $id, $userid ){
		$studentInfo = $this->db->get_where( 'students', array( 'id' => $userid ) )->row_array();
		$projectReadJson = $studentInfo['read_mark'];
		$projectReadJson = str_replace( '\\', '', $projectReadJson );
		$projectReadArr = json_decode( $projectReadJson, JSON_UNESCAPED_UNICODE );
		if( $read_mark == '1' ){
			unset( $projectReadArr[$id] );
		}else{
			$projectReadArr[$id] = $id;
		}
		$newProjectReadJson = json_encode( $projectReadArr, true );
		$res = $this->db->update( 'students', array( 'read_mark' => $newProjectReadJson ), array( 'id' => $userid ) );
		return $res;
	}

	/**
	 * [projects_all_list 所有有效课程列表]
	 * @param  [type] $userid [description]
	 * @return [type]         [description]
	 */
	public function projects_all_list( $userid ){
		$data = $this->db->get_where( 'projects', array( 'status' => '1' ) )->result_array();
		return $data;
	}

	/**
	 * [projects_had_selected_list 已选择课程列表]
	 * @param  [type] $userid [description]
	 * @return [type]         [description]
	 */
	public function projects_had_selected_list( $userid ){
		$data = $this->db->get_where( 'student_projects', array( 'student_id' => $userid, 'status' => '1' ) )->result_array();
		foreach ($data as $key => $value) {
			$project_id = $value['project_id'];
			$data[$key]['projectInfo'] = $this->db->get_where( 'projects', array( 'id' => $project_id, 'status' => '1' ) )->row_array();
			$supervisor_id = $data[$key]['projectInfo']['supervisor_id'];
			$data[$key]['supervisorInfo'] = $this->db->get_where( 'supervisors', array( 'id' => $supervisor_id, 'status' => '1' ) )->row_array();
		}
		return $data;
	}

	/**
	 * [filter_all_projects_by_hadselected 通过已选课题，过滤所有课题列表]
	 * @param    [type]                   $projectsAll         [description]
	 * @param    [type]                   $projectsHadSelected [description]
	 * @return   [type]                                        [description]
	 */
	public function filter_all_projects_by_hadselected( $projectsAlls, $projectsHadSelecteds ){
		$newProjectsAll = $projectsAlls;
		foreach ($projectsAlls as $key => $projectsAll) {
			foreach ($projectsHadSelecteds as $i => $projectsHadSelected) {
				if( $projectsAll['id'] == $projectsHadSelected['project_id'] ){
					unset( $newProjectsAll[$key] );
				}
			}
		}
		return $newProjectsAll;
	}

	public function projects_select_submission( $userid, $arr ){

		foreach ($arr as $key => $value) {
			$newArr[] = $value['project_id'];
		}
		$arrCount = array_count_values( $newArr );
		foreach ($arrCount as $key => $value) {
			if( $value >= 2 ){
				return 'repeat';
				exit();
			}
		}
		$this->db->update( 'student_projects', array( 'status' => '0', 'update_time' => date( 'Y-m-d H:i:s', time() ) ), array( 'student_id' => $userid, 'status' => '1' ) );
		foreach ($arr as $key => $value) {
			$data = array(
					'student_id' => $userid,
					'project_id' => $value['project_id'],
					'project_rank' => $value['project_rank_nr']
				);
			$this->db->insert( 'student_projects', $data );
		}
	}
}