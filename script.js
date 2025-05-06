/* file that handles all the javascript functionalities in our website. contains multiple functionalities
Author:- Neil Joseph */


document.addEventListener("DOMContentLoaded", () => {
  // Initialize userId from PHP session
  //const userId = <?php echo isset($_SESSION['user_id']) ? json_encode($_SESSION['user_id']) : 'null'; ?>;

  // Ensure the user is logged in before proceeding
  if (!userId) {
    console.warn("User not logged in. Bookmarking functionality disabled.");
    return;
  }

  // Fetch and display bookmarks on the profile page
  fetchAndDisplayBookmarks();

  // Attach event listeners to all bookmark buttons
  document.querySelectorAll(".bookmark-btn").forEach((button) => {
    button.addEventListener("click", toggleBookmark);
  });

  /**
   * Toggle bookmark status for a game
   */
  async function toggleBookmark(event) {
    const gameId = event.target.dataset.gameId; // Get the game ID from the button's data attribute
    if (!gameId) return;

    try {
      const response = await fetch("bookmarks.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ userId, gameId }),
      });

      const data = await response.json();
      if (data.success) {
        // Update the UI (e.g., change the star icon)
        event.target.textContent = event.target.textContent === "☆" ? "★" : "☆";
        alert("Bookmark updated successfully!");

        // Refresh bookmarks on the profile page
        fetchAndDisplayBookmarks();
      } else {
        alert("Failed to update bookmark.");
      }
    } catch (error) {
      console.error("Error:", error);
      alert("An error occurred while updating the bookmark.");
    }
  }

  /**
   * Fetch and display bookmarks on the profile page
   */
  async function fetchAndDisplayBookmarks() {
    const bookmarksContainer = document.querySelector(".p_bookmarks-content");
    if (!bookmarksContainer) return;

    try {
      const response = await fetch("get_bookmarks.php");
      const data = await response.json();

      if (!data.success) {
        console.error("Failed to fetch bookmarks:", data.message);
        bookmarksContainer.innerHTML = "<li>No bookmarks available.</li>";
        return;
      }

      const bookmarks = data.data;
      if (bookmarks.length === 0) {
        bookmarksContainer.innerHTML = "<li>No bookmarks available.</li>";
        return;
      }

      // Populate the bookmarks container with fetched data
      bookmarksContainer.innerHTML = bookmarks
        .map(
          (game) => `
            <li>
              <a href="/inner-review.html?id=${game.id}">
                <img src="${game.image_url}" alt="${game.title}" width="50" height="50">
                ${game.title}
              </a>
            </li>
          `
        )
        .join("");
    } catch (error) {
      console.error("Error fetching bookmarks:", error);
      bookmarksContainer.innerHTML = "<li>Error loading bookmarks.</li>";
    }
  }

  /**
   * Mobile Menu Functionality
   */
  const menuCheckbox = document.getElementById("menu-toggle-checkbox"); // Hamburger toggle checkbox
  const navLinks = document.querySelectorAll(".nav-links a"); // All navigation links

  // Close the mobile menu when any link is clicked
  navLinks.forEach((link) => {
    link.addEventListener("click", () => {
      if (menuCheckbox.checked) {
        menuCheckbox.checked = false; // Uncheck to close menu
      }
    });
  });

  // Optional: Close menu on outside click (mobile only)
  document.addEventListener("click", (event) => {
    const navbar = document.querySelector(".navbar");
    const isClickInside = navbar.contains(event.target);

    // Close if clicked outside and menu is open
    if (!isClickInside && menuCheckbox.checked) {
      menuCheckbox.checked = false;
    }
  });

  /**
   * Hero Slider Functionality
   */
  let currentSlide = 0; // Track the current slide index
  let autoSlideInterval; // Store the interval ID for auto-sliding

  // const slides = <?php echo json_encode($games); ?>; // Convert PHP games array to JavaScript
  // if (slides.length === 0) {
  //   console.error("No games available for the slider.");
  //   return;
  // }

  const heroBackground = document.querySelector(".hero-background");
  const heroTitle = document.getElementById("hero-title");
  const heroPlatform = document.getElementById("hero-platform");
  const heroRating = document.getElementById("hero-rating");
  const sliderDots = document.getElementById("sliderDots");

  // Function to update the hero section
  function updateHero(index) {
    const game = slides[index];
    heroBackground.style.backgroundImage = `url('${game.image_url}')`;
    heroTitle.textContent = game.title;
    heroPlatform.textContent = `Platform: ${game.platform}`;
    heroRating.textContent = `Rating: ${game.rating}/10`;

    // Update active dot
    const dots = sliderDots.querySelectorAll(".dot");
    dots.forEach((dot, i) => dot.classList.toggle("active", i === index));
  }

  // Initialize slider dots
  slides.forEach((_, index) => {
    const dot = document.createElement("button");
    dot.className = "dot";
    dot.setAttribute("aria-label", `Slide ${index + 1}`);
    dot.addEventListener("click", () => {
      currentSlide = index;
      updateHero(currentSlide);
    });
    sliderDots.appendChild(dot);
  });

  // Button Event Listeners
  document.querySelector(".slider-controls.left").addEventListener("click", () => {
    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
    updateHero(currentSlide);
  });

  document.querySelector(".slider-controls.right").addEventListener("click", () => {
    currentSlide = (currentSlide + 1) % slides.length;
    updateHero(currentSlide);
  });

  // Initialize the slider with the first game
  updateHero(currentSlide);

  /**
   * Platform Filtering Logic
   */
  const platformButtons = document.querySelectorAll(".platform-btn");
  const allGamesContainer = document.getElementById("allGamesContainer");
  const allGameCards = allGamesContainer.querySelectorAll(".game-card");

  // Initially hide all game cards
  allGameCards.forEach((card) => {
    card.style.display = "none";
  });

  platformButtons.forEach((button) => {
    button.addEventListener("click", function () {
      // Skip the "search button" or any button without a data-platform attribute
      if (!this.hasAttribute("data-platform")) return;

      const selectedPlatform = this.getAttribute("data-platform");

      // Update active button state
      platformButtons.forEach((btn) => btn.classList.remove("active"));
      this.classList.add("active");

      allGameCards.forEach((card) => {
        const cardPlatform = card.getAttribute("data-platform");

        // Show card if the selected platform is "All" or matches the card's platform
        if (selectedPlatform === "" || cardPlatform === selectedPlatform) {
          card.style.display = "block"; // Make the card visible
        } else {
          card.style.display = "none"; // Hide the card
        }
      });
    });
  });
});