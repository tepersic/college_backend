<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// College Api kontroler
// getFollowCollege - dobivanje lista fakulteta i favorita po useru
// setFollowCollege - kad se stisne gumb za favorite doda se ili se mice fakultet iz favorita
// getCollegeDetail - dobivanje detalja fakulteta nakon sta se pritisne kartica tog fakulteta

class College extends CI_Controller {

    public function __construct() { 
        parent::__construct();
        
        
        $this->load->model('college_m');

        
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

        
    }

	public function index()
	{
		var_dump("This is Restful Api controller");
	}

    public function getFollowCollege($user_id)  //  lista fakulteta i lista favorita
    {
        echo json_encode($this->college_m->getFollowCollege($user_id));
    }

    public function getFavourtieCollege($user_id)
    {
        echo json_encode($this->college_m->getFavourtieCollege($user_id));
    }

    public function setFollowCollege()
    {
        $college_id = $this->input->post('college_id');
        $user_id = $this->input->post('user_id');
        $follow = $this->input->post('follow');
        
        if($follow == 1)    // dodavanje fakulteta u favorite 
            $this->college_m->insertFollow($user_id, $college_id);
        else                // micanje fakulteta iz favorita
            $this->college_m->removeFollow($user_id, $college_id);

        echo "success";
    }

    public function getCollegeDetail($college_id)   // dobivanje detalja fakulteta
    {
        echo json_encode($this->college_m->getCollegeDetail($college_id));
    }
}
