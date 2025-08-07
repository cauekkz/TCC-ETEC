<?php
function validate($data)
{
    $errors = [];

    if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL) || !str_ends_with($data['email'], '@etec.sp.gov.br')) {
        $errors[] = 'Email inválido';
    }

    if (empty($data['password']) || strlen($data['password']) < 8) {
        $errors[] = 'A senha precisa ter pelo menos 8 caracteres';
    }

    if (!in_array($data['role'],["student","teacher","admin"])) {
        $errors[] = 'tipo de usuário não permitido';
    }
    if ($data["conf_password"] != $data['password']) {
        $errors[] = 'Senhas diferentes';
    }
    
    if (empty($data['name']) || strlen($data['name']) < 3) {
        $errors[] = 'Nome muito curto';
    }

    return $errors;
}
    