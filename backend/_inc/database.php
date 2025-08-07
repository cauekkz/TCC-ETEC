<?php
/*
$sql = "INSERT INTO users (name, email) VALUES (:name, :email)";
$params = ['name' => 'John Doe', 'email' => 'john@example.com'];

$db = new \bng\System\Database([
    'server' => 'localhost',
    'dbname' => 'my_database',
    'user' => 'root',
    'pass' => 'password'
]);

$response = $db->execute_non_query($sql, $params);
*/

namespace bng\System;

use PDO;
use stdClass;
use PDOException;


class Database
{

    private $host;
    private $dbname;
    private $user;
    private $pass;
    private $return_type;
    private $opt_connection;

    private $connection;

    private function connect()
    {
        if (!$this->connection) {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname}";
            $this->connection = new PDO($dsn, $this->user, $this->pass, $this->opt_connection);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }



    public function __construct($opt, $return_type = 'object', $opt_connection = 'false')
    {

        $this->host = $opt['server'];
        $this->dbname = $opt['dbname'];
        $this->user = $opt['user'];
        $this->pass = $opt['pass'];

        $this->opt_connection = $opt_connection ? [PDO::ATTR_PERSISTENT => false] : [PDO::ATTR_PERSISTENT => true];

        if (!empty($return_type) or $return_type == 'object') {
            $this->return_type = PDO::FETCH_OBJ;
        } else {
            $this->return_type = PDO::FETCH_ASSOC;
        }
    }

    public function execute_query($sql, $parametros = null)
    {
        
        $this->connect();
        $results = null;

        try {

            $query = $this->connection->prepare($sql);
            $query->execute($parametros);
            $results = $query->fetchAll($this->return_type);
        } catch (PDOException $err) {

            return $this->_result('error', $err->getMessage(), $sql, null, 0, null);
        }

        return $this->_result('success', 'success', $sql, $results, $query->rowCount(), null);
    }

    public function execute_non_query($sql, $parametros = null)
    {

        $this->connect();
        $this->connection->beginTransaction();

        try {

            $query = $this->connection->prepare($sql);
            $query->execute($parametros);
            $ultimo_id = $this->connection->lastInsertId();
            $this->connection->commit();
        } catch (PDOException $err) {

            $this->connection->rollBack();

            return $this->_result('Error', $err->getMessage(), $sql, null, 0, null);
        }

        return $this->_result('success', 'success', $sql, null, $query->rowCount(), $ultimo_id);
    }

    private function _result($status, $mensagem, $sql, $results, $affected_rows, $last_id)
    {

        $tmp = new stdClass();
        $tmp->status = $status;
        $tmp->mensagem = $mensagem;
        $tmp->sql = $sql;
        $tmp->results = $results;
        $tmp->affected_rows = $affected_rows;
        $tmp->last_id = $last_id;
        return $tmp;
    }
}
