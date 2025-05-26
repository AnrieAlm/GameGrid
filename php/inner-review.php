<?php
/*inner review file that displays specific reviews from the databse
Author:- Victor
*/
session_start(); // Start the session at the top of the file
$user_id = $_SESSION['user_id'] ?? 1; // Use the logged-in user's ID or a default value
require 'init.php'; // Start the session
require 'db.php'; // Database connection

// Initialize variables
$review_id = null;
$review = null;

// Validate the review ID

if (isset($_GET['id']) && is_numeric($_GET['id'])) {

  $review_id = (int)$_GET['id'];
}
// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $comment_content = trim($_POST['comment']);
    $username = 'Anonymous'; // Replace with actual user session or input if available
    $review_id = (int)$_POST['review_id'];

    if (!empty($comment_content)) {
        // Insert the comment into the database
        $stmt = $pdo->prepare("INSERT INTO comments (review_id, username, comment_text, created_at) VALUES (:review_id, :username, :content, NOW())");
        $stmt->execute([
            'review_id' => $review_id,
            'username' => $username,
            'content' => $comment_content
        ]);
        header("Location: " . htmlspecialchars($_SERVER['PHP_SELF']) . "?id=" . $review_id);

        exit();
    }
}
// Handle Comment Update (Edit)

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_comment'])) {

    $comment_id = (int)$_POST['comment_id'];

    $updated_content = trim($_POST['updated_content']);
    if (!empty($updated_content)) {

          $stmtUpdate = $pdo->prepare("UPDATE comments SET comment_text = :comment_text WHERE id = :comment_id");

          $stmtUpdate->execute([
  
             'comment_text' => $updated_content,
  
              'comment_id' => $comment_id
  
          ]);
        header("Location: " . htmlspecialchars($_SERVER['PHP_SELF']) . "?id=" . $review_id);
        exit();
    // }

  } else {

    echo '<p>Comment content cannot be empty.</p>';
  }
}


    // Handle Comment Deletion (Delete)

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_comment'])) {

  $comment_id = (int)$_POST['comment_id'];

    $stmtDelete = $pdo->prepare("DELETE FROM comments WHERE id = :comment_id");

    $stmtDelete->execute(['comment_id' => $comment_id]);

    header("Location: " . htmlspecialchars($_SERVER['PHP_SELF']) . "?id=" . $review_id);

    exit();

    // }
}


// Validate the review ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $review_id = (int)$_GET['id'];

    // Fetch review details from the database
    $stmt = $pdo->prepare("SELECT * FROM reviews WHERE id = :review_id");
    $stmt->execute(['review_id' => $review_id]);
    $review = $stmt->fetch();

    if ($review) {
        // Fetch associated game details
        $game_id = $review['game_id']; // Assuming the review table has a foreign key `game_id`
        $stmtGame = $pdo->prepare("SELECT * FROM games WHERE id = :game_id");
        $stmtGame->execute(['game_id' => $game_id]);
        $game = $stmtGame->fetch();

        // Fetch screenshots for the game
        $stmtScreenshots = $pdo->prepare("SELECT * FROM screenshots WHERE game_id = :game_id");
        $stmtScreenshots->execute(['game_id' => $game_id]);
        $screenshots = $stmtScreenshots->fetchAll(PDO::FETCH_ASSOC);

        // Fetch comments for this review
        $stmtComments = $pdo->prepare("SELECT * FROM comments WHERE review_id = :review_id ORDER BY created_at DESC");
        $stmtComments->execute(['review_id' => $review_id]);
        $comments = $stmtComments->fetchAll(PDO::FETCH_ASSOC);
    }
} else {
    echo '<p>Invalid review ID.</p>';
}

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Game Review - Game Grid</title>
  <link href="style2.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    /* General Styles */
    body {
      font-family: Arial, sans-serif;
      background-color: #1e1e1e;
      color: white;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }

    h1 {
      font-size: 2rem;
      margin-bottom: 10px;
    }

    .rating {
      color: gold;
      font-size: 1.2rem;
    }

    .review-meta {
      font-size: 0.9rem;
      margin-bottom: 20px;
    }

    .review-meta span {
      margin-right: 10px;
    }

    .review-meta .platforms {
      background-color: #00ffc8;
      color: white;
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 0.9rem;
    }

    .review-image {
      width: 100%;
      max-width: 400px;
      height: auto;
      margin-bottom: 20px;
    }

    .screenshots-section {
      margin-top: 20px;
    }

    .screenshots-header {
      font-size: 1.5rem;
      margin-bottom: 10px;
    }

    .screenshot-grid {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
    }

    .screenshot-item {
      flex: 1 1 calc(33.33% - 20px); /* Adjust for three columns with gaps */
      position: relative;
    }

    .screenshot-item img {
      width: 100%;
      height: auto;
      border-radius: 5px;
    }

    .bookmark-btn {
      position: absolute;
      top: 10px;
      right: 10px;
      background-color: rgba(0, 255, 200, 0.8);
      color: black;
      border: none;
      padding: 5px 10px;
      border-radius: 5px;
      cursor: pointer;
    }



    /* Video Section */
