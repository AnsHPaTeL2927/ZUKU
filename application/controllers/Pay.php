<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
require_once(APPPATH."libraries/razorpay/razorpay-php/Razorpay.php");

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class Pay extends CI_controller
{
			public function __construct(){
				parent:: __construct();
				$this->load->helper('url');
				$this->load->library(array('form_validation','session','encrypt'));
				$this->load->model('admin_company_detail','com');
				$this->load->model('menu_model','menu');	
				$this->load->model('admin_login');	  
			}	
		
			public function index($amount)
			{
				$api = new Api(PAYMENT_KEY, PAYMENT_SECRET_KEY);
				
				$_SESSION['payable_amount'] = $amount;
				$subcription_data = $this->com->get_subcription_detail(0);
				$razorpayOrder = $api->order->create(array(
					'receipt'         => rand().($subcription_data->subcription_amt_id + 1),
					'amount'          => $_SESSION['payable_amount'] * 100, // 2000 rupees in paise
					'currency'        => 'INR',
					'payment_capture' => 1 // auto capture
				));

				 $amount = $razorpayOrder['amount'];

				$razorpayOrderId = $razorpayOrder['id'];
		
				$_SESSION['razorpay_order_id'] = $razorpayOrderId;
				 
				$data = $this->prepareData($amount,$razorpayOrderId);
			 
				$this->load->view('admin/rezorpay',array('data' => $data));	
				 
			}
			public function prepareData($amount,$razorpayOrderId)
			{
				$company_detail = $this->com->s_edit_select(1);
				$s_email = end(explode(",",$company_detail->s_email));
				$s_mobile = end(explode(",",$company_detail->s_mobile));
				$data = array(
					"key" => PAYMENT_KEY,
					"amount" => $amount,
					"name" => "Zuku Software PVT LTD.",
					"description" => "Export Application",
					"image" => "https://www.zuku.co.in/img/logo.png",
					"prefill" => array(
						"name"  => $company_detail->s_name,
						"email"  => $s_email,
						"contact" => $s_mobile,
					),
					"notes"  => array(
						"address"  => "zuku.co.in",
						"merchant_order_id" => rand(),
					),
					"theme"  => array(
						"color"  => "#F37254"
					),
					"order_id" => $razorpayOrderId,
				);
				return $data;
			}
			public function verify()
			{
				$success = true;
				$error = "payment_failed";
				if (empty($_POST['razorpay_payment_id']) === false) {
					$api = new Api(PAYMENT_KEY, PAYMENT_SECRET_KEY);
				try {
						$attributes = array(
							'razorpay_order_id' => $_SESSION['razorpay_order_id'],
							'razorpay_payment_id' => $_POST['razorpay_payment_id'],
							'razorpay_signature' => $_POST['razorpay_signature']
						);
						$api->utility->verifyPaymentSignature($attributes);
					} 
					catch(SignatureVerificationError $e) {
						$success = false;
						$error = 'Razorpay_Error : ' . $e->getMessage();
					}
				}
				if ($success === true) {
					/**
					* Call this function from where ever you want
					* to save save data before of after the payment
					*/
					$this->setRegistrationData(2);
					redirect(base_url().'pay/success');
				}
				else 
				{
					$this->setRegistrationData(1);
					redirect(base_url().'pay/paymentFailed/2');
				}
			}
			public function setRegistrationData($from)
			{
				$company_detail = $this->com->s_edit_select(1);
				$s_email 		= end(explode(",",$company_detail->s_email));
				$s_mobile 		= end(explode(",",$company_detail->s_mobile));
				$name 			= $company_detail->s_name;
				$email 			= $s_email;
				$contact 		= $s_mobile;
				$amount 		= $_SESSION['payable_amount'];
			 
					$registrationData = array(
						'razorpay_payment_id' => $_SESSION['razorpay_order_id'],
						'name' 		=> $name,
						'email' 	=> $email,
						'contact' 	=> $contact,
						'amount' 	=> $amount,
					);
					$savedata = $this->com->insert_subcription($registrationData);
					if($from == 2)
					{
					 	$serial 	=  (SERVER_INFO == "LOCAL")?str_ireplace("SerialNumber ","",shell_exec(HARDDISK_SerialNumber)):base_url();
						$update_key = $this->admin_login->update_subcription(1,trim($serial));
					}
			}
			public function success()
			{
				 
					if(!empty($this->session->id) && $this->session->title == TITLE)
					{
						echo "<script>alert('Your Subscription is done. Thank you. Welcome Back.')</script>";
						$checkdata['result'] 		= $this->admin_login->afetrlogin($this->session->id);
						$checkdata['company_detail'] = $this->admin_company_detail->s_select();	
						$checkdata['menu_data']		 = $this->menu->usermain_menu($this->session->usertype_id);	
				
						$this->load->view('admin/dashboard',$checkdata);
					}
					else
					{
						$data['msg'] 	= "Renew done. Please Login again.";
						$data['status'] = "1";
						$this->load->view('admin/index',$data);
					}
			}
			public function paymentFailed($from)
			{
				if($from == 1)
				{
					$this->setRegistrationData(1);
				}
				 
				if(!empty($this->session->id) && $this->session->title == TITLE)
				{
					echo "<script>alert('Payment Not Completed. Please try again.')</script>";
					$checkdata['result'] = $this->admin_login->afetrlogin($this->session->id);
					 
					$checkdata['company_detail'] 		= $this->admin_company_detail->s_select();	
					$checkdata['menu_data']				= $this->menu->usermain_menu($this->session->usertype_id);	
			 
					$this->load->view('admin/dashboard',$checkdata);
					 
				}
				else
				{
					$data['msg'] 	= "Payment Not Completed. Please try again.";
					$data['status'] = "0";
					$this->load->view('admin/index',$data);
				}
			 
			}
			
	
}
?>