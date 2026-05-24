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

    // ACTION 1: Confirm & Take Request (Tutor)
    if (isset($_POST['assign'])) {
        $requestId = isset($_POST['request_id']) ? intval($_POST['request_id']) : 0;
        $userName  = isset($_POST['user_name']) ? trim($_POST['user_name']) : '';

        // Verification bli l'smiya o l'id machi khawyin
        if ($requestId === 0 || empty($userName)) {
            header('Location: /peersync/views/auth/dashboard.php?error=invalid_request');
            exit();
        }

        // Exécuter l'update f repository b l'id o tutor name
        $success = $repository->assignRequest($requestId, $userName);

        if ($success) {
            // Sauvegarder l'smiya lli ktabha f session storage
            $_SESSION['user_name'] = $userName;
            
            header('Location: /peersync/views/auth/dashboard.php?section=tutor&success=request_assigned');
        } else {
            header('Location: /peersync/views/auth/dashboard.php?error=db_error');
        }
        exit();
    }
    if(isset($_POST['creat_skills'])){
        $skills = htmlspecialchars($_POST['skill_name']);

        if(empty($skills)){
            header('location : /peersync/views/auth/dashboard.php?error=invalid_request');
            exit();
        }
        $success = $repository->creatSkills($skills);

        if($success){
            header('Location: /peersync/views/auth/dashboard.php?op=scc');
            exit();
        }
        else{
            header('Location: /peersync/views/auth/dashboard.php?error=db_error');
            exit();
        }
    }

    // ACTION 2: Create New Request (Student)
    $title       = isset($_POST['title']) ? trim($_POST['title']) : '';
    $skillId     = isset($_POST['technology']) ? intval($_POST['technology']) : 0;
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $userId      = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;

    if (empty($title) || $skillId === 0 || empty($description) || $userId === 0) {
        header('Location: /peersync/views/auth/dashboard.php?error=invalid_data');
        exit();
    }
    
    $success = $repository->createRequest($title, $skillId, $description, $userId);

    if ($success) {
        header('Location: /peersync/views/auth/dashboard.php?op=scc');
        exit();
    } else {
        header('Location: /peersync/views/auth/dashboard.php?error=db_error');
        exit();
    }
}