<?php
include 'config.php';

// Live suggestion list
if (isset($_POST['query'])) {
    $query = mysqli_real_escape_string($conn, $_POST['query']);
    $result = mysqli_query($conn, "SELECT name FROM products WHERE name LIKE '%$query%' LIMIT 10");
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='result-item'>" . htmlspecialchars($row['name']) . "</div>";
        }
    } else {
        echo "<div class='result-item'>No products found</div>";
    }
    exit;
}

// Show product card when name selected
if (isset($_POST['product_name'])) {
    $name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $result = mysqli_query($conn, "SELECT * FROM products WHERE name='$name'");
    if (mysqli_num_rows($result) > 0) {
        while ($p = mysqli_fetch_assoc($result)) {
            echo "
            <div class='product-card'>
              <img src='uploaded_img/{$p['image']}' alt=''>
              <h3>{$p['name']}</h3>
              <p>₹{$p['price']} /-</p>
            </div>
            ";
        }
    } else {
        echo "<p>No details found</p>";
    }
}
?>
