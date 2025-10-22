<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

include '../db.php';

$menu_id = (int)($_GET['id'] ?? 0);

if ($menu_id > 0) {
    // Get menu details first
    $sql = "SELECT url, is_custom_page FROM menus WHERE id = $menu_id";
    $result = $conn->query($sql);
    $menu = $result->fetch_assoc();
    
    // Delete associated page content
    $conn->query("DELETE FROM menu_pages WHERE menu_id = $menu_id");
    
    // Delete the menu
    $conn->query("DELETE FROM menus WHERE id = $menu_id");
    
    // Delete the PHP file if it exists and is a custom page
    if ($menu && $menu['is_custom_page'] == 1 && !empty($menu['url'])) {
        $file_path = '../' . $menu['url'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
}

header('Location: dashboard.php?page=menus');
exit();
?>
