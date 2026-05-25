<?php
require_once __DIR__ . '/login-process.php';
$name = $_SESSION['user_name'];
$role = $_SESSION['user_role'];
$tutorName = $_SESSION['user_name'];

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$words = explode(" ", $name);
$initials = "";
if (count($words) >= 2) {
    $initials = strtoupper(mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1));
} else {
    $initials = strtoupper(mb_substr($words[0], 0, 1));
}

// Determine active section
$section = isset($_GET['section']) ? $_GET['section'] : 'dashboard';

// data 
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../repositories/HelpRequestRepository.php';

$database = new Database();
$dbConnection = $database->connect();
$helpRepo = new HelpRequestRepository($dbConnection);

$technologies = $helpRepo->getAllTechnologies();
$requests     = $helpRepo->getAllRequests();
$stats        = $helpRepo->getRequestStats();


?>
<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PeerSync Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    @keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-4px); }
    75% { transform: translateX(4px); }
}
.animate-shake { animation: shake 0.2s ease-in-out 0s 2; }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #334155;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 dark:bg-[#0b132b] dark:text-slate-200 h-screen w-screen flex text-sm overflow-hidden transition-colors duration-300 relative">

    <!-- ASIDE -->
    <aside class="w-64 bg-white dark:bg-[#111936] border-r border-slate-200 dark:border-[#1e295d] flex flex-col h-screen justify-between flex-shrink-0 hidden md:flex transition-colors duration-300">
    <div class="overflow-y-auto no-scrollbar flex-1 flex flex-col justify-between">
        <div>
            <div class="p-5 flex items-center space-x-2.5">
                <div class="bg-slate-100 dark:bg-[#1a365d]/50 w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm dark:shadow-lg dark:shadow-black/20 border border-slate-200 dark:border-[#1e295d]">
                    <svg class="w-5 h-5 text-[#88c057]" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 3L5 12L19 21V16.5L9.5 12L19 7.5V3Z" />
                    </svg>
                </div>
                <span class="text-slate-900 dark:text-white text-lg font-bold tracking-wide">ENAA</span>
            </div>

            <div class="px-3 py-1">
                <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 tracking-wider uppercase px-3 mb-1.5">Main</p>
                <nav class="space-y-1">
                    <a href="?section=dashboard" class="flex items-center justify-between px-3 py-2.5 rounded-xl transition text-sm
                        <?= $section === 'dashboard' ? 'bg-blue-50 dark:bg-blue-600/10 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/10 font-medium' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/30 hover:text-slate-900 dark:hover:text-slate-200' ?>">
                        <div class="flex items-center space-x-3">
                            <i class="fa-solid fa-table-columns text-base w-4 text-center"></i>
                            <span>Dashboard</span>
                        </div>
                    </a>

                    <a href="?section=profile" class="flex items-center justify-between px-3 py-2.5 rounded-xl transition text-sm
                        <?= $section === 'profile' ? 'bg-blue-50 dark:bg-blue-600/10 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/10 font-medium' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/30 hover:text-slate-900 dark:hover:text-slate-200' ?>">
                        <div class="flex items-center space-x-3">
                            <i class="fa-regular fa-user text-base w-4 text-center"></i>
                            <span>My Profile</span>
                        </div>
                    </a>

                    <a href="?section=Requests_Resolved" class="flex items-center justify-between px-3 py-2.5 rounded-xl transition group text-sm 
                        <?= $section === 'Requests_Resolved' ? 'bg-blue-600/10 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 font-medium border border-blue-500/10' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/30 hover:text-slate-900 dark:hover:text-slate-200' ?>">
                        <div class="flex items-center space-x-3">
                            <i class="fa-regular fa-file-lines text-base w-4 text-center transition-colors <?= $section === 'Requests_Resolved' ? 'text-blue-500' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' ?>"></i>
                            <span>Requests Resolved</span>
                        </div>
                        <span class="text-[11px] px-2 py-0.5 rounded-full border transition-colors <?= $section === 'Requests_Resolved' ? 'bg-blue-500/20 text-blue-500 border-blue-500/30' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 border-slate-200 dark:border-slate-700' ?>">
                            <?= $stats['resolved']; ?>
                        </span>
                    </a>
                </nav>

                <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 tracking-wider uppercase px-3 mt-4 mb-1.5">Explore</p>
                <nav class="space-y-1">
                    <a href="?section=tutor" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition text-sm
                        <?= $section === 'tutor' ? 'bg-blue-50 dark:bg-blue-600/10 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/10 font-medium' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/30 hover:text-slate-900 dark:hover:text-slate-200' ?>">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="w-4 text-center flex-shrink-0">
                            <circle cx="8" cy="5" r="3" />
                            <path d="M2 14c0-3.3 2.7-6 6-6s6 2.7 6 6" />
                            <path d="M11 2l1.5 1.5L15 1" />
                        </svg>
                        <span>Espace Tuteur</span>
                    </a>

                    <a href="?section=reviews" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition text-sm <?= ($section === 'reviews') ? 'bg-blue-600/10 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 font-medium' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/30 hover:text-slate-900 dark:hover:text-slate-200' ?>"> 
                        <i class="<?= ($section === 'reviews') ? 'fa-solid' : 'fa-regular' ?> fa-star text-base w-4 text-center"></i> 
                        <span>Reviews & Ratings</span>
                    </a>
                </nav>
            </div>
        </div>

        <div class="px-3 py-3 mt-auto">
            <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 tracking-wider uppercase px-3 mb-1.5">Account</p>
            <nav class="space-y-1">
                <a href="?section=Settings" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm transition
            <?= $section === 'Settings' ? 'bg-blue-50 dark:bg-blue-600/10 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/10 font-medium' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/30 hover:text-slate-900 dark:hover:text-slate-200' ?>">
            <i class="fa-solid fa-gear text-base w-4 text-center"></i>
            <span>Settings</span>
        </a>
                <a href="/peersync/views/auth/logout-process.php" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-sm text-slate-600 dark:text-slate-400 hover:bg-red-50 dark:hover:bg-red-500/10 hover:text-red-600 dark:hover:text-red-400 border border-transparent hover:border-red-200/60 dark:hover:border-red-500/20 transition-all duration-200 group">
                    <i class="fa-solid fa-right-from-bracket text-sm w-5 text-center text-slate-400 dark:text-slate-500 group-hover:text-red-500 dark:group-hover:text-red-400 transition-colors"></i>
                    <span>Logout</span>
                </a>
            </nav>
        </div>
    </div>

    <div class="p-4 border-t border-slate-200 dark:border-[#1e295d] bg-white dark:bg-[#111936] flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-800/20 cursor-pointer transition sticky bottom-0 z-10 flex-shrink-0">
        <div class="flex items-center space-x-3">
            <div class="w-9 h-9 rounded-full bg-slate-200 dark:bg-slate-700/60 border border-slate-300 dark:border-slate-600 flex items-center justify-center font-bold text-slate-600 dark:text-slate-300 text-sm cursor-pointer">
                <?php echo htmlspecialchars($initials); ?>
            </div>
            <div>
                <h4 class="text-xs font-semibold text-slate-900 dark:text-white leading-tight"><?= htmlspecialchars($name) ?></h4>
                <span class="text-[11px] text-slate-400 dark:text-slate-500"><?= htmlspecialchars($role) ?></span>
            </div>
        </div>
        <i class="fa-solid fa-chevron-down text-xs text-slate-400 dark:text-slate-500"></i>
    </div>
