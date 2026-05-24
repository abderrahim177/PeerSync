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
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PeerSync - Settings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <style>
        /* إخفاء السكرول بار الحركي للحفاظ على جمالية التصميم */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-[#0b132b] text-slate-800 dark:text-slate-100 min-h-screen transition-colors duration-300 antialiased">

    <main class="max-w-5xl mx-auto p-4 sm:p-6 md:p-8 space-y-6">
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-200 dark:border-[#1e295d]/50 pb-5">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Account Settings</h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm mt-0.5">Manage your profile, security preferences, and dashboard configuration.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            
            <div class="md:col-span-1 space-y-1">
                <button class="w-full flex items-center space-x-3 px-4 py-2.5 rounded-xl text-sm font-medium transition bg-blue-50 dark:bg-blue-600/10 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/10">
                    <i class="fa-regular fa-user w-4 text-center"></i>
                    <span>Profile Info</span>
                </button>
                <button class="w-full flex items-center space-x-3 px-4 py-2.5 rounded-xl text-sm font-medium transition text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/30 hover:text-slate-900 dark:hover:text-slate-200">
                    <i class="fa-solid fa-shield-halved w-4 text-center"></i>
                    <span>Security</span>
                </button>
                <button class="w-full flex items-center space-x-3 px-4 py-2.5 rounded-xl text-sm font-medium transition text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/30 hover:text-slate-900 dark:hover:text-slate-200">
                    <i class="fa-regular fa-bell w-4 text-center"></i>
                    <span>Notifications</span>
                </button>
            </div>

            <div class="md:col-span-3 space-y-6">
                
                <div class="bg-white dark:bg-[#111936] border border-slate-200 dark:border-[#1e295d] rounded-2xl p-6 shadow-sm space-y-6">
                    <div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">Public Profile</h3>
                        <p class="text-xs text-slate-400 mt-0.5">This information will be visible to other students and tutors on PeerSync.</p>
                    </div>

                    <div class="flex items-center space-x-5">
                        <div class="relative group">
                            <div class="w-20 h-20 rounded-2xl bg-indigo-600 text-white font-extrabold text-2xl flex items-center justify-center shadow-md uppercase">
                                <?php echo htmlspecialchars($initials); ?>
                            </div>
                            <button class="absolute -bottom-1 -right-1 bg-blue-600 text-white w-7 h-7 rounded-lg flex items-center justify-center border-2 border-white dark:border-[#111936] shadow hover:bg-blue-700 transition">
                                <i class="fa-solid fa-camera text-xs"></i>
                            </button>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800 dark:text-slate-200">Profile Picture</p>
                            <p class="text-xs text-slate-400 mt-0.5">PNG, JPG or GIF. Max 2MB.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Full Name</label>
                            <input type="text" value="Amine Benani" class="w-full px-4 py-2.5 text-sm rounded-xl bg-slate-50 dark:bg-[#0b132b] border border-slate-200 dark:border-[#1e295d] text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 transition">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Email Address</label>
                            <input type="email" value="amine.benani@example.com" class="w-full px-4 py-2.5 text-sm rounded-xl bg-slate-50 dark:bg-[#0b132b] border border-slate-200 dark:border-[#1e295d] text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 transition">
                        </div>
                        <div class="sm:col-span-2 space-y-1.5">
                            <label class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Biography / Skills Overview</label>
                            <textarea rows="3" class="w-full px-4 py-2.5 text-sm rounded-xl bg-slate-50 dark:bg-[#0b132b] border border-slate-200 dark:border-[#1e295d] text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 transition placeholder-slate-400 resize-none" placeholder="Tell us about your background or what you prefer to tutor..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-[#111936] border border-slate-200 dark:border-[#1e295d] rounded-2xl p-6 shadow-sm space-y-6">
                    <div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">Security & Preferences</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Keep your account safe and choose your default system settings.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">New Password</label>
                            <input type="password" placeholder="••••••••" class="w-full px-4 py-2.5 text-sm rounded-xl bg-slate-50 dark:bg-[#0b132b] border border-slate-200 dark:border-[#1e295d] text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 transition">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Confirm Password</label>
                            <input type="password" placeholder="••••••••" class="w-full px-4 py-2.5 text-sm rounded-xl bg-slate-50 dark:bg-[#0b132b] border border-slate-200 dark:border-[#1e295d] text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 transition">
                        </div>
                    </div>

                    <div class="pt-2 space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-slate-800 dark:text-slate-200">Email Notifications</p>
                                <p class="text-xs text-slate-400">Receive alerts when a tutor accepts your help request.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" checked class="sr-only peer">
                                <div class="w-10 h-6 bg-slate-200 dark:bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-3">
                    <button class="px-5 py-2.5 text-xs font-semibold rounded-xl bg-white dark:bg-[#111936] text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-[#1e295d] hover:bg-slate-50 transition">
                        Cancel
                    </button>
                    <button class="px-5 py-2.5 text-xs font-semibold rounded-xl bg-blue-600 text-white shadow-md shadow-blue-500/10 hover:bg-blue-700 transition">
                        Save Changes
                    </button>
                </div>

            </div>
        </div>

    </main>

    <script>
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const themeText = document.getElementById('theme-text');
        const htmlElement = document.documentElement;

        themeToggleBtn.addEventListener('click', () => {
            if (htmlElement.classList.contains('dark')) {
                htmlElement.classList.remove('dark');
                themeIcon.className = 'fa-solid fa-sun';
                themeText.innerText = 'Light Mode';
            } else {
                htmlElement.classList.add('dark');
                themeIcon.className = 'fa-solid fa-moon';
                themeText.innerText = 'Dark Mode';
            }
        });
    </script>
</body>
</html>