<?php
require("../../_inc/init.php");
require_once __DIR__ . '/../../_inc/filters/isLogged.php';

check_request_method($_SERVER['REQUEST_METHOD'], "GET");

if (!isset($_GET["campus_id"]) || !is_numeric($_GET["campus_id"])) {
    $res->set_status("error");
    $res->set_error_message("campus_id inválido.");
    $res->response();
    exit;
}

$campusId = (int)$_GET["campus_id"];

/* logged-in user -> used to know whether they liked it */
$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$jwtData = $jwt->validate_token($tokenJWT);
$userId = $jwtData["id"];

$sql = "
SELECT 
    p.id,
    p.title,
    p.description,
    p.created_at,

    c.name AS course_name,
    cp.name AS campus_name,

    /* total likes */
    COUNT(DISTINCT l.id) AS total_likes,

    /* whether the logged-in user liked it */
    CASE WHEN l2.id IS NULL THEN 0 ELSE 1 END AS user_liked

FROM tcc_project p

LEFT JOIN course c ON c.id = p.course_id
LEFT JOIN campus cp ON cp.id = p.campus_id

/* total likes */
LEFT JOIN likes l 
    ON l.content_type = 'tcc_project'
    AND l.content_id = p.id

/* the user's like */
LEFT JOIN likes l2
    ON l2.content_type = 'tcc_project'
    AND l2.content_id = p.id
    AND l2.user_id = :user_id

WHERE p.campus_id = :campus_id

GROUP BY p.id
ORDER BY p.created_at DESC
";

$result = $db->execute_query($sql, [
    "campus_id" => $campusId,
    "user_id"   => $userId
]);

$res->set_status("success");
$res->set_response_data($result->results);
$res->response();
