/* file that handles the reveiw javascript functionalities in our website. 
Author:- Neil Joseph */

document.addEventListener('DOMContentLoaded', () => {
  
  // Get the review ID from the URL parameters
  const urlParams = new URLSearchParams(window.location.search);
  const reviewId = parseInt(urlParams.get('id'));
  
  // Set up bookmark button functionality
  const bookmarkBtn = document.getElementById('bookmarkBtn');
  bookmarkBtn.addEventListener('click', () => {
    toggleBookmark(reviewId); // Toggle bookmark status
    updateBookmarkButton(reviewId); // Update UI to reflect bookmark state
  });

  // Fetch review data from script.js
  fetch('script.js')
    .then(response => response.text()) // Get script.js content as text
    .then(text => {
      // Extract the games array from script.js using regex
      const gamesMatch = text.match(/const games = (\[[\s\S]*?\]);/);
      if (gamesMatch) {
        const games = eval(gamesMatch[1]); // Convert extracted text to an array
        const game = games.find(g => g.id === reviewId); // Find the game with the matching ID
        if (game) {
          displayReviewDetail(game); // Display the review details
          updateBookmarkButton(reviewId); // Update the bookmark button state
          setupCommentForm(reviewId); // Set up the comment form functionality
        } else {
          displayErrorMessage("Game not found"); // Show error if game is not found
        }
      }
    })
    .catch(error => {
      console.error('Error fetching game data:', error);
      displayErrorMessage("Failed to load review data"); // Display error message if data cannot be loaded
    });
});

// Function to display review details on the page
function displayReviewDetail(game) {
  const reviewDetail = document.getElementById('reviewDetail');
  const videoContainer = document.getElementById('videoContainer');
  
  // Set the document title based on the game's title
  document.title = `${game.title} - Game Grid`;
  
  // Populate the review section with game details
  reviewDetail.innerHTML = `
    <h1>${game.title}</h1>
    <div class="meta-info">
      <span class="rating"><i class="fas fa-star"></i> ${game.rating}/5</span>
      <span class="author">Review by ${game.review.author}</span>
      <span class="date">${formatDate(game.review.date)}</span>
    </div>
    
    <div class="genre-labels">
      <span class="genre-label">Action Adventure</span>
      <span class="genre-label">RPG</span>
      <span class="platform-label">${game.platform}</span>
    </div>
    
    <div class="review-hero">
      <img src="${game.image}" alt="${game.title}" class="hero-image">
    </div>
    
    <div class="review-text">
      <p>${generateLongReviewText(game.title)}</p>
      <p>${generateLongReviewText(game.title, 2)}</p>
    </div>
    
    <div class="review-screenshots">
    
      <h3>Screenshots</h3>
      <div class="screenshots-grid">
      ${game.screenshots.map((screenshot, index) => 
        `<img src="${screenshot}" alt="Screenshot ${index + 1}" onerror="this.src='${game.image}'"/>`
      ).join('')}
        </div>
    </div>
  `;
  
  // Embed a YouTube video related to the game
  videoContainer.innerHTML = `
    <iframe width="560" height="315" 
      src="https://youtu.be/bh5gzGs-63Y?si=QgnkFYzfD76Mo1RE" 
      frameborder="0" 
      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
    </iframe>
    <div class="watch-on-youtube">
      <a href="https://youtu.be/bh5gzGs-63Y?si=QgnkFYzfD76Mo1RE" target="_blank">
        <i class="fab fa-youtube"></i> Watch on YouTube
      </a>
    </div>
  `;
}

// Function to format the review date
function formatDate(dateString) {
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  return new Date(dateString).toLocaleDateString(undefined, options);
}

