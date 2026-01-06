<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Exportinvoice_completed extends CI_controller
{
	  public function __construct(){
	  	parent:: __construct();
	  	$this->load->helper('url');
	  	$this->load->library(array('form_validation','session','encrypt'));
	  	$this->load->model('admin_invoice_list','invoice');
	  	$this->load->model('Admin_pdf');
		$this->load->model('menu_model','menu');	
	  	if (!isset($_SESSION['id']) && $this->session->title == TITLE)
		{
	  		redirect(base_url());
	  	}
	  }	
	  public function index($m="")
	  {
	  	if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$data['erd']= $m;
			$this->load->model('admin_company_detail');	
			$data['company_detail']  = $this->admin_company_detail->s_select();	
			$data['menu_data']	 	 = $this->menu->usermain_menu($this->session->usertype_id);	
			$data['allproductsize']	 = $this->invoice->allproductsize();
			$data['alldesign']	 	 = $this->invoice->alldesign();
			$data['allfinish']	 	 = $this->invoice->allfinish();
			$data['consign_data']	 = $this->invoice->select_consigner();
			$this->load->view('admin/exportinvoice_completed',$data);
		}
		else
		{
			redirect(base_url().'');
		}

	  }
	  public function fetch_record()
	  {
		 
	 	$invoice_status = $this->input->get('invoice_status');
		$invoicedate = explode(" - ",$this->input->get('date'));
		$where = ' and performa_date BETWEEN "'.date('Y-m-d',strtotime($invoicedate[0])).'" and "'.date('Y-m-d',strtotime($invoicedate[1])).'"';
		 $_SESSION['ready_s_date'] = $invoicedate[0];
		 $_SESSION['ready_e_date'] = $invoicedate[1];
		 $cust_id = $this->input->get('cust_id');
		 if(!empty($cust_id))
		 {
		 	$where .= ' and mst.consigne_id = '.$cust_id;
		 	$_SESSION['ready_cust_id'] = $cust_id;
		 }	
		 else
		 {
		 	$_SESSION['ready_cust_id'] = '';
		 }
			if($this->session->usertype_id != 1)
			{
				$where .= " and find_in_set(consign.id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = ".$this->session->id." and status =0))";
			}		
				$this->load->model('Pagging_model');//call module 
				$aColumns = array('performa_invoice_id', 'invoice_no','consign.c_companyname','country.c_name as country_name','performa_date','time','mst.container_details','mst.port_of_discharge','grand_total','mst.status','mst.cdate','step','no_of_export','no_of_po','cur.currency_name','cur.currency_id','mst.consigne_id','addition_detail_status','confirm_status','user.user_name');
				$isWhere = array("mst.status = 0 and confirm_status=1".$where);
				$table = "tbl_performa_invoice as mst";
				$isJOIN = array(
								'left join customer_detail as consign on consign.id=mst.consigne_id',
								'left join country_detail as country on country.id=consign.c_country',
								'left join tbl_currency as cur on cur.currency_id=mst.invoice_currency_id',
								'left join tbl_user as user on user.user_id=mst.user_id'
								);
				$hOrder = "mst.performa_invoice_id desc";
				 $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
				$appData = array();
				$no = ($this->input->get('iDisplayStart') + 1);
				
			foreach($sqlReturn['data'] as $row) {
			 
					$set_container = $this->Admin_pdf->product_set_data($row->performa_invoice_id,-1);
						 $setcontainer =0;
						  $exportcontainer= 0;
						  $con_array = array();
						   $check_container_detail = array();
						for($i=0; $i<count($set_container);$i++)
						{
							if(!in_array($set_container[$i]->con_entry.$set_container[$i]->export_done_status,$con_array))
							{
								if($set_container[$i]->already_done == 1)
								{
									$setcontainer += $set_container[$i]->container;
							  	}
								if($set_container[$i]->export_done_status  == 1)
								{
									$exportcontainer += $set_container[$i]->container;
							 	}
								array_push($check_container_detail, $set_container[$i]->already_done);
								array_push($con_array,$set_container[$i]->con_entry.$set_container[$i]->export_done_status);
							}
						}
					
					 if($exportcontainer>0 || $setcontainer > 0)
					 {
						 $row_data 	= array();
						 $row_data[] =	$no;
						 $check_box = '';
						//var_dump($check_container_detail);
						//var_dump($exportcontainer);
						
						 if($setcontainer == $exportcontainer)
						{
							 
						$viewinvoice1= '<li>
											 
												<a class="tooltips" data-toggle="tooltip" data-title="PI 1" href="'.base_url('performa_invoice_pdf/index/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i> PI 1 (With Finish)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="PI 2" href="'.base_url('performa_invoice_pdf/index_withoutfinish/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i> PI 2 (Without Finish)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="PI 3" href="'.base_url('performa_invoice_pdf/index_withthickness/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i> PI 3 (With Thickness)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="PI 4 (With Unit)" href="'.base_url('performa_invoice_pdf1/index/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i> PI 4 (With Unit)</a>
											
												<a class="tooltips" data-toggle="tooltip" data-title="With Image,Without Barcode" href="'.base_url('performa_invoice_pdf2/index/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i> PI 5 (With Image,Without Barcode)</a>
											
												<a class="tooltips" data-toggle="tooltip" data-title="PI 4" href="'.base_url('performa_invoice_pdf3/index/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i> PI 6</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="'.base_url('performa_invoice_pdf4/index/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i>  PI 7</a>
											
												<a class="tooltips" data-toggle="tooltip" data-title="Zuku Format" href="'.base_url('performa_invoice_pdf6/index/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i>  PI 8 (Zuku Format)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="Other Product" href="'.base_url('performa_invoice_pdf7/index/'.$row->performa_invoice_id).'" ><i class="fa fa-file-text-o"></i>  PI 9 (With Other Product)</a>
												
											 
										
								 	 </li>';
						$row_data[] = '<div class="dropdown">
										<a class="dropdown-toggle"  data-toggle="dropdown">'.$row->invoice_no.'
										<span class="caret"></span></a>
										<ul class="dropdown-menu">
												'.$viewinvoice1.' 
									</div>';
						$row_data[] =  $row->c_companyname;
						$row_data[] =  $row->country_name;
					  	$row_data[] = date('d/m/Y',strtotime($row->performa_date));
						
						$row_data[] = $setcontainer;
						$row_data[] = $exportcontainer;
						 
				 	$viewinvoice='';
					$checkbox = '';
					
					  $viewinvoice= ' <i class="fa fa-check"></i>';
					 
					$row_data[] = $viewinvoice;
					
					 $appData[] = $row_data;
						}
					  $no++;
					 }	
					
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