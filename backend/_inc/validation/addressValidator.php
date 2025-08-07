<?php 



function validate($address)
{
    $errors = [];

    if (!is_array($address)) {
        return ['Endereço inválido'];
    }

    if (empty($address['street']) || strlen($address['street']) < 3) {
        $errors[] = 'Rua inválida';
    }

    if (empty($address['address_number']) || !is_numeric($address['address_number'])) {
        $errors[] = 'Número do endereço inválido';
    }

    if (empty($address['city']) || strlen($address['city']) < 2) {
        $errors[] = 'Cidade inválida';
    }

    if (empty($address['state']) || strlen($address['state']) !== 2) {
        $errors[] = 'Estado inválido (use a sigla, ex: SP)';
    }

    if (empty($address['zip_code']) || !preg_match('/^\d{5}-?\d{3}$/', $address['zip_code'])) {
        $errors[] = 'CEP inválido';
    }

    return $errors;
}

?>