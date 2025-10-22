<?php
// Fetch menus from database
include_once 'db.php';

$sql = "SELECT * FROM menus WHERE parent_id = 0 ORDER BY sort_order ASC";
$main_menus = $conn->query($sql);

// Function to get submenus
function getSubmenus($parent_id, $conn) {
    $sql = "SELECT * FROM menus WHERE parent_id = $parent_id ORDER BY sort_order ASC";
    return $conn->query($sql);
}
?>

<!-- Responsive Navigation Bar -->
<nav class="main-navigation">
    <div class="nav-container">
        <!-- Logo/Brand -->
        <div class="nav-brand">
            <a href="index.php">
                <h2>Shanti Ayurveda</h2>
            </a>
        </div>
        
        <!-- Mobile Menu Toggle -->
        <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">
            <span class="hamburger"></span>
            <span class="hamburger"></span>
            <span class="hamburger"></span>
        </button>
        
        <!-- Navigation Menu -->
        <ul class="nav-menu" id="navMenu">
            <?php while($menu = $main_menus->fetch_assoc()): ?>
                <?php 
                    $submenus = getSubmenus($menu['id'], $conn);
                    $has_submenu = $submenus->num_rows > 0;
                ?>
                
                <li class="nav-item <?php echo $has_submenu ? 'has-submenu' : ''; ?>">
                    <a href="<?php echo htmlspecialchars($menu['url']); ?>" class="nav-link">
                        <?php echo htmlspecialchars($menu['name']); ?>
                        <?php if($has_submenu): ?>
                            <i class="fas fa-chevron-down submenu-icon"></i>
                        <?php endif; ?>
                    </a>
                    
                    <?php if($has_submenu): ?>
                        <ul class="submenu">
                            <?php while($submenu = $submenus->fetch_assoc()): ?>
                                <li class="submenu-item">
                                    <a href="<?php echo htmlspecialchars($submenu['url']); ?>" class="submenu-link">
                                        <?php echo htmlspecialchars($submenu['name']); ?>
                                    </a>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</nav>

<style>
/* Reset & Base Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Navigation Container */
.main-navigation {
    background: linear-gradient(135deg, #8b7355 0%, #6b5644 100%);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    position: sticky;
    top: 0;
    z-index: 1000;
    width: 100%;
}

.nav-container {
    max-width: 1400px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 2rem;
    position: relative;
}

/* Brand/Logo */
.nav-brand {
    padding: 1rem 0;
}

.nav-brand a {
    text-decoration: none;
    color: white;
}

.nav-brand h2 {
    font-size: 1.8rem;
    font-weight: 700;
    color: white;
    letter-spacing: 0.5px;
}

/* Mobile Toggle Button */
.nav-toggle {
    display: none;
    flex-direction: column;
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 0.5rem;
    z-index: 1001;
}

.hamburger {
    width: 25px;
    height: 3px;
    background: white;
    margin: 3px 0;
    transition: all 0.3s ease;
    border-radius: 3px;
}

/* Navigation Menu */
.nav-menu {
    display: flex;
    list-style: none;
    align-items: center;
    gap: 0.5rem;
}

.nav-item {
    position: relative;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 0.3rem;
    padding: 1.2rem 1rem;
    color: white;
    text-decoration: none;
    font-weight: 500;
    font-size: 1rem;
    transition: all 0.3s ease;
    position: relative;
}

.nav-link:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #f5f1ed;
}

.nav-link::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 3px;
    background: white;
    transition: all 0.3s ease;
    transform: translateX(-50%);
}

.nav-link:hover::after {
    width: 80%;
}

.submenu-icon {
    font-size: 0.7rem;
    transition: transform 0.3s ease;
}

.has-submenu:hover .submenu-icon {
    transform: rotate(180deg);
}

/* Submenu Dropdown */
.submenu {
    position: absolute;
    top: 100%;
    left: 0;
    background: white;
    list-style: none;
    min-width: 220px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    border-radius: 0 0 8px 8px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    z-index: 999;
}

.has-submenu:hover .submenu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.submenu-item {
    border-bottom: 1px solid #f0f0f0;
}

.submenu-item:last-child {
    border-bottom: none;
}

.submenu-link {
    display: block;
    padding: 0.9rem 1.2rem;
    color: #333;
    text-decoration: none;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.submenu-link::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 3px;
    background: #8b7355;
    transform: scaleY(0);
    transition: transform 0.3s ease;
}

