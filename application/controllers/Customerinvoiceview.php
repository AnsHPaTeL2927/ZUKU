<?php

defined("BASEPATH") or exit("no dericet script allowed"); 



class Customerinvoiceview extends CI_controller

{

	

	function __construct()

	{

		parent::__construct();

	 	$this->load->model('Customer_invoice_model','custinvoice');

		$this->load->model('menu_model','menu');	

		$this->load->model('admin_exportinvoice_product');

		$this->load->model('admin_exportinvoice','exportinvoice');

		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {

			redirect(base_url());

        }

	}



	function index($id)

	{

		if(!empty($this->session->id)  && $this->session->title == TITLE)

		{

				$data					= $this->custinvoice->get_invoice_data($id);

			 	$array 					= explode("-",$data->export_invoice_id);

				$loading_trn 			= $this->admin_exportinvoice_product->getinvoice_cust_data($array,1,$data->consiger_id);

			 	$sample_data			= $this->admin_exportinvoice_product->getinvoicesampleproductdata(implode(",",$array),1);

				$html_data				= $this->custinvoice->get_invoice_html($id);

				$packing_html_data		= $this->custinvoice->packing_html_data($id);

		 	 	$this->load->model('admin_company_detail');

		 	 	//$this->load->model('User_model');

				$userdata 				= $this->custinvoice->ciadmin_login();

				$menu_data 				= $this->menu->usermain_menu($this->session->usertype_id);	

				$export_supplier_data 	= $this->admin_exportinvoice_product->get_export_supplier($id);			

			  	$v = array(

					'invoicedata'			=> $data,

					'product_data'			=> $loading_trn,

					'invoice_html_data'		=> $html_data,

					'packing_html_data'		=> $packing_html_data,

					'sample_data'			=> $sample_data,

					'direct_invoice' 		=> $data->direct_invoice,  

					'menu_data'				=> $menu_data,

				 	'company_detail'		=> $this->admin_company_detail->s_select(),

				 //	'userfetchdata'			=> $this->User_model->get_user_list(),

					'export_supplier_data'	=> $export_supplier_data,

				 	'userdata'				=> $userdata,

				 	'mode'					=> "0" 

				 );

				$this->load->view('admin/customerinvoiceview',$v); 

		}

			else

			{

				redirect(base_url().'');

			}

	}

