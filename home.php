<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
  header('location:login.php');
}

// Add to Cart functionality
if (isset($_POST['add_to_cart'])) {
  $pro_name = $_POST['product_name'];
  $pro_price = $_POST['product_price'];
  $pro_quantity = $_POST['product_quantity'];
  $pro_image = $_POST['product_image'];

  $check = mysqli_query($conn, "SELECT * FROM `cart` WHERE name='$pro_name' AND user_id='$user_id'") or die('query failed');

  if (mysqli_num_rows($check) > 0) {
    $message[] = 'Already added to cart!';
  } else {
    mysqli_query($conn, "INSERT INTO `cart`(user_id,name,price,quantity,image) VALUES ('$user_id','$pro_name','$pro_price','$pro_quantity','$pro_image')") or die('query failed');
    $message[] = 'Product added to cart!';
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>STF - Luxury Car Interior Design</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">

  <style>
    /* ===== General Styles ===== */
    *{margin:0;padding:0;box-sizing:border-box;}
    body{font-family:'Poppins', sans-serif;background:#0a0a0a;color:#fff;overflow-x:hidden;}
    .empty{text-align:center;font-size:1.5rem;color:#b8b8b8;padding:50px;}
    .product_btn{padding:15px 40px;font-size:1rem;font-weight:600;color:#0a0a0a;background:linear-gradient(135deg,#d4af37,#f4e5c3);border:none;border-radius:50px;cursor:pointer;transition:all 0.4s ease;text-transform:uppercase;letter-spacing:1px;margin-top:10px;}
    .product_btn:hover{transform:translateY(-3px);box-shadow:0 10px 25px rgba(212,175,55,0.4);background:linear-gradient(135deg,#f4e5c3,#d4af37);}
    .pro_box_cont{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:40px;max-width:1400px;margin:0 auto;}
    .pro_box{background:rgba(255,255,255,0.05);backdrop-filter:blur(10px);border:1px solid rgba(212,175,55,0.2);border-radius:20px;padding:30px;display:flex;flex-direction:column;align-items:center;transition:all 0.4s ease;}
    .pro_box:hover{transform:translateY(-10px);box-shadow:0 20px 40px rgba(212,175,55,0.3);border-color:rgba(212,175,55,0.5);}
    .pro_box img{width:100%;height:250px;object-fit:cover;border-radius:15px;margin-bottom:20px;transition:transform 0.4s ease;}
    .pro_box:hover img{transform:scale(1.05);}
    .pro_box h3{font-size:1.5rem;margin-bottom:10px;color:#fff;text-align:center;}
    .pro_box p{font-size:1.3rem;color:#d4af37;font-weight:600;margin-bottom:20px;}
    .pro_box input[type="number"]{width:80px;padding:10px;margin:15px 0;background:rgba(255,255,255,0.1);border:1px solid rgba(212,175,55,0.3);border-radius:10px;color:#fff;text-align:center;font-size:1rem;}

    /* ===== Hero Text Animation ===== */
    .hero_text {
      opacity: 0;
      transform: translateY(30px);
      animation: fadeSlideUp 4s ease forwards;
    }
    @keyframes fadeSlideUp {
      0% { opacity: 0; transform: translateY(30px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    /* ===== Featured Products Title Centering ===== */
    .products_cont h2 {
      text-align: center;
      font-size: 3rem;
      margin-bottom: 40px;
      color: #d4af37;
      font-weight: 700;
    }
  </style>
</head>
<body>

<?php include 'user_header.php'; ?>

<!-- Hero Section -->
<section class="home_cont" style="margin-top:90px;position:relative;height:100vh;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg, rgba(10,10,10,0.8), rgba(20,20,30,0.9)), url('https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?w=1920') center/cover;overflow:hidden;">
  <div class="main_descrip hero_text" style="position:relative;z-index:2;text-align:center;max-width:900px;padding:0 20px;">
    <h1 style="font-size:4.5rem;font-weight:800;background:linear-gradient(135deg,#d4af37,#f4e5c3,#d4af37);-webkit-background-clip:text;-webkit-text-fill-color:transparent;margin-bottom:20px;letter-spacing:2px;">REDEFINE YOUR DRIVE</h1>
    <p style="font-size:1.2rem;color:#b8b8b8;margin-bottom:40px;line-height:1.8;font-weight:300;">TRANSFORM YOUR CAR INTERIOR INTO A MASTERPIECE OF LUXURY & INNOVATION</p>
    <button onclick="document.querySelector('.products_cont').scrollIntoView({behavior:'smooth'})" class="product_btn">START DISCOVRING</button>
  </div>
</section>

<!-- Features Section -->
<section class="features_cont" style="padding:100px 5%;background:linear-gradient(180deg,#0a0a0a,#1a1a2e);">
  <h2 style="text-align:center;font-size:3rem;margin-bottom:60px;color:#d4af37;font-weight:700;">Premium Services</h2>
  <div class="features_grid" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:30px;max-width:1400px;margin:0 auto;">
    <div class="feature_card" style="background:rgba(255,255,255,0.05);backdrop-filter:blur(10px);border:1px solid rgba(212,175,55,0.2);border-radius:20px;padding:40px 30px;text-align:center;transition:all 0.4s ease;position:relative;overflow:hidden;">
      <i class="fas fa-couch" style="font-size:3.5rem;color:#d4af37;margin-bottom:20px;"></i>
      <h3>Leather Customization</h3>
      <p>Premium leather upholstery tailored to your style with exotic patterns and textures</p>
    </div>
    <div class="feature_card" style="background:rgba(255,255,255,0.05);backdrop-filter:blur(10px);border:1px solid rgba(212,175,55,0.2);border-radius:20px;padding:40px 30px;text-align:center;transition:all 0.4s ease;position:relative;overflow:hidden;">
      <i class="fas fa-lightbulb" style="font-size:3.5rem;color:#d4af37;margin-bottom:20px;"></i>
      <h3>Ambient Lighting</h3>
      <p>Sophisticated LED lighting systems that create the perfect mood for every journey</p>
    </div>
    <div class="feature_card" style="background:rgba(255,255,255,0.05);backdrop-filter:blur(10px);border:1px solid rgba(212,175,55,0.2);border-radius:20px;padding:40px 30px;text-align:center;transition:all 0.4s ease;position:relative;overflow:hidden;">
      <i class="fas fa-dashboard" style="font-size:3.5rem;color:#d4af37;margin-bottom:20px;"></i>
      <h3>Dashboard Styling</h3>
      <p>Custom dashboard designs with premium materials and modern aesthetic appeal</p>
    </div>
    <div class="feature_card" style="background:rgba(255,255,255,0.05);backdrop-filter:blur(10px);border:1px solid rgba(212,175,55,0.2);border-radius:20px;padding:40px 30px;text-align:center;transition:all 0.4s ease;position:relative;overflow:hidden;">
      <i class="fas fa-microchip" style="font-size:3.5rem;color:#d4af37;margin-bottom:20px;"></i>
      <h3>Smart Controls</h3>
      <p>Integrate cutting-edge technology for a seamless and intelligent driving experience</p>
    </div>
  </div>
</section>

<!-- Products Section (Admin-added) -->
<section class="products_cont">
  <h2>Featured Products</h2>
  <div class="pro_box_cont">
    <?php
    $select_products = mysqli_query($conn, "SELECT * FROM `products` ORDER BY id DESC") or die('query failed');

    if (mysqli_num_rows($select_products) > 0) {
      while ($fetch_products = mysqli_fetch_assoc($select_products)) {
    ?>
        <form action="" method="post" class="pro_box">
          <img src="./uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
          <h3><?php echo $fetch_products['name']; ?></h3>
          <p>Rs. <?php echo $fetch_products['price']; ?>/-</p>

          <input type="hidden" name="product_name" value="<?php echo $fetch_products['name'] ?>">
          <input type="number" name="product_quantity" min="1" value="1">
          <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
          <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">

          <input type="submit" value="Add to Cart" name="add_to_cart" class="product_btn">
        </form>
    <?php
      }
    } else {
      echo '<p class="empty">No Products Added Yet!</p>';
    }
    ?>
  </div>
</section>

<!-- About Section -->
<section class="about_cont" style="display:grid;grid-template-columns:1fr 1fr;gap:60px;padding:100px 5%;background:linear-gradient(180deg,#1a1a2e,#0a0a0a);align-items:center;">
  <img src="about.jpg" alt="About STF" style="width:100%;height:500px;object-fit:cover;border-radius:20px;box-shadow:0 20px 60px rgba(212,175,55,0.2);transition:transform 0.4s ease;">
  <div class="about_descript">
    <h2 style="font-size:3rem;color:#d4af37;margin-bottom:30px;font-weight:700;">Discover Our Story</h2>
    <p style="font-size:1.1rem;line-height:1.8;color:#b8b8b8;margin-bottom:30px;">For over 30 years, my passion for automotive design has been focused on transforming car interiors into personal sanctuaries. I believe a vehicle's true soul is found in the meticulous details and luxurious materials of its cabin, not just its engine. The interior is a canvas where I combine exquisite craftsmanship with breathtaking aesthetics to create an environment that reflects the owner's unique style and makes every journey unforgettable.</p>
    <button class="product_btn" onclick="window.location.href='about.php';">Read More</button>
  </div>
</section>

<!-- Questions Section -->
<section class="questions_cont" style="padding:100px 5%;background:linear-gradient(135deg, rgba(212,175,55,0.1), rgba(10,10,10,0.9));text-align:center;">
  <div class="questions">
    <h2 style="font-size:3rem;color:#d4af37;margin-bottom:30px;font-weight:700;">Have Any Queries?</h2>
    <p style="font-size:1.1rem;color:#b8b8b8;max-width:800px;margin:0 auto 40px;line-height:1.8;">At SHREE CAR FURNITURE, we value your satisfaction and strive to provide exceptional customer service. If you have any questions, concerns, or inquiries, our dedicated team is here to assist you every step of the way.</p>
    <button class="product_btn" onclick="window.location.href='contact.php';">Contact Us</button>
  </div>
</section>

<?php include 'footer.php'; ?>

<script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>
<script src="script.js"></script>
<script>
  // User account box toggle
  document.getElementById('user_btn').addEventListener('click', function() {
    document.querySelector('.header_acc_box').classList.toggle('active');
  });
  // Mobile menu toggle
  document.getElementById('user_menu_btn').addEventListener('click', function() {
    document.querySelector('.navbar').classList.toggle('active');
  });
  // Close account box when clicking outside
  document.addEventListener('click', function(e) {
    if (!e.target.closest('.icons') && !e.target.closest('.header_acc_box')) {
      document.querySelector('.header_acc_box').classList.remove('active');
    }
  });
</script>
</body>
</html>
