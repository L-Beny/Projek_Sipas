<?php
session_start();
if(isset($_SESSION['status']) && $_SESSION['status'] == "login"){
    // Sinkronkan localStorage dengan Session PHP sebelum mengarahkan halaman
    echo "<script>
            localStorage.setItem('sipas_auth', 'true');
            window.location.href = '../jadwal_angkut/index.html';
          </script>";
    exit;
}

// Logika Splash Screen: Hanya muncul jika tidak ada error/logout
$showSplash = !isset($_GET['pesan']); 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SI-PAS - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../js/tailwind-config.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    
    <style>
        /* === ANIMASI SPLASH SCREEN (Seperti Video) === */
        #splash-screen {
            position: fixed; inset: 0; z-index: 9999;
            background-color: #022c22; /* Warna latar gelap (emerald-950) */
            display: flex; flex-direction: column; justify-content: center; align-items: center;
            transition: opacity 0.8s ease-in-out, visibility 0.8s;
        }
        .splash-hidden {
            opacity: 0; visibility: hidden;
        }
        
        /* Efek garis gambar SVG berseri */
        .draw-path {
            stroke-dasharray: 200; stroke-dashoffset: 200;
            animation: draw 1.2s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
        .draw-path-2 {
            stroke-dasharray: 200; stroke-dashoffset: 200;
            animation: draw 1.2s 0.4s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
        .draw-path-3 {
            stroke-dasharray: 200; stroke-dashoffset: 200;
            animation: draw 1.2s 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
        @keyframes draw { to { stroke-dashoffset: 0; } }

        /* Teks SI-PAS Fade In dari bawah */
        .logo-text {
            opacity: 0; transform: translateY(15px);
            animation: fadeInUp 0.8s 1.2s forwards;
        }
        @keyframes fadeInUp {
            to { opacity: 1; transform: translateY(0); }
        }

        /* === ANIMASI FORM LOGIN MASUK === */
        .login-container-hidden {
            opacity: 0; transform: translateY(40px) scale(0.95);
        }
        .login-container-active {
            opacity: 1; transform: translateY(0) scale(1);
            transition: all 1s cubic-bezier(0.16, 1, 0.3, 1);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased overflow-hidden h-screen flex flex-col">

    <?php if($showSplash): ?>
    <!-- LAPISAN SPLASH SCREEN (Animasi Awal) -->
    <div id="splash-screen">
        <svg class="w-24 h-24 text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <!-- Shape Kotak 3D / Hexagon mirip di video -->
            <path class="draw-path" d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
            <polyline class="draw-path-2" points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
            <line class="draw-path-3" x1="12" y1="22.08" x2="12" y2="12"></line>
        </svg>
        <h1 class="logo-text text-white font-bold text-4xl mt-6 tracking-wider">SI-PAS</h1>
        <p class="logo-text text-emerald-500/70 text-sm mt-2 font-medium uppercase tracking-[0.2em]">Memuat Sistem</p>
    </div>
    <?php endif; ?>

    <!-- LAYAR UTAMA (Background Belakang) -->
    <div id="login-view" class="absolute inset-0 z-50 flex items-center justify-center bg-gradient-to-br from-emerald-700 to-teal-900 p-4">
        
        <!-- CARD LOGIN -->
        <div id="login-card" class="max-w-md w-full bg-white rounded-3xl shadow-2xl p-8 relative overflow-hidden <?php echo $showSplash ? 'login-container-hidden' : 'login-container-active'; ?>">
            <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-emerald-50 opacity-50 pointer-events-none"></div>
            
            <div class="text-center mb-8 relative z-10">
                <div class="mx-auto w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mb-4 shadow-sm border border-emerald-200">
                    <i data-lucide="recycle" class="w-8 h-8"></i>
                </div>
                <h1 class="text-2xl font-bold text-slate-800">Masuk ke SI-PAS</h1>
                <p class="text-sm text-slate-500 mt-1">Sistem Pengelolaan Sampah Masyarakat</p>
            </div>

            <?php
            if(isset($_GET['pesan'])){
                if($_GET['pesan'] == "gagal"){
                    echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4 text-sm text-center font-medium'>Username atau Password salah!</div>";
                } else if($_GET['pesan'] == "logout"){
                    echo "<div class='bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-xl mb-4 text-sm text-center font-medium'>Anda telah berhasil logout.</div>";
                }
            }
            ?>

            <form action="proses_login.php" method="POST" class="space-y-5 relative z-10">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1" for="username">Username</label>
                    <div class="relative">
                        <i data-lucide="user" class="absolute left-3 top-3 w-5 h-5 text-slate-400"></i>
                        <input type="text" id="username" name="username" class="w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition" placeholder="Masukkan username" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1" for="password">Password</label>
                    <div class="relative">
                        <i data-lucide="lock" class="absolute left-3 top-3 w-5 h-5 text-slate-400"></i>
                        <input type="password" id="password" name="password" class="w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition" placeholder="Masukkan password" required>
                    </div>
                </div>
                <div class="pt-2">
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 rounded-xl shadow-lg shadow-emerald-200 transition duration-200 flex justify-center items-center gap-2">
                        Masuk Aplikasi <i data-lucide="log-in" class="w-4 h-4"></i>
                    </button>
                </div>
            </form>
            
            <div class="mt-6 p-4 bg-amber-50 rounded-xl border border-amber-200 text-center">
                <p class="text-xs text-amber-700 font-medium">Database MySQL Aktif</p>
                <p class="text-xs text-amber-600">User: <b>warga</b> | Pass: <b>123456</b></p>
            </div>
        </div>
    </div>
    
    <script>
        lucide.createIcons();
        
        <?php if($showSplash): ?>
        // --- JAVASCRIPT UNTUK TRIGGER ANIMASI ---
        window.addEventListener('DOMContentLoaded', () => {
            // Tunggu animasi garis SVG dan teks selesai (sekitar 3 detik)
            setTimeout(() => {
                const splash = document.getElementById('splash-screen');
                const loginCard = document.getElementById('login-card');
                
                // 1. Pudarkan dan hilangkan latar gelap splash screen
                splash.classList.add('splash-hidden');
                
                // 2. Munculkan form login dengan efek melayang dari bawah
                setTimeout(() => {
                    loginCard.classList.remove('login-container-hidden');
                    loginCard.classList.add('login-container-active');
                }, 200); // Sedikit jeda agar terlihat estetik
                
            }, 3000); 
        });
        <?php endif; ?>
    </script>
</body>
</html>