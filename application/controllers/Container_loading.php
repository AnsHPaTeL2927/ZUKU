<?php 
class Container_loading extends CI_Controller 
{
	public function __construct()
	{
	/*call CodeIgniter's default Constructor*/
	parent::__construct();
	
	 /*load Model*/
	$this->load->library('image_lib', $config);
	
	$this->load->library('upload');
	$this->load->model('Container_loading_model','mode');
	$this->load->model('menu_model','menu');
	}
	
	public function index($id,$container_no)
    {    
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{	 
			 $this->load->model('Admin_pdf');
			 $this->load->model('admin_company_detail'); 
			 $this->load->model('admin_exportinvoice');
			 //$data['container_data'] 	= $this->mode->container_data();	 
			 $data['labeldata'] 		= $this->mode->labeldata($id,$container_no);	 
			  
			 $data['set_container']		= 	$this->Admin_pdf->container_data($id); 
			 //$data['export_container']	=	$this->Admin_exportinvoice->export_container_data($id);
			 $data['container_no']		= 	$container_no;
			 
			 $data['company_detail'] 	= 	$this->admin_company_detail->s_select();	
			 $data['menu_data']			= 	$this->menu->usermain_menu($this->session->usertype_id);	
			 $this->load->view('admin/container_loading',$data);
			  
		}
		else
		{
			redirect(base_url().'');
		}	
    }
	
	public function manage()
	{
	  $check_photo = $this->mode->check_terms_update($this->input->post('container_loading_id'));
	  
			$data = array(												
				//'export_loading_trn_id' => $this->input->post('pi_loading_plan_id'),
				'pi_loading_plan_id' => $this->input->post('pi_loading_plan_id'),
				'container_no'		 => $this->input->post('container_no'),
				'notes'   	   		 => $this->input->post('notes'),
				'status'   	   		 => 0
			);
		 
		$container_loading_id = $this->input->post('container_loading_id');
		 
			$n=0;
			foreach($this->input->post('document_master_id') as $document_master_id)
			{
						 
						if($n==0 && empty($container_loading_id))
						{
							$insert_id = $this->mode->insert_container_photos_mst($data);
						}
						else if($n==0)
						{
							$update_id = $this->mode->update_container_loading($data,$container_loading_id);
							$insert_id = $container_loading_id;
						}
						else if(!empty($container_loading_id))
						{
							$insert_id = $container_loading_id;
						}
				$file_type = $this->input->post('images_type')[$n];
				$images_data = $this->input->post('images_data')[$n];
					$files = $_FILES['upload_logo'.$document_master_id]['name'];
					  if(!empty($_FILES['upload_logo'.$document_master_id]['name'][0]))
					 {
						
					
						 $file = $_FILES['upload_logo'.$document_master_id]['name'];
						 $cpt = count($file);
						 	$images_name = array();
							//  Looping all files
							if($file_type == 1 && !empty($images_data))
							{
								$images_name = array();
								unlink('./upload/container_photos/'.$images_data);
								$delete_image_record = $this->mode->delete_photos($container_loading_id,$document_master_id);
								
							}	
							else if($file_type == 2)
							{
								$images_name = explode(",",$images_data);
								$delete_image_record = $this->mode->delete_photos($container_loading_id,$document_master_id);
							}
								
							for($i=0;$i<$cpt;$i++)
							{
								
							 	$_FILES['confile']['name']		= $_FILES['upload_logo'.$document_master_id]['name'][$i];
								$_FILES['confile']['type']		= $_FILES['upload_logo'.$document_master_id]['type'][$i];
								$_FILES['confile']['tmp_name']	= $_FILES['upload_logo'.$document_master_id]['tmp_name'][$i];
								$_FILES['confile']['error']		= $_FILES['upload_logo'.$document_master_id]['error'][$i];
								$_FILES['confile']['size']		= $_FILES['upload_logo'.$document_master_id]['size'][$i];    
										 
									$this->upload->initialize($this->set_upload_options($this->input->post('container_no').$document_master_id.'_',$_FILES['confile']['name']));
								 	$this->upload->do_upload('confile');
									$upload_image = $this->upload->data();
									array_push($images_name,$upload_image['file_name']);
						 	}
							$data1 = array (												
									'container_loading_id' 				=> $insert_id,
									'document_master_id' 				=> $document_master_id,
									'label_name' 						=> '',
									'upload_logo' 						=> implode(",",array_filter($images_name))
							);
								
									$insertid1 = $this->mode->insert_container_photos_trn($data1);
					 }
				$n++;
			}	
			 
				 if($insert_id)
				 {
				 	$row['res'] = 1;
				 }
				 else if($update_id)
				 {
					 $row['res'] = 2;
				 }
				 else
				 {
				 	$row['res'] = 0;
				 }
			 
		 
		echo json_encode($row);
	}
	
	
	private function set_upload_options($newfilename,$filename)
	{   
	 
		//upload an image options
		$config = array();
		$extension = end(explode(".", $filename));
		$config['file_name'] 		= $newfilename.rand(0,9999).'.'.$extension;
		$config['upload_path'] 		= './upload/container_photos/';
		$config['allowed_types'] 	= 'gif|jpg|jpeg|png|pdf|jfif|mp4';
		$config['max_size']      	= '8000';
		$config['overwrite']     	= FALSE;
	 
		return $config;
	}

				
	public function getdata()
	{
		$id=$this->input->post('id');
		$data = $this->mode->get_data($id);
	 	echo json_encode($data);
	}
	
