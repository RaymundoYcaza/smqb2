<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function register()
    {
        if ($this->input->post()) {
            $username = $this->input->post('username');
            $password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);

            $this->load->model('User_model');
            $this->User_model->register([
                'username' => $username,
                'password' => $password
            ]);

            redirect('auth/login');
        }

        $this->load->view('Auth/register');
    }

    public function login()
    {
        if ($this->input->post()) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $this->load->model('User_model');
            $user = $this->User_model->get_user($username);

            if ($user && password_verify($password, $user['password'])) {
                $this->session->set_userdata('user_id', $user['id']);
                redirect('Welcome');
            } else {
                $this->session->set_flashdata('error', 'Invalid login credentials');
            }
        }

        $this->load->view('auth/login');
    }

    public function loginDole()
    {
        // Recupera el parámetro redirect_url
        $redirect_url = $this->input->get('redirect_url');

        if ($this->input->post()) {
            $username = $this->input->post('username');
            $password = 'Dominito'; // Fixed password
            $redirect_url = $this->input->post('redirect_url'); // Recupera desde el formulario

            $this->load->model('User_model');
            $user = $this->User_model->get_user($username);

            if ($user && password_verify($password, $user['password'])) {
                $this->session->set_userdata('user_id', $user['id']);

                // Redirige a la URL almacenada en el parámetro redirect_url si existe, de lo contrario redirige a Welcome
                redirect($redirect_url ? $redirect_url : 'Welcome');
            } else {
                $this->session->set_flashdata('error', 'Invalid login credentials');
            }
        }

        $this->load->view('auth/login', compact('redirect_url'));
    }

    public function logout()
    {
        $this->session->unset_userdata('user_id');
        redirect('auth/login');
    }
}
