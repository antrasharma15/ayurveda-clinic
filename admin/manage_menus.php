
<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $url = $conn->real_escape_string($_POST['url']);
    $parent_id = (int)($_POST['parent_id'] ?? 0);
    $sort_order = (int)($_POST['sort_order'] ?? 0);
    $is_custom_page = isset($_POST['is_custom_page']) ? 1 : 0;
    $meta_title = $conn->real_escape_string($_POST['meta_title'] ?? '');
    $meta_description = $conn->real_escape_string($_POST['meta_description'] ?? '');
    
    // Insert menu
    $sql = "INSERT INTO menus (name, url, parent_id, sort_order, is_custom_page, meta_title, meta_description) 
            VALUES ('$name', '$url', $parent_id, $sort_order, $is_custom_page, '$meta_title', '$meta_description')";
    $conn->query($sql);
    
    $menu_id = $conn->insert_id;
    
    // Create empty content entry
    $conn->query("INSERT INTO menu_pages (menu_id, content) VALUES ($menu_id, '')");
    
    // Create PHP file if it's a custom page
    if ($is_custom_page && !empty($url)) {
        $file_path = '../' . $url;
        $file_content = "<?php
include 'header.php';
include 'db.php';

// Fetch content from database
\$menu_id = $menu_id;
\$sql = \"SELECT mp.*, m.name, m.meta_title, m.meta_description FROM menu_pages mp JOIN menus m ON mp.menu_id = m.id WHERE mp.menu_id = \$menu_id\";
\$result = \$conn->query(\$sql);
\$page_data = \$result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title><?php echo htmlspecialchars(\$page_data['meta_title'] ?? \$page_data['name']); ?></title>
    <meta name=\"description\" content=\"<?php echo htmlspecialchars(\$page_data['meta_description'] ?? ''); ?>\">
    <link rel=\"stylesheet\" href=\"css/style.css\">
    <link rel=\"stylesheet\" href=\"css/custom-pages.css\">
    <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css\">
</head>
<body>
    <div class=\"page-container\">
        <div class=\"content-wrapper\">
            <h1><?php echo htmlspecialchars(\$page_data['name']); ?></h1>
            <div class=\"page-content\">
                <?php echo \$page_data['content']; ?>
            </div>
        </div>
    </div>
    <script src=\"js/main.js\"></script>
</body>
</html>";
        
        file_put_contents($file_path, $file_content);
    }
    header('Location: dashboard.php?page=menus');
    exit();
}