.video-section {
  margin-top: 20px;
  text-align: center; /* Center the section */
}

.video-container iframe {
  width: 100%;
  max-width: 560px; /* Set a maximum width for the video */
  height: 315px;
  margin: 0 auto; /* Center the iframe horizontally */
}

.comments-section {
      max-width: 1500px;
      margin: 0 auto;
      padding: 1rem;
      background-color: #2a2a2a;
      display: grid;
      grid-template-columns: repeat(5, 1fr); /* Unified 5-column grid */
      gap: 1rem;
    }

    .comments-header {
      grid-column: 1 / -1;
      text-align: center;
      margin-bottom: 1rem;
    }

    .user-avatar-container {
      grid-column: 1 / 2;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .comment-input-container {
      grid-column: 2 / -1;
    }


    .comment-input-container textarea {
      width: 1000px;
  height: 80px;
      resize: vertical;
      background-color: #444;
      color: white;
      border: 1px solid #ccc;
      border-radius: 5px;
      padding: 10px;
    }


    .submit-button-container {
      grid-column: span 5;
      display: flex;
      justify-content: center;
    }

    .submit-button-container button {
      padding: 10px 20px;
      background-color: #00ffc8;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 1rem;
    }

    .submit-button-container button:hover {
      background-color: #00e6b3;
    }

    .comments-container {
      grid-column: span 5;
    }


    .comment {
      background-color: #2a2a2a;
      padding: 10px;
      border-radius: 5px;
      display: grid;
      grid-template-columns: 1fr 4fr;
      gap: 10px;
      align-items: center;
    }

    .comment img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
    }

    .comment strong {
      background-color: #ff4d4d;
      color: white;
    }
/* Comment Actions */
.edit-btn,
.delete-btn {
  padding: 5px 10px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 0.9rem;
  transition: background-color 0.3s ease;
}

.edit-btn {
  background-color: #ff9f43;
  color: white;
}

.delete-btn {
  background-color: #ff4d4d;
  color: white;
}

.edit-btn:hover {
  background-color: #ffbf7f;
}

.delete-btn:hover {
  background-color: #ff6f6f;
}

/* Comments Section */
.comments-section h2 {
  margin: 1rem 0 0.5rem; /* More specific spacing */
}

.no-comments {
  grid-column: span 5;
  text-align: center;
  margin-top: 20px;
  padding: 15px;
  color: #666;
  font-style: italic;
}


</style>

</head>
<?php include 'header.php'; ?>

