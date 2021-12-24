<?php

namespace swcprospect\model\db;

use PDO;
use PDOException;

class DatabaseConnection {

     private $host = '127.0.0.1';
     private $db = 'swcprospect';
     private $user = 'root';
     private $pass = 'password';
     private $charset = 'utf8mb4';

     private $conn;

     public function __construct() {
          $conn_string = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
          $options = [
               PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
          ];

          try {
               $this->conn = new PDO($conn_string, $this->user, $this->pass, $options);
          } catch (PDOException $e) {
               throw new PDOException($e->getMessage(), (int) $e->getCode());
          }
     }

     public function getConn() {
          return $this->conn;
     }
}
?>