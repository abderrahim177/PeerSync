<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PeerSync Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght=300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 dark:bg-[#0b132b] dark:text-slate-200 h-screen w-screen flex text-sm overflow-hidden transition-colors duration-300 relative">

    <aside class="w-64 bg-white dark:bg-[#111936] border-r border-slate-200 dark:border-[#1e295d] flex flex-col h-screen justify-between flex-shrink-0 hidden md:flex transition-colors duration-300">
        <div class="overflow-y-auto no-scrollbar flex-1 flex flex-col justify-between">
            <div>
                <div class="p-5 flex items-center space-x-2.5">
                    <div class="bg-slate-100 dark:bg-[#1a365d]/50 w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm dark:shadow-lg dark:shadow-black/20 border border-slate-200 dark:border-[#1e295d]">
                        <svg class="w-5 h-5 text-[#88c057]" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 3L5 12L19 21V16.5L9.5 12L19 7.5V3Z" />
                        </svg>
                    </div>
                    <span class="text-slate-900 dark:text-white text-lg font-bold tracking-wide">ENAA</span>
                </div>

                <div class="px-3 py-1">
                    <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 tracking-wider uppercase px-3 mb-2">Main</p>
                    <nav class="space-y-0.5">
                        <a href="#" class="flex items-center justify-between px-3 py-2.5 rounded-xl bg-blue-50 dark:bg-blue-600/10 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/10 font-medium">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-table-columns text-base w-4 text-center"></i>
                                <span>Dashboard</span>
                            </div>
                        </a>
                        <button onclick="openModal()" class="w-full flex items-center space-x-3 px-3 py-2.5 rounded-xl text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/30 hover:text-slate-900 dark:hover:text-slate-200 transition text-left">
                            <i class="fa-solid fa-circle-plus text-base w-4 text-center"></i>
                            <span>New Request</span>
                        </button>
                        <a href="#" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/30 hover:text-slate-900 dark:hover:text-slate-200 transition">
                            <div class="flex items-center space-x-3">
                                <i class="fa-regular fa-file-lines text-base w-4 text-center"></i>
                                <span>My Requests</span>
                            </div>
                            <span class="bg-blue-50 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 text-[11px] px-2 py-0.5 rounded-full border border-blue-200 dark:border-blue-500/20">3</span>
                        </a>
                    </nav>

                    <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 tracking-wider uppercase px-3 mt-5 mb-2">Explore</p>
                    <nav class="space-y-0.5">
                        <a href="#" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/30 hover:text-slate-900 dark:hover:text-slate-200 transition">
                            <i class="fa-solid fa-magnifying-glass text-base w-4 text-center"></i>
                            <span>Find Tutors</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/30 hover:text-slate-900 dark:hover:text-slate-200 transition">
                            <i class="fa-regular fa-star text-base w-4 text-center"></i>
                            <span>Reviews & Ratings</span>
                        </a>
                    </nav>
                </div>
            </div>

            <div class="px-3 py-4 mt-auto">
                <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 tracking-wider uppercase px-3 mb-2">Account</p>
                <nav class="space-y-0.5">
                    <a href="#" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/30 hover:text-slate-900 dark:hover:text-slate-200 transition">
                        <i class="fa-solid fa-gear text-base w-4 text-center"></i>
                        <span>Settings</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/30 hover:text-slate-900 dark:hover:text-slate-200 transition">
                        <i class="fa-solid fa-right-from-bracket text-base w-4 text-center"></i>
                        <span>Logout</span>
                    </a>
                </nav>
            </div>
        </div>

        <div class="p-4 border-t border-slate-200 dark:border-[#1e295d] bg-white dark:bg-[#111936] flex items-center justify-between hover:bg-slate-50 dark:hover:bg-slate-800/20 cursor-pointer transition sticky bottom-0 z-10 flex-shrink-0">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-full bg-slate-200 dark:bg-slate-700/60 border border-slate-300 dark:border-slate-600 flex items-center justify-center font-bold text-slate-600 dark:text-slate-300 text-xs">
                    AE
                </div>
                <div>
                    <h4 class="text-xs font-semibold text-slate-900 dark:text-white leading-tight">Ahmed El Mansouri</h4>
                    <span class="text-[11px] text-slate-400 dark:text-slate-500">Student</span>
                </div>
            </div>
            <i class="fa-solid fa-chevron-down text-xs text-slate-400 dark:text-slate-500"></i>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen min-w-0 overflow-hidden">
        <header class="h-20 border-b border-slate-200 dark:border-[#1e295d] px-8 flex items-center justify-between bg-white dark:bg-[#0b132b] flex-shrink-0 transition-colors duration-300">
            <h1 class="text-xl font-semibold text-slate-900 dark:text-white">Dashboard</h1>
            
            <div class="flex items-center space-x-6">
                <div class="relative w-80 hidden sm:block">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 dark:text-slate-500">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" placeholder="Search requests, tutors..." 
                           class="w-full bg-slate-100 dark:bg-[#111936] text-slate-800 dark:text-slate-300 pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-[#1e295d] focus:outline-none focus:border-blue-500 transition placeholder-slate-400 dark:placeholder-slate-500 text-sm">
                </div>

                <div class="flex items-center space-x-2 bg-slate-100 dark:bg-[#111936] border border-slate-200 dark:border-[#1e295d] p-1.5 rounded-xl">
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400 px-1 hidden xs:block">
                        <i id="mode-icon" class="fa-solid fa-moon mr-1"></i>
                    </span>
                    <button id="dark-mode-toggle" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-blue-600 transition-colors duration-200 ease-in-out focus:outline-none" role="switch" aria-checked="true">
                        <span id="switch-handle" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out translate-x-5"></span>
                    </button>
                </div>

                <div class="relative cursor-pointer p-1">
                    <i class="fa-regular fa-bell text-xl text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold">2</span>
                </div>

                <div class="w-9 h-9 rounded-full bg-slate-200 dark:bg-slate-700/60 border border-slate-300 dark:border-slate-600 flex items-center justify-center font-bold text-slate-600 dark:text-slate-300 text-sm cursor-pointer">
                    AE
                </div>
            </div>
        </header>

        <section class="flex-1 p-8 space-y-8 overflow-y-auto bg-slate-50 dark:bg-[#0b132b] transition-colors duration-300">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Welcome back, Ahmed!</h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm">Here is what is happening with your tutoring requests</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-[#111936] border border-slate-200 dark:border-[#1e295d] rounded-2xl p-6 flex items-start space-x-5 hover:border-slate-300 dark:hover:border-slate-700 transition shadow-sm">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-600 dark:text-blue-400 text-xl flex-shrink-0">
                        <i class="fa-regular fa-file-lines"></i>
                    </div>
                    <div>
                        <span class="text-4xl font-bold text-slate-900 dark:text-white tracking-tight">3</span>
                        <h3 class="text-slate-500 dark:text-slate-400 font-medium mt-1">Active Requests</h3>
                        <span class="text-xs text-emerald-600 dark:text-emerald-400 font-medium block mt-1">+1 this week</span>
                    </div>
                </div>

                <div class="bg-white dark:bg-[#111936] border border-slate-200 dark:border-[#1e295d] rounded-2xl p-6 flex items-start space-x-5 hover:border-slate-300 dark:hover:border-slate-700 transition shadow-sm">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400 text-xl flex-shrink-0">
                        <i class="fa-regular fa-circle-check"></i>
                    </div>
                    <div>
                        <span class="text-4xl font-bold text-slate-900 dark:text-white tracking-tight">12</span>
                        <h3 class="text-slate-500 dark:text-slate-400 font-medium mt-1">Completed Sessions</h3>
                        <span class="text-xs text-emerald-600 dark:text-emerald-400 font-medium block mt-1">+4 this month</span>
                    </div>
                </div>

                <div class="bg-white dark:bg-[#111936] border border-slate-200 dark:border-[#1e295d] rounded-2xl p-6 flex items-start space-x-5 hover:border-slate-300 dark:hover:border-slate-700 transition shadow-sm">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-600 dark:text-amber-500 text-xl flex-shrink-0">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                    <div>
                        <span class="text-4xl font-bold text-slate-900 dark:text-white tracking-tight">24h</span>
                        <h3 class="text-slate-500 dark:text-slate-400 font-medium mt-1">Total Learning Time</h3>
                        <span class="text-xs text-emerald-600 dark:text-emerald-400 font-medium block mt-1">+6h this week</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 pt-2">
                <div class="lg:col-span-2 bg-white dark:bg-[#111936] border border-slate-200 dark:border-[#1e295d] rounded-2xl p-6 space-y-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white tracking-wide">Active Requests</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Your pending tutoring requests</p>
                        </div>
                        <button onclick="openModal()" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-xl flex items-center space-x-2 transition text-sm shadow-md shadow-blue-500/10">
                            <i class="fa-solid fa-plus text-xs"></i>
                            <span>New Request</span>
                        </button>
                    </div>

                    <div class="border border-blue-200 dark:border-blue-600/30 bg-blue-50/30 dark:bg-[#131f47]/40 rounded-xl p-5 space-y-4 relative hover:border-blue-300 dark:hover:border-blue-500/50 transition">
                        <div class="flex items-start justify-between">
                            <div>
                                <h4 class="text-base font-semibold text-slate-900 dark:text-white">Help with Data Structures Assignment</h4>
                                <span class="text-xs text-blue-600 dark:text-blue-400 font-medium inline-block mt-1">Algorithms & Data Structures</span>
                            </div>
                            <span class="bg-amber-100 dark:bg-amber-500/10 text-amber-700 dark:text-amber-500 text-xs font-semibold px-2.5 py-1 rounded-lg border border-amber-200 dark:border-amber-500/20">Pending</span>
                        </div>
                        <p class="text-slate-600 dark:text-slate-400 text-xs leading-relaxed max-w-2xl">
                            I need help understanding binary search trees and implementing them in Java. The assignment is due next week and I am struggling with the...
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <div id="request-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 dark:bg-black/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
        
        <div class="bg-white dark:bg-[#111936] w-full max-w-xl rounded-2xl border border-slate-200 dark:border-[#1e295d] shadow-2xl flex flex-col max-h-[90vh] overflow-hidden transform scale-95 transition-transform duration-300" id="modal-card">
            
            <div class="p-6 pb-4 border-b border-slate-100 dark:border-[#1e295d] flex items-start justify-between">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Create Help Request</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Describe your problem and a tutor will be assigned to help you.</p>
                </div>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition p-1 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800/50">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <div class="p-6 space-y-5 overflow-y-auto custom-scrollbar flex-1">
                
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300">Title <span class="text-red-500">*</span></label>
                    <input type="text" placeholder="e.g., Help with React useEffect hook" 
                           class="w-full bg-slate-50 dark:bg-[#0b132b] text-slate-800 dark:text-slate-200 px-4 py-2.5 rounded-xl border border-slate-200 dark:border-[#1e295d] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition placeholder-slate-400 dark:placeholder-slate-500 text-sm shadow-sm">
                    <p class="text-[11px] text-slate-400 dark:text-slate-500">A clear, concise title helps tutors understand your issue quickly.</p>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300">Technology / Skill <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <select class="w-full bg-slate-50 dark:bg-[#0b132b] text-slate-800 dark:text-slate-200 px-4 py-2.5 rounded-xl border border-slate-200 dark:border-[#1e295d] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition text-sm appearance-none shadow-sm cursor-pointer">
                            <option value="" disabled selected>Select a technology</option>
                            <option value="react">React.js</option>
                            <option value="java">Java</option>
                            <option value="databases">Database Systems</option>
                            <option value="tailwind">Tailwind CSS</option>
                        </select>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 pointer-events-none">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </span>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300">Description <span class="text-red-500">*</span></label>
                    <textarea rows="4" placeholder="Describe your problem in detail. Include any error messages, what you've tried, and what you expected to happen." 
                              class="w-full bg-slate-50 dark:bg-[#0b132b] text-slate-800 dark:text-slate-200 px-4 py-3 rounded-xl border border-slate-200 dark:border-[#1e295d] focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 transition placeholder-slate-400 dark:placeholder-slate-500 text-sm shadow-sm resize-none"></textarea>
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
                <button onclick="closeModal()" class="px-4 py-2 rounded-xl text-slate-600 dark:text-slate-300 font-medium text-sm hover:bg-slate-100 dark:hover:bg-slate-800 transition">Cancel</button>
                <button class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-xl transition shadow-md shadow-blue-500/10">Submit Request</button>
            </div>
        </div>
    </div>

    <script>
        const toggleBtn = document.getElementById('dark-mode-toggle');
        const switchHandle = document.getElementById('switch-handle');
        const modeIcon = document.getElementById('mode-icon');
        const htmlEl = document.documentElement;

        // Dark mode logical setup
        toggleBtn.addEventListener('click', () => {
            if (htmlEl.classList.contains('dark')) {
                htmlEl.classList.remove('dark');
                toggleBtn.classList.remove('bg-blue-600');
                toggleBtn.classList.add('bg-slate-300');
                switchHandle.classList.remove('translate-x-5');
                switchHandle.classList.add('translate-x-0');
                modeIcon.className = 'fa-solid fa-sun text-amber-500 mr-1';
            } else {
                htmlEl.classList.add('dark');
                toggleBtn.classList.remove('bg-slate-300');
                toggleBtn.classList.add('bg-blue-600');
                switchHandle.classList.remove('translate-x-0');
                switchHandle.classList.add('translate-x-5');
                modeIcon.className = 'fa-solid fa-moon text-slate-400 mr-1';
            }
        });

        // Functionality bsh t7l o tsdd l-modal smoothly
        const modal = document.getElementById('request-modal');
        const modalCard = document.getElementById('modal-card');

        function openModal() {
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modalCard.classList.remove('scale-95');
            modalCard.classList.add('scale-100');
        }

        function closeModal() {
            modal.classList.add('opacity-0', 'pointer-events-none');
            modalCard.classList.remove('scale-100');
            modalCard.classList.add('scale-95');
        }

        // Kat-sd l-modal ila klikiti tbra dialha
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });
    </script>
</body>
</html>