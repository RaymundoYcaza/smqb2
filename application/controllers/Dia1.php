<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dia1 extends CI_Controller
{
    public function index()
    {
        if (!is_logged_in()) {
            // Obtén la URL actual
            $current_url = current_url();

            // Redirige a Auth/login con la URL actual como parámetro
            redirect('Auth/loginDole?redirect_url=' . urlencode($current_url));
        }

        $this->load->view('Dia1/ShowVideo');
    }
}
