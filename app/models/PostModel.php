<?php
class PostModel
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getLatest($limit = 5)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM posts WHERE status='published' ORDER BY post_date DESC LIMIT ?");
        $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllWithCategory($keyword = '', $category = '', $page = 1, $perPage = 10)
    {
        $offset = ($page - 1) * $perPage;
        $params = [];

        $sql = "SELECT p.*, c.name AS category_name 
            FROM posts p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE 1=1";

        if ($keyword) {
            $sql .= " AND p.title LIKE :keyword";
            $params[':keyword'] = "%$keyword%";
        }

        if ($category) {
            $sql .= " AND p.category_id = :category";
            $params[':category'] = $category;
        }

        $sql .= " ORDER BY p.created_at DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);

        // Bind filter params
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }

        // Bind limit & offset
        $stmt->bindValue(':limit', (int)$perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $stmt->execute();
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Lấy tổng số bản ghi (không bị LIMIT ảnh hưởng)
        $countSql = "SELECT COUNT(*) FROM posts WHERE 1=1";
        if ($keyword) $countSql .= " AND title LIKE :keyword";
        if ($category) $countSql .= " AND category_id = :category";

        $countStmt = $this->pdo->prepare($countSql);
        if ($keyword) $countStmt->bindValue(':keyword', "%$keyword%");
        if ($category) $countStmt->bindValue(':category', $category, PDO::PARAM_INT);
        $countStmt->execute();
        $total = (int)$countStmt->fetchColumn();

        return ['posts' => $posts, 'total' => $total];
    }




    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM posts WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = "INSERT INTO posts 
                (title, slug, excerpt, content, thumbnail, read_time, post_date, category_id, meta_title, meta_description, meta_keywords, status)
                VALUES (:title, :slug, :excerpt, :content, :thumbnail, :read_time, :post_date, :category_id,
                        :meta_title, :meta_description, :meta_keywords, :status)";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    public function update($id, $data)
    {
        $data['id'] = $id;

        $sql = "UPDATE posts SET
                    title=:title,
                    slug=:slug,
                    excerpt=:excerpt,
                    content=:content,
                    thumbnail=:thumbnail,
                    read_time=:read_time,
                    post_date=:post_date,
                    category_id=:category_id,
                    meta_title=:meta_title,
                    meta_description=:meta_description,
                    meta_keywords=:meta_keywords,
                    status=:status
                WHERE id=:id";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM posts WHERE id=?");
        return $stmt->execute([$id]);
    }
}
