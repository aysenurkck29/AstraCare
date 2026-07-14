<?php
require_once 'config.php';
require_once 'header.php';
?>
<div class="max-w-4xl mx-auto glass-panel rounded-2xl overflow-hidden border border-outline-variant/10 relative shadow-2xl">
    <div class="scanline"></div>
    <div class="p-8 border-b border-outline-variant/10 bg-slate-900/20 flex justify-between items-center">
        <div>
            <h1 class="text-xl font-bold <?php echo $is_critical?'text-red-400':'text-primary'; ?>">AI Teşhis Analiz Raporu</h1>
            <p class="text-xs font-mono text-on-surface-variant mt-0.5">DOSYA KODU: AST-<?php echo strtoupper($active_planet); ?>-EMER</p>
        </div>
        <span class="px-3 py-1 bg-red-500/10 border border-red-500/20 text-red-400 font-mono text-xs font-bold rounded">RISK LEVEL: <?php echo $is_critical?'CRITICAL':'LOW'; ?></span>
    </div>
    
    <div class="p-8 space-y-6">
        <div class="space-y-2">
            <h3 class="text-xs font-mono text-primary uppercase tracking-widest">Tıbbi Trend Projeksiyonu</h3>
            <div class="h-32 bg-slate-950/40 border border-outline-variant/10 rounded-xl flex items-center justify-center p-4">
                <svg class="w-full h-full" viewBox="0 0 600 100" preserveAspectRatio="none">
                    <path d="M0,80 Q150,<?php echo $is_critical?'20':'70'; ?> 300,<?php echo $is_critical?'10':'80'; ?> 450,40 600,<?php echo $is_critical?'5':'75'; ?>" fill="none" stroke="<?php echo $is_critical?'#ef4444':'#06b6d4'; ?>" stroke-width="3"></path>
                </svg>
            </div>
        </div>

        <div class="space-y-3 text-sm leading-relaxed">
            <h3 class="text-xs font-mono text-primary uppercase tracking-widest">AI Doktor Notları</h3>
            <p class="opacity-80">Astronot <strong><?php echo $crew_data['name']; ?></strong> için anlık telemetri takibi yapılmıştır. Nabız: <?php echo $crew_data['hr']; ?> BPM, Oksijen: %<?php echo $crew_data['o2']; ?>. Sistem otomatik acil eylem planı gerekliliklerini doğrulamıştır.</p>
        </div>
    </div>
</div>
</div></div></body></html>