<?php
if (!defined('DEBUG_LOG')) define('DEBUG_LOG', __DIR__ . '/../app/debug.log');
if (!defined('WS_URL')) define('WS_URL', 'ws://localhost:8081/chat');
if (!defined('WS_URL_HEARTBEAT')) define('WS_URL_HEARTBEAT', 'ws://localhost:8082/heartbeat');
if (!defined('BASE_URL')) define('BASE_URL', 'http://localhost:8080/love-app/public');

return [
    'vapid' => [
        'subject'    => 'mailto:you@example.com',
        'publicKey'  => 'BNhWPftFYB7I329kCfI-QgSyOgz1WHfJD9pXhBzm40xDXl9F7p6MunLR_0AwUhYHdw8hxN9wIe5Yg-_KRV-ufUI',
        'privateKey' => '1IY8Q1syQrdRnyPWTgGjvQ3sFwWwkRthZ5bGKOwprGU',
    ],
    'redirects' => [
        'longdistance' => 'http://localhost:8080/love-app/public/longdistance/chat',
        'nearlove' => 'http://localhost:8080/love-app/public/nearlove/checkin'
    ]
];