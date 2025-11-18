// Multi-step form for register
function nextStep(step) {
  document.querySelectorAll('.step').forEach(s => s.classList.remove('active'));
  document.getElementById(`step${step}`).classList.add('active');
  document.querySelectorAll('.progress-step').forEach((p, i) => {
    if (i < step - 1) p.classList.add('active');
    else p.classList.remove('active');
  });
}

function prevStep(step) {
  nextStep(step);
}

// Smooth scrolling
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    e.preventDefault();
    document.querySelector(this.getAttribute('href')).scrollIntoView({
      behavior: 'smooth'
    });
  });
});

// Loading animation
window.addEventListener('load', () => {
  document.body.classList.add('loaded');
});

// Add to cart animation (for future use)
function addToCart(button) {
  button.innerHTML = 'Added!';
  button.style.background = '#28a745';
  setTimeout(() => {
    button.innerHTML = 'Buy Now';
    button.style.background = '';
  }, 2000);
}

// Lazy load images
const images = document.querySelectorAll('img');
const imageObserver = new IntersectionObserver((entries, observer) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      const img = entry.target;
      img.src = img.dataset.src;
      img.classList.remove('lazy');
      observer.unobserve(img);
    }
  });
});

images.forEach(img => {
  if (img.classList.contains('lazy')) {
    imageObserver.observe(img);
  }
});

// Notification system
function showNotification(message, type = 'success') {
  const notification = document.createElement('div');
  notification.className = `notification ${type}`;
  notification.textContent = message;
  document.body.appendChild(notification);
  setTimeout(() => {
    notification.remove();
  }, 3000);
}

// Add notification styles dynamically
const style = document.createElement('style');
style.textContent = `
  .notification {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 15px 20px;
    border-radius: 10px;
    color: white;
    font-weight: bold;
    z-index: 10000;
    animation: slideInRight 0.5s ease;
  }
  .notification.success { background: #28a745; }
  .notification.error { background: #dc3545; }
  @keyframes slideInRight {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
  }
`;
document.head.appendChild(style);

// Use software data from PHP if available, otherwise fallback to hardcoded list
const softwareSuggestions = window.softwareData ?
  window.softwareData.map(sw => sw.name) :
  [
    'Visual Studio Code',
    'Adobe Photoshop',
    'Microsoft Office',
    'Google Chrome',
    'Python',
    'Node.js',
    'Java',
    'C++',
    'Unity',
    'Blender',
    'AutoCAD',
    'Premiere Pro',
    'After Effects',
    'Illustrator',
    'InDesign',
    'Excel',
    'Word',
    'PowerPoint',
    'Slack',
    'Zoom'
  ];

// Search suggestions
document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('searchInput');
  const searchSuggestions = document.getElementById('searchSuggestions');

  if (searchInput) {
    searchInput.addEventListener('input', function() {
      const query = this.value.toLowerCase();
      searchSuggestions.innerHTML = '';
      if (query.length > 0) {
        const filtered = softwareSuggestions.filter(item => item.toLowerCase().includes(query));
        filtered.slice(0, 10).forEach(item => { // Limit to 10 suggestions
          const li = document.createElement('li');
          li.textContent = item;
          li.addEventListener('click', function() {
            searchInput.value = item;
            searchSuggestions.style.display = 'none';
            // Optionally redirect to search results or software page
            // window.location.href = `search.php?q=${encodeURIComponent(item)}`;
          });
          searchSuggestions.appendChild(li);
        });
        searchSuggestions.style.display = filtered.length > 0 ? 'block' : 'none';
      } else {
        searchSuggestions.style.display = 'none';
      }
    });

    document.addEventListener('click', function(e) {
      if (!searchInput.contains(e.target) && !searchSuggestions.contains(e.target)) {
        searchSuggestions.style.display = 'none';
      }
    });
  }
});

