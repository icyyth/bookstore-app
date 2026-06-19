<?php
class BookController
{
    private function repository(): BookRepository
    {
        $config = require __DIR__ . '/../../config/database.php';
        $pdo = (new Database($config))->getConnection();
        return new BookRepository($pdo);
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

        $books = $repo->getPaginated($q, $perPage, $offset, $sort, $direction);

        view('books/index', compact('books', 'q', 'page', 'perPage', 'total', 'totalPages', 'sort', 'direction'));
    }

    public function create(): void
    {
        $errors = [];
        $old = ['isbn' => '', 'title' => '', 'author' => '', 'price' => '', 'stock' => '', 'category' => 'general', 'description' => '', 'status' => 'available'];
        view('books/create', compact('errors', 'old'));
    }

    public function store(): void
    {
        $data = $this->validateBook($_POST);
        $errors = $data['errors'];
        $values = $data['values'];

        if (!empty($errors)) {
            $old = $values;
            view('books/create', compact('errors', 'old'));
            return;
        }

        try {
            $this->repository()->create($values);
            flash_set('success', 'Sách đã được thêm thành công.');
            redirect('/books');
        } catch (DuplicateRecordException $e) {
            $errors['isbn'] = 'ISBN này đã tồn tại trong hệ thống.';
            $old = $values;
            view('books/create', compact('errors', 'old'));
        } catch (Exception $e) {
            log_error("Book store: " . $e->getMessage());
            http_response_code(500);
            view('errors/500');
        }
    }

   public function edit(): void
{
    $id = (int) ($_GET['id'] ?? 0);
    $book = $this->repository()->findById($id);

    if (!$book) {
        http_response_code(404);
        view('errors/404');
        return;
    }

    $errors = [];
    $old = $book;
    view('books/edit', compact('errors', 'old', 'book'));
}

    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $book = $this->repository()->findById($id);

        if (!$book) {
            http_response_code(404);
            view('errors/404');
            return;
        }

        $data = $this->validateBook($_POST);
        $errors = $data['errors'];
        $values = $data['values'];

        if (!empty($errors)) {
            $old = $values;
            view('books/edit', compact('errors', 'old', 'book'));
            return;
        }

        try {
            $this->repository()->update($id, $values);
            flash_set('success', 'Sách đã được cập nhật thành công.');
            redirect('/books');
        } catch (DuplicateRecordException $e) {
            $errors['isbn'] = 'ISBN này đã tồn tại trong hệ thống.';
            $old = $values;
            view('books/edit', compact('errors', 'old', 'book'));
        } catch (Exception $e) {
            log_error("Book update: " . $e->getMessage());
            http_response_code(500);
            view('errors/500');
        }
    }

    public function delete(): void
    {
        $id = (int) ($_POST['id'] ?? 0);

        try {
            $this->repository()->delete($id);
            flash_set('success', 'Sách đã được xóa thành công.');
        } catch (Exception $e) {
            log_error("Book delete: " . $e->getMessage());
            flash_set('error', 'Không thể xóa sách này.');
        }

        redirect('/books');
    }

    private function validateBook(array $input): array
    {
        $values = [
            'isbn' => trim($input['isbn'] ?? ''),
            'title' => trim($input['title'] ?? ''),
            'author' => trim($input['author'] ?? ''),
            'price' => (float) ($input['price'] ?? 0),
            'stock' => (int) ($input['stock'] ?? 0),
            'category' => trim($input['category'] ?? 'general'),
            'description' => trim($input['description'] ?? ''),
            'status' => trim($input['status'] ?? 'available'),
        ];

        $errors = [];
        $allowedCategories = ['programming', 'database', 'web', 'mobile', 'general', 'design'];
        $allowedStatuses = ['available', 'out_of_stock', 'discontinued'];

        if (empty($values['isbn'])) {
            $errors['isbn'] = 'Vui lòng nhập ISBN.';
        }

        if (empty($values['title'])) {
            $errors['title'] = 'Vui lòng nhập tên sách.';
        }

        if (empty($values['author'])) {
            $errors['author'] = 'Vui lòng nhập tên tác giả.';
        }

        if ($values['price'] <= 0) {
            $errors['price'] = 'Giá sách phải lớn hơn 0.';
        }

        if ($values['stock'] < 0) {
            $errors['stock'] = 'Số lượng tồn không được âm.';
        }

        if (!in_array($values['category'], $allowedCategories, true)) {
            $errors['category'] = 'Danh mục không hợp lệ.';
        }

        if (!in_array($values['status'], $allowedStatuses, true)) {
            $errors['status'] = 'Trạng thái không hợp lệ.';
        }

        return ['values' => $values, 'errors' => $errors];
    }
}