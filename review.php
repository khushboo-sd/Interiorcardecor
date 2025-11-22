<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
  header('location:login.php');
  exit;
}

if (isset($_POST['submit_review'])) {
    $review_text = trim($_POST['review']);
    $user_query = mysqli_query($conn, "SELECT name FROM `register` WHERE id = '$user_id'");
    $user_data = mysqli_fetch_assoc($user_query);
    $user_name = $user_data['name'];

    if (!empty($review_text)) {
        mysqli_query($conn, "INSERT INTO `reviews` (user_id, name, review) VALUES ('$user_id', '$user_name', '$review_text')");
        $message[] = "✅ Review submitted successfully!";
    } else {
        $message[] = "❌ Please enter your review before submitting!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Reviews - STF Car Interior Design</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
* {margin: 0; padding: 0; box-sizing: border-box;}
body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, rgba(10,10,10,0.95), rgba(26,26,46,0.95)), url('https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=1920') center/cover;
  min-height: 100vh;
  color: #fff;
  padding: 50px 20px;
}
.container {
  max-width: 800px;
  margin: auto;
  background: rgba(26,26,46,0.9);
  border: 1px solid rgba(212,175,55,0.3);
  border-radius: 20px;
  padding: 40px;
  box-shadow: 0 15px 50px rgba(0,0,0,0.5);
}
h2 {
  text-align: center;
  margin-bottom: 25px;
  color: #d4af37;
  font-size: 2rem;
}
textarea {
  width: 100%;
  min-height: 120px;
  border-radius: 15px;
  border: 2px solid rgba(212,175,55,0.3);
  background: rgba(0,0,0,0.3);
  color: #fff;
  padding: 15px;
  font-size: 1rem;
  outline: none;
  resize: vertical;
}
textarea:focus {
  border-color: #d4af37;
}
button {
  display: block;
  margin: 20px auto 0;
  background: linear-gradient(135deg, #d4af37, #f4e5c3);
  border: none;
  color: #0a0a0a;
  font-weight: 600;
  padding: 12px 30px;
  border-radius: 50px;
  cursor: pointer;
  transition: 0.3s;
}
button:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 25px rgba(212,175,55,0.4);
}
.review-box {
  margin-top: 40px;
}
.review {
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.1);
  padding: 20px;
  border-radius: 15px;
  margin-bottom: 20px;
  transition: 0.3s;
}
.review:hover {
  background: rgba(255,255,255,0.08);
  transform: translateY(-3px);
}
.review h4 {
  color: #d4af37;
  margin-bottom: 8px;
  font-weight: 600;
}
.review p {
  color: #ccc;
  font-size: 0.95rem;
}
.review time {
  display: block;
  margin-top: 8px;
  font-size: 0.8rem;
  color: #888;
}
.message {
  background: rgba(212,175,55,0.9);
  color: #0a0a0a;
  padding: 10px 15px;
  margin-bottom: 15px;
  border-radius: 10px;
  text-align: center;
  font-weight: 500;
}
</style>
</head>
<body>

<div class="container">
  <h2><i class="fa fa-star"></i> Share Your Review</h2>

  <?php
  if (isset($message)) {
    foreach ($message as $msg) {
      echo "<div class='message'>$msg</div>";
    }
  }
  ?>

  <form method="POST">
    <textarea name="review" placeholder="Write your honest feedback here..." required></textarea>
    <button type="submit" name="submit_review">Submit Review</button>
  </form>

  <div class="review-box">
    <h2><i class="fa fa-comments"></i> User Reviews</h2>

    <?php
    $reviews = mysqli_query($conn, "SELECT * FROM `reviews` ORDER BY id DESC");
    if (mysqli_num_rows($reviews) > 0) {
      while ($rev = mysqli_fetch_assoc($reviews)) {
        echo "
        <div class='review'>
          <h4><i class='fa fa-user'></i> {$rev['name']}</h4>
          <p>{$rev['review']}</p>
          <time><i class='fa fa-clock'></i> " . date('M d, Y h:i A', strtotime($rev['created_at'])) . "</time>
        </div>";
      }
    } else {
      echo "<p>No reviews yet. Be the first to share your feedback!</p>";
    }
    ?>
  </div>
</div>

</body>
</html>
