<?php

/* home page file that displays the different reviews, search, menu bars, filter  
Author:- Anriel, Neil and Victor
*/

require_once 'db.php';

// Fetch all games for the slider
try {
    $stmt = $pdo->query("SELECT id, title, platform, rating, image_url FROM games");
    $games = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database query failed: " . $e->getMessage());
}
?>
<script>
  const userId = <?php echo isset($_SESSION['user_id']) ? json_encode($_SESSION['user_id']) : 'null'; ?>;
</script>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Game Grid</title>
  <link href="style2.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    /* Hero Section */
    #hero-section {
      position: relative;
      width: 100vw;
      height: 100vh;
      max-height: 800px;
      overflow: hidden;
      margin-bottom: 2rem;
    }
    .hero-slider {
      width: 100%;
      height: 100%;
      position: relative;
    }
    .hero-background {
      position: absolute;
      width: 100%;
      height: 100%;
      background: url('images/hero.jpg') center/cover no-repeat;
      filter: brightness(0.4);
      z-index: 1;
      transition: background-image 0.5s ease-in-out;
    }
    .hero-content {
      position: absolute;
      bottom: 20%;
      left: 0;
      right: 0;
      padding: 2rem;
      text-align: center;
      color: white;
      z-index: 2;
      display: block;
    }
    .hero-content h2 {
      font-size: 3.5rem;
      margin: 0 0 0.5rem 0;
      line-height: 1.1;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    .hero-meta {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 1rem;
      margin-bottom: 0.5rem;
    }
    .platform-tag, .rating {
      font-size: 1.2rem;
      font-weight: bold;
    }
    .hero-content p {
      font-size: 1.4rem;
      margin: 0 0 2rem 0;
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
      line-height: 1.4;
    }
    .read-btn {
      display: inline-block;
      padding: 0.5rem 1rem;
      background: #00ffc8;
      color: #1e1e1e;
      text-decoration: none;
      border-radius: 0.5rem;
      font-weight: bold;
      font-size: 1.1rem;
      transition: all 0.3s ease;
    }
    .read-btn:hover {
      background: #00e6b8;
      transform: translateY(-2px);
    }
    /* Slider Controls */
    .slider-controls {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(0,0,0,0.5);
      color: white;
      border: none;
      padding: 1rem;
      border-radius: 50%;
      cursor: pointer;
      z-index: 3;
    }
    .slider-controls.left { left: 2rem; }
    .slider-controls.right { right: 2rem; }
    .slider-dots {
      position: absolute;
      bottom: 10%;
      left: 0;
      right: 0;
      display: flex;
      justify-content: center;
      gap: 1rem;
      z-index: 3;
    }
    .dot {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background: rgba(255,255,255,0.5);
      border: none;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    .dot.active {
      background: white;
      transform: scale(1.2);
    }
    /* Responsive Adjustments */
    @media (max-width: 768px) {
      #hero-section {
        height: 70vh;
      }
      .hero-content {
        padding: 1rem;
        bottom: 15%;
      }
      .hero-content h2 {
        font-size: 2.5rem;
      }
      .hero-content p {
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
      }
      .platform-tag, .rating {
        font-size: 1rem;
      }
      .slider-controls {
        padding: 0.5rem;
      }
      .read-btn {
        padding: 0.6rem 1rem;
        font-size: 0.8rem;
      }
    }

    .bookmark-btn {
  font-size: 1.5rem;
  background: none;
  border: none;
  cursor: pointer;
}
.bookmark-btn:hover {
  color: gold;
}
   /* General Styles for Game Cards */
/* Game Card Styling */
.game-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background-color: #222; /* Dark background for better contrast */
  border: 1px solid #444;
  border-radius: 8px;
  padding: 16px;
  margin: 16px;
  transition: transform 0.3s ease;
  max-width: 300px; /* Fixed maximum width */
  height: 400px; /* Fixed height */
}

.game-card:hover {
  transform: scale(1.02);
}

