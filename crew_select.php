<?php
require_once 'config.php';

// Kullanıcı bağlantı doğrulaması (Güvenlik Duvarı)
if (!isset($_SESSION['authenticated'])) {
    header("Location: index.php");
    exit;
}

// URL üzerinden bir astronot seçildiyse hafızaya al ve Tıbbi Panel'e (dashboard) fırlat
if (isset($_GET['select_crew'])) {
    $target_planet = $_SESSION['selected_planet'];
    if (array_key_exists($_GET['select_crew'], $planet_db[$target_planet]['crew'])) {
        $_SESSION['selected_crew'] = $_GET['select_crew'];
        header("Location: dashboard.php");
        exit;
    }
}

require_once 'header.php';
?>

<header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
    <div>
        <h1 class="font-headline-lg text-3xl font-bold text-primary tracking-tight">Mürettebat İzleme</h1>
        <p class="text-on-surface-variant/80 font-data-mono text-xs uppercase mt-1">
            Hedef İstasyon: <?php echo strtoupper($p_info['name']); ?> // Gecikme: <?php echo $p_info['latency']; ?>
        </p>
    </div>
    <div class="relative w-full md:w-96 group">
        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-primary/60">search</span>
        <input class="w-full pl-12 pr-4 py-3 bg-surface-container-low/50 border border-outline-variant/30 rounded-xl focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all placeholder:text-on-surface-variant/50 text-sm text-slate-900 dark:text-white" placeholder="Mürettebat üyesi ara..." type="text"/>
    </div>
