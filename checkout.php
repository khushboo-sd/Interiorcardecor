<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    exit;
}

$user_id = intval($_SESSION['user_id']); // secure numeric value

$message = [];

// --- Handle order submission ---
if (isset($_POST['order_btn'])) {
    $name = trim($_POST['name']);
    $number = trim($_POST['number']);
    $email = trim($_POST['email']);
    $method = trim($_POST['method']);
    $address = trim($_POST['address']);
    $placed_on = date('d-M-Y');

    $cart_total = 0;
    $cart_products = [];

    // Fetch cart items
    $cart_query = mysqli_prepare($conn, "SELECT * FROM cart WHERE user_id = ?");
    mysqli_stmt_bind_param($cart_query, "i", $user_id);
    mysqli_stmt_execute($cart_query);
    $result = mysqli_stmt_get_result($cart_query);

    if (mysqli_num_rows($result) > 0) {
        while ($item = mysqli_fetch_assoc($result)) {
            $cart_products[] = "{$item['name']} ({$item['quantity']})";
            $cart_total += ($item['price'] * $item['quantity']);
        }
    }

    $total_products = implode(', ', $cart_products);

    if ($cart_total == 0) {
        $message[] = 'Your cart is empty!';
    } else {
        // Prevent duplicate orders
        $check_order = mysqli_prepare($conn, "SELECT id FROM orders WHERE user_id = ? AND total_products = ? AND total_price = ?");
        mysqli_stmt_bind_param($check_order, "isi", $user_id, $total_products, $cart_total);
        mysqli_stmt_execute($check_order);
        $existing = mysqli_stmt_get_result($check_order);

        if (mysqli_num_rows($existing) > 0) {
            $message[] = 'Order already placed!';
        } else {
            // Determine payment status
            $payment_status = ($method === 'cash on delivery') ? 'completed' : 'pending';

            // Insert order
            $insert_order = mysqli_prepare($conn, "INSERT INTO orders (user_id, name, number, email, method, address, total_products, total_price, placed_on, payment_status)
                                                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($insert_order, "issssssdss", $user_id, $name, $number, $email, $method, $address, $total_products, $cart_total, $placed_on, $payment_status);
            mysqli_stmt_execute($insert_order);

            $order_id = mysqli_insert_id($conn);

            // Clear cart
            $delete_cart = mysqli_prepare($conn, "DELETE FROM cart WHERE user_id = ?");
            mysqli_stmt_bind_param($delete_cart, "i", $user_id);
            mysqli_stmt_execute($delete_cart);

            // Handle redirection based on payment method
            if ($method === 'cash on delivery') {
                $message[] = "Order placed successfully! Payment will be collected on delivery.";
            } else {
                $_SESSION['payment_order_id'] = $order_id;
                $_SESSION['payment_method'] = $method;
                header('location:payment_gateway.php');
                exit;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout - Interior Car Decor</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
body { font-family: 'Poppins', sans-serif; margin:0; color:#fff; background: linear-gradient(135deg, rgba(10,10,10,.97), rgba(26,26,46,.97)), url('https://images.unsplash.com/photo-1502877338535-766e1452684a?w=1920') center/cover fixed; display:flex; flex-direction:column; min-height:100vh; }
.page_content { flex:1; margin-top:80px; padding:0 5%; }
.checkout_hero { height:300px; background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1517949908119-2b1b72b4c4e0?w=1920') center/cover no-repeat; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; }
.checkout_hero h1 { font-size:3rem; color:#d4af37; margin-bottom:15px; text-transform:uppercase; }
.checkout_hero p { color:#ddd; font-size:1.1rem; }
.display_order { margin:60px auto; max-width:1100px; background: rgba(255,255,255,0.05); border:1px solid rgba(212,175,55,0.3); padding:40px; border-radius:15px; }
.display_order h2 { text-align:center; color:#d4af37; margin-bottom:30px; font-size:2rem; }
.single_order_product { display:flex; align-items:center; background: rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); margin-bottom:20px; border-radius:10px; overflow:hidden; transition: all 0.3s ease; }
.single_order_product img { width:120px; height:120px; object-fit:cover; }
.single_des { padding:20px; }
.single_des h3 { color:#fff; margin-bottom:5px; font-size:1.2rem; }
.single_des p { color:#ccc; font-size:0.95rem; }
.checkout_grand_total { text-align:right; margin-top:20px; font-size:1.2rem; color:#d4af37; font-weight:600; }
.checkout_form_section { max-width:800px; margin:60px auto; background: rgba(255,255,255,0.05); border:1px solid rgba(212,175,55,0.3); border-radius:15px; padding:50px; }
.checkout_form h2 { text-align:center; color:#d4af37; margin-bottom:30px; }
.checkout_form input, .checkout_form select, .checkout_form textarea { width:100%; padding:15px; margin-bottom:20px; border-radius:8px; border:none; outline:none; background: rgba(255,255,255,0.1); color:#fff; font-size:1rem; }
.checkout_form textarea { resize:none; height:120px; }
select option { background:#1a1a2e; color:#fff; }
.product_btn { display:inline-block; background:#d4af37; color:#000; padding:15px 40px; border-radius:8px; border:2px solid #d4af37; font-weight:600; cursor:pointer; transition:.3s; }
.product_btn:hover { background:transparent; color:#d4af37; transform:translateY(-3px); box-shadow:0 10px 30px rgba(212,175,55,0.3); }
@media (max-width:768px) { .checkout_hero h1 { font-size:2.2rem; } .display_order, .checkout_form_section { padding:30px; } .single_order_product { flex-direction:column; align-items:flex-start; } .single_order_product img { width:100%; height:200px; } }
</style>
</head>
<body>

<?php include 'user_header.php'; ?>

<div class="page_content">

  <?php
  if (!empty($message)) {
      foreach ($message as $msg) {
          echo "<div style='background:#28a745; color:#fff; padding:15px; margin:20px auto; border-radius:8px; max-width:800px; text-align:center;'>$msg</div>";
      }
  }
  ?>

  <section class="checkout_hero">
      <h1>Checkout</h1>
      <p>Complete your order securely and effortlessly</p>
  </section>

  <section class="display_order">
      <h2>Your Ordered Products</h2>
      <?php
      $grand_total = 0;
      $cart_query = mysqli_prepare($conn, "SELECT * FROM cart WHERE user_id = ?");
      mysqli_stmt_bind_param($cart_query, "i", $user_id);
      mysqli_stmt_execute($cart_query);
      $cart_result = mysqli_stmt_get_result($cart_query);

      if (mysqli_num_rows($cart_result) > 0) {
          while ($cart = mysqli_fetch_assoc($cart_result)) {
              $total_price = $cart['price'] * $cart['quantity'];
              $grand_total += $total_price;
      ?>
      <div class="single_order_product">
          <img src="./uploaded_img/<?php echo htmlspecialchars($cart['image']); ?>" alt="">
          <div class="single_des">
              <h3><?php echo htmlspecialchars($cart['name']); ?></h3>
              <p>Price: ₹<?php echo htmlspecialchars($cart['price']); ?>/-</p>
              <p>Quantity: <?php echo htmlspecialchars($cart['quantity']); ?></p>
          </div>
      </div>
      <?php
          }
      } else {
          echo '<p class="empty">Your cart is empty!</p>';
      }
      ?>
      <div class="checkout_grand_total">
          Grand Total: ₹<?php echo $grand_total; ?>/-  
      </div>
  </section>

  <section class="checkout_form_section">
      <form action="" method="post" class="checkout_form">
          <h2>Billing Details</h2>
          <input type="text" name="name" placeholder="Enter your full name" required>
          <input type="text" name="number" placeholder="Enter your contact number" required>
          <input type="email" name="email" placeholder="Enter your email address" required>

          <select name="method" required>
              <option value="">-- Select Payment Method --</option>
              <option value="cash on delivery">Cash on Delivery</option>
              <option value="Google Pay">Google Pay</option>
              <option value="PhonePe">PhonePe</option>
              <option value="Paytm">Paytm</option>
          </select>

          <textarea name="address" placeholder="Enter your complete address" required></textarea>
          <input type="submit" name="order_btn" value="Place Your Order" class="product_btn">
      </form>
  </section>

</div>

<?php include 'footer.php'; ?>

</body>
</html>