</aside>

    <!-- MAIN -->
    <main class="flex-1 flex flex-col h-screen min-w-0 overflow-hidden">
        <!-- HEADER -->
        <header class="h-20 border-b border-slate-200 dark:border-[#1e295d] px-8 flex items-center justify-between bg-white dark:bg-[#0b132b] flex-shrink-0 transition-colors duration-300">
            <h1 class="text-xl font-semibold text-slate-900 dark:text-white">
                <?= $section === 'tutor' ? 'Espace Tuteur' : 'Dashboard' ?>
            </h1>

            <div class="flex items-center space-x-6">
                <div class="relative w-80 hidden sm:block">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 dark:text-slate-500">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" placeholder="Search requests, tutors..."
                        class="w-full bg-slate-100 dark:bg-[#111936] text-slate-800 dark:text-slate-300 pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-[#1e295d] focus:outline-none focus:border-blue-500 transition placeholder-slate-400 dark:placeholder-slate-500 text-sm">
                </div>

                <div class="flex items-center space-x-2">
    <span class="text-xs font-medium text-slate-500 dark:text-slate-400 px-1 hidden xs:block">
        <i id="mode-icon" class="fa-solid fa-moon mr-1"></i>
    </span>
    <button id="dark-mode-toggle" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-blue-600 transition-colors duration-200 ease-in-out focus:outline-none" role="switch" aria-checked="true">
        <span id="switch-handle" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out translate-x-5"></span>
    </button>
