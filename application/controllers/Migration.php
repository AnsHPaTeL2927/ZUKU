<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Only allow in development or with proper authentication
        // For production, add proper authentication here
    }

    public function index()
    {
        $this->load->library('migration');

        if ($this->migration->current() === FALSE)
        {
            show_error($this->migration->error_string());
        }
        else
        {
            echo '<h1>Migration completed successfully!</h1>';
            echo '<p>Current migration version: ' . $this->migration->current() . '</p>';
            echo '<p><a href="' . base_url() . '">Go to Home</a></p>';
        }
    }

    public function latest()
    {
        $this->load->library('migration');

        if ($this->migration->latest() === FALSE)
        {
            show_error($this->migration->error_string());
        }
        else
        {
            echo '<h1>Migration to latest completed successfully!</h1>';
            echo '<p>Current migration version: ' . $this->migration->current() . '</p>';
            echo '<p><a href="' . base_url() . '">Go to Home</a></p>';
        }
    }

    /**
     * Run all migrations: tries migration library first, then direct SQL fallback
     */
    public function run_all()
    {
        $this->load->library('migration');

        // Try standard migration (current = migrate to config version)
        $result = $this->migration->current();

        if ($result === FALSE)
        {
            echo '<p>Standard migration failed: ' . htmlspecialchars($this->migration->error_string()) . '</p>';
            echo '<p>Running direct SQL fallback for tbl_pi_loading_plan...</p>';
            $this->run_sql();
            return;
        }

        echo '<h1>All migrations completed successfully!</h1>';
        if ($result === TRUE)
        {
            echo '<p>No pending migrations (already at current version).</p>';
        }
        else
        {
            echo '<p>Current migration version: ' . htmlspecialchars($result) . '</p>';
        }
        echo '<p><a href="' . base_url() . '">Go to Home</a></p>';
    }

    public function run_sql()
    {
        // Alternative method: Run SQL directly
        $sql = "ALTER TABLE `tbl_pi_loading_plan` 
                ADD COLUMN `way_date` DATE NULL DEFAULT NULL COMMENT 'Date when the shipment is on the way',
                ADD COLUMN `estimated_arrival_date` DATE NULL DEFAULT NULL COMMENT 'Estimated date of arrival' AFTER `way_date`,
                ADD COLUMN `on_the_way_notes` TEXT NULL DEFAULT NULL COMMENT 'Additional notes for on the way status' AFTER `estimated_arrival_date`";

        try
        {
            if ($this->db->query($sql))
            {
                echo '<h1>Migration completed successfully!</h1>';
                echo '<p>All three fields have been added to tbl_pi_loading_plan table.</p>';
                echo '<p><a href="' . base_url() . '">Go to Home</a></p>';
                return TRUE;
            }
        }
        catch (Exception $e)
        {
            if (strpos($e->getMessage(), 'Duplicate column name') !== false)
            {
                echo '<h1>Migration already completed!</h1>';
                echo '<p>The fields already exist in tbl_pi_loading_plan table.</p>';
                echo '<p><a href="' . base_url() . '">Go to Home</a></p>';
                return TRUE;
            }
            throw $e;
        }

        $error = $this->db->error();
        if (!empty($error['message']) && strpos($error['message'], 'Duplicate column name') !== false)
        {
            echo '<h1>Migration already completed!</h1>';
            echo '<p>The fields already exist in the database.</p>';
        }
        else
        {
            show_error('Migration failed: ' . (isset($error['message']) ? $error['message'] : 'Unknown error'));
        }
        echo '<p><a href="' . base_url() . '">Go to Home</a></p>';
        return FALSE;
    }

    /**
     * Run only the tbl_warehouse_master migration (creates the table).
     * Use this if the full migration index fails due to other migrations.
     */
    public function run_warehouse()
    {
        $this->load->database();
        $this->load->library('migration'); // defines CI_Migration and loads dbforge
        $this->load->dbforge();

        $migration_file = APPPATH . 'migrations/20260131100000_create_tbl_warehouse_master.php';
        if (!is_file($migration_file)) {
            show_error('Warehouse migration file not found.');
        }

        include_once($migration_file);
        if (!class_exists('Migration_Create_tbl_warehouse_master', FALSE)) {
            show_error('Warehouse migration class not found.');
        }

        $migration = new Migration_Create_tbl_warehouse_master();
        $migration->up();

        // Update migrations table so index/latest won't re-run this
        $this->db->update('migrations', array('version' => '20260131100000'));

        echo '<h1>Warehouse migration completed successfully!</h1>';
        echo '<p>Table tbl_warehouse_master has been created.</p>';
        echo '<p><a href="' . base_url() . '">Go to Home</a></p>';
    }

    /**
     * Run only the tbl_warehouse_inventory migration (creates the table).
     * Use this if the full migration index fails due to other migrations.
     */
    public function run_warehouse_inventory()
    {
        $this->load->database();
        $this->load->library('migration'); // defines CI_Migration and loads dbforge
        $this->load->dbforge();

        $migration_file = APPPATH . 'migrations/20260201120000_create_tbl_warehouse_inventory.php';
        if (!is_file($migration_file)) {
            show_error('Warehouse inventory migration file not found.');
        }

        include_once($migration_file);
        if (!class_exists('Migration_Create_tbl_warehouse_inventory', FALSE)) {
            show_error('Warehouse inventory migration class not found.');
        }

        $migration = new Migration_Create_tbl_warehouse_inventory();
        $migration->up();

        // Update migrations table so index/latest won't re-run this
        $this->db->update('migrations', array('version' => '20260201120000'));

        echo '<h1>Warehouse inventory migration completed successfully!</h1>';
        echo '<p>Table tbl_warehouse_inventory has been created.</p>';
        echo '<p><a href="' . base_url() . '">Go to Home</a></p>';
    }

    /**
     * Run only the add_new_menu_entry migration (adds menu entry).
     * Use this to add the Stock menu entry directly.
     */
    public function run_menu_entry()
    {
        $this->load->database();
        $this->load->library('migration'); // defines CI_Migration and loads dbforge
        $this->load->dbforge();

        $migration_file = APPPATH . 'migrations/20260206120000_add_new_menu_entry.php';
        if (!is_file($migration_file)) {
            show_error('Menu entry migration file not found.');
        }

        include_once($migration_file);
        if (!class_exists('Migration_Add_new_menu_entry', FALSE)) {
            show_error('Menu entry migration class not found.');
        }

        try {
            $migration = new Migration_Add_new_menu_entry();
            $migration->up();

            // Check if menu was inserted
            $menu_check = $this->db->get_where('tbl_menu', array('url_name' => 'stock'))->row();
            if ($menu_check) {
                // Update migrations table so index/latest won't re-run this
                $this->db->where('version <', '20260206120000');
                $this->db->update('migrations', array('version' => '20260206120000'));

                echo '<h1>Menu entry migration completed successfully!</h1>';
                echo '<p>Menu entry "Stock" has been added to tbl_menu.</p>';
                echo '<p>Menu ID: ' . $menu_check->menu_id . '</p>';
                echo '<p>Permission has been added for user type 1.</p>';
            } else {
                echo '<h1>Migration ran but menu entry not found!</h1>';
                echo '<p>Please check database errors.</p>';
                if ($this->db->error()['code'] != 0) {
                    echo '<p>Database Error: ' . $this->db->error()['message'] . '</p>';
                }
            }
        } catch (Exception $e) {
            echo '<h1>Migration Error!</h1>';
            echo '<p>Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
            if ($this->db->error()['code'] != 0) {
                echo '<p>Database Error: ' . $this->db->error()['message'] . '</p>';
            }
        }

        echo '<p><a href="' . base_url() . '">Go to Home</a></p>';
    }

    /**
     * Run the PI stock entry and stock calculation tables migration.
     * Creates tbl_pi_stock_entry and tbl_stock_calculation.
     */
    public function run_pi_stock_tables()
    {
        $this->load->database();
        $this->load->library('migration');
        $this->load->dbforge();

        $migration_file = APPPATH . 'migrations/20260206140000_create_pi_stock_and_calculation_tables.php';
        if (!is_file($migration_file)) {
            show_error('PI stock tables migration file not found.');
        }

        include_once($migration_file);
        if (!class_exists('Migration_Create_pi_stock_and_calculation_tables', FALSE)) {
            show_error('Migration class Migration_Create_pi_stock_and_calculation_tables not found.');
        }

        $migration = new Migration_Create_pi_stock_and_calculation_tables();
        $migration->up();

        $this->db->where('version <', '20260206140000');
        $this->db->update('migrations', array('version' => '20260206140000'));

        echo '<h1>PI stock tables migration completed successfully!</h1>';
        echo '<p>Tables created: tbl_pi_stock_entry, tbl_stock_calculation.</p>';
        echo '<p><a href="' . base_url() . '">Go to Home</a></p>';
    }

    public function remove_from_performa_invoice()
    {
        // Remove fields from tbl_performa_invoice (they were added by mistake)
        $sql = "ALTER TABLE `tbl_performa_invoice` 
                DROP COLUMN IF EXISTS `way_date`,
                DROP COLUMN IF EXISTS `estimated_arrival_date`,
                DROP COLUMN IF EXISTS `on_the_way_notes`";
        
        if ($this->db->query($sql))
        {
            echo '<h1>Fields removed successfully!</h1>';
            echo '<p>All three fields have been removed from tbl_performa_invoice table.</p>';
            echo '<p><a href="' . base_url() . '">Go to Home</a></p>';
        }
        else
        {
            $error = $this->db->error();
            if (!empty($error['message']))
            {
                // Check if columns don't exist
                if (strpos($error['message'], "doesn't exist") !== false || strpos($error['message'], 'Unknown column') !== false)
                {
                    echo '<h1>Fields already removed!</h1>';
                    echo '<p>The fields do not exist in tbl_performa_invoice table.</p>';
                }
                else
                {
                    // Try individual DROP statements for MySQL compatibility
                    $this->db->query("ALTER TABLE `tbl_performa_invoice` DROP COLUMN `way_date`");
                    $this->db->query("ALTER TABLE `tbl_performa_invoice` DROP COLUMN `estimated_arrival_date`");
                    $this->db->query("ALTER TABLE `tbl_performa_invoice` DROP COLUMN `on_the_way_notes`");
                    echo '<h1>Fields removed successfully!</h1>';
                    echo '<p>All three fields have been removed from tbl_performa_invoice table.</p>';
                }
            }
            else
            {
                echo '<h1>Fields removed successfully!</h1>';
                echo '<p>All three fields have been removed from tbl_performa_invoice table.</p>';
            }
            echo '<p><a href="' . base_url() . '">Go to Home</a></p>';
        }
    }

    /**
     * Add qc_status column to tbl_production_mst (0 = QC Pending, 1 = QC Done).
     */
    public function run_qc_status()
    {
        $this->load->database();
        $this->load->library('migration');
        $this->load->dbforge();

        $migration_file = APPPATH . 'migrations/20260212120000_add_qc_status_to_production_mst.php';
        if (!is_file($migration_file)) {
            show_error('qc_status migration file not found.');
        }

        include_once($migration_file);
        if (!class_exists('Migration_Add_qc_status_to_production_mst', FALSE)) {
            show_error('Migration class not found.');
        }

        try {
            $migration = new Migration_Add_qc_status_to_production_mst();
            $migration->up();
            $this->db->update('migrations', array('version' => '20260212120000'));
            echo '<h1>qc_status migration completed!</h1>';
            echo '<p>Column qc_status added to tbl_production_mst (or already exists).</p>';
        } catch (Exception $e) {
            echo '<h1>Migration Error!</h1>';
            echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
        }
        echo '<p><a href="' . base_url() . 'producation_detail">Go to Production Detail</a></p>';
    }
}
