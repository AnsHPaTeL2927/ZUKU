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
}
