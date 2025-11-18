<?php session_start(); include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MyTool</title>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
  />
  <link rel="stylesheet" href="css/styles.css" />
  <link rel="stylesheet" href="dark-mode.css" />
  <style>
    /* Hero Section */
    .hero {
      position: relative;
      background-image: url('https://images.unsplash.com/photo-1461749280684-dccba630e2f6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
      background-size: cover;
      background-position: center;
      height: 450px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      text-align: center;
      padding: 0 1rem;
    }
    .hero-overlay {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.5);
      z-index: 1;
    }
    .hero-content {
      position: relative;
      z-index: 2;
      max-width: 700px;
    }
    .hero-content h2 {
      font-size: 2.5rem;
      margin-bottom: 1rem;
      text-shadow: 0 0 10px rgba(0, 0, 0, 0.7);
    }
    .hero-content p {
      font-size: 1.2rem;
      margin-bottom: 1.5rem;
      text-shadow: 0 0 8px rgba(0, 0, 0, 0.6);
    }
    .hero-content .btn {
      font-size: 1.1rem;
      padding: 0.75rem 1.5rem;
    }

    /* Stats Section */
    .stats {
      display: flex;
      justify-content: space-around;
      margin: 3rem 0;
      flex-wrap: wrap;
      gap: 2rem;
    }
    .stat-item {
      flex: 1 1 150px;
      background: #fff;
      border-radius: 10px;
      padding: 1.5rem;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      text-align: center;
      transition: transform 0.3s ease;
    }
    .stat-item:hover {
      transform: translateY(-5px);
    }
    .stat-item i {
      margin-bottom: 0.5rem;
    }
    .stat-item h3 {
      font-size: 2rem;
      margin-bottom: 0.25rem;
      color: #667eea;
    }
    .stat-item p {
      font-size: 1rem;
      color: #555;
    }

    /* Featured, Best Offers, Popular, Recently Viewed Sections */
    .categories {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 1.5rem;
      margin-top: 1rem;
    }
    .software-card {
      background: #fff;
      border-radius: 10px;
      padding: 1rem;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      position: relative;
      transition: box-shadow 0.3s ease;
    }
    .software-card:hover {
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    .software-card img {
      width: 64px;
      height: 64px;
      object-fit: contain;
      margin-bottom: 0.75rem;
    }
    .software-card h3 {
      margin-bottom: 0.5rem;
      font-size: 1.25rem;
      color: #333;
    }
    .software-card p {
      font-size: 0.9rem;
      color: #666;
      margin-bottom: 0.5rem;
      min-height: 40px;
    }
    .software-card .price {
      font-weight: bold;
      color: #28a745;
      margin-bottom: 0.5rem;
    }
    .software-card .rating {
      margin-bottom: 0.75rem;
    }
    .software-card .rating .fa-star {
      color: #ddd;
    }
    .software-card .rating .fa-star.active {
      color: #ffc107;
    }
    .software-card .btn {
      font-size: 0.9rem;
      padding: 0.5rem 1rem;
    }
    .wishlist-btn {
      position: absolute;
      top: 10px;
      right: 10px;
      background: none;
      border: none;
      font-size: 1.3rem;
      color: #ddd;
      cursor: pointer;
      transition: color 0.3s ease;
    }
    .wishlist-btn.active {
      color: #e74c3c;
    }

    /* Offer Card */
    .offer-card {
      text-align: center;
    }
    .offer-card .offer-details {
      display: flex;
      justify-content: center;
      gap: 1rem;
      margin: 0.5rem 0;
    }
    .offer-card .original-price {
      text-decoration: line-through;
      color: #999;
    }
    .offer-card .discounted-price {
      font-weight: bold;
      color: #28a745;
    }
    .offer-card .discount {
      background: #28a745;
      color: white;
      padding: 0.2rem 0.5rem;
      border-radius: 5px;
      font-size: 0.8rem;
    }
    .offer-card .included-items {
      margin-top: 0.5rem;
      text-align: left;
    }
    .offer-card .included-items ul {
      list-style: disc;
      padding-left: 1.2rem;
      font-size: 0.85rem;
      color: #555;
    }

    /* Why Us Section */
    .why-us {
      margin: 3rem 0;
      text-align: center;
    }
    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 2rem;
      margin-top: 1rem;
    }
    .feature {
      background: #fff;
      padding: 1.5rem;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }
    .feature:hover {
      transform: translateY(-5px);
    }
    .feature i {
      font-size: 2.5rem;
      margin-bottom: 0.5rem;
    }
    .feature h3 {
      margin-bottom: 0.5rem;
      color: #333;
    }
    .feature p {
      color: #666;
      font-size: 0.95rem;
    }

    /* Testimonials Section */
    .testimonials {
      margin: 3rem 0;
      text-align: center;
    }
    .reviews {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 1.5rem;
      margin-top: 1rem;
    }
    .review {
      background: #fff;
      padding: 1rem 1.5rem;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      max-width: 300px;
      font-style: italic;
      color: #555;
    }
    .review p:last-child {
      font-style: normal;
      font-weight: bold;
      margin-top: 0.75rem;
      color: #333;
    }

    /* Newsletter Section */
    footer .newsletter {
      background: #667eea;
      color: white;
      padding: 2rem 1rem;
      text-align: center;
      border-radius: 10px 10px 0 0;
      margin-bottom: 1rem;
    }
    footer .newsletter h3 {
      margin-bottom: 0.5rem;
    }
    footer .newsletter p {
      margin-bottom: 1rem;
      font-size: 1rem;
    }
    footer .newsletter form {
      display: flex;
      justify-content: center;
      gap: 0.5rem;
      flex-wrap: wrap;
    }
    footer .newsletter input[type="email"] {
      padding: 0.75rem 1rem;
      border: none;
      border-radius: 5px;
      width: 250px;
      max-width: 100%;
      font-size: 1rem;
    }
    footer .newsletter button {
      padding: 0.75rem 1.5rem;
      background: #28a745;
      border: none;
      border-radius: 5px;
      color: white;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s ease;
    }
    footer .newsletter button:hover {
      background: #218838;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .hero-content h2 {
        font-size: 1.8rem;
      }
      .stats {
        flex-direction: column;
        gap: 1rem;
      }
      .categories {
        grid-template-columns: 1fr;
      }
      .reviews {
        flex-direction: column;
      }
      .features-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
