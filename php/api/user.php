<?php
require_once __DIR__ . '/../core/ApiResponse.php';
require_once __DIR__ . '/../models/User.php';

$userModel = new User($DB);

switch ($_GET['action'] ?? '') {
    case 'signup':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $id = $userModel->create($data);
            if ($id) {
                ApiResponse::success(['id' => $id]);
            } else {
                ApiResponse::error('No se pudo registrar el usuario');
            }
        }
        break;
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $user = $userModel->findByUsername($data['username']);
            if ($user && password_verify($data['password'], $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                ApiResponse::success(['user' => $user]);
            } else {
                ApiResponse::error('Credenciales inválidas', 401);
            }
        }
        break;
    case 'logout':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            session_destroy();
            ApiResponse::success(['logout' => true]);
        }
        break;
    case 'gmail_oauth':
        ApiResponse::error('No implementado. Usa Google API Client para OAuth.', 501);
        break;
    default:
        ApiResponse::error('Acción no válida', 400);
}
?>
