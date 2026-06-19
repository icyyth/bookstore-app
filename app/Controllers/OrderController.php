<?php
class OrderController
{
    private function repository(): OrderRepository
    {
        $config = require __DIR__ . '/../../config/database.php';
        $pdo = (new Database($config))->getConnection();
        return new OrderRepository($pdo);
    }

    public function index(): void
    {
        $q = trim($_GET['q'] ?? '');
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $perPage = 10;
        $sort = $_GET['sort'] ?? 'created_at';
        $direction = $_GET['direction'] ?? 'desc';
        $offset = ($page - 1) * $perPage;

        $repo = $this->repository();
        $total = $repo->countAll($q);
        $totalPages = max(1, (int) ceil($total / $perPage));

        if ($page > $totalPages) {
            $page = $totalPages;
            $offset = ($page - 1) * $perPage;
        }

        $orders = $repo->getPaginated($q, $perPage, $offset, $sort, $direction);

        view('orders/index', compact('orders', 'q', 'page', 'perPage', 'total', 'totalPages', 'sort', 'direction'));
    }

    public function create(): void
    {
        $errors = [];
        $old = [
            'order_code' => 'BK-2026-' . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT),
            'customer_name' => '',
            'customer_email' => '',
            'customer_phone' => '',
            'total_amount' => 0,
            'status' => 'pending',
            'shipping_address' => '',
            'note' => ''
        ];
        view('orders/create', compact('errors', 'old'));
    }

    public function store(): void
    {
        $data = $this->validateOrder($_POST);
        $errors = $data['errors'];
        $values = $data['values'];

        if (!empty($errors)) {
            $old = $values;
            view('orders/create', compact('errors', 'old'));
            return;
        }

        try {
            $this->repository()->create($values);
            flash_set('success', 'Đơn hàng đã được tạo thành công.');
            redirect('/orders');
        } catch (DuplicateRecordException $e) {
            $errors['order_code'] = 'Mã đơn hàng này đã tồn tại trong hệ thống.';
            $old = $values;
            view('orders/create', compact('errors', 'old'));
        } catch (Exception $e) {
            log_error("Order store: " . $e->getMessage());
            http_response_code(500);
            view('errors/500');
        }
    }

    public function edit(): void
{
    $id = (int) ($_GET['id'] ?? 0);
    $order = $this->repository()->findById($id);

    if (!$order) {
        http_response_code(404);
        view('errors/404');
        return;
    }

    $errors = [];
    $old = $order;
    view('orders/edit', compact('errors', 'old', 'order'));
}

    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $order = $this->repository()->findById($id);

        if (!$order) {
            http_response_code(404);
            view('errors/404');
            return;
        }

        $data = $this->validateOrder($_POST);
        $errors = $data['errors'];
        $values = $data['values'];

        if (!empty($errors)) {
            $old = $values;
            view('orders/edit', compact('errors', 'old', 'order'));
            return;
        }

        try {
            $this->repository()->update($id, $values);
            flash_set('success', 'Đơn hàng đã được cập nhật thành công.');
            redirect('/orders');
        } catch (DuplicateRecordException $e) {
            $errors['order_code'] = 'Mã đơn hàng này đã tồn tại trong hệ thống.';
            $old = $values;
            view('orders/edit', compact('errors', 'old', 'order'));
        } catch (Exception $e) {
            log_error("Order update: " . $e->getMessage());
            http_response_code(500);
            view('errors/500');
        }
    }

    public function delete(): void
    {
        $id = (int) ($_POST['id'] ?? 0);

        try {
            $this->repository()->delete($id);
            flash_set('success', 'Đơn hàng đã được xóa thành công.');
        } catch (Exception $e) {
            log_error("Order delete: " . $e->getMessage());
            flash_set('error', 'Không thể xóa đơn hàng này.');
        }

        redirect('/orders');
    }

    private function validateOrder(array $input): array
    {
        $values = [
            'order_code' => trim($input['order_code'] ?? ''),
            'customer_name' => trim($input['customer_name'] ?? ''),
            'customer_email' => trim($input['customer_email'] ?? ''),
            'customer_phone' => trim($input['customer_phone'] ?? ''),
            'total_amount' => (float) ($input['total_amount'] ?? 0),
            'status' => trim($input['status'] ?? 'pending'),
            'shipping_address' => trim($input['shipping_address'] ?? ''),
            'note' => trim($input['note'] ?? ''),
        ];

        $errors = [];
        $allowedStatuses = ['pending', 'confirmed', 'shipping', 'delivered', 'cancelled'];

        if (empty($values['order_code'])) {
            $errors['order_code'] = 'Vui lòng nhập mã đơn hàng.';
        }

        if (empty($values['customer_name'])) {
            $errors['customer_name'] = 'Vui lòng nhập tên khách hàng.';
        }

        if (!empty($values['customer_email']) && !filter_var($values['customer_email'], FILTER_VALIDATE_EMAIL)) {
            $errors['customer_email'] = 'Email không đúng định dạng.';
        }

        if (!empty($values['customer_phone']) && !preg_match('/^[0-9]{10,11}$/', $values['customer_phone'])) {
            $errors['customer_phone'] = 'Số điện thoại phải có 10-11 chữ số.';
        }

        if ($values['total_amount'] < 0) {
            $errors['total_amount'] = 'Tổng tiền không được âm.';
        }

        if (!in_array($values['status'], $allowedStatuses, true)) {
            $errors['status'] = 'Trạng thái không hợp lệ.';
        }

        return ['values' => $values, 'errors' => $errors];
    }
}