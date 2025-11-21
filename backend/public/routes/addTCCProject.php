<?php
require("../../_inc/init.php");
require_once __DIR__ . '/../../_inc/filters/isTeacher.php';
check_request_method($_SERVER['REQUEST_METHOD'], "POST");
require_once __DIR__ . '/../../_inc/validation/projectValidator.php';

$errors = validate($_POST, $_FILES);
if (!empty($errors)) {
    $res->set_status("error");
    $res->set_error_message("Invalid Form");
    $res->set_response_data($errors);
    $res->response();
    exit;
}

$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);
$user_id = $resultJWT['id'];

$title       = trim($_POST["title"]);
$description = trim($_POST["description"]);
$campusId    = $_POST["campus_id"];
$courseId    = $_POST["course_id"];
$memberIds   = $_POST["member_ids"] ?? [];
$uploadedFiles = $_FILES["files"];


$sqlTeacherCheck = "
    SELECT 1
    FROM user_campus
    WHERE user_id = :teacher_id
    AND campus_id = :campus_id
    LIMIT 1
";

$teacherCheck = $db->execute_query($sqlTeacherCheck, [
    "teacher_id" => $user_id,
    "campus_id" => $campusId
]);

if (empty($teacherCheck->results)) {
    $res->set_status("error");
    $res->set_error_message("Você não tem permissão para criar TCC nessa ETEC.");
    $res->response();
    exit;
}

foreach ($memberIds as $memberId) {

    $sqlCourseCheck = "
        SELECT 1
        FROM user_course
        WHERE user_id = :user_id
        AND course_id = :course_id
        LIMIT 1
    ";

    $courseCheck = $db->execute_query($sqlCourseCheck, [
        "user_id" => $memberId,
        "course_id" => $courseId
    ]);

    if (empty($courseCheck->results)) {
        $res->set_status("error");
        $res->set_error_message("O aluno ID $memberId não pertence ao curso selecionado.");
        $res->response();
        exit;
    }

    $sqlCampusCheck = "
        SELECT 1
        FROM user_campus
        WHERE user_id = :user_id
        AND campus_id = :campus_id
        LIMIT 1
    ";

    $campusCheck = $db->execute_query($sqlCampusCheck, [
        "user_id" => $memberId,
        "campus_id" => $campusId
    ]);

    if (empty($campusCheck->results)) {
        $res->set_status("error");
        $res->set_error_message("O aluno ID $memberId não pertence ao campus selecionado.");
        $res->response();
        exit;
    }
}


$sqlProject = "
    INSERT INTO tcc_project (title, description, campus_id, course_id)
    VALUES (:title, :description, :campus_id, :course_id)
";
$paramsProject = [
    "title"       => $title,
    "description" => $description,
    "campus_id"   => $campusId,
    "course_id"   => $courseId
];
$response = $db->execute_non_query($sqlProject, $paramsProject);
if ($response->status !== "success") {
    $res->set_status("error");
    $res->set_error_message("Erro ao criar o projeto");
    $res->response();
    exit;
}
$projectId = $response->last_id;
$sqlMember = "
    INSERT INTO tcc_project_members (project_id, user_id)
    VALUES (:project_id, :user_id)
";
foreach ($memberIds as $memberId) {
    $db->execute_non_query($sqlMember, [
        "project_id" => $projectId,
        "user_id" => $memberId
    ]);
}
$uploadDir = "../../uploads/tcc_projects/" . $projectId . "/";
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}
$allowedTypes = [
    "image/jpeg", "image/png", "image/webp",
    "video/mp4", "video/webm",
    "application/pdf", "application/zip"
];
for ($i = 0; $i < count($uploadedFiles["name"]); $i++) {

    if ($uploadedFiles["error"][$i] !== UPLOAD_ERR_OK) {
        continue;
    }

    $fileName = $uploadedFiles["name"][$i];
    $fileTmp  = $uploadedFiles["tmp_name"][$i];
    $fileType = $uploadedFiles["type"][$i];
    $mime     = mime_content_type($fileTmp);

    if (!in_array($mime, $allowedTypes)) {
        continue;
    }

    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $uniqueName = uniqid() . "_" . time() . "." . $ext;
    $destPath = $uploadDir . $uniqueName;

    if (!move_uploaded_file($fileTmp, $destPath)) {
        continue;
    }

    if (str_contains($mime, "image"))      $fileTypeDB = "image";
    else if (str_contains($mime, "video")) $fileTypeDB = "video";
    else if ($mime === "application/pdf") $fileTypeDB = "pdf";
    else $fileTypeDB = "zip";

    $sqlFile = "
        INSERT INTO tcc_project_file (project_id, file_url, file_name, file_type)
        VALUES (:project_id, :file_url, :file_name, :file_type)
    ";

    $db->execute_non_query($sqlFile, [
        "project_id" => $projectId,
        "file_url"   => "uploads/tcc_projects/$projectId/" . $uniqueName,
        "file_name"  => $fileName,
        "file_type"  => $fileTypeDB
    ]);
}

$res->set_status("success");
$res->set_response_data([
    "project_id" => $projectId,
    "message" => "TCC criado com sucesso!"
]);
$res->response();