.submenu-link:hover {
    background: #f5f1ed;
    color: #8b7355;
    padding-left: 1.5rem;
}

.submenu-link:hover::before {
    transform: scaleY(1);
}

/* Mobile Responsive */
@media (max-width: 968px) {
    .nav-toggle {
        display: flex;
    }
    
    .nav-menu {
        position: fixed;
        left: -100%;
        top: 0;
        flex-direction: column;
        background: white;
        width: 280px;
        height: 100vh;
        padding: 5rem 0 2rem;
        box-shadow: 5px 0 15px rgba(0, 0, 0, 0.1);
        transition: left 0.4s ease;
        overflow-y: auto;
        align-items: flex-start;
        gap: 0;
    }
    
    .nav-menu.active {
        left: 0;
    }
    
    .nav-item {
        width: 100%;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .nav-link {
        color: #333;
        padding: 1rem 1.5rem;
        width: 100%;
        justify-content: space-between;
    }
    
    .nav-link::after {
        display: none;
    }
    
    .nav-link:hover {
        background: #f5f1ed;
        color: #8b7355;
    }
    
    /* Mobile Submenu */
    .submenu {
        position: static;
        opacity: 0;
        visibility: hidden;
        max-height: 0;
        transform: none;
        box-shadow: none;
        border-radius: 0;
        background: #f9f9f9;
        overflow: hidden;
        transition: all 0.4s ease;
    }
    
    .has-submenu.active .submenu {
        opacity: 1;
        visibility: visible;
        max-height: 500px;
    }
    
    .has-submenu.active .submenu-icon {
        transform: rotate(180deg);
    }
    
    .submenu-link {
        padding: 0.8rem 1.5rem 0.8rem 2.5rem;
        font-size: 0.9rem;
    }
    
    .submenu-link:hover {
        padding-left: 3rem;
    }
    
    /* Hamburger Animation */
    .nav-toggle.active .hamburger:nth-child(1) {
        transform: rotate(45deg) translate(5px, 5px);
    }
    
    .nav-toggle.active .hamburger:nth-child(2) {
        opacity: 0;
    }
    
    .nav-toggle.active .hamburger:nth-child(3) {
        transform: rotate(-45deg) translate(7px, -6px);
    }
    
    /* Overlay */
    .nav-menu.active::before {
        content: '';
        position: fixed;
        top: 0;
        left: 280px;
        width: calc(100vw - 280px);
        height: 100vh;
        background: rgba(0, 0, 0, 0.5);
        z-index: -1;
    }
}

@media (max-width: 480px) {
    .nav-brand h2 {
        font-size: 1.4rem;
    }
    
    .nav-container {
        padding: 0 1rem;
    }
    
    .nav-menu {
        width: 250px;
    }
    
    .nav-menu.active::before {
        left: 250px;
        width: calc(100vw - 250px);
    }
}
</style>

<script>
// Mobile Navigation Toggle
document.addEventListener('DOMContentLoaded', function() {
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');
    const hasSubmenuItems = document.querySelectorAll('.has-submenu');
    
    // Toggle mobile menu
    if (navToggle) {
        navToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            navToggle.classList.toggle('active');
            document.body.style.overflow = navMenu.classList.contains('active') ? 'hidden' : '';
        });
    }
    
    // Handle submenu clicks on mobile
    hasSubmenuItems.forEach(item => {
        const link = item.querySelector('.nav-link');
        
        link.addEventListener('click', function(e) {
            if (window.innerWidth <= 968) {
                e.preventDefault();
                
                // Close other submenus
                hasSubmenuItems.forEach(otherItem => {
                    if (otherItem !== item) {
                        otherItem.classList.remove('active');
                    }
                });
                
                // Toggle current submenu
                item.classList.toggle('active');
            }
        });
    });
    
    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (!navToggle.contains(e.target) && !navMenu.contains(e.target)) {
            navMenu.classList.remove('active');
            navToggle.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
    
    // Close submenu on window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 968) {
            navMenu.classList.remove('active');
            navToggle.classList.remove('active');
            document.body.style.overflow = '';
            hasSubmenuItems.forEach(item => item.classList.remove('active'));
        }
    });
});
</script>