</header>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter max-w-7xl mx-auto">
    
    <?php 
    $crew_counter = 0;
    foreach ($p_info['crew'] as $id => $c): 
        $crew_counter++;
        $c_critical = ($c['hr'] > 120 || $c['o2'] < 90);
        
        // Dinamik Profil Fotoğrafı Üretici (AstraCare Renkleriyle)
        $avatar_url = "https://ui-avatars.com/api/?name=" . urlencode($c['name']) . "&background=0d1322&color=4cd7f6&size=256&bold=true";
        
        if ($crew_counter === 1):
    ?>
        <div class="lg:col-span-8 group">
            <div class="glass-panel rounded-2xl p-8 flex flex-col md:flex-row gap-8 relative overflow-hidden transition-all duration-300 hover:shadow-[0_0_30px_rgba(76,215,246,0.1)] <?php echo $c_critical ? 'border-red-500/30 bg-red-500/5' : ''; ?>">
                <div class="relative shrink-0">
                    <div class="w-48 h-48 rounded-2xl overflow-hidden border-2 <?php echo $c_critical ? 'border-red-500/40' : 'border-primary/30'; ?> bg-slate-100 dark:bg-slate-900">
                        <img class="w-full h-full object-cover" src="<?php echo $avatar_url; ?>" alt="<?php echo $c['name']; ?>"/>
                    </div>
                    <div class="absolute -bottom-3 -right-3 w-12 h-12 rounded-full bg-white dark:bg-slate-900 border-4 border-slate-100 dark:border-slate-950 flex items-center justify-center text-primary <?php echo $c_critical ? 'pulse-kritik text-red-500' : 'pulse-stabil'; ?>">
                        <span class="material-symbols-outlined"><?php echo $c_critical ? 'warning' : 'verified'; ?></span>
                    </div>
                </div>
                <div class="flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span class="font-data-mono text-[10px] text-primary bg-primary/10 px-3 py-1 rounded-full uppercase tracking-widest"><?php echo $c['role']; ?></span>
                                <h3 class="font-headline-lg text-2xl font-bold text-slate-900 dark:text-white mt-2"><?php echo $c['name']; ?></h3>
                            </div>
                            <div class="flex items-center gap-2 <?php echo $c_critical ? 'bg-red-500/10 text-red-600 dark:text-red-400 border border-red-500/20' : 'bg-green-500/10 text-green-700 dark:text-green-400 border border-green-500/20'; ?> px-4 py-1.5 rounded-lg">
                                <span class="w-2 h-2 rounded-full <?php echo $c_critical ? 'bg-red-500 animate-pulse' : 'bg-green-500 animate-pulse'; ?>"></span>
                                <span class="text-xs font-mono font-bold"><?php echo $c['status']; ?></span>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-4 mb-6">
                            <div class="p-3 bg-slate-100 dark:bg-slate-900/40 rounded-xl border border-outline-variant/10">
                                <p class="text-[10px] text-slate-500 dark:text-on-surface-variant mb-1 font-mono uppercase">Nabız</p>
                                <p class="font-data-mono text-base font-bold text-slate-900 dark:text-white"><?php echo $c['hr']; ?> <span class="text-[10px] font-normal opacity-50">bpm</span></p>
                            </div>
                            <div class="p-3 bg-slate-100 dark:bg-slate-900/40 rounded-xl border border-outline-variant/10">
                                <p class="text-[10px] text-slate-500 dark:text-on-surface-variant mb-1 font-mono uppercase">Oksijen</p>
                                <p class="font-data-mono text-base font-bold text-slate-900 dark:text-white">%<?php echo $c['o2']; ?></p>
                            </div>
                            <div class="p-3 bg-slate-100 dark:bg-slate-900/40 rounded-xl border border-outline-variant/10">
                                <p class="text-[10px] text-slate-500 dark:text-on-surface-variant mb-1 font-mono uppercase">Stres</p>
                                <p class="font-data-mono text-base font-bold text-slate-900 dark:text-white"><?php echo $c['stress']; ?></p>
                            </div>
                        </div>
                    </div>
                    <a href="?select_crew=<?php echo $id; ?>" class="w-full py-2.5 bg-primary text-white text-xs font-bold font-mono text-center rounded-lg border border-primary/20 transition-all hover:brightness-110 block">
                        DETAYLI ANALİZİ GÖRÜNTÜLE
                    </a>
                </div>
            </div>
        </div>

        <div class="lg:col-span-4 h-full">
            <div class="border-gradient-ai rounded-2xl p-6 h-full flex flex-col justify-between min-h-[250px] bg-white dark:bg-transparent">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="material-symbols-outlined text-tertiary">psychology</span>
                        <h4 class="font-label-sm text-xs font-bold text-tertiary uppercase tracking-widest font-mono">AI Filo Tahmini</h4>
                    </div>
                    <p class="text-sm leading-relaxed mb-6 text-slate-700 dark:text-white opacity-80">
                        Mevcut sinyal hatlarındaki biyometrik telemetri paketleri analiz edilmiştir. İstasyon genel sağlık indeksi kararlılık limitleri içerisindedir.
                    </p>
                </div>
                <div class="space-y-3">
                    <div class="h-1 w-full bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full bg-primary w-[94%] shadow-[0_0_8px_#4cd7f6]"></div>
                    </div>
                    <div class="flex justify-between font-data-mono text-[10px] text-slate-600 dark:text-on-surface-variant uppercase">
                        <span>Sistem Güven Endeksi</span>
                        <span class="text-primary font-bold">94% Optimal</span>
                    </div>
                </div>
            </div>
        </div>

        <?php else: ?>
        
        <div class="lg:col-span-4 group">
            <div class="glass-panel rounded-2xl p-6 transition-all duration-300 border <?php echo $c_critical ? 'border-red-500/30 bg-red-500/5' : 'border-outline-variant/10'; ?> hover:border-primary/30 flex flex-col justify-between min-h-[220px]">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 rounded-xl overflow-hidden border <?php echo $c_critical ? 'border-red-500/40' : 'border-outline-variant'; ?> flex items-center justify-center bg-slate-100 dark:bg-slate-900 text-2xl">
                        <img class="w-full h-full object-cover" src="<?php echo $avatar_url; ?>" alt="<?php echo $c['name']; ?>"/>
                    </div>
                    <div>
                        <span class="font-data-mono text-[10px] text-primary/80 uppercase block"><?php echo $c['role']; ?></span>
                        <h3 class="font-bold text-slate-900 dark:text-white text-base mt-0.5"><?php echo $c['name']; ?></h3>
                        <div class="flex items-center gap-1 mt-1">
                            <span class="w-1.5 h-1.5 rounded-full <?php echo $c_critical ? 'bg-red-500 animate-ping' : 'bg-green-500'; ?>"></span>
                            <span class="text-[10px] font-bold font-mono uppercase <?php echo $c_critical ? 'text-red-600 dark:text-red-400' : 'text-green-700 dark:text-green-400'; ?>"><?php echo $c['status']; ?></span>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-between items-center px-4 py-3 bg-slate-100 dark:bg-slate-900/30 rounded-xl border border-outline-variant/10 mb-4 font-mono text-xs">
                    <div class="text-center">
                        <span class="text-[9px] text-slate-500 dark:text-on-surface-variant block uppercase">Nabız</span>
                        <span class="font-bold text-slate-900 dark:text-white"><?php echo $c['hr']; ?> <small class="text-[9px]">bpm</small></span>
                    </div>
                    <div class="w-[1px] h-6 bg-outline-variant/30"></div>
                    <div class="text-center">
                        <span class="text-[9px] text-slate-500 dark:text-on-surface-variant block uppercase">Oksijen</span>
                        <span class="font-bold text-slate-900 dark:text-white">%<?php echo $c['o2']; ?></span>
                    </div>
                </div>

                <a href="?select_crew=<?php echo $id; ?>" class="w-full py-2 bg-slate-200 dark:bg-surface-container-high/60 hover:bg-primary hover:text-white border border-outline-variant/30 text-center rounded-lg font-mono text-xs text-slate-800 dark:text-on-surface block transition-all">
                    SENSÖR BAĞLANTISINI AÇ
                </a>
            </div>
        </div>
        <?php endif; ?>
    <?php endforeach; ?>

</div>
</div></div>

<script>
    document.querySelectorAll('.glass-panel').forEach(card => {
        card.addEventListener('mouseenter', () => card.style.transform = 'translateY(-4px)');
        card.style.transition = 'all 0.3s ease';
        card.addEventListener('mouseleave', () => card.style.transform = 'translateY(0)');
    });
</script>
</body>
</html>