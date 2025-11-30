<?php
class SepayModel
{
    private $apiKeyFile = __DIR__ . '/../../config/sepay.key';

    public function getApiKey()
    {
        return file_exists($this->apiKeyFile)
            ? trim(file_get_contents($this->apiKeyFile))
            : '';
    }

    public function saveApiKey($key)
    {
        file_put_contents($this->apiKeyFile, trim($key));
    }

    public function getAccounts()
    {
        $apiKey = $this->getApiKey();
        if (!$apiKey) {
            return ['error' => 'API key chưa được cấu hình.'];
        }

        // 🔹 Giả lập dữ liệu API (bạn có thể thay bằng gọi Sepay thật)
        $url = "https://api.sepay.vn/account/list";
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ["Authorization: Bearer $apiKey"],
        ]);
        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);
        return $data['data'] ?? [];
    }
}
