<?php
require_once 'config.php';
require_once 'header.php';

// Oturum Koruma Duvarı
if (!isset($_SESSION['authenticated'])) {
    header("Location: index.php");
    exit;
}
?>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 max-w-7xl mx-auto">
    <div class="lg:col-span-8 space-y-6">
        <div class="glass-panel p-6 rounded-2xl border <?php echo $is_critical ? 'border-red-500 bg-red-500/5' : 'border-outline-variant/10'; ?> flex justify-between items-center shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-gradient-to-tr from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-700 rounded-xl flex items-center justify-center border border-slate-300 dark:border-transparent shadow overflow-hidden">
                    <img class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name=<?php echo urlencode($crew_data['name']); ?>&background=0d1322&color=4cd7f6&bold=true" alt="<?php echo $crew_data['name']; ?>"/>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white"><?php echo $crew_data['name']; ?></h2>
                    <p class="text-xs text-slate-500 dark:text-on-surface-variant font-mono"><?php echo $crew_data['role']; ?> // üs: <?php echo strtoupper($active_planet); ?></p>
                </div>
            </div>
            <div class="text-right">
                <span class="text-[10px] font-mono text-slate-500 dark:text-on-surface-variant block">SİSTEM TEŞHİSİ</span>
                <span class="text-xs font-bold font-mono <?php echo $is_critical ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400'; ?>">
                    ● <?php echo $is_critical ? 'ALARM: KRİTİK SEVİYE' : 'NOMİNAL AKIŞ'; ?>
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="glass-panel p-5 rounded-xl border <?php echo $crew_data['hr']>100 ? 'border-red-500/40 bg-red-500/5':'border-outline-variant/10'; ?>">
                <div class="flex justify-between text-xs font-mono text-slate-500 dark:text-on-surface-variant uppercase"><span>❤️ Nabız</span><span>BPM</span></div>
                <div class="text-3xl font-bold font-mono mt-2 text-slate-900 dark:text-white"><?php echo $crew_data['hr']; ?></div>
                <div class="h-10 mt-3 bg-primary/10 rounded overflow-hidden relative">
                    <div class="absolute bottom-0 w-full h-full bg-primary/40 scanline"></div>
                </div>
            </div>
            <div class="glass-panel p-5 rounded-xl border <?php echo $crew_data['o2']<90 ? 'border-red-500/40 bg-red-500/5':'border-outline-variant/10'; ?>">
                <div class="flex justify-between text-xs font-mono text-slate-500 dark:text-on-surface-variant uppercase"><span>💨 Oksijen Doygunluğu</span><span>% SpO2</span></div>
                <div class="text-3xl font-bold font-mono mt-2 text-slate-900 dark:text-white">%<?php echo $crew_data['o2']; ?></div>
                <div class="w-full h-1.5 bg-slate-200 dark:bg-slate-800 rounded-full mt-4"><div class="h-full bg-primary rounded-full" style="width: <?php echo $crew_data['o2']; ?>%"></div></div>
            </div>
            <div class="glass-panel p-5 rounded-xl border border-outline-variant/10">
                <div class="flex justify-between text-xs font-mono text-slate-500 dark:text-on-surface-variant uppercase"><span>🌡️ Vücut Isısı</span><span>°C</span></div>
                <div class="text-3xl font-bold font-mono mt-2 text-slate-900 dark:text-white"><?php echo $crew_data['temp']; ?>°C</div>
                <p class="text-[10px] text-slate-500 dark:text-on-surface-variant mt-3">Termal Regülasyon Dengeli</p>
            </div>
            <div class="glass-panel p-5 rounded-xl border border-outline-variant/10">
                <div class="flex justify-between text-xs font-mono text-slate-500 dark:text-on-surface-variant uppercase"><span>🧠 Nöro-Stres</span><span>İndeks</span></div>
                <div class="text-3xl font-bold mt-2 text-slate-900 dark:text-white"><?php echo $crew_data['stress']; ?></div>
                <p class="text-[10px] text-slate-500 dark:text-on-surface-variant mt-3">Kortizol Seviyesi: Dengeli</p>
            </div>
        </div>

        <div class="glass-panel p-6 rounded-xl border border-outline-variant/10">
            <h3 class="text-sm font-bold font-mono text-slate-900 dark:text-white mb-4">Uyku Kalite Analizi (<?php echo $crew_data['sleep']; ?>)</h3>
            <div class="grid grid-cols-3 gap-4 font-mono text-xs">
                <div class="p-3 bg-slate-100 dark:bg-slate-900/40 rounded-lg border border-outline-variant/10"><span>Derin Uyku</span><strong class="block text-primary text-base mt-1"><?php echo $crew_data['sleep_deep']; ?></strong></div>
                <div class="p-3 bg-slate-100 dark:bg-slate-900/40 rounded-lg border border-outline-variant/10"><span>REM</span><strong class="block text-primary text-base mt-1"><?php echo $crew_data['sleep_rem']; ?></strong></div>
                <div class="p-3 bg-slate-100 dark:bg-slate-900/40 rounded-lg border border-outline-variant/10"><span>Hafif Uyku</span><strong class="block text-slate-500 dark:text-slate-400 text-base mt-1"><?php echo $crew_data['sleep_light']; ?></strong></div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-4">
        <div class="glass-panel p-6 rounded-2xl border border-outline-variant/20 shadow-xl flex flex-col justify-between h-full min-h-[450px]">
            <div>
                <div class="flex justify-between items-center border-b border-outline-variant/10 pb-3 mb-4">
                    <h3 class="text-xs font-bold font-mono text-slate-900 dark:text-white uppercase tracking-wider">AstraCare AI Doktoru</h3>
                    <span class="text-[9px] font-mono bg-primary/10 text-primary border border-primary/20 px-2 py-0.5 rounded">GEMINI ENGINE</span>
                </div>

                <div class="space-y-4">
                    <div class="p-3 rounded-xl <?php echo $is_critical?'bg-red-500/10 border-red-500/20':'bg-slate-100 dark:bg-slate-900/30 border-slate-200 dark:border-slate-800'; ?> border text-xs">
                        <span class="text-[9px] opacity-60 dark:opacity-50 block font-mono text-slate-700 dark:text-slate-300">KRİTİK ANALİZ SKORU</span>
                        <strong class="<?php echo $is_critical?'text-red-600 dark:text-red-400':'text-green-700 dark:text-green-400'; ?> text-sm font-mono block mt-0.5">
                            <?php echo $is_emergency || $is_critical ? 'YÜKSEK // CRITICAL ALARM' : 'NOMİNAL DÜZEY // SAFE'; ?>
                        </strong>
                    </div>

                    <div class="p-4 rounded-xl bg-white dark:bg-slate-950/40 border border-outline-variant/10 text-xs text-slate-700 dark:text-on-surface-variant leading-relaxed max-h-[250px] overflow-y-auto font-mono">
                        <?php
                        if (isset($_POST['get_consultation'])) {
                            if (GEMINI_API_KEY !== 'AIzaSyYOUR_ACTUAL_API_KEY_HERE' && !empty(GEMINI_API_KEY)) {
                                // Google Gemini Gerçek cURL Bağlantısı
                                $api_url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . GEMINI_API_KEY;
                                $query_prompt = "Sen AstraCare fütüristik uzay hekimisin. Gezegen: " . $p_info['name'] . ". Astronot: " . $crew_data['name'] . ". Veriler; Nabız: " . $crew_data['hr'] . " BPM, Oksijen: %" . $crew_data['o2'] . ", Sıcaklık: " . $crew_data['temp'] . " C. Bu değerleri tıbbi olarak yorumla, varsa kısa eylem planı yaz. Türkçe yaz.";
                                
                                $payload = ["contents" => [["parts" => [["text" => $query_prompt]]]]];
                                
                                $ch = curl_init($api_url);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLOPT_POST, true);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
                                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                                $api_response = curl_exec($ch);
                                
                                if(curl_errno($ch)) {
                                    $report_text = 'Bağlantı Hatası: ' . curl_error($ch);
                                } else {
                                    $result_arr = json_decode($api_response, true);
                                    $report_text = $result_arr['candidates'][0]['content']['parts'][0]['text'] ?? 'Rapor oluşturulamadı. API Key veya İnternet bağlantınızı kontrol edin.';
                                }
                                curl_close($ch);
                                echo nl2br(htmlspecialchars($report_text));
                                
                            } else {
                                // Statik Reçete Demo Modu
                                if ($is_critical) {
                                    echo "<strong>[KRİTİK ALARM]</strong><br>Akut hipoksi ve yüksek kardiyovasküler yük tespit edildi. Kabin O2 seviyesini derhal %25'e çıkartın. Med-Bot otonom stabilizasyon sıvısını enjekte edin.";
                                } else {
                                    echo "<strong>[SAĞLIK RAPORU NOMİNAL]</strong><br>Tüm telemetri değerleri derin uzay sağlık standartlarına uygundur. Ekstra medikal müdahale gerekmemektedir.";
                                }
                            }
                        } else {
                            echo "Tıbbi teşhis raporunu oluşturmak için aşağıdaki butona basın.";
                        }
                        ?>
                    </div>
                </div>
            </div>

            <form method="POST" class="mt-4">
                <button type="submit" name="get_consultation" value="1" class="w-full py-3 bg-gradient-to-r from-cyan-600 to-indigo-600 hover:from-cyan-500 hover:to-indigo-500 text-white font-bold font-mono text-xs rounded-xl tracking-wider shadow-lg active:scale-98 transition-all">
                    🧠 AI TIBBİ REÇETE ÜRET
                </button>
            </form>
        </div>
    </div>
</div>

</div></div></body></html>