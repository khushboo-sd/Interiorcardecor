<?php
include 'config.php';
session_start();

// Check if required session data exists
if (!isset($_SESSION['payment_order_id']) || !isset($_SESSION['payment_method'])) {
    header('location:checkout.php');
    exit;
}

$order_id = intval($_SESSION['payment_order_id']);
$method = $_SESSION['payment_method'];

// Handle simulated payment submission
if (isset($_POST['pay_btn'])) {
    // Update order status to completed
    $update_payment = mysqli_prepare($conn, "UPDATE orders SET payment_status = 'completed' WHERE id = ?");
    mysqli_stmt_bind_param($update_payment, "i", $order_id);
    mysqli_stmt_execute($update_payment);

    // Clear payment session data
    unset($_SESSION['payment_order_id']);
    unset($_SESSION['payment_method']);

    $message = "Payment successful! Your order #$order_id has been placed.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment Gateway - Interior Car Decor</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
body { font-family:'Poppins',sans-serif; background:#1a1a2e; color:#fff; display:flex; justify-content:center; align-items:center; height:100vh; margin:0; }
.payment_container { background: rgba(255,255,255,0.05); padding:50px; border-radius:15px; text-align:center; max-width:400px; width:100%; }
.payment_container h2 { color:#d4af37; margin-bottom:20px; }
.payment_container p { margin-bottom:30px; }
.product_btn { display:inline-block; background:#d4af37; color:#000; padding:15px 40px; border-radius:8px; border:2px solid #d4af37; font-weight:600; cursor:pointer; transition:all 0.3s ease; text-decoration:none; }
.product_btn:hover { background:transparent; color:#d4af37; transform:translateY(-3px); box-shadow:0 10px 30px rgba(212,175,55,0.3); }
.message { background:#dff0d8; border-left:5px solid #28a745; padding:15px 20px; margin-bottom:20px; border-radius:8px; color:#155724; }
</style>
</head>
<body>

<div class="payment_container">
    <h2>Payment - <?php echo htmlspecialchars($method); ?></h2>

    <?php if(isset($message)): ?>
        <div class="message"><i class="fa fa-check-circle"></i> <?php echo $message; ?></div>
        <a href="orders.php" class="product_btn">View My Orders</a>
    <?php else: ?>
        <p>Click the button below to simulate <?php echo htmlspecialchars($method); ?> payment for Order #<?php echo $order_id; ?>.</p>
        <form method="post">
            <button type="submit" name="pay_btn" class="product_btn"><i class="fa fa-credit-card"></i> Pay Now</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
