<?php 
defined("BASEPATH") or exit('no direct script allowed');
class Admin extends CI_controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin_login');	
		$this->load->model('admin_company_detail');
		$this->load->helper('url');	
	 	$this->load->library(array('form_validation','session'));
		require_once(APPPATH.'libraries/geoplugin.class.php');
		
	}
	
	public function index() {
		if (!empty($this->session->id) && $this->session->title == TITLE) {
			if ($this->session->otp_verified) {
				redirect(base_url('dashboard')); // Redirect to dashboard if OTP verified
			} else {
				$this->load->view('admin/index'); // Show the index view if OTP not verified
			}
		} else {
			$this->load->view('admin/index');// Redirect to main login page if session data is not valid
		}
	}
	
	
	public function login()
	{
	 	$data = $this->input->post();
		 $row=array();
			if(!empty($data['username']) && !empty($data['password']))	
	 		{
				$serial =  (SERVER_INFO == "LOCAL")?str_ireplace("SerialNumber ","",shell_exec(HARDDISK_SerialNumber)):base_url();
				 	 
				$checkserial_no = $this->admin_login->checkserial(trim($serial));
	 			if(!empty($checkserial_no))
				{
					
					$checksub = (CONFIGURATION == 0)?1:$this->admin_login->checkp($data);	
					
					if(!empty($checksub))
					{
						$checkdata = $this->admin_login->login($data);
						
						if(!empty($checkdata))	
						{
						
							$geoplugin = new geoPlugin();
							$geodata = $geoplugin->locate($this->input->post('ip_address'));
						
							$data = array(
							'user_id' 		 => $checkdata->user_id,
							'in_time'		 => date('Y-m-d H:i:s'),
							'ip'		 	 => $this->input->post('ip_address'),
							'browser'		 => $this->input->post('browser'),
							'version' 		 => $this->input->post('version'),
							'os' 			 => $this->input->post('os'),
							'city' 			 => $geodata["geoplugin_city"],
							'state' 		 => $geodata["geoplugin_region"],
							'country' 		 => $geodata["geoplugin_countryName"],
							'lng' 			 => $geodata["geoplugin_longitude"],
							'lat' 			 => $geodata["geoplugin_latitude"]
							);
				
							$insert_histroy= $this->admin_login->insert_loginistory($data);
							if($insert_histroy)
							{
								$company_detail = $this->admin_company_detail->s_select(); 
								$newdata = array(
										'username'  	=> $checkdata->log_uname,
										'admin_name'	=> $checkdata->user_name,
										'id' 			=> $checkdata->user_id,
										'usertype_id'  	=> $checkdata->usertype_id,
										'title' 		=> $company_detail[0]->s_name,
										'email'     	=> base_url(),
										'logged_in' 	=> $insert_histroy
								);
								$_SESSION['p_menu']	= '';
								$this->session->set_userdata($newdata);
							$row['res'] = "success";
							$row['id'] = $checkdata->user_id;
							$row['usertype_id'] = $checkdata->usertype_id;
                            $row['email'] = $checkdata->email;
							$row['username'] = $checkdata->user_name;

							}
							else
							{
								$row['res'] = "reject";
							}
					}
					else
					{
						$row['res'] = "invaild";
					}
					}
					else
					{
						$row['res'] = "reject";
						$row['amount'] = SUB_AMOUNT;
					}
			    }
				else
				{
					$data = array(
						'subcription_time' => 0 
					);
					$update_key = $this->admin_login->update_key($data);
				 	$row['res'] = "blank_no";
				 	$row['amount'] = FSUB_AMOUNT;
					
				}
	 		}
	 		else
			{
				$row['res'] = "blank";
	 		}
			echo json_encode($row);
	}

	
	public function send_mail()
	{
		$plan_amount = $this->input->post('plan_amount');
		$company_detail = $this->admin_company_detail->s_select(); 
		$checkrenew_key = $this->admin_login->checkrenew_key('');	
					
		if(empty($checkrenew_key))
		{
			$renew_key = md5(date('Y-m-d H:i:s').$company_detail[0]->s_name);
			$data = array(
						'renew_key' => $renew_key, 
						'key_genrate_time' => date('Y-m-d H:i:s')
						);
			
			$update_key = $this->admin_login->update_key($data);
			
					$config =& get_config();    
					$this->email->initialize($config);
					$this->email->from($this->config->item('from'), $company_detail[0]->s_name);
					$this->email->to($this->config->item('to')); 
					//$this->email->bcc($this->config->item('bcc'));
					$this->email->subject('Renew Key Request from '.$company_detail[0]->s_name);
					$this->email->message('Application URL.'.base_url().' <br> 
					Renew Key : '.$renew_key.'. <br> Valid for 24 hours.');  
				// send_key_msg($renew_key,base_url());
			 	var_dump($this->email->send()); 
		}
		echo 1;  
					
	}
	
	public function check_key()
	{
		$renew_key = $this->input->post('renew_key');
		$check_key = $this->admin_login->checkrenew_key($renew_key);	
		$row = array();
		if(!empty($check_key))
		{
			$serial =  (SERVER_INFO == "LOCAL")?str_ireplace("SerialNumber ","",shell_exec(HARDDISK_SerialNumber)):base_url();
		 	$update_key = $this->admin_login->update_subcription(1,trim($serial));
			$row['res'] = 1;
		}
		else
		{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	public function logout()
	{
		$data = array(
					 'out_time'		 => date('Y-m-d H:i:s'),
					 );
		$id = $this->session->id;
		 $insert_histroy= $this->admin_login->update_loginistory($id,$data);
					
		$this->session->sess_destroy();
		redirect(base_url()."");		
	}
}
?>