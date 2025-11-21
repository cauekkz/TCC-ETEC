<?php
function validate($data, $files) {
    $errors = [];

    if (empty($data['title']) || strlen(trim($data['title'])) < 3) {
        $errors[] = 'O título precisa ter pelo menos 3 caracteres';
    }

    if (empty($data['description']) || strlen(trim($data['description'])) < 10) {
        $errors[] = 'A descrição precisa ter pelo menos 10 caracteres';
    }

    if (empty($data['campus_id']) || !is_numeric($data['campus_id'])) {
        $errors[] = 'Campus inválido';
    }

    if (empty($data['course_id']) || !is_numeric($data['course_id'])) {
        $errors[] = 'Curso inválido';
    }

    if (empty($data['member_ids']) || !is_array($data['member_ids']) || count($data['member_ids']) < 1) {
        $errors[] = 'É necessário adicionar pelo menos 1 integrante ao grupo';
    }

    if (empty($files['files']) || count($files['files']['name']) < 1) {
        $errors[] = 'Envie pelo menos 1 arquivo';
    }

    return $errors;
}
?>
