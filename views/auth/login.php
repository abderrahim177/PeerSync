<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PeerSync - Login</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        .float {
            animation: float 3s ease-in-out infinite;
        }

        .float.delay-1 {
            animation-delay: 0.5s;
        }

        .float.delay-2 {
            animation-delay: 1s;
        }
    </style>
</head>

<body class="min-h-screen bg-gray-900 flex items-center justify-center p-6">

    <!-- MAIN CONTAINER -->
    <div class="w-full max-w-6xl grid md:grid-cols-2 overflow-hidden rounded-2xl border border-white/10 shadow-2xl">

        <!-- LEFT SIDE -->
        <div class="bg-gray-800 p-10 md:p-14">

            <!-- LOGO -->
            <div class="flex items-center gap-3 mb-10">
                <div class="w-10 h-10 rounded-xl bg-[#2563EB] flex items-center justify-center text-white">
                    <i class="fa-solid fa-building-columns"></i>
                </div>
                <h1 class="text-white text-xl font-semibold">PeerSync</h1>
            </div>

            <!-- TITLE -->
            <h2 class="text-white text-3xl font-bold mb-2">Welcome back</h2>
            <p class="text-gray-400 mb-8">Sign in to continue to your dashboard</p>

            <!-- FORM (PHP READY) -->
            <form action="login-process.php" method="POST" class="space-y-5">

                <!-- EMAIL -->
                <div>
                    <label class="text-gray-300 text-sm">Email</label>
                    <input type="email" name="email"
                        class="w-full mt-2 p-3 rounded-xl bg-[#111C33]
                border border-white/10 text-white
                focus:border-[#2563EB] outline-none transition"
                        placeholder="you@enaa.edu" required>
                </div>

                <!-- PASSWORD -->
                <div>
                    <label class="text-gray-300 text-sm">Password</label>
                    <input type="password" name="password"
                        class="w-full mt-2 p-3 rounded-xl bg-[#111C33]
                border border-white/10 text-white
                focus:border-[#2563EB] outline-none transition"
                        placeholder="••••••••" required>
                </div>

                <!-- OPTIONS -->
                <div class="flex items-center justify-between text-sm">

                    <label class="flex items-center gap-2 cursor-pointer select-none group">
                        <input type="checkbox"
                            class="w-4 h-4 accent-blue-600 rounded border-gray-600">

                        <span class="text-gray-400 group-hover:text-white transition">
                            Remember me
                        </span>
                    </label>

                    <a href="#"
                        class="text-blue-400 hover:text-blue-300 transition font-medium">
                        Forgot password?
                    </a>

                </div>

                <!-- BUTTON -->
                <button type="submit" name="login"
                    class="w-full py-3 rounded-xl bg-[#2563EB]
            hover:bg-[#1d4ed8] transition text-white font-semibold">
                    Sign In <i class="fa-solid fa-arrow-right"></i>
                </button>

            </form>

            <!-- ROLE BUTTONS -->
            <div class="mt-8 space-y-3">

                <button class="group w-full flex items-center gap-3 px-5 py-3 rounded-xl
                       border border-white/10 bg-white/0
                       hover:bg-white/5 hover:border-white/20
                       transition-all duration-300 hover:-translate-x-1">

                    <i class="fa-solid fa-graduation-cap text-white"></i>
                    <span class="text-gray-300 group-hover:text-blue-400 font-medium transition">
                        Student Dashboard
                    </span>

                </button>

                <button class="group w-full flex items-center gap-3 px-5 py-3 rounded-xl
                       border border-white/10 bg-white/0
                       hover:bg-white/5 hover:border-white/20
                       transition-all duration-300 hover:-translate-x-1">

                    <i class="fa-solid fa-chalkboard-user text-white"></i>
                    <span class="text-gray-300 group-hover:text-blue-400 font-medium transition">
                        Tutor Dashboard
                    </span>

                </button>

            </div>

        </div>

        <!-- RIGHT SIDE -->
        <div class="relative bg-gradient-to-br from-[#2563EB] to-[#1e40af]
            p-10 flex flex-col justify-center items-center rounded-r-2xl">

            <!-- GLOW -->
            <div class="absolute w-[320px] h-[320px] bg-white/10 blur-3xl rounded-full
                top-[-120px] right-[-120px]"></div>

            <!-- FLOATING CARDS -->
            <div class="space-y-5 mb-10 z-10 w-full flex flex-col items-center">

                <div class="float w-[300px] flex items-center gap-4 p-4 rounded-2xl
                    bg-white/10 backdrop-blur-xl border border-white/20
                    hover:scale-[1.03] transition">
                    <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center">
                        📘
                    </div>
                    <span class="text-white font-medium text-lg">Learn Together</span>
                </div>

                <div class="float delay-1 w-[300px] flex items-center gap-4 p-4 rounded-2xl
                    bg-white/10 backdrop-blur-xl border border-white/20
                    hover:scale-[1.03] transition">
                    <div class="w-12 h-12 rounded-xl bg-cyan-400/20 flex items-center justify-center">
                        👥
                    </div>
                    <span class="text-white font-medium text-lg">Peer Support</span>
                </div>

                <div class="float delay-2 w-[300px] flex items-center gap-4 p-4 rounded-2xl
                    bg-white/10 backdrop-blur-xl border border-white/20
                    hover:scale-[1.03] transition">
                    <div class="w-12 h-12 rounded-xl bg-indigo-400/20 flex items-center justify-center">
                        ⭐
                    </div>
                    <span class="text-white font-medium text-lg">Grow Skills</span>
                </div>

            </div>

            <!-- TEXT -->
            <div class="text-center z-10">
                <h2 class="text-white text-3xl font-bold mb-2">
                    Connect. Learn. Succeed.
                </h2>
                <p class="text-blue-100 text-sm">
                    Peer learning platform for ENAA students
                </p>
            </div>

        </div>

    </div>

</body>

</html>