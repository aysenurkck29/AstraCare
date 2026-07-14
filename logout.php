<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="tr" class="dark">
<head>
    <meta charset="utf-8"/><title>AstraCare // Bağlantı Kesildi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet"/>
</head>
<body class="bg-[#0b1120] text-white min-h-screen flex items-center justify-center font-mono">
    <div class="text-center space-y-6 max-w-sm p-6">
        <span class="text-4xl block text-rose-500 animate-pulse">🔒</span>
        <div>
            <h1 class="text-xl font-bold tracking-wider">BAĞLANTI GÜVENLİ</h1>
            <p class="text-xs text-slate-500 mt-2">Tüm şifreli medikal telemetri verileri yerel bellekten temizlendi ve oturum sonlandırıldı.</p>
        </div>
        <a href="index.php" class="px-5 py-2.5 bg-slate-900 border border-slate-800 hover:bg-slate-800 rounded-xl text-xs font-bold block transition-all">
            Terminali Yeniden Başlat
        </a>
    </div>
</body>
</html>