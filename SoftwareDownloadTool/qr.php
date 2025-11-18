<?php 
session_start(); 
if(!isset($_SESSION['user'])) header('Location: login.php'); 
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>QR Payment - Maftiyo</title>
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
      <input type="text" placeholder="Search software..." class="search-bar" id="searchInput">
      <button class="search-btn"><i class="fas fa-search"></i></button>
      <ul class="search-suggestions" id="searchSuggestions"></ul>
    </div>
    <div class="mobile-menu-toggle">
      <i class="fas fa-bars"></i>
    </div>
  </header>
  <main>
    <h1><i class="fas fa-qrcode"></i> QR Payment</h1>

    <?php
    $bundle_id = $_GET['bundle_id'] ?? null;
    $software_id = $_GET['id'] ?? null;

    if($bundle_id) {
      $offer = array_filter($bestOffers, fn($o) => $o['id'] == $bundle_id);
      $offer = reset($offer);
      if($offer) {
        echo "<div class='payment-summary'>";
        echo "<h3>Bundle: {$offer['name']}</h3>";
        echo "<p>Amount: <strong>$" . number_format($offer['discountedPrice'], 2) . "</strong></p>";
        echo "</div>";
      }
    } elseif($software_id) {
      $sw = array_filter($software, fn($s) => $s['id'] == $software_id);
      $sw = reset($sw);
      if($sw) {
        echo "<div class='payment-summary'>";
        echo "<h3>Software: {$sw['name']}</h3>";
        echo "<p>Amount: <strong>$" . number_format($sw['price'], 2) . "</strong></p>";
        echo "</div>";
      }
    }
    ?>

    <div class="qr-code">
      <img src="image/p1.jpg" alt="QR Code for Payment">
      <p>Scan this QR code with your UPI app (e.g., GPay, PhonePe, Paytm)</p>
      <p class="qr-instructions">
        <i class="fas fa-info-circle"></i> After scanning, complete the payment and click "Confirm Payment" below
      </p>
    </div>

    <form action="process_confirm.php" method="POST">
      <input type="hidden" name="id" value="<?php echo $software_id; ?>">
      <input type="hidden" name="bundle_id" value="<?php echo $bundle_id; ?>">
      <button type="submit" class="btn btn-large">
        <i class="fas fa-check"></i> Confirm Payment
      </button>
    </form>
  </main>
  <footer>
    <p><i class="fas fa-copyright"></i> &copy; 2023 Maftiyo. All rights reserved.</p>
  </footer>
  <script src="js/scripts.js"></script>
</body>
</html>
