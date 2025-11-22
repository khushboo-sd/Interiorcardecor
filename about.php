<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;

if (!isset($user_id)) {
  header('location:login.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us - Interior Car Decor</title>
  
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

    /* Page Content Wrapper */
    .page_content {
      flex: 1;
      margin-top: 70px;
    }

    /* Hero Section */
    .about_hero {
      height: 400px;
      background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                  url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=1920') center/cover no-repeat;
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

    .about_hero h1 {
      font-size: 3.5rem;
      color: #d4af37;
      margin-bottom: 20px;
      text-transform: uppercase;
      letter-spacing: 2px;
    }

    .about_hero p {
      font-size: 1.2rem;
      color: #ddd;
      line-height: 1.8;
    }

    /* About Section */
    .about_section {
      max-width: 1300px;
      margin: 80px auto;
      padding: 0 5%;
    }

    .about_container {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 60px;
      align-items: center;
      margin-bottom: 80px;
    }

    .about_image {
      width: 100%;
      height: 500px;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 15px 40px rgba(0,0,0,0.5);
      position: relative;
      animation: fadeInLeft 1s ease;
    }

    .about_image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }

    .about_image:hover img {
      transform: scale(1.1);
    }

    .about_image::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(212,175,55,0.2), rgba(0,0,0,0.3));
      pointer-events: none;
    }

    .about_content {
      animation: fadeInRight 1s ease;
    }

    .about_content h2 {
      font-size: 2.5rem;
      color: #d4af37;
      margin-bottom: 25px;
      position: relative;
      display: inline-block;
    }

    .about_content h2::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 0;
      width: 80px;
      height: 3px;
      background: #d4af37;
    }

    .about_content p {
      font-size: 1.05rem;
      line-height: 1.9;
      color: #ccc;
      margin-top: 30px;
      text-align: justify;
    }

    /* Features Section */
    .features_section {
      background: rgba(255,255,255,0.05);
      padding: 80px 5%;
      margin: 80px 0;
    }

    .features_container {
      max-width: 1300px;
      margin: 0 auto;
    }

    .section_title {
      text-align: center;
      font-size: 2.5rem;
      color: #d4af37;
      margin-bottom: 60px;
      text-transform: uppercase;
      letter-spacing: 2px;
    }

    .features_grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 40px;
    }

    .feature_card {
      background: rgba(255,255,255,0.08);
      border: 1px solid rgba(212,175,55,0.3);
      border-radius: 12px;
      padding: 40px 30px;
      text-align: center;
      transition: all 0.3s ease;
      animation: fadeInUp 1s ease;
    }

    .feature_card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 40px rgba(212,175,55,0.2);
      border-color: rgba(212,175,55,0.6);
    }

    .feature_icon {
      font-size: 3.5rem;
      color: #d4af37;
      margin-bottom: 25px;
    }

    .feature_card h3 {
      font-size: 1.5rem;
      color: #fff;
      margin-bottom: 15px;
    }

    .feature_card p {
      color: #aaa;
      line-height: 1.7;
      font-size: 0.95rem;
    }

    /* CTA Section */
    .cta_section {
      max-width: 1000px;
      margin: 80px auto;
      padding: 60px 5%;
      text-align: center;
      background: linear-gradient(135deg, rgba(212,175,55,0.1), rgba(212,175,55,0.05));
      border-radius: 15px;
      border: 1px solid rgba(212,175,55,0.3);
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
      line-height: 1.8;
      margin-bottom: 40px;
      max-width: 700px;
      margin-left: auto;
      margin-right: auto;
    }

    .cta_button {
      display: inline-block;
      background: #d4af37;
      color: #000;
      padding: 18px 50px;
      border-radius: 8px;
      font-weight: 600;
      font-size: 1.1rem;
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

    .cta_button i {
      margin-left: 10px;
    }

    /* Animations */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeInLeft {
      from {
        opacity: 0;
        transform: translateX(-50px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @keyframes fadeInRight {
      from {
        opacity: 0;
        transform: translateX(50px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
      .about_container {
        gap: 40px;
      }

      .about_image {
        height: 400px;
      }
    }

    @media (max-width: 768px) {
      .page_content {
        margin-top: 60px;
      }

      .about_hero {
        height: 300px;
      }

      .about_hero h1 {
        font-size: 2.2rem;
      }

      .about_hero p {
        font-size: 1rem;
      }

      .about_container {
        grid-template-columns: 1fr;
        gap: 40px;
        margin-bottom: 60px;
      }

      .about_image {
        height: 350px;
      }

      .about_content h2 {
        font-size: 2rem;
      }

      .about_content p {
        font-size: 0.95rem;
      }

      .features_section {
        padding: 60px 5%;
      }

      .section_title {
        font-size: 2rem;
      }

      .features_grid {
        gap: 30px;
      }

      .cta_section {
        margin: 60px auto;
        padding: 40px 5%;
      }

      .cta_section h2 {
        font-size: 2rem;
      }

      .cta_section p {
        font-size: 1rem;
      }
    }

    @media (max-width: 480px) {
      .about_hero h1 {
        font-size: 1.8rem;
      }

      .about_hero p {
        font-size: 0.9rem;
      }

      .about_content h2 {
        font-size: 1.6rem;
      }

      .section_title {
        font-size: 1.6rem;
      }

      .feature_card {
        padding: 30px 20px;
      }

      .feature_icon {
        font-size: 2.5rem;
      }

      .cta_section h2 {
        font-size: 1.7rem;
      }

      .cta_button {
        padding: 15px 35px;
        font-size: 1rem;
      }
    }
  </style>
</head>
<body>
  
  <!-- Include Header -->
  <?php include 'user_header.php'; ?>

  <div class="page_content">
    <!-- Hero Section -->
    <section class="about_hero">
      <div class="hero_content">
        <h1>About Us</h1>
        <p>Transforming vehicles into masterpieces with premium interior decor solutions</p>
      </div>
    </section>

    <!-- About Section -->
    <section class="about_section">
      <div class="about_container">
        <div class="about_image">
          <img src="about1.jpg" alt="Interior Car Decor Showroom" onerror="this.src='https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=800'">
        </div>
        <div class="about_content">
          <h2>Why Choose Us?</h2>
          <p>
            With over 30 years of industry expertise, our company is committed to delivering superior-quality materials tailored to meet diverse client needs. We pride ourselves on fostering long-standing relationships built on trust and excellence.
          </p>
          <p>
            In addition to fulfilling bulk orders with efficiency and reliability, we also offer customized export solutions designed to align with international standards and customer specifications. Our dedication to quality and customer satisfaction sets us apart in the automotive interior decoration industry.
          </p>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section class="features_section">
      <div class="features_container">
        <h2 class="section_title">What We Offer</h2>
        <div class="features_grid">
          <div class="feature_card">
            <div class="feature_icon">
              <i class="fas fa-award"></i>
            </div>
            <h3>Premium Quality</h3>
            <p>We source only the finest materials to ensure durability and elegance in every product we deliver.</p>
          </div>

          <div class="feature_card">
            <div class="feature_icon">
              <i class="fas fa-users"></i>
            </div>
            <h3>Expert Team</h3>
            <p>Our experienced professionals bring decades of expertise to provide personalized solutions for your needs.</p>
          </div>

          <div class="feature_card">
            <div class="feature_icon">
              <i class="fas fa-shipping-fast"></i>
            </div>
            <h3>Fast Delivery</h3>
            <p>Efficient logistics and reliable shipping ensure your orders arrive on time, every time.</p>
          </div>

          <div class="feature_card">
            <div class="feature_icon">
              <i class="fas fa-paint-brush"></i>
            </div>
            <h3>Custom Solutions</h3>
            <p>Tailored designs and customization options to match your unique style and preferences.</p>
          </div>

          <div class="feature_card">
            <div class="feature_icon">
              <i class="fas fa-globe"></i>
            </div>
            <h3>Global Export</h3>
            <p>We serve clients worldwide with international shipping and compliance with global standards.</p>
          </div>

          <div class="feature_card">
            <div class="feature_icon">
              <i class="fas fa-headset"></i>
            </div>
            <h3>24/7 Support</h3>
            <p>Our dedicated customer service team is always ready to assist you with any inquiries or concerns.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="cta_section">
      <h2>Have Any Queries?</h2>
      <p>
        At Interior Car Decor, we value your satisfaction and strive to provide exceptional customer service. 
        If you have any questions, concerns, or inquiries, our dedicated team is here to assist you every step of the way.
      </p>
      <a href="contact.php" class="cta_button">
        Contact Us <i class="fas fa-arrow-right"></i>
      </a>
    </section>
  </div>

  <!-- Include Footer -->
  <?php include 'footer.php'; ?>

</body>
</html>