    <?php
    require("../../_inc/init.php");
    require_once __DIR__ . '/../../_inc/filters/isStudent.php';
    $data = $_POST;
    if (empty($data['courses_Ids'])) {
        $errors[] = 'invalid ID Campus';
        $res->set_status("error");
        $res->set_error_message("Invalid Form");
        $res->set_response_data($errors);
        $res->response();
        exit;
    }
    $course_Ids_string = $data['courses_Ids'];
    $courseArray = explode(",", $course_Ids_string);
    $courseArray = array_filter($courseArray, fn($v) => trim($v) !== "");
    $courseArray = array_values(array_unique($courseArray));
    $jwt = new JwtAuth();
    $tokenJWT = $jwt->get_jwt_by_header();
    $resultJWT = $jwt->validate_token($tokenJWT);
    $user_id = $resultJWT['id'];


    $placeholders = [];
    $params = [];

    foreach ($courseArray as $index => $id) {
        $key = ":id$index";
        $placeholders[] = $key;
        $params[$key] = $id;
    }
    $params["user_id"] = $user_id;
    $sql = "DELETE FROM user_course WHERE course_id IN (" . implode(", ", $placeholders) . ") AND user_id = :user_id";
    $response = $db->execute_non_query($sql, $params);
    if ($response->status != 'success') {
        $res->set_status('error');
        $res->set_error_message($response->mensagem);
        $res->response();
        exit;
    }
    $res->response();
