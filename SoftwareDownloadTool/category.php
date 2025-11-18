<?php session_start(); include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($_GET['cat'] ?? 'Category'); ?> Software - Maftiyo</title>
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
    <div class="compare-bar" id="compareBar" style="display: none;">
      <span id="compareCount">0</span> selected for comparison
      <a href="comparison.php" class="btn">Compare Now</a>
    </div>
  </header>
  <main>
    <h2><?php echo htmlspecialchars($_GET['cat'] ?? 'Category'); ?> Software</h2>
    <div class="filter-section">
      <div class="filters">
        <input type="text" id="search" placeholder="Search <?php echo htmlspecialchars($_GET['cat'] ?? 'category'); ?> software..." class="search-bar">
        <div class="filter-controls">
          <label>Price Range:</label>
          <input type="number" id="minPrice" placeholder="Min Price" min="0" step="0.01">
          <input type="number" id="maxPrice" placeholder="Max Price" min="0" step="0.01">
          <label>Min Rating:</label>
          <select id="minRating">
            <option value="">Any</option>
            <option value="1">1+</option>
            <option value="2">2+</option>
            <option value="3">3+</option>
            <option value="4">4+</option>
            <option value="5">5</option>
          </select>
          <button id="applyFilters" class="btn">Apply Filters</button>
          <button id="clearFilters" class="btn">Clear</button>
        </div>
      </div>
    </div>
    <div class="categories" id="softwareContainer">
      <?php
      $cat = $_GET['cat'] ?? '';
      foreach($software as $sw): if($sw['category'] == $cat): ?>
        <div class="software-card">
          <div class="card-actions">
            <button class="wishlist-btn <?php echo in_array($sw['id'], $_SESSION['wishlist'] ?? []) ? 'active' : ''; ?>" data-id="<?php echo $sw['id']; ?>"><i class="fas fa-heart"></i></button>
            <label class="compare-checkbox">
              <input type="checkbox" class="compare-select" data-id="<?php echo $sw['id']; ?>" <?php echo in_array($sw['id'], $_SESSION['compare'] ?? []) ? 'checked' : ''; ?>>
              Compare
            </label>
          </div>
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
    const minPriceInput = document.getElementById('minPrice');
    const maxPriceInput = document.getElementById('maxPrice');
    const minRatingSelect = document.getElementById('minRating');
    const applyFiltersBtn = document.getElementById('applyFilters');
    const clearFiltersBtn = document.getElementById('clearFilters');

    function applyFilters() {
      const query = searchInput.value.toLowerCase();
      const minPrice = parseFloat(minPriceInput.value) || 0;
      const maxPrice = parseFloat(maxPriceInput.value) || Infinity;
      const minRating = parseInt(minRatingSelect.value) || 0;

      const cards = softwareContainer.querySelectorAll('.software-card');
      cards.forEach(card => {
        const name = card.querySelector('h3').textContent.toLowerCase();
        const priceText = card.querySelector('.price').textContent.replace('$', '');
        const price = parseFloat(priceText);
        const ratingStars = card.querySelectorAll('.rating .fa-star.active');
        const rating = ratingStars.length;

        const matchesSearch = name.includes(query);
        const matchesPrice = price >= minPrice && price <= maxPrice;
        const matchesRating = rating >= minRating;

        card.style.display = (matchesSearch && matchesPrice && matchesRating) ? 'block' : 'none';
      });
    }

    if (softwareContainer) {
      searchInput.addEventListener('input', applyFilters);
      minPriceInput.addEventListener('input', applyFilters);
      maxPriceInput.addEventListener('input', applyFilters);
      minRatingSelect.addEventListener('change', applyFilters);
      applyFiltersBtn.addEventListener('click', applyFilters);
      clearFiltersBtn.addEventListener('click', () => {
        searchInput.value = '';
        minPriceInput.value = '';
        maxPriceInput.value = '';
        minRatingSelect.value = '';
        applyFilters();
      });
    }
  </script>
</body>
</html>
