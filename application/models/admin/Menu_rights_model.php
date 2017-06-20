<?php
/**
*
*/
class Menu_rights_model extends CI_Model
{

	function __construct()
	{

	}

	public function get_menu_rights( $role_id ){
		// 获取所有符合要求的一级菜单
		$query = $this->db->query("SELECT * FROM fyp_rights AS A RIGHT JOIN (SELECT * FROM fyp_role_rights WHERE role_id = '$role_id' ) AS B ON A.id = B.right_id WHERE A.parent_id = '0' AND A.status = '1' ORDER BY A.idx ASC ");
		$mainMenues = $query->result_array();

        // var_dump($mainMenues);die;
		// 组合二级菜单
		$newDatas = array();
		foreach ($mainMenues as $key => $mainMenue) {
			$newDatas[$key] = $mainMenue;
			$id = $mainMenue['id'];
			$query = $this->db->query( "SELECT * FROM fyp_rights WHERE parent_id = $id" );
			$submenues = $query->result_array();
			$newDatas[$key]['submenues'] = $submenues;
		}
		// $roleRightsArr = array_column($mainMenues, 'right_id');

		return $newDatas;
	}
}