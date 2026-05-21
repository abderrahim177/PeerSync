<?php 
    require_once __DIR__ . '/login-process.php';
    $name = $_SESSION['user_name'];
    $role = $_SESSION['user_role'];

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
        tailwind.config = { darkMode: 'class' }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; }
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
                    <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 tracking-wider uppercase px-3 mb-2">Main</p>
                    <nav class="space-y-0.5">
                        <!-- Dashboard link -->
                        <a href="?section=dashboard" class="flex items-center justify-between px-3 py-2.5 rounded-xl transition
                            <?= $section === 'dashboard' ? 'bg-blue-50 dark:bg-blue-600/10 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/10 font-medium' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/30 hover:text-slate-900 dark:hover:text-slate-200' ?>">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-table-columns text-base w-4 text-center"></i>
                                <span>Dashboard</span>
                            </div>
                        </a>

                        <button onclick="openModal()" class="w-full flex items-center space-x-3 px-3 py-2.5 rounded-xl text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/30 hover:text-slate-900 dark:hover:text-slate-200 transition text-left">
                            <i class="fa-solid fa-circle-plus text-base w-4 text-center"></i>
                            <span>New Request</span>
                        </button>

                        <a href="#" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/30 hover:text-slate-900 dark:hover:text-slate-200 transition">
                            <div class="flex items-center space-x-3">
                                <i class="fa-regular fa-file-lines text-base w-4 text-center"></i>
                                <span>My Requests</span>
                            </div>
                            <span class="bg-blue-50 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 text-[11px] px-2 py-0.5 rounded-full border border-blue-200 dark:border-blue-500/20">3</span>
                        </a>
                    </nav>

                    <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 tracking-wider uppercase px-3 mt-5 mb-2">Explore</p>
                    <nav class="space-y-0.5">
                        <!-- Espace Tuteur link -->
                        <a href="?section=tutor" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl transition
                            <?= $section === 'tutor' ? 'bg-blue-50 dark:bg-blue-600/10 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/10 font-medium' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/30 hover:text-slate-900 dark:hover:text-slate-200' ?>">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="w-4 text-center flex-shrink-0"><circle cx="8" cy="5" r="3"/><path d="M2 14c0-3.3 2.7-6 6-6s6 2.7 6 6"/><path d="M11 2l1.5 1.5L15 1"/></svg>
                            <span>Espace Tuteur</span>
                        </a>

                        <a href="#" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/30 hover:text-slate-900 dark:hover:text-slate-200 transition">
                            <i class="fa-regular fa-star text-base w-4 text-center"></i>
                            <span>Reviews & Ratings</span>
                        </a>
                    </nav>
                </div>
            </div>

            <div class="px-3 py-4 mt-auto">
                <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 tracking-wider uppercase px-3 mb-2">Account</p>
                <nav class="space-y-0.5">
                    <a href="#" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/30 hover:text-slate-900 dark:hover:text-slate-200 transition">
                        <i class="fa-solid fa-gear text-base w-4 text-center"></i>
                        <span>Settings</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/30 hover:text-slate-900 dark:hover:text-slate-200 transition">
                        <i class="fa-solid fa-right-from-bracket text-base w-4 text-center"></i>
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

                <div class="flex items-center space-x-2 bg-slate-100 dark:bg-[#111936] border border-slate-200 dark:border-[#1e295d] p-1.5 rounded-xl">
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400 px-1 hidden xs:block">
                        <i id="mode-icon" class="fa-solid fa-moon mr-1"></i>
                    </span>
                    <button id="dark-mode-toggle" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-blue-600 transition-colors duration-200 ease-in-out focus:outline-none" role="switch" aria-checked="true">
                        <span id="switch-handle" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out translate-x-5"></span>
                    </button>
                </div>

                <div class="relative cursor-pointer p-1">
                    <i class="fa-regular fa-bell text-xl text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold">2</span>
                </div>

                <div class="w-9 h-9 rounded-full bg-slate-200 dark:bg-slate-700/60 border border-slate-300 dark:border-slate-600 flex items-center justify-center font-bold text-slate-600 dark:text-slate-300 text-sm cursor-pointer">
                    <?php echo htmlspecialchars($initials); ?>
                </div>
            </div>
        </header>

        <!-- DYNAMIC CONTENT -->
        <?php if ($section === 'tutor'): ?>
            <?php include __DIR__ . '/Content_Tutor.php'; ?>
        <?php else: ?>
            <?php include __DIR__ . '/Content_dashboard.php'; ?>
        <?php endif; ?>
    </main>

    <!-- MODAL: New Request -->
    <div id="request-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 dark:bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
        <form action="../../app/controller/HelpRequestController.php" method="post" class="bg-white dark:bg-[#111936] w-full max-w-xl rounded-2xl border border-slate-200 dark:border-[#1e295d] shadow-2xl flex flex-col max-h-[90vh] overflow-hidden transform scale-95 transition-transform duration-300" id="modal-card">
            <div class="p-6 pb-4 border-b border-slate-100 dark:border-[#1e295d] flex items-start justify-between">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Create Help Request</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Describe your problem and a tutor will be assigned to help you.</p>
                </div>
                <button type="button" onclick="closeModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition p-1 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800/50">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <div class="p-6 space-y-5 overflow-y-auto custom-scrollbar flex-1">
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300">Title <span class="text-red-500">*</span></label>
                    <input name="title" type="text" placeholder="e.g., Help with React useEffect hook" 
                           class="w-full bg-slate-50 dark:bg-[#0b132b] text-slate-800 dark:text-slate-200 px-4 py-2.5 rounded-xl border border-slate-200 dark:border-[#1e295d] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition placeholder-slate-400 dark:placeholder-slate-500 text-sm shadow-sm">
                    <p class="text-[11px] text-slate-400 dark:text-slate-500">A clear, concise title helps tutors understand your issue quickly.</p>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300">Technology / Skill <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select name="technology" class="w-full bg-slate-50 dark:bg-[#0b132b] text-slate-800 dark:text-slate-200 px-4 py-2.5 rounded-xl border border-slate-200 dark:border-[#1e295d] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition text-sm appearance-none shadow-sm cursor-pointer">
                            <option value="">select technology. . .</option>
                            <?php foreach ($technologies as $tech): ?>
                            <option value="<?= $tech['id']; ?>"><?= htmlspecialchars($tech['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 pointer-events-none">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </span>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300">Description <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="4" placeholder="Describe your problem in detail. Include any error messages, what you've tried, and what you expected to happen." 
                              class="w-full bg-slate-50 dark:bg-[#0b132b] text-slate-800 dark:text-slate-200 px-4 py-3 rounded-xl border border-slate-200 dark:border-[#1e295d] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition placeholder-slate-400 dark:placeholder-slate-500 text-sm shadow-sm resize-none"></textarea>
                    <p class="text-[11px] text-slate-400 dark:text-slate-500">The more detail you provide, the faster you'll get effective help.</p>
                </div>

                <div class="bg-blue-50/50 dark:bg-[#0b132b]/50 border border-blue-100 dark:border-[#1e295d] rounded-xl p-4 flex items-start space-x-3">
                    <i class="fa-regular fa-circle-question text-blue-500 dark:text-blue-400 text-base mt-0.5"></i>
                    <div class="space-y-1">
                        <h4 class="text-xs font-semibold text-slate-800 dark:text-slate-300">Tips for a great request</h4>
                        <ul class="text-[11px] text-slate-500 dark:text-slate-400 space-y-1 list-disc list-inside pl-0.5">
                            <li>Be specific about what you're trying to accomplish</li>
                            <li>Include relevant code snippets or error messages</li>
                            <li>Mention what you've already tried</li>
                            <li>Share links to documentation you've read</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="p-5 border-t border-slate-100 dark:border-[#1e295d] flex items-center justify-end space-x-3 bg-slate-50/50 dark:bg-[#111936]">
                <button type="button" onclick="closeModal()" class="px-4 py-2 rounded-xl text-slate-600 dark:text-slate-300 font-medium text-sm hover:bg-slate-100 dark:hover:bg-slate-800 transition">Cancel</button>
                <button name="submit" type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-xl transition shadow-md shadow-blue-500/10">Submit Request</button>
            </div>
        </form>
    </div>

    <!-- MODAL: Details -->
    <div id="details-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 dark:bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
        <div id="details-card" class="bg-white dark:bg-[#0b132b] w-full max-w-4xl rounded-2xl border border-slate-200 dark:border-[#1e295d] shadow-2xl flex flex-col max-h-[90vh] overflow-hidden transform scale-95 transition-transform duration-300 text-slate-600 dark:text-slate-300">
            
            <div class="p-6 pb-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                <button onclick="closeDetailsModal()" class="flex items-center space-x-2 text-xs text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white transition">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Back to Dashboard</span>
                </button>
                <button onclick="closeDetailsModal()" class="text-slate-400 hover:text-slate-800 dark:hover:text-white transition p-1 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <div class="p-6 overflow-y-auto custom-scrollbar flex-1 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 space-y-6">
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2">
                            <span class="bg-blue-500/10 text-blue-600 dark:text-blue-400 text-[11px] px-2.5 py-0.5 rounded-md font-medium">React</span>
                            <span class="bg-teal-500/10 text-teal-600 dark:text-teal-400 text-[11px] px-2.5 py-0.5 rounded-md font-medium">In Progress</span>
                        </div>
                        <h2 class="text-xl font-bold text-slate-900 dark:text-white">Help with React useEffect cleanup</h2>
                        <div class="text-slate-600 dark:text-slate-400 space-y-3 text-xs leading-relaxed">
                            <p>I'm having trouble understanding when and how to properly clean up effects in React. My component keeps throwing memory leak warnings when navigating away from the page.</p>
                            <p>I've tried returning a cleanup function but I'm not sure if I'm doing it correctly. The warning says 'Can't perform a React state update on an unmounted component'.</p>
                        </div>
                        <p class="text-[11px] text-slate-400 dark:text-slate-500 flex items-center"><i class="fa-regular fa-clock mr-1.5"></i>May 18, 2026 at 2:30 PM</p>
                    </div>

                    <hr class="border-slate-200 dark:border-slate-800">

                    <div class="space-y-4">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white tracking-wide">Activity Timeline</h3>
                        <div class="relative pl-6 space-y-6 before:absolute before:bottom-2 before:top-2 before:left-[11px] before:w-[1px] before:bg-slate-200 dark:before:bg-slate-800">
                            <div class="relative">
                                <div class="absolute -left-[21px] mt-0.5 bg-amber-500/10 text-amber-600 dark:text-amber-500 border border-amber-500/20 w-5 h-5 rounded-full flex items-center justify-center text-[10px]">
                                    <i class="fa-regular fa-clock"></i>
                                </div>
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="text-xs font-semibold text-slate-900 dark:text-white leading-tight">Request created</h4>
                                        <p class="text-[11px] text-slate-500 mt-0.5">by Ahmed El Fassi</p>
                                    </div>
                                    <span class="text-[10px] text-slate-400 dark:text-slate-500">May 18, 2:30 PM</span>
                                </div>
                            </div>
                            <div class="relative">
                                <div class="absolute -left-[21px] mt-0.5 bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-500/20 w-5 h-5 rounded-full flex items-center justify-center text-[10px]">
                                    <i class="fa-regular fa-user"></i>
                                </div>
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="text-xs font-semibold text-slate-900 dark:text-white leading-tight">Tutor assigned</h4>
                                        <p class="text-[11px] text-slate-500 mt-0.5">by Sarah Martinez</p>
                                        <div class="bg-slate-50 dark:bg-slate-900/60 text-slate-600 dark:text-slate-400 text-xs p-3 rounded-xl border border-slate-200 dark:border-slate-800 mt-2">
                                            I'll be helping you with this. Let me review your issue.
                                        </div>
                                    </div>
                                    <span class="text-[10px] text-slate-400 dark:text-slate-500">May 18, 2:45 PM</span>
                                </div>
                            </div>
                            <div class="relative">
                                <div class="absolute -left-[21px] mt-0.5 bg-teal-500/10 text-teal-600 dark:text-teal-400 border border-teal-500/20 w-5 h-5 rounded-full flex items-center justify-center text-[10px]">
                                    <i class="fa-regular fa-comment"></i>
                                </div>
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="text-xs font-semibold text-slate-900 dark:text-white leading-tight">Comment added</h4>
                                        <p class="text-[11px] text-slate-500 mt-0.5">by Sarah Martinez</p>
                                        <div class="bg-slate-50 dark:bg-slate-900/60 text-slate-600 dark:text-slate-400 text-xs p-3 rounded-xl border border-slate-200 dark:border-slate-800 mt-2">
                                            The issue is likely that you're setting state after an async operation completes, but the component has already unmounted.
                                        </div>
                                    </div>
                                    <span class="text-[10px] text-slate-400 dark:text-slate-500">May 18, 3:00 PM</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3 pt-2">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white">Add Comment</h3>
                        <div class="relative">
                            <textarea rows="2" placeholder="Write a comment..." class="w-full bg-slate-50 dark:bg-[#111936] border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 text-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-blue-500 text-xs resize-none shadow-sm"></textarea>
                            <div class="absolute right-3 bottom-3">
                                <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-3 py-1.5 rounded-lg text-xs transition flex items-center space-x-1.5">
                                    <i class="fa-regular fa-paper-plane text-[10px]"></i>
                                    <span>Send</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-5">
                    <div class="bg-slate-50 dark:bg-[#111936] border border-slate-200 dark:border-slate-800 rounded-2xl p-4 space-y-4">
                        <h4 class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Assigned Tutor</h4>
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 rounded-full bg-blue-100 dark:bg-blue-900/50 border border-blue-200 dark:border-blue-500/30 flex items-center justify-center text-sm font-bold text-blue-600 dark:text-blue-400">S</div>
                            <div>
                                <h4 class="text-xs font-semibold text-slate-900 dark:text-white">Sarah Martinez</h4>
                                <p class="text-[11px] text-slate-400 dark:text-slate-500">Tutor</p>
                            </div>
                        </div>
                        <button class="w-full bg-white dark:bg-transparent border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/50 text-slate-700 dark:text-white font-medium py-2 rounded-xl text-xs transition flex items-center justify-center space-x-2">
                            <i class="fa-regular fa-message text-xs"></i>
                            <span>Message Tutor</span>
                        </button>
                    </div>
                    <div class="bg-slate-50 dark:bg-[#111936] border border-slate-200 dark:border-slate-800 rounded-2xl p-4 space-y-3">
                        <h4 class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Actions</h4>
                        <button class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2.5 rounded-xl text-xs transition flex items-center justify-center space-x-2">
                            <i class="fa-regular fa-circle-check text-sm"></i>
                            <span>Mark as Resolved</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Dark mode toggle
        const toggleBtn = document.getElementById('dark-mode-toggle');
        const switchHandle = document.getElementById('switch-handle');
        const modeIcon = document.getElementById('mode-icon');
        const htmlEl = document.documentElement;

        toggleBtn.addEventListener('click', () => {
            if (htmlEl.classList.contains('dark')) {
                htmlEl.classList.remove('dark');
                toggleBtn.classList.replace('bg-blue-600', 'bg-slate-300');
                switchHandle.classList.replace('translate-x-5', 'translate-x-0');
                modeIcon.className = 'fa-solid fa-sun text-amber-500 mr-1';
            } else {
                htmlEl.classList.add('dark');
                toggleBtn.classList.replace('bg-slate-300', 'bg-blue-600');
                switchHandle.classList.replace('translate-x-0', 'translate-x-5');
                modeIcon.className = 'fa-solid fa-moon text-slate-400 mr-1';
            }
        });

        // New Request modal
        const modal = document.getElementById('request-modal');
        const modalCard = document.getElementById('modal-card');

        function openModal() {
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modalCard.classList.replace('scale-95', 'scale-100');
        }
        function closeModal() {
            modal.classList.add('opacity-0', 'pointer-events-none');
            modalCard.classList.replace('scale-100', 'scale-95');
        }
        modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });

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
        detailsModal.addEventListener('click', (e) => { if (e.target === detailsModal) closeDetailsModal(); });
    </script>
</body>
</html>