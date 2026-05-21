<?php
// app/controller/HelpRequestController.php

require_once __DIR__ . '/../../config/Database.php'; 
require_once __DIR__ . '/../../repositories/HelpRequestRepository.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
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