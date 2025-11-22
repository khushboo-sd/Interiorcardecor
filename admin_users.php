<?php
include 'config.php';
session_start();

$admin_id=$_SESSION['admin_id'];

if(!isset($admin_id)){
  header('location:login.php');
}

if(isset($_GET['delete'])){
  $delete_id=$_GET['delete'];
  mysqli_query($conn,"DELETE FROM `register` WHERE id='$delete_id'");
  $message[]='1 user has been deleted';
  header("location:admin_users.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Users</title>
  <style>
      body{
          background:#071A2B; 
          font-family: 'Poppins', sans-serif;
          color:white;
          margin:0;
      }

      .admin_users{
          padding: 40px 0;
      }

      .admin_box_container{
          width: 95%;
          margin:auto;
          display: flex;
          flex-wrap: wrap;
          gap: 20px;
          justify-content: center;
      }

      .admin_box{
          background:#0A1D37;
          border: 1px solid #D4AF37;
          width:300px;
          padding:20px;
          border-radius:12px;
          box-shadow:0 4px 10px rgba(0,0,0,0.4);
          transition:0.3s;
      }

      .admin_box:hover{
          transform: translateY(-5px);
          box-shadow:0 6px 18px rgba(0,0,0,0.6);
      }

      .admin_box p{
          font-size:15px;
          margin:8px 0;
          color:white;
      }

      .admin_box span{
          color:#F1D27A;
          font-weight:bold;
      }

      .delete-btn{
          display:block;
          width:100%;
          text-align:center;
          background:#D9534F;
          padding:10px;
          color:white;
          text-decoration:none;
          border-radius:8px;
          margin-top:15px;
          font-weight:bold;
          transition:0.3s;
      }

      .delete-btn:hover{
          background:#C9302C;
      }
  </style>
</head>
<body>

<?php
include 'admin_header.php';
?>

<section class="admin_users">
  <div class="admin_box_container">
    <?php
      $select_users=mysqli_query($conn,"SELECT * FROM `register`");

      while($fetch_users=mysqli_fetch_assoc($select_users)){

    ?>
    <div class="admin_box">
      <p>Username : <span><?php echo $fetch_users['name']?></span></p>
      <p>Email : <span><?php echo $fetch_users['email']?></span></p>
      <p>Usertype : <span style="color:<?php if($fetch_users['user_type']=='admin'){echo 'blue';}else{echo 'green';}?>"><?php echo $fetch_users['user_type']?></span></p>
      <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');" class="delete-btn">delete</a>
    </div>
      <?php
        };
      ?>
    
  </div>
</section>



<script src="admin_js.js"></script>
<script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>

</body>
</html>