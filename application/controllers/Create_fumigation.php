<?php
class Create_fumigation extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_create_fumigation', 'fumigation');
        $this->load->model('menu_model', 'menu');    
    }

    function index($id)
    {
        if (!empty($this->session->id) && $this->session->title == TITLE)
        {
            $this->load->model('admin_company_detail');    
            $company = $this->admin_company_detail->s_select();
            $data = $this->fumigation->select_invoice_data($id); 
			//$exportdata = $this->fumigation->get_invoice_data($export_invoice); 
            $menu_data = $this->menu->usermain_menu($this->session->usertype_id);    
            $v = array( 
                'menu_data'      => $menu_data,
                'mode'           => 'Add',
                'company_detail' => $company,
                'invoicedata'    => $data,
                'export_invoice_id' => $id 
            );
            $this->load->view('admin/create_fumigation', $v);
        }
        else
        {
            $this->load->view('admin/index');
        }    
    }

    public function edit_fumigation($id)
    {
        if (!empty($this->session->id) && $this->session->title == TITLE)
        {
            $this->load->model('admin_company_detail'); 
            $company = $this->admin_company_detail->s_select();
            $data = $this->fumigation->select_data($id);
            $menu_data = $this->menu->usermain_menu($this->session->usertype_id);
            $v = array(
                'menu_data' => $menu_data,
                'mode' => 'Edit',
                'fumigation_data' => $data,
                'company_detail'	=> $company,
                'export_invoice_id' => $data['export_invoice'] 
            );
            $this->load->view('admin/edit_fumigation', $v);
        }
        else
        {
            $this->load->view('admin/index');
        }
    }

    public function insert()
    {
        $data = array(
            'export_invoice' => $this->input->post('export_invoice'),
            'consigner_exporter' => $this->input->post('consigner_exporter'),
            'consignee_importer' => $this->input->post('consignee_importer'),
            'dppqs_number' => $this->input->post('dppqs_number'),
            'treatment_certificate_number' => $this->input->post('treatment_certificate_number'),
            'date_of_issue' => $this->input->post('date_of_issue'),
			 'nameof_accreditedfumigation' => $this->input->post('nameof_accreditedfumigation'),
            'dppqs_accreditation_cardno' => $this->input->post('dppqs_accreditation_cardno'),
            'dppqs_accreditation_cardno' => $this->input->post('dppqs_accreditation_cardno'),
            'dppqs_date' => $this->input->post('dppqs_date'),
            'description_of_goods' => $this->input->post('description_of_goods'),
            'quantity_declared' => $this->input->post('quantity_declared'),
            'distinguishing_marks' => $this->input->post('distinguishing_marks'),
            'consignment_link_container_no' => $this->input->post('consignment_link_container_no'),
            'rfid_e_seal' => $this->input->post('rfid_e_seal'),
            'port_country_of_loading' => $this->input->post('port_country_of_loading'),
            'declared_point_of_entry' => $this->input->post('declared_point_of_entry'),
            'country_of_destination' => $this->input->post('country_of_destination'),
            'fumigant_name' => $this->input->post('fumigant_name'),
            'date_of_treatment' => $this->input->post('date_of_treatment'),
            'place_of_fumigation' => $this->input->post('place_of_fumigation'),
            'dosage_rate_of_fumigant' => $this->input->post('dosage_rate_of_fumigant'),
            'duration_of_fumigation' => $this->input->post('duration_of_fumigation'),
            'minimum_air_temperature' => $this->input->post('minimum_air_temperature'),
            'fumigation_under_gas_tight_sheet' => $this->input->post('fumigation_under_gas_tight_sheet'),
            'container_pressure_test_conducted' => $this->input->post('container_pressure_test_conducted'),
            'container_free_air_space' => $this->input->post('container_free_air_space'),
            'in_transit_fumigation_ventilation' => $this->input->post('in_transit_fumigation_ventilation'),
            'container_ventilation_below_5ppm' => $this->input->post('container_ventilation_below_5ppm'),
            'fumigation_prior_to_finishing' => $this->input->post('fumigation_prior_to_finishing'),
            'plastic_wrapping_used' => $this->input->post('plastic_wrapping_used'),
            'fumigated_prior_to_wrapping' => $this->input->post('fumigated_prior_to_wrapping'),
            'plastic_wrapping_slashed' => $this->input->post('plastic_wrapping_slashed'),
            'timber_thickness_and_spacing' => $this->input->post('timber_thickness_and_spacing'),
        );

        if ($this->input->post('mode') == 'Edit') {
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('tbl_createfumigation', $data);
            $redirect_id = $this->input->post('id');
        } else {
            $this->db->insert('tbl_createfumigation', $data);
            $redirect_id = $this->db->insert_id();
        }

        redirect('create_fumigation/view/' . $redirect_id);
    }

    public function update()
    {
        $export_invoice = $this->input->post('export_invoice'); 
        $id = $this->fumigation->get_id_by_export_invoice($export_invoice); 
        
        $data = array(
            'consigner_exporter' => $this->input->post('consigner_exporter'),
            'consignee_importer' => $this->input->post('consignee_importer'),
			'dppqs_number' => $this->input->post('dppqs_number'),
            'treatment_certificate_number' => $this->input->post('treatment_certificate_number'),
            'date_of_issue' => $this->input->post('date_of_issue'),
            'nameof_accreditedfumigation' => $this->input->post('nameof_accreditedfumigation'),
            'dppqs_accreditation_cardno' => $this->input->post('dppqs_accreditation_cardno'),
            'dppqs_date' => $this->input->post('dppqs_date'),
            'description_of_goods' => $this->input->post('description_of_goods'),
            'quantity_declared' => $this->input->post('quantity_declared'),
            'distinguishing_marks' => $this->input->post('distinguishing_marks'),
            'consignment_link_container_no' => $this->input->post('consignment_link_container_no'),
            'rfid_e_seal' => $this->input->post('rfid_e_seal'),
            'port_country_of_loading' => $this->input->post('port_country_of_loading'),
            'declared_point_of_entry' => $this->input->post('declared_point_of_entry'),
            'country_of_destination' => $this->input->post('country_of_destination'),
            'fumigant_name' => $this->input->post('fumigant_name'),
            'date_of_treatment' => $this->input->post('date_of_treatment'),
            'place_of_fumigation' => $this->input->post('place_of_fumigation'),
            'dosage_rate_of_fumigant' => $this->input->post('dosage_rate_of_fumigant'),
            'duration_of_fumigation' => $this->input->post('duration_of_fumigation'),
            'minimum_air_temperature' => $this->input->post('minimum_air_temperature'),
            'fumigation_under_gas_tight_sheet' => $this->input->post('fumigation_under_gas_tight_sheet'),
            'container_pressure_test_conducted' => $this->input->post('container_pressure_test_conducted'),
            'container_free_air_space' => $this->input->post('container_free_air_space'),
            'in_transit_fumigation_ventilation' => $this->input->post('in_transit_fumigation_ventilation'),
            'container_ventilation_below_5ppm' => $this->input->post('container_ventilation_below_5ppm'),
            'fumigation_prior_to_finishing' => $this->input->post('fumigation_prior_to_finishing'),
            'plastic_wrapping_used' => $this->input->post('plastic_wrapping_used'),
            'fumigated_prior_to_wrapping' => $this->input->post('fumigated_prior_to_wrapping'),
            'plastic_wrapping_slashed' => $this->input->post('plastic_wrapping_slashed'),
            'timber_thickness_and_spacing' => $this->input->post('timber_thickness_and_spacing')
        );

        $update_status = $this->fumigation->update_fumigation($data, $export_invoice);

        if ($update_status) {
            $this->session->set_flashdata('success', 'Data updated successfully.');
            redirect('create_fumigation/view/' . $id); 
        } else {
            $this->session->set_flashdata('error', 'Failed to update data.');
            redirect('create_fumigation/edit_fumigation/' . $export_invoice);
        }
    }

    public function view($id)
    {
        $this->load->model('admin_company_detail');    
        $company = $this->admin_company_detail->s_select();
        $data = $this->fumigation->fumigation_data($id);
        $menu_data = $this->menu->usermain_menu($this->session->usertype_id);
        $this->load->view('admin/view_fumigation', array('invoicedata' => $data, 'menu_data' => $menu_data,'company_detail'=>$company));
    }
}
?>
