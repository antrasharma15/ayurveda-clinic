
<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $url = $conn->real_escape_string($_POST['url']);
    $parent_id = (int)($_POST['parent_id'] ?? 0);
    $sort_order = (int)($_POST['sort_order'] ?? 0);
    $sql = "INSERT INTO menus (name, url, parent_id, sort_order) VALUES ('$name', '$url', $parent_id, $sort_order)";
    $conn->query($sql);
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
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 2.5rem;
    align-items: flex-end;
}
.menus-form input, .menus-form select {
    padding: 0.75rem 1rem;
    border: 1px solid var(--accent-light);
    border-radius: 8px;
    font-size: 1rem;
    background: var(--white);
    color: var(--dark);
    flex: 1 1 180px;
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
        <input type="text" name="name" placeholder="Menu Name" required>
        <input type="text" name="url" placeholder="URL">
        <select name="parent_id">
            <option value="0">Main Menu</option>
            <?php foreach ($menus as $menu) { if ($menu['parent_id'] == 0) echo "<option value='".htmlspecialchars($menu['id'])."'>".htmlspecialchars($menu['name'])."</option>"; } ?>
        </select>
        <input type="number" name="sort_order" placeholder="Sort Order">
        <button type="submit"><i class="fas fa-plus"></i> Add Menu</button>
    </form>
    <div class="menus-table-wrapper">
        <table class="menus-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>URL</th>
                    <th>Type</th>
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
