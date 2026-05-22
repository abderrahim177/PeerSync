<?php
$name = $_SESSION['user_name'];
$role = $_SESSION['user_role'];
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../repositories/HelpRequestRepository.php';
$database = new Database();
$dbConnection = $database->connect();
$helpRepo = new HelpRequestRepository($dbConnection);
$stats    = $helpRepo->getRequestStats();
$words = explode(" ", $name);
$initials = "";
if (count($words) >= 2) {
    $initials = strtoupper(mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1));
} else {
    $initials = strtoupper(mb_substr($words[0], 0, 1));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <section class="flex-1 p-8 space-y-8 overflow-y-auto bg-slate-50 dark:bg-[#0b132b] transition-colors duration-300 custom-scrollbar">
    
    <div>
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Account Settings</h2>
        <p class="text-slate-500 dark:text-slate-400 text-sm mt-0.5">Manage your public profile and account preferences.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <div class="bg-white dark:bg-[#111936] border border-slate-200 dark:border-[#1e295d] rounded-2xl p-6 shadow-sm flex flex-col items-center text-center space-y-4">
            <div class="relative group">
                <div class="w-24 h-24 rounded-full bg-blue-600 dark:bg-blue-500 text-white font-bold text-3xl flex items-center justify-center border-4 border-slate-100 dark:border-[#0b132b] shadow-md">
                    <?php echo htmlspecialchars($initials); ?>
                </div>
                <button class="absolute bottom-0 right-0 bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-full text-xs shadow-md border border-white dark:border-[#111936] transition cursor-pointer">
                    <i class="fa-solid fa-camera"></i>
                </button>
            </div>

            <div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white leading-tight"><?= $name ?></h3>
                <span class="inline-block mt-1 bg-blue-500/10 text-blue-600 dark:text-blue-400 text-xs font-semibold px-2.5 py-0.5 rounded-full border border-blue-500/20">
                    Student
                </span>
            </div>

            <hr class="w-full border-slate-100 dark:border-[#1e295d]/60">

            <div class="grid grid-cols-2 gap-4 w-full pt-2">
                <div class="bg-slate-50 dark:bg-[#0b132b]/40 p-3 rounded-xl border border-slate-100 dark:border-[#1e295d]/30">
                    <p class="text-slate-400 text-[11px] font-medium uppercase tracking-wider">Total Requests</p>
                    <p class="text-xl font-bold text-slate-900 dark:text-white mt-0.5"><?= $stats['total']; ?></p>
                </div>
                <div class="bg-slate-50 dark:bg-[#0b132b]/40 p-3 rounded-xl border border-slate-100 dark:border-[#1e295d]/30">
                    <p class="text-slate-400 text-[11px] font-medium uppercase tracking-wider">Resolved</p>
                    <p class="text-xl font-bold text-emerald-600 dark:text-emerald-400 mt-0.5"><?= $stats['resolved']; ?></p>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 bg-white dark:bg-[#111936] border border-slate-200 dark:border-[#1e295d] rounded-2xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 dark:border-[#1e295d]/60">
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Profile Information</h3>
                <p class="text-slate-400 text-xs mt-0.5">Update your personal details and how peers see you.</p>
            </div>

            <form action="update-profile.php" method="POST" class="p-6 space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1.5 uppercase">Full Name</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fa-regular fa-user text-xs"></i>
                            </span>
                            <input type="text" name="name" placeholder="Your Full Name" required class="w-full bg-slate-50 dark:bg-[#0b132b] text-slate-800 dark:text-slate-300 pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-[#1e295d] focus:outline-none focus:border-blue-500 transition text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1.5 uppercase">Account Role</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="fa-solid fa-graduation-cap text-xs"></i>
                            </span>
                            <input type="text" disabled value="Student" class="w-full bg-slate-100 dark:bg-[#0b132b]/60 text-slate-400 dark:text-slate-500 pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-[#1e295d]/50 text-sm cursor-not-allowed">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1.5 uppercase">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="fa-regular fa-envelope text-xs"></i>
                        </span>
                        <input type="email" name="email" placeholder="your.email@enaa.ma" required class="w-full bg-slate-50 dark:bg-[#0b132b] text-slate-800 dark:text-slate-300 pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-[#1e295d] focus:outline-none focus:border-blue-500 transition text-sm">
                    </div>
                </div>

                <div class="pt-2 border-t border-slate-100 dark:border-[#1e295d]/60 flex items-center justify-between">
                    <p class="text-xs text-slate-400 dark:text-slate-500">Make sure to save changes before leaving.</p>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-5 py-2.5 rounded-xl transition cursor-pointer border-0 shadow-md shadow-blue-500/10">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

    </div>
</section>
</body>
</html>


