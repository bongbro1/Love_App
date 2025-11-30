<?php
// run_all_server.php
echo "Starting chat-server...\n";
$pid1 = popen('php "'.__DIR__.'\chat-server.php"', 'r');

echo "Starting heartbeat-server...\n";
$pid2 = popen('php "'.__DIR__.'\heartbeat-server.php"', 'r');

echo "✅ Servers started. Press Ctrl+C to stop.\n";

// Giữ script chạy
while (true) {
    sleep(1);
}
