CREATE DATABASE IF NOT EXISTS foodtruckss_store_db;
USE foodtruckss_store_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE foodts_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL,
    description TEXT,  
    image_url VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    item_id INT NOT NULL,
    quantity INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    cardNo VARCHAR(20),
    cvv VARCHAR(5),
    expiry DATE,
    phone_number VARCHAR(20),
    payment_method VARCHAR(20),
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (item_id) REFERENCES foodts_items(id)
);

CREATE TABLE payment_methods (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(20) NOT NULL,
    description VARCHAR(100) NOT NULL
);

INSERT INTO payment_methods (name, description) VALUES 
('card', 'Payment by Card'),
('phone', 'Payment by Phone Number');

INSERT INTO foodts_items (name, price, quantity, description, image_url) VALUES
('Charbroilers', 1.50, 100, 'Description for Charbroilers.', 'images/Charbroilers.jpg'),
('Commercial Gas Griddles and Flat Top Grills', 0.50, 200, 'Description for Commercial Gas Griddles and Flat Top Grills.', 'images/Commercial Gas Griddles and Flat Top Grills.jpg'),
('Hand Sinks and Accessories', 3.00, 50, 'Description for Hand Sinks and Accessories.', 'images/Hand Sinks and Accessories.jpg'),
('Outdoor Coolers', 0.75, 150, 'Description for Outdoor Coolers.', 'images/Outdoor Coolers.jpg');
