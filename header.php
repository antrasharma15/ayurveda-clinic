<?php
include 'db.php';
$sql = "SELECT * FROM menus WHERE parent_id = 0 ORDER BY sort_order";
$main_menus = $conn->query($sql);
?>
<header class="site-header">
    <div class="header-content">
        <div class="brand">
            <div class="logo">SA</div>
            <div>
                <div style="font-weight:800">Sikhar Ayurveda Clinic</div>
                <div class="muted" style="font-size:13px">Holistic care • Panchakarma • Natural healing</div>
            </div>
        </div>
        <nav class="nav" aria-label="Primary" id="primaryNav">
            <?php while ($menu = $main_menus->fetch_assoc()) { ?>
                <div class="menu-item">
                    <a href="<?php echo $menu['url']; ?>"><?php echo $menu['name']; ?></a>
                    <?php
                    $sub_sql = "SELECT * FROM menus WHERE parent_id = {$menu['id']} ORDER BY sort_order";
                    $sub_menus = $conn->query($sub_sql);
                    if ($sub_menus->num_rows > 0) {
                        echo '<div class="submenu">';
                        while ($sub = $sub_menus->fetch_assoc()) {
                            echo '<a href="' . $sub['url'] . '">' . $sub['name'] . '</a>';
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
            <?php } ?>
            <a class="cta" href="book_appointment.php">Book Appointment</a>
        </nav>
        <button id="hamburger" aria-label="Open menu" aria-expanded="false">☰</button>
    </div>
</header>