// Wishlist button click handler
document.querySelectorAll('.wishlist-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const id = btn.getAttribute('data-id');
    const isActive = btn.classList.contains('active');
    fetch('wishlist_action.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id, action: isActive ? 'remove' : 'add' })
    })
    .then(res => res.json())
    .then(data => {
      if(data.success) {
        btn.classList.toggle('active');
        showNotification(isActive ? 'Removed from wishlist' : 'Added to wishlist');
      } else {
        showNotification('Error updating wishlist', 'error');
      }
    });
  });
});

// Rating stars click handler
document.querySelectorAll('.rating .fa-star').forEach(star => {
  star.addEventListener('click', () => {
    const rating = star.getAttribute('data-rating');
    const id = star.getAttribute('data-id');
    fetch('rating_action.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id, rating })
    })
    .then(res => res.json())
    .then(data => {
      if(data.success) {
        // Update stars UI
        document.querySelectorAll(`.rating .fa-star[data-id="${id}"]`).forEach(s => {
          s.classList.toggle('active', s.getAttribute('data-rating') <= rating);
        });
        showNotification('Rating saved');
      } else {
        showNotification('Error saving rating', 'error');
      }
    });
  });
});

// Review form handling
document.addEventListener('DOMContentLoaded', () => {
  const reviewForm = document.getElementById('reviewForm');
  if (reviewForm) {
    const stars = reviewForm.querySelectorAll('.stars .fa-star');
    const ratingValue = document.getElementById('ratingValue');

    stars.forEach(star => {
      star.addEventListener('click', () => {
        const rating = star.getAttribute('data-rating');
        ratingValue.value = rating;
        stars.forEach(s => s.classList.toggle('active', s.getAttribute('data-rating') <= rating));
      });
    });

    reviewForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const formData = new FormData(reviewForm);
      const data = {
        software_id: formData.get('software_id'),
        comment: formData.get('comment'),
        rating: formData.get('rating')
      };

      fetch('review_action.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          showNotification('Review submitted successfully');
          reviewForm.reset();
          stars.forEach(s => s.classList.remove('active'));
          // Optionally reload page to show new review
          setTimeout(() => location.reload(), 1000);
        } else {
          showNotification(data.message || 'Error submitting review', 'error');
        }
      });
    });
  }
});

// Compare functionality
document.addEventListener('DOMContentLoaded', () => {
  const compareBar = document.getElementById('compareBar');
  const compareCount = document.getElementById('compareCount');

  function updateCompareBar() {
    const checked = document.querySelectorAll('.compare-select:checked');
    const count = checked.length;
    if (count > 0) {
      compareBar.style.display = 'block';
      compareCount.textContent = count;
    } else {
      compareBar.style.display = 'none';
    }
  }

  document.querySelectorAll('.compare-select').forEach(checkbox => {
    checkbox.addEventListener('change', () => {
      const id = checkbox.getAttribute('data-id');
      const action = checkbox.checked ? 'add' : 'remove';
      fetch('compare_action.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id, action })
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          updateCompareBar();
        }
      });
    });
  });

  updateCompareBar(); // Initial check
});

// Newsletter subscription
document.addEventListener('DOMContentLoaded', () => {
  const newsletterForm = document.getElementById('newsletterForm');
  if (newsletterForm) {
    newsletterForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const formData = new FormData(newsletterForm);
      const data = { email: formData.get('email') };

      fetch('newsletter_subscribe.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          showNotification('Subscribed successfully!');
          newsletterForm.reset();
        } else {
          showNotification(data.message || 'Subscription failed', 'error');
        }
      });
    });
  }
});

// Dark mode toggle
document.addEventListener('DOMContentLoaded', () => {
  const themeToggleBtn = document.getElementById('themeToggle');
  if (themeToggleBtn) {
    themeToggleBtn.addEventListener('click', () => {
      document.body.classList.toggle('dark-mode');
      // Save preference to localStorage
      if (document.body.classList.contains('dark-mode')) {
        localStorage.setItem('theme', 'dark');
        themeToggleBtn.innerHTML = '<i class="fas fa-sun"></i>';
      } else {
        localStorage.setItem('theme', 'light');
        themeToggleBtn.innerHTML = '<i class="fas fa-moon"></i>';
      }
    });

    // On page load, apply saved theme preference
    if (localStorage.getItem('theme') === 'dark') {
      document.body.classList.add('dark-mode');
      themeToggleBtn.innerHTML = '<i class="fas fa-sun"></i>';
    } else {
      themeToggleBtn.innerHTML = '<i class="fas fa-moon"></i>';
    }
  }
});

