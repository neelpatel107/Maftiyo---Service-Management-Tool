<footer>
  <div class="newsletter">
    <h3>Subscribe to our Newsletter</h3>
    <p>Get the latest updates on new software releases and offers.</p>
    <form id="newsletterForm">
      <input type="email" name="email" placeholder="Enter your email" required />
      <button type="submit" class="btn">Subscribe</button>
    </form>
  </div>
  <p>
    <i class="fas fa-copyright"></i> &copy; 2023 Maftiyo. All rights reserved.
  </p>
</footer>
<script>
  // Newsletter form submission with validation and fetch
  document.getElementById('newsletterForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const emailInput = this.email;
    const email = emailInput.value.trim();
    if (!email) {
      alert('Please enter your email.');
      return;
    }
    fetch('newsletter_subscribe.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ email }),
    })
      .then((res) => res.json())
      .then((data) => {
        alert(data.message);
        if (data.success) {
          emailInput.value = '';
        }
      })
      .catch(() => {
        alert('Subscription failed. Please try again later.');
      });
  });
</script>
