<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <section class="flex-1 p-8 space-y-8 overflow-y-auto bg-slate-50 dark:bg-[#0b132b] transition-colors duration-300 custom-scrollbar">
    
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Peer Reviews</h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-0.5">See what students and tutors say about their mentoring sessions.</p>
        </div>
        
        <div class="flex items-center space-x-2 overflow-x-auto pb-1 sm:pb-0">
            <button class="px-4 py-2 text-xs font-semibold rounded-xl bg-blue-600 text-white shadow-md shadow-blue-500/10 border-0 cursor-pointer transition">All Reviews</button>
            <button class="px-4 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-[#111936] text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-[#1e295d] hover:border-blue-500 dark:hover:border-blue-500 cursor-pointer transition flex items-center space-x-1">
                <span>5</span> <i class="fa-solid fa-star text-amber-400 text-[10px]"></i>
            </button>
            <button class="px-4 py-2 text-xs font-semibold rounded-xl bg-white dark:bg-[#111936] text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-[#1e295d] hover:border-blue-500 dark:hover:border-blue-500 cursor-pointer transition flex items-center space-x-1">
                <span>4</span> <i class="fa-solid fa-star text-amber-400 text-[10px]"></i>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white dark:bg-[#111936] border border-slate-200 dark:border-[#1e295d] rounded-2xl p-5 shadow-sm flex items-center space-x-4">
            <div class="p-3.5 rounded-xl bg-amber-500/10 text-amber-500">
                <i class="fa-solid fa-star text-xl"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-medium uppercase tracking-wider">Average Rating</p>
                <div class="flex items-baseline space-x-2 mt-0.5">
                    <p class="text-2xl font-bold text-slate-900 dark:text-white">4.8</p>
                    <p class="text-xs text-slate-400">/ 5.0</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-[#111936] border border-slate-200 dark:border-[#1e295d] rounded-2xl p-5 shadow-sm flex items-center space-x-4">
            <div class="p-3.5 rounded-xl bg-blue-500/10 text-blue-500">
                <i class="fa-regular fa-comments text-xl"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-medium uppercase tracking-wider">Total Feedbacks</p>
                <p class="text-2xl font-bold text-slate-900 dark:text-white mt-0.5">124</p>
            </div>
        </div>

        <div class="bg-white dark:bg-[#111936] border border-slate-200 dark:border-[#1e295d] rounded-2xl p-5 shadow-sm flex items-center space-x-4">
            <div class="p-3.5 rounded-xl bg-emerald-500/10 text-emerald-500">
                <i class="fa-solid fa-heart-pulse text-xl"></i>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-medium uppercase tracking-wider">Satisfaction Rate</p>
                <p class="text-2xl font-bold text-slate-900 dark:text-white mt-0.5">96%</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <div class="bg-white dark:bg-[#111936] border border-slate-200 dark:border-[#1e295d] rounded-2xl p-6 shadow-sm flex flex-col justify-between space-y-4 hover:shadow-md transition duration-300">
            <div class="space-y-3">
                <div class="flex items-start justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white font-bold text-sm flex items-center justify-center shadow-inner">
                            AB
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white leading-tight">Amine Benani</h4>
                            <p class="text-slate-400 text-[11px] mt-0.5">Student • PeerSync App</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-0.5 bg-slate-50 dark:bg-[#0b132b]/50 px-2 py-1 rounded-lg border border-slate-100 dark:border-[#1e295d]/40">
                        <i class="fa-solid fa-star text-[11px] text-amber-400"></i>
                        <i class="fa-solid fa-star text-[11px] text-amber-400"></i>
                        <i class="fa-solid fa-star text-[11px] text-amber-400"></i>
                        <i class="fa-solid fa-star text-[11px] text-amber-400"></i>
                        <i class="fa-solid fa-star text-[11px] text-amber-400"></i>
                    </div>
                </div>

                <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">
                    "The session was perfect! The tutor explained MySQL query relationships very clearly. It saved me hours of debugging code on my repository."
                </p>
            </div>

            <div class="pt-3 border-t border-slate-100 dark:border-[#1e295d]/50 flex items-center justify-between text-xs text-slate-400">
                <span class="bg-blue-500/10 text-blue-600 dark:text-blue-400 font-medium px-2 py-0.5 rounded-md border border-blue-500/10">MySQL / PHP</span>
                <div class="flex items-center space-x-1.5">
                    <i class="fa-regular fa-calendar text-[11px]"></i>
                    <span>May 20, 2026</span>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-[#111936] border border-slate-200 dark:border-[#1e295d] rounded-2xl p-6 shadow-sm flex flex-col justify-between space-y-4 hover:shadow-md transition duration-300">
            <div class="space-y-3">
                <div class="flex items-start justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white font-bold text-sm flex items-center justify-center shadow-inner">
                            YK
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white leading-tight">Youssef Kasmi</h4>
                            <p class="text-slate-400 text-[11px] mt-0.5">Student • Tailwind CSS Issue</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-0.5 bg-slate-50 dark:bg-[#0b132b]/50 px-2 py-1 rounded-lg border border-slate-100 dark:border-[#1e295d]/40">
                        <i class="fa-solid fa-star text-[11px] text-amber-400"></i>
                        <i class="fa-solid fa-star text-[11px] text-amber-400"></i>
                        <i class="fa-solid fa-star text-[11px] text-amber-400"></i>
                        <i class="fa-solid fa-star text-[11px] text-amber-400"></i>
                        <i class="fa-regular fa-star text-[11px] text-slate-300 dark:text-slate-600"></i>
                    </div>
                </div>

                <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">
                    "Very helpful guidance on fixing layout responsiveness with custom break points. Dark mode styles are fully operational now. Thanks!"
                </p>
            </div>

            <div class="pt-3 border-t border-slate-100 dark:border-[#1e295d]/50 flex items-center justify-between text-xs text-slate-400">
                <span class="bg-amber-500/10 text-amber-600 dark:text-amber-400 font-medium px-2 py-0.5 rounded-md border border-amber-500/10">Tailwind CSS</span>
                <div class="flex items-center space-x-1.5">
                    <i class="fa-regular fa-calendar text-[11px]"></i>
                    <span>May 18, 2026</span>
                </div>
            </div>
        </div>

    </div>
</section>
</body>
</html>