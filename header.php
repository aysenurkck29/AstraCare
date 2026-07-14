<?php
require_once 'config.php';

// Tema Değiştirme Yakalayıcı
if (isset($_GET['action']) && $_GET['action'] == 'toggle_theme') {
    $_SESSION['theme'] = ($_SESSION['theme'] == 'dark') ? 'light' : 'dark';
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit;
}

$theme = $_SESSION['theme'];
$active_planet = $_SESSION['selected_planet'];
$active_crew_id = $_SESSION['selected_crew'];
$p_info = $planet_db[$active_planet];
$crew_data = $p_info['crew'][$active_crew_id] ?? reset($p_info['crew']);

// Kritik Biyometrik Alarm Durumu
$is_critical = ($crew_data['hr'] > 120 || $crew_data['o2'] < 90);
?>
<!DOCTYPE html>
<html lang="tr" class="<?php echo $theme; ?>">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>AstraCare Kontrol Merkezi v4.0</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-container-low": "#eff4ff",
                        "primary-fixed": "#acedff",
                        "on-secondary-fixed-variant": "#3f465c",
                        "surface-variant": "#d3e4fe",
                        "on-background": "#0b1c30",
                        "on-tertiary-container": "#7e000f",
                        "primary-container": "#06b6d4",
                        "on-secondary-container": "#5c647a",
                        "outline": "#6d797d",
                        "inverse-surface": "#213145",
                        "tertiary": "#b91a24",
                        "on-tertiary-fixed-variant": "#930013",
                        "on-tertiary-fixed": "#410004",
                        "surface-bright": "#f8f9ff",
                        "on-surface-variant": "#3d494c",
                        "surface": "#f8f9ff",
                        "surface-container": "#e5eeff",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-highest": "#d3e4fe",
                        "outline-variant": "#bcc9cd",
                        "surface-tint": "#00687a",
                        "background": "#f8f9ff",
                        "on-primary": "#ffffff",
                        "on-tertiary": "#ffffff",
                        "inverse-primary": "#4cd7f6",
                        "primary": "#00687a",
                        "on-error-container": "#93000a",
                        "tertiary-fixed": "#ffdad7",
                        "secondary-container": "#dae2fd",
                        "on-secondary": "#ffffff",
                        "error": "#ba1a1a",
                        "error-container": "#ffdad6",
                        "primary-fixed-dim": "#4cd7f6",
                        "on-primary-fixed": "#001f26",
                        "secondary-fixed": "#dae2fd",
                        "secondary-fixed-dim": "#bec6e0",
                        "secondary": "#565e74",
                        "tertiary-container": "#ff817a",
                        "on-primary-container": "#00424f",
                        "on-error": "#ffffff",
                        "tertiary-fixed-dim": "#ffb3ad",
                        "on-surface": "#0b1c30",
                        "surface-dim": "#cbdbf5",
                        "on-primary-fixed-variant": "#004e5c",
                        "on-secondary-fixed": "#131b2e",
                        "surface-container-high": "#dce9ff",
                        "inverse-on-surface": "#eaf1ff"
                    },
                    "spacing": {
                        "margin-mobile": "16px",
                        "margin-desktop": "40px",
                        "gutter": "16px",
                        "container-padding": "24px",
                        "lg": "24px", "xl": "40px", "sm": "8px", "md": "16px"
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .dark body { background-color: #0d1322; color: #dde2f8; }
        .light body { background-color: #f8f9ff; color: #0b1c30; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .light .glass-panel {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
            border: 1px solid #e2e8f0;
        }
        .planet-glow-mars { filter: drop-shadow(0 0 30px rgba(255, 129, 122, 0.4)); }
        .planet-glow-titan { filter: drop-shadow(0 0 30px rgba(188, 199, 222, 0.4)); }
        .planet-glow-moon { filter: drop-shadow(0 0 30px rgba(76, 215, 246, 0.4)); }
        .animate-pulse-glow { animation: pulse-glow 3s ease-in-out infinite; }
        @keyframes pulse-glow {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.03); opacity: 0.8; }
        }
        .scanline {
            width: 100%; height: 4px; z-index: 10;
            background: linear-gradient(to right, transparent, #4cd7f6, transparent);
            position: absolute; top: 0; left: 0; animation: scan 4s linear infinite;
        }
        @keyframes scan { 0% { top: 0%; opacity: 0; } 50% { opacity: 1; } 100% { top: 100%; opacity: 0; } }
    </style>
</head>
<body class="min-h-screen flex flex-col overflow-x-hidden">

<?php if (isset($_SESSION['authenticated'])): ?>
<header class="fixed top-0 z-50 w-full bg-surface/10 dark:bg-surface-dim/10 backdrop-blur-xl border-b border-outline-variant/20 px-6 md:px-10 py-4 flex justify-between items-center shadow-[0_0_20px_rgba(76,215,246,0.15)]">
    <div class="flex items-center gap-4">
        <a href="planet_select.php" class="font-display-lg text-2xl font-bold tracking-tighter text-primary dark:text-primary-fixed">AstraCare</a>
    </div>
    
    <div class="hidden md:flex items-center gap-8">
        <a class="<?php echo basename($_SERVER['PHP_SELF'])=='planet_select.php'?'text-primary border-b-2 border-primary':'text-on-surface-variant'; ?> font-bold py-1" href="planet_select.php">Lokasyonlar</a>
        <a class="<?php echo basename($_SERVER['PHP_SELF'])=='crew_select.php'?'text-primary border-b-2 border-primary':'text-on-surface-variant'; ?> font-bold py-1" href="crew_select.php">Mürettebat</a>
        <a class="<?php echo basename($_SERVER['PHP_SELF'])=='dashboard.php'?'text-primary border-b-2 border-primary':'text-on-surface-variant'; ?> font-bold py-1" href="dashboard.php">Tıbbi Panel</a>
    </div>

    <div class="flex items-center gap-4">
        <a href="?action=toggle_theme" class="material-symbols-outlined text-on-surface-variant hover:bg-primary-container/20 p-2 rounded-full transition-all">
            <?php echo $theme == 'dark' ? 'light_mode' : 'dark_mode'; ?>
        </a>
        <span class="material-symbols-outlined text-primary relative">notifications_active
            <?php if($is_critical): ?><span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span><?php endif; ?>
        </span>
        <div class="flex items-center gap-3 cursor-pointer group">
            <div class="text-right hidden sm:block">
                <p class="text-xs font-bold font-mono">DR. SELİN YILMAZ</p>
                <p class="text-[10px] text-on-surface-variant font-mono uppercase">MEDIKAL SUBAY</p>
            </div>
            <img class="w-10 h-10 rounded-full border-2 border-primary object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCQ18q5QaCEkTrNKAAvNrrWmv7742J1G54oq4aKICIJqyEA3o8-z3XT4XlB7eIciN5FXOJUjjoO0UYSsKkR0hUjYcaBbINB4GrofOe5HngdLz8_RB5Otn7_19FAw5hvrzlPDTPtRNBZoXVfw9fqEA87A6m9xoM-__vuj467uCvdJmaBXcudoRQYzUC26ZM3o7sCL2XkULNF3L2DFTbdHW-g7fxGPfJn7Fizq_8xhJmKGu24HnGnYKYyYmqhZvD5dmpNaTuaBb0rM8Uz"/>
        </div>
    </div>
</header>

<div class="flex flex-grow pt-20">
    <aside class="hidden md:flex flex-col w-64 fixed left-0 top-20 bottom-0 bg-surface-container-low/30 dark:bg-surface-container-lowest/30 backdrop-blur-2xl border-r border-outline-variant/10 shadow-2xl py-8 z-40">
        <div class="px-6 mb-6">
            <div class="font-headline-lg text-lg font-bold text-primary uppercase font-mono"><?php echo $p_info['name']; ?></div>
            <div class="font-label-sm text-xs text-on-surface-variant mt-1">Sinyal Derecesi: Kararlı</div>
        </div>
        
        <nav class="flex-grow space-y-1">
            <a href="dashboard.php" class="flex items-center gap-3 px-6 py-4 transition-all <?php echo basename($_SERVER['PHP_SELF'])=='dashboard.php'?'bg-primary/20 text-primary border-r-4 border-primary':'text-on-surface-variant hover:bg-surface-variant/20 hover:text-primary'; ?>">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="text-xs font-bold font-mono uppercase">Kontrol Paneli</span>
            </a>
            <a href="crew_select.php" class="flex items-center gap-3 px-6 py-4 transition-all <?php echo basename($_SERVER['PHP_SELF'])=='crew_select.php'?'bg-primary/20 text-primary border-r-4 border-primary':'text-on-surface-variant hover:bg-surface-variant/20 hover:text-primary'; ?>">
                <span class="material-symbols-outlined">groups</span>
                <span class="text-xs font-bold font-mono uppercase">Mürettebat İzleme</span>
            </a>
            <a href="ai_detail.php" class="flex items-center gap-3 px-6 py-4 transition-all <?php echo basename($_SERVER['PHP_SELF'])=='ai_detail.php'?'bg-primary/20 text-primary border-r-4 border-primary':'text-on-surface-variant hover:bg-surface-variant/20 hover:text-primary'; ?>">
                <span class="material-symbols-outlined">psychology</span>
                <span class="text-xs font-bold font-mono uppercase">AI Detay Raporu</span>
            </a>
        </nav>

        <div class="px-6 mt-auto space-y-4">
            <a href="emergency_alert.php" class="w-full py-3 bg-red-600 text-white font-bold font-mono text-xs rounded-lg flex items-center justify-center gap-2 shadow-lg shadow-red-600/20 hover:bg-red-700 transition-all text-center">
                <span class="material-symbols-outlined text-sm">emergency</span> ACİL PROTOKOLÜ
            </a>
            
            <div class="pt-4 border-t border-outline-variant/10 flex flex-col gap-2">
                <a href="#" class="flex items-center gap-3 text-on-surface-variant px-2 py-2 hover:text-primary transition-colors cursor-pointer text-sm">
                    <span class="material-symbols-outlined text-sm">settings</span>
                    <span class="font-bold">Ayarlar</span>
                </a>
                <a href="logout.php" class="flex items-center gap-3 text-on-surface-variant px-2 py-2 hover:text-red-500 transition-colors cursor-pointer text-sm">
                    <span class="material-symbols-outlined text-sm text-red-500">logout</span>
                    <span class="font-bold text-red-500">Oturumu Kapat</span>
                </a>
            </div>
        </div>
    </aside>
    <div class="flex-1 md:ml-64 p-6 overflow-y-auto">
<?php endif; ?>