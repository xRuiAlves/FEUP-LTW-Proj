<?php
  class Database {
    private $db = NULL;
    private static $instance = NULL;

    private function __construct() {
      $this->db = new PDO('sqlite:' . '../db/database.db');

      $this->db->query('PRAGMA foreign_keys = ON');
      $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

      if ($this->db == NULL) {
        throw new Exception("Error: Could not open database");
      }
    }
    
    public function getDB() {
      return $this->db;
    }
    
    static function getInstance() {
      if (NULL == self::$instance) {
        self::$instance = new Database();
      }
      return self::$instance;
    }
  }
?>