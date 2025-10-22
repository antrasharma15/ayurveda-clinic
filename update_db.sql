-- Update script for existing ayurveda_clinic database
-- Run this file to update your existing database with new features

USE ayurveda_clinic;

-- Add new table for storing menu page content
CREATE TABLE IF NOT EXISTS menu_pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    menu_id INT NOT NULL,
    content LONGTEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (menu_id) REFERENCES menus(id) ON DELETE CASCADE
);

-- Add index for better performance
CREATE INDEX idx_menu_id ON menu_pages(menu_id);

-- Add meta fields to menus table if they don't exist
ALTER TABLE menus ADD COLUMN IF NOT EXISTS meta_title VARCHAR(255) DEFAULT NULL;
ALTER TABLE menus ADD COLUMN IF NOT EXISTS meta_description TEXT DEFAULT NULL;
ALTER TABLE menus ADD COLUMN IF NOT EXISTS is_custom_page TINYINT(1) DEFAULT 0;
