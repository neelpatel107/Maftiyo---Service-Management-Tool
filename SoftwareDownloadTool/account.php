<?php session_start(); if(!isset($_SESSION['user'])) header('Location: login.php'); include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Account - Maftiyo</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <?php include 'header.php'; ?>
  <main>
    <h2><i class="fas fa-user"></i> Your Account</h2>

    <?php if(isset($_GET['bundle_success'])): ?>
      <div class="success-message" style="background: rgba(40, 167, 69, 0.1); border: 1px solid #28a745; color: #28a745; padding: 1rem; border-radius: 10px; margin-bottom: 2rem; text-align: center;">
        <i class="fas fa-check-circle"></i> Bundle purchased successfully! All included software is now available for download.
      </div>
    <?php endif; ?>

    <div class="user-info">
      <h3>Welcome, <?php echo $_SESSION['user']['fname']; ?>!</h3>
      <p>Email: <?php echo $_SESSION['user']['email']; ?></p>
    </div>

    <?php
    $bundle_purchases = $_SESSION['bundle_purchases'] ?? [];
    if(!empty($bundle_purchases)): ?>
      <div class="download-history">
        <h3><i class="fas fa-box"></i> Bundle Purchases</h3>
        <?php foreach($bundle_purchases as $purchase): $offer = array_filter($bestOffers, fn($o) => $o['id'] == $purchase['bundle_id']); $offer = reset($offer); ?>
          <div class="history-item">
            <img src="<?php echo $offer['icon']; ?>" alt="<?php echo $offer['name']; ?>" class="small-icon">
            <div>
              <h4><?php echo $offer['name']; ?> <span style="color: #28a745; font-size: 0.8rem;">(Bundle)</span></h4>
              <p>Purchased on: <?php echo date('M d, Y', strtotime($purchase['purchase_date'])); ?></p>
              <small>Includes: <?php echo count($purchase['items']); ?> software items</small>
            </div>
            <div style="display: flex; gap: 0.5rem;">
              <a href="download.php?bundle_id=<?php echo $purchase['bundle_id']; ?>" class="btn" style="font-size: 0.8rem; padding: 8px 12px;">Download All</a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php
    $downloads = $_SESSION['downloads'] ?? [];
    if(!empty($downloads)): ?>
      <div class="download-history">
        <h3><i class="fas fa-download"></i> Purchased Software</h3>
        <?php foreach($downloads as $id): $sw = array_filter($software, fn($s) => $s['id'] == $id); $sw = reset($sw); if($sw): ?>
          <div class="history-item">
            <img src="<?php echo $sw['icon']; ?>" alt="<?php echo $sw['name']; ?>" class="small-icon">
            <div>
              <h4><?php echo $sw['name']; ?></h4>
              <p><?php echo $sw['description']; ?></p>
            </div>
            <a href="download.php?id=<?php echo $id; ?>" class="btn">Download</a>
          </div>
        <?php endif; endforeach; ?>
      </div>
    <?php endif; ?>

    <div class="download-history">
      <h3><i class="fas fa-download"></i> Download History</h3>
      <?php
      $download_history = $_SESSION['download_history'] ?? [];
      if(empty($download_history)): ?>
        <p>No downloads yet.</p>
      <?php else: foreach($download_history as $download): $sw = array_filter($software, fn($s) => $s['id'] == $download['id']); $sw = reset($sw); ?>
        <div class="history-item">
          <img src="<?php echo $sw['icon']; ?>" alt="<?php echo $sw['name']; ?>" class="small-icon">
          <div>
            <h4><?php echo $sw['name']; ?></h4>
            <p><?php echo $sw['description']; ?></p>
            <small>Downloaded on: <?php echo date('M d, Y H:i', strtotime($download['timestamp'])); ?></small>
          </div>
          <a href="download.php?id=<?php echo $download['id']; ?>" class="btn">Download Again</a>
        </div>
      <?php endforeach; endif; ?>
    </div>
  </main>
  <footer>
    <p><i class="fas fa-copyright"></i> &copy; 2023 Maftiyo. All rights reserved.</p>
  </footer>
  <script src="js/scripts.js"></script>
</body>
</html>
