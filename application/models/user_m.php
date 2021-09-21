<?php
class User_m extends CI_Model {

    public function __construct() {
        parent::__construct();
        
        // ucitavanje baze podataka
        $this->load->database();
        
        $this->userTbl = 'users';   // tablica "users"
    }


    public function insert_entry($email, $password) // dodavanje novog korisnika sa $email i $sifrom
    {
        $userData = array(
            'email' => $email,
            'password' => md5($password),   // koristi md5 encode function
        );
        $this->db->insert($this->userTbl, $userData); // dodavanje korisnika u tablicu
        return "success";
    }

    public function checkEmail($email)  // provjera dali email vec postoji 
    {
        // Query = dobivanje svih rezultata koji podudaraju s emailom
        $query = $this->db->select('*')->from($this->userTbl)->where('email', $email)->get();
        $result=$query->result();
        $num_rows=$query->num_rows();

        if($num_rows == 0)  // ako nema emaila koji podudaraju vraca "false"
            return false;
        return true;
    }

    public function attempt($email, $password)  //provjerava email i sifru tijekom prijave
    {
        $where = array(
            'email' => $email,
            'password' => md5($password)
        );

        // dobivanje rezultata prema gore navedenim email i sifrom
        $query = $this->db->select('*')->from($this->userTbl)->where($where)->get();
        $result=$query->row_array();
        
        $num_rows=$query->num_rows();

        // ako postoje rezultati iz baze podataka moguca je prijava
        if($num_rows != 0)
            return $result['id'];
        return 0;
    }

}