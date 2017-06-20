<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 账号管理
*/
class Operators_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	/**
	 * [get_operator_detail 获取特定账号的详情]
	 * @param    [type]                   $supervisor_id [description]
	 * @return   [type]                                  [description]
	 */
	public function get_operator_detail( $supervisor_id ){
		$data = $this->db->where( array( 'supervisor_id' => $supervisor_id, 'status' => '1' ) )->get( 'operator' )->row_array();
		return $data;
	}

	public function password_change( $data ){
		$operatorInfo = $this->db->where( 'id', $data['userid'] )->get( 'operator' )->row_array();
		if( $operatorInfo['password'] != $data['old_password'] ){
			return '原始密码错误';
			exit();
		}else{
			$res = $this->db->set( array( 'password' => $data['password'], 'update_time' => date( 'Y-m-d H:i:s', time() ) ) )->where( 'id', $data['userid'] )->update( 'operator' );
			if( $res ){
				return true;
			}else{
				return '更新失败';
			}
		}
	}

}