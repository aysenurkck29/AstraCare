<?php
session_start();

// Google Gemini API Key - Sabit Gömme Alanı (Kendi anahtarını buraya yazabilirsin)
define('GEMINI_API_KEY', 'AIzaSyYOUR_ACTUAL_API_KEY_HERE');

// Güvenli Giriş Şifresi
define('SYSTEM_PASSWORD', 'mars2165');

// Tema Protokolü (Varsayılan: Dark Mode)
if (!isset($_SESSION['theme'])) {
    $_SESSION['theme'] = 'dark';
}

// Varsayılan Lokasyon ve Mürettebat Seçimleri
if (!isset($_SESSION['selected_planet'])) $_SESSION['selected_planet'] = 'mars';
if (!isset($_SESSION['selected_crew'])) $_SESSION['selected_crew'] = 'c1';

// Gezegenler ve Mürettebat Dinamik Veritabanı
$planet_db = [
    'mars' => [
        'name' => 'Mars',
        'location' => 'Eridania Havzası',
        'distance' => '4.1 AU',
        'population' => '1.240 Kişi',
        'latency' => '14.2 dk',
        'status' => 'STABİL',
        'status_type' => 'primary',
        'badge' => 'AKTİF KOLONİ',
        'glow_class' => 'planet-glow-mars',
        'accent_color' => 'tertiary',
        'img_idx' => 3,
        'crew' => [
            'c1' => ['name' => 'Dr. Elif Yıldız', 'role' => 'Kaptan / Tıbbi Subay', 'hr' => 72, 'o2' => 98, 'temp' => 36.6, 'stress' => 'Düşük', 'sleep' => '7.5h', 'sleep_deep' => '2.4s', 'sleep_rem' => '1.8s', 'sleep_light' => '3.3s', 'status' => 'STABIL', 'img_idx' => 7],
            'c2' => ['name' => 'Caner Demir', 'role' => 'Kıdemli Uçuş Mühendisi', 'hr' => 124, 'o2' => 89, 'temp' => 37.8, 'stress' => 'Yüksek', 'sleep' => '5.1h', 'sleep_deep' => '1.1s', 'sleep_rem' => '0.9s', 'sleep_light' => '3.1s', 'status' => 'UYARI', 'img_idx' => 9]
        ]
    ],
    'titan' => [
        'name' => 'Titan',
        'location' => 'Satürn Yörüngesi',
        'distance' => '9.5 AU',
        'population' => '342 Kişi',
        'latency' => '78.0 dk',
        'status' => 'BEKLEMEDE',
        'status_type' => 'secondary',
        'badge' => 'ARAŞTIRMA ÜSSÜ',
        'glow_class' => 'planet-glow-titan',
        'accent_color' => 'secondary',
        'img_idx' => 4,
        'crew' => [
            'c3' => ['name' => 'Mete Han', 'role' => 'Baş Tıbbi Araştırmacı', 'hr' => 68, 'o2' => 99, 'temp' => 36.4, 'stress' => 'Düşük', 'sleep' => '7.2h', 'sleep_deep' => '2.1s', 'sleep_rem' => '2.0s', 'sleep_light' => '3.1s', 'status' => 'STABIL', 'img_idx' => 8]
        ]
    ],
    'moon' => [
        'name' => 'Ay',
        'location' => 'Dünya Yörüngesi',
        'distance' => '0.002 AU',
        'population' => '8.420 Kişi',
        'latency' => '1.3 sn',
        'status' => 'YÜKSEK HIZ',
        'status_type' => 'primary',
        'badge' => 'ANA MERKEZ',
        'glow_class' => 'planet-glow-moon',
        'accent_color' => 'primary',
        'img_idx' => 5,
        'crew' => [
            'c4' => ['name' => 'Selin Aksoy', 'role' => 'Filo Baş Pilotu', 'hr' => 75, 'o2' => 97, 'temp' => 36.7, 'stress' => 'Düşük', 'sleep' => '8.0h', 'sleep_deep' => '2.5s', 'sleep_rem' => '2.2s', 'sleep_light' => '3.3s', 'status' => 'STABIL', 'img_idx' => 10]
        ]
    ]
];