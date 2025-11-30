<?php
class CategoryModel
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function all()
    {
        $stmt = $this->pdo->query("SELECT * FROM categories ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll($keyword = '', $page = 1, $perPage = 10)
    {
        $offset = ($page - 1) * $perPage;
        $params = [];
        $sql = "SELECT * FROM categories WHERE 1=1";

        if ($keyword) {
            $sql .= " AND name LIKE :keyword";
            $params[':keyword'] = "%$keyword%";
        }

        $sql .= " ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);

        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->bindValue(':limit', (int)$perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Tổng số categories
        $countSql = "SELECT COUNT(*) FROM categories WHERE 1=1";
        if ($keyword) $countSql .= " AND name LIKE :keyword";
        $countStmt = $this->pdo->prepare($countSql);
        if ($keyword) $countStmt->bindValue(':keyword', "%$keyword%");
        $countStmt->execute();
        $total = (int)$countStmt->fetchColumn();

        return ['categories' => $categories, 'total' => $total, 'page' => (int)$page, 'perPage' => $perPage];
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO categories (name, slug, color) VALUES (?, ?, ?)");
        return $stmt->execute([$data['name'], $data['slug'], $data['color']]);
    }

    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare("UPDATE categories SET name = ?, slug = ?, color = ? WHERE id = ?");
        return $stmt->execute([$data['name'], $data['slug'], $data['color'], $id]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM categories WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
