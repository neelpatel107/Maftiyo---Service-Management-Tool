<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Maftiyo</title>
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
        <li><a href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
        <li><a href="register.php"><i class="fas fa-user-plus"></i> Register</a></li>
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
    <form id="registerForm" action="process_register.php" method="POST">
      <h2>Register</h2>
      <div class="progress-bar">
        <div class="progress-step active" data-step="1"></div>
        <div class="progress-step" data-step="2"></div>
        <div class="progress-step" data-step="3"></div>
      </div>
      
      <div class="step active" id="step1">
        <input type="text" name="fname" placeholder="First Name" required>
        <input type="text" name="lname" placeholder="Last Name" required>
        <input type="text" name="mname" placeholder="Middle Name">
        <input type="email" name="email" placeholder="Email" required>
        <input type="tel" name="phone" placeholder="Phone Number" required>
        <button type="button" class="btn" onclick="nextStep(2)">Next</button>
      </div>
      
      <div class="step" id="step2">
        <input type="date" name="dob" required>
        <textarea name="address" placeholder="Address" required></textarea>
        <input type="text" name="upiId" placeholder="UPI ID" required>
        <button type="button" class="btn" onclick="prevStep(1)">Previous</button>
        <button type="button" class="btn" onclick="nextStep(3)">Next</button>
      </div>
      
      <div class="step" id="step3">
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="button" class="btn" onclick="prevStep(2)">Previous</button>
        <button type="submit" class="btn">Register</button>
      </div>
    </form>
  </main>
  <footer>
    <p><i class="fas fa-copyright"></i> &copy; 2023 Maftiyo. All rights reserved.</p>
  </footer>
  <script src="js/scripts.js"></script>
</body>
</html>
