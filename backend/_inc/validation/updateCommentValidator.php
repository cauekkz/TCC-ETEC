<?php

function validate($data)
{
    $errors = [];

    if (empty($data['id_comment']) || !is_numeric($data['id_comment'])) {
        $errors[] = 'ID do comment inválido';
    }

    if (empty($data['content'])) {
        $errors[] = 'O conteúdo precisa ter pelo menos 5 caracteres';
    }

    return $errors;
}