<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

    public function register($data)
    {
        return $this->db->insert('users', $data);
    }

    public function get_user($username)
    {
        return $this->db->get_where('users', ['username' => $username])->row_array();
    }

    public function get_logged_in_user()
    {
        $user_id = $this->session->userdata('user_id'); // Recupera el ID del usuario desde la sesión
        if ($user_id) {
            return $this->db->get_where('users', ['id' => $user_id])->row_array(); // Busca el usuario en la base de datos
        }
        return null; // Retorna null si no hay usuario logueado
    }
}
