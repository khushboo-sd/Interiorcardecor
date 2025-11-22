<?php
// Get cart count for header badge
$cart_row_number = 0;
if (isset($user_id) && $user_id) {
    $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'") or die('Cart query failed');
    $cart_row_number = mysqli_num_rows($select_cart_number);
}

// Get session data for account box
$user_name = $_SESSION['user_name'] ?? 'Guest';
$user_email = $_SESSION['user_email'] ?? 'Not logged in';

// Get current page for active link
$current_page = basename($_SERVER['PHP_SELF']);
?>

<style>
/* --- Message Notifications --- */
.message {
    position: fixed;
    top: 100px;
    right: 20px;
    background: rgba(212, 175, 55, 0.95);
    color: #0a0a0a;
    padding: 18px 28px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    gap: 15px;
    z-index: 10000;
    box-shadow: 0 10px 30px rgba(212, 175, 55, 0.4);
    animation: slideInRight 0.4s ease forwards;
    font-weight: 500;
}
@keyframes slideInRight {
    from { transform: translateX(300px); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}
.message i {
    cursor: pointer;
    font-size: 1.2rem;
    transition: transform 0.3s ease;
}
.message i:hover { transform: rotate(90deg); }

.message .success-icon {
    color: #0f9d58; /* green tick color */
    font-size: 1.2rem;
}

/* --- Header --- */
.user_header {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 1000;
    background: #000;
    box-shadow: 0 5px 30px rgba(0,0,0,0.4);
}
.header_placeholder {
    max-width: 1600px;
    margin: 0 auto;
    padding: 0 3%;
}
.user_flex {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 0;
}

/* --- Left Title --- */
.site_title {
    color: #d4af37;
    font-size: 1.4rem;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    text-decoration: none;
}

/* --- Navbar --- */
.navbar {
    display: flex;
    gap: 35px;
    align-items: center;
    margin: 0 auto;
}
.navbar a {
    color: #f2f2f2;
    text-decoration: none;
    font-size: 1.05rem;
    font-weight: 500;
    position: relative;
    transition: color 0.3s ease;
}
.navbar a::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 0;
    height: 2px;
    background: #d4af37;
    transition: width 0.3s ease;
}
.navbar a:hover, .navbar a.active { color: #d4af37; }
.navbar a:hover::after, .navbar a.active::after { width: 100%; }

/* --- Right Section --- */
.last_part {
    display: flex;
    align-items: center;
    gap: 25px;
}
.loginorreg p { color: #e0e0e0; font-size: 0.95rem; }
.loginorreg a { color: #d4af37; font-weight: 600; text-decoration: none; }
.loginorreg a:hover { color: #f4e5c3; }

/* --- Icons --- */
.icons {
    display: flex;
    align-items: center;
    gap: 20px;
    font-size: 1.2rem;
}
.icons a, .icons div, .icons i {
    color: #fff;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
}
.icons a:hover, .icons div:hover, .icons i:hover {
    color: #d4af37;
    transform: scale(1.1);
}
.icons .quantity {
    position: absolute;
    top: -8px;
    right: -12px;
    background: #d4af37;
    color: #0a0a0a;
    font-size: 0.7rem;
    padding: 2px 6px;
    border-radius: 10px;
    font-weight: 700;
}

/* --- Account Box --- */
.header_acc_box {
    position: absolute;
    top: 100%;
    right: 3%;
    background: rgba(20,20,20,0.98);
    border: 1px solid rgba(212,175,55,0.3);
    border-radius: 15px;
    padding: 25px;
    min-width: 280px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.5);
    display: none;
}
.header_acc_box.active {
    display: block;
    animation: fadeInDown 0.3s ease;
}
@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
.header_acc_box p { color: #e0e0e0; margin-bottom: 15px; }
.header_acc_box span { color: #d4af37; font-weight: 600; }

.delete-btn {
    display: inline-block;
    padding: 12px 30px;
    background: linear-gradient(135deg, #d4af37, #f4e5c3);
    color: #0a0a0a;
    border-radius: 25px;
    font-weight: 600;
    text-decoration: none;
}
.delete-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(212,175,55,0.4);
}

/* --- Responsive --- */
#user_menu_btn { display: none; }
@media (max-width: 968px) {
    .navbar {
        position: fixed;
        top: 76px;
        left: -100%;
        width: 100%;
        background: #000;
        flex-direction: column;
        padding: 30px;
        gap: 20px;
        transition: left 0.3s ease;
    }
    .navbar.active { left: 0; }
    #user_menu_btn { display: block; }
    .loginorreg { display: none; }
}
</style>

<?php
// --- Message Popup ---
if (isset($message) && !empty($message)) {
    foreach ($message as $msg) {
        echo '
        <div class="message">
            <i class="fa-solid fa-circle-check success-icon"></i>
            <span>' . htmlspecialchars($msg) . '</span>
        </div>
        ';
    }
}
?>

<header class="user_header">
    <div class="header_placeholder">
        <div class="user_flex">

            <a href="home.php" class="site_title">Interior Car Decor</a>

            <nav class="navbar">
                <a href="home.php" class="<?php echo ($current_page == 'home.php') ? 'active' : ''; ?>">Home</a>
                <a href="shop.php" class="<?php echo ($current_page == 'shop.php') ? 'active' : ''; ?>">Shop</a>
                <a href="orders.php" class="<?php echo ($current_page == 'orders.php') ? 'active' : ''; ?>">Order</a>
                <a href="about.php" class="<?php echo ($current_page == 'about.php') ? 'active' : ''; ?>">About</a>
                <a href="contact.php" class="<?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>">Contact</a>
            </nav>

            <div class="last_part">
                <div class="loginorreg">
                    <p><a href="login.php">Login</a> / <a href="register.php">Register</a></p>
                </div>

                <div class="icons">
                    <a class="fa-solid fa-magnifying-glass" href="search_page.php"></a>
                    <div class="fas fa-user" id="user_btn"></div>
                    <a href="cart.php">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="quantity">(<?php echo $cart_row_number; ?>)</span>
                    </a>
                    <div class="fas fa-bars" id="user_menu_btn"></div>
                </div>
            </div>

            <div class="header_acc_box">
                <p>Username: <span><?php echo htmlspecialchars($user_name); ?></span></p>
                <p>Email: <span><?php echo htmlspecialchars($user_email); ?></span></p>
                <a href="logout.php" class="delete-btn">Logout</a>
            </div>

        </div>
    </div>
</header>

<script>
// Toggle account box
document.getElementById('user_btn').addEventListener('click', () => {
    document.querySelector('.header_acc_box').classList.toggle('active');
});

// Mobile menu toggle
document.getElementById('user_menu_btn').addEventListener('click', () => {
    document.querySelector('.navbar').classList.toggle('active');
});

// Close account box when clicking outside
document.addEventListener('click', (e) => {
    if (!e.target.closest('.icons') && !e.target.closest('.header_acc_box')) {
        document.querySelector('.header_acc_box').classList.remove('active');
    }
});

// Auto-hide messages after 3 seconds
setTimeout(() => {
    document.querySelectorAll('.message').forEach(msg => {
        msg.style.transition = 'opacity 0.5s ease';
        msg.style.opacity = '0';
        setTimeout(() => msg.remove(), 500);
    });
}, 3000);
</script>
