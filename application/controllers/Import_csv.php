<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Import_csv extends CI_controller{
	
	public function __construct(){
		parent:: __construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('Import_csv_model','csv');
		
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
				redirect(base_url());
        }
	}	
	
	public function index()
	{ 
		if( $this->session->id == 1 && $this->session->title == TITLE)
		{ 
			$this->load->model('admin_company_detail');	
			$data['company_detail'] = $this->admin_company_detail->s_select();	
			$this->load->model('admin_country_detail');
			$data['countrydata'] = $this->admin_country_detail->s_select();	
			$this->load->view('admin/import_csv',$data);
		}
		else
		{
			redirect(base_url().'');
		}			
	}
	public function checkfile()
	{
		//ignore_user_abort(true);
		set_time_limit(0);
		$row = array();
		if($_FILES['file']['name'] != "" )	
		{
			$path = './upload/csv/';
			$this->load->library('upload');
			$this->upload->initialize($this->set_upload_options('csvfile',$_FILES['file']['name'],$path));
			$this->upload->do_upload('file');
			$upload_image = $this->upload->data();
			$data['file_name']  = $upload_image['file_name'];
			if(!empty($data['file_name']))
			{
				$file = fopen($path.$data['file_name'], 'r');
				$fields = fgetcsv($file);
				if(count($fields)==19)
				{
					 
					while(($row = fgetcsv($file)) != false ) 
					{            
						if( $row != null )
						{ 
							if($row[10]=="69072300" || $row[10]=="69072200" || $row[10]=="69072100") 
							{
								$insert_data = array(
									"sb_no" 				=> $row[0],
									"sb_date" 				=> date("Y-m-d",strtotime($row[1])),
									"iec" 					=> $row[2],
									"export_name" 			=> $row[3],
									"consignee_name"		=> $row[4],
									"country_destination"   => $row[5],
									"port_of_discharge" 	=> $row[6],
									"invoice_ser_no" 		=> $row[7],
									"invoice_no"		 	=> $row[8],
									"item_no" 				=> $row[9],
									"ritc_code" 			=> $row[10],
									"item_des" 				=> $row[11],
									"qty" 					=> $row[12],
									"uqc" 					=> $row[13],
									"currency" 				=> $row[14],
									"fob" 					=> $row[15],
									"drawback" 				=> $row[17],
									"challan_no" 			=> $row[18] 
								); 
								 
								$rdata = $this->csv->insert_data($insert_data);
							}							
						}
					}
					fclose($file);
					$row['res'] = 1;
				}
				else
				{
					$row['res'] = 2;
				}
			}
			else
			{
				$row['res'] = 0;
			}
	 	}
		else
		{
			$row['res'] = 0;
		}
		
		echo json_encode($row);
		 
	}
	private function set_upload_options($newfilename,$filename,$path)
	{   
		//upload an image options
		$config = array();
		$extension = end(explode(".", $filename));
		$config['file_name'] = $newfilename.'.'.$extension;
		$config['upload_path'] = $path;
		$config['allowed_types'] = 'csv';
		$config['max_size']      = '10000';
		$config['overwrite']     = FALSE;

		return $config;
	}
}
?>