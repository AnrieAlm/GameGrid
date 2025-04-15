// Function to toggle mobile menu visibility
function setupMobileMenu() {
  const menuToggle = document.querySelector('.menu-toggle'); // Select the menu toggle button
  const navLinks = document.querySelector('.nav-links'); // Select the navigation links container
  
  if (menuToggle && navLinks) { // Check if both elements exist
    menuToggle.addEventListener('click', () => { // Add click event listener to the toggle button
      navLinks.classList.toggle('active'); // Toggle the 'active' class on the navigation links
    });
  }
}

// Initialize variables for slider functionality
let currentSlide = 0; // Track the current slide index
let autoSlideInterval; // Store the interval ID for auto-sliding

// Array of slides data for the hero section
const slides = [
  {
    title: "GOD OF WAR RAGNAROK", // Slide title
    platform: "PS5", // Platform information
    rating: "4.8", // Game rating
    description: "Continues the epic journey of Kratos and Atreus", // Slide description
    link: "#", // Link for the "Read More" button
    image: "images/god-of-war-ragnarok-ps4-ps5-wallpapers-01.jpg" // Background image URL
  },
  {
    title: "ELDEN RING",
    platform: "PS5, Xbox Series X/S, PC",
    rating: "4.9",
    description: "An epic adventure in a vast open world",
    link: "#",
    image: "images/eldenRing.jpg"
  },
  {
    title: "STARFIELD",
    platform: "Xbox Series X/S, PC",
    rating: "4.7",
    description: "Bethesda's first new universe in 25 years",
    link: "#",
    image: "images/starField.jpg"
  }

  // Additional slides follow the same structure...
];

// Array of games data for review cards
const games = [
  {
    id: 1, // Unique identifier for the game
    title: "The Last of Us Part II", // Game title
    rating: 4.5, // Game rating
    platform: "PS4", // Platforms available
    image: "images/lastOfUs.jpg", // Image URL for the game
    screenshots: ["images/tlou1.jpeg", "images/tlou3.jpeg", "images/tlou4.jpeg"], // Screenshots
    review: { // Review details
      text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit.", // Review text
      author: "John Doe", // Review author
      date: "2023-10-27" // Review date
    },
    isBookmarked: false // Bookmark status
  },
  {
    id: 2,
    title: "Red Dead Redemption 2",
    rating: 4.8,
    platform: "PS4, Xbox One",
    image: "images/redDeadRed2.jpg",
    screenshots: ["images/rdr1.jpeg", "images/rdr2.jpeg", "images/rdr3.jpeg"],
    review: {
      text: "Nulla vitae elit libero, a pharetra augue. Donec sed odio dui.",
      author: "Jane Doe",
      date: "2023-11-05"
    },
    isBookmarked: true
  },
  {
    id: 3,
    title: "Elden Ring",
    rating: 4.9,
    platform: "PS4, PS5, Xbox One, Xbox Series X/S, PC",
    image: "images/eldenRing.jpg",
    screenshots: ["images/er1.jpeg", "images/er2.jpeg", "images/er3.jpeg"],
    review: {
      text: "Donec ullamcorper nulla non metus auctor fringilla.",
      author: "Mike Smith",
      date: "2023-11-12"
    },
    isBookmarked: false
  }
// Add more games here...
];

// Load bookmarks from local storage
let bookmarks = JSON.parse(localStorage.getItem('bookmarks')) || [];

// Sync initial bookmark status
games.forEach(game => {
    game.isBookmarked = bookmarks.includes(game.id);
});

