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

	/**
	 * PO + supplier details + additional info (when production_mst_id set) for View PO page.
	 */
	public function get_po_view_data($id)
	{
		$q = $this->db->select('po.*, supplier.company_name, supplier.supplier_name, supplier.address,
			p_add.made_in_india_status, p_add.air_bag_status, p_add.mosqure_bag_status, p_add.safety_belt,
			cap.pallet_cap_name, fumigation.fumigation_name')
			->from('tbl_purchase_order as po')
			->join('tbl_supplier as supplier', 'supplier.supplier_id = po.seller_id', 'LEFT')
			->join('tbl_performa_additional_detail as p_add', 'p_add.production_mst_id = po.production_mst_id', 'LEFT')
			->join('tbl_fumigation as fumigation', 'fumigation.fumigation_id = p_add.fumigation_id', 'LEFT')
			->join('tbl_pallet_cap as cap', 'cap.pallet_cap_id = p_add.pallet_cap_id', 'LEFT')
			->where('po.purchase_order_id', (int) $id)
			->get();
		return $q->row();
	}

	/**
	 * Trn rows with product/size for standalone PO. Packing (design, finish, pallet, box) via getpurchaseproductrate.
	 */
	public function get_standalone_po_trns($id)
	{
		$q = $this->db->select('mst.*, pro.size_type_mm, pro.size_type_cm, size.pcs_per_box, size.sqm_per_box, size.boxes_per_pallet, size.product_packing_name, ser.series_name')
			->from('tbl_purchaseordertrn as mst')
			->join('tbl_product as pro', 'pro.product_id = mst.product_id', 'LEFT')
			->join('tbl_series as ser', 'ser.series_id = pro.series_id', 'LEFT')
			->join('tbl_product_size as size', 'size.product_size_id = mst.product_size_id', 'LEFT')
			->where('mst.purchase_order_id', (int) $id)
			->get();
		return $q->result();
	}

	public function update_performa($id)
	{
		 
		$data = array("po_status"=>0);
		$this->db->where('production_mst_id in ('.$id.') and production_mst_id  !=',0);	
		return $this->db->update('tbl_production_mst',$data);	
			
	}
	
}

?>
