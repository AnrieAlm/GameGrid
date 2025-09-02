
# GameGrid
Gaming Review Website for SEWA

# GameGrid
Gaming Review Website for SEWA


# Authors 

# Team Members:
   # • Name 1: [Neil Joseph], [3168101]
   # • Name 2: [Victor Adisa ], [3166231]
   # • Name 3: [Anriel Almeida], [3168178]

 
# SEWA - Assignment 3: Server-side Components Documentation
Table of Contents
    1. Project Overview
    2. Implementation Details
        a. Templating
        b. Users Management
        c. CRUD Operations
        d. Validation (Server-Side)
        e. Coding Standards
    3. Division of Work
    4. Deployment
    5. Extra Features
    6. Readme.md
    7. Coversheet

Note: the Database name:game_grid, username game_grid and password: game_grid


# 1. Project Overview
Application Name:
GameGrid
A dynamic web application designed to manage and display video game information. Users can browse games, view trending reviews, bookmark their favourite games, and interact with the database through CRUD operations.
Key Features:
    • Hero Slider: Dynamically fetches game data for the hero section.
    • Search Functionality: Allows users to search for games by title.
    • Bookmarking: Local storage-based bookmarking functionality for user preferences.
    • Trending Reviews: Displays popular games with ratings and platform details.
    • Responsive Design: Ensures compatibility across devices using CSS media queries.

# 2. Implementation Details
Templating
The project uses PHP include statements to modularize the codebase. For example:
<?php include 'header.php'; ?>
<?php include 'footer.php'; ?>
 
This ensures separation of concerns and makes the code easier to maintain. The header and footer are reused across multiple pages, reducing redundancy.
Users Management
    • Session Management: The $_SESSION object is used to maintain user-specific states, such as login status and preferences.
    • Database Integration: User data is stored in a MySQL database. Each user can retrieve their previously stored data, such as bookmarks or game preferences.
CRUD Operations
Create:
    • Games are added to the database via a form submission handled by PHP.
    • Example SQL query for adding a new game:$stmt = $pdo->prepare("INSERT INTO games (title, rating, image_url) VALUES (?, ?, ?)");
$stmt->execute([$title, $rating, $image_url]);
 
Read:
    • Fetching game data from the database:$stmt = $pdo->query("SELECT * FROM games");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "Game: " . htmlspecialchars($row['title']) . "<br>";
}
 
Update:
    • Updating game details based on user input:$stmt = $pdo->prepare("UPDATE games SET title = ?, rating = ? WHERE id = ?");
$stmt->execute([$new_title, $new_rating, $game_id]);
 
Delete:
    • Removing a game from the database:$stmt = $pdo->prepare("DELETE FROM games WHERE id = ?");
$stmt->execute([$game_id]);
 
Validation (Server-Side)
    • Form data is validated using PHP to ensure correctness and prevent malicious inputs.
    • Example validation:if (empty($_POST['title'])) {
    die("Title is required.");
}
if (!is_numeric($_POST['rating'])) {
    die("Rating must be a number.");
}
 
Search Functionality
    • A search query is retrieved from the $_GET['query'] parameter and sanitized using trim() to remove unnecessary whitespace.
    • Prepared statements are used to securely query the database:$stmt = $pdo->prepare("SELECT * FROM games WHERE title LIKE :search");
$stmt->execute(['search' => "%$query%"]);
 
    • Results are displayed dynamically, with proper escaping of special characters using htmlspecialchars().
Hero Slider
    • The hero slider dynamically fetches game data from the database:$sqlHero = "SELECT * FROM games LIMIT 1";
$resultHero = $pdo->query($sqlHero);
 
    • The background image, title, and rating are displayed using PHP:echo '<div class="hero-background" style="background-image: url(\'' . htmlspecialchars($rowHero["image_url"]) . '\');"></div>';
echo '<h2>' . htmlspecialchars($rowHero["title"]) . '</h2>';
 
Bookmarking
    • Bookmarking is implemented using JavaScript and local storage:const bookmarks = JSON.parse(localStorage.getItem('bookmarks')) || [];
button.addEventListener('click', () => {
    if (bookmarks.includes(gameId)) {
        bookmarks.splice(bookmarks.indexOf(gameId), 1);
        button.classList.remove('bookmarked');
        button.textContent = 'Bookmark';
    } else {
        bookmarks.push(gameId);
        button.classList.add('bookmarked');
        button.textContent = 'Bookmarked';
    }
    localStorage.setItem('bookmarks', JSON.stringify(bookmarks));
});
 
Coding Standards
    • Readability: Code is well-indented and formatted for clarity.
    • Comments: Every major function and block of code is documented.
    • Naming Conventions: Variables and functions have meaningful names, e.g., $pdo, fetchGames().
    • Error Handling: Proper error messages are displayed for invalid inputs or database errors.

# 3. Division of Work
Summary of Division of Work:
Work was evenly divided among team members.
Percentage of Work Completed:
    • Neil: 35% (Deployment, CRUD Implementation)
    • Victor: 35% (Users Management, Validation, comments section )
    • Anriel: 30% (Styling,Templating, SQL setup, profile button , search bar)

# 4. Deployment
Hosting:
    • The application is hosted online at [ URL].
    • The server environment includes PHP and MySQL, .
Database Setup:
    • A MySQL database named game_grid was created to store game and user data.
    • $dbname = 'game_grid'; // Database name
    • $username = 'game_grid'; // Database username
    • $password = 'game_grid'; // Database password
    • In the SQL query window in myPhp admin this query was written to create a user 
    • SELECT User, Host FROM mysql.user;
