<?php
function validate($data)
{
    $errors = [];

    if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL) || !str_ends_with($data['email'], '@etec.sp.gov.br')) {
        $errors[] = 'Email inválido';
    }
    
    if (empty($data['name']) || strlen($data['name']) < 3) {
        $errors[] = 'Nome muito curto';
    }

    return $errors;
}
    