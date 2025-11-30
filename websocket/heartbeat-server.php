<?php
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\App;

require dirname(__DIR__) . '/vendor/autoload.php';

class HeartbeatServer implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        echo "💓 Heartbeat server started...\n";
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "👤 New heartbeat connection ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        echo "📨 Heartbeat message: $msg\n";

        // Gửi lại cho tất cả client khác (real-time)
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo "❌ Heartbeat connection {$conn->resourceId} closed\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "⚠️ Error: {$e->getMessage()}\n";
        $conn->close();
    }
}

// Khởi chạy server Heartbeat
$app = new App('localhost', 8082, '0.0.0.0');
$app->route('/heartbeat', new HeartbeatServer, ['*']);
$app->run();
