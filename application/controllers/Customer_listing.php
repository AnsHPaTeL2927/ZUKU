<?php 

defined("BASEPATH") or exit("no dericet script allowed"); 

class Customer_listing extends CI_controller{

	

		public function __construct(){

			parent:: __construct();

		 

			$this->load->model('Customer_invoice_model','custinvoice');

			$this->load->model('menu_model','menu');	

			if (!isset($_SESSION['id']) && $this->session->title == TITLE) {

				redirect(base_url());

			}  

		}	

		public function index($m="")

		{

			if(!empty($this->session->id)  && $this->session->title == TITLE)

			 { 

				$data['erd']= $m;

				$this->load->model('admin_company_detail');	

				$data['company_detail'] = $this->admin_company_detail->s_select();

				$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	

				$data['consign_data']	 = $this->custinvoice->select_consigner();	

				$data['customer_data']	 = $this->custinvoice->getcustomerdata();				

				$this->load->view('admin/customer_listing',$data);

			}

			else

			{

				redirect(base_url().'');

			}

		}

		public function deleterecord()

		{

			$id				   = $this->input->post('id');

			$export_invoice_id = $this->input->post('export_invoice_id');

			

				$update_export_invoice_id = explode("-",$export_invoice_id);

				

				$update_export_invoice 	  = $this->custinvoice->update_cust_status(implode(",",$update_export_invoice_id),0);

					

			$deleterecord = $this->custinvoice->customerinvoicedelete($id);	

				if($deleterecord)

				{

					$row['res'] = '1';

				}

				else{

					$row['res'] = '0';

				}

				echo json_encode($row);

		}

		public function updateperforma_invoice()

		{

			$id = $this->input->post('id');

			$no_of_export = ($this->input->post('no_of_export')-1);

			$updaterecord = $this->export->updateperformainvoice($id,$no_of_export);	

			echo 1;

		}

	  	public function fetch_record()

		{

			 $invoice_status = $this->input->get('invoice_status');

			$invoicedate = explode(" - ",$this->input->get('date'));

			$cust_id = $this->input->get('cust_id');

			$customerdata = $this->input->get('customerdata');

			

			$where = ' and invoice_date BETWEEN "'.date('Y-m-d',strtotime($invoicedate[0])).'" and "'.date('Y-m-d',strtotime($invoicedate[1])).'"';

			if($invoice_status==1)

			{

				$where = ' and (mst.step=3 or mst.step = 4)';

			}

			else if($invoice_status==2)

			{

				$where = ' and mst.step=1';

			}

			else if($invoice_status==3)

			{

				$where = ' and mst.step=2';

			}	

			 $_SESSION['customer_s_date'] = $invoicedate[0];

			 $_SESSION['customer_e_date'] = $invoicedate[1];

			

			if(!empty($cust_id))

			{

				$where .= ' and mst.consiger_id = '.$cust_id;

				$_SESSION['customer_cust_id'] = $cust_id;

			}	

			else

			{

				$_SESSION['customer_cust_id'] = '';

			}

			

			if(!empty($customerdata))

			{

				$where .= ' and mst.customer_invoice_id = '.$customerdata;

				$_SESSION['get_customerdata'] = $customerdata;

			}	

			else

			{

				$_SESSION['get_customerdata'] = '';

			}

		

			 // if($this->session->usertype_id != 1)

			// {

				// $where .= " and find_in_set(mst.consiger_id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = ".$this->session->id." and status =0))";

			// }

			$this->load->model('Pagging_model');//call module 

			$aColumns = array('mst.customer_invoice_id','mst.invoice_date', 'mst.customer_invoice_no','consign.c_companyname','mst.container_details','mst.port_of_discharge','mst.grand_total','mst.terms_id','mst.certification_charge', 'mst.insurance_charge','mst.seafright_charge','mst.status','mst.cdate','mst.step','cur.currency_name','cur.currency_id','mst.export_invoice_id','bl.id as upload_bl_id');

			$isWhere = array("mst.status = 0".$where);

			$table = "tbl_customer_invoice as mst";

			$isJOIN = array(

				'left join customer_detail consign on consign.id=mst.consiger_id',

				'left join tbl_currency cur on cur.currency_id=mst.invoice_currency_id',

				'left join upload_bl bl on bl.customer_invoice_id	= mst.customer_invoice_id'

				);

			

			$hOrder = "mst.customer_invoice_id desc";

			 $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());

			$appData = array();

			$no = ($this->input->get('iDisplayStart') + 1);

