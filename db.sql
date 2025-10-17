-- Database schema for Shanti Ayurveda Clinic Admin Panel

CREATE DATABASE IF NOT EXISTS ayurveda_clinic;
USE ayurveda_clinic;

-- Admin users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin user (password: admin123)
INSERT INTO users (username, password) VALUES ('admin', 'admin123');

-- Doctors table
CREATE TABLE doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    specialization VARCHAR(100),
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Menus table (for navigation)
CREATE TABLE menus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    url VARCHAR(255),
    parent_id INT DEFAULT 0,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default menus
INSERT INTO menus (name, url, parent_id, sort_order) VALUES
('Home', 'index.php', 0, 1),
('About Clinic', 'about.php', 0, 2),
('Services / Treatments', 'services.php', 0, 3),
('Patients Testimonials', 'testimonials.php', 0, 4),
('Blog', 'blog.php', 0, 5),
('Contact', 'contact.php', 0, 6),
('E-commerce', 'shop.php', 0, 7);

-- Blog posts table
CREATE TABLE blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Appointments table
CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    symptoms TEXT,
    preferred_date DATE,
    doctor_id INT,
    status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
    assigned_time DATETIME,
    meet_link VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (doctor_id) REFERENCES doctors(id)
);