<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Extra_detail extends CI_controller
{
	
	public function __construct()
	{
	/*call CodeIgniter's default Constructor*/
	parent::__construct();
	
	/*load database libray manually*/
	$this->load->database();
	
	
	/*load Model*/
	$this->load->model('Extra_detail_model','mode');
	$this->load->model('menu_model','menu');
	
	
	}
	
	public function index($id)
    {    
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			 
			 $this->load->model('admin_company_detail'); 
			 $this->load->model('Admin_exportinvoice_list');
			 //$this->load->model('Admin_customer_detail');	
			 $data['detail'] = $this->mode->get_extra_detail($id);
			 $data['export_data'] = $this->Admin_exportinvoice_list->exportinvoice_data($id); 	
			 $data['chadata'] = $this->mode->cha_data();	
			 $data['forwarerdata'] = $this->mode->forwarer_data();	
			 $data['shippingdata'] = $this->mode->shipping_data();			 
			 $data['vesseldata'] = $this->mode->vessel_data();			 
		
			 $data['company_detail'] = $this->admin_company_detail->s_select();	
			 
			
			 $data['menu_data']	= $this->menu->usermain_menu($this->session->usertype_id);	
			 $this->load->view('admin/extra_detail',$data);
		}
		else
		{
			redirect(base_url().'');
		}	
    }
	
	public function manage()
	{
		$check_box_design = $this->mode->check_terms_update($this->input->post('forwarer_id'));
		if(empty($check_box_design))
		{
			 $row =array();
			 $data1 = array(		
							'forwarer_id' 			=> $this->input->post('forwarer_id')	
							);
			 $data=array(
							'shippment_days' 	 	=> $this->input->post('shippment_days'),
							'exportinvoice_id' 	 	=> $this->input->post('exportdata'),
							'vessel_id' 	 		=> $this->input->post('vessel_id'),
							'shipping_id' 	 		=> $this->input->post('shipping_id'),
							'cha_id' 	 			=> $this->input->post('cha_id'),
							'forwarer_id' 	 		=> $this->input->post('forwarer_id'),
							'vessel_track_no'		=> $this->input->post('track_no'),
							'checkpack'			    => $this->input->post('checkpack'),
							'containers'			=> $this->input->post('containers'),
							'checkpack_remark'		=> $this->input->post('checkpack_remark'),
							'field_1'				=> $this->input->post('field1'),
							'field_2'				=> $this->input->post('field2'),
							'field_3'				=> $this->input->post('field3'),
							'field_4'				=> $this->input->post('field4'),
							
							'status'   	   	=> 0
			);
		
			$customer_add_detail_id = $this->input->post('customer_add_detail_id');
			if($customer_add_detail_id > 0)
			{
				
					$insert_id = $this->mode->update_additional_detail($data,$customer_add_detail_id);
					if($insert_id)
					 {
						$row['res'] = 2;
					 }
					 else
					 {
						$row['res'] = 0;
					 }
			}
			else
			{
			  if(empty($check_box_design))
			  {	
				$pdata = $this->mode->terms_insert($data1);			
				$insert_id = $this->mode->insert_additional_detail($data);
					if($insert_id)
					 {
						$row['res'] = 1;
					 }
					 else
					 {
						$row['res'] = 0;
					 }
			  }
			  else
			  {
			  	 $row['res'] = 3;
			  }
			  
			}
		}
		else
		{
			$row =array();
			
			 $data=array(
							'shippment_days' 	 	=> $this->input->post('shippment_days'),
							'exportinvoice_id' 	 	=> $this->input->post('exportdata'),
							'vessel_id' 	 		=> $this->input->post('vessel_id'),
							'shipping_id' 	 		=> $this->input->post('shipping_id'),
							'cha_id' 	 			=> $this->input->post('cha_id'),
							'forwarer_id' 	 		=> $this->input->post('forwarer_id'),
							'vessel_track_no'		=> $this->input->post('track_no'),
							'checkpack'			    => $this->input->post('checkpack'),
							'containers'			=> $this->input->post('containers'),
							'checkpack_remark'		=> $this->input->post('checkpack_remark'),
							'field_1'				=> $this->input->post('field1'),
							'field_2'				=> $this->input->post('field2'),
							'field_3'				=> $this->input->post('field3'),
							'field_4'				=> $this->input->post('field4'),
							
							'status'   	   	=> 0
			);
		
			$customer_add_detail_id = $this->input->post('customer_add_detail_id');
			if($customer_add_detail_id > 0)
			{
				
				$insert_id = $this->mode->update_additional_detail($data,$customer_add_detail_id);
					if($insert_id)
					 {
						$row['res'] = 2;
					 }
					 else
					 {
						$row['res'] = 0;
					 }
			}
			else
			{
			  if(empty($check_box_design))
			  {
				$insert_id = $this->mode->insert_additional_detail($data);
					if($insert_id)
					 {
						$row['res'] = 1;
					 }
					 else
					 {
						$row['res'] = 0;
					 }
			  }
			  else
			  {
			  	 $row['res'] = 3;
			  }
			  
			}
		}
		
          
		echo json_encode($row);
	}

}
?>