// Function to generate placeholder review text
function generateLongReviewText(gameTitle, paragraph = 1) {
  const lorem1 = `Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio a ante commodo dignissim. Donec et dignissim massa. Vestibulum nec justo a libero fermentum imperdiet. Praesent euismod nisi vel justo. Curabitur in est non nibh feugiat semper in id ex. Mauris eget purus ac justo pharetra aliquet viverra vitae nisl. Mauris et ipsum mollis, viverra risus vel, ultricies diam. Pellentesque augue eros, dictum et urna quis, interdum fringilla nunc. Donec commodo non ligula vel porttitor. Praesent quis tincidunt sapien. Etiam velit ante sit elit volutpat sodales. Integer porta lectus ligula, quis porta massa lobortis non. In hac habitasse platea dictumst.`;
    
  const lorem2 = `Praesent ultricies vulputate nibh id finibus. Donec iaculis lorem iaculis, sit amet porttitor leo ultricies at. Maecenas vitae lectus tortor, et pulvinar tortor. Vivamus porta risus nec consequat laoreet. Nulla id purus eget massa mollis vulputate eu eu nisi. Praesent tempus turpis at eros. Sed commodo augue ipsum. Integer quis ligula sit amet felis fringilla interdum. Duis convallis odio turpis, ac aliquam magna rhoncus at. Integer porta diam velit, non dignissim tellus sagittis sit amet. In hac habitasse platea dictumst. Vestibulum efficitur felis quis risus ultricies tincidunt. Nulla ac dui sit amet augue tristique tempus. Integer porta massa fermentum, finibus augue sed, imperdiet diam.`;

  return paragraph === 1 ? lorem1.replace("Lorem ipsum", gameTitle) : lorem2;
}

// Function to update the bookmark button state
function updateBookmarkButton(gameId) {
  const bookmarkedGames = JSON.parse(localStorage.getItem('bookmarkedGames') || '[]');
  const isBookmarked = bookmarkedGames.includes(gameId);
  
  const bookmarkBtn = document.getElementById('bookmarkBtn');
  if (isBookmarked) {
    bookmarkBtn.innerHTML = '<i class="fas fa-bookmark"></i> Bookmarked';
    bookmarkBtn.classList.add('bookmarked');
  } else {
    bookmarkBtn.innerHTML = '<i class="far fa-bookmark"></i> Bookmark';
    bookmarkBtn.classList.remove('bookmarked');
  }
}

// Function to toggle bookmark state
function toggleBookmark(gameId) {
  let bookmarkedGames = JSON.parse(localStorage.getItem('bookmarkedGames') || '[]');
  
  if (bookmarkedGames.includes(gameId)) {
    bookmarkedGames = bookmarkedGames.filter(id => id !== gameId);
  } else {
    bookmarkedGames.push(gameId);
  }
  
  localStorage.setItem('bookmarkedGames', JSON.stringify(bookmarkedGames));
}

// Function to set up the comment form
function setupCommentForm(gameId) {
  const commentForm = document.getElementById('commentForm');
  const commentsContainer = document.getElementById('commentsContainer');
  
  displayComments(gameId); // Load existing comments
  
  commentForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const textarea = commentForm.querySelector('textarea');
    const commentText = textarea.value.trim();
    
    if (commentText) {
      addComment(gameId, commentText);
      textarea.value = '';
      displayComments(gameId);
    }
  });
}

// Function to add a comment
function addComment(gameId, commentText) {
  let comments = JSON.parse(localStorage.getItem(`comments_${gameId}`) || '[]');
  comments.push({ text: commentText, author: 'Current User', date: new Date().toISOString() });
  localStorage.setItem(`comments_${gameId}`, JSON.stringify(comments));
}

// Function to display comments
function displayComments(gameId) {
  const commentsContainer = document.getElementById('commentsContainer');
  const comments = JSON.parse(localStorage.getItem(`comments_${gameId}`) || '[]');
  
  if (comments.length === 0) {
    commentsContainer.innerHTML = '<p>No comments yet.</p>';
    return;
  }
  
  commentsContainer.innerHTML = comments.map(comment => `
    <div class="comment">
      <strong>${comment.author}</strong> - ${formatDate(comment.date)}
      <p>${comment.text}</p>
    </div>
  `).join('');
}



  