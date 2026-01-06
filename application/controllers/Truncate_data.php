<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Truncate_data extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('settingmodel','setting');
		$this->load->model('menu_model','menu');	
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) 
		{
			redirect(base_url());
        }
	}
	public function index()
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			if(!isset($_SESSION['updatedinsetting']))
			{
				$_SESSION['updatedinsetting'] = 0;
			}
			$resultdata['result'] = $this->setting->afetrlogin($this->session->id);
			$resultdata['setting_data'] = $this->setting->setting_data(1);
			$resultdata['warner_data'] = $this->setting->warner_data(1);
		 	$resultdata['invoicetypedata'] = $this->setting->fecth();
			$this->load->model('admin_company_detail');	
			$resultdata['company_detail'] 	= $this->admin_company_detail->s_select();	
			$resultdata['menu_data']	 	= $this->menu->usermain_menu($this->session->usertype_id);	
		 	$this->load->view('admin/truncate_data',$resultdata);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	public  function drop_all()
	{
		$files = array_values(array_diff(scandir(FCPATH.'/upload/'), array('.', '..'))); 
		 
		 for($x = 0; $x < count($files); $x++)
		 {
			if (!is_dir($files[$x]))
			{
				unlink(FCPATH.'/upload/'.$files[$x]);
			}					
		}	
		$agreement_doc = array_values(array_diff(scandir(FCPATH.'/upload/agreement_doc/'), array('.', '..'))); 
		 
		 for($x = 0; $x < count($agreement_doc); $x++)
		 {
		 	if (!is_dir($agreement_doc[$x]))
			{
				unlink(FCPATH.'/upload/agreement_doc/'.$agreement_doc[$x]);
			}					
		}
		$bl_upload = array_values(array_diff(scandir(FCPATH.'/upload/bl_upload/'), array('.', '..'))); 
		 
		 for($x = 0; $x < count($bl_upload); $x++)
		 {
			if (!is_dir($bl_upload[$x]))
			{
				unlink(FCPATH.'/upload/bl_upload/'.$bl_upload[$x]);
			}					
		}		
		$box_design = array_values(array_diff(scandir(FCPATH.'/upload/box_design/'), array('.', '..'))); 
		 
		 for($x = 0; $x < count($box_design); $x++)
		 {
			if (!is_dir($box_design[$x]))
			{
				unlink(FCPATH.'/upload/box_design/'.$box_design[$x]);
			}					
		}	
		 
		 $company_doc = array_values(array_diff(scandir(FCPATH.'/upload/company_doc/'), array('.', '..'))); 
		 
		 for($x = 0; $x < count($company_doc); $x++)
		 {
			if (!is_dir($company_doc[$x]))
			{
				unlink(FCPATH.'/upload/company_doc/'.$company_doc[$x]);
			}					
		}	
		$container_photos = array_values(array_diff(scandir(FCPATH.'/upload/container_photos/'), array('.', '..'))); 
		 
		 for($x = 0; $x < count($container_photos); $x++)
		 {
			if (!is_dir($container_photos[$x]))
			{
				unlink(FCPATH.'/upload/container_photos/'.$container_photos[$x]);
			}					
		 }
		 $customer_document = array_values(array_diff(scandir(FCPATH.'/upload/customer_document/'), array('.', '..'))); 		 
		 for($x = 0; $x < count($customer_document); $x++)
		 {
			if (!is_dir($customer_document[$x]))
			{
				unlink(FCPATH.'/upload/customer_document/'.$customer_document[$x]);
			}					
		 }
		
		$database = array_values(array_diff(scandir(FCPATH.'/upload/database/'), array('.', '..'))); 		 
		 for($x = 0; $x < count($database); $x++)
		 {
			if (!is_dir($database[$x]))
			{
				unlink(FCPATH.'/upload/database/'.$database[$x]);
			}					
		 }		

		 $design = array_values(array_diff(scandir(FCPATH.'/upload/design/'), array('.', '..'))); 		 
		 for($x = 0; $x < count($design); $x++)
		 {
			if (!is_dir($design[$x]))
			{
				unlink(FCPATH.'/upload/design/'.$design[$x]);
			}					
		 }	
		
		 $document_master = array_values(array_diff(scandir(FCPATH.'/upload/document_master/'), array('.', '..'))); 		 
		 for($x = 0; $x < count($document_master); $x++)
		 {
			if (!is_dir($document_master[$x]))
			{
				unlink(FCPATH.'/upload/document_master/'.$document_master[$x]);
			}					
		 }	
			
		 $help_file = array_values(array_diff(scandir(FCPATH.'/upload/help_file/'), array('.', '..'))); 		 
		 for($x = 0; $x < count($help_file); $x++)
		 {
			if (!is_dir($help_file[$x]))
			{
				unlink(FCPATH.'/upload/help_file/'.$help_file[$x]);
			}					
		 }	
			
		 $payment = array_values(array_diff(scandir(FCPATH.'/upload/payment/'), array('.', '..'))); 		 
		 for($x = 0; $x < count($payment); $x++)
		 {
			if (!is_dir($payment[$x]))
			{
				unlink(FCPATH.'/upload/payment/'.$payment[$x]);
			}					
		 }	
		 
		 $qc_image = array_values(array_diff(scandir(FCPATH.'/upload/qc_image/'), array('.', '..'))); 		 
		 for($x = 0; $x < count($qc_image); $x++)
		 {
			if (!is_dir($qc_image[$x]))
			{
				unlink(FCPATH.'/upload/qc_image/'.$qc_image[$x]);
			}					
		 }
		 
		 $quotation = array_values(array_diff(scandir(FCPATH.'/upload/quotation/'), array('.', '..'))); 		 
		 for($x = 0; $x < count($quotation); $x++)
		 {
			if (!is_dir($quotation[$x]))
			{
				unlink(FCPATH.'/upload/quotation/'.$quotation[$x]);
			}					
		 }
		 
		 $shipping_bill = array_values(array_diff(scandir(FCPATH.'/upload/shipping_bill/'), array('.', '..'))); 		 
		 for($x = 0; $x < count($shipping_bill); $x++)
		 {
			if (!is_dir($shipping_bill[$x]))
			{
				unlink(FCPATH.'/upload/shipping_bill/'.$shipping_bill[$x]);
			}					
		 }
		 
		 $shipping_logo = array_values(array_diff(scandir(FCPATH.'/upload/shipping_logo/'), array('.', '..'))); 		 
		 for($x = 0; $x < count($shipping_logo); $x++)
		 {
			if (!is_dir($shipping_logo[$x]))
			{
				unlink(FCPATH.'/upload/shipping_logo/'.$shipping_logo[$x]);
			}					
		 }
		 
		 $supplier_api = array_values(array_diff(scandir(FCPATH.'/upload/supplier_api/'), array('.', '..'))); 		 
		 for($x = 0; $x < count($supplier_api); $x++)
		 {
			if (!is_dir($supplier_api[$x]))
			{
				unlink(FCPATH.'/upload/supplier_api/'.$supplier_api[$x]);
			}					
		 } 
		 
		 $user = array_values(array_diff(scandir(FCPATH.'/upload/user/'), array('.', '..'))); 		 
		 for($x = 0; $x < count($user); $x++)
		 {
			if (!is_dir($user[$x]))
			{
				unlink(FCPATH.'/upload/user/'.$user[$x]);
			}					
		 } 
	}
	public  function manage()
	{
		$data = array(
			"invoice_type" 		=> $this->input->post('invoice_type'),
			"invoice_series" 	=> $this->input->post('invoice_series'),
			"invoice_format" 	=> $this->input->post('invoice_format'),
			"formate_value" 	=> $this->input->post('formate_value'), 
			"with_date" 		=> implode(",",$this->input->post('with_date')), 
			"separate_by" 		=> $this->input->post('separate_by'), 
			"with_date_sq" 		=> 0, 
			"date_palce" 		=> $this->input->post('date_palce'), 
			"final_formate" 	=> $this->input->post('final_formate'), 
			"cdate" 			=> date('Y-m-d H:i:s'), 
			"status" 			=> 0
		);
		$row['res'] = '';
		if($this->input->post('mode')=="add")
		{
			$rdata = $this->setting->insert($data);
			if($rdata)
			{
				$row['res'] = '1';
			}
			else
			{
				$row['res'] = '0';
			 
			}
		}
		else if($this->input->post('mode')=="edit"){
			$invoice_type_id = $this->input->post('invoice_type_id');
			$updatedata = $this->setting->update($data,$invoice_type_id);
			if($updatedata)
			{
				$row['res'] = '1';
			}
			else
			{
				$row['res'] = '0';
			 
			}
			echo json_encode($row);
		}
	}
	public  function warner_api()
	{
		$data = array(
			"api_key" 				=> $this->input->post('api_key'),
			"latitude" 				=> $this->input->post('latitude'),
			"longitude" 			=> $this->input->post('longitude'),
			"warner_company_id" 	=> $this->input->post('company_id'), 
			"customer_id" 			=> $this->input->post('customer_id'), 
			"enter_by" 				=> $this->input->post('enter_by'), 
			"ebn_enter_type" 	 	=> $this->input->post('ebn_enter_type'), 
		 	"status" 				=> 0
		);
		$row['res'] = '';
		 $_SESSION['updatedinsetting'] = 3;
			$company_id = 1;
			$updatedata = $this->setting->update_warner($data,$company_id);
			if($updatedata)
			{
				echo "<script>alert('Data Updated Successfully');window.location='".base_url()."setting'</script>";
			}
			else
			{
				echo "<script>alert('Something is wrong');window.location='".base_url()."setting'</script>";
			 
			}
			echo json_encode($row);
		 
	}
 	public function selectinvoicetype()
	{
	 
		$id = $this->input->post('eid');
		$resultdata = $this->setting->singlerecord($id);
		echo json_encode($resultdata);
	}
	public function updatedefaultprice()
	{
		 
		$psize 					= $this->input->post('psize');
		$usd 					= $this->input->post('usd');
		$euro 					= $this->input->post('euro');
		$gbp 					= $this->input->post('gbp');
		$notification_text 		= $this->input->post('notification_text');
		$fob_charges 			= $this->input->post('fob_charges');
		$pallet_charges 		= $this->input->post('pallet_charges');
		$big_pallet_charge 		= $this->input->post('big_pallet_charge');
		$small_pallet_charges 	= $this->input->post('small_pallet_charges');
		$id 					= $_SESSION['id'];
		$updateid = $this->setting->updateprice($usd,$euro,$id,$psize,$notification_text,$gbp,$fob_charges,$pallet_charges,$big_pallet_charge,$small_pallet_charges,$this->input->post('exchange_rate_btn'));
			if($updateid)
			{
			
				$_SESSION['updatedinsetting'] = ($this->input->post('exchange_rate_btn') == 1)?1:2;
					 
		 	echo "<script>alert('Data Updated Successfully');window.location='".base_url()."setting'</script>";
			}
			else
			{
				echo "<script>alert('Something is wrong');window.location='".base_url()."setting'</script>";
			 
			}
	}
	public function updatepacking_fields()
	{
		$no = 0;
		foreach($this->input->post('update_with') as $updatewith)
		{
			$fields_data = array(
				"defualt_show_status" => (!empty($this->input->post('print_fileds'.$updatewith)))?"1":"0",
				"packing_fields_for" => 1,
			 );
			
			$updateid = $this->setting->update_packing_fields($fields_data,$updatewith);
			 $no++;
		}
		 
		 
		 $_SESSION['updatedinsetting'] = 3;
		echo "<script>alert('Data Updated Successfully');window.location='".base_url()."setting'</script>";
			 
	}
	public function remove_data()
	{
		$backup_database = $this->database_backup($which);
		$which = $this->input->post('which');
		$truncate_all = $this->setting->truncate_all($which);
		 
		echo "1";
			 
	}
	public function database_backup($which)
	{
		$get_all_table = $this->setting->get_table();	
		$target_tables = array();
		
		foreach($get_all_table as $tablerow)
		{
			$name = 'Tables_in_'.$this->db->database;
			array_push($target_tables,$tablerow->$name);
		}
		 
	 	$tables=false;
		if($tables !== false) { $target_tables = array_intersect( $target_tables, $tables); }
		$content = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n \r\n\r\n\r\n";
		 
	 	foreach($target_tables as $table)
		{
		 	$result	= $this->setting->from_table($table); 
			
			$fields_amount=$result['fieldcount'];  
			$rows_num=$result['affectedrows']; 
			$res = $this->setting->create_table($table);
			
			$TableMLine=$res[0];
			$content .= "\n\n DROP TABLE IF EXISTS ".$table.";\n\n";
			$content .= "\n\n".$TableMLine["Create Table"].";\n\n";
			$st_counter = 0;
			 
				foreach($result['resultrow'] as $allrow)
				{ 			
					$row = array_values($allrow);  
					 	if ($st_counter%100 == 0 || $st_counter == 0 )
						{
							$content .= "\nINSERT INTO ".$table." VALUES";
						}
						$content .= "\n(";
					 	for($j=0; $j<$fields_amount; $j++)  
						{
							$row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); if (isset($row[$j])){$content .= '"'.$row[$j].'"' ; }else {$content .= '""';}	   if ($j<($fields_amount-1)){$content.= ',';}		
						}
						$content .=")";
						if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) 
						{
							$content .= ";";
						} 
						else 
						{ 
							$content .= ",";
						}	
						$st_counter=$st_counter+1;
				}
			   $content .="\n\n\n";
		}
		
	 	$content .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
		
		 
		$backup_name =   "backup".$which.".sql";
		/**Code for backup record add*/
		 
		/**Code for backup record add*/
		 
		//header('Content-Type: application/octet-stream');	
		//header("Content-Transfer-Encoding: Binary"); 
		//header("Content-disposition: attachment; filename=\"".$backup_name."\"");
		file_put_contents('upload/database/'.$backup_name,$content); 
		return 1;
	 
	}
	public function use_onoff()
	{
		$checked=$this->input->post('value');
		$control=$this->input->post('control');
		$deleteid=$this->setting->update_onoff($checked,$control);
		if($deleteid)
		{
			$row['res'] = 1;
			$_SESSION['updatedinsetting'] = 4;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
}



?>