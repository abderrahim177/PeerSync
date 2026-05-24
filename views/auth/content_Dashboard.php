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


// function calcule time 
function timeAgo($timestamp) {
    if (!$timestamp) return "Unknown time";

    $time_ago = strtotime($timestamp);
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    
    if ($time_difference < 1) { return 'just now'; }
    $condition = array(
        12 * 30 * 24 * 60 * 60  =>  'year',
        30 * 24 * 60 * 60       =>  'month',
        7 * 24 * 60 * 60        =>  'week',
        24 * 60 * 60            =>  'day',
        60 * 60                 =>  'hour',
        60                      =>  'minute',
        1                       =>  'second'
    );
    foreach ($condition as $secs => $str) {
        $d = $time_difference / $secs;
        if ($d >= 1) {
            $r = round($d);
            
            return $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
        }
    }
}
?>

<section class="flex-1 h-screen overflow-y-auto p-8 space-y-8 relative transition-colors duration-300 antialiased text-slate-900 dark:text-white bg-slate-100 dark:bg-[#040814] isolate">
    
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat -z-10 transition-all duration-300 pointer-events-none" 
         style="background-image: url('image_dae2df.jpg');"></div>
    
    <div class="absolute inset-0 bg-slate-100/90 dark:bg-[#040814]/95 -z-10 transition-colors duration-300 pointer-events-none"></div>

    <div class="space-y-8">
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-200 dark:border-cyan-500/10 pb-6">
            <div>
                <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-wide uppercase">
                    Welcome back, <span class="text-cyan-600 dark:text-cyan-400 drop-shadow-[0_0_10px_rgba(6,182,212,0.2)] dark:drop-shadow-[0_0_10px_rgba(6,182,212,0.5)]"><?= htmlspecialchars($name) . '!' ?></span>
                </h2>
                <p class="text-slate-600 dark:text-slate-400 text-sm mt-0.5">System Status: Active // Track your help requests and get assistance.</p>
            </div>
            <div class="flex items-center space-x-3 self-start sm:self-auto">
                <button onclick="openSkillModal()" class="bg-white/80 dark:bg-slate-800/80 hover:bg-slate-100 dark:hover:bg-slate-700/80 border border-slate-300 dark:border-cyan-500/30 text-cyan-600 dark:text-cyan-400 font-semibold px-4 py-2.5 rounded-xl flex items-center space-x-2 transition text-sm shadow-md dark:shadow-[0_0_15px_rgba(6,182,212,0.15)] backdrop-blur-md cursor-pointer">
                    <i class="fa-solid fa-gear text-xs animate-spin-slow"></i>
                    <span>Add Skill</span>
                </button>
                
                <button onclick="openModal()" class="bg-cyan-500 hover:bg-cyan-600 text-slate-950 font-bold px-4 py-2.5 rounded-xl flex items-center space-x-2 transition text-sm shadow-lg dark:shadow-[0_0_20px_rgba(6,182,212,0.4)] cursor-pointer">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>New Request</span>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white/80 dark:bg-[#0b132b]/60 border border-slate-200 dark:border-cyan-500/20 rounded-2xl p-5 flex items-center justify-between shadow-md dark:shadow-lg backdrop-blur-md relative overflow-hidden group hover:border-cyan-500/50 transition duration-300">
                <div class="absolute left-0 top-0 bottom-0 w-[3px] bg-amber-500"></div>
                <div class="space-y-1">
                    <p class="text-slate-500 dark:text-slate-400 text-xs font-bold tracking-wider uppercase">Pending Requests</p>
                    <p class="text-3xl font-black text-slate-900 dark:text-white"><?= $stats['pending']; ?></p>
                    <p class="text-xs text-amber-600 dark:text-amber-500 font-medium flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Need attention</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center text-lg border border-amber-500/20">
                    <i class="fa-regular fa-clock"></i>
                </div>
            </div>

            <div class="bg-white/80 dark:bg-[#0b132b]/60 border border-slate-200 dark:border-cyan-500/20 rounded-2xl p-5 flex items-center justify-between shadow-md dark:shadow-lg backdrop-blur-md relative overflow-hidden group hover:border-cyan-500/50 transition duration-300">
                <div class="absolute left-0 top-0 bottom-0 w-[3px] bg-blue-500"></div>
                <div class="space-y-1">
                    <p class="text-slate-500 dark:text-slate-400 text-xs font-bold tracking-wider uppercase">Assigned</p>
                    <p class="text-3xl font-black text-slate-900 dark:text-white"><?= $stats['assigned'] ?? 0; ?></p>
                    <p class="text-xs text-blue-600 dark:text-blue-400 font-medium flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span> In progress</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center text-lg border border-blue-500/20">
                    <i class="fa-regular fa-user"></i>
                </div>
            </div>

            <div class="bg-white/80 dark:bg-[#0b132b]/60 border border-slate-200 dark:border-cyan-500/20 rounded-2xl p-5 flex items-center justify-between shadow-md dark:shadow-lg backdrop-blur-md relative overflow-hidden group hover:border-cyan-500/50 transition duration-300">
                <div class="absolute left-0 top-0 bottom-0 w-[3px] bg-emerald-500"></div>
                <div class="space-y-1">
                    <p class="text-slate-500 dark:text-slate-400 text-xs font-bold tracking-wider uppercase">Resolved</p>
                    <p id="stats-resolved" class="text-3xl font-black text-slate-900 dark:text-white"><?= $stats['resolved']; ?></p>
                    <p class="text-xs text-emerald-600 dark:text-emerald-400 font-medium flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Completed</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-lg border border-emerald-500/20">
                    <i class="fa-regular fa-circle-check"></i>
                </div>
            </div>

            <div class="bg-white/80 dark:bg-[#0b132b]/60 border border-slate-200 dark:border-cyan-500/20 rounded-2xl p-5 flex items-center justify-between shadow-md dark:shadow-lg backdrop-blur-md relative overflow-hidden group hover:border-cyan-500/50 transition duration-300">
                <div class="absolute left-0 top-0 bottom-0 w-[3px] bg-cyan-500"></div>
                <div class="space-y-1">
                    <p class="text-slate-500 dark:text-slate-400 text-xs font-bold tracking-wider uppercase">Total Requests</p>
                    <p class="text-3xl font-black text-slate-900 dark:text-white"><?= $stats['total']; ?></p>
                    <div class="h-4"></div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 flex items-center justify-center text-lg border border-cyan-500/20">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-black text-slate-800 dark:text-white uppercase tracking-widest flex items-center gap-2">
                    <span class="w-2 h-4 bg-cyan-500 inline-block"></span> Recent Network Requests
                </h3>
                <div class="flex items-center space-x-3 w-72 relative">
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-cyan-600 dark:text-cyan-400">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        </span>
                        <input type="text" id="request-search" placeholder="Filter node database..." class="w-full bg-white dark:bg-[#0a1128]/80 text-slate-800 dark:text-cyan-300 pl-9 pr-4 py-2 rounded-xl border border-slate-300 dark:border-cyan-500/20 focus:outline-none focus:border-cyan-500 text-xs placeholder-slate-400 dark:placeholder-slate-500 backdrop-blur-sm shadow-sm">
                    </div>
                    
                    <div class="relative">
                        <button id="filter-btn" class="bg-white dark:bg-[#0a1128]/80 border border-slate-300 dark:border-cyan-500/20 p-2.5 rounded-xl text-slate-700 dark:text-cyan-400 hover:text-cyan-500 transition flex items-center justify-center h-9 w-9 flex-shrink-0 cursor-pointer shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 8.293A1 1 0 013 7.586V4z"></path>
                            </svg>
                        </button>

                        <div id="filter-dropdown" class="absolute right-0 mt-2 w-42 bg-white dark:bg-[#0d1530] border border-slate-200 dark:border-cyan-500/30 rounded-xl shadow-2xl py-1.5 z-50 opacity-0 pointer-events-none scale-95 transition-all duration-200 backdrop-blur-md">
                            <button onclick="filterStatus('ALL')" class="w-full text-left px-4 py-2 text-xs font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-cyan-500/10 hover:text-cyan-600 dark:hover:text-cyan-400 transition flex items-center space-x-2 cursor-pointer border-0 bg-transparent">
                                <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                                <span>All Terminal Nodes</span>
                            </button>
                            <button onclick="filterStatus('PENDING')" class="w-full text-left px-4 py-2 text-xs font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-cyan-500/10 hover:text-amber-500 transition flex items-center space-x-2 cursor-pointer border-0 bg-transparent">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                <span>Pending</span>
                            </button>
                            <button onclick="filterStatus('ASSIGNED')" class="w-full text-left px-4 py-2 text-xs font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-cyan-500/10 hover:text-blue-500 transition flex items-center space-x-2 cursor-pointer border-0 bg-transparent">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                <span>Assigned</span>
                            </button>
                            <button onclick="filterStatus('RESOLVED')" class="w-full text-left px-4 py-2 text-xs font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-cyan-500/10 hover:text-emerald-500 transition flex items-center space-x-2 cursor-pointer border-0 bg-transparent">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                <span>Resolved</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="requests-container" class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                <?php if (empty($requests)): ?>
                    <p id="no-requests-msg" class="text-slate-500 dark:text-slate-400 text-sm col-span-2 text-center py-8 bg-white dark:bg-[#0b132b]/40 rounded-2xl border border-slate-200 dark:border-cyan-500/10">No transmission packets found.</p>
                <?php else: ?>
                    <?php foreach ($requests as $request): ?>
                        <?php $status = strtoupper($request['status']); ?>
                        
                        <div data-status="<?= $status; ?>" class="request-card bg-white dark:bg-[#0b132b]/50 border border-slate-200 dark:border-cyan-500/20 rounded-2xl p-6 space-y-4 shadow-md dark:shadow-lg relative hover:border-cyan-500/60 transition duration-300 flex flex-col justify-between backdrop-blur-md group">
                            
                            <div class="space-y-2">
                                <div class="flex items-start justify-between">
                                    <h4 class="text-base font-bold text-slate-900 dark:text-white leading-snug class-title group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition">
                                        <?= htmlspecialchars($request['title']); ?>
                                    </h4>
                                    <?php
                                    $statusClass = "bg-amber-500/10 text-amber-600 dark:text-amber-400 border-amber-500/30";
                                    if ($status === 'ASSIGNED') {
                                        $statusClass = "bg-blue-500/10 text-blue-600 dark:text-blue-400 border-blue-500/30";
                                    } elseif ($status === 'RESOLVED') {
                                        $statusClass = "bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/30";
                                    }
                                    ?>
                                    <span class="<?= $statusClass; ?> text-[10px] font-bold tracking-wider uppercase px-2.5 py-0.5 rounded-full border">
                                        <?= ucfirst(strtolower($status)); ?>
                                    </span>
                                </div>
                                <p class="text-slate-600 dark:text-slate-400 text-xs leading-relaxed class-desc">
                                    <?= htmlspecialchars($request['description']); ?>
                                </p>
                            </div>
                            
                            <div class="pt-3 border-t border-slate-100 dark:border-cyan-500/10 flex items-center justify-between text-slate-500 dark:text-slate-400 text-xs">
                                <div class="flex items-center space-x-4">
                                    <span class="bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 text-[10px] uppercase font-bold px-2.5 py-0.5 rounded-md border border-cyan-500/20 tracking-wider">
                                        <?= htmlspecialchars($request['skill_name'] ?? 'Unknown'); ?>
                                    </span>
                                    <span class="flex items-center text-slate-500"><i class="fa-regular fa-clock mr-1.5 text-cyan-500/50"></i><?= timeAgo($request['created_at']); ?></span>
                                </div>
                                <?php if ($status === 'ASSIGNED'): ?>
                            <button onclick="openDetailsModal(this)" 
                                data-id="<?= $request['id']; ?>"
                                data-title="<?= htmlspecialchars($request['title']); ?>"
                                data-desc="<?= htmlspecialchars($request['description']); ?>"
                                data-status="<?= $status; ?>"
                                data-tech="<?= htmlspecialchars($request['skill_name'] ?? 'Unknown'); ?>"
                                data-date="<?= timeAgo($request['created_at']); ?>"
                                data-tutor="<?= htmlspecialchars($request['tutor_name'] ?? ''); ?>"
                                data-user="<?= htmlspecialchars($request['user_name'] ?? 'Student'); ?>"
                                class="text-cyan-600 dark:text-cyan-400 font-bold hover:text-cyan-500 dark:hover:text-cyan-300 inline-flex items-center space-x-1 bg-transparent border-0 cursor-pointer text-xs uppercase tracking-wider">
                                
                                <span>Query Details</span>
                                <i class="fa-solid fa-arrow-right text-[10px] ml-1"></i>
                            </button>
                        <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                    <p id="js-no-requests-msg" class="text-slate-500 dark:text-cyan-500/70 text-sm col-span-2 text-center py-8 hidden">No terminal logs matching current filter parameters.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<!-- new request modale -->
 <div id="request-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 dark:bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
        <form action="/peersync/app/controller/HelpRequestController.php" method="post" class="bg-white dark:bg-[#111936] w-full max-w-xl rounded-2xl border border-slate-200 dark:border-[#1e295d] shadow-2xl flex flex-col max-h-[90vh] overflow-hidden transform scale-95 transition-transform duration-300" id="modal-card">

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
                    <input id="modal-title" name="title" type="text" placeholder="e.g., Help with React useEffect hook"
                        class="w-full bg-slate-50 dark:bg-[#0b132b] text-slate-800 dark:text-slate-200 px-4 py-2.5 rounded-xl border border-slate-200 dark:border-[#1e295d] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition placeholder-slate-400 dark:placeholder-slate-500 text-sm shadow-sm">
                    <p id="title-error" class="text-[11px] text-red-500 hidden">Title is required.</p>
                    <p class="text-[11px] text-slate-400 dark:text-slate-500">A clear, concise title helps tutors understand your issue quickly.</p>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300">Technology / Skill <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select id="modal-tech" name="technology" class="w-full bg-slate-50 dark:bg-[#0b132b] text-slate-800 dark:text-slate-200 px-4 py-2.5 rounded-xl border border-slate-200 dark:border-[#1e295d] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition text-sm appearance-none shadow-sm cursor-pointer">
                            <option value="">select technology. . .</option>
                            <?php foreach ($technologies as $tech): ?>
                                <option value="<?= $tech['id']; ?>"><?= htmlspecialchars($tech['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 pointer-events-none">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </span>
                    </div>
                    <p id="tech-error" class="text-[11px] text-red-500 hidden">Please select a technology.</p>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300">Description <span class="text-red-500">*</span></label>
                    <textarea id="modal-desc" name="description" rows="4" placeholder="Describe your problem in detail. Include any error messages, what you've tried, and what you expected to happen."
                        class="w-full bg-slate-50 dark:bg-[#0b132b] text-slate-800 dark:text-slate-200 px-4 py-3 rounded-xl border border-slate-200 dark:border-[#1e295d] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition placeholder-slate-400 dark:placeholder-slate-500 text-sm shadow-sm resize-none"></textarea>
                    <p id="desc-error" class="text-[11px] text-red-500 hidden">Description is required.</p>
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

                <button id="submit-request-btn" name="action_create" type="submit" disabled
                    class="px-5 py-2 bg-slate-300 dark:bg-slate-800 text-slate-400 dark:text-slate-600 font-medium text-sm rounded-xl transition cursor-not-allowed">
                    Submit Request
                </button>
            </div>
        </form>
    </div>

<div id="details-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 dark:bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
    
    <div id="details-card" class="bg-white dark:bg-[#0b132b] w-full max-w-4xl rounded-2xl border border-slate-200 dark:border-[#1e295d] shadow-2xl flex flex-col max-h-[90vh] overflow-hidden transform scale-95 transition-transform duration-300 text-slate-600 dark:text-slate-300">
        
        <div class="p-6 pb-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
            <button type="button" onclick="closeDetailsModal()" class="flex items-center space-x-2 text-xs text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white transition">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to Dashboard</span>
            </button>
            <button type="button" onclick="closeDetailsModal()" class="text-slate-400 hover:text-slate-800 dark:hover:text-white transition p-1 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form action="/peersync/app/controller/HelpRequestController.php" method="POST" class="flex flex-col flex-1 overflow-hidden">
            
            <input type="hidden" name="help_request_id" id="help-request-id" value="1">
            <input  name="rating" id="rating-input" >
            

            <div class="p-6 overflow-y-auto custom-scrollbar flex-1 grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="md:col-span-2 space-y-6">

                    <div class="space-y-4">
                        <div class="flex items-center space-x-2">
                            <span id="detail-badge-tech" class="bg-blue-500/10 text-blue-600 dark:text-blue-400 text-[11px] px-2.5 py-0.5 rounded-md font-medium">React</span>
                            <span id="detail-badge-status" class="text-[11px] px-2.5 py-0.5 rounded-md font-medium">In Progress</span>
                        </div>
                        <h2 id="detail-title" class="text-xl font-bold text-slate-900 dark:text-white">Help with React useEffect cleanup</h2>
                        <div id="detail-desc" class="text-slate-600 dark:text-slate-400 space-y-3 text-xs leading-relaxed"></div>
                        <p class="text-[11px] text-slate-400 dark:text-slate-500 flex items-center">
                            <i class="fa-regular fa-clock mr-1.5"></i>
                            <span id="detail-date">May 18, 2026 at 2:30 PM</span>
                        </p>
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
                                        <p id="timeline-user-name" class="text-[11px] text-slate-500 mt-0.5"></p>
                                    </div>
                                </div>
                            </div>

                            <div id="timeline-tutor-assigned" class="relative">
                                <div class="absolute -left-[21px] mt-0.5 bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-500/20 w-5 h-5 rounded-full flex items-center justify-center text-[10px]">
                                    <i class="fa-regular fa-user"></i>
                                </div>
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="text-xs font-semibold text-slate-900 dark:text-white leading-tight">Tutor assigned</h4>
                                        <p id="timeline-tutor-name" class="text-[11px] text-slate-500 mt-0.5"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3 pt-2">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white">Add Comment</h3>
                        <div class="space-y-2">
                            <textarea name="comment" placeholder="Write a comment..." class="w-full bg-slate-50 dark:bg-[#111936] border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 text-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-blue-500 text-xs resize-none shadow-sm"></textarea>
                            <div class="flex justify-end">
                                <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg text-xs transition flex items-center space-x-1.5 shadow-sm">
                                    <i class="fa-regular fa-paper-plane text-[10px]"></i>
                                    <span>Send</span>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="space-y-5">

                    <div id="tutor-info-card" class="bg-slate-50 dark:bg-[#111936] border border-slate-200 dark:border-slate-800 rounded-2xl p-4 space-y-4">
                        <h4 class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Assigned Tutor</h4>
                        <div class="flex items-center space-x-3">
                            <div id="tutor-initial" class="w-9 h-9 rounded-full bg-blue-100 dark:bg-blue-900/50 border border-blue-200 dark:border-blue-500/30 flex items-center justify-center text-sm font-bold text-blue-600 dark:text-blue-400">S</div>
                            <div>
                                <h4 id="tutor-full-name" class="text-xs font-semibold text-slate-900 dark:text-white">Sarah Martinez</h4>
                                <p class="text-[11px] text-slate-400 dark:text-slate-500">Tutor</p>
                            </div>
                        </div>
                        <button type="button" class="w-full bg-white dark:bg-transparent border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/50 text-slate-700 dark:text-white font-medium py-2 rounded-xl text-xs transition flex items-center justify-center space-x-2">
                            <i class="fa-regular fa-message text-xs"></i>
                            <span>Message Tutor</span>
                        </button>
                    </div>

                    <div id="no-tutor-card" class="bg-slate-50 dark:bg-[#111936] border border-slate-200 dark:border-slate-800 rounded-2xl p-4 text-center py-6 hidden">
                        <p class="text-xs text-slate-400">Awaiting tutor assignment...</p>
                    </div>

                    <div id="actions-card" class="bg-slate-50 dark:bg-[#111936] border border-slate-200 dark:border-slate-800 rounded-2xl p-4 space-y-3">
                        <h4 class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Actions</h4>
                        
                        <button type="button" id="resolve-btn" onclick="handleResolveRequest()" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2.5 rounded-xl text-xs transition flex items-center justify-center space-x-2 border-0 cursor-pointer">
                            <i id="resolve-icon" class="fa-regular fa-circle-check text-sm"></i>
                            <span id="resolve-text">Mark as Resolved</span>
                        </button>

                        <div id="rating-card" class="max-h-0 opacity-0 overflow-hidden transition-all duration-500 ease-in-out border-t border-transparent space-y-3 pt-0">
                            <h5 class="text-xs font-semibold text-slate-700 dark:text-slate-300">Rate this session :</h5>
                            <div class="flex items-center space-x-1.5 justify-center py-1">
                                <i class="fa-regular fa-star text-xl text-slate-300 dark:text-slate-600 cursor-pointer hover:scale-110 transition star-btn" onclick="event.preventDefault(); setRating(1)"></i>
                                <i class="fa-regular fa-star text-xl text-slate-300 dark:text-slate-600 cursor-pointer hover:scale-110 transition star-btn" onclick="event.preventDefault(); setRating(2)"></i>
                                <i class="fa-regular fa-star text-xl text-slate-300 dark:text-slate-600 cursor-pointer hover:scale-110 transition star-btn" onclick="event.preventDefault(); setRating(3)"></i>
                                <i class="fa-regular fa-star text-xl text-slate-300 dark:text-slate-600 cursor-pointer hover:scale-110 transition star-btn" onclick="event.preventDefault(); setRating(4)"></i>
                                <i class="fa-regular fa-star text-xl text-slate-300 dark:text-slate-600 cursor-pointer hover:scale-110 transition star-btn" onclick="event.preventDefault(); setRating(5)"></i>
                            </div>

                            <button type="submit" name="action_resolve" class="w-full bg-slate-200 dark:bg-slate-800 hover:bg-blue-600 dark:hover:bg-blue-600 hover:text-white text-slate-700 dark:text-slate-300 font-semibold py-2 rounded-xl text-[11px] transition border-0 cursor-pointer">
                                Submit Review
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </form>
        
    </div>
</div>
<style>
    .animate-spin-slow {
        animation: spin 6s linear infinite;
    }
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>

<script>
    
   document.addEventListener("DOMContentLoaded", function () {
    
    let currentRating = 0;

window.setRating = function(value) {

    currentRating = value;
    document.getElementById("rating-input").value = value;

    const stars = document.querySelectorAll(".star-btn");

    stars.forEach((star, index) => {

        if(index < value){

            star.classList.remove("fa-regular");
            star.classList.add("fa-solid", "text-yellow-400");

        } else {

            star.classList.remove("fa-solid", "text-yellow-400");
            star.classList.add("fa-regular", "text-slate-300");

        }

    });

}

    const modal = document.getElementById('request-modal');
    const modalCard = document.getElementById('modal-card');

    window.openModal = function () {
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modalCard.classList.replace('scale-95', 'scale-100');
    };

    window.closeModal = function () {
        modal.classList.add('opacity-0', 'pointer-events-none');
        modalCard.classList.replace('scale-100', 'scale-95');
    };

    modal?.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });

});
     const modal = document.getElementById('request-modal');
        const modalCard = document.getElementById('modal-card');

        window.openModal = function () {
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modalCard.classList.replace('scale-95', 'scale-100');
    }

        window.closeModal = function () {
            modal.classList.add('opacity-0', 'pointer-events-none');
            modalCard.classList.replace('scale-100', 'scale-95');
        }
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });
document.addEventListener("DOMContentLoaded", function () {
    const filterBtn = document.getElementById('filter-btn');
    const filterDropdown = document.getElementById('filter-dropdown');
    const searchInput = document.getElementById('request-search');
    
    let currentStatusFilter = 'ALL';

    if(filterBtn && filterDropdown) {
        filterBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            filterDropdown.classList.toggle('opacity-0');
            filterDropdown.classList.toggle('pointer-events-none');
            filterDropdown.classList.toggle('scale-95');
            filterDropdown.classList.toggle('scale-100');
        });

        document.addEventListener('click', function () {
            if(filterDropdown) filterDropdown.classList.add('opacity-0', 'pointer-events-none', 'scale-95');
        });
    }

    window.filterStatus = function(status) {
        currentStatusFilter = status;
        applyFilters();
    }

    if(searchInput) {
        searchInput.addEventListener('input', applyFilters);
    }

    function applyFilters() {
        const searchText = searchInput ? searchInput.value.toLowerCase().trim() : "";
        const cards = document.querySelectorAll('.request-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const cardStatus = card.getAttribute('data-status');
            const title = card.querySelector('.class-title')?.textContent.toLowerCase() || "";
            const desc = card.querySelector('.class-desc')?.textContent.toLowerCase() || "";
            
            const matchesStatus = (currentStatusFilter === 'ALL' || cardStatus === currentStatusFilter);
            const matchesSearch = (title.includes(searchText) || desc.includes(searchText));

            if (matchesStatus && matchesSearch) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        const jsMsg = document.getElementById('js-no-requests-msg');
        if(jsMsg) {
            if (visibleCount === 0) {
                jsMsg.classList.remove('hidden');
            } else {
                jsMsg.classList.add('hidden');
            }
        }
    }
});


</script>