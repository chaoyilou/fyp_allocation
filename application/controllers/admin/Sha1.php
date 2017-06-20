<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Sha1 extends CI_Controller
{
	
	function __construct()
	{
	}

	public function show(){
		echo sha1( '123456' );
	}
}