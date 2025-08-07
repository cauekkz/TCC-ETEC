<?php
function validate($data) {
    $errors = [];

    if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL) || !str_ends_with($data['email'], '@etec.sp.gov.br')) {
        $errors[] = 'Email inválido';
    }
    
    if (empty($data['password']) || strlen($data['password']) < 8) {
        $errors[] = 'A senha precisa ter pelo menos 8 caracteres';
    }

    return $errors;
}
