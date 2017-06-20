<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 教授管理
*/
class Supervisors_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	/**
	 * [supervisors_list 教授列表--管理后台]
	 * @param    string                   $status [description]
	 * @return   [type]                           [description]
	 */
	public function supervisors_list( $supervisor_id, $status = '-1' ){
		if( $status == '-1' ){
			if( $supervisor_id == 0 ){
				$data = $this->db->order_by('id','DESC')->get( 'supervisors' )->result_array();
			}else{
				$data = $this->db->where( array( 'id' => $supervisor_id ) )->order_by('id','DESC')->get( 'supervisors' )->result_array();
			}
		}else{
			if( $supervisor_id == 0 ){
				$data = $this->db->where( array( 'status' => $status ) )->order_by('id','DESC')->get('supervisors')->result_array();
			}else{
				$data = $this->db->where( array( 'id' => $supervisor_id, 'status' => $status ) )->order_by('id','DESC')->get( 'supervisors' )->result_array();
			}
		}
		foreach ($data as $key => &$value) {
			$value['appointment_preference'] = appointment_preference_data_filter( $value['appointment_preference'] );
			$value['headimgurlfull'] = base_url('uploads/supervisors/') . $value['headimgurl'];
		}
		return $data;
	}

	/**
	 * [supervisors_delete 删除一个教授--后台]
	 * @param    [type]                   $supervisor_id [description]
	 * @return   [type]                                  [description]
	 */
	public function supervisors_delete( $supervisor_id ){
		$res = $this->db->update( 'supervisors', array( 'status' => '0', 'update_time' => date( 'Y-m-d H:i:s',time() ) ), array( 'id' => $supervisor_id ) );
		return $res;
	}

	/**
	 * [supervisors_recover 恢复一个教授--后台]
	 * @param    [type]                   $supervisor_id [description]
	 * @return   [type]                                  [description]
	 */
	public function supervisors_recover( $supervisor_id ){
		$res = $this->db->update( 'supervisors', array( 'status' => '1', 'update_time' => date( 'Y-m-d H:i:s',time() ) ), array( 'id' => $supervisor_id ) );
		return $res;
	}

	public function supervisor_detail( $supervisor_id ){
		$data = $this->db->where( array( 'id' => $supervisor_id, 'status' => '1' ) )->get( 'supervisors' )->row_array();
		$data['operatorInfo'] = $this->db->where( array( 'supervisor_id' => $supervisor_id, 'status' => '1' ) )->get( 'operator' )->row_array();
		$data['appointment_preference'] = appointment_preference_data_filter( $data['appointment_preference'] );
		return $data;
	}

	/**
	 * [supervisors_and_operator_add 教授+登陆账号添加]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function supervisors_and_operator_add( $supervisor, $operator ){
		$this->db->trans_start();
			$res = $this->db->insert( 'supervisors', $supervisor );
			$new_id_number = $this->db->insert_id();
			$operator['supervisor_id'] = $new_id_number;
			$res = $this->db->insert( 'operator', $operator );
		$this->db->trans_complete();
		return $res;
	}

	/**
	 * [supervisors_and_operator_modify 教授+登陆账号修改]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function supervisors_and_operator_modify( $supervisor, $operator, $id ){
		$supervisor['update_time'] = date( 'Y-m-d H:i:s', time() );
		$operator['update_time'] = date( 'Y-m-d H:i:s', time() );
		$this->db->trans_start();
			$resOne = $this->db->where( 'id' , $id )->set( $supervisor )->update( 'supervisors' );
			$resTwo = $this->db->where( 'supervisor_id' , $id )->set( $operator )->update( 'operator' );
		$this->db->trans_complete();
		return $resTwo;
	}

	/**
	 * [operators_add 教授账号添加]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function operators_add( $data ){
		$res = $this->db->insert( 'operator', $data );
		return $res;
	}

	/**
	 * [supervisors_modify 教授修改]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function supervisors_modify( $data, $id ){
		$data['update_time'] = date( 'Y-m-d H:i:s', time() );
		$res = $this->db->where( 'id' , $id )->set( $data )->update( 'supervisors' );
		return $res;
	}

	/**
	 * [get_supervisors_for_web 获取教授列表（不分页）--前端]
	 * @return   [type]                   [description]
	 */
	public function get_supervisors_for_web(){
		$data = $this->db->order_by('id','DESC')->where( array( 'status' => '1' ) )->get( 'supervisors' )->result_array();
		foreach ($data as $key => $value) {
			if( $value['appointment_preference'] == '1' ){
				$data[$key]['appointment_preference'] = 'individual meeting';
			}else if( $value['appointment_preference'] == '2' ){
				$data[$key]['appointment_preference'] = 'group meeting';
			}else{
				$data[$key]['appointment_preference'] = 'individual meeting/group meeting';
			}
		}
		return $data;
	}

	/**
	 * [get_supervisors_for_web_pagination 获取教授列表（分页）--前端]
	 * @return   [type]                   [description]
	 */
	public function get_supervisors_for_web_pagination( $total, $perPageNum, $currentPageNum, $searchKey ){
		if( empty( $searchKey ) ){
			$data = $this->db->order_by('id','DESC')->where( array( 'status' => '1' ) )->limit( $perPageNum, ( $currentPageNum - 1 ) * $perPageNum )->get( 'supervisors' )->result_array();
		}else{
			$data = $this->db->order_by('id','DESC')->where( array( 'status' => '1' ) )->like( 'name', $searchKey )->limit( $perPageNum, ( $currentPageNum - 1 ) * $perPageNum )->get( 'supervisors' )->result_array();
		}
		foreach ($data as $key => &$value) {
			$value['appointment_preference'] = appointment_preference_data_filter( $value['appointment_preference'] );
		}
		return $data;
	}

	/**
	 * [get_supervisor_detail_for_web 获取特定教授的详情--前端]
	 * @param    [type]                   $supervisor_id [description]
	 * @return   [type]                                  [description]
	 */
	public function get_supervisor_detail_for_web( $supervisor_id ){
		$data = $this->db->where( array( 'id' => $supervisor_id, 'status' => '1' ) )->get( 'supervisors' )->row_array();
		if( $data['appointment_preference'] == '1' ){
			$data['appointment_preference'] = 'individual meeting';
		}else if( $data['appointment_preference'] == '2' ){
			$data['appointment_preference'] = 'group meeting';
		}else{
			$data['appointment_preference'] = 'individual meeting/group meeting';
		}
		return $data;
	}

	public function get_supervisors_total_num( $searchKey = '' ){
		if( empty( $searchKey ) ){
			$data = $this->db->where( array( 'status' => '1' ) )->count_all_results('supervisors');
		}else{
			$data = $this->db->where( array( 'status' => '1' ) )->like( 'name', $searchKey )->count_all_results('supervisors');
		}
		return $data;
	}
}