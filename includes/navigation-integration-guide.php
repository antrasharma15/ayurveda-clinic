<!-- 
    RESPONSIVE NAVIGATION INTEGRATION GUIDE
    Include this in your header.php or any page where you want navigation
-->

<?php
// Make sure db.php is included
if (!isset($conn)) {
    include_once 'db.php';
}
?>

<!-- Include the responsive navigation -->
<?php include_once 'includes/navigation.php'; ?>

<!-- 
    ALTERNATIVE: If you want to include it manually in any page:
    
    <?php include 'includes/navigation.php'; ?>
    
    This will automatically:
    ✅ Load menus from database
    ✅ Display main menus
    ✅ Display submenus (parent_id > 0)
    ✅ Work on mobile with hamburger menu
    ✅ Work on desktop with dropdown
-->

<!-- Example Page Structure: -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    
    <!-- Include Navigation -->
    <?php include 'includes/navigation.php'; ?>
    
    <!-- Your Page Content -->
    <main>
        <div class="container">
            <!-- Your content here -->
        </div>
    </main>
    
    <!-- Footer -->
    <footer>
        <!-- Your footer content -->
    </footer>
    
    <script src="js/main.js"></script>
</body>
</html>

<!--
    NOTES:
    
    1. Navigation automatically:
       - Fetches menus from database
       - Sorts by sort_order
       - Shows main menus (parent_id = 0)
       - Shows submenus under their parents
       - Responsive on all devices
    
    2. Mobile Features:
       - Hamburger icon appears < 968px
       - Slide menu from left
       - Click to expand submenus
       - Overlay background
       - Touch-friendly
    
    3. Desktop Features:
       - Horizontal menu bar
       - Hover to show submenus
       - Smooth animations
       - Dropdown positioning
    
    4. Customization:
       - Colors: Edit in includes/navigation.php (CSS section)
       - Breakpoint: Change @media (max-width: 968px)
       - Logo: Edit .nav-brand section
       - Effects: Modify transition properties
-->
