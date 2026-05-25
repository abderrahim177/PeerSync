<?php
// Importation dial l-config o repository
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../repositories/HelpRequestRepository.php';

// Safe check ila kanti madrtich session_start() f l-fo9 dial l-project
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest User';
$role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'Member';
$email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : ''; // تأكد من وجوده في السيرفر

$database = new Database();
$dbConnection = $database->connect();
$helpRepo = new HelpRequestRepository($dbConnection);
$stats    = $helpRepo->getRequestStats();

// T9wim dial l-initials mn l-ism
$words = explode(" ", $name);
$initials = "";
if (count($words) >= 2) {
    $initials = strtoupper(mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1));
} else {
    $initials = strtoupper(mb_substr($words[0], 0, 1));
}
?>

<!DOCTYPE html>
<html lang="en" class="dark h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Settings Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-50 h-full font-sans transition-colors duration-200 flex flex-col overflow-hidden">

    <div class="max-w-6xl w-full mx-auto px-4 py-6 md:py-8 flex flex-col h-full overflow-hidden">
        
        <header class="flex justify-between items-center border-b border-slate-200 dark:border-slate-800 pb-4 mb-6 flex-shrink-0">
            <div>
                <h1 class="text-3xl font-bold tracking-tight">Settings</h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Manage your account settings and preferences.</p>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 flex-1 overflow-hidden min-h-0">
            
            <aside class="md:col-span-1 flex-shrink-0">
                <nav class="space-y-1" id="settings-nav">
                    <button data-target="account" class="nav-btn w-full flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all bg-indigo-50 text-indigo-600 dark:bg-indigo-950/50 dark:text-indigo-400">
                        <i data-lucide="user" class="w-4 h-4"></i> Account
                    </button>
                    <button data-target="preferences" class="nav-btn w-full flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-900">
                        <i data-lucide="globe" class="w-4 h-4"></i> Preferences & Language
                    </button>
                    <button data-target="notifications" class="nav-btn w-full flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-900">
                        <i data-lucide="bell" class="w-4 h-4"></i> Notifications
                    </button>
                    <button data-target="security" class="nav-btn w-full flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-900">
                        <i data-lucide="shield" class="w-4 h-4"></i> Security
                    </button>
                </nav>
            </aside>

            <main class="md:col-span-3 space-y-6 md:overflow-y-auto pr-2 pb-8 h-full custom-scrollbar">
                
                <section id="account" class="settings-section bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
                    <h2 class="text-xl font-semibold mb-1">Profile Information</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">Update your personal details and public profile.</p>
                    
                    <form action="update-profile.php" method="POST" class="space-y-6">
                        <div class="flex items-center gap-6 pb-6 border-b border-slate-100 dark:border-slate-800">
                            <div class="relative group">
                                <div class="w-20 h-20 rounded-2xl bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center text-white text-2xl font-bold shadow-md">
                                    <?php echo htmlspecialchars($initials); ?>
                                </div>
                                <button type="button" class="absolute -bottom-1 -right-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-1.5 rounded-lg shadow-sm hover:scale-105 transition-transform cursor-pointer">
                                    <i data-lucide="camera" class="w-3.5 h-3.5 text-slate-600 dark:text-slate-300"></i>
                                </button>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium">Profile Photo</h4>
                                <p class="text-xs text-slate-400 mt-0.5">Role: <span class="font-semibold text-indigo-500"><?php echo htmlspecialchars($role); ?></span></p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Full Name</label>
                                <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Email Address</label>
                                <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="your-email@example.com" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Bio</label>
                            <textarea name="bio" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm" placeholder="Tell us a little bit about yourself..."></textarea>
                        </div>

                        <div class="flex justify-end gap-3 mt-8 pt-4 border-t border-slate-100 dark:border-slate-800">
                            <button type="button" class="px-4 py-2 text-sm font-medium rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-all cursor-pointer">Cancel</button>
                            <button type="submit" class="px-4 py-2 text-sm font-medium rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 shadow-sm shadow-indigo-500/10 transition-all cursor-pointer">Save Changes</button>
                        </div>
                    </form>
                </section>

                <section id="preferences" class="settings-section hidden bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
                    <h2 class="text-xl font-semibold mb-1">Preferences & Language</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">Customize your region, language, and display settings.</p>
                    
                    <div class="space-y-6">
                        <div class="max-w-md">
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Interface Language</label>
                            <div class="relative">
                                <select class="w-full appearance-none px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm cursor-pointer">
                                    <option value="en">🇬🇧 English (US)</option>
                                    <option value="fr">🇫🇷 Français (FR)</option>
                                    <option value="ar">🇲🇦 العربية (Darija / Arabic)</option>
                                    <option value="es">🇪🇸 Español</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                </div>
                            </div>
                        </div>

                        <div class="max-w-md">
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Timezone</label>
                            <div class="relative">
                                <select class="w-full appearance-none px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm cursor-pointer">
                                    <option>(GMT+01:00) Casablanca / Morocco</option>
                                    <option>(GMT+00:00) London / Western Europe</option>
                                    <option>(GMT-05:00) Eastern Time (US & Canada)</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="notifications" class="settings-section hidden bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
                    <h2 class="text-xl font-semibold mb-1">Notifications</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">Choose how and when you want to receive updates.</p>
                    
                    <div class="divide-y divide-slate-100 dark:divide-slate-800">
                        <div class="flex items-center justify-between py-4">
                            <div class="pr-4">
                                <h4 class="text-sm font-medium">Email Notifications</h4>
                                <p class="text-xs text-slate-400 mt-0.5">Receive weekly summaries, product updates, and tips.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" checked class="sr-only peer">
                                <div class="w-10 h-6 bg-slate-200 dark:bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-indigo-600"></div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between py-4">
                            <div class="pr-4">
                                <h4 class="text-sm font-medium">Security Alerts</h4>
                                <p class="text-xs text-slate-400 mt-0.5">Get notified immediately about unusual account activities.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" checked class="sr-only peer">
                                <div class="w-10 h-6 bg-slate-200 dark:bg-slate-800 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-indigo-600"></div>
                            </label>
                        </div>
                    </div>
                </section>

                <section id="security" class="settings-section hidden bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
                    <h2 class="text-xl font-semibold mb-1">Security Settings</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">Manage your password and active login sessions.</p>
                    
                    <form action="update-password.php" method="POST" class="space-y-4 max-w-md">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Current Password</label>
                            <input type="password" name="current_password" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">New Password</label>
                            <input type="password" name="new_password" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-sm">
                        </div>
                        <button type="submit" class="mt-2 px-4 py-2 text-sm font-medium rounded-xl bg-slate-900 dark:bg-slate-100 text-white dark:text-slate-900 hover:opacity-90 transition-all cursor-pointer border-0">Update Password</button>
                    </form>
                </section>

            </main>
        </div>
    </div>

    <script>
        // Initialize Lucide Icons
        lucide.createIcons();

        // Sidebar Navigation Switching Logic
        const navButtons = document.querySelectorAll('.nav-btn');
        const sections = document.querySelectorAll('.settings-section');

        navButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const target = btn.getAttribute('data-target');

                // Update active state button styling
                navButtons.forEach(b => {
                    b.classList.remove('bg-indigo-50', 'text-indigo-600', 'dark:bg-indigo-950/50', 'dark:text-indigo-400');
                    b.classList.add('text-slate-600', 'dark:text-slate-400', 'hover:bg-slate-100', 'dark:hover:bg-slate-900');
                });
                btn.classList.add('bg-indigo-50', 'text-indigo-600', 'dark:bg-indigo-950/50', 'dark:text-indigo-400');
                btn.classList.remove('text-slate-600', 'dark:text-slate-400', 'hover:bg-slate-100', 'dark:hover:bg-slate-900');

                // Switch visible sections smoothly
                sections.forEach(section => {
                    if (section.id === target) {
                        section.classList.remove('hidden');
                    } else {
                        section.classList.add('hidden');
                    }
                });
            });
        });
    </script>
</body>
</html>