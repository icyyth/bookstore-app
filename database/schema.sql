-- Tạo database
CREATE DATABASE bookstore_db;
GO

USE bookstore_db;
GO

-- Bảng users
CREATE TABLE users (
    id INT IDENTITY(1,1) PRIMARY KEY,
    name NVARCHAR(100) NOT NULL,
    email NVARCHAR(150) NOT NULL UNIQUE,
    password_hash NVARCHAR(255) NOT NULL,
    role NVARCHAR(20) NOT NULL DEFAULT 'staff',
    status NVARCHAR(20) NOT NULL DEFAULT 'active',
    created_at DATETIME DEFAULT GETDATE(),
    updated_at DATETIME DEFAULT GETDATE()
);
GO

-- Bảng books (Module A)
CREATE TABLE books (
    id INT IDENTITY(1,1) PRIMARY KEY,
    isbn NVARCHAR(20) NOT NULL UNIQUE,
    title NVARCHAR(200) NOT NULL,
    author NVARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    category NVARCHAR(50) NOT NULL DEFAULT 'general',
    description NVARCHAR(MAX),
    status NVARCHAR(20) NOT NULL DEFAULT 'available',
    created_at DATETIME NOT NULL DEFAULT GETDATE(),
    updated_at DATETIME NULL
);
GO

CREATE INDEX idx_books_title ON books(title);
CREATE INDEX idx_books_category ON books(category);
CREATE INDEX idx_books_status_created_at ON books(status, created_at);
CREATE INDEX idx_books_price ON books(price);
GO

-- Bảng orders (Module B)
CREATE TABLE orders (
    id INT IDENTITY(1,1) PRIMARY KEY,
    order_code NVARCHAR(50) NOT NULL UNIQUE,
    customer_name NVARCHAR(100) NOT NULL,
    customer_email NVARCHAR(150) NULL,
    customer_phone NVARCHAR(20) NULL,
    total_amount DECIMAL(12,2) NOT NULL DEFAULT 0,
    status NVARCHAR(30) NOT NULL DEFAULT 'pending',
    shipping_address NVARCHAR(MAX) NULL,
    note NVARCHAR(MAX) NULL,
    created_at DATETIME NOT NULL DEFAULT GETDATE(),
    updated_at DATETIME NULL
);
GO

CREATE INDEX idx_orders_created_at ON orders(created_at);
CREATE INDEX idx_orders_status_created_at ON orders(status, created_at);
CREATE INDEX idx_orders_customer_email ON orders(customer_email);
CREATE INDEX idx_orders_customer_phone ON orders(customer_phone);
GO