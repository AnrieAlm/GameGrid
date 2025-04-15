
<?php
require 'init.php'; // Start the session
require 'db.php'; // Database connection
?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reviews - Game Grid</title>
  <link href="CSS/style2.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <!-- Include the header -->
  <?php include 'header.php'; ?>

  <main>
    <section id="reviews">
      <span class="reviews-header">
        <h2>Game Reviews</h2>
        <span class="view-toggle">
          <button id="gridView" class="active">Grid</button>
          <button id="listView">List</button>
        </span>
      </span>
      <span class="reviews-container grid-view" id="reviewsContainer">
        <?php if ($games): ?>
          <?php foreach ($games as $game): ?>
            <div class="review-card" data-game-id="<?php echo htmlspecialchars($game['id']); ?>">
              <div class="card-header">
                <img src="<?php echo htmlspecialchars($game['image_url']); ?>" alt="<?php echo htmlspecialchars($game['title']); ?>">
                <button class="bookmark-btn" onclick="toggleBookmark(<?php echo $game['id']; ?>)">
                  <?php
                  // Check if the game is bookmarked by the user
      
                  $isBookmarked = false; // Default value
                  if (isset($_SESSION['user_id'])) {
                      try {
                          $stmt = $pdo->prepare("SELECT id FROM bookmarks WHERE user_id = :user_id AND game_id = :game_id");
                          $stmt->execute(['user_id' => $_SESSION['user_id'], 'game_id' => $game['id']]);
                          $isBookmarked = $stmt->fetch() !== false; // Check if a row was found
                      } catch (PDOException $e) {
                          error_log("Error checking bookmark: " . $e->getMessage());
                      }
                  }
                  echo $isBookmarked ? '★' : '☆';
                  ?>
                </button>
              </div>
              <div class="review-content">
                <h3><?php echo htmlspecialchars($game['title']); ?></h3>
                <span class="star-rating">⭐ <?php echo htmlspecialchars($game['rating']); ?>/5</span>
                <p class="review-description"><?php echo htmlspecialchars($game['description']); ?></p>
                <a href="inner-review.php?id=<?php echo $game['id']; ?>" class="read-more">Read More</a>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>No reviews available yet.</p>
        <?php endif; ?>
      </span>
    </section>
  </main>

  <span id="gameModal" class="modal">
    <span class="modal-content">
      <span class="close-modal">&times;</span>
      <span id="gameDetails" class="game-details"></span>
    </span>
  </span>

  <!-- Include the footer -->
  <?php include 'footer.php'; ?>

  <script src="script.js"></script>
</body>

</html>