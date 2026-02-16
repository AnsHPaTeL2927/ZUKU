<?php
defined("BASEPATH") or exit("no direct script allowed");

/**
 * Production Reminder Controller
 * Call via cron job daily to send production reminder emails.
 * PRODUCTION REMINDER - Fires when PSC estimated date is within X days (configurable in Setting > On/Off Setting).
 *
 * Cron command (run daily at 9:00 AM):
 *   php /path/to/ZUKU/index.php production_reminder send_reminders
 *
 * Windows Task Scheduler:
 *   php C:\xampp\htdocs\ZUKU\index.php production_reminder send_reminders
 *
 * Linux cron (crontab -e):
 *   0 9 * * * cd /path/to/ZUKU && php index.php production_reminder send_reminders
 */
class Production_reminder extends CI_controller
{
	function __construct()
	{
		parent::__construct();
		// Skip auth when run from CLI (cron)
		if (!$this->input->is_cli_request()) {
			$this->load->library('session');
			if (!isset($_SESSION['id']) || empty($this->session->id)) {
				show_error('Access denied. This action must be run via CLI (cron).', 403);
				exit;
			}
		}
		$this->load->model('Settingmodel', 'setting');
		$this->load->model('Admin_pdf', 'admin_pdf');
		$this->load->library('Email_service');
	}

	/**
	 * Send production reminder emails for sheets due within configured days.
	 * Run via cron: php index.php production_reminder send_reminders
	 */
	public function send_reminders()
	{
		$is_cli = $this->input->is_cli_request();
		$log = function ($msg) use ($is_cli) {
			log_message('info', 'Production_reminder: ' . $msg);
			if ($is_cli) {
				echo $msg . "\n";
			}
		};

		$log('Production reminder process started.');

		// Get reminder days from settings (ciadmin_login.production_reminder_days)
		$setting = $this->setting->setting_data(1);
		$days = isset($setting->production_reminder_days) && $setting->production_reminder_days !== '' && $setting->production_reminder_days !== null
			? (int) $setting->production_reminder_days
			: 2;
		if ($days <= 0) {
			$days = 2;
		}

		// Get production records due within X days
		$records = $this->admin_pdf->get_production_reminder_records($days);

		if (empty($records)) {
			$log('No production sheets with exactly ' . $days . ' day(s) left. Skipping email.');
			return;
		}

		$count = count($records);
		$log('Found ' . $count . ' production sheet(s) with exactly ' . $days . ' day(s) left. Sending email...');

		$sent = $this->email_service->send_production_reminder_email($records, $days);

		if ($sent) {
			$log('Production reminder email sent successfully to admin.');
		} else {
			$log('Failed to send production reminder email. Check logs and admin email configuration.');
		}
	}
}
