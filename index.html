<?php

header("Content-Type: application/json; charset=utf-8;");

// Yetki kontrolü senin kırmızı çizgin, asla dokunmuyorum sevgilim
include "../../server/authcontrol.php";

ini_set("display_errors", 0);
error_reporting(0);

// Senin Render Ana Sunucu Adresin
$RENDER_DOMAIN = "https://gamebzhhshs.onrender.com/api/v1/search/";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // --- BOT DÜĞÜM SEÇİCİ ---
    // Botun oluşturduğu ID (Örn: nev_1_, ad_soyad_v2)
    $node = htmlspecialchars($_POST["node"] ?? ""); 
    
    if (empty($node)) {
        echo json_encode(["success" => "false", "message" => "Lütfen sorgulanacak veri düğümünü belirt aşkım."]);
        die();
    }

    // --- PANEL VERİLERİNİ YAKALAMA ---
    // Python API'mizin beklediği parametre isimleriyle eşleştiriyoruz
    $post_data = [
        "tc"      => htmlspecialchars($_POST["tc"] ?? ""),
        "ad"      => htmlspecialchars($_POST["ad"] ?? ""),
        "soyad"   => htmlspecialchars($_POST["soyad"] ?? ""),
        "annetc"  => htmlspecialchars($_POST["annetc"] ?? ""),
        "babatc"  => htmlspecialchars($_POST["babatc"] ?? ""),
        "q"       => htmlspecialchars($_POST["q"] ?? "") // Genel arama için
    ];

    // --- RENDER API'YE DİNAMİK BAĞLANTI ---
    // Python tarafındaki GET/POST uyumu sayesinde http_build_query ile tertemiz bir URL yapıyoruz
    $final_url = $RENDER_DOMAIN . $node . "?" . http_build_query($post_data);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $final_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 60); // Büyük veri blokları için süreyi yüksek tuttum sevgilim
    
    $api_response = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // --- SONUÇLARI PANELİNE ATMA ---
    if ($http_status == 200) {
        // Python API'den gelen o şık metin blokları
        echo json_encode([
            "success" => "true",
            "message" => "Veriler başarıyla getirildi sevgilim.",
            "data" => $api_response 
        ]);
    } else if ($http_status == 404) {
        // Python tarafındaki "Kayıt bulunamadı" mesajını yakalar
        echo json_encode(["success" => "false", "message" => "Aradığın kriterlere uygun kayıt bulunamadı."]);
    } else {
        echo json_encode(["success" => "false", "message" => "API Hatası (Kod: $http_status) - Sevgilim Render uyanıyor olabilir, tekrar dene."]);
    }
    die();

} else {
    echo json_encode(["success" => "false", "message" => "request error"]);
    die();
}
?>
