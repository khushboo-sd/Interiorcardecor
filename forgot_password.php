<?php
include 'config.php';
session_start();

$message = [];

if (isset($_POST['submit'])) {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message[] = "❌ Invalid email format!";
    } else {
        $email_safe = mysqli_real_escape_string($conn, $email);
        $sql = "SELECT * FROM `register` WHERE email='$email_safe' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            $ts = time();
            $hash = hash('sha256', $email . $ts . "SOME_SECRET_KEY");

            $reset_link = "http://localhost/bookstore/reset_password.php?email=" . urlencode($email) . "&ts=$ts&hash=$hash";

            $message[] = "✅ Reset link generated! Click to reset: <a href='$reset_link'>Reset Password</a>";
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
<title>Forgot Password - STF Car Interior Design</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
body {
    font-family: 'Poppins', sans-serif;
    min-height: 100vh;
    display: flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, rgba(10,10,10,0.95), rgba(26,26,46,0.95)),
                url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=1920') center/cover fixed;
}
.login_box {
    width: 400px; background: rgba(26,26,46,0.85); padding: 40px; border-radius: 20px; 
    border: 1px solid rgba(212,175,55,0.3); box-shadow: 0 20px 50px rgba(0,0,0,0.5);
}
form h2 {color:#fff;text-align:center;margin-bottom:30px;}
.inputbox {position:relative;margin:25px 0;}
.inputbox input {
    width:100%;padding:12px;border:none;border-bottom:2px solid rgba(212,175,55,0.3);background:transparent;color:#fff;
}
.inputbox input:focus {border-bottom-color:#d4af37; outline:none;}
.inputbox input::placeholder {color:transparent;}
.inputbox span {
    position:absolute; left:0; top:12px; color:#b8b8b8; pointer-events:none; transition: all 0.3s ease;
}
.inputbox input:focus ~ span,
.inputbox input:not(:placeholder-shown) ~ span {
    top:-10px; font-size:0.85rem; color:#d4af37; font-weight:500;
}
.links {display:flex;justify-content:flex-end;margin:20px 0;}
.links a {color:#b8b8b8;text-decoration:none;}
.links a:hover {color:#d4af37;}
input[type="submit"] {
    width:100%;padding:12px;border:none;border-radius:50px;
    background:linear-gradient(135deg,#d4af37,#f4e5c3);color:#0a0a0a;font-weight:600;cursor:pointer;
}
.message {background:rgba(212,175,55,0.95);color:#0a0a0a;padding:15px;margin-bottom:20px;border-radius:10px;}
</style>
</head>
<body>

<div class="login_box">
    <form action="" method="post">
        <h2>Forgot Password</h2>
        <?php
        if(!empty($message)){
            foreach($message as $msg){
                echo "<div class='message'>$msg</div>";
            }
        }
        ?>
        <div class="inputbox">
            <input type="email" name="email" required placeholder=" ">
            <span>Email</span>
        </div>
        <div class="links">
            <a href="login.php">Back to Login</a>
        </div>
        <input type="submit" name="submit" value="Generate Reset Link">
    </form>
</div>

</body>
</html>
