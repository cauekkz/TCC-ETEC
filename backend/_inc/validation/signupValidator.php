<?php
function validate($data)
{
    $errors = [];

    // Validação do e-mail
    if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL) || !str_ends_with($data['email'], '@etec.sp.gov.br')) {
        $errors[] = 'Email inválido';
    }

    // Validação da senha
  if (empty($data['password']) || strlen($data['password']) < 8) {
        $errors[] = 'A senha precisa ter pelo menos 8 caracteres';
    } else {
        if (!preg_match('/[A-Za-z]/', $data['password'])) {
            $errors[] = 'A senha precisa conter pelo menos uma letra';
        }
        if (!preg_match('/\d/', $data['password'])) {
            $errors[] = 'A senha precisa conter pelo menos um número';
        }
        if (!preg_match('/[\W_]/', $data['password'])) {
            $errors[] = 'A senha precisa conter pelo menos um caractere especial';
        }
    }

    if (empty($data['acceptedTerms']) || $data['acceptedTerms'] !== "1") {
        $errors[] = 'Você deve aceitar os Termos e Políticas para continuar.';
    }
    // Validação da confirmação da senha
    if ($data["conf_password"] != $data['password']) {
        $errors[] = 'Senhas diferentes';
    }

    // Validação do nome
    if (empty($data['name']) || strlen($data['name']) < 3) {
        $errors[] = 'Nome muito curto';
    }

    // Validação da data de nascimento
    if (empty($data['birthday'])) {
        $errors[] = 'Data de nascimento obrigatória';
    } else {
        $today = new DateTime();
        $birthday = new DateTime($data['birthday']);

        if ($birthday > $today) {
            $errors[] = 'Data de nascimento inválida';
        }
    }

    // Validação da matrícula
    if (empty($data['registration']) || !is_numeric($data['registration']) || (strlen($data['registration']) != 11 && strlen($data['registration']) != 6)) {
        $errors[] = 'Matrícula inválida';
    }

    return $errors;
}
