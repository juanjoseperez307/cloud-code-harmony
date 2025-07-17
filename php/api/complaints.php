<?php
require_once __DIR__ . '/../core/ApiResponse.php';
require_once __DIR__ . '/../models/Complaint.php';

$complaintModel = new Complaint($DB);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        ApiResponse::success($complaintModel->all());
        break;
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $complaintModel->create($data);
        if ($id) {
            ApiResponse::success(['id' => $id]);
        } else {
            ApiResponse::error('No se pudo crear el reclamo');
        }
        break;
    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $ok = $complaintModel->updateStatus($data['id'], $data['status']);
        if ($ok) {
            ApiResponse::success(['updated' => true]);
        } else {
            ApiResponse::error('No se pudo actualizar el estado');
        }
        break;
    default:
        ApiResponse::error('Método no permitido', 405);
}
?>
