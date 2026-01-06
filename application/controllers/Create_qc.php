<?php
class Create_qc extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_create_qc', 'qc');
        $this->load->model('menu_model', 'menu');    
    }

    function index($id)
    {
        if (!empty($this->session->id) && $this->session->title == TITLE)
        {
            $this->load->model('admin_company_detail');    
            $company = $this->admin_company_detail->s_select();
            $data = $this->qc->select_invoice_data($id); 
            $menu_data = $this->menu->usermain_menu($this->session->usertype_id);    
            $v = array( 
                'menu_data'      => $menu_data,
                'mode'           => 'Add',
                'company_detail' => $company,
                'invoicedata'    => $data,
                'production_mst_id' => $id 
            );
            $this->load->view('admin/create_qc', $v);
        }
        else
        {
            $this->load->view('admin/index');
        }    
    }
	
	private function set_upload_options($newfilename,$filename)
	{   
		//upload an image options
		$config = array();
		$extension = end(explode(".", $filename));
		$config['file_name'] = $newfilename.rand(0,9999).'.'.$extension;
		$config['upload_path'] = './upload/QcImage/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size']      = '5000';
		$config['overwrite']     = FALSE;

		return $config;
	}
	
    public function edit_qc($id)
    {
        if (!empty($this->session->id) && $this->session->title == TITLE)
        {
            $this->load->model('admin_company_detail'); 
            $company = $this->admin_company_detail->s_select();
            $data = $this->qc->select_data($id);
            $menu_data = $this->menu->usermain_menu($this->session->usertype_id);
            $v = array(
                'menu_data' => $menu_data,
                'mode' => 'Edit',
                'qc_data' => $data,
                'company_detail'	=> $company,
                'production_mst_id' => $data['production_mst_id'] 
            );
            $this->load->view('admin/edit_qc', $v);
        }
        else
        {
            $this->load->view('admin/index');
        }
    }

    public function insert()
    {
        $data = array(
            'production_mst_id' => $this->input->post('production_mst_id'),
            'plantname_address' => $this->input->post('plantname_address'),
            'plantowner_contactno' => $this->input->post('plantowner_contactno'),
            'plantcontactperson_no' => $this->input->post('plantcontactperson_no'),
            'po_pi_details' => $this->input->post('po_pi_details'),
            'product_type' => $this->input->post('product_type'),
            'designname_qty' => $this->input->post('designname_qty'),
            'size' => $this->input->post('size'),
            'batches_shades' => $this->input->post('batches_shades'),
            'packing_details' => $this->input->post('packing_details'),
            'pcs_per_box' => $this->input->post('pcs_per_box'),
            'corner_guard' => $this->input->post('corner_guard'),
            'binder' => $this->input->post('binder'),
            'carton_quality' => $this->input->post('carton_quality'),
            'carton_boxdesign' => $this->input->post('carton_boxdesign'),
            'label_content' => $this->input->post('label_content'),
            'barcode_sticker_details' => $this->input->post('barcode_sticker_details'),
            'separation_between_tiles' => $this->input->post('separation_between_tiles'),
            'any_other_details' => $this->input->post('any_other_details'),
            'back_appearance' => $this->input->post('back_appearance'),
            'standard_to_follow' => $this->input->post('standard_to_follow'),
            'refrence_sample_design' => $this->input->post('refrence_sample_design'),
            'l_a_b_value_details' => $this->input->post('l_a_b_value_details'),
            'any_other_instructions' => $this->input->post('any_other_instructions'),
            'qc_no' => $this->input->post('qc_no'),
            'qc_date' => $this->input->post('qc_date'),
            'qc_sign' => $this->input->post('qc_sign')
        );
		
		if($_FILES['qc_image']['name'] != "" )	
				{
					$this->load->library('upload');
					$this->upload->initialize($this->set_upload_options('qc_image',$_FILES['qc_image']['name']));
					$this->upload->do_upload('qc_image');
					$upload_image = $this->upload->data();
					$data['qc_image']  = $upload_image['file_name'];
					
				} 
				else
				{
					$data['qc_image']  = $this->input->post('qc_image_name');
				}
			
        $production_mst_id = $data['production_mst_id'];

        $this->qc->insert_qc($data);

        redirect('create_qc/view/' . $production_mst_id);
    }


    public function update()
    {
        $production_mst_id = $this->input->post('production_mst_id'); 
        $id = $this->qc->get_id_by_production_mst_id($production_mst_id); 
        
        $data = array(
            'plantname_address' => $this->input->post('plantname_address'),
            'plantowner_contactno' => $this->input->post('plantowner_contactno'),
            'plantcontactperson_no' => $this->input->post('plantcontactperson_no'),
            'po_pi_details' => $this->input->post('po_pi_details'),
            'product_type' => $this->input->post('product_type'),
            'designname_qty' => $this->input->post('designname_qty'),
            'size' => $this->input->post('size'),
            'batches_shades' => $this->input->post('batches_shades'),
            'packing_details' => $this->input->post('packing_details'),
            'pcs_per_box' => $this->input->post('pcs_per_box'),
            'corner_guard' => $this->input->post('corner_guard'),
            'binder' => $this->input->post('binder'),
            'carton_quality' => $this->input->post('carton_quality'),
            'carton_boxdesign' => $this->input->post('carton_boxdesign'),
            'label_content' => $this->input->post('label_content'),
            'barcode_sticker_details' => $this->input->post('barcode_sticker_details'),
            'separation_between_tiles' => $this->input->post('separation_between_tiles'),
            'any_other_details' => $this->input->post('any_other_details'),
            'back_appearance' => $this->input->post('back_appearance'),
            'standard_to_follow' => $this->input->post('standard_to_follow'),
            'refrence_sample_design' => $this->input->post('refrence_sample_design'),
            'l_a_b_value_details' => $this->input->post('l_a_b_value_details'),
            'any_other_instructions' => $this->input->post('any_other_instructions'),
			 'qc_no' => $this->input->post('qc_no'),
            'qc_date' => $this->input->post('qc_date'),
            'qc_sign' => $this->input->post('qc_sign')
        );
		
		// if($_FILES['qc_image']['name'] != "" )	
			// {
				// unlink("./upload/QcImage/".$this->input->post('qc_image'));
			
				// $this->load->library('upload');
				// $this->upload->initialize($this->set_upload_options('qc_image',$_FILES['qc_image']['name']));
				// $this->upload->do_upload('qc_image');
				// $upload_image = $this->upload->data();
				// $data['qc_image']  = $upload_image['file_name'];
				
			// } 
			// else
			// {
				// $data['qc_image']  = $this->input->post('qc_image_name');
			// }	
			
        if ($id) {
            $this->qc->update_qc($data, $production_mst_id);
        } else {
            $this->qc->insert_qc($data);
        }
        
        redirect('create_qc/view/'.$production_mst_id);
    }

    public function view($production_mst_id)
    {
        $this->load->model('admin_company_detail');    
        $company = $this->admin_company_detail->s_select();
        $data = $this->qc->qc_data($production_mst_id); 
        $menu_data = $this->menu->usermain_menu($this->session->usertype_id);
        $this->load->view('admin/view_qc', array('invoicedata' => $data, 'menu_data' => $menu_data, 'company_detail' => $company));
    }


}
?>
