<?php
include 'config.php';
session_start();

$admin_id=$_SESSION['admin_id'];

if(!isset($admin_id)){
  header('location:login.php');
}

if(isset($_POST['update_order'])){

  $order_update_id=$_POST['order_id'];
  $update_payment=$_POST['update_payment'];

  mysqli_query($conn,"UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_update_id'") or die('query failed');

  $message[]='Order Payment status has been updated';
}

if(isset($_GET['delete'])){
  $delete_id=$_GET['delete'];
  mysqli_query($conn,"DELETE FROM `orders` WHERE id='$delete_id'");
  $message[]='1 order has been deleted';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orders</title>
   <style>
    body{
      margin:0;
      padding:0;
      font-family:'Poppins',sans-serif;
      background:#071A2B; /* navy */
      color:white;
    }

    .title{
      text-align:center;
      margin:20px 0;
      font-size:32px;
      font-weight:700;
      color:#F1D27A; /* Light Gold */
      text-transform:uppercase;
      letter-spacing:1px;
    }

    .admin_orders{
      padding:20px;
    }

    .admin_box_container{
      display:flex;
      flex-wrap:wrap;
      gap:20px;
    }

    .admin_box{
      background:#0A1D37; /* Dark Blue */
      border:2px solid #D4AF37; /* Gold */
      border-radius:12px;
      padding:20px;
      width:320px;
      box-shadow:0 0 15px rgba(0,0,0,0.5);
      transition:0.3s ease-in-out;
    }

    .admin_box:hover{
      transform:translateY(-5px);
      box-shadow:0 0 25px rgba(212,175,55,0.7); /* Gold Glow */
    }

    .admin_box p{
      margin:8px 0;
      font-size:15px;
      font-weight:500;
      color:#F1D27A; /* Light Gold labels */
    }

    .admin_box span{
      color:white; /* User information */
      font-weight:600;
    }

    .admin_box form{
      margin-top:10px;
    }

    select{
      width:100%;
      padding:8px;
      border-radius:6px;
      border:2px solid #D4AF37;
      background:#071A2B;
      color:white;
      font-size:14px;
      margin-bottom:10px;
    }

    .option-btn{
      width:100%;
      background:#D4AF37;
      color:#071A2B;
      padding:10px;
      border:none;
      border-radius:6px;
      font-weight:600;
      cursor:pointer;
      margin-bottom:10px;
      transition:0.3s;
    }

    .option-btn:hover{
      background:#F1D27A;
      color:black;
    }

    .delete-btn{
      display:block;
      width:100%;
      text-align:center;
      background:#b91c1c;
      padding:10px;
      color:white;
      border-radius:6px;
      font-weight:600;
      text-decoration:none;
      transition:0.3s;
    }

    .delete-btn:hover{
      background:#ef4444;
    }

    .empty{
      width:100%;
      text-align:center;
      padding:20px;
      background:#0A1D37;
      border:2px solid #D4AF37;
      border-radius:10px;
      font-size:20px;
      color:white;
      margin-top:20px;
    }
  </style>
</head>
<body>

<?php
include 'admin_header.php';
?>

<section class="admin_orders">
  <h1 class="title">Placed Orders</h1>

  <div class="admin_box_container">
    <?php
      $select_orders=mysqli_query($conn,"SELECT * FROM `orders`") or die('query failed');

      if(mysqli_num_rows($select_orders)>0){
        while($fetch_orders=mysqli_fetch_assoc($select_orders)){

    ?>
    <div class="admin_box">
      <p>User Id : <span><?php echo $fetch_orders['user_id']?></span></p>
      <p>Placed On : <span><?php echo $fetch_orders['placed_on']?></span></p>
      <p>Name : <span><?php echo $fetch_orders['name']?></span></p>
      <p>Number : <span><?php echo $fetch_orders['number']?></span></p>
      <p>Email : <span><?php echo $fetch_orders['email']?></span></p>
      <p>Address : <span><?php echo $fetch_orders['address']?></span></p>
      <p>Total Products : <span><?php echo $fetch_orders['total_products']?></span></p>
      <p>Total Price : <span><?php echo $fetch_orders['total_price']?></span></p>
      <p>Payment Method : <span><?php echo $fetch_orders['method']?></span></p>

      <form action="" method="post">
            <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
            <select name="update_payment">
               <option value="" selected disabled><?php echo $fetch_orders['payment_status']; ?></option>
               <option value="pending">pending</option>
               <option value="completed">completed</option>
            </select>
            <input type="submit" value="update" name="update_order" class="option-btn">
            <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('Are you sure you want to delete this order?');" class="delete-btn">delete</a>
         </form>
    </div>
    <?php
        }
      }else{
        echo '<p class="empty">No orders placed yet!</p>';
      }
    ?>
    
  </div>
</section>


<script src="admin_js.js"></script>
<script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>

</body>
</html>