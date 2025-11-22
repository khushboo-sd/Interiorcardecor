<?php
include 'config.php';
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
  header('location:login.php');
  exit;
}

$user_id = intval($_SESSION['user_id']); // secure numeric ID
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Orders - Interior Car Decor</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family:'Poppins',sans-serif;
      background:linear-gradient(135deg,rgba(10,10,10,.97),rgba(26,26,46,.97)),
                 url('https://images.unsplash.com/photo-1502877338535-766e1452684a?w=1920') center/cover fixed;
      color:#fff; margin:0;
    }
    .orders_section {max-width:1200px; margin:80px auto; padding:20px;}
    h1 {text-align:center; color:#d4af37; margin-bottom:40px;}
    .orders_container {
      display:grid;
      grid-template-columns:repeat(auto-fill,minmax(350px,1fr));
      gap:25px;
    }
    .order_card {
      background:rgba(255,255,255,.08);
      border:1px solid rgba(212,175,55,.3);
      border-radius:10px;
      padding:20px;
      transition:.3s;
    }
    .order_card:hover {transform:translateY(-5px); box-shadow:0 10px 20px rgba(212,175,55,.2);}
    .order_header {display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;}
    .order_date {color:#d4af37;}
    .order_status {
      border-radius:20px; padding:5px 12px; font-size:.9rem; font-weight:600; text-transform:uppercase;
    }
    .status_pending {background:rgba(255,71,87,.2);color:#ff4757;border:1px solid #ff4757;}
    .status_completed {background:rgba(46,213,115,.2);color:#2ed573;border:1px solid #2ed573;}
    .detail_row {margin:5px 0;}
    .detail_label {color:#aaa; font-weight:500; min-width:130px; display:inline-block;}
    .detail_highlight {color:#d4af37; font-weight:600;}
    .empty_state {text-align:center; padding:80px 20px;}
    .empty_state i {font-size:5rem; color:#d4af37; opacity:0.6; margin-bottom:20px;}
  </style>
</head>
<body>

<?php include 'user_header.php'; ?>

<section class="orders_section">
  <h1>Your Order History</h1>

  <div class="orders_container">
    <?php
    // Use a prepared statement for safety
    $stmt = mysqli_prepare($conn, "SELECT * FROM `orders` WHERE user_id = ? ORDER BY id DESC");
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
      while ($order = mysqli_fetch_assoc($result)) {
        $status = htmlspecialchars($order['payment_status']);
        $status_class = ($status === 'pending') ? 'status_pending' : 'status_completed';
    ?>
        <div class="order_card">
          <div class="order_header">
            <span class="order_date"><i class="far fa-calendar-alt"></i> <?= htmlspecialchars($order['placed_on']) ?></span>
            <span class="order_status <?= $status_class ?>"><?= ucfirst($status) ?></span>
          </div>

          <div class="order_details">
            <div class="detail_row"><span class="detail_label">Name:</span><?= htmlspecialchars($order['name']) ?></div>
            <div class="detail_row"><span class="detail_label">Contact:</span><?= htmlspecialchars($order['number']) ?></div>
            <div class="detail_row"><span class="detail_label">Email:</span><?= htmlspecialchars($order['email']) ?></div>
            <div class="detail_row"><span class="detail_label">Address:</span><?= htmlspecialchars($order['address']) ?></div>
            <div class="detail_row"><span class="detail_label">Payment Method:</span><span class="detail_highlight"><?= htmlspecialchars($order['method']) ?></span></div>
            <div class="detail_row"><span class="detail_label">Products:</span><?= htmlspecialchars($order['total_products']) ?></div>
            <div class="detail_row"><span class="detail_label">Total Amount:</span><span class="detail_highlight">₹<?= htmlspecialchars($order['total_price']) ?>/-</span></div>
          </div>
        </div>
    <?php
      }
    } else {
      echo '<div class="empty_state">
              <i class="fas fa-shopping-bag"></i>
              <h2>No Orders Found</h2>
              <p>You haven’t placed any orders yet.</p>
              <a href="shop.php" class="detail_highlight">Start Shopping →</a>
            </div>';
    }

    mysqli_stmt_close($stmt);
    ?>
  </div>
</section>

<?php include 'footer.php'; ?>

</body>
</html>
