<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;

if (!isset($user_id)) {
  header('location:login.php');
  exit;
}

// Update cart quantity
if (isset($_POST['update_cart'])) {
  $cart_id = $_POST['cart_id'];
  $cart_quantity = $_POST['cart_quantity'];
  mysqli_query($conn, "UPDATE `cart` SET quantity='$cart_quantity' WHERE id='$cart_id'") or die('query failed');
  $message[] = 'Cart Quantity Updated!';
}

// Delete individual item
if (isset($_GET['delete'])) {
  $delete_id = $_GET['delete'];
  mysqli_query($conn, "DELETE FROM `cart` WHERE id='$delete_id'") or die('query failed');
  header('location:cart.php');
  exit;
}

// Delete all
if (isset($_GET['delete_all'])) {
  mysqli_query($conn, "DELETE FROM `cart` WHERE user_id='$user_id'") or die('query failed');
  header('location:cart.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Cart - Interior Car Decor</title>

  <!-- Fonts & Icons -->
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
    .cart_hero {
      height: 350px;
      background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                  url('https://images.unsplash.com/photo-1563720223185-11005f12d4aa?w=1920') center/cover no-repeat;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      position: relative;
    }

    .cart_hero h1 {
      font-size: 3rem;
      color: #d4af37;
      text-transform: uppercase;
      letter-spacing: 2px;
    }

    /* Cart Section */
    .shopping_cart {
      max-width: 1300px;
      margin: 80px auto;
      padding: 0 5%;
      animation: fadeInUp 1s ease;
    }

    .shopping_cart h2 {
      text-align: center;
      font-size: 2.5rem;
      color: #d4af37;
      margin-bottom: 40px;
      text-transform: uppercase;
      letter-spacing: 1.5px;
    }

    .cart_box_cont {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 40px;
    }

    .cart_box {
      background: rgba(255,255,255,0.08);
      border: 1px solid rgba(212,175,55,0.3);
      border-radius: 15px;
      padding: 25px;
      text-align: center;
      position: relative;
      transition: all 0.3s ease;
    }

    .cart_box:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 30px rgba(212,175,55,0.3);
      border-color: rgba(212,175,55,0.6);
    }

    .cart_box img {
      width: 100%;
      height: 250px;
      object-fit: cover;
      border-radius: 12px;
      margin-bottom: 15px;
    }

    .cart_box h3 {
      font-size: 1.4rem;
      color: #fff;
      margin: 10px 0;
    }

    .cart_box p {
      color: #ccc;
      margin-bottom: 10px;
    }

    .cart_box .fa-times {
      position: absolute;
      top: 15px;
      right: 20px;
      color: #d4af37;
      font-size: 1.3rem;
      cursor: pointer;
      transition: color 0.3s;
    }

    .cart_box .fa-times:hover {
      color: red;
    }

    .cart_box form {
      margin-top: 10px;
    }

    .cart_box input[type="number"] {
      width: 70px;
      padding: 8px;
      border-radius: 6px;
      border: none;
      background: #222;
      color: #fff;
      text-align: center;
    }

    .product_btn {
      display: inline-block;
      background: #d4af37;
      color: #000;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.3s ease;
      margin-top: 15px;
    }

    .product_btn:hover {
      background: transparent;
      color: #d4af37;
      border: 2px solid #d4af37;
      transform: translateY(-3px);
    }

    .cart_total {
      text-align: center;
      margin-top: 70px;
      background: rgba(255,255,255,0.05);
      border: 1px solid rgba(212,175,55,0.3);
      border-radius: 12px;
      padding: 40px;
      max-width: 900px;
      margin-left: auto;
      margin-right: auto;
    }

    .cart_total h3 {
      font-size: 1.8rem;
      color: #fff;
      margin-bottom: 25px;
    }

    .cart_total span {
      color: #d4af37;
      font-weight: 600;
    }

    .btns_cart {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
    }

    .empty {
      text-align: center;
      color: #aaa;
      font-size: 1.3rem;
      margin: 50px 0;
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

    @media (max-width: 768px) {
      .cart_box img {
        height: 200px;
      }
      .cart_total h3 {
        font-size: 1.5rem;
      }
      .cart_hero h1 {
        font-size: 2rem;
      }
    }
  </style>
</head>
<body>

  <?php include 'user_header.php'; ?>

  <div class="page_content">
    <!-- Hero Section -->
    <section class="cart_hero">
      <h1>Your Shopping Cart</h1>
    </section>

    <!-- Cart Section -->
    <section class="shopping_cart">
      <h2>Products Added</h2>

      <div class="cart_box_cont">
        <?php
        $grand_total = 0;
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'") or die('query failed');

        if (mysqli_num_rows($select_cart) > 0) {
          while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
        ?>
        <div class="cart_box">
          <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('Remove this product from your cart?');"></a>
          <img src="./uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="">
          <h3><?php echo $fetch_cart['name']; ?></h3>
          <p>Price: Rs. <?php echo $fetch_cart['price']; ?>/-</p>

          <form action="" method="post">
            <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
            <input type="number" name="cart_quantity" min="1" value="<?php echo $fetch_cart['quantity']; ?>">
            <input type="submit" value="Update" name="update_cart" class="product_btn">
          </form>

          <p>Total: <span>Rs. <?php echo $sub_total = $fetch_cart['price'] * $fetch_cart['quantity']; ?>/-</span></p>
        </div>
        <?php
          $grand_total += $sub_total;
          }
        } else {
          echo '<p class="empty">Your cart is currently empty!</p>';
        }
        ?>
      </div>

      <?php if ($grand_total > 0) { ?>
      <div class="cart_total">
        <h3>Total Cart Value: <span>Rs. <?php echo $grand_total; ?>/-</span></h3>
        <div class="btns_cart">
          <a href="cart.php?delete_all" class="product_btn" onclick="return confirm('Are you sure you want to delete all items?');">Delete All</a>
          <a href="shop.php" class="product_btn">Continue Shopping</a>
          <a href="checkout.php" class="product_btn">Checkout</a>
        </div>
      </div>
      <?php } ?>
    </section>
  </div>

  <?php include 'footer.php'; ?>

</body>
</html>
