<?php session_start(); include 'config.php'; $reviews = json_decode(file_get_contents('reviews.json'), true) ?? []; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Categories - Maftiyo</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="dark-mode.css">
</head>
<body>
<?php include 'header.php'; ?>
  <main>
    <h2>Software Categories</h2>
    <input type="text" id="search" placeholder="Search software..." class="search-bar">
    <div class="categories" id="categoriesContainer">
      <?php
      $categories = array_unique(array_column($software, 'category'));
      $categoryPages = [
        'Coding' => 'coding.php',
        'Graphic Design' => 'graphic-design.php',
        'DevOps' => 'devops.php',
        'UI/UX Design' => 'ui-ux-design.php',
        'Browser' => 'browser.php',
        'Communication' => 'communication.php',
        'Social Media' => 'social-media.php'
      ];
      $ratings = [];
      foreach($software as $sw) {
          $sw_reviews = array_filter($reviews, fn($r) => $r['software_id'] == $sw['id'] && $r['approved']);
          $avg = empty($sw_reviews) ? 0 : array_sum(array_column($sw_reviews, 'rating')) / count($sw_reviews);
          $ratings[$sw['id']] = round($avg, 1);
      }
      foreach($categories as $cat):
        $link = isset($categoryPages[$cat]) ? $categoryPages[$cat] : 'category.php?cat=' . urlencode($cat);
      ?>
        <div class="category-card">
          <h3><?php echo $cat; ?></h3>
          <p>Explore <?php echo $cat; ?> software</p>
          <a href="<?php echo $link; ?>" class="btn">View</a>
        </div>
      <?php endforeach; ?>
    </div>
    <?php if(isset($_GET['cat'])): ?>
      <h3><?php echo htmlspecialchars($_GET['cat']); ?> Software</h3>
      <div class="filters">
        <form id="filterForm">
          <label>Min Price: <input type="number" id="minPrice" placeholder="0"></label>
          <label>Max Price: <input type="number" id="maxPrice" placeholder="1000"></label>
          <label>Min Rating: <input type="number" id="minRating" step="0.1" placeholder="0"></label>
          <button type="button" id="applyFilters">Apply Filters</button>
          <button type="button" id="clearFilters">Clear</button>
        </form>
      </div>
      <div class="categories" id="softwareContainer">
        <?php foreach($software as $sw): if($sw['category'] == $_GET['cat']): ?>
          <div class="software-card" data-price="<?php echo $sw['price']; ?>" data-rating="<?php echo $ratings[$sw['id']]; ?>">
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
    <?php endif; ?>
  </main>
<?php include 'footer.php'; ?>
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