// Fetch menus
$sql = "SELECT * FROM menus ORDER BY sort_order";
$result = $conn->query($sql);
$menus = [];
while ($row = $result->fetch_assoc()) {
    $menus[] = $row;
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
.menus-section {
    max-width: 900px;
    margin: 2rem auto;
    padding: 2rem;
    background: var(--card);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
}
.menus-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 2rem;
}
.menus-header h2 {
    color: var(--accent-dark);
    margin: 0;
    font-size: 2rem;
}
.menus-form {
    display: flex;
<<<<<<< HEAD
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 2.5rem;
    align-items: flex-end;
}
.menus-form input, .menus-form select {
=======
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 2.5rem;
}
.menus-form .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}
.menus-form .form-group {
    display: flex;
    flex-direction: column;
}
.menus-form label {
    margin-bottom: 0.3rem;
    font-weight: 600;
    color: var(--dark);
    font-size: 0.9rem;
}
.menus-form input, .menus-form select, .menus-form textarea {
>>>>>>> 115ea196c (Add menu system, CKEditor, responsive navigation, and DB update script)
    padding: 0.75rem 1rem;
    border: 1px solid var(--accent-light);
    border-radius: 8px;
    font-size: 1rem;
    background: var(--white);
    color: var(--dark);
<<<<<<< HEAD
    flex: 1 1 180px;
=======
}
.menus-form textarea {
    min-height: 80px;
    resize: vertical;
    font-family: inherit;
}
.checkbox-wrapper {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 0;
}
.checkbox-wrapper input[type="checkbox"] {
    width: auto;
    cursor: pointer;
}
.checkbox-wrapper label {
    margin: 0;
    cursor: pointer;
>>>>>>> 115ea196c (Add menu system, CKEditor, responsive navigation, and DB update script)
}
.menus-form button {
    background: var(--accent);
    color: var(--white);
    border: none;
    border-radius: 8px;
    padding: 0.7rem 1.5rem;
    font-size: 1rem;
    cursor: pointer;
    transition: background 0.2s;
    font-weight: 600;
}
.menus-form button:hover {
    background: var(--accent-dark);
}
.menus-table-wrapper {
    overflow-x: auto;
}
.menus-table {
    width: 100%;
    border-collapse: collapse;
    background: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
}
.menus-table th, .menus-table td {
    padding: 0.75rem 1rem;
    text-align: left;
}
.menus-table th {
    background: var(--accent-light);
    color: var(--dark);
    font-weight: 600;
    border-bottom: 2px solid var(--accent);
}
.menus-table tr {
    transition: background 0.2s;
}
.menus-table tr:hover {
    background: var(--light);
}
.menus-table td {
    border-bottom: 1px solid #eee;
    vertical-align: middle;
}
.action-btns {
    display: flex;
    gap: 0.5rem;
}
.action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.4rem 0.7rem;
    border: none;
    border-radius: 6px;
    background: var(--accent-light);
    color: var(--dark);
    font-size: 1rem;
    cursor: pointer;
    transition: background 0.2s, color 0.2s;
    text-decoration: none;
}
.action-btn:hover {
    background: var(--accent);
    color: var(--white);
}
.action-btn.edit { background: #ffe082; color: var(--dark); }
.action-btn.edit:hover { background: #ffd54f; color: var(--dark); }
.action-btn.delete { background: #ffbdbd; color: var(--dark); }
.action-btn.delete:hover { background: #ff5252; color: var(--white); }
@media (max-width: 768px) {
    .menus-section {
        padding: 1rem;
    }
    .menus-header h2 {
        font-size: 1.3rem;
    }
    .menus-table th, .menus-table td {
        padding: 0.5rem 0.5rem;
        font-size: 0.95rem;
    }
}
</style>

<div class="menus-section">
    <div class="menus-header">
        <h2><i class="fas fa-bars"></i> Manage Menus</h2>
    </div>
    <form method="POST" class="menus-form">
<<<<<<< HEAD
        <input type="text" name="name" placeholder="Menu Name" required>
        <input type="text" name="url" placeholder="URL">
        <select name="parent_id">
            <option value="0">Main Menu</option>
            <?php foreach ($menus as $menu) { if ($menu['parent_id'] == 0) echo "<option value='".htmlspecialchars($menu['id'])."'>".htmlspecialchars($menu['name'])."</option>"; } ?>
        </select>
        <input type="number" name="sort_order" placeholder="Sort Order">
        <button type="submit"><i class="fas fa-plus"></i> Add Menu</button>
=======
        <div class="form-row">
            <div class="form-group">
                <label for="name">Menu Name *</label>
                <input type="text" id="name" name="name" placeholder="Menu Name" required>
            </div>
            <div class="form-group">
                <label for="url">URL/File Name *</label>
                <input type="text" id="url" name="url" placeholder="e.g., my-page.php" required>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="parent_id">Parent Menu</label>
                <select id="parent_id" name="parent_id">
                    <option value="0">Main Menu</option>
                    <?php foreach ($menus as $menu) { if ($menu['parent_id'] == 0) echo "<option value='".htmlspecialchars($menu['id'])."'>".htmlspecialchars($menu['name'])."</option>"; } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="sort_order">Sort Order</label>
                <input type="number" id="sort_order" name="sort_order" placeholder="0">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="meta_title">Meta Title (SEO)</label>
                <input type="text" id="meta_title" name="meta_title" placeholder="Page title for search engines">
            </div>
            <div class="form-group">
                <div class="checkbox-wrapper">
                    <input type="checkbox" id="is_custom_page" name="is_custom_page" value="1" checked>
                    <label for="is_custom_page">Create Custom Page with Content Editor</label>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label for="meta_description">Meta Description (SEO)</label>
            <textarea id="meta_description" name="meta_description" placeholder="Brief description for search engines"></textarea>
        </div>
        
        <button type="submit"><i class="fas fa-plus"></i> Add Menu & Create Page</button>
>>>>>>> 115ea196c (Add menu system, CKEditor, responsive navigation, and DB update script)
    </form>
    <div class="menus-table-wrapper">
        <table class="menus-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>URL</th>
                    <th>Type</th>
<<<<<<< HEAD
=======
                    <th>Custom Page</th>
>>>>>>> 115ea196c (Add menu system, CKEditor, responsive navigation, and DB update script)
                    <th>Sort Order</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($menus as $menu) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($menu['name']); ?></td>
                    <td><?php echo htmlspecialchars($menu['url']); ?></td>
                    <td><?php echo $menu['parent_id'] > 0 ? 'Submenu' : 'Main Menu'; ?></td>
<<<<<<< HEAD
=======
                    <td><?php echo ($menu['is_custom_page'] ?? 0) ? '<i class="fas fa-check" style="color: green;"></i> Yes' : '<i class="fas fa-times" style="color: red;"></i> No'; ?></td>
>>>>>>> 115ea196c (Add menu system, CKEditor, responsive navigation, and DB update script)
                    <td><?php echo htmlspecialchars($menu['sort_order']); ?></td>
                    <td>
                        <div class="action-btns">
                            <a href="edit_menu.php?id=<?php echo $menu['id']; ?>" class="action-btn edit" title="Edit"><i class="fas fa-edit"></i></a>
                            <a href="delete_menu.php?id=<?php echo $menu['id']; ?>" class="action-btn delete" title="Delete" onclick="return confirm('Are you sure you want to delete this menu?');"><i class="fas fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
