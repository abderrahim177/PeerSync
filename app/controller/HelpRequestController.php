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

    // ==========================================
    // ACTION 1: Confirm & Take Request (Tutor)
    // ==========================================
    if (isset($_POST['assign'])) {
        $requestId = isset($_POST['request_id']) ? intval($_POST['request_id']) : 0;
        $userName  = isset($_POST['user_name']) ? trim($_POST['user_name']) : '';

        if ($requestId === 0 || empty($userName)) {
            header('Location: /peersync/views/auth/dashboard.php?error=invalid_request');
            exit();
        }

        $success = $repository->assignRequest($requestId, $userName);

        if ($success) {
            $_SESSION['user_name'] = $userName;
            header('Location: /peersync/views/auth/dashboard.php?section=tutor&success=request_assigned');
        } else {
            header('Location: /peersync/views/auth/dashboard.php?error=db_error');
        }
        exit();
    }

    // ==========================================
    // ACTION 2: Create Skills
    // ==========================================
    if (isset($_POST['creat_skills'])) {
        $skills = htmlspecialchars($_POST['skill_name']);

        if (empty($skills)) {
            header('Location: /peersync/views/auth/dashboard.php?error=invalid_request');
            exit();
        }
        
        $success = $repository->creatSkills($skills);

        if ($success) {
            header('Location: /peersync/views/auth/dashboard.php?op=scc');
            exit();
        } else {
            header('Location: /peersync/views/auth/dashboard.php?error=db_error');
            exit();
        }
    }

    // ==========================================
    // ACTION 3: Create New Request (Student) 
    // ==========================================
    // جمعناه وسط الـ if باش ما يبقاش يوقف الكود الآخر
    if (isset($_POST['action_create'])) {
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

    // ==========================================
    // ACTION 4: Submit Review (Resolved)
    // ==========================================
   // ==========================================
    // ACTION 4: Submit Review & Mark as Resolved
    // ==========================================
    if (isset($_POST['action_resolve'])) {
        $help_request_id = intval($_POST['help_request_id']);
        $rating = htmlspecialchars($_POST['rating']);
        $comment = htmlspecialchars($_POST['comment']);
        
        if ($comment == '' || $rating == 0 || $help_request_id === 0) {
            header('Location: /peersync/views/auth/dashboard.php?error=invalid_data');
            exit();
        }
        
        // هنا عيطنا على الدالة الجديدة اللي كتدير التقييم وكتغير الحالة لـ RESOLVED ف دقة وحدة
        $success = $repository->resolveAndRateRequest($help_request_id, $rating, $comment);
        
        if ($success) {
            // op=scc غاترجعو للـ dashboard والطلب غيختفي حيت الـ Status ديالو ولات RESOLVED
            header('Location: /peersync/views/auth/dashboard.php?op=scc');
            exit();
        } else {
           header('Location: /peersync/views/auth/dashboard.php?error=db_error');
           exit();
        }
    }
}