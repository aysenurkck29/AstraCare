<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="tr" class="dark">
<head>
    <meta charset="utf-8"/><title>AstraCare | KORDON ALARMI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@700&display=swap" rel="stylesheet"/>
</head>
<body class="bg-red-950 text-white min-h-screen flex items-center justify-center p-4 font-mono select-none">
    <div class="w-full max-w-xl bg-slate-950/90 border-2 border-red-500 rounded-2xl p-8 text-center space-y-6 shadow-[0_0_50px_rgba(239,68,68,0.4)] animate-pulse">
        <span class="text-5xl block animate-bounce">🚨</span>
        <h1 class="text-2xl font-bold tracking-widest text-red-500">MANUEL ACİL DURUM ETKİN</h1>
        <p class="text-xs text-slate-400 max-w-sm mx-auto">Yaşam destek sistemleri ve istasyon kalkanı acil durum moduna geçirildi. Tüm kabin basınç valfleri manuel kontrole devredilmiştir.</p>
        
        <div class="pt-4">
            <a href="dashboard.php" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition-all shadow-md inline-block">
                PROTOKOLÜ SONLANDIR VE DÖN
            </a>
        </div>
    </div>
</body>
</html>