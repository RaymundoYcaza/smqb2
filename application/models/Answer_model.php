<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Answer_model extends CI_Model
{
    public function save_answer($user, $question_id, $answer_id)
    {
        $gmtMinusFive = strtotime('-5 hours');

        $username = isset($user['username']) ? $user['username'] : null;

        $data = [
            'username' => $username,
            'question_id' => $question_id,
            'answer_id' => $answer_id,
            'created_at' => gmdate('Y-m-d H:i:s', $gmtMinusFive), // Ajusta la fecha a GMT-5
        ];

        log_message('info', 'Datos a insertar: ' . print_r($data, true));

        $this->db->insert('user_answers', $data);

        if (!$this->db->affected_rows()) {
            log_message('error', 'Error al insertar en la tabla user_answers: ' . $this->db->last_query());
        }
    }
}
