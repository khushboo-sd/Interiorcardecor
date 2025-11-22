<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;
if (empty($user_id)) {
  header('location:login.php');
  exit();
}

// Add to cart functionality
$message = [];
if (isset($_POST['add_to_cart'])) {
  $pro_name = mysqli_real_escape_string($conn, $_POST['product_name']);
  $pro_price = mysqli_real_escape_string($conn, $_POST['product_price']);
  $pro_quantity = mysqli_real_escape_string($conn, $_POST['product_quantity']);
  $pro_image = mysqli_real_escape_string($conn, $_POST['product_image']);

  $check = mysqli_query($conn, "SELECT * FROM `cart` WHERE name='$pro_name' AND user_id='$user_id'");
  if (mysqli_num_rows($check) > 0) {
    $message[] = 'Already added to cart!';
  } else {
    mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image)
      VALUES ('$user_id','$pro_name','$pro_price','$pro_quantity','$pro_image')");
    $message[] = 'Product added to cart!';
  }
}

include 'user_header.php'; // ✅ Common black header with golden text
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shop - Interior Car Decor</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
body {
  font-family: 'Poppins', sans-serif;
  background: #0a0a0a;
  color: #fff;
  margin-top: 100px; /* space for fixed header */
}
.products_cont {
  max-width: 1300px;
  margin: auto;
  padding: 60px 5%;
  text-align: center;
}
.products_cont h2 {
  color: #d4af37;
  font-size: 2.4rem;
  margin-bottom: 40px;
}
.pro_box_cont {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(270px, 1fr));
  gap: 25px;
}
.pro_box {
  background: rgba(255,255,255,.05);
  border: 1px solid rgba(212,175,55,.3);
  border-radius: 15px;
  padding: 20px;
  text-align: center;
  transition: .3s;
}
.pro_box img {
  width: 100%;
  height: 220px;
  object-fit: cover;
  border-radius: 10px;
}
.pro_box h3 { color: #d4af37; margin: 10px 0; }
.pro_box p { color: #ccc; }
.pro_box input[type=number] {
  width: 60px; padding: 6px; text-align: center;
  background: rgba(255,255,255,.1); color: #fff;
  border: 1px solid rgba(212,175,55,.3); border-radius: 5px; margin: 10px 0;
}
.product_btn {
  background: linear-gradient(135deg,#d4af37,#f4e5c3);
  border: none; padding: 10px 18px; border-radius: 20px;
  color: #000; font-weight: 600; cursor: pointer; transition: .3s;
}
.product_btn:hover {
  transform: scale(1.05);
  box-shadow: 0 0 15px rgba(212,175,55,.3);
}
</style>
</head>

<body>

<section class="products_cont">
  <h2>Our Latest Products</h2>
  <div class="pro_box_cont">
    <?php
    $select_products = mysqli_query($conn, "SELECT * FROM `products`");
    if(mysqli_num_rows($select_products) > 0){
      while($fetch = mysqli_fetch_assoc($select_products)){ ?>
        <form method="post" class="pro_box">
          <img src="./uploaded_img/<?= $fetch['image'] ?>" alt="">
          <h3><?= $fetch['name'] ?></h3>
          <p>₹ <?= $fetch['price'] ?> /-</p>
          <input type="hidden" name="product_name" value="<?= $fetch['name'] ?>">
          <input type="number" name="product_quantity" min="1" value="1">
          <input type="hidden" name="product_price" value="<?= $fetch['price'] ?>">
          <input type="hidden" name="product_image" value="<?= $fetch['image'] ?>">
          <input type="submit" name="add_to_cart" value="Add to Cart" class="product_btn">
        </form>
      <?php } } else echo '<p>No Products Found!</p>'; ?>
  </div>
</section>
<?php include 'footer.php'; ?>
</body>
</html>
