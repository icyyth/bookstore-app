<?php
class BookRepository
{
    public function __construct(private PDO $db) {}

    public function countAll(string $keyword = ''): int
    {
        if ($keyword !== '') {
            $sql = "SELECT COUNT(*) AS total FROM books WHERE title LIKE ? OR isbn LIKE ? OR author LIKE ?";
            $stmt = $this->db->prepare($sql);
            $searchTerm = '%' . $keyword . '%';
            $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
        } else {
            $sql = "SELECT COUNT(*) AS total FROM books";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
        }
        
        return (int) ($stmt->fetch()['total'] ?? 0);
    }

    public function getPaginated(string $keyword, int $limit, int $offset, string $sort, string $direction): array
    {
        $allowedSorts = ['id', 'isbn', 'title', 'author', 'price', 'stock', 'category', 'status', 'created_at'];
        $allowedDirections = ['asc', 'desc'];

        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }

        if (!in_array(strtolower($direction), $allowedDirections, true)) {
            $direction = 'desc';
        }

        if ($keyword !== '') {
            $sql = "SELECT id, isbn, title, author, price, stock, category, status, created_at 
                    FROM books 
                    WHERE title LIKE ? OR isbn LIKE ? OR author LIKE ? 
                    ORDER BY {$sort} {$direction} 
                    LIMIT ? OFFSET ?";
            
            $stmt = $this->db->prepare($sql);
            $searchTerm = '%' . $keyword . '%';
            $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $limit, $offset]);
        } else {
            $sql = "SELECT id, isbn, title, author, price, stock, category, status, created_at 
                    FROM books 
                    ORDER BY {$sort} {$direction} 
                    LIMIT ? OFFSET ?";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$limit, $offset]);
        }
        
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM books WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO books (isbn, title, author, price, stock, category, description, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $data['isbn'],
                $data['title'],
                $data['author'],
                (float) $data['price'],
                (int) $data['stock'],
                $data['category'],
                $data['description'] ?? null,
                $data['status'],
            ]);
        } catch (PDOException $e) {
            if (($e->errorInfo[1] ?? null) === 1062) {
                throw new DuplicateRecordException('ISBN đã tồn tại trong hệ thống.');
            }
            throw $e;
        }
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE books 
                SET isbn = ?, title = ?, author = ?, 
                    price = ?, stock = ?, category = ?, 
                    description = ?, status = ?, updated_at = NOW()
                WHERE id = ?";

        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $data['isbn'],
                $data['title'],
                $data['author'],
                (float) $data['price'],
                (int) $data['stock'],
                $data['category'],
                $data['description'] ?? null,
                $data['status'],
                $id,
            ]);
        } catch (PDOException $e) {
            if (($e->errorInfo[1] ?? null) === 1062) {
                throw new DuplicateRecordException('ISBN đã tồn tại trong hệ thống.');
            }
            throw $e;
        }
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM books WHERE id = ?");
        return $stmt->execute([$id]);
    }
}