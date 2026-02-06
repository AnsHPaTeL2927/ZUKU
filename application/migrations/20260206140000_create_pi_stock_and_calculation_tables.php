<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Creates tables to:
 * 1) Relate which PI (Proforma Invoice) goes to stock when "Add to Inventory" is triggered.
 * 2) Store and manage stock-related calculations (sales, ROP, ETD/ETA, etc.) for the Stock module.
 */
class Migration_Create_pi_stock_and_calculation_tables extends CI_Migration {

	public function up()
	{
		// -------------------------------------------------------------------------
		// Table: tbl_pi_stock_entry – which invoice went to stock (one row per Add to Inventory)
		// -------------------------------------------------------------------------
		if (!$this->db->table_exists('tbl_pi_stock_entry')) {
			$this->dbforge->add_field(array(
				'id' => array(
					'type'           => 'INT',
					'constraint'     => 11,
					'unsigned'       => TRUE,
					'auto_increment' => TRUE
				),
				'performa_invoice_id' => array(
					'type'       => 'INT',
					'constraint' => 11,
					'unsigned'   => TRUE,
					'null'       => FALSE,
					'comment'    => 'FK to tbl_performa_invoice – PI that was added to stock'
				),
				'added_at' => array(
					'type'    => 'DATETIME',
					'null'    => FALSE,
					'comment' => 'When Add to Inventory was triggered'
				),
				'added_by' => array(
					'type'       => 'INT',
					'constraint' => 11,
					'unsigned'   => TRUE,
					'null'       => TRUE,
					'comment'    => 'User ID who triggered Add to Inventory'
				),
				'notes' => array(
					'type'    => 'TEXT',
					'null'    => TRUE,
					'comment' => 'Optional notes for this stock entry'
				),
			));
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->add_key('performa_invoice_id');
			$this->dbforge->add_key('added_at');
			$this->dbforge->create_table('tbl_pi_stock_entry', TRUE);
		}

		// -------------------------------------------------------------------------
		// Table: tbl_stock_calculation – calculations and metrics for Stock Details
		// Links to design/warehouse and optionally to PI (which invoice goes to stock).
		// -------------------------------------------------------------------------
		if (!$this->db->table_exists('tbl_stock_calculation')) {
			$this->dbforge->add_field(array(
				'id' => array(
					'type'           => 'INT',
					'constraint'     => 11,
					'unsigned'       => TRUE,
					'auto_increment' => TRUE
				),
				'performa_invoice_id' => array(
					'type'       => 'INT',
					'constraint' => 11,
					'unsigned'   => TRUE,
					'null'       => TRUE,
					'comment'    => 'FK to tbl_performa_invoice – which PI this row relates to'
				),
				'pi_stock_entry_id' => array(
					'type'       => 'INT',
					'constraint' => 11,
					'unsigned'   => TRUE,
					'null'       => TRUE,
					'comment'    => 'FK to tbl_pi_stock_entry – link to Add to Inventory action'
				),
				'design_id' => array(
					'type'       => 'INT',
					'constraint' => 11,
					'unsigned'   => TRUE,
					'null'       => TRUE,
					'comment'    => 'FK to tbl_packing_model (packing_model_id)'
				),
				'warehouse_id' => array(
					'type'       => 'INT',
					'constraint' => 11,
					'unsigned'   => TRUE,
					'null'       => TRUE,
					'comment'    => 'FK to tbl_warehouse_master – NULL = aggregated'
				),
				'calculation_date' => array(
					'type'    => 'DATE',
					'null'    => TRUE,
					'comment' => 'Date for which calculations are as-of'
				),
				'sku_code' => array(
					'type'       => 'VARCHAR',
					'constraint' => 100,
					'null'       => TRUE,
					'comment'    => 'SKU / item code for display'
				),
				'design_name' => array(
					'type'       => 'VARCHAR',
					'constraint' => 255,
					'null'       => TRUE,
					'comment'    => 'Design name for display'
				),
				'size' => array(
					'type'       => 'VARCHAR',
					'constraint' => 50,
					'null'       => TRUE,
					'comment'    => 'Size (e.g. 60X120)'
				),
				'supplier_country' => array(
					'type'       => 'VARCHAR',
					'constraint' => 255,
					'null'       => TRUE,
					'comment'    => 'Supplier & country for display'
				),
				'warehouse_01_sqm' => array(
					'type'       => 'DECIMAL',
					'constraint' => '12,2',
					'default'    => 0,
					'null'       => FALSE,
					'comment'    => 'Stock in Warehouse 01 [M²]'
				),
				'warehouse_02_sqm' => array(
					'type'       => 'DECIMAL',
					'constraint' => '12,2',
					'default'    => 0,
					'null'       => FALSE,
					'comment'    => 'Stock in Warehouse 02 [M²]'
				),
				'warehouse_03_sqm' => array(
					'type'       => 'DECIMAL',
					'constraint' => '12,2',
					'default'    => 0,
					'null'       => FALSE,
					'comment'    => 'Stock in Warehouse 03 [M²]'
				),
				'total_stock_sqm' => array(
					'type'       => 'DECIMAL',
					'constraint' => '12,2',
					'default'    => 0,
					'null'       => FALSE,
					'comment'    => 'Total stock [M²]'
				),
				'total_sales_6m_sqm' => array(
					'type'       => 'DECIMAL',
					'constraint' => '12,2',
					'default'    => 0,
					'null'       => FALSE,
					'comment'    => 'Total sales last 6 months [M²]'
				),
				'avg_monthly_sales_sqm' => array(
					'type'       => 'DECIMAL',
					'constraint' => '12,2',
					'default'    => 0,
					'null'       => FALSE,
					'comment'    => 'Average monthly sales [M²]'
				),
				'avg_daily_sales_sqm' => array(
					'type'       => 'DECIMAL',
					'constraint' => '12,2',
					'default'    => 0,
					'null'       => FALSE,
					'comment'    => 'Average daily sales [M²]'
				),
				'lead_time_days' => array(
					'type'       => 'INT',
					'constraint' => 11,
					'default'    => 0,
					'null'       => FALSE,
					'comment'    => 'Lead time [days]'
				),
				'safety_stock_days' => array(
					'type'       => 'INT',
					'constraint' => 11,
					'default'    => 0,
					'null'       => FALSE,
					'comment'    => 'Safety stock [days]'
				),
				'reorder_point_sqm' => array(
					'type'       => 'DECIMAL',
					'constraint' => '12,2',
					'default'    => 0,
					'null'       => FALSE,
					'comment'    => 'Reorder point ROP [M²]'
				),
				'days_of_stock_coverage' => array(
					'type'       => 'INT',
					'constraint' => 11,
					'default'    => 0,
					'null'       => FALSE,
					'comment'    => 'Days of stock coverage'
				),
				'etd' => array(
					'type'    => 'DATE',
					'null'    => TRUE,
					'comment' => 'ETD – Estimated time of departure'
				),
				'eta' => array(
					'type'    => 'DATE',
					'null'    => TRUE,
					'comment' => 'ETA – Estimated time of arrival'
				),
				'days_until_delivery' => array(
					'type'       => 'INT',
					'constraint' => 11,
					'default'    => 0,
					'null'       => FALSE,
					'comment'    => 'Days until delivery'
				),
				'days_out_of_stock_before_delivery' => array(
					'type'       => 'INT',
					'constraint' => 11,
					'default'    => 0,
					'null'       => FALSE,
					'comment'    => 'Days out of stock before delivery'
				),
				'lost_sales_sqm' => array(
					'type'       => 'DECIMAL',
					'constraint' => '12,2',
					'default'    => 0,
					'null'       => FALSE,
					'comment'    => 'Lost sales [M²]'
				),
				'created_at' => array(
					'type'    => 'DATETIME',
					'null'    => TRUE,
					'comment' => 'Record created'
				),
				'updated_at' => array(
					'type'    => 'DATETIME',
					'null'    => TRUE,
					'comment' => 'Record updated'
				),
			));
			$this->dbforge->add_key('id', TRUE);
			$this->dbforge->add_key('performa_invoice_id');
			$this->dbforge->add_key('pi_stock_entry_id');
			$this->dbforge->add_key('design_id');
			$this->dbforge->add_key('warehouse_id');
			$this->dbforge->add_key('calculation_date');
			$this->dbforge->create_table('tbl_stock_calculation', TRUE);
		}
	}

	public function down()
	{
		if ($this->db->table_exists('tbl_stock_calculation')) {
			$this->dbforge->drop_table('tbl_stock_calculation', TRUE);
		}
		if ($this->db->table_exists('tbl_pi_stock_entry')) {
			$this->dbforge->drop_table('tbl_pi_stock_entry', TRUE);
		}
	}
}
