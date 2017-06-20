<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	后台学生管理model
*/
class Students_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function students_list( $status = '-1' ){
		if( $status == '-1' ){
			$data = $this->db->order_by('id','DESC')->get( 'students' )->result_array();
		}else{
			$data = $this->db->where( array( 'status' => $status ) )->order_by('id','DESC')->get('students')->result_array();
		}
		foreach ($data as $key => &$value) {
			$value['headimgurlfull'] = base_url('uploads/students/') . $value['headimgurl'];
		}
		return $data;
	}

	public function students_delete( $student_id ){
		$res = $this->db->update( 'students', array( 'status' => '0', 'update_time' => date( 'Y-m-d H:i:s',time() ) ), array( 'id' => $student_id ) );
		return $res;
	}

	public function students_recover( $student_id ){
		$res = $this->db->update( 'students', array( 'status' => '1', 'update_time' => date( 'Y-m-d H:i:s',time() ) ), array( 'id' => $student_id ) );
		return $res;
	}

	public function student_detail( $student_id ){
		$data = $this->db->where( array( 'id' => $student_id, 'status' => '1' ) )->get( 'students' )->row_array();
		$data['stream'] = stream_data_filter( $data['stream'] );
		return $data;
	}

	/**
	 * [students_add 学生添加]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function students_add( $data ){
		$res = $this->db->insert( 'students', $data );
		return $res;
	}

	/**
	 * [students_modify 学生修改]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function students_modify( $data, $id ){
		$data['update_time'] = date( 'Y-m-d H:i:s', time() );
		$res = $this->db->where( 'id' , $id )->set( $data )->update( 'students' );
		return $res;
	}
}