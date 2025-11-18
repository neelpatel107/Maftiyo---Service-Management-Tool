<?php session_start(); if(!isset($_SESSION['user'])) header('Location: login.php'); include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bundle Payment - Maftiyo</title>
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
    <h2><i class="fas fa-shopping-cart"></i> Bundle Payment</h2>
    <?php
    $id = $_GET['id'] ?? null;
    $offer = array_filter($bestOffers, fn($o) => $o['id'] == $id);
    $offer = reset($offer);
    if($offer): ?>
      <div class="bundle-summary">
        <div class="bundle-header">
          <img src="<?php echo $offer['icon']; ?>" alt="<?php echo $offer['name']; ?>" class="bundle-icon">
          <div class="bundle-info">
            <h3><?php echo $offer['name']; ?></h3>
            <p><?php echo $offer['description']; ?></p>
            <div class="bundle-pricing">
              <span class="original-price">$<?php echo number_format($offer['originalPrice'], 2); ?></span>
              <span class="discounted-price">$<?php echo number_format($offer['discountedPrice'], 2); ?></span>
              <span class="discount-badge"><?php echo $offer['discount']; ?>% OFF</span>
            </div>
          </div>
        </div>

        <div class="bundle-items-summary">
          <h4>Included Software:</h4>
          <ul>
            <?php foreach($offer['items'] as $itemId):
              $item = array_filter($software, fn($sw) => $sw['id'] == $itemId);
              $item = reset($item);
              if($item): ?>
                <li><?php echo $item['name']; ?> - $<?php echo $item['price']; ?></li>
              <?php endif; ?>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

      <form action="process_bundle_payment.php" method="POST">
        <input type="hidden" name="bundle_id" value="<?php echo $id; ?>">
        <div class="payment-methods">
          <div class="payment-option" data-method="card">
            <i class="fas fa-credit-card"></i>
            <h3>Credit/Debit Card</h3>
            <p>Secure payment with Visa, MasterCard, American Express</p>
          </div>
          <div class="payment-option" data-method="upi">
            <i class="fas fa-mobile-alt"></i>
            <h3>UPI</h3>
            <p>Instant payment via GPay, PhonePe, Paytm</p>
          </div>
          <div class="payment-option" data-method="paypal">
            <i class="fab fa-paypal"></i>
            <h3>PayPal</h3>
            <p>Global payment solution</p>
          </div>
          <div class="payment-option" data-method="crypto">
            <i class="fab fa-bitcoin"></i>
            <h3>Cryptocurrency</h3>
            <p>Pay with Bitcoin, Ethereum, and other crypto</p>
          </div>
        </div>
        <input type="hidden" name="method" id="selectedMethod">
        <div class="order-summary">
          <div class="summary-row">
            <span>Bundle Price:</span>
            <span>$<?php echo number_format($offer['discountedPrice'], 2); ?></span>
          </div>
          <div class="summary-row">
            <span>You Save:</span>
            <span class="savings">-$<?php echo number_format($offer['originalPrice'] - $offer['discountedPrice'], 2); ?></span>
          </div>
          <div class="summary-row total">
            <span><strong>Total:</strong></span>
            <span><strong>$<?php echo number_format($offer['discountedPrice'], 2); ?></strong></span>
          </div>
        </div>
        <button type="submit" class="btn btn-large" id="payBtn" disabled>
          <i class="fas fa-lock"></i> Complete Purchase
        </button>
      </form>
    <?php else: ?>
      <div class="error-message">
        <h2><i class="fas fa-exclamation-triangle"></i> Bundle Not Found</h2>
        <p>The bundle you're trying to purchase doesn't exist.</p>
        <a href="index.php" class="btn">Back to Home</a>
      </div>
    <?php endif; ?>
  </main>
  <footer>
    <p><i class="fas fa-copyright"></i> &copy; 2023 Maftiyo. All rights reserved.</p>
  </footer>
  <script>
    // Load software data from PHP
    const softwareData = <?php echo json_encode($software); ?>;
    const bestOffersData = <?php echo json_encode($bestOffers); ?>;
  </script>
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
