<?php 
class Admin_purchaseorder_list extends CI_Model{

	public function __construct()
	{
	parent:: __construct();	
	$this->load->database();
		
	}

	public function get_productdetail($id)
	{
		$q = $this->db->where("purchase_order_id",$id);
		$q = $this->db->get('tbl_purchaseordertrn');
		//echo $this->db->last_query();
		return $q->result();
	}
	public function delete_purchase($id){
		
		$data = array("status"=>2);
		$this->db->where('purchase_order_id',$id);
	 
		return $this->db->update('tbl_purchase_order',$data);	
	}
	public function delete_purchasetrn($id){
		
		$q=$this->db->where('purchase_order_id',$id);
		$q=$this->db->delete('tbl_purchaseordertrn');
		$q1=$this->db->where('purchase_order_id',$id);
		$this->db->delete('tbl_purchase_packing');
		return 1;
 	}
	public function po_data($id){
		$q = $this->db->select('po.*,supplier.supplier_name')
			 ->from('tbl_purchase_order as po')
			->join('tbl_supplier as supplier', 'supplier.supplier_id = po.seller_id', 'LEFT')
			->where('purchase_order_id',$id)
			->get();
		  
			return $q->row();
	}
	public function update_performa($id)
	{
		 
		$data = array("po_status"=>0);
		$this->db->where('production_mst_id in ('.$id.') and production_mst_id  !=',0);	
		return $this->db->update('tbl_production_mst',$data);	
			
	}
	
}

?>