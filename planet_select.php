<?php
require_once 'config.php';

// Gezegen Değiştirme Yakalayıcı
if (isset($_GET['select_planet']) && array_key_exists($_GET['select_planet'], $planet_db)) {
    $_SESSION['selected_planet'] = $_GET['select_planet'];
    $_SESSION['selected_crew'] = array_key_first($planet_db[$_GET['select_planet']]['crew']);
    header("Location: crew_select.php");
    exit;
}

require_once 'header.php';
?>

<div class="max-w-6xl mx-auto mb-10 space-y-2">
    <div class="flex items-center gap-2">
        <span class="w-8 h-[2px] bg-primary"></span>
        <span class="font-mono text-xs text-primary uppercase tracking-widest">Görev Kontrol Merkezi</span>
    </div>
    <h1 class="text-3xl font-bold tracking-tight">İzleme Bölgesi Seçin</h1>
    <p class="text-sm text-on-surface-variant max-w-2xl">Derin uzay tıbbi izleme protokolü için aktif bir lokasyon belirleyin. Her bölge bağımsız telemetri hattı sunar.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
    <?php foreach ($planet_db as $key => $p): ?>
        <div class="glass-panel rounded-2xl overflow-hidden flex flex-col group transition-all duration-300 border border-outline-variant/10 hover:border-primary/40">
            <div class="h-48 relative bg-slate-900/20 flex items-center justify-center p-6 border-b border-outline-variant/10">
                <span class="absolute top-4 left-4 text-[10px] font-mono bg-surface-container-high px-2 py-0.5 rounded border border-outline-variant/30"><?php echo $p['badge']; ?></span>
                <span class="text-6xl <?php echo $p['glow_class']; ?> animate-pulse-glow">🪐</span>
            </div>
            
            <div class="p-6 flex-1 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-end mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-white"><?php echo $p['name']; ?></h2>
                            <p class="text-xs text-on-surface-variant"><?php echo $p['location']; ?></p>
                        </div>
                        <span class="font-mono text-primary font-bold text-sm"><?php echo $p['distance']; ?></span>
                    </div>

                    <div class="space-y-2 text-xs font-mono mb-6 opacity-80">
                        <div class="flex justify-between border-b border-outline-variant/10 pb-1"><span>Mürettebat</span><span><?php echo $p['population']; ?></span></div>
                        <div class="flex justify-between border-b border-outline-variant/10 pb-1"><span>Gecikme</span><span><?php echo $p['latency']; ?></span></div>
                        <div class="flex justify-between"><span>Durum</span><span class="text-emerald-400 font-bold"><?php echo $p['status']; ?></span></div>
                    </div>
                </div>

                <a href="?select_planet=<?php echo $key; ?>" class="w-full py-3 bg-primary text-white text-xs font-bold font-mono uppercase rounded-xl text-center block tracking-wider hover:brightness-110 active:scale-98 transition-all shadow-md">
                    BAĞLAN VE SENKRONİZE ET
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once 'header.php'; // HTML kapanışını yönetir ?>
</div></div></body></html>