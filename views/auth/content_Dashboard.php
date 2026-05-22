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
$stats    = $helpRepo->getRequestStats();


// function clacule time 
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

<section class="flex-1 p-8 space-y-8 overflow-y-auto bg-slate-50 dark:bg-[#0b132b] transition-colors duration-300">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Welcome back, <span><?= htmlspecialchars($name) . '!' ?></span></h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-0.5">Track your help requests and get assistance from tutors.</p>
        </div>
        <button onclick="openModal()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2.5 rounded-xl flex items-center space-x-2 transition text-sm shadow-md shadow-blue-500/10 self-start sm:self-auto">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>New Request</span>
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-[#111936] border border-slate-200 dark:border-[#1e295d] rounded-2xl p-5 flex items-center justify-between shadow-sm">
            <div class="space-y-1">
                <p class="text-slate-400 dark:text-slate-500 text-xs font-semibold tracking-wide">Pending Requests</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white"><?= $stats['pending']; ?></p>
                <p class="text-xs text-amber-500 font-medium">Need attention</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center text-lg">
                <i class="fa-regular fa-clock"></i>
            </div>
        </div>
        <div class="bg-white dark:bg-[#111936] border border-slate-200 dark:border-[#1e295d] rounded-2xl p-5 flex items-center justify-between shadow-sm">
            <div class="space-y-1">
                <p class="text-slate-400 dark:text-slate-500 text-xs font-semibold tracking-wide">Assigned</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white"><?= $stats['assigned'] ?? 0; ?></p>
                <p class="text-xs text-blue-500 font-medium">In progress</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center text-lg">
                <i class="fa-regular fa-user"></i>
            </div>
        </div>
        <div class="bg-white dark:bg-[#111936] border border-slate-200 dark:border-[#1e295d] rounded-2xl p-5 flex items-center justify-between shadow-sm">
            <div class="space-y-1">
                <p class="text-slate-400 dark:text-slate-500 text-xs font-semibold tracking-wide">Resolved</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white"><?= $stats['resolved']; ?></p>
                <p class="text-xs text-emerald-500 font-medium">Completed</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-lg">
                <i class="fa-regular fa-circle-check"></i>
            </div>
        </div>

        <div class="bg-white dark:bg-[#111936] border border-slate-200 dark:border-[#1e295d] rounded-2xl p-5 flex items-center justify-between shadow-sm">
            <div class="space-y-1">
                <p class="text-slate-400 dark:text-slate-500 text-xs font-semibold tracking-wide">Total Requests</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white"><?= $stats['total']; ?></p>
                <div class="h-4"></div>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-500 flex items-center justify-center text-lg">
                <i class="fa-solid fa-arrow-trend-up"></i>
            </div>
        </div>
    </div>

    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white tracking-wide">Recent Requests</h3>
            <div class="flex items-center space-x-3 w-72 relative">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" id="request-search" placeholder="Search requests..." class="w-full bg-white dark:bg-[#111936] text-slate-800 dark:text-slate-300 pl-9 pr-4 py-2 rounded-xl border border-slate-200 dark:border-[#1e295d] focus:outline-none focus:border-blue-500 text-xs placeholder-slate-400">
                </div>
                
                <div class="relative">
                    <button id="filter-btn" class="bg-white dark:bg-[#111936] border border-slate-200 dark:border-[#1e295d] p-2.5 rounded-xl text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition flex items-center justify-center h-9 w-9 flex-shrink-0 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 8.293A1 1 0 013 7.586V4z"></path>
                        </svg>
                    </button>

                    <div id="filter-dropdown" class="absolute right-0 mt-2 w-40 bg-white dark:bg-[#111936] border border-slate-200 dark:border-[#1e295d] rounded-xl shadow-xl py-1.5 z-50 opacity-0 pointer-events-none scale-95 transition-all duration-200">
                        <button onclick="filterStatus('ALL')" class="w-full text-left px-4 py-2 text-xs font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-[#0b132b] transition flex items-center space-x-2">
                            <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                            <span>All Requests</span>
                        </button>
                        <button onclick="filterStatus('PENDING')" class="w-full text-left px-4 py-2 text-xs font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-[#0b132b] transition flex items-center space-x-2">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            <span>Pending</span>
                        </button>
                        <button onclick="filterStatus('ASSIGNED')" class="w-full text-left px-4 py-2 text-xs font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-[#0b132b] transition flex items-center space-x-2">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                            <span>Assigned</span>
                        </button>
                        <button onclick="filterStatus('RESOLVED')" class="w-full text-left px-4 py-2 text-xs font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-[#0b132b] transition flex items-center space-x-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span>Resolved</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="requests-container" class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            <?php if (empty($requests)): ?>
                <p id="no-requests-msg" class="text-slate-500 dark:text-slate-400 text-sm col-span-2 text-center py-4">No help requests found.</p>
            <?php else: ?>
                <?php foreach ($requests as $request): ?>
                    <?php $status = strtoupper($request['status']); ?>
                    
                    <div data-status="<?= $status; ?>" class="request-card bg-white dark:bg-[#111936] border border-slate-200 dark:border-[#1e295d] rounded-2xl p-6 space-y-4 shadow-sm relative hover:border-slate-300 dark:hover:border-slate-700 transition flex flex-col justify-between">
                        <div class="space-y-2">
                            <div class="flex items-start justify-between">
                                <h4 class="text-base font-bold text-slate-900 dark:text-white leading-snug class-title">
                                    <?= htmlspecialchars($request['title']); ?>
                                </h4>
                                <?php
                                $statusClass = "bg-amber-800/10  text-amber-600 dark:text-amber-500 border-amber-500/20";
                                if ($status === 'ASSIGNED') {
                                    $statusClass = "bg-blue-500/10 text-blue-600 dark:text-blue-400 border-blue-500/20";
                                } elseif ($status === 'RESOLVED') {
                                    $statusClass = "bg-emerald-500/10 text-emerald-600 dark:text-emerald-500 border-emerald-500/20";
                                }
                                ?>
                                <span class="<?= $statusClass; ?> text-[11px] font-semibold px-2.5 py-0.5 rounded-full border">
                                    <?= ucfirst(strtolower($status)); ?>
                                </span>
                            </div>
                            <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed class-desc">
                                <?= htmlspecialchars($request['description']); ?>
                            </p>
                        </div>
                        <div class="pt-2 border-t border-slate-100 dark:border-[#1e295d]/60 flex items-center justify-between text-slate-400 dark:text-slate-500 text-xs">
                            <div class="flex items-center space-x-4">
                                <span class="bg-blue-500/10 text-blue-600 dark:text-blue-400 text-[11px] px-2.5 py-0.5 rounded-md font-medium">
                                    <?= htmlspecialchars($request['skill_name'] ?? 'Unknown'); ?>
                                </span>
                                <span class="flex items-center"><i class="fa-regular fa-clock mr-1.5"></i><?= timeAgo($request['created_at']); ?></span>
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
                        class="text-blue-600 dark:text-blue-400 font-medium hover:underline inline-flex items-center space-x-1 bg-transparent border-0 cursor-pointer">
                    <span>View details</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </button>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <p id="js-no-requests-msg" class="text-slate-500 dark:text-slate-400 text-sm col-span-2 text-center py-4 hidden">No requests found matching this filter.</p>
            <?php endif; ?>
        </div>
    </div>

</section>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const filterBtn = document.getElementById('filter-btn');
    const filterDropdown = document.getElementById('filter-dropdown');
    const searchInput = document.getElementById('request-search');
    
    let currentStatusFilter = 'ALL';

    filterBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        filterDropdown.classList.toggle('opacity-0');
        filterDropdown.classList.toggle('pointer-events-none');
        filterDropdown.classList.toggle('scale-95');
        filterDropdown.classList.toggle('scale-100');
    });

    document.addEventListener('click', function () {
        filterDropdown.classList.add('opacity-0', 'pointer-events-none', 'scale-95');
        filterDropdown.classList.remove('scale-100');
    });

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