</div>

                <!-- Notification Wrapper -->
<div class="relative inline-block text-left" id="notification-wrapper">
    
    <!-- Notification Trigger Icon -->
    <button id="notification-btn" class="relative cursor-pointer p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 transition-all duration-200 focus:outline-none">
        <i class="fa-regular fa-bell text-xl text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200"></i>
        <!-- Badge -->
        <span class="absolute top-1 right-1 bg-gradient-to-r from-red-500 to-pink-500 text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold">2</span>
    </button>

    <!-- Dropdown Menu -->
    <!-- 
      Animations classes details:
      - Hidden by default: 'hidden'
      - Opacity & Scale transitions for that smooth premium feeling
    -->
    <div id="notification-dropdown" class="hidden absolute right-0 mt-2 w-80 sm:w-96 origin-top-right rounded-2xl bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 shadow-xl dark:shadow-2xl focus:outline-none z-50 transform opacity-0 scale-95 transition-all duration-200 ease-out">
        
        <!-- Header -->
        <div class="flex items-center justify-between px-4 py-3 border-b border-slate-100 dark:border-slate-800">
            <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100">Notifications</h3>
            <button class="text-xs font-medium text-blue-600 dark:text-blue-400 hover:underline">Mark all as read</button>
        </div>

        <!-- Notifications List Container -->
        <div class="max-h-80 overflow-y-auto divide-y divide-slate-50 dark:divide-slate-800/50">
            
            <!-- Notification Item 1 (Unread) -->
            <a href="#" class="flex gap-3 p-4 bg-blue-50/40 dark:bg-blue-950/10 hover:bg-slate-50 dark:hover:bg-slate-800/60 transition-colors duration-150">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center text-blue-600 dark:text-blue-400">
                    <i class="fa-solid fa-user-plus text-sm"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-slate-800 dark:text-slate-200 font-medium">
                        <span class="font-semibold text-slate-900 dark:text-white">Amine Benali</span> sent you a connection request.
                    </p>
                    <span class="text-xs text-slate-400 dark:text-slate-500 mt-1 block">Just now</span>
                </div>
                <!-- Unread Indicator Dot -->
                <div class="flex-shrink-0 self-center">
                    <span class="block w-2 h-2 rounded-full bg-blue-600"></span>
                </div>
            </a>

            <!-- Notification Item 2 (Unread) -->
            <a href="#" class="flex gap-3 p-4 bg-blue-50/40 dark:bg-blue-950/10 hover:bg-slate-50 dark:hover:bg-slate-800/60 transition-colors duration-150">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                    <i class="fa-solid fa-circle-check text-sm"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-slate-800 dark:text-slate-200">
                        Your payment for <span class="font-semibold text-slate-900 dark:text-white">Invoice #1024</span> was successful.
                    </p>
                    <span class="text-xs text-slate-400 dark:text-slate-500 mt-1 block">2 hours ago</span>
                </div>
                <div class="flex-shrink-0 self-center">
                    <span class="block w-2 h-2 rounded-full bg-blue-600"></span>
                </div>
            </a>

            <!-- Notification Item 3 (Read) -->
            <a href="#" class="flex gap-3 p-4 hover:bg-slate-50 dark:hover:bg-slate-800/60 transition-colors duration-150">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-900/50 flex items-center justify-center text-amber-600 dark:text-amber-400">
                    <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-slate-600 dark:text-slate-400">
                        Storage space is running low (85% used). Upgrade your plan.
                    </p>
                    <span class="text-xs text-slate-400 dark:text-slate-500 mt-1 block">1 day ago</span>
                </div>
            </a>

        </div>

        <!-- Footer -->
        <div class="p-3 text-center border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 rounded-b-2xl">
            <a href="#" class="text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                View all notifications
            </a>
        </div>
    </div>
</div>

                <!-- Profile Menu Wrapper -->
