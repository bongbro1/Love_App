<?php
function printTree($dir, $prefix = '') {
    $files = scandir($dir);
    $files = array_diff($files, ['.', '..']); // loại bỏ . và ..

    $count = count($files);
    $i = 0;

    foreach ($files as $file) {
        $i++;
        $path = $dir . DIRECTORY_SEPARATOR . $file;

        // Bỏ qua thư mục vendor
        if (is_dir($path) && $file === 'vendor') {
            continue;
        }

        $connector = ($i === $count) ? '└── ' : '├── ';
        echo $prefix . $connector . $file . PHP_EOL;

        if (is_dir($path)) {
            $newPrefix = $prefix . (($i === $count) ? '    ' : '│   ');
            printTree($path, $newPrefix);
        }
    }
}

$projectDir = __DIR__; // hoặc 'C:/xampp/htdocs/love-app'
printTree($projectDir);