		function index_cif($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
				$data					= $this->custinvoice->get_invoice_data($id);
			 	$array 					= explode("-",$data->export_invoice_id);
				$loading_trn 			= $this->admin_exportinvoice_product->getinvoice_cust_data($array,1,$data->consiger_id);
			 	$sample_data			= $this->admin_exportinvoice_product->getinvoicesampleproductdata(implode(",",$array),1);
				$html_data				= $this->custinvoice->get_invoice_html($id);
				$packing_html_data		= $this->custinvoice->packing_html_data($id);
		 	 	$this->load->model('admin_company_detail');
				$userdata 				= $this->custinvoice->ciadmin_login();
				$menu_data 				= $this->menu->usermain_menu($this->session->usertype_id);	
				$export_supplier_data 	= $this->admin_exportinvoice_product->get_export_supplier($id);			
			  	$v = array(
					'invoicedata'			=> $data,
					'product_data'			=> $loading_trn,
					'invoice_html_data'		=> $html_data,
					'packing_html_data'		=> $packing_html_data,
					'sample_data'			=> $sample_data,
					'direct_invoice' 		=> $data->direct_invoice,  
					'menu_data'				=> $menu_data,
				 	'company_detail'		=> $this->admin_company_detail->s_select(),
					'export_supplier_data'	=> $export_supplier_data,
				 	'userdata'				=> $userdata,
				 	'mode'					=> "0" 
				 );
				$this->load->view('admin/customerinvoiceview_cif',$v); 
		}
			else
			{
				redirect(base_url().'');
			}
	}
	
	function index_cif_sign($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
				$data					= $this->custinvoice->get_invoice_data($id);
			 	$array 					= explode("-",$data->export_invoice_id);
				$loading_trn 			= $this->admin_exportinvoice_product->getinvoice_cust_data($array,1,$data->consiger_id);
			 	$sample_data			= $this->admin_exportinvoice_product->getinvoicesampleproductdata(implode(",",$array),1);
				$html_data				= $this->custinvoice->get_invoice_html($id);
				$packing_html_data		= $this->custinvoice->packing_html_data($id);
		 	 	$this->load->model('admin_company_detail');
				$userdata 				= $this->custinvoice->ciadmin_login();
				$menu_data 				= $this->menu->usermain_menu($this->session->usertype_id);	
				$export_supplier_data 	= $this->admin_exportinvoice_product->get_export_supplier($id);			
			  	$v = array(
					'invoicedata'			=> $data,
					'product_data'			=> $loading_trn,
					'invoice_html_data'		=> $html_data,
					'packing_html_data'		=> $packing_html_data,
					'sample_data'			=> $sample_data,
					'direct_invoice' 		=> $data->direct_invoice,  
					'menu_data'				=> $menu_data,
				 	'company_detail'		=> $this->admin_company_detail->s_select(),
					'export_supplier_data'	=> $export_supplier_data,
				 	'userdata'				=> $userdata,
				 	'mode'					=> "0" 
				 );
				$this->load->view('admin/customerinvoiceview_cif_sign',$v); 
		}
			else
			{
				redirect(base_url().'');
			}
	}
	
	

	function batch_shade($id)

	{

		if(!empty($this->session->id)  && $this->session->title == TITLE)

		{

				$data					= $this->custinvoice->get_invoice_data($id);

			 	$array 					= explode("-",$data->export_invoice_id);

				$loading_trn 			= $this->admin_exportinvoice_product->getinvoice_cust_data($array,1,$data->consiger_id);

			 	$sample_data			= $this->admin_exportinvoice_product->getinvoicesampleproductdata(implode(",",$array),1);

				$html_data				= $this->custinvoice->get_invoice_html($id);

				$packing_html_data		= $this->custinvoice->packing_html_data($id);

		 	 	$this->load->model('admin_company_detail');

				$userdata 				= $this->custinvoice->ciadmin_login();

				$menu_data 				= $this->menu->usermain_menu($this->session->usertype_id);	

				$export_supplier_data 	= $this->admin_exportinvoice_product->get_export_supplier($id);			

			  	$v = array(

					'invoicedata'			=> $data,

					'product_data'			=> $loading_trn,

					'invoice_html_data'		=> $html_data,

					'packing_html_data'		=> $packing_html_data,

					'sample_data'			=> $sample_data,

					'direct_invoice' 		=> $data->direct_invoice,  

					'menu_data'				=> $menu_data,

				 	'company_detail'		=> $this->admin_company_detail->s_select(),

					'export_supplier_data'	=> $export_supplier_data,

				 	'userdata'				=> $userdata,

				 	'mode'					=> "0" 

				 );

				$this->load->view('admin/customerinvoiceview_batch_shade',$v); 

		}

			else

			{

				redirect(base_url().'');

			}

	}

	

	function index2($id)

	{

		if(!empty($this->session->id)  && $this->session->title == TITLE)

		{

				$data					= $this->custinvoice->get_invoice_data($id);

			 	$array 					= explode("-",$data->export_invoice_id);

				$loading_trn 			= $this->admin_exportinvoice_product->getinvoice_cust_data($array,1,$data->consiger_id);

			 	$sample_data			= $this->admin_exportinvoice_product->getinvoicesampleproductdata(implode(",",$array),1);

				$html_data				= $this->custinvoice->get_invoice_html($id);

				$packing_html_data		= $this->custinvoice->packing_html_data($id);

		 	 	$this->load->model('admin_company_detail');

				$userdata 				= $this->custinvoice->ciadmin_login();

				$menu_data 				= $this->menu->usermain_menu($this->session->usertype_id);	

				$export_supplier_data 	= $this->admin_exportinvoice_product->get_export_supplier($id);			

			  	$v = array(

					'invoicedata'			=> $data,

					'product_data'			=> $loading_trn,

					'invoice_html_data'		=> $html_data,

					'packing_html_data'		=> $packing_html_data,

					'sample_data'			=> $sample_data,

					'direct_invoice' 		=> $data->direct_invoice,  

					'menu_data'				=> $menu_data,

				 	'company_detail'		=> $this->admin_company_detail->s_select(),

					'export_supplier_data'	=> $export_supplier_data,

				 	'userdata'				=> $userdata,

				 	'mode'					=> "0" 

				 );

				$this->load->view('admin/customerinvoiceview_nohsn',$v); 

		}

			else

			{

				redirect(base_url().'');

			}

	}

	function other_product($id)

	{

		if(!empty($this->session->id)  && $this->session->title == TITLE)

		{

				$data					= $this->custinvoice->get_invoice_data($id);

			 	$array 					= explode("-",$data->export_invoice_id);

				$loading_trn 			= $this->admin_exportinvoice_product->getinvoice_cust_data($array,1,$data->consiger_id);

			 	$sample_data			= $this->admin_exportinvoice_product->getinvoicesampleproductdata(implode(",",$array),1);

				$html_data				= $this->custinvoice->get_invoice_html($id);

				$packing_html_data		= $this->custinvoice->packing_html_data($id);

		 	 	$this->load->model('admin_company_detail');

				$userdata 				= $this->custinvoice->ciadmin_login();

				$menu_data 				= $this->menu->usermain_menu($this->session->usertype_id);	

				$export_supplier_data 	= $this->admin_exportinvoice_product->get_export_supplier($id);			

			  	$v = array(

					'invoicedata'			=> $data,

					'product_data'			=> $loading_trn,

					'invoice_html_data'		=> $html_data,

					'packing_html_data'		=> $packing_html_data,

					'sample_data'			=> $sample_data,

					'direct_invoice' 		=> $data->direct_invoice,  

					'menu_data'				=> $menu_data,

				 	'company_detail'		=> $this->admin_company_detail->s_select(),

					'export_supplier_data'	=> $export_supplier_data,

				 	'userdata'				=> $userdata,

				 	'mode'					=> "0" 

				 );

				$this->load->view('admin/customerinvoice_other_product',$v); 

		}

			else

			{

				redirect(base_url().'');

			}

	}

	function dubai($id)

	{

		if(!empty($this->session->id)  && $this->session->title == TITLE)

		{

				$data					= $this->custinvoice->get_invoice_data($id);

			 	$array 					= explode("-",$data->export_invoice_id);

				$loading_trn 			= $this->admin_exportinvoice_product->getinvoice_cust_data($array,1,$data->consiger_id);

			 	$sample_data			= $this->admin_exportinvoice_product->getinvoicesampleproductdata(implode(",",$array),1);

				$html_data				= $this->custinvoice->get_invoice_html($id);

				$packing_html_data		= $this->custinvoice->packing_html_data($id);

		 	 	$this->load->model('admin_company_detail');

				$userdata 				= $this->custinvoice->ciadmin_login();

				$menu_data 				= $this->menu->usermain_menu($this->session->usertype_id);	

				$export_supplier_data 	= $this->admin_exportinvoice_product->get_export_supplier($id);			

			  	$v = array(

					'invoicedata'			=> $data,

					'product_data'			=> $loading_trn,

					'invoice_html_data'		=> $html_data,

					'packing_html_data'		=> $packing_html_data,

					'sample_data'			=> $sample_data,

					'direct_invoice' 		=> $data->direct_invoice,  

					'menu_data'				=> $menu_data,

				 	'company_detail'		=> $this->admin_company_detail->s_select(),

					'export_supplier_data'	=> $export_supplier_data,

				 	'userdata'				=> $userdata,

				 	'mode'					=> "0" 

				 );

				$this->load->view('admin/customerinvoicedubaiview',$v); 

		}

			else

			{

				redirect(base_url().'');

			}

	}

	function index_small($id)

	{

		if(!empty($this->session->id)  && $this->session->title == TITLE)

		{

				$data					= $this->custinvoice->get_invoice_data($id);

			 	$array 					= explode("-",$data->export_invoice_id);

				$loading_trn 			= $this->admin_exportinvoice_product->getinvoice_cust_data($array,1,$data->consiger_id);

			 	$sample_data			= $this->admin_exportinvoice_product->getinvoicesampleproductdata(implode(",",$array),1);

				$html_data				= $this->custinvoice->get_invoice_html($id);

				$packing_html_data		= $this->custinvoice->packing_html_data($id);

		 	 	$this->load->model('admin_company_detail');

				$userdata 				= $this->custinvoice->ciadmin_login();

				$menu_data 				= $this->menu->usermain_menu($this->session->usertype_id);	

				$export_supplier_data 	= $this->admin_exportinvoice_product->get_export_supplier($id);			

			  	$v = array(

					'invoicedata'			=> $data,

					'product_data'			=> $loading_trn,

					'invoice_html_data'		=> $html_data,

					'packing_html_data'		=> $packing_html_data,

					'sample_data'			=> $sample_data,

					'direct_invoice' 		=> $data->direct_invoice,  

					'menu_data'				=> $menu_data,

				 	'company_detail'		=> $this->admin_company_detail->s_select(),

					'export_supplier_data'	=> $export_supplier_data,

				 	'userdata'				=> $userdata,

				 	'mode'					=> "0" 

				 );

				$this->load->view('admin/customerinvoiceview_small',$v); 

		}

			else

			{

				redirect(base_url().'');

			}

	}

	function index1($id){

	

	

		if(!empty($this->session->id)  && $this->session->title == TITLE)

			 {

				$data= $this->custinvoice->get_invoice_data($id);

				 

				$array 				= explode("-",$data->export_invoice_id);

				$loading_trn = $this->admin_exportinvoice_product->getinvoice_cust_data($array,1,$data->consiger_id);

			 	$sample_data		= $this->admin_exportinvoice_product->getinvoicesampleproductdata(implode(",",$array),1);

				$html_data				= $this->custinvoice->get_invoice_html($id);

				$packing_html_data		= $this->custinvoice->packing_html_data($id);

		 	

			 	$this->load->model('admin_company_detail');

				$userdata 	= $this->custinvoice->ciadmin_login();

				$menu_data 	= $this->menu->usermain_menu($this->session->usertype_id);	

			 		$export_supplier_data 	= $this->admin_exportinvoice_product->get_export_supplier($id);			

			  	$v = array(

					'invoicedata'			=> $data,

					'product_data'			=> $loading_trn,

					'sample_data'			=> $sample_data,

					'direct_invoice' 		=> $data->direct_invoice,  

					'menu_data'				=> $menu_data,

				 	'company_detail'		=> $this->admin_company_detail->s_select(),

					'export_supplier_data'	=> $export_supplier_data,

				 	'userdata'				=> $userdata,

					'invoice_html_data'		=> $html_data,

					'packing_html_data'		=> $packing_html_data,

				 	'mode'					=> "0" 

				 );

				$this->load->view('admin/customerinvoiceview1',$v); 

		}

			else

			{

				redirect(base_url().'');

			}

	}

	function sign_view($id)

	{

			if(!empty($this->session->id)  && $this->session->title == TITLE)

			 {

				$data= $this->custinvoice->get_invoice_data($id);

				 

				$array 				= explode("-",$data->export_invoice_id);

				$loading_trn = $this->admin_exportinvoice_product->getinvoice_cust_data($array,1,$data->consiger_id);

			 	$sample_data		= $this->admin_exportinvoice_product->getinvoicesampleproductdata(implode(",",$array),1);

				$html_data				= $this->custinvoice->get_invoice_html($id);

				$packing_html_data		= $this->custinvoice->packing_html_data($id);

		 	

			 	$this->load->model('admin_company_detail');

				$userdata 	= $this->custinvoice->ciadmin_login();

				$menu_data 	= $this->menu->usermain_menu($this->session->usertype_id);	

			 		$export_supplier_data 	= $this->admin_exportinvoice_product->get_export_supplier($id);			

			  	$v = array(

					'invoicedata'			=> $data,

					'product_data'			=> $loading_trn,

					'sample_data'			=> $sample_data,

					'direct_invoice' 		=> $data->direct_invoice,  

					'menu_data'				=> $menu_data,

				 	'company_detail'		=> $this->admin_company_detail->s_select(),

					'export_supplier_data'	=> $export_supplier_data,

				 	'userdata'				=> $userdata,

					'invoice_html_data'		=> $html_data,

					'packing_html_data'		=> $packing_html_data,

				 	'mode'					=> "0" 

				 );

				$this->load->view('admin/customerinvoice_sign_view',$v); 

		}

			else

			{

				redirect(base_url().'');

			}

	}

	public function performa_html_update()

	{

	 

		$performa_invoice_id	= $this->input->post('performa_invoice_id');

		$invoice_table_name		= $this->input->post('invoice_table_name');

		$invoice_html			= str_ireplace('contenteditable="true"','contenteditable="false"',$this->input->post('invoice_html'));

	 	 

		$data = array(

			"table_id" 				=> 	$performa_invoice_id,

			"invoice_html" 			=> 	$invoice_html,

			"invoice_table_name" 	=> 	$invoice_table_name,

			"cdate" 				=>	date('Y-m-d H:i:s'),

			"status" 				=>	0

		);

		 

		$check_id = $this->exportinvoice->check_invoice_html($invoice_table_name,$performa_invoice_id);

		 

		if(empty($check_id))

		{

			$insertid = $this->exportinvoice->insert_invoice_html($data);

		}

		else

		{

			$insertid = $this->exportinvoice->update_invoice_html($data,$performa_invoice_id,$invoice_table_name);

		}

		if($insertid)

		{

			$row['res'] = 1;

		}

		else{

			$row['res'] = 0;

		}

		echo json_encode($row);

	}

	

	public function invoice_html_update()

	{

	 

		$customer_invoice_id	= $this->input->post('customer_invoice_id');

		$invoice_html		= str_ireplace('contenteditable="true"','contenteditable="false"',$this->input->post('invoice_html'));

	 	 

		$data = array(

			"table_id" 				=> 	$customer_invoice_id,

			"invoice_html" 			=> 	$invoice_html,

			"invoice_table_name" 	=> 	'commercial_invoice',

			"cdate" 				=>	date('Y-m-d H:i:s'),

			"status" 				=>	0

		);

		 

		$check_id = $this->exportinvoice->check_invoice_html('commercial_invoice',$customer_invoice_id);

		 

		if(empty($check_id))

		{

			$insertid = $this->exportinvoice->insert_invoice_html($data);

		}

		else

		{

			$insertid = $this->exportinvoice->update_invoice_html($data,$customer_invoice_id,'commercial_invoice');

		}

		if($insertid)

		{

			$row['res'] = 1;

		}

		else{

			$row['res'] = 0;

		}

		echo json_encode($row);

	}

	public function packing_html_update()

	{

	 

		$customer_invoice_id	= $this->input->post('customer_invoice_id');

		$packing_html		= str_ireplace('contenteditable="true"','contenteditable="false"',$this->input->post('packing_html'));

	 	 

		$data = array(

			"table_id" 				=> 	$customer_invoice_id,

			"invoice_html" 			=> 	$packing_html,

			"invoice_table_name" 	=> 	'commercial_packing_html',

			"cdate" 				=>	date('Y-m-d H:i:s'),

			"status" 				=>	0

		);

		 

		$check_id = $this->exportinvoice->check_invoice_html('commercial_packing_html',$customer_invoice_id);

		 

		if(empty($check_id))

		{

			$insertid = $this->exportinvoice->insert_invoice_html($data);

		}

		else

		{

			$insertid = $this->exportinvoice->update_invoice_html($data,$customer_invoice_id,'commercial_packing_html');

		}

		if($insertid)

		{

			$row['res'] = 1;

		}

		else{

			$row['res'] = 0;

		}

		echo json_encode($row);

	}

	public function bl_html_update()

	{

	 

		$customer_invoice_id	= $this->input->post('customer_invoice_id');

		$invoice_html		= str_ireplace('contenteditable="true"','contenteditable="false"',$this->input->post('invoice_html'));

	 	 

		$data = array(

			"table_id" 				=> 	$customer_invoice_id,

			"invoice_html" 			=> 	$invoice_html,

			"invoice_table_name" 	=> 	'bl_html',

			"cdate" 				=>	date('Y-m-d H:i:s'),

			"status" 				=>	0

		);

		 

		$check_id = $this->exportinvoice->check_invoice_html('bl_html',$customer_invoice_id);

		 

		if(empty($check_id))

		{

			$insertid = $this->exportinvoice->insert_invoice_html($data);

		}

		else

		{

			$insertid = $this->exportinvoice->update_invoice_html($data,$customer_invoice_id,'bl_html');

		}

		if($insertid)

		{

			$row['res'] = 1;

		}

		else{

			$row['res'] = 0;

		}

		echo json_encode($row);

	}

	public function coo_html_update()

	{

	 

		$customer_invoice_id	= $this->input->post('customer_invoice_id');

		$invoice_html		= str_ireplace('contenteditable="true"','contenteditable="false"',$this->input->post('invoice_html'));

	 	 

		$data = array(

			"table_id" 				=> 	$customer_invoice_id,

			"invoice_html" 			=> 	$invoice_html,

			"invoice_table_name" 	=> 	'coo_html',

			"cdate" 				=>	date('Y-m-d H:i:s'),

			"status" 				=>	0

		);

		 

		$check_id = $this->exportinvoice->check_invoice_html('coo_html',$customer_invoice_id);

		 

		if(empty($check_id))

		{

			$insertid = $this->exportinvoice->insert_invoice_html($data);

		}

		else

		{

			$insertid = $this->exportinvoice->update_invoice_html($data,$customer_invoice_id,'coo_html');

		}

		if($insertid)

		{

			$row['res'] = 1;

		}

		else{

			$row['res'] = 0;

		}

		echo json_encode($row);

	}

	public function estimate_html_update()

	{

	 

		$estimate_id	= $this->input->post('estimate_id');

		$invoice_html		= str_ireplace('contenteditable="true"','contenteditable="false"',$this->input->post('invoice_html'));

	 	 

		$data = array(

			"table_id" 				=> 	$estimate_id,

			"invoice_html" 			=> 	$invoice_html,

			"invoice_table_name" 	=> 	'estimate_html',

			"cdate" 				=>	date('Y-m-d H:i:s'),

			"status" 				=>	0

		);

		 

		$check_id = $this->exportinvoice->check_invoice_html('estimate_html',$estimate_id);

		 

		if(empty($check_id))

		{

			$insertid = $this->exportinvoice->insert_invoice_html($data);

		}

		else

		{

			$insertid = $this->exportinvoice->update_invoice_html($data,$estimate_id,'estimate_html');

		}

		if($insertid)

		{

			$row['res'] = 1;

		}

		else{

			$row['res'] = 0;

		}

		echo json_encode($row);

	}



}