<div class="relative inline-block text-left" id="profile-wrapper">
    
    <!-- Profile Trigger Button -->
    <button id="profile-btn" class="w-9 h-9 rounded-full bg-slate-200 dark:bg-slate-700/60 border border-slate-300 dark:border-slate-600 flex items-center justify-center font-bold text-slate-600 dark:text-slate-300 text-sm cursor-pointer hover:border-slate-400 dark:hover:border-slate-500 transition-all duration-200 focus:outline-none">
        <?php echo htmlspecialchars($initials); ?>
    </button>

    <!-- Dropdown Menu -->
    <div id="profile-dropdown" class="hidden absolute right-0 mt-2 w-64 origin-top-right rounded-2xl bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 shadow-xl dark:shadow-2xl focus:outline-none z-50 transform opacity-0 scale-95 transition-all duration-200 ease-out">
        
        <!-- User Info Header Section -->
        <div class="px-4 py-4 border-b border-slate-100 dark:border-slate-800 bg-slate-50/40 dark:bg-slate-900/40 rounded-t-2xl">
            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500">Signed in as</p>
            <!-- Smya dyal l-user -->
            <p class="text-sm font-bold text-slate-800 dark:text-white mt-1 truncate">
                Amine Benali
            </p>
            <!-- Email walla l-role dyalo f l-platform -->
            <p class="text-xs text-slate-500 dark:text-slate-400 truncate">
                amine.developer@email.com
            </p>
            
            <!-- Badge dyal l-Role (Admin/Professor/Student) -->
            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-blue-50 text-blue-700 border border-blue-200 dark:bg-blue-950/40 dark:text-blue-400 dark:border-blue-900 mt-2">
                Administrator
            </span>
        </div>

        <!-- Navigation Links Menu -->
        <div class="p-1.5 space-y-0.5">
            <!-- Profile Link -->
            <a href="profile.php" class="flex items-center gap-3 px-3 py-2 text-sm text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800/60 rounded-xl transition-all duration-150 group">
                <i class="fa-regular fa-user text-base text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300 w-5"></i>
                My Profile
            </a>

            <!-- Settings Link -->
            <a href="settings.php" class="flex items-center gap-3 px-3 py-2 text-sm text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800/60 rounded-xl transition-all duration-150 group">
                <i class="fa-regular fa-gear text-base text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300 w-5"></i>
                Account Settings
            </a>

            <!-- Help/Support Link -->
            <a href="support.php" class="flex items-center gap-3 px-3 py-2 text-sm text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800/60 rounded-xl transition-all duration-150 group">
                <i class="fa-regular fa-circle-question text-base text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300 w-5"></i>
                Help & Support
            </a>
        </div>

        <!-- Separation Line -->
        <div class="border-t border-slate-100 dark:border-slate-800 my-1"></div>

        <!-- Logout Action Button -->
        <div class="p-1.5">
            <a href="logout.php" class="flex items-center gap-3 px-3 py-2 text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/30 rounded-xl transition-all duration-150 group">
                <i class="fa-regular fa-arrow-right-from-bracket text-base text-red-400 group-hover:text-red-600 dark:group-hover:text-red-400 w-5"></i>
                Sign Out
            </a>
        </div>

    </div>
</div>
            </div>
        </header>

        <!-- DYNAMIC CONTENT -->
      <?php
if ($section === 'tutor') {
    include __DIR__ . '/Content_Tutor.php';
} elseif ($section === 'profile') {
    include __DIR__ . '/profile.php';
} elseif ($section === 'reviews') {
    include __DIR__ . '/reviews.php';
} elseif ($section === 'Requests_Resolved') {
    include __DIR__ . '/Requests_Resolved.php';
} elseif ($section === 'Settings') {
    include __DIR__ . '/Settings.php';
    
}else {
    include __DIR__ . '/Content_dashboard.php';
}
?>

    <!-- MODAL: New Request -->
    

    <!-- MODAL: Details -->
  
        
