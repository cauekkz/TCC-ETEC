<?php
require("../../_inc/init.php");
check_request_method($_SERVER['REQUEST_METHOD'], "POST");

require_once __DIR__ . '/../../_inc/filters/isLogged.php';

$data = $_POST;


$requiredFields = ['title', 'date', 'time', 'location', 'capacity'];
$errors = [];

foreach ($requiredFields as $field) {
    if (empty($data[$field])) {
        $errors[] = "Preencha todos os campos.";
    }
}

if (!empty($errors)) {
    $res->set_status("error");
    $res->set_error_message("Formulário inválido");
    $res->set_response_data($errors);
    $res->response();
    exit;
}


$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);
$user_id = $resultJWT['id'];
$user_role = $resultJWT['role'];


$title = trim($data['title']);
$description = trim($data['description'] ?? '');
$date = $data['date'];
$time = $data['time'];
$location = trim($data['location']);
$capacity = isset($data['capacity']) ? intval($data['capacity']) : null;

$eventDate = new DateTime($date);
$today     = new DateTime('today');
$maxDate   = (new DateTime('today'))->modify('+1 year');



if ($capacity !== null && $capacity < 1) {
    $res->set_status("error");
    $res->set_error_message("A capacidade deve ser maior que 0.");
    $res->response();
    exit;
}


if ($eventDate < $today) {
    $res->set_status("error");
    $res->set_error_message("A data do evento não pode ser anterior à data atual.");
    $res->response();
    exit;
}

if ($eventDate > $maxDate) {
    $res->set_status("error");
    $res->set_error_message("A data do evento deve ser no máximo até 1 ano a partir de hoje.");
    $res->response();
    exit;
}


$sql = "INSERT INTO events (title, description, date, time, location, capacity) 
        VALUES (:title, :description, :date, :time, :location, :capacity)";
$params = [
    ':title' => $title,
    ':description' => $description,
    ':date' => $date,
    ':time' => $time,
    ':location' => $location,
    ':capacity' => $capacity
];

$response = $db->execute_non_query($sql, $params);

/* if ($response->status != 'success') {
    $res->set_status("error");
    $res->set_error_message($response->mensagem ?? "Erro ao criar evento");
    $res->response();
    exit;
} */

$res->response();
