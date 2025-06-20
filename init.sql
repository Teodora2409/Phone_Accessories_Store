CREATE DATABASE phone_store
use phone_store
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    description TEXT,
    price DECIMAL(10,2)
);

INSERT INTO products (name, description, price) VALUES
('Phone Case', 'Durable phone case', 12.99),
('Screen Protector', 'Tempered glass', 8.49),
('Wireless Charger', 'Fast charging pad', 19.99);
