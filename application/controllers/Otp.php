<?php
defined("BASEPATH") or exit('No direct script access allowed');

require '/home3/zukuonli/public_html/apps/latest/phpmailers/phpmailer/src/Exception.php';
require '/home3/zukuonli/public_html/apps/latest/phpmailers/phpmailer/src/PHPMailer.php';
require '/home3/zukuonli/public_html/apps/latest/phpmailers/phpmailer/src/SMTP.php';



use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Otp extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Otp_model');
        $this->load->helper('url');
        $this->load->library('session');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");
    }

    public function index() {
        if ($this->session->userdata('otp_verified')) {
            redirect(base_url('dashboard'));
        } else if ($this->input->post('otp')) {
            $this->verifyOtp();
            return;
        }
        $this->load->view('admin/otpview');
    }
    
    public function sendOtp() {
        header('Content-Type: application/json');
        $rawInput = file_get_contents('php://input');
        $postData = json_decode($rawInput, true);
    
        if (isset($postData['user_id'], $postData['email'], $postData['user_name'])) {
            $userId = $postData['user_id'];
            $email = $postData['email'];
            $username = $postData['user_name'];
            $otp = rand(100000, 999999);
            date_default_timezone_set('Asia/Kolkata'); 
            $dateTime = date('d-m-Y H:i:s');
            
    
            $isAdmin = $this->Otp_model->isAdmin($userId);
    
           // if ($isAdmin) {
                $adminUserId = 1; 
                $adminEmail = $this->Otp_model->getUserEmail($adminUserId);
    
                if ($adminEmail) {
                    if ($this->Otp_model->storeOtp($userId, $otp, $email)) {
                        $subject = 'Your One-Time Password (OTP) for Secure Access';
                        $message = "
                        Dear $username ,<br><br>
                        To complete your login, please use the following One-Time Password (OTP):<br><br>
                        <strong>$otp</strong><br><br>
                        Login request sent at: $dateTime<br><br>
                        Please use this code as soon as possible. Do not share this code with anyone. If you did not request this OTP, please contact our support team immediately.<br><br>
                        Stay secure,<br>
                        Zuku Team
                        ";
    
                        if ($this->send_email($adminEmail, $subject, $message)) {
                            $this->session->set_userdata('otp_user_id', $userId);
                            $this->session->set_userdata('otp_email', $email);
    
                            echo json_encode(['success' => true, 'message' => 'OTP Has Been Sent Successfully to Admin Email.']);
                        } else {
                            echo json_encode(['success' => false, 'error' => 'Failed To Send OTP to Admin Email. Please try again.']);
                        }
                    } else {
                        echo json_encode(['success' => false, 'error' => 'Failed To Store OTP.']);
                    }
                } else {
                    echo json_encode(['success' => false, 'error' => 'Admin Email not found.']);
                }
            // } else {
                // echo json_encode(['success' => false, 'error' => 'User is not authorized to send OTP.']);
            // }
        } else {
            echo json_encode(['success' => false, 'error' => 'Missing required parameters.']);
        }
        exit;
    }
    
    
    
    public function verifyOtp() {
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url());
        } else {
            $otp = $this->input->post('otp');
            $userId = $this->session->userdata('otp_user_id');
            $email = $this->session->userdata('otp_email');
            
            if ($this->Otp_model->verifyOtp($userId, $otp, $email)) {
                $this->session->set_userdata('otp_verified', true);
                redirect(base_url('dashboard'));
            } else {
                $data['error'] = 'Invalid OTP. Please try again.';
                $this->load->view('admin/otpview', $data);
            }
        }
    }
    
    // private function send_email($to, $subject, $message) {
        // $mail = new PHPMailer(true);
    
        // try {
            // $mail->isSMTP();
            // $mail->Host = 'smtp.gmail.com';
            // $mail->SMTPAuth = true;
            // $mail->Username = 'maverickstesters20@gmail.com';
            // $mail->Password = 'cgqp ghhe fdfc zfxe';
            // $mail->SMTPSecure = 'tls';
            // $mail->Port = 587;
    
            // $mail->setFrom('maverickstesters20@gmail.com', 'SecureNotify');
            // $mail->addAddress($to);
    
            // $mail->isHTML(true);
            // $mail->Subject = $subject;
            // $mail->Body = $message;
    
            // $mail->send();
            // return true;
        // } catch (Exception $e) {
            // return false;
        // }
    // }
	
	  private function send_email($to, $subject, $message) {
        $mail = new PHPMailer(true);
    
       try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'dev.zuku@gmail.com';
            $mail->Password = 'ybtb ebhq jwtb rnul';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
    
            $mail->setFrom('dev.zuku@gmail.com', 'Zuku Software');
            $mail->addAddress($to);
    
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;
    
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
?>
