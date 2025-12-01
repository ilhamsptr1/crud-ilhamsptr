CREATE DATABASE IF NOT EXISTS sistem_crud;
USE sistem_crud;


CREATE TABLE IF NOT EXISTS produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    harga DECIMAL(10,2) NOT NULL,
    stok INT NOT NULL,
    tanggal_ditambahkan TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO produk (nama, deskripsi, harga, stok) VALUES
('Laptop ASUS', 'Laptop ASUS Core i5, RAM 8GB, SSD 256GB', 8500000, 10),
('Smartphone Samsung', 'Samsung Galaxy S20, 128GB, 8GB RAM', 7500000, 15),
('Mouse Wireless', 'Mouse wireless dengan baterai tahan lama', 250000, 50),
('Keyboard Mechanical', 'Keyboard mekanikal RGB dengan switch blue', 1200000, 20),
('Monitor 24 inch', 'Monitor LED 24 inch Full HD', 1800000, 12);