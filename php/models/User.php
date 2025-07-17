<?php
require_once __DIR__ . '/../config.php';

class User {
    private $conn;
    public function __construct($db) {
        $this->conn = $db->conn;
    }
    public function create($data) {
        $sql = "INSERT INTO users (name, email, username, password) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ssss', $data['name'], $data['email'], $data['username'], password_hash($data['password'], PASSWORD_BCRYPT));
        if ($stmt->execute()) {
            return $stmt->insert_id;
        }
        return false;
    }
    public function findByUsername($username) {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function findById($id) {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?>
