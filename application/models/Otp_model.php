<?php
class Otp_model extends CI_Model {
    
    public function getUserByEmail($email) {
        $query = $this->db->get_where('tbl_user', array('email' => $email));
        return $query->row_array();
    }

    public function storeOtp($userId, $otp, $email) {
        $data = array(
            'user_id' => $userId,
            'otp' => $otp,
            'email'=>$email,
            'created_at' => date('Y-m-d H:i:s')
        );
        return $this->db->insert('tbl_user_otp', $data);
    }
    
    public function verifyOtp($userId, $submitted_otp, $email) {
        
        $this->db->select('otp');
        $this->db->where('user_id', $userId);
        $this->db->where('email', $email);
        $this->db->order_by('created_at', 'desc'); 
        $this->db->limit(1); 
        $query = $this->db->get('tbl_user_otp');
        
        if ($query->num_rows() == 1) {
            $row = $query->row();
            $stored_otp = $row->otp;
            
            if ($submitted_otp == $stored_otp) {
               
                $this->db->where('user_id', $userId);
                $this->db->where('email', $email);
                $this->db->delete('tbl_user_otp');
                return true;
            }
        }
        
        return false;
    }

    public function isAdmin($userId) {
        $this->db->select('usertype_id');
        $this->db->where('user_id', $userId);
        $query = $this->db->get('tbl_user');

        if ($query->num_rows() > 0) {
            $user = $query->row();
            return $user->usertype_id == 1; 
        }

        return false; 
    }

    public function getUserEmail($userId) {
        $this->db->select('email');
        $this->db->where('user_id', $userId);
        $query = $this->db->get('tbl_user');

        if ($query->num_rows() > 0) {
            $user = $query->row();
            return $user->email; 
        }

        return false; 
    }
    
}
?>
