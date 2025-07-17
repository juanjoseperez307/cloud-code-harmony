<?php
require_once __DIR__ . '/../config.php';

class Complaint {
    private $conn;
    public function __construct($db) {
        $this->conn = $db->conn;
    }
    public function all() {
        $result = $this->conn->query('SELECT * FROM complaints');
        $complaints = [];
        while ($row = $result->fetch_assoc()) {
            $complaints[] = $row;
        }
        return $complaints;
    }
    public function create($data) {
        $sql = "INSERT INTO complaints (user_id, category, content, status, location) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('issss', $data['user_id'], $data['category'], $data['content'], $data['status'], $data['location']);
        if ($stmt->execute()) {
            return $stmt->insert_id;
        }
        return false;
    }
    public function updateStatus($id, $status) {
        $sql = "UPDATE complaints SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('si', $status, $id);
        return $stmt->execute();
    }
}
?>
