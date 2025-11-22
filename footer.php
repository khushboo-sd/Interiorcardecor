<!-- footer.php -->
<footer class="modern_footer">
  <div class="footer_content">
    <div class="footer_grid">
      <!-- Company Info Section -->
      <div class="footer_column company_info">
        <h3 class="footer_heading">Interior Car Decor</h3>
        <div class="contact_info">
          <p class="contact_item">
            <i class="fas fa-phone"></i>
            <span>+91 9825442975</span>
          </p>
          <p class="contact_item">
            <i class="fas fa-envelope"></i>
            <span>tejpalsinghbhati9801@gmail.com</span>
          </p>
          <p class="contact_item">
            <i class="fas fa-map-marker-alt"></i>
            <span>Surat, Gujarat, India - 395009</span>
          </p>
          <p class="contact_item">
            <i class="fa-solid fa-shop"></i>
            <span>Shop Timings : 9am - 9pm</span>
          </p>
        </div>
      </div>

      <!-- Quick Links Section -->
      <div class="footer_column">
        <h3 class="footer_heading">Quick Links</h3>
        <div class="footer_links">
          <a href="home.php" class="footer_link">Home</a>
          <a href="about.php" class="footer_link">About</a>
          <a href="shop.php" class="footer_link">Shop</a>
          <a href="contact.php" class="footer_link">Contact</a>
        </div>
      </div>

      <!-- Other Links Section -->
      <div class="footer_column">
        <h3 class="footer_heading">Other Links</h3>
        <div class="footer_links">
          <a href="login.php" class="footer_link">Login</a>
          <a href="register.php" class="footer_link">Register</a>
          <a href="cart.php" class="footer_link">Cart</a>
          <a href="orders.php" class="footer_link">Orders</a>
        </div>
      </div>
    </div>
  </div>

 
</footer>

<style>
/* === MODERN FOOTER STYLES === */
.modern_footer {
  background: #000;
  color: #fff;
  font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
  margin-top: auto;
}

.footer_content {
  max-width: 1400px;
  margin: 0 auto;
  padding: 60px 30px 40px;
}

.footer_grid {
  display: grid;
  grid-template-columns: 1.5fr 1fr 1fr;
  gap: 60px;
}

/* === FOOTER COLUMNS === */
.footer_column {
  display: flex;
  flex-direction: column;
}

.footer_heading {
  color: #d4af37;
  font-size: 20px;
  font-weight: 600;
  margin-bottom: 25px;
  letter-spacing: 0.5px;
}

/* === COMPANY INFO SECTION === */
.company_info .footer_heading {
  font-size: 22px;
  margin-bottom: 30px;
}

.contact_info {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.contact_item {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  color: #ccc;
  font-size: 15px;
  line-height: 1.6;
  margin: 0;
}

.contact_item i {
  color: #d4af37;
  font-size: 16px;
  margin-top: 3px;
  min-width: 18px;
}

.contact_item span {
  color: #ccc;
}

/* === FOOTER LINKS === */
.footer_links {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.footer_link {
  color: #ccc;
  text-decoration: none;
  font-size: 15px;
  transition: all 0.3s ease;
  display: inline-block;
  width: fit-content;
}

.footer_link:hover {
  color: #d4af37;
  transform: translateX(5px);
}

/* === FOOTER BOTTOM === */
.footer_bottom {
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  padding: 25px 30px;
  max-width: 1400px;
  margin: 0 auto;
}

.copyright_text {
  text-align: center;
  color: #888;
  font-size: 14px;
  margin: 0;
  letter-spacing: 0.3px;
}

.copyright_text .highlight {
  color: #d4af37;
  font-weight: 500;
}

/* === RESPONSIVE DESIGN === */
@media (max-width: 1024px) {
  .footer_grid {
    grid-template-columns: 1fr 1fr;
    gap: 40px;
  }
  
  .company_info {
    grid-column: 1 / -1;
  }
  
  .footer_content {
    padding: 50px 25px 30px;
  }
}

@media (max-width: 768px) {
  .footer_grid {
    grid-template-columns: 1fr;
    gap: 35px;
  }
  
  .company_info {
    grid-column: 1;
  }
  
  .footer_content {
    padding: 40px 20px 25px;
  }
  
  .footer_heading {
    font-size: 18px;
    margin-bottom: 20px;
  }
  
  .company_info .footer_heading {
    font-size: 20px;
  }
  
  .contact_item {
    font-size: 14px;
    gap: 10px;
  }
  
  .footer_link {
    font-size: 14px;
  }
  
  .footer_bottom {
    padding: 20px 20px;
  }
  
  .copyright_text {
    font-size: 13px;
  }
}

@media (max-width: 480px) {
  .footer_content {
    padding: 35px 15px 20px;
  }
  
  .footer_grid {
    gap: 30px;
  }
  
  .footer_heading {
    font-size: 17px;
  }
  
  .company_info .footer_heading {
    font-size: 18px;
  }
  
  .contact_item {
    font-size: 13px;
  }
  
  .footer_link {
    font-size: 13px;
  }
  
  .copyright_text {
    font-size: 12px;
    line-height: 1.6;
  }
}

/* === ACCESSIBILITY === */
@media (prefers-reduced-motion: reduce) {
  .footer_link {
    transition: none;
  }
}

/* === PRINT STYLES === */
@media print {
  .modern_footer {
    background: white;
    color: black;
  }
  
  .footer_heading,
  .contact_item i,
  .copyright_text .highlight {
    color: black;
  }
}