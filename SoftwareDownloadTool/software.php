<?php session_start(); include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Software Details - Maftiyo</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="dark-mode.css">
</head>
<body>
<?php include 'header.php'; ?>
  <main>
    <?php
    $id = $_GET['id'] ?? null;
    $sw = array_filter($software, fn($s) => $s['id'] == $id);
    $sw = reset($sw);
    if($sw):
        if (!isset($_SESSION['recently_viewed'])) {
            $_SESSION['recently_viewed'] = [];
        }
        $key = array_search($id, $_SESSION['recently_viewed']);
        if ($key !== false) {
            unset($_SESSION['recently_viewed'][$key]);
        }
        array_unshift($_SESSION['recently_viewed'], $id);
        $_SESSION['recently_viewed'] = array_slice($_SESSION['recently_viewed'], 0, 10);
    ?>
      <div class="software-details">
        <img src="<?php echo $sw['icon']; ?>" alt="<?php echo $sw['name']; ?>" class="software-icon">
        <h2><?php echo $sw['name']; ?></h2>
        <p><?php echo $sw['description']; ?></p>
        <p class="price">$<?php echo $sw['price']; ?></p>
        <div class="rating">★★★★☆ (4.5/5)</div>
        <?php if($sw['price'] > 0): ?>
          <a href="payment.php?id=<?php echo $sw['id']; ?>" class="btn">Buy Now</a>
        <?php else: ?>
          <a href="<?php echo $sw['downloadLink']; ?>" class="btn" target="_blank">Download Free</a>
        <?php endif; ?>

        <!-- Social Sharing -->
        <div class="social-share">
          <h3>Share this software:</h3>
          <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('http://localhost/SoftwareDownloadTool/software.php?id=' . $sw['id']); ?>" target="_blank" class="share-btn"><i class="fab fa-facebook-f"></i></a>
          <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode('http://localhost/SoftwareDownloadTool/software.php?id=' . $sw['id']); ?>&text=<?php echo urlencode('Check out ' . $sw['name']); ?>" target="_blank" class="share-btn"><i class="fab fa-twitter"></i></a>
          <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode('http://localhost/SoftwareDownloadTool/software.php?id=' . $sw['id']); ?>" target="_blank" class="share-btn"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>

      <!-- Reviews Section -->
      <div class="reviews-section">
        <h3>User Reviews</h3>
        <?php
        $reviews = json_decode(file_get_contents('reviews.json'), true);
        $software_reviews = array_filter($reviews, fn($r) => $r['software_id'] == $id && $r['approved']);
        if (!empty($software_reviews)): ?>
          <div class="reviews-list">
            <?php foreach($software_reviews as $review): ?>
              <div class="review">
                <div class="review-header">
                  <strong><?php echo htmlspecialchars($review['user']); ?></strong>
                  <div class="rating">
                    <?php for($i = 1; $i <= 5; $i++): ?>
                      <i class="fas fa-star <?php echo $i <= $review['rating'] ? 'active' : ''; ?>"></i>
                    <?php endfor; ?>
                  </div>
                  <small><?php echo date('M d, Y', strtotime($review['date'])); ?></small>
                </div>
                <p><?php echo htmlspecialchars($review['comment']); ?></p>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <p>No reviews yet. Be the first to review!</p>
        <?php endif; ?>

        <?php if(isset($_SESSION['user'])): ?>
          <div class="review-form">
            <h4>Leave a Review</h4>
            <form id="reviewForm">
              <input type="hidden" name="software_id" value="<?php echo $id; ?>">
              <div class="rating-input">
                <label>Rating:</label>
                <div class="stars">
                  <?php for($i = 1; $i <= 5; $i++): ?>
                    <i class="fas fa-star" data-rating="<?php echo $i; ?>"></i>
                  <?php endfor; ?>
                </div>
                <input type="hidden" name="rating" id="ratingValue" required>
              </div>
              <textarea name="comment" placeholder="Write your review..." required></textarea>
              <button type="submit" class="btn">Submit Review</button>
            </form>
          </div>
        <?php else: ?>
          <p><a href="login.php">Login</a> to leave a review.</p>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </main>
<?php include 'footer.php'; ?>
  <script src="js/scripts.js"></script>
</body>
</html>
