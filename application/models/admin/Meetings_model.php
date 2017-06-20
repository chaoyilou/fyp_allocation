<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	后台预约会议管理model
*/
class Meetings_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function meetings_list( $supervisor_id, $status = '-1' ){
		if( $status == '-1' ){
			if( $supervisor_id == 0 ){
				$meetings = $this->db->order_by('id','DESC')->get( 'student_meetings' )->result_array();
			}else{
				$meetings = $this->db->where( 'supervisor_id', $supervisor_id )->order_by('id','DESC')->get( 'student_meetings' )->result_array();
			}
		}else{
			if( $supervisor_id == 0 ){
				$meetings = $this->db->where( array( 'status' => $status ) )->order_by('id','DESC')->get('student_meetings')->result_array();
			}else{
				$meetings = $this->db->where( array( 'status' => $status, 'supervisor_id' => $supervisor_id ) )->order_by('id','DESC')->get('student_meetings')->result_array();
			}
		}
		foreach ($meetings as $key => &$meeting) {
			$studentInfo = $this->db->where( array( 'id' => $meeting['student_id'] ) )->get( 'students' )->row_array();
			$supervisorInfo = $this->db->where( array( 'id' => $meeting['supervisor_id'] ) )->get( 'supervisors' )->row_array();
			$meeting['student_name'] = $studentInfo['name'];
			$meeting['supervisor_name'] = $supervisorInfo['name'];

		}
		return $meetings;
	}

	public function meeting_status_change( $id, $status ){
		$res = $this->db->update( 'student_meetings', array( 'status' => $status, 'update_time' => date( 'Y-m-d H:i:s',time() ) ), array( 'id' => $id ) );
		return $res;
	}

	public function get_unprocessing_meeting_count( $userid ){
		$operatorInfo = $this->db->where( array( 'id' => $userid ) )->get( 'operator' )->row_array();
        // 管理员获取全部
        if( $operatorInfo['role_id'] == '1' ){
            $meetingsCount = $this->db->where( array( 'status' => '0' ) )->count_all_results( 'student_meetings' );
        // 教授只能看到自己的
        }else if( $operatorInfo['role_id'] == '2' ){
            $meetingsCount = $this->db->where( array( 'supervisor_id' => $userid, 'status' => '0' ) )->count_all_results( 'student_meetings' );
        }else{
            $meetingsCount = '';
        }
        return $meetingsCount;
	}
}