<!-- [NEW] Modern Backdrop-Blur Modal for adding a skill -->
<div id="skill-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 dark:bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
    
    <div id="skill-card" class="bg-white dark:bg-[#111936] border border-slate-200 dark:border-[#1e295d] rounded-2xl w-full max-w-md shadow-2xl scale-95 transition-all duration-300 overflow-hidden">
        
        <!-- Header -->
        <div class="px-6 py-4 border-b border-slate-100 dark:border-[#1e295d]/60 flex items-center justify-between">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center space-x-2">
                <i class="fa-solid fa-graduation-cap text-blue-500 text-base"></i>
                <span>Add New Skill / Technology</span>
            </h3>
            <button onclick="closeSkillModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition p-1 rounded-lg hover:bg-slate-100 dark:hover:bg-[#0b132b]">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <!-- Form -->
        <form id="skill-form" action="/peersync/app/controller/HelpRequestController.php" method="POST" onsubmit="return validateSkillForm(event)" class="p-6 space-y-4">
            
            <div class="space-y-1.5">
                <label for="skill-name" class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Skill Name</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        <i class="fa-solid fa-code text-xs"></i>
                    </span>
                    <input type="text" id="skill-name" name="skill_name" placeholder="e.g. Laravel, React, Docker..." 
                           class="w-full bg-slate-50 dark:bg-[#0b132b] text-slate-800 dark:text-slate-300 pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-[#1e295d] focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm placeholder-slate-400 transition-all">
                </div>
                <p id="skill-name-error" class="text-red-500 text-xs hidden mt-1 flex items-center">
                    <i class="fa-solid fa-circle-exclamation mr-1"></i> Please enter a valid skill name (min 2 characters).
                </p>
            </div>

            <!-- Footer Buttons -->
            <div class="pt-4 border-t border-slate-100 dark:border-[#1e295d]/60 flex items-center justify-end space-x-3">
                <button type="button" onclick="closeSkillModal()" class="px-4 py-2 rounded-xl text-sm font-medium text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-[#0b132b] transition">
                    Cancel
                </button>
                <button name= "creat_skills" type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-xl text-sm transition shadow-md shadow-blue-500/10">
                    Save Skill
                </button>
            </div>
        </form>

    </div>
</div>
    <script>
        // skills modal 
        // [NEW] Logic for Add Skill Modal & Validation

function openSkillModal() {
    const modal = document.getElementById('skill-modal');
    const card = document.getElementById('skill-card');
    
    if (modal && card) {
        document.body.appendChild(modal); // Safely mount to body to avoid z-index/overflow issues
        modal.classList.remove('opacity-0', 'pointer-events-none');
        card.classList.remove('scale-95');
        card.classList.add('scale-100');
        
        // Focus input straight away
        setTimeout(() => document.getElementById('skill-name').focus(), 100);
    }
}

function closeSkillModal() {
    const modal = document.getElementById('skill-modal');
    const card = document.getElementById('skill-card');
    const form = document.getElementById('skill-form');
    const errorMsg = document.getElementById('skill-name-error');
    const input = document.getElementById('skill-name');
    
    if (modal && card) {
        modal.classList.add('opacity-0', 'pointer-events-none');
        card.classList.remove('scale-100');
        card.classList.add('scale-95');
        
        // Reset inputs and errors when closing
        if(form) form.reset();
        if(errorMsg) errorMsg.classList.add('hidden');
        if(input) input.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500/20');
    }
}

function validateSkillForm(event) {
    const input = document.getElementById('skill-name');
    const errorMsg = document.getElementById('skill-name-error');
    const value = input.value.trim();

    if (value.length < 2) {
        // Stop form submission
        event.preventDefault();
        
        // Show modern error layout
        errorMsg.classList.remove('hidden');
        input.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500/20');
        
        // Add shake animation effect (Optional but matches high quality visual standard)
        input.classList.add('animate-shake');
        setTimeout(() => input.classList.remove('animate-shake'), 500);
        
        return false;
    }
    
    return true;
}
        // Fonction mni kayclikki 3la Mark as Resolved
window.handleResolveRequest = function() {
    const btn = document.getElementById('resolve-btn');
    const icon = document.getElementById('resolve-icon');
    const text = document.getElementById('resolve-text');
    const ratingCard = document.getElementById('rating-card');

    if (!btn) return;

    // 1. Tbdel l-design dial l-button (wllat Resolved o Disabled)
    btn.disabled = true;
    btn.classList.remove('bg-emerald-600', 'hover:bg-emerald-700', 'cursor-pointer');
    btn.classList.add('bg-emerald-500/10', 'text-emerald-600', 'dark:text-emerald-400', 'border', 'border-emerald-500/20', 'cursor-not-allowed');
    
    // 2. Tbdel l-icon o l-kitaba
    if (icon) {
        icon.className = "fa-solid fa-circle-check text-sm"; // rj3at solid icon
    }
    if (text) {
        text.textContent = "Resolved";
    }

    // 3. Affichi l-Card dial rating b-animation smooth
    if (ratingCard) {
        ratingCard.classList.remove('max-h-0', 'opacity-0');
        ratingCard.classList.add('max-h-40', 'opacity-100', 'border-slate-200', 'dark:border-slate-800', 'pt-3');
    }
};

