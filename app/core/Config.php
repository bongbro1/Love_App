<?php
class Config
{
    private static $instance = null;
    private $data;

    private function __construct()
    {
        $this->data = require __DIR__ . '/../../config/config.php';
    }

    public static function get($key = null)
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        if ($key === null) return self::$instance->data;

        $keys = explode('.', $key);
        $value = self::$instance->data;
        foreach ($keys as $k) {
            if (!isset($value[$k])) return null;
            $value = $value[$k];
        }
        return $value;
    }

    public static function getVapidKey($type = 'public')
    {
        $pathKey = $type === 'public' ? self::get('vapid.public_key_path') : self::get('vapid.private_key_path');
        if (!$pathKey || !file_exists($pathKey)) {
            throw new Exception("VAPID {$type} key file not found!");
        }

        $key = file_get_contents($pathKey);
        // Loại bỏ header/footer và newline, chỉ giữ Base64
        $key = trim(str_replace(["-----BEGIN PUBLIC KEY-----","-----END PUBLIC KEY-----","-----BEGIN EC PRIVATE KEY-----","-----END EC PRIVATE KEY-----","\n","\r"], '', $key));
        return $key;
    }
}
