<?php
class Supplier_list_model extends CI_model
{
	public function __construct()
	{
		parent:: __construct();	
		$this->load->database();
	}
	
	public function companydata()
	{
		$q = $this->db->select('*')
			 ->from('tbl_supplier')
			
			->get();
		return $q->result();
	} 
	
	public function select_companydata()
	{
		$q = $this->db->select('supplier_other_company')
			 ->from('tbl_supplier')
			
			->get();
		return $q->result();
	} 
	
	public function bank_select()
	 {
		$q= $this->db->select("mst.*")
			 ->from("bank_master as mst")
			 //->where('mst.status',"0")
			->where('mst.id not in (select supplier_id from tbl_supplier where supplier_id = mst.id ) and mst.id !=',0)
			 ->get();
			  
		 return $q->result();
	 }
	 
	public function check_company_name($company_name)
	{
		$this->db->where('status',0);
		$this->db->where('company_name',$company_name);
		$q = $this->db->get('tbl_supplier');
		return $q->row();
	}
	
	public function terms_insert($data1)
	{
		$id = $this->db->insert('tbl_payment_terms',$data1); 
		return $this->db->insert_id();
	}
	
	public function check_terms_update($supplier_payment_terms)
	{
		$q=$this->db->where('payment_terms',$supplier_payment_terms);
		
		$q=$this->db->get('tbl_payment_terms');

		return $q->row();
	}
	
	public function supplier_select()
	{
		$q=$this->db->order_by('supplier_id','desc');
		$q=$this->db->get('tbl_supplier');
		return $q->result();
	}
	
