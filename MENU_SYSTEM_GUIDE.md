# Menu Management System - Updated Features

## 🎉 New Features Added

### 1. **Automatic PHP File Creation**
When you create a menu with "Custom Page" checkbox enabled, the system will automatically:
- Create a PHP file with the specified filename
- Generate database entry for storing page content
- Create a beautiful page template ready to use

### 2. **Rich Text Editor (Like Google Blogs)**
The system now includes TinyMCE editor with features like:
- **Text Formatting**: Bold, Italic, Underline, Colors
- **Headings**: H1, H2, H3, H4, H5, H6
- **Lists**: Bullet points, Numbered lists
- **Alignment**: Left, Center, Right, Justify
- **Images**: Upload and insert images
- **Links**: Add hyperlinks
- **Tables**: Create and manage tables
- **Media**: Embed videos and other media
- **Code View**: See and edit HTML code
- **Undo/Redo**: Full history support
- **Full Screen Mode**: Distraction-free editing

### 3. **SEO Features**
- Meta Title for search engines
- Meta Description for better SEO
- Custom URL slugs

## 📋 Installation Steps

### Step 1: Update Database
Run the `update_db.sql` file to add new tables and columns:

```bash
# Option 1: Using MySQL command line
mysql -u root -p ayurveda_clinic < update_db.sql

# Option 2: Using phpMyAdmin
# 1. Open phpMyAdmin
# 2. Select 'ayurveda_clinic' database
# 3. Go to 'Import' tab
# 4. Choose 'update_db.sql' file
# 5. Click 'Go'

# Option 3: Using terminal with XAMPP
/opt/lampp/bin/mysql -u root ayurveda_clinic < update_db.sql
```

### Step 2: Set Permissions
Make sure the images/uploads directory has write permissions:

```bash
chmod -R 777 images/uploads
```

## 🚀 How to Use

### Creating a New Menu with Custom Page

1. **Go to Admin Panel** → Manage Menus
2. **Fill in the form:**
   - **Menu Name**: Enter the display name (e.g., "Our Services")
   - **URL/File Name**: Enter filename (e.g., "our-services.php")
   - **Parent Menu**: Select if it's a submenu
   - **Sort Order**: Enter number for ordering
   - **Meta Title**: SEO title (optional)
   - **Meta Description**: SEO description (optional)
   - **Custom Page Checkbox**: ✅ Keep it checked to create PHP file
3. **Click "Add Menu & Create Page"**

The system will:
- ✅ Create database entry
- ✅ Create PHP file in root directory
- ✅ Create content storage in database

### Editing Page Content

1. **Click the Edit (✏️) button** next to the menu
2. **Use the Rich Text Editor** to add content:
   - Type your content
   - Format text using toolbar
   - Add images by clicking image icon
   - Create tables, lists, etc.
3. **Click "Update Menu & Page"**

### Adding Images

**Method 1: Upload via Editor**
1. Click the image icon in toolbar
2. Choose "Upload" tab
3. Select image from computer
4. Image will be automatically uploaded to `images/uploads/`

**Method 2: Drag & Drop**
1. Drag image directly into the editor
2. It will be automatically uploaded

## 📁 File Structure

```
ayurveda-clinic-main/
├── admin/
│   ├── manage_menus.php       # Main menu management (updated)
│   ├── edit_menu.php           # Edit menu & content (NEW)
│   ├── delete_menu.php         # Delete menu & files (NEW)
│   └── upload_image.php        # Image upload handler (NEW)
├── images/
│   └── uploads/                # Image uploads directory (NEW)
├── update_db.sql               # Database update script (NEW)
└── your-custom-pages.php       # Auto-generated pages
```

## 🗄️ Database Tables

### New Table: `menu_pages`
Stores page content for each menu item:
- `id`: Primary key
- `menu_id`: Foreign key to menus table
- `content`: Page content (HTML)
- `created_at`: Creation timestamp
- `updated_at`: Last update timestamp

### Updated Table: `menus`
New columns added:
- `meta_title`: SEO title
- `meta_description`: SEO description
- `is_custom_page`: Flag for custom pages (0 or 1)

## 🎨 Features of Rich Text Editor

### Toolbar Options:
- **Undo/Redo**: Ctrl+Z / Ctrl+Y
- **Format**: Paragraph, Headings, Pre
- **Bold**: Ctrl+B
- **Italic**: Ctrl+I
- **Text Color**: Choose any color
- **Background Color**: Highlight text
- **Alignment**: Left, Center, Right, Justify
- **Lists**: Bullets, Numbers, Indent/Outdent
- **Insert Image**: Upload or paste URL
- **Insert Link**: Add hyperlinks
- **Insert Table**: Create tables
- **Insert Media**: Embed videos
- **Code View**: Edit HTML directly
- **Preview**: See how it looks
- **Full Screen**: F11

## 🔒 Security Features

- Session-based authentication
- SQL injection protection
- File type validation for uploads
- Secure file naming (prevents overwrites)
- Foreign key constraints

## 💡 Tips

1. **Image Optimization**: Compress images before uploading for better performance
2. **SEO**: Always fill Meta Title and Description for better search rankings
3. **URL Structure**: Use lowercase and hyphens (e.g., `about-us.php`)
4. **Content Backup**: Database stores all content - you can restore anytime
5. **File Naming**: Avoid spaces in filenames - use hyphens instead

## 🐛 Troubleshooting

### Images not uploading?
```bash
# Check permissions
chmod -R 777 images/uploads
```

### Database errors?
```bash
# Make sure update_db.sql is executed
# Check if tables exist
mysql -u root -p -e "SHOW TABLES FROM ayurveda_clinic;"
```

### PHP file not created?
- Check if "Custom Page" checkbox is enabled
- Verify write permissions on root directory
- Check error logs in Apache

## 📞 Support

For issues or questions, check:
- Error logs: `/opt/lampp/logs/error_log`
- PHP info: Visit `phpinfo.php` in browser
- Database: Use phpMyAdmin to verify data

---

**Version**: 2.0  
**Last Updated**: October 2025  
**Compatible with**: PHP 7.4+, MySQL 5.7+
