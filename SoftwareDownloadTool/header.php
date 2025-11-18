<?php if (session_status() == PHP_SESSION_NONE) { session_start(); } ?>
<header class="header-container">
  <div class="logo">
    <i class="fas fa-download" style="font-size: 2rem; color: #667eea; margin-right: 0.5rem;"></i>
    <h1>Maftiyo</h1>
  </div>
  <nav class="main-nav">
    <ul>
      <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
      <li><a href="categories.php"><i class="fas fa-th-large"></i> Categories</a></li>
      <?php if (isset($_SESSION['user'])) : ?>
      <li><a href="account.php"><i class="fas fa-user"></i> Profile</a></li>
      <li><a href="account.php"><i class="fas fa-history"></i> Download History</a></li>
      <li><button id="filterBtn"><i class="fas fa-filter"></i> Filter</button></li>
      <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
      <?php else : ?>
      <li><a href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
      <li><a href="register.php"><i class="fas fa-user-plus"></i> Register</a></li>
      <?php endif; ?>
    </ul>
  </nav>
  <div id="filterOverlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999;"></div>
  <div id="filterPanel" style="position:fixed; left:-300px; top:0; height:100vh; width:300px; background:white; border-right:1px solid #ccc; padding:20px; z-index:1000; transition:left 0.3s ease; overflow-y:auto; box-shadow:2px 0 10px rgba(0,0,0,0.1);">
    <button id="closeFilter" style="float:right; background:none; border:none; font-size:24px; cursor:pointer; color:#666;">&times;</button>
    <h3 style="margin-top:0;">Filters</h3>
    <form action="software.php" method="get">
      <div style="margin-bottom:15px;">
        <label style="display:block; margin-bottom:5px; font-weight:bold;">Category:</label>
        <div style="max-height:200px; overflow-y:auto;">
          <label style="display:block; margin-bottom:5px;"><input type="checkbox" name="category[]" value="coding"> Coding</label>
          <label style="display:block; margin-bottom:5px;"><input type="checkbox" name="category[]" value="video-editing"> Video Editing</label>
          <label style="display:block; margin-bottom:5px;"><input type="checkbox" name="category[]" value="graphic-design"> Graphic Design</label>
          <label style="display:block; margin-bottom:5px;"><input type="checkbox" name="category[]" value="game-development"> Game Development</label>
          <label style="display:block; margin-bottom:5px;"><input type="checkbox" name="category[]" value="3d-modeling"> 3D Modeling</label>
          <label style="display:block; margin-bottom:5px;"><input type="checkbox" name="category[]" value="web-development"> Web Development</label>
          <label style="display:block; margin-bottom:5px;"><input type="checkbox" name="category[]" value="data-analysis"> Data Analysis</label>
          <label style="display:block; margin-bottom:5px;"><input type="checkbox" name="category[]" value="devops"> DevOps</label>
          <label style="display:block; margin-bottom:5px;"><input type="checkbox" name="category[]" value="ci-cd"> CI/CD</label>
          <label style="display:block; margin-bottom:5px;"><input type="checkbox" name="category[]" value="ui-ux-design"> UI/UX Design</label>
          <label style="display:block; margin-bottom:5px;"><input type="checkbox" name="category[]" value="browser"> Browser</label>
          <label style="display:block; margin-bottom:5px;"><input type="checkbox" name="category[]" value="communication"> Communication</label>
          <label style="display:block; margin-bottom:5px;"><input type="checkbox" name="category[]" value="social-media"> Social Media</label>
        </div>
      </div>
      <div style="margin-bottom:15px;">
        <label style="display:block; margin-bottom:5px; font-weight:bold;">Min Price:</label>
        <input type="number" name="minPrice" step="0.01" style="width:100%; padding:5px; margin-bottom:10px;">
      </div>
      <div style="margin-bottom:15px;">
        <label style="display:block; margin-bottom:5px; font-weight:bold;">Max Price:</label>
        <input type="number" name="maxPrice" step="0.01" style="width:100%; padding:5px; margin-bottom:10px;">
      </div>
      <div style="margin-bottom:15px;">
        <label style="display:block; margin-bottom:5px; font-weight:bold;">Min Rating:</label>
        <select name="rating" style="width:100%; padding:5px;">
          <option value="">Any</option>
          <option value="1">1+</option>
          <option value="2">2+</option>
          <option value="3">3+</option>
          <option value="4">4+</option>
          <option value="5">5</option>
        </select>
      </div>
      <button type="submit" style="width:100%; padding:10px; background:#007bff; color:white; border:none; border-radius:5px; cursor:pointer;">Apply Filters</button>
    </form>
  </div>
  <div class="header-search">
    <input type="text" placeholder="Search software..." class="search-bar" id="searchInput" />
    <button class="search-btn"><i class="fas fa-search"></i></button>
    <ul class="search-suggestions" id="searchSuggestions"></ul>
  </div>
  <div class="mobile-menu-toggle">
    <i class="fas fa-bars"></i>
  </div>
  <div class="theme-toggle">
    <button id="themeToggle" class="theme-btn"><i class="fas fa-moon"></i></button>
  </div>
</header>
