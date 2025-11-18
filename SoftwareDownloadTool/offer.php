<?php session_start(); include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bundle Details - Maftiyo</title>
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
    <?php
    $id = $_GET['id'] ?? null;
    $offer = array_filter($bestOffers, fn($o) => $o['id'] == $id);
    $offer = reset($offer);
    if($offer): ?>
      <div class="bundle-details">
        <div class="bundle-header">
          <img src="<?php echo $offer['icon']; ?>" alt="<?php echo $offer['name']; ?>" class="bundle-icon">
          <div class="bundle-info">
            <h2><?php echo $offer['name']; ?></h2>
            <p><?php echo $offer['description']; ?></p>
            <div class="bundle-pricing">
              <span class="original-price">$<?php echo number_format($offer['originalPrice'], 2); ?></span>
              <span class="discounted-price">$<?php echo number_format($offer['discountedPrice'], 2); ?></span>
              <span class="discount-badge"><?php echo $offer['discount']; ?>% OFF</span>
            </div>
            <div class="savings">
              <strong>You save: $<?php echo number_format($offer['originalPrice'] - $offer['discountedPrice'], 2); ?></strong>
            </div>
          </div>
        </div>

        <div class="bundle-benefits">
          <h3><i class="fas fa-check-circle"></i> What's Included in This Bundle:</h3>
          <div class="included-software">
            <?php foreach($offer['items'] as $itemId):
              $item = array_filter($software, fn($sw) => $sw['id'] == $itemId);
              $item = reset($item);
              if($item): ?>
                <div class="included-item">
                  <img src="<?php echo $item['icon']; ?>" alt="<?php echo $item['name']; ?>">
                  <div class="item-info">
                    <h4><?php echo $item['name']; ?></h4>
                    <p><?php echo $item['description']; ?></p>
                    <span class="individual-price">Individual: $<?php echo $item['price']; ?></span>
                  </div>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="bundle-actions">
          <a href="payment_bundle.php?id=<?php echo $offer['id']; ?>" class="btn btn-large">
            <i class="fas fa-shopping-cart"></i> Buy Bundle - $<?php echo number_format($offer['discountedPrice'], 2); ?>
          </a>
          <div class="bundle-features">
            <div class="feature">
              <i class="fas fa-shield-alt"></i>
              <span>Lifetime Access</span>
            </div>
            <div class="feature">
              <i class="fas fa-download"></i>
              <span>Instant Download</span>
            </div>
            <div class="feature">
              <i class="fas fa-headset"></i>
              <span>24/7 Support</span>
            </div>
          </div>
        </div>
      </div>
    <?php else: ?>
      <div class="error-message">
        <h2><i class="fas fa-exclamation-triangle"></i> Bundle Not Found</h2>
        <p>The bundle you're looking for doesn't exist or has been removed.</p>
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
</body>
</html>
