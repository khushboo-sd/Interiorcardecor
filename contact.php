<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;

if (!isset($user_id)) {
  header('location:login.php');
  exit;
}

if (isset($_POST['send'])) {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $number = mysqli_real_escape_string($conn, $_POST['number']);
  $msg = mysqli_real_escape_string($conn, $_POST['message']);

  $check_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name='$name' AND email='$email' AND number='$number' AND message='$msg'") or die('query failed');

  if (mysqli_num_rows($check_message) > 0) {
    $message[] = 'Message already sent!';
  } else {
    mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id','$name','$email','$number','$msg')") or die('query failed');
    $message[] = 'Message sent successfully!';
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us - Interior Car Decor</title>

  <!-- Font Awesome & Google Fonts -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, rgba(10,10,10,.97), rgba(26,26,46,.97)),
                  url('https://images.unsplash.com/photo-1502877338535-766e1452684a?w=1920') center/cover fixed;
      color: #fff;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .page_content {
      flex: 1;
      margin-top: 70px;
    }

    /* Hero Section */
    .contact_hero {
      height: 400px;
      background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                  url('https://images.unsplash.com/photo-1542365887-2a6d0efc7b88?w=1920') center/cover no-repeat;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      position: relative;
    }

    .hero_content {
      max-width: 800px;
      padding: 0 20px;
      animation: fadeInUp 1s ease;
    }

    .contact_hero h1 {
      font-size: 3.5rem;
      color: #d4af37;
      margin-bottom: 20px;
      text-transform: uppercase;
      letter-spacing: 2px;
    }

    .contact_hero p {
      font-size: 1.2rem;
      color: #ddd;
      line-height: 1.8;
    }

    /* Contact Form Section */
    .contact_section {
      max-width: 1300px;
      margin: 80px auto;
      padding: 0 5%;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 60px;
      align-items: start;
    }

    .contact_form {
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(212,175,55,0.3);
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.4);
      animation: fadeInLeft 1s ease;
    }

    .contact_form h2 {
      color: #d4af37;
      font-size: 2rem;
      margin-bottom: 20px;
    }

    .contact_form p {
      color: #bbb;
      margin-bottom: 30px;
    }

    .inputBox {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      margin-bottom: 20px;
    }

    .inputBox input {
      flex: 1 1 48%;
      padding: 12px;
      border-radius: 8px;
      border: 1px solid rgba(212,175,55,0.3);
      background: rgba(255,255,255,0.08);
      color: #fff;
      outline: none;
    }

    textarea {
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      border: 1px solid rgba(212,175,55,0.3);
      background: rgba(255,255,255,0.08);
      color: #fff;
      resize: none;
      height: 150px;
    }

    .btn {
      margin-top: 20px;
      background: #d4af37;
      color: #000;
      border: none;
      padding: 14px 35px;
      border-radius: 6px;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s;
    }

    .btn:hover {
      background: #fff;
      color: #000;
      transform: translateY(-3px);
    }

    /* Contact Info Section */
    .contact_info {
      animation: fadeInRight 1s ease;
    }

    .contact_info h2 {
      color: #d4af37;
      font-size: 2rem;
      margin-bottom: 25px;
    }

    .contact_info p {
      color: #ccc;
      margin-bottom: 15px;
      font-size: 1.05rem;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .contact_info i {
      color: #d4af37;
      font-size: 1.3rem;
    }

    /* CTA Section */
    .cta_section {
      text-align: center;
      background: linear-gradient(135deg, rgba(212,175,55,0.1), rgba(212,175,55,0.05));
      border: 1px solid rgba(212,175,55,0.3);
      border-radius: 15px;
      padding: 60px 5%;
      max-width: 1000px;
      margin: 100px auto;
      animation: fadeInUp 1s ease;
    }

    .cta_section h2 {
      font-size: 2.5rem;
      color: #d4af37;
      margin-bottom: 20px;
    }

    .cta_section p {
      font-size: 1.1rem;
      color: #ccc;
      margin-bottom: 40px;
      line-height: 1.8;
    }

    .cta_button {
      display: inline-block;
      background: #d4af37;
      color: #000;
      padding: 15px 40px;
      border-radius: 8px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.3s ease;
      border: 2px solid #d4af37;
    }

    .cta_button:hover {
      background: transparent;
      color: #d4af37;
      transform: translateY(-3px);
      box-shadow: 0 10px 30px rgba(212,175,55,0.3);
    }

    /* Animations */
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInLeft {
      from { opacity: 0; transform: translateX(-50px); }
      to { opacity: 1; transform: translateX(0); }
    }

    @keyframes fadeInRight {
      from { opacity: 0; transform: translateX(50px); }
      to { opacity: 1; transform: translateX(0); }
    }

    /* Responsive */
    @media (max-width: 992px) {
      .contact_section {
        grid-template-columns: 1fr;
        gap: 40px;
      }
    }

    @media (max-width: 768px) {
      .contact_hero h1 { font-size: 2.2rem; }
      .contact_hero p { font-size: 1rem; }
      .contact_form h2, .contact_info h2 { font-size: 1.8rem; }
    }

    @media (max-width: 480px) {
      .contact_hero h1 { font-size: 1.7rem; }
      .cta_section h2 { font-size: 1.7rem; }
    }
  </style>
</head>
<body>

  <?php include 'user_header.php'; ?>

  <div class="page_content">
    <!-- Hero Section -->
    <section class="contact_hero">
      <div class="hero_content">
        <h1>Contact Us</h1>
        <p>We’d love to hear from you — let’s transform your car interior together!</p>
      </div>
    </section>

    <!-- Contact Form Section -->
    <section class="contact_section">
      <div class="contact_form">
        <h2>Get In Touch</h2>
        <p>Fill out the form below and our team will reach out to you soon.</p>

        <form action="" method="post">
          <div class="inputBox">
            <input type="text" name="name" required placeholder="Enter your name">
            <input type="email" name="email" required placeholder="Enter your email">
          </div>
          <div class="inputBox">
            <input type="number" name="number" required placeholder="Enter your number">
          </div>
          <textarea name="message" required placeholder="Enter your message"></textarea>
          <input type="submit" name="send" value="Send Message" class="btn">
        </form>
      </div>

      <div class="contact_info">
        <h2>Our Contact Details</h2>
        <p><i class="fas fa-phone"></i> +91 9825442975</p>
        <p><i class="fas fa-envelope"></i> Shreecardecor@gmail.com</p>
        <p><i class="fas fa-map-marker-alt"></i> Surat, Gujarat, India - 395010</p>
        <p><i class="fa-solid fa-shop"></i> Shop Timings : 9am - 9pm</p>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="cta_section">
      <h2>Need Custom Interior Work?</h2>
      <p>We specialize in custom car interiors tailored to your style and comfort. Reach out today to discuss your design ideas and get a free quote!</p>
      <a href="shop.php" class="cta_button">Explore Our Products <i class="fas fa-arrow-right"></i></a>
    </section>
  </div>

  <?php include 'footer.php'; ?>
</body>
</html>
