<?php

function validate($data)
{
    $errors = [];

    if (empty($data['server_id'])) {
        $errors[] = 'server_id é obrigatório';
    }

    if (empty($data['title'])) {
        $errors[] = 'title é obrigatório';
    }
    if (empty($data['description'])) {
        $errors[] = 'description é obrigatório';
    }
    if (empty($data['type'])) {
        $errors[] = 'type é obrigatório';
    }

    return $errors;
}
