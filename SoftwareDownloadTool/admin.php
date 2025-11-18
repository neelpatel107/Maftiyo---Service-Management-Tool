<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: admin_login.php');
    exit;
}
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Maftiyo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .admin-container { max-width: 1200px; margin: 0 auto; padding: 2rem; }
        .admin-tabs { display: flex; margin-bottom: 2rem; }
        .admin-tab { padding: 1rem; background: #f8f9fa; border: 1px solid #ddd; cursor: pointer; flex: 1; text-align: center; }
        .admin-tab.active { background: #667eea; color: white; }
        .admin-content { display: none; }
        .admin-content.active { display: block; }
        .review-item { border: 1px solid #ddd; padding: 1rem; margin-bottom: 1rem; border-radius: 10px; }
        .review-item h4 { margin: 0; }
        .review-item p { margin: 0.5rem 0; }
        .review-actions { margin-top: 1rem; }
        .btn-approve { background: #28a745; color: white; padding: 0.5rem 1rem; border: none; border-radius: 5px; cursor: pointer; }
        .btn-reject { background: #dc3545; color: white; padding: 0.5rem 1rem; border: none; border-radius: 5px; cursor: pointer; margin-left: 0.5rem; }
        .subscriber-item { display: flex; justify-content: space-between; align-items: center; border: 1px solid #ddd; padding: 1rem; margin-bottom: 1rem; border-radius: 10px; }
        .btn-remove { background: #dc3545; color: white; padding: 0.5rem 1rem; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <header class="header-container">
        <div class="logo">
            <i class="fas fa-download" style="font-size: 2rem; color: #667eea; margin-right: 0.5rem;"></i>
            <h1>Maftiyo - Admin Panel</h1>
        </div>
        <nav class="main-nav">
            <ul>
                <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>
    </header>
    <main class="admin-container">
        <h2><i class="fas fa-cogs"></i> Admin Panel</h2>
        <div class="admin-tabs">
            <div class="admin-tab active" onclick="showTab('reviews')">Review Approval</div>
            <div class="admin-tab" onclick="showTab('newsletter')">Newsletter Management</div>
        </div>
        <div id="reviews" class="admin-content active">
            <h3>Pending Reviews</h3>
            <div id="reviews-list">
                <?php
                $reviews = json_decode(file_get_contents('reviews.json'), true) ?? [];
                $pending_reviews = array_filter($reviews, fn($r) => !$r['approved']);
                if (empty($pending_reviews)) {
                    echo '<p>No pending reviews.</p>';
                } else {
                    foreach ($pending_reviews as $index => $review) {
                        $sw = array_filter($software, fn($s) => $s['id'] == $review['software_id']);
                        $sw = reset($sw);
                        echo '<div class="review-item" data-index="' . $index . '">';
                        echo '<h4>' . htmlspecialchars($sw['name']) . '</h4>';
                        echo '<p><strong>User:</strong> ' . htmlspecialchars($review['user']) . '</p>';
                        echo '<p><strong>Rating:</strong> ' . $review['rating'] . '/5</p>';
                        echo '<p><strong>Comment:</strong> ' . htmlspecialchars($review['comment']) . '</p>';
                        echo '<p><strong>Date:</strong> ' . $review['date'] . '</p>';
                        echo '<div class="review-actions">';
                        echo '<button class="btn-approve" onclick="approveReview(' . $index . ')">Approve</button>';
                        echo '<button class="btn-reject" onclick="rejectReview(' . $index . ')">Reject</button>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
        <div id="newsletter" class="admin-content">
            <h3>Newsletter Subscribers</h3>
            <div id="subscribers-list">
                <?php
                $subscribers = json_decode(file_get_contents('newsletter.json'), true) ?? [];
                if (empty($subscribers)) {
                    echo '<p>No subscribers.</p>';
                } else {
                    foreach ($subscribers as $index => $email) {
                        echo '<div class="subscriber-item" data-index="' . $index . '">';
                        echo '<span>' . htmlspecialchars($email) . '</span>';
                        echo '<button class="btn-remove" onclick="removeSubscriber(' . $index . ')">Remove</button>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </main>
    <footer>
        <p><i class="fas fa-copyright"></i> &copy; 2023 Maftiyo. All rights reserved.</p>
    </footer>
    <script src="js/scripts.js"></script>
    <script>
        function showTab(tab) {
            document.querySelectorAll('.admin-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.admin-content').forEach(c => c.classList.remove('active'));
            document.querySelector(`[onclick="showTab('${tab}')"]`).classList.add('active');
            document.getElementById(tab).classList.add('active');
        }

        function approveReview(index) {
            fetch('admin_review_action.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'approve', index: index })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        }

        function rejectReview(index) {
            fetch('admin_review_action.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'reject', index: index })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        }

        function removeSubscriber(index) {
            fetch('admin_newsletter_action.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'remove', index: index })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        }
    </script>
</body>
</html>
