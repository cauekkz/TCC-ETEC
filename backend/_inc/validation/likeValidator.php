<?php 

function validate($data) {
    $errors = [];

    if (empty($data['content_type'])) {
        $errors[] = 'content_type é obrigatório';
    }

    if (empty($data['content_id'])) {
        $errors[] = 'content_id é obrigatório';
    }

    return $errors;
}

?>