// Function to initialize the hero slider
function initSlider() {
  const heroBg = document.querySelector('.hero-background'); // Hero background element
  const leftControl = document.querySelector('.slider-controls.left'); // Left control button
  const rightControl = document.querySelector('.slider-controls.right'); // Right control button
  const dots = document.querySelectorAll('.slider-dots .dot'); // Slider dots

  // Exit early if required elements are missing
  if (!heroBg || !leftControl || !rightControl || !dots.length) {
    console.log("Slider elements not found. Skipping slider initialization."); // Log error message
    return;
  }

  // Update slide content and background
  function updateSlide() {
    const currentSlideData = slides[currentSlide]; // Get current slide data
    document.querySelector('.hero-content h2').textContent = currentSlideData.title; // Update title
    document.querySelector('.platform-tag').textContent = currentSlideData.platform; // Update platform
    document.querySelector('.rating').textContent = currentSlideData.rating; // Update rating
    document.querySelector('.hero-content p').textContent = currentSlideData.description; // Update description
    document.querySelector('.read-btn').href = currentSlideData.link; // Update "Read More" link

    // Update background image
    if (heroBg) {
      heroBg.style.backgroundImage = `url('${currentSlideData.image}')`; // Set background image
    }

    // Update active dot
    dots.forEach((dot, index) => {
      dot.classList.toggle('active', index === currentSlide); // Highlight active dot
    });
  }

  // Start auto-slide functionality
  function startAutoSlide() {
    autoSlideInterval = setInterval(() => { // Auto-change slides every 5 seconds
      currentSlide = (currentSlide + 1) % slides.length; // Move to next slide
      updateSlide(); // Update slide content
    }, 5000);
  }

  // Stop auto-slide functionality
  function stopAutoSlide() {
    clearInterval(autoSlideInterval); // Clear the interval to stop sliding
  }

  // Bind slider controls
  if (leftControl && rightControl) {
    leftControl.addEventListener('click', () => { // Add click event to left control
      stopAutoSlide(); // Stop auto-sliding
      currentSlide = (currentSlide - 1 + slides.length) % slides.length; // Move to previous slide
      updateSlide(); // Update slide content
      startAutoSlide(); // Restart auto-sliding
    });

    rightControl.addEventListener('click', () => { // Add click event to right control
      stopAutoSlide(); // Stop auto-sliding
      currentSlide = (currentSlide + 1) % slides.length; // Move to next slide
      updateSlide(); // Update slide content
      startAutoSlide(); // Restart auto-sliding
    });
  }


  // Bind slider dots
  dots.forEach((dot, index) => {
    dot.addEventListener('click', () => { // Add click event to each dot
      stopAutoSlide(); // Stop auto-sliding
      currentSlide = index; // Set current slide to the clicked dot's index
      updateSlide(); // Update slide content
      startAutoSlide(); // Restart auto-sliding
    });
  });

  // Initialize the first slide
  updateSlide(); // Display the first slide
  startAutoSlide(); // Start auto-sliding
}

// Function to display review cards
function displayReviews() {
  const reviewsContainer = document.getElementById('reviewsContainer'); // Select the reviews container
  if (!reviewsContainer) return; // Exit if the container doesn't exist

  reviewsContainer.innerHTML = ''; // Clear previous reviews

  games.forEach(game => { // Loop through the games array
    const reviewCard = document.createElement('div'); // Create a new review card element
    reviewCard.classList.add('review-card'); // Add 'review-card' class to the element
    reviewCard.dataset.gameId = game.id; // Set a data attribute for the game ID

    reviewCard.innerHTML = `
      <div class="card-header">
        <img src="${game.image}" alt="${game.title}"> 
        <!-- Game image -->
        <button class="bookmark-btn" onclick="toggleBookmark(${game.id})"> <!-- Bookmark button -->
          ${game.isBookmarked ? '★' : '☆'} <!-- Show filled or empty star -->
        </button>
      </div>
      <div class="review-content">
        <h3>${game.title}</h3> <!-- Game title -->
        <span class="star-rating">⭐ ${game.rating}/5</span> <!-- Game rating -->
        <p class="review-description">${game.review.text}</p> <!-- Review text -->
        <a href="/inner-review.html?id=${game.id}" class="read-more">Read More</a> <!-- Read More link -->
      </div>
    `;

    reviewsContainer.appendChild(reviewCard); // Append the review card to the container
  });
}

// Unified toggle function for bookmarks
function toggleBookmark(gameId) {
  const game = games.find(game => game.id === gameId);
  if (!game) return;

  // Toggle bookmark status
  game.isBookmarked = !game.isBookmarked;

  // Update bookmarks array
  if (game.isBookmarked) {
      bookmarks.push(gameId);
  } else {
      bookmarks = bookmarks.filter(id => id !== gameId);
  }

  // Save updated bookmarks to local storage
  localStorage.setItem('bookmarks', JSON.stringify(bookmarks));

  // Update the UI
  updateBookmarkUI(gameId);
  displayBookmarksOnProfile();
}

