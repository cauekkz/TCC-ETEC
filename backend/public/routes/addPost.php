<?php 
require("../../_inc/init.php");
require_once __DIR__ . '/../../_inc/filters/isTeacher.php';

check_request_method($_SERVER['REQUEST_METHOD'], "POST");

require_once __DIR__ . '/../../_inc/validation/postValidator.php';

$jwt = new JwtAuth();
$tokenJWT = $jwt->get_jwt_by_header();
$resultJWT = $jwt->validate_token($tokenJWT);
$user_id = $resultJWT['id'];

// Sempre usar FormData
$content = $_POST["content"] ?? '';
$serverId = $_POST["server_id"] ?? '';
$uploadedFiles = $_FILES["media"] ?? null;

// Validar dados básicos
if (empty($content) || empty($serverId)) {
    $res->set_status("error");
    $res->set_error_message("Content and server_id are required");
    $res->response();
    exit;
}

// Validar conteúdo (prevenir XSS e código malicioso)
$content = trim($content);
if (strlen($content) > 5000) { // Limite de 5000 caracteres
    $res->set_status("error");
    $res->set_error_message("Content too long (max 5000 characters)");
    $res->response();
    exit;
}

// Validar server_id
if (!is_numeric($serverId) || $serverId <= 0) {
    $res->set_status("error");
    $res->set_error_message("Invalid server_id");
    $res->response();
    exit;
}

$sqlAuthCheck = "
SELECT s.id
FROM server s
LEFT JOIN user_campus uc ON s.campus_id = uc.campus_id AND uc.user_id = :userId
WHERE 
  s.id = :serverId
  AND (
    s.id = 1
    OR LOWER(s.name) = 'geral'
    OR uc.id IS NOT NULL
  )
LIMIT 1;
";
$paramsAuthCheck = [
    'userId' => $user_id,
    'serverId' => $serverId
];

$authResult = $db->execute_query($sqlAuthCheck, $paramsAuthCheck);
if (count($authResult->results) === 0) {
    $res->set_status("error");
    $res->set_error_message("Você não tem permissão para postar neste servidor.");
    $res->response();
    exit;
}

$sql = "INSERT INTO post (id_author, content, server_id) VALUES (:id_author, :content, :serverId)";
$params = ['content' => $content, "id_author" => $user_id, "serverId" => $serverId];
$response = $db->execute_non_query($sql, $params);

if ($response->status != 'success') {
    $res->set_status('error');
    $res->set_error_message("erro ao criar post");
    $res->response();
    exit;
}

$post_id = $response->last_id;

// Processar upload de imagens se houver
if ($uploadedFiles && !empty($uploadedFiles['name'][0])) {
    $uploadDir = "../../uploads/mediaPost/";
    $userDir = $uploadDir . "user_" . $user_id . "/";
    
    // Criar pasta do usuário se não existir
    if (!file_exists($userDir)) {
        mkdir($userDir, 0755, true);
    }
    
    $allowedTypes = [
        'image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp',
        'video/mp4', 'video/avi', 'video/mov', 'video/wmv', 'video/flv', 'video/webm'
    ];
    $maxFileSize = 150 * 1024 * 1024; // 150MB para vídeos e imagens
    
    for ($i = 0; $i < count($uploadedFiles['name']); $i++) {
        if ($uploadedFiles['error'][$i] === UPLOAD_ERR_OK) {
            $fileName = $uploadedFiles['name'][$i];
            $fileType = $uploadedFiles['type'][$i];
            $fileSize = $uploadedFiles['size'][$i];
            $fileTmpName = $uploadedFiles['tmp_name'][$i];
            
            // Validar tipo de arquivo
            if (!in_array($fileType, $allowedTypes)) {
                continue; // Pular arquivo inválido
            }
            
            if ($fileSize > $maxFileSize) {
                continue; 
            }
            
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'mp4', 'avi', 'mov', 'wmv', 'flv', 'webm'];
            if (!in_array($fileExtension, $allowedExtensions)) {
                continue; // Pular arquivo com extensão inválida
            }
            
            // Validar conteúdo do arquivo (verificar se é realmente uma imagem/vídeo)
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $fileTmpName);
            finfo_close($finfo);
            
            if (!in_array($mimeType, $allowedTypes)) {
                continue; // Pular arquivo com MIME type inválido
            }
            
            // Gerar nome único para o arquivo
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $uniqueFileName = uniqid() . '_' . time() . '.' . $fileExtension;
            $filePath = $userDir . $uniqueFileName;
            
            // Mover arquivo
            if (move_uploaded_file($fileTmpName, $filePath)) {
                // Salvar referência no banco
                $mediaUrl = "uploads/mediaPost/user_" . $user_id . "/" . $uniqueFileName;
                $mediaType = (strpos($fileType, 'video/') === 0) ? 'video' : 'image';
                
                $sqlMedia = "INSERT INTO post_media (post_id, media_url, media_type, media_order) VALUES (:post_id, :media_url, :media_type, :media_order)";
                $paramsMedia = [
                    'post_id' => $post_id,
                    'media_url' => $mediaUrl,
                    'media_type' => $mediaType,
                    'media_order' => $i
                ];
                
                $db->execute_non_query($sqlMedia, $paramsMedia);
            }
        }
    }
}

$res->set_status('success');
$res->set_response_data(['post_id' => $post_id]);
$res->response();
?>