	public function getsupplierproduct_record($id)
	{
		$id = implode(",",$id);
		$q = $this->db->select("mst.*,series.series_name, product.size_type_mm, product.size_width_mm, product.size_height_mm, product.thickness,size.*,supplier.supplier_name,supplier.company_name")
			->from("tbl_product_size as size")
			->join("tbl_product as product",'product.product_id = size.product_id','inner')
			->join("tbl_supplier_product as  mst",'mst.product_id = product.product_id','inner')
		 	->join("tbl_series as series",'series.series_id = product.series_id','inner')
			->join("tbl_supplier as supplier",'supplier.supplier_id = mst.supplier_id','inner')
			->where("size.product_size_id in (".$id.") and size.product_size_id !=",0)
			->get();
		  
		return $q->result();
	}
	public function supplierinsert($data)
	{
		$q = $this->db->insert('tbl_supplier',$data);
		return $this->db->insert_id();
	}
	public function getsupplier_record($id)
	{
		$q = $this->db->where("supplier_id",$id);
		$q = $this->db->get('tbl_supplier');
		//echo $this->db->last_query();
		return $q->row();
	}
	public function supplierupdate($data,$id)
	{
		$this->db->where('supplier_id', $id); 
		return $this->db->update('tbl_supplier',$data); 
	}
	public function delete_supplier($id){
		
		$this->db->where('supplier_id',$id);
		return $this->db->delete('tbl_supplier');
	}
	public function allproductsize()
	{
		 $q= $this->db->select("mst.*,series.series_name,detail.orderby,series.hsnc_code")
			 ->from("tbl_product as mst")
			 ->join("tbl_series as series","series.series_id=mst.series_id","LEFT")
			 ->join("product_code_detail as detail","detail.hsnc_code=series.hsnc_code","LEFT")
			 ->order_by('detail.orderby asc, series.series_name asc, mst.product_id desc')
			 ->where('mst.status',"0")
			 ->get();
		 return $q->result();
	}
	public function delete_supplierproduct($id)
	{
		$q = $this->db->where('supplier_id',$id);
		$q = $this->db->delete('tbl_supplier_product');
		return $q;
	}
	public function insertsupplierproduct($product_id,$supplier_id)
	{
		    $copyqry = 'INSERT INTO tbl_supplier_product(
				product_id,
				supplier_id,
				rate,
				price_type,
				total_price,
				usd_per_box,
				our_selling_price,
				profit_price,
				pallet_charges,
				fob_expenenses
				)  
				SELECT 
				'.$product_id.',
				'.$supplier_id.',
				0,0,0,0,0,0,0,0  
			FROM  tbl_product as product  WHERE product.product_id='.$product_id; 
			return $this->db->query($copyqry);
 	}
	public function getaddedproduct($id)
	{
		$q = $this->db->select("mst.*, series.series_name, product.size_type_mm, product.thickness, size.product_packing_name, size.pcs_per_box,size.weight_per_box,size.sqm_per_box,size.feet_per_box,size.box_per_container,size.total_boxes,size.multi_box_per_container,size.sqm_per_container,size.withoutpallet_sqm_per_container,size.multi_sqm_per_container,size.product_size_id")
			->from("tbl_supplier_product as mst")
			->join("tbl_product as product",'product.product_id = mst.product_id','inner')
			->join("tbl_product_size as size",'size.product_id = product.product_id','inner')
			->join("tbl_series as series",'series.series_id = product.series_id','inner')
			->where("supplier_id",$id)
			->get();
		// echo $this->db->last_query();
		return $q->result();
	}
	public function delete_onesupplierproduct($id)
	{
		
		$this->db->where('supplier_product_id',$id);
		return $this->db->delete('tbl_supplier_product');
	}
	 public function gettermsdata()
	{
		$q = $this->db->where('status !=','2');
		$q = $this->db->get('tbl_terms');
		return $q->result();
	}
	public function getsupplier_product_record($id)
	{
		$id = implode(",",$id);
		$q = $this->db->select("mst.*,series.series_name, product.size_type_mm, product.size_width_mm, product.size_height_mm, product.thickness,size.*,supplier.supplier_name,supplier.company_name,(select product_rate_per from  tbl_design_suppiler_rate where product_id = product.product_id and supplier_id = supplier.supplier_id limit 0,1) as product_rate_per,(select design_rate from  tbl_design_suppiler_rate where product_id = product.product_id and supplier_id = supplier.supplier_id limit 0,1) as design_rate")
			->from("tbl_product_size as size")
			->join("tbl_product as product",'product.product_id = size.product_id','inner')
			->join("tbl_supplier_product as  mst",'mst.product_id = product.product_id','inner')
		 	->join("tbl_series as series",'series.series_id = product.series_id','inner')
			->join("tbl_supplier as supplier",'supplier.supplier_id = mst.supplier_id','inner')
		 	->where("size.product_size_id in (".$id.") and size.product_size_id !=",0)
			->get();
		  
		return $q->result();
	}
	public function edit_product_data($data,$id)
	{
		$this->db->where('supplier_product_id', $id); 
		 return $this->db->update('tbl_supplier_product',$data); 
	}
	public function select_config(){

		$q=$this->db->get('ciadmin_login');
		return $q->row();
	}
	public function get_series($id){

		$q = $this->db->where('product_id',$id);
		$q = $this->db->get('tbl_seriesgroup');
		 
		return $q->result();
	}
	public function check_epcg_data($series_name,$supplier_id)
	{
		$array = array("status"=>0,"epcg_no"=>$series_name,"supplier_id"=>$supplier_id);
		$q= $this->db->where($array);
		$q= $this->db->get("tbl_supplie_epcg");
		return $q->row();
	}
	public function insert_epcg_data($data)
	{
		$q = $this->db->insert('tbl_supplie_epcg',$data);
		return $this->db->insert_id();
	}
	public function get_epcg_data($id)
	{
		$q = $this->db->select("mst.*")
			->from("tbl_supplie_epcg as mst")
			->where("supplier_id",$id)
			->get();
		// echo $this->db->last_query();
		return $q->result();
	}
	public function fetchepcgdata($id){

		$q = $this->db->where('supplie_epcg_id',$id);
		$q = $this->db->get('tbl_supplie_epcg');
		 
		return $q->row();
	}
	public function update_epcgdata($data,$id)
	{
		$this->db->where('supplie_epcg_id', $id); 
		 return $this->db->update('tbl_supplie_epcg',$data); 
	}
	public function deleteepcgrecord($id){
		
		$this->db->where('supplie_epcg_id',$id);
		return $this->db->delete('tbl_supplie_epcg');
	}
	public function insert_quotation($data)
	{
		$q = $this->db->insert('tbl_quotation',$data);
		return $this->db->insert_id();
	}
	public function insert_quotation_trn($data)
	{
		$q = $this->db->insert('tbl_quotation_trn',$data);
		return $this->db->insert_id();
	} 
	public function get_quotation_data($id)
	{
		$q = $this->db->select("mst.*,(select group_concat(distinct series_name) from tbl_quotation_trn as trn 
			inner join tbl_product as product on product.product_id = trn.product_id  
			inner join tbl_series as series on series.series_id = product.series_id  
			where quotation_id = mst.quotation_id and trn.status = 0) as series_name,terms.terms_name")
			->from('tbl_quotation as mst')
			->join('tbl_terms as terms','terms.terms_id = mst.terms_id','inner')
		  	->where('quotation_id',$id) 
		 	->get(); 
			 
		$category = $q->row();
		$category->trn = $this->get_quotation_trn($category->quotation_id);
		return $category;
	}
	public function get_quotation_trn($id)
	{
		$q = $this->db->select("mst.*,series.series_name,product.size_type_mm")
			->from('tbl_quotation_trn as mst')
			->join('tbl_product as product','product.product_id = mst.product_id','inner')
			->join('tbl_series as series','series.series_id = product.series_id','inner')
		 	->where('quotation_id',$id) 
		 	->get(); 
		  
		
		return $q->result();
	}
	
}

?>