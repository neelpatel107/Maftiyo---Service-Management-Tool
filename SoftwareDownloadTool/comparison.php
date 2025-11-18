<?php
session_start();
include 'config.php';

$compare_ids = $_SESSION['compare'] ?? [];
$compare_software = array_filter($software, fn($s) => in_array($s['id'], $compare_ids));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Software Comparison - Maftiyo</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="css/styles.css" />
  <style>
    .comparison-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
    }
    .comparison-table th, .comparison-table td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: center;
      vertical-align: top;
    }
    .comparison-table th {
      background-color: #f4f4f4;
    }
    .software-icon {
      width: 64px;
      height: 64px;
      object-fit: contain;
    }
    .remove-btn {
      background: #dc3545;
      color: white;
      border: none;
      padding: 5px 10px;
      cursor: pointer;
      border-radius: 5px;
    }
  </style>
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
  </header>
  <main>
    <h2>Software Comparison</h2>
    <?php if(empty($compare_software)): ?>
      <p>No software selected for comparison. Please select software from the categories.</p>
    <?php else: ?>
      <table class="comparison-table">
        <thead>
          <tr>
            <th>Feature</th>
            <?php foreach($compare_software as $sw): ?>
              <th>
                <img src="<?php echo $sw['icon']; ?>" alt="<?php echo $sw['name']; ?>" class="software-icon" /><br />
                <?php echo htmlspecialchars($sw['name']); ?><br />
                <button class="remove-btn" data-id="<?php echo $sw['id']; ?>">Remove</button>
              </th>
            <?php endforeach; ?>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Description</td>
            <?php foreach($compare_software as $sw): ?>
              <td><?php echo htmlspecialchars($sw['description']); ?></td>
            <?php endforeach; ?>
          </tr>
          <tr>
            <td>Price</td>
            <?php foreach($compare_software as $sw): ?>
              <td>$<?php echo $sw['price']; ?></td>
            <?php endforeach; ?>
          </tr>
          <tr>
            <td>Rating</td>
            <?php foreach($compare_software as $sw): ?>
              <td>
                <?php
                $rating = $_SESSION['ratings'][$sw['id']] ?? 0;
                for ($i = 1; $i <= 5; $i++) {
                  echo '<i class="fas fa-star ' . ($i <= $rating ? 'active' : '') . '"></i>';
                }
                ?>
              </td>
            <?php endforeach; ?>
          </tr>
          <tr>
            <td>Download</td>
            <?php foreach($compare_software as $sw): ?>
              <td>
                <?php if($sw['price'] > 0): ?>
                  <a href="payment.php?id=<?php echo $sw['id']; ?>" class="btn">Buy Now</a>
                <?php else: ?>
                  <a href="<?php echo $sw['downloadLink']; ?>" class="btn" target="_blank">Download Free</a>
                <?php endif; ?>
              </td>
            <?php endforeach; ?>
          </tr>
        </tbody>
      </table>
    <?php endif; ?>
  </main>
  <footer>
    <p><i class="fas fa-copyright"></i> &copy; 2023 Maftiyo. All rights reserved.</p>
  </footer>
  <script>
    document.querySelectorAll('.remove-btn').forEach(button => {
      button.addEventListener('click', () => {
        const id = button.getAttribute('data-id');
        fetch('compare_action.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ id, action: 'remove' })
        })
        .then(res => res.json())
        .then(data => {
          if(data.success) {
            location.reload();
          }
        });
      });
    });
  </script>
</body>
</html>
