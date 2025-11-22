<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
  header('location:login.php');
  exit;
}

if (isset($_POST['add_to_cart'])) {
  $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
  $product_price = $_POST['product_price'];
  $product_image = $_POST['product_image'];
  $product_quantity = $_POST['product_quantity'];

  $check_cart = mysqli_query($conn, "SELECT * FROM cart WHERE name='$product_name' AND user_id='$user_id'") or die('query failed');

  if (mysqli_num_rows($check_cart) > 0) {
    $message[] = 'Already added to cart!';
  } else {
    mysqli_query($conn, "INSERT INTO cart(user_id, name, price, quantity, image)
      VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
    $message[] = 'Product added to cart!';
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search - Interior Car Decor</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, rgba(10,10,10,.97), rgba(26,26,46,.97)), 
                  url('https://images.unsplash.com/photo-1502877338535-766e1452684a?w=1920') center/cover fixed;
      color: #fff;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .page_content {
      flex: 1;
      margin-top: 80px;
      padding: 0 5%;
    }

    /* Hero */
    .search_hero {
      height: 300px;
      background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)),
                  url('https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?w=1920') center/cover no-repeat;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
    }

    .search_hero h1 {
      font-size: 3rem;
      color: #d4af37;
      text-transform: uppercase;
      margin-bottom: 15px;
    }

    .search_hero p {
      color: #ddd;
      font-size: 1.1rem;
    }

    /* Search Form */
    .search_form {
      text-align: center;
      margin: 50px auto;
    }

    .search_form input[type="text"] {
      width: 50%;
      padding: 15px;
      border: none;
      border-radius: 8px 0 0 8px;
      background: rgba(255,255,255,0.1);
      color: #fff;
      font-size: 1rem;
      outline: none;
    }

    .search_form input::placeholder {
      color: #aaa;
    }

    .search_form .product_btn {
      padding: 15px 30px;
      border: none;
      border-radius: 0 8px 8px 0;
      background: #d4af37;
      color: #000;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .search_form .product_btn:hover {
      background: transparent;
      color: #d4af37;
      border: 2px solid #d4af37;
      transform: translateY(-3px);
      box-shadow: 0 10px 30px rgba(212,175,55,0.3);
    }

    /* Product Grid */
    .products_cont {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 25px;
      max-width: 1100px;
      margin: 60px auto;
      animation: fadeInUp 1s ease;
    }

    .pro_box {
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(212,175,55,0.3);
      border-radius: 12px;
      padding: 20px;
      text-align: center;
      transition: all 0.3s ease;
    }

    .pro_box:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(212,175,55,0.2);
    }

    .pro_box img {
      width: 100%;
      height: 220px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 15px;
    }

    .pro_box h3 {
      color: #fff;
      font-size: 1.2rem;
      margin-bottom: 10px;
    }

    .pro_box p {
      color: #d4af37;
      font-weight: 500;
      margin-bottom: 15px;
    }

    .pro_box input[type="number"] {
      width: 60px;
      padding: 8px;
      border-radius: 6px;
      border: none;
      outline: none;
      background: rgba(255,255,255,0.1);
      color: #fff;
      text-align: center;
      margin-bottom: 10px;
    }

    .pro_box .product_btn {
      display: inline-block;
      background: #d4af37;
      color: #000;
      padding: 10px 25px;
      border-radius: 8px;
      border: 2px solid #d4af37;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .pro_box .product_btn:hover {
      background: transparent;
      color: #d4af37;
      box-shadow: 0 5px 20px rgba(212,175,55,0.3);
    }

    .empty {
      text-align: center;
      font-size: 1.2rem;
      color: #ccc;
    }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
      .search_form input[type="text"] { width: 70%; }
    }
  </style>
</head>
<body>

<?php include 'user_header.php'; ?>

<div class="page_content">

  <!-- Hero -->
  <section class="search_hero">
    <h1>Search</h1>
    <p>Find your favorite car interior products</p>
  </section>

  <!-- Search Form -->
  <section class="search_form">
    <form action="" method="post">
      <input type="text" name="search" placeholder="Search products..." required>
      <input type="submit" name="submit" value="Search" class="product_btn">
    </form>
  </section>

  <!-- Products Section -->
  <section class="products_cont">
    <?php
    if (isset($_POST['submit'])) {
      $search_item = mysqli_real_escape_string($conn, $_POST['search']);
      $select_products = mysqli_query($conn, "SELECT * FROM products WHERE name LIKE '%{$search_item}%'") or die('query failed');
      if (mysqli_num_rows($select_products) > 0) {
        while ($fetch_products = mysqli_fetch_assoc($select_products)) {
    ?>
          <form action="" method="post" class="pro_box">
            <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
            <h3><?php echo $fetch_products['name']; ?></h3>
            <p>₹<?php echo $fetch_products['price']; ?> /-</p>
            <input type="number" name="product_quantity" min="1" value="1">
            <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
            <input type="submit" name="add_to_cart" value="Add to Cart" class="product_btn">
          </form>
    <?php
        }
      } else {
        echo '<p class="empty">No products found!</p>';
      }
    } else {
      echo '<p class="empty">Search for something!</p>';
    }
    ?>
  </section>

</div>

<?php include 'footer.php'; ?>

</body>
</html>
