<?php
include 'config.php';
session_start();

$admin_id=$_SESSION['admin_id'];

if(!isset($admin_id)){
  header('location:login.php');
};

if(isset($_POST['add_products_btn'])){
  $name=mysqli_real_escape_string($conn, $_POST['name']);
  $price=$_POST['price'];
  $image=$_FILES['image']['name'];
  $image_size=$_FILES['image']['size'];
  $image_tmp_name=$_FILES['image']['tmp_name'];
  $image_folder="uploaded_img/".$image;

  $select_product_name=mysqli_query($conn, "SELECT name FROM `products` WHERE name='$name'") or die('query failed');

  if(mysqli_num_rows($select_product_name)>0){
    $message[]='The given product is already added';
  }else{
    $add_product_query=mysqli_query($conn,"INSERT INTO `products`(name,price,image) VALUES ('$name','$price','$image')") or die('query2 failed');
    if($add_product_query){
      if($image_size>2000000){
        $message[]='Image size is too large';
      }else{
        move_uploaded_file($image_tmp_name,$image_folder);
        $message[]="Product added successfully!";
      }
    }else{
      $message[]="Product failed to be added!";
    }
  }
};

if(isset($_GET['delete'])){
  $delete_id=$_GET['delete'];

  $delete_img_query=mysqli_query($conn,"SELECT image from `products` WHERE id='$delete_id'") or die('query failed');
  $fetch_del_img=mysqli_fetch_assoc($delete_img_query);
  unlink('./uploaded_img/'.$fetch_del_img);

  mysqli_query($conn, "DELETE FROM `products` WHERE id='$delete_id'") or die('query failed');
  header('location:admin_products.php');
}

