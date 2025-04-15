<?php
require 'init.php'; // Start the session
require 'db.php'; // Database connection
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Game Review - Game Grid</title>
  <link href="CSS/style2.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
  /* Bookmark Button Styling */
.review-navigation {
  position: relative;
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
}

.bookmark {
  background: rgba(54, 54, 54, 0.9);
  border: 1px solid #00ffc8;
  color: #00ffc8;
  font-size: 1.5rem;
  cursor: pointer;
  padding: 7px;
  border-radius: 50%;
  width: 35px;
  height: 35px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
  margin-left: 1rem;
}

.bookmark:hover {
  background: #00ffc8;
  color: #1e1e1e;
  box-shadow: 0 0 10px rgba(0, 255, 200, 0.5);
  transform: scale(1.1);
}

.bookmark.bookmarked .bookmark-icon {
  color: #00ffc8;
  content: "★";
}

/* Mobile Responsiveness */
@media (max-width: 600px) {
  .bookmark {
    width: 30px;
    height: 30px;
    font-size: 1.2rem;
  }
  
  .review-navigation {
    padding: 0 1rem;
  }
}
</style>
</head>

<body>
  <?php
  // Include the header
  include 'header.php';
  ?>

  <main class="review-page">
    <nav class="review-navigation">
      <a href="reviews.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to reviews</a>
      <button class="bookmark" id="bookmarkBtn" aria-label="Bookmark this review">
        <span class="bookmark-icon">☆</span>
      </button>
    </nav>

    <article id="reviewDetail" class="review-detail">
      <!-- Dynamic content can be loaded here using PHP -->
      <?php
      // Example: Fetch review details from the database
      require 'db.php'; // Database connection

      // Assume we have a review ID passed via GET
      if (isset($_GET['id'])) {
          $review_id = $_GET['id'];

          // Fetch review details from the database
          $stmt = $pdo->prepare("SELECT * FROM reviews WHERE id = :review_id");
          $stmt->execute(['review_id' => $review_id]);
          $review = $stmt->fetch();

          if ($review) {
              echo '<h1>' . htmlspecialchars($review['title']) . '</h1>';
              echo '<p>' . htmlspecialchars($review['content']) . '</p>';
          } else {
              echo '<p>Review not found.</p>';
          }
      } else {
          echo '<p>No review selected.</p>';
      }
      ?>
    </article>

    <section class="video-section">
      <h2>Official Trailer</h2>
      <figure class="video-container" id="videoContainer">
        <!-- Example: Embed a video dynamically -->
        <?php
        if (isset($review) && !empty($review['video_url'])) {
            echo '<iframe width="560" height="315" src="' . htmlspecialchars($review['video_url']) . '" frameborder="0" allowfullscreen></iframe>';
        } else {
            echo '<p>No video available.</p>';
        }
        ?>
      </figure>
    </section>

    <section class="comments-section">
      <h2>Comments</h2>
      <form id="commentForm" class="comment-form">
        <label for="commentInput" class="user-avatar">
          <img src="https://placehold.co/50" alt="User Profile Picture">
        </label>
        <textarea id="commentInput" placeholder="Add a comment..." aria-label="Write a comment"></textarea>
        <button type="submit" id="submitComment" class="btn">Comment</button>
      </form>
      <section id="commentsContainer" class="comments-container">
        <!-- Example: Load comments dynamically -->
        <?php
        if (isset($review)) {
            // Fetch comments for this review from the database
            $stmt = $pdo->prepare("SELECT * FROM comments WHERE review_id = :review_id ORDER BY created_at DESC");
            $stmt->execute(['review_id' => $review_id]);
            $comments = $stmt->fetchAll();

            if (!empty($comments)) {
                foreach ($comments as $comment) {
                    echo '<div class="comment">';
                    echo '<img src="https://placehold.co/50" alt="User Avatar">';
                    echo '<p><strong>' . htmlspecialchars($comment['username']) . '</strong>: ' . htmlspecialchars($comment['content']) . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No comments yet. Be the first to comment!</p>';
            }
        }
        ?>
      </section>
    </section>
  </main>

  <?php
  // Include the footer
  include 'footer.php';
  ?>
  <script src="script.js"></script>
  <script src="review.js"></script>
</body>

</html>