// UI update function for bookmarks
function updateBookmarkUI(gameId) {
    const buttons = document.querySelectorAll(`[data-game-id="${gameId}"] .bookmark-btn`);
    buttons.forEach(button => {
        button.innerHTML = bookmarks.includes(gameId) ? '★' : '☆';
    });
}

// Function to display bookmarks on the profile page
function displayBookmarksOnProfile() {
    const container = document.querySelector('.p_bookmarks-content');
    if (!container) return;

    container.innerHTML = bookmarks.length
        ? bookmarks.map(id => {
              const game = games.find(g => g.id === id);
              return `<li><a href="/inner-review.html?id=${id}">${game?.title || 'Unknown Game'}</a></li>`;
          }).join('')
          : '<li>No bookmarks yet.</li>';
        }

        function loadPlatformGames(platform = '') {

          const gamesContainer = document.getElementById('platformGames');
        
    
  fetch(`get_platform_games.php?platform=${platform}`)
        
            .then(response => response.json())
        
            .then(games => {
        
              gamesContainer.innerHTML = games.map(game => `
        
                <div class="game-card">
        
                  <img src="${game.image_url}" alt="${game.title}">
        
                  <h3>${game.title}</h3>
        
                  <span class="platform-tag">${game.platform}</span>
        
                </div>
        
              `).join('');
        
            })
        
            .catch(error => console.error('Error:', error));}



// DOMContentLoaded event listener to initialize components
document.addEventListener('DOMContentLoaded', () => {
  console.log("DOM fully loaded. Initializing components..."); // Log initialization message

  // Initialize slider only if relevant elements exist
  if (document.querySelector('.hero-background')) {
    console.log("Hero background found. Initializing slider..."); // Log slider initialization
    initSlider(); // Call the slider initialization function
  } else {
    console.log("Hero background not found. Skipping slider initialization."); // Log error message
  }

  // Setup mobile menu
  console.log("Setting up mobile menu..."); // Log mobile menu setup
  setupMobileMenu(); // Call the mobile menu setup function

  // Check for reviews container
  const reviewsContainer = document.getElementById('reviewsContainer');
  if (reviewsContainer) {
    console.log("Reviews container found. Displaying reviews..."); // Log reviews display
    displayReviews(); // Call the reviews display function

    // View toggle functionality
    const gridViewBtn = document.getElementById('gridView'); // Select grid view button
    const listViewBtn = document.getElementById('listView'); // Select list view button

    if (gridViewBtn && listViewBtn) {
      console.log("Grid and list view buttons found. Setting up view toggle..."); // Log view toggle setup
      gridViewBtn.addEventListener('click', () => { // Add click event to grid view button
        reviewsContainer.className = 'reviews-container grid-view'; // Switch to grid view
        gridViewBtn.classList.add('active'); // Highlight grid view button
        listViewBtn.classList.remove('active'); // Unhighlight list view button
      });

      listViewBtn.addEventListener('click', () => { // Add click event to list view button
        reviewsContainer.className = 'reviews-container list-view'; // Switch to list view
        listViewBtn.classList.add('active'); // Highlight list view button
        gridViewBtn.classList.remove('active'); // Unhighlight grid view button
      });
    } else {
      console.warn("Grid or list view buttons not found. Skipping view toggle setup."); // Log warning
    }
  } else {
    console.warn("Reviews container not found. Skipping review display."); // Log warning
  }
  // Display bookmarks on the profile page
  displayBookmarksOnProfile();

 // Platform filtering

 const platformButtons = document.querySelectorAll('.platform-btn');

 platformButtons.forEach(button => {

   button.addEventListener('click', () => {

     platformButtons.forEach(btn => btn.classList.remove('active'));

     button.classList.add('active');

     loadPlatformGames(button.dataset.platform);

   });

 });

 

 // Initial load

 loadPlatformGames();

 console.log("DOM fully loaded. Initializing components...");


});

//-----------------bookmark
// Listen for any click event on the document
document.addEventListener('click', (event) => {
  // Check if clicked element has 'bookmark-btn' class
  if (event.target.classList.contains('bookmark-btn')) {
    // Get game ID from data attribute (incorrect implementation - should use closest())
    const gameId = event.target.dataset.gameId;
    // Call toggle function (gameId might be undefined here)
    toggleBookmark(gameId);
  }
});

