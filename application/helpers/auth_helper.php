<?php
function is_logged_in()
{
    $ci = &get_instance();
    return $ci->session->userdata('user_id') !== null;
}