// logique view details 
function openDetailsModal(button) {
    const id = button.getAttribute('data-id');
    const title = button.getAttribute('data-title');
    const desc = button.getAttribute('data-desc');
    const status = button.getAttribute('data-status');
    const tech = button.getAttribute('data-tech');
    const date = button.getAttribute('data-date');
    const tutorName = button.getAttribute('data-tutor');
    const userName = button.getAttribute('data-user');

    document.getElementById('detail-title').textContent = title;
    document.getElementById('detail-desc').innerHTML = `<p>${desc}</p>`;
    document.getElementById('detail-date').textContent = date;
    document.getElementById('detail-badge-tech').textContent = tech;
    document.getElementById('timeline-user-name').textContent = userName;

    const statusBadge = document.getElementById('detail-badge-status');
    statusBadge.textContent = status.charAt(0) + status.slice(1).toLowerCase();
    
    statusBadge.className = "text-[11px] px-2.5 py-0.5 rounded-md font-medium ";
    if (status === 'PENDING') {
        statusBadge.classList.add('bg-amber-500/10', 'text-amber-600', 'dark:text-amber-500');
    } else if (status === 'ASSIGNED') {
        statusBadge.classList.add('bg-blue-500/10', 'text-blue-600', 'dark:text-blue-400');
    } else if (status === 'RESOLVED') {
        statusBadge.classList.add('bg-emerald-500/10', 'text-emerald-600', 'dark:text-emerald-500');
    }

    const tutorInfoCard = document.getElementById('tutor-info-card');
    const noTutorCard = document.getElementById('no-tutor-card');
    const timelineTutor = document.getElementById('timeline-tutor-assigned');
    const actionsCard = document.getElementById('actions-card');

    if (tutorName && tutorName.trim() !== '') {
        tutorInfoCard.classList.remove('hidden');
        noTutorCard.classList.add('hidden');
        if(timelineTutor) timelineTutor.classList.remove('hidden');
        
        document.getElementById('tutor-full-name').textContent = tutorName;
        document.getElementById('timeline-tutor-name').textContent = tutorName;
        document.getElementById('tutor-initial').textContent = tutorName.charAt(0).toUpperCase();
    } else {
        tutorInfoCard.classList.add('hidden');
        noTutorCard.classList.remove('hidden');
        if(timelineTutor) timelineTutor.classList.add('hidden');
    }

    if (status === 'RESOLVED') {
        actionsCard.classList.add('hidden');
    } else {
        actionsCard.classList.remove('hidden');
    }

    const modal = document.getElementById('details-modal');
    const card = document.getElementById('details-card');
    
    modal.classList.remove('opacity-0', 'pointer-events-none');
    card.classList.remove('scale-95');
    card.classList.add('scale-100');
}

function closeDetailsModal() {
    const modal = document.getElementById('details-modal');
    const card = document.getElementById('details-card');
    
    modal.classList.add('opacity-0', 'pointer-events-none');
    card.classList.remove('scale-100');
    card.classList.add('scale-95');
}
</script>