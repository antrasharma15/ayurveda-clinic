<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu System Demo - Shanti Ayurveda</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
        }
        .demo-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .demo-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        .demo-header h1 {
            color: #8b7355;
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        .demo-header p {
            color: #666;
            font-size: 1.2rem;
        }
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }
        .feature-card {
            padding: 2rem;
            background: #f9f9f9;
            border-radius: 12px;
            border-left: 4px solid #8b7355;
        }
        .feature-card h3 {
            color: #8b7355;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .feature-card ul {
            list-style: none;
            padding: 0;
        }
        .feature-card li {
            padding: 0.5rem 0;
            color: #333;
        }
        .feature-card li::before {
            content: "✓";
            color: #8b7355;
            font-weight: bold;
            margin-right: 0.5rem;
        }
        .test-section {
            margin-top: 3rem;
            padding: 2rem;
            background: #e8f5e9;
            border-radius: 12px;
        }
        .test-section h2 {
            color: #2e7d32;
            margin-bottom: 1rem;
        }
        .test-steps {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            margin-top: 1rem;
        }
        .test-steps ol {
            padding-left: 1.5rem;
        }
        .test-steps li {
            padding: 0.5rem 0;
            color: #333;
            line-height: 1.6;
        }
        @media (max-width: 768px) {
            .demo-container {
                padding: 1rem;
            }
            .demo-header h1 {
                font-size: 1.8rem;
            }
            .feature-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    
    <!-- Include the responsive navigation -->
    <?php include 'includes/navigation.php'; ?>
    
    <div class="demo-container">
        <div class="demo-header">
            <h1><i class="fas fa-rocket"></i> Menu System Demo Page</h1>
            <p>Testing Responsive Navigation & Dynamic Page Creation</p>
        </div>
        
        <div class="feature-grid">
            <div class="feature-card">
                <h3><i class="fas fa-check-circle"></i> Admin Features</h3>
                <ul>
                    <li>Create menus from admin panel</li>
                    <li>Auto PHP file generation</li>
                    <li>Rich text editor (CKEditor)</li>
                    <li>Image upload support</li>
                    <li>SEO meta tags</li>
                    <li>Parent/child menu structure</li>
                </ul>
            </div>
            
            <div class="feature-card">
                <h3><i class="fas fa-mobile-alt"></i> Responsive Design</h3>
                <ul>
                    <li>Mobile hamburger menu</li>
                    <li>Tablet optimized layout</li>
                    <li>Desktop dropdown menus</li>
                    <li>Touch-friendly buttons</li>
                    <li>Smooth animations</li>
                    <li>Auto-adjusting content</li>
                </ul>
            </div>
            
            <div class="feature-card">
                <h3><i class="fas fa-code"></i> Technical Features</h3>
                <ul>
                    <li>Database-driven menus</li>
                    <li>Dynamic content loading</li>
                    <li>No API key required</li>
                    <li>Clean URL structure</li>
                    <li>Secure file handling</li>
                    <li>SQL injection protection</li>
                </ul>
            </div>
        </div>
        
        <div class="test-section">
            <h2><i class="fas fa-vial"></i> Test This Demo</h2>
            <div class="test-steps">
                <h3>Desktop Test:</h3>
                <ol>
                    <li>Hover over menu items in the navigation bar</li>
                    <li>Check if submenus appear on hover</li>
                    <li>Click any menu item to navigate</li>
                    <li>Verify smooth animations and transitions</li>
                </ol>
                
                <h3>Mobile Test:</h3>
                <ol>
                    <li>Resize browser window to < 968px (or press F12 → Toggle Device)</li>
                    <li>Click the hamburger icon (☰) in top-right</li>
                    <li>Menu should slide in from left with overlay</li>
                    <li>Click menus with arrow (▼) to expand submenus</li>
                    <li>Click outside menu to close</li>
                </ol>
                
                <h3>Admin Panel Test:</h3>
                <ol>
                    <li>Go to <code>admin/login.php</code></li>
                    <li>Login with admin credentials</li>
                    <li>Go to "Manage Menus"</li>
                    <li>Create a new menu with custom page ✓</li>
                    <li>Edit the menu and add content using CKEditor</li>
                    <li>Visit the created page - content should display perfectly!</li>
                </ol>
            </div>
        </div>
        
        <div style="margin-top: 3rem; padding: 2rem; background: #fff3e0; border-radius: 12px; border-left: 4px solid #ff9800;">
            <h3 style="color: #e65100; margin-bottom: 1rem;">
                <i class="fas fa-exclamation-triangle"></i> Important Notes
            </h3>
            <ul style="color: #333; line-height: 1.8;">
                <li><strong>Database Required:</strong> Make sure you've run <code>update_db.sql</code></li>
                <li><strong>Permissions:</strong> <code>images/uploads/</code> must have write permissions (777)</li>
                <li><strong>Navigation:</strong> This page includes <code>includes/navigation.php</code></li>
                <li><strong>No API Key:</strong> CKEditor works without any API key!</li>
                <li><strong>Responsive:</strong> Resize window to test all breakpoints</li>
            </ul>
        </div>
    </div>
    
    <script>
        // Show current viewport width for testing
        function showViewport() {
            const width = window.innerWidth;
            const mode = width > 968 ? 'Desktop' : width > 768 ? 'Tablet' : 'Mobile';
            console.log(`Viewport: ${width}px - Mode: ${mode}`);
        }
        
        showViewport();
        window.addEventListener('resize', showViewport);
    </script>
</body>
</html>
