<?php
include 'config.php';
session_start();

$message = [];

if (isset($_POST['reset_btn'])) {
    $email = trim($_POST['email']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message[] = "❌ Invalid email format!";
    } elseif (empty($new_password) || empty($confirm_password)) {
        $message[] = "❌ Password fields cannot be empty!";
    } elseif ($new_password !== $confirm_password) {
        $message[] = "❌ Passwords do not match!";
    } else {
        // Check if user exists
        $email_safe = mysqli_real_escape_string($conn, $email);
        $check_user = mysqli_query($conn, "SELECT * FROM register WHERE email='$email_safe' LIMIT 1");

        if (mysqli_num_rows($check_user) > 0) {
            // ✅ Store plain password (no encryption)
            $plain_password = mysqli_real_escape_string($conn, $new_password);
            mysqli_query($conn, "UPDATE register SET password='$plain_password' WHERE email='$email_safe'");
            $message[] = "✅ Password reset successfully! You can now login.";
        } else {
            $message[] = "❌ No account found with this email!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset Password - STF Car Interior Design</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
* {margin:0;padding:0;box-sizing:border-box;}
body {
    font-family: 'Poppins', sans-serif;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, rgba(10,10,10,0.95), rgba(26,26,46,0.95)),
                url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=1920') center/cover fixed;
    position: relative;
    overflow: hidden;
}
body::before {
    content: '';
    position: absolute; top:0; left:0; width:100%; height:100%;
    background: radial-gradient(circle at 50% 50%, rgba(212,175,55,0.1), transparent 70%);
    animation: pulse 8s ease-in-out infinite;
}
@keyframes pulse {0%,100%{opacity:0.3;}50%{opacity:0.6;}}
.message {
    position: fixed; top:20px; right:20px; background: rgba(212,175,55,0.95);
    color:#0a0a0a; padding:20px 30px; border-radius:15px; display:flex; align-items:center;
    gap:20px; z-index:10000; box-shadow:0 10px 30px rgba(212,175,55,0.4);
    animation: slideInRight 0.5s ease; font-weight:500; max-width:400px;
}
@keyframes slideInRight {from{transform:translateX(400px);opacity:0;}to{transform:translateX(0);opacity:1;}}
.reset_box {
    position: relative; z-index: 2; width:450px;
    background: rgba(26,26,46,0.85); backdrop-filter: blur(20px);
    border:1px solid rgba(212,175,55,0.3); border-radius:25px; padding:50px 40px;
    box-shadow:0 25px 60px rgba(0,0,0,0.5);
}
form h2 {
    font-size:2.5rem; color:#fff; text-align:center; margin-bottom:15px; font-weight:700;
    background:linear-gradient(135deg,#d4af37,#f4e5c3);
    -webkit-background-clip:text; -webkit-text-fill-color:transparent;
}
form h2::after {
    content:''; display:block; width:80px; height:3px;
    background:linear-gradient(135deg,#d4af37,#f4e5c3); margin:15px auto 30px; border-radius:2px;
}
.inputbox {position:relative; margin:35px 0;}
.inputbox input {
    width:100%; padding:15px 0; font-size:1rem; color:#fff; background:transparent;
    border:none; border-bottom:2px solid rgba(212,175,55,0.3); outline:none; 
}
.inputbox input:focus {border-bottom-color:#d4af37;}
.inputbox span {
    position:absolute; left:0; top:15px; font-size:1rem; color:#b8b8b8; pointer-events:none;
    transition: all 0.3s ease;
}
.inputbox input:focus ~ span,
.inputbox input:not(:placeholder-shown) ~ span {
    top: -10px; font-size:0.85rem; color:#d4af37; font-weight:500;
}
.inputbox i {
    position: absolute;
    right: 10px;
    top: 15px;
    color: #b8b8b8;
    cursor: pointer;
    transition: color 0.3s ease;
}
.inputbox i.active { color: #d4af37; }
input[type="submit"] {
    width:100%; padding:15px; background:linear-gradient(135deg,#d4af37,#f4e5c3);
    color:#0a0a0a; border:none; border-radius:50px; font-size:1.1rem; font-weight:600;
    cursor:pointer; transition:all 0.4s ease; text-transform:uppercase; letter-spacing:1px;
    box-shadow:0 10px 30px rgba(212,175,55,0.3); margin-top:10px;
}
input[type="submit"]:hover {
    transform:translateY(-3px); box-shadow:0 15px 40px rgba(212,175,55,0.5);
    background:linear-gradient(135deg,#f4e5c3,#d4af37);
}
.links {display:flex; justify-content:flex-end; margin-top:10px;}
.links a {color:#b8b8b8; font-size:0.9rem; text-decoration:none; transition:color 0.3s ease;}
.links a:hover {color:#d4af37;}
</style>
</head>
<body>

<?php
if (!empty($message)) {
    foreach ($message as $msg) {
        echo "<div class='message'><span>$msg</span></div>";
    }
}
?>

<div class="reset_box">
    <form action="" method="post">
        <h2>Reset Password</h2>

        <div class="inputbox">
            <input type="email" name="email" required placeholder=" ">
            <span>Email</span>
        </div>

        <div class="inputbox">
            <input type="password" name="new_password" id="new_password" required placeholder=" ">
            <span>New Password</span>
            <i class="fa-solid fa-eye" id="toggleNewPassword"></i>
        </div>

        <div class="inputbox">
            <input type="password" name="confirm_password" id="confirm_password" required placeholder=" ">
            <span>Confirm Password</span>
            <i class="fa-solid fa-eye" id="toggleConfirmPassword"></i>
        </div>

        <input type="submit" value="Reset Password" name="reset_btn">
        <div class="links">
            <a href="login.php">Back to Login</a>
        </div>
    </form>
</div>

<script>
// Auto-hide messages after 5s
setTimeout(() => {
    const messages = document.querySelectorAll('.message');
    messages.forEach(msg => {
        msg.style.animation = 'slideOutRight 0.5s ease forwards';
        setTimeout(() => msg.remove(), 500);
    });
}, 5000);

// Password visibility toggle
function togglePassword(toggleId, inputId) {
    const toggle = document.getElementById(toggleId);
    const input = document.getElementById(inputId);

    toggle.addEventListener('click', () => {
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        toggle.classList.toggle('fa-eye-slash');
        toggle.classList.toggle('active');
    });
}

togglePassword('toggleNewPassword', 'new_password');
togglePassword('toggleConfirmPassword', 'confirm_password');
</script>

</body>
</html>
