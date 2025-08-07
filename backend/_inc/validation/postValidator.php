<?php 

function validate($data) {
    $errors = [];
    if (empty($data['server_id']) || !is_numeric($data['server_id'])) {
        $errors[] = 'ID do servidor inválido';
    }

    if (empty($data['content']) || strlen(trim($data['content'])) < 5) {
        $errors[] = 'O conteúdo precisa ter pelo menos 5 caracteres';
    }


    return $errors;
}


?>