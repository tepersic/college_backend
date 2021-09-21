<?php
class College_m extends CI_Model {  

    public function __construct() {
        parent::__construct();
        
        // ucitavanje baze podataka
        $this->load->database();
        
        $this->userTbl = 'users';           // tablica "users"
        $this->userlikeTbl = 'user_like';   // tablica "user_like"
        $this->collegeTbl = 'colleges';     // tablica "colleges"

    }

    public function getCollegeDetail($college_id) // bit ce odabrana sva polja koja podudaraju s upisanim college_id-om
    {
        $query = $this->db->select('*')->from($this->collegeTbl)->where('id', $college_id)->get();
        $result=$query->row_array();
        return $result;
    }

    public function getFavourtieCollege($user_id) // model za dobivanje samo fakultete koji su u favoritima
    {
        $sql = "SELECT t1.*, t2.user_id
                        FROM colleges t1 LEFT JOIN user_like t2 ON t2.user_id = '$user_id' AND t2.college_id = t1.id                        
                        WHERE t2.user_id IS NOT NULL
                        ORDER BY t1.id";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;   
    }

    public function getFollowCollege($user_id)  // model pomocu kojeg dobivamo listu favorita 
    {
      
        $sql = "SELECT t1.*, IF(IFNULL(t2.user_id, 0) > 0, 1, 0) follow 
                       FROM colleges t1 LEFT JOIN user_like t2 ON t2.user_id = '$user_id' AND t2.college_id = t1.id 
                       ORDER BY t1.id";
        $query = $this->db->query($sql);
        $result = $query->result();

        return $result;   
    }

    public function insertFollow($user_id, $college_id) // dodavanje user_id i college_id u tablicu user_like
    {                                                   
        $array = array(
            'user_id' => $user_id,
            'college_id' => $college_id,
        );
        $this->db->insert($this->userlikeTbl, $array);
    }

    public function removeFollow($user_id, $college_id) // micanje user_id i college_id u tablicu user_like
    {                                                   
        $array = array(
            'user_id' => $user_id,
            'college_id' => $college_id,
        );
        $this->db->delete($this->userlikeTbl, $array);
    }
}