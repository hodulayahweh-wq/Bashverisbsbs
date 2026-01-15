<?php
error_reporting(0);
$sonuc = "";

$bot_base_url = "http://localhost:10000/api/v1/search/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $node_id = htmlspecialchars($_POST['node_id'] ?? ''); 
    $q = htmlspecialchars($_POST['q'] ?? '');           

    if ($node_id && $q) {
        $istek_url = $bot_base_url . urlencode($node_id) . "?q=" . urlencode($q);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $istek_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code == 200) {
            // Sevgilim, burada ham metni parçalayıp JSON yapıyoruz
            $satirlar = explode("\n", trim($response));
            $json_array = [
                "durum" => "basarili",
                "node" => $node_id,
                "sorgu" => $q,
                "bulunan_kayitlar" => array_filter($satirlar)
            ];
            // JSON formatına çevir ve güzelce hizala
            $sonuc = json_encode($json_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else if ($http_code == 404) {
            $sonuc = json_encode(["hata" => "API Düğümü veya kayıt bulunamadı sevgilim."], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            $sonuc = json_encode(["hata" => "Bot bağlantı hatası: $http_code"], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Dinamik API Gateway | JSON Mode</title>
    <style>
        body { background: #010409; color: #c9d1d9; font-family: 'Inter', sans-serif; display: flex; justify-content: center; padding: 50px; }
        .wrapper { background: #0d1117; border: 1px solid #30363d; padding: 35px; border-radius: 16px; width: 550px; box-shadow: 0 15px 35px rgba(0,0,0,0.7); }
        h2 { color: #58a6ff; text-align: center; margin-bottom: 25px; font-weight: 300; }
        .input-box { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-size: 13px; color: #8b949e; }
        input { width: 100%; padding: 14px; background: #010409; border: 1px solid #30363d; color: #fff; border-radius: 8px; box-sizing: border-box; transition: 0.3s; }
        input:focus { border-color: #58a6ff; outline: none; }
        button { width: 100%; padding: 14px; background: #238636; border: none; color: white; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 16px; margin-top: 10px; }
        button:hover { background: #2ea043; }
        /* Terminal alanı JSON için optimize edildi sevgilim */
        .terminal { background: #000; padding: 15px; margin-top: 25px; border-radius: 8px; border: 1px solid #30363d; font-family: 'Fira Code', 'Courier New', monospace; font-size: 13px; color: #7ee787; white-space: pre-wrap; max-height: 400px; overflow-y: auto; line-height: 1.4; }
        .badge { background: #21262d; padding: 4px 8px; border-radius: 4px; font-size: 11px; color: #8b949e; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>📡 API Köprüsü <span class="badge">JSON v2.0</span></h2>
        <form method="POST">
            <div class="input-box">
                <label>Aktif API ID (Düğüm)</label>
                <input type="text" name="node_id" placeholder="Botun verdiği ID'yi girin..." value="<?php echo htmlspecialchars($node_id); ?>" required>
            </div>
            <div class="input-box">
                <label>Sorgu Parametresi</label>
                <input type="text" name="q" placeholder="TC, Ad veya Kelime..." value="<?php echo htmlspecialchars($q); ?>" required>
            </div>
            <button type="submit">BOTU SORGULA</button>
        </form>

        <?php if ($sonuc): ?>
            <div class="terminal"><?php echo htmlspecialchars($sonuc); ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
