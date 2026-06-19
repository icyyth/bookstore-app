USE bookstore_db;
GO

-- Insert users
INSERT INTO users (name, email, password_hash, role) VALUES
(N'Admin User', 'admin@bookstore.com', '$2y$10$examplehashadmin', 'admin'),
(N'Sales Staff', 'sales@bookstore.com', '$2y$10$examplehashstaff', 'staff');
GO

-- Insert books
INSERT INTO books (isbn, title, author, price, stock, category, description, status) VALUES
('978-3-16-148410-0', N'Clean Code', N'Robert C. Martin', 450000, 10, 'programming', N'A handbook of agile software craftsmanship.', 'available'),
('978-0-13-235088-4', N'The Pragmatic Programmer', N'David Thomas', 520000, 8, 'programming', N'Your journey to mastery.', 'available'),
('978-0-59-600712-6', N'Design Patterns', N'Erich Gamma', 380000, 5, 'programming', N'Elements of reusable object-oriented software.', 'available'),
('978-1-49-190499-6', N'You Don''t Know JS', N'Kyle Simpson', 290000, 12, 'programming', N'JavaScript book series.', 'available'),
('978-0-32-112521-7', N'Refactoring', N'Martin Fowler', 420000, 6, 'programming', N'Improving the design of existing code.', 'available'),
('978-0-20-161622-4', N'The Mythical Man-Month', N'Frederick Brooks', 350000, 3, 'programming', N'Essays on software engineering.', 'available'),
('978-0-13-110362-7', N'The C Programming Language', N'Brian Kernighan', 280000, 4, 'programming', N'The classic C language book.', 'available'),
('978-0-59-600895-6', N'Head First Design Patterns', N'Eric Freeman', 390000, 7, 'programming', N'A brain-friendly guide.', 'available'),
('978-1-84-668166-0', N'Domain-Driven Design', N'Eric Evans', 480000, 2, 'programming', N'Tackling complexity in software.', 'available'),
('978-0-13-117705-4', N'Code Complete', N'Steve McConnell', 540000, 9, 'programming', N'A practical handbook of software construction.', 'available'),
('978-0-59-600108-7', N'JavaScript: The Good Parts', N'Douglas Crockford', 210000, 15, 'programming', N'The good parts of JavaScript.', 'available'),
('978-0-13-235088-4', N'Introduction to Algorithms', N'Thomas Cormen', 640000, 5, 'programming', N'The MIT press algorithms book.', 'available'),
('978-0-59-600443-9', N'Learning Python', N'Mark Lutz', 370000, 0, 'programming', N'Python programming language.', 'out_of_stock'),
('978-0-13-790700-1', N'Database System Concepts', N'Abraham Silberschatz', 510000, 8, 'database', N'Database fundamentals textbook.', 'available'),
('978-0-59-600923-6', N'SQL Performance Explained', N'Markus Winand', 320000, 6, 'database', N'Everything developers need to know.', 'available');
GO

-- Insert orders
INSERT INTO orders (order_code, customer_name, customer_email, customer_phone, total_amount, status, shipping_address) VALUES
('BK-2026-0001', N'Nguyen Van An', 'an.nguyen@email.com', '0909000001', 850000, 'delivered', N'123 Le Loi Street, District 1, HCMC'),
('BK-2026-0002', N'Tran Thi Binh', 'binh.tran@email.com', '0909000002', 520000, 'shipping', N'456 Nguyen Hue Street, District 3, HCMC'),
('BK-2026-0003', N'Le Van Cuong', 'cuong.le@email.com', '0909000003', 1380000, 'confirmed', N'789 Vo Van Tan Street, District 10, HCMC'),
('BK-2026-0004', N'Pham Thi Dung', 'dung.pham@email.com', '0909000004', 290000, 'pending', N'321 Cach Mang Thang 8 Street, District 10, HCMC'),
('BK-2026-0005', N'Hoang Minh', 'minh.hoang@email.com', '0909000005', 1160000, 'pending', N'654 Pham Ngoc Thach Street, District 3, HCMC'),
('BK-2026-0006', N'Nguyen Thu Huong', 'huong.nguyen@email.com', '0909000006', 370000, 'cancelled', N'987 Dien Bien Phu Street, Binh Thanh District, HCMC');
GO