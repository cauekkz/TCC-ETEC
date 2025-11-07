<?php 
require("../../_inc/init.php");
require_once __DIR__ . '/../../_inc/filters/isLogged.php';
check_request_method($_SERVER['REQUEST_METHOD'], "GET");

// --- 1. CAPTURA O ID DO CONTATO ---
// Assumindo que o front-end envia o ID do contato como parâmetro GET (ex: ?contact_id=123)
$contact_id = $_GET['contact_id'] ?? null;

if (!$contact_id || !is_numeric($contact_id)) {
    http_response_code(400);
    echo json_encode(['error' => 'ID do contato inválido ou ausente.']);
    exit;
}
$contact_id = (int) $contact_id; // Sanitiza para inteiro

$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);
$user_id = $resultJWT['id'];

// --- 2. CORREÇÃO DA QUERY SQL ---
$sql = "SELECT 
            id, sender_id, receiver_id, content, created_at, is_read 
        FROM 
            message 
        WHERE
            (sender_id = :user_id AND receiver_id = :contact_id)
            OR
            (sender_id = :contact_id AND receiver_id = :user_id)
        ORDER BY
            created_at ASC";

$params = [
    "user_id" => $user_id,
    "contact_id" => $contact_id // Adicionado o parâmetro do contato
];

$response = $db->execute_query($sql, $params);

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message($response->mensagem);
    $res->response();
    exit;
}

$res->set_response_data($response->results);
$res->response();
exit;
?>