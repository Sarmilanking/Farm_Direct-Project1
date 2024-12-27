-- Create the database
CREATE DATABASE IF NOT EXISTS farms;
USE farms;

-- Create the 'categories' table
CREATE TABLE IF NOT EXISTS categories (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    image VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

-- Create the 'products' table
CREATE TABLE IF NOT EXISTS products (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    PRIMARY KEY (id),
    FOREIGN KEY (category) REFERENCES categories(name) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Create the 'users' table
CREATE TABLE IF NOT EXISTS users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('buyer', 'farmer') DEFAULT 'buyer',
    PRIMARY KEY (id)
);

-- Insert data into 'categories'
INSERT INTO categories (id, name, image) VALUES
(1, 'Fruits', 'images/fruits.jpg'),
(2, 'Vegetables', 'images/vegetables.jpg'),
(3, 'Other', 'images/other.jpg');

-- Insert data into 'products'
INSERT INTO products (id, name, category, price, description, image) VALUES
(1, 'Fresh Apples', 'Fruits', 3.50, 'Fresh organic apples picked locally.', 'images/fresh_apples.jpg'),
(2, 'Carrots', 'Vegetables', 1.20, 'Crunchy and sweet carrots.', 'images/carrots.jpg'),
(3, 'Raw Honey', 'Other', 12.00, 'Pure raw honey from local beekeepers.', 'images/raw_honey.jpg');
