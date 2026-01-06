<?php
defined("BASEPATH") or exit("no dericet script allowed"); 
class Import_csv_model extends CI_model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	 
}


?>