			foreach($sqlReturn['data'] as $row) {

				$row_data = array();

				$step_status='';

				$viewinvoice='';

				$viewinvoice1='';

				$upload_bltn='';

				$coo_draft='';

				$bl_draft='';

				$deletebtn = '<li>

								<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->customer_invoice_id.',&quot;'.$row->export_invoice_id.'&quot;)" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>

							</li>';

				$actionbtn = '<li> 

								<a class="tooltips" data-toggle="tooltip" data-title="Edit" href="'.base_url().'create_customer_invoice/invoice_edit/'.$row->customer_invoice_id.'"><i class="fa fa-pencil"></i>Edit</a>

							</li>';

				  

				if($row->step==4 || $row->step==3)

				{

					$viewinvoice='<li>

									<a class="tooltips" data-toggle="tooltip" data-title="View Invoice" href="'.base_url('customerinvoiceview/index/'.$row->customer_invoice_id).'" ><i class="fa fa-file-text-o"></i> View Invoice</a>

								  </li>

								  

								  <li>

									<a class="tooltips" data-toggle="tooltip" data-title="View Invoice (With Sign)" href="'.base_url('customerinvoiceview/sign_view/'.$row->customer_invoice_id).'" ><i class="fa fa-file-text-o"></i> View Invoice (With Sign)</a>

								  </li>

								    <li>
									<a class="tooltips" data-toggle="tooltip" data-title="View Invoice (CIF)" href="'.base_url('customerinvoiceview/index_cif/'.$row->customer_invoice_id).'" ><i class="fa fa-file-text-o"></i> View Invoice (CIF)</a>
								  </li> 

								  <li>
									<a class="tooltips" data-toggle="tooltip" data-title="View Invoice (CIF)" href="'.base_url('customerinvoiceview/index_cif_sign/'.$row->customer_invoice_id).'" ><i class="fa fa-file-text-o"></i> View Invoice (CIF With Sign)</a>
								  </li>
								  

								  <li>

									<a class="tooltips" data-toggle="tooltip" data-title="View Invoice (With Batch Shade)" href="'.base_url('customerinvoiceview/batch_shade/'.$row->customer_invoice_id).'" ><i class="fa fa-file-text-o"></i> View Invoice (With Batch Shade)</a>

								  </li>

								  

								  <li>

									<a class="tooltips" data-toggle="tooltip" data-title="View Invoice (DUBAI)" href="'.base_url('customerinvoiceview/dubai/'.$row->customer_invoice_id).'" ><i class="fa fa-file-text-o"></i> View Invoice (DUBAI)</a>

								  </li>

								  <li>

									<a class="tooltips" data-toggle="tooltip" data-title="View Invoice" href="'.base_url('customerinvoiceview/index_small/'.$row->customer_invoice_id).'" ><i class="fa fa-file-text-o"></i> View Invoice (Small Case Latter)</a>

								  </li>

								  <li>

									<a class="tooltips" data-toggle="tooltip" data-title="View Invoice(Other Product)" href="'.base_url('customerinvoicepdf/other_product/'.$row->customer_invoice_id).'"  ><i class="fa fa-file-pdf-o"></i> View Invoice(Other Product)</a>

								  </li>

								  <li>

									<a class="tooltips" data-toggle="tooltip" data-title="View in Invoice Pdf" href="'.base_url('customerinvoicepdf/index/'.$row->customer_invoice_id).'" target="_blank" ><i class="fa fa-file-pdf-o"></i> View Pdf</a>

								  </li>

								  ';

						$viewinvoice1='<li>

									<a class="tooltips" data-toggle="tooltip" data-title="View Invoice" href="'.base_url('customerinvoiceview/index/'.$row->customer_invoice_id).'" ><i class="fa fa-file-text-o"></i> View Invoice</a>

								  </li>

								   <li>

									<a class="tooltips" data-toggle="tooltip" data-title="View Invoice (With Sign)" href="'.base_url('customerinvoiceview/sign_view/'.$row->customer_invoice_id).'" ><i class="fa fa-file-text-o"></i> View Invoice (With Sign)</a>

								  </li>

								    <li>
									<a class="tooltips" data-toggle="tooltip" data-title="View Invoice (CIF)" href="'.base_url('customerinvoiceview/index_cif/'.$row->customer_invoice_id).'" ><i class="fa fa-file-text-o"></i> View Invoice (CIF)</a>
								  </li>
								  

								  <li>

									<a class="tooltips" data-toggle="tooltip" data-title="View Invoice(Other Product)" href="'.base_url('customerinvoicepdf/other_product/'.$row->customer_invoice_id).'" ><i class="fa fa-file-pdf-o"></i> View Invoice(Other Product)</a>

								  </li>

								  <li>

									<a class="tooltips" data-toggle="tooltip" data-title="View in Invoice Pdf" href="'.base_url('customerinvoicepdf/index/'.$row->customer_invoice_id).'" target="_blank" ><i class="fa fa-file-pdf-o"></i> View Pdf</a>

								  </li>

								  ';		  

								  $bl_draft = '<li>

												<a class="tooltips" data-toggle="tooltip" data-title="BL Draft View" href="'.base_url('view_bldraft/index/'.$row->customer_invoice_id).'" ><i class="fa fa-eye"></i> BL Draft</a>

											</li>';

											

									$coo_draft = '<li>

												<a class="tooltips" data-toggle="tooltip" data-title="COO View" href="'.base_url('view_coo/index/'.$row->customer_invoice_id).'" ><i class="fa fa-eye"></i> COO</a>

											</li>';

					 

					if(empty($row->upload_bl_id))

					{

						$upload_bltn = '<li>

											<a class="tooltips" data-toggle="tooltip" data-title="Upload BL" href="'.base_url().'upload_bl/index/'.$row->customer_invoice_id.'"><i class="fa fa-pencil"></i> Upload BL</a>

										</li>';

					}

					else

					{

						$upload_bltn = '<li>

											<a class="tooltips" data-toggle="tooltip" data-title="Edit BL" href="'.base_url().'upload_bl/form_edit/'.$row->upload_bl_id.'"><i class="fa fa-pencil"></i> Edit BL</a>

										</li>';

					}    

	 			}

				if($row->step==1)

				{

					$step_status = '<a class="btn btn-warning tooltips" data-toggle="tooltip" data-title="Add Product Pending" href="'.base_url().'cutomerinvoiceproduct/index/'.$row->customer_invoice_id.'"><i class="glyphicon glyphicon-stop"></i></a>';

				}

				else if($row->step==2)

				{

					$step_status = '<a class="btn btn-primary tooltips" data-toggle="tooltip" data-title="Packing Pending" href="'.base_url().'customerinvoicepacking/index/'.$row->customer_invoice_id.'"><i class="fa fa-square-o"></i></a>';

				}

			 	else 

				{

					$step_status = '<a class="btn btn-success tooltips" data-toggle="tooltip" data-title="Customer Invoice Done" href="javascript:;"><i class="fa fa-check-square-o"></i></a>';

				}

				$row_data[] = $step_status;

				$row_data[] = date('d/m/Y',strtotime($row->invoice_date));

				if($row->step>1)

				{

					$row_data[] = '<div class="dropdown">

									<a   data-toggle="dropdown">'.$row->customer_invoice_no.'

									<span class="caret"></span></a>

									<ul class="dropdown-menu">

									 

										'.$viewinvoice1.'

										 

								</div> ';

				}

				else

				{

					$row_data[] = $row->customer_invoice_no;

				}

				$row_data[] = $row->c_companyname;

				$row_data[] = $row->container_details;

				$row_data[] = $row->port_of_discharge;

				$currency_symbol = "$";

				$currency_symbol = "$";

					if($row->currency_name=="Euro")

					{

						$currency_symbol = "&euro;";

					}

					else if($row->currency_name=="RS")

					{

						$currency_symbol = "<img src='".base_url()."adminast/assets/images/ruppe_sysbol.jpg' />";

					}
					
				if($row->terms_id == 1)
				{
					$row_data[] = $currency_symbol.' '.number_format($row->grand_total,2,'.','');
				}
				else if($row->terms_id == 3)
				{
					$row_data[] = $currency_symbol.' '.number_format(($row->grand_total - $row->seafright_charge - $row->insurance_charge - $row->certification_charge),2,'.','');
				
				}
				else
				{
					$row_data[] = $currency_symbol.' '.number_format($row->grand_total,2,'.','');
				}
					
					

				

				

				

				$row_data[] = '<div class="dropdown">

									<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action

									<span class="caret"></span></button>

									<ul class="dropdown-menu">

										'.$actionbtn .'

										'.$viewinvoice.'

										'.$bl_draft.'

										'.$coo_draft.'

										'.$upload_bltn.'

									 	'.$deletebtn.'

								</div>';

				$appData[] = $row_data;

			}

			$totalrecord = $this->Pagging_model->count_all($aColumns,$table,$hOrder,$isJOIN,$isWhere,'');

			

			$numrecord=$sqlReturn['data'];

			$output = array(

					"sEcho" => intval($this->input->get('sEcho')),

					"iTotalRecords" =>  $numrecord,

					"iTotalDisplayRecords" =>$totalrecord,

					"aaData" => $appData

			);

				echo json_encode( $output );

		}

}

?>