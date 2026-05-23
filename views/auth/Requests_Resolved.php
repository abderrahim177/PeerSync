<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PeerSync - Resolved Requests</title>
    <!-- Tailwind CSS & FontAwesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <script>
        // Tailwind config bach n-definiw l-dark mode classes ila bghiti t-togglayh b class="dark" f l-html
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
</head>
<!-- Tqder t-changer mn 'bg-slate-50' l 'dark:bg-[#0b0f19]' ghir b dynamic class integration -->
<body class="bg-slate-50 dark:bg-[#0b0f19] min-h-screen text-slate-800 dark:text-slate-100 transition-colors duration-300 antialiased p-4 sm:p-6 md:p-8">

    <div class="max-w-5xl mx-auto">
        
        <!-- HEADER SECTION -->
        <header class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-200 dark:border-white/5 pb-6">
            <div>
                <div class="flex items-center gap-2 text-sm text-blue-600 dark:text-blue-400 font-semibold mb-1">
                    <i class="fa-solid fa-circle-check text-xs"></i>
                    <span>Archived History</span>
                </div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-3xl">Resolved Requests</h1>
                <p class="text-slate-500 dark:text-gray-400 text-sm mt-1">Review all completed peer tutoring and academic help sessions.</p>
            </div>

            <!-- Stats Badge Counter -->
            <div class="flex items-center gap-3 bg-white dark:bg-[#111827] border border-slate-200 dark:border-white/5 px-4 py-2.5 rounded-xl shadow-sm self-start sm:self-auto">
                <div class="w-8 h-8 rounded-lg bg-green-500/10 text-green-600 dark:text-green-400 flex items-center justify-center text-sm font-bold">
                    3
                </div>
                <span class="text-xs font-medium text-slate-500 dark:text-gray-400 uppercase tracking-wider">Total Sessions</span>
            </div>
        </header>

        <!-- SEARCH & FILTER BAR (Pro Dashboard look) -->
        <div class="mb-6 flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 dark:text-gray-500">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </span>
                <input type="text" placeholder="Search by technology or student name..." 
                    class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl bg-white dark:bg-[#111827] border border-slate-200 dark:border-white/10 text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10 transition">
            </div>
            <select class="px-4 py-2.5 text-sm rounded-xl bg-white dark:bg-[#111827] border border-slate-200 dark:border-white/10 text-slate-700 dark:text-gray-300 focus:outline-none focus:border-blue-500 transition cursor-pointer">
                <option>All Technologies</option>
                <option>PHP / Laravel</option>
                <option>React.js</option>
                <option>Tailwind CSS</option>
            </select>
        </div>

        <!-- RESOLVED REQUESTS LIST/CARDS CONTAINER -->
        <div class="space-y-4">

            <!-- CARD 1 (Laravel Request) -->
            <div class="group bg-white dark:bg-[#111827] border border-slate-200 dark:border-white/5 rounded-2xl p-5 sm:p-6 shadow-sm hover:shadow-md transition duration-200 relative overflow-hidden">
                <!-- Status Border Highlight -->
                <div class="absolute left-0 top-0 bottom-0 w-[4px] bg-green-500"></div>
                
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <!-- Tech Icon Badge -->
                        <div class="w-12 h-12 rounded-xl bg-orange-500/10 dark:bg-orange-500/20 text-orange-600 dark:text-orange-400 flex items-center justify-center text-lg shrink-0 border border-orange-500/10">
                            <i class="fa-brands fa-laravel"></i>
                        </div>
                        <div>
                            <div class="flex items-center flex-wrap gap-2 mb-1">
                                <h3 class="font-bold text-slate-900 dark:text-white text-base group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">Database Relationship Mapping</h3>
                                <span class="bg-slate-100 dark:bg-white/5 text-slate-600 dark:text-gray-300 text-xs px-2.5 py-0.5 rounded-full font-medium border border-slate-200/60 dark:border-white/5">Laravel</span>
                            </div>
                            <p class="text-sm text-slate-500 dark:text-gray-400 line-clamp-2 max-w-2xl">Help with configuring a advanced Eloquent polymorphic relationship inside a modular dashboard schema.</p>
                            
                            <!-- Meta details info row -->
                            <div class="flex flex-wrap items-center gap-y-1 gap-x-4 mt-3 text-xs text-slate-400 dark:text-gray-500">
                                <span class="flex items-center gap-1.5"><i class="fa-solid fa-graduation-cap"></i> Student: <strong class="text-slate-600 dark:text-gray-300 font-medium">Anas Lamrani</strong></span>
                                <span class="flex items-center gap-1.5"><i class="fa-solid fa-chalkboard-user"></i> Tutor: <strong class="text-slate-600 dark:text-gray-300 font-medium">Yassine El</strong></span>
                                <span class="flex items-center gap-1.5"><i class="fa-regular fa-calendar"></i> May 22, 2026</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Actions/Badge Section -->
                    <div class="flex items-center justify-between md:justify-end md:flex-col items-end gap-3 pt-4 md:pt-0 border-t md:border-t-0 border-slate-100 dark:border-white/5">
                        <span class="bg-green-50 dark:bg-green-500/10 text-green-600 dark:text-green-400 text-xs font-semibold px-3 py-1 rounded-full border border-green-200/50 dark:border-green-500/20 flex items-center gap-1">
                            <i class="fa-solid fa-check text-[10px]"></i> Resolved
                        </span>
                        <button class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 text-xs font-medium flex items-center gap-1 px-2.5 py-1.5 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-500/10 transition">
                            <span>View Details</span>
                            <i class="fa-solid fa-angle-right text-[10px]"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- CARD 2 (React.js Request) -->
            <div class="group bg-white dark:bg-[#111827] border border-slate-200 dark:border-white/5 rounded-2xl p-5 sm:p-6 shadow-sm hover:shadow-md transition duration-200 relative overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-[4px] bg-green-500"></div>
                
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl bg-cyan-500/10 dark:bg-cyan-500/20 text-cyan-600 dark:text-cyan-400 flex items-center justify-center text-lg shrink-0 border border-cyan-500/10">
                            <i class="fa-brands fa-react"></i>
                        </div>
                        <div>
                            <div class="flex items-center flex-wrap gap-2 mb-1">
                                <h3 class="font-bold text-slate-900 dark:text-white text-base group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">Global State Context Bug</h3>
                                <span class="bg-slate-100 dark:bg-white/5 text-slate-600 dark:text-gray-300 text-xs px-2.5 py-0.5 rounded-full font-medium border border-slate-200/60 dark:border-white/5">React.js</span>
                            </div>
                            <p class="text-sm text-slate-500 dark:text-gray-400 line-clamp-2 max-w-2xl">Fixing infinite re-rendering loops happening whenever the theme switcher updates local storage bindings inside context providers.</p>
                            
                            <div class="flex flex-wrap items-center gap-y-1 gap-x-4 mt-3 text-xs text-slate-400 dark:text-gray-500">
                                <span class="flex items-center gap-1.5"><i class="fa-solid fa-graduation-cap"></i> Student: <strong class="text-slate-600 dark:text-gray-300 font-medium">Fatima Zahra</strong></span>
                                <span class="flex items-center gap-1.5"><i class="fa-solid fa-chalkboard-user"></i> Tutor: <strong class="text-slate-600 dark:text-gray-300 font-medium">Amine Drissi</strong></span>
                                <span class="flex items-center gap-1.5"><i class="fa-regular fa-calendar"></i> May 20, 2026</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between md:justify-end md:flex-col items-end gap-3 pt-4 md:pt-0 border-t md:border-t-0 border-slate-100 dark:border-white/5">
                        <span class="bg-green-50 dark:bg-green-500/10 text-green-600 dark:text-green-400 text-xs font-semibold px-3 py-1 rounded-full border border-green-200/50 dark:border-green-500/20 flex items-center gap-1">
                            <i class="fa-solid fa-check text-[10px]"></i> Resolved
                        </span>
                        <button class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 text-xs font-medium flex items-center gap-1 px-2.5 py-1.5 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-500/10 transition">
                            <span>View Details</span>
                            <i class="fa-solid fa-angle-right text-[10px]"></i>
                        </button>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- SCRIPT T7T LAILA TO TOGGLE FOR PREVIEW PURPOSES -->
    <div class="fixed bottom-6 right-6 z-50">
        <button onclick="document.documentElement.classList.toggle('dark')" class="bg-slate-900 text-white dark:bg-white dark:text-slate-900 font-medium text-xs px-4 py-2.5 rounded-xl shadow-2xl flex items-center gap-2 transition active:scale-95">
            <i class="fa-solid fa-moon dark:hidden"></i>
            <i class="fa-solid fa-sun hidden dark:inline"></i>
            <span>Toggle Dark/Light Mode</span>
        </button>
    </div>
    <script>
    const themeToggleBtn = document.getElementById('theme-toggle');
    const darkIcon = document.getElementById('theme-toggle-dark-icon');
    const lightIcon = document.getElementById('theme-toggle-light-icon');

    // 1. Affichi l-icon l-monasiba 3la hsab l-mode l-7ali
    if (document.documentElement.classList.contains('dark')) {
        lightIcon.classList.remove('hidden');
    } else {
        darkIcon.classList.remove('hidden');
    }

    // 2. L-Event listener mli l-user kayswitchi
    themeToggleBtn.addEventListener('click', function() {
        // Toggle l-icons inside the button
        darkIcon.classList.toggle('hidden');
        lightIcon.classList.toggle('hidden');

        // Ila kan dark mode, rj3o light.. o l-3aks صحيح
        if (localStorage.getItem('color-theme')) {
            if (localStorage.getItem('color-theme') === 'light') {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            }
        } else {
            // Ila kant awel mara o makaynsh f local storage
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
        }
    });
</script>
</body>
</html>