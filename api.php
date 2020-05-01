<?php
/ 取得用戶IP
if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
   $ipAddress = $_SERVER["HTTP_CLIENT_IP"];
} else if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
   $ipAddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
} else {
   $ipAddress = $_SERVER["REMOTE_ADDR"];
}

//IP資料API
$url = "https://api.ip.sb/geoip/".urlencode($ipAddress);
$ch = curl_init($url);
$headr = array();
curl_setopt($ch, CURLOPT_HTTPHEADER, $headr);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$res = curl_exec($ch);
$data = json_decode($res, true);
curl_close($ch);

//Google Translate API 將獲取的數值翻譯成你想要的語言
$token = ""; //可以在 https://console.cloud.google.com/apis/library/translate.googleapis.com 申請
$target = "zh-TW"; //要轉換的語言
$source = "en"; //原始語言
$translteurl = "https://translation.googleapis.com/language/translate/v2?key=".urlencode($token)."&target=".urlencode($target)."&source=".urlencode($source)."&q=".urlencode($data['country']).urlencode($data['city']);
$transltech = curl_init($translteurl); 
curl_setopt($transltech, CURLOPT_HTTPHEADER, $translteheadr);
curl_setopt($transltech, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($transltech, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($transltech, CURLOPT_RETURNTRANSFER, 1); 
$translteres = curl_exec($transltech); 
$transltedata = json_decode($translteres, true);
curl_close($transltech);
?>
<?php echo $transltedata['data']['translations'][0]['translatedText']; ?>
