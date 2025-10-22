<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

include '../db.php';

$menu_id = (int)($_GET['id'] ?? 0);

if ($menu_id == 0) {
    header('Location: dashboard.php?page=menus');
    exit();
}

// Fetch menu details
$sql = "SELECT * FROM menus WHERE id = $menu_id";
$result = $conn->query($sql);
$menu = $result->fetch_assoc();

if (!$menu) {
    header('Location: dashboard.php?page=menus');
    exit();
}

// Fetch menu content
$sql_content = "SELECT * FROM menu_pages WHERE menu_id = $menu_id";
$result_content = $conn->query($sql_content);
$menu_content = $result_content->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $url = $conn->real_escape_string($_POST['url']);
    $parent_id = (int)($_POST['parent_id'] ?? 0);
    $sort_order = (int)($_POST['sort_order'] ?? 0);
    $is_custom_page = isset($_POST['is_custom_page']) ? 1 : 0;
    $meta_title = $conn->real_escape_string($_POST['meta_title'] ?? '');
    $meta_description = $conn->real_escape_string($_POST['meta_description'] ?? '');
    $content = $_POST['content'] ?? '';
    
    // Update menu
    $sql = "UPDATE menus SET 
            name = '$name', 
            url = '$url', 
            parent_id = $parent_id, 
            sort_order = $sort_order,
            is_custom_page = $is_custom_page,
            meta_title = '$meta_title',
            meta_description = '$meta_description'
            WHERE id = $menu_id";
    $conn->query($sql);
    
    // Update or insert menu content
    if ($menu_content) {
        $sql_update = "UPDATE menu_pages SET content = '$content' WHERE menu_id = $menu_id";
        $conn->query($sql_update);
    } else {
        $sql_insert = "INSERT INTO menu_pages (menu_id, content) VALUES ($menu_id, '$content')";
        $conn->query($sql_insert);
    }
    
    // Update the PHP file if it's a custom page
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu - Shanti Ayurveda Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.ckeditor.com/4.22.1/standard-all/ckeditor.js"></script>
    <style>
        :root {
            --accent: #8b7355;
            --accent-dark: #6b5644;
            --accent-light: #f5f1ed;
            --white: #ffffff;
            --light: #f9f9f9;
            --dark: #333;
            --card: #ffffff;
            --shadow: 0 2px 8px rgba(0,0,0,0.1);
            --border-radius: 12px;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--light);
            padding: 2rem;
        }
        .edit-container {
            max-width: 1200px;
            margin: 0 auto;
            background: var(--card);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 2rem;
        }
        .edit-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--accent-light);
        }
        .edit-header h2 {
            color: var(--accent-dark);
            font-size: 2rem;
        }
        .back-btn {
            background: var(--accent-light);
            color: var(--dark);
            padding: 0.7rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s;
            font-weight: 600;
        }
        .back-btn:hover {
            background: var(--accent);
            color: var(--white);
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--dark);
            font-weight: 600;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--accent-light);
            border-radius: 8px;
            font-size: 1rem;
            background: var(--white);
            color: var(--dark);
        }
        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .checkbox-group input[type="checkbox"] {
            width: auto;
        }
        .submit-btn {
            background: var(--accent);
            color: var(--white);
            border: none;
            border-radius: 8px;
            padding: 1rem 2rem;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.2s;
            font-weight: 600;
            width: 100%;
            margin-top: 1rem;
        }
        .submit-btn:hover {
            background: var(--accent-dark);
        }
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            body {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="edit-container">
        <div class="edit-header">
            <h2><i class="fas fa-edit"></i> Edit Menu</h2>
            <a href="dashboard.php?page=menus" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Menus</a>
        </div>
        
        <form method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label for="name">Menu Name *</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($menu['name']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="url">URL/File Name *</label>
                    <input type="text" id="url" name="url" value="<?php echo htmlspecialchars($menu['url']); ?>" placeholder="e.g., my-page.php" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="parent_id">Parent Menu</label>
                    <select id="parent_id" name="parent_id">
                        <option value="0">Main Menu</option>
                        <?php 
                        $sql_menus = "SELECT * FROM menus WHERE id != $menu_id AND parent_id = 0 ORDER BY sort_order";
                        $result_menus = $conn->query($sql_menus);
                        while ($m = $result_menus->fetch_assoc()) {
                            $selected = ($m['id'] == $menu['parent_id']) ? 'selected' : '';
                            echo "<option value='".$m['id']."' $selected>".htmlspecialchars($m['name'])."</option>";
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="sort_order">Sort Order</label>
                    <input type="number" id="sort_order" name="sort_order" value="<?php echo htmlspecialchars($menu['sort_order']); ?>" placeholder="0">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="meta_title">Meta Title (SEO)</label>
                    <input type="text" id="meta_title" name="meta_title" value="<?php echo htmlspecialchars($menu['meta_title'] ?? ''); ?>" placeholder="Page title for search engines">
                </div>
                
                <div class="form-group checkbox-group">
                    <input type="checkbox" id="is_custom_page" name="is_custom_page" value="1" <?php echo ($menu['is_custom_page'] ?? 0) ? 'checked' : ''; ?>>
                    <label for="is_custom_page">Create Custom Page with Content Editor</label>
                </div>
            </div>
            
            <div class="form-group">
                <label for="meta_description">Meta Description (SEO)</label>
                <textarea id="meta_description" name="meta_description" placeholder="Brief description for search engines"><?php echo htmlspecialchars($menu['meta_description'] ?? ''); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="content">Page Content</label>
                <textarea id="content" name="content"><?php echo htmlspecialchars($menu_content['content'] ?? ''); ?></textarea>
            </div>
            
            <button type="submit" class="submit-btn"><i class="fas fa-save"></i> Update Menu & Page</button>
        </form>
    </div>
    
    <script>
        CKEDITOR.replace('content', {
            height: 500,
            // Full toolbar with all features
            toolbarGroups: [
                { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
                { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
                { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
                { name: 'forms', groups: [ 'forms' ] },
                '/',
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
                { name: 'links', groups: [ 'links' ] },
                { name: 'insert', groups: [ 'insert' ] },
                '/',
                { name: 'styles', groups: [ 'styles' ] },
                { name: 'colors', groups: [ 'colors' ] },
                { name: 'tools', groups: [ 'tools' ] },
                { name: 'others', groups: [ 'others' ] },
                { name: 'about', groups: [ 'about' ] }
            ],
            // Remove any restriction
            removeButtons: '',
            // Enable all features
            extraPlugins: 'uploadimage,image2,colorbutton,font,justify,preview',
            // Image upload settings
            filebrowserUploadUrl: 'upload_image.php',
            filebrowserUploadMethod: 'form',
            uploadUrl: 'upload_image.php',
            // Allow all content
            allowedContent: true,
            // Enhanced features
            removeDialogTabs: '',
            format_tags: 'p;h1;h2;h3;h4;h5;h6;pre;address;div',
            // Color picker
            colorButton_colors: '000,800000,8B4513,2F4F4F,008080,000080,4B0082,696969,' +
                'B22222,A52A2A,DAA520,006400,40E0D0,0000CD,800080,808080,' +
                'F00,FF8C00,FFD700,008000,0FF,00F,EE82EE,A9A9A9,' +
                'FFA07A,FFA500,FFFF00,00FF00,AFEEEE,ADD8E6,DDA0DD,D3D3D3,' +
                'FFF0F5,FAEBD7,FFFFE0,F0FFF0,F0FFFF,F0F8FF,E6E6FA,FFF',
            colorButton_enableMore: true
        });
        
        // Handle image upload
        CKEDITOR.on('fileUploadRequest', function(evt) {
            var fileLoader = evt.data.fileLoader;
            var formData = new FormData();
            var xhr = fileLoader.xhr;
            
            xhr.open('POST', fileLoader.uploadUrl, true);
            formData.append('file', fileLoader.file, fileLoader.fileName);
            fileLoader.xhr.send(formData);
            
            evt.stop();
        });
        
        CKEDITOR.on('fileUploadResponse', function(evt) {
            evt.stop();
            var data = evt.data;
            var xhr = data.fileLoader.xhr;
            var response = JSON.parse(xhr.responseText);
            
            if (response.location) {
                data.url = response.location;
            } else if (response.error) {
                data.message = response.error;
                evt.cancel();
            }
        });
    </script>
</body>
</html>
