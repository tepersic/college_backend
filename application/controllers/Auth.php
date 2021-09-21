<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Auth extends CI_Controller {

	// Auth Api kontroler
    // sign_up - api za registriranje novog usera
    // sign_in - api za provjeru dali postoji korisnik koji se prijavljuje


    public function __construct() { 
        parent::__construct();
        
       
        $this->load->model('user_m');


        

        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

        ///////////////////////////////////////////////
    }

	public function index()
	{
		var_dump("This is Restful Api controller");
	}

    public function sign_up()   // Sign up API
    {
        $email = $this->input->post('email');           // dobivanje Email-a
        $password = $this->input->post('password');     // dobivanje sifre

        if(!empty($email) && !empty($password)) {       // provjera dali su email i sifra prazni
            if($this->user_m->checkEmail($email))       // provjera dali taj zatrazeni email postoji ili ne
            {
                echo "email_exist";                     // ako postoji vraca "email_exist" odgovor 
                return;
            }
            $result = $this->user_m->insert_entry($email, $password);   //ako sve odgovara registrira se novi korisnik
            
            if($result == "success"){   // ako se novi korisnik uspije registrirat vraca "success" odgovor
                echo "success";         
            }else{                      
                echo "failed";          // ako se korisnik ne uspije registrirat vraca "failed" kao odgovor
            }
        }
    }

    public function sign_in()
    {
        $email = $this->input->post('email');       // dobivanje Email-a
        $password = $this->input->post('password'); // dobivanje sifre

        if(!empty($email) && !empty($password)) {   // provjera dali su email i sifra prazni
            if($user_id = $this->user_m->attempt($email, $password)){ // provjerava dali posotji korisnik sa tim email i sifrom 
                echo $user_id;      // ako se korisnik uspije prijavit vraca id korisnika
                return;
            }
            else {  // ako se ne uspije prijavit vraca"failed" kao odgovor
                echo "failed";
                return;
            }
        }
        echo "failed";
    }
}