	public function download($upload_logo = NULL) 
	{
		// load download helder
		$this->load->helper('download');
		// read file contents
		$data = file_get_contents(base_url('./upload/container_photos/'.$upload_logo));
		force_download($upload_logo, $data);
	}
	
	public function delete_image()
	{
		$container_photos_id = $this->input->post('id');
		$image_name = $this->input->post('image_name');
		
	 	
		$resultdata = $this->mode->fetchimagedata($container_photos_id);
		unlink('upload/container_photos/'.$image_name);
		
		$images_array = explode(",",$resultdata->upload_logo);
		if(in_array($image_name,$images_array))
		{
			$key = array_search($image_name,$images_array);
			 unset($images_array[$key]);
		}
		 
			if(!empty($images_array))
			{				
				$updatedid = $this->mode->update_photos($container_photos_id,$images_array);
			}
			else
			{
				$updatedid = $this->mode->delete_photosdata($container_photos_id);
			}
		if($updatedid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	
	function view_pdf()
	{
		$this->load->view('admin/containerloadingpdf');
	}
	
	function view_pdf1() {
		// Increase memory limit and execution time
		ini_set('memory_limit', '2048M');
		ini_set('max_execution_time', 300); // Increase max execution time (300 seconds)

		// Load the PDF and session library
		$this->load->library('pdf');
		$this->load->library('session'); 

		// Enable error reporting temporarily for debugging
		ini_set('log_errors', 1);
		ini_set('display_errors', 1); // Set to 1 for now, change to 0 for production
		error_reporting(E_ALL);

		// Clear output buffer before starting PDF generation
		if (ob_get_contents()) {
			ob_end_clean();
		}

		// Check if session data exists before generating the PDF
		$container_loading_content = $this->session->userdata('container_loading_content');
		if (!$container_loading_content) {
			show_error('No content found in session for PDF generation.');
			return;
		}

		// HTML content with embedded font-face
		$html = '
		<head>
			<title>' . $_SESSION['invoice_no'] . '</title>
			<style>
			   @page {
					size: A4;
					margin-top: 0px; /* Remove top margin */
					margin-bottom: 0px;
					margin-left: 20px;
					margin-right: 20px;
				}
				body {
					margin: 0;
					padding: 0;
				}
			   
				@font-face {
					font-family: "calibri";
					src: url("' . base_url('assets/fonts/calibri.ttf') . '") format("truetype");
					font-weight: normal;
					font-style: normal;
				}

				table {
					width: 100%;
					border-collapse: collapse;
					font-family: "calibri", sans-serif;
					border: 0.5px solid #333;
					font-size: 8px;
				}
			   td, th {
					border: 0.5px solid #333;
					padding: 2px;
					word-wrap: break-word; 
				}
				.save_invoice_html {  border: 0.5px solid #333; }
			</style>
		</head>
		<body>
			' . $container_loading_content . '
		</body>';
		
	   //$html_with_new_margin = preg_replace('/margin-top:\s*80px;?/i', '/margin-top:\s*0px;?/i', $html);
	   //echo $html_with_new_margin; exit;
		// Create a new instance of DomPDF and configure custom font directory
		$dompdf = new Dompdf\Dompdf();
		$options = $dompdf->getOptions();
		$options->set('isHtml5ParserEnabled', true);
		$options->set('isRemoteEnabled', true); // Enable remote access for font

		// Correctly set the font directory as a string (not an array)
		$fontDir = realpath('./assets/fonts');
		$fontCache = realpath('./assets/fonts');

		$options->set('fontDir', $fontDir);  // Set as string
		$options->set('fontCache', $fontCache);  // Set as string

		// $options->set('margin_top', 0);
		// $options->set('margin_right', 0);
		// $options->set('margin_bottom', 0);
		// $options->set('margin_left', 0);

		$dompdf->setOptions($options);

		// Load the HTML content into DomPDF
		$dompdf->loadHtml($html);

		// Set paper size and orientation
		$dompdf->setPaper('A4', 'portrait');

		// Render the PDF
		$dompdf->render();

		// Stream the generated PDF file for download
		$dompdf->stream($_SESSION['invoice_no'] . ".pdf", array("Attachment" => 1));
	}

	

}
?>