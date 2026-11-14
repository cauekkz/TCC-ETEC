<?php

use \Firebase\JWT\JWT;

class JwtAuth
{
    private $secret_key;

    public function __construct()
    {
        $this->secret_key = defined('JWT_SECRET') ? JWT_SECRET : (getenv('JWT_SECRET') ?: 'dev-only-jwt-secret-change-me-in-production');
    }
    private $issuer = 'http://localhost/';
    private $audience = 'app';

    public function generate_token_user($user_data)
    {
        $issued_at = time();
        $expiration_time = $issued_at + 3600;

        $payload = [
            'iat' => $issued_at,
            'exp' => $expiration_time,
            'iss' => $this->issuer,
            'aud' => $this->audience,
            'role' => $user_data->role,
            'id' => $user_data->id,
            'email' => $user_data->email,
            'name' => $user_data->name,
        ];

        return JWT::encode($payload, $this->secret_key, 'HS256');
    }
    public function get_jwt_by_header()
    {
        $headers = getallheaders();
        if (!isset($headers['Authorization'])) {
            return null;
        }
        $authHeader = $headers['Authorization'];
        if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return $matches[1];
        }

        return null;
    }

    public function validate_token($jwt)
    {
        try {
            $decoded = JWT::decode($jwt, new \Firebase\JWT\Key($this->secret_key, 'HS256'));
            return (array) $decoded;
        } catch (Exception $e) {
            return null;
        }
    }
}
