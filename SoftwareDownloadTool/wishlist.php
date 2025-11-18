<?php session_start(); if(!isset($_SESSION['user'])) header('Location: login.php'); include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wishlist - Maftiyo</title>
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
        <li><a href="wishlist.php"><i class="fas fa-heart"></i> Wishlist</a></li>
        <li><a href="account.php"><i class="fas fa-user"></i> Account</a></li>
        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
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
    <h2><i class="fas fa-heart"></i> Your Wishlist</h2>
    <?php
    $wishlist = $_SESSION['wishlist'] ?? [];
    if(empty($wishlist)): ?>
      <p>Your wishlist is empty. Add some software to your wishlist from the home page!</p>
    <?php else: ?>
      <div class="categories">
        <?php foreach($wishlist as $id): $sw = array_filter($software, fn($s) => $s['id'] == $id); $sw = reset($sw); if($sw): ?>
          <div class="software-card">
            <button class="wishlist-btn active" data-id="<?php echo $sw['id']; ?>"><i class="fas fa-heart"></i></button>
            <img src="<?php echo $sw['icon']; ?>" alt="<?php echo $sw['name']; ?>">
            <h3><?php echo $sw['name']; ?></h3>
            <p><?php echo $sw['description']; ?></p>
            <p class="price">$<?php echo $sw['price']; ?></p>
            <div class="rating">
              <?php for($i = 1; $i <= 5; $i++): ?>
                <i class="fas fa-star <?php echo ($i <= ($_SESSION['ratings'][$sw['id']] ?? 0)) ? 'active' : ''; ?>" data-rating="<?php echo $i; ?>" data-id="<?php echo $sw['id']; ?>"></i>
              <?php endfor; ?>
            </div>
            <a href="software.php?id=<?php echo $sw['id']; ?>" class="btn"><i class="fas fa-eye"></i> View Details</a>
          </div>
        <?php endif; endforeach; ?>
      </div>
    <?php endif; ?>
  </main>
  <footer>
    <p><i class="fas fa-copyright"></i> &copy; 2023 Maftiyo. All rights reserved.</p>
  </footer>
  <script>
    const softwareData = <?php echo json_encode($software); ?>;
  </script>
  <script src="js/scripts.js"></script>
</body>
</html>