<body>
  <div class="container">
    <?php
    if ($review) {
        // Display game title and rating
        echo '<h1>' . htmlspecialchars($game['title']) . '</h1>';
        echo '<div class="review-meta">';
        echo '<span class="rating"><i class="fas fa-star"></i> ' . htmlspecialchars($game['rating']) . '/5</span>';
        
        echo '</div>';

        // Display platforms
        echo '<div class="review-meta">';
       
        echo '<span class="platforms">' . htmlspecialchars($game['platform']) . '</span>';
        echo '</div>';

        // Display game image
        echo '<img src="' . htmlspecialchars($game['image_url']) . '" alt="' . htmlspecialchars($game['title']) . '" class="review-image">';

        // Display review description
        echo '<p>' . htmlspecialchars($review['content']) . '</p>';

        // Display screenshots section
        echo '<h2 class="screenshots-header">Screenshots</h2>';
        echo '<div class="screenshot-grid">';
        foreach ($screenshots as $screenshot) {
            echo '<div class="screenshot-item">';
            echo '<img src="' . htmlspecialchars($screenshot['image_url']) . '" alt="Screenshot of ' . htmlspecialchars($game['title']) . '">';
            //echo '<button class="bookmark-btn">Bookmark</button>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<p>Review not found.</p>';
    }
    ?>

  </div>

  <br>

        <!-- Example: Embed a video dynamically -->
        <section class="video-section">
  <h2>Official Trailer</h2>
  <div class="video-container">
    <?php
    if (!empty($review['video_url'])) {
        echo '<iframe width="560" height="315" src="' . htmlspecialchars($review['video_url']) . '" frameborder="0" allowfullscreen></iframe>';
    } else {
        echo '<p>No video available.</p>';
    }
    ?>
  </div>
</section>




    <!-- Single Comment Submission Form -->
    <section class="comments-section">
  <!-- Comments Header -->
  <h2 class="comments-header">Comments</h2>

  <!-- Avatar + Textarea + Submit Button (Direct Children) -->
  <article class="user-avatar-container">
    <label for="commentInput" class="user-avatar">
      <img src="https://cdn-icons-png.flaticon.com/128/5663/5663802.png" alt="User Profile Picture">
    </label>
  </article>

  <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?php echo $review_id; ?>" id="commentForm">
    <article class="comment-input-container">
      <textarea id="commentInput" name="comment" placeholder="Add a comment..." aria-label="Write a comment" required></textarea>
    </article>

    <input type="hidden" name="review_id" value="<?php echo htmlspecialchars($review_id); ?>">

    <article class="submit-button-container">
      <button type="submit" id="submitComment" class="btn">Comment</button>
    </article>
  </form>

 
 <!-- -->
  <section id="commentsContainer" class="comments-container">
     <?php
    if (!empty($comments)) {
        foreach ($comments as $comment) {
          echo '<article class="comment">';
            echo '<div class="comment">';
            echo '<img src="https://cdn-icons-png.flaticon.com/128/5663/5663802.png" alt="User Avatar">';
            echo '</div>';
          echo '<div class="comment-text">';
            echo '<p><strong>' . htmlspecialchars($comment['username']) . '</strong>: ';
            if (isset($_GET['edit_comment']) && (int)$_GET['edit_comment'] === $comment['id']) {
              // Show edit form
              echo '<form method="POST" class="edit-comment-form" >';
              echo '<textarea name="updated_content">' . htmlspecialchars($comment['comment_text']) . '</textarea>';
              echo '<input type="hidden" name="comment_id" value="' . htmlspecialchars($comment['id']) . '">';
              echo '<input type="hidden" name="review_id" value="<?php echo htmlspecialchars($review_id); ?>">';
              echo '<button type="submit" name="edit_comment" class="btn">Save</button>';
              echo '</form>';
          } else {
              // Show comment content
              echo htmlspecialchars($comment['comment_text']);
          }
          echo '</p>';
          echo '<div class="comment-actions">';
          echo '<a href="?id=' . $review_id . '&edit_comment=' . $comment['id'] . '" class="edit-btn">Edit</a>';
          echo '<form method="POST" class="delete-comment-form" style="display:inline;">';
          echo '<input type="hidden" name="comment_id" value="' . htmlspecialchars($comment['id']) . '">';
          echo '<input type="hidden" name="review_id" value="<?php echo htmlspecialchars($review_id); ?>">';
          echo '<button type="submit" name="delete_comment" class="delete-btn">Delete</button>';
          echo '</form>';
          echo '</div>';
          echo '</article>'; // Close the article tag
        }
    } else {
        echo '<article class="no-comments">';
        echo '<p>No comments yet. Be the first to comment!</p>';
        echo '</article>';
    }
    ?>
  </section>
</section>
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