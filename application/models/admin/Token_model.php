<?php 
class Token_model extends CI_Model
{
	
	function __construct()
	{
		
	}

	public function new_token(){
		$token = 'van'.rand( 10000, 99999 );
		return $token;
	}
	public function update_token( $usrename, $password, $token ){
		// echo $usrename, $password, $token;
		$data = array( 'token' => $token );
		$where = array( 'nick_name' => $usrename, 'password' => sha1( $password ) );
        $res = $this->db->update( 'operator', $data, $where );
        return $res;
	}

	public function checktoken( $session ){
		$usrename = $session['username'];
		$token = $session['token'];
		$time = $session['time'];
		$role_id = $session['role_id'];
        $token_time = strtotime($time);
		$time_now = time();

		$res = $this->db->where( array( 'nick_name' => $usrename, 'role_id' => $role_id ) )->get( 'operator' )->row_array();
        $newtoken = $res['token'];
        // print_r(($time_now - 7000) < $token_time);die;
		if( ($time_now - 86400 * 2) > $token_time || $newtoken != $token ){
             redirect('admin/login');
		}
	}
}