<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
}
class ADMIN_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        // if (!$this->session->admin_logged_in) {
        //     $this->session->set_userdata('return_url', current_url());
        //     redirect('admin/auth');
        // }
    }
}
