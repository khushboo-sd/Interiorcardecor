<?php 
include 'config.php';

if (isset($_POST['submit'])) {
    $name      = trim($_POST['name']);
    $email     = trim($_POST['email']);
    $password  = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    $errors = [];

    // --- Validation ---
    if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
        $errors[] = "❌ Name should only contain letters and spaces.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !str_contains($email, '@') || !str_ends_with($email, '.com')) {
        $errors[] = "❌ Enter a valid email address ending with .com.";
    }

    if (strlen($password) < 6) {
        $errors[] = "❌ Password must be at least 6 characters long.";
    }
    if (!preg_match("/[A-Z]/", $password)) {
        $errors[] = "❌ Password must contain at least one uppercase letter.";
    }
    if (!preg_match("/[a-z]/", $password)) {
        $errors[] = "❌ Password must contain at least one lowercase letter.";
    }
    if (!preg_match("/[0-9]/", $password)) {
        $errors[] = "❌ Password must contain at least one number.";
    }

    if ($password !== $cpassword) {
        $errors[] = "❌ Password and Confirm Password do not match.";
    }

    if (empty($errors)) {
        // Check if email already exists
        $checkQuery = mysqli_query($conn, "SELECT * FROM `register` WHERE email = '$email'");
        if (mysqli_num_rows($checkQuery) > 0) {
            $message[] = "❌ User already exists with this email!";
        } else {
            // ✅ Store password as plain text (no hashing)
            $insertQuery = "INSERT INTO `register` (name, email, password) 
                            VALUES ('$name', '$email', '$password')";
            if (mysqli_query($conn, $insertQuery)) {
                $message[] = "✅ Registered Successfully!";
                header("Location: login.php");
                exit();
            } else {
                $message[] = "❌ Registration failed. Try again.";
            }
        }
    } else {
        $message = $errors;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - STF Car Interior Design</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(10, 10, 10, 0.95), rgba(26, 26, 46, 0.95)),
                        url('https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=1920') center/cover fixed;
            position: relative;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 60px 20px;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: radial-gradient(circle at 50% 50%, rgba(212, 175, 55, 0.1), transparent 70%);
            animation: pulse 8s ease-in-out infinite;
        }

        @keyframes pulse { 0%, 100% { opacity: 0.3; } 50% { opacity: 0.6; } }

        .message {
            position: fixed;
            top: 20px; right: 20px;
            background: rgba(212, 175, 55, 0.95);
            backdrop-filter: blur(10px);
            color: #0a0a0a;
            padding: 15px 25px;
            border-radius: 15px;
            z-index: 10000;
            box-shadow: 0 10px 30px rgba(212, 175, 55, 0.4);
            animation: slideInRight 0.5s ease;
            font-weight: 500;
            max-width: 400px;
            margin-bottom: 10px;
            font-size: 0.95rem;
        }

        @keyframes slideInRight {
            from { transform: translateX(400px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        .box {
            position: relative;
            z-index: 2;
            width: 500px;
            max-width: 95%;
            background: rgba(26, 26, 46, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 25px;
            padding: 50px 40px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.5);
            animation: fadeInUp 0.8s ease-out;
            margin: 50px 0;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        form h2 {
            font-size: 2.5rem;
            color: #fff;
            text-align: center;
            margin-bottom: 15px;
            font-weight: 700;
            background: linear-gradient(135deg, #d4af37, #f4e5c3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        form h2::after {
            content: '';
            display: block;
            width: 80px; height: 3px;
            background: linear-gradient(135deg, #d4af37, #f4e5c3);
            margin: 15px auto 30px;
            border-radius: 2px;
        }

        .inputbox { position: relative; margin: 30px 0; }
        .inputbox input {
            width: 100%; padding: 15px 0;
            font-size: 1rem; color: #fff;
            background: transparent; border: none;
            border-bottom: 2px solid rgba(212, 175, 55, 0.3);
            outline: none; transition: 0.3s;
            font-family: 'Poppins', sans-serif;
        }

        .inputbox span {
            position: absolute; left: 0; top: 15px;
            font-size: 1rem; color: #b8b8b8;
            pointer-events: none; transition: 0.3s;
        }

        .inputbox input:focus ~ span,
        .inputbox input:valid ~ span {
            top: -10px; font-size: 0.85rem;
            color: #d4af37; font-weight: 500;
        }

        .inputbox i {
            position: absolute; right: 10px; top: 15px;
            color: #b8b8b8; cursor: pointer;
            transition: color 0.3s ease;
        }

        .inputbox i.active { color: #d4af37; }

        .links { display: flex; justify-content: center; margin: 25px 0; }
        .links a { color: #b8b8b8; text-decoration: none; }
        .links a:hover { color: #d4af37; }

        input[type="submit"] {
            width: 100%; padding: 15px;
            background: linear-gradient(135deg, #d4af37, #f4e5c3);
            color: #0a0a0a; border: none;
            border-radius: 50px; font-size: 1.1rem;
            font-weight: 600; cursor: pointer;
            transition: 0.4s; text-transform: uppercase;
            box-shadow: 0 10px 30px rgba(212, 175, 55, 0.3);
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(212, 175, 55, 0.5);
        }

        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #d4af37, #f4e5c3);
            border-radius: 5px;
        }
    </style>
</head>
<body>

<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo "<div class='message'><span>$msg</span></div>";
    }
}
?>

<div class="box">
    <form action="" method="post">
        <h2>Register</h2>

        <div class="inputbox">
            <input type="text" name="name" required>
            <span>Name</span>
        </div>

        <div class="inputbox">
            <input type="email" name="email" required>
            <span>Email</span>
        </div>

        <div class="inputbox">
            <input type="password" name="password" id="password" required>
            <span>Password</span>
            <i class="fa-solid fa-eye" id="togglePassword"></i>
        </div>

        <div class="inputbox">
            <input type="password" name="cpassword" id="cpassword" required>
            <span>Confirm Password</span>
            <i class="fa-solid fa-eye" id="toggleCPassword"></i>
        </div>

        <div class="links">
            <a href="login.php">Already have an account? Login</a>
        </div>

        <input type="submit" value="Register Now" name="submit">
    </form>
</div>

<script>
setTimeout(() => {
    const messages = document.querySelectorAll('.message');
    messages.forEach(msg => {
        msg.style.animation = 'slideOutRight 0.5s ease forwards';
        setTimeout(() => msg.remove(), 500);
    });
}, 5000);

const style = document.createElement('style');
style.textContent = `
@keyframes slideOutRight {
    to { transform: translateX(400px); opacity: 0; }
}`;
document.head.appendChild(style);

function toggleVisibility(toggleId, inputId) {
    const toggle = document.getElementById(toggleId);
    const input = document.getElementById(inputId);
    toggle.addEventListener('click', () => {
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        toggle.classList.toggle('fa-eye-slash');
        toggle.classList.toggle('active');
    });
}

toggleVisibility('togglePassword', 'password');
toggleVisibility('toggleCPassword', 'cpassword');
</script>

</body>
</html>