// Fonction bach t-gérer l-clik 3la njmat (Rating)
let currentRating = 0;
window.setRating = function(ratingValue) {
    currentRating = ratingValue;
    const stars = document.querySelectorAll('.star-btn');
    
    stars.forEach((star, index) => {
        if (index < ratingValue) {
            // Njmzat li mseltin yvlliou solid o sfar
            star.className = "fa-solid fa-star text-xl text-amber-400 cursor-pointer hover:scale-110 transition star-btn";
        } else {
            // Njmzat l-ba9iyin dima empty
            star.className = "fa-regular fa-star text-xl text-slate-300 dark:text-slate-600 cursor-pointer hover:scale-110 transition star-btn";
        }
    });
};

// Action dial submission (b7al ila ghadi tsiftha l-baza dyal l-ma3loumat)
window.submitRating = function() {
    if (currentRating === 0) {
        alert("Please select a star rating first!");
        return;
    }
    alert("Thank you for your rating of " + currentRating + " stars!");
    
    // Hna t9der t-gérer l-ferman dial modal aw tsiftha l-backend b-Fetch API
    if (typeof closeDetailsModal === 'function') {
        closeDetailsModal();
    }
};
        // Dark mode toggle
        // Dark mode toggle — persist in localStorage
        const toggleBtn = document.getElementById('dark-mode-toggle');
        const switchHandle = document.getElementById('switch-handle');
        const modeIcon = document.getElementById('mode-icon');
        const htmlEl = document.documentElement;

        if (localStorage.getItem('theme') === 'light') {
            document.documentElement.classList.remove('dark');
        }

        // Apply saved preference on page load
        const savedMode = localStorage.getItem('theme');
        if (savedMode === 'light') {
            htmlEl.classList.remove('dark');
            toggleBtn.classList.replace('bg-blue-600', 'bg-slate-300');
            switchHandle.classList.replace('translate-x-5', 'translate-x-0');
            modeIcon.className = 'fa-solid fa-sun text-amber-500 mr-1';
        }

        toggleBtn.addEventListener('click', () => {
            if (htmlEl.classList.contains('dark')) {
                htmlEl.classList.remove('dark');
                toggleBtn.classList.replace('bg-blue-600', 'bg-slate-300');
                switchHandle.classList.replace('translate-x-5', 'translate-x-0');
                modeIcon.className = 'fa-solid fa-sun text-amber-500 mr-1';
                localStorage.setItem('theme', 'light');
            } else {
                htmlEl.classList.add('dark');
                toggleBtn.classList.replace('bg-slate-300', 'bg-blue-600');
                switchHandle.classList.replace('translate-x-0', 'translate-x-5');
                modeIcon.className = 'fa-solid fa-moon text-slate-400 mr-1';
                localStorage.setItem('theme', 'dark');
            }
        });

        // New Request modal
       

        // Details modal
        const detailsModal = document.getElementById('details-modal');
        const detailsCard = document.getElementById('details-card');

        function openDetailsModal() {
            detailsModal.classList.remove('opacity-0', 'pointer-events-none');
            detailsCard.classList.replace('scale-95', 'scale-100');
        }

        function closeDetailsModal() {
            detailsModal.classList.add('opacity-0', 'pointer-events-none');
            detailsCard.classList.replace('scale-100', 'scale-95');
        }
        detailsModal.addEventListener('click', (e) => {
            if (e.target === detailsModal) closeDetailsModal();
        });
        // detail afichage modal
        // Fonction pour ouvrir le modal des détails avec l'injection des données
