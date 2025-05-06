<?php
/* This is the reviews php file for the reviews page that displays the reviews from the database */

// Start session and connect to database
require 'init.php'; // Starts session
require 'db.php';  // Connects to the database

// Fetch all games from the database
try {
    $stmt = $pdo->query("SELECT * FROM games ORDER BY id DESC");
    $games = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error fetching games: " . $e->getMessage());
    $games = []; // Fallback to empty array if query fails
}

// Optional: Preload user bookmarks for performance
$bookmarks = [];
if (isset($_SESSION['user_id'])) {
    try {
        $stmt = $pdo->prepare("SELECT game_id FROM bookmarks WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $bookmarks[$row['game_id']] = true;
        }
    } catch (PDOException $e) {
        error_log("Error fetching bookmarks: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reviews - Game Grid</title>
  <link href="style2.css" rel="stylesheet" type="text/css" />
</head>

<style>
  /* Basic styling for review cards */
  .review-card {
    display: grid;
    grid-template-columns: 1fr;
    grid-template-areas:
      "image"
      "header"
      "stars"
      "desc"
      "button";
    border: 1px solid #ccc;
    border-radius: 12px;
    overflow: hidden;
    background-color: #fff;
    padding: 1rem;
    max-width: 300px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    gap: 0.5rem;
  }

  .card-image {
    grid-area: image;
    width: 100%;
    height: auto;
    border-radius: 8px;
    object-fit: cover;
  }

  .card-header {
    grid-area: header;
    display: grid;
    grid-template-columns: 4fr 1fr;
    align-items: center;
    gap: 0.5rem;
  }

  .game-title {
    font-size: 1.1rem;
    margin: 0;
    text-align: left;
  }

  .bookmark-btn {
    background-color: #eee;
    border: none;
    border-radius: 50%;
    font-size: 1.2rem;
    padding: 0.4rem 0.6rem;
    cursor: pointer;
    transition: background-color 0.3s;
  }

  .bookmark-btn:hover {
    background-color: #ddd;
  }

  .star-rating {
    grid-area: stars;
    font-size: 0.9rem;
    color: #f39c12;
  }

  .review-description {
    grid-area: desc;
    font-size: 0.95rem;
    color: #333;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    text-overflow: ellipsis;
  }

  .read-more {
    grid-area: button;
    font-size: 0.9rem;
    color: #007bff;
    text-decoration: none;
    margin-top: 0.5rem;
  }

  .read-more:hover {
    text-decoration: underline;
  }

  .bookmark-btn, .review-card span[title] {
  font-size: 1.2rem;
  cursor: pointer;
  transition: color 0.3s;
}

.review-card span[title]:hover {
  color: #aaa;
}

.bookmark-btn {
  background-color: #eee;
  border: none;
  border-radius: 50%;
  font-size: 1.2rem;
  padding: 0.4rem 0.6rem;
  cursor: pointer;
  transition: all 0.3s ease; /* Smooth for both color and background */
  color: #999; /* Default color */
}

.bookmark-btn:hover {
  background-color: #ddd;
  color: #f39c12; /* Highlight color on hover */
}

.bookmark-btn.active {
  color: #f39c12; /* Bookmarked color */
}

.review-card span[title] {
  font-size: 1.2rem;
  color: #ccc;
  cursor: not-allowed;
}
</style>

<body>
  <!-- Include the header -->
  <?php include 'header.php'; ?>

  <main>
    <section id="reviews">
      <!-- Section Header with Title and View Toggle -->
      <span class="reviews-header">
        <h2>Game Reviews</h2>
        <span class="view-toggle">
          <button id="gridView" class="active">Grid</button>
          <button id="listView">List</button>
        </span>
      </span>

      <!-- Container for Review Cards -->
      <span class="reviews-container grid-view" id="reviewsContainer">

        <?php if ($games): ?>
          <?php foreach ($games as $game): 
              // Determine if current game is bookmarked by the logged-in user
              $isBookmarked = isset($bookmarks[$game['id']]);
          ?>
            <!-- Single Review Card -->
            <div class="review-card" data-game-id="<?= htmlspecialchars($game['id']) ?>">
              
              <!-- Game Image -->
              <img src="<?= htmlspecialchars($game['image_url']) ?>" alt="<?= htmlspecialchars($game['title']) ?>" class="card-image">

              <!-- Title and Bookmark Button -->
              <div class="card-header">
                <h3 class="game-title"><?= htmlspecialchars($game['title']) ?></h3>
                <?php if (isset($_SESSION['user_id'])): ?>
  <button class="bookmark-btn" onclick="toggleBookmark(<?= $game['id'] ?>)">
    <?= $isBookmarked ? '★' : '☆' ?>
  </button>
<?php else: ?>
  <span title="Login to bookmark">☆</span>
<?php endif; ?>
              </div>

              <!-- Rating -->
              <span class="star-rating">⭐ <?= htmlspecialchars($game['rating']) ?>/5</span>

              <!-- Description (Truncated) -->
              <p class="review-description"><?= htmlspecialchars($game['description']) ?></p>

              <!-- Read More Link -->
              <a href="inner-review.php?id=<?= $game['id'] ?>" class="read-more">Read More →</a>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>No reviews available yet.</p>
        <?php endif; ?>

      </span>
    </section>
  </main>

  <!-- Include the footer -->
  <?php include 'footer.php'; ?>

  <!-- Modal for Detailed Game Info -->
  <span id="gameModal" class="modal">
    <span class="modal-content">
      <span class="close-modal">&times;</span>
      <span id="gameDetails" class="game-details"></span>
    </span>
  </span>

  <!-- JavaScript -->
  <script src="script.js"></script> <!-- Original game list logic -->
<script src="bookmarks.js"></script> <!-- Shared bookmark logic -->

</body>
</html>