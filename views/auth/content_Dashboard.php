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
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                    <p id="js-no-requests-msg" class="text-slate-500 dark:text-cyan-500/70 text-sm col-span-2 text-center py-8 hidden">No terminal logs matching current filter parameters.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

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

function openDetailsModal(button) {
    const id = button.getAttribute('data-id');
    const title = button.getAttribute('data-title');
    const desc = button.getAttribute('data-desc');
    const status = button.getAttribute('data-status') ? button.getAttribute('data-status').toUpperCase() : 'PENDING';
    const tech = button.getAttribute('data-tech');
    const date = button.getAttribute('data-date');
    const tutorName = button.getAttribute('data-tutor');
    const userName = button.getAttribute('data-user');

    if(document.getElementById('detail-title')) document.getElementById('detail-title').textContent = title;
    if(document.getElementById('detail-desc')) document.getElementById('detail-desc').innerHTML = `<p>${desc}</p>`;
    if(document.getElementById('detail-date')) document.getElementById('detail-date').textContent = date;
    if(document.getElementById('detail-badge-tech')) document.getElementById('detail-badge-tech').textContent = tech;
    if(document.getElementById('timeline-user-name')) document.getElementById('timeline-user-name').textContent = userName;

    const statusBadge = document.getElementById('detail-badge-status');
    if (statusBadge) {
        statusBadge.textContent = status.charAt(0) + status.slice(1).toLowerCase();
        statusBadge.className = "text-[11px] px-2.5 py-0.5 rounded-full font-semibold border uppercase tracking-wider ";
        
        if (status === 'PENDING') {
            statusBadge.className += "bg-amber-500/10 text-amber-600 border-amber-500/30";
        } else if (status === 'ASSIGNED') {
            statusBadge.className += "bg-blue-500/10 text-blue-600 border-blue-500/30";
        } else if (status === 'RESOLVED') {
            statusBadge.className += "bg-emerald-500/10 text-emerald-600 border-emerald-500/30";
        }
    }

    const tutorInfoCard = document.getElementById('tutor-info-card');
    const noTutorCard = document.getElementById('no-tutor-card');
    const timelineTutor = document.getElementById('timeline-tutor-assigned');
    const actionsCard = document.getElementById('actions-card');

    if (tutorName && tutorName.trim() !== '') {
        if(tutorInfoCard) tutorInfoCard.classList.remove('hidden');
        if(noTutorCard) noTutorCard.classList.add('hidden');
        if(timelineTutor) timelineTutor.classList.remove('hidden');
        
        if(document.getElementById('tutor-full-name')) document.getElementById('tutor-full-name').textContent = tutorName;
        if(document.getElementById('timeline-tutor-name')) document.getElementById('timeline-tutor-name').textContent = tutorName;
        if(document.getElementById('tutor-initial')) document.getElementById('tutor-initial').textContent = tutorName.charAt(0).toUpperCase();
    } else {
        if(tutorInfoCard) tutorInfoCard.classList.add('hidden');
        if(noTutorCard) noTutorCard.classList.remove('hidden');
        if(timelineTutor) timelineTutor.classList.add('hidden');
    }

    if (actionsCard) {
        if (status === 'ASSIGNED') {
            actionsCard.classList.remove('hidden');
        } else {
            actionsCard.classList.add('hidden');
        }
    }

    const modal = document.getElementById('details-modal');
    const card = document.getElementById('details-card');
    
    if (modal && card) {
        document.body.appendChild(modal); 
        modal.classList.remove('opacity-0', 'pointer-events-none');
        card.classList.remove('scale-95');
        card.classList.add('scale-100');
    }
}

function closeDetailsModal() {
    const modal = document.getElementById('details-modal');
    const card = document.getElementById('details-card');
    
    if (modal && card) {
        modal.classList.add('opacity-0', 'pointer-events-none');
        card.classList.remove('scale-100');
        card.classList.add('scale-95');
    }
}
</script>