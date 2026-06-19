<?php
class OrderRepository
{
    public function __construct(private PDO $db) {}

    public function countAll(string $keyword = ''): int
    {
        if ($keyword !== '') {
            $sql = "SELECT COUNT(*) AS total FROM orders 
                    WHERE order_code LIKE ? 
                    OR customer_name LIKE ? 
                    OR customer_email LIKE ? 
                    OR customer_phone LIKE ?";
            $stmt = $this->db->prepare($sql);
            $searchTerm = '%' . $keyword . '%';
            $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        } else {
            $sql = "SELECT COUNT(*) AS total FROM orders";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
        }
        
        return (int) ($stmt->fetch()['total'] ?? 0);
    }

    public function getPaginated(string $keyword, int $limit, int $offset, string $sort, string $direction): array
    {
        $allowedSorts = ['id', 'order_code', 'customer_name', 'customer_email', 'total_amount', 'status', 'created_at'];
        $allowedDirections = ['asc', 'desc'];

        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }

        if (!in_array(strtolower($direction), $allowedDirections, true)) {
            $direction = 'desc';
        }

        if ($keyword !== '') {
            $sql = "SELECT id, order_code, customer_name, customer_email, customer_phone, 
                           total_amount, status, created_at 
                    FROM orders 
                    WHERE order_code LIKE ? 
                    OR customer_name LIKE ? 
                    OR customer_email LIKE ? 
                    OR customer_phone LIKE ? 
                    ORDER BY {$sort} {$direction} 
                    LIMIT ? OFFSET ?";
            
            $stmt = $this->db->prepare($sql);
            $searchTerm = '%' . $keyword . '%';
            $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm, $limit, $offset]);
        } else {
            $sql = "SELECT id, order_code, customer_name, customer_email, customer_phone, 
                           total_amount, status, created_at 
                    FROM orders 
                    ORDER BY {$sort} {$direction} 
                    LIMIT ? OFFSET ?";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$limit, $offset]);
        }
        
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function findByOrderCode(string $orderCode): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE order_code = ?");
        $stmt->execute([$orderCode]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO orders (order_code, customer_name, customer_email, customer_phone, 
                                    total_amount, status, shipping_address, note) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $data['order_code'],
                $data['customer_name'],
                $data['customer_email'] ?? null,
                $data['customer_phone'] ?? null,
                (float) $data['total_amount'],
                $data['status'],
                $data['shipping_address'] ?? null,
                $data['note'] ?? null,
            ]);
        } catch (PDOException $e) {
            if (($e->errorInfo[1] ?? null) === 1062) {
                throw new DuplicateRecordException('Mã đơn hàng đã tồn tại.');
            }
            throw $e;
        }
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE orders 
                SET order_code = ?, customer_name = ?, 
                    customer_email = ?, customer_phone = ?,
                    total_amount = ?, status = ?,
                    shipping_address = ?, note = ?, updated_at = NOW()
                WHERE id = ?";

        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $data['order_code'],
                $data['customer_name'],
                $data['customer_email'] ?? null,
                $data['customer_phone'] ?? null,
                (float) $data['total_amount'],
                $data['status'],
                $data['shipping_address'] ?? null,
                $data['note'] ?? null,
                $id,
            ]);
        } catch (PDOException $e) {
            if (($e->errorInfo[1] ?? null) === 1062) {
                throw new DuplicateRecordException('Mã đơn hàng đã tồn tại.');
            }
            throw $e;
        }
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM orders WHERE id = ?");
        return $stmt->execute([$id]);
    }
}