<?php
if(isset($message)){
    foreach($message as $message){
        echo '
        <div class="message" style="
            background:#0A1D37;
            color:#F1D27A;
            padding:12px 18px;
            margin:10px auto;
            width:95%;
            border-left:4px solid #D4AF37;
            border-radius:10px;
            font-size:16px;
            display:flex;
            justify-content:space-between;
            box-shadow:0 4px 10px rgba(0,0,0,0.4);
        ">
            <span>'.$message.'</span>
            <i class="fa-solid fa-xmark" onclick=\"this.parentElement.remove();\" 
               style=\"cursor:pointer;color:#F1D27A;font-size:18px;\"></i>
        </div>
        ';
    } 
}
?>

<header class="admin_header" style="
    width:100%;
    background:#071A2B;
    padding:15px 0;
    position:sticky;
    top:0;
    left:0;
    z-index:1000;
    box-shadow:0 4px 12px rgba(0,0,0,0.5);
">
    <div class="header_navigation" style="
        max-width:1400px;
        margin:auto;
        display:flex;
        justify-content:space-between;
        align-items:center;
        padding:0 20px;
        color:white;
        position:relative;
    ">

      <a href="admin_page.php" class="header_logo" style="
          font-size:28px;
          font-weight:700;
          color:#F1D27A;
          text-decoration:none;
      ">
        Admin <span style="color:white;">Dashboard</span>
      </a>

      <nav class="header_navbar" style="
          display:flex;
          gap:25px;
      ">
        <a href="admin_page.php" style="text-decoration:none;color:white;font-size:16px;transition:0.3s;" 
           onmouseover="this.style.color='#D4AF37';" onmouseout="this.style.color='white';">Home</a>

        <a href="admin_products.php" style="text-decoration:none;color:white;font-size:16px;transition:0.3s;" 
           onmouseover="this.style.color='#D4AF37';" onmouseout="this.style.color='white';">Products</a>

        <a href="admin_orders.php" style="text-decoration:none;color:white;font-size:16px;transition:0.3s;" 
           onmouseover="this.style.color='#D4AF37';" onmouseout="this.style.color='white';">Orders</a>

        <a href="admin_users.php" style="text-decoration:none;color:white;font-size:16px;transition:0.3s;" 
           onmouseover="this.style.color='#D4AF37';" onmouseout="this.style.color='white';">Users</a>

        <a href="admin_messages.php" style="text-decoration:none;color:white;font-size:16px;transition:0.3s;" 
           onmouseover="this.style.color='#D4AF37';" onmouseout="this.style.color='white';">Messages</a>
      </nav>

      <!-- USER ICON ONLY (HAMBURGER REMOVED) -->
      <div class="header_icons" style="
          display:flex;
          gap:20px;
          color:#F1D27A;
          font-size:22px;
          cursor:pointer;
      ">
        <div id="user_btn" class="fas fa-user"></div>
      </div>

      <!-- HIDDEN ACCOUNT BOX (TOGGLE ON CLICK) -->
      <div id="acc_box" style="
          display:none;
          position:absolute;
          top:65px;
          right:20px;
          background:#0A1D37;
          padding:15px 18px;
          border-radius:12px;
          border:1px solid #D4AF37;
          color:white;
          font-size:14px;
          width:220px;
          box-shadow:0 4px 14px rgba(0,0,0,0.5);
          animation:fadeIn 0.3s;
      ">
        <p style="margin:0 0 5px 0;">Username : 
            <span style="color:#F1D27A;"><?php echo $_SESSION['admin_name'];?></span>
        </p>

        <p style="margin:0 0 10px 0;">Email : 
            <span style="color:#F1D27A;"><?php echo $_SESSION['admin_email'];?></span>
        </p>

        <a href="logout.php" style="
            text-decoration:none;
            padding:8px 12px;
            background:#D4AF37;
            color:#071A2B;
            font-weight:600;
            text-align:center;
            border-radius:8px;
            display:block;
            transition:0.3s;
        "
        onmouseover="this.style.background='#F1D27A';"
        onmouseout="this.style.background='#D4AF37';">
            Logout
        </a>
      </div>

    </div>
</header>

<script>
// Toggle account box
document.getElementById("user_btn").onclick = function(){
    let box = document.getElementById("acc_box");
    box.style.display = (box.style.display === "block") ? "none" : "block";
};
</script>
