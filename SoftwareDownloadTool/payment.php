<?php session_start(); if(!isset($_SESSION['user'])) header('Location: login.php'); include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment - Maftiyo</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <header class="header-container">
    <div class="logo">
      <i class="fas fa-download" style="font-size: 2rem; color: #667eea; margin-right: 0.5rem;"></i>
      <h1>Maftiyo</h1>
    </div>
    <nav class="main-nav">
      <ul>
        <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
        <li><a href="categories.php"><i class="fas fa-th-large"></i> Categories</a></li>
        <?php if(isset($_SESSION['user'])): ?>
          <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        <?php else: ?>
          <li><a href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
          <li><a href="register.php"><i class="fas fa-user-plus"></i> Register</a></li>
        <?php endif; ?>
      </ul>
    </nav>
    <div class="header-search">
      <input type="text" placeholder="Search software..." class="search-bar">
      <button class="search-btn"><i class="fas fa-search"></i></button>
    </div>
    <div class="mobile-menu-toggle">
      <i class="fas fa-bars"></i>
    </div>
  </header>
  <main>
    <h2>Payment Gateway</h2>
    <?php
    $id = $_GET['id'] ?? null;
    $sw = array_filter($software, fn($s) => $s['id'] == $id);
    $sw = reset($sw);
    if($sw): ?>
      <div class="software-details">
        <img src="<?php echo $sw['icon']; ?>" alt="<?php echo $sw['name']; ?>" class="software-icon">
        <h3><?php echo $sw['name']; ?></h3>
        <p><?php echo $sw['description']; ?></p>
        <p class="price">$<?php echo $sw['price']; ?></p>
        <div class="rating">★★★★☆ (4.5/5)</div>
      </div>
      <form action="process_payment.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="payment-methods">
          <div class="payment-option" data-method="card">
            <h3>Credit/Debit Card</h3>
            <p>Secure payment with Visa, MasterCard</p>
          </div>
          <div class="payment-option" data-method="upi">
            <h3>UPI</h3>
            <p>Instant payment via GPay, PhonePe</p>
          </div>
          <div class="payment-option" data-method="paypal">
            <h3>PayPal</h3>
            <p>Global payment solution</p>
          </div>
        </div>
        <input type="hidden" name="method" id="selectedMethod">
        <button type="submit" class="btn" id="payBtn" disabled>Proceed to Pay</button>
      </form>
    <?php endif; ?>
  </main>
  <footer>
    <p><i class="fas fa-copyright"></i> &copy; 2023 Maftiyo. All rights reserved.</p>
  </footer>
  <script src="js/scripts.js"></script>
  <script>
    document.querySelectorAll('.payment-option').forEach(option => {
      option.addEventListener('click', () => {
        document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('selected'));
        option.classList.add('selected');
        document.getElementById('selectedMethod').value = option.dataset.method;
        document.getElementById('payBtn').disabled = false;
      });
    });
  </script>
</body>
</html>
