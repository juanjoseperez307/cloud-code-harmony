<?php
class Database {
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $name = 'denuncia_vista';
    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass);
        if ($this->conn->connect_error) {
            die('Error de conexión: ' . $this->conn->connect_error);
        }
        $this->conn->query("CREATE DATABASE IF NOT EXISTS {$this->name}");
        $this->conn->select_db($this->name);
        $this->setupSchema();
    }

    private function setupSchema() {
        $this->conn->query("CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100),
            username VARCHAR(50) UNIQUE,
            email VARCHAR(100) UNIQUE,
            password VARCHAR(255),
            phone VARCHAR(20),
            location VARCHAR(100),
            bio TEXT,
            avatar VARCHAR(255),
            transparency_points INT DEFAULT 0,
            level INT DEFAULT 1,
            complaints_submitted INT DEFAULT 0,
            comments_given INT DEFAULT 0,
            helpful_votes INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        $this->conn->query("CREATE TABLE IF NOT EXISTS complaints (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            category VARCHAR(50),
            content TEXT,
            status VARCHAR(20),
            location VARCHAR(100),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id)
        )");
        $this->conn->query("CREATE TABLE IF NOT EXISTS achievements (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(100),
            description TEXT,
            icon VARCHAR(10),
            target INT,
            category VARCHAR(50)
        )");
        $this->conn->query("CREATE TABLE IF NOT EXISTS user_achievements (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            achievement_id INT,
            progress INT DEFAULT 0,
            completed BOOLEAN DEFAULT FALSE,
            completed_at TIMESTAMP NULL,
            FOREIGN KEY (user_id) REFERENCES users(id),
            FOREIGN KEY (achievement_id) REFERENCES achievements(id)
        )");
    }
}

$DB = new Database();
?>