/* Image Styling */
.game-card img {
  width: 100%; /* Ensure the image spans the full width of the card */
  height: 200px; /* Fixed height for the image */
  object-fit: cover; /* Crop the image to fit the container */
  border-radius: 8px; /* Rounded corners for the image */
  margin-bottom: 16px; /* Space between image and text */
}

/* Text Styling */
.game-card h3 {
  font-size: 1.5rem;
  color: white;
  margin: 0;
}

.game-card p {
  font-size: 1rem;
  color: #ccc;
  margin: 8px 0;
}
  

 
  </style>
</head>
<body>
   <!-- Header Section -->
 <?php include 'header.php'; ?>

  <main>
    <!-- Hero Slider Section -->
    <section id="hero-section">
      <article class="hero-slider">
        <!-- Background Image -->
        <div class="hero-background"></div>
        <div class="hero-content">
          <h2 id="hero-title">Loading...</h2>
          <div class="hero-meta">
            <span class="platform-tag" id="hero-platform">Platform: Loading...</span>
            <span class="rating" id="hero-rating">Rating: Loading...</span>
          </div>
        </div>

        <!-- Slider Controls -->
        <button class="slider-controls left" aria-label="Previous slide">
          <i class="fas fa-chevron-left"></i>
        </button>
        <button class="slider-controls right" aria-label="Next slide">
          <i class="fas fa-chevron-right"></i>
        </button>

        <!-- Slider Dots -->
        <nav class="slider-dots" aria-label="Slider navigation" id="sliderDots"></nav>
      </article>
    </section>

    <!-- Platform Browse Section -->
    <section class="platform-section">


<nav class="platform-grid">

    <button class="platform-btn " data-platform="">All</button>

    <button class="platform-btn" data-platform="PS5">PS5</button>

    <button class="platform-btn" data-platform="Nintendo">Nintendo</button>

    <button class="platform-btn" data-platform="Xbox">Xbox</button>

    <button class="platform-btn" data-platform="PS4">PS4</button>

    <button class="platform-btn" data-platform="PC">PC</button>

</nav>

</section>
    <section class="browse-games-section">
            <div id="allGamesContainer" class="games-container grid-view">
                <?php foreach ($games as $game): ?>
                  <div class="game-card" data-game-id="<?php echo htmlspecialchars($game['id']); ?>" data-platform="<?php echo htmlspecialchars($game['platform'] ?? ''); ?>">
  <img src="<?php echo htmlspecialchars($game['image_url']); ?>" alt="<?php echo htmlspecialchars($game['title']); ?>">
  <h3><?php echo htmlspecialchars($game['title']); ?></h3>
  <p>Platform: <?php echo htmlspecialchars($game['platform'] ?? 'N/A'); ?> | Rating: <?php echo htmlspecialchars($game['rating']); ?>/10</p>
</div>
                    <!-- <div class="game-card" data-game-id="<?php //echo htmlspecialchars($game['id']); ?>" data-platform="// echo htmlspecialchars($game['platform'] ?? ''); ?>">
                        <img src="<?php //echo htmlspecialchars($game['image_url']); ?>" alt="<?php //echo htmlspecialchars($game['title']); ?>">
                        <h3><?php //echo htmlspecialchars($game['title']); ?></h3>
                        <p>Platform: <?php //echo htmlspecialchars($game['platform'] ?? 'N/A'); ?> | Rating: <?php //echo htmlspecialchars($game['rating']); ?>/10</p>
                    </div> -->
                <?php endforeach; ?>
            </div>
        </section>

    <!-- Trending Reviews -->
    <div class="section-header">
      <h2>Trending Reviews</h2>
      <div class="view-toggle">
        <button id="gridView" class="active">Grid</button>
        <button id="listView">List</button>
      </div>
    </div>
    <div id="reviewsContainer" class="reviews-container grid-view">
      <?php
      try {
        // Query to fetch trending games
        $stmt = $pdo->query("SELECT * FROM games ORDER BY rating DESC LIMIT 6");
        $gamesTrending = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($gamesTrending) > 0) {
          foreach ($gamesTrending as $game) {
            ?>
            <div class="review-card" data-game-id="<?= htmlspecialchars($game['id']) ?>">
          <div class="review-hero">
            <img src="<?= htmlspecialchars($game['image_url']) ?>" alt="<?= htmlspecialchars($game['title']) ?>">
          </div>
          <div class="review-content">
            <h3><?= htmlspecialchars($game['title']) ?></h3>
            <div class="meta-info">
              <span class="platform-label"><?= htmlspecialchars($game['platform'] ?? 'N/A') ?></span>
              <span class="rating"><i class="fas fa-star"></i> <?= htmlspecialchars($game['rating']) ?>/10</span>
            </div>
          
            <button class="bookmark-btn" data-game-id="<?= $game['id'] ?>">☆</button>
            <a href="inner-review.php?id=<?= $game['id'] ?>" class="read-more">Read More →</a>
          </div>
            </div>
            <?php
      }
    } else {
      echo '<p>No trending reviews available at the moment.</p>';
    }
  } catch (PDOException $e) {
    echo '<p>Error loading trending reviews: ' . htmlspecialchars($e->getMessage()) . '</p>';
  }
  ?>
