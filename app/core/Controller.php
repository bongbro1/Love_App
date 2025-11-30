<?php
// app/core/Controller.php
require_once __DIR__ . '/../../config/database.php'; // file này tạo sẵn $pdo

class Controller
{
    protected $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    /**
     * Load view kèm layout
     * @param string $view đường dẫn view (ví dụ: 'longdistance/dashboard')
     * @param array $data dữ liệu truyền vào view
     * @param bool $useLayout có dùng layout chung không
     */
    public function view($view, $data = [], $layout = 'private')
    {
        extract($data);

        $viewPath = __DIR__ . '/../views/' . $view . '.php';

        $layoutDir = __DIR__ . '/../views/layout/' . $layout;

        if (file_exists($layoutDir . '/index.php')) {
            require $layoutDir . '/index.php';
        } else {
            include $viewPath; // fallback
        }
    }

    public function model($model)
    {
        require_once __DIR__ . '/../models/' . $model . '.php';
        return new $model($this->pdo);
    }
}