// Select all bookmark buttons (duplicate event listener - already handled above)
document.querySelectorAll('.bookmark-btn').forEach(button => {
  // Add click handler to each button (conflicts with previous listener)
  button.addEventListener('click', async () => {
    // Get game ID from data attribute (needs proper dataset access)
    const gameId = button.dataset.gameId;
    // PHP code in JavaScript - invalid syntax
    //const userId = <?php echo $_SESSION['user_id']; ?>; 

    try {
      // API call to bookmark endpoint (needs proper error handling)
      const response = await fetch('/api/bookmark.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        // userId is undefined - PHP code not working
        body: JSON.stringify({ userId, gameId })
      });

      // Check response status
      if (response.ok) {
        // Parse JSON data
        const data = await response.json();
        // Check server response
        if (data.success) {
          // Toggle star icons (FontAwesome classes not used in HTML)
          button.querySelector('i').classList.toggle('fa-star');
          button.querySelector('i').classList.toggle('fa-star-outline');
        } else {
          // Show error alert
          alert('Failed to bookmark the game.');
        }
      }
    } catch (error) {
      // Log errors
      console.error('Error:', error);
    }
  });

  // Bookmark display function (incorrectly nested inside event listener)
  function displayBookmarksOnProfile() {
    // Get bookmarks container
    const bookmarksContainer = document.querySelector('.p_bookmarks-content');
    // Exit if no container
    if (!bookmarksContainer) return;
  
    // Clear container
    bookmarksContainer.innerHTML = '';
  
    // Filter bookmarked games
    const bookmarkedGames = games.filter(game => game.isBookmarked);
    // Handle empty state
    if (bookmarkedGames.length === 0) {
      bookmarksContainer.innerHTML = '<li>No bookmarks yet.</li>';
      return;
    }
  
    // Create bookmark items
    bookmarkedGames.forEach(game => {
      const bookmarkItem = document.createElement('li');
      // Populate bookmark HTML
      bookmarkItem.innerHTML = `
        <a href="/inner-review.html?id=${game.id}">
          <img src="${game.image}" alt="${game.title}" width="50" height="50">
          ${game.title}
        </a>
      `;
      // Add to container
      bookmarksContainer.appendChild(bookmarkItem);
    });
  }

  // Update localStorage (incorrectly placed inside event listener)
  // Initialize bookmarks array
let bookmarks = JSON.parse(localStorage.getItem('bookmarks')) || [];

// Single event listener for bookmark buttons
document.addEventListener('click', (event) => {
  const bookmarkBtn = event.target.closest('.bookmark-btn');
  if (!bookmarkBtn) return;

  const gameId = bookmarkBtn.dataset.gameId;
  toggleBookmark(gameId);
});

// Unified toggle function
function toggleBookmark(gameId) {
  const game = games.find(game => game.id === gameId);
  if (!game) return;

  game.isBookmarked = !game.isBookmarked;
  
  // Update bookmarks array
  if (game.isBookmarked) {
    bookmarks.push(gameId);
  } else {
    bookmarks = bookmarks.filter(id => id !== gameId);
  }
  
  // Update storage and UI
  localStorage.setItem('bookmarks', JSON.stringify(bookmarks));
  updateBookmarkUI(gameId);
  displayBookmarksOnProfile();
}

// UI update function
function updateBookmarkUI(gameId) {
  const buttons = document.querySelectorAll(`[data-game-id="${gameId}"] .bookmark-btn`);
  buttons.forEach(button => {
    button.innerHTML = bookmarks.includes(gameId) ? '★' : '☆';
  });
}

// Bookmark display function
function displayBookmarksOnProfile() {
  const container = document.querySelector('.p_bookmarks-content');
  if (!container) return;

  container.innerHTML = bookmarks.length 
    ? bookmarks.map(id => {
        const game = games.find(g => g.id === id);
        return `<li><a href="/inner-review.html?id=${id}">${game?.title || 'Unknown Game'}</a></li>`;
      }).join('')
    : '<li>No bookmarks yet.</li>';
}

// Initial load handler
document.addEventListener('DOMContentLoaded', () => {
  // Sync initial state
  games.forEach(game => {
    game.isBookmarked = bookmarks.includes(game.id);
  });
  
  displayReviews();
  displayBookmarksOnProfile();
});

});
