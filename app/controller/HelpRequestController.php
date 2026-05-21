<?php
require_once __DIR__ . '/../../config/Database.php'; 
require_once __DIR__ . '/../../repositories/HelpRequestRepository.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $database = new Database();
    $dbConnection = $database->connect();
    $repository = new HelpRequestRepository($dbConnection);

    if (isset($_POST['assign'])) {
        $requestId = isset($_POST['request_id']) ? intval($_POST['request_id']) : 0;

        if ($requestId === 0) {
            header('Location: /peersync/views/dashboard.php?error=invalid_request');
            exit();
        }

        $success = $repository->assignRequest($requestId);

        if ($success) {
            header('Location: ../../views/auth/dashboard.php?section=tutor?success=request_assigned');
        } else {
            header('Location: /peersync/views/dashboard.php?error=db_error');
        }
        exit();
    }
    $title       = isset($_POST['title']) ? trim($_POST['title']) : '';
    $skillId     = isset($_POST['technology']) ? intval($_POST['technology']) : 0; 
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $userId      = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
    
    if (empty($title) || $skillId === 0 || empty($description) || $userId === 0) {
        header('Location: ../../views/dashboard.php?error=invalid_data');
        exit();
    }

    $database = new Database();
    $dbConnection = $database->connect();

    $repository = new HelpRequestRepository($dbConnection);
    
    
    $success = $repository->createRequest($title, $skillId, $description, $userId);

    if ($success) {
        header('Location: ../../views/auth/dashboard.php?op=scc');
    exit();
    } else {
        header('Location: ../../views/dashboard.php?error=db_error');
         exit();
    }
}