window.openDetailsModal = function(button) {
    const modal = document.getElementById('details-modal');
    const card = document.getElementById('details-card');
    
    if (!modal || !card) return;

    // 1. Récupération des données depuis le bouton cliqué
    const id = button.getAttribute('data-id') || '';
    const title = button.getAttribute('data-title') || '';
    const desc = button.getAttribute('data-desc') || '';
    const status = (button.getAttribute('data-status') || '').toUpperCase();
    const tech = button.getAttribute('data-tech') || 'Unknown';
    const date = button.getAttribute('data-date') || '';
    const tutorName = button.getAttribute('data-tutor') || '';
    const studentName = button.getAttribute('data-user') || 'Student';
    const idInput = document.getElementById('help-request-id'); // 👈 كنجيبو الـ Input المخفي
    if (idInput) idInput.value = id;
    // 2. Injection des données basiques dans le HTML du modal
    document.getElementById('detail-title').textContent = title;
    document.getElementById('detail-desc').textContent = desc;
    document.getElementById('detail-date').textContent = date;
    document.getElementById('detail-badge-tech').textContent = tech;
    document.getElementById('detail-badge-status').textContent = status.charAt(0) + status.slice(1).toLowerCase();
    
    // Mettre à jour le nom de l'étudiant dans la timeline
    const timelineUser = document.getElementById('timeline-user-name');
    if (timelineUser) timelineUser.textContent = `By ${studentName}`;

    // 3. Gestion dynamique des Badges de statut (Couleurs)
    const statusBadge = document.getElementById('detail-badge-status');
    // Nettoyer les anciennes classes de couleur
    statusBadge.className = "text-[11px] px-2.5 py-0.5 rounded-md font-medium border";
    
    if (status === 'RESOLVED') {
        statusBadge.classList.add('bg-emerald-500/10', 'text-emerald-600', 'dark:text-emerald-400', 'border-emerald-500/20');
    } else if (status === 'ASSIGNED' || status === 'IN PROGRESS') {
        statusBadge.classList.add('bg-blue-500/10', 'text-blue-600', 'dark:text-blue-400', 'border-blue-500/20');
    } else { // PENDING
        statusBadge.classList.add('bg-amber-500/10', 'text-amber-600', 'dark:text-amber-400', 'border-amber-500/20');
    }
    modal.classList.remove('opacity-0', 'pointer-events-none');
    card.classList.remove('scale-95');
    // 4. Gestion de la visibilité des cartes du tuteur (Assigned vs Awaiting)
    const tutorCard = document.getElementById('tutor-info-card');
    const noTutorCard = document.getElementById('no-tutor-card');
    const timelineTutor = document.getElementById('timeline-tutor-assigned');

    if (tutorName && tutorName.trim() !== "") {
        // Si un tuteur est assigné
        if (tutorCard) tutorCard.classList.remove('hidden');
        if (noTutorCard) noTutorCard.classList.add('hidden');
        if (timelineTutor) timelineTutor.classList.remove('hidden');
        
        // Injecter le nom et la première lettre
        const tutorFullNameElem = document.getElementById('tutor-full-name');
        const tutorInitialElem = document.getElementById('tutor-initial');
        const timelineTutorNameElem = document.getElementById('timeline-tutor-name');

        if (tutorFullNameElem) tutorFullNameElem.textContent = tutorName;
        if (timelineTutorNameElem) timelineTutorNameElem.textContent = `Assigned to ${tutorName}`;
        if (tutorInitialElem) tutorInitialElem.textContent = tutorName.charAt(0).toUpperCase();
    } else {
        // Si aucun tuteur n'est encore assigné
        if (tutorCard) tutorCard.classList.add('hidden');
        if (noTutorCard) noTutorCard.classList.remove('hidden');
        if (timelineTutor) timelineTutor.classList.add('hidden'); // masquer de la timeline
    }

    // 5. Affichage du Modal avec l'animation Tailwind original
    modal.classList.remove('opacity-0', 'pointer-events-none');
    card.classList.remove('scale-95');
    card.classList.add('scale-100');
};

