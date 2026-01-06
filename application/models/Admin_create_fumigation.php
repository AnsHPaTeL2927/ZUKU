<?php
class Admin_create_fumigation extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function insert_fumigation($data) {
        $this->db->insert('tbl_createfumigation', $data);
        return $this->db->insert_id();
    }

    public function update_fumigation($data, $id)
    {
        $this->db->where('export_invoice', $id);
        return $this->db->update('tbl_createfumigation', $data);
    }

    public function get_id_by_export_invoice($export_invoice)
    {
        $this->db->select('id');
        $this->db->from('tbl_createfumigation');
        $this->db->where('export_invoice', $export_invoice);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row()->id;
        }
        return false;
    }
	
	

    public function select_data($id)
    {
        $this->db->where('export_invoice', $id);
        return $this->db->get('tbl_createfumigation')->row_array();
    }

    public function select_invoice_data($id)
    {
        $this->db->where('export_invoice', $id);
        $query = $this->db->get('tbl_createfumigation');
        return $query->result();
    }

    public function insert($data)
    {
        $this->db->insert('tbl_createfumigation', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('export_invoice', $id);
        return $this->db->update('tbl_createfumigation', $data);
    }

    public function get_fumigation_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('tbl_createfumigation');
        return $query->row();
    }

    public function get_by_export_invoice_consigner_consignee($export_invoice, $consigner_exporter, $consignee_importer)
    {
        $this->db->where('export_invoice', $export_invoice);
        $this->db->where('consigner_exporter', $consigner_exporter);
        $this->db->where('consignee_importer', $consignee_importer);
        $query = $this->db->get('tbl_createfumigation');
        return $query->row();
    }

    public function fumigation_data($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('tbl_createfumigation');
        return $query->row_array();
    }
}
?>
