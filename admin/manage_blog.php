
<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $sql = "INSERT INTO blog_posts (title, content) VALUES ('$title', '$content')";
    $conn->query($sql);
    header('Location: dashboard.php?page=blog');
    exit();
}

// Fetch blog posts
$sql = "SELECT * FROM blog_posts ORDER BY created_at DESC";
$result = $conn->query($sql);
$posts = [];
while ($row = $result->fetch_assoc()) {
    $posts[] = $row;
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
.blog-section {
    max-width: 900px;
    margin: 2rem auto;
    padding: 2rem;
    background: var(--card);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
}
.blog-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 2rem;
}
.blog-header h2 {
    color: var(--accent-dark);
    margin: 0;
    font-size: 2rem;
}
.blog-form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 2.5rem;
}
.blog-form input, .blog-form textarea {
    padding: 0.75rem 1rem;
    border: 1px solid var(--accent-light);
    border-radius: 8px;
    font-size: 1rem;
    background: var(--white);
    color: var(--dark);
}
.blog-form textarea {
    min-height: 100px;
    resize: vertical;
}
.blog-form button {
    align-self: flex-start;
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
.blog-form button:hover {
    background: var(--accent-dark);
}
.blog-table-wrapper {
    overflow-x: auto;
}
.blog-table {
    width: 100%;
    border-collapse: collapse;
    background: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
}
.blog-table th, .blog-table td {
    padding: 0.75rem 1rem;
    text-align: left;
}
.blog-table th {
    background: var(--accent-light);
    color: var(--dark);
    font-weight: 600;
    border-bottom: 2px solid var(--accent);
}
.blog-table tr {
    transition: background 0.2s;
}
.blog-table tr:hover {
    background: var(--light);
}
.blog-table td {
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
.action-btn.view { background: var(--accent-light); }
.action-btn.edit { background: #ffe082; color: var(--dark); }
.action-btn.edit:hover { background: #ffd54f; color: var(--dark); }
.action-btn.delete { background: #ffbdbd; color: var(--dark); }
.action-btn.delete:hover { background: #ff5252; color: var(--white); }
@media (max-width: 768px) {
    .blog-section {
        padding: 1rem;
    }
    .blog-header h2 {
        font-size: 1.3rem;
    }
    .blog-table th, .blog-table td {
        padding: 0.5rem 0.5rem;
        font-size: 0.95rem;
    }
}
</style>

<div class="blog-section">
    <div class="blog-header">
        <h2><i class="fas fa-blog"></i> Manage Blog</h2>
    </div>
    <form method="POST" class="blog-form">
        <input type="text" name="title" placeholder="Blog Title" required>
        <textarea name="content" placeholder="Blog Content" required></textarea>
        <button type="submit"><i class="fas fa-plus"></i> Add Post</button>
    </form>
    <div class="blog-table-wrapper">
        <table class="blog-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($post['title']); ?></td>
                    <td><?php echo htmlspecialchars($post['created_at']); ?></td>
                    <td>
                        <div class="action-btns">
                            <a href="view_blog.php?id=<?php echo $post['id']; ?>" class="action-btn view" title="View"><i class="fas fa-eye"></i></a>
                            <a href="edit_blog.php?id=<?php echo $post['id']; ?>" class="action-btn edit" title="Edit"><i class="fas fa-edit"></i></a>
                            <a href="delete_blog.php?id=<?php echo $post['id']; ?>" class="action-btn delete" title="Delete" onclick="return confirm('Are you sure you want to delete this post?');"><i class="fas fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