// Filter functionality on categories.php
document.addEventListener('DOMContentLoaded', () => {
  const applyFiltersBtn = document.getElementById('applyFilters');
  const clearFiltersBtn = document.getElementById('clearFilters');
  const minPriceInput = document.getElementById('minPrice');
  const maxPriceInput = document.getElementById('maxPrice');
  const minRatingInput = document.getElementById('minRating');
  const softwareContainer = document.getElementById('softwareContainer');

  if (applyFiltersBtn && softwareContainer) {
    applyFiltersBtn.addEventListener('click', () => {
      const minPrice = parseFloat(minPriceInput.value) || 0;
      const maxPrice = parseFloat(maxPriceInput.value) || Infinity;
      const minRating = parseFloat(minRatingInput.value) || 0;

      const cards = softwareContainer.querySelectorAll('.software-card');
      if (!cards || cards.length === 0) return; // Prevent error if no cards found
      cards.forEach(card => {
        const price = parseFloat(card.getAttribute('data-price'));
        const rating = parseFloat(card.getAttribute('data-rating'));

        if (price >= minPrice && price <= maxPrice && rating >= minRating) {
          card.style.display = 'block';
        } else {
          card.style.display = 'none';
        }
      });
    });
  }

  if (clearFiltersBtn && softwareContainer) {
    clearFiltersBtn.addEventListener('click', () => {
      minPriceInput.value = '';
      maxPriceInput.value = '';
      minRatingInput.value = '';

      const cards = softwareContainer.querySelectorAll('.software-card');
      cards.forEach(card => {
        card.style.display = 'block';
      });
    });
  }

  // Header search on categories.php
  const headerSearchBar = document.querySelector('.header-search .search-bar');
  const headerSearchBtn = document.querySelector('.header-search .search-btn');
  if (headerSearchBar && headerSearchBtn && softwareContainer) {
    headerSearchBtn.addEventListener('click', function() {
      const query = headerSearchBar.value.toLowerCase();
      const cards = softwareContainer.querySelectorAll('.software-card');
      cards.forEach(card => {
        const name = card.querySelector('h3').textContent.toLowerCase();
        card.style.display = name.includes(query) ? 'block' : 'none';
      });
    });
  }
});

// Filter panel toggle (Amazon/Flipkart style sidebar)
document.addEventListener('DOMContentLoaded', () => {
  const filterBtn = document.getElementById('filterBtn');
  const filterPanel = document.getElementById('filterPanel');
  const filterOverlay = document.getElementById('filterOverlay');
  const closeFilter = document.getElementById('closeFilter');

  if (filterBtn && filterPanel && filterOverlay) {
    // Open filter panel
    filterBtn.addEventListener('click', () => {
      filterPanel.style.left = '0';
      filterOverlay.style.display = 'block';
      document.body.style.overflow = 'hidden'; // Prevent body scroll
    });

    // Close on overlay click
    filterOverlay.addEventListener('click', () => {
      filterPanel.style.left = '-300px';
      filterOverlay.style.display = 'none';
      document.body.style.overflow = '';
    });

    // Close on close button
    if (closeFilter) {
      closeFilter.addEventListener('click', () => {
        filterPanel.style.left = '-300px';
        filterOverlay.style.display = 'none';
        document.body.style.overflow = '';
      });
    }

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && filterPanel.style.left === '0') {
        filterPanel.style.left = '-300px';
        filterOverlay.style.display = 'none';
        document.body.style.overflow = '';
      }
    });
  }
});
