<?php session_start(); include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UI/UX Design Software - Maftiyo</title>
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
          <li><a href="wishlist.php"><i class="fas fa-heart"></i> Wishlist</a></li>
          <li><a href="account.php"><i class="fas fa-user"></i> Account</a></li>
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
    <h2>UI/UX Design Software</h2>
    <input type="text" id="search" placeholder="Search UI/UX design software..." class="search-bar">
    <div class="categories" id="softwareContainer">
      <?php foreach($software as $sw): if($sw['category'] == 'UI/UX Design'): ?>
        <div class="software-card">
          <button class="wishlist-btn <?php echo in_array($sw['id'], $_SESSION['wishlist'] ?? []) ? 'active' : ''; ?>" data-id="<?php echo $sw['id']; ?>"><i class="fas fa-heart"></i></button>
          <img src="<?php echo $sw['icon']; ?>" alt="<?php echo $sw['name']; ?>">
          <h3><?php echo $sw['name']; ?></h3>
          <p><?php echo $sw['description']; ?></p>
          <p class="price">$<?php echo $sw['price']; ?></p>
          <div class="rating">
            <?php for($i = 1; $i <= 5; $i++): ?>
              <i class="fas fa-star <?php echo ($i <= ($_SESSION['ratings'][$sw['id']] ?? 0)) ? 'active' : ''; ?>" data-rating="<?php echo $i; ?>" data-id="<?php echo $sw['id']; ?>"></i>
            <?php endfor; ?>
          </div>
          <a href="software.php?id=<?php echo $sw['id']; ?>" class="btn">View Details</a>
        </div>
      <?php endif; endforeach; ?>
    </div>
  </main>
  <footer>
    <p><i class="fas fa-copyright"></i> &copy; 2023 Maftiyo. All rights reserved.</p>
  </footer>
  <script>
    const softwareData = <?php echo json_encode($software); ?>;
  </script>
  <script src="js/scripts.js"></script>
  <script>
    const searchInput = document.getElementById('search');
    const softwareContainer = document.getElementById('softwareContainer');
    if (softwareContainer) {
      searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const cards = softwareContainer.querySelectorAll('.software-card');
        cards.forEach(card => {
          const name = card.querySelector('h3').textContent.toLowerCase();
          card.style.display = name.includes(query) ? 'block' : 'none';
        });
      });
    }
  </script>
</body>
</html>