CREATE USER 'game_grid1'@'localhost' IDENTIFIED BY 'game_grid';
ALTER USER 'game_grid1'@'localhost' IDENTIFIED BY 'new_password';
GRANT ALL PRIVILEGES ON game_grid.* TO 'game_grid1'@'localhost';

        ◦ games: Stores game details (id, title, rating, image_url).
        ◦ users: Stores user credentials and preferences.

Deployment Steps:
    1. Export the database schema and data using mysqldump.
    2. Upload the PHP files and assets to the server.
    3. Configure the db.php file with the correct database credentials.

# 5. Extra Features
    • Hero Slider: Dynamically fetches game data for the hero section.
    • Bookmarking: Uses local storage to save user preferences. (tried to make it work)
    • Responsive Design: CSS media queries ensure compatibility across devices.
    • Slider Controls: Interactive buttons for navigating the hero slider.
    • Search Functionality: Allows users to search for games by title.

# 6. Readme.md
Project Description:
GameGrid is a dynamic web application built using PHP, MySQL, HTML, and CSS. It allows users to browse games, view reviews, and bookmark their favorites.
File Structure:
/root
  /css
    style2.css
  /images
    hero.jpg
    game1.jpg
    game2.jpg
  /icons
  /php 
  db.php
  header.php
  footer.php
  index.php
  slides.php
readme.md
coversheet.pdf
 
# Contributions:
    • Neil: 35% (Deployment, CRUD Implementation)
    • Victor: 35% (platform filter, Validation, search bar )
    • Anriel: 30% (Styling,Templating, SQL setup, user management)


Submission Date:
18-04-2025

# References:
    1. Dani Krossing (2023) 25 | How to Create Sessions in PHP for Beginners | 2023 | Learn PHP Full Course For Beginners . Available at: https://www.youtube.com/watch?v=JAgd_L3GhI0 (Accessed: [17-04-2025]).

    2. Dani Krossing (2023) 22 | INSERT INTO Database Using PHP From Your Website! | 2023 | Learn PHP Full Course for Beginners . Available at: https://www.youtube.com/watch?v=IagGGcC95Ig (Accessed: [17-04-2025]).

    3. Dani Krossing (2023) Learn Object Oriented PHP for Beginners | With Examples to Help You Understand! | OOP PHP Tutorial . Available at: https://www.youtube.com/watch?v=yrFr5PMdk2A&amp;t=4s (Accessed: [17-04-2025]).

    4. Stack Overflow Contributors (n.d.) PHP Notes for Professionals . Available at: file:///C:/Users/Anriel/Downloads/PHPNotesForProfessionals.pdf (Accessed: [17-04-2025 ]).
    5. freeCodeCamp.org (n.d.) PHP Programming Language Tutorial - Full Course . Available at: https://www.youtube.com/watch?v=OK_JCtrrv-c (Accessed: [17-04-2025]).




# Future Enhancement Opportunities  
We've identified several opportunities for future enhancement: 
1. Bookmarks saved to turn up on the profile page 
2. Individual profiles editing 
3. Admin page to create reviews
4. Change the UI to look better

 # HTML , CSS and Javascript
   

# Authors 
# Anreil Almeida - style.css, inner-review.html,profile
# Neil Joseph - Style.css, script.js, review.js, login.js
# Victor Adisa - index, login.html, reviews.html, about.html
 
 Work done so far. 
 So far, we have been able to create our pages using HTML, style the pages with CSS, and use JavaScript. We also linked all pages in our nav section using anchor tags to make them a single unit so you could navigate from all pages in the site without closing the site. We also used media Queries to make a laptop view and phone view making the site responsive as well and we used forms to accept the user's details and validate the user's inputs where necessary. We used Javascript to display our reviews page. We also styled the theme of our website using CSS and we maintained consistency across all the pages on the site.
We planned to use the search feature in the site and we inserted it, we also planned to use a community feature whereby users can comment on games and give their reviews, we also planned to use the Bookmark option where the user can bookmark games which he or she likes and it will be stored in the user's profile, then we planned to have a user profile for each user and we designed a profile page whereby the user can have all his records stored in it. We also have the sign-in and register page where the user can either sign in if he is a returning user or register if he's a new user and his record will be stored in the database. We created a feature for the user to change his password if he wishes to. 
  In our reviews page we made a feature in which the user can change to a view he or she prefers (list or grid view). We created buttons where the user can pick if he wants to search for games by platform but the buttons aren't functional for now because it will be done once php is integrated.

# Interactive Feedback

Form elements provide clear focus and hover states
Actions (like editing profiles) have appropriate visual feedback
Input validation indicators help users complete forms correctly

# Dark Mode Implementation
The dark theme implementation carefully considers readability and eye strain reduction:

Text elements maintain WCAG AA contrast requirements
Interactive elements use distinctive highlight colors (#00ff88)
Background elements use subtle gradient variations to create depth

# Advanced Layout Techniques
The profile interface uses layout methods including:
Grid-based layout for the preferences section allowing dynamic content organization
Strategic use of justify-content and align-items properties for perfect vertical and horizontal positioning

# Intuitive Information Hierarchy

Critical user information is prominently positioned
Secondary actions are appropriately de-emphasized
Content sections use visual weight to guide user attention

# Future Enhancement Opportunities  
We've identified several opportunities for future enhancement: 
1. Profile editing feature 
2. Individual profiles
3. Login/Register
4. Bookmark saving feature.

# Contributions
  The work was evenly distributed among team members.
  The HTML pages were created by Victor and Anriel, 
  CSS was done both by Neil and Anriel, 
  Java script was done by Neil.