</div>
  </main>

  <!-- Footer -->
  <?php include 'footer.php'; ?>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
  // Convert PHP games array to JavaScript
  const games = <?php echo json_encode($games); ?>;
  if (games.length === 0) {
    console.error("No games available for the slider.");
    return;
  }

  let currentIndex = 0;

  // DOM Elements
  const heroBackground = document.querySelector('.hero-background');
  const heroTitle = document.getElementById('hero-title');
  const heroPlatform = document.getElementById('hero-platform');
  const heroRating = document.getElementById('hero-rating');
  const sliderDots = document.getElementById('sliderDots');

  // Function to update the hero section
  function updateHero(index) {
    const game = games[index];
    heroBackground.style.backgroundImage = `url('${game.image_url}')`;
    heroTitle.textContent = game.title;
    heroPlatform.textContent = `Platform: ${game.platform}`;
    heroRating.textContent = `Rating: ${game.rating}/10`;

    // Update active dot
    const dots = sliderDots.querySelectorAll('.dot');
    dots.forEach((dot, i) => dot.classList.toggle('active', i === index));
  }

  // Initialize slider dots
  games.forEach((_, index) => {
    const dot = document.createElement('button');
    dot.className = 'dot';
    dot.setAttribute('aria-label', `Slide ${index + 1}`);
    dot.addEventListener('click', () => {
      currentIndex = index;
      updateHero(currentIndex);
    });
    sliderDots.appendChild(dot);
  });

  // Button Event Listeners
  document.querySelector('.slider-controls.left').addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + games.length) % games.length;
    updateHero(currentIndex);
  });

  document.querySelector('.slider-controls.right').addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % games.length;
    updateHero(currentIndex);
  });

  // Initialize the slider with the first game
  updateHero(currentIndex);

  // Platform Buttons Logic
  const platformButtons = document.querySelectorAll('.platform-btn');
  const allGamesContainer = document.getElementById('allGamesContainer');
  const allGameCards = allGamesContainer.querySelectorAll('.game-card');

  // Initially hide all game cards
  allGameCards.forEach(card => {
    card.style.display = 'none';
  });

  platformButtons.forEach(button => {
    button.addEventListener('click', function () {
      // Skip the "search button" or any button without a data-platform attribute
      if (!this.hasAttribute('data-platform')) return;

      const selectedPlatform = this.getAttribute('data-platform');

      // Update active button state
      platformButtons.forEach(btn => btn.classList.remove('active'));
      this.classList.add('active');

      allGameCards.forEach(card => {
        const cardPlatform = card.getAttribute('data-platform');
        // Show card if the selected platform is "All" or matches the card's platform
        if (selectedPlatform === "" || cardPlatform === selectedPlatform) {
          card.style.display = 'block'; // Make the card visible
        } else {
          card.style.display = 'none'; // Hide the card
        }
      });
    });
  });
});
src="script.js"
  </script>
 
</body>

</html>