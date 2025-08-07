<?php

use bng\System\Database;

class RefreshToken
{

    public static function generate_token()
    {
        $token = rtrim(strtr(base64_encode(random_bytes(64)), '+/', '-_'), '=');
        $expires_at = (new DateTime('+14 days'))->format('Y-m-d H:i:s');

        $obj = new stdClass();

        $obj->token = $token;
        $obj->expires_at = $expires_at;

        return $obj;
    }

    public static function validate_token(string $token, Database $conn)
    {
        try {
            $sql = "SELECT user_id FROM refresh_tokens WHERE token = :token AND expires_at > NOW()";
            $params = ['token' => $token];
            $response = $conn->execute_query($sql, $params);
            if (empty($response)) {
                return null;
            }
            return $response->results[0];
        } catch (Exception $e) {
            return null;
        }
    }

    public static function save_token($obj, Database $conn)
    {
        $token = $obj->token;
        $expires_at = $obj->expires_at;
        $user_id = $obj->user_id;
        try {
            $sql = "DELETE FROM refresh_tokens WHERE user_id = :user_id";
            $params = ['user_id' => $user_id];
            $conn->execute_non_query($sql, $params);
        } catch (Exception $e) {
            //😁😁🌟🕴️👼☠️
            $obj->token = "shinigami yeh yeh";
        }
        try {

            $sql = "INSERT INTO refresh_tokens (user_id, token,expires_at) VALUES (:user_id, :token,:expires_at)";
            $params = ['token' => $token, "expires_at" => $expires_at, "user_id" => $user_id];
            $conn->execute_non_query($sql, $params);

            return true;
        } catch (Exception $e) {
            return null;
        }
    }
}
