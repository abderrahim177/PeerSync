<?php
// 1. الاتصال بالـ Database والـ Repository
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../repositories/HelpRequestRepository.php';

$database = new Database();
$dbConnection = $database->connect();
$helpRepo = new HelpRequestRepository($dbConnection);

// =========================================================================
// 2. الـ SQL Queries المصلحة بناءً على الـ Structure ديال الجداول ديالك
// =========================================================================

// أولاً: جلب الإحصائيات (Average Rating, Total Feedbacks, Satisfaction Rate)
try {
    $statsQuery = "SELECT 
        ROUND(AVG(rating), 1) as avg_rating,
        COUNT(id) as total_feedbacks,
        ROUND((SUM(CASE WHEN rating >= 4 THEN 1 ELSE 0 END) / COUNT(id)) * 100) as satisfaction_rate
    FROM reviews";
    
    $statsStmt = $dbConnection->query($statsQuery);
    $reviewStats = $statsStmt->fetch(PDO::FETCH_ASSOC) ?: [
        'avg_rating' => '0.0', 
        'total_feedbacks' => 0, 
        'satisfaction_rate' => 0
    ];
} catch (PDOException $e) {
    $reviewStats = ['avg_rating' => '0.0', 'total_feedbacks' => 0, 'satisfaction_rate' => 0];
}

try {
    $reviewsQuery = "SELECT 
        r.id,
        r.rating,
        r.comment,
        hr.title as request_title,
        u.name as student_name, 
        s.name as skill_name,    
        hr.id as help_request_id
    FROM reviews r
    JOIN help_requests hr ON r.help_request_id = hr.id
    JOIN users u ON hr.userId = u.id 
    LEFT JOIN skills s ON hr.skill_id = s.id
    ORDER BY r.id DESC";
    
    $reviewsStmt = $dbConnection->query($reviewsQuery);
    $reviewsList = $reviewsStmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
} catch (PDOException $e) {
    $reviewsList = [];
}

function getInitials($name) {
    $words = explode(' ', $name);
    $initials = '';
    foreach ($words as $w) {
        $initials .= strtoupper($w[0] ?? '');
    }
    return substr($initials, 0, 2) ?: 'U';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <section class="flex-1 p-8 space-y-8 overflow-y-auto bg-slate-50 dark:bg-[#0b132b] transition-colors duration-300 custom-scrollbar">
    
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Peer Reviews</h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-0.5">See what students and tutors say about their mentoring sessions.</p>
        </div>
        
        <div class="flex items-center space-x-2 overflow-x-auto pb-1 sm:pb-0">
            <button class="px-4 py-2 text-xs font-semibold rounded-xl bg-blue-600 text-white shadow-md shadow-blue-500/10 border-0 cursor-pointer transition">All Reviews</button>
            <button class="px-4 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-[#111936] text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-[#1e295d] hover:border-blue-500 dark:hover:border-blue-500 cursor-pointer transition flex items-center space-x-1">
                <span>5</span> <i class="fa-solid fa-star text-amber-400 text-[10px]"></i>
            </button>
            <button class="px-4 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-[#111936] text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-[#1e295d] hover:border-blue-500 dark:hover:border-blue-500 cursor-pointer transition flex items-center space-x-1">
                <span>4</span> <i class="fa-solid fa-star text-amber-400 text-[10px]"></i>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white dark:bg-[#111936] border border-slate-200 dark:border-[#1e295d] rounded-2xl p-5 shadow-sm flex items-center space-x-4">
            <div class="p-3.5 rounded-xl bg-amber-500/10 text-amber-500">
                <i class="fa-solid fa-star text-xl"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-medium uppercase tracking-wider">Average Rating</p>
                <div class="flex items-baseline space-x-2 mt-0.5">
                    <p class="text-2xl font-bold text-slate-900 dark:text-white"><?= htmlspecialchars($reviewStats['avg_rating'] ?? '0.0') ?></p>
                    <p class="text-xs text-slate-400">/ 5.0</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-[#111936] border border-slate-200 dark:border-[#1e295d] rounded-2xl p-5 shadow-sm flex items-center space-x-4">
            <div class="p-3.5 rounded-xl bg-blue-500/10 text-blue-500">
                <i class="fa-regular fa-comments text-xl"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-medium uppercase tracking-wider">Total Feedbacks</p>
                <p class="text-2xl font-bold text-slate-900 dark:text-white mt-0.5"><?= htmlspecialchars($reviewStats['total_feedbacks'] ?? 0) ?></p>
            </div>
        </div>

        <div class="bg-white dark:bg-[#111936] border border-slate-200 dark:border-[#1e295d] rounded-2xl p-5 shadow-sm flex items-center space-x-4">
            <div class="p-3.5 rounded-xl bg-emerald-500/10 text-emerald-500">
                <i class="fa-solid fa-heart-pulse text-xl"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-medium uppercase tracking-wider">Satisfaction Rate</p>
                <p class="text-2xl font-bold text-slate-900 dark:text-white mt-0.5"><?= htmlspecialchars($reviewStats['satisfaction_rate'] ?? 0) ?>%</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <?php if (!empty($reviewsList)): ?>
            <?php foreach ($reviewsList as $review): ?>
                <div class="bg-white dark:bg-[#111936] border border-slate-200 dark:border-[#1e295d] rounded-2xl p-6 shadow-sm flex flex-col justify-between space-y-4 hover:shadow-md transition duration-300">
                    <div class="space-y-3">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white font-bold text-sm flex items-center justify-center shadow-inner uppercase">
                                    <?= getInitials($review['student_name'] ?? 'Student') ?>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900 dark:text-white leading-tight"><?= htmlspecialchars($review['student_name'] ?? 'Anonymous') ?></h4>
                                    <p class="text-slate-400 text-[11px] mt-0.5">Student • <?= htmlspecialchars($review['request_title'] ?? 'Help Session') ?></p>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-0.5 bg-slate-50 dark:bg-[#0b132b]/50 px-2 py-1 rounded-lg border border-slate-100 dark:border-[#1e295d]/40">
                                <?php 
                                $rating = intval($review['rating'] ?? 5);
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $rating) {
                                        echo '<i class="fa-solid fa-star text-[11px] text-amber-400"></i>';
                                    } else {
                                        echo '<i class="fa-regular fa-star text-[11px] text-slate-300 dark:text-slate-600"></i>';
                                    }
                                }
                                ?>
                            </div>
                        </div>

                        <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">
                            "<?= htmlspecialchars($review['comment'] ?? '') ?>"
                        </p>
                    </div>

                    <div class="pt-3 border-t border-slate-100 dark:border-[#1e295d]/50 flex items-center justify-between text-xs text-slate-400">
                        <span class="bg-blue-500/10 text-blue-600 dark:text-blue-400 font-medium px-2 py-0.5 rounded-md border border-blue-500/10">
                            <?= htmlspecialchars($review['skill_name'] ?? 'General') ?>
                        </span>
                        <div class="flex items-center space-x-1.5">
                            <i class="fa-regular fa-calendar text-[11px]"></i>
                            <span>Session Done</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center py-12 bg-white dark:bg-[#111936] border border-slate-200 dark:border-[#1e295d] rounded-2xl col-span-1 md:col-span-2">
                <i class="fa-regular fa-folder-open text-slate-300 dark:text-slate-700 text-4xl mb-3"></i>
                <p class="text-sm text-slate-500 dark:text-gray-400">No reviews found in the system yet.</p>
            </div>
        <?php endif; ?>

    </div>
</section>
</body>
</html>