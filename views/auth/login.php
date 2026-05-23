<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PeerSync — Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        syne: ['Syne', 'sans-serif'],
                        dm:   ['DM Sans', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        body { font-family: 'DM Sans', sans-serif; }

        .grid-bg {
            background-image:
                linear-gradient(rgba(37,99,235,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(37,99,235,0.04) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 1000px #0F1629 inset;
            -webkit-text-fill-color: #F0F4FF;
            transition: background-color 5000s;
        }

        .text-gradient {
            background: linear-gradient(135deg, #60a5fa, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* pseudo-element effects */
        .btn-submit::before {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.12) 0%, transparent 60%);
            pointer-events: none; border-radius: inherit;
        }
        .btn-submit::after {
            content: '';
            position: absolute;
            top: -100%; left: -100%;
            width: 60%; height: 300%;
            background: linear-gradient(105deg, transparent, rgba(255,255,255,0.15), transparent);
            transform: skewX(-20deg);
            transition: left 0.5s;
        }
        .btn-submit:hover::after { left: 200%; }

        .left-sep::after {
            content: '';
            position: absolute; right: 0; top: 10%; bottom: 10%;
            width: 1px;
            background: linear-gradient(to bottom, transparent, rgba(255,255,255,0.07), transparent);
        }

        .card-glow::before {
            content: ''; position: absolute; inset: 0; border-radius: 16px;
            background: linear-gradient(135deg, rgba(37,99,235,0.06), transparent);
            opacity: 0; transition: opacity 0.4s;
        }
        .card-glow:hover::before { opacity: 1; }

        .role-glow::before {
            content: ''; position: absolute; inset: 0; border-radius: 12px;
            background: linear-gradient(135deg, rgba(37,99,235,0.08), transparent);
            opacity: 0; transition: opacity 0.3s;
        }
        .role-glow:hover::before { opacity: 1; }

        .focus-in:focus {
            border-color: rgba(37,99,235,0.6) !important;
            background: rgba(37,99,235,0.04) !important;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.12), inset 0 1px 0 rgba(255,255,255,0.04) !important;
        }

        /* animations */
        @keyframes gridDrift {
            0%   { transform: translate(0,0); }
            100% { transform: translate(60px,60px); }
        }
        .anim-grid { animation: gridDrift 20s linear infinite; }

        @keyframes orbPulse {
            0%,100% { opacity:0; transform:scale(0.9); }
            50%     { opacity:1; transform:scale(1.1); }
        }
        .orb-1 { animation: orbPulse 8s ease-in-out 0s   infinite; }
        .orb-2 { animation: orbPulse 8s ease-in-out -4s  infinite; }
        .orb-3 { animation: orbPulse 8s ease-in-out -2s  infinite; }

        @keyframes scan {
            0%   { top:-10px; opacity:0; }
            5%   { opacity:1; }
            95%  { opacity:1; }
            100% { top:110vh; opacity:0; }
        }
        .scan-line {
            position:fixed; left:0; right:0; height:2px; z-index:50; pointer-events:none;
            background: linear-gradient(90deg, transparent, rgba(37,99,235,0.3), transparent);
            animation: scan 8s linear infinite;
        }

        @keyframes slideL {
            from { opacity:0; transform:translateX(-30px); }
            to   { opacity:1; transform:translateX(0); }
        }
        .anim-left { animation: slideL 0.8s cubic-bezier(0.22,1,0.36,1) 0.1s both; }

        @keyframes slideR {
            from { opacity:0; transform:translateX(30px); }
            to   { opacity:1; transform:translateX(0); }
        }
        .anim-right { animation: slideR 0.8s cubic-bezier(0.22,1,0.36,1) 0.2s both; }

        @keyframes fIn  { from{opacity:0;transform:translateY(20px);} to{opacity:1;transform:translateY(0);} }
        @keyframes fUD  { 0%,100%{transform:translateY(0);} 50%{transform:translateY(-8px);} }

        .float-1 { animation: fIn 0.6s cubic-bezier(0.22,1,0.36,1) 0.5s both, fUD 5s ease-in-out 1.2s infinite; }
        .float-2 { animation: fIn 0.6s cubic-bezier(0.22,1,0.36,1) 0.7s both, fUD 5s ease-in-out 1.4s infinite; }
        .float-3 { animation: fIn 0.6s cubic-bezier(0.22,1,0.36,1) 0.9s both, fUD 5s ease-in-out 1.6s infinite; }

        @keyframes dotPulse { 0%,100%{opacity:1;} 50%{opacity:0.4;} }
        .dot-pulse { animation: dotPulse 2s ease-in-out infinite; }
    </style>
</head>
<body class="min-h-screen bg-[#0A0F1E] text-[#F0F4FF] overflow-hidden flex items-center justify-center">

    <!-- Scan line -->
    <div class="scan-line"></div>

    <!-- BG -->
    <div class="fixed inset-0 z-0 overflow-hidden bg-[#0A0F1E]">
        <div class="grid-bg anim-grid absolute inset-0"></div>
        <div class="orb-1 absolute w-[500px] h-[500px] rounded-full blur-[80px] -top-36 -left-24"
             style="background:radial-gradient(circle,rgba(37,99,235,.18),transparent 70%)"></div>
        <div class="orb-2 absolute w-[400px] h-[400px] rounded-full blur-[80px] -bottom-24 -right-24"
             style="background:radial-gradient(circle,rgba(99,102,241,.12),transparent 70%)"></div>
        <div class="orb-3 absolute w-[300px] h-[300px] rounded-full blur-[80px] top-1/2 right-1/4"
             style="background:radial-gradient(circle,rgba(14,165,233,.08),transparent 70%)"></div>
    </div>

    <!-- Page layout -->
    <div class="relative z-10 min-h-screen flex items-stretch">

        <!-- ══ LEFT ══ -->
        <div class="anim-left left-sep relative flex-none w-[520px] flex flex-col justify-center items-cnter px-14 py-16">

            <!-- Logo -->
            <div class="flex items-center gap-3 mb-14">
                <div class="relative w-10 h-10 rounded-xl bg-[#2563EB] flex items-center justify-center text-white text-base"
                     style="box-shadow:0 0 0 1px rgba(37,99,235,.5),0 8px 24px rgba(37,99,235,.3)">
                    <i class="fa-solid fa-building-columns"></i>
                    <div class="absolute inset-0 rounded-xl pointer-events-none"
                         style="background:linear-gradient(135deg,rgba(255,255,255,.2),transparent)"></div>
                </div>
                <span class="font-syne text-xl font-bold tracking-tight">PeerSync</span>
            </div>

            <!-- Heading -->
            <h2 class="font-syne text-[34px] font-extrabold leading-tight tracking-tight mb-2">Welcome back</h2>
            <p class="text-sm font-light text-[#8A96B0] tracking-wide mb-10">Sign in to continue to your dashboard</p>

            <!-- Form -->
            <form action="login-process.php" method="POST" class="flex flex-col gap-5">

                <!-- Email -->
                <div class="flex flex-col gap-2">
                    <label class="text-[11px] font-medium tracking-[0.8px] uppercase text-[#4A5468]">Email</label>
                    <div class="relative">
                        <i class="fa-regular fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-[#4A5468] text-sm pointer-events-none transition-colors duration-300"></i>
                        <input type="email" name="email" placeholder="you@enaa.edu" required
                               class="focus-in w-full bg-white/[.035] border border-white/[.07] rounded-xl py-3.5 pl-11 pr-4 text-sm text-[#F0F4FF] placeholder-[#4A5468] font-light outline-none transition-all duration-300">
                    </div>
                </div>

                <!-- Password -->
                <div class="flex flex-col gap-2">
                    <label class="text-[11px] font-medium tracking-[0.8px] uppercase text-[#4A5468]">Password</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-[#4A5468] text-sm pointer-events-none transition-colors duration-300"></i>
                        <input type="password" name="password" placeholder="••••••••" required
                               class="focus-in w-full bg-white/[.035] border border-white/[.07] rounded-xl py-3.5 pl-11 pr-4 text-sm text-[#F0F4FF] placeholder-[#4A5468] font-light outline-none transition-all duration-300">
                    </div>
                </div>

                <!-- Options -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" class="w-4 h-4 accent-blue-600 cursor-pointer">
                        <span class="text-[13px] font-light text-[#8A96B0]">Remember me</span>
                    </label>
                    <a href="#" class="text-[13px] text-blue-400 hover:text-blue-300 transition-colors duration-200">Forgot password?</a>
                </div>

                <!-- Submit -->
                <button type="submit" name="login"
                        class="btn-submit relative w-full py-[15px] rounded-xl bg-[#2563EB] hover:bg-[#1d4ed8] text-white text-[15px] font-medium overflow-hidden transition-all duration-200 hover:-translate-y-px active:translate-y-0"
                        style="box-shadow:0 4px 20px rgba(37,99,235,.35),inset 0 1px 0 rgba(255,255,255,.15)">
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        Sign In <i class="fa-solid fa-arrow-right"></i>
                    </span>
                </button>

            </form>

            <!-- Divider -->
            <div class="flex items-center gap-3 mt-7 mb-4">
                <div class="flex-1 h-px bg-white/[.07]"></div>
                <span class="text-[11px] font-medium tracking-[1px] uppercase text-[#4A5468]">Access Dashboard</span>
                <div class="flex-1 h-px bg-white/[.07]"></div>
            </div>

            <!-- Role buttons -->

        </div>

        <!-- ══ RIGHT ══ -->
        

</body>
</html>