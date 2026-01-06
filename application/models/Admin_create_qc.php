<?php
class Admin_create_qc extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function insert_qc($data) {
        $this->db->insert('tbl_createqc', $data);
        return $this->db->insert_id();
    }

    public function update_qc($data, $production_mst_id)
    {
        $this->db->where('production_mst_id', $production_mst_id);
        return $this->db->update('tbl_createqc', $data);
    }

    public function select_invoice_data($production_mst_id)
    {
        $this->db->where('production_mst_id', $production_mst_id);
        $query = $this->db->get('tbl_createqc');
        return $query->result();
    }

    public function get_id_by_production_mst_id($production_mst_id)
    {
        $this->db->select('id');
        $this->db->from('tbl_createqc');
        $this->db->where('production_mst_id', $production_mst_id);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row()->id;
        }
        return false;
    }

    public function select_data($id)
    {
        $this->db->where('production_mst_id', $id);
        return $this->db->get('tbl_createqc')->row_array();
    }

    public function get_by_production_mst_id_consigner_consignee($production_mst_id, $consigner_exporter, $consignee_importer)
    {
        $this->db->where('production_mst_id', $production_mst_id);
        $this->db->where('consigner_exporter', $consigner_exporter);
        $this->db->where('consignee_importer', $consignee_importer);
        $query = $this->db->get('tbl_createqc');
        return $query->row();
    }

    public function qc_data($production_mst_id)
    {
        $this->db->where('production_mst_id', $production_mst_id);
        $query = $this->db->get('tbl_createqc');
        return $query->row_array();
    }
}
?>
