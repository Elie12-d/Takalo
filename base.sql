DROP DATABASE IF EXISTS revision_final_s3;
CREATE DATABASE revision_final_s3;
use revision_final_s3;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255)
);
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    description VARCHAR(255),
    status VARCHAR(255),
    created_at DATE
);
CREATE TABLE objets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    name VARCHAR(255),
    description TEXT,
    category_id INT,
    created_at DATE,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);
INSERT INTO categories (name, description, status, created_at) VALUES ('Category 1', 'Description for Category 1', 'active', CURDATE());