if(isset($_POST['update_product'])){
  $update_p_id=$_POST['update_p_id'];
  $update_name=$_POST['update_name'];
  $update_price=$_POST['update_price'];

  mysqli_query($conn,"UPDATE `products` SET name='$update_name', price='$update_price' WHERE id='$update_p_id'") or die('query failed');

  $update_image=$_FILES['update_image']['name'];
  $update_image_tmp_name=$_FILES['update_image']['tmp_name'];
  $update_image_size=$_FILES['update_image']['size'];
  $update_folder='./uploaded_img/'.$update_image;
  $old_image=$_POST['update_old_img'];
  if(!empty($update_image)){
    if($update_image_size>2000000){
      $message[]='Image size is too large';
    }else{
      mysqli_query($conn,"UPDATE `products` SET image='$update_image' WHERE id='$update_p_id'") or die('query failed');

      move_uploaded_file($update_image_tmp_name,$update_folder);
      unlink('./uploaded_img/'.$old_image);

      $message[]="Product added successfully!";
    }
  }
  header('location:admin_products.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
  <style>
    body{
      margin:0;
      background:#071A2B;    /* Navy */
      font-family:'Poppins',sans-serif;
      color:white;
    }

    /* Add Product Form */
    .admin_add_products form{
      width:350px;
      margin:30px auto;
      padding:25px;
      border:2px solid #D4AF37;
      background:#0A1D37;
      border-radius:12px;
      box-shadow:0 0 20px rgba(0,0,0,0.5);
      text-align:center;
    }

    .admin_add_products h3{
      color:#F1D27A;
      margin-bottom:20px;
    }

    .admin_input{
      width:100%;
      padding:12px;
      margin:10px 0;
      border-radius:8px;
      border:2px solid #D4AF37;
      background:#071A2B;
      color:white;
      font-size:15px;
    }

    .admin_input[type="submit"]{
      background:#D4AF37;
      color:#071A2B;
      font-weight:bold;
      cursor:pointer;
      transition:0.2s;
    }
    .admin_input[type="submit"]:hover{
      background:#F1D27A;
    }

    /* Product Listing */
    .product_box_cont{
      display:flex;
      flex-wrap:wrap;
      gap:25px;
      justify-content:center;
      padding:30px;
    }

    .product_box{
      width:260px;
      background:#0A1D37;
      border:2px solid #D4AF37;
      border-radius:12px;
      padding:15px;
      text-align:center;
      box-shadow:0 0 20px rgba(0,0,0,0.5);
      transition:0.3s;
    }

    .product_box:hover{
      transform:translateY(-8px);
      box-shadow:0 0 25px rgba(212,175,55,0.8);
    }

    .product_box img{
      width:100%;
      height:220px;
      object-fit:cover;
      border-radius:10px;
      margin-bottom:10px;
      border:2px solid #F1D27A;
    }

    .product_name{
      font-size:20px;
      color:white;
      margin:8px 0;
      font-weight:600;
    }

    .product_price{
      color:#F1D27A;
      font-size:18px;
      margin-bottom:10px;
    }

    .product_btn{
      display:block;
      padding:10px;
      border-radius:8px;
      margin:6px 0;
      background:#D4AF37;
      color:#071A2B;
      font-weight:600;
      text-decoration:none;
      transition:0.2s;
    }

    .product_btn:hover{
      background:#F1D27A;
    }

    .product_del_btn{
      background:#b30000;
      color:white;
    }
    .product_del_btn:hover{
      background:#ff1a1a;
    }

    /* Edit Form */
    .edit_product_form{
      display:flex;
      justify-content:center;
      padding:30px;
    }

    .edit_product_form form{
      width:350px;
      padding:25px;
      background:#0A1D37;
      border:2px solid #D4AF37;
      border-radius:12px;
      text-align:center;
      box-shadow:0 0 20px rgba(0,0,0,0.5);
    }

    .edit_product_form img{
      width:100%;
      height:220px;
      object-fit:cover;
      border-radius:10px;
      border:2px solid #D4AF37;
      margin-bottom:15px;
    }
  </style>
</head>
<body>

<?php
include 'admin_header.php';
?>

<section class="admin_add_products">
  <form action="" method="post" enctype="multipart/form-data">
    <h3>Add Product</h3>
    <input type="text" name="name" class="admin_input" placeholder="Enter Product Name" required>

    <input type="number" min="0" name="price" class="admin_input" placeholder="Enter Product Price" required>

    <input type="file" name="image" class="admin_input" accept="image/jpg, image/jpeg, image/png" required>

    <input type="submit" name="add_products_btn" class="admin_input" value="Add Product">
  </form>

</section>

<section class="show_products">
  <div class="product_box_cont">
    <?php
      $select_products=mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');

      if(mysqli_num_rows($select_products)>0){
        while($fetch_products=mysqli_fetch_assoc($select_products)){

    ?>

    <div class="product_box">
      <img src="./uploaded_img/<?php echo $fetch_products['image'];?>" alt="">

      <div class="product_name">
      <?php echo $fetch_products['name'];?>
      </div>

      <div class="product_price">Rs. 
      <?php echo $fetch_products['price'];?> /-
      </div>

      <a href="admin_products.php?update=<?php echo $fetch_products['id']?>" class="product_btn">Update</a>

      <a href="admin_products.php?delete=<?php echo $fetch_products['id']?>" class="product_btn product_del_btn" onclick= "return confirm('Are you sure you want to delete this product ?');">Delete</a>
    </div>
    <?php
      }
    }else{
      echo '<p class="empty">No Product added yet!</p>';
    }
    ?>
  </div>
</section>

<section class="edit_product_form">
  <?php
    if(isset($_GET['update'])){
      $update_id=$_GET['update'];
      $update_query=mysqli_query($conn,"SELECT * FROM `products` WHERE id='$update_id'") or die('query failed');
      if(mysqli_num_rows($update_query)>0){
        while($fetch_update=mysqli_fetch_assoc($update_query)){

  ?>

  <form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id'];?>">

    <input type="hidden" name="update_old_img" value="<?php echo $fetch_update['image'];?>">

    <img src="./uploaded_img/<?php echo $fetch_update['image'];?>" alt="">


    <input type="text" name="update_name" value="<?php echo $fetch_update['name'];?>" class="admin_input update_box" required placeholder="Enter Product Name">

    <input type="number" name="update_price" min="0" value="<?php echo $fetch_update['price'];?>" class="admin_input update_box" required placeholder="Enter Product Price">

    <input type="file" name="update_image" value="<?php echo $fetch_update['price'];?>" class="admin_input update_box" accept="image/jpg, image/jpeg, image/png">

    <input type="submit" value="update" name="update_product" class="product_btn">
    <input type="reset" value="cancel" id="close_update" class="product_btn product_del_btn">
    
  </form>

  <?php
      }
    }
  }else{
    echo "<script>
    document.querySelector('.edit_product_form').style.display='none';
    </script>";
  }
  ?>

</section>

<script src="admin_js.js"></script>
<script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>

</body>
</html>