// Fonction pour fermer le modal des détails
window.closeDetailsModal = function() {
    const modal = document.getElementById('details-modal');
    const card = document.getElementById('details-card');
    
    if (!modal || !card) return;

    // Cacher le modal et remettre l'effet scale
    modal.classList.add('opacity-0', 'pointer-events-none');
    card.classList.remove('scale-100');
    card.classList.add('scale-95');
};
        // message of validation

        document.addEventListener("DOMContentLoaded", function() {
            const titleInput = document.getElementById("modal-title");
            const techSelect = document.getElementById("modal-tech");
            const descInput = document.getElementById("modal-desc");
            const submitBtn = document.getElementById("submit-request-btn");

            const titleError = document.getElementById("title-error");
            const techError = document.getElementById("tech-error");
            const descError = document.getElementById("desc-error");

            function validateForm() {
                let isTitleValid = titleInput.value.trim() !== "";
                let isTechValid = techSelect.value !== "";
                let isDescValid = descInput.value.trim() !== "";

                // إظهار أو إخفاء رسائل الخطأ لكل حقل
                if (titleInput.value.trim() === "" && titleInput === document.activeElement) {
                    titleError.classList.remove("hidden");
                } else if (titleInput.value.trim() !== "") {
                    titleError.classList.add("hidden");
                }

                if (techSelect.value === "" && techSelect === document.activeElement) {
                    techError.classList.remove("hidden");
                } else if (techSelect.value !== "") {
                    techError.classList.add("hidden");
                }

                if (descInput.value.trim() === "" && descInput === document.activeElement) {
                    descError.classList.remove("hidden");
                } else if (descInput.value.trim() !== "") {
                    descError.classList.add("hidden");
                }

                if (isTitleValid && isTechValid && isDescValid) {
                    submitBtn.removeAttribute("disabled");
                    submitBtn.className = "px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-xl transition shadow-md shadow-blue-500/10 cursor-pointer";
                } else {
                    submitBtn.setAttribute("disabled", "true");
                    submitBtn.className = "px-5 py-2 bg-slate-300 dark:bg-slate-800 text-slate-400 dark:text-slate-600 font-medium text-sm rounded-xl transition cursor-not-allowed";
                }
            }


            titleInput.addEventListener("input", validateForm);
            titleInput.addEventListener("blur", validateForm);

            techSelect.addEventListener("change", validateForm);
            techSelect.addEventListener("blur", validateForm);

            descInput.addEventListener("input", validateForm);
            descInput.addEventListener("blur", validateForm);
        });
        document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('notification-btn');
    const dropdown = document.getElementById('notification-dropdown');
    const wrapper = document.getElementById('notification-wrapper');

    function toggleDropdown() {
        if (dropdown.classList.contains('hidden')) {
            // Open animation
            dropdown.classList.remove('hidden');
            // Ghadi ntsnnaw chwya bach l-browser y-trigger transition
            setTimeout(() => {
                dropdown.classList.remove('opacity-0', 'scale-95');
                dropdown.classList.add('opacity-100', 'scale-100');
            }, 10);
        } else {
            // Close animation
            dropdown.classList.remove('opacity-100', 'scale-100');
            dropdown.classList.add('opacity-0', 'scale-95');
            // Khassna ntsnnaw transition tsali (200ms) 3ad ndiro hidden
            setTimeout(() => {
                dropdown.classList.add('hidden');
            }, 200);
        }
    }

    // Event listener 3la l-bouton
    btn.addEventListener('click', (e) => {
        e.stopPropagation();
        toggleDropdown();
    });

    // Tsadd l-dropdown ila klykyty f khwa dyal dashboard
    document.addEventListener('click', (e) => {
        if (!wrapper.contains(e.target) && !dropdown.classList.contains('hidden')) {
            dropdown.classList.remove('opacity-100', 'scale-100');
            dropdown.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                dropdown.classList.add('hidden');
            }, 200);
        }
    });
});
document.addEventListener('DOMContentLoaded', () => {
    const profileBtn = document.getElementById('profile-btn');
    const profileDropdown = document.getElementById('profile-dropdown');
    const profileWrapper = document.getElementById('profile-wrapper');

    function toggleProfileDropdown() {
        if (profileDropdown.classList.contains('hidden')) {
            // Open Transition
            profileDropdown.classList.remove('hidden');
            setTimeout(() => {
                profileDropdown.classList.remove('opacity-0', 'scale-95');
                profileDropdown.classList.add('opacity-100', 'scale-100');
            }, 10);
        } else {
            // Close Transition
            profileDropdown.classList.remove('opacity-100', 'scale-100');
            profileDropdown.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                profileDropdown.classList.add('hidden');
            }, 200);
        }
    }

    // Click trigger on avatar
    profileBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        toggleProfileDropdown();
    });

    // Close when clicking outside the profile menu wrapper
    document.addEventListener('click', (e) => {
        if (!profileWrapper.contains(e.target) && !profileDropdown.classList.contains('hidden')) {
            profileDropdown.classList.remove('opacity-100', 'scale-100');
            profileDropdown.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                profileDropdown.classList.add('hidden');
            }, 200);
        }
    });
});
    </script>
</body>

</html>