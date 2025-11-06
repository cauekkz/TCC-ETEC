<?php 

function validate($data) {
    $errors = [];

    if (empty($data['receiver_id'])  || !is_numeric($data['receiver_id'])) {
        $errors[] = 'ID do rementente inválido';
    }

    if ((empty($data['content']) || strlen(trim($data['content'])) < 1 )&& !isset($_FILES['media_file'])) {
        $errors[] = 'menssagem sem conteudo';
    }

    return $errors;
}

?>