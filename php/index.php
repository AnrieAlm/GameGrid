<?php
// Start the session to access session variables
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Game Grid</title>
  <link href="CSS/style2.css" rel="stylesheet" type="text/css" />
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

    .platform-tag,
    .rating {
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
      padding: 1rem 2rem;
      background: #1e1e1e;
      color: #00ffc8;
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
      background: rgba(0, 0, 0, 0.5);
      color: white;
      border: none;
      padding: 1rem;
      border-radius: 50%;
      cursor: pointer;
      z-index: 3;
    }

    .slider-controls.left {
      left: 2rem;
    }

    .slider-controls.right {
      right: 2rem;
    }

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
      background: rgba(255, 255, 255, 0.5);
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

      .platform-tag,
      .rating {
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

    /* Bookmark Button */
    .bookmark-btn {
      background: #00ffc8;
      color: #1e1e1e;
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 4px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .bookmark-btn.bookmarked {
      background: #ff4d4d;
      color: white;
    }
  </style>
</head>

<body>
  <!-- Header Section -->
 <!-- Include the header.php file -->
   <?php include 'header.php'; ?>

        

  <main>
    <!-- Hero Slider Section -->
    <section id="hero-section">
      <article class="hero-slider">
        <!-- Background Image -->
        <div class="hero-background"></div>

        <!-- Slide Content Empty container -->
        <div class="hero-content">
          <h2>Welcome to Game Grid</h2>
          <div class="hero-meta">
            <span class="platform-tag">All Platforms</span>
            <span class="rating">Top Rated</span>
          </div>
          <p>Discover the latest reviews, news, and community discussions about your favorite games.</p>
          <a href="#" class="read-btn">Read More</a>
        </div>

        <!-- Slider Controls -->
        <button class="slider-controls left" aria-label="Previous slide">
          <i class="fas fa-chevron-left"></i>
        </button>
        <button class="slider-controls right" aria-label="Next slide">
          <i class="fas fa-chevron-right"></i>
        </button>

        <!-- Slider Dots -->
        <nav class="slider-dots" aria-label="Slider navigation">
          <button class="dot active" aria-label="Slide 1"></button>
          <button class="dot" aria-label="Slide 2"></button>
          <button class="dot" aria-label="Slide 3"></button>
        </nav>
      </article>
    </section>

    <!-- Platform Browse Section -->
    <section class="platform-section">
      <h2>Browse by Platform</h2>
      <nav class="platform-grid">
        <a href="#" class="platform-btn">PS5</a>
        <a href="#" class="platform-btn">Nintendo</a>
        <a href="#" class="platform-btn">Xbox</a>
        <a href="#" class="platform-btn">PS4</a>
        <a href="#" class="platform-btn">PC</a>
      </nav>
    </section>

    <!-- Trending Reviews -->
    <section id="trending-reviews">
      <div class="section-header">
        <h2>Trending Reviews</h2>
        <div class="view-toggle">
          <button id="gridView" class="active">Grid</button>
          <button id="listView">List</button>
        </div>
      </div>
      <div id="reviewsContainer" class="reviews-container grid-view">
        <!-- Example Review Cards -->
        <div class="review-card" data-game-id="1">
          <img src="images/game1.jpg" alt="Game Cover">
          <h3>Game Title 1</h3>
          <p>Platform: PS5 | Rating: 9/10</p>
          <button class="bookmark-btn" data-game-id="1">Bookmark</button>
        </div>
        <div class="review-card" data-game-id="2">
          <img src="images/game2.jpg" alt="Game Cover">
          <h3>Game Title 2</h3>
          <p>Platform: Xbox | Rating: 8/10</p>
          <button class="bookmark-btn" data-game-id="2">Bookmark</button>
        </div>
      </div>
    </section>
  </main>

  <footer>
    <p>© 2024 Game Grid. All rights reserved.</p>
    <a href="aboutus.html">About Us</a>
  </footer>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Load bookmarks from local storage on page load
      const bookmarks = JSON.parse(localStorage.getItem('bookmarks')) || [];

      // Add click event listeners to all bookmark buttons
      document.querySelectorAll('.bookmark-btn').forEach(button => {
        const gameId = button.dataset.gameId;

        // Check if the game is already bookmarked
        if (bookmarks.includes(gameId)) {
          button.classList.add('bookmarked');
          button.textContent = 'Bookmarked';
        }

        button.addEventListener('click', () => {
          if (bookmarks.includes(gameId)) {
            // Remove the bookmark
            bookmarks.splice(bookmarks.indexOf(gameId), 1);
            button.classList.remove('bookmarked');
            button.textContent = 'Bookmark';
          } else {
            // Add the bookmark
            bookmarks.push(gameId);
            button.classList.add('bookmarked');
            button.textContent = 'Bookmarked';
          }

          // Save updated bookmarks to local storage
          localStorage.setItem('bookmarks', JSON.stringify(bookmarks));
        });
      });
    });
  </script>
</body>

</html>