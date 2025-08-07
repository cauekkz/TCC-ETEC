<?php

function validate($data)
{
    $errors = [];

    if (empty($data['id_post']) || !is_numeric($data['id_post'])) {
        $errors[] = 'ID do Post inválido';
    }

    if (empty($data['content'])) {
        $errors[] = 'O conteúdo precisa ter pelo menos 5 caracteres';
    }

    return $errors;
}