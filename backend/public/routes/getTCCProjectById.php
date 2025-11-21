<?php
require("../../_inc/init.php");
require_once __DIR__ . '/../../_inc/filters/isLogged.php';

check_request_method($_SERVER['REQUEST_METHOD'], "GET");

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    $res->set_status("error");
    $res->set_error_message("project_id inválido.");
    $res->response();
    exit;
}

$projectId = (int)$_GET["id"];



$sqlProject = "
SELECT 
    p.id,
    p.title,
    p.description,
    p.created_at,

    c.name AS course_name,
    cp.name AS campus_name

FROM tcc_project p
LEFT JOIN course  c  ON c.id = p.course_id
LEFT JOIN campus cp  ON cp.id = p.campus_id
WHERE p.id = :project_id
LIMIT 1
";

$projectResult = $db->execute_query($sqlProject, [
    "project_id" => $projectId
]);

if (empty($projectResult->results)) {
    $res->set_status("error");
    $res->set_error_message("Projeto não encontrado.");
    $res->response();
    exit;
}

$project = $projectResult->results[0];

$sqlMembers = "
SELECT 
    u.id,
    u.name,
    u.profile_photo_path
FROM tcc_project_members pm
INNER JOIN user u ON u.id = pm.user_id
WHERE pm.project_id = :project_id
ORDER BY u.name ASC
";

$membersResult = $db->execute_query($sqlMembers, [
    "project_id" => $projectId
]);

$sqlFiles = "
SELECT
    id,
    file_url,
    file_name,
    file_type,
    uploaded_at
FROM tcc_project_file
WHERE project_id = :project_id
ORDER BY uploaded_at DESC
";

$filesResult = $db->execute_query($sqlFiles, [
    "project_id" => $projectId
]);



$response = [
    "project" => $project,
    "members" => $membersResult->results,
    "files"   => $filesResult->results
];

$res->set_status("success");
$res->set_response_data($response);
$res->response();
