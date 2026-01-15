<?php
error_reporting(0);
$sonuc = "";

// Senin botunun tam dış adresi sevgilim
$bot_base_url = "https://gamebzhhshs.onrender.com/api/v1/search/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $node_id = htmlspecialchars($_POST['node_id'] ?? ''); 
    $q = htmlspecialchars($_POST['q'] ?? '');           

    if ($node_id && $q) {
        // Botun API yapısına göre URL oluşturuyoruz
        $istek_url = $bot_base_url . urlencode($node_id) . "?q=" . urlencode($q);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $istek_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15); // Biraz daha süre tanıyalım
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // SSL hatalarını es geçelim
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code == 200) {
            // Ham metni botun formatına göre JSON'a çeviriyoruz sevgilim
            $satirlar = explode("\n", trim($response));
            $json_array = [
                "durum" => "basarili",
                "sunucu" => "gamebzhhshs.onrender.com",
                "node" => $node_id,
                "sorgu" => $q,
                "sonuc_sayisi" => count($satirlar),
                "veriler" => array_values(array_filter($satirlar))
            ];
            $sonuc = json_encode($json_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else if ($http_code == 404) {
            $sonuc = json_encode(["hata" => "API Düğümü (ID) veya kayıt bulunamadı sevgilim."], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            $sonuc = json_encode(["hata" => "Bot sunucusuna ulaşılamadı. Kod: $http_code"], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Dinamik JSON API Gateway</title>
    <style>
        body { background: #010409; color: #c9d1d9; font-family: 'Inter', sans-serif; display: flex; justify-content: center; padding: 40px 20px; margin: 0; }
        .wrapper { background: #0d1117; border: 1px solid #30363d; padding: 35px; border-radius: 16px; width: 100%; max-width: 600px; box-shadow: 0 15px 35px rgba(0,0,0,0.7); }
        h2 { color: #58a6ff; text-align: center; margin-bottom: 25px; font-weight: 300; letter-spacing: 1px; }
        .input-box { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-size: 13px; color: #8b949e; font-weight: bold; }
        input { width: 100%; padding: 14px; background: #010409; border: 1px solid #30363d; color: #fff; border-radius: 8px; box-sizing: border-box; transition: 0.3s; font-size: 15px; }
        input:focus { border-color: #58a6ff; outline: none; box-shadow: 0 0 10px rgba(88, 166, 255, 0.1); }
        button { width: 100%; padding: 15px; background: #238636; border: none; color: white; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 16px; margin-top: 10px; transition: 0.2s; }
        button:hover { background: #2ea043; transform: translateY(-1px); }
        .terminal { background: #000; padding: 18px; margin-top: 25px; border-radius: 8px; border: 1px solid #30363d; font-family: 'Fira Code', 'Courier New', monospace; font-size: 13px; color: #7ee787; white-space: pre-wrap; max-height: 450px; overflow-y: auto; line-height: 1.5; border-top: 4px solid #58a6ff; }
        .badge { background: #21262d; padding: 4px 10px; border-radius: 6px; font-size: 11px; color: #8b949e; vertical-align: middle; margin-left: 10px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>📡 API GATEWAY <span class="badge">GAMEBZH</span></h2>
        <form method="POST">
            <div class="input-box">
                <label>📍 API Node ID (Botun Verdiği)</label>
                <input type="text" name="node_id" placeholder="Örn: tc_data" value="<?php echo htmlspecialchars($node_id); ?>" required autocomplete="off">
            </div>
            <div class="input-box">
                <label>🔍 Sorgulanacak Veri</label>
                <input type="text" name="q" placeholder="TC No, İsim veya Soyisim..." value="<?php echo htmlspecialchars($q); ?>" required autocomplete="off">
            </div>
            <button type="submit">SORGULA VE JSON ÇIKTI AL</button>
        </form>

        <?php if ($sonuc): ?>
            <div class="terminal"><?php echo htmlspecialchars($sonuc); ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
