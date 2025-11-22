<?php
include 'config.php';
session_start();

$admin_id=$_SESSION['admin_id'];

if(!isset($admin_id)){
  header('location:login.php');
}

if(isset($_GET['delete'])){
  $delete_id=$_GET['delete'];
  mysqli_query($conn,"DELETE FROM `message` WHERE id='$delete_id'");
  $message[]='1 message has been deleted';
  header("location:admin_messages.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Messages</title>
   <style>
    body{
      margin:0;
      padding:0;
      font-family: 'Poppins', sans-serif;
      background:#071A2B;  /* NAVY BLUE */
      color:white;
    }

    .admin_messages{
      padding:30px;
    }

    .admin_box_container{
      display:flex;
      flex-wrap:wrap;
      gap:20px;
      justify-content:flex-start;
    }

    .admin_box{
      background:#0A1D37;     /* DARK BLUE */
      border:2px solid #D4AF37;  /* GOLD BORDER */
      border-radius:12px;
      padding:20px;
      width:300px;
      box-shadow:0 0 15px rgba(0,0,0,0.5);
      transition:0.3s ease-in-out;
    }

    .admin_box:hover{
      transform:translateY(-5px);
      box-shadow:0 0 25px rgba(212,175,55,0.7); /* GOLD GLOW */
    }

    .admin_box p{
      font-size:16px;
      margin:8px 0;
      font-weight:500;
      color:#F1D27A;  /* LIGHT GOLD LABEL */
    }

    .admin_box span{
      color:white;   /* White value text */
      font-weight:600;
    }

    .delete-btn{
      display:inline-block;
      background:#D4AF37;
      color:#071A2B;
      padding:8px 14px;
      border-radius:6px;
      margin-top:10px;
      font-weight:600;
      text-decoration:none;
      transition:0.3s;
    }

    .delete-btn:hover{
      background:#F1D27A;
      color:#000;
    }

    .empty{
      text-align:center;
      padding:20px;
      background:#0A1D37;
      border:2px solid #D4AF37;
      border-radius:10px;
      font-size:20px;
      width:100%;
      color:white;
    }
  </style>
</head>
<body>

<?php
include 'admin_header.php';
?>

<section class="admin_messages">
  <div class="admin_box_container">
    <?php
      $select_msgs=mysqli_query($conn,"SELECT * FROM `message`") or die('query failed');
      if(mysqli_num_rows($select_msgs)>0){
        while($fetch_msgs=mysqli_fetch_assoc($select_msgs)){  
    ?>
    <div class="admin_box">
      <p>Name : <span><?php echo $fetch_msgs['name']; ?></span></p>
      <p>Number : <span><?php echo $fetch_msgs['number']; ?></span></p>
      <p>Email : <span><?php echo $fetch_msgs['email']; ?></span></p>
      <p>Message : <span><?php echo $fetch_msgs['message']; ?></span></p>
      <a href="admin_messages.php?delete=<?php echo $fetch_msgs['id']; ?>" onclick="return confirm('Are you sure you want to delete this message?');" class="delete-btn">delete</a>
    </div>
    <?php
      };
    }
    else{
      echo '<p class="empty">You Have No Messages!</p>';
    }
    ?>
  </div>
</section>

<script src="admin_js.js"></script>
<script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>

</body>
</html>