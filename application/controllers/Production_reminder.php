<?php
defined("BASEPATH") or exit("no direct script allowed");

/**
 * Production Reminder Controller
 * This controller should be called via cron job daily to send production reminders
 * 3. PRODUCTION REMINDER - It will be delivered before 2 days from manually entry of days of production
 */
class Production_reminder extends CI_controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_Producation', 'producation');
	}
	
	/**
	 * Send production reminders for orders due in 2 days (email removed; kept for cron placeholder).
	 * This should be called via cron: php index.php production_reminder send_reminders
	 */
	public function send_reminders()
	{
		log_message('info', 'Production reminder process run (email notifications disabled).');
		echo "Production reminders: email notifications disabled.\n";
	}
}

