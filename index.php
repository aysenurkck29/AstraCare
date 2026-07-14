<?php
require_once 'config.php';

// Ziyaretçiye animasyonlu Splash ekranını sadece bir kez göstermek için:
if (!isset($_SESSION['splash_triggered'])) {
    $_SESSION['splash_triggered'] = true;
    header("refresh:2;url=index.php");
    ?>
    <!DOCTYPE html>
    <html lang="tr" class="dark">
    <head>
        <meta charset="utf-8"/><title>AstraCare // Başlatılıyor</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@600;700&family=JetBrains+Mono&display=swap" rel="stylesheet"/>
    </head>
    <body class="bg-[#0d1322] text-[#dde2f8] min-h-screen flex items-center justify-center font-mono">
        <div class="text-center space-y-4">
            <div class="relative w-24 h-24 mx-auto mb-6 flex items-center justify-center">
                <div class="absolute inset-0 border-4 border-cyan-500/20 border-t-cyan-500 rounded-full animate-spin"></div>
                <span class="text-cyan-400 text-3xl">🛰️</span>
            </div>
            <h1 class="text-3xl font-bold tracking-widest text-slate-100">ASTRA<span class="text-cyan-400">CARE</span></h1>
            <p class="text-xs text-slate-500 tracking-[0.2em]">DEEP SPACE LIFESUPPORT NET INITIALIZING...</p>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// Güvenli Form Giriş Kontrolü
$login_error = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mission_id = $_POST['mission_id'] ?? '';
    $biometric_key = $_POST['biometric_key'] ?? '';
    
    if ($biometric_key === SYSTEM_PASSWORD) {
        $_SESSION['authenticated'] = true;
        header("Location: planet_select.php");
        exit;
    } else {
        $login_error = true;
    }
}
?>
<!DOCTYPE html>
<html lang="tr" class="dark">
<head>
    <meta charset="utf-8"/><title>AstraCare | Güvenli Giriş</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=JetBrains+Mono&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        body { background-color: #0d1322; color: #dde2f8; font-family: 'Inter', sans-serif; }
        .glass-panel { background: rgba(21, 27, 43, 0.6); backdrop-filter: blur(24px); border: 0.5px solid rgba(255, 255, 255, 0.1); }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between">
    <div class="fixed inset-0 pointer-events-none opacity-40 bg-[radial-gradient(circle_at_50%_50%,rgba(6,182,212,0.1)_0%,transparent_70%)]"></div>
    
    <main class="flex-grow flex items-center justify-center px-4">
        <div class="glass-panel w-full max-w-[430px] rounded-2xl p-8 md:p-10 shadow-2xl relative border-t-2 border-cyan-500/30">
            <div class="text-center mb-8">
                <span class="material-symbols-outlined text-4xl text-cyan-400 drop-shadow-[0_0_10px_rgba(6,182,212,0.4)]">shield_heart</span>
                <h1 class="text-2xl font-bold tracking-tight text-white mt-2">AstraCare Terminal</h1>
                <p class="text-xs text-slate-400 font-mono tracking-wider mt-1">DERİN UZAY MEDİKAL SİSTEMLERİ</p>
            </div>

            <form method="POST" class="space-y-5">
                <div class="space-y-1.5">
                    <label class="font-mono text-[11px] text-cyan-400 block tracking-wider">GÖREV KİMLİĞİ (MISSION ID)</label>
                    <input type="text" name="mission_id" required value="MS-2165-CONTROL" class="w-full bg-slate-900/50 border border-slate-700 rounded-xl py-3 px-4 text-sm font-mono focus:ring-2 focus:ring-cyan-500/40 focus:outline-none text-white">
                </div>

                <div class="space-y-1.5">
                    <label class="font-mono text-[11px] text-cyan-400 block tracking-wider">BİYOMETRİK ANAHTAR / ŞİFRE</label>
                    <input type="password" name="biometric_key" required placeholder="••••••••••••" class="w-full bg-slate-900/50 border border-slate-700 rounded-xl py-3 px-4 text-sm font-mono focus:ring-2 focus:ring-cyan-500/40 focus:outline-none text-white tracking-widest">
                    <p class="text-[10px] text-slate-500 font-mono">Erişim Şifresi: <span class="underline">mars2165</span></p>
                </div>

                <?php if ($login_error): ?>
                    <div class="p-3 bg-red-500/10 border border-red-500/20 rounded-xl text-xs text-red-400 font-mono flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">error</span> Şifre Geçersiz. İstasyon Reddedildi.
                    </div>
                <?php endif; ?>

                <button type="submit" class="w-full bg-cyan-600 hover:bg-cyan-500 text-white font-bold py-3.5 rounded-xl font-mono text-xs uppercase tracking-widest shadow-lg shadow-cyan-600/20 active:scale-98 transition-all">
                    Sistem Bağlantısını Tetikle
                </button>
            </form>
        </div>
    </main>

    <footer class="w-full p-6 flex justify-between items-center text-slate-500 font-mono text-[10px] border-t border-slate-900">
        <span>GÜVENLİ BAĞLANTI: AES-256-GCM</span>
        <span>© 2026 AstraCare Systems</span>
    </footer>
</body>
</html>