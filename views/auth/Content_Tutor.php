<?php
// Fetch only pending requests for the tutor space

require_once __DIR__ . '/login-process.php';
$name = $_SESSION['user_name'];
$role = $_SESSION['user_role'];

if (session_status() === PHP_SESSION_NONE) {
    session_start();
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
$pendingRequests = array_filter($requests, function ($r) {
    return strtoupper($r['status']) === 'PENDING';
});

function timeAgo($timestamp) {
    if (!$timestamp) return "Unknown time";

    $time_ago = strtotime($timestamp);
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    
    if ($time_difference < 1) { return 'just now'; }
    $condition = array (
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        #name-modal {
    position: fixed;
    inset: 0;
    width: 100vw;
    height: 100vh;
    }
    body{
        margin :0;
        padding: 0;
    }
    </style>
</head>
<body>
    <section class="flex-1 p-8 space-y-8 overflow-y-auto bg-slate-50 dark:bg-[#0b132b] transition-colors duration-300">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Espace Tuteur</h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-0.5">Requests waiting for a tutor — pick one to start helping.</p>
        </div>
        <div class="flex items-center space-x-2 self-start sm:self-auto">
            <span class="bg-amber-500/10 text-amber-600 dark:text-amber-400 text-xs font-semibold px-3 py-1.5 rounded-full border border-amber-500/20">
                <?= count($pendingRequests); ?> pending
            </span>
        </div>
    </div>
<!-- modale take request -->
<div id="name-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 dark:bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">    
    <form action="/peersync/app/controller/HelpRequestController.php" method="post" class="bg-white dark:bg-[#111936] w-full max-w-md rounded-2xl border border-slate-200 dark:border-[#1e295d] shadow-2xl flex flex-col transform scale-95 transition-transform duration-300" id="name-modal-card">
        
        <input type="hidden" name="request_id" id="modal-request-id" value="">

        <div class="p-6 pb-4 border-b border-slate-100 dark:border-[#1e295d] flex items-start justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Confirm Taking Request</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Please enter your full name to assign this request to yourself.</p>
            </div>
            <button type="button" onclick="closeNameModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition p-1 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800/50">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <div class="p-6 space-y-4">
            <div class="space-y-1.5">
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300">Full Name <span class="text-red-500">*</span></label>
                <input id="modal-user-name" name="user_name" type="text" placeholder="e.g., John Doe" 
                       class="w-full bg-slate-50 dark:bg-[#0b132b] text-slate-800 dark:text-slate-200 px-4 py-2.5 rounded-xl border border-slate-200 dark:border-[#1e295d] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition placeholder-slate-400 dark:placeholder-slate-500 text-sm shadow-sm">
                <p id="name-input-error" class="text-[11px] text-red-500 hidden">Name is required and cannot be empty.</p>
            </div>
        </div>

        <div class="p-5 border-t border-slate-100 dark:border-[#1e295d] flex items-center justify-end space-x-3 bg-slate-50/50 dark:bg-[#111936]">
            <button type="button" onclick="closeNameModal()" class="px-4 py-2 rounded-xl text-slate-600 dark:text-slate-300 font-medium text-sm hover:bg-slate-100 dark:hover:bg-slate-800 transition">Cancel</button>
            
            <button id="name-submit-btn" name="assign" type="submit" disabled 
                    class="px-5 py-2 bg-slate-300 dark:bg-slate-800 text-slate-400 dark:text-slate-600 font-medium text-sm rounded-xl transition cursor-not-allowed">
                Confirm & Take
            </button>
        </div>
    </form>
</div>

    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white tracking-wide">Pending Requests</h3>
            <div class="relative w-64">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" placeholder="Search..." class="w-full bg-white dark:bg-[#111936] text-slate-800 dark:text-slate-300 pl-9 pr-4 py-2 rounded-xl border border-slate-200 dark:border-[#1e295d] focus:outline-none focus:border-blue-500 text-xs placeholder-slate-400">
            </div>
        </div>

        <?php if (empty($pendingRequests)): ?>
            <div class="bg-white dark:bg-[#111936] border border-slate-200 dark:border-[#1e295d] rounded-2xl p-12 text-center shadow-sm">
                <div class="w-14 h-14 rounded-full bg-emerald-500/10 text-emerald-500 flex items-center justify-center text-2xl mx-auto mb-4">
                    <i class="fa-regular fa-circle-check"></i>
                </div>
                <h4 class="text-base font-semibold text-slate-900 dark:text-white">All caught up!</h4>
                <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">No pending requests at the moment.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                <?php foreach ($pendingRequests as $request): ?>
                    <div class="bg-white dark:bg-[#111936] border border-slate-200 dark:border-[#1e295d] rounded-2xl p-6 shadow-sm hover:border-amber-300 dark:hover:border-amber-500/30 transition flex flex-col justify-between space-y-4">
                        <div class="space-y-2">
                            <div class="flex items-start justify-between gap-2">
                                <h4 class="text-base font-bold text-slate-900 dark:text-white leading-snug">
                                    <?= htmlspecialchars($request['title']); ?>
                                </h4>
                                <span class="bg-amber-500/10 text-amber-600 dark:text-amber-400 text-[11px] font-semibold px-2.5 py-0.5 rounded-full border border-amber-500/20 whitespace-nowrap flex-shrink-0">
                                    Pending
                                </span>
                            </div>
                            <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed">
                                <?= htmlspecialchars($request['description']); ?>
                            </p>
                        </div>

                        <div class="pt-3 border-t border-slate-100 dark:border-[#1e295d]/60 flex items-center justify-between text-xs">
                            <div class="flex items-center space-x-3">
                                <span class="bg-blue-500/10 text-blue-600 dark:text-blue-400 text-[11px] px-2.5 py-0.5 rounded-md font-medium">
                                    <?= htmlspecialchars($request['skill_name'] ?? 'Unknown'); ?>
                                </span>
                                <span class="text-slate-400 flex items-center">
                                    <i class="fa-regular fa-clock mr-1.5"></i><?= timeAgo($request['created_at']); ?>
                                </span>
                            </div>

                            <?php $isAssignedOrResolved = (strtoupper($request['status']) !== 'PENDING'); ?>

                            <button type="button" 
                                    onclick="openNameModal(<?= $request['id']; ?>)"
                                    <?= $isAssignedOrResolved ? 'disabled' : ''; ?>
                                    class="<?= $isAssignedOrResolved
                                                ? 'bg-slate-300 dark:bg-slate-800 text-slate-400 dark:text-slate-600 cursor-not-allowed'
                                                : 'bg-blue-600 hover:bg-blue-700 text-white shadow-sm shadow-blue-500/20'; ?> 
                                            text-[11px] font-semibold px-3 py-1.5 rounded-lg transition flex items-center space-x-1.5">
                                <i class="fa-solid fa-hand-pointer text-[10px]"></i>
                                <span>
                                    <?= $isAssignedOrResolved ? 'Already Taken' : 'Take this request'; ?>
                                </span>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</section>

<script>
function openNameModal(requestId) {
    const modal = document.getElementById('name-modal');
    const card = document.getElementById('name-modal-card');
    const hiddenInput = document.getElementById('modal-request-id');
    
    if(hiddenInput && requestId) {
        hiddenInput.value = requestId; // هنا كيتحط الـ id
    }
    
    modal.classList.remove('opacity-0', 'pointer-events-none');
    card.classList.remove('scale-95');
    card.classList.add('scale-100');
}

function closeNameModal() {
    const modal = document.getElementById('name-modal');
    const card = document.getElementById('name-modal-card');
    
    modal.classList.add('opacity-0', 'pointer-events-none');
    card.classList.remove('scale-100');
    card.classList.add('scale-95');
    
    document.getElementById('modal-user-name').value = '';
    document.getElementById('modal-request-id').value = '';
    document.getElementById('name-input-error').classList.add('hidden');
}

document.addEventListener("DOMContentLoaded", function () {
    const nameInput = document.getElementById("modal-user-name");
    const submitBtn = document.getElementById("name-submit-btn");
    const nameError = document.getElementById("name-input-error");

    function validateNameForm() {
        let isNameValid = nameInput.value.trim() !== "";
        
        if (nameInput.value.trim() === "" && nameInput === document.activeElement) {
            nameError.classList.remove("hidden");
        } else if (nameInput.value.trim() !== "") {
            nameError.classList.add("hidden");
        }

        if (isNameValid) {
            submitBtn.removeAttribute("disabled");
            submitBtn.className = "px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-xl transition shadow-md shadow-blue-500/10 cursor-pointer";
        } else {
            submitBtn.setAttribute("disabled", "true");
            submitBtn.className = "px-5 py-2 bg-slate-300 dark:bg-slate-800 text-slate-400 dark:text-slate-600 font-medium text-sm rounded-xl transition cursor-not-allowed";
        }
    }

    nameInput.addEventListener("input", validateNameForm);
    nameInput.addEventListener("blur", validateNameForm);
});
</script>
</body>
</html>
