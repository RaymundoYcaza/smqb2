<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Answers extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Answer_model');
        $this->load->model('User_model');
        $this->load->database();
    }

    public function recordAnswer()
    {
        // Verifica que la solicitud sea AJAX
        if ($this->input->is_ajax_request()) {
            // Obtén los datos JSON de la solicitud
            $data = json_decode($this->input->raw_input_stream, true);

            if (isset($data['answers'])) {
                // Procesa las respuestas
                $answers = $data['answers'];
                $logged_in_user = $this->User_model->get_logged_in_user();

                // Inicia la transacción
                $this->db->trans_start();

                // Guarda cada respuesta en la base de datos
                foreach ($answers as $question_id => $answer_id) {
                    $this->Answer_model->save_answer($logged_in_user, $question_id, $answer_id);
                }

                // Completa la transacción
                $this->db->trans_complete();

                // Verifica el estado de la transacción
                if ($this->db->trans_status() === FALSE) {
                    // Si algo falla, deshace todas las operaciones de la transacción
                    echo json_encode(['status' => 'error', 'message' => 'Error al guardar las respuestas']);
                } else {
                    // Si todo es exitoso, confirma la transacción
                    echo json_encode(['status' => 'success', 'message' => $answers]);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No se encontraron respuestas']);
            }
        } else {
            show_error('No direct script access allowed');
        }
    }
}
