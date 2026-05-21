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
$pendingRequests = array_filter($requests, function($r) {
    return strtoupper($r['status']) === 'PENDING';
});

?>
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
    <!-- Pending requests list -->
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
                                    <i class="fa-regular fa-clock mr-1.5"></i>Just now
                                </span>
                            </div>
                            <form action="/peersync/app/controller/HelpRequestController.php" method="post" class="inline">
                            <input type="hidden" name="request_id" value="<?= $request['id']; ?>">
                            
                            <?php 
                                $isAssignedOrResolved = (strtoupper($request['status']) !== 'PENDING'); 
                            ?>

                            <button name="assign" type="submit"
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
                        </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</section>