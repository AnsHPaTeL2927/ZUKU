<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Exportinvoicesample extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('admin_exportinvoice_product','export');
		$this->load->model('menu_model','menu');	
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}

	function index($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
				$data				= $this->export->get_invoice_data($id);
			   	$container_data 	= $this->export->get_container_data($id,$datap[0]->export_invoice_id,$data->performa_invoice_id);
				$this->load->model('admin_company_detail');
				$userdata 		  	= $this->export->ciadmin_login();	
				$get_annexuredata 	= $this->export->getannexuredata($id);
				$menu_data	 		= $this->menu->usermain_menu($this->session->usertype_id);	
				$loadingtrn_data 	= $this->export->loadingtrn_data($id);
				
				$v = array(
					'invoicedata'			=> $data,
				 	'company_detail'		=> $this->admin_company_detail->s_select(),
					'allproduct'			=> $this->export->allproductsize(),
					'container_data'		=> $container_data,
					'menu_data'				=> $menu_data,
					'userdata'				=> $userdata,
					'product_data'			=> $loadingtrn_data,
					'annexuredata'			=> $get_annexuredata,
					'mode' 					=>  "0",
					 
				);
			$this->load->view('admin/exportinvoicesample',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}

	function manage()
	{
		 
		$no =0;
		 foreach($this->input->post('export_loading_trn_id') as $key)
		 {
			 $data3 = array(
				 	"updated_net_weight"  		=> $this->input->post('net_weight')[$no],
					"updated_gross_weight"  	=> $this->input->post('gross_weight')[$no]
			 	);
			  $trnupdatedid = $this->export->updatecointainer($data3,$key);
			  $no++;
		 }
			 
			$step = ($this->input->post('export_step')==6)?3:$this->input->post('export_step');
			 
		$stepupdate = $this->export->export_invoice_stepupdate($this->input->post('export_invoice_id'),$step,0);
		 $row['res'] = "1";
		echo json_encode($row);

	}
	public function update_export()
	{
		$export_data = array(
			'certification_charge'=> $this->input->post('certification_charge'),
			'insurance_charge'=> $this->input->post('insurance_charge'),
			'seafright_charge'=> $this->input->post('seafright_charge'),
			'discount'=> $this->input->post('discount'),
			'export_under'=> $this->input->post('export_under'),
			'epcg_licence_no'=> $this->input->post('epcg_licence_no'),
			'grand_total'=> $this->input->post('grand_total'),
			'Exchange_Rate_val'=>$this->input->post('Exchange_Rate_val'),
			'remarks'=>$this->input->post('remarks'),
			'supplier_gstib'=>$this->input->post('supplier_gstib'),
			'supplier_invoice_no'=>$this->input->post('supplier_invoice_no'),
			'indian_ruppe_val'=>$this->input->post('indian_ruppe_val'),
			'indian_ruppe_after_gst'=>$this->input->post('aftergst_indian_ruppe_val'),
			);
			$export_data['step'] = ($this->input->post('step')==3)?$this->input->post('step'):2;
			$export_data_update_id = $this->export->updateexport($export_data,$this->input->post('export_invoice_id'));
		echo 1;
	}
	public function deleterecord()
	{
		$id = $this->input->post('id');
		$deleterecord = $this->export->delete_sampleproduct($id);	
		$deletetrnrecord = $this->export->delete_sampletrnproduct($id);	
			if($deleterecord)
			{
				$row['res'] = '1';
			}
			else{
				$row['res'] = '0';
			}
			echo json_encode($row);
	}
	public function fetchproductdata()
	{
		$id = $this->input->post('id');
		$fetchresult = $this->export->fetchrecord($id);
		echo json_encode($fetchresult);
	}
	public function allproductsave($id){

		$rdata = $this->export->product_data_save($id);
		
			if($rdata)
			{	
				redirect(base_url('packing/index/'.$id));
			}
	}
	public function selecthsncproduct()
	{
		$hsncval=$this->input->post('hsncval');
		$resultdata=array();
		$data=$this->pinv->hsncproductsize($hsncval);
		
		foreach($data as $row)
		{
			$resultdata[]=array($row->size_details,$row->id);	
		}
		 echo json_encode($resultdata);
	}
	public function updateinvoice()
	{
		$invoiceid=$this->input->post('invoice_id');
		//$remarks=$this->input->post('remarks');
	 	$step=1;
		$temp_status=0;
		$updatestepinvoice = $this->export->export_invoice_stepupdate($invoiceid,$step,$temp_status);
	}
	public function make_container_fun()
	{
		$data = array(
			'allproduct_id'=> implode(",",$this->input->post('allvalues')),
			'invoice_id'=> $this->input->post('performainvoice_id'),
			'container_count'=> 1,
			'status'=> 0 
			);
			$insertid = $this->pinv->insert_makecontainer($data);
			echo  "1";
			 
	}
	public function getproduct_data()
	{
	 	$packing_detail	=	$this->export->get_packing_detail($this->input->post('product_id'));
		$data_product 	= 	$this->export->hsncproductsizedetail($this->input->post('product_id'),2);
	 	$design_detail	=	$this->export->fetchdesign_detail($this->input->post('product_id'));
		$str ='<option value="">Select Packing</option>';
				foreach($packing_detail as $packing_row)
				{	 
					$str .='<option '.$sel.' value="'.$packing_row->product_size_id.'">'.$packing_row->product_packing_name.'</option>';
				}
		$str_design ='<option value="">Select Design</option>';
				foreach($design_detail as $design_row)
				{	 
					$str_design .='<option  value="'.$design_row->packing_model_id.'">'.$design_row->model_name.'</option>';
				}	
			$row['str'] = $str;
			$row['str_design'] = $str_design;
		echo json_encode($row);
	}
	public function getproduct_size_data()
	{
			$product_size_id 	= $this->input->post('product_size_id');
			$packing_detail		= $this->export->get_packing_size_detail($product_size_id);
		 	echo json_encode($packing_detail);
	}
}