<?php include 'header.php'; ?>
  <main>
    <section class="hero">
      <div class="hero-overlay"></div>
      <div class="hero-content">
        <h2><i class="fas fa-rocket"></i> Welcome to the Ultimate Software Download Platform</h2>
        <p>
          Download coding tools, video editors, and more with ease. Professional,
          secure, and lightning-fast.
        </p>
        <a href="categories.php" class="btn"
          ><i class="fas fa-search"></i> Explore Categories</a
        >
      </div>
    </section>

    <section class="stats">
      <div class="stat-item">
        <i class="fas fa-download" style="font-size: 3rem; color: #667eea"></i>
        <h3>10,000+</h3>
        <p>Downloads</p>
      </div>
      <div class="stat-item">
        <i class="fas fa-users" style="font-size: 3rem; color: #764ba2"></i>
        <h3>5,000+</h3>
        <p>Users</p>
      </div>
      <div class="stat-item">
        <i class="fas fa-star" style="font-size: 3rem; color: #ffc107"></i>
        <h3>4.8/5</h3>
        <p>Rating</p>
      </div>
      <div class="stat-item">
        <i class="fas fa-layer-group" style="font-size: 3rem; color: #00d4ff"></i>
        <h3>50+</h3>
        <p>Categories</p>
      </div>
    </section>

    <section class="featured">
      <h2><i class="fas fa-fire"></i> Featured Software</h2>
      <div class="categories">
        <?php $featured = array_slice($software, 0, 6);
        foreach ($featured as $sw) : ?>
        <div class="software-card">
          <button
            class="wishlist-btn <?php echo in_array($sw['id'], $_SESSION['wishlist'] ?? []) ? 'active' : ''; ?>"
            data-id="<?php echo $sw['id']; ?>"
          >
            <i class="fas fa-heart"></i>
          </button>
          <img src="<?php echo $sw['icon']; ?>" alt="<?php echo $sw['name']; ?>" />
          <h3><?php echo $sw['name']; ?></h3>
          <p><?php echo $sw['description']; ?></p>
          <p class="price">$<?php echo $sw['price']; ?></p>
          <div class="rating">
            <?php for ($i = 1; $i <= 5; $i++) : ?>
            <i
              class="fas fa-star <?php echo ($i <= ($_SESSION['ratings'][$sw['id']] ?? 0)) ? 'active' : ''; ?>"
              data-rating="<?php echo $i; ?>"
              data-id="<?php echo $sw['id']; ?>"
            ></i>
            <?php endfor; ?>
          </div>
          <a href="software.php?id=<?php echo $sw['id']; ?>" class="btn"
            ><i class="fas fa-eye"></i> View Details</a
          >
        </div>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="best-offers">
      <h2><i class="fas fa-gift"></i> Best Offers</h2>
      <div class="categories">
        <?php foreach ($bestOffers as $offer) : ?>
        <div class="software-card offer-card">
          <img src="<?php echo $offer['icon']; ?>" alt="<?php echo $offer['name']; ?>" />
          <h3><?php echo $offer['name']; ?></h3>
          <p><?php echo $offer['description']; ?></p>
          <div class="offer-details">
            <p class="original-price">$<?php echo number_format($offer['originalPrice'], 2); ?></p>
            <p class="discounted-price">$<?php echo number_format($offer['discountedPrice'], 2); ?></p>
            <p class="discount"><?php echo $offer['discount']; ?>% OFF</p>
          </div>
          <div class="included-items">
            <small>Includes:</small>
            <ul>
              <?php foreach ($offer['items'] as $itemId) : ?>
              <?php
                $item = array_filter($software, function ($sw) use ($itemId) {
                  return $sw['id'] == $itemId;
                });
              ?>
              <?php if ($item) : $item = array_values($item)[0]; ?>
              <li><?php echo $item['name']; ?></li>
              <?php endif; ?>
              <?php endforeach; ?>
            </ul>
          </div>
          <a href="offer.php?id=<?php echo $offer['id']; ?>" class="btn"
            ><i class="fas fa-shopping-cart"></i> Get Bundle</a
          >
        </div>
        <?php endforeach; ?>
      </div>
    </section>

    <section class="popular">
      <h2><i class="fas fa-star"></i> Popular Software</h2>
      <div class="categories">
        <?php $popular = array_slice($software, 6, 12);
        foreach ($popular as $sw) : ?>
        <div class="software-card">
          <img src="<?php echo $sw['icon']; ?>" alt="<?php echo $sw['name']; ?>" />
          <h3><?php echo $sw['name']; ?></h3>
          <p><?php echo $sw['description']; ?></p>
          <p class="price">$<?php echo $sw['price']; ?></p>
          <a href="software.php?id=<?php echo $sw['id']; ?>" class="btn"
            ><i class="fas fa-eye"></i> View Details</a
          >
        </div>
        <?php endforeach; ?>
      </div>
    </section>

    <?php if (isset($_SESSION['recently_viewed']) && !empty($_SESSION['recently_viewed'])) : ?>
    <section class="recently-viewed">
      <h2><i class="fas fa-history"></i> Recently Viewed</h2>
      <div class="categories">
        <?php
          $recent = array_filter($software, fn($s) => in_array($s['id'], $_SESSION['recently_viewed']));
          foreach (array_slice($recent, 0, 6) as $sw) :
        ?>
        <div class="software-card">
          <img src="<?php echo $sw['icon']; ?>" alt="<?php echo $sw['name']; ?>" />
          <h3><?php echo $sw['name']; ?></h3>
          <p><?php echo $sw['description']; ?></p>
          <p class="price">$<?php echo $sw['price']; ?></p>
          <a href="software.php?id=<?php echo $sw['id']; ?>" class="btn"
            ><i class="fas fa-eye"></i> View Details</a
          >
        </div>
        <?php endforeach; ?>
      </div>
    </section>
    <?php endif; ?>

    <section class="why-us">
      <h2><i class="fas fa-shield-alt"></i> Why Choose Us?</h2>
      <div class="features-grid">
        <div class="feature">
          <i class="fas fa-lock" style="color: #28a745"></i>
          <h3>Secure Downloads</h3>
          <p>All software is scanned and verified for safety.</p>
        </div>
        <div class="feature">
          <i class="fas fa-bolt" style="color: #00d4ff"></i>
          <h3>Lightning Fast</h3>
          <p>High-speed servers for instant downloads.</p>
        </div>
        <div class="feature">
          <i class="fas fa-credit-card" style="color: #667eea"></i>
          <h3>Secure Payments</h3>
          <p>Multiple payment options with encryption.</p>
        </div>
        <div class="feature">
          <i class="fas fa-headset" style="color: #764ba2"></i>
          <h3>24/7 Support</h3>
          <p>Round-the-clock customer assistance.</p>
        </div>
      </div>
    </section>

    <section class="testimonials">
      <h2><i class="fas fa-comments"></i> Client Reviews</h2>
      <div class="reviews">
        <div class="review">
          <p>"MyTool has made downloading software so easy and secure. Highly recommended!"</p>
          <p>- Sarah Johnson</p>
        </div>
        <div class="review">
          <p>"Great selection of tools. Fast downloads and excellent support."</p>
          <p>- Mike Chen</p>
        </div>
        <div class="review">
          <p>"Professional platform with user-friendly interface."</p>
          <p>- Emily Davis</p>
        </div>
      </div>
    </section>
  </main>
<?php include 'footer.php'; ?>
  <script>
    // Load software data from PHP
    const softwareData = <?php echo json_encode($software); ?>;
    const bestOffersData = <?php echo json_encode($bestOffers); ?>;
  </script>
  <script src="js/scripts.js"></script>
</body>
</html>
