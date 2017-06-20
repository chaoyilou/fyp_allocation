<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

/**
*	web端课程列表model
*/

class Meetings_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}


	public function appointment_submisson( $data ){
		$this->db->insert( 'student_meetings', $data );
		return true;
	}
}