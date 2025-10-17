<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}
include '../db.php';

// Get dashboard statistics
$stats = [];

// Safely get statistics with error handling
function getCount($conn, $query) {
    $result = $conn->query($query);
    return ($result && $row = $result->fetch_assoc()) ? $row['count'] : 0;
}

// Get statistics with error handling
$stats['appointments'] = getCount($conn, "SELECT COUNT(*) as count FROM appointments");
$stats['blog_posts'] = getCount($conn, "SELECT COUNT(*) as count FROM blog_posts");
$stats['today_appointments'] = getCount($conn, "SELECT COUNT(*) as count FROM appointments WHERE DATE(preferred_date) = CURDATE()");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Ayurveda Clinic</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .admin-wrapper {
            min-height: 100vh;
            display: flex;
            background: var(--light);
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            background: var(--white);
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .brand-container {
            padding: 1.5rem;
            background: var(--accent);
            color: var(--white);
        }

        .brand-container h2 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .nav-menu {
            padding: 1rem 0;
        }

        .nav-item {
            padding: 0.5rem 1.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--dark);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            background: var(--accent-light);
            color: var(--white);
        }

        .nav-link i {
            width: 24px;
            margin-right: 12px;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 2rem;
            background: var(--bg-gradient);
        }

        /* Header */
        .content-header {
            margin-bottom: 2rem;
        }

        .content-header h1 {
            color: var(--dark);
            margin: 0;
            font-size: 2rem;
            font-weight: 600;
        }

        .breadcrumb {
            color: var(--muted);
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--white);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }

        .stat-icon {
            position: absolute;
            right: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 3rem;
            opacity: 0.1;
            color: var(--accent);
        }

        .stat-title {
            color: var(--muted);
            font-size: 1rem;
            margin: 0 0 0.5rem;
        }

        .stat-value {
            color: var(--dark);
            font-size: 2rem;
            font-weight: 600;
            margin: 0;
        }

        /* Content Area */
        .content-area {
            background: var(--white);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            min-height: 400px;
        }

        /* Responsive Design */
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--dark);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 1rem;
        }

        @media (max-width: 768px) {
            .admin-wrapper {
                position: relative;
            }

            .sidebar {
                position: fixed;
                left: -280px;
                height: 100vh;
            }

            .sidebar.active {
                left: 0;
            }

            .menu-toggle {
                display: block;
                position: fixed;
                top: 1rem;
                left: 1rem;
                z-index: 1001;
                background: var(--white);
                border-radius: 50%;
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            }

            .main-content {
                padding: 1rem;
                padding-top: 4rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--light);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--accent-light);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent);
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <!-- Mobile Menu Toggle -->
        <button class="menu-toggle" id="menuToggle">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="brand-container">
                <h2><i class="fas fa-leaf"></i> Ayurveda Admin</h2>
            </div>
            <nav class="nav-menu">
                <div class="nav-item">
                    <a href="?page=home" class="nav-link <?php echo (!isset($_GET['page']) || $_GET['page'] === 'home') ? 'active' : ''; ?>">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </div>
                <div class="nav-item">
                    <a href="?page=appointments" class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] === 'appointments') ? 'active' : ''; ?>">
                        <i class="fas fa-calendar-check"></i> Appointments
                    </a>
                </div>
                <div class="nav-item">
                    <a href="?page=blog" class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] === 'blog') ? 'active' : ''; ?>">
                        <i class="fas fa-blog"></i> Blog Posts
                    </a>
                </div>
                <div class="nav-item">
                    <a href="?page=menus" class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] === 'menus') ? 'active' : ''; ?>">
                        <i class="fas fa-bars"></i> Menus
                    </a>
                </div>
                <div class="nav-item">
                    <a href="logout.php" class="nav-link">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="content-header">
                <h1>Welcome to Dashboard</h1>
                <div class="breadcrumb">
                    Home / <?php echo ucfirst($_GET['page'] ?? 'Dashboard'); ?>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <i class="fas fa-calendar-check stat-icon"></i>
                    <h3 class="stat-title">Total Appointments</h3>
                    <p class="stat-value"><?php echo $stats['appointments']; ?></p>
                </div>
                
                <div class="stat-card">
                    <i class="fas fa-calendar-day stat-icon"></i>
                    <h3 class="stat-title">Today's Appointments</h3>
                    <p class="stat-value"><?php echo $stats['today_appointments']; ?></p>
                </div>

                <div class="stat-card">
                    <i class="fas fa-blog stat-icon"></i>
                    <h3 class="stat-title">Blog Posts</h3>
                    <p class="stat-value"><?php echo $stats['blog_posts']; ?></p>
                </div>
            </div>

            <!-- Content Area -->
            <div class="content-area">
                <?php
                $page = $_GET['page'] ?? 'home';

                if ($page == 'menus') {
                    include 'manage_menus.php';
                } elseif ($page == 'blog') {
                    include 'manage_blog.php';
                } elseif ($page == 'appointments') {
                    include 'manage_appointments.php';
                } else {
                    echo "<div style='text-align: center; padding: 2rem;'>
                            <i class='fas fa-leaf' style='font-size: 3rem; color: var(--accent); margin-bottom: 1rem;'></i>
                            <h2 style='color: var(--dark); margin-bottom: 1rem;'>Welcome to Ayurveda Clinic Admin Panel</h2>
                            <p style='color: var(--muted);'>Select an option from the sidebar to manage your clinic's content.</p>
                          </div>";
                }
                ?>
            </div>
        </main>
    </div>

    <script>
        // Mobile menu toggle functionality
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        
        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            menuToggle.querySelector('i').classList.toggle('fa-bars');
            menuToggle.querySelector('i').classList.toggle('fa-times');
        });

        // Close sidebar when clicking outside
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 768 && 
                !sidebar.contains(e.target) && 
                !menuToggle.contains(e.target) && 
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
                menuToggle.querySelector('i').classList.add('fa-bars');
                menuToggle.querySelector('i').classList.remove('fa-times');
            }
        });
    </script>
</body>
</html>
