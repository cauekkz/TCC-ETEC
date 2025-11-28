<?php
require("../../_inc/init.php");
check_request_method($_SERVER['REQUEST_METHOD'], "GET");
$user_id = null;

if (isset($_GET["user_id"])) {
    $user_id = $_GET["user_id"];
} else {
    $res->set_status('error');
    $res->set_error_message("Parâmetro user_id ausente");
    $res->response();
    exit;
}

$sql = "SELECT
    e.*,
    (SELECT COUNT(*) FROM event_participants ep WHERE ep.event_id = e.id) AS total_participants,
    EXISTS(
        SELECT 1 FROM event_participants ep2 WHERE ep2.event_id = e.id AND ep2.user_id = :user_id
    ) AS user_participating
FROM events e
ORDER BY e.date DESC";

$params = ["user_id" => $user_id];

$response = $db->execute_query($sql, $params);

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message("Erro ao buscar eventos");
    $res->response();
    exit;
}

$res->set_response_data($response->results);
$res->response();
