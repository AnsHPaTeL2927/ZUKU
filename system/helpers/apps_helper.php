<?php
			$url = 'http://api.zuku.co.in/zuku_config_api/';
			$ch = curl_init($url);
			$headers = array(
				'Content-Type:application/json',
				'Authorization: Basic enVrdWFkbWluOnp1a3VAMjAyMQ==' // <---
			);
			curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			
			$result = curl_exec($ch);
			 
			curl_close($ch);
			$data = json_decode($result);
		  
define('CONFIGURATION','365');

//Harddisk Detail 
define("HARDDISK_SerialNumber",$data->harddisk_no);
define("SERVER_INFO",'LOCAL');
// SMTP setting 
$config['protocol']    		= 'smtp';
$config['smtp_host']    	= $data->smtp_host;
$config['smtp_port']    	= $data->smtp_port;
$config['smtp_timeout'] 	= $data->smtp_timeout;
$config['smtp_user']   	 	= $data->smtp_user;
$config['smtp_pass']   		= $data->smtp_pass;
$config['charset']    		= 'utf-8';
$config['newline']   	 	= "\r\n";
$config['mailtype'] 		= 'html';  
$config['from'] 			= $data->from_email;
$config['to'] 				= $data->to_email;
$config['bcc'] 				= $data->bcc_email;
 
 
 //Razorpay Detail
 define("PAYMENT_KEY",$data->payment_key);
 define("PAYMENT_SECRET_KEY",$data->payment_secret_key);
 define("PAYMENT_CURRENCY",$data->payment_curreny);
 define("FSUB_AMOUNT",$data->first_amt);
 define("SUB_AMOUNT",$data->sub_amt);
 define("ZUKUFILES",$data->files);
 
 //SMS NO
  define("SMS_TO",$data->sms_to);
 