<?php
// التأكد من بدء الجلسة (Session) لجلب بيانات المستخدم
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$name = $_SESSION['user_name'] ?? 'User';
$role = $_SESSION['user_role'] ?? 'Student';

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

<section class="flex-1 p-6 lg:p-10 space-y-8 overflow-y-auto bg-slate-50 dark:bg-[#040814] transition-colors duration-300 custom-scrollbar antialiased text-slate-900 dark:text-white">
    
    <!-- Header العناوين الرئيسية -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-slate-200 dark:border-cyan-500/10 pb-6">
        <div>
            <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-wide uppercase">
                Account Control Center
            </h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">
                Configure your identity, secure your credentials, and monitor system metrics.
            </p>
        </div>
        <div class="flex items-center space-x-3">
            <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-mono bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 border border-cyan-500/20 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse mr-1.5"></span>
                Node Active
            </span>
        </div>
    </div>

    <!-- Hero Profile Card بطاقة الملف الشخصي العلوية الاحترافية -->
    <div class="relative bg-white dark:bg-[#0b132b]/40 border border-slate-200 dark:border-cyan-500/10 rounded-2xl overflow-hidden shadow-md backdrop-blur-md">
        <!-- Cover Background -->
        <div class="h-32 w-full bg-gradient-to-r from-blue-600 via-indigo-600 to-cyan-500 opacity-80 dark:opacity-40"></div>
        
        <div class="p-6 pt-0 flex flex-col sm:flex-row items-start sm:items-end gap-6 -mt-10 sm:-mt-12 relative z-10">
            <!-- Avatar -->
            <div class="relative group shrink-0">
                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl bg-gradient-to-br from-blue-600 to-cyan-500 text-white font-black text-3xl sm:text-4xl flex items-center justify-center border-4 border-white dark:border-[#040814] shadow-xl">
                    <?= htmlspecialchars($initials); ?>
                </div>
                <button class="absolute -bottom-2 -right-2 bg-slate-900 text-white hover:bg-cyan-500 hover:text-slate-950 p-2 rounded-xl text-xs shadow-lg border border-slate-700 transition duration-300 cursor-pointer">
                    <i class="fa-solid fa-camera"></i>
                </button>
            </div>

            <!-- Identity Core -->
            <div class="flex-1 space-y-2 pb-2">
                <div class="flex flex-wrap items-center gap-2">
                    <h3 class="text-2xl font-black tracking-tight text-slate-900 dark:text-white"><?= htmlspecialchars($name); ?></h3>
                    <span class="bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 text-[10px] uppercase font-bold px-2.5 py-0.5 rounded-full border border-cyan-500/20 tracking-wider">
                        <?= htmlspecialchars($role); ?>
                    </span>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-mono">ID: // SYNC-USER</p>
            </div>

            <!-- Metrics Quick Grid الإحصائيات الجانبية السريعة -->
            <div class="flex gap-3 w-full sm:w-auto pt-4 sm:pt-0 border-t sm:border-t-0 border-slate-100 dark:border-cyan-500/10">
                <div class="bg-slate-50 dark:bg-[#040814]/40 px-4 py-2.5 rounded-xl border border-slate-200/60 dark:border-cyan-500/10 min-w-[100px] text-center">
                    <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Requests</p>
                    <p class="text-lg font-black text-slate-900 dark:text-white mt-0.5"><?= $stats['total']; ?></p>
                </div>
                <div class="bg-slate-50 dark:bg-[#040814]/40 px-4 py-2.5 rounded-xl border border-slate-200/60 dark:border-cyan-500/10 min-w-[100px] text-center">
                    <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Resolved</p>
                    <p class="text-lg font-black text-emerald-600 dark:text-emerald-400 mt-0.5"><?= $stats['resolved']; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation الأقسام الداخلية للملف الشخصي -->
    <div class="border-b border-slate-200 dark:border-cyan-500/10 flex space-x-6 text-sm font-medium">
        <button class="border-b-2 border-cyan-500 pb-3 text-cyan-600 dark:text-cyan-400 font-bold px-1 flex items-center gap-2 bg-transparent border-0 cursor-pointer">
            <i class="fa-regular fa-id-card text-xs"></i>
            <span>Profile Architecture</span>
        </button>
        <button class="border-b-2 border-transparent pb-3 text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 px-1 flex items-center gap-2 bg-transparent border-0 cursor-pointer transition p-0">
            <i class="fa-solid fa-shield-halved text-xs"></i>
            <span>Security Credentials</span>
        </button>
    </div>

    <!-- Main Grid Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <!-- Left Side: System Information & Logs -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-[#111936]/40 border border-slate-200 dark:border-cyan-500/10 rounded-2xl p-6 shadow-sm backdrop-blur-md space-y-4">
                <h4 class="text-xs font-black text-slate-900 dark:text-cyan-400 uppercase tracking-widest flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-cyan-500"></i>
                    <span>Node Metadata</span>
                </h4>
                
                <div class="space-y-3 text-xs font-mono text-slate-600 dark:text-slate-400">
                    <div class="flex justify-between py-2 border-b border-slate-100 dark:border-cyan-500/5">
                        <span>Environment:</span>
                        <span class="text-slate-900 dark:text-white font-bold">Production / SSL</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100 dark:border-cyan-500/5">
                        <span>Access Level:</span>
                        <span class="text-slate-900 dark:text-white font-bold"><?= htmlspecialchars($role); ?></span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span>Terminal Gateway:</span>
                        <span class="text-slate-900 dark:text-white font-bold">Localhost // DB</span>
                    </div>
                </div>
            </div>
            
            <!-- Quick Tips Panel -->
            <div class="bg-gradient-to-br from-blue-600/5 to-cyan-500/5 dark:from-blue-500/5 dark:to-cyan-400/5 border border-blue-500/10 dark:border-cyan-500/10 rounded-2xl p-5 space-y-3 flex items-start gap-3">
                <i class="fa-regular fa-lightbulb text-cyan-500 text-lg mt-0.5"></i>
                <div class="space-y-1">
                    <h5 class="text-xs font-bold text-slate-900 dark:text-white">Data Integrity</h5>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed">Your profile information is shared within the peer network to match you with compatible technical tutors.</p>
                </div>
            </div>
        </div>

        <!-- Right Side: Profile Edit Form -->
        <div class="lg:col-span-2 bg-white dark:bg-[#111936]/20 border border-slate-200 dark:border-cyan-500/10 rounded-2xl shadow-sm backdrop-blur-md overflow-hidden">
            <div class="p-6 border-b border-slate-200 dark:border-cyan-500/10 bg-slate-50/50 dark:bg-[#111936]/40">
                <h3 class="text-base font-black text-slate-900 dark:text-white uppercase tracking-wider">Identity Matrix Configuration</h3>
                <p class="text-slate-400 text-xs mt-1">Modify structural variables linked to your synchronization node.</p>
            </div>

            <form action="update-profile.php" method="POST" class="p-6 space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    
                    <!-- Full Name -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Full Identity Name</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 dark:text-cyan-500/40 pointer-events-none">
                                <i class="fa-regular fa-user text-xs"></i>
                            </span>
                            <input type="text" name="name" value="<?= htmlspecialchars($name); ?>" placeholder="Your Full Name" required 
                                   class="w-full bg-slate-50 dark:bg-[#040814]/60 text-slate-800 dark:text-slate-200 pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-cyan-500/20 focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/10 transition text-sm font-medium shadow-sm">
                        </div>
                    </div>

                    <!-- Role (Read Only) -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">System Privilege Role</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 dark:text-slate-600 pointer-events-none">
                                <i class="fa-solid fa-graduation-cap text-xs"></i>
                            </span>
                            <input type="text" disabled value="<?= htmlspecialchars($role); ?>" 
                                   class="w-full bg-slate-100/80 dark:bg-[#040814]/30 text-slate-400 dark:text-slate-500 pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-cyan-500/5 text-sm font-mono cursor-not-allowed">
                        </div>
                    </div>
                </div>

                <!-- Email Address -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Communication Vector (Email)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 dark:text-cyan-500/40 pointer-events-none">
                            <i class="fa-regular fa-envelope text-xs"></i>
                        </span>
                        <input type="email" name="email" placeholder="username@domain.com" required 
                               class="w-full bg-slate-50 dark:bg-[#040814]/60 text-slate-800 dark:text-slate-200 pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-cyan-500/20 focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/10 transition text-sm font-medium shadow-sm">
                    </div>
                </div>

                <!-- Action Footer -->
                <div class="pt-5 border-t border-slate-200 dark:border-cyan-500/10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-slate-50/30 dark:bg-transparent -mx-6 -mb-6 p-6">
                    <p class="text-xs text-slate-400 dark:text-slate-500 flex items-center gap-1.5">
                        <i class="fa-solid fa-triangle-exclamation text-amber-500/70"></i>
                        Commit all state modifications before reloading.
                    </p>
                    <button type="submit" class="bg-cyan-500 hover:bg-cyan-600 text-slate-950 font-bold text-xs px-6 py-2.5 rounded-xl transition cursor-pointer border-0 shadow-lg dark:shadow-[0_0_20px_rgba(6,182,212,0.2)] tracking-wider uppercase">
                        Save Matrix Changes
                    </button>
                </div>
            </form>
        </div>

    </div>
</section>