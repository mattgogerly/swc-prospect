<?php

namespace swcprospect\model\db;

use PDO;
use PDOException;

/**
 * DatabaseConnection is a wrapper for a PDO connection to a MySQL database.
 */
class DatabaseConnection
{
     private $host = '127.0.0.1';
     private $db = 'swcprospect';
     private $user = 'root';
     private $pass = 'password';
     private $charset = 'utf8mb4';

     private $conn;

     /**
      * Create a new instance of DatabaseConnection. Populates the value of {@var $conn}.
      *
      * @return void
      */
    public function __construct()
    {
         $conn_string = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
         $options = [
              PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
         ];

         try {
              $this->conn = new PDO($conn_string, $this->user, $this->pass, $options);
         } catch (PDOException $e) {
              trigger_error('500: Failed to connect to database');
         }
    }

     /**
      * get the value of conn.
      *
      * @return PDO connection to database.
      */
    public function getConn(): PDO
    {
         return $this->conn;
    }
}
